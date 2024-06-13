<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

$id = $_GET['id'];
$data = json_decode(file_get_contents('php://input'), true);

// Prepare the SQL statement
$sql = "UPDATE return_flights SET name=?, departure_airport=?, departure_date=?, departure_time=?, arrival_airport=?, arrival_date=?, arrival_time=?, flight_type=?, note=?, country=? WHERE id=?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . htmlspecialchars($conn->error)]);
    exit();
}

// Bind the parameters
$stmt->bind_param(
    "ssssssssssi", 
    $data['name'], 
    $data['departure_airport'], 
    $data['departure_date'], 
    $data['departure_time'], 
    $data['arrival_airport'], 
    $data['arrival_date'], 
    $data['arrival_time'], 
    $data['flight_type'], 
    $data['note'], 
    $data['country'], 
    $id
);

// Execute the statement
if ($stmt->execute()) {
    // Fetch the updated data to return to the client
    $sql = "SELECT name, departure_airport, departure_date, departure_time, arrival_airport, arrival_date, arrival_time, flight_type, note, country FROM return_flights WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $updated_data = $result->fetch_assoc();

    echo json_encode(['success' => true, 'data' => $updated_data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Execute failed: ' . htmlspecialchars($stmt->error)]);
}

$stmt->close();
$conn->close();
?>
