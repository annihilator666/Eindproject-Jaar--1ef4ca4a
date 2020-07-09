<?php
$host = 'localhost';
$db   = 'stam';
$user = 'stam';
$pass = 'pl3#8Uw6';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;port=3306;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
date_default_timezone_set('Europe/Amsterdam');
// Host: https://projects.bit-academy.nl/phpMyAdmin/
// Database naam: stam
// Username: stam
// Password: pl3#8Uw6
?>