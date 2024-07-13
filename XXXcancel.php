<?php
include('includes/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];

    $sql = "SELECT booking_date FROM bookings WHERE id = '$booking_id' AND user_id = '$user_id'";
    $result = $conn->query($sql);
    $booking = $result->fetch_assoc();

    $current_time = date('Y-m-d H:i:s');
    $booking_time = $booking['booking_date'];

    // Check if the booking is within 72 hours
    if (strtotime($current_time) - strtotime($booking_time) <= 72 * 60 * 60) {
        echo "You cannot cancel the booking within 72 hours of departure.";
    } else {
        $sql = "DELETE FROM bookings WHERE id = '$booking_id' AND user_id = '$user_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Booking cancelled successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$sql = "SELECT * FROM bookings WHERE user_id = '$user_id'";
$result = $conn->query($sql);
include('includes/header.php');
?>

<main>
    <h2>Cancel Booking</h2>
    <table>
        <tr>
            <th>Flight Number</th>
            <th>Seat Number</th>
            <th>Booking Date</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['flight_id']; ?></td>
            <td><?php echo $row['seat_number']; ?></td>
            <td><?php echo $row['booking_date']; ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Cancel</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>

</body>
</html>
