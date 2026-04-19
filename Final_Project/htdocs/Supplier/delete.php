<?php
// DB connection
$host = "sql207.infinityfree.com";
$user = "if0_38837486";
$password = "7396649051";
$database = "if0_38837486_supplier";

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
