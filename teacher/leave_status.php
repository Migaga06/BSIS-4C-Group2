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

$user_id = $_SESSION['user_id'];
$query = "SELECT *, DATE_FORMAT(date_submitted, '%Y-%m-%d') as formatted_date_submitted FROM leave_requests WHERE user_id = '$user_id' AND status IN ('Approved by ASDS', 'Approved by Personnel', 'Approved by Personnel Head', 'Pending') ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Status</title>
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
            <h2 class="Form-Head">Leave Status</h2>
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
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
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
                        <?php if ($row['status'] == 'Pending'): ?>
                            <a class="dropdown-item" href="edit_leave.php?id=<?= htmlspecialchars($row['id']) ?>">Edit</a>
                            <a class="dropdown-item" href="cancel_leave.php?id=<?= htmlspecialchars($row['id']) ?>">Cancel</a>
                        <?php endif; ?>
                        <?php if ($row['status'] == 'Approved by ASDS' || $row['status'] == 'Rejected by Personnel' || $row['status'] == 'Rejected by Personnel Head' || $row['status'] == 'Rejected by ASDS'): ?>
                            <a class="dropdown-item" href="archive_leave.php?id=<?= htmlspecialchars($row['id']) ?>">Archive</a>
                        <?php endif; ?>
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

    <!-- Toast Notification -->
<div class="toast" id="successToast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: fixed; bottom: 1rem; right: 1rem;">
  <div class="toast-header">
    <strong class="mr-auto text-success">Success</strong>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    <?= $_SESSION['toast_success'] ?>
  </div>
</div>

    <!-- /#wrapper -->

    <script src="../assets/javascript/sidebar_toggle.js"></script>
    
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
