<?php
session_start();
include 'includes/db_connection.php';

$previous_data = [
    'user_id' => '',
    'firstname' => '',
    'middlename' => '',
    'lastname' => '',
    'emailaddress' => '',
    'contactnumber' => '',
    'district_section' => '',
    'password' => '',
    'retype_password' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($previous_data as $key => $value) {
        if (isset($_POST[$key])) {
            $previous_data[$key] = $_POST[$key];
        }
    }

    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $emailaddress = $_POST['emailaddress'];
    $contactnumber = $_POST['contactnumber'];
    $district_section = $_POST['district_section'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];

    // Check if user ID already exists
    $query = "SELECT user_id FROM users WHERE user_id = '$user_id' UNION SELECT user_id FROM pending_teachers WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error_message'] = "User ID already exists. Please choose a different User ID.";
        $_SESSION['previous_data'] = $previous_data;
        header("Location: signup.php");
        exit;
    }

    // Password validation
    if (strlen($password) < 8) {
        $_SESSION['error_message'] = "Password must be at least 8 characters long.";
        $_SESSION['previous_data'] = $previous_data;
        header("Location: signup.php");
        exit;
    }

    if (!preg_match("/[!@#$%^&*_\-]/", $password)) {
        $_SESSION['error_message'] = "Password must contain at least one special character (e.g., !, @, #, $, %, ^, &, *, _, -).";
        $_SESSION['previous_data'] = $previous_data;
        header("Location: signup.php");
        exit;
    }

    if ($password !== $retype_password) {
        $_SESSION['error_message'] = "Passwords do not match.";
        $_SESSION['previous_data'] = $previous_data;
        header("Location: signup.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO pending_teachers (user_id, firstname, middlename, lastname, emailaddress, contactnumber, district_section, password) 
              VALUES ('$user_id', '$firstname', '$middlename', '$lastname', '$emailaddress', '$contactnumber', '$district_section', '$hashed_password')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "Signup request submitted successfully.";
        header("Location: signup.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn) . "<br>";
    }
}

if (isset($_SESSION['previous_data'])) {
    $previous_data = $_SESSION['previous_data'];
    unset($_SESSION['previous_data']);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Teacher Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/signup.css">
    <style>
        .error-message {
            color: #FF5E00;
            margin-top: -10px;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .input-group .input-group-append .input-group-text {
            background: none;
        }

        .input-group .input-group-append .input-group-text .fa-eye, 
        .input-group .input-group-append .input-group-text .fa-eye-slash {
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-box">
            <h2>Teacher Signup</h2>
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
                    <label for="user_id">User ID:</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" value="<?= htmlspecialchars($previous_data['user_id']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?= htmlspecialchars($previous_data['firstname']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="middlename">Middle Name:</label>
                    <input type="text" class="form-control" id="middlename" name="middlename" value="<?= htmlspecialchars($previous_data['middlename']) ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?= htmlspecialchars($previous_data['lastname']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="emailaddress">Email Address:</label>
                    <input type="email" class="form-control" id="emailaddress" name="emailaddress" value="<?= htmlspecialchars($previous_data['emailaddress']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="contactnumber">Contact Number:</label>
                    <input type="text" class="form-control" id="contactnumber" name="contactnumber" value="<?= htmlspecialchars($previous_data['contactnumber']) ?>" required>
                </div>
                <div class="form-group district-section">
                    <label for="district_section">District Section:</label>
                    <select class="form-control" id="district_section" name="district_section" required>
                        <option value="I" <?= $previous_data['district_section'] == 'I' ? 'selected' : '' ?>>I</option>
                        <option value="II" <?= $previous_data['district_section'] == 'II' ? 'selected' : '' ?>>II</option>
                        <option value="III" <?= $previous_data['district_section'] == 'III' ? 'selected' : '' ?>>III</option>
                        <option value="IV" <?= $previous_data['district_section'] == 'IV' ? 'selected' : '' ?>>IV</option>
                        <option value="V" <?= $previous_data['district_section'] == 'V' ? 'selected' : '' ?>>V</option>
                        <option value="VI" <?= $previous_data['district_section'] == 'VI' ? 'selected' : '' ?>>VI</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" value="<?= htmlspecialchars($previous_data['password']) ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="retype_password">Retype Password:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="retype_password" name="retype_password" value="<?= htmlspecialchars($previous_data['retype_password']) ?>" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="toggleRetypePassword">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>                
                </div>
                <button type="submit" class="btn btn-primary btn-block">Signup</button>
                <p class="mt-2">
                    Already have an account? <a href="index.php" class="btn-link">Login</a>
                </p>
            </form>
        </div>
    </div>
    <script src="assets/javascript/signup.js"> </script>
</body>
</html>
