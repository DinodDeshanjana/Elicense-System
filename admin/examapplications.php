<?php

session_start();
require 'dbconnection.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error_message'] = "You do not have permission to access this page.";
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'])) {
    $application_id = (int) $_POST['application_id'];

    if (isset($_POST['approve'])) {
        $exam_date = isset($_POST['exam_date']) ? trim($_POST['exam_date']) : '';

        if (empty($exam_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $exam_date)) {
            $_SESSION['error_message'] = "Please select a valid exam date before approving.";
        } else {
            $sql = "UPDATE exam_applications SET status = 'Approved', scheduled_exam_date = ? WHERE application_id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("si", $exam_date, $application_id);
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Application #$application_id has been approved for $exam_date.";
                } else {
                    $_SESSION['error_message'] = "DB execute error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $_SESSION['error_message'] = "DB prepare error: " . $conn->error;
            }
        }
    }
    elseif (isset($_POST['reject'])) {
        $sql = "UPDATE exam_applications SET status = 'Rejected' WHERE application_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $application_id);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Application #$application_id has been rejected.";
            } else {
                $_SESSION['error_message'] = "DB execute error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "DB prepare error: " . $conn->error;
        }
    }

    header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
    exit();
}

$applications = [];
$sql = "SELECT 
            ea.application_id, 
            ea.applied_date, 
            ea.scheduled_exam_date, 
            ea.status, 
            u.fullname, 
            u.nic 
        FROM exam_applications AS ea
        JOIN users AS u ON ea.user_id = u.user_id
        ORDER BY FIELD(ea.status, 'Pending', 'Approved', 'Rejected'), ea.applied_date DESC";

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
    $result->free();
} else {
    $_SESSION['error_message'] = "DB fetch error: " . $conn->error;
}

$conn->close();

$today = date('Y-m-d');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Exam Applications</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f4f6f9; font-family: Poppins, sans-serif; }
    .table thead th { background: #cfe2ff; }
    .table td, .table th { vertical-align: middle; }
    .card-table { box-shadow: 0 6px 18px rgba(0,0,0,0.08); border-radius: 8px; }
  </style>
</head>
<body>

<?php include "adminnavigation.php" ?>

  <div class="container py-5">
    <h3 class="text-center text-primary mb-4">Manage Exam Applications</h3>

    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="alert alert-success alert-dismissible fade show"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="table-responsive bg-white p-3 card-table">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>App ID</th>
            <th>User Name</th>
            <th>NIC</th>
            <th>Date Applied</th>
            <th>Scheduled Exam Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($applications)): ?>
            <tr><td colspan="7" class="text-center text-muted">No applications found.</td></tr>
          <?php else: ?>
            <?php foreach ($applications as $app): ?>
              <tr>
                <td><?php echo htmlspecialchars($app['application_id']); ?></td>
                <td><?php echo htmlspecialchars($app['fullname']); ?></td>
                <td><?php echo htmlspecialchars($app['nic']); ?></td>
                <td><?php echo htmlspecialchars($app['applied_date']); ?></td>
                <td>
                  <?php if ($app['status'] !== 'Pending'): ?>
                    <?php if (!empty($app['scheduled_exam_date'])): ?>
                      <?php echo htmlspecialchars($app['scheduled_exam_date']); ?>
                    <?php else: ?>
                      <span class="text-muted">N/A</span>
                    <?php endif; ?>
                  <?php else: ?>
                    <input type="date" id="exam_date_<?php echo (int)$app['application_id']; ?>" data-app-id="<?php echo (int)$app['application_id']; ?>" class="form-control form-control-sm" style="width: 160px;" min="<?php echo $today; ?>" required>
                  <?php endif; ?>
                </td>
                <td>
                  <?php
                    $status = htmlspecialchars($app['status']);
                    $badge = 'bg-warning text-dark';
                    if ($status === 'Approved') $badge = 'bg-success';
                    if ($status === 'Rejected') $badge = 'bg-danger';
                    echo "<span class='badge $badge'>$status</span>";
                  ?>
                </td>
                <td style="min-width: 200px;">
                  <?php if ($app['status'] === 'Pending'): ?>
                    <form id="rejectForm_<?php echo (int)$app['application_id']; ?>" method="post" style="display: inline;">
                      <input type="hidden" name="application_id" value="<?php echo (int)$app['application_id']; ?>">
                      <button type="submit" name="reject" class="btn btn-danger btn-sm">Reject</button>
                    </form>
                    <button type="button" class="btn btn-success btn-sm ms-1" onclick="approveApplication(<?php echo (int)$app['application_id']; ?>)">Approve</button>
                  <?php else: ?>
                    <button class="btn btn-secondary btn-sm" disabled><?php echo $status; ?></button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function approveApplication(appId) {
      var dateInput = document.getElementById('exam_date_' + appId);
      var examDate = dateInput.value.trim();

      if (!examDate) {
        alert('Please select a scheduled exam date before approving.');
        return false;
      }

      if (!/^\d{4}-\d{2}-\d{2}$/.test(examDate)) {
        alert('Invalid date format. Please select from the calendar.');
        return false;
      }

      var form = document.createElement('form');
      form.method = 'POST';
      form.style.display = 'none';

      var inputAppId = document.createElement('input');
      inputAppId.type = 'hidden';
      inputAppId.name = 'application_id';
      inputAppId.value = appId;
      form.appendChild(inputAppId);

      var inputExamDate = document.createElement('input');
      inputExamDate.type = 'hidden';
      inputExamDate.name = 'exam_date';
      inputExamDate.value = examDate;
      form.appendChild(inputExamDate);

      var inputApprove = document.createElement('input');
      inputApprove.type = 'hidden';
      inputApprove.name = 'approve';
      inputApprove.value = '1';
      form.appendChild(inputApprove);

      document.body.appendChild(form);
      form.submit();
    }
  </script>
</body>
</html>