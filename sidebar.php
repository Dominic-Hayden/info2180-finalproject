<?php
// Enable error reporting for debugging (comment out for production)
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');
error_reporting(E_ALL);

include 'db_connection.php';  // Include database connection

// Fetch user data
$users = [];
try {
    $stmt = $conn->prepare("SELECT firstname, lastname, email, role, created_at FROM Users ORDER BY created_at DESC");
    if (!$stmt) {
        die("SQL preparation failed: " . $conn->error);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

$conn->close(); // Close the connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Include existing dashboard CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Adjust main content for sidebar */
        .main-content {
            margin-left: 220px; /* Match sidebar width */
            padding: 20px;
            background-color: #f9fafb;
            min-height: 100vh; /* Full height */
        }

        /* Header alignment */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #333;
        }

        .add-button {
            display: inline-block;
            background-color: #4f46e5;
            color: #fff;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .add-button:hover {
            background-color: #3730a3;
        }

        /* Table styling */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .user-table th, .user-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .user-table thead {
            background-color: #f3f4f6;
        }

        .user-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .user-table tbody tr:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Users</h1>
            <a href="add_user.php" class="add-button">
                <i class="fas fa-plus"></i> Add User
            </a>
        </div>

        <!-- User Table -->
        <table class="user-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></strong></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($user['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
