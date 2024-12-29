<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Management - Thống kê</title>
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

        .btn-primary {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(to right, #1A72B1, #24ADCD);
            color: white;
        }

        /* Responsive adjustments for mobile */
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
                margin-left: 50px;
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
                <li class="nav-item"><a href="../ThongKe/index.php" class="nav-link active">Thống kê</a></li>
                <li class="nav-item"><a href="../QLKhachHang/index.php" class="nav-link">Khách Hàng</a></li>
                <li class="nav-item"><a href="../QLChuyenBay/index.php" class="nav-link">Chuyến bay</a></li>
                <li class="nav-item"><a href="../QLVe/index.php" class="nav-link">Vé</a></li>
                <li class="nav-item"><a href="../QLMayBay/index.php" class="nav-link">Máy bay</a></li>
                
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
                    <h2 class="mb-0">Thống kê</h2>
                </div>
            </div>

            <!-- Form chọn tháng và năm -->
            <div class="bg-white p-4 rounded shadow-sm mb-4">
                <div class="row mb-3">
                    <!-- Chọn tháng -->
                    <div class="col-md-3">
                        <label for="month" class="form-label">Tháng</label>
                        <select class="form-select" id="month">
                            <option value="">Chọn tháng</option>
                            <option value="1">Tháng 1</option>
                            <option value="2">Tháng 2</option>
                            <option value="3">Tháng 3</option>
                            <option value="4">Tháng 4</option>
                            <option value="5">Tháng 5</option>
                            <option value="6">Tháng 6</option>
                            <option value="7">Tháng 7</option>
                            <option value="8">Tháng 8</option>
                            <option value="9">Tháng 9</option>
                            <option value="10">Tháng 10</option>
                            <option value="11">Tháng 11</option>
                            <option value="12">Tháng 12</option>
                        </select>
                    </div>
                    <!-- Chọn năm -->
                    <div class="col-md-3">
                        <label for="year" class="form-label">Năm</label>
                        <select class="form-select" id="year">
                            <option value="">Chọn năm</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                        </select>
                    </div>
                </div>

                <!-- Biểu đồ -->
                <div class="row">
                    <!-- Biểu đồ cột -->
                    <div class="col-md-6">
                        <div class="bg-light rounded p-4 mb-3">
                            <canvas id="statChart"></canvas>
                        </div>
                    </div>
                    <!-- Biểu đồ hình tròn -->
                    <div class="col-md-6">
                        <div class="bg-light rounded p-4 mb-3">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Nút xuất báo cáo và tổng doanh thu -->
                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" onclick="XuatbaoCao()">Xuất báo cáo</button>
                    <p class="mb-0"><b>Tổng doanh thu:</b> <span id="total-revenue">0</span> VND</p>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="index.js"></script>
</body>
</html>
