<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');
require_once('../config/functions.php'); // Needed for logActivity()

// Variables for form fields
$title = $description = $location = $salary = $department_id = "";
$departments_res = mysqli_query($conn, "SELECT * FROM departments ORDER BY name");

// If editing an existing job, fetch the job details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM jobs WHERE id = $id");
    $job = mysqli_fetch_assoc($query);
    if ($job) {
        $title = $job['title'];
        $description = $job['description'];
        $location = $job['location'];
        $salary = $job['salary'];
        $department_id = $job['department_id']; // fetch department_id
    }
}

// Handle form submission for adding/editing job
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $department_id = isset($_POST['department_id']) ? intval($_POST['department_id']) : null;

    if (isset($_GET['id'])) { // Update existing job
        $id = intval($_GET['id']);
        mysqli_query($conn, "UPDATE jobs SET title = '$title', description = '$description', location = '$location', salary = '$salary', department_id = " . ($department_id ?: "NULL") . " WHERE id = $id");

        // ✅ Log if user
        if ($_SESSION['role'] === 'user') {
            logActivity($_SESSION['user_id'], 'Updated Job', 'job', $id);
        }

        header('Location: manage_jobs.php');
        exit();
    } else { // Insert new job
        mysqli_query($conn, "INSERT INTO jobs (title, description, location, salary, department_id) VALUES ('$title', '$description', '$location', '$salary', " . ($department_id ?: "NULL") . ")");
        $newJobId = mysqli_insert_id($conn);

        // ✅ Log if user
        if ($_SESSION['role'] === 'user') {
            logActivity($_SESSION['user_id'], 'Added Job', 'job', $newJobId);
        }

        header('Location: manage_jobs.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= isset($_GET['id']) ? 'Edit' : 'Add'; ?> Job - Recruitment Tracker</title>
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
      max-width: 700px;
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
    <h2 class="mb-4"><?= isset($_GET['id']) ? 'Edit' : 'Add'; ?> Job</h2>

    <form method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Job Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($title); ?>" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Job Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($description); ?></textarea>
      </div>
      <div class="mb-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($location); ?>" required>
      </div>

      <div class="mb-3">
        <label for="department_id" class="form-label">Department</label>
        <select name="department_id" id="department_id" class="form-select">
          <option value="">Select Department</option>
          <?php 
          // Reset pointer before loop (in case used before)
          mysqli_data_seek($departments_res, 0);
          while ($d = mysqli_fetch_assoc($departments_res)): ?>
            <option value="<?= $d['id'] ?>" <?= ($department_id == $d['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($d['name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="salary" class="form-label">Salary</label>
        <input type="number" class="form-control" id="salary" name="salary" value="<?= htmlspecialchars($salary); ?>" required>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary"><?= isset($_GET['id']) ? 'Update Job' : 'Add Job'; ?></button>
        <a href="manage_jobs.php" class="btn btn-secondary">Back</a>
      </div>
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
