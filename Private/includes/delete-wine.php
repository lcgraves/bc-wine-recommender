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

// 1. Get the wine ID from the POST request
$wine_id = filter_input(INPUT_POST, 'wine_id', FILTER_VALIDATE_INT);

// If no valid ID is present, or if it wasn't a POST request, redirect back
if (!$wine_id) {
    redirect('manage_wines.php');
}