<?php
/**
 * E-License System | Exam Application Status
 *
 * - Fetches and displays all exam applications for the logged-in user.
 * - Shows the status (Pending, Approved, Rejected) with color-coded badges.
 * - Protected page: only accessible to logged-in users.
 */

// Must be the very first line to use sessions
session_start();

// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in to view your application status.";
    header("Location: login.php");
    exit();
}

// Include the database connection file.
require 'dbconnection.php';

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch all exam applications for this user from the database
$applications = [];
$sql = "SELECT application_id, exam_type, applied_date, status 
        FROM exam_applications 
        WHERE user_id = ? 
        ORDER BY applied_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $applications[] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Exam Status - E-License</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 900px;
      margin: auto;
    }
    .badge { 
        font-size: 0.9rem;
        padding: 0.5em 0.9em;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <div class="card p-4 p-md-5">
    <h3 class="text-center text-primary mb-3">Exam Application Status</h3>
    <p class="text-center text-muted mb-4">Check the status of your submitted exam applications.</p>

    <div class="table-responsive">
        <table class="table table-hover text-center align-middle">
        <thead class="table-light">
          <tr>
            <th>Application ID</th>
            <th>Exam Type</th>
            <th>Date Applied</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($applications)): ?>
            <tr>
              <td colspan="4" class="text-center text-muted p-4">You have not submitted any applications yet.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($applications as $app): ?>
              <tr>
                <td><?php echo 'APP-' . htmlspecialchars($app['application_id']); ?></td>
                <td><?php echo htmlspecialchars(ucfirst($app['exam_type'])); ?></td>
                <td><?php echo htmlspecialchars($app['applied_date']); ?></td>
                <td>
                  <?php
                    // Set a different badge color based on the status
                    $status = htmlspecialchars($app['status']);
                    $badge_class = '';
                    switch ($status) {
                        case 'Approved':
                            $badge_class = 'bg-success';
                            break;
                        case 'Rejected':
                            $badge_class = 'bg-danger';
                            break;
                        case 'Pending':
                        default:
                            $badge_class = 'bg-warning text-dark';
                            break;
                    }
                    echo '<span class="badge ' . $badge_class . '">' . $status . '</span>';
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="text-center mt-4">
        <a href="dashboard.php" class="text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back to Dashboard</a>
    </div>
  </div>
</div>
</body>
</html>
