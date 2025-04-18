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
        justify-content: center;
        /* justify-content: space-between; */
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
        max-height: 50px;
    }

    .btn-return {
        margin-left: auto;
    }

    .btn-edit {
        background-color: #4facfe;
        color: white;
    }

    .btn-delete {
        background-color: #d9534f;
        color: white;
    }
    .head {
        display: flex;
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
                <li class="nav-item"><a href="../ThongKe/index.php" class="nav-link active">Thống kê</a></li>
                <li class="nav-item"><a href="../QLKhachHang/index.php" class="nav-link">Khách Hàng</a></li>
                <li class="nav-item"><a href="../QLChuyenBay/index.php" class="nav-link">Chuyến bay</a></li>
                <li class="nav-item"><a href="../QLVe/index.php" class="nav-link">Vé</a></li>
                <li class="nav-item"><a href="../QLMayBay/index.php" class="nav-link">Máy bay</a></li>
                <li class="nav-item"><a href="../QLHangBay/index.php" class="nav-link">Hãng bay</a></li>
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
            <div class="p-3 mb-4 head">
                <button class="menu-btn btn d-md-none me-3">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Thống kê</h2>
                </div>

                <button class="menu-btn btn d-md-none me-3">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Báo cáo năm</h2>
                </div>

                <button type="button" class="btn btn-custom btn-return"><a href="../ThongKe/index.php" class="nav-link">Quay lại</a></button>
            </div>

            <!-- Table -->
            <div class="table-responsive bg-white p-3 rounded shadow-sm mb-4">
                <div class="input-group">
                    <!-- <label for="">Tháng </label>
                    <label for="" id="month">12 </label> -->

                    <!-- <input type="text" class="search" placeholder="Tìm kiếm"> -->
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Số thứ tự</th>
                            <th>Tháng</th>
                            <th>Số chuyến bay</th>
                            <th>Doanh thu</th>
                            <th>Tỷ lệ</th>

                        </tr>
                    </thead>
                    <tbody>
        
                    </tbody>
                </table>

                <nav aria-label='Page navigation' class='flex-grow-1 d-flex justify-content-center'>
                    <ul class='pagination' style='margin: 0;'>
                      <!--pagination here-->
                    </ul>
                  </nav>
            </div>

            <!-- Form -->
            
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const authToken = localStorage.getItem('auth_token');
    const year = localStorage.getItem('year');
    console.log(year);
    if (!authToken || !year) {
        alert('Vui lòng đăng nhập và chọn năm!');
        window.location.href = "../login.php";
        return;
    }

    fetch(`http://172.20.10.4:8000/api/revenue/year?year=${year}`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Không thể tải dữ liệu báo cáo năm!');
            return response.json();
        })
        .then(data => {
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = '';

            if (!data || data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
                return;
            }

            data.forEach((row, index) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.month}</td>
                        <td>${row.number_of_flights}</td>
                        <td>${new Intl.NumberFormat('vi-VN').format(row.revenue)} VND</td>
                        <td>${(row.revenue_ratio * 100).toFixed(2)}%</td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error(error);
            alert('Lỗi khi tải dữ liệu báo cáo năm!');
        });
});

</script>

</html>