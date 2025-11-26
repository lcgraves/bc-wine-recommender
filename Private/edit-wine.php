<?php
// CRITICAL: Must be the very first thing
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/Database.php'; 
$pdo = createDBConnection();

// Check for authenticated user (Redirect if not logged in)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('../Public/login.php');
}