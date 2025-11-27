<?php

// Start session for potential error/success messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();

$page_title = "Login";
require_once 'includes/Database.php';
require 'includes/header.php';
require 'includes/nav.php';

// Connect to database & initialize variables
$pdo = createDBConnection();
$errors = [];
$success_message = '';
$username = ''; // Used to persist the username on validation error

// --- 2. REGISTRATION PROCESSING LOGIC ---
if (is_post_request()) {
    
    // 1. Get and clean up inputs
    $username = trim($_POST['username'] ?? '');
    $password_plain = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

// 2. Validation Checks
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (strlen($username) < 4 || strlen($username) > 20) {
        $errors[] = "Username must be between 4 and 20 characters.";
    }

if (empty($password_plain)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password_plain) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

if ($password_plain !== $password_confirm) {
        $errors[] = "Password and confirmation do not match.";
    }


// 3. Check for existing username (Database check)
    if (empty($errors)) {
        $sql_check = "SELECT COUNT(*) FROM admin WHERE username = :username";
        $count = executePS($pdo, $sql_check, [':username' => $username])->fetchColumn();
        
        if ($count > 0) {
            $errors[] = "Username is already taken. Please choose another.";
        }
    }

// 4. Save new user if no errors
    if (empty($errors)) {
        try {
            // A. Securely HASH the password
            $hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

// 5. INSERT new user into the admin table
            $sql_insert = "INSERT INTO admin (username, password) VALUES (?, ?)";
            executePS($pdo, $sql_insert, [$username, $hashed_password]);

            $success_message = "✅ Registration successful! You can now log in.";
            
            // Clear the username variable so the form is empty on success
            $username = '';

        } catch (PDOException $e) {
            error_log("Registration DB error: " . $e->getMessage());
            $errors[] = "A server error occurred during registration.";
        }
    }
}
?>

<main class="container login-wrapper">
        <div class="login-card">
            <h1 class="recommender-title" style="font-size: 2rem; margin-bottom: 2rem;">Register New Admin</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" style="color: darkred; font-weight: bold; margin-bottom: 1rem;">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= html_escape($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <p class="success-message" style="color: darkgreen; font-weight: bold; margin-bottom: 1rem;"><?= html_escape($success_message) ?></p>
            <?php endif; ?>

            <form action="register.php" method="POST">

<div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-input" value="<?= html_escape($username) ?>"
                         required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password (Min 8 characters)</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="password_confirm" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-input" required>
                </div>
                
                <button type="submit" class="button button-primary" style="width: 100%;">
                    Register
                </button>
            </form>

            <p style="text-align: center; margin-top: 1.5rem;">
                Already have an account? <a href="login.php">Log In here</a>.
            </p>
        </div>
    </main>
    <?php require 'includes/footer.php' ?>