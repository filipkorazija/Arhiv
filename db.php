<?php
$servername = "157.90.125.171";
$username = "sql-arhiv";
$password = "eWRga4GV2GhC8ffWP5ax";
$dbname = "arhiv";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
