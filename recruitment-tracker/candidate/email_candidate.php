<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');
require_once('../config/functions.php'); // <-- for logActivity()

if (!isset($_GET['id'])) {
    die("Candidate ID is missing.");
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM candidates WHERE id = $id");

if (mysqli_num_rows($result) === 0) {
    die("Candidate not found.");
}

$candidate = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $to = $candidate['email'];
    $headers = "From: your_email@example.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {

        // ✅ Log activity only if role is user
        if ($_SESSION['role'] === 'user') {
            logActivity($_SESSION['user_id'], 'Emailed Candidate', 'candidate', $id);
        }

        echo "<script>alert('Email sent successfully'); window.location.href='list_candidates.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to send email');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Email Candidate - Recruitment Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  
  <style>
    .content {
      margin-left: 260px;
      padding: 6rem 2rem 2rem 2rem;
      background-color: #f9f9f9;
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
    <div class="card card-light p-4">
      <h4 class="mb-4">Email Candidate: <?= htmlspecialchars($candidate['name']) ?></h4>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">To</label>
          <input type="email" class="form-control" value="<?= htmlspecialchars($candidate['email']) ?>" readonly />
        </div>
        <div class="mb-3">
          <label class="form-label">Subject</label>
          <input type="text" name="subject" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Message</label>
          <textarea name="message" class="form-control" rows="6" required></textarea>
        </div>
        <div class="d-flex justify-content-between">
          <a href="list_candidates.php" class="btn btn-secondary">Back</a>
          <button type="submit" class="btn btn-primary">Send Email</button>
        </div>
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