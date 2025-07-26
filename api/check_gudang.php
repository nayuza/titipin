<?php
// File: api/check_gudang.php

header('Content-Type: application/json');
require_once '../config.php';

if (!isset($_GET['daerah']) || empty($_GET['daerah'])) {
  echo json_encode(['status' => 'error', 'message' => 'Parameter daerah tidak ditemukan.']);
  exit;
}

$daerah = $_GET['daerah'];

$stmt = $conn->prepare("SELECT nama_gudang, alamat, (kapasitas - terisi) as sisa_slot FROM gudang WHERE daerah = ? AND status = 'Aktif' AND kapasitas > terisi LIMIT 1");

if ($stmt === false) {
    echo json_encode(['status' => 'error', 'message' => 'Query prepare gagal: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $daerah);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $gudang = $result->fetch_assoc();
  echo json_encode([
    'status' => 'tersedia',
    'message' => 'Kabar baik! Gudang kami tersedia di daerah ' . htmlspecialchars($daerah) . '.',
    'data' => [
        'nama_gudang' => $gudang['nama_gudang'],
        'alamat' => $gudang['alamat'],
        'sisa_slot' => $gudang['sisa_slot']
    ]
  ]);
} else {
  echo json_encode([
    'status' => 'tidak_tersedia',
    'message' => 'Mohon maaf, saat ini gudang kami di daerah ' . htmlspecialchars($daerah) . ' sudah penuh atau belum tersedia. Silakan cek daerah lain atau hubungi admin.'
  ]);
}

$stmt->close();
$conn->close();
?>