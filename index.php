<?php
session_start();
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            switch ($user['role']) {
                case 'Teacher':
                    header("Location: teacher/apply_leave.php");
                    exit;
                case 'Personnel':
                    header("Location: personnel/p_dashboard.php");
                    exit;
                case 'Personnel Head':
                    header("Location: personnel_head/ph_dashboard.php");
                    exit;
                case 'ASDS':
                    header("Location: asds/asds_dashboard.php");
                    exit;
                case 'Admin':
                    header("Location: admin/admin_dashboard.php");
                    exit;
            }
        } else {
            $_SESSION['error_message'] = "Incorrect password.";
        }
    } else {
        $_SESSION['error_message'] = "User ID not found.";
    }
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <?php
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
            ?>
            <form method="POST">
                <div class="form-group">
                    <label for="user_id">User ID:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" id="user_id" name="user_id" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>

                <p class="mt-4">
                    Don't have an account? <a href="signup.php" class="btn-link">Sign up</a>
                </p>
                <p class="mt-2">
                Forgot your password? <a href="forgot_password.php" class="btn-link">Reset Password</a>
                </p>

            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $("#togglePassword").click(function() {
            let passwordField = $("#password");
            let passwordFieldType = passwordField.attr("type");

            if (passwordFieldType == "password") {
                passwordField.attr("type", "text");
                $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                passwordField.attr("type", "password");
                $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });
    });
    </script>
</body>
</html>
