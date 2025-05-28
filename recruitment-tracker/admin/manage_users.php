<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');

// Only Admin allowed
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit();
}

// Fetch users
$users = mysqli_query($conn, "SELECT * FROM users");

// Handle Delete User
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users - Recruitment Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .content {
      margin-left: 260px;
      padding: 6rem 2rem 2rem 2rem;
      transition: margin-left 0.3s ease;
      min-height: 100vh;
      background-color: #f9f9f9;
    }

    .content.full-width {
      margin-left: 0;
    }

    .card-light {
      background-color: #fff;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      padding: 2rem;
    }

    .btn-narrow {
      padding-left: 20px;
      padding-right: 20px;
    }

    .footer {
      text-align: center;
      padding: 10px 0;
      color: #666;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<?php include('../partials/navbar.php'); ?>
<?php include('../partials/sidebar.php'); ?>

<div class="content" id="content">
  <div class="card-light">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Manage Users</h2>
      <a href="edit_user.php" class="btn btn-success btn-narrow">Add New User</a>
    </div>

    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Username</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($user = mysqli_fetch_assoc($users)): ?>
        <tr>
          <td><?= htmlspecialchars($user['name']); ?></td>
          <td><?= htmlspecialchars($user['email']); ?></td>
          <td><?= htmlspecialchars($user['username']); ?></td>
          <td><?= ucfirst($user['role']); ?></td>
          <td>
            <a href="edit_user.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="manage_users.php?delete=<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <div class="footer mt-4">
    <p>&copy; 2025 Recruitment Tracker. All Rights Reserved.</p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Sidebar toggle logic
  document.getElementById('toggleSidebar').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('sidebar-hidden');
    document.getElementById('content').classList.toggle('full-width');
  });
</script>

</body>
</html>
