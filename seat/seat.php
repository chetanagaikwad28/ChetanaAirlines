<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="stylesheet" rel="stylesheet" href="../assets/seat.css">
    <title>Plane Seating Layout</title>
</head>

<body>
    <div class="plane">
        <?php
        include('../includes/db.php');
        // Function to release seats that have been locked for more than 10 minutes
        function release_locked_seats($conn)
        {
            $current_time = date('Y-m-d H:i:s');
            $sql = "UPDATE `seat` SET `Status` = 'free', `LockUntil` = NULL WHERE `Status` = 'locked' AND `LockUntil` <= NOW()";
            echo $current_time;
            $conn->query($sql);
        }

        // Call the function to release locked seats
        release_locked_seats($conn);

        $flightId = isset($_POST['flight_id']) ? intval($_POST['flight_id']) : 1; // Default to 1 if not set
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
                <div class="seat ' . $seatClass . $isFireExit . '" data-seat-number="' . $seatNumber . '">
                    <div class="seat-number">' . $seatNumber . '</div>
                    <div class="headrest"></div>
                    <div class="backrest"></div>
                    <div class="seat-cushion"></div>
                    <div class="armrest armrest-left"></div>
                    <div class="armrest armrest-right"></div>';

                if ($seatClass == 'free') {
                    echo '<button class="lock-button btn btn-primary">Lock</button>';
                }
                echo '</div>';
                $rowCount++;
            }
            echo '</div>';
            echo '<button id="book-selected-seats" >Book Selected Seats</button>';
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flightId = <?php echo json_encode($flightId); ?>;
            const selectedSeats = [];

            document.querySelectorAll('.seat.free').forEach(seat => {
                seat.addEventListener('click', function() {
                    const seatNumber = this.dataset.seatNumber;
                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        const index = selectedSeats.indexOf(seatNumber);
                        if (index > -1) {
                            selectedSeats.splice(index, 1);
                        }
                    } else {
                        this.classList.add('selected');
                        selectedSeats.push(seatNumber);
                    }
                });
            });

            document.getElementById('book-selected-seats').addEventListener('click', function() {
                if (selectedSeats.length === 0) {
                    alert('Please select at least one seat to book.');
                    return;
                }

                bookSeats(flightId, selectedSeats);
            });

            document.querySelectorAll('.lock-button').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopPropagation(); // Prevent seat selection on button click
                    var seatNumber = this.parentElement.querySelector('.seat-number').textContent.trim();
                    lockSeat(flightId, seatNumber);
                });
            });
        });

        // this is bookSeats
        function bookSeats(flightId, seatNumbers) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '../bkng.php'; // Update the action to point to bkng.php or your booking endpoint

            var flightIdInput = document.createElement('input');
            flightIdInput.type = 'hidden';
            flightIdInput.name = 'flight_id';
            flightIdInput.value = flightId;
            form.appendChild(flightIdInput);

            seatNumbers.forEach(seatNumber => {
                var seatNumberInput = document.createElement('input');
                seatNumberInput.type = 'hidden';
                seatNumberInput.name = 'seat_numbers[]'; // Use brackets to indicate an array in PHP
                seatNumberInput.value = seatNumber;
                form.appendChild(seatNumberInput);
            });

            document.body.appendChild(form);
            form.submit();
        }

        // this is lockseat
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