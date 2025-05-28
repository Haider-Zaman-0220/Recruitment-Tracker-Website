<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $description = trim(mysqli_real_escape_string($conn, $_POST['description']));

    if ($name === '') {
        $error = "Department name is required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO departments (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);

        if ($stmt->execute()) {
            $success = "Department created successfully.";
            // Optionally clear form inputs after success
            $name = $description = '';
        } else {
            $error = "Failed to create department.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Create Department - Recruitment Tracker</title>
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
</style>
</head>
<body>

<?php include('../partials/navbar.php'); ?>
<?php include('../partials/sidebar.php'); ?>

<div class="content" id="content">
  <div class="card-light p-4">
    <h2>Create Department</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" action="create_department.php" class="mt-3">
      <div class="mb-3">
        <label for="name" class="form-label">Department Name</label>
        <input type="text" id="name" name="name" class="form-control" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control"><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Create</button>
      <a href="view_departments.php" class="btn btn-secondary ms-2">Back to List</a>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('toggleSidebar').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('sidebar-hidden');
    document.getElementById('content').classList.toggle('full-width');
  });
</script>

</body>
</html>
