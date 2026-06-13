<?php
/* ══════════════════════════════════════════════
   admin/index.php — Login page
   Reached only via the 5-click logo easter egg.
   ══════════════════════════════════════════════ */

require_once 'config.php';

// Already logged in → go straight to admin panel
if (!empty($_SESSION['admin_id'])) {
    header('Location: admin.html');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = db()->prepare('SELECT id, password FROM admins WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($row && password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id']   = $row['id'];
            $_SESSION['admin_user'] = $username;
            header('Location: admin.html');
            exit;
        } else {
            $error = 'Incorrect username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — CRUD</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Poppins',sans-serif; background:#f7f7f5; display:flex; align-items:center; justify-content:center; min-height:100vh; }
        a { text-decoration:none; color:inherit; }

        .card {
            background:#ffffff;
            border:1px solid #e6e6e4;
            border-radius:20px;
            padding:48px 44px;
            width:100%;
            max-width:420px;
            box-shadow:0 8px 40px rgba(0,0,0,0.07);
        }
        .logo {
            font-size:13px; font-weight:600; letter-spacing:3.5px;
            color:#111111; margin-bottom:6px;
        }
        .sub {
            font-size:12px; color:#aaaaaa; margin-bottom:36px;
        }
        h1 { font-size:22px; font-weight:600; color:#111111; margin-bottom:28px; letter-spacing:-0.3px; }

        .field { display:flex; flex-direction:column; gap:6px; margin-bottom:18px; }
        .field label { font-size:11px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:#999999; }
        .input-wrap { display:flex; align-items:center; gap:8px; border:1px solid #e6e6e4; border-radius:10px; padding:0 14px; background:#ffffff; transition:border-color 0.2s; }
        .input-wrap:focus-within { border-color:#111111; }
        .input-wrap i { font-size:18px; color:#aaaaaa; flex-shrink:0; }
        .input-wrap input { border:none; outline:none; font-family:inherit; font-size:13px; color:#111111; width:100%; padding:12px 0; background:transparent; }

        .error-msg {
            background:#fce4ec; border:1px solid #f48fb1;
            border-radius:10px; padding:11px 16px;
            font-size:12px; color:#c62828;
            margin-bottom:20px;
            display:flex; align-items:center; gap:8px;
        }
        .error-msg i { font-size:16px; flex-shrink:0; }

        .btn {
            width:100%; padding:13px;
            background:#111111; color:#ffffff;
            border:none; border-radius:10px;
            font-family:inherit; font-size:14px; font-weight:500;
            cursor:pointer; transition:background 0.2s;
            display:flex; align-items:center; justify-content:center; gap:8px;
            margin-top:8px;
        }
        .btn:hover { background:#333333; }

        .back { text-align:center; margin-top:20px; font-size:12px; color:#aaaaaa; }
        .back a { color:#555555; transition:color 0.2s; }
        .back a:hover { color:#111111; }
    </style>
</head>
<body>
    <div class="card">
        <p class="logo">CRUD</p>
        <p class="sub">Admin Panel — Restricted Access</p>
        <h1>Sign in</h1>

        <?php if ($error): ?>
        <div class="error-msg">
            <i class='bx bx-error-circle'></i>
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST">
            <div class="field">
                <label>Username</label>
                <div class="input-wrap">
                    <i class='bx bx-user'></i>
                    <input type="text" name="username" autocomplete="username"
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                           placeholder="admin" required>
                </div>
            </div>
            <div class="field">
                <label>Password</label>
                <div class="input-wrap">
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" name="password" autocomplete="current-password"
                           placeholder="••••••••" required>
                </div>
            </div>
            <button class="btn" type="submit">
                <i class='bx bx-log-in'></i> Sign In
            </button>
        </form>

        <p class="back"><a href="index.html">← Back to Store</a></p>
    </div>
</body>
</html>
