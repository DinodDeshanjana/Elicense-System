<?php
/**
 * E-License System | User Dashboard
 *
 * This is the main page for logged-in users.
 * It provides navigation to all user-specific functionalities.
 */



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
            <a class="nav-link active" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Contact</a>
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


  

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
