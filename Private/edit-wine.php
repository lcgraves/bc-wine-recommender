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
    'wild cherry', 'black fruit', 'raspberry', 'cranberry', 'strawberry', 'plum',
    'mushroom', 'earthy', 'cedar', 'smoky', 'black olive',
    'lime', 'petrol', 'slate_mineral', 'grapefruit', 'citrus_zest', 'saline_maritime',
    'bell_pepper', 'floral', 'elderflower'
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
    if (!validate_required((string)$wine['price'])) { // Convert price back to string for the required check
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

}
    }
}
?>

<section>

        
</section>
<?php require 'includes/footer.php' ?>
