<?php
session_start();
include 'config.php';

$userId = $_SESSION['userid'];  // Ensure the user is logged in and user ID is available

// Fetch only unread notifications
$query = "SELECT id, message FROM client_notifications WHERE user_id = ? AND is_read = 0 ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

$stmt->close();
$conn->close();

// Send notifications as JSON response
echo json_encode($notifications);
?>
