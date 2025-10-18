<?php
/**
 * E-License System | ADMIN - Main Dashboard
 *
 * - Provides an overview of system statistics and links to management pages.
 * - Protected page: only accessible to users with the 'admin' role.
 * - Fetches counts for pending applications, results, licenses, and total users.
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
    header("Location: dashboard.php"); // Redirect non-admins to their dashboard
    exit();
}

// Get the admin's name from the session to display it
$admin_name = $_SESSION['fullname'];


// --- DATA FETCHING FOR WIDGETS ---
// 1. Count pending exam applications
$sql_pending_apps = "SELECT COUNT(application_id) AS pending_count FROM exam_applications WHERE status = 'Pending'";
$pending_apps_count = $conn->query($sql_pending_apps)->fetch_assoc()['pending_count'] ?? 0;

// 2. Count pending exam results (for Approved applications)
$sql_pending_results = "SELECT COUNT(ea.application_id) AS pending_count 
                        FROM exam_applications ea 
                        LEFT JOIN exam_results er ON ea.application_id = er.application_id 
                        WHERE ea.status = 'Approved' AND er.result_id IS NULL";
$pending_results_count = $conn->query($sql_pending_results)->fetch_assoc()['pending_count'] ?? 0;


// 3. Count licenses in 'Processing' status
$sql_processing_licenses = "SELECT COUNT(license_id) AS processing_count FROM licenses WHERE status = 'Processing'";
$processing_licenses_count = $conn->query($sql_processing_licenses)->fetch_assoc()['processing_count'] ?? 0;

// 4. Count total users
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
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      background-color: #004aad;
    }
    .navbar-brand {
      color: #fff !important;
      font-weight: 600;
    }
    .nav-link {
      color: #fff !important;
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
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="admin_dashboard.php"><i class="bi bi-shield-lock-fill"></i> E-License Admin</a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active" href="admin_dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Dashboard -->
  <div class="container py-5">
    <h2 class="mb-4 fw-semibold text-center text-primary">Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h2>
    <div class="row g-4">

      <!-- Manage Exam Applications -->
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

      <!-- Add / Update Results -->
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

      <!-- License Approvals -->
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

      <!-- Manage Users -->
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

  <footer class="text-center py-3 text-muted small">
    © <?php echo date("Y"); ?> E-License Sri Lanka | Admin Panel
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
