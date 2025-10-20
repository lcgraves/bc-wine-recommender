<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | The BC Pour</title>
    <link rel="stylesheet" href="/bc-wine-recommender/Public/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-wine-bg">

    <!-- Header  -->
    <header class="header">
        <div class="container header-content">
            <a href="/bc-wine-recommender/Public/index.php" class="logo">The BC Pour</a>
            <nav class="nav">
                <!-- The Logout link -->
                <a href="/Private/logout.php" class="button button-third">Log Out</a>
            </nav>
        </div>
    </header>

    <main class="container dashboard-layout">
        
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <h2 class="recommender-title" style="font-size: 1.5rem; padding: 1rem 1.5rem; margin-bottom: 0.5rem;">Dashboard</h2>
            <nav class="sidebar-menu">
                <!-- Dashboard Home -->
                <a href="admin.php" class="active">Overview</a> 
                
                <!-- Wine Management -->
                <a href="manage_wines.php">Manage Wines</a>
                
                <!-- Add Wine directly via sidebar -->
                <a href="add_wine.php">Add New Wine</a>
                
                <!-- User Management (Only shown if user_role is 'admin' via PHP) -->
                <?php 
                    /* // Example PHP Logic to conditionally display this link
                    if ($_SESSION['user_role'] === 'admin') {
                        echo '<a href="manage_users.php">Manage Admin Users</a>';
                    }
                    */
                ?>
                
                <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #eee;">
                
                <a href="logout.php">Log Out</a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <section class="main-content">
            <h1 class="recommender-title" style="margin-bottom: 0.5rem;">Welcome Back!</h1>
            <!-- PHP would replace this with the actual logged-in user's name -->
            <p style="color: #666; margin-bottom: 2rem;">You are currently logged in as a **[Placeholder Role - e.g., Admin/Editor]**.</p>
            
            <h2 style="font-size: 1.5rem; color: var(--wine-dark); border-bottom: 2px solid var(--wine-accent); padding-bottom: 0.5rem;">System Overview</h2>

            <!-- Placeholder Stat Cards (PHP will populate these values) -->
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php /* PHP: echo $total_wines; */ ?>124</div>
                    <div class="stat-label">Total BC Wines</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value"><?php /* PHP: echo $active_editors; */ ?>3</div>
                    <div class="stat-label">Active Editors</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value"><?php /* PHP: echo $red_wines; */ ?>56</div>
                    <div class="stat-label">Red Wines in Database</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value"><?php /* PHP: echo $latest_update; */ ?>10/18/2025</div>
                    <div class="stat-label">Last Data Update</div>
                </div>
            </div>

            <div style="margin-top: 3rem;">
                 <h2 style="font-size: 1.5rem; color: var(--wine-dark); border-bottom: 2px solid var(--wine-accent); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Quick Actions</h2>
                 
                 <!-- Primary Action Button -->
                 <a href="add_wine.php" class="button button-primary" style="margin-right: 1rem;">
                    + Add New Wine Profile
                 </a>

                 <!-- Secondary Action Button -->
                 <a href="manage_wines.php" class="button button-secondary">
                    View All Wines
                 </a>
            </div>
            
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