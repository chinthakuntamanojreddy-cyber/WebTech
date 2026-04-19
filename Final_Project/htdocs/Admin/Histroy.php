<?php
// Database connection details
$servername = "sql210.infinityfree.com"; // FIXED
$username = "if0_41698831";
$password = "bd5ZeQnxFWdh7";
$dbname = "if0_41698831_vechile_management";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {	
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$isDate = false;
$isVehicle = false;
$isRoute = false;

if ($search !== '') {
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $search)) {
        $isDate = true;
    } elseif (preg_match('/^[A-Za-z0-9 -]+$/', $search)) {
        if (preg_match('/\d/', $search)) {
            $isVehicle = true;
        } else {
            $isRoute = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bus & Auto Route Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
    <style>
        h6 {
            font-family: 'Cinzel', serif;
        }
    </style>
</head>
 <body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white topbar mb-4 shadow">
          <div class="container-fluid">
            <!-- Search Form -->
         <form method="GET" class="d-flex flex-grow-1 me-2" role="search">
  <input 
    type="search" 
    id="search" 
    name="search" 
    class="form-control me-2 w-50" 
    placeholder="Date / Route / Vehicle No." 
    value="<?php echo htmlspecialchars($search); ?>" 
    aria-label="Search"
  >
</form>

            <!-- Buttons aligned right -->
            <div class="d-flex flex-nowrap">
              <a href="../index.php" class="btn btn-success shadow-sm d-flex align-items-center me-2" style="font-family: 'Cinzel', serif;">
                <i class="fas fa-bus fa-sm text-white-50 me-1"></i> Bus Details
              </a>&nbsp;&nbsp;
              <a href="Dashboard.php" class="btn btn-info shadow-sm d-flex align-items-center" style="font-family: 'Cinzel', serif;">
                <i class="fas fa-user-shield fa-sm text-white-50 me-1"></i> Admin
              </a>
            </div>
          </div>
        </nav>
<div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                       <h1 class="h3 mb-0 text-gray-800" style="font-family: 'Cinzel', serif; font-size: 36px; font-weight: bold; color:black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
  History
</h1>
<a href="/Vechiles/Excel.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-download fa-sm text-white-50"></i> Download Report
</a>

</div>


                <div class="container-fluid">
                    <div class="row">
                        <!-- Bus Table -->
                        <div class="col-xl-6 col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Bus Route</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Vehicle Number</th>
                                                    <th>Bus Route</th>
                                                    <th>Time In</th>
                                                    <th>No. of Employees</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
$busSql = "SELECT date, vehicle_number, bus_route, time_in, num_employees FROM Bus_entry WHERE 1";
$params = [];
$types = '';
if ($isDate) {
    $busSql .= " AND date = ?";
    $types .= 's';
    $params[] = $search;
} elseif ($isRoute) {
    $busSql .= " AND bus_route = ?";
    $types .= 's';
    $params[] = $search;
} elseif ($isVehicle) {
    $busSql .= " AND vehicle_number = ?";
    $types .= 's';
    $params[] = $search;
}
$busSql .= " ORDER BY date DESC";
$busStmt = $conn->prepare($busSql);
if ($params) $busStmt->bind_param($types, ...$params);
$busStmt->execute();
$result = $busStmt->get_result();
$totalBus = 0;
$busFound = false;
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['date']}</td><td>{$row['vehicle_number']}</td><td>{$row['bus_route']}</td><td>{$row['time_in']}</td><td>{$row['num_employees']}</td></tr>";
    $totalBus += $row['num_employees'];
    $busFound = true;
}
if (!$busFound) {
    echo "<tr><td colspan='5'>No records found in Bus table.</td></tr>";
}
?>
                                            </tbody>
                                            <tfoot>
                                                <tr><td colspan="4"><strong>Total Employees</strong></td><td><strong><?php echo $totalBus; ?></strong></td></tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Auto Table -->
                        <div class="col-xl-6 col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-success">Auto Route</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Vehicle Number</th>
                                                    <th>Auto Route</th>
                                                    <th>Time In</th>
                                                    <th>No. of Employees</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
$autoSql = "SELECT date, vehicleNumber, busRoute, timeIn, numEmployees FROM Auto_entry WHERE 1";
$params = [];
$types = '';
if ($isDate) {
    $autoSql .= " AND date = ?";
    $types .= 's';
    $params[] = $search;
} elseif ($isRoute) {
    $autoSql .= " AND busRoute = ?";
    $types .= 's';
    $params[] = $search;
} elseif ($isVehicle) {
    $autoSql .= " AND vehicleNumber = ?";
    $types .= 's';
    $params[] = $search;
}
$autoSql .= " ORDER BY date DESC";
$autoStmt = $conn->prepare($autoSql);
if ($params) $autoStmt->bind_param($types, ...$params);
$autoStmt->execute();
$result = $autoStmt->get_result();
$totalAuto = 0;
$autoFound = false;
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['date']}</td><td>{$row['vehicleNumber']}</td><td>{$row['busRoute']}</td><td>{$row['timeIn']}</td><td>{$row['numEmployees']}</td></tr>";
    $totalAuto += $row['numEmployees'];
    $autoFound = true;
}
if (!$autoFound) {
    echo "<tr><td colspan='5'>No records found in Auto table.</td></tr>";
}
?>
                                            </tbody>
                                            <tfoot>
                                                <tr><td colspan="4"><strong>Total Employees</strong></td><td><strong><?php echo $totalAuto; ?></strong></td></tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?php if ($totalBus > 0 || $totalAuto > 0): ?>
                    <style>
  .card-hover-effect {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card-hover-effect:hover {
    transform: scale(1.02);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2);
  }

  .gradient-header {
    background: linear-gradient(90deg, #004e92, #000428); /* Blue gradient */
    color: #ffffff;
  }

  .employee-total {
    font-size: 2.5rem;
    font-weight: 800;
    color: #198754; /* Bootstrap green */
  }

  .subtext {
    font-size: 0.95rem;
    color: #6c757d;
  }
</style>

<div class="row">
  <div class="col-xl-12 col-lg-12 mb-4">
    <div class="card shadow card-hover-effect border-0">
      <div class="card-header gradient-header d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold"><i class="fas fa-user-tie me-2"></i>Total Employees (Bus + Auto)</h5>
        <i class="fas fa-users fa-lg"></i>
      </div>
      <div class="card-body text-center">
        <div class="employee-total">
          <?php echo $totalBus + $totalAuto; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>