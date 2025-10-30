<?php
require 'functions.php';
require 'views/index.view.php';

// connect to MySQL wine_db

$dsn = "mysql:host=localhost;port=3306;dbname=wine_db;user=root;charset=utf8mb4";
$pdo = new PDO($dsn);

$statement = $pdo->prepare("SELECT * FROM `wine_db`.`wine-data`");
$statement->execute();
$wines = $statement->fetchAll(PDO::FETCH_ASSOC);

dd($wines);