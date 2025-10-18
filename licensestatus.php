<?php
/**
 * E-License System | License Status
 *
 * - Fetches and displays the final license status for the logged-in user.
 * - Shows the status (Processing, Ready for Collection, Collected).
 * - Protected page: only accessible to logged-in users.
 */

// Must be the very first line to use sessions
session_start();

// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in to view your license status.";
    header("Location: login.php");
    exit();
}

// Include the database connection file.
require 'dbconnection.php';

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch the latest license status for this user from the database
$license = null;
$sql = "SELECT license_id, issue_date, status 
        FROM licenses 
        WHERE user_id = ? 
        ORDER BY issue_date DESC 
        LIMIT 1"; // Get the most recent license record

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $license = $result->fetch_assoc();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>License Status - E-License</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
body {
  background-color: #f4f6f9;
  font-family: 'Poppins', sans-serif;
  min-height: 100vh;
  position: relative;
  padding-bottom: 80px; /* Adjust based on footer height */
}

footer {
  position: absolute;
  bottom: 0;
  width: 100%;
}
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 700px;
      margin: auto;
    }
    .status-icon {
        font-size: 3rem;
    }
  </style>
</head>
<body>

 <?php include "usernavigation.php"; ?>
<div class="container mt-5">
  <div class="card p-4 p-md-5">
    <h3 class="text-center text-primary mb-3">Your License Status</h3>
    <p class="text-center text-muted mb-4">View if your driving license is ready for collection.</p>

    <!-- Dynamic Status Display -->
    <div class="mt-4">
        <?php if ($license): ?>
            <?php
                $status = htmlspecialchars($license['status']);
                $issue_date = htmlspecialchars($license['issue_date']);
                $alert_class = '';
                $icon_class = '';
                $message = '';

                switch ($status) {
                    case 'Processing':
                        $alert_class = 'alert-info';
                        $icon_class = 'bi bi-gear-wide-connected text-info';
                        $message = 'Your license application has been approved and is now <strong>Processing</strong>. The issue date will be updated once it is ready.';
                        break;
                    case 'Ready for Collection':
                        $alert_class = 'alert-warning';
                        $icon_class = 'bi bi-person-check-fill text-warning';
                        $message = 'Good news! Your license is <strong>Ready for Collection</strong>. Please visit the main office to collect it.';
                        break;
                    case 'Collected':
                        $alert_class = 'alert-success';
                        $icon_class = 'bi bi-patch-check-fill text-success';
                        $message = 'Congratulations! Your license has been <strong>Collected</strong> on ' . $issue_date . '.';
                        break;
                }
            ?>
            <div class="alert <?php echo $alert_class; ?> text-center" role="alert">
                <i class="status-icon <?php echo $icon_class; ?>"></i>
                <p class="fs-5 mt-3 mb-0"><?php echo $message; ?></p>
            </div>
        <?php else: ?>
            <div class="alert alert-secondary text-center" role="alert">
                <i class="status-icon bi bi-hourglass-split text-secondary"></i>
                <p class="fs-5 mt-3 mb-0">No license information found. Your license status will appear here after you have passed all exams and it has been approved by an administrator.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="text-center mt-4">
        <a href="dashboard.php" class="text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back to Dashboard</a>
    </div>
  </div>
</div>
 <footer class="bg-dark text-light py-4 mt-5">
    <div class="container text-center">
      <p class="mb-0">&copy; <?php echo date("Y"); ?> E-License System | Developed by Dinod Deshanjana</p>
    </div>
  </footer>

</body>
</html>
