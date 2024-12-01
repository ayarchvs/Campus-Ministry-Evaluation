$(document).ready(function() {
    console.log("Update Delete Staff JS file loaded");



        // Add click Staff listener to each "Delete" btn
        
        $('.staff-delete-btn').on('click', function() {
            const staffId = $(this).data('id');  // Get the data-id of the clicked button
            console.log("Clicked delete Btn: ", staffId);
        
            // Show confirmation dialog to the user
            const isConfirmed = confirm("Are you sure you want to delete this staff member?");
        
            // If confirmed
            if (isConfirmed) {
                // Send AJAX request to delete the staff
                $.ajax({
                    url: 'php/delete-staff.php',   // PHP script to delete staff
                    type: 'GET',
                    data: { id: staffId },         // Send staff ID to the PHP script
                    success: function(response) {
                        console.log("AJAX Response:", response);  // Log the response to check if it's JSON

                        try {
                            const data = JSON.parse(response); // Parse the response

                            // Check if the status is error due to foreign key constraint
                            if (data.status === 'error') {
                                alert(data.message); // Show the error message in a popup
                            } else if (data.status === 'success') {
                                console.log("Staff deleted successfully!");
                                alert("Staff deleted successfully!");
                                location.reload();  // Reload the page to update the list
                            }
                        } catch (error) {
                            console.error('Error parsing JSON:', error);
                            alert('Error processing the response.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error);  // Log any error
                        alert("An error occurred while deleting the staff.");
                    }
                });
            } else {
                console.log("Deletion cancelled.");
                alert("Staff deletion cancelled.");
            }
        });







///*



    // ================= For Update Staff ===================
    // Open the modal and populate fields when "Update" button is clicked

    var update_btn_id;

    $('.staff-update-btn').on('click', function () {
        const staffId = $(this).data('id');
        update_btn_id = staffId;

        console.log("Clicked Update Btn: ", staffId);

        // Fetch current Staff details using AJAX
        $.ajax({
            url: 'php/fetch-staff-details.php',
            type: 'GET', // Ensure this matches your PHP script's expected method
            data: { id: staffId },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        // Populate modal fields with the existing Staff data
                        
                        // Populate modal fields with the existing Staff data
                        var Name = data.staffData.S_Name; // Full name from the response

                        // Split the name into first and last name at the comma
                        var nameParts = Name.split(',');

                        var last_name = nameParts[0].trim();  // Get the last name if available
                        var first_name = nameParts[1] ? nameParts[1].trim() : '';  // Get the first name and trim spaces
                        
                        
                        
                        // Populate modal fields with the existing Staff data
                        $('#updateStaffFirstName').val(first_name);
                        $('#updateStaffLastName').val(last_name); // Populate month based on the fetched data

                        $('#updateStaffType').val(data.staffData.S_Type);
                        $('#updateStaffEmail').val(data.staffData.S_Email);
                        //$('#updateStaffPassword').val(); // Set Staff Type based on the fetched data
                        //$('#updateStaffConfirmPassword').val(); // Set Religion based on the fetched data

    
                        
                        // Show the modal
                        $('#updateStaffModal').modal('show');
                    } else {
                        alert('Failed to fetch Staff details: ' + data.message);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alert('Error processing the response from the server.');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                alert('An error occurred while fetching Staff details.');
            }
        });
    });

    

    // Submit the updated data when the form in the modal is submitted
    $('.update-information-btn').on('click', function (e) {
        e.preventDefault();  // Prevent form submission
    
        const password = $('#updateStaffPassword').val();
        const confirmPassword = $('#updateStaffConfirmPassword').val();


        if (!$('#updateStaffFirstName').val()) {
            alert("Must not leave First Name blank.");
            return;

        }

        if (!$('#updateStaffLastName').val()) {
            alert("Must not leave Last Name blank.");
            return;

        }

        if (!$('#updateStaffEmail').val()) {
            alert("Must not leave Email blank. (no need to add adzu.edu.ph)");
            return;

        }

    
        // Add password only if provided
        if ((password && !confirmPassword) || (!password && confirmPassword)) {
            alert("If you are trying to change the password, you must fill in both Password and Confirm Password.");

            // Prevent modal from closing on successful form submission
            //$('#updateStaffModal').modal('hide');
            return;  // Prevent form submission if passwords don't match
            
        }
    
        // Check if same password and confirm password have value and are the same
        if ((password && confirmPassword) && (password !== confirmPassword)) {
            alert("Password & Confirm Password do not match.");

            // Prevent modal from closing on successful form submission
            //$('#updateStaffModal').modal('hide');
            return;  // Prevent form submission if passwords do not match
        }
    
        // Gather updated data from form
        const updatedData = {
            staffId: update_btn_id,
            staffFirstName: $('#updateStaffFirstName').val(),
            staffLastName: $('#updateStaffLastName').val(),
            staffType: $('#updateStaffType').val(),
            staffEmail: $('#updateStaffEmail').val(),
            staffPassword: $('#updateStaffPassword').val(),  // Password field if updated  //staffFirstName staffLastName staffType staffEmail staffPassword
        };
    
        
        // Send update request via AJAX
        $.ajax({
            url: 'php/update-staff.php',
            type: 'POST',
            data: updatedData, // Make sure you're sending the updated data object correctly
            success: function(response) {
                console.log("AJAX Response:", response);
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert('Staff Details updated successfully!');
                        $('#updateStaffModal').modal('hide'); // Close the modal
                        location.reload(); // Reload to show updated data
                    } else {
                        alert('Failed to update Staff Details: ' + data.message);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alert('Error processing the update response.');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
                alert('An error occurred while updating the Staff Details.');
            }
        });  //*/
    });
    
    








});
