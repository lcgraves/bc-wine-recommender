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

?>

<main class="container login-wrapper">
        <div class="login-card">
            <h1 class="recommender-title" style="font-size: 2rem; margin-bottom: 2rem;">Register New Admin</h1>

            <form action="register.php" method="POST">

<div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-input" 
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