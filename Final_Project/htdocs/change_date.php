<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection (FIXED)
$conn = new mysqli(
    "sql210.infinityfree.com",
    "if0_41698831",
    "bd5ZeQnxFWdh7",
    "if0_41698831_vechile_management"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input
$table = $_POST['table'];
$before_date = $_POST['before_date'];
$after_date = $_POST['after_date'];

// Allow only expected table names (GOOD - keep this)
$allowed_tables = ["Auto_entry", "Bus_entry"];

if (!in_array($table, $allowed_tables)) {
    die("Invalid table selected.");
}

// Prepare SQL statement
$sql = "UPDATE $table SET date = ? WHERE date = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $after_date, $before_date);

// Execute
if ($stmt->execute()) {
    echo "✅ Date updated in <strong>$table</strong> from <strong>$before_date</strong> to <strong>$after_date</strong>.";
} else {
    echo "❌ Error updating date: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>