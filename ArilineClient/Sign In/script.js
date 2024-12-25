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
document.getElementById("signInForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Ngăn chặn hành động gửi form mặc định

    // Lấy giá trị từ form
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Danh sách tài khoản cứng
    const users = [
        { username: "Ngọc Minh", password: "123456", role: "user" }, // Người dùng thông thường
        { username: "Nhân Viên", password: "654321", role: "employee" }, // Nhân viên
        { username: "Giám Đốc", password: "admin123", role: "director" } // Giám đốc
    ];

    // Kiểm tra thông tin đăng nhập
    const user = users.find(user => user.username === username && user.password === password);

    if (user) {
        // Lưu tên người dùng và vai trò vào sessionStorage
        sessionStorage.setItem("username", user.username);
        sessionStorage.setItem("role", user.role);

        // Thông báo đăng nhập thành công
        alert("Đăng nhập thành công! Xin chào, " + user.username);

        // Chuyển hướng dựa trên vai trò
        if (user.role === "user") {
            window.location.href = "../TEST/index.html"; // Trang chính
        } else if (user.role === "employee") {
            window.location.href = "../TEST/index.html"; // Trang nhân viên
        } else if (user.role === "director") {
            window.location.href = "../TEST/index.html"; // Trang giám đốc
        }
    } else {
        // Thông báo nếu thông tin không đúng
        alert("Sai tên đăng nhập hoặc mật khẩu. Vui lòng thử lại.");
    }
});

