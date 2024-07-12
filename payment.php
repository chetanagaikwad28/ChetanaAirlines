<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background: url('https://unsplash.com/photos/eICUFSeirc0/download?force=true&w=1920') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-group input,
        .form-group select {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 10px;
            box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.1), inset -5px -5px 10px rgba(255, 255, 255, 0.5);
            padding: 10px;
            width: 100%;
            margin-top: 5px;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 10px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1), -5px -5px 10px rgba(255, 255, 255, 0.5);
            padding: 10px 20px;
            color: #333;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .special-assistance a {
            color: #1e3c72;
            font-size: 0.9em;
            text-decoration: none;
        }

        .special-assistance a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h4 class="text-center">Flight Booking Form</h4>

            <?php
            // Include database connection
            include('includes/db.php');

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Retrieve form data from booking.php
                $paymentMethod = $_POST['paymentMethod'];

                // Validate and process payment (simulate payment here)
                $paymentStatus = 'paid'; // Replace with actual payment processing logic

                if ($paymentStatus === 'paid') {
                    $passengerData = [];
                    $totalAmount = 0;

                    // Fetch flight details and fare from flight table
                    $flightId = $_POST['flight_id']; // Assuming flight_id is passed from booking.php
                    $fetchFlightQuery = "SELECT Fare FROM flight WHERE FlightID = ?";
                    $stmtFlight = $conn->prepare($fetchFlightQuery);
                    $stmtFlight->bind_param("i", $flightId);
                    $stmtFlight->execute();
                    $stmtFlight->bind_result($fare);

                    if ($stmtFlight->fetch()) {
                        $stmtFlight->close();

                        // Loop through submitted passenger data
                        for ($i = 1; isset($_POST["name$i"]); $i++) {
                            $name = filter_var($_POST["name$i"], FILTER_SANITIZE_STRING);
                            $ageGroup = $_POST["ageGroup$i"];
                            $age = filter_var($_POST["age$i"], FILTER_VALIDATE_INT);
                            $email = filter_var($_POST["email$i"], FILTER_VALIDATE_EMAIL);
                            $phone = filter_var($_POST["phone$i"], FILTER_SANITIZE_STRING);
                            $mealPreference = $_POST["mealPreference$i"];
                            $seatNumber = $_POST["seatNumber$i"];

                            // Example validation (you should implement proper validation)
                            if (!$name || !$age || !$email || !$phone) {
                                die("Error: All fields are required.");
                            }

                            // Calculate seat number based on age
                            // if ($age >= 0 && $age <= 2) {
                            //     $seatNumber = "A" . $i; // Example seat assignment for infants
                            // } elseif ($age >= 3 && $age <= 12) {
                            //     $seatNumber = "C" . $i; // Example seat assignment for children
                            // } else {
                            //     $seatNumber = "A" . $i; // Example seat assignment for adults
                            // }

                            // Apply discount for child passengers
                            $discount = 0;
                            if ($ageGroup === 'child') {
                                $discount = 0.15; // 15% discount for child passengers
                            }

                            // Calculate passenger fare with discount
                            $passengerFare = $fare * (1 - $discount);

                            // Prepare data to insert into database
                            $passengerData[] = [
                                'name' => $name,
                                'ageGroup' => $ageGroup,
                                'age' => $age,
                                'seatNumber' => $seatNumber,
                                'email' => $email,
                                'phone' => $phone,
                                'mealPreference' => $mealPreference,
                                'fare' => $passengerFare
                            ];

                            if ($age <= 12) {
                                $passengerFare = 0.85 * $passengerFare;
                            }

                            // Accumulate total amount
                            $totalAmount += $passengerFare;
                        }

                        // Display total amount to user
                        echo "<div class='text-center mb-3'>Total Amount: $" . number_format($totalAmount, 2) . "</div>";

                        // Insert data into database
                        foreach ($passengerData as $passenger) {
                            // Insert passenger data into `passenger` table
                            $insertPassengerQuery = "INSERT INTO passenger (UserID, Name, Age, AgeGroup, SeatNumber, Email, PhoneNumber, MealPreference)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                            $stmtPassenger = $conn->prepare($insertPassengerQuery);
                            $stmtPassenger->bind_param(
                                "isisssss",
                                $userID,
                                $passenger['name'],
                                $passenger['age'],
                                $passenger['ageGroup'],
                                $passenger['seatNumber'],
                                $passenger['email'],
                                $passenger['phone'],
                                $passenger['mealPreference']
                            );

                            // Set $userID appropriately based on your application's logic
                            $userID = 1; // Example value, replace with actual user ID

                            if ($stmtPassenger->execute()) {
                                // Insert booking data into `booking` table
                                $fetchSeatQuery = "SELECT SeatID FROM seat WHERE SeatNumber = ? AND FlightID = ?";
                                $stmtSeat = $conn->prepare($fetchSeatQuery);
                                $stmtSeat->bind_param("si", $passenger['seatNumber'], $flightId);
                                $stmtSeat->execute();
                                $stmtSeat->bind_result($seatId);

                                if ($stmtSeat->fetch()) {
                                    $stmtSeat->close();

                                    $insertBookingQuery = "INSERT INTO booking (UserID, FlightID, SeatID, PassengerID, BookingTime)
                                                        VALUES (?, ?, ?, LAST_INSERT_ID(), CURRENT_TIMESTAMP())";
                                    $stmtBooking = $conn->prepare($insertBookingQuery);
                                    $stmtBooking->bind_param("iii", $userID, $flightId, $seatId);

                                    if ($stmtBooking->execute()) {
                                        echo "<div class='alert alert-success mt-2' role='alert'>Booking successful for passenger: " . $passenger['name'] . "</div>";
                                    } else {
                                        echo "<div class='alert alert-danger mt-2' role='alert'>Error inserting booking: " . $stmtBooking->error . "</div>";
                                    }

                                    $stmtBooking->close();
                                } else {
                                    echo "<div class='alert alert-danger mt-2' role='alert'>Error fetching seat information for seat number: " . $passenger['seatNumber'] . "</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger mt-2' role='alert'>Error inserting passenger: " . $stmtPassenger->error . "</div>";
                            }

                            $stmtPassenger->close();
                        }
                    } else {
                        echo "<div class='alert alert-danger mt-2' role='alert'>Error fetching flight details.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger mt-2' role='alert'>Payment failed. Please try again.</div>";
                }
            } else {
                echo "<div class='alert alert-danger mt-2' role='alert'>Invalid request method.</div>";
            }

            $conn->close();
            ?>

            <div class="text-center">
                <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>