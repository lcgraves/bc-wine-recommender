<?php
//Start session to retain login state
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Login";
require_once 'includes/Database.php';
require 'includes/header.php';
require 'includes/nav.php';

// Connect to database
$pdo = createDBConnection();
$login_message = ''; // Variable to store feedback messages

// --- 2. LOGIN PROCESSING LOGIC ---
if (is_post_request()) {
    
    // Get inputs
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $login_message = "Please enter both username and password.";
    }

    else {
        try {
            // A. Fetch the user's record based on the username
            $sql = "SELECT id, username, hashed_password FROM admin_users WHERE username = :username";
            $params = [':username' => $username];
            
            $stmt = executePS($pdo, $sql, $params);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // B. Verify the password if user exists
            if ($user && password_verify($password, $user['hashed_password'])) {
                
                // SUCCESS: Set session variables and redirect
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];

?>

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
    <?php require 'includes/footer.php' ?>
