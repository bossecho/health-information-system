
<?php
include_once("../config/db.php");

// 🟢 DELETE PATIENT
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = intval($_GET['id']); // Get patient ID from URL

    if ($id <= 0) {
        die("❌ Invalid patient ID.");
    }

    // Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM patients WHERE id = ?");
    if (!$stmt) {
        die("❌ SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to patients page with success message
        header("Location: ../pages/patients.php?deleted=1");
        exit;
    } else {
        die("❌ Delete failed: " . $stmt->error);
    }
}


// 🟡 EDIT (update)
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = intval($_POST['id']);
    $fullname = $_POST['fullname'] ?? '';
    $age = $_POST['age'] ?? 0;
    $sex = $_POST['sex'] ?? '';
    $dob = $_POST['dob'] ?? null;
    $address = $_POST['address'] ?? null;
    $contact = $_POST['contact'] ?? null;
    $height = $_POST['height'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $notes = $_POST['notes'] ?? null;

    // ✅ Validation
    if (empty($fullname)) {
        die("❌ Missing required field: Fullname.");
    }

    // ✅ Update query (no patient_id to avoid foreign key issues)
    $query = "UPDATE patients SET 
                fullname=?, age=?, sex=?, dob=?, address=?, 
                contact=?, height=?, weight=?, notes=? 
              WHERE id=?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("❌ Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "sisssssddi",
        $fullname,
        $age,
        $sex,
        $dob,
        $address,
        $contact,
        $height,
        $weight,
        $notes,
        $id
    );

    if (!$stmt->execute()) {
        die("❌ Update failed: " . $stmt->error);
    }

    header("Location: ../modules/patientRecord.php?updated=1");
    exit;
} // ✅ this closes the if block — no extra brace below!

?>