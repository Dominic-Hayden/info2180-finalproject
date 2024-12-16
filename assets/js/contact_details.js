$(document).ready(function () {
    const contactId = $('#conHead').data("id");;

    // Assign to Me Button
    $('#assignBtn').on('click', function () {
        $.ajax('database/update_contact.php', {
            method: 'POST',
            data: {
                action: 'assign_to_me', 
                contact_id: contactId,
            }
        }).done(function(response) {
            try {
                console.log(response);
                const resp = JSON.parse(response); // Parse JSON response
                $('#assignedTo').text(resp.assigned_to);
                $('#lastUpdated').text(resp.updated_at);
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

    // Toggle Contact Type Button
    $('#toggleTypeBtn').on('click', function () {
        $.ajax('database/update_contact.php', {
            method: 'POST',
            data: {
                action: 'toggle_type', 
                contact_id: contactId,
            }
        }).done(function(response) {
            try {
                console.log(response);
                const resp = JSON.parse(response); // Parse JSON response
                $('#contactType').text(resp.new_type);
                $('#lastUpdated').text(resp.updated_at);
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

    // Add New Note
    $('#addNoteForm').on('submit', function (e) {
        e.preventDefault();
        const newNote = $('#newNote').val();
        $.ajax('database/add_note.php', {
            method: 'POST',
            data: {
                contact_id: contactId, 
                note: newNote,
            }
        }).done(function(response) {
            try {
                console.log(response);
                const resp = JSON.parse(response); // Parse JSON response
                const noteItem = `
                    <li class="list-group-item">
                        <strong>${resp.user}:</strong> ${resp.comment} 
                        <em>(${resp.date})</em>
                    </li>`;
                $('#notesList').append(noteItem);
                $('#newNote').val('');
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
});
