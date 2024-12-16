<!-- navbar.php -->
<div class="d-flex">
    <!-- Side Navbar -->
    <div class="bg-dark text-white p-3" style="width: 250px; height: 100vh;">
        <div class="d-flex align-items-center justify-content-center mb-3">
            <img src="assets/images/dolphin.png" alt="Dolphin Logo" style="max-width: 30px; max-height: 30px; margin-right: 8px;">
            <h4 class="mb-0">Dolphin CRM</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white ajax-link" href="pages/home.php" data-target="#content">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white ajax-link" href="pages/add_contact.php" data-target="#content">New Contact</a>
            </li>
            <li class="nav-item">
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a class="nav-link text-white ajax-link" href="pages/users.php" data-target="#content">Users</a>
                <?php endif; ?>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="pages/logout.php">Logout</a>
            </li>
        </ul>
    </div>
