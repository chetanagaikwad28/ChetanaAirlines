<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>

<header class="bg-primary text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <img src="assets/images/aviation_logo-22.jpg" alt="Airline Logo" class="img-fluid">
        </div>
        <nav class="nav">
            <ul class="nav">
                <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
                <li class="nav-item"><a href="flights.php" class="nav-link text-white">Check Flight Status</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Book</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="manageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Manage</a>
                    <div class="dropdown-menu" aria-labelledby="manageDropdown">
                        <a class="dropdown-item" href="#">Edit Booking</a>
                        <a class="dropdown-item" href="#">Cancel Flight</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="infoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Info</a>
                    <div class="dropdown-menu" aria-labelledby="infoDropdown">
                        <a class="dropdown-item" href="#">Fees and Charges</a>
                        <a class="dropdown-item" href="#">FAQs</a>
                        <a class="dropdown-item" href="#">Contact Us</a>
                    </div>
                </li>
                <?php if ($is_logged_in) : ?>
                    <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
                    <?php if ($is_admin) : ?>
                        <li class="nav-item"><a href="admin.php" class="nav-link text-white">Admin Panel</a></li>
                    <?php endif; ?>
                <?php else : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="loginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
                        <div class="dropdown-menu" aria-labelledby="loginDropdown">
                            <a class="dropdown-item" href="login.php">Customer Login</a>
                            <a class="dropdown-item" href="admin_login.php">Admin Login</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
