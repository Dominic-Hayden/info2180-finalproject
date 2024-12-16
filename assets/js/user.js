$(document).ready(function() {
    var button = $('#add');

    button.on('click', function(element){
        element.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var cpassword = $('#confirm-password').val();
        var role= $('#role').val();

        const nname = name.split(" ", 2);
        if (nname.length < 2){
            alert('Please Enter Full Name');
            return;
        }
        if (!(password===cpassword)){
            alert('Passwords do not match');
            return;
        }

        var firstname = nname[0];
        var lastname = nname[1];

        let contain_capital = /[A-Z]/;
        let contain_number = /[0-9]/;
        let contain_atleast = /(.){8,}/;

        if (!contain_capital.test(password)){
            alert('Password Needs to contain a Capital Letter');
            return ;
        }

        if (!contain_number.test(password)){
            alert('Password Needs to contain a Number');
            return ;
        }

        if (!contain_atleast.test(password)){
            alert('Password Needs to contain at least 8 characters');
            return ;
        }


        $.ajax('database/create_user.php', {
            method: 'POST',
            data: {
                firstname: firstname,
                lastname: lastname,
                email: email,
                password:password,
                role:role,
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
});