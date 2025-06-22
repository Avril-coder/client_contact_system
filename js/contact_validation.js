document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {
        const name = form.querySelector('input[name="name"]').value.trim();
        const surname = form.querySelector('input[name="surname"]').value.trim();
        const email = form.querySelector('input[name="email"]').value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let errors = [];

        if (!name) errors.push("Name is required.");
        if (!surname) errors.push("Surname is required.");
        if (!email || !emailPattern.test(email)) errors.push("Valid email is required.");

        if (errors.length > 0) {
            e.preventDefault();
            alert(errors.join("\n"));
        }
    });
});
