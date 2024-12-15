<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $company = $_POST['company'];
    $type = $_POST['type'];
    $assigned_to = $_POST['assigned_to'];
    $created_by = $_POST['created_by'];

    $stmt = $pdo->prepare('INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
    if ($stmt->execute([$title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by])) {
        echo json_encode(['success' => true, 'message' => 'Contact added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add contact.']);
    }
}
?>
