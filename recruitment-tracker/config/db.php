<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if different
$password = "";     // Change if your MySQL has a password
$database = "recruitment_tracker";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
