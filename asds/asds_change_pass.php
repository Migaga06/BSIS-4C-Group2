<?php
session_start();
include '../includes/db_connection.php';

// Ensure user is logged in and has the correct role
if ($_SESSION['role'] != 'ASDS') {
    echo "Unauthorized access.";
    exit;
}

// Fetch the logged-in user's details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT firstname, lastname, password FROM users WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

$password_pattern = "/^(?=.*[!@#$%^&*_\-])[A-Za-z\d!@#$%^&*_\-]{8,}$/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify the current password
    if ($user && password_verify($current_password, $user['password'])) {
        // Validate new password
        if (!preg_match($password_pattern, $new_password)) {
            if (strlen($new_password) < 8) {
                $error_message = 'New password must be at least 8 characters long.';
            } elseif (!preg_match("/[!@#$%^&*_\-]/", $new_password)) {
                $error_message = 'New password must contain at least one special character (e.g., !, @, #, $, %, ^, &, *, _, -).';
            }
        } elseif ($new_password !== $confirm_password) {
            $error_message = 'New password and confirm password do not match.';
        } else {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_query = "UPDATE users SET password = '$hashed_password' WHERE user_id = '$user_id'";
            if (mysqli_query($conn, $update_query)) {
                $_SESSION['toast_success'] = 'Password updated successfully!';
                header('Location: asds_change_pass.php');
                exit();
            } else {
                $error_message = 'Error updating password. Please try again.';
            }
        }
    } else {
        $error_message = 'Current password is incorrect.';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/t_sidebar.css">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php include '../includes/asds_sidebar.php'; ?>

        <!-- Page Content -->
        <div class="content" id="page-content-wrapper">
            <?php include '../includes/asds_navbar.php'; ?>

            <div class="container change-password-container">
                <div class="change-password-form">
                    <h2>Change Password</h2>
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                    <?php endif; ?>
                    <form method="POST" action="asds_change_pass.php">
                    <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <div class="input-group">
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                    <div class="input-group-append">
                    <span class="input-group-text" id="toggleCurrentPassword" style="cursor: pointer;">
                    <i class="fas fa-eye"></i>
                     </span>
                    </div>
                    </div>
                </div>
                        <div class="form-group">
                        <label for="new_password">New Password</label>
                        <div class="input-group">
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <div class="input-group-append">
                        <span class="input-group-text" id="toggleNewPassword" style="cursor: pointer;">
                        <i class="fas fa-eye"></i>
                        </span>
                        </div>
                    </div>
                        </div>
                        <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                    <div class="input-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <div class="input-group-append">
                    <span class="input-group-text" id="toggleConfirmPassword" style="cursor: pointer;">
                <i class="fas fa-eye"></i>
            </span>
                    </div>
                    </div>
                    </div>

                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <div class="toast" id="successToast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: fixed; bottom: 1rem; right: 1rem;">
  <div class="toast-header">
    <strong class="mr-auto text-success">Success</strong>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    Password Updated
  </div>
</div>


    <script src="../assets/javascript/sidebar_toggle.js"></script>
    <script src="../assets/javascript/change_pass_toggle.js"></script>

    <script>
        $(document).ready(function() {
        <?php if (isset($_SESSION['toast_success'])): ?>
        $('#successToast').toast('show');
        <?php unset($_SESSION['toast_success']); ?>
        <?php endif; ?>
        });
    </script>
</body>
</html>
