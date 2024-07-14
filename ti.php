<?php
// Include database connection
include('includes/db.php');

// Function to generate random date time within a range
function randomDateTime($start, $end)
{
    $randomTimestamp = mt_rand(strtotime($start), strtotime($end));
    return date("Y-m-d H:i:s", $randomTimestamp);
}

// Fetch flights from the flight table
$sqlFlights = "SELECT * FROM `flight`";
$resultFlights = $conn->query($sqlFlights);

// Check if there are any flights returned
if ($resultFlights->num_rows > 0) {
    while ($flight = $resultFlights->fetch_assoc()) {
        $FlightID = $flight['FlightID'];
        $PlaneID = $flight['PlaneID'];
        $FlightNumber = $flight['FlightNumber'];
        $DepartureTime = $flight['DepartureTime'];
        $ArrivalTime = $flight['ArrivalTime'];
        $DepartureLocation = $flight['DepartureLocation'];
        $ArrivalLocation = $flight['ArrivalLocation'];
        $fare = $flight['fare'];
        $DurationTime = $flight['Duration Time'];
        $CabinClass = $flight['CabinClass'];

        // Insert seats for each flight into the seat table
        $sqlSeats = "INSERT INTO `seat` (`FlightID`, `SeatNumber`, `Status`, `IsFireExit`) VALUES ";

        // Number of total rows and columns for seat arrangement
        $rows = 6; // A to E rows
        $columns = 10; // 1 to 10 columns

        // Insert seats for each row and column
        for ($col = 1; $col <= $columns; $col++) {
            for ($row = 1; $row <= $rows; $row++) {
                // Generate seat number (e.g., 1A, 1B, ..., 1E, 2A, 2B, ..., 2E, ..., 10E)
                $seatNumber = $col . chr(64 + $row);

                // Determine if this seat is a fire exit seat
                $isFireExit = ($row == $rows && $col <= 6) ? '1' : '0'; // Last row (E) has fire exit seats (1 to 6)

                // Append values to the SQL query
                $sqlSeats .= "('$FlightID', '$seatNumber', 'free', '$isFireExit'),";
            }
        }

        // Remove the last comma
        $sqlSeats = rtrim($sqlSeats, ",");

        // Execute the SQL query to insert seats
        if ($conn->query($sqlSeats) === TRUE) {
            echo "Seats inserted successfully for FlightID: $FlightID<br>";
        } else {
            echo "Error inserting seats for FlightID: $FlightID - " . $conn->error . "<br>";
        }
    }
} else {
    echo "No flights found.";
}

// Close connection
$conn->close();
