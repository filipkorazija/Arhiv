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
    <title>MOS Servis - Leti</title>
    <link rel="stylesheet" type="text/css" href="/utils/style.css?v=1.1">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <h2>Vnos novih letov</h2>
        <form class="dn-form" action="save_flight.php" method="post">
            <div class="form-group">
                <label for="ime_priimek">Ime in priimek:</label>
                <input type="text" id="ime_priimek" name="ime_priimek" required>
            </div>
            <div class="form-group">
                <label for="letalisce_odhoda">Letališče odhoda:</label>
                <input type="text" id="letalisce_odhoda" name="letalisce_odhoda" required>
            </div>
            <div class="form-group">
                <label for="datum_odhoda">Datum odhoda:</label>
                <input type="date" id="datum_odhoda" name="datum_odhoda" required>
            </div>
            <div class="form-group">
                <label for="ura_odhoda">Ura odhoda:</label>
                <input type="time" id="ura_odhoda" name="ura_odhoda" required>
            </div>
            <div class="form-group">
                <label for="letalisce_prihoda">Letališče prihoda:</label>
                <input type="text" id="letalisce_prihoda" name="letalisce_prihoda" required>
            </div>
            <div class="form-group">
                <label for="datum_prihoda">Datum prihoda:</label>
                <input type="date" id="datum_prihoda" name="datum_prihoda" required>
            </div>
            <div class="form-group">
                <label for="ura_pristanka">Ura pristanka:</label>
                <input type="time" id="ura_pristanka" name="ura_pristanka" required>
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
                <label for="tip_leta">Tip leta:</label>
                <select id="tip_leta" name="tip_leta" required>
                    <option value="Direkten let">Direkten let</option>
                    <option value="Prestopni let">Prestopni let</option>
                </select>
            </div>
            <div class="form-group" id="opomba-container" style="display: none;">
                <label for="opomba">Opomba:</label>
                <textarea id="opomba" name="opomba"></textarea>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Shrani</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('tip_leta').addEventListener('change', function() {
            var opombaContainer = document.getElementById('opomba-container');
            if (this.value === 'Prestopni let') {
                opombaContainer.style.display = 'block';
            } else {
                opombaContainer.style.display = 'none';
            }
        });
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
