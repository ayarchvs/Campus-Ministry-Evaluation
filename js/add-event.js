document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
        event.preventDefault(); 

        // Pop up
        const UserConfirmed= confirm("Are you sure?");
        if (UserConfirmed) {
            const formData = new FormData(form);

            // Send the form data using AJAX
            fetch("php/add-event.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Event added successfully!");
                
                    window.location.href = "main-page.php";
                } else {
                    
                    alert("Failed to add event: " + data);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while adding the event.");
            });
        }
    });
});
