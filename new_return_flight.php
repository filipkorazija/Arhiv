<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vnos povratnih letov</title>
    <link rel="stylesheet" type="text/css" href="/utils/flights.css?v=1.1">
    <link rel="stylesheet" type="text/css" href="/utils/style.css?v=1.1">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <h2>Vnos povratnih letov</h2>
        <form class="flight-form" action="save_return_flight.php" method="post">
            <div class="form-group">
                <label for="name">Ime in priimek:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="departure_airport">Letališče odhoda:</label>
                <input type="text" id="departure_airport" name="departure_airport" required>
            </div>
            <div class="form-group">
                <label for="departure_date">Datum odhoda:</label>
                <input type="date" id="departure_date" name="departure_date" required>
            </div>
            <div class="form-group">
                <label for="departure_time">Ura odhoda:</label>
                <input type="time" id="departure_time" name="departure_time" required>
            </div>
            <div class="form-group">
                <label for="arrival_airport">Letališče prihoda:</label>
                <input type="text" id="arrival_airport" name="arrival_airport" required>
            </div>
            <div class="form-group">
                <label for="arrival_date">Datum prihoda:</label>
                <input type="date" id="arrival_date" name="arrival_date" required>
            </div>
            <div class="form-group">
                <label for="arrival_time">Ura pristanka:</label>
                <input type="time" id="arrival_time" name="arrival_time" required>
            </div>
            <div class="form-group">
                <label for="country">Država - Kraj:</label>
                <select id="country" name="country" required>
                    <option value="AT-Dunaj">AT - Dunaj</option>
                    <option value="AT-Graz">AT - Graz</option>
                    <option value="HR-Zagreb">HR - Zagreb</option>
                    <option value="CA-Toronto">CA - Toronto</option>
                    <option value="DE-Frankfurt">DE - Frankfurt</option>
                    <option value="US-Greenville">US - Greenville SC</option>
                    <option value="US-Guatemala">US - Guatemala</option>
                </select>
            </div>
            <div class="form-group">
                <label for="flight_type">Tip leta:</label>
                <input type="radio" id="direct_flight" name="flight_type" value="Direkten let" onclick="toggleNoteField(false)" checked> Direkten let
                <input type="radio" id="connecting_flight" name="flight_type" value="Prestopen let" onclick="toggleNoteField(true)"> Prestopni let
            </div>
            <div class="form-group" id="note_field" style="display: none;">
                <label for="note">Opomba:</label>
                <textarea id="note" name="note"></textarea>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Shrani</button>
            </div>
        </form>
    </div>
    <script>
        function toggleNoteField(show) {
            document.getElementById('note_field').style.display = show ? 'block' : 'none';
        }
    </script>
    
    <?php include('footer.php'); ?>
    
</body>
</html>
