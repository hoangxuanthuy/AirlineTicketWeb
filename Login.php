<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Quicksand', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        overflow: hidden;
        position: relative;
    }

    /* Nền mờ */
    .background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('./assets/img/ảnh đăng nhập.jpg') no-repeat center center;
        background-size: cover;
        z-index: -2; /* Đặt lớp nền ở phía sau */
    }

    /* Lớp phủ màu trắng mờ */
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.4); /* Màu trắng mờ 40% */
        z-index: -1; /* Đặt lớp phủ giữa nền và form */
    }

    .container {
        display: flex;
        width: 60%;
        max-width: 1000px;
        height: 500px;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 1;
    }

    .container .image-section {
        flex: 1.2;
        background: url('./assets/img/ảnh đăng nhập.jpg') no-repeat center;
        background-size: cover;
        position: relative;
    }

    .container .image-section i {
        font-size: 60px;
        color: white;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .container .form-section {
        flex: 1;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #fff;
    }

    .form-section h2 {
        margin-bottom: 30px;
        color: #333;
        font-size: 28px;
        font-weight: 600;
        text-align: center;
    }

    .form-section .input-group {
        position: relative;
        margin-bottom: 20px;
    }

    .form-section .input-group input {
        width: 100%;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 25px;
        font-size: 16px;
        outline: none;
        padding-right: 40px; /* space for eye icon */
    }

    .form-section .input-group .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 18px;
        color: #aaa;
    }

    .form-section .btn {
        background: linear-gradient(to right, #4facfe, #00f2fe);
        color: white;
        border: none;
        padding: 15px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        margin-top: 20px;
        text-align: center;
    }

    .form-section .btn:hover {
        background: linear-gradient(to right, #3a9ad9, #00c9fe);
    }

    .form-section .options {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        font-size: 14px;
        color: #555;
    }

    .form-section .options a {
        color: #007bff;
        text-decoration: none;
    }

    .form-section .options a:hover {
        text-decoration: underline;
    }

    .form-section .checkbox-label {
        display: flex;
        align-items: center;
    }

    .form-section .checkbox-label input {
        margin-right: 5px;
    }
</style>
</head>
<body>

<div class="background"></div> <!-- Lớp nền -->
<div class="overlay"></div> <!-- Lớp phủ màu trắng mờ -->

<div class="container">
    <div class="image-section">
        <i class="fa-solid fa-plane-departure"></i>
    </div>
    <div class="form-section">
        <h2>Đăng Nhập</h2>
        <div class="input-group">
            <input type="email" placeholder="Email của bạn" id="username" required>
        </div>
        <div class="input-group">
            <input type="password" id="password" placeholder="Mật khẩu" required>
            <span class="toggle-password" onclick="togglePasswordVisibility()">
                <i class="fa-regular fa-eye"></i>
            </span>
        </div>
        <button class="btn" onclick="login(event)">Đăng Nhập</button>
        <div class="options">
            <label class="checkbox-label"><input type="checkbox"> Ghi nhớ mật khẩu</label>
            <a href="#">Quên mật khẩu?</a>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        const passwordToggle = document.querySelector('.toggle-password i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordToggle.classList.remove('fa-eye');
            passwordToggle.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            passwordToggle.classList.remove('fa-eye-slash');
            passwordToggle.classList.add('fa-eye');
        }
    }

    const correctUsername = "admin";
    const correctPassword = "123456";

    // Hàm xử lý đăng nhập
    function login(e) {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        
        // Kiểm tra tài khoản và mật khẩu
        if (username === correctUsername && password === correctPassword) {
            // Nếu đăng nhập đúng, chuyển hướng đến trang chào mừng
            localStorage.setItem("isLoggedIn", true);
            window.location.href = "ThongKe/index.html";
            return false;  // Ngừng gửi form
        } else {
            // Hiển thị thông báo lỗi nếu tài khoản hoặc mật khẩu sai
            document.getElementById("error-message").style.display = "block";
            return false;  // Ngừng gửi form
        }
    }

    // function login(e) {
    //     e.preventDefault();
    
    //     const username = document.getElementById('username').value;
    //     const password = document.getElementById('password').value;
        
    //     // Here you can add your authentication logic
    //     console.log('Login attempt:', { username, password });
        
    //     const serverIp = "127.0.0.1";
    //     const serverPort = "8001";

    //     console.log('Server IP:', serverIp);  
    //     fetch(`http://${serverIp}:${serverPort}/api/login`, {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify({
    //             email: username,
    //             password: password,
    //             role : 'Admin'
    //         })
    //     })
    //     .then(response => {
    //         // Kiểm tra trạng thái HTTP
    //         if (!response.ok) {
    //             return response.json().then(err => {
    //                 throw new Error(err.message || 'Đăng nhập thất bại.');
    //             });
    //         }
    //         return response.json(); // Trích xuất JSON từ phản hồi
    //     })
    //     .then(data => {
    //         // Kiểm tra phản hồi từ server
    //         if (data.token) {
    //             alert('Đăng nhập thành công! Chào mừng, ' + username);
                
    //             // Lưu token vào localStorage
    //             localStorage.setItem('auth_token', data.token);
    //             localStorage.setItem("isLoggedIn", true);
    //             // Chuyển hướng đến trang dashboard
    //             window.location.href = "ThongKe.html";
    //         } else {
    //             alert('Đăng nhập thất bại: ' + (data.message || 'Lỗi không xác định.'));
    //         }
    //     })
    //     .catch(error => {
    //         // Xử lý lỗi kết nối hoặc lỗi khác
    //         console.error('Lỗi:', error);
    //         alert('Đăng nhập thất bại: ' + error.message);
    //     });
    // }

    
</script>

</body>
</html>