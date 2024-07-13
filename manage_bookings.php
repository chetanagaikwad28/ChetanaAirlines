<?php
include('includes/db.php');
session_start();

// Check if user is logged in and retrieve user ID from session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

// Retrieve bookings for the logged-in user
$sql = "SELECT b.BookingID, f.FlightID, f.FlightNumber, f.DepartureTime, f.ArrivalTime, f.DepartureLocation, f.ArrivalLocation, p.Name AS PassengerName, p.SeatNumber, p.MealPreference, b.status
        FROM booking b
        LEFT JOIN passenger p ON b.PassengerID = p.PassengerID
        LEFT JOIN flight f ON b.FlightID = f.FlightID
        WHERE b.UserID = ?
        ORDER BY b.BookingTime DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

// include('includes/header.php'); // Include your header file
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<main>
    <div class="container mt-5">
        <h2>Your Bookings</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Flight Number</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Passenger</th>
                        <th>Seat Number</th>
                        <th>Meal Preference</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['BookingID']; ?></td>
                            <td><?php echo $row['FlightNumber']; ?></td>
                            <td><?php echo $row['DepartureLocation'] . ' - ' . $row['DepartureTime']; ?></td>
                            <td><?php echo $row['ArrivalLocation'] . ' - ' . $row['ArrivalTime']; ?></td>
                            <td><?php echo $row['PassengerName']; ?></td>
                            <td><?php echo $row['SeatNumber']; ?></td>
                            <td><?php echo $row['MealPreference']; ?></td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- <?php include('includes/footer.php'); // Include your footer file  -->
        ?>