<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in to view your exam results.";
    header("Location: login.php");
    exit();
}

require 'dbconnection.php';

$user_id = $_SESSION['user_id'];

$results = [];
$sql = "SELECT 
            er.exam_date,
            er.result,
            ea.exam_type,
            ea.application_id
        FROM exam_results AS er
        JOIN exam_applications AS ea ON er.application_id = ea.application_id
        WHERE ea.user_id = ?
        ORDER BY er.exam_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_set = $stmt->get_result();

while ($row = $result_set->fetch_assoc()) {
    $results[] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Exam Results - E-License</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
body {
  background-color: #f4f6f9;
  font-family: 'Poppins', sans-serif;
  min-height: 100vh;
  position: relative;
  padding-bottom: 80px;
}

footer {
  position: absolute;
  bottom: 0;
  width: 100%;
}
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 900px;
      margin: auto;
    }
    .badge { 
        font-size: 0.9rem;
        padding: 0.5em 0.9em;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
  </style>
</head>
<body>
   <?php include "usernavigation.php"; ?>
<div class="container mt-5">
  <div class="card p-4 p-md-5">
    <h3 class="text-center text-primary mb-3">Your Exam Results</h3>
    <p class="text-center text-muted mb-4">A history of your written and practical exam results.</p>

    <div class="table-responsive">
        <table class="table table-hover text-center align-middle">
        <thead class="table-light">
          <tr>
            <th>Application ID</th>
            <th>Exam Type</th>
            
            <th>Result</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($results)): ?>
            <tr>
              <td colspan="4" class="text-center text-muted p-4">No exam results found. Results will appear here after an admin updates them.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($results as $res): ?>
              <tr>
                <td><?php echo 'APP-' . htmlspecialchars($res['application_id']); ?></td>
                <td><?php echo htmlspecialchars(ucfirst($res['exam_type'])); ?></td>
                
                <td>
                  <?php
                    // Set a different badge color based on the result
                    $result_status = htmlspecialchars($res['result']);
                    $badge_class = '';
                    switch ($result_status) {
                        case 'Pass':
                            $badge_class = 'bg-success';
                            break;
                        case 'Fail':
                            $badge_class = 'bg-danger';
                            break;
                        case 'Pending':
                        default:
                            $badge_class = 'bg-secondary';
                            break;
                    }
                    echo '<span class="badge ' . $badge_class . '">' . $result_status . '</span>';
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="text-center mt-4">
        <a href="dashboard.php" class="text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back to Dashboard</a>
    </div>
  </div>
</div>

 <footer class="bg-dark text-light py-4 mt-5">
    <div class="container text-center">
      <p class="mb-0">&copy; <?php echo date("Y"); ?> E-License System | Developed by Dinod Deshanjana</p>
    </div>
  </footer>

</body>
</html>
