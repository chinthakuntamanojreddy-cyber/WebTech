<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "sql210.infinityfree.com";
$username = "if0_41698831";
$password = "bd5ZeQnxFWdh7";
$dbname = "if0_41698831_vechile_management"; // FIXED

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "✅ Connected successfully!";
?>