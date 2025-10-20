<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - E-License</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
      :root {
        --primary-blue: #0d6efd;
        --secondary-color: #6c757d;
        --success-color: #198754;
        --danger-color: #dc3545;
        --dark-blue: #0043a6;
        --light-blue: #e3f2fd;
      }

      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { 
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden; 
        scroll-padding-top: 80px;
        position: relative; 
        min-height: 100vh; 
        padding-bottom: 100px; 
        background-color: #f8f9fa; 
      }
      .navbar { 
        background: white; 
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
        padding: 1rem 0; 
      }
      .navbar-brand { font-weight: 700; font-size: 1.5rem; color: rgb(8, 8, 8) !important; }
      .navbar-brand i { margin-right: 0.5rem; }
      .nav-link { color: rgba(12, 12, 12, 0.8) !important; font-weight: 600; transition: all 0.3s ease; margin: 0 0.5rem; font-size: 1rem; }
      .nav-link:hover { color: rgb(14, 163, 255) !important; transform: translateY(-2px); }
      .nav-link.active { color: var(--primary-blue) !important; } 
      
      .btn-login { background-color: rgb(20, 93, 251); color: white; font-weight: bold; padding: 0.5rem 1.5rem; border-radius: 60px; transition: all 0.3s ease; }
      .btn-login:hover { background-color: #7ebbfc; transform: translateY(-2px); }
      
      .btn-login a, .btn-light a { text-decoration: none !important; color: inherit; }
      
      html {
        scroll-behavior: smooth;
      }
      
      .navbar-brand i {
        margin-right: 0.5rem;
        color: #007bff;
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
        background-color: #343a40; 
        color: white;
        padding: 1.5rem 0; 
      }

      .contact-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <i class="fas fa-id-card"></i> E-License
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="services.php">Services</a>
            </li>
              <li class="nav-item">
              <a class="nav-link active" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.php">About Us</a>
            </li>
          </ul>
          
          <div class="ms-3 d-flex gap-2">
            <?php if (isset($_SESSION['user_id'])): ?>
              <?php
                $dashboard_link = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'dashboard.php';
              ?>
              <a href="<?php echo $dashboard_link; ?>" class="btn btn-light">My Dashboard</a>
              <a href="logout.php" class="btn-logout btn-login">Logout</a>
            <?php else: ?>
              <a href="login.php" class="btn btn-login">Login</a>
              <a href="register.php" class="btn btn-login">Sign Up</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>

    <section class="py-5 text-center" id="contact-header" style="background-color: white;">
        <div class="container">
            <h2 class="fw-bold mb-4">Contact Us</h2>
            <p class="lead text-muted mx-auto" style="max-width: 800px;">
              Have questions or need assistance? Here's how to reach our support team for help with your E-License needs.
            </p>
        </div>
    </section>

    <div class="container my-5">
        <div class="row g-5 justify-content-center">
        
            <div class="col-lg-8"> <h3 class="fw-bold mb-4 text-center">Contact Information</h3> <div class="card contact-card p-4 p-md-5"> <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center mb-4">
                            <i class="bi bi-geo-alt-fill text-primary fs-3 me-3"></i>
                            <div>
                                <h5 class="mb-0">Address</h5>
                                <p class="mb-0 text-muted">Department of Motor Traffic<br>Colombo, Sri Lanka</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                            <i class="bi bi-telephone-fill text-primary fs-3 me-3"></i>
                            <div>
                                <h5 class="mb-0">Phone</h5>
                                <p class="mb-0 text-muted">+94 11 123 4567</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-envelope-fill text-primary fs-3 me-3"></i>
                            <div>
                                <h5 class="mb-0">Email</h5>
                                <p class="mb-0 text-muted">support@e-license.gov.lk</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            </div>
    </div>


    <footer class="text-center">
      <p class="mb-0">&copy; <?php echo date("Y"); ?> E-License System | Developed by Dinod Deshanjana</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>