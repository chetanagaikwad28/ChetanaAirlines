<?php
session_start();
include('includes/header.php'); // Include your header file with necessary PHP logic

// Example array of flight offers (replace with actual dynamic fetching from DB or API)
$flightOffers = [
    [
        'id' => 1,
        'destination' => 'Tata Neu HDFC Bank Credit Cards',
        'description' => 'Book tickets with Tata Neu HDFC credit card and get NeuCoins.',
        'image' => 'images/Tata Neu.png'
    ],
    [
        'id' => 2,
        'destination' => 'Bajaj Pay UPI',
        'description' => 'Book your Air India flight tickets with Bajaj Pay UPI and receive 5% value back, up to INR 750.',
        'image' => 'images/Bajaj Pay UPI.png'
    ],
    [
        'id' => 3,
        'destination' => 'Children below 15',
        'description' => 'Get 25% off on flight booking tickets when you book with Airline India.',
        'image' => 'images/Children below 15.jpg'
    ],
    [
        'id' => 6,
        'destination' => 'Instant Discount Using ICICI Bank Cards',
        'description' => 'Book your flight tickets with ICICI Bank Credit or Debit Cards and get up to INR 2000 off.',
        'image' => 'images/ICICI Bank Cards.jpg'
    ],
];

// Example array of airline news (simplified)
$airlineNews = [
    [
        'image' => 'images/Archietecture.jpg',
        'alt' => 'New Look and Modern Architecture',
        'headline' => 'Low Cost Airline unveils a new look and modern architecture of its website.',
    ],
    [
        'image' => 'images/Direct Flights Announcement.jpg',
        'alt' => 'Direct Flights Announcement',
        'headline' => 'Low Cost Airline announces new direct flights between Mumbai and Vijayawada.',
    ],
    [
        'image' => 'images/New Route Announcementjpg.jpg',
        'alt' => 'New Route Announcement',
        'headline' => 'Low Cost Airline introduces direct flights between Bengaluru and Mumbai.',
    ],
    [
        'image' => 'images/Additional Flights Announcement.jpg',
        'alt' => 'Additional Flights Announcement',
        'headline' => 'Low Cost Airline adds more flights between Jaipur and Mumbai to meet passenger demand.',
    ],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="includes/style.css">
    <style>
        .why-choose-us img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .news-item {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
        }

        .offers-section .card {
            height: 100%;
        }

        .offers-section .card img {
            object-fit: contain;
            height: 200px;
        }
    </style>
</head>

<body>
    <main class="container mt-4">
        <div class="search-section bg-white p-4 rounded shadow-sm">
            <form id="booking-form" method="POST" action="flights.php"> <!-- Changed to 'flights.php' -->
                <div class="row align-items-center">
                    <div class="col-auto">
                        <label class="form-check-label me-3"><input type="radio" name="trip" value="one-way" checked> One Way</label>
                        <!-- <label class="form-check-label"><input type="radio" name="trip" value="round-trip"> Round Trip</label> -->
                    </div>
                    <div class="col-auto">
                        <span class="promo-code text-primary">Use promo code</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="from">From</label>
                        <select id="from" name="from" class="form-select" required>
                            <option value="" disabled selected>Choose...</option>
                            <?php
                            include('includes/db.php'); // Include your database connection file

                            $sql = "SELECT DISTINCT DepartureLocation FROM flight";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['DepartureLocation'] . "'>" . $row['DepartureLocation'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No locations found</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="to">To</label>
                        <select id="to" name="to" class="form-select" required>
                            <option value="" disabled selected>Choose...</option>
                            <?php
                            $sql = "SELECT DISTINCT ArrivalLocation FROM flight";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['ArrivalLocation'] . "'>" . $row['ArrivalLocation'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No locations found</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="departure_date">Departure Date</label>
                        <input type="date" id="departure_date" name="departure_date" class="form-control" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary w-100">Search Flight</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <button type="button" class="btn btn-outline-secondary w-100">Individual</button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-secondary w-100">Family & Friends</button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-secondary w-100">Unaccompanied Minor</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Why Choose Our Website Section -->
        <div class="why-choose-us mt-5 bg-light p-5 rounded shadow-sm">
            <h2>Why choose our airline</h2>
            <div class="row">
                <div class="col-md-6">
                    <p>Our Airline India gives the best offers and deals on flight bookings.
                        We ensure the highest standards of safety and comfort for our passengers.
                        24/7 customer support to assist you with all your travel needs. Easy booking
                        process and user-friendly website.
                        Exclusive discounts and rewards for frequent flyers.</p>
                </div>
                <div class="col-md-6">
                    <img src="images/Aeroplane.jpg" alt="Aeroplane" class="img-fluid rounded">
                </div>
            </div>
        </div>
        <div class="news-section mt-4">
            <h2>Low Cost Airline News</h2>
            <div class="news-container row">
                <?php foreach ($airlineNews as $news) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['alt']; ?>" class="img-fluid card-img-top fixed-image">
                            <div class="card-body d-flex flex-column">
                                <p class="card-title"><?php echo $news['headline']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>

        </style>


        <!-- Offers Section -->
        <div class="offers-section mt-4">
            <h2>Latest Flight Offers</h2>
            <div class="row">
                <?php foreach ($flightOffers as $offer) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo $offer['image']; ?>" alt="<?php echo $offer['destination']; ?>" class="card-img-top">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo $offer['destination']; ?></h5>
                                <p class="card-text"><?php echo $offer['description']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light text-dark py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>Get to Know Airline India</h5>
                    <ul class="list-unstyled">
                        <li>About us</li>
                        <li>Leadership Team</li>
                        <li>Investor Relations</li>
                        <li>Seat/Aircraft information</li>
                        <li>Career Opportunities</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Services</h5>
                    <ul class="list-unstyled">
                        <li>Plan B</li>
                        <li>Medical Assistance</li>
                        <li>Seat Select</li>
                        <li>Add-ons & Services</li>
                        <li>Baggage</li>
                        <li>Refund Claim</li>
                        <li>Charter Services</li>
                        <li>Hotels</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li>Offers</li>
                        <li>Advertise with us</li>
                        <li>Sitemap</li>
                        <li>Destinations</li>
                        <li>Blogs</li>
                        <li>Terms and Conditions</li>
                        <li>Conditions of Carriage</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><strong>Registered Office:</strong> Airline India, ABC Street, XYZ City, Country</li>
                        <li><strong>Corporate Office:</strong> Airline India, DEF Street, UVW City, Country</li>
                        <li><strong>Customer Support:</strong> +123 456 7890</li>
                        <li>Email: support@airlineindia.com</li>
                    </ul>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col text-center">
                    <p class="mb-0">&copy; <?php echo date("Y"); ?> Airline India. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript and Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- <script src="scripts.js"></script> -->
</body>

</html>