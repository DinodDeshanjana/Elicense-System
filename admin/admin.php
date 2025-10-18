<?php

session_start();
require 'dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in to access the admin panel.";
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error_message'] = "You do not have permission to access this page.";
    header("Location: dashboard.php"); 
    exit();
}


$admin_name = $_SESSION['fullname'];



$sql_pending_apps = "SELECT COUNT(application_id) AS pending_count FROM exam_applications WHERE status = 'Pending'";
$pending_apps_count = $conn->query($sql_pending_apps)->fetch_assoc()['pending_count'] ?? 0;

$sql_pending_results = "SELECT COUNT(ea.application_id) AS pending_count 
                        FROM exam_applications ea 
                        LEFT JOIN exam_results er ON ea.application_id = er.application_id 
                        WHERE ea.status = 'Approved' AND er.result_id IS NULL";
$pending_results_count = $conn->query($sql_pending_results)->fetch_assoc()['pending_count'] ?? 0;



$sql_processing_licenses = "SELECT COUNT(license_id) AS processing_count FROM licenses WHERE status = 'Processing'";
$processing_licenses_count = $conn->query($sql_processing_licenses)->fetch_assoc()['processing_count'] ?? 0;

$sql_total_users = "SELECT COUNT(user_id) AS total_users FROM users WHERE role = 'user'";
$total_users_count = $conn->query($sql_total_users)->fetch_assoc()['total_users'] ?? 0;

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-License | Admin Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      border: none;
      border-radius: 15px;
      transition: all 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .card i {
      font-size: 40px;
      color: #004aad;
    }
    .badge-notification {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 1rem;
    }

        .btn-logout {
      background-color: #dc3545;
      color: white;
      font-weight: bold;
      padding: 0.5rem 1.5rem;
      border-radius: 50px;
      transition: all 0.3s ease;
      border: none;
      text-decoration: none; 
      display: inline-block;
    }
        .btn-logout:hover {
      background-color: #c82333;
      color: white;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>


<?php include "adminnavigation.php"?>


  <div class="container py-5">
    <h2 class="mb-4 fw-semibold text-center text-primary">Administrator Account <br> Welcome,  <?php echo htmlspecialchars($admin_name); ?>!</h2>
    <div class="row g-4">


      <div class="col-md-3">
        <div class="card text-center p-4">
          <?php if ($pending_apps_count > 0): ?>
            <span class="badge rounded-pill bg-danger badge-notification"><?php echo $pending_apps_count; ?></span>
          <?php endif; ?>
          <i class="bi bi-journal-text mb-3"></i>
          <h5 class="fw-bold">Exam Applications</h5>
          <p class="text-muted small">View and approve new exam applications.</p>
          <a href="examapplications.php" class="btn btn-primary btn-sm mt-auto">Manage</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center p-4">
          <?php if ($pending_results_count > 0): ?>
            <span class="badge rounded-pill bg-danger badge-notification"><?php echo $pending_results_count; ?></span>
          <?php endif; ?>
          <i class="bi bi-bar-chart-line-fill mb-3"></i>
          <h5 class="fw-bold">Exam Results</h5>
          <p class="text-muted small">Add and update exam results for applicants.</p>
          <a href="examresult.php" class="btn btn-primary btn-sm mt-auto">Add Results</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center p-4">
           <?php if ($processing_licenses_count > 0): ?>
            <span class="badge rounded-pill bg-danger badge-notification"><?php echo $processing_licenses_count; ?></span>
          <?php endif; ?>
          <i class="bi bi-card-checklist mb-3"></i>
          <h5 class="fw-bold">License Approvals</h5>
          <p class="text-muted small">Approve and issue driving licenses to passed users.</p>
          <a href="licenseapprovals.php" class="btn btn-primary btn-sm mt-auto">Approve</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center p-4">
          <i class="bi bi-people-fill mb-3"></i>
          <h5 class="fw-bold">Manage Users</h5>
          <p class="text-muted small">Total: <strong class="text-primary"><?php echo $total_users_count; ?></strong><br> registered users in the system.<br></p>
          <a href="manageusers.php" class="btn btn-primary btn-sm mt-auto">View Users</a>
        </div>
      </div>

    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
