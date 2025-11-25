<?php
// Access session data
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/Database.php';

// --- 1. TERMINATE SESSION ---

// 1. Clear $_SESSION array
$_SESSION = [];

