<?php
// Lấy tên file hiện tại
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<style>
    body {
        background-color: #f4f6f8;
        min-height: 100vh;
        padding: 20px;
    }

    .sidebar {
        background: linear-gradient(to bottom, #2c7da0, #00b4d8);
        color: white;
        border-radius: 10px;
        padding: 30px 15px;
    }

    .sidebar .active {
        background-color: #0096c7;
        border-radius: 5px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
    }

    .header {
        padding: 10px 20px;
        margin-bottom: 20px;
        border-left: 5px solid #0096c7;
    }

    .input-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 16px;
    }

    .searchCombo {
        display: flex;
    }

    #countryInput {
        margin-bottom: 15px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 200px;
        outline: none;
    }

    .search {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 400px;
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

    @media (max-width: 768px) {
        .menu-btn {
            display: block;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
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

        .sidebar {
            display: none;
            transform: translateX(-150%);
        }

        .sidebar.active {
            display: block;
            transform: translateX(0);
        }
    }
</style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar py-3">
            <div class="text-center mb-4">
                <i class="fa-regular fa-user-circle fa-3x"></i>
                <p class="mt-2">Welcome,<br><b>Admin</b></p>
            </div>
            <ul class="nav flex-column">
    <li class="nav-item">
        <a href="../ThongKe/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'ThongKe') !== false ? 'active' : '' ?>">
            Thống kê
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLKhachHang/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLKhachHang') !== false ? 'active' : '' ?>">
            Khách Hàng
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLChuyenBay/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLChuyenBay') !== false ? 'active' : '' ?>">
            Chuyến bay
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLVe/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLVe') !== false ? 'active' : '' ?>">
            Vé
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLMayBay/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLMayBay') !== false ? 'active' : '' ?>">
            Máy bay
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLHangBay/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLHangBay') !== false ? 'active' : '' ?>">
            Hãng bay
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLHangGhe/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLHangGhe') !== false ? 'active' : '' ?>">
            Hạng ghế
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLSanBay/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLSanBay') !== false ? 'active' : '' ?>">
            Sân bay
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLHanhLy/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLHanhLy') !== false ? 'active' : '' ?>">
            Hành lý
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLPhieuDat/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLPhieuDat') !== false ? 'active' : '' ?>">
            Phiếu đặt
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLTaiKhoan/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLTaiKhoan') !== false ? 'active' : '' ?>">
            Tài khoản
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLThamSo/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLThamSo') !== false ? 'active' : '' ?>">
            Tham số
        </a>
    </li>
    <li class="nav-item">
        <a href="../QLKhuyenMai/index.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'QLKhuyenMai') !== false ? 'active' : '' ?>">
            Khuyến mãi
        </a>
    </li>
    <li class="nav-item">
        <button onclick="logout()" class="nav-link" style="color: white;">
            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
        </button>
    </li>
</ul>

        </nav>

        <!-- Content -->
        <main class="col-md-9 col-lg-10 px-md-4">
            <div class="p-3 mb-4">
                <button class="menu-btn btn d-md-none me-3">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Khách hàng</h2>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive bg-white p-3 rounded shadow-sm mb-4">
                <div class="searchCombo">
                    <div class="input-group">
                        <input type="text" class="search" id="searchInput" placeholder="Tìm kiếm" onchange="loadCustomers(1)">
                    </div>
                    
                    <select class="form-select" id="countryInput" onchange="loadCustomers(1)">
                        <option value="chon" disabled selected>Lọc quốc gia</option>
                    </select>
                </div>
        
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã khách hàng</th>
                            <th>Tên khách hàng</th>
                            <th>CCCD</th>
                            <th>SDT</th>
                            <th>Giới tính</th>
                            <th>Ngày sinh</th>
                            <th>Quốc gia</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu động sẽ được thêm tại đây -->
                    </tbody>
                </table>

                <nav aria-label='Page navigation' class='flex-grow-1 d-flex justify-content-center'>
                    <ul class='pagination' style='margin: 0;'></ul>
                </nav>
            </div>

            <!-- Form -->
            <div class="bg-white p-4 rounded shadow-sm">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên:</label>
                            <input type="text" id="name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="cccd" class="form-label">CCCD:</label>
                            <input type="text" id="cccd" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại:</label>
                            <input type="tel" id="phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="birth" class="form-label">Ngày sinh:</label>
                            <input type="date" id="birth" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Giới tính:</label>
                            <select class="form-select" id="gender">
                                <option value="" disabled selected>Chọn</option>
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="country" class="form-label">Quốc tịch:</label> 
                            <select class="form-select" id="country">
                                <option value="chon" disabled selected>Chọn</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-custom" onclick="Insert(event)">Thêm</button>
                        <button type="button" class="btn btn-custom" onclick="Update(event)">Sửa</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../QLKhachHang/index.js"></script>
</body>
</html>
