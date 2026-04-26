<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $role = $_POST['role'];
    $password = $_POST['password'];

    if ($role === "admin" && $password === "YOUR_ADMIN_PASSWORD") {
        header("Location: https://vehiclesmanagement.infinityfreeapp.com/Admin/Dashboard.php");
        exit;
    } elseif ($role === "deo" && $password === "YOUR_DEO_PASSWORD") {
        header("Location: https://vehiclesmanagement.infinityfreeapp.com/index.php");
        exit;
    } else {
        $error = "Invalid Role or Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="icon" type="image/x-icon" href="wp-admin/images/abgl.jpg">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('main background.png');
            backdrop-filter: blur(5px);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: sans-serif;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            padding: 44px 40px;
            background: rgba(0,0,0,0.88);
            box-shadow: 0 15px 25px rgba(0,0,0,0.6);
            border-radius: 10px;
        }

        .login-box p.title {
            color: #fff;
            text-align: center;
            font-size: 1.6rem;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .login-box p.sub {
            color: rgba(255,255,255,0.45);
            text-align: center;
            font-size: 13px;
            margin-bottom: 30px;
            letter-spacing: 0.3px;
        }

        /* Role tabs */
        .role-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 30px;
        }

        .role-tab {
            padding: 10px 0;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 6px;
            color: rgba(255,255,255,0.45);
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s;
        }

        .role-tab.active {
            background: #fff;
            color: #272727;
            border-color: #fff;
        }

        .role-tab:hover:not(.active) {
            border-color: #fff;
            color: #fff;
        }

        .user-box {
            position: relative;
            margin-bottom: 30px;
        }

        .user-box input,
        .user-box select {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            border: none;
            border-bottom: 1px solid #fff;
            outline: none;
            background: transparent;
            appearance: none;
            -webkit-appearance: none;
        }

        .user-box select option {
            background: #1a1a1a;
            color: #fff;
        }

        .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            pointer-events: none;
            transition: 0.5s;
        }

        .user-box input:focus ~ label,
        .user-box input:valid ~ label {
            top: -20px;
            font-size: 12px;
            color: #fff;
        }

        .error-msg {
            color: #ff4d4d;
            font-size: 13px;
            text-align: center;
            margin-bottom: 14px;
            display: <?php echo isset($error) ? 'block' : 'none'; ?>;
        }

        .pwd-wrap {
            position: relative;
        }

        .pwd-wrap input {
            padding-right: 30px;
        }

        .eye-toggle {
            position: absolute;
            right: 0;
            top: 10px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .eye-toggle svg {
            width: 18px;
            height: 18px;
            fill: rgba(255,255,255,0.5);
            transition: fill 0.2s;
        }

        .eye-toggle:hover svg { fill: #fff; }

        form button[type=submit] {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            font-weight: bold;
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            overflow: hidden;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: 0.5s;
            margin-top: 30px;
            letter-spacing: 3px;
            width: 100%;
        }

        form button[type=submit]:hover {
            background: #fff;
            color: #272727;
            border-radius: 5px;
        }

        form button[type=submit] span {
            position: absolute;
            display: block;
        }

        form button[type=submit] span:nth-child(1) {
            top: 0; left: -100%;
            width: 100%; height: 2px;
            background: linear-gradient(90deg, transparent, #fff);
            animation: btn-anim1 1.5s linear infinite;
        }
        @keyframes btn-anim1 { 0%{left:-100%} 50%,100%{left:100%} }

        form button[type=submit] span:nth-child(2) {
            top: -100%; right: 0;
            width: 2px; height: 100%;
            background: linear-gradient(180deg, transparent, #fff);
            animation: btn-anim2 1.5s linear infinite;
            animation-delay: 0.375s;
        }
        @keyframes btn-anim2 { 0%{top:-100%} 50%,100%{top:100%} }

        form button[type=submit] span:nth-child(3) {
            bottom: 0; right: -100%;
            width: 100%; height: 2px;
            background: linear-gradient(270deg, transparent, #fff);
            animation: btn-anim3 1.5s linear infinite;
            animation-delay: 0.75s;
        }
        @keyframes btn-anim3 { 0%{right:-100%} 50%,100%{right:100%} }

        form button[type=submit] span:nth-child(4) {
            bottom: -100%; left: 0;
            width: 2px; height: 100%;
            background: linear-gradient(360deg, transparent, #fff);
            animation: btn-anim4 1.5s linear infinite;
            animation-delay: 1.125s;
        }
        @keyframes btn-anim4 { 0%{bottom:-100%} 50%,100%{bottom:100%} }

        @media (max-width: 480px) {
            .login-box {
                padding: 36px 26px;
            }
            .login-box p.title { font-size: 1.35rem; }
        }
    </style>
</head>
<body>

<div class="login-box">
    <p class="title">Vehicle Management</p>
    <p class="sub">Sign in to your portal</p>

    <div class="role-tabs">
        <button type="button" class="role-tab active" onclick="setRole('admin', this)">Admin</button>
        <button type="button" class="role-tab" onclick="setRole('deo', this)">DEO</button>
    </div>

    <?php if (isset($error)): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php else: ?>
        <div class="error-msg" id="jsErr"></div>
    <?php endif; ?>

    <form method="POST" id="loginForm">
        <input type="hidden" name="role" id="roleInput" value="admin">

        <div class="user-box pwd-wrap">
            <input required name="password" id="pwdField" type="password" autocomplete="current-password">
            <label>Password</label>
            <button type="button" class="eye-toggle" onclick="togglePwd()" id="eyeBtn">
                <svg id="eyeIcon" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
            </button>
        </div>

        <button type="submit" name="login">
            <span></span><span></span><span></span><span></span>
            Login
        </button>
    </form>
</div>

<script>
    function setRole(role, el) {
        document.getElementById('roleInput').value = role;
        document.getElementById('pwdField').value = '';
        document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    function togglePwd() {
        const f = document.getElementById('pwdField');
        const icon = document.getElementById('eyeIcon');
        if (f.type === 'password') {
            f.type = 'text';
            icon.innerHTML = '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
        } else {
            f.type = 'password';
            icon.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
        }
    }
</script>

</body>
</html>