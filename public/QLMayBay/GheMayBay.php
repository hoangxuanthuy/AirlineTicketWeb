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
                    <li class="nav-item"><a href="../QLChuyenBay/index.php" class="nav-link">Chuyến bay</a></li>
                    <li class="nav-item"><a href="../QLVe/index.php" class="nav-link">Vé</a></li>
                    <li class="nav-item"><a href="../QLMayBay/index.php" class="nav-link active">Máy bay</a></li>
                    
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
                        <h2 class="mb-0">Máy bay</h2>
                    </div>

                    <button class="menu-btn btn d-md-none me-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Ghế ngồi</h2>
                    </div>

                    <button type="button" class="btn btn-custom btn-return"><a href="../QLMayBay/index.php"
                            class="nav-link">Quay lại</a></button>
                </div>

                <!-- Table -->
                <div class="table-responsive bg-white p-3 rounded shadow-sm mb-4">
                    <div class="input-group">
                        <input type="text" class="search" id="searchInput" placeholder="Tìm kiếm" oninput="loadData(1)">
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã ghế</th>
                                <th>Mã hạng ghế</th>
                                <th>Mã máy bay</th>
                                <th>Chức năng</th>

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
                <div class="bg-white p-4 rounded shadow-sm">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Hạng ghế:</label>
                                <!-- <select class="form-select" id="gender">
                                    <option value="" disabled selected>Chọn</option>
                                    
                                </select> -->
                                <input type="number" id="seat_class_id" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="seat1" class="form-label">Máy bay:</label>
                                <br>
                                <label for="seat1" class="form-label" id="plane_id">MB001</label>
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
    <script>

        let authToken = null;

        const menuBtn = document.querySelector('.menu-btn');
        const sidebar = document.querySelector('.sidebar');



        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        let currentEditingseatId = null; // Biến toàn cục để lưu ID ghế đang chỉnh sửa
        let planeID=null
document.addEventListener('DOMContentLoaded', function () {
    authToken = localStorage.getItem('auth_token');
    const isLoggedIn = localStorage.getItem('isLoggedIn');
     planeID = localStorage.getItem('planeID');

    if (!planeID) {
        alert('Không tìm thấy ID Máy bay!');
        window.location.href = '../QLMayBay/index.php';
    }

    if (!authToken || !isLoggedIn) {
        alert('Vui lòng đăng nhập trước!');
        window.location.href = "../login.php";
    } else {
        console.log('Token:', authToken);
        document.getElementById('plane_id').textContent = planeID;
        loadData(1); // Tải danh sách ghế
    }
});

        // Đăng xuất
        function logout() {
            const confirmation = window.confirm("Bạn có chắc chắn muốn đăng xuất?");
            if (confirmation) {
                localStorage.removeItem("isLoggedIn");
                localStorage.removeItem("auth_token");
                window.location.href = "../login.php";
            }
        }

        // Load seats
        function loadData(currentPage = 1) {
            if (!authToken) {
                alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
                window.location.href = "../login.php";
                return;
            }

            const serverIp = "172.20.10.4";
            const serverPort = "8000";
            const limit = 5;
            const offset = (currentPage - 1) * limit;

            const searchQuery = planeID;
            const url = `http://${serverIp}:${serverPort}/api/seats?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

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
                    console.error('Lỗi khi tải dữ liệu Ghế máy bay:', error);
                    alert('Không thể tải dữ liệu Ghế máy bay. Vui lòng thử lại!');
                });
        }
        // Hàm lấy tổng số dòng từ API riêng
        function fetchTotalCount(currentPage, limit) {
            const serverIp = "172.20.10.4";
            const serverPort = "8000";
            const countUrl = `http://${serverIp}:${serverPort}/api/seats/count?search=${encodeURIComponent(planeID)}`;

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
                    console.error('Lỗi khi lấy tổng số Ghế máy bay:', error);
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



        // Hiển thị danh sách Ghế máy bay trong bảng
        function displayData(seats) {
    const tbody = document.querySelector('table.table tbody');
    tbody.innerHTML = '';

    if (!Array.isArray(seats) || seats.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>';
        return;
    }

    seats.forEach(seat => {
        const row = `
            <tr>
                <td>${seat.seat_id}</td>
                <td>${seat.seat_class_id || 'Không xác định'}</td>
                <td>${seat.plane_id || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow(this, ${seat.seat_id})">Sửa</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(${seat.seat_id})">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

        // Thêm Ghế máy bay
        function Insert(event) {
    event.preventDefault();
    const seat_class_id = document.getElementById('seat_class_id').value.trim();
    const plane_id = document.getElementById('plane_id').textContent.trim();

    fetch('http://172.20.10.4:8000/api/seats', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify({ seat_class_id, plane_id })
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to insert seat');
            return response.json();
        })
        .then(() => {
            alert('Thêm Ghế máy bay thành công!');
            clearForm();
            loadData(1);
        })
        .catch(error => {
            console.error('Lỗi khi thêm Ghế máy bay:', error);
        });
}


        function clearForm() {

            document.getElementById('seat_class_id').value = '';
        }


        

        function Update(event) {
            event.preventDefault();

    
            if (!currentEditingseatId) {
                alert("Vui lòng chọn Ghế máy bay để sửa!");
                return;
            }

            // Thu thập dữ liệu từ form
            const updatedData = {
                seat_class_id: document.getElementById('seat_class_id').value.trim(),
                plane_id: planeID,
            };

            // Gửi request cập nhật
            fetch(`http://172.20.10.4:8000/api/seats/${currentEditingseatId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify(updatedData)
            })
                .then(response => {
                    if (!response.ok) throw new Error(`Failed to update seat: ${response.status}`);
                    return response.json();
                })
                .then(() => {
                    alert('Cập nhật Ghế máy bay thành công!');
                    clearForm();
                    loadData(1); // Tải lại danh sách Ghế máy bay
                })
                .catch(error => {
                    console.error('Lỗi khi cập nhật Ghế máy bay:', error);
                    alert('Không thể cập nhật Ghế máy bay. Vui lòng thử lại!');
                });
        }

        function editRow(button, seatId) {
    const row = button.closest('tr');
    const seat_class_id = row.cells[1].textContent.trim();
    document.getElementById('seat_class_id').value = seat_class_id;
    currentEditingseatId = seatId;
}

// Hàm xóa
function deleteRow(seatId) {
    if (!confirm(`Bạn có chắc chắn muốn xóa ghế ID ${seatId}?`)) return;

    fetch(`http://172.20.10.4:8000/api/seats/${seatId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to delete seat');
            return response.json();
        })
        .then(() => {
            alert(`Xóa ghế ID ${seatId} thành công!`);
            loadData(1);
        })
        .catch(error => {
            console.error('Lỗi khi xóa ghế:', error);
        });
}


    </script>

</body>

</html>