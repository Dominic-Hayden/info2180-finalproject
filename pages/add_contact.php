<?php include '../database/get_users.php'; ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">New Contact</h3>
    </div>
    <div class="card-body">
        <form action="database/create_contact.php" method="POST">
            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <select name="title" id="title" class="form-select" required>
                    <option value="" disabled selected>Select a title</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Dr.">Dr.</option>
                    <option value="Prof.">Prof.</option>
                </select>
            </div>

            <!-- First Name -->
            <div class="mb-3">
                <label for="first-name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first-name" class="form-control" placeholder="Enter first name" required>
            </div>

            <!-- Last Name -->
            <div class="mb-3">
                <label for="last-name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last-name" class="form-control" placeholder="Enter last name" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" required>
            </div>

            <!-- Telephone -->
            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="Enter telephone number" required>
            </div>

            <!-- Company -->
            <div class="mb-3">
                <label for="company" class="form-label">Company</label>
                <input type="text" name="company" id="company" class="form-control" placeholder="Enter company name" required>
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="" disabled selected>Select type</option>
                    <option value="Sales_lead">Sales Lead</option>
                    <option value="Support">Support</option>
                </select>
            </div>

            <!-- Assigned To -->
            <div class="mb-3">
                <label for="assigned-to" class="form-label">Assigned To</label>
                <select name="assigned_to" id="assigned-to" class="form-select" required>
                    <option value="" disabled selected>Select a user</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>"><?= $user['firstname'] ?> <?= $user['lastname'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success" id="add">Create Contact</button>
                <a href="pages/home.php" class="btn btn-secondary ajax-link" data-target="#content">Cancel</a>
            </div>
        </form>
        <div id="result"></div>
    </div>
</div>

<script src="assets/js/contacts.js"></script
