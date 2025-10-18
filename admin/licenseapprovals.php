<?php
/**
 * E-License System | ADMIN - License Approvals
 *
 * - Allows admins to issue new licenses to users who have passed their exams.
 * - Allows admins to update the status of existing licenses.
 * - Protected page: only accessible to users with the 'admin' role.
 */

session_start();
require 'dbconnection.php';

// --- SECURITY CHECK ---
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error_message'] = "You do not have permission to access this page.";
    header("Location: login.php");
    exit();
}


// --- ACTION HANDLING ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ACTION 1: Issue a new license for a passed user
    if (isset($_POST['issue_license'])) {
        $user_id_to_issue = $_POST['user_id'];

        // Prepare INSERT statement
        $sql = "INSERT INTO licenses (user_id, issue_date, status) VALUES (?, CURDATE(), 'Processing')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id_to_issue);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "License has been successfully issued and is now processing.";
        } else {
            $_SESSION['error_message'] = "Error issuing license. It might already exist.";
        }
        $stmt->close();
    }

    // ACTION 2: Update the status of an existing license
    if (isset($_POST['update_status'])) {
        $license_id_to_update = $_POST['license_id'];
        $new_status = $_POST['new_status'];
        
        // Basic validation for allowed statuses
        $allowed_statuses = ['Processing', 'Ready for Collection', 'Collected'];
        if (in_array($new_status, $allowed_statuses)) {
            $sql = "UPDATE licenses SET status = ? WHERE license_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_status, $license_id_to_update);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "License #" . $license_id_to_update . " status updated to '" . $new_status . "'.";
            } else {
                $_SESSION['error_message'] = "Error updating license status.";
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Invalid status selected.";
        }
    }

    // Redirect back to the same page to prevent form resubmission
    header("Location: licenseapprovals.php");
    exit();
}


// --- DATA FETCHING ---
// Get all users who have passed an exam, and join their license status if it exists.
$applicants = [];
$sql = "SELECT 
            u.user_id, 
            u.fullname,
            l.license_id,
            l.issue_date,
            l.status AS license_status
        FROM users u
        JOIN exam_applications ea ON u.user_id = ea.user_id
        JOIN exam_results er ON ea.application_id = er.application_id
        LEFT JOIN licenses l ON u.user_id = l.user_id AND l.license_id = (SELECT MAX(license_id) FROM licenses WHERE user_id = u.user_id)
        WHERE er.result = 'Pass'
        GROUP BY u.user_id -- Show each passed user only once
        ORDER BY 
            CASE WHEN l.license_id IS NULL THEN 0 ELSE 1 END, -- Users needing a license appear first
            FIELD(l.status, 'Processing', 'Ready for Collection', 'Collected'), -- Order by workflow
            l.issue_date DESC";

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applicants[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>License Approvals</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#f4f6f9;">
  <div class="container py-5">
    <h3 class="text-center text-primary mb-4">License Approval Panel</h3>
    
    <!-- Session Message Display -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive bg-white shadow rounded p-3">
      <table class="table table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>User Name</th>
            <th>Issue Date</th>
            <th>Current Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($applicants)): ?>
            <tr><td colspan="4" class="text-center text-muted p-4">No users found who have passed an exam.</td></tr>
          <?php else: ?>
            <?php foreach ($applicants as $applicant): ?>
            <tr>
              <td><?php echo htmlspecialchars($applicant['fullname']); ?></td>
              <td><?php echo $applicant['issue_date'] ? htmlspecialchars($applicant['issue_date']) : '<span class="text-muted">N/A</span>'; ?></td>
              <td>
                <?php
                  $status = $applicant['license_status'] ?? 'Needs Issuing';
                  $badge_class = 'bg-secondary';
                  if ($status == 'Processing') $badge_class = 'bg-info text-dark';
                  if ($status == 'Ready for Collection') $badge_class = 'bg-warning text-dark';
                  if ($status == 'Collected') $badge_class = 'bg-success';
                  echo '<span class="badge ' . $badge_class . '">' . htmlspecialchars($status) . '</span>';
                ?>
              </td>
              <td>
                <?php if (is_null($applicant['license_id'])): ?>
                  <!-- User has passed but has no license record -> Show "Issue License" button -->
                  <form action="licenseapprovals.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $applicant['user_id']; ?>">
                    <button type="submit" name="issue_license" class="btn btn-primary btn-sm">Issue License</button>
                  </form>
                <?php elseif ($applicant['license_status'] !== 'Collected'): ?>
                  <!-- License exists and is not yet collected -> Show status update form -->
                  <form action="licenseapprovals.php" method="POST" class="d-flex gap-2">
                    <input type="hidden" name="license_id" value="<?php echo $applicant['license_id']; ?>">
                    <select name="new_status" class="form-select form-select-sm" style="width: 200px;">
                      <option value="Processing" <?php if($applicant['license_status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                      <option value="Ready for Collection" <?php if($applicant['license_status'] == 'Ready for Collection') echo 'selected'; ?>>Ready for Collection</option>
                      <option value="Collected" <?php if($applicant['license_status'] == 'Collected') echo 'selected'; ?>>Collected</option>
                    </select>
                    <button type="submit" name="update_status" class="btn btn-success btn-sm">Update</button>
                  </form>
                <?php else: ?>
                  <!-- License is already collected -> Show disabled button -->
                  <button class="btn btn-secondary btn-sm" disabled>Completed</button>
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
