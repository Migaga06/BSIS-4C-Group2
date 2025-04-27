<div class="sidebar" id="sidebar-wrapper">
            <h2 class="sidebar-heading">Teacher</h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'apply_leave.php') echo 'active'; ?>" href="apply_leave.php">
                        <i class="fas fa-paper-plane"></i> Apply Leave
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 't_leave_history.php') echo 'active'; ?>" href="t_leave_history.php">
                        <i class="fas fa-history"></i> Leave History
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'leave_status.php') echo 'active'; ?>" href="leave_status.php">
                        <i class="fas fa-clipboard-list"></i> Leave Status
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page == 'leave_type.php') echo 'active'; ?>" href="leave_type.php">
                        <i class="fas fas fa-book-reader"></i> Leave Type
                    </a>
                </li>
            </ul>
        </div>