<?php
/**
 * E-License System | User Dashboard
 *
 * This is the main page for logged-in users.
 * It provides navigation to all user-specific functionalities.
 */

// Must be the very first line to use sessions
session_start();

// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    // Set a message to inform the user why they were redirected
    $_SESSION['error_message'] = "Please log in to access your dashboard.";
    header("Location: login.php");
    exit();
}

// Get the user's name from the session variable to display it
$fullname = isset($_SESSION['fullname']) ? htmlspecialchars($_SESSION['fullname']) : "User";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-License | User Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
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
    .navbar {
      background: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 1rem 0;
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 1.5rem;
      color: #333 !important;
    }
    .navbar-brand i {
      margin-right: 0.5rem;
      color: #007bff;
    }
    .nav-link {
      color: rgba(12, 12, 12, 0.8) !important;
      font-weight: 600;
      transition: all 0.3s ease;
      margin: 0 0.5rem;
      font-size: 1rem;
    }
    .nav-link:hover {
      color: #007bff !important;
      transform: translateY(-2px);
    }
    .btn-logout {
      background-color: #dc3545;
      color: white;
      font-weight: bold;
      padding: 0.5rem 1.5rem;
      border-radius: 50px;
      transition: all 0.3s ease;
      border: none;
      text-decoration: none; /* remove underline from link */
      display: inline-block; /* correct alignment */
    }
    .btn-logout:hover {
      background-color: #c82333;
      color: white;
      transform: translateY(-2px);
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
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <i class="fas fa-id-card"></i> E-License
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Profile</a>
          </li>
        </ul>
        <!-- Correct logout button -->
        <a href="logout.php" class="btn-logout ms-3">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Dashboard -->
  <div class="container py-5">
    <h2 class="mb-4 fw-semibold text-center text-primary">Welcome, <?php echo $fullname; ?>!</h2>
    
    <!-- Message Display Area -->
    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success alert-dismissible fade show col-md-8 mx-auto" role="alert">' . $_SESSION['success_message'] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        unset($_SESSION['success_message']);
    }
    ?>

    <div class="row g-4 mt-2">

      <!-- Apply for Exam -->
      <div class="col-md-3">
        <div class="card text-center p-4 h-100">
          <i class="bi bi-journal-check mb-3"></i>
          <h5 class="fw-bold">Apply for Exam</h5>
          <p class="text-muted small">Submit your application for the driving license exam.</p>
          <a href="applyexam.php" class="btn btn-primary btn-sm mt-auto">Apply Now</a>
        </div>
      </div>

      <!-- View Exam Status -->
      <div class="col-md-3">
        <div class="card text-center p-4 h-100">
          <i class="bi bi-eye-fill mb-3"></i>
          <h5 class="fw-bold">Exam Status</h5>
          <p class="text-muted small">Check whether your exam application has been approved.</p>
          <a href="examstatus.php" class="btn btn-primary btn-sm mt-auto">View Status</a>
        </div>
      </div>

      <!-- View Results -->
      <div class="col-md-3">
        <div class="card text-center p-4 h-100">
          <i class="bi bi-bar-chart-line-fill mb-3"></i>
          <h5 class="fw-bold">Exam Results</h5>
          <p class="text-muted small">See your written or practical exam results.</p>
          <a href="examresultstatus.php" class="btn btn-primary btn-sm mt-auto">View Results</a>
        </div>
      </div>

      <!-- License Availability -->
      <div class="col-md-3">
        <div class="card text-center p-4 h-100">
          <i class="bi bi-card-checklist mb-3"></i>
          <h5 class="fw-bold">License Status</h5>
          <p class="text-muted small">View if your driving license is ready for collection.</p>
          <a href="licensestatus.php" class="btn btn-primary btn-sm mt-auto">Check Status</a>
        </div>
      </div>

    </div>
  </div>
  
  <footer class="bg-dark text-light py-4 mt-5">
    <div class="container text-center">
      <p class="mb-0">&copy; <?php echo date("Y"); ?> E-License System | Developed by Dinod Deshanjana</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
