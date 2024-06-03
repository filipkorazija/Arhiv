<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $departure_airport = $_POST['departure_airport'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $arrival_airport = $_POST['arrival_airport'];
    $arrival_date = $_POST['arrival_date'];
    $arrival_time = $_POST['arrival_time'];
    $country = $_POST['country'];
    $flight_type = $_POST['flight_type'];
    $note = isset($_POST['note']) ? $_POST['note'] : '';

    $sql = "INSERT INTO return_flights (name, departure_airport, departure_date, departure_time, arrival_airport, arrival_date, arrival_time, country, flight_type, note)
            VALUES ('$name', '$departure_airport', '$departure_date', '$departure_time', '$arrival_airport', '$arrival_date', '$arrival_time', '$country', '$flight_type', '$note')";

    if ($conn->query($sql) === TRUE) {
        header("Location: new_return_flight.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
