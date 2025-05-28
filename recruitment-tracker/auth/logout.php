<?php
session_start();
require_once('../config/db.php');
require_once('../config/functions.php');

if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    logActivity($_SESSION['user_id'], 'Logged Out');
}

session_destroy();
header('Location: ../index.php');
exit();
?>
