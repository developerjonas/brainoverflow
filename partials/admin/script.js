document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector(".login-form");
    const signupForm = document.querySelector(".signup-form");

    if (loginForm) {
        loginForm.addEventListener("submit", function(event) {
            const username = loginForm.querySelector('input[type="text"]').value;
            const password = loginForm.querySelector('input[type="password"]').value;

            if (username === "" || password === "") {
                event.preventDefault();
                alert("Please fill in both username and password.");
            }
        });
    }

    if (signupForm) {
        signupForm.addEventListener("submit", function(event) {
            const fullName = signupForm.querySelector('input[placeholder="Full Name"]').value;
            const email = signupForm.querySelector('input[type="email"]').value;
            const username = signupForm.querySelector('input[placeholder="Username"]').value;
            const password = signupForm.querySelector('input[placeholder="Password"]').value;
            const confirmPassword = signupForm.querySelector('input[placeholder="Confirm Password"]').value;

            if (fullName === "" || email === "" || username === "" || password === "" || confirmPassword === "") {
                event.preventDefault();
                alert("Please fill out all fields.");
            } else if (password !== confirmPassword) {
                event.preventDefault();
                alert("Passwords do not match.");
            }
        });
    }
});
