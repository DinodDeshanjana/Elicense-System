<?php

session_start();
require 'dbconnection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error_message'] = "You do not have permission to access this page.";
    header("Location: login.php");
    exit();
}

$current_admin_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id_to_delete = $_POST['user_id'];


    if ($user_id_to_delete == $current_admin_id) {
        $_SESSION['error_message'] = "You cannot delete your own account.";
    } else {

        $sql_check_role = "SELECT role FROM users WHERE user_id = ?";
        $stmt_check = $conn->prepare($sql_check_role);
        $stmt_check->bind_param("i", $user_id_to_delete);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        $user_role = $result->fetch_assoc()['role'];
        $stmt_check->close();

        if ($user_role === 'admin') {
            $_SESSION['error_message'] = "Admins cannot be deleted from this panel.";
        } else {
       
            $sql_delete = "DELETE FROM users WHERE user_id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $user_id_to_delete);

            if ($stmt_delete->execute()) {
                $_SESSION['success_message'] = "User #" . $user_id_to_delete . " has been successfully deleted.";
            } else {
                $_SESSION['error_message'] = "Error deleting user.";
            }
            $stmt_delete->close();
        }
    }


    header("Location: manageusers.php.php");
    exit();
}



$users = [];
$sql = "SELECT user_id, fullname, email, nic, role FROM users ORDER BY FIELD(role, 'admin', 'user'), user_id ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Users</title>
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

<?php include "adminnavigation.php"?>

  <div class="container py-5">
    <h3 class="text-center text-primary mb-4">User Management</h3>
    

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
            <th>User ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>NIC</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($users)): ?>
            <tr><td colspan="6" class="text-center text-muted p-4">No registered users found.</td></tr>
          <?php else: ?>
            <?php foreach ($users as $user): ?>
            <tr>
              <td><?php echo htmlspecialchars($user['user_id']); ?></td>
              <td><?php echo htmlspecialchars($user['fullname']); ?></td>
              <td><?php echo htmlspecialchars($user['email']); ?></td>
              <td><?php echo htmlspecialchars($user['nic']); ?></td>
              <td>
                <?php
                  $role = htmlspecialchars($user['role']);
                  $badge_class = ($role === 'admin') ? 'bg-secondary' : 'bg-info text-dark';
                  echo '<span class="badge ' . $badge_class . '">' . ucfirst($role) . '</span>';
                ?>
              </td>
              <td>
                <?php if ($user['role'] === 'user'): ?>
                  <!-- Show Delete button only for regular users -->
                  <form action="manageusers.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <button type="submit" name="delete_user" class="btn btn-danger btn-sm">Delete</button>
                  </form>
                <?php else: ?>
                  <!-- Admins are protected -->
                  <button class="btn btn-secondary btn-sm" disabled>Protected</button>
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
</body>
</html>
