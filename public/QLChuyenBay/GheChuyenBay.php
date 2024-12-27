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
                    <li class="nav-item"><a href="../ThongKe/index.php" class="nav-link">Thống kê</a></li>
                    <li class="nav-item"><a href="../QLKhachHang/index.php" class="nav-link">Khách Hàng</a></li>
                    <li class="nav-item"><a href="../QLChuyenBay/index.php" class="nav-link active">Chuyến bay</a></li>
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
                        </button>
                    </li>
                </ul>
            </nav>

            <!-- Content -->
            <main class="col-md-9 col-lg-10 px-md-4">
                <div class="p-3 mb-4 head">
                    <button class="menu-btn btn d-md-none me-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Chuyến bay</h2>
                    </div>

                    <button class="menu-btn btn d-md-none me-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Ghế ngồi</h2>
                    </div>

                    <button type="button" class="btn btn-custom btn-return"><a href="../QLChuyenBay/index.php"
                            class="nav-link">Quay lại</a></button>
                </div>

                <!-- Table -->
                <div class="table-responsive bg-white p-3 rounded shadow-sm mb-4">
                    <div class="input-group">
                        <input type="text" class="search" id="searchInput" placeholder="Tìm kiếm">
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã ghế</th>
                                <th>Mã Chuyến bay</th>
                                <th>Tình trạng</th>
                                <!-- <th>Chức năng</th> -->

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>GH001</td>
                                <td>CB001</td>
                                <td>Còn trống</td>
                                <!-- <td>
                                <button class="btn btn-edit btn-sm"  onclick="updateRow(this)">Sửa</button>
                                <button class="btn btn-delete btn-sm" onclick="deleteRow(this)">Xóa</button>
                            </td> -->
                            </tr>
                        </tbody>
                    </table>

                    <nav aria-label='Page navigation' class='flex-grow-1 d-flex justify-content-center'>
                        <ul class='pagination' style='margin: 0;'>
                            <!--pagination here-->
                        </ul>
                    </nav>
                </div>

                <!-- Form -->
                <div class="bg-white p-4 rounded shadow-sm">
                    <form>
                        <div class="row g-3">
                            <!-- <div class="col-md-6">
                            <label for="gender" class="form-label">Hạng ghế:</label>
                            <select class="form-select" id="gender">
                                <option value="" disabled selected>Chọn</option>
                                
                            </select>
                        </div> -->
                            <div class="col-md-6">
                                <label for="seat1" class="form-label">Chuyến bay:</label>
                                <br>
                                <!-- <input type="number" id="seat1" class="form-control"> -->
                                <label for="seat1" class="form-label" id="planeLabel">MB001</label>
                            </div>
                        </div>
                        <!-- <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-custom" onclick="Insert(event)">Thêm</button>
                        <button type="button" class="btn btn-custom" onclick="Update(event)">Sửa</button>
                    </div> -->
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

let authToken = null;

        const menuBtn = document.querySelector('.menu-btn');
        const sidebar = document.querySelector('.sidebar');

        // Lấy giá trị từ localStorage
        const fightID = localStorage.getItem('fightID');

        // Gán giá trị lấy được vào nội dung của label
        if (fightID) {
            document.getElementById('planeLabel').textContent = fightID;
        }

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        document.addEventListener('DOMContentLoaded', function () {
            authToken = localStorage.getItem('auth_token');
            const isLoggedIn = localStorage.getItem('isLoggedIn');

            if (!authToken || !isLoggedIn) {
                alert('Vui lòng đăng nhập trước!');
                window.location.href = "../login.php";
            } else {
                console.log('Token:', authToken); // Kiểm tra token được truyền vào
                loadCustomers(1); // Gọi hàm loadCustomers để lấy dữ liệu
            }

        });

        function logout() {
            const confirmation = window.confirm("Bạn có chắc chắn muốn đăng xuất?");
            if (confirmation) {
                localStorage.removeItem("isLoggedIn");
                localStorage.removeItem("auth_token");
                window.location.href = "../login.php";
            }
        }

        function loadData(currentPage = 1) {
        if (!authToken) {
            alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
            window.location.href = "../login.php";
            return;
        }

        const serverIp = "192.168.60.5";
        const serverPort = "8000";
        const limit = 5;
        const offset = (currentPage - 1) * limit;

        //load theo mã sân bay 
        const searchQuery = document.getElementById('flight_id ').value || '';
        // let countryFilter = document.getElementById('countryInput').value || '';
        // if (countryFilter === 'chon') {
        //     countryFilter = '';
        // }
        const url = `http://${serverIp}:${serverPort}/api/seatflights?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        })
            .then(response => {
                console.log('HTTP Response Status:', response.status);
                if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
                return response.json();
            })
            .then(data => {
                displayData(data);

                // Cập nhật phân trang
                if (data.length < limit && currentPage === 1) {
                    updatePagination(data.length, currentPage, limit);
                } else {
                    fetchTotalCount(currentPage, limit);
                }
            })
            .catch(error => {
                console.error('Lỗi khi tải dữ liệu Chuyến bay:', error);
                alert('Không thể tải dữ liệu Chuyến bay. Vui lòng thử lại!');
            });
    }
    // Hàm lấy tổng số dòng từ API riêng
    function fetchTotalCount(currentPage, limit) {
        const serverIp = "192.168.60.5";
        const serverPort = "8000";
        const countUrl = `http://${serverIp}:${serverPort}/api/seatflights/count`;

        fetch(countUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const totalCount = data.totalCount; // Lấy giá trị totalCount
                updatePagination(totalCount, currentPage, limit);
            })
            .catch(error => {
                console.error('Lỗi khi lấy tổng số Chuyến bay:', error);
            });
    }

    function updatePagination(totalCount, currentPage, limit) {
        const pagination = document.querySelector('.pagination');
        pagination.innerHTML = ''; // Xóa nội dung phân trang cũ
        const totalPages = Math.ceil(totalCount / limit);
        console.log('Total Pages:', totalPages); // Kiểm tra tổng số trang

        // Nút "Trang đầu"
        pagination.innerHTML += `
    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="loadData(1)">Đầu</a>
    </li>
`;

        // Nút "Trang trước"
        pagination.innerHTML += `
    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="loadData(${currentPage - 1})">Trước</a>
    </li>
`;

        // Các trang
        for (let page = 1; page <= totalPages; page++) {
            pagination.innerHTML += `
        <li class="page-item ${currentPage === page ? 'active' : ''}">
            <a class="page-link" href="#" onclick="loadData(${page})">${page}</a>
        </li>
    `;
        }

        // Nút "Trang tiếp theo"
        pagination.innerHTML += `
    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="loadData(${currentPage + 1})">Sau</a>
    </li>
`;
        // Nút "Trang cuối"
        pagination.innerHTML += `
    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="loadData(${totalPages})">Cuối</a>
    </li>
`;
    }



    // Hiển thị danh sách Chuyến bay trong bảng
    function displayData(seatflights) {
        const tbody = document.querySelector('table.table tbody');
        tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

        if (!Array.isArray(seatflights) || seatflights.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
            return;
        }

        seatflights.forEach(seatflight => {
            const row = `
        
        <tr>
            <td>${seatflight.seat_id }</td>
            <td>${seatflight.flight_id || 'Không xác định'}</td>
            <td>${seatflight.status || 'Không xác định'}</td>
            <td>
            </td>
        </tr>
    `;
            tbody.innerHTML += row;
        });
    }
    </script>

</body>

</html>