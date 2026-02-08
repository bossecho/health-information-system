<?php
// php/user_action.php
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once __DIR__ . '/../config/db.php'; // use your existing connection

// --- Helper functions ---
function jsonResponse($success, $message, $code = 200) {
    http_response_code($code);
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

function verifyFirebaseToken($idToken) {
    if (!$idToken) return false;
    $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$resp) return false;
    $data = json_decode($resp, true);
    if (!$data || !isset($data['sub'])) return false;

    return $data;
}

// --- Collect form data ---
$action   = $_POST['action'] ?? 'add';
$fullname = trim($_POST['fullname'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$roleRaw  = trim($_POST['role'] ?? '');
$status   = $_POST['status'] ?? null;
$contact  = $_POST['contact'] ?? null;
$user_id  = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;
$firebase_token = $_POST['firebase_token'] ?? null;

// --- Verify Firebase 2FA ---
$firebasePayload = verifyFirebaseToken($firebase_token);
if (!$firebasePayload) {
    jsonResponse(false, 'Invalid or missing Firebase token. Please complete 2FA.', 401);
}

// --- Validate fields ---
if ($fullname === '' || $username === '') {
    jsonResponse(false, 'Full name and username are required.');
}

// --- Role mapping (HTML vs DB ENUM) ---
$roleMap = [
    'Admin' => 'Admin',
    'Health Worker' => 'BHW',
    'Encoder' => 'Nurse',
];
$role = $roleMap[$roleRaw] ?? $roleRaw;
$allowedRoles = ['Admin', 'BHW', 'Nurse', 'Midwife'];
if (!in_array($role, $allowedRoles, true)) {
    jsonResponse(false, 'Invalid role selected.');
}

// --- Use your DB connection ---
try {
    // Determine if you're using mysqli or PDO
    // Adjust the variable name accordingly
    if (!isset($conn) && isset($pdo)) {
        $conn = $pdo; // fallback for PDO variable naming
    }

    // --- ADD USER ---
    if ($action === 'add') {
        // check for duplicate username
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            jsonResponse(false, 'Username already exists.');
        }

        if ($password === '') {
            jsonResponse(false, 'Password is required for new users.');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Check if status column exists
        $colCheck = $conn->prepare("SHOW COLUMNS FROM users LIKE 'status'");
        $colCheck->execute();
        $hasStatus = $colCheck->fetch();

        if ($hasStatus) {
            $sql = "INSERT INTO users (fullname, username, password, role, contact, status, created_at)
                    VALUES (:fullname, :username, :password, :role, :contact, :status, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':fullname' => $fullname,
                ':username' => $username,
                ':password' => $hash,
                ':role' => $role,
                ':contact' => $contact,
                ':status' => $status
            ]);
        } else {
            $sql = "INSERT INTO users (fullname, username, password, role, contact, created_at)
                    VALUES (:fullname, :username, :password, :role, :contact, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':fullname' => $fullname,
                ':username' => $username,
                ':password' => $hash,
                ':role' => $role,
                ':contact' => $contact
            ]);
        }

        jsonResponse(true, 'User added successfully.');
    }

    // --- EDIT USER ---
    elseif ($action === 'edit') {
        if (!$user_id) jsonResponse(false, 'Missing user_id for edit.');

        $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $existing = $stmt->fetch();
        if ($existing && intval($existing['user_id']) !== $user_id) {
            jsonResponse(false, 'Username already used by another user.');
        }

        $fields = [
            'fullname' => $fullname,
            'username' => $username,
            'role' => $role,
            'contact' => $contact
        ];

        if ($password !== '') {
            $fields['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // include status if exists
        $colCheck = $conn->prepare("SHOW COLUMNS FROM users LIKE 'status'");
        $colCheck->execute();
        $hasStatus = $colCheck->fetch();
        if ($hasStatus && $status !== null) {
            $fields['status'] = $status;
        }

        $setParts = [];
        foreach ($fields as $col => $val) {
            $setParts[] = "$col = :$col";
        }

        $sql = "UPDATE users SET " . implode(", ", $setParts) . " WHERE user_id = :user_id";
        $fields['user_id'] = $user_id;
        $stmt = $conn->prepare($sql);
        $stmt->execute($fields);

        jsonResponse(true, 'User updated successfully.');
    }

    else {
        jsonResponse(false, 'Invalid action.');
    }

} catch (Exception $e) {
    jsonResponse(false, 'Server error: ' . $e->getMessage(), 500);
}
