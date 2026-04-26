<?php
$servername = "YOUR_DB_HOST";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$dbname = "YOUR_DB_USERNAME_vechile_management";

$conn = new mysqli($servername, $username, $password, $dbname);

date_default_timezone_set('Asia/Kolkata');
$todayDate = date('Y-m-d');

$auto_entries = [];
$sql1 = "SELECT timeIn, numEmployees, busRoute FROM Auto_entry WHERE DATE(date) = '$todayDate' ORDER BY timeIn";
$result1 = $conn->query($sql1);
while ($row = $result1->fetch_assoc()) {
    $auto_entries[] = [
        'time' => $row['timeIn'],
        'count' => $row['numEmployees'],
        'route' => 'Auto - ' . $row['busRoute']
    ];
}

$bus_entries = [];
$sql2 = "SELECT time_in, num_employees, bus_route FROM Bus_entry WHERE DATE(date) = '$todayDate' ORDER BY time_in";
$result2 = $conn->query($sql2);
while ($row = $result2->fetch_assoc()) {
    $bus_entries[] = [
        'time' => $row['time_in'],
        'count' => $row['num_employees'],
        'route' => 'Bus - ' . $row['bus_route']
    ];
}

$conn->close();

$all_entries = array_merge($auto_entries, $bus_entries);

usort($all_entries, function ($a, $b) {
    return strcmp($a['time'], $b['time']);
});
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet">

<link href="css/sb-admin-2.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body id="page-top">

    <div id="wrapper">

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
<div class="d-flex justify-content-between align-items-center w-100 my-2">
    
    <a href="../index.php" class="btn btn-success shadow-sm" style="font-size: 16px; font-family: 'Cinzel', serif; padding: 10px 20px; min-width: 150px;">
        <i class="fas fa-bus fa-sm text-white-50"></i> Bus Details
    </a>

<a href="Histroy.php" class="btn btn-info shadow-sm" style="font-size: 16px; font-family: 'Cinzel', serif; padding: 10px 20px; min-width: 150px;">
    <i class="fas fa-history fa-sm text-white-50"></i> History
</a>

</div>
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                </nav>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                       <h1 class="h3 mb-0 text-gray-800" style="font-family: 'Cinzel', serif; font-size: 36px; font-weight: bold; color: #ffffff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
  Dashboard
</h1>
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="sendEmail()">
    <i class="fas fa-download fa-sm text-white-50"></i> Send Report
</a>

</div>
<script>
function sendEmail() {
    if (confirm("Are you sure you want to send the attendance report?")) {
        let statusElement = document.getElementById('status');
        statusElement.innerText = '📨 Sending...';

        fetch('Php/send_report.php', {
            method: 'POST',
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                statusElement.innerText = '✅ ' + data.message;
            } else {
                statusElement.innerText = '❌ ' + data.message;
                console.error("PHPMailer Error:", data.error);
            }
        })
        .catch(error => {
            statusElement.innerText = '❌ Failed to send email.';
            console.error('Fetch Error:', error);
        });
    }
}
</script>
<div
<div id="status" style="margin-top: 20px; font-size: 18px; font-weight: bold;"></div>
                    </div>
                    <div class="row">
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-dark shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1" style="font-family: 'Cinzel', serif;">
                        Date</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="currentDate">--</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const today = new Date();
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    document.getElementById("currentDate").textContent = today.toLocaleDateString(undefined, options);
</script>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-family: 'Cinzel', serif;">
                                                Bus Route</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php
$servername = "YOUR_DB_HOST";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$dbname = "YOUR_DB_USERNAME_vechile_management";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<div class="h5 mb-0 font-weight-bold text-gray-800">
  
   <?php
date_default_timezone_set('Asia/Kolkata');
$todayDate = date('Y-m-d');

$query = "SELECT COUNT( vehicle_number) AS total_vehicles, 
                 SUM(num_employees) AS total_employees 
          FROM Bus_entry 
          WHERE DATE(date) = '$todayDate'";

$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    echo $row['total_vehicles'] . " - " . $row['total_employees'];
} else {
    echo "Summary data not available.";
}
?>


</div>
 </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-bus fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-family: 'Cinzel', serif;">
                        Auto Route</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php
$servername = "YOUR_DB_HOST";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$dbname = "YOUR_DB_USERNAME_vechile_management";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<div class="h5 mb-0 font-weight-bold text-gray-800">
   <?php
date_default_timezone_set('Asia/Kolkata');
$todayDate = date('Y-m-d');

$query = "SELECT COUNT(vehicleNumber) AS total_vehicles, 
                 SUM(numEmployees) AS total_employees 
          FROM Auto_entry 
          WHERE DATE(date) = '$todayDate'";

$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    echo $row['total_vehicles'] . " - " . $row['total_employees'];
} else {
    echo "Summary data not available.";
}
?>

</div>
</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-route fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-family: 'Cinzel', serif;">
                        Total Employees</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><div class="h5 mb-0 font-weight-bold text-gray-800">
   <?php
date_default_timezone_set('Asia/Kolkata');
$todayDate = date('Y-m-d');

$bus_query = $conn->query("SELECT SUM(num_employees) AS total_bus FROM Bus_entry WHERE DATE(date) = '$todayDate'");
$bus_total = ($bus_query && $row = $bus_query->fetch_assoc()) ? $row['total_bus'] ?? 0 : 0;

$auto_query = $conn->query("SELECT SUM(numEmployees) AS total_auto FROM Auto_entry WHERE DATE(date) = '$todayDate'");
$auto_total = ($auto_query && $row = $auto_query->fetch_assoc()) ? $row['total_auto'] ?? 0 : 0;

$grand_total = $bus_total + $auto_total;

echo $grand_total;
?>


</div>
</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
                    </div>

<div class="row">
    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary" style="font-family: 'Cinzel', serif;">Bus Route (Today)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Date</th>
                                <th>Vehicle</th>
                                <th>Bus Route</th>
                                <th>Time In</th>
                                <th>Employees</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                       <?php
date_default_timezone_set('Asia/Kolkata');
$todayDate = date('Y-m-d');

$sql = "SELECT id, date, vehicle_number, bus_route, time_in, num_employees,reason 
        FROM Bus_entry 
        WHERE DATE(date) = '$todayDate' 
        ORDER BY date DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td style='font-size:15px'>{$row['date']}</td>
                <td>{$row['vehicle_number']}</td>
                <td>{$row['bus_route']}</td>
                <td>{$row['time_in']}</td>
                <td style='position:relative;'>
                    {$row['num_employees']}
                    <button 
                        class='delete-btn' 
                        data-id='{$row['id']}' 
                        data-table='Bus_entry' 
                        title='Delete' 
                        style='border:none; background:none; color:red; cursor:pointer; font-size:1.2rem; position:absolute; right:5px; top:50%; transform: translateY(-50%);'>
                        &#128465;
                    </button>
                </td>
                <td style='border: 1px solid #ddd; padding: 8px; color: " . (!empty($row['reason']) ? "red" : "black") . ";'>{$row['reason']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success" style="font-family: 'Cinzel', serif;">Auto Route (Today)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-success">
                            <tr>
                                <th>Date</th>
                                <th>Vehicle</th>
                                <th>Auto Route</th>
                                <th>Time In</th>
                                <th>Employees</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           $sql = "SELECT id, date, vehicleNumber, busRoute, timeIn, numEmployees,reason 
                                   FROM Auto_entry 
                                   WHERE DATE(date) = '$todayDate' 
                                   ORDER BY date ASC";

                           $result = $conn->query($sql);

                           if ($result && $result->num_rows > 0) {
                               while ($row = $result->fetch_assoc()) {
                                   echo "<tr>
                                           <td>{$row['date']}</td>
                                           <td>{$row['vehicleNumber']}</td>
                                           <td>{$row['busRoute']}</td>
                                           <td>{$row['timeIn']}</td>
                                           <td style='position:relative;'>
                                                {$row['numEmployees']}
                                                <button 
                                                    class='delete-btn' 
                                                    data-id='{$row['id']}' 
                                                    data-table='Auto_entry' 
                                                    title='Delete' 
                                                    style='border:none; background:none; color:red; cursor:pointer; font-size:1.2rem; position:absolute; right:5px; top:50%; transform: translateY(-50%);'>
                                                    &#128465;
                                                </button>
                                           </td>
                                           <td style='border: 1px solid #ddd; padding: 8px; color: " . (!empty($row['reason']) ? "red" : "black") . ";'>{$row['reason']}</td>
                                         </tr>";
                               }
                           } else {
                               echo "<tr><td colspan='5'>No records found</td></tr>";
                           }
                           ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', () => {
      if (!confirm('Are you sure you want to delete this record?')) return;

      const id = button.getAttribute('data-id');
      const table = button.getAttribute('data-table');

      fetch('delete_entry.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id) + '&table=' + encodeURIComponent(table)
      })
      .then(res => res.text())
      .then(data => {
        if (data.trim() === 'success') {
          button.closest('tr').remove();
        } else {
          alert('Delete failed: ' + data);
        }
      })
      .catch(err => alert('Error: ' + err));
    });
  });
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <div class="row">
                        <div class="col-xl-8 col-lg-6 col-md-8">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                     <h6 class="m-0 font-weight-bold text-primary" style="font-family: 'Cinzel', serif;">Vehicle Entry  by Time and Route</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="vehicleChart" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
const ctx = document.getElementById('vehicleChart').getContext('2d');

const labels = <?php echo json_encode(array_column($all_entries, 'time')); ?>;
const data = <?php echo json_encode(array_column($all_entries, 'count')); ?>;
const routeInfo = <?php echo json_encode(array_column($all_entries, 'route')); ?>;

const pointColors = routeInfo.map(route => {
    if (route.startsWith('Auto')) return 'rgba(255, 206, 86, 1)';
    if (route.startsWith('Bus')) return 'rgba(54, 162, 235, 1)';
    return 'rgba(255, 99, 132, 1)';
});

const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Employee Entries',
            data: data,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: pointColors,
            pointHoverBackgroundColor: pointColors
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    title: function(context) {
                        return 'Time: ' + context[0].label;
                    },
                    label: function(context) {
                        const index = context.dataIndex;
                        return 'Employees: ' + context.parsed.y + ' (' + routeInfo[index] + ')';
                    }
                }
            },
            title: {
                display: true,
                text: 'Time vs No. of Employees with Route Info'
            },
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Time (HH:MM:SS)'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Number of Employees'
                },
                beginAtZero: true
            }
        }
    }
});
</script>
<?php
$servername = "YOUR_DB_HOST";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$dbname = "YOUR_DB_USERNAME_vechile_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_date = date('Y-m-d');

$query = "
    SELECT 
        SUM(CASE WHEN time_in >= '08:45:00' AND time_in < '08:50:00' THEN 1 ELSE 0 END) AS vehicles_8_45_8_50,
        SUM(CASE WHEN time_in >= '08:50:00' AND time_in < '08:59:59' THEN 1 ELSE 0 END) AS vehicles_8_50_8_59,
        SUM(CASE WHEN time_in >= '09:00:00' THEN 1 ELSE 0 END) AS vehicles_after_9,
        SUM(CASE WHEN time_in >= '08:45:00' AND time_in < '08:50:00' THEN num_employees ELSE 0 END) AS emp_8_45_8_50,
        SUM(CASE WHEN time_in >= '08:50:00' AND time_in < '08:59:59' THEN num_employees ELSE 0 END) AS emp_8_50_8_59,
        SUM(CASE WHEN time_in >= '09:00:00' THEN num_employees ELSE 0 END) AS emp_after_9
    FROM Bus_entry
    WHERE DATE(date) = '$current_date'
";

$result = $conn->query($query);

$bus_8_45_8_50 = $bus_8_50_8_59 = $bus_after_9 = 0;
$emp_8_45_8_50 = $emp_8_50_8_59 = $emp_after_9 = 0;

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $bus_8_45_8_50 = $row['vehicles_8_45_8_50'];
    $bus_8_50_8_59 = $row['vehicles_8_50_8_59'];
    $bus_after_9   = $row['vehicles_after_9'];
    $emp_8_45_8_50 = $row['emp_8_45_8_50'];
    $emp_8_50_8_59 = $row['emp_8_50_8_59'];
    $emp_after_9   = $row['emp_after_9'];
}

$conn->close();
?>

<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Vehicles Entry</h6>
        </div>
        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
            </div>
            <div class="mt-4 text-center small">
                <span class="mr-2"><i class="fas fa-circle" style="color: #28a745;"></i> Bus 8:45-8:50</span>
                <span class="mr-2"><i class="fas fa-circle" style="color: #ffc107;"></i> Bus 8:50-8:59</span>
                <span class="mr-2"><i class="fas fa-circle" style="color: #dc3545;"></i> Above 9:00</span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function() {
        const ctx = document.getElementById('myPieChart').getContext('2d');

        const vehicleCounts = [<?= $bus_8_45_8_50 ?>, <?= $bus_8_50_8_59 ?>, <?= $bus_after_9 ?>];
        const employeeCounts = [<?= $emp_8_45_8_50 ?>, <?= $emp_8_50_8_59 ?>, <?= $emp_after_9 ?>];

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    'Bus 8:45-8:50',
                    'Bus 8:50-8:59',
                    'Above 9:00'
                ],
                datasets: [{
                    data: vehicleCounts,
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#dc3545'
                    ],
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                const vehicle = vehicleCounts[index];
                                const emp = employeeCounts[index];
                                return `${context.label}: ${vehicle} vehicles, ${emp} employees`;
                            }
                        }
                    }
                }
            }
        });
    };
</script>

</div>
<?php 
$servername = "YOUR_DB_HOST";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$dbname = "YOUR_DB_USERNAME_vechile_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Kolkata');
$todayDate = date('Y-m-d');

$max1 = $conn->query("SELECT MAX(num_employees) AS max_count FROM Bus_entry WHERE DATE(date) = '$todayDate'")->fetch_assoc()['max_count'] ?? 1;
$busResult = $conn->query("SELECT bus_route, num_employees FROM Bus_entry WHERE DATE(date) = '$todayDate'");

$max2 = $conn->query("SELECT MAX(numEmployees) AS max_count FROM Auto_entry WHERE DATE(date) = '$todayDate'")->fetch_assoc()['max_count'] ?? 1;
$autoResult = $conn->query("SELECT busRoute, numEmployees FROM Auto_entry WHERE DATE(date) = '$todayDate'");
?>

<style>
    .bg-orange {
        background-color: orange !important;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bus Routes and Employees</h6>
            </div>
            <div class="card-body">
               <?php
$current_date = date('Y-m-d');

$busResult = $conn->query("SELECT bus_route, num_employees FROM Bus_entry WHERE DATE(date) = '$current_date' ORDER BY num_employees ASC");

if ($busResult->num_rows > 0) {
    while ($row = $busResult->fetch_assoc()) {
        $route = htmlspecialchars($row['bus_route']);
        $count = (int)$row['num_employees'];
        $width = ($count / $max1) * 100;

        if ($count >= 50) {
            $barClass = "bg-success";
        } elseif ($count >= 40) {
            $barClass = "bg-warning";
        } else {
            $barClass = "bg-danger";
        }

        echo '
        <h4 class="small font-weight-bold">
            ' . $route . '
            <span class="float-right">' . $count . '</span>
        </h4>
        <div class="progress mb-4">
            <div class="progress-bar ' . $barClass . '" role="progressbar" style="width: ' . $width . '%"
                aria-valuenow="' . $count . '" aria-valuemin="0" aria-valuemax="' . $max1 . '"></div>
        </div>';
    }
} else {
    echo "<p>No bus routes found.</p>";
}
?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Auto Routes and Employees</h6>
            </div>
            <div class="card-body">
             <?php
$current_date = date('Y-m-d');

$autoResult = $conn->query("SELECT busRoute, numEmployees FROM Auto_entry WHERE DATE(date) = '$current_date' ORDER BY numEmployees ASC");

if ($autoResult->num_rows > 0) {
    while ($row = $autoResult->fetch_assoc()) {
        $route = htmlspecialchars($row['busRoute']);
        $count = (int)$row['numEmployees'];
        $width = ($count / $max2) * 100;

        if ($count >= 15) {
            $barClass = "bg-success";
        } elseif ($count >= 10) {
            $barClass = "bg-warning";
        } else {
            $barClass = "bg-danger";
        }

        echo '
        <h4 class="small font-weight-bold">
            ' . $route . '
            <span class="float-right">' . $count . '</span>
        </h4>
        <div class="progress mb-4">
            <div class="progress-bar ' . $barClass . '" role="progressbar" style="width: ' . $width . '%"
                aria-valuenow="' . $count . '" aria-valuemin="0" aria-valuemax="' . $max2 . '"></div>
        </div>';
    }
} else {
    echo "<p>No auto routes found.</p>";
}

$conn->close();
?>
            </div>
        </div>
    </div>
</div>


            </div>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

    <script src="vendor/chart.js/Chart.min.js"></script>

    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>
</html>