<?php
session_start();
include '../includes/db_connection.php';

if ($_SESSION['role'] != 'Admin') {
    echo "Unauthorized access.";
    exit;
}

$user_id = $_POST['user_id'];
$action = $_POST['action'];

if ($action == 'approve') {
    // Approve teacher (Update status in pending_teachers table)
    $approve_query = "UPDATE pending_teachers SET status='Approved' WHERE user_id='$user_id'";
    mysqli_query($conn, $approve_query);

    // Move the record to the users table with the original password
    $move_query = "INSERT INTO users (user_id, firstname, middlename, lastname, emailaddress, contactnumber, district_section, role, password)
                   SELECT user_id, firstname, middlename, lastname, emailaddress, contactnumber, district_section, 'Teacher', password
                   FROM pending_teachers WHERE user_id='$user_id'";
    mysqli_query($conn, $move_query);

    // Optionally delete from pending_teachers table after moving
    $delete_query = "DELETE FROM pending_teachers WHERE user_id='$user_id'";
    mysqli_query($conn, $delete_query);

} elseif ($action == 'reject') {
    // Reject teacher
    $reject_query = "UPDATE pending_teachers SET status='Rejected' WHERE user_id='$user_id'";
    mysqli_query($conn, $reject_query);
}

header('Location: pending_teachers.php');
exit;
?>
