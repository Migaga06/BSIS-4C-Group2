<div class="sidebar" id="sidebar-wrapper">
    <h2 class="sidebar-heading">Personnel</h2>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'p_dashboard.php') echo 'active'; ?>" href="p_dashboard.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'p_pending_applications.php') echo 'active'; ?>" href="p_pending_applications.php">
                <i class="fas fa-clock"></i> Pending Applications
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'p_approved.php') echo 'active'; ?>" href="p_approved.php">
                <i class="fas fa-check-circle"></i> Approved
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'p_rejected.php') echo 'active'; ?>" href="p_rejected.php">
                <i class="fas fa-times-circle"></i> Rejected
            </a>
        </li>
    </ul>
</div>
