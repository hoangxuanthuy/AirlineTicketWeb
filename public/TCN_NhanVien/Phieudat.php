
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phieu Dat</title>
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

        .MAIN {
            margin-top: 100px;
        }

        .sidebar {
            background: linear-gradient(to bottom, #2c7da0, #00b4d8);
            color: white;
            border-radius: 10px;
            padding: 30px 15px;
            margin-top: 100px;

        }

        .sidebar .active {
            background-color: #0096c7;
            border-radius: 5px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        /* .header {
            padding: 10px 20px;
            margin-bottom: 20px;
            border-left: 5px solid #0096c7;
        } */

        .input-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 16px;

        }

        .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating) {
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .search {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 20px;
            width: 200px;
            outline: none;
        }

        table thead {
            background: linear-gradient(to right, #1A72B1, #24ADCD);
            color: white;
        }

        .btn-custom {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(to right, #1A72B1, #24ADCD);
            color: white;
        }

        .btn-edit {
            background-color: #4facfe;
            color: white;
        }

        .btn-delete {
            background-color: #d9534f;
            color: white;
        }

        .btn-xemghe {
            background-color: #d9ab4f;
            color: white;
        }

        /* Hiển thị nút menu (hamburger) khi màn hình nhỏ */
        @media (max-width: 768px) {
            .menu-btn {
                display: block;
                /* Hiển thị nút hamburger */
                position: fixed;
                /* Đặt ở góc */
                top: 20px;
                left: 20px;
                z-index: 1000;
                /* Đảm bảo icon ở trên cùng */
                background: none;
                border: none;
                color: #2c7da0;
                font-size: 24px;
                cursor: pointer;
                margin: 20px;
            }

            .header {
                padding: 10px 20px;
                margin-bottom: 20px;
                margin-left: 50px;
                border-left: 5px solid #0096c7;
            }

            /* .sidebar {
            display: none; 
            
        } */

            .sidebar {
                display: none;
                transform: translateX(-150%);
                /* Đẩy sidebar ra khỏi màn hình */
            }

            .sidebar.active {
                display: block;
                transform: translateX(0);
                /* Trượt sidebar vào màn hình */
            }

            /* .container-fluid{
            margin-top: 500px;
        }
     */

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
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar py-3">
                <div class="text-center mb-4">
                    <i class="fa-regular fa-user-circle fa-3x"></i>
                    <p class="mt-2">Welcome,<br><b>Admin</b></p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="Taikhoan.php" class="nav-link " id="accountLink">Tài Khoản</a>
                    </li>
                    <li class="nav-item"><a href="Xulytt.php" class="nav-link">Khách Hàng</a></li>
                    <li class="nav-item"><a href="Xulyve.php" class="nav-link">Vé</a></li>
                    <li class="nav-item"><a href="Phieudat.php" class="nav-link active">Phiếu đặt</a></li>
                    <li class="nav-item">
                        <button onclick="logout()" class="nav-link" style="color: white;">
                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                        </button>
                    </li>
                </ul>
            </nav>

            <!-- Content -->
            <main class="col-md-9 col-lg-10 px-md-4 MAIN ">


                <!-- Table -->
                <div class="table-responsive bg-white p-3 rounded shadow-sm mb-4">
                    <div class="input-group">
                        <input type="text" class="search" placeholder="Tìm kiếm">
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã phiếu đặt</th>
                                <th>Mã ghế ngồi</th>
                                <th>Mã khuyến mãi</th>
                                <th>Mã khách hàng</th>
                                <th>Mã hành lý</th>
                                <th>Mã chuyến bay</th>
                                <th>Ngày xuất vé</th>
                                <th>Tình trạng</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>V001</td>
                                <td>G123</td>
                                <td>KM2024</td>
                                <td>KH001</td>
                                <td>HL123</td>
                                <td>CB456</td>
                                <td>2024-11-15</td>
                                <td>Đã xuất vé</td>
                                <td>
                                    <button class="btn btn-delete btn-sm">Xóa</button>
                                    <button class="btn btn-edit btn-sm">Hủy</button>
                                    <button class="btn btn-xemghe btn-sm">Xuất vé</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Form -->
                <div class="bg-white p-4 rounded shadow-sm">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="flight" class="form-label">Chuyến bay:</label>
                                <input type="text" id="flight" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="client" class="form-label">Hành khách:</label>
                                <input type="text" id="client" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="cccd" class="form-label">CCCD:</label>
                                <input type="text" id="cccd" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Điện thoại:</label>
                                <input type="tel" id="phone" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="seat" class="form-label">Ghế ngồi:</label>
                                <input type="text" id="seat" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="seatClass" class="form-label">Hạng ghế:</label>
                                <input type="text" id="seatClass" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="luggage" class="form-label">Hành lý:</label>
                                <input type="text" id="luggage" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="promotion" class="form-label">Mã khuyến mãi:</label>
                                <input type="text" id="promotion" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="ticketDate" class="form-label">Ngày xuất vé:</label>
                                <input type="datetime-local" id="ticketDate" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Giá tiền:</label>
                                <input type="number" id="price" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-custom">Hủy vé</button>
                            <button type="submit" class="btn btn-custom">Xuất vé</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const menuBtn = document.querySelector('.menu-btn');
        const sidebar = document.querySelector('.sidebar');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

      // Gắn sự kiện cho "Đăng xuất"
   
        function dangxuat(){

   
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
                window.location.href = "../TEST/index.php";  // Chuyển về trang login
            } else {
                // Nếu người dùng chọn Cancel, không làm gì
                console.log("Đăng xuất đã bị hủy");
            }
        };
    
    </script>
</body>

</html>