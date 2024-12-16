<?php
include '../database/get_users.php';
session_start();

if($_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="m-0">Users</h1>
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <a href="pages/add_user.php" class="btn btn-primary ajax-link" data-target="#content">Add User</a>
    <?php endif; ?>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['firstname']); ?> <?= htmlspecialchars($user['lastname']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['role']); ?></td>
                    <td><?= htmlspecialchars($user['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No users found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
