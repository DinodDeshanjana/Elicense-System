<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - E-License</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
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
        background-color: #343a40; 
        color: white;
        padding: 1.5rem 0; 
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
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="about.php">About Us</a>
            </li>
          </ul>
          
          <div class="ms-3 d-flex gap-2">
            <?php if (isset($_SESSION['user_id'])): ?>
              <?php
                $dashboard_link = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'dashboard.php';
                $profile = ($_SESSION['role']== 'admin') ? 'admin_dashboard.php' : 'profile.php';
              ?>
              <a href="<?php echo $profile; ?>" class="btn btn-light">My Profile</a>
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

    <div class="container my-5">

        <section class="text-center" id="about"> <div class="fade-in">
            <h2 class="fw-bold mb-4">About Our E-License Portal</h2>
            <p class="lead text-muted mx-auto" style="max-width: 800px;">
              The Department of Motor Traffic is responsible for licensing, road safety enforcement, and vehicle inspections.
              Through the E-License system, these services are made simpler and faster for all citizens.
            </p>
          </div>
        </section>

        <hr class="my-5"> <div class="row g-4">
            <div class="col-lg-6">
                <h2><i class="bi bi-bullseye text-primary"></i> Our Mission</h2>
                <p>Our mission is simple: to help you pass your Sri Lankan driver's license exam with confidence and become a safe, responsible driver for life. We know the process can seem confusing, so we've gathered all the key resources in one easy-to-use place.</p>
            </div>
            <div class="col-lg-6">
                <h2><i class="bi bi-eye text-primary"></i> Our Vision</h2>
                <p>We believe that better-prepared drivers create safer roads for everyone. By providing clear study guides and essential safety practices, we hope to play a small part in building a safer, more confident driving culture across Sri Lanka.</p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card bg-light border-0 p-4">
                    <div class="card-body">
                        <h2 class="text-center mb-4">What We Provide</h2>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item bg-transparent fs-5">
                                <i class="bi bi-card-checklist me-2 text-success"></i>
                                A step-by-step guide to the <strong>Driver's License Application</strong> process.
                            </div>
                            <div class="list-group-item bg-transparent fs-5">
                                <i class="bi bi-book-half me-2 text-success"></i>
                                A detailed <strong>Written Exam Guide</strong> with study materials and practice questions.
                            </div>
                            <div class="list-group-item bg-transparent fs-5">
                                <i class="bi bi-shield-check me-2 text-success"></i>
                                Practical <strong>Safety Guidelines</strong> to build good driving habits from day one.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2>Get Started on Your Journey</h2>
                <p>Explore our guides, start studying, and take the first step towards getting your license. We're here to help you succeed.</p>
                <a href="index.php" class="btn btn-primary btn-lg">Back to Home</a>
            </div>
        </div>

    </div> <footer class="text-center"> <p class="mb-0">&copy; <?php echo date("Y"); ?> E-License System | Developed by Dinod Deshanjana</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>