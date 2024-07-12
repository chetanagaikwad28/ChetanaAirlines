<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Options</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-size: cover;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e0f7fa;
            /* Light blue background */
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .header-bar {
            background-color: #0056b3;
            padding: 10px;
            color: #fff;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin-bottom: 20px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
        }

        .payment-option img {
            width: 30px;
            margin-right: 10px;
        }

        .payment-option input {
            margin-right: 10px;
        }

        .payment-option label {
            margin: 0;
            font-weight: bold;
            color: #007bff;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-bar">
            <h4>Payment Options</h4>
        </div>

        <?php
        // Include database connection
        include('includes/db.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

                        if (!$name || !$age || !$email || !$phone) {
                            die("Error: All fields are required.");
                        }

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

                        $totalAmount += $passengerFare;
                    }

                    echo "<h5>Amount Payable: ₹" . number_format($totalAmount, 2) . "</h5>";
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

<<<<<<< HEAD
        <div class="payment-option">
            <img src="images/upi-icon.png" alt="UPI">
            <label for="upi">UPI</label>
        </div>
        <div class="payment-option">
            <img src="images/debit-card-credit.png" alt="Credit Card">
            <label for="credit-card">Credit/Debit Card</label>
        </div>
        <div class="payment-option">
            <img src="images/gift voucher.png" alt="Gift Voucher">
            <label for="gift-voucher">Gift Voucher</label>
        </div>
        <div class="payment-option">
            <img src="images/Net Banking.png" alt="Net Banking">
            <label for="net-banking">Net Banking</label>
        </div>
=======
        <form action="finalize_payment.php" method="post">
            <!-- Payment Options -->
            <div class="payment-option">
                <input type="radio" name="payment_method" id="upi" value="UPI" required>
                <img src="upi.png" alt="UPI">
                <label for="upi">UPI</label>
            </div>
            <div class="payment-option">
                <input type="radio" name="payment_method" id="credit-card" value="Credit/Debit Card" required>
                <img src="credit-card.png" alt="Credit Card">
                <label for="credit-card">Credit/Debit Card</label>
            </div>
            <div class="payment-option">
                <input type="radio" name="payment_method" id="gift-voucher" value="Gift Voucher" required>
                <img src="gift-voucher.png" alt="Gift Voucher">
                <label for="gift-voucher">Gift Voucher</label>
            </div>
            <div class="payment-option">
                <input type="radio" name="payment_method" id="net-banking" value="Net Banking" required>
                <img src="net-banking.png" alt="Net Banking">
                <label for="net-banking">Net Banking</label>
            </div>

            <!-- Hidden fields to pass necessary data -->
            <?php
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $subKey => $subValue) {
                        echo "<input type='hidden' name='{$key}[$subKey]' value='" . htmlspecialchars($subValue) . "'>";
                    }
                } else {
                    echo "<input type='hidden' name='$key' value='" . htmlspecialchars($value) . "'>";
                }
            }
            ?>

            <div class="text-center">
                <button type="submit" class="btn btn-success mt-3">Pay Now</button>
            </div>
        </form>
>>>>>>> bb114eaace4d45f191f0958620feadb4fa780f61

        <div class="text-center">
            <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>