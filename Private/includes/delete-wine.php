<?php
// Ensure session has been started and user logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../Public/includes/Database.php';

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
    
    // 4. Delete the physical image file
    if ($image_url_to_delete && defined('UPLOAD_PATH')) {
        $file_path = UPLOAD_PATH . basename($image_url_to_delete);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Redirect back to the wine management page with a success message
    $_SESSION['success_message'] = "Wine ID **$wine_id** was successfully deleted.";
    redirect('manage-wines.php');

    } catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Wine Deletion Failed: " . $e->getMessage());
    $_SESSION['error_message'] = "❌ Error: Wine could not be deleted. Check logs.";
    redirect('manage_wines.php'); // Redirect back to prevent resubmission
}
