<?php include 'db_connection.php'; ?>

<?php
session_start();

// Get filter value from the AJAX request
$filter = $_GET['filter'] ?? 'all';
$loggedInUserId = $_SESSION['user_id'];

// Query based on the filter
switch ($filter) {
    case 'sales_lead':
        $query = "SELECT * FROM contacts WHERE type = 'Sales Lead'";
        break;
    case 'support':
        $query = "SELECT * FROM contacts WHERE type = 'Support'";
        break;
    case 'my_contacts':
        $query = "SELECT * FROM contacts WHERE assigned_to = :user_id";
        break;
    default:
        $query = "SELECT * FROM contacts";
}

try{
    // Prepare and execute query
    $stmt = $conn->prepare($query);

    if ($filter === 'my_contacts') {
        $stmt->bindParam(':user_id', $loggedInUserId, PDO::PARAM_INT);
    }

    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($contacts);

}catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
