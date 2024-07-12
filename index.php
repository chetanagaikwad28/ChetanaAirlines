<?php
session_start();
include('includes/header.php'); // Include your header file with necessary PHP logic

// Example array of flight offers (replace with actual dynamic fetching from DB or API)
$flightOffers = [
    [
        'id' => 1,
        'destination' => 'Tata Neu HDFC Bank Credit Cards',
        'description' => 'Book tickets with Tata Neu HDFC credit card and get NeuCoins.',
        'image' => 'image1.jpg'
    ],
    [
        'id' => 2,
        'destination' => 'Bajaj Pay UPI',
        'description' => 'Book your Air India flight tickets with Bajaj Pay UPI and receive 5% value back, up to INR 750.',
        'image' => 'image2.jpg'
    ],
    [
        'id' => 3,
        'destination' => 'Children below 15',
        'description' => 'Get 25% off on flight booking tickets when you book with Airline India.',
        'image' => 'image3.jpg'
    ],
    [
        'id' => 6,
        'destination' => 'Instant Discount Using ICICI Bank Cards',
        'description' => 'Book your flight tickets with ICICI Bank Credit or Debit Cards and get up to INR 2000 off.',
        'image' => 'image4.jpg'
    ],
];

// Example array of airline news (simplified)
$airlineNews = [
    [
        'image' => 'image1.jpg',
        'alt' => 'New Look and Modern Architecture',
        'headline' => 'Low Cost Airline unveils a new look and modern architecture of its website.',
    ],
    [
        'image' => 'image2.jpg',
        'alt' => 'Direct Flights Announcement',
        'headline' => 'Low Cost Airline announces new direct flights between Mumbai and Vijayawada.',
    ],
    [
        'image' => 'image3.jpg',
        'alt' => 'New Route Announcement',
        'headline' => 'Low Cost Airline introduces direct flights between Bengaluru and Mumbai.',
    ],
    [
        'image' => 'image4.jpg',
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
</head>

<body>
    <main class="container mt-4">
        <div class="search-section bg-white p-4 rounded shadow-sm">
            <form id="booking-form" method="POST" action="search.php"> <!-- Assuming 'search.php' is your PHP processing file -->
                <!-- Your existing search form -->
                <div class="row align-items-center">
                    <div class="col-auto">
                        <label class="form-check-label me-3"><input type="radio" name="trip" value="one-way" checked> One Way</label>
                        <label class="form-check-label"><input type="radio" name="trip" value="round-trip"> Round Trip</label>
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
                        <select id="to" name="to" class="form-select" required>
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
                <div class="row mt-3">
                    <div class="col">
                        <input type="date" name="departure_date" class="form-control" required>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-primary w-100">Add return trip</button>
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

        <div class="news-section mt-4">
            <h2>Low Cost Airline News</h2>
            <div class="news-container d-flex justify-content-between">
                <?php foreach ($airlineNews as $news) : ?>
                    <div class="news-item">
                        <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['alt']; ?>">
                        <p><?php echo $news['headline']; ?></p>
                    </div>
                <?php endforeach; ?>
                <div class="news-item">
                    <img src="image1.jpg" alt="New Look and Modern Architecture" class="img-fluid">
                    <p>Low Cost Airline is to unveil a new look and modern architecture of its website.</p>
                </div>
                <div class="news-item">
                    <img src="image2.jpg" alt="Mumbai and Vijayawada" class="img-fluid">
                    <p>Low Cost Airline announces direct flights between Mumbai and Vijayawada</p>
                </div>
                <div class="news-item">
                    <img src="image3.jpg" alt="Bengaluru and Mumbai" class="img-fluid">
                    <p> Low Cost Airline announces direct flights between Bengaluru and Mumbai</p>
                </div>
                <div class="news-item">
                    <img src="image4.jpg" alt="Jaipur and Mumbai" class="img-fluid">
                    <p>Low Cost Airline announces additional flights between Jaipur and Mumbai</p>
                </div>
            </div>
        </div>

        <!-- Offers Section -->
        <div class="offers-section mt-4">
            <h2>Latest Flight Offers</h2>
            <div class="row">
                <?php foreach ($flightOffers as $offer) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($offer['image'])) : ?>
                                    <img src="<?php echo $offer['image']; ?>" alt="<?php echo $offer['destination']; ?>" class="img-fluid mb-3">
                                <?php endif; ?>
                                <h5 class="card-title"><?php echo $offer['destination']; ?></h5>
                                <?php if (isset($offer['price'])) : ?>
                                    <p class="card-text">Price: $<?php echo $offer['price']; ?></p>
                                <?php endif; ?>
                                <?php if (isset($offer['promo_code'])) : ?>
                                    <p class="card-text">Promo Code: <?php echo $offer['promo_code']; ?></p>
                                <?php endif; ?>
                                <?php if (isset($offer['description'])) : ?>
                                    <p class="card-text"><?php echo $offer['description']; ?></p>
                                <?php endif; ?>
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
                        <li>Leadership Team</li>
                        <li>Investor Relations</li>
                        <li>Seat/Aircraft information</li>
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
                    <h5>Quick links</h5>
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
                    <h5>Our Awards</h5>
                    <ul class="list-unstyled">
                        <li><img src="award1.png" alt="Best Low Cost Airline - India" class="img-fluid"></li>
                        <li><img src="award3.png" alt="Passenger Choice Award" class="img-fluid"></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript and Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>