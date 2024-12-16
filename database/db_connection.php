<?php
// db_connection.php
//Universal across each team member

// Default Database credentials

$host = 'localhost';
$db = 'dolphin_crm';
$user = 'user';
$password = 'password123';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
