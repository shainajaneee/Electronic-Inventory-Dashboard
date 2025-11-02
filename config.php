<?php
$host = 'localhost';      // your database host
$user = 'root';           // your MySQL username
$pass = '';               // your MySQL password (empty if none)
$dbname = 'inventory_db'; // change this to your actual database name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
