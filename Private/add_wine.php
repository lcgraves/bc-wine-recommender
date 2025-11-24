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

$page_title = "Add New Wine";
require_once '../Public/includes/Database.php';
require '../Public/includes/header_private.php';

// create db connection
$pdo = createDBConnection();

// Initialize message variable
$message = '';

?>

<main class="container dashboard-layout">

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <!-- Class: sidebar-title replaces inline styles for H2 -->
        <h2 class="sidebar-title">Dashboard</h2>
        <nav class="sidebar-menu">
            <a href="dashboard.php">Overview</a>
            <a href="manage_wines.php">Manage Wine</a>
            <a href="add_wine.php" class="active">Add New Wine</a>

            <?php
            /* // PHP Logic to show Manage Users only for 'admin' role
            if ($_SESSION['user_role'] === 'admin') {
                echo '<a href="manage_users.php">Manage Admin Users</a>';
            }
            */
            ?>

            <hr class="sidebar-separator">

            <a href="logout.php">Log Out</a>
        </nav>
    </aside>

    <!-- Main Content Area: Add Wine Form -->
    <section class="main-content">
        <h1 class="recommender-title page-header-title">Add New Wine Profile</h1>
        <p class="form-subtitle">Fill out the details below to add a new BC wine to the recommender database.</p>

        <!-- The form action will point to itself -->
        <form action="add_wine.php" method="POST enctype="multipart/form-data">

            <!-- Section 1: Core Wine Details (Maps to 'wines' table) -->
            <h2 class="form-section-header">Product Information</h2>

            <div class="form-group">
                <label for="name" class="form-label">Wine Name</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="winery" class="form-label">Winery / Producer</label>
                <input type="text" id="winery" name="winery" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="region" class="form-label">Region (e.g., Okanagan Valley, Fraser Valley)</label>
                <input type="text" id="region" name="region" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="image_url" class="form-label">Image</label>
                <input type="file" id="image_file" name="image_file" class="form-input" accept="image/*">
                <p class="help-text">Allowed formats: JPG, PNG, GIF, WebP. Maximum size: 5MB</p>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description (Brief marketing text)</label>
                <textarea id="description" name="description" class="form-textarea"></textarea>
            </div>

            <hr class="form-separator">

            <!-- Section 2: Filter Data (ENUMs and Price) -->
            <h2 class="form-section-header">Recommendation Filters & Pricing</h2>

            <div class="form-grid-auto">

                <div class="form-group">
                    <label for="colour" class="form-label">Colour</label>
                    <select id="colour" name="colour" class="form-select" required>
                        <option value="">Select Colour...</option>
                        <option value="Red">Red</option>
                        <option value="White">White</option>
                        <option value="Rosé">Rosé</option>
                        <option value="Sparkling">Sparkling</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="body" class="form-label">Body</label>
                    <select id="body" name="body" class="form-select" required>
                        <option value="">Select Body...</option>
                        <option value="Light">Light</option>
                        <option value="Medium">Medium</option>
                        <option value="Full">Full</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sweetness" class="form-label">Sweetness</label>
                    <select id="sweetness" name="sweetness" class="form-select" required>
                        <option value="">Select Sweetness...</option>
                        <option value="Dry">Dry</option>
                        <option value="Off-Dry">Off-Dry</option>
                        <option value="Sweet">Sweet</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Price (CAD)</label>
                    <input type="number" id="price" name="price" class="form-input" min="0" step="0.01" required>
                </div>
            </div>

            <hr class="form-separator">

            <!-- Section 3: Tasting Notes (Maps to 'tasting_notes' table) -->
            <h2 class="form-section-header">Tasting Notes</h2>
            <p class="form-subtitle" style="margin-bottom: 1rem;">Select all flavor notes that apply to this wine.
                (These will populate the many-to-many table.)</p>

            <div class="notes-grid">
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="wild_cherry"> Wild Cherry</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="black_fruit"> Black Fruit</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="raspberry"> Raspberry</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="cranberry"> Cranberry</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="strawberry"> Strawberry</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="plum"> Plum</div>

                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="mushroom"> Mushroom</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="earthy"> Earthy</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="cedar"> Cedar</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="smoky"> Smoky</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="black_olive"> Black Olive</div>

                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="lime"> Lime</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="petrol"> Petrol</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="slate_mineral"> Slate/Mineral
                </div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="grapefruit"> Grapefruit</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="citrus_zest"> Citrus Zest</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="saline_maritime">
                    Saline/Maritime</div>

                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="bell_pepper"> Bell Pepper</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="floral"> Floral</div>
                <div class="checkbox-item"><input type="checkbox" name="notes[]" value="elderflower"> Elderflower</div>
            </div>

            <div class="form-actions">
                <!-- Submit Button -->
                <button type="submit" class="button button-primary button-large">
                    Save Wine Profile
                </button>
                <!-- Cancel Button -->
                <a href="admin.php" class="button button-secondary">
                    Cancel / Back to Dashboard
                </a>
            </div>
        </form>
    </section>

</main>

<!-- Footer -->
<?php require '../Public/includes/footer.php'; ?>