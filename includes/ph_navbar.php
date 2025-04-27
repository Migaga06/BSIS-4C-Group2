
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <button class="btn btn-primary" id="menu-toggle">
        <i class="fas fa-times" id="toggle-icon"></i>
    </button>
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#">
                <i class="fas fa-bell"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']) ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="ph_profile.php">Profile</a>
                <a class="dropdown-item" href="ph_change_pass.php">Change Password</a>
                <a class="dropdown-item" href="../logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>
