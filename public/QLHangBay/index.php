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

    .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating) {
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;}

    .search{
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

    /* Hiển thị nút menu (hamburger) khi màn hình nhỏ */
@media (max-width: 768px) {
    .menu-btn {
        display: block; /* Hiển thị nút hamburger */
        position: fixed; /* Đặt ở góc */
        top: 20px;
        left: 20px;
        z-index: 1000; /* Đảm bảo icon ở trên cùng */
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
        transform: translateX(-150%); /* Đẩy sidebar ra khỏi màn hình */
    }
    .sidebar.active {
        display: block; 
        transform: translateX(0); /* Trượt sidebar vào màn hình */
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
                <!-- <li class="nav-item"><a href="ThongKe.html" class="nav-link">Thống kê</a></li>
                <li class="nav-item"><a href="QLKhachHang.html" class="nav-link">Khách Hàng</a></li>
                <li class="nav-item"><a href="QLChuyenBay.html" class="nav-link">Chuyến bay</a></li>
                <li class="nav-item"><a href="QLVe.html" class="nav-link">Vé</a></li>
                <li class="nav-item"><a href="QLMayBay.html" class="nav-link">Máy bay</a></li>
                <li class="nav-item"><a href="QLHangBay.html" class="nav-link active">Hãng bay</a></li>
                <li class="nav-item"><a href="QLHangGhe.html" class="nav-link">Hạng ghế</a></li>
                <li class="nav-item"><a href="QLSanBay.html" class="nav-link">Sân bay</a></li>
                <li class="nav-item"><a href="QLHanhLy.html" class="nav-link">Hành lý</a></li>
                <li class="nav-item"><a href="QLPhieuDat.html" class="nav-link">Phiếu đặt</a></li>
                <li class="nav-item"><a href="QLTaiKhoan.html" class="nav-link">Tài khoản</a></li>
                <li class="nav-item"><a href="QLThamSo.html" class="nav-link">Tham số</a></li>
                <li class="nav-item"><a href="QLKhuyenMai.html" class="nav-link">Khuyến mãi</a></li> -->

                <li class="nav-item"><a href="../ThongKe/index.php" class="nav-link">Thống kê</a></li>
                <li class="nav-item"><a href="../QLKhachHang/index.php" class="nav-link">Khách Hàng</a></li>
                <li class="nav-item"><a href="../QLChuyenBay/index.php" class="nav-link">Chuyến bay</a></li>
                <li class="nav-item"><a href="../QLVe/index.php" class="nav-link">Vé</a></li>
                <li class="nav-item"><a href="../QLMayBay/index.php" class="nav-link">Máy bay</a></li>
                <li class="nav-item"><a href="../QLHangBay/index.php" class="nav-link active">Hãng bay</a></li>
                <li class="nav-item"><a href="../QLHangGhe/index.php" class="nav-link">Hạng ghế</a></li>
                <li class="nav-item"><a href="../QLSanBay/index.php" class="nav-link">Sân bay</a></li>
                <li class="nav-item"><a href="../QLHanhLy/index.php" class="nav-link">Hành lý</a></li>
                <li class="nav-item"><a href="../QLPhieuDat/index.php" class="nav-link">Phiếu đặt</a></li>
                <li class="nav-item"><a href="../QLTaiKhoan/index.php" class="nav-link">Tài khoản</a></li>
                <li class="nav-item"><a href="../QLThamSo/index.php" class="nav-link">Tham số</a></li>
                <li class="nav-item"><a href="../QLKhuyenMai/index.php" class="nav-link">Khuyến mãi</a></li>
                <li class="nav-item">
                    <button onclick="logout()" class="nav-link" style="color: white;">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </button></li>
            </ul>
        </nav>

        <!-- Content -->
        <main class="col-md-9 col-lg-10 px-md-4">
            <div class="p-3 mb-4">
                <button class="menu-btn btn d-md-none me-3">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Hãng bay</h2>
                    
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive bg-white p-3 rounded shadow-sm mb-4">
                <div class="input-group">
                    <input type="text" class="search"  id="searchInput"  placeholder="Tìm kiếm">
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã hãng bay</th>
                            <th>Tên hãng bay</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>VN</td>
                            <td>VietNamAirlines</td>
                            <td>
                                <button class="btn btn-edit btn-sm">Sửa</button>
                                <button class="btn btn-delete btn-sm">Xóa</button>
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
                            <label for="airline" class="form-label">Hãng bay:</label>
                            <input type="text" id="airline" class="form-control">
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-custom">Thêm</button>
                        <button type="button" class="btn btn-custom">Sửa</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="index.js">
    
</script>
</body>
</html>