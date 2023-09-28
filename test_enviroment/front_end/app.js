document.addEventListener('DOMContentLoaded', function () {
    // Register Form Submission
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        e.preventDefault();
        
        let username = document.getElementById('registerUsername').value;
        let password = document.getElementById('registerPassword').value;
        
        if (username.length < 3 || password.length < 6) {
            alert("Username must be at least 3 characters and password at least 6 characters long.");
            return;
        }
        
        fetch('http://localhost/test_environment/back_end/back_end.php?action=register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: username,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
    });

    // Login Form Submission
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();
        
        let username = document.getElementById('loginUsername').value;
        let password = document.getElementById('loginPassword').value;
        
        if (username.length < 3 || password.length < 6) {
            alert("Username must be at least 3 characters and password at least 6 characters long.");
            return;
        }
        
        fetch('http://localhost/test_environment/back_end/back_end.php?action=login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: username,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
    });
});
