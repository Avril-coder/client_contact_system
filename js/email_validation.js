document.addEventListener("DOMContentLoaded", () => {
    const emailInput = document.querySelector("input[name='email']");
    const form = document.querySelector("form");
    const messageDiv = document.createElement("div");
    emailInput.after(messageDiv);

    emailInput.addEventListener("input", () => {
        const email = emailInput.value.trim();
        if (email.length < 5) return;

        // Add email format validation here:
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            messageDiv.innerHTML = "<p style='color: red;'>Please enter a valid email address.</p>";
            emailInput.setCustomValidity("Please enter a valid email address.");
            return;
        }

        const allowedDomains = ['gmail.com', 'yahoo.com'];
        const emailParts = email.split('@');

        if (emailParts.length !== 2 || !allowedDomains.includes(emailParts[1].toLowerCase())) {
            messageDiv.innerHTML = "<p style='color: red;'>Only Gmail and Yahoo emails are allowed.</p>";
            emailInput.setCustomValidity("Only Gmail and Yahoo emails are allowed.");
            return;
        }

        fetch(`../controllers/check_email.php?email=${encodeURIComponent(email)}`)
            .then(res => res.json())
            .then(data => {
                if (data.unique === false) {
                    messageDiv.innerHTML = "<p style='color: red;'>Email already exists.</p>";
                    emailInput.setCustomValidity("Email already exists.");
                } else {
                    messageDiv.innerHTML = "";
                    emailInput.setCustomValidity(""); // valid
                }
            })
            .catch(err => {
                messageDiv.innerHTML = "<p style='color: red;'>Could not validate email.</p>";
                emailInput.setCustomValidity("Could not validate email.");
            });
    });
});
