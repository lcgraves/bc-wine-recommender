<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../Public/includes/Database.php';
$pdo = createDBConnection();

// Check for authenticated user (Redirect if not logged in)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('../Public/login.php');
}

$page_title = "Edit Wine";
require 'includes/header_private.php';
require 'includes/side_nav.php';
$message = ''; // For success or error messages
$errors = []; // For validation errors
$wine_id = $_GET['id'] ?? null; // Get wine ID from URL for intial load

// If no ID is provided in the URL, redirect back to the manage page
if (!$wine_id) {
    redirect('manage_wines.php');
}

// Initialize variables (will be filled below)
$wine = [];
$tasting_notes_db = []; // notes currently in database for this wine
$selected_notes = []; // Notes selected by user in the form

// Constants (for the form structure)
$all_notes_list = [
    'wild cherry',
    'black fruit',
    'raspberry',
    'cranberry',
    'strawberry',
    'plum',
    'mushroom',
    'earthy',
    'cedar',
    'smoky',
    'black olive',
    'lime',
    'petrol',
    'slate_mineral',
    'grapefruit',
    'citrus_zest',
    'saline_maritime',
    'bell_pepper',
    'floral',
    'elderflower'
];

// ====================================================================
// SECTION 1: HANDLE POST REQUEST (UPDATE DATA)
// ====================================================================
if (is_post_request()) {

    // 1. Get inputs & assign to $wine array
    $wine['wine_id'] = $wine_id;
    $wine['name'] = trim($_POST['name'] ?? '');
    $wine['winery'] = trim($_POST['winery'] ?? '');
    $wine['region'] = $_POST['region'] ?? '';
    $wine['colour'] = $_POST['colour'] ?? '';
    $wine['body'] = $_POST['body'] ?? '';
    $wine['sweetness'] = $_POST['sweetness'] ?? '';
    $wine['description'] = trim($_POST['description'] ?? '');

    // Get and validate price & assign
    $submitted_price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $wine['price'] = $submitted_price !== false ? $submitted_price : null; // set to null if invalid

    // Get notes selected by user
    $selected_notes = $_POST['notes'] ?? [];

    // Get current image path from hidden field
    $original_image_url = $_POST['original_image_url'] ?? null;
    $wine['image_url'] = $original_image_url; // default to original unless new file uploaded

    // 2. VALIDATION

    if (!validate_required($wine['name'])) {
        $errors[] = 'Wine Name is required.';
    }
    if (!validate_required($wine['winery'])) {
        $errors[] = 'Winery is required.';
    }
    if (!validate_required($wine['region'])) {
        $errors[] = 'Region selection is required.';
    }
    if (!validate_required($wine['colour'])) {
        $errors[] = 'Colour selection is required.';
    }
    if (!validate_required($wine['body'])) {
        $errors[] = 'Body selection is required.';
    }
    if (!validate_required($wine['sweetness'])) {
        $errors[] = 'Sweetness selection is required.';
    }
    if (!validate_required((string) $wine['price'])) { // Convert price back to string for the required check
        $errors[] = 'Price is required.';
    } elseif ($wine['price'] === false || $wine['price'] < 0) {
        $errors[] = 'Price must be a valid positive number.';
    }
    // 5. Image file upload and deletion logic (adapted from add_wine.php)

    // Check if a NEW file was submitted and PHP detected no initial error
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        
        $file_tmp_name = $_FILES['image_file']['tmp_name'];
        $file_name = $_FILES['image_file']['name'];
        $file_size = $_FILES['image_file']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

   // A. File validation
        if (!in_array($file_ext, $allowed_extensions)) {
            $errors[] = "Error: Invalid file type. Only JPG, PNG, WEBP, and AVIF are allowed.";
        } elseif ($file_size > $max_size) {
            $errors[] = "Error: File size exceeds the 5MB limit.";
        }

        // B. Attempt to move file only if validation passed
        if (empty($errors)) {
            // 1. Generate unique file name
            $new_file_name = uniqid('wine_', true) . '.' . $file_ext;

            // 2. Define the final target path (Uses UPLOAD_PATH constant)
            $target_file = UPLOAD_PATH . $new_file_name;

    // 3. UPDATE DATABASE IF NO ERRORS
    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            // A. Update the main wine table
            $sql_wine_update = "
                UPDATE wine SET 
                    name = ?, winery = ?, region = ?, colour = ?, body = ?, 
                    sweetness = ?, price = ?, description = ?, image_url = ?
                WHERE wine_id = ?
            ";
            $params_wine_update = [
                $wine['name'],
                $wine['winery'],
                $wine['region'],
                $wine['colour'],
                $wine['body'],
                $wine['sweetness'],
                $wine['price'],
                $wine['description'],
                $wine['image_url'],
                $wine_id
            ];

            executePS($pdo, $sql_wine_update, $params_wine_update);

            // B. Update the tasting-notes table

            // 1. Delete all existing notes
            $sql_delete_notes = "DELETE FROM `tasting-notes` WHERE wine_fk = ?";
            executePS($pdo, $sql_delete_notes, [$wine_id]);

            // 2. Insert the newly selected notes
            if (!empty($selected_notes)) {
                $sql_insert_note = "INSERT INTO `tasting-notes` (wine_fk, flavour_note) VALUES (?, ?)";
                $stmt_insert = $pdo->prepare($sql_insert_note);

                foreach ($selected_notes as $note) {
                    $stmt_insert->execute([$wine_id, $note]);
                }
            }

            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log("Wine Update Failed: " . $e->getMessage());
            $errors[] = "Error: Database update failed. Check logs.";
        }

    }
}

// ====================================================================
// SECTION 2: LOAD DATA FOR DISPLAY (HANDLES INITIAL LOAD OR POST FAILURE)
// ====================================================================

// If it was a POST request that failed, the $wine array already contains the submitted data.
if (empty($wine) || !is_post_request() || !empty($errors)) {
    // 1. Fetch main wine details from DB (only if it wasn't a failed POST)
    if (!is_post_request() || !empty($errors)) {
        $sql_fetch_wine = "SELECT * FROM wine WHERE wine_id = :id";
        $stmt_fetch_wine = executePS($pdo, $sql_fetch_wine, [':id' => $wine_id]);
        $fetched_wine = $stmt_fetch_wine->fetch(PDO::FETCH_ASSOC);

    // If no wine found, redirect back to manage page
    if (!$fetched_wine) {
            redirect('manage_wines.php');
        }
        $wine = $fetched_wine; // Use DB data for rendering
    }

    // 2. Fetch current tasting notes from DB
    $sql_fetch_notes = "SELECT flavour_note FROM `tasting-notes` WHERE wine_fk = :id";
    $stmt_fetch_notes = executePS($pdo, $sql_fetch_notes, [':id' => $wine_id]);
    $tasting_notes_db = $stmt_fetch_notes->fetchAll(PDO::FETCH_COLUMN, 0);

    // If it's a first load (GET), use DB notes to check checkboxes
    if (!is_post_request()) {
        $selected_notes = $tasting_notes_db;
    } 
    // If it's a failed POST, $selected_notes retains the user's submitted values
}

// Check for success flag from the successful POST redirect
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $message = "Wine ID $wine_id updated successfully!";
}
?>


<section>

<h1>Editing: <?= html_escape($wine['name'] ?? 'Wine') ?> (ID: <?= $wine_id ?>)</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>
            <ul style="margin-top: 10px;">
                <?php foreach ($errors as $error): ?>
                    <li><?= html_escape($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($message): ?>
        <p class="feedback-message alert alert-success"><?= html_escape($message) ?></p>
    <?php endif; ?>

    <form action="edit-wine.php?id=<?= $wine_id ?>" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="original_image_url" value="<?= html_escape($wine['image_url'] ?? '') ?>">

        <h2 class="form-section-header">Product Information</h2>

        <div class="form-group">
            <label for="name" class="form-label">Wine Name</label>
            <input type="text" id="name" name="name" class="form-input" required 
                   value="<?= html_escape($wine['name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="winery" class="form-label">Winery / Producer</label>
            <input type="text" id="winery" name="winery" class="form-input" required 
                   value="<?= html_escape($wine['winery'] ?? '') ?>">
        </div>

        // PHP logic selects the current region
        <div class="form-group">
            <label for="region" class="form-label">Region</label>
            <select id="region" name="region" class="form-select" required>
                <option value="">Select Region...</option>
                <?php 
                $regions = ["Okanagan Valley", "Similkameen Valley", "Vancouver Island", "Fraser Valley", "Thompson Valley"];
                $current_region = $wine['region'] ?? '';
                foreach ($regions as $region): 
                ?>
                    <option value="<?= html_escape($region) ?>" 
                        <?= $current_region === $region ? 'selected' : '' ?>>
                        <?= html_escape($region) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Current Image</label>
            <?php if (!empty($wine['image_url'])): ?>
                <img src="../Public/<?= html_escape($wine['image_url']) ?>" alt="Current Wine Label" 
                     style="max-width: 150px; display: block; margin-bottom: 1rem; border: 1px solid #ccc;">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
            
            <label for="image_file" class="form-label">Change Image (Optional)</label>
            <input type="file" name="image_file" id="image_file" class="form-input" accept="image/*">
            <p class="help-text">Leave blank to keep the current image. Max 5MB.</p>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description (Brief marketing text)</label>
            <textarea id="description" name="description" class="form-textarea"><?= html_escape($wine['description'] ?? '') ?></textarea>
        </div>

        <hr class="form-separator">

        <h2 class="form-section-header">Recommendation Filters & Pricing</h2>

        <div class="form-grid-auto">

            <div class="form-group">
                <label for="colour" class="form-label">Colour</label>
                <select id="colour" name="colour" class="form-select" required>
                    <option value="">Select Colour...</option>
                    <?php 
                    $colours = ["Red", "White", "Rosé", "Sparkling"];
                    $current_colour = $wine['colour'] ?? '';
                    foreach ($colours as $colour): 
                    ?>
                        <option value="<?= html_escape($colour) ?>" 
                            <?= $current_colour === $colour ? 'selected' : '' ?>>
                            <?= html_escape($colour) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="body" class="form-label">Body</label>
                <select id="body" name="body" class="form-select" required>
                    <option value="">Select Body...</option>
                    <?php 
                    $bodies = ["Light", "Medium", "Full"];
                    $current_body = $wine['body'] ?? '';
                    foreach ($bodies as $body): 
                    ?>
                        <option value="<?= html_escape($body) ?>" 
                            <?= $current_body === $body ? 'selected' : '' ?>>
                            <?= html_escape($body) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="sweetness" class="form-label">Sweetness</label>
                <select id="sweetness" name="sweetness" class="form-select" required>
                    <option value="">Select Sweetness...</option>
                    <?php 
                    $sweetnesses = ["Dry", "Off-Dry", "Sweet"];
                    $current_sweetness = $wine['sweetness'] ?? '';
                    foreach ($sweetnesses as $sweetness): 
                    ?>
                        <option value="<?= html_escape($sweetness) ?>" 
                            <?= $current_sweetness === $sweetness ? 'selected' : '' ?>>
                            <?= html_escape($sweetness) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Price (CAD)</label>
                <input type="number" id="price" name="price" class="form-input" min="0" step="0.01" required 
                       value="<?= html_escape(number_format($wine['price'] ?? 0, 2, '.', '')) ?>">
            </div>
        </div>

        <hr class="form-separator">

        <h2 class="form-section-header">Tasting Notes</h2>
        <p class="form-subtitle" style="margin-bottom: 1rem;">Select all flavor notes that apply to this wine.
            (The currently selected notes are checked.)</p>

        <div class="notes-grid">
            
            <?php foreach ($all_notes_list as $note_value): ?>
                <div class="checkbox-item">
                    <label>
                        <input type="checkbox" name="notes[]" value="<?= html_escape($note_value) ?>"
                               <?= in_array($note_value, $selected_notes ?? []) ? 'checked' : '' ?>>
                        <?= html_escape(str_replace('_', ' ', $note_value)) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="form-actions">
            <button type="submit" class="button button-primary button-large">
                Save Wine Profile Changes
            </button>
            <a href="manage-wines.php" class="button button-secondary">
                Cancel / Back to Manage Wines
            </a>
        </div>
    </form>

</section>
</main>
<?php require 'includes/footer.php' ?>