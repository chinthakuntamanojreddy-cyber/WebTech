<?php
// Enable error reporting (only for development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database config
$host = "sql207.infinityfree.com";
$user = "if0_38837486";
$password = "7396649051";
$database = "if0_38837486_supplier";

// Connect to DB
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier = trim($_POST['supplier']);
    $material_code = trim($_POST['material_code']);
    $location = trim($_POST['location']);
    $bails = isset($_POST['bails']) ? (int)$_POST['bails'] : null;

    // Simple validation
    if (empty($supplier) || empty($material_code) || empty($location) || $bails === null) {
        die("All fields are required.");
    }

    // Insert into database
    $stmt = mysqli_prepare($conn, "INSERT INTO materials (supplier, material_code, location, bails) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssi", $supplier, $material_code, $location, $bails);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Data saved successfully!'); window.location.href='Supplier.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
