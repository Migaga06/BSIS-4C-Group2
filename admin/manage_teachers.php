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

// Search and Filter Logic
$search = isset($_GET['search']) ? $_GET['search'] : '';
$district_filter = isset($_GET['district_filter']) ? $_GET['district_filter'] : '';

// Fetch all teachers, organized by last name from A-Z
$query = "SELECT user_id, lastname, firstname, district_section FROM users WHERE role='Teacher'";

if (!empty($search)) {
    $query .= " AND (user_id LIKE '%$search%' OR lastname LIKE '%$search%' OR firstname LIKE '%$search%')";
}

if (!empty($district_filter)) {
    $query .= " AND district_section = '$district_filter'";
}

$query .= " ORDER BY lastname ASC";
$result = mysqli_query($conn, $query);

// Fetch all districts for the filter dropdown
$district_query = "SELECT DISTINCT district_section FROM users WHERE role='Teacher' ORDER BY district_section ASC";
$district_result = mysqli_query($conn, $district_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Teachers</title>
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

            <div class="container-fluid mt-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="Form-Head">Manage Teachers</h2>
                    <form method="GET" action="" class="form-inline">
                        <div class="form-group mr-2">
                            <input type="text" class="form-control" name="search" placeholder="Search by name or user ID" value="<?= htmlspecialchars($search) ?>">
                        </div>
                        <div class="form-group mr-2">
                            <select class="form-control" name="district_filter">
                                <option value="">All Districts</option>
                                <?php while ($district_row = mysqli_fetch_assoc($district_result)): ?>
                                    <option value="<?= htmlspecialchars($district_row['district_section']) ?>" <?= $district_filter == $district_row['district_section'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($district_row['district_section']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Lastname</th>
                                <th>Firstname</th>
                                <th>District Section</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['user_id']) ?></td>
                                    <td><?= htmlspecialchars($row['lastname']) ?></td>
                                    <td><?= htmlspecialchars($row['firstname']) ?></td>
                                    <td><?= htmlspecialchars($row['district_section']) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="view_user.php?id=<?= htmlspecialchars($row['user_id']) ?>">View</a>
                                                <a class="dropdown-item" href="edit_user.php?id=<?= htmlspecialchars($row['user_id']) ?>">Edit</a>
                                                <a class="dropdown-item" href="delete_user.php?id=<?= htmlspecialchars($row['user_id']) ?>">Disable</a>
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

    <!-- /#wrapper -->

    <script src="../assets/javascript/sidebar_toggle.js"></script>

</body>
</html>
