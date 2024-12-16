<?php include 'db_connection.php'; ?>

<?php

try{
    // Rest of the script for handling user insertion
    $user_password = $_POST['password'] ?? null;
    $user_firstname = $_POST['firstname'] ?? null;
    $user_lastname = $_POST['lastname'] ?? null;
    $user_email = $_POST['email'] ?? null;
    $user_role = $_POST['role'] ?? null;

    if (!$user_email || !$user_password) {
        http_response_code(400); // Bad request
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Check if the user already exists
    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = :email");
    $stmt->bindParam(':email', $user_email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['status' => 'error', 'message' => 'User already exists']);
    } else {
        // Hash the password
        $hashed_password = hash('sha256', $user_password);

        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)");
        $stmt->execute([
            ':firstname' => $user_firstname,
            ':lastname' => $user_lastname,
            ':email' => $user_email,
            ':password' => $hashed_password,
            ':role' => $user_role,
        ]);

        echo json_encode(['status' => 'success', 'message' => 'User added successfully']);
    }

}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
