<?php
session_start();
include '../includes/db_connection.php';

if ($_SESSION['role'] != 'ASDS') {
    echo "Unauthorized access.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_id = $_POST['leave_id'];
    $action = $_POST['action'];

    $status = $action == 'approve' ? 'Approved by ASDS' : 'Rejected by ASDS';
    $query = "UPDATE leave_requests SET status='$status' WHERE id='$leave_id'";
    if (mysqli_query($conn, $query)) {
        echo "Request updated successfully.<br>";
    } else {
        echo "Error updating record: " . mysqli_error($conn) . "<br>";
    }
}

$query = "SELECT * FROM leave_requests WHERE status='Approved by Personnel Head'";
$result = mysqli_query($conn, $query);
?>

<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html>
<head>
    <title>ASDS Interface</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapc.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/a_sidebar.css">
</head>
<body>
    <div class="sidebar">
        <h2>ASDS Interface</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php if($current_page == 'pending_applications.php') echo 'active'; ?>" href="pending_applications.php">
                    <i class="fas fa-clock"></i> Pending Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current_page == 'approved.php') echo 'active'; ?>" href="approved.php">
                    <i class="fas fa-check-circle"></i> Approved
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current_page == 'rejected.php') echo 'active'; ?>" href="rejected.php">
                    <i class="fas fa-times-circle"></i> Rejected
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current_page == '../logout.php') echo 'active'; ?>" href="../logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>
    <div class="content">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h1>Pending Leave Requests</h1>
            <form method="POST">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div>
                        <p>Leave Request ID: <?= $row['id'] ?></p>
                        <p>Teacher ID: <?= $row['teacher_id'] ?></p>
                        <p>Leave Type: <?= $row['leave_type'] ?></p>
                        <p>Start Date: <?= $row['start_date'] ?></p>
                        <p>End Date: <?= $row['end_date'] ?></p>
                        <p>Reason: <?= $row['reason'] ?></p>
                        
                        <input type="hidden" name="leave_id" value="<?= $row['id'] ?>">
                        <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                        <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                    </div>
                <?php endwhile; ?>
            </form>
        </main>
    </div>
</body>
</html>
