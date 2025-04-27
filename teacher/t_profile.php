<?php
session_start();
include '../includes/db_connection.php';

if ($_SESSION['role'] != 'Teacher') {
    echo "Unauthorized access.";
    exit;
}


$user_id = $_SESSION['user_id'];
$query = "SELECT user_id, firstname, middlename, lastname, district_section, emailaddress, contactnumber FROM users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/t_sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <?php include '../includes/t_sidebar.php'; ?>

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div class="content" id="page-content-wrapper">
        <?php include '../includes/t_navbar.php'; ?>


            <div class="container profile-container">
                <div class="profile-card">
                    <div class="profile-card-header">
                        Profile Information
                    </div>
                    <div class="profile-card-body">
        <p><strong>User ID:</strong> <?= htmlspecialchars($user['user_id']) ?></p>
        <p><strong>First Name:</strong> <?= htmlspecialchars($user['firstname']) ?></p>
        <p><strong>Middle Name:</strong> <?= htmlspecialchars($user['middlename']) ?></p>
        <p><strong>Last Name:</strong> <?= htmlspecialchars($user['lastname']) ?></p>
        <p><strong>District Section:</strong> <?= htmlspecialchars($user['district_section']) ?></p>
        <p><strong>Email Address:</strong> <?= htmlspecialchars($user['emailaddress']) ?></p>
        <p><strong>Contact No:</strong> <?= htmlspecialchars($user['contactnumber']) ?></p>
                </div>

                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <div class="toast" id="successToast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: fixed; bottom: 1rem; right: 1rem;">
  <div class="toast-header">
    <strong class="mr-auto text-success">Success</strong>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    Password Updated Successfully.
  </div>
</div>
    <!-- Menu Toggle Script -->
<script src="../assets/javascript/sidebar_toggle.js"></script>

</body>
</html>
