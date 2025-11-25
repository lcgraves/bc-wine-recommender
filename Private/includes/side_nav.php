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