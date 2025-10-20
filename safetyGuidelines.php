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


    <div class="container my-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h1 class="mb-4">Safety Guidelines for New Drivers</h1>
                <p class="lead">Access essential road safety rules and best practices for new drivers. Mastering the rules is the first step; driving safely is a lifelong skill.</p>
                <hr class="my-4">

                <h2><i class="bi bi-shield-check text-success"></i> The Core Safety Rules</h2>
                <p>These are the non-negotiable rules of safe driving. Make them a habit from day one.</p>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item fs-5"><i class="bi bi-check-circle-fill text-success me-2"></i><strong>Always Wear Your Seatbelt.</strong> This is the single most effective way to save your life in a crash. Ensure all passengers are buckled up too.</li>
                    <li class="list-group-item fs-5"><i class="bi bi-x-octagon-fill text-danger me-2"></i><strong>Never Drive Under the Influence.</strong> Do not drive after consuming alcohol or drugs. It severely impairs your judgment, coordination, and reaction time.</li>
                    <li class="list-group-item fs-5"><i class="bi bi-phone-off-fill text-danger me-2"></i><strong>Eliminate Distractions.</strong> Put your phone away. Never text and drive. Set your GPS and music before you start your trip.</li>
                    <li class="list-group-item fs-5"><i class="bi bi-sign-stop-lights-fill text-warning me-2"></i><strong>Obey Speed Limits.</strong> The speed limit is a maximum, not a target. Drive slower in bad weather, heavy traffic, or at night.</li>
                </ul>

                <h2 class="mt-5"><i class="bi bi-eye-fill text-primary"></i> Defensive Driving: The Key to Safety</h2>
                <p>Defensive driving means assuming other drivers might make mistakes. Your goal is to anticipate and avoid danger before it happens.</p>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">1. Keep a Safe Following Distance</h5>
                                <p class="card-text">Use the <strong>"3-Second Rule."</strong> Watch the vehicle in front of you pass a fixed object (like a sign). It should take you at least 3 seconds to pass the same object. Make it 4-5 seconds in rain or at night.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">2. Always Check Your Blind Spots</h5>
                                <p class="card-text">Your mirrors don't show you everything. Before changing lanes, always physically turn your head and look over your shoulder to check the blind spot.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">3. Scan the Road Ahead</h5>
                                <p class="card-text">Don't just look at the car in front of you. Scan 10-15 seconds down the road. Look for brake lights, pedestrians, cyclists, and potential hazards.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">4. Have an Escape Plan</h5>
                                <p class="card-text">Always be aware of the space around your vehicle. Leave yourself an "out" — a safe path into another lane or onto the shoulder if the car in front of you stops suddenly.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="mt-5"><i class="bi bi-exclamation-triangle-fill text-danger"></i> Special Tips for Driving in Sri Lanka</h2>
                <p>Driving in Sri Lanka has its own unique challenges. Be aware of these local practices:</p>
                <div class="accordion" id="sriLankaTips">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tip-one">
                                <strong>1. Be Aware of Buses and Trucks</strong>
                            </button>
                        </h2>
                        <div id="tip-one" class="accordion-collapse collapse show" data-bs-parent="#sriLankaTips">
                            <div class="accordion-body">
                                In Sri Lanka, larger vehicles (especially buses) often drive very aggressively and may not follow lane rules. <strong>Always give them space.</strong> Be prepared for them to overtake in risky situations. Do not challenge them.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tip-two">
                                <strong>2. Understand Honking (Using the Horn)</strong>
                            </button>
                        </h2>
                        <div id="tip-two" class="accordion-collapse collapse" data-bs-parent="#sriLankaTips">
                            <div class="accordion-body">
                                The horn is used frequently, often not out of anger. A common use is a short beep to mean "I am here" or "I am overtaking you." Be alert to these audio warnings.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tip-three">
                                <strong>3. Watch for Pedestrians, Bicycles, and Animals</strong>
                            </button>
                        </h2>
                        <div id="tip-three" class="accordion-collapse collapse" data-bs-parent="#sriLankaTips">
                            <div class="accordion-body">
                                People, stray dogs, and cyclists can appear on the road unexpectedly. Be especially careful in towns and at night. Be cautious at zebra crossings (pedestrian crossings) — traffic behind you may not expect you to stop, so check your mirrors.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tip-four">
                                <strong>4. Be Cautious with Motorcyclists</strong>
                            </button>
                        </h2>
                        <div id="tip-four" class="accordion-collapse collapse" data-bs-parent="#sriLankaTips">
                            <div class="accordion-body">
                                Motorcyclists are everywhere and may filter between lanes. Always signal your turns and lane changes well in advance, and check your mirrors and blind spots twice.
                            </div>
                        </div>
                    </div>
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