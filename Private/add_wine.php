<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Wine Profile | The BC Pour Admin</title>
    <!-- Assuming this is the correct path to your external stylesheet -->
    <link rel="stylesheet" href="/bc-wine-recommender/Public/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-wine-bg">

    <!-- Header (Consistent Navigation) -->
    <header class="header">
        <div class="container header-content">
            <a href="/bc-wine-recommender/Public/index.php" class="logo">The BC Pour</a>
            <nav class="nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="logout.php" class="button button-third">Log Out</a>
            </nav>
        </div>
    </header>

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
            <form action="add_wine.php" method="POST">
                
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
                    <label for="image_url" class="form-label">Image URL (Direct link to bottle image)</label>
                    <input type="url" id="image_url" name="image_url" class="form-input">
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
                <p class="form-subtitle" style="margin-bottom: 1rem;">Select all flavor notes that apply to this wine. (These will populate the many-to-many table.)</p>
                
                <div class="notes-grid">
                    <!-- Fruit/Aroma Notes -->
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Black Cherry"> Black Cherry</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Plum"> Plum</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Raspberry"> Raspberry</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Citrus"> Citrus</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Apple/Pear"> Apple/Pear</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Tropical Fruit"> Tropical Fruit</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Stone Fruit"> Stone Fruit</div>
                    
                    <!-- Earthy/Spicy Notes -->
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Vanilla"> Vanilla</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Oak/Toast"> Oak/Toast</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Spice"> Spice</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Earthy/Mushroom"> Earthy/Mushroom</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Mineral"> Mineral</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Leather/Tobacco"> Leather/Tobacco</div>
                    <div class="checkbox-item"><input type="checkbox" name="notes[]" value="Floral"> Floral</div>
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
    <footer class="footer">
        <div class="container text-center">
            &copy; 2025 The BC Pour Admin | Supporting BC Wine.
        </div>
    </footer>
    
</body>
</html>
