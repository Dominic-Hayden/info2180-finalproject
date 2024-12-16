<?php include 'db_connection.php'; ?>

<?php
session_start();

try{
    // Rest of the script for handling user insertion
    $contact_id = $_POST['contact_id'] ?? null;
    $contact_action = $_POST['action'] ?? null;

    // Check if the contact already exists
    $stmt = $conn->prepare("SELECT * FROM Contacts WHERE id = :id");
    $stmt->bindParam(':id', $contact_id);
    $stmt->execute();
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($contact_action == 'assign_to_me') {
        $stmt = $conn->prepare("UPDATE Contacts SET assigned_to = :user_id WHERE id = :contact_id");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':contact_id' => $contact_id,
        ]);

        $stmt = $conn->prepare("SELECT * FROM Contacts WHERE id = :id");
        $stmt->bindParam(':id', $contact_id);
        $stmt->execute();
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'message' => 'Contact successfully assigned to you', 'assigned_to' => $_SESSION['user_id'], 'updated_at' => $contact['updated_at']]);
    } else {
        $type = $contact['type'] == 'Sales Lead' ? 'Support' : 'Sales Lead';
        $stmt = $conn->prepare("UPDATE Contacts SET type = :type WHERE id = :contact_id");
        $stmt->execute([
            ':type' => $type,
            ':contact_id' => $contact_id,
        ]);

        $stmt = $conn->prepare("SELECT * FROM Contacts WHERE id = :id");
        $stmt->bindParam(':id', $contact_id);
        $stmt->execute();
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'message' => 'Contact type successfully changed', 'new_type' => $type, 'updated_at' => $contact['updated_at']]);
    }

}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>