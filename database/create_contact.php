<?php include 'db_connection.php'; ?>

<?php
session_start();

try{
    // Rest of the script for handling user insertion
    $contact_title = $_POST['title'] ?? null;
    $contact_firstname = $_POST['firstname'] ?? null;
    $contact_lastname = $_POST['lastname'] ?? null;
    $contact_email = $_POST['email'] ?? null;
    $contact_telephone = $_POST['telephone'] ?? null;
    $contact_company = $_POST['company'] ?? null;
    $contact_type = $_POST['type'] ?? null;
    $contact_assigned_to = $_POST['assigned_to'] ?? null;

    if (!$contact_title || !$contact_email || !$contact_firstname || !$contact_lastname || !$contact_type || !$contact_telephone || !$contact_company || !$contact_assigned_to) {
        http_response_code(400); // Bad request
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Check if the contact already exists
    $stmt = $conn->prepare("SELECT * FROM Contacts WHERE email = :email");
    $stmt->bindParam(':email', $contact_email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['status' => 'error', 'message' => 'Contact already exists']);
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by) VALUES (:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by)");
        $stmt->execute([
            ':title' => $contact_title,
            ':firstname' => $contact_firstname,
            ':lastname' => $contact_lastname,
            ':email' => $contact_email,
            ':telephone' => $contact_telephone,
            ':company' => $contact_company,
            ':type' => $contact_type,
            ':assigned_to' => $contact_assigned_to,
            ':created_by' => $_SESSION['user_id'],
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Contact added successfully']);
    }

}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
