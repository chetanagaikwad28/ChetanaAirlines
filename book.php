<?php
include('includes/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$flight_id = $_GET['flight_id'];
$user_id = $_SESSION['user_id'];
$is_admin = $_SESSION['is_admin'];

// Function to release seats that have been locked for more than 10 minutes
function release_locked_seats($conn)
{
    $current_time = date('Y-m-d H:i:s');
    $sql = "UPDATE seat SET Status = 'free', LockUntil = NULL WHERE Status = 'locked' AND LockUntil < '$current_time'";
    $conn->query($sql);
}

// Call the function to release locked seats
release_locked_seats($conn);

// Fetch PlaneID from the flight table
$sql = "SELECT PlaneID FROM flight WHERE FlightID = '$flight_id'";
$result = $conn->query($sql);
$flight = $result->fetch_assoc();
$plane_id = $flight['PlaneID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seat_number = $_POST['seat_number'];
    $booking_date = date('Y-m-d H:i:s');

    // Check if the user is booking more than 6 tickets
    $sql = "SELECT COUNT(*) AS count FROM booking WHERE UserID = '$user_id' AND FlightID = '$flight_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row['count'] >= 6) {
        echo "You cannot book more than 6 tickets.";
    } else {
        // Check if the seat is already locked or booked
        $sql = "SELECT * FROM seat WHERE SeatNumber = '$seat_number' AND PlaneID = '$plane_id' AND Status = 'free'";
        $result = $conn->query($sql);
        // Call the function to release locked seats
        release_locked_seats($conn);
        if ($result->num_rows == 0) {
            echo "Seat is already booked or locked.";
        } else {
            // Call the function to release locked seats
            release_locked_seats($conn);
            // Lock the seat for 10 minutes
            $lock_until = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $sql = "UPDATE seat SET Status = 'locked', LockUntil = '$lock_until' WHERE SeatNumber = '$seat_number' AND PlaneID = '$plane_id'";
            if ($conn->query($sql) === TRUE) {
                // Insert the booking into the database
                $sql = "INSERT INTO booking (UserID, FlightID, SeatID, BookingTime) VALUES ('$user_id', '$flight_id', (SELECT SeatID FROM seat WHERE SeatNumber = '$seat_number' AND PlaneID = '$plane_id'), '$booking_date')";
                if ($conn->query($sql) === TRUE) {
                    // Confirm the booking by setting the seat status to booked
                    $sql = "UPDATE seat SET Status = 'booked', LockUntil = NULL WHERE SeatNumber = '$seat_number' AND PlaneID = '$plane_id'";
                    $conn->query($sql);
                    echo "Booking successful.";
                    // Call the function to release locked seats
                    release_locked_seats($conn);
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

include('includes/header.php');
?>

<main>
    <h2>Book Flight: <?php echo $flight_id; ?></h2>
    <form method="POST" action="">
        <label>Seat Number:</label>
        <input type="text" name="seat_number" required>
        <button type="submit">Book</button>
    </form>

    <?php if ($is_admin) : ?>
        <h2>Admin Actions</h2>
        <form method="POST" action="admin_actions.php">
            <label>Action:</label>
            <select name="action" required>
                <option value="add">Add Ticket</option>
                <option value="delete">Delete Ticket</option>
                <option value="modify">Modify Ticket</option>
            </select><br>
            <label>Flight ID:</label>
            <input type="text" name="flight_id" required><br>
            <label>Details:</label>
            <input type="text" name="details" required><br>
            <button type="submit">Submit</button>
        </form>
    <?php endif; ?>
</main>

</body>

</html>