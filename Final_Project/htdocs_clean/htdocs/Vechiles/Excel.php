<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

// Load your Excel template with chart styling
$spreadsheet = IOFactory::load('chart_template.xltx');

$servername = "YOUR_DB_HOST";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$dbname = "YOUR_DB_USERNAME_vechile_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ===================== Fetch Summary Data =====================
$sql = "
SELECT dates.date AS date,
       COALESCE(bus.total, 0) AS bus_total,
       COALESCE(auto.total, 0) AS auto_total,
       COALESCE(bus.total, 0) + COALESCE(auto.total, 0) AS total
FROM
    (SELECT DISTINCT date FROM Bus_entry
     UNION
     SELECT DISTINCT date FROM Auto_entry) AS dates
LEFT JOIN
    (SELECT date, SUM(num_employees) AS total FROM Bus_entry GROUP BY date) AS bus
ON dates.date = bus.date
LEFT JOIN
    (SELECT date, SUM(numEmployees) AS total FROM Auto_entry GROUP BY date) AS auto
ON dates.date = auto.date
ORDER BY dates.date ASC;
";

$result = $conn->query($sql);
$summaryData = [];
while ($row = $result->fetch_assoc()) {
    $summaryData[] = $row;
}

// ===================== Fetch Bus & Auto Raw Data =====================
$busResult = $conn->query("SELECT date, vehicle_number, bus_route, time_in, num_employees FROM Bus_entry ORDER BY date ASC");
$busData = [];
while ($row = $busResult->fetch_assoc()) {
    $busData[] = $row;
}

$autoResult = $conn->query("SELECT date, vehicleNumber, busRoute, timeIn, numEmployees FROM Auto_entry ORDER BY date ASC");
$autoData = [];
while ($row = $autoResult->fetch_assoc()) {
    $autoData[] = $row;
}

// ===================== Setup styles =====================
$defaultBorderStyle = [
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
];

// ======================= Sheet 1: SUMMARY =======================
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Summary");

$headers = ['Date', 'Bus Route Employees', 'Auto Route Employees', 'Total Employees'];
$sheet->fromArray($headers, null, 'A1');
$sheet->getStyle('A1:D1')->getFont()->setBold(true);
$sheet->getStyle('A1:D1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0FFFF');
$sheet->getStyle('A1:D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1:D1')->applyFromArray($defaultBorderStyle);

$rowNum = 2;
foreach ($summaryData as $row) {
    $sheet->setCellValue("A$rowNum", $row['date']);
    $sheet->setCellValue("B$rowNum", $row['bus_total']);
    $sheet->setCellValue("C$rowNum", $row['auto_total']);
    $sheet->setCellValue("D$rowNum", $row['total']);
    $sheet->getStyle("A$rowNum:D$rowNum")->applyFromArray($defaultBorderStyle);
    $sheet->getStyle("A$rowNum:D$rowNum")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $rowNum++;
}
foreach (range('A', 'D') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$endRow = $rowNum - 1;
$categories = new DataSeriesValues('String', "Summary!A2:A$endRow", null, $endRow - 1);

// ======================= Charts =======================

// Bus Chart (Top Left)
$busSeries = new DataSeriesValues('Number', "Summary!B2:B$endRow", null, $endRow - 1);
$chartBus = new Chart(
    'BusEmployees',
    new Title('Bus Employees'),
    new Legend(Legend::POSITION_RIGHT, null, false),
    new PlotArea(null, [new DataSeries(DataSeries::TYPE_LINECHART, null, range(0, 0), [], [$categories], [$busSeries])])
);
$chartBus->setTopLeftPosition('F2');
$chartBus->setBottomRightPosition('L15');

// Auto Chart (Top Right)
$autoSeries = new DataSeriesValues('Number', "Summary!C2:C$endRow", null, $endRow - 1);
$chartAuto = new Chart(
    'AutoEmployees',
    new Title('Auto Employees'),
    new Legend(Legend::POSITION_RIGHT, null, false),
    new PlotArea(null, [new DataSeries(DataSeries::TYPE_LINECHART, null, range(0, 0), [], [$categories], [$autoSeries])])
);
$chartAuto->setTopLeftPosition('M2');
$chartAuto->setBottomRightPosition('S15');

// Total Chart (Bottom Center)
$totalSeries = new DataSeriesValues('Number', "Summary!D2:D$endRow", null, $endRow - 1);
$chartTotal = new Chart(
    'TotalEmployees',
    new Title('Total Employees'),
    new Legend(Legend::POSITION_RIGHT, null, false),
    new PlotArea(null, [new DataSeries(DataSeries::TYPE_LINECHART, null, range(0, 0), [], [$categories], [$totalSeries])])
);
$chartTotal->setTopLeftPosition('H17');
$chartTotal->setBottomRightPosition('P30');

// Add Charts
$sheet->addChart($chartBus);
$sheet->addChart($chartAuto);
$sheet->addChart($chartTotal);

// ======================= Sheet 2: BUS =======================
$busSheet = $spreadsheet->getSheetByName('Bus');
if ($busSheet === null) {
    $busSheet = $spreadsheet->createSheet();
}
$busSheet->setTitle('Bus');
$busHeaders = ['Date', 'Vehicle Number', 'Bus Route', 'Time In', 'No. of Employees'];
$busSheet->fromArray($busHeaders, null, 'A1');
$row = 2;
foreach ($busData as $entry) {
    $busSheet->setCellValue("A{$row}", $entry['date']);
    $busSheet->setCellValue("B{$row}", $entry['vehicle_number']);
    $busSheet->setCellValue("C{$row}", $entry['bus_route']);
    $busSheet->setCellValue("D{$row}", $entry['time_in']);
    $busSheet->setCellValue("E{$row}", $entry['num_employees']);
    $row++;
}
$busSheet->getStyle("A1:E" . ($row - 1))->applyFromArray($defaultBorderStyle);
$busSheet->getStyle("A1:E1")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('90EE90');
$busSheet->getStyle("A1:E1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
foreach (range('A', 'E') as $col) {
    $busSheet->getColumnDimension($col)->setAutoSize(true);
}

// ======================= Sheet 3: AUTO =======================
$autoSheet = $spreadsheet->getSheetByName('Auto');
if ($autoSheet === null) {
    $autoSheet = $spreadsheet->createSheet();
}
$autoSheet->setTitle('Auto');
$autoHeaders = ['Date', 'Vehicle Number', 'Auto Route', 'Time In', 'No. of Employees'];
$autoSheet->fromArray($autoHeaders, null, 'A1');
$row = 2;
foreach ($autoData as $entry) {
    $autoSheet->setCellValue("A{$row}", $entry['date']);
    $autoSheet->setCellValue("B{$row}", $entry['vehicleNumber']);
    $autoSheet->setCellValue("C{$row}", $entry['busRoute']);
    $autoSheet->setCellValue("D{$row}", $entry['timeIn']);
    $autoSheet->setCellValue("E{$row}", $entry['numEmployees']);
    $row++;
}
$autoSheet->getStyle("A1:E" . ($row - 1))->applyFromArray($defaultBorderStyle);
$autoSheet->getStyle("A1:E1")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('ADD8E6');
$autoSheet->getStyle("A1:E1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
foreach (range('A', 'E') as $col) {
    $autoSheet->getColumnDimension($col)->setAutoSize(true);
}

// ======================= Output =======================
$spreadsheet->setActiveSheetIndex(0);
$todayDate = date('Y-m-d'); // e.g. 2025-05-27
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"Vehicle_Report_{$todayDate}.xlsx\"");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->setIncludeCharts(true);
$writer->save('php://output');
exit;
?>
