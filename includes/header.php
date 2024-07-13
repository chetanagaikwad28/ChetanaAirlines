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
            <img src="images/aviation_logo-22.png" alt="Airline Logo" class="img-fluid">
        </div>
        <nav class="nav">
            <ul class="nav">
                <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
                <li class="nav-item"><a href="flights.php" class="nav-link text-white">Check Flight Status</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Book</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Manage</a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="#">Edit Booking</a></li>
                        <li><a class="dropdown-item" href="#">Cancel Flight</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="infoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Info</a>
                    <ul class="dropdown-menu" aria-labelledby="infoDropdown">
                        <li><a class="dropdown-item" href="fees_and_charges.php">Fees and Charges</a></li>
                        <li><a class="dropdown-item" href="#">FAQs</a></li>
                        <li><a class="dropdown-item" href="#">Contact Us</a></li>
                    </ul>
                </li>
                <?php if ($is_logged_in) : ?>
                    <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
                    <?php if ($is_admin) : ?>
                        <li class="nav-item"><a href="admin.php" class="nav-link text-white">Admin Panel</a></li>
                    <?php endif; ?>
                <?php else : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Login</a>
                        <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                            <li><a class="dropdown-item" href="login.php">Customer Login</a></li>
                            <li><a class="dropdown-item" href="admin_login.php">Admin Login</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzV4Scd1NxkHl9pbMA1p6iYkMfH7/E3yG7arPbEe9tz3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+27mtL0EaBw2rZ2x0Gctczf4FuvHg" crossorigin="anonymous"></script>