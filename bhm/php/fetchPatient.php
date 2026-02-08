<?php
include_once("../config/db.php"); // your DB connection

header('Content-Type: application/json');

if (!isset($_GET['query']) || empty($_GET['query'])) {
    echo json_encode([]);
    exit;
}

$search = "%{$_GET['query']}%";

// Search by patient_id or fullname
$stmt = $conn->prepare("SELECT patient_id, fullname FROM patients WHERE patient_id LIKE ? OR fullname LIKE ? LIMIT 1");
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode([]);
}
?>