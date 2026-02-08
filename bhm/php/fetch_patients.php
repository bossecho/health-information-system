<?php
// ✅ Correct DB connection
include '../config/db.php'; // adjust if needed

header('Content-Type: application/json');

// ✅ Pagination setup
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$offset = ($page - 1) * $limit;

// ✅ Search condition
$where = "";
if ($search !== '') {
  $search = $conn->real_escape_string($search);
  $where = "WHERE fullname LIKE '%$search%' OR patient_id LIKE '%$search%'";
}

// ✅ Count total
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM patients $where");
$total = $totalResult ? (int)$totalResult->fetch_assoc()['total'] : 0;

// ✅ Fetch patient data
$query = "SELECT id, patient_id, fullname, age, sex, address 
          FROM patients $where 
          ORDER BY id DESC 
          LIMIT $limit OFFSET $offset";

$result = $conn->query($query);

$patients = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
  }
}

// ✅ Return JSON
echo json_encode(['patients' => $patients, 'total' => $total]);
