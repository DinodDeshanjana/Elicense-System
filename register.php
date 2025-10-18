<?php
/**
 * E-License System | User Registration
 *
 * This single file handles both the display of the registration form
 * and the processing of the form submission.
 */

// Must be the very first line to use sessions
session_start();

// Include the database connection file.
require 'dbconnection.php';

// --- FORM PROCESSING LOGIC ---
// This block will only run when the user submits the form (sends a POST request).
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Retrieve and sanitize input data
    $fullname   = trim($_POST['fullname']);
    $email      = trim($_POST['email']);
    $contact_no = trim($_POST['phone']); 
    $password   = $_POST['password'];

    // 2. Server-side Validation
    if (empty($fullname) || empty($email) || empty($contact_no) || empty($password)) {
        $_SESSION['error_message'] = "All fields are required. Please fill out the entire form.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format. Please enter a valid email address.";
    } else {
        // 3. Check if the email already exists
        $sql_check_email = "SELECT user_id FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check_email);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $_SESSION['error_message'] = "This email is already registered. Please <a href='login.php' class='alert-link'>login</a> instead.";
        } else {
            // 4. Hash the password for secure storage
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 5. Insert the new user into the database
            $sql_insert_user = "INSERT INTO users (fullname, email, password, contact_no) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert_user);
            $stmt_insert->bind_param("ssss", $fullname, $email, $hashed_password, $contact_no);

            if ($stmt_insert->execute()) {
                // If successful, set a success message and redirect to the login page
                $_SESSION['success_message'] = "Registration successful! You can now log in.";
                header("Location: login.php");
                exit(); // Important to stop the script after a redirect
            } else {
                $_SESSION['error_message'] = "Database error: Could not complete registration.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
    
    // If there was an error, redirect back to this same page to display it
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

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-4 p-4 bg-white shadow box-area" style="max-width: 520px; width: 100%;">

      <!-- Header -->
      <div class="text-center mb-4">
        <i class="bi bi-person-plus-fill display-4 text-warning"></i>
        <h3 class="fw-bold mt-2">Create an Account</h3>
        <p class="text-muted">Register to access your E-License dashboard</p>
      </div>

      <!-- PHP code to display error messages -->
      <?php
      if (isset($_SESSION['error_message'])) {
          echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
          // Unset the session variable so it doesn't show again on refresh
          unset($_SESSION['error_message']);
      }
      ?>

      <!-- Register Form -->
      <!-- The action attribute points to this same file -->
      <form action="register.php" method="POST">
        <div class="mb-3">
          <label class="form-label fw-semibold">Full Name</label>
          <input type="text" name="fullname" class="form-control" placeholder="Enter your full name" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
      
        <div class="mb-3">
          <label class="form-label fw-semibold">Contact Number</label>
          <input type="tel" name="phone" class="form-control" placeholder="Enter your mobile number" required>
        </div>
      
        <div class="mb-3">
          <label class="form-label fw-semibold">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
      
        <div class="d-grid mt-3">
          <button type="submit" class="btn btn-warning fw-bold">Register</button>
        </div>

        <div class="text-center mt-3">
          <!-- Make sure login.php exists -->
          <p class="mb-0">Already have an account? <a href="login.php" class="text-warning fw-semibold text-decoration-none">Login</a></p>
        </div>
      </form>
      <div class="text-center mt-3 back-link">
        <a href="index.html" class="mb-0 text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back to Home</a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

