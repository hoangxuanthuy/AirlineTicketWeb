document.getElementById('signInForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    // Here you can add your authentication logic
    console.log('Login attempt:', { username, password });
    
    const serverIp = "127.0.0.1";
    const serverPort = "8001";

    console.log('Server IP:', serverIp);
    fetch(`http://${serverIp}:${serverPort}/api/login`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: username,
            password: password
        })
    })
    .then(response => {
        console.log('Response:', response);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text().then(text => text ? JSON.parse(text) : {});
    })
    .then(data => {
       // TODO: check the status code not the message
        if (data.message === 'Login successful') {
            alert('Sign in successful!\nWelcome ' + username);
            window.location.href = '/dashboard'; // Navigate to dashboard page
        } else {
            alert('Sign in failed: ' + JSON.stringify(data));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Sign in failed: ' + error.message);
    });
});