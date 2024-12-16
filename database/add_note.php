<?php include 'db_connection.php'; ?>

<?php
session_start();

try{
    // Rest of the script for handling user insertion
    $contact_id = $_POST['contact_id'] ?? null;
    $note_comment = $_POST['note'] ?? null;

    if (!$contact_id || !$note_comment) {
        http_response_code(400); // Bad request
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    
    // Insert the new note into the database
    $stmt = $conn->prepare("INSERT INTO Notes (contact_id, comment, created_by) VALUES (:contact_id, :comment, :created_by)");
    $stmt->execute([
        ':contact_id' => $contact_id,
        ':comment' => $note_comment,
        ':created_by' => $_SESSION['user_id'],
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Note added successfully']);
    

}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
