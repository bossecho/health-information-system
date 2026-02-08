<?php
include_once("../config/db.php");

/* ------------------------------------------------------------
   🔹 ADD PATIENT
   ------------------------------------------------------------ */
if (isset($_POST['action']) && $_POST['action'] === "add_patient") {
    $fullname = $_POST['fullname'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $dob = $_POST['dob'];
    $patient_id = $_POST['patient_id'];
    $notes = $_POST['notes'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    if (empty($patient_id)) {
        $patient_id = "P-" . strtoupper(uniqid());
    }

    $stmt = $conn->prepare("INSERT INTO patients (patient_id, fullname, age, sex, dob, address, contact, height, weight, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssddss", $patient_id, $fullname, $age, $sex, $dob, $address, $contact, $height, $weight, $notes);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Patient record saved successfully!'); window.location.href = '../modules/patientRecord.php';</script>";
    } else {
        echo "<script>alert('❌ Failed to save patient record.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
    exit;
}

/* ------------------------------------------------------------
   🔹 PAGINATION + SEARCH
   ------------------------------------------------------------ */


header('Content-Type: application/json');

// Turn off error display (important!)
ini_set('display_errors', 0);
error_reporting(0);

$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

$response = [
  "draw" => $draw,
  "recordsTotal" => 0,
  "recordsFiltered" => 0,
  "data" => []
];

try {
    // Count total records
    $totalQuery = "SELECT COUNT(*) AS total FROM patients";
    $totalRes = mysqli_query($conn, $totalQuery);
    $totalRecords = mysqli_fetch_assoc($totalRes)['total'];

    // Build search filter
    $where = "";
    if (!empty($searchValue)) {
        $searchValue = mysqli_real_escape_string($conn, $searchValue);
        $where = "WHERE fullname LIKE '%$searchValue%' OR patient_id LIKE '%$searchValue%'";
    }

    // Count filtered records
    $filterQuery = "SELECT COUNT(*) AS total FROM patients $where";
    $filterRes = mysqli_query($conn, $filterQuery);
    $recordsFiltered = mysqli_fetch_assoc($filterRes)['total'];

    // Fetch data
    $dataQuery = "
        SELECT id, patient_id, fullname, age, sex, address
        FROM patients
        $where
        ORDER BY id DESC
        LIMIT $start, $length
    ";
    $dataRes = mysqli_query($conn, $dataQuery);

    $data = [];
    while ($row = mysqli_fetch_assoc($dataRes)) {
        $data[] = $row;
    }

    // Prepare valid response
    $response['recordsTotal'] = intval($totalRecords);
    $response['recordsFiltered'] = intval($recordsFiltered);
    $response['data'] = $data;

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
exit;



// ---------------------------------------------------
// 🔹 3. CRUD
// ---------------------------------------------------






?>