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

// Fetch the teacher's details based on user_id
$teacher_id = $_GET['id'];
$teacher_query = "SELECT user_id, firstname, middlename, lastname, emailaddress, contactnumber, district_section, DATE_FORMAT(date_submitted, '%Y-%m-%d') AS date_submitted FROM pending_teachers WHERE user_id='$teacher_id'";
$teacher_result = mysqli_query($conn, $teacher_query);
$teacher = mysqli_fetch_assoc($teacher_result);

if (!$teacher) {
    echo "No details found for the specified teacher.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Details</title>
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
                <div class="profile-card">
                    <div class="profile-card-header">
                        Pending Request
                    </div>
                    <div class="profile-card-body">
                        <p><strong>User ID:</strong> <?= htmlspecialchars($teacher['user_id']) ?></p>
                        <p><strong>First Name:</strong> <?= htmlspecialchars($teacher['firstname']) ?></p>
                        <p><strong>Middle Name:</strong> <?= htmlspecialchars($teacher['middlename']) ?></p>
                        <p><strong>Last Name:</strong> <?= htmlspecialchars($teacher['lastname']) ?></p>
                        <p><strong>Email Address:</strong> <?= htmlspecialchars($teacher['emailaddress']) ?></p>
                        <p><strong>Contact Number:</strong> <?= htmlspecialchars($teacher['contactnumber']) ?></p>
                        <p><strong>District Section:</strong> <?= htmlspecialchars($teacher['district_section']) ?></p>
                        <p><strong>Date Submitted:</strong> <?= htmlspecialchars($teacher['date_submitted']) ?></p>

                        <!-- Action Buttons inside Profile Card -->
                        <form method="post" action="process_teacher.php" class="mt-3">
                            <input type="hidden" name="teacher_id" value="<?= htmlspecialchars($teacher['user_id']) ?>">
                            <button type="submit" name="action" value="approve" class="btn btn-primary">Approve</button>
                            <button type="submit" name="action" value="reject" class="btn btn-primary">Reject</button>
                            <button type="button" class="btn btn-primary" onclick="history.back()">Back</button>
                        </form>
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
