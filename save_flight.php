<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['ime_priimek'];
    $departure_airport = $_POST['letalisce_odhoda'];
    $departure_date = $_POST['datum_odhoda'];
    $departure_time = $_POST['ura_odhoda'];
    $arrival_airport = $_POST['letalisce_prihoda'];
    $arrival_date = $_POST['datum_prihoda'];
    $arrival_time = $_POST['ura_pristanka'];
    $country = $_POST['country'];
    $flight_type = $_POST['tip_leta'];
    $note = isset($_POST['opomba']) ? $_POST['opomba'] : '';

    $sql = "INSERT INTO flights (name, departure_airport, departure_date, departure_time, arrival_airport, arrival_date, arrival_time, country, flight_type, note)
            VALUES ('$name', '$departure_airport', '$departure_date', '$departure_time', '$arrival_airport', '$arrival_date', '$arrival_time', '$country', '$flight_type', '$note')";

    if ($conn->query($sql) === TRUE) {
        header("Location: new_flight.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
