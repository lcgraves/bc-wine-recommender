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


<main class="container">
        <h1>Manage Wines 🍷</h1>
        
        <p>
            <a href="add_wine.php" class="button button-primary">Add New Wine</a>
        </p>

        <?php if (empty($wines)): ?>
            <p>No wines found in the database.</p>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Colour</th>
                        <th>Body</th>
                        <th>Sweetness</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($wines as $wine): ?>
                        <tr>
                            <td><?= html_escape($wine['wine_id']) ?></td>
                            <td><?= html_escape($wine['name']) ?></td>
                            <td><?= html_escape($wine['colour']) ?></td>
                            <td><?= html_escape($wine['body']) ?></td>
                            <td><?= html_escape($wine['sweetness']) ?></td>
                            <td>$<?= html_escape(number_format($wine['price'], 2)) ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
                    
    </main>

<!-- Footer -->
<?php require '../Public/includes/footer.php'; ?>