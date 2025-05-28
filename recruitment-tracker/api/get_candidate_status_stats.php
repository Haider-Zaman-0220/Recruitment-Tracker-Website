<?php


// Return JSON response
header('Content-Type: application/json');

// Include database connection
require_once('../config/db.php');


$data = [];

// SQL to count candidates by status
$sql = "SELECT status, COUNT(*) as count FROM candidates GROUP BY status";

// Execute query
$result = mysqli_query($conn, $sql);

// Check for error
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Database query failed"]);
    exit;
}

// Build result array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        "status" => $row['status'],
        "count" => (int)$row['count']
    ];
}

// Return as JSON
echo json_encode($data);
?>
