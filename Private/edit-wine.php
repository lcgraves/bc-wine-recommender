<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/Database.php'; 
$pdo = createDBConnection();

// Check for authenticated user (Redirect if not logged in)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('../Public/login.php');
}


$page_title = "Edit Wine";
require 'includes/header_private.php';
require 'includes/side_nav.php';
$message = ''; // For success or error messages
$wine_id = $_GET['id'] ?? null; // Get wine ID from URL for intial load

// If no ID is provided in the URL, redirect back to the manage page
if (!$wine_id) {
    redirect('manage-wines.php');
}

// Initialize variables (will be filled below)
$wine = [];
$tasting_notes_db = []; // notes currently in database for this wine
$selected_notes = []; // Notes selected by user in the form

// Constants (for the form structure)
$all_notes_list = [
    'wild cherry', 'black fruit', 'raspberry', 'cranberry', 'strawberry', 'plum',
    'mushroom', 'earthy', 'cedar', 'smoky', 'black olive',
    'lime', 'petrol', 'slate_mineral', 'grapefruit', 'citrus_zest', 'saline_maritime',
    'bell_pepper', 'floral', 'elderflower'
];

// ====================================================================
// SECTION 1: HANDLE POST REQUEST (UPDATE DATA)
// ====================================================================
if (is_post_request()) {
    
    // 1. Get inputs
    $name = $_POST['name'] ?? '';
    $winery = $_POST['winery'] ?? '';
    $region = $_POST['region'] ?? '';
    $colour = $_POST['colour'] ?? '';
    $body = $_POST['body'] ?? '';
    $sweetness = $_POST['sweetness'] ?? '';
    $description = $_POST['description'] ?? '';

    // Get and validate price
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

    // Get notes selected by user
    $selected_notes = $_POST['notes'] ?? [];

    // Get current image path from hidden field
    $current_image_url = $_POST['current_image_url'] ?? null;


?>

<section>

        
</section>
<?php require 'includes/footer.php' ?>
