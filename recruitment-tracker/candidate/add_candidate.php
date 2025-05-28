<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');
require_once('../config/functions.php'); // <- make sure this file contains logActivity()

$departments_res = mysqli_query($conn, "SELECT * FROM departments ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $department_id = isset($_POST['department_id']) && $_POST['department_id'] !== '' ? intval($_POST['department_id']) : 'NULL';

    // Insert candidate with department_id
    $query = "INSERT INTO candidates (name, email, phone, position, status, department_id) VALUES ('$name', '$email', '$phone', '$position', '$status', $department_id)";
    if (mysqli_query($conn, $query)) {
        $newCandidateId = mysqli_insert_id($conn);

        // ✅ Log activity only if user (not admin)
        if ($_SESSION['role'] === 'user') {
            logActivity($_SESSION['user_id'], 'Added Candidate', 'candidate', $newCandidateId);
        }
    }

    header('Location: list_candidates.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add Candidate - Recruitment Tracker</title>
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
      color: #212529;
    }
    .form-label {
      font-weight: 600;
    }
  </style>
</head>
<body>

  <?php include('../partials/navbar.php'); ?>
  <?php include('../partials/sidebar.php'); ?>

  <div class="content" id="content">
    <div class="card-light">
      <h2 class="mb-4">Add New Candidate</h2>

      <form method="POST" id="candidateForm" novalidate>
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" name="name" required />
          <div class="invalid-feedback">Full Name is required.</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required />
          <div class="invalid-feedback">Valid Email is required.</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="text" class="form-control" name="phone" required />
          <div class="invalid-feedback">Phone is required.</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Position Applied For</label>
          <input type="text" class="form-control" name="position" required />
          <div class="invalid-feedback">Position is required.</div>
        </div>

        <div class="mb-3">
          <label for="department_id" class="form-label">Department</label>
          <select name="department_id" id="department_id" class="form-select">
            <option value="">Select Department</option>
            <?php while ($d = mysqli_fetch_assoc($departments_res)): ?>
              <option value="<?= $d['id'] ?>" <?= (isset($candidate) && $candidate['department_id'] == $d['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($d['name']) ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select class="form-select" name="status" required>
            <option value="">Select Status</option>
            <option value="Applied">Applied</option>
            <option value="Interviewed">Interviewed</option>
            <option value="Hired">Hired</option>
            <option value="Rejected">Rejected</option>
          </select>
          <div class="invalid-feedback">Status is required.</div>
        </div>

        <button type="submit" class="btn btn-success me-2">Add Candidate</button>
        <a href="list_candidates.php" class="btn btn-secondary">Back</a>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/form_validation.js"></script>

  <script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
      document.querySelector('.sidebar').classList.toggle('sidebar-hidden');
      document.getElementById('content').classList.toggle('full-width');
    });
  </script>

</body>
</html>
