<?php
include('includes/db.php');
session_start();
// if (!empty($_SESSION)) {
//     // Loop through each session variable and print the key-value pairs
//     foreach ($_SESSION as $key => $value) {
//         echo "Key: " . htmlspecialchars($key) . " - Value: " . htmlspecialchars($value) . "<br>";
//     }
// }
// Retrieve the POST variables
$from = $_POST['from'];
$to = $_POST['to'];
$departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : null;

// Initial query with the date filter if provided
if ($departure_date) {
    $sql = "SELECT * FROM flight WHERE DepartureLocation = ? AND ArrivalLocation = ? AND DATE(DepartureTime) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $from, $to, $departure_date);
} else {
    $sql = "SELECT * FROM flight WHERE DepartureLocation = ? AND ArrivalLocation = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from, $to);
}

$stmt->execute();
$result = $stmt->get_result();

// Check if any flights are found
$suggestedFlights = [];
if ($result->num_rows == 0) {
    // If no flights are found, perform a new query without the date filter
    $sql = "SELECT * FROM flight WHERE (DepartureLocation = ? AND ArrivalLocation = ?) OR (DepartureLocation = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $from, $to, $from);
    $stmt->execute();
    $suggestedFlights = $stmt->get_result();
}

include('includes/header.php');
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="includes/style.css">
<main class="container mt-4">
    <h2 class="mb-4">Available Flights</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Flight Number</th>
                    <th>Departure Date</th>
                    <th>Departure Time</th>
                    <th>Arrival Date</th>
                    <th>Arrival Time</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['FlightNumber']; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($row['DepartureTime'])); ?></td>
                            <td><?php echo date("H:i", strtotime($row['DepartureTime'])); ?></td>
                            <td><?php echo date("d-m-Y", strtotime($row['ArrivalTime'])); ?></td>
                            <td><?php echo date("H:i", strtotime($row['ArrivalTime'])); ?></td>
                            <td><?php echo $row['DepartureLocation']; ?></td>
                            <td><?php echo $row['ArrivalLocation']; ?></td>
                            <?php if (!isset($_SESSION['user_id'])) : ?>
                                <td>
                                    <form method="POST" action="seat/seat.php">
                                        <input type="hidden" name="flight_id" value="<?php echo $row['FlightID']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">View Seats</button>
                                    </form>
                                </td>
                            <?php else : ?>
                                <td>
                                    <form method="POST" action="seat/seat.php">
                                        <input type="hidden" name="flight_id" value="<?php echo $row['FlightID']; ?>">
                                        <button type="submit" class="btn btn-success btn-sm">Book</button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">No flights found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($result->num_rows == 0 && $suggestedFlights->num_rows > 0) : ?>
        <h2 class="mt-5 mb-4">Suggested Flights</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Flight Number</th>
                        <th>Departure Date</th>
                        <th>Departure Time</th>
                        <th>Arrival Date</th>
                        <th>Arrival Time</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $suggestedFlights->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['FlightNumber']; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($row['DepartureTime'])); ?></td>
                            <td><?php echo date("H:i", strtotime($row['DepartureTime'])); ?></td>
                            <td><?php echo date("d-m-Y", strtotime($row['ArrivalTime'])); ?></td>
                            <td><?php echo date("H:i", strtotime($row['ArrivalTime'])); ?></td>
                            <td><?php echo $row['DepartureLocation']; ?></td>
                            <td><?php echo $row['ArrivalLocation']; ?></td>
                            <?php if (!isset($_SESSION['user_id'])) : ?>
                                <td>
                                    <form method="POST" action="seat/seat.php">
                                        <input type="hidden" name="flight_id" value="<?php echo $row['FlightID']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">View Seats</button>
                                    </form>
                                </td>
                            <?php else : ?>
                                <td>
                                    <form method="POST" action="seat/seat.php">
                                        <input type="hidden" name="flight_id" value="<?php echo $row['FlightID']; ?>">
                                        <button type="submit" class="btn btn-success btn-sm">Book</button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>