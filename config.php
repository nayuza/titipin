<?php
// File: config.php

// Nama database yang sudah kita tentukan.
define('DB_NAME', 'titipin_db');

// Kredensial untuk server lokal (XAMPP). Biasanya 'root' dan password kosong.
// Sesuaikan jika berbeda.
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

// Membuat koneksi
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
  die(json_encode(['status' => 'error', 'message' => 'Koneksi database gagal.']));
}

$conn->set_charset("utf8mb4");
?>