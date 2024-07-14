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