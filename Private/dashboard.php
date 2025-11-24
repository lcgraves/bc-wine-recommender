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

$page_title = "Admin Dashboard";
require_once '../Public/includes/Database.php';
require '../Public/includes/header_private.php';

// --- 1. RETRIEVE DATA FROM DATABASE ---

// Initialize stats array
$stats = [
    'total_wines' => 0,
    'total_admins' => 0,
    'red_wines' => 0,
    'last_updated' => 'N/A'
];

try {
    // A. Total BC Wines (Assumes your main wine table is named 'wines')
    $stmt = executePS($pdo, "SELECT COUNT(*) FROM wines");
    $stats['total_wines'] = $stmt->fetchColumn();

?>


    <main class="container dashboard-layout">
        
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <h2 class="sidebar-title">Dashboard</h2>
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
                
                <hr class="sidebar-separator">
                
                <a href="logout.php">Log Out</a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <section class="main-content">
            <h1 class="recommender-title mb-05">Welcome Back!</h1>
            <p class="dashboard-welcome-text">You are currently logged in as a **[Placeholder Role - e.g., Admin/Editor]**.</p>
            
            <h2 class="dashboard-subheader">System Overview</h2>

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

            <div class="mt-3">
                 <h2 class="dashboard-subheader mb-15">Quick Actions</h2>
                 
                 <!-- Primary Action Button -->
                 <a href="add_wine.php" class="button button-primary mr-1">
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
    <?php require '../Public/includes/footer.php'; ?>