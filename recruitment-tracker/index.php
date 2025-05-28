<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recruitment Tracker - Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Full page setup */
    body, html {
      height: 100%;
      font-family: 'Arial', sans-serif;
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }

    /* Centered content */
    .text-center {
      text-align: center;
    }

    /* Wider card-style container */
    .card-container {
      width: 100%;
      max-width: 500px; /* Increased width */
      background-color: #ffffff;
      padding: 30px 40px; /* Adjusted padding for more spacious design */
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
    }

    /* Card Title */
    h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #007bff;
      margin-bottom: 1.5rem;
    }

    /* Button styling */
    .btn {
      background-color: #007bff;
      color: white;
      border-radius: 30px;
      padding: 12px 25px;
      font-size: 1.2rem;
      width: 100%;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #0056b3;
    }

    /* Simple fade-in animation */
    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    /* Footer */
    footer {
      position: fixed;
      bottom: 10px;
      width: 100%;
      text-align: center;
      font-size: 0.9rem;
      color: #888;
    }

    footer a {
      color: #007bff;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="card-container">
  <h1>Welcome to Recruitment Tracker</h1>
  <p>Manage your recruitment process with ease and efficiency.</p>
  <a href="auth/login.php" class="btn">Login</a>
</div>

<!-- Footer -->
<footer>
  <p>&copy; 2025 Recruitment Tracker. <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
