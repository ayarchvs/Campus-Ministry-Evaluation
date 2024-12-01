document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("registerForm");
    const createAccBtn = document.getElementById("createAccBtn");

    console.log("Register Staff JS file loaded");


    $('#createAccBtn').on('click', function(e) {
       
        e.preventDefault();

        const password = $('#inputPassword').val();
        const confirmPassword = $('#inputPasswordConfirm').val();


        if (!$('#inputFirstName').val()) {
            alert("Must not leave First Name blank.");
            return;

        }

        if (!$('#inputLastName').val()) {
            alert("Must not leave Last Name blank.");
            return;

        }

        if (!$('#inputEmail').val()) {
            alert("Must not leave Email blank. (no need to add adzu.edu.ph)");
            return;

        }
        
        
        if (!password) {
            alert("Must not leave Password blank.");
            return;

        }
    

        if (!confirmPassword) {
            alert("Must not leave Confirm Password blank.");
            return;

        }

        // Check if same password and confirm password have value and are the same
        if ((password && confirmPassword) && (password !== confirmPassword)) {
            alert("Password & Confirm Password do not match.");

            // Prevent modal from closing on successful form submission
            //$('#updateStaffModal').modal('hide');
            return;  // Prevent form submission if passwords do not match
        }


        if (!$('#inputType').val()) {
            alert("Must Select a Type.");
            return;

        }




      //popup
        const confirmation = confirm("Are you sure to create this account?");
        
        if (confirmation) {
            //If user confirms, submit form data via AJAX or standard form submission
            //registerForm.submit();
            // direct to staff list.php
            //window.location.href = "staff-list.php";

            // Send update request via AJAX


            // Gather updated data from form
            const addedData = {
                //staffId: update_btn_id,
                staffFirstName: $('#inputFirstName').val(),
                staffLastName: $('#inputLastName').val(),
                staffType: $('#inputType').val(),
                staffEmail: $('#inputEmail').val(),
                staffPassword: $('#inputPassword').val(),  // Password field if updated  //staffFirstName staffLastName staffType staffEmail staffPassword
            };




            $.ajax({
            url: 'php/add-staff.php',
            type: 'POST',
            data: addedData, // Make sure you're sending the updated data object correctly
            success: function(response) {
                console.log("AJAX Response:", response);
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert('Staff Details added successfully!');
                        //$('#updateStaffModal').modal('hide'); // Close the modal
                        //location.reload(); // Reload to show updated data

                        window.location.href = "staff-list.php";

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




        }
        // If the user presses no, the form submission is canceled and nothing happens




    });
   
});
