
const serverIp = '172.20.10.4';
const serverPort = 8000;
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
                    sessionStorage.setItem('account_id', data.account_id);
                   
                    if (data.role === "Customer") {
                        window.location.href = "../TEST/index.php"; // Trang chính
                    } else if (data.role === "Staff") {
                        window.location.href = "../TEST/index.php"; // Trang nhân viên
                    } else if (data.role === "Director") {
                        window.location.href = "../TEST/index.php"; // Trang giám đốc
                    }
                });
            }
        })

});