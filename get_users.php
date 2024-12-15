<?php
require 'db.php';

$stmt = $pdo->query('SELECT id, firstname, lastname, email, role FROM Users ORDER BY created_at DESC');
$users = $stmt->fetchAll();

echo json_encode($users);
?>
