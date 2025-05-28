<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');
require_once('../config/functions.php'); // <-- Needed for logActivity()

$departments_res = mysqli_query($conn, "SELECT * FROM departments ORDER BY name");
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die('Invalid candidate ID');
}

$result = mysqli_query($conn, "SELECT * FROM candidates WHERE id=$id");
$candidate = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Handle department_id (nullable)
    $department_id = isset($_POST['department_id']) && $_POST['department_id'] !== '' 
        ? intval($_POST['department_id']) 
        : "NULL";

    $update_query = "UPDATE candidates SET 
        name='$name', 
        email='$email', 
        phone='$phone', 
        position='$position', 
        status='$status', 
        department_id=$department_id 
        WHERE id=$id";

    if (mysqli_query($conn, $update_query)) {

        // Log user action only if role is 'user'
        if ($_SESSION['role'] === 'user') {
            logActivity($_SESSION['user_id'], 'Updated Candidate', 'candidate', $id);
        }

        header('Location: list_candidates.php');
        exit();
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Candidate - Recruitment Tracker</title>
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
    <h2 class="mb-4">Edit Candidate</h2>

    <form method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($candidate['name']); ?>" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($candidate['email']); ?>" required>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($candidate['phone']); ?>" required>
      </div>

      <div class="mb-3">
        <label for="position" class="form-label">Position Applied For</label>
        <input type="text" class="form-control" id="position" name="position" value="<?= htmlspecialchars($candidate['position']); ?>" required>
      </div>

      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" class="form-select" name="status" required>
          <option value="Applied" <?= $candidate['status'] == 'Applied' ? 'selected' : ''; ?>>Applied</option>
          <option value="Interviewed" <?= $candidate['status'] == 'Interviewed' ? 'selected' : ''; ?>>Interviewed</option>
          <option value="Hired" <?= $candidate['status'] == 'Hired' ? 'selected' : ''; ?>>Hired</option>
          <option value="Rejected" <?= $candidate['status'] == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="department_id" class="form-label">Department</label>
        <select name="department_id" id="department_id" class="form-select">
          <option value="">Select Department</option>
          <?php 
            // Reset pointer to start of results to loop again
            mysqli_data_seek($departments_res, 0);
            while ($d = mysqli_fetch_assoc($departments_res)): 
          ?>
            <option value="<?= $d['id'] ?>" <?= (isset($candidate) && $candidate['department_id'] == $d['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($d['name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Update Candidate</button>
        <a href="list_candidates.php" class="btn btn-secondary">Back</a>
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
