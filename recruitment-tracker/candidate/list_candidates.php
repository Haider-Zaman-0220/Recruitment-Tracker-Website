<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');
require_once('../config/functions.php'); // Required for logActivity()

// Fetch candidates with department name (LEFT JOIN in case department_id is NULL)
$candidates = mysqli_query($conn, "
    SELECT candidates.*, departments.name AS department_name
    FROM candidates
    LEFT JOIN departments ON candidates.department_id = departments.id
");

$role = $_SESSION['role'] ?? 'user';
$username = $_SESSION['username'] ?? 'User';

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Log only if role is 'user'
    if ($role === 'user') {
        logActivity($_SESSION['user_id'], 'Deleted Candidate', 'candidate', $id);
    }

    mysqli_query($conn, "DELETE FROM candidates WHERE id = $id");
    header('Location: list_candidates.php');
    exit;
}

// Handle email submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_email'])) {
    $to = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $headers = "From: hr@khanorg.com\r\nContent-Type: text/plain; charset=UTF-8";

    mail($to, $subject, $message, $headers);

    // Log if role is user
    if ($role === 'user') {
        $res = mysqli_query($conn, "SELECT id FROM candidates WHERE email = '" . mysqli_real_escape_string($conn, $to) . "' LIMIT 1");
        $row = mysqli_fetch_assoc($res);
        if ($row) {
            logActivity($_SESSION['user_id'], 'Emailed Candidate', 'candidate', $row['id']);
        }
    }

    echo "<script>alert('Email sent successfully to $to');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Candidates - Recruitment Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    /* Your styles here */
    .content {
      margin-left: 260px;
      padding: 6rem 2rem 2rem 2rem;
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
      color: #212529;
    }
  </style>
</head>
<body>

<?php include('../partials/navbar.php'); ?>
<?php include('../partials/sidebar.php'); ?>

<div class="content" id="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manage Candidates</h2>
    <a href="add_candidate.php" class="btn btn-success">Add New Candidate</a>
  </div>

  <div class="card card-light p-4">
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Position</th>
          <th>Department</th>  <!-- Added -->
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($candidate = mysqli_fetch_assoc($candidates)): ?>
        <tr>
          <td><?= htmlspecialchars($candidate['name']); ?></td>
          <td><?= htmlspecialchars($candidate['email']); ?></td>
          <td><?= htmlspecialchars($candidate['phone']); ?></td>
          <td><?= htmlspecialchars($candidate['position']); ?></td>
          <td><?= htmlspecialchars($candidate['department_name'] ?? '—'); ?></td>  <!-- Added -->
          <td><?= htmlspecialchars($candidate['status']); ?></td>
          <td class="d-flex gap-2 flex-wrap">
            <a href="edit_candidate.php?id=<?= $candidate['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="list_candidates.php?delete=<?= $candidate['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
            <?php if ($role === 'user'): ?>
              <a href="email_candidate.php?id=<?= $candidate['id']; ?>" class="btn btn-primary btn-sm">Email</a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Email Modal (unchanged) -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('toggleSidebar').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('sidebar-hidden');
    document.getElementById('content').classList.toggle('full-width');
  });

  function fillEmail(email) {
    document.getElementById('emailInput').value = email;
  }
</script>

</body>
</html>
