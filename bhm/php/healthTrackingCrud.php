<?php
include_once("../config/db.php"); // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'] ?? '';
    $service_date = $_POST['service_date'] ?? '';
    $attending_staff = $_POST['attending_staff'] ?? '';
    $service_id = $_POST['service_type'] ?? ''; // This should now be the service ID
    $diagnosis = $_POST['diagnosis'] ?? '';
    $treatment = $_POST['treatment'] ?? '';
    $status = $_POST['status'] ?? '';

    // Validate required fields
    if (empty($patient_id) || empty($service_date) || empty($service_id)) {
        die("❌ Missing required fields.");
    }

    // Check if the selected service ID exists in the services table
    $serviceCheck = $conn->prepare("SELECT id FROM services WHERE id = ?");
    $serviceCheck->bind_param("i", $service_id);
    $serviceCheck->execute();
    $serviceCheck->store_result();
    if ($serviceCheck->num_rows === 0) {
        die("❌ Invalid service selected.");
    }

    // Insert record into service_records table
    $stmt = $conn->prepare("INSERT INTO service_records 
        (patient_id, date_provided, attending_bhw, service_id, diagnosis, treatment, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssss", $patient_id, $service_date, $attending_staff, $service_id, $diagnosis, $treatment, $status);

    if ($stmt->execute()) {
        header("Location: ../modules/serviceTracking.php?success=1");
        exit;
    } else {
        die("❌ Failed to record service: " . $stmt->error);
    }
}

?>