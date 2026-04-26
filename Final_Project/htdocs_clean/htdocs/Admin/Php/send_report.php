<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Database connection details
$servername = "YOUR_DB_HOST";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$dbname = "YOUR_DB_USERNAME_vechile_management";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$todayDate = date('Y-m-d');

/* ---------------------------------------------------------
   🚫 STOP EMAIL IF BOTH TABLES ARE EMPTY
------------------------------------------------------------ */
$checkBus = $conn->query("SELECT COUNT(*) AS c FROM Bus_entry WHERE DATE(date) = '$todayDate'");
$checkAuto = $conn->query("SELECT COUNT(*) AS c FROM Auto_entry WHERE DATE(date) = '$todayDate'");

if ($checkBus->fetch_assoc()['c'] == 0 && $checkAuto->fetch_assoc()['c'] == 0) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'no_data',
        'message' => '🚫 No data found for today. Email not sent.'
    ]);
    exit;
}

/* ---------------------------------------------------------
   EMAIL CONTENT START
------------------------------------------------------------ */

$content = "<html><body>";
$content .= "<div class='row' style='font-family: \"Cinzel\", serif;'>";

$content .= "<p style='font-size: 18px; color: black;'>
                Respected Factory Manager/Unit HR,
                This Is Today ABGL Vehicles Report
             </p>";

/* ---------------------------------------------------------
   BUS ROUTE CARD (NO STYLING CHANGES)
------------------------------------------------------------ */

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

$bus_query = $conn->query("
    SELECT date, vehicle_number, bus_route, time_in, num_employees, reason
    FROM Bus_entry 
    WHERE DATE(date) = '$todayDate'
    ORDER BY date DESC
");

$totalEmployeesBus = 0;

if ($bus_query->num_rows > 0) {
    while ($row = $bus_query->fetch_assoc()) {
        $totalEmployeesBus += $row['num_employees'];
        $reasonColor = !empty($row['reason']) ? "red" : "black";

        $content .= "<tr>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['date']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['vehicle_number']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['bus_route']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['time_in']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['num_employees']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: $reasonColor;'>{$row['reason']}</td>
                     </tr>";
    }
} else {
    $content .= "<tr><td colspan='6' style='border: 1px solid #ddd; padding: 8px; color: black;'>No records found</td></tr>";
}

$content .= "<tr style='font-weight: bold;'>
                <td colspan='5' style='border: 1px solid #ddd; padding: 8px; color: black;'>Total No. of Employees</td>
                <td style='border: 1px solid #ddd; padding: 8px; color: black;'>$totalEmployeesBus</td>
             </tr>
        </tbody></table></div></div></div>";

/* ---------------------------------------------------------
   AUTO ROUTE CARD (NO STYLING CHANGES)
------------------------------------------------------------ */

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

$auto_query = $conn->query("
    SELECT date, vehicleNumber, busRoute, timeIn, numEmployees, reason
    FROM Auto_entry
    WHERE DATE(date) = '$todayDate'
    ORDER BY date ASC
");

$totalEmployeesAuto = 0;

if ($auto_query->num_rows > 0) {
    while ($row = $auto_query->fetch_assoc()) {
        $totalEmployeesAuto += $row['numEmployees'];
        $reasonColor = !empty($row['reason']) ? "red" : "black";

        $content .= "<tr>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['date']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['vehicleNumber']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['busRoute']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['timeIn']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: black;'>{$row['numEmployees']}</td>
                        <td style='border: 1px solid #ddd; padding: 8px; color: $reasonColor;'>{$row['reason']}</td>
                     </tr>";
    }
} else {
    $content .= "<tr><td colspan='6' style='border: 1px solid #ddd; padding: 8px; color: black;'>No records found</td></tr>";
}

$content .= "<tr style='font-weight: bold;'>
                <td colspan='5' style='border: 1px solid #ddd; padding: 8px; color: black;'>Total No. of Employees</td>
                <td style='border: 1px solid #ddd; padding: 8px; color: black;'>$totalEmployeesAuto</td>
             </tr>
        </tbody></table></div></div></div>";

/* ---------------------------------------------------------
   SUMMARY BLOCK (UNCHANGED)
------------------------------------------------------------ */

$busStats = $conn->query("
    SELECT COUNT(vehicle_number) AS vehicle_count, SUM(num_employees) AS total_people
    FROM Bus_entry WHERE DATE(date) = '$todayDate'
")->fetch_assoc();

$autoStats = $conn->query("
    SELECT COUNT(vehicleNumber) AS vehicle_count, SUM(numEmployees) AS total_people
    FROM Auto_entry WHERE DATE(date) = '$todayDate'
")->fetch_assoc();

$busVehicleCount = $busStats['vehicle_count'] ?? 0;
$busPeopleCount  = $busStats['total_people'] ?? 0;

$autoVehicleCount = $autoStats['vehicle_count'] ?? 0;
$autoPeopleCount  = $autoStats['total_people'] ?? 0;

$VehicleCountt = $busVehicleCount + $autoVehicleCount;
$PeopleCountt  = $busPeopleCount + $autoPeopleCount;

$busAverage  = ($busVehicleCount > 0) ? round($busPeopleCount / $busVehicleCount, 2) : 0;
$autoAverage = ($autoVehicleCount > 0) ? round($autoPeopleCount / $autoVehicleCount, 2) : 0;
$PeopleAverage = ($VehicleCountt > 0) ? round($PeopleCountt / $VehicleCountt, 2) : 0;

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

$content .= "<p style='font-size: 15px; color: black; margin: 8px 0;'>
    Thank You,<br>
    ABGL Dashboard - <a href='https://vechiclesmanagement.infinityfreeapp.com/Admin/Dashboard.php?i=1' 
    style='color: blue; text-decoration: underline;' target='_blank'>
    Open Dashboard
    </a>
</p>";
$content .= "</div></body></html>";


/* ---------------------------------------------------------
   SEND EMAIL
------------------------------------------------------------ */

$gmailEmail = 'attendancereport341@gmail.com';
$gmailAppPassword = 'ayghsliffmgjqkci';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $gmailEmail;
    $mail->Password = $gmailAppPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

   $mail->setFrom($gmailEmail, 'Vehicles Report System');
    
    $mail->addAddress('chinthakuntamanojreddy@gmail.com');
    
    $mail->isHTML(true);
    $mail->Subject = date('d/m/Y') . ' Vehicle Attendance Report';
    $mail->Body = $content;

    $mail->send();

    echo json_encode([
        'status' => 'success',
        'message' => '✅ Email sent successfully!'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Failed to send email.',
        'error' => $mail->ErrorInfo
    ]);
}

$conn->close();
?>
