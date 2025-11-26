
<?php
// Continue session started in process_filters.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/Database.php';
$page_title = "Recommended Wines";
require 'includes/header.php';
require 'includes/nav.php';

// --- 1. RETRIEVE WINE DATA AND FILTERS FROM SESSION ---

// Get the results (the array of matching wine rows)
$wines = $_SESSION['wine_search_results'] ?? [];
// Get the filters used for the search (e.g., [':colour' => 'Red'])
$filters_raw = $_SESSION['wine_search_filters'] ?? [];

$note_map = [
    'berry_fruit'     => 'Berry & Fruit',
    'earthy_spice'    => 'Earthy & Spice',
    'citrus_mineral'  => 'Citrus & Mineral',
    'vegetal_herbal'  => 'Vegetal & Herbal',
];

// Clear the session data after retrieval.
unset($_SESSION['wine_search_results']);
unset($_SESSION['wine_search_filters']);

// --- 2. EXTRACT FILTER VALUES FOR DISPLAY ---

// Store filter values for use in the page
$selected_colour = $filters_raw['colour'] ?? '';
$selected_sweetness = $filters_raw['sweetness'] ?? '';
$selected_notes = $filters_raw['notes'] ?? '';
$selected_body = $filters_raw['body'] ?? '';
?>



    <main class="container main-content">

        <!-- 2. Recommended Pours Results Section -->
        <section id="recommendations" class="recommendations-section">
            <div class="results-header">
                <h2 class="results-title">
                    Your Recommended Pours
                </h2>

                
                <!-- Result Filters (Price and Region) -->
                <div class="results-filters">
                    <select class="filter-select-small" name="price">
                        <option disabled selected value="">Filter by Price</option>
                        <option value="low">Under $20</option>
                        <option value="med">$20 - $40</option>
                        <option value="high">Over $40</option>
                    </select>
                    <select class="filter-select-small" name="region">
                        <option disabled selected value="">BC Region</option>
                        <option value="okanagan">Okanagan Valley</option>
                        <option value="similkameen">Similkameen Valley</option>
                        <option value="fraser">Fraser Valley</option>
                    </select>
                </div>
            </div>

            <div class="selected-filters-display">
                    <?php 
                    $display_filters = [];

                    // Build a list of the filters the user chose
                    if ($selected_colour) $display_filters[] = 'Colour: ' . htmlspecialchars(ucfirst($selected_colour));
                    if ($selected_sweetness) $display_filters[] = 'Sweetness: ' . htmlspecialchars(ucfirst($selected_sweetness));
                    if ($selected_notes && array_key_exists($selected_notes, $note_map)) {
                        // Retrieve the human-readable name from the map
                        $display_note_name = $note_map[$selected_notes];
                        $display_filters[] = 'Notes: ' . htmlspecialchars($display_note_name);
                    }
                    if ($selected_body) $display_filters[] = 'Body: ' . htmlspecialchars(ucfirst($selected_body));

                    if (!empty($display_filters)) {
                        echo '<p>Filtered by:</p>';
                        echo '<ul>';
                        foreach ($display_filters as $filter) {
                            echo '<li>' . $filter . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        // Handles case where a search was submitted with no filters selected.
                        echo '<p>No filters were selected. Please go back to the <a href="index.php">home page</a> to choose your criteria.</p>';
                    }
                    ?>
                </div>

            <!-- Container where wine cards will eventually be loaded -->
            <div id="wine-card-container" class="wine-card-container">
                
                <?php if (empty($wines)): ?>
                    <p class="no-results-message">
                        😔 Sorry, no wines matched your selection! Please try adjusting your filters.
                    </p>
                <?php else: ?>
                    
                    <?php foreach ($wines as $wine): ?>
                        <div class="wine-card">
                            <img src="<?php echo htmlspecialchars($wine['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($wine['name']); ?>" 
                                 class="wine-card-image">
                            
                            <div class="wine-card-info">
                                <h3 class="wine-card-name"><?php echo htmlspecialchars($wine['name']); ?></h3>
                                <p class="wine-card-winery">
                                    <?php echo htmlspecialchars($wine['winery']); ?> (<?php echo htmlspecialchars($wine['region']); ?>)
                                </p>
                                
                                <p class="wine-card-price">
                                    <strong>$<?php echo number_format($wine['price'], 2); ?></strong>
                                </p>
                                
                                <hr>
                                
                                <p class="wine-card-description">
                                    <?php 
                                        // Display the first 150 characters of the description for card view
                                        $desc = htmlspecialchars($wine['description']);
                                        echo (strlen($desc) > 150) ? substr($desc, 0, 150) . '...' : $desc;
                                    ?>
                                </p>
                                
                                <div class="wine-card-details">
                                    <span>Colour: <?php echo htmlspecialchars($wine['colour']); ?></span> |
                                    <span>Body: <?php echo htmlspecialchars($wine['body']); ?></span> |
                                    <span>Sweetness: <?php echo htmlspecialchars($wine['sweetness']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                <?php endif; ?>
                
            </div>

            <div class="try-again-wrapper">
                <button class="button button-lg button-primary button-double-border" onclick="window.location.href='index.php'">
                    Try Again!
                </button>
            </div>
        </section>

    </main>
 
    <?php require 'includes/footer.php' ?>