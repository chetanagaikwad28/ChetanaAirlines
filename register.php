<?php
include('includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = ''; // You can add name field in the form if needed.
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = ''; // You can add age field in the form if needed.
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Validate input if required

    $sql = "INSERT INTO user (Name, Email, Password, Age, is_admin) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $password, $age, $is_admin);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['register_error'] = "Registration failed. Please try again later.";
        header("Location: index.php"); // Redirect to appropriate page
        exit();
    }
}
