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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Delovni Nalog Entry</h2>
        <form action="save_dn.php" method="POST">
            <div class="mb-3">
                <label for="dn" class="form-label">DN:</label>
                <input type="text" class="form-control" id="dn" name="dn" required>
            </div>
            <div class="mb-3">
                <label for="naslov_stanovanja" class="form-label">Naslov Stanovanja:</label>
                <input type="text" class="form-control" id="naslov_stanovanja" name="naslov_stanovanja" required>
            </div>
            <div class="mb-3">
                <label for="postna_st" class="form-label">Poštna Št.:</label>
                <input type="text" class="form-control" id="postna_st" name="postna_st" required>
            </div>
            <div class="mb-3">
                <label for="kontakt" class="form-label">Kontakt:</label>
                <input type="text" class="form-control" id="kontakt" name="kontakt" required>
            </div>
            <div class="mb-3">
                <label for="imena" class="form-label">Imena (comma separated):</label>
                <input type="text" class="form-control" id="imena" name="imena" required>
            </div>
            <div class="mb-3">
                <label for="cena_oseba_dan" class="form-label">Cena/Oseba/Dan:</label>
                <input type="text" class="form-control" id="cena_oseba_dan" name="cena_oseba_dan" required>
            </div>
            <div class="mb-3">
                <label for="st_racuna" class="form-label">Št. Računa:</label>
                <input type="text" class="form-control" id="st_racuna" name="st_racuna" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Države:</label>
                <select class="form-select" id="country" name="country" required>
                    <option value="">Select Country</option>
                    <option value="Germany">Germany</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Netherlands">Netherlands</option>
                    <!-- Add more countries as needed -->
                </select>
            </div>
            <div class="mb-3">
                <label for="opombe" class="form-label">Opombe:</label>
                <textarea class="form-control" id="opombe" name="opombe"></textarea>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
