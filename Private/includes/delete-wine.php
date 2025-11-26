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

try {
    $pdo->beginTransaction();
    
    // Retrieve image URL to delete the file from the server
    $sql_fetch_image = "SELECT image_url FROM wine WHERE wine_id = ?";
    $stmt = executePS($pdo, $sql_fetch_image, [$wine_id]);
    $image_url_to_delete = $stmt->fetchColumn();

    // 2. Delete tasting notes first (due to foreign key constraints)
    $sql_notes = "DELETE FROM `tasting-notes` WHERE wine_fk = ?";
    executePS($pdo, $sql_notes, [$wine_id]);

    // 3. Delete the main wine record
    $sql_wine = "DELETE FROM wine WHERE wine_id = ?";
    executePS($pdo, $sql_wine, [$wine_id]);

    $pdo->commit();

}