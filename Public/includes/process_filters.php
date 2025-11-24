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

// Build the base SQL query using an INNER JOIN

$sql = "
    SELECT DISTINCT 
        w.wine_id, w.name, w.winery, w.region, w.colour, w.body, w.sweetness, 
        w.price, w.description, w.image_url 
    FROM wine AS w 
    INNER JOIN `tasting-notes` AS t ON w.wine_id = t.wine_fk 
    WHERE 1=1
";

// Initialize parameters array for prepared statement
$params = [];

// Filter for choses parameters
if ($colour) {
    $sql .= " AND w.colour = :colour";
    $params[':colour'] = $colour;
}

if ($sweetness) {
    $sql .= " AND w.sweetness = :sweetness";
    $params[':sweetness'] = $sweetness;
}

if ($notes_filter) {
    $sql .= " AND t.flavour_note LIKE :notes_filter";
    $params[':notes_filter'] = '%' . $notes_filter . '%';
}

if ($body) {
    $sql .= " AND w.body = :body";
    $params[':body'] = $body;
}

// Add an ORDER BY clause do display results by price ascending
$sql .= " ORDER BY w.price ASC";

// ===================================
// 4. EXECUTION & REDIRECT
// ===================================

try {
    // Execute the prepared statement
    $stmt = executePS($pdo, $sql, $params);
    $recommended_wines = $stmt->fetchAll(); // Results are fetched here
