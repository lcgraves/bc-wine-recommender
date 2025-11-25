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
$error = false; // flag to track errors

if (is_post_request()) {
    
    // --- 1. Collect and Prepare Data ---
    
    // General Wine Details
    $name = post_data('name');
    $winery = post_data('winery');
    $region = post_data('region');
    $colour = post_data('colour');
    $body = post_data('body');
    $sweetness = post_data('sweetness');
    $price = post_data('price');
    $description = post_data('description');

    // Tasting Notes (Array of selected notes)
    $selected_notes = $_POST['notes'] ?? [];

    // Initialize image path variable
    $image_url_db = '';

    // --- 2. Basic Validation ---
    if (empty($name) || empty($winery) || empty($region) || empty($colour) || empty($body) || empty($sweetness) || !is_numeric($price)) {
        $message = "Error: Please fill out all required fields and ensure the price is valid.";
        $error = true;
    }

    // --- 3. Handle File Upload ---
    $file_upload_status = ''; // For debugging or feedback

    // Check if a file was uploaded successfully
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        
        $file_tmp_name = $_FILES['image_file']['tmp_name'];
        $file_name = $_FILES['image_file']['name'];
        $file_size = $_FILES['image_file']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Define allowed extensions and max size
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        // File validation
        if (!in_array($file_ext, $allowed_extensions)) {
            $message = "Error: Invalid file type. Only JPG, PNG, WEBP, and AVIF are allowed.";
            $error = true;
        } elseif ($file_size > $max_size) {
            $message = "Error: File size exceeds the 5MB limit.";
            $error = true;
        }

        if (!$error) {
            // Generate a unique file name to prevent overwrites
            $new_file_name = uniqid('wine_', true) . '.' . $file_ext;

        // Define the final target path
            $target_file = UPLOAD_PATH . $new_file_name;

        // Attempt to move the file
            if (move_uploaded_file($file_tmp_name, $target_file)) {
                // Success! Create the relative URL path required by the DB
                $image_url_db = 'images/' . $new_file_name;
            } else {
                $message = "Error: Failed to move uploaded file. Check directory permissions.";
                $error = true;
            }
        }
    } else {
        // Handle case where file upload failed or no file was submitted
        $message = "Error: Image upload failed or no image was selected.";
        $error = true;
    }

// --- 4. Database Transaction ---
    if (!$error) { // Only proceed if no errors
        
        try {
            $pdo->beginTransaction();

        // Insert into WINES table
            $sql_wine = "INSERT INTO wines (name, winery, region, colour, body, sweetness, price, description, image_url) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params_wine = [
                $name, $winery, $region, $colour, $body, $sweetness, $price, $description, $image_url_db
            ];

        executePS($pdo, $sql_wine, $params_wine);
        $new_wine_id = $pdo->lastInsertId();

        // Insert into TASTING_NOTES table
            if (!empty($selected_notes)) {
                $sql_note = "INSERT INTO tasting_notes (wine_fk, flavour_note) VALUES (?, ?)";
                $stmt_note = $pdo->prepare($sql_note);

                foreach ($selected_notes as $note_value) {
                    $stmt_note->execute([$new_wine_id, $note_value]);
                }
            }

        // Finalize database transaction
            $pdo->commit();

            // Save success message and redirect to dashboard
            $_SESSION['success_message'] = "✅ Your wine **" . html_escape($name) . "** was successfully added!";
            redirect('dashboard.php');

        // Add catch block for error handling
            } catch (PDOException $e) {
            // Reverse any database changes on error
            $pdo->rollBack();
            error_log("Wine insertion error: " . $e->getMessage());
            $message = "❌ A database error occurred. Wine could not be added. (Details logged)";
        }
    }
}
?>

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