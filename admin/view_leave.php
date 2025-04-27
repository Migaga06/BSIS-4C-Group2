<?php
session_start();
include '../includes/db_connection.php';

// Check if the user is an Admin
if ($_SESSION['role'] != 'Admin') {
    echo "Unauthorized access.";
    exit;
}

// Fetch the admin's name
$user_id = $_SESSION['user_id'];
$user_query = "SELECT firstname, lastname FROM users WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch the leave request details
$id = $_GET['id'];
$query = "SELECT *, DATE_FORMAT(date_submitted, '%Y-%m-%d') as formatted_date_submitted FROM leave_requests WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Prepare values for display
$formatted_date_submitted = htmlspecialchars($row['formatted_date_submitted']);
$leave_type = htmlspecialchars($row['leave_type']);
$leave_details = htmlspecialchars($row['leave_details']);
$start_date = htmlspecialchars($row['start_date']);
$end_date = htmlspecialchars($row['end_date']);
$commutation = htmlspecialchars($row['commutation']);
$status = htmlspecialchars($row['status']);
$rejection_remarks = htmlspecialchars($row['rejection_remarks']);
$specify_abroad = !empty($row['specify_abroad']) ? htmlspecialchars($row['specify_abroad']) : '';
$specify_illness_hospital = !empty($row['specify_illness_hospital']) ? htmlspecialchars($row['specify_illness_hospital']) : '';
$specify_illness_outpatient = !empty($row['specify_illness_outpatient']) ? htmlspecialchars($row['specify_illness_outpatient']) : '';
$specify_special_leave_women = !empty($row['specify_special_leave_women']) ? htmlspecialchars($row['specify_special_leave_women']) : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Leave Request</title>
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

            <div class="container mt-4 view-leave-container">
                <h2 id="leave-heading">View Leave Request</h2>
                <div id="print-section">
                    <p><strong>Date Submitted:</strong> <?= $formatted_date_submitted ?></p>
                    <p><strong>Leave Type:</strong> <?= $leave_type ?></p>
                    <p><strong>Details of Leave:</strong> <?= $leave_details ?></p>
                    <?php if (!empty($specify_abroad)): ?>
                        <p><strong>Specify Abroad:</strong> <?= $specify_abroad ?></p>
                    <?php endif; ?>
                    <?php if (!empty($specify_illness_hospital)): ?>
                        <p><strong>Specify Illness (In Hospital):</strong> <?= $specify_illness_hospital ?></p>
                    <?php endif; ?>
                    <?php if (!empty($specify_illness_outpatient)): ?>
                        <p><strong>Specify Illness (Out Patient):</strong> <?= $specify_illness_outpatient ?></p>
                    <?php endif; ?>
                    <?php if (!empty($specify_special_leave_women)): ?>
                        <p><strong>Specify Illness (Special Leave Benefits for Women):</strong> <?= $specify_special_leave_women ?></p>
                    <?php endif; ?>
                    <p><strong>Start Date:</strong> <?= $start_date ?></p>
                    <p><strong>End Date:</strong> <?= $end_date ?></p>
                    <p><strong>Commutation:</strong> <?= $commutation ?></p>
                    <p><strong>Status:</strong> <?= $status ?></p>
                    <?php if (!empty($rejection_remarks)): ?>
                        <p><strong>Rejection Remarks:</strong> <?= $rejection_remarks ?></p>
                    <?php endif; ?>
                </div>
                <button class="btn btn-primary" onclick="history.back()">Back</button>
            </div>

        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script src="../assets/javascript/sidebar_toggle.js"></script>
</body>
</html>
