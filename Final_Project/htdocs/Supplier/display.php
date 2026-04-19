<?php
// Database config
$host = "sql207.infinityfree.com";
$user = "if0_38837486";
$password = "7396649051";
$database = "if0_38837486_supplier";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$search = $_GET['search'] ?? '';
$data = [];

if (!empty($search)) {
    $stmt = $conn->prepare("SELECT * FROM materials 
        WHERE supplier LIKE CONCAT('%', ?, '%') 
        OR material_code LIKE CONCAT('%', ?, '%') 
        OR location LIKE CONCAT('%', ?, '%') 
        ORDER BY created_at DESC");
    $stmt->bind_param("sss", $search, $search, $search);
} else {
    $stmt = $conn->prepare("SELECT * FROM materials ORDER BY created_at DESC");
}

$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>📋 Materials Data</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  th {
  font-family: 'Cinzel', serif;
}

  h2 {
    font-family: 'Cinzel', serif;
    color: #002b5b;
    text-align: center;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
  }

    body {
      font-family: 'Segoe UI', sans-serif;
      color: #1a1a1a;
      position: relative;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 30px 15px;
      overflow: hidden;
      background-color: #f4f8fb;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('fabric.jpg') center/cover no-repeat fixed;
      filter: blur(10px);
      z-index: -1;
    }

    h2 {
      color: #002b5b;
      text-align: center;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
      margin-bottom: 30px;
    }

    .container {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(10px);
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 1000px;
    }

    .search-box {
      max-width: 500px;
      margin: 0 auto 25px;
    }

    table {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    th {
      background: #4A90E2;
      color: white;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .action-btns a {
      margin-right: 10px;
      text-decoration: none;
      font-size: 18px;
      transition: 0.2s ease;
    }

    .edit { color: #0d6efd; }
    .edit:hover { color: #084dc2; }

    .delete { color: #dc3545; }
    .delete:hover { color: #a70000; }

    .no-data {
      text-align: center;
      color: #dc3545;
      font-weight: 500;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Supplier Details</h2>

    <!-- Search Bar -->
  <form class="search-box d-flex justify-content-between align-items-center gap-2" method="GET" action="">
  <div class="input-group" style="flex: 1;">
    <input type="text" class="form-control" name="search" placeholder="Search by Supplier, Code, or Location..." value="<?= htmlspecialchars($search) ?>">
    <button class="btn btn-primary" type="submit">Search</button>
  </div>

  <!-- Inward Button (redirect to inward.html or inward.php) -->
  <a href="Supplier.html" class="btn btn-success">Inward</a>
</form>


    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Supplier</th>
            <th>Material Code</th>
            <th>Location</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($data) > 0): ?>
            <?php foreach ($data as $row): ?>
              <tr>
                <td><?= htmlspecialchars($row['supplier']) ?></td>
                <td><?= htmlspecialchars($row['material_code']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td class="action-btns">
                  <a href="edit.php?id=<?= $row['id'] ?>" class="edit" title="Edit">&#9998;</a>
                  <a href="delete.php?id=<?= $row['id'] ?>" class="delete" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">&#128465;</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" class="no-data">No records found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>