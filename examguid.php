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
              <a class="nav-link" href="about.php">About Us</a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
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


    <div class="container my-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h1 class="fw-bold mb-4">Sri Lanka Driver's License Written Exam Guide</h1>
                <p class="lead">Prepare for the computer test with our study materials and practice questions. The official test is designed to check your knowledge of road rules, traffic signs, and safe driving practices.</p>

                <hr class="my-4">

                <h2>About the Exam</h2>
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li><strong><i class="bi bi-laptop"></i> Format:</strong> Computer-Based Test (Multiple Choice)</li>
                            <li><strong><i class="bi bi-question-circle"></i> Questions:</strong> Approximately 40-45 questions</li>
                            <li><strong><i class="bi bi-clock"></i> Time Limit:</strong> Approximately 60 minutes</li>
                            <li><strong><i class="bi bi-translate"></i> Languages:</strong> Available in English, Sinhala, and Tamil</li>
                        </ul>
                    </div>
                </div>

                <h2 class="mt-5">Key Topics to Study</h2>
                <div class="accordion" id="topicsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
                                <strong>1. Road Signs</strong>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#topicsAccordion">
                            <div class="accordion-body">
                                You must know all three categories of road signs:
                                <ul>
                                    <li><strong>Warning Signs:</strong> Usually triangular, warning of potential hazards (e.g., sharp curves, pedestrian crossings, slippery roads).</li>
                                    <li><strong>Regulatory Signs:</strong> Signs that give an order.
                                        <ul>
                                            <li><strong>Prohibitory:</strong> (e.g., No Entry, No U-Turn, Speed Limit)</li>
                                            <li><strong>Mandatory:</strong> (e.g., Proceed Straight, Turn Left Only, Roundabout)</li>
                                            <li><strong>Priority:</strong> (e.g., STOP sign, Give Way sign)</li>
                                        </ul>
                                    </li>
                                    <li><strong>Informative Signs:</strong> Provide information (e.g., hospital ahead, parking, highway numbers).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                <strong>2. Rules of the Road</strong>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#topicsAccordion">
                            <div class="accordion-body">
                                This includes right-of-way rules (e.g., at roundabouts, give way to vehicles from your right), rules for overtaking, proper use of lanes, speed limits for different vehicles, and understanding road markings (e.g., solid vs. broken lines).
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                <strong>3. Hand Signals</strong>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#topicsAccordion">
                            <div class="accordion-body">
                                Be sure to learn the correct driver's hand signals for stopping, turning right, and turning left.
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="mt-5">Common Road Signs</h2>
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100">
                                                        <div class="card-body">
                                <h5 class="card-title">STOP</h5>
                                <p class="card-text"><strong>Type:</strong> Priority</p>
                                <p class="card-text">Must come to a complete stop and give way to all traffic.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100">
                                                        <div class="card-body">
                                <h5 class="card-title">Give Way</h5>
                                <p class="card-text"><strong>Type:</strong> Priority</p>
                                <p class="card-text">Slow down and be ready to stop; give way to traffic on the major road.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100">
                                                        <div class="card-body">
                                <h5 class="card-title">No Entry</h5>
                                <p class="card-text"><strong>Type:</strong> Prohibitory</p>
                                <p class="card-text">You must not drive your vehicle into this road or area.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100">
                                                        <div class="card-body">
                                <h5 class="card-title">Pedestrian Crossing</h5>
                                <p class="card-text"><strong>Type:</strong> Warning/Informative</p>
                                <p class="card-text">Be prepared to slow down and stop for people crossing the road.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="mt-5">Sample Practice Questions</h2>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Q: At a roundabout, who has the right of way?</strong><br>
                        A: Vehicles already on the roundabout and approaching from your right.
                    </li>
                    <li class="list-group-item">
                        <strong>Q: What does a solid white line in the center of the road mean?</strong><br>
                        A: You must not cross or overtake. The line must be kept on your right.
                    </li>
                    <li class="list-group-item">
                        <strong>Q: What does a triangular sign with a red border indicate?</strong><br>
                        A: A warning sign (e.g., sharp curve ahead, school, or slippery road).
                    </li>
                </ul>

                <h2 class="mt-5">Study Resources</h2>
                <div class="list-group">
                    <a href="httpsa://dmt.gov.lk/index.php?lang=en" class="list-group-item list-group-item-action" target="_blank">
                        Official Department of Motor Traffic (DMT) Website
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        Download the official "Sri Lanka Drivers Manual - Highway Code" (Check the DMT site for links)
                    </a>
                </div>

            </div>
        </div>
    </div>

    <footer class="bg-dark text-light py-4">
      <div class="container text-center">
        <p class="mb-0">&copy; <?php echo date("Y"); ?> E-License System | Developed by Dinod Deshanjana</p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>