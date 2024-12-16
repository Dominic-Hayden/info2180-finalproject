<?php
// Enable error reporting for debugging (comment out for production)
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'errors_log.txt');
error_reporting(E_ALL);

require 'db_connection.php'; // Include database connection

// Fetch all users for the Assigned To dropdown
$users = [];
try {
    $stmt = $conn->prepare("SELECT id, CONCAT(firstname, ' ', lastname) AS full_name FROM Users");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    error_log("Error fetching users: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json'); // JSON response header

    // Retrieve form data
    $title = $_POST['title'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $company = $_POST['company'] ?? '';
    $type = $_POST['type'] ?? '';
    $assigned_to = $_POST['assigned_to'] ?? 0;

    try {
        // Insert new contact
        $stmt = $conn->prepare('INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'SQL preparation error: ' . $conn->error]);
            exit();
        }
        $stmt->bind_param('sssssssi', $title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Contact added successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add contact: ' . $stmt->error]);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Unexpected error: ' . $e->getMessage()]);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact</title>
    <link rel="stylesheet" href="add_contact.css">
    <link rel="stylesheet" href="dashboard.css"> <!-- Sidebar styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    
     <!-- Include Sidebar -->
     <?php include 'sidebar.php'; ?>
    <!-- Main Content -->
    <div class="main-content">
        <div class="form-container">
            <h1>New Contact</h1>
            <form id="add-contact-form">
                <div class="form-group">
                    <label>Title</label>
                    <select name="title" required>
                        <option value="Mr.">Mr.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Prof.">Prof.</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstname" placeholder="Jane" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lastname" placeholder="Doe" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="something@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Telephone</label>
                        <input type="text" name="telephone" placeholder="123-456-7890" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" name="company" placeholder="Company Name">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" required>
                            <option value="Sales Lead">Sales Lead</option>
                            <option value="Support">Support</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Assigned To</label>
                    <select name="assigned_to" required>
                        <option value="">Select a user</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="save-button">Save</button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        $(document).ready(function () {
            $('#add-contact-form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        alert(response.message);
                        if (response.success) {
                            $('#add-contact-form')[0].reset();
                        }
                    },
                    error: function () {
                        alert('An error occurred while adding the contact.');
                    }
                });
            });
        });
    </script>
</body>
</html>
