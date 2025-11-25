<?php
// Access session data
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/Database.php';

// --- 1. TERMINATE SESSION ---

// 1. Clear $_SESSION array
$_SESSION = [];

// 2. Destroy session cookie including session ID
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    // Deletes the cookie by setting its expiration time in the past
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destroy the session data file on the server
session_destroy();

// --- 2. REDIRECT TO LOGIN PAGE ---

redirect('../Public/login.php');