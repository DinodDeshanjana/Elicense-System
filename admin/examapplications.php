<?php
/**
 * E-License System | ADMIN - Manage Exam Applications
 *
 * - Allows admins to view, approve, or reject user exam applications.
 * - Protected page: only accessible to users with the 'admin' role.
 */

session_start();
require 'dbconnection.php';

// --- SECURITY CHECK ---
// 1. Check if a user is logged in at all.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in to access the admin panel.";
    header("Location: login.php");
    exit();
}
// 2. Check if the logged-in user is an admin.
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error_message'] = "You do not have permission to access this page.";
    // Redirect non-admins to their own dashboard
    header("Location: dashboard.php");
    exit();
}


// --- ACTION HANDLING (Approve/Reject) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if an application_id was submitted
    if (isset($_POST['application_id'])) {
        $application_id = $_POST['application_id'];
        $new_status = '';

        // Determine the new status based on which button was clicked
        if (isset($_POST['approve'])) {
            $new_status = 'Approved';
        } elseif (isset($_POST['reject'])) {
            $new_status = 'Rejected';
        }

        if (!empty($new_status)) {
            // Prepare a secure SQL statement to update the status
            $sql = "UPDATE exam_applications SET status = ? WHERE application_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_status, $application_id);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Application #" . $application_id . " has been updated to '" . $new_status . "'.";
            } else {
                $_SESSION['error_message'] = "Error updating application status.";
            }
            $stmt->close();
            
            // Redirect back to the same page to prevent form resubmission on refresh
            header("Location: examapplications.php");
            exit();
        }
    }
}


// --- DATA FETCHING ---
// Fetch all applications, joining with the users table to get user details
$applications = [];
$sql = "SELECT 
            ea.application_id, 
            ea.applied_date, 
            ea.status, 
            u.fullname, 
            u.nic 
        FROM 
            exam_applications AS ea 
        JOIN 
            users AS u ON ea.user_id = u.user_id 
        ORDER BY 
            -- Show 'Pending' applications first, then by the most recent date
            FIELD(ea.status, 'Pending', 'Approved', 'Rejected'), 
            ea.applied_date DESC";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Exam Applications</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="background-color:#f4f6f9;">
  <div class="container py-5">
    <h3 class="text-center text-primary mb-4">Manage Exam Applications</h3>
    
    <!-- Session Message Display -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="table-responsive bg-white shadow rounded p-3">
      <table class="table table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>App ID</th>
            <th>User Name</th>
            <th>NIC</th>
            <th>Date Applied</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($applications)): ?>
            <tr>
              <td colspan="6" class="text-center text-muted p-4">No applications found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($applications as $app): ?>
            <tr>
              <td><?php echo htmlspecialchars($app['application_id']); ?></td>
              <td><?php echo htmlspecialchars($app['fullname']); ?></td>
              <td><?php echo htmlspecialchars($app['nic']); ?></td>
              <td><?php echo htmlspecialchars($app['applied_date']); ?></td>
              <td>
                <?php
                  $status = htmlspecialchars($app['status']);
                  $badge_class = '';
                  switch ($status) {
                      case 'Approved': $badge_class = 'bg-success'; break;
                      case 'Rejected': $badge_class = 'bg-danger'; break;
                      default: $badge_class = 'bg-warning text-dark'; break;
                  }
                  echo '<span class="badge ' . $badge_class . '">' . $status . '</span>';
                ?>
              </td>
              <td>
                <?php if ($app['status'] === 'Pending'): ?>
                  <!-- Show Approve/Reject buttons only for Pending applications -->
                  <form action="examapplications.php" method="POST" class="d-inline-block">
                    <input type="hidden" name="application_id" value="<?php echo $app['application_id']; ?>">
                    <button type="submit" name="approve" class="btn btn-success btn-sm">Approve</button>
                  </form>
                  <form action="examapplications.php" method="POST" class="d-inline-block">
                    <input type="hidden" name="application_id" value="<?php echo $app['application_id']; ?>">
                    <button type="submit" name="reject" class="btn btn-danger btn-sm">Reject</button>
                  </form>
                <?php else: ?>
                  <!-- Show a disabled button for completed actions -->
                  <button class="btn btn-secondary btn-sm" disabled><?php echo $app['status']; ?></button>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
