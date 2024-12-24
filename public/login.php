
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

    .background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('./assets/img/anh-dang-nhap.jpg') no-repeat center center;
        background-size: cover;
        z-index: -2;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.4);
        z-index: -1;
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
        background: url('./assets/img/anh-dang-nhap.jpg') no-repeat center;
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
        padding-right: 40px;
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

    .error-message {
        color: red;
        text-align: center;
        margin-top: 10px;
    }
</style>
</head>
<body>

<div class="background"></div>
<div class="overlay"></div>

<div class="container">
    <div class="image-section">
        <i class="fa-solid fa-plane-departure"></i>
    </div>
    <div class="form-section">
        <h2>Đăng Nhập</h2>
        <?php if (isset($error)): ?>
            <div class="error-message"> <?php echo $error; ?> </div>
        <?php endif; ?>
        <form onsubmit="login(event)">
    <div class="input-group">
        <input id="username" type="text" name="username" placeholder="Tên đăng nhập" required>
    </div>
    <div class="input-group">
        <input id="password" type="password" name="password" placeholder="Mật khẩu" required>
        <span class="toggle-password" onclick="togglePasswordVisibility()">
            <i class="fa-regular fa-eye"></i>
        </span>
    </div>
    <button type="submit" class="btn">Đăng Nhập</button>
</form>

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
function login(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của form

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const serverIp = "192.168.60.5"; // Đổi IP thành địa chỉ server API của bạn
    const serverPort = "8000";

    fetch(`http://${serverIp}:${serverPort}/api/login`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: username, // API của bạn yêu cầu `email` thay vì `username`
            password: password
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Đăng nhập thất bại.');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.token && data.role === "Admin") {
            alert('Đăng nhập thành công! Chào mừng, ' + username);
            // Lưu token và role vào localStorage
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('role', data.role);
            localStorage.setItem('isLoggedIn', true);
            
            // Chuyển hướng đến trang dashboard
            window.location.href = "/QLKhachHang/index.php";
        } else {
            alert('Bạn không có quyền truy cập. Chỉ tài khoản Admin mới được phép đăng nhập.');
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đăng nhập thất bại: ' + error.message);
    });
}


</script>


</body>
</html>
