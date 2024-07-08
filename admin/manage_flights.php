<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flight_number = $_POST['flight_number'];
    $departure = $_POST['departure'];
    $arrival = $_POST['arrival'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $seats = $_POST['seats'];

    $sql = "INSERT INTO flights (flight_number, departure, arrival, origin, destination, seats) VALUES ('$flight_number', '$departure', '$arrival', '$origin', '$destination', '$seats')";
    if ($conn->query($sql) === TRUE) {
        echo "Flight added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM flights";
$result = $conn->query($sql);
include('../includes/header.php');
?>

<main>
    <h2>Manage Flights</h2>
    <form method="POST" action="">
        <label>Flight Number:</label>
        <input type="text" name="flight_number" required>
        <label>Departure:</label>
        <input type="datetime-local" name="departure" required>
        <label>Arrival:</label>
        <input type="datetime-local" name="arrival" required>
        <label>Origin:</label>
        <input type="text" name="origin" required>
        <label>Destination:</label>
        <input type="text" name="destination" required>
        <label>Seats:</label>
        <input type="number" name="seats" required>
        <button type="submit">Add Flight</button>
    </form>
    <table>
        <tr>
            <th>Flight Number</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Seats</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['flight_number']; ?></td>
            <td><?php echo $row['departure']; ?></td>
            <td><?php echo $row['arrival']; ?></td>
            <td><?php echo $row['origin']; ?></td>
            <td><?php echo $row['destination']; ?></td>
            <td><?php echo $row['seats']; ?></td>
            <td><a href="manage_seats.php?flight_id=<?php echo $row['id']; ?>">Manage Seats</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>

</body>
</html>
