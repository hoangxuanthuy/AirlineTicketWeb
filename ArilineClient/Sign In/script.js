const serverIp = 'localhost';
const serverPort = 8001;
document.getElementById('signInForm')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;


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
            console.log(response); // Log the response

            if (response.ok) {
                response.json().then(data => {
                    sessionStorage.setItem('auth_token', data.token);
                    sessionStorage.setItem('username', username);
                    sessionStorage.setItem('role', data.role);
                   
                    if (data.role === "user") {
                        window.location.href = "../TEST/index.html"; // Trang chính
                    } else if (data.role === "employee") {
                        window.location.href = "../TEST/index.html"; // Trang nhân viên
                    } else if (data.role === "director") {
                        window.location.href = "../TEST/index.html"; // Trang giám đốc
                    }
                });
            }
        })

});
