<!-- Header & Navigation -->
    <header class="header">
        <div class="container header-content">
            <!-- Logo/Title -->
            <a href="index.php" class="logo">The BC Pour</a>
            <!-- Navigation Links -->
            <nav class="nav">
                <a href="index.php" class="<?= urlIs('/bc-wine-recommender/Public/index.php') ? 'current' : ''; ?> nav-link ">Home</a>
                <a href="about.php" class="<?= urlIs('/bc-wine-recommender/Public/about.php') ? 'current' : ''; ?> nav-link">About</a>
                <a href="login.php" class="admin-button">Admin Login</a>
            </nav>
        </div>
    </header>