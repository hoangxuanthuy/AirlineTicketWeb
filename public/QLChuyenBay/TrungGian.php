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
                        <h2 class="mb-0">Trung gian</h2>
                    </div>

                    <button type="button" class="btn btn-custom btn-return"><a href="../QLChuyenBay/index.php"
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
                                <th>Mã sân bay trung gian</th>
                                <th>Mã Chuyến bay</th>
                                <th>Thời gian dừng</th>
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
                    <form id="intermediateForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="intermediate_airport_id" class="form-label">Mã Sân Bay Trung Gian:</label>
                                <input type="text" id="intermediate_airport_id" class="form-control" placeholder="VD: 1">
                            </div>
                            <div class="col-md-6">
                                <label for="stopover_time" class="form-label">Thời Gian Dừng (HH:MM):</label>
                                <input type="text" id="stopover_time" class="form-control" placeholder="Từ 00:30:00 đến 02:00:00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mã Chuyến Bay:</label>
                                <label id="flight_id" class="form-label">CB001</label>
                            </div>
                        </div>
                        <button type="button" class="btn btn-custom" onclick="Insert(event)">Thêm</button>
                        <button type="button" class="btn btn-custom" onclick="Update(event)">Sửa</button>

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
const flightId = localStorage.getItem('flightId');




menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('flight_id').textContent = flightId;
    authToken = localStorage.getItem('auth_token');
    const isLoggedIn = localStorage.getItem('isLoggedIn');

    if (!authToken || !isLoggedIn) {
        alert('Vui lòng đăng nhập trước!');
        window.location.href = "../login.php";
    } else {
        loadData(1); // Tải dữ liệu khi trang được load
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

async function fetchSystemParameters() {
    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const url = `http://${serverIp}:${serverPort}/api/parameters`;

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        });
        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
        const data = await response.json();
        return data[0];
    } catch (error) {
        console.error('Lỗi khi lấy tham số hệ thống:', error);
        alert('Không thể tải tham số hệ thống. Vui lòng thử lại!');
        throw error;
    }
}

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

    const flightId = localStorage.getItem('flightId');
    if (!flightId) {
        alert("Không tìm thấy mã chuyến bay. Vui lòng chọn chuyến bay trước!");
        return;
    }

    const url = `http://${serverIp}:${serverPort}/api/intermediates?flight_id=${flightId}&limit=${limit}&offset=${offset}`;

    fetch(url, {
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
            displayData(data);
            fetchTotalCount(flightId, currentPage, limit);
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu sân bay trung gian:', error);
            alert('Không thể tải dữ liệu. Vui lòng thử lại!');
        });
}

function fetchTotalCount(flightId, currentPage, limit) {
    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const countUrl = `http://${serverIp}:${serverPort}/api/intermediates/count?flight_id=${flightId}`;

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
            updatePagination(data.totalCount, currentPage, limit);
        })
        .catch(error => {
            console.error('Lỗi khi lấy tổng số sân bay trung gian:', error);
        });
}

function displayData(intermediates) {
    const tbody = document.querySelector('table.table tbody');
    tbody.innerHTML = '';

    if (!Array.isArray(intermediates) || intermediates.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>';
        return;
    }

    intermediates.forEach(intermediate => {
        const row = `
            <tr>
                <td>${intermediate.intermediate_airport_id || 'Không xác định'}</td>
                <td>${intermediate.flight_id || 'Không xác định'}</td>
                <td>${intermediate.stopover_time || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow(this, ${intermediate.intermediate_airport_id})">Sửa</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(${intermediate.intermediate_airport_id})">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function updatePagination(totalCount, currentPage, limit) {
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = '';
    const totalPages = Math.ceil(totalCount / limit);

    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadData(1)">Đầu</a>
        </li>
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadData(${currentPage - 1})">Trước</a>
        </li>
    `;

    for (let page = 1; page <= totalPages; page++) {
        pagination.innerHTML += `
            <li class="page-item ${currentPage === page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadData(${page})">${page}</a>
            </li>
        `;
    }

    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadData(${currentPage + 1})">Sau</a>
        </li>
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadData(${totalPages})">Cuối</a>
        </li>
    `;
}

function clearForm() {
    document.getElementById('intermediate_airport_id').value = '';
    document.getElementById('stopover_time').value = '';
}

function editRow(button, intermediateId) {
    const row = button.closest('tr');
    const intermediate_airport_id = row.cells[0].textContent.trim();
    const stopover_time = row.cells[2].textContent.trim();

    document.getElementById('intermediate_airport_id').value = intermediate_airport_id;
    document.getElementById('stopover_time').value = stopover_time;
    window.currentEditingintermediateId = intermediateId;
}

async function deleteRow(intermediateId) {
    if (!confirm(`Bạn có chắc chắn muốn xóa sân bay trung gian với ID ${intermediateId}?`)) {
        return;
    }

    const flightId = localStorage.getItem('flightId');
    const serverIp = "172.20.10.4";
    const serverPort = "8000";

    fetch(`http://${serverIp}:${serverPort}/api/intermediates/${flightId}/${intermediateId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
            return response.json();
        })
        .then(() => {
            alert(`Xóa sân bay trung gian với ID ${intermediateId} thành công!`);
            loadData(1);
        })
        .catch(error => {
            console.error('Lỗi khi xóa sân bay trung gian:', error);
            alert('Không thể xóa sân bay trung gian. Vui lòng thử lại!');
        });
}

async function Insert(event) {
    event.preventDefault();

    const parameters = await fetchSystemParameters();
    const formData = {
        flight_id: document.getElementById('flight_id').textContent.trim(),
        intermediate_airport_id: document.getElementById('intermediate_airport_id').value.trim(),
        stopover_time: document.getElementById('stopover_time').value.trim()
    };

    if (formData.stopover_time < parameters.min_stopover_time || formData.stopover_time > parameters.max_stopover_time) {
        alert(`Thời gian dừng phải trong khoảng từ ${parameters.min_stopover_time} đến ${parameters.max_stopover_time}`);
        return;
    }

    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const countUrl = `http://${serverIp}:${serverPort}/api/intermediates/count?flight_id=${formData.flight_id}`;
    const countResponse = await fetch(countUrl, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    });
    const countData = await countResponse.json();
    if (countData.totalCount >= parameters.max_intermediate_airport) {
        alert(`Số lượng sân bay trung gian tối đa cho chuyến bay này là ${parameters.max_intermediate_airport}.`);
        return;
    }

    fetch(`http://${serverIp}:${serverPort}/api/intermediates`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(formData)
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to insert intermediate');
            return response.json();
        })
        .then(() => {
            alert('Thêm sân bay trung gian thành công!');
            clearForm();
            loadData(1);
        })
        .catch(error => {
            console.error('Lỗi khi thêm sân bay trung gian:', error);
            alert('Không thể thêm sân bay trung gian. Vui lòng thử lại!');
        });
}

async function Update(event) {
    event.preventDefault();
    const parameters = await fetchSystemParameters();

    const intermediateId = window.currentEditingintermediateId;
    if (!intermediateId) {
        alert("Vui lòng chọn sân bay trung gian để sửa!");
        return;
    }

    const updatedData = {
        stopover_time: document.getElementById('stopover_time').value.trim()
    };

    if (updatedData.stopover_time < parameters.min_stopover_time || updatedData.stopover_time > parameters.max_stopover_time) {
        alert(`Thời gian dừng phải trong khoảng từ ${parameters.min_stopover_time} đến ${parameters.max_stopover_time}`);
        return;
    }

    const flightId = document.getElementById('flight_id').textContent.trim();
    const serverIp = "172.20.10.4";
    const serverPort = "8000";

    fetch(`http://${serverIp}:${serverPort}/api/intermediates/${flightId}/${intermediateId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(updatedData)
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to update intermediate');
            return response.json();
        })
        .then(() => {
            alert('Cập nhật sân bay trung gian thành công!');
            loadData(1);
        })
        .catch(error => {
            console.error('Lỗi khi cập nhật sân bay trung gian:', error);
            alert('Không thể cập nhật sân bay trung gian. Vui lòng thử lại!');
        });
}

    </script>

</body>

</html>