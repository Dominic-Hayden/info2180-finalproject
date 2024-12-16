$(document).ready(function() {
    var button = $('#lookup');
    var button2 = $('#lookup_cities');

    button.on('click', function(element){
        element.preventDefault();
        var country = $('#country').val();
  
        $.ajax('http://localhost:8888/info2180-lab5/world.php', {
            method: 'POST',
            data: {
            country: country,
            lookup: ""
            }
        }).done(function(response) {
            var resp = response;
            console.log(resp);
            $('#result').html(resp);
        }).fail(function() {
            alert('There was a problem with the request.');
        });
    });

    button2.on('click', function(element){
        element.preventDefault();
        var country = $('#country').val();
  
        $.ajax('http://localhost:8888/info2180-lab5/world.php', {
            method: 'POST',
            data: {
            country: country,
            lookup: "cities"
            }
        }).done(function(response) {
            var resp = response;
            console.log(resp);
            $('#result').html(resp);
        }).fail(function() {
            alert('There was a problem with the request.');
        });
    });
});