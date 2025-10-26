<?php
session_start();
require 'dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$dashboard_link = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'dashboard.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname   = trim($_POST['fullname']);
    $email      = trim($_POST['email']);
    $contact_no = trim($_POST['phone']);
    $nic        = trim($_POST['nic']);
    $password   = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($fullname) || empty($email) || empty($contact_no) || empty($nic)) {
        $_SESSION['error_message'] = "All fields (except password) are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
    } else {
        
        $sql_check_email = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
        $stmt_check = $conn->prepare($sql_check_email);
        $stmt_check->bind_param("si", $email, $user_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $_SESSION['error_message'] = "This email is already registered to another account.";
        } else {
            
            if (!empty($password)) {
                if ($password !== $confirm_password) {
                    $_SESSION['error_message'] = "New passwords do not match.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql_update = "UPDATE users SET fullname = ?, email = ?, contact_no = ?, nic = ?, password = ? WHERE user_id = ?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("sssssi", $fullname, $email, $contact_no, $nic, $hashed_password, $user_id);
                }
            } else {
                $sql_update = "UPDATE users SET fullname = ?, email = ?, contact_no = ?, nic = ? WHERE user_id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ssssi", $fullname, $email, $contact_no, $nic, $user_id);
            }

            if (isset($stmt_update)) {
                if ($stmt_update->execute()) {
                    $_SESSION['success_message'] = "Profile updated successfully!";
                } else {
                    $_SESSION['error_message'] = "Database error: Could not update profile.";
                }
                $stmt_update->close();
            }
        }
        $stmt_check->close();
    }
    
    header("Location: profile.php");
    exit();
}

$sql_fetch = "SELECT fullname, email, nic, contact_no FROM users WHERE user_id = ?";
$stmt_fetch = $conn->prepare($sql_fetch);
$stmt_fetch->bind_param("i", $user_id);
$stmt_fetch->execute();
$stmt_fetch->bind_result($fullname, $email, $nic, $contact_no);
$stmt_fetch->fetch();
$stmt_fetch->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - E-License</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
      :root {
        --primary-blue: #0d6efd;
      }
      body { 
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa; 
      }
      .navbar { 
        background: white; 
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); 
        padding: 1rem 0; 
      }
      .navbar-brand { 
        font-weight: 700; 
        font-size: 1.5rem; 
        color: rgb(8, 8, 8) !important; 
      }
      .navbar-brand i { 
        margin-right: 0.5rem;
        color: var(--primary-blue);
      }
      .nav-link { 
        color: rgba(12, 12, 12, 0.8) !important; 
        font-weight: 600; 
        margin: 0 0.5rem; 
        font-size: 1rem; 
      }
      .nav-link:hover { 
        color: var(--primary-blue) !important; 
      }
      .btn-logout-nav {
        background-color: #dc3545;
        color: white;
        font-weight: bold;
        padding: 0.5rem 1.5rem;
        border-radius: 60px; 
        transition: all 0.3s ease;
        border: none;
        text-decoration: none; 
        display: inline-block;
      }
      .btn-logout-nav:hover {
        background-color: #c82333;
        color: white;
        transform: translateY(-2px);
      }
      .profile-form-container {
        background: #ffffff;
        border-radius: 12px;
        padding: 2.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      }
      .form-label {
        font-weight: 600;
        color: #555;
      }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <i class="fas fa-id-card"></i> E-License
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-center">
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

            <li class="nav-item">
              <a class="nav-link" href="profile.php">My Profile</a>
            </li>

            <?php if (isset($_SESSION['user_id'])): ?>
              <li class="nav-item">
                 <a class="nav-link" href="<?php echo $dashboard_link; ?>">My Dashboard</a>
              </li>
              <li class="nav-item ms-lg-3">
                 <a href="logout.php" class="btn-logout-nav">Logout</a>
              </li>
            <?php else: ?>
              <li class="nav-item ms-lg-3">
                <a href="login.php" class="btn btn-primary" style="border-radius: 60px; padding: 0.5rem 1.5rem;">Login</a>
              </li>
            <?php endif; ?>

          </ul>
        </div>
      </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-7 col-md-10 mx-auto">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">My Profile</h2>
                    <a href="<?php echo $dashboard_link; ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Dashboard
                    </a>
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

                <div class="profile-form-container">
                    <form action="profile.php" method="POST">
                        
                        <div class="mb-4">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($fullname); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">ID Number (NIC)</label>
                                <input type="text" name="nic" class="form-control" value="<?php echo htmlspecialchars($nic); ?>" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Contact Number</label>
                                <input type="tel" name="phone" class="form-control" value="<?php echo htmlspecialchars($contact_no); ?>" required>
                            </div>
                        </div>

                        <hr classs="my-4">
                        
                        <h5 class="fw-bold mt-4 mb-3">Update Password (Optional)</h5>
                        
                        <div class="mb-4">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Re-type new password">
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 mt-5" style="background-color: #343a40; color: white;">
      <p class="mb-0">&copy; <?php echo date("Y"); ?> E-License System | Developed by Dinod Deshanjana</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>