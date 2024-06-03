<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL to delete a record
    $sql = "DELETE FROM flights WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}

header("Location: display_flights.php"); // Adjust this to the correct file name for viewing flights
exit();
?>
