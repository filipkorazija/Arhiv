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
    <title>MOS Servis</title>
    <link rel="stylesheet" type="text/css" href="style.css?v=1.1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <h2>Vnos novega stanovanja</h2>
        <form class="dn-form" action="save_dn.php" method="post">
            <div class="form-group">
                <label for="dn">DN:</label>
                <input type="text" id="dn" name="dn" required>
            </div>
            <div class="form-group">
                <label for="naslov_stanovanja">Naslov Stanovanja:</label>
                <input type="text" id="naslov_stanovanja" name="naslov_stanovanja" required>
            </div>
            <div class="form-group">
                <label for="postna_st">Poštna Št.:</label>
                <input type="text" id="postna_st" name="postna_st" required>
            </div>
            <div class="form-group">
                <label for="kontakt">Kontakt:</label>
                <input type="text" id="kontakt" name="kontakt" required>
            </div>
            <div class="form-group">
                <label for="imena">Imena delavcev (št. oseb):</label>
                <input type="text" id="imena" name="imena" required>
            </div>
            <div class="form-group">
                <label for="cena_oseba_dan">Cena/Oseba/Dan:</label>
                <input type="text" id="cena_oseba_dan" name="cena_oseba_dan" required>
            </div>
            <div class="form-group">
                <label for="st_racuna">Št. Računa:</label>
                <input type="text" id="st_racuna" name="st_racuna" required>
            </div>
            <div class="form-group">
                <label for="country">Države:</label>
                <select id="country" name="country" required>
                    <option value="">Izberi Državo</option>
                    <option value="Anglija">Anglija</option>
                    <option value="Avstrija">Avstrija</option>
                    <option value="Belgija">Belgija</option>
                    <option value="Bolgarija">Bolgarija</option>
                    <option value="Češka">Češka</option>
                    <option value="Danska">Danska</option>
                    <option value="Finska">Finska</option>
                    <option value="Francija">Francija</option>
                    <option value="Hrvaška">Hrvaška</option>
                    <option value="Kanada">Kanada</option>
                    <option value="Italija">Italija</option>
                    <option value="Islandija">Islandija</option>
                    <option value="Nemčija">Nemčija</option>
                    <option value="Nizozemska">Nizozemska</option>
                    <option value="Norveška">Norveška</option>
                    <option value="Madžarska">Madžarska</option>
                    <option value="Poljska">Poljska</option>
                    <option value="Portugalska">Portugalska</option>
                    <option value="Romunija">Romunija</option>
                    <option value="Slovaška">Slovaška</option>
                    <option value="Španija">Španija</option>
                    <option value="Švedska">Švedska</option>
                    <option value="Švica">Švica</option>
                    <option value="ZDA">ZDA</option>
                    <!-- Add more countries as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="opombe">Opombe:</label>
                <textarea id="opombe" name="opombe"></textarea>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Shrani</button>
            </div>
        </form>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>
