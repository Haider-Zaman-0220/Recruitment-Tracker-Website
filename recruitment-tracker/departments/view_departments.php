<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM departments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: view_departments.php');
    exit();
}

$departments = mysqli_query($conn, "SELECT * FROM departments ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Departments List - Recruitment Tracker</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<style>
  body {
    background-color: #f9f9f9;
  }
  .content {
    margin-left: 260px;
    padding: 6rem 2rem 2rem 2rem;
    min-height: 100vh;
  }
  .content.full-width {
    margin-left: 0;
  }
  .card-light {
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    color: #212529;
  }
  td .btn {
    white-space: nowrap;
    min-width: 75px;
  }
</style>
</head>
<body>

<?php include('../partials/navbar.php'); ?>
<?php include('../partials/sidebar.php'); ?>

<div class="content" id="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Departments</h2>
    <a href="create_department.php" class="btn btn-success">Add Department</a>
  </div>

  <div class="card-light p-4">
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th style="width: 130px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($dept = mysqli_fetch_assoc($departments)): ?>
          <tr>
            <td><?= htmlspecialchars($dept['name']) ?></td>
            <td><?= htmlspecialchars($dept['description']) ?></td>
            <td class="d-flex gap-2 flex-wrap">
              <a href="edit_department.php?id=<?= $dept['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="view_departments.php?delete=<?= $dept['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this department?');">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
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
