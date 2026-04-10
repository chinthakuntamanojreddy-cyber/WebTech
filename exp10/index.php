<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Management API</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #8b5cf6;
      --primary-hover: #7c3aed;
      --bg-dark: #0f172a;
      --glass-bg: rgba(30, 41, 59, 0.6);
      --glass-border: rgba(255, 255, 255, 0.1);
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Outfit', sans-serif;
      background: var(--bg-dark);
      background-image: 
        radial-gradient(circle at 15% 50%, rgba(139, 92, 246, 0.15), transparent 25%),
        radial-gradient(circle at 85% 30%, rgba(56, 189, 248, 0.15), transparent 25%);
      background-attachment: fixed;
      color: var(--text-main);
      min-height: 100vh;
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .container {
      width: 100%;
      max-width: 1000px;
      background: var(--glass-bg);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid var(--glass-border);
      border-radius: 24px;
      padding: 32px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    h2 {
      text-align: center;
      margin-bottom: 24px;
      font-size: 28px;
      font-weight: 700;
      background: linear-gradient(to right, #a78bfa, #38bdf8);
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: -0.5px;
    }

    .controls {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 16px;
      margin-bottom: 30px;
    }

    .controls input[type="text"],
    .controls select {
      padding: 12px 18px;
      background: rgba(15, 23, 42, 0.5);
      border: 1px solid var(--glass-border);
      border-radius: 12px;
      font-size: 15px;
      color: var(--text-main);
      outline: none;
      font-family: 'Outfit', sans-serif;
      transition: all 0.3s ease;
    }

    .controls input[type="text"]:focus,
    .controls select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
    }

    .controls input[type="text"] { width: 260px; }
    
    .controls select option { background: var(--bg-dark); }

    .controls button {
      padding: 12px 24px;
      background: linear-gradient(135deg, var(--primary), var(--primary-hover));
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 600;
      font-family: 'Outfit', sans-serif;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }
    .controls button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(139, 92, 246, 0.4);
    }

    .table-responsive {
      overflow-x: auto;
      border-radius: 16px;
      border: 1px solid var(--glass-border);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    thead tr {
      background: rgba(15, 23, 42, 0.7);
    }

    thead th {
      padding: 16px;
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--text-muted);
      border-bottom: 1px solid var(--glass-border);
    }

    tbody tr {
      transition: background 0.2s;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: rgba(255, 255, 255, 0.05); }

    tbody td {
      padding: 16px;
      font-size: 15px;
    }

    .no-result {
      text-align: center;
      padding: 30px;
      color: var(--text-muted);
      font-style: italic;
    }

    /* Course Badges */
    .badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      background: rgba(255,255,255,0.1);
    }
    .course-CS { color: #38bdf8; background: rgba(56, 189, 248, 0.15); }
    .course-IT { color: #a78bfa; background: rgba(167, 139, 250, 0.15); }
    .course-SE { color: #f472b6; background: rgba(244, 114, 182, 0.15); }
    .course-ECE { color: #fbbf24; background: rgba(251, 191, 36, 0.15); }
    .course-ME { color: #34d399; background: rgba(52, 211, 153, 0.15); }
  </style>
</head>
<body>

  <div class="container">
    <h2>Student Management API</h2>

    <div class="controls">
      <input type="text" id="searchInput" placeholder="Search student name..." oninput="renderTable()"/>
      <select id="courseFilter" onchange="renderTable()">
        <option value="All">All Courses</option>
        <option value="CS">CS</option>
        <option value="IT">IT</option>
        <option value="SE">SE</option>
        <option value="ECE">ECE</option>
        <option value="ME">ME</option>
      </select>
      <button onclick="sortByMarks()">Sort by Marks</button>
    </div>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Marks</th>
            <th>Course</th>
          </tr>
        </thead>
        <tbody id="tableBody"></tbody>
      </table>
    </div>
  </div>

  <script>
    let sortDesc = false;

    function sortByMarks() {
      sortDesc = !sortDesc;
      renderTable();
    }

    async function renderTable() {
      const search = document.getElementById("searchInput").value;
      const course = document.getElementById("courseFilter").value;

      const url = `api.php?search=${encodeURIComponent(search)}&course=${encodeURIComponent(course)}&sortDesc=${sortDesc}`;

      try {
        const response = await fetch(url);
        const filtered = await response.json();
        const tbody = document.getElementById("tableBody");

        if (filtered.length === 0) {
          tbody.innerHTML = `<tr><td colspan="5" class="no-result">No students found matching your criteria.</td></tr>`;
          return;
        }

        tbody.innerHTML = filtered.map(s => {
          const badgeClass = `badge course-${s.course}`;
          return `
            <tr>
              <td>#${s.id}</td>
              <td style="font-weight: 500;">${s.name}</td>
              <td>${s.age} yrs</td>
              <td style="font-weight: 600;">${s.marks}</td>
              <td><span class="${badgeClass}">${s.course}</span></td>
            </tr>
          `;
        }).join('');
      } catch (err) {
        console.error("Error fetching students:", err);
      }
    }

    // Initial render
    renderTable();
  </script>

</body>
</html>