<?php
// Include necessary files
include('includes/db.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Function to get user's bookings
function getUserBookings($conn, $userID)
{
    $bookings = array();

    $query = "SELECT b.BookingID, f.FlightNumber, f.DepartureLocation, f.DepartureTime, s.SeatNumber, p.Name, b.BookingTime, b.status
              FROM booking b
              INNER JOIN flight f ON b.FlightID = f.FlightID
              INNER JOIN seat s ON b.SeatID = s.SeatID
              INNER JOIN passenger p ON b.PassengerID = p.PassengerID
              WHERE b.UserID = ?
              ORDER BY b.BookingTime DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }

    $stmt->close();

    return $bookings;
}

// Check if there's a cancellation request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $bookingID = $_POST['booking_id'];

    // Query to cancel the booking
    $cancelBookingQuery = "UPDATE booking SET status = 'cancelled' WHERE BookingID = ?";
    $stmt = $conn->prepare($cancelBookingQuery);
    $stmt->bind_param("i", $bookingID);

    if ($stmt->execute()) {
        $_SESSION['cancel_success'] = "Booking cancelled successfully.";
    } else {
        $_SESSION['cancel_error'] = "Error cancelling booking. Please try again.";
    }

    $stmt->close();

    // Redirect to avoid resubmission of form
    header("Location: cancel_booking.php");
    exit();
}

// Fetch user's bookings
$userID = $_SESSION['user_id'];
$bookings = getUserBookings($conn, $userID);

// Include header
include('includes/header.php');
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


<main class="container mt-4">
    <h2>Your Bookings</h2>
    <?php if (empty($bookings)) : ?>
        <p class="text-muted">You have no bookings to display.</p>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Flight Number</th>
                        <th>Departure Location</th>
                        <th>Departure Time</th>
                        <th>Passenger Name</th>
                        <th>Seat Number</th>
                        <th>Booking Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking) : ?>
                        <tr>
                            <td><?php echo $booking['FlightNumber']; ?></td>
                            <td><?php echo $booking['DepartureLocation']; ?></td>
                            <td><?php echo $booking['DepartureTime']; ?></td>
                            <td><?php echo $booking['Name']; ?></td>
                            <td><?php echo $booking['SeatNumber']; ?></td>
                            <td><?php echo $booking['BookingTime']; ?></td>
                            <td><?php echo ucfirst($booking['status']); ?></td>
                            <td>
                                <?php if ($booking['status'] == 'booked') : ?>
                                    <form method="POST" action="cancel_booking.php">
                                        <input type="hidden" name="booking_id" value="<?php echo $booking['BookingID']; ?>">
                                        <button type="submit" class="btn btn-danger">Cancel Booking</button>
                                    </form>
                                <?php else : ?>
                                    <p class="text-muted">Cancelled</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>