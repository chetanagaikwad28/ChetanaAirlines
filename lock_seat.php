<?php
include('includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flight_id = $_POST['flight_id'];
    $seat_number = $_POST['seat_number'];

    // Fetch PlaneID from the flight table
    $sql = "SELECT PlaneID FROM flight WHERE FlightID = '$flight_id'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "Flight not found.";
        exit();
    }
    $flight = $result->fetch_assoc();
    $plane_id = $flight['PlaneID'];

    // Check if the seat is already locked or booked
    $sql = "SELECT * FROM seat WHERE SeatNumber = '$seat_number' AND PlaneID = '$plane_id' AND Status = 'free'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "Seat is already booked or locked.";
    } else {
        // Lock the seat for 10 minutes
        date_default_timezone_set('Asia/Kolkata');
        $lock_until = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $sql = "UPDATE seat SET Status = 'locked', LockUntil = '$lock_until' WHERE SeatNumber = '$seat_number' AND PlaneID = '$plane_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Seat locked successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
