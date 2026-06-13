<?php
/* ══════════════════════════════════════════════
   config.php — Database connection + helpers
   ══════════════════════════════════════════════ */

// ── Database credentials (XAMPP defaults) ──────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // XAMPP default: empty password
define('DB_NAME', 'crud_store');

// ── Session ─────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Connect ─────────────────────────────────────
function db(): mysqli {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            http_response_code(500);
            die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}

// ── Auth guard: redirect if not logged in ───────
function require_login(): void {
    if (empty($_SESSION['admin_id'])) {
        header('Location: index.php');
        exit;
    }
}

// ── JSON response helper ─────────────────────────
function json_out(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
