<?php

$page_title = "Login";
require_once 'includes/Database.php';
require 'includes/header.php';
require 'includes/nav.php';

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