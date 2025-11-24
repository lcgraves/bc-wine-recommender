<?php
// ==========================================================
// IMPORTANT: RUN THIS SCRIPT ONLY ONCE TO CREATE THE FIRST ADMIN
// ==========================================================

require_once 'database.php';

// 1. DEFINE THE FIRST ADMIN CREDENTIALS
$username = 'laracraves'; 
$password_plain = 'ilovephp'; 

// 2. Connet to database and check for existing admins
try {
    // Get the PDO connection object using your function
    $pdo = createDBConnection(); 
    
    // Check if any admin users already exist to prevent accidental re-runs
    $stmt = executePS($pdo, "SELECT COUNT(*) FROM admin");
    $user_count = $stmt->fetchColumn();

    if ($user_count > 0) {
        // Prevent running the script if users already exist
        die("❌ Error: Admin user already exists. Cannot run setup script again.");
    }

    // A. HASH the plain password
    $hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

    // B. DEFINE SQL (using positional placeholders ?)
    $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";

    // C. EXECUTE prepared SQL statement
    executePS($pdo, $sql, [$username, $hashed_password]);

    // D. Confirmation
    echo "✅ Success! First admin user created:<br>";
    echo "Username: <strong>" . html_escape($username) . "</strong><br>"; // Using your html_escape for safety
    echo "Password: (The one you chose)<br><br>";
    echo "<strong>🚨 SECURITY WARNING: DELETE OR RENAME THIS FILE IMMEDIATELY!</strong>";

    } catch (PDOException $e) {
    // Catch database errors
    die("Database Error: " . html_escape($e->getMessage()));
}