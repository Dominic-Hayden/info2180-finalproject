function loadContacts(filter) {
    $.ajax({
        url: 'database/get_contacts.php',
        method: 'GET',
        data: { filter: filter },
        success: function(data) {
            const tbody = $('#contact-table-body');
            tbody.empty();

            if (data.length > 0) {
                data.forEach(contact => {
                    tbody.append(`
                        <tr>
                            <td>${contact.title} ${contact.firstname} ${contact.lastname}</td>
                            <td>${contact.email}</td>
                            <td>${contact.company}</td>
                            <td>${contact.type}</td>
                            <td>
                                <a href="pages/view_contact.php?id=${contact.id}" class="btn btn-info btn-sm ajax-link" data-target="#content">View Details</a>
                            </td>
                        </tr>
                    `);
                });
            } else {
                tbody.append('<tr><td colspan="5" class="text-center">No contacts found.</td></tr>');
            }
        },
        error: function() {
            alert('Failed to load contacts. Please try again.');
        }
    });
}

function createContact(){
    var button = $('#add');

    button.on('click', function(element){
        element.preventDefault();
        var title = $('#title').val();
        var firstname = $('#first-name').val();
        var lastname = $('#last-name').val();
        var email = $('#email').val();
        var telephone = $('#telephone').val();
        var company = $('#company').val();
        var type = $('#type').val();
        var assigned_to = $('#assigned-to').val();

        $.ajax('database/create_contact.php', {
            method: 'POST',
            data: {
                title:title,
                firstname: firstname,
                lastname: lastname,
                email: email,
                telephone:telephone,
                company:company,
                type:type,
                assigned_to,assigned_to,
            }
            
        }).done(function(response) {
            try {
                console.log(response);
                const resp = JSON.parse(response); // Parse JSON response
                $('#result').text(resp.message).css('color', resp.status === 'success' ? 'green' : 'red');
            } catch (e) {
                //console.error('Error parsing response:', e);
                $('#result').text('Unexpected response from server.').css('color', 'red');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Request failed:', textStatus, errorThrown);
            $('#result').text('There was a problem with the request.').css('color', 'red');
        });
    });
}

// Event listener for filter dropdown
$(document).ready(function() {
    const filterDropdown = $('#contact-filter');

    // Load all contacts initially
    loadContacts('all');

    // Creates contact when button is pressed.
    createContact();

    // Load contacts based on filter change
    filterDropdown.on('change', function() {
        const selectedFilter = $(this).val();
        loadContacts(selectedFilter);
    });
});
