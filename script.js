document.addEventListener("DOMContentLoaded", function() {
    // Form validation and submission
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        
        // Get form fields
        var name = document.getElementById('name').value.trim();
        var email = document.getElementById('email').value.trim();
        var message = document.getElementById('message').value.trim();
        
        // List of validation errors
        var errors = [];

        // Validate Name
        if (name === "") {
            errors.push("Name is required.");
        }

        // Validate Email
        var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        if (email === "") {
            errors.push("Email is required.");
        } else if (!email.match(emailPattern)) {
            errors.push("Please enter a valid email address.");
        }

        // Validate Message
        if (message === "") {
            errors.push("Message cannot be empty.");
        }

        // Check if there are any errors
        if (errors.length > 0) {
            // Show the error messages in a popup
            alert("The following errors occurred:\n" + errors.join("\n"));
        } else {
            // If no errors, submit the form using the form's submit method
            this.submit(); 
        }
    });
});


