<?php
include('includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $login_as = $_POST['login_as']; // 'customer' or 'admin'

    $sql = "SELECT * FROM user WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserID'];

            if ($login_as === 'admin' && $user['is_admin']) {
                $_SESSION['is_admin'] = true;
                header("Location: index.php");
            } else {
                $_SESSION['is_admin'] = false;
                header("Location: index.php");
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid password.";
        }
    } else {
        $_SESSION['login_error'] = "No user found with that email.";
    }
}

header("Location: index.php");
exit();
