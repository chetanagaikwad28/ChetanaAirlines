<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<?php
include('includes/db.php');
session_start();

include('includes/header.php');


// Check if user is logged in and retrieve user ID from session
if (!isset($_SESSION['user_id'])) {
    // header("Location: index.php");
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Login Required</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body {
                // display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #e0f7fa;
                margin: 0;
            }
            .card {
                max-width: 400px;
                border: none;
                border-radius: 10px;
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                background: rgba(255, 255, 255, 0.9);
                padding: 20px;
                text-align: center;
                animation: slideIn 0.5s ease forwards;
            }
            .warning-icon {
                font-size: 3rem;
                color: #dc3545;
            }
            @keyframes slideIn {
                0% {
                    transform: translateY(-50px);
                    opacity: 0;
                }
                100% {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        </style>
    </head>
    <body>
        <div class='card'>
            <div class='warning-icon mb-3'>⚠️</div>
            <h3 class='mb-3'>Login Required</h3>
            <p class='mb-3'>Please log in to access this feature.</p>
            <a href='login.php' class='btn btn-primary'>Log In</a>
        </div>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
    </body>
    </html>
    ";


    exit();
}

$userID = $_SESSION['user_id'];

// Retrieve bookings for the logged-in user
$sql = "SELECT b.BookingID, f.FlightID, f.FlightNumber, f.DepartureTime, f.ArrivalTime, f.DepartureLocation, f.ArrivalLocation, p.Name AS PassengerName, p.SeatNumber, p.MealPreference, b.status
        FROM booking b
        LEFT JOIN passenger p ON b.PassengerID = p.PassengerID
        LEFT JOIN flight f ON b.FlightID = f.FlightID
        WHERE b.UserID = ?
        ORDER BY b.BookingTime DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

// include('includes/header.php'); // Include your header file
?>

<main>
    <div class="container mt-5">
        <h2>Your Bookings</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Flight Number</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Passenger</th>
                        <th>Seat Number</th>
                        <th>Meal Preference</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['BookingID']; ?></td>
                            <td><?php echo $row['FlightNumber']; ?></td>
                            <td><?php echo $row['DepartureLocation'] . ' - ' . $row['DepartureTime']; ?></td>
                            <td><?php echo $row['ArrivalLocation'] . ' - ' . $row['ArrivalTime']; ?></td>
                            <td><?php echo $row['PassengerName']; ?></td>
                            <td><?php echo $row['SeatNumber']; ?></td>
                            <td><?php echo $row['MealPreference']; ?></td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- <?php include('includes/footer.php'); // Include your footer file  -->
        ?>