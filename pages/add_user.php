<?php
session_start();

if($_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
}
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Add User</h3>
    </div>
    <div class="card-body">
        <form action="database/create_user.php" method="POST">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" required>
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="" disabled selected>Select role</option>
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </select>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm-password" class="form-control" placeholder="Re-enter password" required>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success" id="add">Add User</button>
                <a href="pages/users.php" class="btn btn-secondary ajax-link" data-target="#content">Cancel</a>
            </div>
        </form>
        <div id="result"></div>
    </div>
</div>

<script src="assets/js/user.js"></script
