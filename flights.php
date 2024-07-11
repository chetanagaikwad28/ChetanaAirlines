<?php
include('includes/db.php');
session_start();

$sql = "SELECT * FROM flight";
$result = $conn->query($sql);
include('includes/header.php');
?>

<main>
    <h2>Available Flights</h2>
    <table>
        <tr>
            <th>Flight Number</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['FlightNumber']; ?></td>
                <td><?php echo $row['DepartureTime']; ?></td>
                <td><?php echo $row['ArrivalTime']; ?></td>
                <td><?php echo $row['DepartureLocation']; ?></td>
                <td><?php echo $row['ArrivalLocation']; ?></td>
                <?php
                if (!isset($_SESSION['user_id'])) {
                ?>
                    <td>
                        <form method="POST" action="seat/seat.php">
                            <input type="hidden" name="flight_id" value="<?php echo $row['FlightID']; ?>">
                            <button type="submit">View Seats</button>
                        </form>
                    </td>
                <?php
                } else {
                ?>
                    <td><a href="book.php?flight_id=<?php echo $row['FlightID']; ?>">Book</a></td>
                <?php
                }
                ?>
            </tr>
        <?php endwhile; ?>
    </table>
</main>

</body>

</html>