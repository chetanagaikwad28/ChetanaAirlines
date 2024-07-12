<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Booking System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>

<body>
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
                    <li class="nav-item"><a href="#" class="nav-link text-white">Manage</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-white">Info</a></li>
                    <?php if ($is_logged_in) : ?>
                        <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
                        <?php if ($is_admin) : ?>
                            <li class="nav-item"><a href="admin.php" class="nav-link text-white">Admin Panel</a></li>
                        <?php endif; ?>
                    <?php else : ?>
                        <li class="nav-item"><a href="register.php" class="nav-link text-white">Register</a></li>
                        <li class="nav-item"><a href="login.php" class="nav-link text-white">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

