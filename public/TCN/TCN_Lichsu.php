<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JO4 Travel - Tài khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        /* Phần Icon nằm dưới banner */
        .icon-container {
            background-color: var(--white);
            padding: 1rem 2rem;
            margin-top: 2rem;
            /* Tách khung khỏi banner */
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .icon-container i {
            font-size: 2rem;
            /* Đặt kích thước icon */
            color: #333;
            /* Màu sắc của icon */
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
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
            min-width: 150px;
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
            text-align: center;
            /* Ngăn nội dung bị xuống dòng */
        }

        .dropdown-menu button {
            /* display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            font-family: Arial, sans-serif;
            font-size: 16px;
            white-space: nowrap; */
            /* Ngăn nội dung bị xuống dòng */
            border: none; /* Loại bỏ khung viền */
            background-color: white; /* Nền màu trắng */
            color: black; /* Màu chữ (tùy chọn) */
            padding: 10px 15px; 
            font-size: 16px; /* Kích thước chữ (tùy chọn) */
            cursor: pointer; 
            width: 100%;
            height: 45px;
        }

        .dropdown-menu li a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-menu button:hover {
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

        /* Main Content */
        .main-container {
            max-width: 1200px;
            margin: 100px auto;
            display: flex;
            gap: 2rem;
            padding: 0 1rem;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .user-profile {
            text-align: center;
            margin-bottom: 2rem;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 1rem;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .avatar i {
            font-size: 3rem;
            color: #999;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--text-color);
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: #f0f0f0;
        }

        /* Main Content Area */
        .content {
            flex: 1;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        /* Booking History Styles */
        .booking-card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .airline-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .airline-logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .flight-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .flight-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            display: grid;
            grid-template-columns: auto 1fr auto auto;
            align-items: center;
            gap: 20px;
            border: 1px dashed var(--primary-color);
            margin-bottom: 1rem;
        }

        .airline-logo {
            width: 24px;
            height: 24px;
            display: inline-block;
            background-image: url('img/vietnam-airline-logo.jpg');
            background-size: cover;
            background-position: center;
        }


        .airline-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .airline-name {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .airline-name img {
            width: 24px;
            height: 24px;
        }

        .seats-left {
            font-size: 0.875rem;
            color: #666;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .flight-times {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .time-group {
            text-align: center;
        }

        .time {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .airport {
            color: #666;
            font-size: 0.875rem;
        }

        .duration {
            text-align: center;
            color: #666;
            font-size: 0.875rem;
            position: relative;
            padding: 0 30px;
        }

        .duration::before,
        .duration::after {
            content: '';
            position: absolute;
            height: 1px;
            background: var(--border-color);
            width: 30px;
            top: 50%;
        }

        .duration::before {
            left: 0;
        }

        .duration::after {
            right: 0;
        }

        .price {
            text-align: right;
        }

        .amount {
            color: #ff4d4d;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .per-person {
            color: #666;
            font-size: 0.875rem;
        }

        .select-button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.2s;
        }

        .select-button:hover {
            background: var(--secondary-color);
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
            background: var (--secondary-color);
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
            <img src="img/Logo.png" alt="JO4 Travel" class="logo">
            <nav class="nav-menu">
                <a href="#">Trang chủ</a>
                <a href="#">Thông tin hành trình</a>
                <a href="#">Liên hệ</a>
                <!-- Dropdown Tài khoản -->
                <div class="dropdown" id="account-dropdown">
                    <a href="#" class="dropdown-toggle" id="user-account">Ngọc Minh</a>
                    <ul class="dropdown-menu" id="account-menu">
                        <li><a href="../TCN/TCN_Lichsu.php">Tài khoản</a></li>
                        <li><button id="logout-link" onclick="dangxuat()">Đăng xuất</button></li>
                    </ul>
                </div>

            </nav>
        </div>
    </header>

    <main class="main-container">
        <aside class="sidebar">
            <div class="user-profile">
                <div class="avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h2>Ngọc Minh</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="account.php" id="accountLink">Tài khoản</a></li>
                <li><a href="booking-history.php" id="historyLink">Lịch sử đặt vé</a></li>
                <li><a href="../TEST/index.php" id="dangxuat" onclick="dangxuat()">Đăng xuất</a></li>
            </ul>
        </aside>

        <div class="content" id="mainContent">
            <!-- Content will be loaded here -->
        </div>
    </main>
    <script>
        // Templates for different pages
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
            `,
            history: `
            <div id="historyContent">
                <div class="content-header">
                    <h1>Lịch sử đặt vé</h1>
                </div>
                <div id="flightCardsContainer">
                    <!-- ...existing code... -->
                </div>
            </div>
            `
        };
        // Gắn sự kiện cho "Đăng xuất"

        function dangxuat() {


            sessionStorage.removeItem("username");

            sessionStorage.removeItem("role");
            window.location.href = "../TEST/index.php";
        }


        // Function to load content
        function loadContent(page) {
            const mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = templates[page];

            // Update active state in sidebar
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.classList.remove('active');
            });
            document.getElementById(page + 'Link').classList.add('active');

            // Initialize tab functionality if on account page
            if (page === 'account') {
                initializeTabs();
            } else if (page === 'history') {
                BookingHistory();
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

        // Event listeners for navigation
        document.getElementById('accountLink').addEventListener('click', (e) => {
            e.preventDefault();
            loadContent('account');
        });

        document.getElementById('historyLink').addEventListener('click', (e) => {
            e.preventDefault();
            loadContent('history');
        });

        document.getElementById('logoutLink').addEventListener('click', (e) => {
            e.preventDefault();
            // Add logout logic here
            console.log('Logging out...');
        });

        // Load initial content
        loadContent('account');
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

        async function BookingHistory() {
            const serverIp = "localhost";
            const serverPort = 8000;
            let account_id = sessionStorage.getItem('account_id');
            let authToken = sessionStorage.getItem('auth_token');
            if (!authToken) {
                alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
                window.location.href = "../Sign In/index.php";
                return;
            }
            const url = `http://${serverIp}:${serverPort}/api/tickets/account/${account_id}`;



            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                }
            })
                .then(response => {
                    console.log(response);
                    if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    const container = document.getElementById('flightCardsContainer');
                    container.innerHTML = '';
                    data.forEach(ticket => {
                        const card = document.createElement('div');
                        card.className = 'flight-card';
                        card.innerHTML = `
                            <div class="airline-info">
                                <div class="airline-name">
                                    <span class="airline-logo"></span> ${ticket.airline_name}
                                </div>
                                <div class="seats-left">
                                   
                                </div>
                            </div>

                            <div class="flight-times">
                                <div class="time-group">
                                    <div class="time">${new Date(ticket.departure_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                                    <div class="airport">${ticket.departure_airport}</div>
                                </div>
                                <div class="duration">
                                    <div>${ticket.flight_time}</div>
                                    <div>Bay thẳng</div>
                                </div>
                                <div class="time-group">
                                    <div class="time">${new Date(ticket.departure_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                                    <div class="airport">${ticket.arrival_airport}</div>
                                </div>
                            </div>

                            <div class="price">
                                <div class="amount">${ticket.unit_price.toLocaleString()} VND</div>
                                <div class="per-person">/khách</div>
                            </div>
                        `;
                        container.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error('Error fetching booking history:', error);
                });
        }
    </script>
</body>

</html>