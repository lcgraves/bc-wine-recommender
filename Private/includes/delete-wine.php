<?php
// Ensure session has been started and user logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect user if not logged in successfully
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('../Public/login.php');
}

$pdo = createDBConnection();
