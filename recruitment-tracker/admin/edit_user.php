<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user = ['name' => '', 'email' => '', 'username' => '', 'role' => 'user', 'password' => ''];

if ($id) {
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
    $user = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    if ($id) {
        // Update
        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET name='$name', email='$email', username='$username', role='$role', password='$passwordHash' WHERE id=$id");
        } else {
            mysqli_query($conn, "UPDATE users SET name='$name', email='$email', username='$username', role='$role' WHERE id=$id");
        }
    } else {
        // Create
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (name, email, username, role, password) VALUES ('$name', '$email', '$username', '$role', '$passwordHash')");
    }

    header('Location: manage_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $id ? 'Edit' : 'Add'; ?> User - Recruitment Tracker</title>
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
      max-width: 600px;
      margin: 0 auto;
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
    <h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> User</h2>

    <form method="POST" id="userForm" novalidate>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Role</label>
        <select class="form-select" name="role" required>
          <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
          <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Password <?= $id ? '(leave blank to keep current)' : ''; ?></label>
        <input type="password" class="form-control" name="password" <?= $id ? '' : 'required'; ?>>
      </div>
      <button type="submit" class="btn btn-success"><?= $id ? 'Update' : 'Create'; ?> User</button>
      <a href="manage_users.php" class="btn btn-secondary ms-2">Back</a>
    </form>
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
