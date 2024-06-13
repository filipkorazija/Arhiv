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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vnos povratnih letov</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/utils/style.css?v=1.1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container mt-6"> <!-- Ensure consistent margin-top with mt-5 class -->
        <h2>Vnos povratnih letov</h2>
        <form class="row g-3" action="save_return_flight.php" method="post">
            <div class="col-md-6">
                <label for="name" class="form-label">Ime in priimek:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="departure_airport" class="form-label">Letališče odhoda:</label>
                <input type="text" id="departure_airport" name="departure_airport" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="departure_date" class="form-label">Datum odhoda:</label>
                <input type="date" id="departure_date" name="departure_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="departure_time" class="form-label">Ura odhoda:</label>
                <input type="time" id="departure_time" name="departure_time" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="arrival_airport" class="form-label">Letališče prihoda:</label>
                <input type="text" id="arrival_airport" name="arrival_airport" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="arrival_date" class="form-label">Datum prihoda:</label>
                <input type="date" id="arrival_date" name="arrival_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="arrival_time" class="form-label">Ura pristanka:</label>
                <input type="time" id="arrival_time" name="arrival_time" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="country" class="form-label">Država - Kraj:</label>
                <select id="country" name="country" class="form-select" required>
                    <option value="AT-Dunaj">AT - Dunaj</option>
                    <option value="AT-Graz">AT - Graz</option>
                    <option value="HR-Zagreb">HR - Zagreb</option>
                    <option value="CA-Toronto">CA - Toronto</option>
                    <option value="CA-Montreal">CA - Montreal</option>
                    <option value="DE-Frankfurt">DE - Frankfurt</option>
                    <option value="US-Greenville">US - Greenville SC</option>
                    <option value="US-Guatemala">US - Guatemala</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="flight_type" class="form-label">Tip leta:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="direct_flight" name="flight_type" value="Direkten let" onclick="toggleNoteField(false)" checked>
                    <label class="form-check-label" for="direct_flight">Direkten let</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="connecting_flight" name="flight_type" value="Prestopen let" onclick="toggleNoteField(true)">
                    <label class="form-check-label" for="connecting_flight">Prestopni let</label>
                </div>
            </div>
            <div class="col-md-12" id="note_field" style="display: none;">
                <label for="note" class="form-label">Opomba:</label>
                <textarea id="note" name="note" class="form-control"></textarea>
            </div>
            <div class="col-12">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
