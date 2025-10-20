<?php

session_start();

require 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname   = trim($_POST['fullname']);
    $email      = trim($_POST['email']);
    $contact_no = trim($_POST['phone']); 
    $password   = $_POST['password'];
    $id = trim($_POST['nic']);

    // 2. Server-side Validation
    if (empty($fullname) || empty($email) || empty($contact_no) || empty($password) || empty($id)) {
        $_SESSION['error_message'] = "All fields are required. Please fill out the entire form.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format. Please enter a valid email address.";
    } else {
      
        $sql_check_email = "SELECT user_id FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check_email);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $_SESSION['error_message'] = "This email is already registered. Please <a href='login.php' class='alert-link'>login</a> instead.";
        } else {
          
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

         
            $sql_insert_user = "INSERT INTO users (fullname, email, password, contact_no, nic) VALUES (?, ?, ?, ?,?)";
            $stmt_insert = $conn->prepare($sql_insert_user);
            $stmt_insert->bind_param("sssss", $fullname, $email, $hashed_password, $contact_no, $id);

            if ($stmt_insert->execute()) {

                $_SESSION['success_message'] = "Registration successful! You can now log in.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Database error: Could not complete registration.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
    

    if(isset($_SESSION['error_message'])){
        header("Location: register.php");
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
  <title>E-License | Register</title>

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
    .register-body {
      background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
      font-family: 'Poppins', sans-serif;
    }
    .box-area {
      border-radius: 12px;
    }
  </style>
</head>
<body class="register-body">

  <div class="container d-flex justify-content-center py-5">
    <div class="row border rounded-4 p-4 bg-white shadow box-area" style="max-width: 520px; width: 100%;">

      <div class="text-center mb-4">
        <i class="bi bi-person-plus-fill display-4 text-warning"></i>
        <h3 class="fw-bold mt-2">Create an Account</h3>
        <p class="text-muted">Register to access your E-License dashboard</p>
      </div>

      <?php
      if (isset($_SESSION['error_message'])) {
          echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
          unset($_SESSION['error_message']);
      }
      ?>

      <form action="register.php" method="POST">
        
        <div class="mb-3">
          <label class="form-label fw-semibold">Full Name</label>
          <input type="text" name="fullname" class="form-control" placeholder="John Doe" required>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">ID Number (NIC)</label>
            <input type="text" name="nic" class="form-control" placeholder="123456789ABC" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Contact Number</label>
            <input type="tel" name="phone" class="form-control" placeholder="+94 70 123 4567" required>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Email Address</label>
           <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
          </div>
          <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Enter a secure password" required>
          </div>
        </div>

        <div class="d-grid mt-3">
          <button type="submit" class="btn btn-warning fw-bold">Register Now</button>
        </div>

        <div class="text-center mt-3">
          <p class="mb-0">Already have an account? <a href="login.php" class="text-warning fw-semibold text-decoration-none">Login</a></p>
        </div>
      </form>
      <div class="text-center mt-3 back-link">
        <a href="index.php" class="mb-0 text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back to Home</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.nptm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

