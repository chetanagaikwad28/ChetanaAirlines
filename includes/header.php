<?php
// session_start();
include('includes/db.php');

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0+TA4q4euS7G1tL9GvTjHm9QzjszBtZQ9s0P86UcPPUGm0rPPN4RshKtANwCk2I" crossorigin="anonymous">
    <style>
        .logo img {
            max-width: 100px;
        }
    </style>
</head>

<body>

    <header class="bg-primary text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="https://firebasestorage.googleapis.com/v0/b/uniment-c0c23.appspot.com/o/reviewer%2Fchetana.jpg?alt=media&token=7d9c3889-76ce-4a20-b5a8-aa9efb69246f">
                    <img src="images/aviation_logo-22-white.png" alt="Airline Logo" class="img-fluid">
                </a>
            </div>

            <nav class="nav">
                <ul class="nav">
                    <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
                    <!-- <li class="nav-item"><a href="flights.php" class="nav-link text-white">Check Flight Status</a></li> -->
                    <!-- <li class="nav-item"><a href="#" class="nav-link text-white">Book</a></li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Manage</a>
                        <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                            <li><a class="dropdown-item" href="manage_bookings.php">My Booking</a></li>
                            <li><a class="dropdown-item" href="cancel_booking.php">Cancel Flight</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="fees_and_charges.php" id="infoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Info</a>
                        <ul class="dropdown-menu" aria-labelledby="infoDropdown">
                            <li><a class="dropdown-item" href="fees_and_charges.php">Fees and Charges</a></li>
                            <li><a class="dropdown-item" href="faqs.php">FAQs</a></li>
                            <li><a class="dropdown-item" href="contact_us.php">Contact Us</a></li>
                        </ul>
                    </li>
                    <?php if ($is_logged_in) : ?>
                        <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
                        <?php if ($is_admin) : ?>
                            <!-- <li class="nav-item"><a href="admin.php" class="nav-link text-white">Admin Panel</a></li> -->
                        <?php endif; ?>
                    <?php else : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Login</a>
                            <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#customerLoginModal">Customer Login</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#adminLoginModal">Admin Login</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Customer Login Modal -->
    <div class="modal fade" id="customerLoginModal" tabindex="-1" aria-labelledby="customerLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerLoginModalLabel">Customer Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="login.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <?php if (isset($_SESSION['login_error'])) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['login_error']; ?>
                            </div>
                            <?php unset($_SESSION['login_error']); ?>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    <div class="mt-3">
                        <span>New User? <a href="#" data-bs-toggle="modal" data-bs-target="#customerRegisterModal">Sign Up</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Register Modal -->
    <div class="modal fade" id="customerRegisterModal" tabindex="-1" aria-labelledby="customerRegisterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerRegisterModalLabel">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="register.php">
                        <div class="mb-3">
                            <label for="regMobileNo" class="form-label">Mobile No.</label>
                            <div class="d-flex">
                                <input type="text" class="form-control me-2" id="regCountryCode" name="country_code" value="+91" readonly style="flex: 1;">
                                <input type="text" class="form-control" id="regMobileNo" name="mobile_no" style="flex: 3;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="regEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="regEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="regPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="regPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="regConfirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="regConfirmPassword" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Login Modal -->
    <div class="modal fade" id="adminLoginModal" tabindex="-1" aria-labelledby="adminLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminLoginModalLabel">Admin Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="login.php">
                        <input type="hidden" name="login_as" value="admin"> <!-- Add hidden field to indicate admin login -->
                        <div class="mb-3">
                            <label for="adminEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="adminEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="adminPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="adminPassword" name="password" required>
                        </div>
                        <?php if (isset($_SESSION['login_error'])) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['login_error']; ?>
                            </div>
                            <?php unset($_SESSION['login_error']); ?>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-HVr4uF2CpWhzKR7ynOoJwBnr2Bq9onM6vZmZ1eXj8jI/EMCv3WC0Qkz0G0brHX1h" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-XQP6k7P46OozQ/x3oU2gkV1oXJz5f2taV+1g9wrbaJUtm8M6DPPY2jh1OwAq1J+/" crossorigin="anonymous"></script>
</body>

</html>