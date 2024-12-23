<?php

$host = 'localhost';
$db = 'cleaning_service';
$user = 'root'; // по умолчанию для XAMPP
$pass = ''; // по умолчанию для XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
