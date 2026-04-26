<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Store Inward Form</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('BG5.jpg'); /* Replace with your actual image path */
      backdrop-filter: blur(5px);
      background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
      margin: 0;
      padding: 20px;
    }
    .top-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .top-bar h1 {
      font-size: 33px;
        color: #f0f0f0; /* light grey - clean and modern */
    }
    .submit-btn {
      background-color: #007bff;
      color: white;
      padding: 10px 24px;
      border: none;
      border-radius: 6px;
      font-size: 19px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .submit-btn:hover {
      background-color: #0056b3;
    }
    .form-container {
      background: white;
      padding: 25px 30px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 900px;
      margin: auto;
    }
    h1 {
      font-size: 30px;
      margin-bottom: 20px;
      color: #444;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 15px;
      color: #333;
    }
    input[type="text"], select, input[type="date"], input[type="time"], input[type="number"] {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background: #f9f9f9;
      font-size: 14px;
      transition: all 0.3s ease;
    }
    input[type="text"]:focus, select:focus, input[type="date"]:focus, input[type="time"]:focus, input[type="number"]:focus {
      background: #fff;
      border-color: #007bff;
      outline: none;
      box-shadow: 0 0 5px rgba(0,123,255,0.3);
    }
    .input-button-group {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .input-button-group input {
      flex: 1;
    }
    .input-button-group button {
      padding: 10px 16px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .input-button-group button:hover {
      background-color: #218838;
    }
    .button-group {
      margin-top: 20px;
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }
    .button-group button {
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      background-color: #007bff;
      color: white;
      transition: background-color 0.3s ease;
      flex: 1;
      min-width: 120px;
    }
    .button-group button:hover {
      background-color: #0056b3;
    }

    /* Responsive Design for Tab (Samsung Tab A9) and Mobile */
    @media (max-width: 820px) {
      .top-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
      .top-bar h1 {
        font-size: 20px;
      }
      .submit-btn {
        width: 100%;
      }
      .input-button-group {
        flex-direction: column;
        align-items: stretch;
      }
      .input-button-group button {
        width: 100%;
      }
      .button-group {
        flex-direction: column;
      }
      .button-group button {
        width: 100%;
      }
      .form-container {
        padding: 20px;
      }
    }
  </style>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="top-bar d-flex justify-content-between align-items-center p-3 border-bottom" style="background: transparent; font-family: 'Cinzel', serif;">
  <!-- White Heading, Smaller -->
  <h1 class="h6 m-0 text-white">Vehicle Management</h1>

  <!-- Buttons -->
  <div class="button-group">
    <a href="/index.php" class="btn btn-info btn-md shadow  px-4 py-2">
      <i class="fas fa-car fa-sm text-white-50"></i> Bus Details
    </a>
  <a href="Auto_Edit.html" class="btn btn-success btn-md shadow px-4 py-2">
    <i class="fas fa-edit fa-sm text-white-50"></i> Edit
  </a>
    <a href="/Admin/Dashboard.php" class="btn btn-primary btn-md shadow px-4 py-2">
      <i class="fas fa-user-shield fa-sm text-white-50"></i> Admin
    </a>
  </div>
</div>

<div class="form-container">
 <h1 style="font-family: 'Cinzel', serif;">Auto Details</h1>
  <form action="Save_Auto_Entry.php" method="post">
    <div class="form-grid">

      <div class="form-group">
        <label for="date">Date:</label>
        <div class="input-button-group">
          <input type="date" id="date" name="date" required>
          <button type="button" onclick="fillToday()" style="font-family: 'Cinzel', serif;">Today</button>
        </div>
      </div>
<?php
$data = json_decode(file_get_contents('options_data.json'), true);
?>
    
      <div class="form-group">
        <label for="vehicleNumber">Vehicle Number:</label>
        <select id="vehicleNumber" name="vehicleNumber">
  <option value="">-- Select Vehicle Number --</option>
  <?php foreach ($data['vehicleNumbers'] as $v): ?>
    <option value="<?= htmlspecialchars($v) ?>"><?= htmlspecialchars($v) ?></option>
  <?php endforeach; ?>
</select>
      </div>

      <div class="form-group">
          <div class="form-group">
        <label for="busRoute">Auto Route:</label>
        <select id="busRoute" name="busRoute">
  <option value="">-- Select Auto Route --</option>
  <?php foreach ($data['busRoutes'] as $r): ?>
    <option value="<?= htmlspecialchars($r) ?>"><?= htmlspecialchars($r) ?></option>
  <?php endforeach; ?>
</select>      </div>
      

<div class="form-group">
  <label for="timeIn">Time In:</label>
  <div class="input-button-group">
    <input type="time" id="timeIn" name="timeIn" required oninput="checkTime()">
    <button type="button" onclick="fillNow()" style="font-family: 'Cinzel', serif;">Now</button>
  </div>
</div>

<!-- Hidden field for late reason -->
<div class="form-group" id="whyContainer" style="display: none;">
  <label for="reason">Why (Late Reason):</label>
  <input type="text" id="reason" name="reason" placeholder="Enter Reason">
</div>

<script>
function fillNow() {
  const now = new Date();
  const hours = now.getHours().toString().padStart(2, '0');
  const minutes = now.getMinutes().toString().padStart(2, '0');
  document.getElementById("timeIn").value = `${hours}:${minutes}`;
  checkTime();
}

function checkTime() {
  const inputTime = document.getElementById("timeIn").value;
  const threshold = "09:10";

  const whyContainer = document.getElementById("whyContainer");
  const reasonInput = document.getElementById("reason");

  if (inputTime && inputTime > threshold) {
    whyContainer.style.display = "block";
    reasonInput.required = true;
  } else {
    whyContainer.style.display = "none";
    reasonInput.required = false;
  }
}
</script>

      <div class="form-group">
        <label for="numEmployees">Number Of Employees:</label>
        <input type="number" id="numEmployees" name="numEmployees" required>
      </div>

    </div>

    <div class="button-group">
      <button type="submit" style="font-family: 'Cinzel', serif;">Save</button>
      <button type="reset" style="font-family: 'Cinzel', serif;">Clear</button>
    </div>

  </form>
</div>

<script>
function fillToday() {
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('date').value = today;
}

function fillNow() {
  const now = new Date();
  let hours = now.getHours().toString().padStart(2, '0');
  let minutes = now.getMinutes().toString().padStart(2, '0');
  document.getElementById('timeIn').value = `${hours}:${minutes}`;
}
</script>

</body>
</html>
