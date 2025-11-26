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
$errors = []; // For validation errors
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

    // 1. Get inputs
    $name = trim($_POST['name'] ?? '');
    $winery = trim($_POST['winery'] ?? '');
    $region = $_POST['region'] ?? '';
    $colour = $_POST['colour'] ?? '';
    $body = $_POST['body'] ?? '';
    $sweetness = $_POST['sweetness'] ?? '';
    $description = trim($_POST['description'] ?? '');

    // Get and validate price
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

    // Get notes selected by user
    $selected_notes = $_POST['notes'] ?? [];

    // Get current image path from hidden field
    $current_image_url = $_POST['current_image_url'] ?? null;

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
    // 5. Image Upload Validation (Only if a new file was provided)
    if (!empty($_FILES['image_file']['name'])) {
        $file = $_FILES['image_file'];

        // Check for common PHP upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Image upload failed. Error code: ' . $file['error'];
        }

        // Check file type and size against defined constants
        elseif (!in_array($file['type'], $allowed_image_types)) {
            $errors[] = 'Invalid image type. Allowed: JPG, PNG, GIF, WebP.';
        } elseif ($file['size'] > $max_size) {
            $errors[] = 'Image is too large. Maximum size: 5MB.';
        }
    }

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
?>


<section>


</section>
<?php require 'includes/footer.php' ?>