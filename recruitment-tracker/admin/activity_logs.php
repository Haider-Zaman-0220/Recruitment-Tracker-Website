<?php
require_once('../auth/auth_check.php');
require_once('../config/db.php');
require_once('../config/db.php'); 
require_once('../config/functions.php');

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit();
}

$logs = mysqli_query($conn, "SELECT a.*, u.username FROM activity_logs a JOIN users u ON a.user_id = u.id ORDER BY timestamp DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Activity Logs - Recruitment Tracker</title>
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

        .footer {
            text-align: center;
            padding: 10px 0;
            color: #666;
            font-size: 0.9rem;
        }

        .table thead th {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<?php include('../partials/navbar.php'); ?>
<?php include('../partials/sidebar.php'); ?>

<div class="content" id="content">
    <div class="card-light">
        <h2 class="mb-4">User Activity Logs</h2>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($log = mysqli_fetch_assoc($logs)): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['username']); ?></td>
                        <td><?= htmlspecialchars($log['action']); ?></td>
                        <td><?= $log['timestamp']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar toggle logic
    document.getElementById('toggleSidebar')?.addEventListener('click', function () {
        document.querySelector('.sidebar').classList.toggle('sidebar-hidden');
        document.getElementById('content').classList.toggle('full-width');
    });
</script>

</body>
</html>
