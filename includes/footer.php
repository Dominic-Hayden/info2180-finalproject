<!-- footer.php -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 Dolphin CRM. All rights reserved.</p>
</footer>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>

<script>
$(document).ready(function () {
    // Handle clicks on links with the class "ajax-link"
    $(".ajax-link").click(function (e) {
        e.preventDefault(); // Prevent default link behavior

        let url = $(this).attr("href"); // Get the URL from the link
        let target = $(this).data("target"); // Get the target container ID

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

    $('#content').on('click', '.ajax-link', function (e){
        e.preventDefault(); // Prevent default link behavior

        let url = $(this).attr("href"); // Get the URL from the link
        let target = $(this).data("target"); // Get the target container ID

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
});
</script>
