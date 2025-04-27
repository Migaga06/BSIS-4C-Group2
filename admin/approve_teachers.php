<?php
session_start();
include '../includes/db_connection.php';

// Fetch the logged-in user’s details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT firstname, lastname FROM users WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

$current_page = basename($_SERVER['PHP_SELF']);

if ($_SESSION['role'] != 'Admin') {
    echo "Unauthorized access.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    // Start a transaction to ensure all queries run successfully
    $conn->begin_transaction();

    try {
        // Insert approved teacher into users table
        $insert_query = "INSERT INTO users (user_id, password, firstname, middlename, lastname, district_section, emailaddress, contactnumber, role)
                         SELECT user_id, password, firstname, middlename, lastname, district_section, emailaddress, contactnumber, 'Teacher' 
                         FROM pending_teachers WHERE user_id = ?";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("s", $user_id);  // Adjust the parameter type to 's' for string
        $stmt->execute();

        // Delete from pending_teachers table
        $delete_query = "DELETE FROM pending_teachers WHERE user_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("s", $user_id);  // Adjust the parameter type to 's' for string
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        echo "Teacher approved successfully.<br>";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

// Query to select all pending teachers
$query = "SELECT * FROM pending_teachers WHERE status='Pending'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve Teachers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/admin_sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar-wrapper">
        <h2 class="sidebar-heading">Admin</h2>
        <ul class="list-group">
            <li class="list-group-item <?php if($current_page == 'approve_teachers.php') echo 'active'; ?>">
                <a class="nav-link" href="approve_teachers.php">
                    <i class="fas fa-user-check"></i> Pending Teachers
                </a>
            </li>
            <li class="list-group-item <?php if($current_page == 'manage_users.php') echo 'active'; ?>">
                <a class="nav-link" href="manage_users.php">
                    <i class="fas fa-user-cog"></i> Manage Users
                </a>
            </li>
            <li class="list-group-item <?php if($current_page == 'leave_requests.php') echo 'active'; ?>">
                <a class="nav-link" href="leave_requests.php">
                    <i class="fas fa-file-alt"></i> Leave Requests
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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $user['firstname'] . ' ' . $user['lastname'] ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="container mt-4">
            <h2>Pending Teacher Sign-Up Requests</h2>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <form method="POST" action="approve_teachers.php">
                    <div class="form-group">
                        <p>User ID: <?= $row['user_id'] ?></p>
                        <p>First Name: <?= $row['firstname'] ?></p>
                        <p>Middle Name: <?= $row['middlename'] ?></p>
                        <p>Last Name: <?= $row['lastname'] ?></p>
                        <p>District Section: <?= $row['district_section'] ?></p>
                        <p>Email Address: <?= $row['emailaddress'] ?></p>
                        <p>Contact Number: <?= $row['contactnumber'] ?></p>
                        <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                        <button type="submit" class="btn btn-success">Approve</button>
                    </div>
                </form>
            <?php endwhile; ?>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
</body>
</html>
