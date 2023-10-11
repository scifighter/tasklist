<?php
$host = 'localhost';
$database = 'tasklist';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$database;";

$options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$pdo = new PDO($dsn, $user, $pass, $options);