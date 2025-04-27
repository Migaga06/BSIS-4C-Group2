<div class="sidebar" id="sidebar-wrapper">
    <h2 class="sidebar-heading">Personnel Head</h2>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'ph_dashboard.php') echo 'active'; ?>" href="ph_dashboard.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'ph_pending_applications.php') echo 'active'; ?>" href="ph_pending_applications.php">
                <i class="fas fa-clock"></i> Pending Applications
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'ph_approved.php') echo 'active'; ?>" href="ph_approved.php">
                <i class="fas fa-check-circle"></i> Approved
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($current_page == 'ph_rejected.php') echo 'active'; ?>" href="ph_rejected.php">
                <i class="fas fa-times-circle"></i> Rejected
            </a>
        </li>
    </ul>
</div>
