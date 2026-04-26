<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("YOUR_DB_HOST", "YOUR_DB_USERNAME", "YOUR_DB_PASSWORD", "YOUR_DB_USERNAME_vechile_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$date = $_POST['date'];
$vehicleNumber = $_POST['vehicleNumber'];
$busRoute = $_POST['busRoute'];
$timeIn = $_POST['timeIn'];
$numEmployees = $_POST['numEmployees'];
$reason = isset($_POST['reason']) ? $_POST['reason'] : null; // Handles empty case

// Insert into database (with reason)
$sql = "INSERT INTO Bus_entry (date, vehicle_number, bus_route, time_in, num_employees, reason)
        VALUES ('$date', '$vehicleNumber', '$busRoute', '$timeIn', '$numEmployees', '$reason')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php"); // Redirect on success
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>