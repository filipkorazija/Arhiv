<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // SQL to delete a record
    $sql = "DELETE FROM delovni_nalog WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}

// Redirect back to the display page
header("Location: display_dn.php");
exit();
?>
