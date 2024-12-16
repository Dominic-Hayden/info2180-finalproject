<?php include 'db_connection.php'; ?>

<?php
session_start();
try{
    // Get the submitted username and password
    $user_email = $_POST['email'] ?? null;
    $user_password = $_POST['password'] ?? null;

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
        $storedHash = $user['password'];
        $providedHash = hash('sha256', $user_password);
        if(hash_equals($storedHash, $providedHash)){
            $_SESSION['user_id'] = $user['id']; // Example user ID
            $_SESSION['username'] = $user['firstname'];
            $_SESSION['role'] = $user['role'];
        } else {
            echo json_encode(['status' => 'failure', 'message' => 'Incorrect username or password.']);
        }
    } else {
        echo json_encode(['status' => 'failure', 'message' => 'Incorrect username or password.']);
    }
}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Redirect to the index
header("Location: ../index.php");
exit;
?>


