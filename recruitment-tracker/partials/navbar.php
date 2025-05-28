<?php
if (!isset($_SESSION)) {
    session_start();
}
$username = $_SESSION['username'] ?? 'User';
$role = $_SESSION['role'] ?? 'user';
$initials = strtoupper(substr($username, 0, 2));
?>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3 fixed-top shadow-sm">
  <button id="toggleSidebar" type="button" class="btn btn-link text-white fs-4 me-2 d-inline p-0" style="line-height:1;">
    <i class="bi bi-list"></i>
  </button>
  <a class="navbar-brand fw-bold text-white d-flex align-items-center" href="/recruitment-tracker/dashboard.php">
    DigiOrg
  </a>

  <form class="d-flex ms-3 w-50" method="GET" action="#">
    <input class="form-control me-2" type="search" placeholder="Search by Name, Job, Email or Department" aria-label="Search" />
    <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
  </form>

  <div class="ms-auto d-flex align-items-center gap-3">

    <!-- Plus Icon Dropdown -->
    <div class="dropdown">
      <button
        class="btn text-white p-0 border-0 bg-transparent"
        type="button"
        id="plusDropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        style="font-size: 1.25rem;"
      >
        <i class="bi bi-plus-circle-fill"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="plusDropdown">
        <li>
          <a class="dropdown-item d-flex align-items-center gap-2" href="/recruitment-tracker/candidate/add_candidate.php">
            <i class="bi bi-person-plus-fill"></i> Create Candidate
          </a>
        </li>

        <?php if ($role === 'admin'): ?>
        <li>
          <a class="dropdown-item d-flex align-items-center gap-2" href="/recruitment-tracker/departments/create_department.php">
            <i class="bi bi-bank2"></i> Create Department
          </a>
        </li>
        <?php endif; ?>

        <li>
          <a class="dropdown-item d-flex align-items-center gap-2" href="/recruitment-tracker/jobs/edit_job.php">
            <i class="bi bi-briefcase-fill"></i> Create Job
          </a>
        </li>

        <?php if ($role === 'admin'): ?>
        <li>
          <a class="dropdown-item d-flex align-items-center gap-2" href="/recruitment-tracker/admin/edit_user.php">
            <i class="bi bi-people-fill"></i> Create User
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </div>

    <i class="bi bi-gift-fill text-white fs-5"></i>
    <i class="bi bi-bell-fill text-white fs-5"></i>

    <!-- User Dropdown -->
    <div class="dropdown">
      <button
        class="btn btn-warning text-white dropdown-toggle"
        type="button"
        id="userDropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        style="border-radius: 15px; padding: 6px 14px; font-weight: 600; font-size: 1rem;"
      >
        <?= $initials; ?>
      </button>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="/recruitment-tracker/auth/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
