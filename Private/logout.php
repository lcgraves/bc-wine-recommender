<?php
// Access session data
if (session_status() === PHP_SESSION_NONE) {
    session_start();

require_once 'includes/Database.php';


}