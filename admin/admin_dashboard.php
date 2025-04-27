<?php
session_start();
include '../includes/db_connection.php';

$current_page = basename($_SERVER['PHP_SELF']);

// Fetch the logged-in user's details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT firstname, lastname FROM users WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

if ($_SESSION['role'] != 'Admin') {
    echo "Unauthorized access.";
    exit;
}

// Fetch counts for different statistics
$pending_teachers_query = "SELECT COUNT(*) AS total_pending_teachers FROM pending_teachers WHERE status='Pending'";
$total_teachers_query = "SELECT COUNT(*) AS total_teachers FROM users WHERE role='Teacher'";
$total_admins_query = "SELECT COUNT(*) AS total_admins FROM users WHERE role IN ('Admin', 'Personnel', 'Personnel Head', 'ASDS')";
$pending_leave_requests_query = "SELECT COUNT(*) AS total_pending_leave_requests FROM leave_requests WHERE status IN ('Pending', 'Approved by Personnel', 'Approved by Personnel Head')";

$pending_teachers_result = mysqli_query($conn, $pending_teachers_query);
$total_teachers_result = mysqli_query($conn, $total_teachers_query);
$total_admins_result = mysqli_query($conn, $total_admins_query);
$pending_leave_requests_result = mysqli_query($conn, $pending_leave_requests_query);

$pending_teachers_count = mysqli_fetch_assoc($pending_teachers_result)['total_pending_teachers'];
$total_teachers_count = mysqli_fetch_assoc($total_teachers_result)['total_teachers'];
$total_admins_count = mysqli_fetch_assoc($total_admins_result)['total_admins'];
$pending_leave_requests_count = mysqli_fetch_assoc($pending_leave_requests_result)['total_pending_leave_requests'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/p_sidebar.css">
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <?php include '../includes/admin_sidebar.php'; ?>

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div class="content" id="page-content-wrapper">
            <?php include '../includes/admin_navbar.php'; ?>

            <div class="container-fluid mt-4">
                <h2 class="Form-Head">Dashboard</h2>
                <div class="dashboard">
                    <div class="card pending-teachers">
                        <h3>Total Pending Teacher Signups</h3>
                        <div class="count"><?= htmlspecialchars($pending_teachers_count) ?></div>
                    </div>
                    <div class="card total-teachers">
                        <h3>Total Teachers</h3>
                        <div class="count"><?= htmlspecialchars($total_teachers_count) ?></div>
                    </div>
                    <div class="card total-admins">
                        <h3>Total Admins</h3>
                        <div class="count"><?= htmlspecialchars($total_admins_count) ?></div>
                    </div>
                    <div class="card pending-leave-requests">
                        <h3>Total Pending Leave Requests</h3>
                        <div class="count"><?= htmlspecialchars($pending_leave_requests_count) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var wrapper = document.getElementById('wrapper');
        var menuToggle = document.getElementById('menu-toggle');
        var toggleIcon = document.getElementById('toggle-icon');

        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            wrapper.classList.toggle('toggled');
            
            if (wrapper.classList.contains('toggled')) {
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            } else {
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-times');
            }
        });
    });
    </script>

</body>
</html>
