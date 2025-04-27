<div class="sidebar" id="sidebar-wrapper">
    <h2 class="sidebar-heading">Admin</h2>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'admin_dashboard.php') echo 'active'; ?>" href="admin_dashboard.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'pending_teachers.php') echo 'active'; ?>" href="pending_teachers.php">
                <i class="fas fa-user-clock"></i> Pending Teachers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'leave_requests.php') echo 'active'; ?>" href="leave_requests.php">
                <i class="fas fa-file-alt"></i> Leave Requests
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'manage_teachers.php') echo 'active'; ?>" href="manage_teachers.php">
                <i class="fas fa-chalkboard-teacher"></i> Manage Teachers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'manage_admins.php') echo 'active'; ?>" href="manage_admins.php">
                <i class="fas fa-user-shield"></i> Manage Admins
            </a>
        </li>
    </ul>
</div>
