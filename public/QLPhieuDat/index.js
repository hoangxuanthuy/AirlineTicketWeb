// Quản lý menu sidebar
const menuBtn = document.querySelector('.menu-btn');
const sidebar = document.querySelector('.sidebar');

menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

// Kiểm tra trạng thái đăng nhập
const isLoggedIn = localStorage.getItem("isLoggedIn");
const authToken = localStorage.getItem("auth_token");

if (!isLoggedIn || !authToken) {
    alert("Vui lòng đăng nhập trước!");
    window.location.href = "login.php";
}

// Đăng xuất
function logout() {
    const confirmation = window.confirm("Bạn có chắc chắn muốn đăng xuất?");
    if (confirmation) {
        localStorage.removeItem("isLoggedIn");
        localStorage.removeItem("auth_token");
        window.location.href = "../login.php";
    }
}

// Hàm tải dữ liệu booking
function loadData(currentPage = 1) {
    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const limit = 5;
    const offset = (currentPage - 1) * limit;
    const searchQuery = document.getElementById('searchInput').value || '';

    const url = `http://${serverIp}:${serverPort}/api/bookings?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

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
    
                // Cập nhật phân trang
                if (data.length < limit && currentPage === 1) {
                    updatePagination(data.length, currentPage, limit);
                } else {
                    fetchTotalCount(currentPage, limit);
                }
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu phiếu đặt:', error);
            alert('Không thể tải dữ liệu phiếu đặt. Vui lòng thử lại!');
        });
}

// Hàm lấy tổng số dòng từ API
function fetchTotalCount(currentPage, limit) {
    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const countUrl = `http://${serverIp}:${serverPort}/api/bookings/count`;

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
            console.error('Lỗi khi lấy tổng số phiếu đặt:', error);
        });
}

// Hàm cập nhật phân trang
function updatePagination(totalCount, currentPage, limit) {
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = '';
    const totalPages = Math.ceil(totalCount / limit);

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

// Hiển thị danh sách phiếu đặt trong bảng
function displayData(bookings) {
    const tbody = document.querySelector('table.table tbody');
    tbody.innerHTML = '';

    if (!Array.isArray(bookings) || bookings.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-center">Không có dữ liệu</td></tr>';
        return;
    }

    bookings.forEach(booking => {
        const row = `
            <tr>
                <td>${booking.booking_id}</td>
                <td>${booking.seat_id || 'Không xác định'}</td>
                <td>${booking.promotion_id || 'Không xác định'}</td>
                <td>${booking.client_id || 'Không xác định'}</td>
                <td>${booking.luggage_id || 'Không xác định'}</td>
                <td>${booking.flight_id || 'Không xác định'}</td>
                <td>${booking.booking_issuance_date || 'Không xác định'}</td>
                <td>${booking.status || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="cancelRow(${booking.booking_id},'${booking.status}')">Hủy</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(${booking.booking_id})">Xóa</button>
                    <button class="btn btn-xemghe btn-sm" onclick="issuanceRow(${booking.booking_id})">Xuất vé</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

// Hàm xóa phiếu đặt
function deleteRow(bookingId) {
    if (!confirm(`Bạn có chắc chắn muốn xóa phiếu đặt với ID ${bookingId}?`)) return;

    const url = `http://172.20.10.4:8000/api/bookings/${bookingId}`;

    fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Lỗi khi xóa phiếu đặt!');
            alert('Xóa phiếu đặt thành công!');
            loadData(1);
        })
        .catch(error => {
            console.error('Lỗi khi xóa phiếu đặt:', error);
        });
}

// Hàm hủy phiếu đặt
function cancelRow(bookingId, status) {
    console.log(status);
    // Kiểm tra trạng thái phiếu đặt
    if (status === "Canceled") {
        alert(`Phiếu đặt với ID ${bookingId} đã bị hủy trước đó.`);
        return;
    }

    // Xác nhận từ người dùng trước khi thực hiện hủy
    if (!confirm(`Bạn có chắc chắn muốn hủy phiếu đặt với ID ${bookingId}?`)) {
        return;
    }

    // Gọi API để hủy phiếu đặt
    const url = `http://172.20.10.4:8000/api/bookings/${bookingId}`;

    fetch(url, {
        method: 'PUT', // Phương thức cập nhật trạng thái
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
            alert(`Hủy phiếu đặt với ID ${bookingId} thành công!`);
            loadData(1); // Tải lại dữ liệu sau khi hủy
        })
        .catch(error => {
            console.error('Lỗi khi hủy phiếu đặt:', error);
            alert('Không thể hủy phiếu đặt. Vui lòng thử lại!');
        });
}


// Hàm xuất vé
function issuanceRow(bookingId) {
    if (!confirm(`Bạn có chắc chắn muốn xuất vé cho phiếu đặt với ID ${bookingId}?`)) return;

    const url = `http://172.20.10.4:8000/api/bookings/issuance/${bookingId}`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Lỗi khi xuất vé!');
            alert('Xuất vé thành công!');
            loadData(1);
        })
        .catch(error => {
            console.error('Lỗi khi xuất vé:', error);
        });
}

// Thêm sự kiện tìm kiếm
document.getElementById('searchInput').addEventListener('input', () => {
    loadData(1);
});

// Gọi loadData lần đầu tiên khi trang được tải
loadData();
