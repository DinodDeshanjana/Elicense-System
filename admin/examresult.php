<?php
/**
 * E-License System | ADMIN - Add/Update Exam Results
 *
 * - Allows admins to enter Pass/Fail results for users with 'Approved' applications.
 * - Protected page: only accessible to users with the 'admin' role.
 */

session_start();
require 'dbconnection.php';

// --- SECURITY CHECK ---
// 1. Check if a user is logged in.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in to access the admin panel.";
    header("Location: login.php");
    exit();
}
// 2. Check if the logged-in user is an admin.
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error_message'] = "You do not have permission to access this page.";
    header("Location: dashboard.php");
    exit();
}


// --- ACTION HANDLING (Save Result) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_result'])) {
    $application_id = $_POST['application_id'];
    $exam_date = $_POST['exam_date'];
    $result_status = $_POST['result']; // 'Pass' or 'Fail'

    // Simple validation
    if (empty($application_id) || empty($exam_date) || empty($result_status)) {
        $_SESSION['error_message'] = "All fields are required to save a result.";
    } else {
        // Prepare a secure SQL statement to INSERT the result
        $sql = "INSERT INTO exam_results (application_id, exam_date, result) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $application_id, $exam_date, $result_status);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Result for Application #" . $application_id . " has been saved.";
        } else {
            // Check for duplicate entry error
            if ($conn->errno == 1062) { // 1062 is the MySQL error code for duplicate entry
                 $_SESSION['error_message'] = "A result for this application already exists.";
            } else {
                $_SESSION['error_message'] = "Error saving result: " . $stmt->error;
            }
        }
        $stmt->close();
    }
    
    // Redirect back to the same page to prevent form resubmission
    header("Location: examresult.php");
    exit();
}


// --- DATA FETCHING ---
// Fetch all 'Approved' applications and join with users and results tables
$applicants = [];
$sql = "SELECT 
            ea.application_id,
            u.fullname,
            er.exam_date,
            er.result
        FROM 
            exam_applications AS ea
        JOIN 
            users AS u ON ea.user_id = u.user_id
        LEFT JOIN 
            exam_results AS er ON ea.application_id = er.application_id
        WHERE 
            ea.status = 'Approved'
        ORDER BY
            -- Show applicants who need a result at the top
            CASE WHEN er.result_id IS NULL THEN 0 ELSE 1 END, 
            ea.application_id DESC";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
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
  <title>Add Exam Results</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#f4f6f9;">
  <div class="container py-5">
    <h3 class="text-center text-primary mb-4">Add / Update Exam Results</h3>
    
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
            <th>Exam Date</th>
            <th>Result</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($applicants)): ?>
            <tr>
              <td colspan="5" class="text-center text-muted p-4">No approved applications found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($applicants as $applicant): ?>
              <tr>
                <form action="examresult.php" method="POST">
                  <td>
                    <?php echo htmlspecialchars($applicant['application_id']); ?>
                    <input type="hidden" name="application_id" value="<?php echo $applicant['application_id']; ?>">
                  </td>
                  <td><?php echo htmlspecialchars($applicant['fullname']); ?></td>
                  
                  <?php if (is_null($applicant['result'])): // If result is not yet saved ?>
                    <td>
                      <input type="date" name="exam_date" class="form-control form-control-sm" style="width:150px;" required>
                    </td>
                    <td>
                      <select name="result" class="form-select form-select-sm" style="width:120px;" required>
                        <option value="Pass">Pass</option>
                        <option value="Fail">Fail</option>
                      </select>
                    </td>
                    <td>
                      <button type="submit" name="save_result" class="btn btn-primary btn-sm">Save</button>
                    </td>
                  <?php else: // If result is already saved ?>
                    <td><?php echo htmlspecialchars($applicant['exam_date']); ?></td>
                    <td>
                      <?php
                        $result_status = htmlspecialchars($applicant['result']);
                        $badge_class = ($result_status === 'Pass') ? 'bg-success' : 'bg-danger';
                        echo '<span class="badge ' . $badge_class . '">' . $result_status . '</span>';
                      ?>
                    </td>
                    <td>
                      <button class="btn btn-secondary btn-sm" disabled>Saved</button>
                    </td>
                  <?php endif; ?>

                </form>
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

