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

$id = $_GET['id'] ?? 0;
$id = intval($id);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier = $_POST['supplier'];
    $material_code = $_POST['material_code'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("UPDATE materials SET supplier=?, material_code=?, location=? WHERE id=?");
    $stmt->bind_param("sssi", $supplier, $material_code, $location, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Record updated successfully'); window.location.href='display.php';</script>";
    } else {
        echo "Update failed: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch current data
$sql = "SELECT * FROM materials WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Material</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #eef2f7;
      padding: 30px;
    }
    .form-box {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>

<div class="form-box">
  <h4 class="mb-3 text-center">✏️ Edit Material</h4>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Supplier</label>
      <input type="text" name="supplier" class="form-control" value="<?= htmlspecialchars($row['supplier']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Material Code</label>
      <input type="text" name="material_code" class="form-control" value="<?= htmlspecialchars($row['material_code']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Location</label>
      <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($row['location']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Update</button>
  </form>
</div>

</body>
</html>

<?php $conn->close(); ?>
