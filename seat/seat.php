<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="stylesheet" rel="stylesheet" href="styles.css">
    <title>Plane Seating Layout</title>
</head>

<body>
    <div class="plane">
        <?php
        include('../includes/db.php');

        $flightId = isset($_POST['flight_id']) ? intval($_POST['flight_id']) : NULL; // Default to 1 if not set
        $sql = "SELECT * FROM seat WHERE FlightID = $flightId ORDER BY SeatID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $rowCount = 0;
            echo '<div class="row">';
            while ($row = $result->fetch_assoc()) {
                $seatClass = $row['Status'];
                $seatNumber = $row['SeatNumber'];
                $isFireExit = $row['IsFireExit'] ? ' fire-exit' : '';

                if ($rowCount % 6 == 0 && $rowCount != 0) {
                    echo '</div><div class="row">';
                }

                if ($rowCount % 3 == 0 && $rowCount != 0) {
                    echo '<div class="gap"></div>';
                }

                echo '
                <div class="seat ' . $seatClass . $isFireExit . '">
                    <div class="seat-number">' . $seatNumber . '</div>
                    <div class="headrest"></div>
                    <div class="backrest"></div>
                    <div class="seat-cushion"></div>
                    <div class="armrest armrest-left"></div>
                    <div class="armrest armrest-right"></div>';

                if ($seatClass == 'free') {
                    echo '<button class="lock-button btn btn-primary">Lock</button>';
                }
                echo  '</div>';
                $rowCount++;
            }
            echo '</div>';
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flightId = <?php echo json_encode($flightId); ?>;

            document.querySelectorAll('.lock-button').forEach(button => {
                button.addEventListener('click', function() {
                    var seatNumber = this.parentElement.querySelector('.seat-number').textContent.trim();
                    lockSeat(flightId, seatNumber);
                });
            });
        });

        function lockSeat(flightId, seatNumber) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '../lock_seat.php';

            var flightIdInput = document.createElement('input');
            flightIdInput.type = 'hidden';
            flightIdInput.name = 'flight_id';
            flightIdInput.value = flightId;
            form.appendChild(flightIdInput);

            var seatNumberInput = document.createElement('input');
            seatNumberInput.type = 'hidden';
            seatNumberInput.name = 'seat_number';
            seatNumberInput.value = seatNumber;
            form.appendChild(seatNumberInput);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>

</html>