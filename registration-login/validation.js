// Registration form validation
function validateRegistration() {
    let fullname = document.getElementById("fullname").value.trim();
    let email = document.getElementById("email").value.trim();
    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value;
    let confirm_password = document.getElementById("confirm_password").value;
    let country = document.getElementById("country").value;

    if (!fullname || !email || !username || !password || !confirm_password || !country) {
        alert("All fields are required!");
        return false;
    }

    // Email format
    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!email.match(emailPattern)) {
        alert("Invalid email format!");
        return false;
    }

    if (password !== confirm_password) {
        alert("Passwords do not match!");
        return false;
    }

    return true;
}

// Login form validation
function validateLogin() {
    let username = document.getElementById("login_username").value.trim();
    let password = document.getElementById("login_password").value;

    if (!username || !password) {
        alert("Both fields are required!");
        return false;
    }
    return true;
}
