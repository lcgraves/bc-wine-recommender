<!-- Header & Navigation -->
    <header class="header">
        <div class="container header-content">
            <!-- Logo/Title -->
            <a href="index.php" class="logo">The BC Pour</a>
            <!-- Navigation Links -->
            <nav class="nav">
                <a href="index.php" class="<?php if ($_SERVER['REQUEST_URI'] == "/bc-wine-recommender/Public/index.php") { echo 'current';} ?> nav-link ">Home</a>
                <a href="about.php" class="<?php if ($_SERVER['REQUEST_URI'] == "/bc-wine-recommender/Public/about.php") { echo 'current';} ?> nav-link">About</a>
                <a href="login.php" class="admin-button">Admin Login</a>
            </nav>
        </div>
    </header>