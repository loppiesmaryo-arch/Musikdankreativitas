<?php
header('Content-Type: application/json');

// Fungsi untuk validasi input
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Ambil data dari POST
$name = isset($_POST['name']) ? validateInput($_POST['name']) : '';
$email = isset($_POST['email']) ? validateInput($_POST['email']) : '';
$message = isset($_POST['message']) ? validateInput($_POST['message']) : '';

// Validasi field wajib
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'Harap isi semua field wajib!']);
    exit;
}

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Email tidak valid!']);
    exit;
}

// Simpan data ke file JSON (simulasi database)
$data = [
    'name' => $name,
    'email' => $email,
    'message' => $message,
    'timestamp' => date('Y-m-d H:i:s')
];

$file = 'services_data.json';
$existingData = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
$existingData[] = $data;

if (file_put_contents($file, json_encode($existingData, JSON_PRETTY_PRINT))) {
    echo json_encode(['status' => 'success', 'message' => 'Pesan berhasil dikirim!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pesan.']);
}
?>