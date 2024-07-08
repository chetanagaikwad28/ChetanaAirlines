<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../index.php");
}

$flight_id = $_GET['flight_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seat_number = $_POST['seat_number'];

    $sql = "INSERT INTO seats (flight_id, seat_number) VALUES ('$flight_id', '$seat_number')";
    if ($conn->query($sql) === TRUE) {
        echo "Seat added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM seats WHERE flight_id = '$flight_id'";
$result = $conn->query($sql);
include('../includes/header.php');
?>

<main>
    <h2>Manage Seats for Flight ID: <?php echo $flight_id; ?></h2>
    <form method="POST" action="">
        <label>Seat Number:</label>
        <input type="text" name="seat_number" required>
        <button type="submit">Add Seat</button>
    </form>
    <table>
        <tr>
            <th>Seat Number</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['seat_number']; ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="seat_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete" value="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>

</body>
</html>
