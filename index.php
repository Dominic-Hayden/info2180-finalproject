<?php include 'database/db_connection.php'; ?>

<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, include home page
    include 'includes/header.php';
    include 'includes/navbar.php';

    echo '<div class="container-fluid" id="content" style="padding: 20px;">
    <!-- Default content loaded here -->';
    echo '</div>
    </div>';

    include 'includes/footer.php';

} else {
    // User is not logged in, include login page
    include 'pages/login.php';
}
?>

<script>
$(document).ready(function () {
    let url = 'pages/home.php';
    let target = $('#content') // Get the target container ID

    // Load content dynamically using AJAX
    $.ajax({
        url: url,
        type: "GET",
        success: function (data) {
            $(target).html(data); // Replace content inside the target
        },
        error: function () {
            $(target).html("<p class='text-danger'>An error occurred while loading content.</p>");
        }
    });
});
</script>