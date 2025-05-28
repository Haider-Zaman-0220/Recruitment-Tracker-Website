<?php
require_once('auth/auth_check.php');
require_once('config/db.php');

// Get total candidates count
$candidateQuery = "SELECT COUNT(*) AS total FROM candidates";
$candidateResult = mysqli_query($conn, $candidateQuery);
$candidateCount = $candidateResult ? mysqli_fetch_assoc($candidateResult)['total'] : 0;

// Get total jobs count
$jobQuery = "SELECT COUNT(*) AS total FROM jobs";
$jobResult = mysqli_query($conn, $jobQuery);
$jobCount = $jobResult ? mysqli_fetch_assoc($jobResult)['total'] : 0;

$role = $_SESSION['role'] ?? 'user';
$username = $_SESSION['username'] ?? 'User';

if ($role === 'admin') {
    $userQuery = "SELECT COUNT(*) AS total FROM users";
    $userResult = mysqli_query($conn, $userQuery);
    $userCount = $userResult ? mysqli_fetch_assoc($userResult)['total'] : 0;

    // Department count query
    $departmentQuery = "SELECT COUNT(*) AS total FROM departments";
    $departmentResult = mysqli_query($conn, $departmentQuery);
    $DepartmentCount = $departmentResult ? mysqli_fetch_assoc($departmentResult)['total'] : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f9f9;
      color: #212529;
    }

    .navbar {
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .content {
      margin-left: 260px;
      padding: 6rem 2rem 2rem 2rem; /* Top padding adjusted for fixed navbar */
      background-color: #f9f9f9;
      min-height: 100vh;
    }

    .card-light {
      background-color: #ffffff;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      color: #212529;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      transition: transform 0.2s ease-in-out;
    }

    .card-light:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-light-custom {
      background-color: #000;
      border: none;
      border-radius: 20px;
      color: #fff;
      padding: 10px 20px;
      text-decoration: none;
      display: inline-block;
      text-align: center;
    }

    .btn-outline-primary {
      border-radius: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .full-width {
      margin-left: 0 !important;
    }

    
  #statusChart {
    display: block;          /* treat as block-level */
    margin: 0 auto;          /* center horizontally */
    max-width: 300px;
    max-height: 300px;
  }
  /* Optionally, center the heading inside the card, too */
  .status-card {
    text-align: center;
    padding: 1.5rem;
  }


  </style>
</head>
<body>

  <?php include('partials/navbar.php'); ?>
  <?php include('partials/sidebar.php'); ?>

  <!-- Main Content -->
  <div class="content">
    <div class="header">
      <div>
        <h2>Dashboard</h2>
        <p class="text-muted">Welcome back, <?= htmlspecialchars(ucfirst($role)); ?>!</p>
      </div>
    </div>

    <!-- Welcome Section -->
    <div class="text-center my-5">
      <h2>Hello <?= htmlspecialchars($username); ?>,</h2>
      <p class="lead">Here are three steps to get you started.</p>
      <div class="d-flex justify-content-center gap-4 mt-4 flex-wrap">
        <div class="card card-light p-4 text-center" style="width: 250px;">
          <h6>Create a Candidate</h6>
          <p class="text-muted small">Let's start by creating your first candidate.</p>
          <a href="candidate/add_candidate.php" class="btn btn-outline-primary">+ Create Candidate</a>
        </div>

        <?php if ($role === 'admin'): ?>
        <div class="card card-light p-4 text-center" style="width: 250px;">
          <h6>Create a Department</h6>
          <p class="text-muted small">Departments host the different jobs under your company.</p>
          <a href="departments/create_department.php" class="btn btn-outline-primary">+ Create Department</a>
        </div>
        <?php endif; ?>

        <div class="card card-light p-4 text-center" style="width: 250px;">
          <h6>Create a Job</h6>
          <p class="text-muted small">A new position opened up? Add it to the job list.</p>
          <a href="jobs/edit_job.php" class="btn btn-outline-primary">+ Create Job</a>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="d-flex justify-content-center gap-4 flex-wrap my-5">
      <div class="card card-light p-4 text-center" style="width: 250px;">
        <h5>Total Candidates</h5>
        <h2 style="color: black;"><?= $candidateCount; ?></h2>
        <a href="candidate/view_candidates.php" class="btn btn-light-custom mt-3">View Candidates</a>
      </div>

      <div class="card card-light p-4 text-center" style="width: 250px;">
        <h5>Total Jobs</h5>
        <h2 style="color: black;"><?= $jobCount; ?></h2>
        <a href="jobs/view_jobs.php" class="btn btn-light-custom mt-3">View Jobs</a>
      </div>

      <?php if ($role === 'admin'): ?>
      <div class="card card-light p-4 text-center" style="width: 250px;">
        <h5>Total Users</h5>
        <h2 style="color: black;"><?= $userCount; ?></h2>
        <a href="admin/view_users.php" class="btn btn-light-custom mt-3">View Users</a>
      </div>

      <div class="card card-light p-4 text-center" style="width: 250px;">
        <h5>Total Departments</h5>
        <h2 style="color: black;"><?= htmlspecialchars($DepartmentCount); ?></h2>
        <a href="departments/list_departments.php" class="btn btn-light-custom mt-3">View Departments</a>
      </div>
      <?php endif; ?>
    </div>

    <!-- Recent Items -->
    <div class="row mt-4">
      <div class="col-lg-6">
        <div class="card card-light p-4">
          <h5>Recent Candidates</h5>
          <ul>
            <li>Abid Ali - UI/UX Designer</li>
            <li>Ammid Ali Khan - Computer Operator</li>
          </ul>
          <a href="candidate/list_candidates.php" class="btn btn-outline-primary mt-3">Manage Candidates</a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card card-light p-4">
          <h5>Recent Jobs</h5>
          <ul>
            <li>Android App Developer - Rawalpindi</li>
            <li>ML Engineer - Peshawar</li>
          </ul>
          <a href="jobs/manage_jobs.php" class="btn btn-outline-primary mt-3">Manage Jobs</a>
        </div>
      </div>

      <?php if ($role === 'admin'): ?>
      <div class="col-lg-6">
        <div class="card card-light p-4">
          <h5>Recent Users</h5>
          <ul>
            <li>Haider Zaman - User</li>
            <li>Abdullah Azib - User</li>
          </ul>
          <a href="admin/manage_users.php" class="btn btn-outline-primary mt-3">Manage Users</a>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
      document.querySelector('.sidebar').classList.toggle('sidebar-hidden');
      document.querySelector('.content').classList.toggle('full-width');
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

  
      <script>
  const statusColors = {
    "Applied": "blue",
    "Interviewed": "yellow",
    "Hired": "green",
    "Rejected": "red"
  };

  fetch('api/get_candidate_status_stats.php')
    .then(res => res.json())
    .then(data => {
      const labels = data.map(d => d.status);
      const values = data.map(d => d.count);
      const total = values.reduce((sum, val) => sum + val, 0);
      const backgroundColors = labels.map(label => statusColors[label] || 'gray');

      new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
          labels,
          datasets: [{
            data: values,
            backgroundColor: backgroundColors
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            datalabels: {
              color: '#fff',
              font: {
                weight: 'bold',
                size: 14
              },
              formatter: (value, context) => {
                const percentage = ((value / total) * 100).toFixed(1);
                return `${percentage}%`;
              }
            },
            legend: {
              position: 'bottom',
              labels: {
                boxWidth: 20
              }
            }
          }
        },
        plugins: [ChartDataLabels]
      });
    });
</script>

  <div class="card card-light p-4 text-center mt-4" style="max-width: 500px; margin: auto;">
  <h4 class="mb-4">Candidate Status Overview</h4>
  <div style="position: relative; width: 100%; height: 300px;">
    <canvas id="statusChart"></canvas>
  </div>
</div>

</body>
</html>
