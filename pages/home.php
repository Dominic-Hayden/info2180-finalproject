<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="m-0">Dashboard</h1>
    <div>
        <select id="contact-filter" class="form-select form-select-sm" style="width: 200px; display: inline-block;">
            <option value="all">All Contacts</option>
            <option value="sales_lead">Sales Lead</option>
            <option value="support">Support</option>
            <option value="my_contacts">My Contacts</option>
        </select>
        <a href="pages/add_contact.php" class="btn btn-primary btn-sm ajax-link" data-target="#content">Add Contact</a>
    </div>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Company</th>
            <th>Type</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody id="contact-table-body">
        <tr>
            <td colspan="5" class="text-center">Loading contacts...</td>
        </tr>
    </tbody>
</table>

<script src="assets/js/contacts.js"></script
