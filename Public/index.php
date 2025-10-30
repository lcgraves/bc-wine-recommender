<?php
require 'functions.php';
require 'views/index.view.php';
require 'Database.php';


// connect to MySQL wine_db and execute query

$db = new Database();
$wines = $db->query("SELECT * FROM `wine_db`.`wine-data`")->fetchAll(PDO::FETCH_ASSOC); 

foreach ($wines as $wine) {
    echo "<li> " . $wine['name'] . " - " . $wine['winery'] . " - " . $wine['region'] . " - " . $wine['colour'] . " - " . $wine['price'] . "</li>";
}