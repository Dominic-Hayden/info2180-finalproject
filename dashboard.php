<?php
// Enable error reporting for debugging (comment out for production)
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
error_reporting(E_ALL);

session_start();
include('db_connection.php'); // Database connection

// Get the logged-in user's ID
$current_user_id = $_SESSION['user_id'] ?? 1; // Default for testing purposes

// Get the filter type from URL or default to 'all'
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Build the SQL query based on the filter
if ($filter == 'sales_leads') {
    $sql = "SELECT c.id, c.title, CONCAT(c.firstname, ' ', c.lastname) AS full_name, c.email, c.company, c.type 
            FROM Contacts c WHERE c.type = 'Sales Lead'";
} elseif ($filter == 'support') {
    $sql = "SELECT c.id, c.title, CONCAT(c.firstname, ' ', c.lastname) AS full_name, c.email, c.company, c.type 
            FROM Contacts c WHERE c.type = 'Support'";
} elseif ($filter == 'assigned_to_me') {
    $sql = "SELECT c.id, c.title, CONCAT(c.firstname, ' ', c.lastname) AS full_name, c.email, c.company, c.type 
            FROM Contacts c WHERE c.assigned_to = $current_user_id";
} else {
    $sql = "SELECT c.id, c.title, CONCAT(c.firstname, ' ', c.lastname) AS full_name, c.email, c.company, c.type 
            FROM Contacts c";
}

$result = mysqli_query($conn, $sql);

// Check for SQL errors
if (!$result) {
    die("Error fetching contacts: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Include Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Dashboard</h1>
                <a href="add_contact.php" class="cta-button"><i class="fas fa-plus"></i> Add New Contact</a>
            </div>

            <!-- Filters Section -->
            <div class="filters">
                <i class="fas fa-filter"></i>
                <span style="margin-right: 10px; font-weight: bold;">Filter By:</span>
                <a href="dashboard.php?filter=all" class="filter-btn <?php echo ($filter == 'all') ? 'active' : ''; ?>">All</a>
                <a href="dashboard.php?filter=sales_leads" class="filter-btn <?php echo ($filter == 'sales_leads') ? 'active' : ''; ?>">Sales Leads</a>
                <a href="dashboard.php?filter=support" class="filter-btn <?php echo ($filter == 'support') ? 'active' : ''; ?>">Support</a>
                <a href="dashboard.php?filter=assigned_to_me" class="filter-btn <?php echo ($filter == 'assigned_to_me') ? 'active' : ''; ?>">Assigned to Me</a>
            </div>

            <!-- Contacts Table -->
            <div class="contacts-list">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['title'] . ' ' . $row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['company']); ?></td>
                                    <td>
                                        <span class="type-badge <?php echo ($row['type'] == 'Sales Lead') ? 'type-sales-lead' : 'type-support'; ?>">
                                            <?php echo strtoupper($row['type']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="view_contact.php?id=<?php echo $row['id']; ?>" class="view-btn">View</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">No contacts found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
