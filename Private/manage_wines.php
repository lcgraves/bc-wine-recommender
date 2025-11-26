<?php
// Ensure session has been started and user logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if a success message exists in the session
$success_message = $_SESSION['success_message'] ?? null;

// Clear the session variable so it doesn't reappear on refresh
if (isset($_SESSION['success_message'])) {
    unset($_SESSION['success_message']);
}

// Redirect user if not logged in successfully
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    require_once '../Public/includes/Database.php'; // Need redirect() function
    redirect('../Public/login.php');
}

$page_title = "Manage Wines";
require_once '../Public/includes/Database.php';
require 'includes/header_private.php';
require 'includes/side_nav.php';

// create db connection
$pdo = createDBConnection();

// Fetch all wines from the database
$sql_wines = "SELECT wine_id, name, colour, body, sweetness, price FROM wine ORDER BY wine_id DESC";
$stmt_wines = executePS($pdo, $sql_wines);
$wines = $stmt_wines->fetchAll(PDO::FETCH_ASSOC);
?>


<section class="container">
        <h1>Manage Wines 🍷</h1>
        
        <?php if ($success_message): ?>
        <div style="color: green; font-weight: 600;" class="alert alert-success">
            <?= html_escape($success_message) ?>
        </div>
        <?php endif; ?>

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
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($wines as $wine): ?>
                        <tr>
                            <td><?= html_escape($wine['wine_id']) ?></td>
                            <td class="wine-name"><?= html_escape($wine['name']) ?></td>
                            <td><?= html_escape($wine['colour']) ?></td>
                            <td>$<?= html_escape(number_format($wine['price'], 2)) ?></td>
                        <td class="action-buttons">
                            <!-- pass wine id via query string-->
                                <a href="edit-wine.php?id=<?= $wine['wine_id'] ?>" class="button button-secondary button-small">Edit</a>
                            <!--use post method to hide sensitive data-->
                                <form action="delete-wine.php" method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Are you sure you want to delete <?= html_escape($wine['name']) ?>?');">
                                    <input type="hidden" name="wine_id" value="<?= $wine['wine_id'] ?>">
                                    <button type="submit" class="button button-danger button-small">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
                    
    </section>
</main>

<!-- Footer -->
<?php require '../Public/includes/footer.php'; ?>