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
        loadAirports(); 
        loadPlanes();
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
                    <button class="btn btn-trunggian btn-sm" onclick="viewIntermediate(${flight.flight_id})">Xem Trung Gian</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

// Load airports
function loadAirports() {
    const url = `http://172.20.10.4:8000/api/airports`;
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
            const departureSelect = document.getElementById('departure_airport_id');
            const arrivalSelect = document.getElementById('arrival_airport_id');
            
            departureSelect.innerHTML = '<option value="">Chọn sân bay đi</option>';
            arrivalSelect.innerHTML = '<option value="">Chọn sân bay đến</option>';

            data.forEach(airport => {
                const option = `<option value="${airport.airport_id}">${airport.airport_name} - (${airport.address})</option>`;
                departureSelect.innerHTML += option;
                arrivalSelect.innerHTML += option;
            });
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu sân bay:', error);
            alert('Không thể tải danh sách sân bay. Vui lòng thử lại!');
        });
}

// Load planes
function loadPlanes() {
    const url = `http://172.20.10.4:8000/api/airplanes`;
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
            const planeSelect = document.getElementById('plane_id');
            planeSelect.innerHTML = '<option value="">Chọn máy bay</option>';
            data.forEach(plane => {
                planeSelect.innerHTML += `<option value="${plane.plane_id}">${plane.plane_name}</option>`;
            });
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu máy bay:', error);
            alert('Không thể tải danh sách máy bay. Vui lòng thử lại!');
        });
}

// Get system parameters
async function getSystemParameters() {
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
        console.log("System Parameters:", data);
        return data[0]; // Trả về tham số hệ thống đầu tiên
    } catch (error) {
        console.error("Lỗi khi lấy tham số hệ thống:", error);
        alert("Không thể tải tham số hệ thống. Vui lòng thử lại!");
        throw error;
    }
}
// Add flight

async function Insert(event) {
    event.preventDefault();

    try {
        const systemParameters = await getSystemParameters();
        const minFlightTime = systemParameters.min_flight_time;

        const formData = {
            plane_id: document.getElementById('plane_id').value.trim(),
            departure_airport_id: document.getElementById('departure_airport_id').value,
            arrival_airport_id: document.getElementById('arrival_airport_id').value,
            gate_id: document.getElementById('gate_id').value.trim(),
            flight_time: document.getElementById('flight_time').value.trim(),
            departure_date_time: document.getElementById('departure_date_time').value,
            unit_price: document.getElementById('unit_price').value.trim()
        };

        if (!formData.plane_id || !formData.departure_airport_id || !formData.arrival_airport_id) {
            alert("Vui lòng điền đầy đủ thông tin!");
            return;
        }
        if (formData.departure_airport_id === formData.arrival_airport_id) {
            alert("Sân bay đi và đến không được trùng nhau!");
            return;
        }
        if (formData.flight_time < minFlightTime) {
            alert(`Thời gian bay phải lớn hơn hoặc bằng ${minFlightTime}.`);
            return;
        }

        const response = await fetch('http://172.20.10.4:8000/api/flights', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) throw new Error("Failed to insert flight");

        alert("Thêm chuyến bay thành công!");
        clearForm();
        loadData(1);
    } catch (error) {
        console.error("Lỗi khi thêm chuyến bay:", error);
        alert("Không thể thêm chuyến bay. Vui lòng thử lại!");
    }
}
// Update flight
async function Update(event) {
    event.preventDefault();

    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        return;
    }

    const flightId = window.currentEditingflightId; // ID chuyến bay đang chỉnh sửa
    if (!flightId) {
        alert("Vui lòng chọn chuyến bay để sửa!");
        return;
    }

    try {
        const systemParameters = await getSystemParameters(); // Lấy tham số hệ thống
        const minFlightTime = systemParameters.min_flight_time;

        // Thu thập dữ liệu từ form
        const updatedData = {
            plane_id: document.getElementById('plane_id').value.trim(),
            departure_airport_id: document.getElementById('departure_airport_id').value,
            arrival_airport_id: document.getElementById('arrival_airport_id').value,
            gate_id: document.getElementById('gate_id').value.trim(),
            flight_time: document.getElementById('flight_time').value.trim(),
            departure_date_time: document.getElementById('departure_date_time').value,
            unit_price: document.getElementById('unit_price').value.trim()
        };

        // Kiểm tra dữ liệu đầu vào
        if (!updatedData.plane_id || !updatedData.departure_airport_id || !updatedData.arrival_airport_id) {
            alert("Vui lòng điền đầy đủ thông tin!");
            return;
        }
        if (updatedData.departure_airport_id === updatedData.arrival_airport_id) {
            alert("Sân bay đi và đến không được trùng nhau!");
            return;
        }
        if (updatedData.flight_time < minFlightTime) {
            alert(`Thời gian bay phải lớn hơn hoặc bằng ${minFlightTime}.`);
            return;
        }

        // Gửi yêu cầu cập nhật
        const response = await fetch(`http://172.20.10.4:8000/api/flights/${flightId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(updatedData)
        });

        if (!response.ok) throw new Error(`Failed to update flight: ${response.status}`);

        alert("Cập nhật chuyến bay thành công!");
        clearForm(); // Xóa dữ liệu trong form
        loadData(1); // Reload danh sách
    } catch (error) {
        console.error("Lỗi khi cập nhật chuyến bay:", error);
        alert("Không thể cập nhật chuyến bay. Vui lòng thử lại!");
    }
}


// Clear form fields
function clearForm() {
    document.getElementById('plane_id').value = '';
    document.getElementById('departure_airport_id').value = '';
    document.getElementById('arrival_airport_id').value = '';
    document.getElementById('gate_id').value = '';
    document.getElementById('flight_time').value = '';
    document.getElementById('departure_date_time').value = '';
    document.getElementById('unit_price').value = '';
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

function viewIntermediate(flightId) {
    // Lưu flightId vào localStorage
    localStorage.setItem('flightId', flightId);

    // Chuyển hướng đến trang TrungGian.php
    window.location.href = 'TrungGian.php';
}
// Thêm sự kiện khi thay đổi input tìm kiếm
document.getElementById('searchInput').addEventListener('input', () => {
    loadData(1); // Load lại từ trang đầu
});