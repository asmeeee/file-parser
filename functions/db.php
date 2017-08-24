<?php

$host   = 'localhost';
$dbname = 'file_parse';
$user   = 'root';
$pass   = '';

try {

    $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);

} catch(PDOException $e) {

    exit("Unable to connect to database. Error: \n" . $e->getMessage());

}