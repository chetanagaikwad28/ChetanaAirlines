<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .form-container {
            max-width: 700px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .special-assistance a {
            display: block;
            margin-top: 10px;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h4 class="text-center">Flight Booking Form</h4>
            <form>
                <div id="passenger-fields">
                    <div class="form-group row align-items-center">
                        <div class="col-md-3">
                            <label for="name1" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name1" name="name1" placeholder="Enter name" required>
                        </div>
                        <div class="col-md-2">
                            <label for="ageGroup1" class="form-label">Age Group</label>
                            <select class="form-select" id="ageGroup1" name="ageGroup1" required>
                                <option value="adult">Adult (12+ years)</option>
                                <option value="senior">Senior Citizen (60+ years)</option>
                                <option value="child">Child (2-12 years)</option>
                                <option value="infant">Infant (0-2 years)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="age1" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age1" name="age1" placeholder="Enter age" required>
                        </div>
                        <div class="col-md-3">
                            <label for="seatNumber1" class="form-label">Seat Number</label>
                            <input type="text" class="form-control" id="seatNumber1" name="seatNumber1" placeholder="Enter seat number" required>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mt-3">
                        <div class="col-md-4">
                            <label for="email1" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email1" name="email1" placeholder="Enter email" required>
                        </div>
                        <div class="col-md-4">
                            <label for="phone1" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone1" name="phone1" placeholder="Enter phone number" required>
                        </div>
                        <div class="col-md-4">
                            <label for="mealPreference1" class="form-label">Meal Preference</label>
                            <select class="form-select" id="mealPreference1" name="mealPreference1">
                                <option value="none">None</option>
                                <option value="veg">Vegetarian</option>
                                <option value="non-veg">Non-Vegetarian</option>
                                <option value="vegan">Vegan</option>
                                <option value="kosher">Kosher</option>
                                <option value="halal">Halal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary mt-3" onclick="addPassenger()">Add Another
                    Passenger</button>
                <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
            </form>
            <div class="special-assistance mt-3">
                <a href="#">Need Special Assistance?</a>
                <a href="#">Need help with 9+ travelers? Click Here</a>
            </div>
        </div>
    </div>

    <script>
        let passengerCount = 1;

        function addPassenger() {
            passengerCount++;
            const passengerFields = document.getElementById('passenger-fields');
            const newPassengerField = `
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
                        <input type="text" class="form-control" id="seatNumber${passengerCount}" name="seatNumber${passengerCount}" placeholder="Enter seat number" required>
                    </div>
                </div>
                <div class="form-group row align-items-center mt-3">
                    <div class="col-md-4">
                        <label for="email${passengerCount}" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email${passengerCount}" name="email${passengerCount}" placeholder="Enter email" >
                    </div>
                    <div class="col-md-4">
                        <label for="phone${passengerCount}" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone${passengerCount}" name="phone${passengerCount}" placeholder="Enter phone number" >
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
                </div>`;
            passengerFields.insertAdjacentHTML('beforeend', newPassengerField);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>