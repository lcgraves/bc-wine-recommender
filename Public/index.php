<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The BC Pour | Find Your Wine</title>
    <!-- Link the external CSS file -->
    <link rel="stylesheet" href="styles.css">
    <!-- Load Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-wine-bg">

    <!-- Header & Navigation -->
    <header class="header">
        <div class="container header-content">
            <!-- Logo/Title -->
            <a href="#" class="logo">The BC Pour</a>
            <!-- Navigation Links -->
            <nav class="nav">
                <a href="index.php" class="nav-link current">Home</a>
                <a href="about.php" class="nav-link">About</a>
                <!-- Admin Login/Logout Placeholder -->
                <a href="admin.php" class="admin-button">Admin Login</a>
            </nav>
        </div>
    </header>

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
                    <option value="citrus">Citrus/Zesty</option>
                    <option value="berry">Berry/Jammy</option>
                    <option value="earthy">Earthy/Spicy</option>
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

    <!-- Footer Placeholder -->
    <footer class="footer">
        <div class="container text-center">
            &copy; 2025 The BC Pour | Supporting BC Wine.
        </div>
    </footer>
    
</body>
</html>