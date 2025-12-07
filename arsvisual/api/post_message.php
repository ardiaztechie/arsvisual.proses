<?php
require_once '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Ambil data dari form
$name = mysqli_real_escape_string($conn, trim($_POST['name'] ?? ''));
$email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
$phone = mysqli_real_escape_string($conn, trim($_POST['phone'] ?? ''));
$service = mysqli_real_escape_string($conn, trim($_POST['service'] ?? ''));
$message = mysqli_real_escape_string($conn, trim($_POST['message'] ?? ''));

// Validasi
if (empty($name) || empty($email) || empty($phone) || empty($service) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Semua field harus diisi!']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email tidak valid!']);
    exit;
}

// Insert ke database
$sql = "INSERT INTO messages (name, email, phone, service, message, status) 
        VALUES ('$name', '$email', '$phone', '$service', '$message', 'new')";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        'success' => true,
        'message' => 'Pesan berhasil dikirim! Kami akan segera menghubungi Anda.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal mengirim pesan: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
