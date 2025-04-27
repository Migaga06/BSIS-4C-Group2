<?php
session_start();
include '../includes/db_connection.php';

$current_page = basename($_SERVER['PHP_SELF']);

// Fetch the logged-in user’s details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT firstname, lastname FROM users WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

if ($_SESSION['role'] != 'Teacher') {
    echo "Unauthorized access.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $user_id = $_SESSION['user_id']; // Make sure this is set
    $leave_details = $_POST['leave_details'];
    $commutation = $_POST['commutation'];
    $other_leave_type = $_POST['other_leave_type'] ?? null;

    // Set the leave type to the 'Other' input if it's filled
    if ($leave_type == 'Others' && !empty($other_leave_type)) {
        $leave_type = $other_leave_type;
    }

    $query = "INSERT INTO leave_requests (user_id, leave_type, start_date, end_date, leave_details, commutation, status) 
              VALUES ('$user_id', '$leave_type', '$start_date', '$end_date', '$leave_details', '$commutation', 'Pending')";
    if (mysqli_query($conn, $query)) {
        header('Location: leave_status.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Interface</title>
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
        <div class="sidebar" id="sidebar-wrapper">
            <h2 class="sidebar-heading">Teacher</h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'teacher_interface.php') echo 'active'; ?>" href="teacher_interface.php">
                        <i class="fas fa-paper-plane"></i> Apply Leave
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 't_leave_history.php') echo 'active'; ?>" href="t_leave_history.php">
                        <i class="fas fa-history"></i> Leave History
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'leave_status.php') echo 'active'; ?>" href="leave_status.php">
                        <i class="fas fa-clipboard-list"></i> Leave Status
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div class="content" id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-primary" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#">
                            <i class="fas fa-bell"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $user['firstname'] . ' ' . $user['lastname'] ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="../logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid mt-4 form-container">
                <form method="POST" action="teacher_interface.php">
                    <div class="form-group">
                        <label for="leave_type">6.A. Type of Leave to be Availed of:</label>
                        <select class="form-control" id="leave_type" name="leave_type" required onchange="toggleOtherField(this)">
                            <option value="Vacation Leave">Vacation Leave</option>
                            <option value="Mandatory Forced Leave">Mandatory Forced Leave</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Maternity Leave">Maternity Leave</option>
                            <option value="Paternity Leave">Paternity Leave</option>
                            <option value="Special Privilege">Special Privilege</option>
                            <option value="Solo Parent Leave">Solo Parent Leave</option>
                            <option value="Study Leave">Study Leave</option>
                            <option value="10-Day VAWC">10-Day VAWC</option>
                            <option value="Rehabilitation">Rehabilitation</option>
                            <option value="Special Leave Benefits for Women">Special Leave Benefits for Women</option>
                            <option value="Adoption Leave">Adoption Leave</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="form-group" id="other_leave_type_group" style="display:none;">
                        <label for="other_leave_type">Please Specify:</label>
                        <input type="text" class="form-control" id="other_leave_type" name="other_leave_type">
                    </div>
                    <div class="form-group">
                        <label for="leave_details">6.B. Details of Leave:</label>
                        <select class="form-control" id="leave_details" name="leave_details" required>
                            <option value="Within the Philippines">Within the Philippines</option>
                            <option value="Abroad">Abroad</option>
                            <option value="In Hospital">In Hospital</option>
                            <option value="Out Patient">Out Patient</option>
                            <option value="Completion of Master's Degree">Completion of Master's Degree</option>
                            <option value="BAR/Board Examination Review">BAR/Board Examination Review</option>
                            <option value="Monetization of Leave Credits">Monetization of Leave Credits</option>
                            <option value="Terminal Leave">Terminal Leave</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_date">6.C. Duration of Leave: Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">6.C. Duration of Leave: End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="commutation">6.D. Commutation:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="commutation_requested" name="commutation" value="Requested" required>
                            <label class="form-check-label" for="commutation_requested">Requested</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="commutation_not_requested" name="commutation" value="Not Requested" required>
                            <label class="form-check-label" for="commutation_not_requested">Not Requested</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Leave</button>
                </form>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>
        function toggleOtherField(selectElement) {
            var otherFieldGroup = document.getElementById('other_leave_type_group');
            if (selectElement.value === 'Others') {
                otherFieldGroup.style.display = 'block';
            } else {
                otherFieldGroup.style.display = 'none';
            }
        }

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
</html>
