<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../auth/auth_check.php');
$role = $_SESSION['role'] ?? 'user';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
  .sidebar {
    width: 260px;
    background-color: #ffffff;
    height: 100vh;
    position: fixed;
    padding-top: 70px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    transform: translateX(0);
    z-index: 1000;
  }

  .sidebar a {
    color: #333;
    text-decoration: none;
    display: block;
    padding: 15px 30px;
    transition: 0.2s;
  }

  .sidebar a:hover,
  .sidebar .active {
    background-color: #e7f1ff;
    color: #000;
    font-weight: 500;
  }

  .sidebar.sidebar-hidden {
    transform: translateX(-100%);
  }

  .content.full-width {
    margin-left: 0 !important;
  }
</style>

<!-- Sidebar -->
<div class="sidebar">
  <h4 class="text-center text-black fw-bold">Recruitment Tracker</h4>

  <a href="/recruitment-tracker/dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">
    <i class="bi bi-house-door me-2"></i>Dashboard
  </a>

  <a href="/recruitment-tracker/candidate/list_candidates.php" class="<?= strpos($_SERVER['PHP_SELF'], 'candidate') !== false ? 'active' : '' ?>">
    <i class="bi bi-person-lines-fill me-2"></i>Candidates
  </a>

  <a href="/recruitment-tracker/jobs/manage_jobs.php" class="<?= strpos($_SERVER['PHP_SELF'], 'jobs') !== false ? 'active' : '' ?>">
    <i class="bi bi-briefcase me-2"></i>Jobs
  </a>

  <?php if ($role === 'admin'): ?>
    <a href="/recruitment-tracker/admin/manage_users.php" class="<?= strpos($_SERVER['PHP_SELF'], 'users') !== false ? 'active' : '' ?>">
      <i class="bi bi-people me-2"></i>Users
    </a>

    <a href="/recruitment-tracker/departments/view_departments.php" class="<?= strpos($_SERVER['PHP_SELF'], 'departments') !== false ? 'active' : '' ?>">
      <i class="bi bi-building me-2"></i>Departments
    </a>

    <a href="/recruitment-tracker/admin/activity_logs.php" class="<?= strpos($_SERVER['PHP_SELF'], 'activity_logs') !== false ? 'active' : '' ?>">
      <i class="bi bi-clock-history me-2"></i>Activity Logs
    </a>
  <?php endif; ?>

  <a href="/recruitment-tracker/auth/logout.php" class="<?= $currentPage === 'logout.php' ? 'active' : '' ?>">
    <i class="bi bi-box-arrow-right me-2"></i>Logout
  </a>
</div>
