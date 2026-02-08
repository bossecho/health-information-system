<?php
include_once("../config/db.php");

$search = $_GET['search'] ?? '';
$limit = $_GET['limit'] ?? 5;
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $limit;

// Main query
$sql = "
    SELECT 
        sr.id,
        sr.patient_id,
        p.fullname AS patient_name,
        s.service_name,
        sr.date_provided,
        sr.attending_bhw,
        sr.status
    FROM service_records sr
    LEFT JOIN patients p ON sr.patient_id = p.patient_id
    LEFT JOIN services s ON sr.service_id = s.id
    WHERE p.fullname LIKE ? OR s.service_name LIKE ?
    ORDER BY sr.date_provided DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

// Get total count for pagination
$countSql = "
    SELECT COUNT(*) AS total
    FROM service_records sr
    LEFT JOIN patients p ON sr.patient_id = p.patient_id
    LEFT JOIN services s ON sr.service_id = s.id
    WHERE p.fullname LIKE ? OR s.service_name LIKE ?
";
$countStmt = $conn->prepare($countSql);
$countStmt->bind_param("ss", $searchTerm, $searchTerm);
$countStmt->execute();
$countResult = $countStmt->get_result()->fetch_assoc();
$total = $countResult['total'];

echo json_encode([
    'data' => $rows,
    'total' => $total
]);
?>
