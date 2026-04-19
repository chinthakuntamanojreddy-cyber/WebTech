<?php
// Database connection details
$servername = "sql207.infinityfree.com";
$username = "if0_38837486";
$password = "7396649051";
$dbname = "if0_38837486_vechile_management";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's date
$todayDate = date('Y-m-d');

// Prepare the HTML email content
$content = "<html><body>";
$content .= "<div class='row' style='font-family: \"Cinzel\", serif;'>";

$content .= "<p style='font-size: 18px; color: black;'>
                Respected [Factory Manager/Unit HR], This Is Today Vehicles Report
             </p>";

// Bus Entry Data (Card 1)
$content .= "<div class='col-xl-6 col-lg-6 mb-4'>
                <div class='card shadow'>
                    <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                        <p class='m-0 font-weight-bold text-primary' style='font-size: 15px;color:black;'>Bus Route</p>
                    </div>
                    <div class='card-body'>
                        <div class='table-responsive'>
                            <table style='width: 50%; border-collapse: collapse;text-align: center;'>
                                <thead style='background-color: #cce5ff;'>
                                    <tr>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Date</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Vehicle Number</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Bus Route</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Time In</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>No. of Employees</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>";

$bus_query = $conn->query("SELECT date, vehicle_number, bus_route, time_in, num_employees,reason 
                            FROM Bus_entry 
                            WHERE DATE(date) = '$todayDate' 
                            ORDER BY date DESC");

$totalEmployeesBus = 0;

if ($bus_query->num_rows > 0) {
    while ($row = $bus_query->fetch_assoc()) {
        $totalEmployeesBus += $row['num_employees'];
        $content .= "<tr>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['date']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['vehicle_number']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['bus_route']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['time_in']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['num_employees']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: " . (!empty($row['reason']) ? "red" : "black") . ";'>{$row['reason']}</td>
                     </tr>";
    }
} else {
    $content .= "<tr><td colspan='5' style='border: 1px solid #ddd; padding: 8px; color: black;'>No records found</td></tr>";
}

$content .= "         <tr style='font-weight: bold;'>
                        <td colspan='5' style='border: 1px solid #ddd; padding: 8px; color: black;'>Total No. of Employees</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>$totalEmployeesBus</td>
                     </tr>";

$content .= "         </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>";

// Auto Entry Data (Card 2)
$content .= "<div class='col-xl-6 col-lg-6 mb-4'>
                <div class='card shadow'>
                    <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                        <p class='m-0 font-weight-bold text-success' style='font-size: 15px;color:black;'>Auto Route </p>
                    </div>
                    <div class='card-body'>
                        <div class='table-responsive'>
                            <table style='width: 50%; border-collapse: collapse; text-align: center;'>
                                <thead style='background-color: #d4edda;'>
                                    <tr>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Date</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Vehicle Number</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Auto Route</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Time In</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>No. of Employees</th>
                                        <th style='border: 1px solid #ddd; padding: 8px; color: black;'>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>";

$auto_query = $conn->query("SELECT date, vehicleNumber, busRoute, timeIn, numEmployees,reason 
                            FROM Auto_entry 
                            WHERE DATE(date) = '$todayDate' 
                            ORDER BY date ASC");

$totalEmployeesAuto = 0;

if ($auto_query->num_rows > 0) {
    while ($row = $auto_query->fetch_assoc()) {
        $totalEmployeesAuto += $row['numEmployees'];
        $content .= "<tr>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['date']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['vehicleNumber']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['busRoute']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['timeIn']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['numEmployees']}</td>
                      <td style='border: 1px solid #ddd; padding: 8px; color: " . (!empty($row['reason']) ? "red" : "black") . ";'>{$row['reason']}</td>
                     </tr>";
    }
} else {
    $content .= "<tr><td colspan='5' style='border: 1px solid #ddd; padding: 8px; color: black;'>No records found</td></tr>";
}

$content .= "         <tr style='font-weight: bold;'>
                        <td colspan='5' style='border: 1px solid #ddd; padding: 8px; color: black;'>Total No. of Employees</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>$totalEmployeesAuto</td>
                     </tr>";

$content .= "         </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>";

// --- Bus Stats ---
$busQuery = "SELECT COUNT(DISTINCT vehicle_number) AS vehicle_count, 
                    SUM(num_employees) AS total_people
             FROM Bus_entry WHERE DATE(date) = '$todayDate'";
$busResult = mysqli_query($conn, $busQuery);
$busData = mysqli_fetch_assoc($busResult);
$busVehicleCount = $busData['vehicle_count'];
$busPeopleCount = $busData['total_people'];
$busAverage = ($busVehicleCount > 0) ? round($busPeopleCount / $busVehicleCount, 2) : 0;

// --- Auto Stats ---
$autoQuery = "SELECT COUNT(vehicleNumber) AS vehicle_count, 
                     SUM(numEmployees) AS total_people
              FROM Auto_entry 
              WHERE DATE(date) = '$todayDate'";
$autoResult = mysqli_query($conn, $autoQuery);
$autoData = mysqli_fetch_assoc($autoResult);

$autoVehicleCount = $autoData['vehicle_count'];
$autoPeopleCount = $autoData['total_people'];
$autoAverage = ($autoVehicleCount > 0) ? round($autoPeopleCount / $autoVehicleCount, 2) : 0;

$VehicleCountt = $busVehicleCount+$autoVehicleCount;
$PeopleCountt = $autoPeopleCount+$busPeopleCount;
$PeopleAverage = ($VehicleCountt > 0) ? number_format($PeopleCountt / $VehicleCountt, 2, '.', '') : 0;


// Display in table (your existing HTML block here)
$content .= "<div class='col-xl-12 col-lg-12 mb-4'>
    <div class='card shadow' style='width: 50%; margin-left: 0;'>
        <div class='card-header py-3'>
            <h5 class='m-0 font-weight-bold text-success' style='font-size: 15px;color:black;'>Summary</h5>
        </div>
        <div class='card-body'>
            <div class='table-responsive'>
                <table style='width: 100%; border-collapse: collapse; text-align: center;'>
                    <thead style='background-color: #f8f9fc;'>
                        <tr>
                            <th style='border: 1px solid #ccc; padding: 10px; color: black;'></th>
                            <th style='border: 1px solid #ccc; padding: 10px; color: black;'>Bus Route</th>
                            <th style='border: 1px solid #ccc; padding: 10px; color: black;'>Auto Route</th>
                            <th style='border: 1px solid #ccc; padding: 10px; color: black;'>Vehicles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>Vehicles</td>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>$busVehicleCount</td>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>$autoVehicleCount</td>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>$VehicleCountt</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>No. Of People</td>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>$busPeopleCount</td>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>$autoPeopleCount</td>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>$PeopleCountt</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>Avg</td>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>$busAverage</td>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>$autoAverage</td>
                            <td style='border: 1px solid #ccc; padding: 10px; color: black;'>$PeopleAverage</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>";
   
$content .= "<p style='font-size: 15px; color: black;'>
                Thank You,
             </p>";

$content .= "</div></body></html>";
// Set dynamic email content
$today = date('d/m/Y'); // Format: Day/Month/Year
$subject = "$today Attendance Report";

// API Key from SendGrid
$apiKey = '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';

// Sender email (must be verified in SendGrid)
$fromEmail = 'attendancereport341@gmail.com'; // updated to match your desired 'From'
$fromName  = 'Vehicles Report System';       // readable name

// Set multiple recipients
$recipients = [
    ['email' => 'rajasekharr341@gmail.com'],
    ['email' => 'vennapusarajasekharreddy341@gmail.com'],
    ['email' => 'prabhakar@example.com']
];

// Prepare the email data
$emailData = [
    'personalizations' => [
        [
            'to' => $recipients,
            'subject' => $subject
        ]
    ],
    'from' => ['email' => $fromEmail, 'name' => $fromName],
    'content' => [
        [
            'type' => 'text/html',
            'value' => $content
        ]
    ]
];

// Send the email via SendGrid API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Return JSON response
header('Content-Type: application/json');

if ($http_code == 202) {
    echo json_encode([
        'status' => 'success',
        'message' => '✅ Email sent successfully!'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Failed to send email.',
        'response' => $response
    ]);
}

// Close the database connection
$conn->close();
?>
