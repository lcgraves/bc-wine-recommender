<!-- Header & Navigation -->
<header class="header navbar navbar-expand-md navbar-dark">
    <div class="container header-content">
        <a href="index.php" class="navbar-brand logo">The BC Pour</a> 
        <button
            class="navbar-toggler"          
            type="button"
            data-bs-toggle="collapse"       
            data-bs-target="#navbarNav"     
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?= urlIs('/bc-wine-recommender/Public/index.php') ? 'active' : ''; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link <?= urlIs('/bc-wine-recommender/Public/about.php') ? 'active' : ''; ?>">About</a>
                </li>
                <li class="nav-item">
                    <a href="login.php" class="nav-link admin-button">Admin Login</a> 
                </li>
            </ul>
        </div>
    </div>
</header>