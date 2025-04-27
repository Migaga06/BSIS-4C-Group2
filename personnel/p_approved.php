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

// Query to get all requests approved by Personnel
$query = "SELECT * FROM leave_requests WHERE approved_personnel='Yes'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approved Leave Requests</title>
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

            <div class="container-fluid mt-2">
                <h2 class="Form-Head">Approved Leave Requests</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <!-- Leave Request ID column removed -->
                                <th>Teacher's ID</th>
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <!-- Leave Request ID cell removed -->
                                    <td><?= htmlspecialchars($row['user_id']) ?></td>
                                    <td><?= htmlspecialchars($row['leave_type']) ?></td>
                                    <td><?= htmlspecialchars($row['start_date']) ?></td>
                                    <td><?= htmlspecialchars($row['end_date']) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="p_view_leave.php?id=<?= htmlspecialchars($row['id']) ?>">View</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
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
