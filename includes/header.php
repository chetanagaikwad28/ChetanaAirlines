<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['customer_login'])) {
        // Customer login process
        $country_code = $_POST['country_code'];
        $mobile_no = $_POST['mobile_no'];
        $password = $_POST['password'];

        // Dummy check for login
        if ($country_code === '+91' && $mobile_no === '940' && $password === 'password') {
            $_SESSION['user_id'] = 'customer_id';
            $_SESSION['is_admin'] = false;
            header('Location: customer_dashboard.php');
            exit;
        } else {
            // Redirect back with error message
            header('Location: index.php?login_error=1');
            exit;
        }
    } elseif (isset($_POST['admin_login'])) {
        // Admin login process
        $user_id = $_POST['user_id'];
        $password = $_POST['password'];

        // Dummy check for login
        if ($user_id === 'admin' && $password === 'adminpassword') {
            $_SESSION['user_id'] = 'admin_id';
            $_SESSION['is_admin'] = true;
            header('Location: admin_dashboard.php');
            exit;
        } else {
            // Redirect back with error message
            header('Location: index.php?login_error=1');
            exit;
        }
    }
}
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
                    <a class="nav-link dropdown-toggle text-white" href="fees_and_charges.php" id="infoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Info</a>
                    <ul class="dropdown-menu" aria-labelledby="infoDropdown">
                        <li><a class="dropdown-item" href="#">Fees and Charges</a></li>
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
                <h5 class="modal-title" id="customerLoginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <input type="hidden" name="customer_login" value="1">
                    <div class="mb-3">
                        <label for="mobileNo" class="form-label">Mobile No.</label>
                        <div class="d-flex">
                            <input type="text" class="form-control me-2" id="countryCode" name="country_code" value="+91" readonly style="flex: 1;">
                            <input type="text" class="form-control" id="mobileNo" name="mobile_no" style="flex: 3;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me">
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>
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
                <form method="post" action="register_customer.php">
                    <div class="mb-3">
                        <label for="regMobileNo" class="form-label">Mobile No.</label>
                        <div class="d-flex">
                            <input type="text" class="form-control me-2" id="regCountryCode" name="country_code" value="+91" readonly style="flex: 1;">
                            <input type="text" class="form-control" id="regMobileNo" name="mobile_no" style="flex: 3;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="regEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="regEmail" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="regPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="regPassword" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="regConfirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="regConfirmPassword" name="confirm_password">
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
                <h5 class="modal-title" id="adminLoginModalLabel">Partner Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <input type="hidden" name="admin_login" value="1">
                    <div class="mb-3">
                        <label for="userId" class="form-label">User ID</label>
                        <input type="text" class="form-control" id="userId" name="user_id">
                    </div>
                    <div class="mb-3">
                        <label for="adminPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="adminPassword" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <div class="mt-3">
                    <span>New User? <a href="#" data-bs-toggle="modal" data-bs-target="#adminRegisterModal">Register Admin</a></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admin Register Modal -->
<div class="modal fade" id="adminRegisterModal" tabindex="-1" aria-labelledby="adminRegisterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminRegisterModalLabel">Admin Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="register_admin.php">
                    <div class="mb-3">
                        <label for="regAdminEmail" class="form-label">Official Email</label>
                        <input type="email" class="form-control" id="regAdminEmail" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="regAdminPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="regAdminPhone" name="phone">
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzV4Scd1NxkHl9pbMA1p6iYkMfH7/E3yG7arPbEe9tz3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+27mtL0EaBw2rZ2x0Gctczf4FuvHg" crossorigin="anonymous"></script>