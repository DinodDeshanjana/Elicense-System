<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Written Exam Guide - Sri Lanka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      rel="stylesheet"
    />
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
      .btn-login { background-color: rgb(20, 93, 251); color: white; font-weight: bold; padding: 0.5rem 1.5rem; border-radius: 60px; transition: all 0.3s ease; }
      .btn-login:hover { background-color: #7ebbfc; transform: translateY(-2px); }
      .hero-section { 
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%); 
        color: white; 
        padding: 100px 0; 
        min-height: 80vh; 
        display: flex; 
        align-items: center; 
      }
      .service-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; border-radius: 12px; }
      .service-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
      .btn-login a, .btn-light a { text-decoration: none !important; color: inherit; }
      
      html {
        scroll-behavior: smooth;
      }
      
      section {
        scroll-margin-top: 80px;
      }
      
      .styled-image {
        max-width: 100%;
        height: auto;
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
    }
      </style>
    
</head>
<body>

   <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
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
              <a class="nav-link" href="contact.php">Contact</a>
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

    <section id="services" class="py-5 bg-light">
      <div class="container">
          <div class="row text-center mb-5">
              <div class="col-lg-8 mx-auto fade-in">
                  <h2 class="fw-bold mb-4">Our Services</h2>
                  <p class="lead text-muted">Comprehensive resources for your driving license journey.</p>
              </div>
          </div>
        
          <div class="row g-4 justify-content-center">
          
              <div class="col-md-6 col-lg-4 card-item fade-in">
                  <div class="card service-card h-100">
                      <div class="card-body text-center p-4 d-flex flex-column">
                          <i class="bi bi-person-badge text-primary" style="font-size: 2.5rem;"></i>
                          <h5 class="card-title mt-3">Driver's License Application</h5>
                          <p class="card-text">Apply online for your new driver's license with our easy-to-use system.</p>
                          <a href="applyexam.php" class="btn btn-primary mt-auto">Get Started</a>
                      </div>
                  </div>
              </div>
              
              <div class="col-md-6 col-lg-4 card-item fade-in">
                  <div class="card service-card h-100">
                       <div class="card-body text-center p-4 d-flex flex-column">
                          <i class="bi bi-book-half text-primary" style="font-size: 2.5rem;"></i>
                          <h5 class="card-title mt-3">Written Exam Guide</h5>
                          <p class="card-text">Prepare for the computer test with our study materials and practice questions.</p>
                           <a href="examguid.php" class="btn btn-primary mt-auto">Start Studying</a>
                      </div>
                  </div>
              </div>

          
              <div class="col-md-6 col-lg-4 card-item fade-in">
                  <div class="card service-card h-100">
                       <div class="card-body text-center p-4 d-flex flex-column">
                          <i class="bi bi-shield-check text-primary" style="font-size: 2.5rem;"></i>
                          <h5 class="card-title mt-3">Safety Guidelines</h5>
                          <p class="card-text">Access essential road safety rules and best practices for new drivers.</p>
                          <a href="safetyGuidelines.php" class="btn btn-primary mt-auto">Learn Safety</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>


    <footer class="bg-dark text-light py-4">
      <div class="container text-center">
        <p class="mb-0">&copy; <?php echo date("Y"); ?> E-License System | Developed by Dinod Deshanjana</p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>