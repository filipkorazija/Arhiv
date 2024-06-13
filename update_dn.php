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
$sql = "UPDATE delovni_nalog SET dn=?, naslov_stanovanja=?, postna_st=?, kontakt=?, imena=?, cena_oseba_dan=?, st_racuna=?, opombe=?, country=? WHERE id=?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . htmlspecialchars($conn->error)]);
    exit();
}

// Bind the parameters
$stmt->bind_param(
    "sssssssssi", 
    $data['dn'], 
    $data['naslov_stanovanja'], 
    $data['postna_st'], 
    $data['kontakt'], 
    $data['imena'], 
    $data['cena_oseba_dan'], 
    $data['st_racuna'], 
    $data['opombe'], 
    $data['country'], 
    $id
);

// Execute the statement
if ($stmt->execute()) {
    // Fetch the updated data to return to the client
    $sql = "SELECT dn, naslov_stanovanja, postna_st, kontakt, imena, cena_oseba_dan, st_racuna, opombe, country FROM delovni_nalog WHERE id=?";
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
