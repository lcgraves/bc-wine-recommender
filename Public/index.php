<?php
require 'functions.php';
require 'views/index.view.php';

// connect to MySQL wine_db and execute query

$dsn = "mysql:host=localhost;port=3306;dbname=wine_db;user=root;charset=utf8mb4";
$pdo = new PDO($dsn);

$statement = $pdo->prepare("SELECT * FROM `wine_db`.`wine-data`");
$statement->execute();
$wines = $statement->fetchAll(PDO::FETCH_ASSOC); // gives results as associatie array

foreach ($wines as $wine) {
    echo "<li> " . $wine['name'] . " - " . $wine['winery'] . " - " . $wine['region'] . " - " . $wine['colour'] . " - " . $wine['price'] . "</li>";
}