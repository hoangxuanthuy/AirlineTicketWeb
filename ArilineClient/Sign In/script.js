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
// Lấy đối tượng form và nút sign-in
document.getElementById("signInForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Ngăn chặn hành động gửi form mặc định

    // Kiểm tra giá trị username và password (nếu cần)
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Giả sử kiểm tra thành công, chuyển hướng đến trang chủ
    if (username && password) { // Bạn có thể thêm logic kiểm tra đăng nhập tại đây
        window.location.href ="http://127.0.0.1:5501/ArilineClient/TEST/index.html"; // Đường dẫn đến giao diện trang chủ
    } else {
        alert("Please fill in both username and password.");
    }
});
