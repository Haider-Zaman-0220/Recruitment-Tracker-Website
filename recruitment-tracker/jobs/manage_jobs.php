<?php 
require_once('../auth/auth_check.php');
require_once('../config/db.php');
require_once('../config/functions.php'); // For logActivity()

// Fetch all jobs with department names using LEFT JOIN (in case department_id is NULL)
$jobs = mysqli_query($conn, "
    SELECT jobs.*, departments.name AS department_name 
    FROM jobs 
    LEFT JOIN departments ON jobs.department_id = departments.id
    ORDER BY jobs.id DESC
");

// Handle Delete Job
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // ✅ Log only if user
    if ($_SESSION['role'] === 'user') {
        logActivity($_SESSION['user_id'], 'Deleted Job', 'job', $id);
    }

    mysqli_query($conn, "DELETE FROM jobs WHERE id = $id");
    header('Location: manage_jobs.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Jobs - Recruitment Tracker</title>
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
  <div class="card-light">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Manage Jobs</h2>
      <a href="edit_job.php" class="btn btn-success btn-narrow">Add New Job</a>
    </div>

    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Location</th>
          <th>Department</th> <!-- Added Department header -->
          <th>Salary</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($job = mysqli_fetch_assoc($jobs)): ?>
        <tr>
          <td><?= htmlspecialchars($job['title']); ?></td>
          <td><?= htmlspecialchars($job['description']); ?></td>
          <td><?= htmlspecialchars($job['location']); ?></td>
          <td><?= htmlspecialchars($job['department_name'] ?? 'N/A'); ?></td> <!-- Show department name or N/A -->
          <td><?= htmlspecialchars($job['salary']); ?></td>
          <td>
            <div class="d-flex flex-wrap gap-2">
              <a href="edit_job.php?id=<?= $job['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="manage_jobs.php?delete=<?= $job['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
            </div>
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
