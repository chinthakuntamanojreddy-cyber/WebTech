<?php 
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include PHP QR Code library
include('phpqrcode/qrlib.php');

// ✅ Fixed URL (no extra "?")
$qr_code_data = "https://baleopening.infinityfree.me/dashboarddd.php";

// Directory for saving QR
$qr_code_dir = 'qr_codes/';
if (!file_exists($qr_code_dir)) {
    mkdir($qr_code_dir, 0777, true);
}

// File path
$qr_code_image = $qr_code_dir . 'dashboard_qr.png';

// Generate QR code and save
QRcode::png($qr_code_data, $qr_code_image);

// Show result
echo "<h2>QR Code Generated</h2>";
echo "<p>Scan this QR or <a href='$qr_code_image' download>Download PNG</a></p>";
echo "<img src='$qr_code_image' alt='Dashboard QR Code' style='width:250px;height:250px;border:1px solid #000;'>";
?>
