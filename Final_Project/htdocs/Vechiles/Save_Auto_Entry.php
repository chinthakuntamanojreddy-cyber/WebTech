<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "sql210.infinityfree.com"; // FIXED
$username = "if0_41698831";
$password = "bd5ZeQnxFWdh7";
$dbname = "if0_41698831_vechile_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $date = $_POST['date'];
    $vehicleNumber = $_POST['vehicleNumber'];
    $busRoute = $_POST['busRoute'];
    $timeIn = $_POST['timeIn'];
    $numEmployees = $_POST['numEmployees'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : null;

    // Insert data into Auto_entry table
    $sql = "INSERT INTO Auto_entry (date, vehicleNumber, busRoute, timeIn, numEmployees, reason)
            VALUES ('$date', '$vehicleNumber', '$busRoute', '$timeIn', '$numEmployees', '$reason')";

    if ($conn->query($sql) === TRUE) {
        header("Location: Auto.php"); // Redirect
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>