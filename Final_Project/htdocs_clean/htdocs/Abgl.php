<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ABGL Systems</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    :root {
        --blue: #1e5fa3;
        --light-blue: #edf4fb;
        --card-blue: #f7fbff;
        --border: #d6e4f2;
        --text-dark: #1f2937;
    }

    body {
        margin: 0;
        font-family: "Segoe UI", Arial, sans-serif;
        background: var(--light-blue);
        color: var(--text-dark);
    }

    .header {
        background: linear-gradient(90deg, #1e5fa3, #3b82c4);
        color: #ffffff;
        text-align: center;
        padding: 18px 12px;
    }

    .header h1 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.8px;
    }

    .header span {
        font-size: 13px;
        opacity: 0.95;
    }

    .container {
        padding: 14px;
        max-width: 700px;
        margin: auto;
    }

    .card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--card-blue);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: transform 0.2s ease;
    }

    .card:active {
        transform: scale(0.98);
    }

    .left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .icon {
        font-size: 26px;
        background: #e1efff;
        color: var(--blue);
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .title {
        font-size: 15px;
        font-weight: 600;
    }

    .arrow {
        font-size: 20px;
        color: var(--blue);
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    @media (min-width: 768px) {
        .header h1 {
            font-size: 20px;
        }
        .title {
            font-size: 16px;
        }
    }
</style>
</head>

<body>

<div class="header">
    <h1>ADITYA BIRLA GARMENTS LIMITED</h1>
    <span>(UNIT – ABGL)</span>
</div>

<div class="container">

    <a href="https://storemanagement.infinityfreeapp.com/wp-admin/display_rack.php?rack_number=a&i=1" target="_blank">
        <div class="card">
            <div class="left">
                <div class="icon">🏬</div>
                <div class="title">Store Bins Management</div>
            </div>
            <div class="arrow">➜</div>
        </div>
    </a>

    <a href="https://inspectionreports.infinityfreeapp.com/Display.php?i=1" target="_blank">
        <div class="card">
            <div class="left">
                <div class="icon">📋</div>
                <div class="title">Inspection Reports</div>
            </div>
            <div class="arrow">➜</div>
        </div>
    </a>

    <a href="https://vechiclesmanagement.infinityfreeapp.com/" target="_blank">
        <div class="card">
            <div class="left">
                <div class="icon">🚚</div>
                <div class="title">Vehicle Management</div>
            </div>
            <div class="arrow">➜</div>
        </div>
    </a>
                                    
    <a href="https://naveen8008.pythonanywhere.com/" target="_blank">
        <div class="card">
            <div class="left">
                <div class="icon">⚙️</div>
                <div class="title">Asset Management</div>
            </div>
            <div class="arrow">➜</div>
        </div>
    </a>

                                    
    <a href="https://baleopening.infinityfree.me/Thread/Display.php" target="_blank">
        <div class="card">
            <div class="left">
                <div class="icon">🧵</div>
                <div class="title">Thread Management</div>
            </div>
            <div class="arrow">➜</div>
        </div>
    </a>

    <a href="https://4-ux-guardianzip-1-zipzip-1-zip-1-zip--jaswanth07.replit.app" target="_blank">
        <div class="card">
            <div class="left">
                <div class="icon">✂️</div>
                <div class="title">Trims Management</div>
            </div>
            <div class="arrow">➜</div>
        </div>
    </a>

    <a href="https://scoardboard.infinityfreeapp.com/?i=2" target="_blank">
        <div class="card">
            <div class="left">
                <div class="icon">🏭</div>
                <div class="title">Production Management</div>
            </div>
            <div class="arrow">➜</div>
        </div>
    </a>

    <a href="https://baleopening.infinityfree.me/?i=1" target="_blank">
        <div class="card">
            <div class="left">
                <div class="icon">📦</div>
                <div class="title">Bale Opening</div>
            </div>
            <div class="arrow">➜</div>
        </div>
    </a>

</div>

</body>
</html>
