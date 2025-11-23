<?php

/* database connection */
require_once 'config.php';  


/* create database connection */

function createDBConnection() {
    /* $pdo is static to ensure a single connection instance */
    static $pdo = null;

    if ($pdo === null) {

    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // throws php exception on database error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //sets default way to retrieve data as associative array
        PDO::ATTR_EMULATE_PREPARES => false, // use database's native prepared SQL statements if supported
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}

return $pdo;
}

/*** Excecute prepared statement ****/

function executePS($pdo, $sql, $params = []): PDOStatement{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

