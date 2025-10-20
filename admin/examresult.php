<?php

session_start();
require 'dbconnection.php';


if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in to access the admin panel.";
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error_message'] = "You do not have permission to access this page.";
    header("Location: dashboard.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_result'])) {
    $application_id = $_POST['application_id'];
    $result_status = $_POST['result'];

    if (empty($application_id) || empty($result_status)) {
        $_SESSION['error_message'] = "A result must be selected to save.";
    } else {
        
        $sql = "INSERT INTO exam_results (application_id, exam_date, result) VALUES (?, CURDATE(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $application_id, $result_status);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Result for Application #" . $application_id . " has been saved.";
        } else {
            if ($conn->errno == 1062) { 
                $_SESSION['error_message'] = "A result for this application already exists.";
            } else {
                $_SESSION['error_message'] = "Error saving result: " . $stmt->error;
            }
        }
        $stmt->close();
    }
    
    header("Location: examresult.php");
    exit();
}


$applicants = [];
$sql = "SELECT 
            ea.application_id,
            u.fullname,
            er.result,
            er.exam_date
        FROM 
            exam_applications AS ea
        JOIN 
            users AS u ON ea.user_id = u.user_id
        LEFT JOIN 
            exam_results AS er ON ea.application_id = er.application_id
        WHERE 
            ea.status = 'Approved'
        ORDER BY
            CASE WHEN er.result_id IS NULL THEN 0 ELSE 1 END, 
            ea.application_id DESC";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applicants[] = $row;
    }
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Exam Results</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
      body {
          background-color: #f4f6f9;
          font-family: 'Poppins', sans-serif;
      }
  </style>
</head>
<body style="background-color:#f4f6f9;">

  <?php include "adminnavigation.php" ?>

  <div class="container py-5">
    <h3 class="text-center text-primary mb-4">Add / Update Exam Results</h3>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive bg-white shadow rounded p-3">
      <table class="table table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>App ID</th>
            <th>User Name</th>
            <th>Result</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($applicants)): ?>
            <tr>
              <td colspan="4" class="text-center text-muted p-4">No approved applications found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($applicants as $applicant): ?>
              <tr>
                <form action="examresult.php" method="POST">
                  <td>
                    <?php echo htmlspecialchars($applicant['application_id']); ?>
                    <input type="hidden" name="application_id" value="<?php echo $applicant['application_id']; ?>">
                  </td>
                  <td><?php echo htmlspecialchars($applicant['fullname']); ?></td>
                  
                  <?php if (is_null($applicant['result'])): ?>
                    <td>
                      <select name="result" class="form-select form-select-sm" style="width:120px;" required>
                        <option value="" disabled selected>Select...</option>
                        <option value="Pass">Pass</option>
                        <option value="Fail">Fail</option>
                      </select>
                    </td>
                    <td>
                      <button type="submit" name="save_result" class="btn btn-primary btn-sm">Save</button>
                    </td>
                  <?php else:  ?>
                    <td>
                      <?php
                        $result_status = htmlspecialchars($applicant['result']);
                        $badge_class = ($result_status === 'Pass') ? 'bg-success' : 'bg-danger';
                        echo '<span class="badge ' . $badge_class . '">' . $result_status . '</span>';
                      ?>
                    </td>
                    <td>
                      <button class="btn btn-secondary btn-sm" disabled>Saved</button>
                    </td>
                  <?php endif; ?>
                </form>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
