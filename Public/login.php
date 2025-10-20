
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | The BC Pour</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Removed internal <style> block; CSS is now in styles.css -->
</head>
<body class="bg-wine-bg">

    <!-- Header -->
    <header class="header">
        <div class="container header-content">
            <a href="index.php" class="logo">The BC Pour</a>
            <nav class="nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="login.php" class="admin-button">Admin Login</a>
            </nav>
        </div>
    </header>

    <main class="container login-wrapper">
        <div class="login-card">
            <h1 class="recommender-title" style="font-size: 2rem; margin-bottom: 2rem;">Admin Login</h1>
            
            <!-- This form submits credentials to PHP on backend -->
            <form action="login.php" method="POST">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-input" required>
                
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" required>
                
                <!-- The button is styled as the primary action -->
                <button type="submit" class="button button-primary" style="width: 100%;">
                    Log In
                </button>
            </form>
        </div>
    </main>

    <!-- Footer  -->
    <footer class="footer">
        <div class="container text-center">
            &copy; 2025 The BC Pour | Supporting BC Wine.
        </div>
    </footer>
    
</body>
</html>
