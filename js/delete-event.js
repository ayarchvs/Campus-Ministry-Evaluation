$(document).ready(function() {
    // When the form submittedd

    console.log("Delete Event js file test");

    $('#userForm').on('submit', function(event) {
        event.preventDefault();  // dont submit liek usual

        var username = $('#username').val();
        var email = $('#email').val();

        // Perform the AJAX request to the PHP backend
        $.ajax({
            url: 'insert.php',  // Backend PHP script
            type: 'POST',       // POST method for sending data
            data: {
                username: username,
                email: email
            },
            success: function(response) {
                // Display the response from the PHP script
                $('#response').html(response);
            },
            error: function(xhr, status, error) {
                $('#response').html('Error: ' + error);
            }
        });
    });
});
