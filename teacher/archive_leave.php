<?php
session_start();
include '../includes/db_connection.php';

if ($_SESSION['role'] != 'Teacher') {
    echo "Unauthorized access.";
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Use prepared statements to prevent SQL injection
$query = "UPDATE leave_requests SET status = 'Approved' WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $id, $user_id);

if ($stmt->execute()) {
    $_SESSION['toast_success'] = "Leave request archived successfully.";
    header('Location: leave_status.php');
    exit();
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
