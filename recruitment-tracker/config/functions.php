<?php
function logActivity($userId, $action) {
    global $conn; // Make $conn accessible inside this function
    
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, timestamp) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $userId, $action);
    $stmt->execute();
    $stmt->close();
}


?>
