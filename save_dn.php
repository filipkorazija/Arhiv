<?php
include('nav.php');
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dn = $_POST['dn'];
    $naslov_stanovanja = $_POST['naslov_stanovanja'];
    $postna_st = $_POST['postna_st'];
    $kontakt = $_POST['kontakt'];
    $imena = $_POST['imena'];
    $cena_oseba_dan = $_POST['cena_oseba_dan'];
    $st_racuna = $_POST['st_racuna'];
    $country = $_POST['country'];
    $opombe = $_POST['opombe'];

    $sql = "INSERT INTO delovni_nalog (dn, naslov_stanovanja, postna_st, kontakt, imena, cena_oseba_dan, st_racuna, country, opombe)
            VALUES ('$dn', '$naslov_stanovanja', '$postna_st', '$kontakt', '$imena', '$cena_oseba_dan', '$st_racuna', '$country', '$opombe')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Save Delovni Nalog</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Delovni Nalog Entry</h2>
        <form class="dn-form" action="save_dn.php" method="POST">
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
                <label for="imena">Imena (comma separated):</label>
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
                    <option value="">Select Country</option>
                    <option value="Germany">Germany</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Netherlands">Netherlands</option>
                    <!-- Add more countries as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="opombe">Opombe:</label>
                <textarea id="opombe" name="opombe"></textarea>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</body>
</html>
