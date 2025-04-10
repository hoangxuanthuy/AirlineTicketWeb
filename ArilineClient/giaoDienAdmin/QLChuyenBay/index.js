const menuBtn = document.querySelector('.menu-btn');
const sidebar = document.querySelector('.sidebar');

menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

let authToken = null;

// Kiểm tra trạng thái đăng nhập
const isLoggedIn = localStorage.getItem("isLoggedIn");

document.addEventListener('DOMContentLoaded', function () {
    authToken = localStorage.getItem('auth_token');
    const isLoggedIn = localStorage.getItem('isLoggedIn');

    if (!authToken || !isLoggedIn) {
        alert('Vui lòng đăng nhập trước!');
        window.location.href = "../login.php";
    } else {
        console.log('Token:', authToken); // Kiểm tra token được truyền vào
        loadData(1); // Gọi hàm loadData để lấy dữ liệu
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


function XemGhe(button) {
    const row = button.closest('tr');
    const fightID = row.cells[0].textContent; // Lấy mã khách hàng từ hàng
    // alert("")
    // Lưu planeID vào localStorage
    localStorage.setItem('fightID', fightID);

    // Chuyển hướng đến GheMayBay.html
    window.location.href = 'GheChuyenBay.html';
}

function XemTG(button) {
    const row = button.closest('tr');
    const fightID = row.cells[0].textContent; // Lấy mã khách hàng từ hàng
    // alert("")
    // Lưu planeID vào localStorage
    localStorage.setItem('fightID', fightID);

    // Chuyển hướng đến GheMayBay.html
    window.location.href = 'TrungGian.html';
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

    //load theo mã sân bay 
    const searchQuery = document.getElementById('searchInput').value || '';
    const url = `http://${serverIp}:${serverPort}/api/flights?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

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
    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const countUrl = `http://${serverIp}:${serverPort}/api/flights/count`;

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


function displayData(flights) {
    const tbody = document.querySelector('table.table tbody');
    tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

    if (!Array.isArray(flights) || flights.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
        return;
    }

    flights.forEach(flight => {
        const row = `
            <tr>
                <td>${flight.flight_id}</td>
                <td>${flight.departure_airport || 'Không xác định'}</td>
                <td>${flight.arrival_airport || 'Không xác định'}</td>
                <td>${flight.flight_time || 'Không xác định'}</td>
                <td>${flight.unit_price || 'Không xác định'}</td>
                <td>${flight.first_class_seats || 'Không xác định'}</td>
                <td>${flight.second_class_seats || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow(${flight.flight_id}, ${flight.plane_id}, '${flight.departure_airport_id}', '${flight.arrival_airport_id}', '${flight.gate_id}', '${flight.departure_date_time}', '${flight.flight_time}', ${flight.unit_price})">Sửa</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(${flight.flight_id})">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}
// Thêm Chuyến bay
function Insert(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của form

    // Thu thập dữ liệu từ form
    const formData = {
        plane_id: document.getElementById('plane_id').value.trim(),
        departure_airport_id: document.getElementById('departure_airport_id').value.trim(),
        arrival_airport_id: document.getElementById('arrival_airport_id').value.trim(),
        gate_id: document.getElementById('gate_id').value.trim(),
        flight_time: document.getElementById('flight_time').value.trim(),
        departure_date_time: document.getElementById('departure_date_time').value,
        unit_price: document.getElementById('unit_price').value.trim(),

    };


    // Gửi yêu cầu POST tới API
    fetch('http://172.20.10.4:8000/api/flights', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(formData)
    })
        .then(response => {
            console.log('HTTP Response Status:', response.status); // Log trạng thái HTTP
            if (!response.ok) throw new Error('Failed to insert flight');
            return response.json();
        })
        .then(data => {
            clearForm(); // Xóa sạch form sau khi thêm thành công
            loadData(1); // Tải lại danh sách Chuyến bay
            alert('Thêm Chuyến bay thành công!');
        })
        .catch(error => {
            console.error('Lỗi khi thêm Chuyến bay:', error);
            alert('Không thể thêm Chuyến bay. Vui lòng thử lại!');
        });
}
// Hàm xóa sạch form sau khi thêm Chuyến bay
function clearForm() {


    document.getElementById('plane_id').value = '';
    document.getElementById('departure_airport_id').value = '';
    document.getElementById('arrival_airport_id').value = '';
    document.getElementById('gate_id').value = '';
    document.getElementById('flight_time').value = '';
    document.getElementById('departure_date_time').value = '';
    document.getElementById('unit_price').value = '';
}
// Sửa Chuyến bay
function Update(event) {
    event.preventDefault();

    const flightId = window.currentEditingflightId; // ID Chuyến bay đang chỉnh sửa
    if (!flightId) {
        alert("Vui lòng chọn Chuyến bay để sửa!");
        return;
    }

    // Thu thập dữ liệu từ form
    const updatedData = {
        plane_id: document.getElementById('plane_id').value.trim(),
        departure_airport_id: document.getElementById('departure_airport_id').value.trim(),
        arrival_airport_id: document.getElementById('arrival_airport_id').value.trim(),
        gate_id: document.getElementById('gate_id').value.trim(),
        flight_time: document.getElementById('flight_time').value.trim(),
        departure_date_time: document.getElementById('departure_date_time').value,
        unit_price: document.getElementById('unit_price').value.trim(),
    };

    // Gửi request cập nhật
    fetch(`http://172.20.10.4:8000/api/flights/${flightId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(updatedData)
    })
        .then(response => {
            if (!response.ok) throw new Error(`Failed to update flight: ${response.status}`);
            return response.json();
        })
        .then(() => {
            alert('Cập nhật Chuyến bay thành công!');
            loadData(1); // Tải lại danh sách Chuyến bay
        })
        .catch(error => {
            console.error('Lỗi khi cập nhật Chuyến bay:', error);
            alert('Không thể cập nhật Chuyến bay. Vui lòng thử lại!');
        });
}

// Xóa chuyến bay
function deleteRow(flightId) {
    if (!confirm(`Bạn có chắc chắn muốn xóa Chuyến bay với ID ${flightId}?`)) {
        return;
    }

    fetch(`http://172.20.10.4:8000/api/flights/${flightId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error(`Lỗi khi xóa Chuyến bay: ${response.status}`);
            return response.json();
        })
        .then(() => {
            alert(`Xóa Chuyến bay với ID ${flightId} thành công!`);
            loadData(1); // Tải lại danh sách Chuyến bay
        })
        .catch(error => {
            console.error('Lỗi khi xóa Chuyến bay:', error);
            alert('Không thể xóa Chuyến bay. Vui lòng thử lại!');
        });
}



function editRow(flight_id, plane_id, departure_airport_id, arrival_airport_id, gate_id, departure_date_time, flight_time, unit_price) {
    // Điền thông tin từ hàng được chọn vào form
    document.getElementById('plane_id').value = plane_id || '';
    document.getElementById('departure_airport_id').value = departure_airport_id || '';
    document.getElementById('arrival_airport_id').value = arrival_airport_id || '';
    document.getElementById('gate_id').value = gate_id || '';
    document.getElementById('flight_time').value = flight_time || '';
    document.getElementById('unit_price').value = unit_price || '';

    // Kiểm tra định dạng và xử lý giá trị ngày giờ
    if (departure_date_time) {
        const formattedDateTime = departure_date_time.replace(' ', 'T'); // Chuyển định dạng thành yyyy-MM-ddTHH:mm
        document.getElementById('departure_date_time').value = formattedDateTime;
    } else {
        document.getElementById('departure_date_time').value = '';
    }

    // Lưu flight_id để phục vụ việc cập nhật
    window.currentEditingflightId = flight_id;
}
// Thêm sự kiện khi thay đổi input tìm kiếm
document.getElementById('searchInput').addEventListener('input', () => {
    loadData(1); // Load lại từ trang đầu
});