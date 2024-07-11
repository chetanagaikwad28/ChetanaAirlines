<?php
include('includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs to prevent SQL injection
    $flight_id = intval($_POST['flight_id']);
    $seat_number = $conn->real_escape_string($_POST['seat_number']);



    // Check if the seat is already locked or booked
    $sql = "SELECT * FROM seat WHERE SeatNumber = '$seat_number' AND FlightID = '$flight_id' AND Status = 'free'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "Seat is already booked or locked.";
    } else {
        // Lock the seat for 10 minutes
        date_default_timezone_set('Asia/Kolkata');
        $lock_until = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $sql = "UPDATE seat SET Status = 'locked', LockUntil = '$lock_until' WHERE SeatNumber = '$seat_number' AND FlightID = '$flight_id   '";
        if ($conn->query($sql) === TRUE) {
            echo "Seat locked successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Invalid request method.";
}

// Redirect back to the seat layout or another appropriate page
header("Location: index.php");
exit();
