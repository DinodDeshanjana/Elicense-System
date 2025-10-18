
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Poppins', sans-serif;
      font-weight:bold;
    }
    .navbar {
      background-color: #004aad;
      padding: 1rem 0;
    }
    .navbar-brand {
      color: #fff !important;
      font-weight: 600;
      
    }
    .nav-link {
      color: #fff !important;
margin: 0 0.5rem;
    }
    .card {
      border: none;
      border-radius: 15px;
      transition: all 0.3s ease;
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
        footer {
  position: absolute;
  bottom: 0;
  width: 100%;
}
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="admin.php"><i class="bi bi-shield-lock-fill"></i> E-License Admin</a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active" href="admin.php">Dashboard</a></li>
          <li class="nav-item"><a href="logout.php" class="btn-logout btn-login">Logout</a></li>
          
        </ul>
      </div>
    </div>
  </nav>

  <footer class="bg-dark text-light py-4 mt-5">
    <div class="container text-center">
      <p class="mb-0">&copy; <?php echo date("Y"); ?> E-License System | Developed by Dinod Deshanjana</p>
    </div>
  </footer>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
