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

// ===================================
// 2. REQUEST VALIDATION
// ===================================

// Check if the request is a POST submission
if (!is_post_request()) {
    // If not a POST request, redirect back to the form page.
    redirect('index.php');
}

// ===================================
// 3. PROCESSING
// ===================================

// Retrieve filter inputs
$colour = $_POST['colour'] ?? null;
$sweetness = $_POST['sweetness'] ?? null;
$notes_filter = $_POST['notes'] ?? null;
$body = $_POST['body'] ?? null;