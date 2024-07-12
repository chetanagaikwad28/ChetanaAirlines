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
            <form id="booking-form" method="POST" action="payment.php">
                <div id="passenger-fields"></div>
                <!-- Hidden input field for flight_id -->
                <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($_POST['flight_id']); ?>">

                <div class="form-group mt-3">
                    <label for="paymentMethod">Payment Method</label>
                    <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                        <option value="">Select Payment Method</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Proceed to Payment</button>
            </form>
        </div>
    </div>

    <?php echo json_encode($_POST['flight_id']); ?>;
    <script>
        // Retrieve the flight ID and selected seats from PHP
        const flightId = <?php echo json_encode($_POST['flight_id']); ?>;
        const selectedSeats = <?php echo json_encode($_POST['seat_numbers']); ?>;

        let passengerCount = 0;

        // Function to create a new passenger form
        function createPassengerForm(seatNumber) {
            passengerCount++;
            return `
                <div class="passenger-form">
                    <h5>Passenger ${passengerCount}</h5>
                    <div class="form-group row align-items-center mt-3">
                        <div class="col-md-3">
                            <label for="name${passengerCount}" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name${passengerCount}" name="name${passengerCount}" placeholder="Enter name" required>
                        </div>
                        <div class="col-md-2">
                            <label for="ageGroup${passengerCount}" class="form-label">Age Group</label>
                            <select class="form-select" id="ageGroup${passengerCount}" name="ageGroup${passengerCount}" required>
                                <option value="adult">Adult (12+ years)</option>
                                <option value="senior">Senior Citizen (60+ years)</option>
                                <option value="child">Child (2-12 years)</option>
                                <option value="infant">Infant (0-2 years)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="age${passengerCount}" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age${passengerCount}" name="age${passengerCount}" placeholder="Enter age" required>
                        </div>
                        <div class="col-md-3">
                            <label for="seatNumber${passengerCount}" class="form-label">Seat Number</label>
                            <input type="text" class="form-control" id="seatNumber${passengerCount}" name="seatNumber${passengerCount}" value="${seatNumber}" placeholder="Enter seat number" required readonly>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mt-3">
                        <div class="col-md-4">
                            <label for="email${passengerCount}" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email${passengerCount}" name="email${passengerCount}" placeholder="Enter email" required>
                        </div>
                        <div class="col-md-4">
                            <label for="phone${passengerCount}" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone${passengerCount}" name="phone${passengerCount}" placeholder="Enter phone number" required>
                        </div>
                        <div class="col-md-4">
                            <label for="mealPreference${passengerCount}" class="form-label">Meal Preference</label>
                            <select class="form-select" id="mealPreference${passengerCount}" name="mealPreference${passengerCount}">
                                <option value="none">None</option>
                                <option value="veg">Vegetarian</option>
                                <option value="non-veg">Non-Vegetarian</option>
                                <option value="vegan">Vegan</option>
                                <option value="kosher">Kosher</option>
                                <option value="halal">Halal</option>
                            </select>
                        </div>
                    </div>
                </div>`;
        }

        // Generate passenger forms for each selected seat
        window.onload = function() {
            const passengerFields = document.getElementById('passenger-fields');
            selectedSeats.forEach(seat => {
                passengerFields.insertAdjacentHTML('beforeend', createPassengerForm(seat));
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>