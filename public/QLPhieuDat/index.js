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
                <button class="btn btn-edit btn-sm" 
                onclick="cancelRow(${booking.booking_id}, '${booking.booking_issuance_date}', '${booking.status}')">
            Hủy
        </button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(${booking.booking_id})">Xóa</button>
                    <button class="btn btn-xemghe btn-sm" onclick="issuanceRow(${booking.booking_id},'${booking.status}')">Xuất vé</button>
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
async function getSystemParameter(parameterName) {
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

        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);

        const data = await response.json();
        console.log("System Parameters:", data);
        return data[0]; // Trả về tham số hệ thống đầu tiên
    } catch (error) {
        console.error("Lỗi khi lấy tham số hệ thống:", error);
        alert("Không thể tải tham số hệ thống. Vui lòng thử lại!");
        throw error;
    }
}
// Hàm hủy phiếu đặt
// Hàm hủy phiếu đặt
async function cancelRow(bookingId, bookingIssuanceDate, currentStatus) {
    try {
        // Kiểm tra trạng thái hiện tại của phiếu đặt
        if (currentStatus === "Canceled") {
            alert(`Phiếu đặt với ID ${bookingId} đã bị hủy trước đó.`);
            return;
        }

        // Lấy giá trị latest_cancellation_time từ tham số hệ thống
        const systemParameters = await getSystemParameter('latest_cancellation_time');
        const latestCancellationTime = parseFloat(systemParameters.latest_cancellation_time); // Chuyển đổi giá trị thành số (giờ)

        if (isNaN(latestCancellationTime)) {
            alert('Tham số hệ thống latest_cancellation_time không hợp lệ.');
            return;
        }

        // Tính toán thời gian hiện tại và thời gian phát hành vé
        const currentTime = new Date();
        const issuanceTime = new Date(bookingIssuanceDate);

        if (isNaN(issuanceTime.getTime())) {
            alert(`Ngày phát hành vé không hợp lệ: ${bookingIssuanceDate}`);
            return;
        }

        const elapsedTime = Math.abs(currentTime - issuanceTime) / (1000 * 60 * 60); // Tính số giờ trôi qua

        if (elapsedTime > latestCancellationTime) {
            alert(`Không thể hủy vé vì đã vượt quá thời gian hủy cho phép: ${latestCancellationTime} giờ.`);
            return;
        }

        // Xác nhận từ người dùng
        if (!confirm(`Bạn có chắc chắn muốn hủy phiếu đặt với ID ${bookingId}?`)) {
            return;
        }

        // Gọi API để hủy phiếu đặt
        const url = `http://172.20.10.4:8000/api/bookings/${bookingId}`;
        const response = await fetch(url, {
            method: 'PUT', // Phương thức cập nhật trạng thái
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify({ status: "Canceled" }) // Cập nhật trạng thái thành Canceled
        });

        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);

        alert(`Hủy phiếu đặt với ID ${bookingId} thành công!`);
        loadData(1); // Tải lại dữ liệu sau khi hủy
    } catch (error) {
        console.error('Lỗi khi hủy phiếu đặt:', error);
        alert('Không thể hủy phiếu đặt. Vui lòng thử lại!');
    }
}



// Hàm xuất vé
function issuanceRow(bookingId, status) {
    // Kiểm tra trạng thái phiếu đặt
    if (status === "Canceled") {
        alert(`Phiếu đặt với ID ${bookingId} đã bị hủy trước đó và không thể xuất vé.`);
        return;
    }

    if (status === "Confirmed") {
        alert(`Vé với ID ${bookingId} đã được xuất trước đó.`);
        return;
    }

    if (status === "Pending") {
        if (!confirm(`Bạn có chắc chắn muốn xuất vé cho phiếu đặt với ID ${bookingId}?`)) return;

        // Gọi API để cập nhật trạng thái thành Confirmed
        const url = `http://172.20.10.4:8000/api/exportbookings/${bookingId}`;

        fetch(url, {
            method: 'PUT', // Phương thức cập nhật trạng thái
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        })
            .then(response => {
                if (!response.ok) throw new Error('Lỗi khi cập nhật trạng thái phiếu đặt!');
                return response.json();
            })
            .then(() => {
                alert(`Xuất vé thành công! Trạng thái phiếu đặt đã được cập nhật thành Confirmed.`);
                loadData(1); // Tải lại dữ liệu sau khi cập nhật
            })
            .catch(error => {
                console.error('Lỗi khi xuất vé:', error);
                alert('Không thể xuất vé. Vui lòng thử lại!');
            });
    }
}


// Thêm sự kiện tìm kiếm
document.getElementById('searchInput').addEventListener('input', () => {
    loadData(1);
});

// Gọi loadData lần đầu tiên khi trang được tải
loadData();
