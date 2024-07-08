<?php
include('includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = $_POST['age'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $sql = "INSERT INTO user (Name, Email, Password, Age, is_admin) VALUES ('$name', '$email', '$password', '$age', '$is_admin')";
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

include('includes/header.php');
?>

<main>
    <h2>Register</h2>
    <form method="POST" action="">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Age:</label>
        <input type="number" name="age" required><br>
        <label>Admin:</label>
        <input type="checkbox" name="is_admin"><br>
        <button type="submit">Register</button>
    </form>
</main>

</body>

</html>