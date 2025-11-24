
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

            <!-- Container where wine cards will eventually be loaded -->
            <div id="wine-card-container" class="wine-card-container">
                <p style="text-align: center; color: #9B7258; padding: 3rem;">Use the filters above to find your perfect BC wine!</p>
            </div>

            <!-- Try Again Button -->
            <div class="try-again-wrapper">
                <button class="button button-lg button-primary button-double-border">
                    Try Again!
                </button>
            </div>
        </section>

    </main>
 
    <?php require 'includes/footer.php' ?>