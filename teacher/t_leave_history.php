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

// Fetch Approved/Archived, rejected or canceled leave requests
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

$query = "SELECT id, leave_type, start_date, end_date, status, DATE_FORMAT(date_submitted, '%Y-%m-%d') as formatted_date_submitted FROM leave_requests WHERE user_id='$user_id'";
if (!empty($status_filter)) {
    $query .= " AND status = '$status_filter'";
} else {
    $query .= " AND status IN ('Rejected by ASDS', 'Rejected by Personnel', 'Rejected by Personnel Head', 'Canceled', 'Approved')";
}
$query .= " ORDER BY id DESC";
$rejected_result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Leave History</title>
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
        <?php include '../includes/t_sidebar.php'; ?>

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div class="content" id="page-content-wrapper">
            <?php include '../includes/t_navbar.php'; ?>
    
            <div class="container-fluid mt-2">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h2 class="Form-Head">Leave History</h2>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <form method="GET" action="" class="form-inline">
                            <div class="form-group">
                                <select class="form-control" id="status_filter" name="status_filter">
                                    <option value="" <?= $status_filter == '' ? 'selected' : '' ?>>All</option>
                                    <option value="Approved" <?= $status_filter == 'Approved' ? 'selected' : '' ?>>Approved</option>
                                    <option value="Rejected by ASDS" <?= $status_filter == 'Rejected by ASDS' ? 'selected' : '' ?>>Rejected by ASDS</option>
                                    <option value="Rejected by Personnel" <?= $status_filter == 'Rejected by Personnel' ? 'selected' : '' ?>>Rejected by Personnel</option>
                                    <option value="Rejected by Personnel Head" <?= $status_filter == 'Rejected by Personnel Head' ? 'selected' : '' ?>>Rejected by Personnel Head</option>
                                    <option value="Canceled" <?= $status_filter == 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary ml-2">Filter</button>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Date Submitted</th>
                                <th>Leave Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($rejected_result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['formatted_date_submitted']) ?></td>
                                    <td><?= htmlspecialchars($row['leave_type']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="view_leave.php?id=<?= htmlspecialchars($row['id']) ?>">View</a>
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

    <script src="../assets/javascript/sidebar_toggle.js"></script>
</body>
</html>
