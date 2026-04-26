<?php
// DB connection
$host = "YOUR_DB_HOST";
$user = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$database = "YOUR_DB_USERNAME_supplier";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get ID and delete
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM materials WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location.href='display.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
