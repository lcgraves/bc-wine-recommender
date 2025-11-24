<?php
// ===================================
// 1. SETUP
// ===================================

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure necessary databse functions are available
require_once 'database.php';
// Connect to database
$pdo = createDBConnection(); 

