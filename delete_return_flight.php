<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    $sql = "DELETE FROM return_flights WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Vnos je bil uspesno izbrisan.";
    } else {
        $_SESSION['error'] = "Napaka pri brisanju vnosa: " . $conn->error;
    }
} else {
    $_SESSION['error'] = "Neveljaven ID vnosa.";
}

$conn->close();

header("Location: display_return_flights.php");
exit();
?>
