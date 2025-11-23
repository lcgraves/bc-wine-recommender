
<?php require 'includes/head.php' ?>
<?php require 'includes/nav.php' ?>

    <main class="container main-content">

        <!-- 1. Recommendation Search Section (The Hero) -->
        <!-- Form to collect filter data for PHP submission -->
        <form id="wine-filter-form" class="recommender-section">
            <h1 class="recommender-title">
                Find Your Next Perfect BC Wine
            </h1>
            
            <!-- Filters: Added name attributes for form submission -->
            <div class="filter-group">
                <select id="colour-filter" name="colour" class="filter-select">
                    <option disabled selected value="">Colour</option>
                    <option value="red">Red</option>
                    <option value="white">White</option>
                    <option value="rosé">Rosé</option>
                    <option value="sparkling">Sparkling</option>
                </select>
                <select id="sweetness-filter" name="sweetness" class="filter-select">
                    <option disabled selected value="">Sweetness</option>
                    <option value="dry">Dry</option>
                    <option value="off-dry">Off-Dry</option>
                    <option value="sweet">Sweet</option>
                </select>
                <select id="notes-filter" name="notes" class="filter-select">
                    <option disabled selected value="">Flavor Notes</option>
                    <option value="berry_fruit">Berry & Fruit</option>
                    <option value="earthy_spice">Earthy & Spice</option>
                    <option value="citrus_mineral">Citrus & Mineral</option>
                    <option value="vegetal_herbal">Vegetal & Herbal</option>
                </select>
                <select id="body-filter" name="body" class="filter-select">
                    <option disabled selected value="">Body</option>
                    <option value="light">Light</option>
                    <option value="medium">Medium</option>
                    <option value="full">Full</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <!-- Changed type to 'submit' for form handling -->
                <button type="submit" id="find-wine-btn" class="button button-primary">
                    Find My Wine
                </button>
                <button type="button" id="surprise-me-btn" class="button button-accent">
                    Surprise Me!
                </button>
            </div>
        </form>

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