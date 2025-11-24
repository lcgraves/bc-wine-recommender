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

//Define category of flavour notes to notes map
$category_to_notes_map = [
    'berry_fruit' => ['wild cherry', 'black fruit', 'raspberry', 'cranberry', 'strawberry', 'plum'],
    'earthy_spice' => ['mushroom', 'earthy', 'cedar', 'smoky', 'black olive'],
    'citrus_mineral' => ['lime', 'petrol', 'slate/mineral', 'grapefruit', 'citrus zest', 'saline/maritime'],
    'vegetal_herbal' => ['bell pepper', 'floral', 'elderflower'],
];

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
// Initialize display filters array
$display_filters = [];

// Filter for chosen parameters
if ($colour) {
    $sql .= " AND w.colour = :colour";
    $params[':colour'] = $colour;
    // Store the clean filter value for display
    $display_filters['colour'] = $colour;
}

if ($sweetness) {
    $sql .= " AND w.sweetness = :sweetness";
    $params[':sweetness'] = $sweetness;
    $display_filters['sweetness'] = $sweetness;
}

if ($notes_filter) {
    $sql .= " AND t.flavour_note LIKE :notes_filter";
    $params[':notes_filter'] = '%' . $notes_filter . '%';
    $display_filters['notes'] = $notes_filter;
}

if ($body) {
    $sql .= " AND w.body = :body";
    $params[':body'] = $body;
    $display_filters['body'] = $body;
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

    // Store results and filters in session for retrieval on the recommended.php page
    $_SESSION['wine_search_results'] = $recommended_wines;
    $_SESSION['wine_search_filters'] = $display_filters;

    // Redirect the user to the display page
    redirect('../recommended.php');

} catch (PDOException $e) {
    // Handle database errors
    error_log("Database Query Failed: " . $e->getMessage());
    $_SESSION['error_message'] = "A server error occurred during the search.";
    redirect('index.php'); 
}


