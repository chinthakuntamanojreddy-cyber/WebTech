<?php
// Database connection details
$servername = "YOUR_DB_HOST";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$dbname = "YOUR_DB_USERNAME_vechile_management";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Fetch Auto_entry data
$auto_entries = [];
$sql1 = "SELECT timeIn, numEmployees, busRoute FROM Auto_entry ORDER BY timeIn";
$result1 = $conn->query($sql1);
while ($row = $result1->fetch_assoc()) {
    $auto_entries[] = [
        'time' => $row['timeIn'],
        'count' => $row['numEmployees'],
        'route' => 'Auto - ' . $row['busRoute']
    ];
}

// Fetch Bus_entry data
$bus_entries = [];
$sql2 = "SELECT time_in, num_employees, bus_route FROM Bus_entry ORDER BY time_in";
$result2 = $conn->query($sql2);
while ($row = $result2->fetch_assoc()) {
    $bus_entries[] = [
        'time' => $row['time_in'],
        'count' => $row['num_employees'],
        'route' => 'Bus - ' . $row['bus_route']
    ];
}

$conn->close();

// Merge all entries
$all_entries = array_merge($auto_entries, $bus_entries);

// Sort by time
usort($all_entries, function ($a, $b) {
    return strcmp($a['time'], $b['time']);
});

// Initialize counts for each time range
$auto_entries_830_840 = 0;
$auto_entries_840_850 = 0;
$auto_entries_850_900 = 0;

$bus_entries_830_840 = 0;
$bus_entries_840_850 = 0;
$bus_entries_850_900 = 0;

// Calculate the counts for each time range for auto entries
foreach ($auto_entries as $entry) {
    $entry_time = $entry['time'];
    if (strtotime($entry_time) >= strtotime('08:30:00') && strtotime($entry_time) < strtotime('08:40:00')) {
        $auto_entries_830_840 += $entry['count'];
    } elseif (strtotime($entry_time) >= strtotime('08:40:00') && strtotime($entry_time) < strtotime('08:50:00')) {
        $auto_entries_840_850 += $entry['count'];
    } elseif (strtotime($entry_time) >= strtotime('08:50:00') && strtotime($entry_time) < strtotime('09:00:00')) {
        $auto_entries_850_900 += $entry['count'];
    }
}

// Calculate the counts for each time range for bus entries
foreach ($bus_entries as $entry) {
    $entry_time = $entry['time'];
    if (strtotime($entry_time) >= strtotime('08:30:00') && strtotime($entry_time) < strtotime('08:40:00')) {
        $bus_entries_830_840 += $entry['count'];
    } elseif (strtotime($entry_time) >= strtotime('08:40:00') && strtotime($entry_time) < strtotime('08:50:00')) {
        $bus_entries_840_850 += $entry['count'];
    } elseif (strtotime($entry_time) >= strtotime('08:50:00') && strtotime($entry_time) < strtotime('09:00:00')) {
        $bus_entries_850_900 += $entry['count'];
    }
}

// Calculate totals for each time range
$total_830_840 = $auto_entries_830_840 + $bus_entries_830_840;
$total_840_850 = $auto_entries_840_850 + $bus_entries_840_850;
$total_850_900 = $auto_entries_850_900 + $bus_entries_850_900;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Entries</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .container {
            max-width: 600px; /* Reduced width for simplicity */
            margin: 50px auto; /* Centered horizontally */
        }
        .card-header {
            background-color: #4e73df;
            color: white;
        }
        .card-body {
            padding: 20px;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .legend i {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header text-center">
                <h3>Vehicle Entries (Auto & Bus) by Time</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Pie Chart -->
                    <div class="col-md-12">
                        <div class="chart-container">
                            <canvas id="myPieChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="row mt-4">
                    <div class="col text-center legend">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> 08:30 - 08:40
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> 08:40 - 08:50
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> 08:50 - 09:00
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to render the pie chart -->
    <script>
        var total_830_840 = <?php echo $total_830_840; ?>;
        var total_840_850 = <?php echo $total_840_850; ?>;
        var total_850_900 = <?php echo $total_850_900; ?>;

        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie', 
            data: {
                labels: ['08:30 - 08:40', '08:40 - 08:50', '08:50 - 09:00'],
                datasets: [{
                    data: [total_830_840, total_840_850, total_850_900], 
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)"
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' vehicles';
                            }
                        }
                    }
                }
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
