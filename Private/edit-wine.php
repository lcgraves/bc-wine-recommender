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


?>

<section>

        
</section>
<?php require 'includes/footer.php' ?>
