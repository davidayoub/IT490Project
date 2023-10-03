<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration and Login</title>
</head>
<body>
    <!-- Registration Form -->
    <form id="registerForm">
        <h2>Register</h2>
        <label for="registerUsername">Username:</label>
        <input type="text" id="registerUsername" name="username" minlength="3" required>
        <br>
        <label for="registerPassword">Password:</label>
        <input type="password" id="registerPassword" name="password" minlength="6" required>
        <br>
        <input type="submit" value="Register">
    </form>
    
    <hr>
    
    <!-- Login Form -->
    <form action="/login" method="post">

        <h2>Login</h2>
        <label for="loginUsername">Username:</label>
        <input type="text" id="loginUsername" name="username" minlength="3" required>
        <br>
        <label for="loginPassword">Password:</label>
        <input type="password" id="loginPassword" name="password" minlength="6" required>
        <br>
        <input type="submit" value="Login">
    </form>
    
    <script src="app.js"></script>
</body>
</html>


<script>
// Use HTTPS when sending data
// Add proper error handling
// Validate data before sending

document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault();
    
    let username = document.getElementById('registerUsername').value;
    let password = document.getElementById('registerPassword').value;
    
    // Perform client-side validation if needed
    
    if (username.length < 3 || password.length < 6) {
        alert("Username must be at least 3 characters and password at least 6 characters long.");
        return;
    }

    // Send to your backend API via Fetch API
    fetch('https://yourbackend/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: username,
            password: password
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));
});


</script>


