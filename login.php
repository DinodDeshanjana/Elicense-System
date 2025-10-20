<?php

session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}

require 'dbconnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Both email and password are required.";
    } else {
        $sql = "SELECT user_id, fullname, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                
                session_regenerate_id(true); 
                $_SESSION['user_id']  = $user['user_id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role']     = $user['role'];
                
                if ($user['role'] === 'admin') {
                    header("Location: admin/admin.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit(); 

            } else {
                $_SESSION['error_message'] = "Invalid email or password. Please try again.";
            }
        } else {

            $_SESSION['error_message'] = "Invalid email or password. Please try again.";
        }
        $stmt->close();
    }
    
    
    if(isset($_SESSION['error_message'])){
        header("Location: login.php");
        exit();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-License | Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-blue: #0d6efd;
      --secondary-blue: #3b82f6;
      --light-blue: #e3f2fd;
      --dark-blue: #0043a6;
    }
    .login-body {
      background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
      font-family: 'Poppins', sans-serif;
    }
    .box-area {
      border-radius: 12px;
    }
  </style>
</head>
<body class="login-body">

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-4 p-4 bg-white shadow box-area" style="max-width: 480px; width: 100%;">

      <div class="text-center mb-4">
        <i class="bi bi-person-circle display-4 text-warning"></i>
        <h3 class="fw-bold mt-2">Welcome Back</h3>
        <p class="text-muted">Login to manage your E-License</p>
      </div>

      <?php
      if (isset($_SESSION['success_message'])) {
          echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
          unset($_SESSION['success_message']); 
      }
      if (isset($_SESSION['error_message'])) {
          echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
          unset($_SESSION['error_message']); 
      }
      ?>

      <form action="login.php" method="POST">
        <div class="mb-3">
          <label class="form-label fw-semibold">Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
      
        <div class="d-grid mt-3">
          <button type="submit" class="btn btn-warning fw-bold">Login</button>
        </div>

        <div class="text-center mt-3">
          <p class="mb-0">Don't have an account? <a href="register.php" class="text-warning fw-semibold text-decoration-none">Register</a></p>
        </div>
      </form>
      <div class="text-center mt-3 back-link">
        <a href="index.php" class="mb-0 text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back to Home</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

