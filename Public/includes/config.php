<?php

/* Database configuration settings */


/* Database credentials */

define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_NAME', 'wine_db');
define('DB_CHARSET', 'utf8mb4');
define('DB_PASS', '');
define('DB_USER', 'root');

/* Application settings */

define('SITE_NAME', 'BC Wine Recommender');
define('BASE_URL', 'http://localhost/bc-wine-recommender/Public/');
define('UPLOAD_PATH', __DIR__ . '/../images/');

/* Image upload settings */
// Define allowed extensions and max size
$allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
$max_size = 5 * 1024 * 1024; // 5MB

/* Error reporting for production environment */

error_reporting(E_ALL);
ini_set('display_errors', 1);