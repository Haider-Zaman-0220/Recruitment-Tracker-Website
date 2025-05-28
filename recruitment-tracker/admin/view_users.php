<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit();
}

// Fetch all users
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>View Users - Recruitment Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
 
  <style>
    .content {
      margin-left: 260px;
      padding: 6rem 2rem 2rem 2rem;
      transition: margin-left 0.3s ease;
      min-height: 100vh;
      background-color: #f9f9f9;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .content.full-width {
      margin-left: 0;
    }
    .card-light {
      background-color: #fff;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      padding: 2rem;
      width: 100%;
      max-width: 1100px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    table th, table td {
      padding: 15px 20px;
      text-align: left;
    }
    table th {
      background-color: #007bff;
      color: white;
      font-weight: bold;
    }
    table td {
      background-color: #f9f9f9;
      color: #333;
    }
    table tr:nth-child(even) td {
      background-color: #f1f1f1;
    }
    table tr:hover {
      background-color: #e9ecef;
      cursor: pointer;
    }

    .btn-custom {
      background-color: #007bff;
      color: white;
      border-radius: 30px;
      padding: 10px 25px;
      font-size: 1rem;
      transition: background-color 0.3s ease;
    }
    .btn-custom:hover {
      background-color: #0056b3;
      color: white;
    }

    .no-data {
      text-align: center;
      font-size: 1.25rem;
      color: #888;
      margin-top: 20px;
    }

    .footer {
      text-align: center;
      padding: 10px 0;
      color: #666;
      font-size: 0.9rem;
      margin-top: 2rem;
    }
  </style>
</head>
<body>

<?php include('../partials/navbar.php'); ?>
<?php include('../partials/sidebar.php'); ?>

<div class="content" id="content">
  <div class="card-light">
    <h2 class="mb-4 text-center">Registered Users</h2>

    <?php if (mysqli_num_rows($users) === 0): ?>
      <p class="no-data">No users found.</p>
    <?php else: ?>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($user = mysqli_fetch_assoc($users)): ?>
            <tr>
              <td><?= htmlspecialchars($user['name']); ?></td>
              <td><?= htmlspecialchars($user['email']); ?></td>
              <td><?= htmlspecialchars($user['username']); ?></td>
              <td><?= htmlspecialchars($user['role']); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <div class="text-center mt-4">
      <a href="../dashboard.php" class="btn btn-custom"><i class="bi bi-arrow-left-circle"></i> Back to Dashboard</a>
    </div>
  </div>

  <div class="footer">
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
