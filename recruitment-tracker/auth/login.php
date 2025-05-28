<?php
session_start();
require_once('../config/db.php');
require_once('../config/functions.php'); // Include logActivity
$error = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // ✅ Log login only if the user is a non-admin
                if ($_SESSION['role'] === 'user') {
                    logActivity($_SESSION['user_id'], 'Logged In');
                }

                header('Location: ../dashboard.php');
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Database query failed.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Recruitment Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <style>
    /* Full height for body and centering */
    body, html {
      height: 100%;
      font-family: 'Arial', sans-serif;
      background-color: #f0f2f5;
    }

    .d-flex {
      min-height: 100vh;
      align-items: center;
      justify-content: center;
    }

    /* Card Styling */
    .card {
      width: 100%;
      max-width: 400px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      background-color: #ffffff;
    }

    .card h2 {
      font-size: 1.75rem;
      font-weight: 600;
      color: #333;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    /* Input Field Styling */
    .form-control {
      border-radius: 8px;
      border: 1px solid #ced4da;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 8px;
      padding: 12px 0;
      font-size: 1.1rem;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    /* Error message styling */
    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
      border-radius: 8px;
      margin-bottom: 1rem;
      font-weight: 500;
    }

    /* Add some padding to the form */
    .form-group {
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body class="bg-light d-flex">

<div class="card shadow-lg">
    <h2>Login</h2>

    <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form id="loginForm" method="POST" novalidate>
      <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
        <div class="invalid-feedback">Please enter your username.</div>
      </div>
      <div class="mb-3">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="invalid-feedback">Please enter your password.</div>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/form_validation.js"></script> <!-- Corrected path -->
</body>
</html>
