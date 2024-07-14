<?php
// Include database connection
include('includes/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve payment method and other necessary details from POST data
    $paymentMethod = $_POST['payment_method'];
    $flightId = $_POST['flight_id']; // Assuming flight_id is passed from payment.php
    $userId = $_SESSION['user_id']; // Assuming user_id is passed from payment.php

    // Check if payment was successful
    $paymentStatus = 'paid'; // Replace with actual payment processing logic

    if ($paymentStatus === 'paid') {
        // Prepare statement for inserting passenger details into the database
        $insertPassengerQuery = "INSERT INTO passenger (UserID, Name, Age, AgeGroup, SeatNumber, Email, PhoneNumber, MealPreference) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtPassenger = $conn->prepare($insertPassengerQuery);

        // Prepare statement for inserting booking details into the database
        $insertBookingQuery = "INSERT INTO booking (UserID, FlightID, PassengerID) VALUES (?, ?, ?)";
        $stmtBooking = $conn->prepare($insertBookingQuery);

        // Loop through submitted passenger data
        for ($i = 1; isset($_POST["name$i"]); $i++) {
            $name = filter_var($_POST["name$i"], FILTER_SANITIZE_STRING);
            $ageGroup = $_POST["ageGroup$i"];
            $age = filter_var($_POST["age$i"], FILTER_VALIDATE_INT);
            $email = filter_var($_POST["email$i"], FILTER_VALIDATE_EMAIL);
            $phone = filter_var($_POST["phone$i"], FILTER_SANITIZE_STRING);
            $mealPreference = $_POST["mealPreference$i"];
            $seatNumber = $_POST["seatNumber$i"];

            // Bind parameters and execute statement to insert passenger
            $stmtPassenger->bind_param("isisssss", $userId, $name, $age, $ageGroup, $seatNumber, $email, $phone, $mealPreference);
            $stmtPassenger->execute();

            // Get the last inserted PassengerID
            $passengerId = $stmtPassenger->insert_id;

            // Bind parameters and execute statement to insert booking
            $stmtBooking->bind_param("iii", $userId, $flightId, $passengerId);
            $stmtBooking->execute();
        }

        // Close the statements
        $stmtPassenger->close();
        $stmtBooking->close();

        // Display a success message
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Payment Success</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #e0f7fa;
                }
        
                .card {
                    border: none;
                    border-radius: 15px;
                    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                    background: rgba(255, 255, 255, 0.9);
                    padding: 20px;
                    text-align: center;
                    animation: popUp 0.5s ease forwards;
                }
        
                .celebrate-icon {
                    font-size: 4rem;
                    color: #28a745;
                }
        
                @keyframes popUp {
                    0% {
                        transform: scale(0);
                    }
        
                    100% {
                        transform: scale(1);
                    }
                }
            </style>
        </head>
        
        <body>
            <div class='card'>
                <div class='card-body'>
                    <div class='celebrate-icon'>🎉</div>
                    <h3 class='card-title'>Payment Successful!</h3>
                    <p class='card-text'>Thank you for your payment. Your booking has been successfully processed.</p>
                    <a href='index.php' class='btn btn-primary mt-3'>Back to Home</a>
                </div>
            </div>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
        </body>
        
        </html>
        ";

        // Redirect to confirmation or success page after a short delay
        header("refresh:3;url=index.php");
    } else {
        echo "<div class='alert alert-danger mt-2' role='alert'>Payment failed. Please try again.</div>";
    }
} else {
    echo "<div class='alert alert-danger mt-2' role='alert'>Invalid request method.</div>";
}

// Close the database connection
$conn->close();
