<?php
// Ensure session has been started and user logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect user if not logged in successfully
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    require_once '../Public/includes/Database.php'; // Need redirect() function
    redirect('../Public/login.php');
}

$page_title = "Manage Wines";
require_once '../Public/includes/Database.php';
require '../Public/includes/header_private.php';

// create db connection
$pdo = createDBConnection();

// Fetch all wines from the database
$sql_wines = "SELECT wine_id, name, colour, body, sweetness, price FROM wine ORDER BY wine_id DESC";
$stmt_wines = executePS($pdo, $sql_wines);
$wines = $stmt_wines->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- Footer -->
<?php require '../Public/includes/footer.php'; ?>