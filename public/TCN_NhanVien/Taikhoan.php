
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Booking</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0088cc;
            --secondary-color: #005580;
            --background-color: #f5f5f5;
            --text-color: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg,
                    #ffffff 0%,
                    #e6f2ff 25%,
                    #ffffff 50%,
                    #e6f2ff 75%,
                    #ffffff 100%);
            background-size: 400% 400%;
            animation: gradientBackground 10s ease infinite;
        }


        /* Header */
        .header {
            background-color: var(--primary-color);
            padding: 1rem 0;
            position: fixed;
            /* Cố định header */
            top: 0;
            /* Đặt header ở trên cùng */
            left: 0;
            /* Đặt header ở bên trái */
            width: 100%;
            /* Header rộng 100% */
            z-index: 1000;
            /* Đảm bảo header nằm trên các phần tử khác */
        }

        /* Điều chỉnh phần nội dung để không bị che khuất bởi header */
        .body {
            padding-top: 80px;
            /* Giảm khoảng cách đầu trang để không bị che */
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            height: 40px;
        }

        .nav-menu {
            display: flex;
            gap: 2rem;
        }

        .nav-menu a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
        }

        * Header styles */ .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
        }

        .header-content {
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: space-between;
        }

        .logo {
            height: 50px;
        }

        .nav-menu {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            /* Thống nhất font chữ */
            font-size: 16px;
            /* Thống nhất kích thước chữ */
        }

        .nav-menu a:hover {
            background-color: #0056b3;
        }

        /* Dropdown specific styles */
        .dropdown {
            position: relative;
            /* Đảm bảo dropdown được đặt đúng vị trí */
        }

        .dropdown-toggle {
            color: white;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 16px;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            /* Đẩy menu dropdown vào trong */
            background-color: white;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            /* Đảm bảo dropdown có z-index cao để không bị khuất */
            list-style-type: none;
            padding: 0;
            margin: 0;
            border-radius: 5px;
            min-width: 200px;
            /* Đặt chiều rộng tối thiểu để không bị mất chữ */
            white-space: nowrap;
            /* Đảm bảo nội dung không bị xuống dòng */
            overflow: hidden;
            /* Xử lý trường hợp chữ quá dài */
        }

        .dropdown-menu li {
            border-bottom: 1px solid #ddd;
        }

        .dropdown-menu li:last-child {
            border-bottom: none;
        }

        .dropdown-menu li a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            font-family: Arial, sans-serif;
            font-size: 16px;
            white-space: nowrap;
            /* Ngăn nội dung bị xuống dòng */
        }
        .dropdown-menu button{
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            font-family: Arial, sans-serif;
            font-size: 16px;
            white-space: nowrap;
            /* Ngăn nội dung bị xuống dòng */
        }


        .dropdown-menu li a:hover {
            background-color: #f1f1f1;
        }

        /* Đảm bảo dropdown hiển thị đầy đủ khi có quá nhiều mục */
        .dropdown-menu {
            overflow-y: auto;
            max-height: 300px;
            /* Đặt chiều cao tối đa nếu cần cuộn */
        }



        /* Show dropdown menu on hover */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .main-container {
            display: flex;
            flex-direction: row;
            /* Đảm bảo nội dung nằm ngang */
            gap: 20px;
            /* Khoảng cách giữa sidebar và content */
            align-items: flex-start;
            /* Căn nội dung phía trên */
            margin-top: 100px;
            /* Đảm bảo không bị che bởi header */
        }

        .sidebar {
            flex: 0 0 250px;
            /* Chiều rộng cố định của sidebar */
            max-width: 250px;
            background: linear-gradient(to bottom, #2c7da0, #00b4d8);
            color: white;
            border-radius: 10px;
            padding: 30px 15px;
            height: auto;
            /* Để tự động điều chỉnh chiều cao */
        }

        .content {
            flex: 1;
            /* Nội dung chiếm toàn bộ phần còn lại */
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }


        .sidebar .active {
            background-color: #0096c7;
            border-radius: 5px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        /* Tabs */
        .tabs {
            display: flex;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            color: var(--text-color);
        }

        .tab.active {
            border-bottom-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Forms */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid black;
            border-radius: 4px;
            font-size: 1rem;
        }

        .btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background: var(--secondary-color);
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .main-container {
                flex-direction: column;
                gap: 1rem;
            }

            .sidebar {
                width: 100%;
                padding: 1rem;
            }

            .content {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-menu {
                flex-direction: column;
                gap: 0.5rem;
                align-items: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 1rem;
            }

            .nav-menu a {
                padding: 0.5rem;
                font-size: 0.9rem;
            }

            .sidebar {
                padding: 0.75rem;
            }

            .avatar {
                width: 80px;
                height: 80px;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <img src="img/Logo.png" alt="JO4 Airlines" class="logo">
            <nav class="nav-menu">
                <a href="#" id="home-link">Trang chủ</a>
                <a href="#" id="journey-info-link">Thông tin hành trình</a>
                <a href="#">Liên hệ</a>

                <!-- Dropdown Tài khoản -->
                <div class="dropdown" id="account-dropdown">
                    <a href="#" class="dropdown-toggle" id="user-account">Nhân viên</a>
                    <ul class="dropdown-menu" id="account-menu">
                        <li><a href="../TCN_NhanVien/Taikhoan.php">Tài khoản</a></li>
                        <li><a href="../TCN_NhanVien/Phieudat.php">Xử lý phiếu đặt</a></li>
                        <li><a href="../TCN_NhanVien/Xulyve.php">Xử lý vé</a></li>
                        <li><a href="../TCN_NhanVien/Xulytt.php">Xử lý thông tin KH</a></li>
                        <li><button id="logout-link" onclick="dangxuat()">Đăng xuất</button></li>
                    </ul>
                </div>

            </nav>
        </div>
    </header>
    <main class="main-container">
        <nav class="sidebar">
            <div class="text-center mb-4">
                <i class="fa-regular fa-user-circle fa-3x"></i>
                <p class="mt-2">Welcome,<br><b>Admin</b></p>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="Taikhoan.php" class="nav-link active" id="accountLink">Tài Khoản</a></li>
                <li class="nav-item"><a href="Xulytt.php" class="nav-link">Khách Hàng</a></li>
                <li class="nav-item"><a href="Xulyve.php" class="nav-link">Vé</a></li>
                <li class="nav-item"><a href="Phieudat.php" class="nav-link">Phiếu đặt</a></li>
                <li class="nav-item">
                    <button onclick="logout()" class="nav-link" style="color: white;">
                        <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                    </button>
                </li>
            </ul>
        </nav>

        <div class="content" id="mainContent">
            <!-- Nội dung sẽ được tải ở đây -->
        </div>
    </main>

    <script>
        const templates = {
            account: `
        <div id="accountContent">
            <div class="content-header">
                <h1>Cài đặt</h1>
                <div class="tabs">
                    <div class="tab active" data-tab="info">Thông tin cá nhân</div>
                    <div class="tab" data-tab="security">Mật khẩu và bảo mật</div>
                </div>
            </div>
            <div id="infoTab">
                <form id="profileForm" class="form-grid">
                    <div class="form-group">
                        <label>Họ Tên</label>
                        <input type="text" name="fullName">
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <input type="text" name="gender">
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh</label>
                        <input type="date" name="birthDate">
                    </div>
                    <div class="form-group">
                        <label>CCCD</label>
                        <input type="text" name="idNumber">
                    </div>
                    <div class="form-group">
                        <label>Quốc gia</label>
                        <input type="text" name="country">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="tel" name="phone">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <button type="submit" class="btn">Chỉnh sửa</button>
                    </div>
                </form>
            </div>
            <div id="securityTab" style="display: none;">
                <form id="passwordForm">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email">
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="password" name="currentPassword">
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu mới</label>
                        <input type="password" name="newPassword">
                    </div>
                    <div class="form-group">
                        <label>Xác nhận mật khẩu</label>
                        <input type="password" name="confirmPassword">
                    </div>
                    <button type="submit" class="btn">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    `,
        };


        function loadContent(page) {
            const mainContent = document.getElementById('mainContent');
            if (mainContent && templates[page]) {
                mainContent.innerHTML = templates[page];

                // Đảm bảo cập nhật trạng thái "active" đúng cách
                document.querySelectorAll('.sidebar a').forEach(link => {
                    link.classList.remove('active');
                });
                const activeLink = document.getElementById(page + 'Link');
                if (activeLink) activeLink.classList.add('active');

                // Khởi tạo tabs nếu là trang "account"
                if (page === 'account') initializeTabs();
            } else {
                console.error('Không tìm thấy nội dung hoặc template.');
            }
        }


        // Initialize tabs
        function initializeTabs() {
            const tabs = document.querySelectorAll('.tab');
            const infoTab = document.getElementById('infoTab');
            const securityTab = document.getElementById('securityTab');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    if (tab.dataset.tab === 'info') {
                        infoTab.style.display = 'block';
                        securityTab.style.display = 'none';
                    } else {
                        infoTab.style.display = 'none';
                        securityTab.style.display = 'block';
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            // Gắn sự kiện click cho tab "Tài khoản"
            document.getElementById("accountLink").addEventListener("click", (e) => {
                e.preventDefault();
                loadContent("account");
            });

            // Load nội dung mặc định
            loadContent("account");
        });

        // Gắn sự kiện cho "Đăng xuất"

        function dangxuat() {


            sessionStorage.removeItem("username");

            sessionStorage.removeItem("role");
            window.location.href = "../TEST/index.php";
        }

        function logout() {
            // Cảnh báo xác nhận trước khi đăng xuất
            const confirmation = window.confirm("Bạn có chắc chắn muốn đăng xuất?");

            if (confirmation) {
                // Nếu người dùng chọn OK, quay lại trang đăng nhập
                localStorage.removeItem("isLoggedIn");
                window.location.href = "../Sign In/index.php";  // Chuyển về trang login
            } else {
                // Nếu người dùng chọn Cancel, không làm gì
                console.log("Đăng xuất đã bị hủy");
            }
        }


        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function () {
                document.querySelector('.tab.active').classList.remove('active');
                this.classList.add('active');
            });
        });

        // Form submission
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Đã lưu thông tin thành công!');
        });

        // Menu item clicking
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function () {
                document.querySelector('.menu-item.active').classList.remove('active');
                this.classList.add('active');
            });
        });

    </script>
</body>

</html>