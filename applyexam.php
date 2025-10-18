<?php

/**
 * E-License System | Exam Application
 *
 * - Allows logged-in users to apply for an exam.
 * - Prevents access for non-logged-in users.
 * - Submits application data to the 'exam_applications' table.
 */

// Must be the very first line to use sessions
session_start();

// 1. Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    // Set a message to inform the user why they were redirected
    $_SESSION['error_message'] = "Please log in to apply for an exam.";
    header("Location: login.php");
    exit();
}

// Include the database connection file.
require 'dbconnection.php';

// 2. Fetch the logged-in user's details to pre-fill the form
$user_id = $_SESSION['user_id'];
$fullname = '';
$nic = '';

$sql_user = "SELECT fullname, nic FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
if ($user_data = $result_user->fetch_assoc()) {
    $fullname = $user_data['fullname'];
    $nic = $user_data['nic'];
}
$stmt_user->close();


// --- FORM PROCESSING LOGIC ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Retrieve form data
    $exam_type = $_POST['exam_type'];
    $applied_date = date('Y-m-d'); // Get the current date in YYYY-MM-DD format

    // 4. Validation
    if (empty($exam_type) || $exam_type === "Select Exam Type") {
        $_SESSION['error_message'] = "Please select a valid exam type.";
    } else {
        // 5. Check for existing 'Pending' or 'Approved' applications to prevent duplicates
        $sql_check = "SELECT application_id FROM exam_applications WHERE user_id = ? AND exam_type = ? AND (status = 'Pending' OR status = 'Approved')";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("is", $user_id, $exam_type);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $_SESSION['error_message'] = "You already have an active application for the " . htmlspecialchars($exam_type) . " exam.";
        } else {
            // 6. Insert the new application into the database
            $sql_insert = "INSERT INTO exam_applications (user_id, exam_type, applied_date, status) VALUES (?, ?, ?, 'Pending')";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iss", $user_id, $exam_type, $applied_date);

            if ($stmt_insert->execute()) {
                $_SESSION['success_message'] = "Your application for the " . htmlspecialchars($exam_type) . " exam has been submitted successfully!";
                header("Location: dashboard.php"); // Redirect to dashboard on success
                exit();
            } else {
                $_SESSION['error_message'] = "Database error. Could not submit your application.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
    
    // If there was an error, redirect back to this page to display it
    header("Location: applyexam.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Apply for Exam - E-License</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 700px;
      margin: auto;
    }
    .btn-custom { background-color: #007bff; color: #fff; }
    .btn-custom:hover { background-color: #0056b3; }
  </style>
</head>
<body>
<div class="container mt-5">
  <div class="card p-4 p-md-5">
    <h3 class="text-center mb-3 text-primary">Apply for Driving Exam</h3>
    <p class="text-center text-muted mb-4">Submit your application for the driving license exam.</p>

    <!-- Message Display Area -->
    <?php
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']); // Clear message
    }
    ?>

    <!-- The form posts data to this same page -->
    <form action="applyexam.php" method="POST">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Full Name</label>
          <!-- Pre-fill user data and make it readonly -->
          <input type="text" class="form-control" value="<?php echo htmlspecialchars($fullname); ?>" readonly>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">NIC Number</label>
          <input type="text" class="form-control" value="<?php echo htmlspecialchars($nic); ?>" readonly>
        </div>
      </div>
      <div class="mb-3">
        <label for="exam_type" class="form-label fw-semibold">Exam Type</label>
        <!-- The 'name' attribute is crucial for PHP to receive the data -->
        <select class="form-select" name="exam_type" id="exam_type" required>
          <option selected disabled>Select Exam Type</option>
          <option value="written">Written Exam</option>
          <option value="practical">Practical Exam</option>
        </select>
      </div>
      <div class="text-center mt-4">
        <button type="submit" class="btn btn-custom px-5">Submit Application</button>
      </div>
    </form>
     <div class="text-center mt-3">
        <a href="dashboard.php" class="text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back to Dashboard</a>
    </div>
  </div>
</div>
</body>
</html>
