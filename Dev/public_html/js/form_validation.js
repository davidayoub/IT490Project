
function validate(form) {
    // Clear previous errors
    let errors = document.querySelectorAll('.error');
    errors.forEach(error => {
        error.remove();
    });

    let valid = true; // Assume the form is valid until a check proves otherwise

    // Email validation
    let email = form["email"].value.trim();
    let emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (email === "" || !emailRegex.test(email)) {
        displayError(form["email"], "Invalid email.");
        valid = false;
    }

    // Username validation
    let username = form["username"].value.trim();
    let usernameRegex = /^[a-z0-9_-]{3,30}$/i;
    if (username === "" || !usernameRegex.test(username)) {
        displayError(form["username"], "Username must only be alphanumeric and can contain - or _. Must be between 3 and 30 characters.");
        valid = false;
    }

    // Password validation
    let password = form["password"].value;
    if (password === "" || password.length < 8) {
        displayError(form["password"], "Password must not be empty and should be at least 8 characters.");
        valid = false;
    }

    // Confirm password validation
    let confirm = form["confirm"].value;
    if (confirm === "" || password !== confirm) {
        displayError(form["confirm"], "Confirm password must not be empty and should match the password.");
        valid = false;
    }

    return valid; // Return the validity status
}

function displayError(element, message) {
    let errorDiv = document.createElement('div');
    errorDiv.className = "error";
    errorDiv.style.color = "red";
    errorDiv.innerText = message;
    element.after(errorDiv);
}

