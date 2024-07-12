<?php
session_start();
include('includes/header.php'); // Include your header file with necessary PHP logic

// Example array of flight offers (replace with actual dynamic fetching from DB or API)
$flightOffers = [
    [
        'id' => 1,
        'destination' => 'New York',
        'price' => 250,
        'promo_code' => 'FLYNY2024'
    ],
    [
        'id' => 2,
        'destination' => 'Los Angeles',
        'price' => 300,
        'promo_code' => 'FLYLA2024'
    ],
    [
        'id' => 3,
        'destination' => 'Chicago',
        'price' => 280,
        'promo_code' => 'FLYCHI2024'
    ],
    // Add more offers as needed
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="container mt-4">
        <div class="search-section bg-white p-4 rounded shadow-sm">
            <form id="booking-form" method="POST" action="search.php"> <!-- Assuming 'search.php' is your PHP processing file -->
                <!-- Your existing search form -->
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label class="mr-3"><input type="radio" name="trip" value="one-way" checked> One Way</label>
                        <label><input type="radio" name="trip" value="round-trip"> Round Trip</label>
                    </div>
                    <div class="col-auto">
                        <span class="promo-code text-primary">Use promo code</span>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="col">
                        <label for="from">From</label>
                        <select id="from" name="from" class="form-control" required>
                            <option value="" disabled selected>Choose...</option>
                            <option value="New York">New York</option>
                            <option value="Los Angeles">Los Angeles</option>
                            <option value="Chicago">Chicago</option>
                            <option value="Houston">Houston</option>
                            <option value="Miami">Miami</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="col">
                        <label for="to">To</label>
                        <select id="to" name="to" class="form-control" required>
                            <option value="" disabled selected>Choose...</option>
                            <option value="New York">New York</option>
                            <option value="Los Angeles">Los Angeles</option>
                            <option value="Chicago">Chicago</option>
                            <option value="Houston">Houston</option>
                            <option value="Miami">Miami</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="col">
                        <input type="date" name="departure_date" class="form-control" required>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-primary btn-block">Add return trip</button>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-block">Search Flight</button>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="col">
                        <button type="button" class="btn btn-outline-secondary btn-block">Individual</button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-secondary btn-block">Family & Friends</button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-secondary btn-block">Unaccompanied Minor</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- IndiGo News Section -->
        <div class="news-section mt-4">
            <h2>IndiGo News</h2>
            <div class="news-container d-flex justify-content-between">
                <div class="news-item">
                    <img src="image1.jpg" alt="New Look and Modern Architecture">
                    <p>IndiGo to unveil a new look and modern architecture of its website and mobile app</p>
                </div>
                <div class="news-item">
                    <img src="image2.jpg" alt="Mumbai and Vijayawada">
                    <p>IndiGo announces direct flights between Mumbai and Vijayawada</p>
                </div>
                <div class="news-item">
                    <img src="image3.jpg" alt="Bengaluru and Abu Dhabi">
                    <p>IndiGo announces direct flights between Bengaluru and Abu Dhabi</p>
                </div>
                <div class="news-item">
                    <img src="image4.jpg" alt="Jeddah and Mumbai">
                    <p>IndiGo announces additional flights between Jeddah and Mumbai</p>
                </div>
            </div>
        </div>

        <!-- Offers Section -->
        <div class="offers-section mt-4">
            <h2>Latest Flight Offers</h2>
            <div class="row">
                <?php foreach ($flightOffers as $offer): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $offer['destination']; ?></h5>
                                <p class="card-text">Price: $<?php echo $offer['price']; ?></p>
                                <p class="card-text">Promo Code: <?php echo $offer['promo_code']; ?></p>
                                <a href="#" class="btn btn-primary">Book Now</a>
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
                    <h5>Get to Know Us</h5>
                    <ul class="list-unstyled">
                        <li>About us</li>
                        <li>IndiGo Green - ESG report</li>
                        <li>6E Embrace - Diversity Equity & Inclusion</li>
                        <li>IndiGoReach - Our CSR initiatives</li>
                        <li>Hello 6E Magazine</li>
                        <li>Board of Directors</li>
                        <li>Leadership Team</li>
                        <li>Investor Relations</li>
                        <li>Press Releases</li>
                        <li>InterGlobe Enterprises</li>
                        <li>RPWD - Equal Opportunity Policy</li>
                        <li>Transgender Persons Policy</li>
                        <li>HIV/AIDS workplace policy</li>
                        <li>Our Awards</li>
                        <li>Seat/Aircraft information</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Services</h5>
                    <ul class="list-unstyled">
                        <li>Plan B</li>
                        <li>Special/Disability Assistance</li>
                        <li>Medical Assistance</li>
                        <li>Seat Select</li>
                        <li>6E Eats</li>
                        <li>Add-ons & Services</li>
                        <li>Baggage</li>
                        <li>Refund Claim</li>
                        <li>Charter Services</li>
                        <li>Hotels</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Quick links</h5>
                    <ul class="list-unstyled">
                        <li>Offers</li>
                        <li>Careers</li>
                        <li>Advertise with us</li>
                        <li>Sitemap</li>
                        <li>Destinations</li>
                        <li>Blogs</li>
                        <li>Terms and Conditions</li>
                        <li>Conditions of Carriage</li>
                        <li>Privacy Policy</li>
                        <li>Disclaimer</li>
                        <li>International Travel Tips</li>
                        <li>Web check-in Advisory</li>
                        <li>Tariff Sheet</li>
                        <li>Purchase Requirement</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Social</h5>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fab fa-linkedin"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                    <h5>Download</h5>
                    <div>
                        <a href="#"><img src="google-play-badge.png" alt="Get it on Google Play" class="img-fluid"></a>
                        <a href="#"><img src="app-store-badge.png" alt="Download on the App Store" class="img-fluid"></a>
                    </div>
                    <h5>Our Awards</h5>
                    <ul class="list-unstyled">
                        <li><img src="award1.png" alt="Best Low Cost Airline - Asia" class="img-fluid"></li>
                        <li><img src="award2.png" alt="Best Low Cost Airline - Central Asia" class="img-fluid"></li>
                        <li><img src="award3.png" alt="Passenger Choice Award" class="img-fluid"></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript and Bootstrap Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
