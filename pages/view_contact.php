<?php include '../database/db_connection.php'; ?>

<?php
session_start();

try{
    $stmt = $conn->prepare("SELECT * FROM Contacts WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

try{
    $stmt = $conn->prepare("SELECT * FROM Notes WHERE contact_id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$logged_in_user = $_SESSION['user_id'];

try{
    $stmt = $conn->prepare("SELECT * FROM Users WHERE id = :id");
    $stmt->bindParam(':id', $logged_in_user, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

try{
    $stmt = $conn->prepare("SELECT * FROM Users WHERE id = :id");
    $stmt->bindParam(':id', $contact['created_by'], PDO::PARAM_INT);
    $stmt->execute();
    $user2 = $stmt->fetch(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h3 id="conHead" data-id="<?= $contact['id'] ?>">Contact Details</h3>
    </div>
    <div class="card-body">
        <p><strong>Title:</strong> <?= $contact['title'] ?></p>
        <p><strong>Full Name:</strong> <?= $contact['firstname'] ?> <?= $contact['lastname'] ?></p>
        <p><strong>Email:</strong> <?= $contact['email'] ?></p>
        <p><strong>Company:</strong> <?= $contact['company'] ?></p>
        <p><strong>Telephone:</strong> <?= $contact['telephone'] ?></p>
        <p><strong>Type:</strong> <?= $contact['type'] ?></p>
        <p><strong>Assigned To:</strong> <?= $user['firstname'] ?> <?= $user['lastname'] ?></p>
        <p><strong>Created By:</strong> <?= $user2['firstname'] ?> <?= $user['lastname'] ?> on <?= $contact['created_at'] ?></p>
        <p><strong>Last Updated:</strong> <?= $contact['updated_at'] ?></p>

        <!-- Action Buttons -->
        <button class="btn btn-success" id="assignBtn">Assign to Me</button>
        <button class="btn btn-secondary" id="toggleTypeBtn">Toggle Contact Type</button>
    </div>
</div>

<!-- Notes Section -->
<div class="card">
    <div class="card-header bg-secondary text-white">
        <h4>Notes</h4>
    </div>
    <div class="card-body">
        <ul class="list-group mb-3" id="notesList">
            <?php foreach ($notes as $note): ?>
                <li class="list-group-item">
                    <?= htmlspecialchars($note['comment']) ?>
                    <em>(<?= $note['created_at'] ?>)</em>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- Add New Note Form -->
        <form id="addNoteForm">
            <div class="input-group mb-3">
                <input type="text" name="new_note" id="newNote" class="form-control" placeholder="Add a new note" required>
                <button class="btn btn-primary" type="submit">Add Note</button>
            </div>
        </form>
    </div>
</div>

<script src="assets/js/contact_details.js"></script>
