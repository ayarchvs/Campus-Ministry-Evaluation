$(document).ready(function() {
    console.log("View Event JS file loaded");

    // Add click event listener to each "View" button
    $('.view-btn').on('mousedown', function() {
        const eventId = $(this).data('id');  // Get the data-id of the clicked button
        console.log("Clicked View Btn: ", eventId);


        // button 1 = is middle click
        if(event.button === 1){
            event.preventDefault();

            // Send AJAX request to get event details
            $.ajax({
                url: 'php/fetch-event-details.php',   
                type: 'GET',
                data: { id: eventId },            // Send event ID to PHP script
                success: function(response) {
                    console.log("AJAX Response:", response);  
                
                    // try parse the response if it a string cuz if error or noh
                    try {
                        const data = JSON.parse(response); // Only parse if response is a string
                
                        if (data.status === 'success') {
                            console.log(data.eventData.Event_ID);
                            window.open("event-details.php?id=" + data.eventData.Event_ID, "_blank") // open to new tab if they want
                        } else {
                            console.log('Failed to fetch event details:', data.message);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);  // Log any error
                }
            });


        }

        else{
            // Send AJAX request to get event details
            $.ajax({
                url: 'php/fetch-event-details.php',   
                type: 'GET',
                data: { id: eventId },            // Send event ID to PHP script
                success: function(response) {
                    console.log("AJAX Response:", response);  
                
                    // try parse the response if it a string cuz if error or noh
                    try {
                        const data = JSON.parse(response); // Only parse if response is a string
                
                        if (data.status === 'success') {
                            console.log(data.eventData.Event_ID);
                            window.location.href = "event-details.php?id=" + data.eventData.Event_ID; // Redirect
                        } else {
                            console.log('Failed to fetch event details:', data.message);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);  // Log any error
                }
            });
        }

    });





        // Add click event listener to each "Delete" btn
        $('.delete-btn').on('click', function() {
            const eventId = $(this).data('id');  // Get the data-id of le clicked button
            console.log("Clicked delete Btn: ", eventId);
            
            // Show confirmation dialog to person
            const isConfirmed = confirm("Are you sure you want to delete this event?");
            // If (Yes)
            if (isConfirmed) {
                // Send AJAX req to delete event from database
                $.ajax({
                    url: 'php/delete-event.php',   // PHP script that deletes the event
                    type: 'GET',
                    data: { id: eventId },         // Send event ID to the PHP script
                    success: function(response) {
                        console.log("AJAX Response:", response);  // Log the response to check if it's JSON

                        // Try parsing the response if it's a string
                        try {
                            const data = JSON.parse(response); // Only parse if response is a string

                            if (data.status === 'success') {
                                console.log("Event deleted successfully!");
                                alert("Event deleted successfully!");
                                // Optionally, remove the row from the table (or reload the page)
                                location.reload();  // Reload the page to update the list
                            } else {
                                console.log('Failed to delete event:', data.message);
                                alert("Failed to delete event: " + data.message);
                            }
                        } catch (error) {
                            console.error('Error parsing JSON:', error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error);  // Log any error
                        alert("An error occurred while deleting the event.");
                    }
                });
            } else {
                console.log("Deletion cancelled.");
                // If user presses "No", you can add any other handling here, like showing a message
                alert("Event deletion cancelled.");
            }
        });










    // ================= For Update Event ===================
    // Open the modal and populate fields when "Update" button is clicked
    $('.event-update-btn').on('click', function () {
        const eventId = $(this).data('id');
        console.log("Clicked Update Btn: ", eventId);

        // Fetch current event details using AJAX
        $.ajax({
            url: 'php/fetch-event-details.php',
            type: 'GET', // Ensure this matches your PHP script's expected method
            data: { id: eventId },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        // Populate modal fields with the existing event data
                        $('#updateEventId').val(data.eventData.Event_ID);
                        $('#updateEventMonth').val(data.eventData.E_Month); // Populate month based on the fetched data
                        $('#updateEventDay').val(data.eventData.E_Day);
                        $('#updateEventYear').val(data.eventData.E_Year);
                        $('#updateEventType').val(data.eventData.E_Type); // Set Event Type based on the fetched data
                        $('#updateEventReligion').val(data.eventData.E_Religion); // Set Religion based on the fetched data
                        $('#updateEventLocation').val(data.eventData.E_Location);
                        $('#updateEventCourse').val(data.eventData.E_Course);
    
                        // Show the modal
                        $('#updateEventModal').modal('show');
                    } else {
                        alert('Failed to fetch event details: ' + data.message);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alert('Error processing the response from the server.');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                alert('An error occurred while fetching event details.');
            }
        });
    });

    // Submit the updated data when the form in the modal is submitted
    $('#updateEventForm').on('submit', function (e) {
        e.preventDefault();

        // Gather updated data from form
        const updatedData = {
            eventId: $('#updateEventId').val(),
            eventYear: $('#updateEventYear').val(),
            eventMonth: $('#updateEventMonth').val(),
            eventDay: $('#updateEventDay').val(),
            eventType: $('#updateEventType').val(),
            religion: $('#updateEventReligion').val(),
            location: $('#updateEventLocation').val(),
            course: $('#updateEventCourse').val()
        };

        // Send update request via AJAX
        $.ajax({
            url: 'php/update-event.php',
            type: 'POST',
            data: updatedData,
            success: function (response) {
                console.log("AJAX Response (raw):", response);  // Log the raw response
            
                try {
                    const data = JSON.parse(response);  // Try to parse JSON
                    console.log("Parsed JSON data:", data);
            
                    if (data.status === 'success') {
                        alert('Event Details updated successfully!');
                        $('#updateStaffModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Failed to update Staff Details: ' + data.message);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alert('Error processing the update response.');
                }
            },
            
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                alert('An error occurred while updating the event.');
            }
        });
    });
});
