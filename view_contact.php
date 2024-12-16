<?php
// Enable error reporting for debugging (disable for production)
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'errors_log.txt');
error_reporting(E_ALL);

require 'db_connection.php'; // Database connection

// Check if 'id' is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Contact ID is required.');
}

$contact_id = intval($_GET['id']); // Sanitize the input
$contact = null;

// Fetch contact details
try {
    $stmt = $conn->prepare("
        SELECT c.id, c.title, c.firstname, c.lastname, c.email, c.telephone, c.company, c.type, 
               u.firstname AS assigned_firstname, u.lastname AS assigned_lastname
        FROM Contacts c
        LEFT JOIN Users u ON c.assigned_to = u.id
        WHERE c.id = ?
    ");
    $stmt->bind_param('i', $contact_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die('No contact found with the given ID.');
    }

    $contact = $result->fetch_assoc();
    $stmt->close();
} catch (Exception $e) {
    die("Error fetching contact: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Table Styling */
        .contact-details {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .contact-details table {
            width: 70%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .contact-details th,
        .contact-details td {
            padding: 15px 20px;
            border: 1px solid #ddd;
            font-size: 16px;
            color: #555;
            text-align: left;
        }

        .contact-details th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-align: left;
            width: 30%;
        }

        .contact-details td {
            background-color: #fff;
        }

        .type-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .type-sales-lead {
            background-color: #fbbf24;
            color: #333;
        }

        .type-support {
            background-color: #6366f1;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Contact Details</h1>
            <a href="dashboard.php" class="cta-button"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>

        <!-- Contact Details Table -->
        <div class="contact-details">
            <table>
                <tr>
                    <th>Title</th>
                    <td><?php echo htmlspecialchars($contact['title']); ?></td>
                </tr>
                <tr>
                    <th>First Name</th>
                    <td><?php echo htmlspecialchars($contact['firstname']); ?></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><?php echo htmlspecialchars($contact['lastname']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($contact['email']); ?></td>
                </tr>
                <tr>
                    <th>Telephone</th>
                    <td><?php echo htmlspecialchars($contact['telephone']); ?></td>
                </tr>
                <tr>
                    <th>Company</th>
                    <td><?php echo htmlspecialchars($contact['company']); ?></td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>
                        <span class="type-badge <?php echo ($contact['type'] == 'Sales Lead') ? 'type-sales-lead' : 'type-support'; ?>">
                            <?php echo strtoupper($contact['type']); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Assigned To</th>
                    <td><?php echo htmlspecialchars($contact['assigned_firstname'] . ' ' . $contact['assigned_lastname']); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
