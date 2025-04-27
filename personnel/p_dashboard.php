<?php
session_start();
include '../includes/db_connection.php';

$current_page = basename($_SERVER['PHP_SELF']);

// Fetch the logged-in user’s details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT firstname, lastname FROM users WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

if ($_SESSION['role'] != 'Personnel') {
    echo "Unauthorized access.";
    exit;
}

// Fetch the counts for different leave request statuses
$pending_query = "SELECT COUNT(*) AS total_pending FROM leave_requests WHERE status='Pending'";
$approved_query = "SELECT COUNT(*) AS total_approved FROM leave_requests WHERE approved_personnel='Yes'";
$rejected_query = "SELECT COUNT(*) AS total_rejected FROM leave_requests WHERE status='Rejected by Personnel'";

$pending_result = mysqli_query($conn, $pending_query);
$approved_result = mysqli_query($conn, $approved_query);
$rejected_result = mysqli_query($conn, $rejected_query);

$pending_count = mysqli_fetch_assoc($pending_result)['total_pending'];
$approved_count = mysqli_fetch_assoc($approved_result)['total_approved'];
$rejected_count = mysqli_fetch_assoc($rejected_result)['total_rejected'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Personnel Dashboard</title>
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
        <?php include '../includes/p_sidebar.php'; ?>

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div class="content" id="page-content-wrapper">
            <?php include '../includes/p_navbar.php'; ?>

            <div class="container-fluid mt-4">
                <h2 class="Form-Head">Dashboard</h2>
                <div class="dashboard">
                    <div class="card pending">
                        <h3>Total Pending Requests</h3>
                        <div class="count"><?= htmlspecialchars($pending_count) ?></div>
                    </div>
                    <div class="card approved">
                        <h3>Total Approved Requests</h3>
                        <div class="count"><?= htmlspecialchars($approved_count) ?></div>
                    </div>
                    <div class="card rejected">
                        <h3>Total Rejected Requests</h3>
                        <div class="count"><?= htmlspecialchars($rejected_count) ?></div>
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
