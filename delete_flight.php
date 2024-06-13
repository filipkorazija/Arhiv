<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL to delete a record
    $sql = "DELETE FROM flights WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Vnos je bil uspesno izbrisan.";
    } else {
        $_SESSION['error'] = "Napaka pri brisanju vnosa: " . $conn->error;
    }
} else {
    $_SESSION['error'] = "Neveljaven ID vnosa.";
}

header("Location: display_flights.php"); // Adjust this to the correct file name for viewing flights
exit();
?>
