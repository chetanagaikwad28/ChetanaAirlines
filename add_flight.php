<?php
// Include necessary files
include('includes/db.php');
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['is_admin'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flightNumber = $_POST['flight_number'];
    $departureLocation = $_POST['departure_location'];
    $arrivalLocation = $_POST['arrival_location'];
    $departureTime = $_POST['departure_time'];
    $arrivalTime = $_POST['arrival_time'];

    $query = "INSERT INTO flight (FlightNumber, DepartureLocation, ArrivalLocation, DepartureTime, ArrivalTime) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $flightNumber, $departureLocation, $arrivalLocation, $departureTime, $arrivalTime);

    if ($stmt->execute()) {
        $successMessage = "Flight added successfully.";
    } else {
        $errorMessage = "Error adding flight. Please try again.";
    }

    $stmt->close();
}

// Include header
include('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <h2>Add Flight</h2>
        <?php if (isset($successMessage)) : ?>
            <div class="alert alert-success">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="add_flight.php">
            <div class="mb-3">
                <label for="flight_number" class="form-label">Flight Number</label>
                <input type="text" class="form-control" id="flight_number" name="flight_number" required>
            </div>
            <div class="mb-3">
                <label for="departure_location" class="form-label">Departure Location</label>
                <input type="text" class="form-control" id="departure_location" name="departure_location" required>
            </div>
            <div class="mb-3">
                <label for="arrival_location" class="form-label">Arrival Location</label>
                <input type="text" class="form-control" id="arrival_location" name="arrival_location" required>
            </div>
            <div class="mb-3">
                <label for="departure_time" class="form-label">Departure Time</label>
                <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" required>
            </div>
            <div class="mb-3">
                <label for="arrival_time" class="form-label">Arrival Time</label>
                <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Flight</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>