<?php
session_start();
include '../includes/db_connection.php';

// Verify that the current session is an admin
if ($_SESSION['role'] != 'Admin') {
    echo "Unauthorized access.";
    exit;
}

$admin_id = $_SESSION['user_id']; // Store the admin ID separately

// Fetch the admin's details for the navbar
$admin_query = "SELECT firstname, lastname FROM users WHERE user_id='$admin_id'";
$admin_result = mysqli_query($conn, $admin_query);
$admin = mysqli_fetch_assoc($admin_result);

if (!isset($_GET['id'])) {
    echo "Invalid user ID.";
    exit;
}

$user_id = $_GET['id']; // Ensure we get the correct ID from the URL parameter

// Fetch the user's existing details
$query = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch details from POST request
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $emailaddress = $_POST['emailaddress'];
    $contactnumber = $_POST['contactnumber'];
    $district_section = $_POST['district_section'];
    $role = $_POST['role'];

    // Ensure we're updating the correct user
    $query = "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', emailaddress='$emailaddress', contactnumber='$contactnumber', district_section='$district_section', role='$role' WHERE user_id='$user_id'";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "User details updated successfully.";
        header("Location: edit_user.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Error updating user details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
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
        
        <!-- Page Content -->
        <div class="content" id="page-content-wrapper">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-primary" id="menu-toggle">
                    <i class="fas fa-times" id="toggle-icon"></i>
                </button>
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= htmlspecialchars($admin['firstname']) . ' ' . htmlspecialchars($admin['lastname']) ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="asds_profile.php">Profile</a>
                            <a class="dropdown-item" href="asds_change_pass.php">Change Password</a>
                            <a class="dropdown-item" href="../logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="container-fluid mt-2">
                <div class="edit-user-container">
                    <div class="edit-user-box">
                        <h2>Edit User</h2>
                        <?php
                        if (isset($_SESSION['success_message'])) {
                            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                            unset($_SESSION['success_message']);
                        }
                        if (isset($_SESSION['error_message'])) {
                            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                            unset($_SESSION['error_message']);
                        }
                        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="firstname">First Name:</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="middlename">Middle Name:</label>
                                <input type="text" class="form-control" id="middlename" name="middlename" value="<?= htmlspecialchars($user['middlename']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="emailaddress">Email Address:</label>
                                <input type="email" class="form-control" id="emailaddress" name="emailaddress" value="<?= htmlspecialchars($user['emailaddress']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="contactnumber">Contact Number:</label>
                                <input type="text" class="form-control" id="contactnumber" name="contactnumber" value="<?= htmlspecialchars($user['contactnumber']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="district_section">District Section:</label>
                                <select class="form-control" id="district_section" name="district_section" required>
                                    <option value="I" <?= $user['district_section'] == 'I' ? 'selected' : '' ?>>I</option>
                                    <option value="II" <?= $user['district_section'] == 'II' ? 'selected' : '' ?>>II</option>
                                    <option value="III" <?= $user['district_section'] == 'III' ? 'selected' : '' ?>>III</option>
                                    <option value="IV" <?= $user['district_section'] == 'IV' ? 'selected' : '' ?>>IV</option>
                                    <option value="V" <?= $user['district_section'] == 'V' ? 'selected' : '' ?>>V</option>
                                    <option value="VI" <?= $user['district_section'] == 'VI' ? 'selected' : '' ?>>VI</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="Teacher" <?= $user['role'] == 'Teacher' ? 'selected' : '' ?>>Teacher</option>
                                    <option value="Admin" <?= $user['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="Personnel" <?= $user['role'] == 'Personnel' ? 'selected' : '' ?>>Personnel</option>
                                    <option value="Personnel Head" <?= $user['role'] == 'Personnel Head' ? 'selected' : '' ?>>Personnel Head</option>
                                    <option value="ASDS" <?= $user['role'] == 'ASDS' ? 'selected' : '' ?>>ASDS</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-primary" onclick="history.back()">Back</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script src="../assets/javascript/sidebar_toggle.js"></script>
</body>
</html>
