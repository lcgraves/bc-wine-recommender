<?php require 'partials/head.php' ?>
<?php require 'partials/nav.php' ?>

    <main class="container login-wrapper">
        <div class="login-card">
            <h1 class="recommender-title" style="font-size: 2rem; margin-bottom: 2rem;">Admin Login</h1>
            
            <!-- This form submits credentials to PHP on backend -->
            <form action="login.php" method="POST">
                
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                
                <!-- The button is styled as the primary action -->
                <button type="submit" class="button button-primary" style="width: 100%;">
                    Log In
                </button>
            </form>
        </div>
    </main>

    <!-- Footer  -->
    <?php require 'partials/footer.php' ?>
