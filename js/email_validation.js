document.addEventListener("DOMContentLoaded", () => {
    const emailInput = document.querySelector("input[name='email']");
    const form = document.querySelector("form");
    const messageDiv = document.createElement("div");
    emailInput.after(messageDiv);

    emailInput.addEventListener("input", () => {
        const email = emailInput.value.trim();
        if (email.length < 5) return;

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
