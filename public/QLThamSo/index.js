let authToken = null;

// Lấy token từ localStorage khi trang được tải
document.addEventListener('DOMContentLoaded', function () {
    authToken = localStorage.getItem('auth_token');
    const isLoggedIn = localStorage.getItem('isLoggedIn');

    if (!authToken || !isLoggedIn) {
        alert('Vui lòng đăng nhập trước!');
        window.location.href = "../login.php";
    } else {
        loadParameters(); // Gọi hàm để lấy dữ liệu từ API
    }
});

// Load parameters từ API
function loadParameters() {
    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const url = `http://${serverIp}:${serverPort}/api/parameters`;

    fetch(url, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
            return response.json();
        })
        .then(data => displayParameters(data))
        .catch(error => console.error('Lỗi:', error));
}

// Hiển thị tham số
function displayParameters(parameters) {
    const tbody = document.querySelector('table tbody');
    tbody.innerHTML = '';

    if (!parameters || parameters.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" class="text-center">Không có dữ liệu</td></tr>';
        return;
    }

    // Hiển thị từng tham số với các giá trị
    parameters.forEach(parameter => {
        const row = `
            <tr>
                <td>Thời gian bay tối thiểu</td>
                <td>${parameter.min_flight_time || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow('min_flight_time', '${parameter.min_flight_time}')">Sửa</button>
                </td>
            </tr>
            <tr>
                <td>Số sân bay trung gian tối đa</td>
                <td>${parameter.max_intermediate_airport || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow('max_intermediate_airport', '${parameter.max_intermediate_airport}')">Sửa</button>
                </td>
            </tr>
            <tr>
                <td>Thời gian dừng tối thiểu</td>
                <td>${parameter.min_stopover_time || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow('min_stopover_time', '${parameter.min_stopover_time}')">Sửa</button>
                </td>
            </tr>
            <tr>
                <td>Thời gian dừng tối đa</td>
                <td>${parameter.max_stopover_time || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow('max_stopover_time', '${parameter.max_stopover_time}')">Sửa</button>
                </td>
            </tr>
            <tr>
                <td>Thời gian đặt vé chậm nhất</td>
                <td>${parameter.latest_booking_time || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow('latest_booking_time', '${parameter.latest_booking_time}')">Sửa</button>
                </td>
            </tr>
            <tr>
                <td>Thời gian hủy vé chậm nhất</td>
                <td>${parameter.latest_cancellation_time || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow('latest_cancellation_time', '${parameter.latest_cancellation_time}')">Sửa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

// Hàm sửa tham số
function editRow(parameterName, value) {
    document.getElementById('parameter').value = parameterName;
    document.getElementById('value').value = value;
}

// Hàm cập nhật tham số
function updateParameter() {
    const parameterName = document.getElementById('parameter').value.trim();
    const value = document.getElementById('value').value.trim();

    if (!parameterName || !value) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }

    const data = {
        [parameterName]: value // Dữ liệu để cập nhật
    };

    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const url = `http://${serverIp}:${serverPort}/api/parameters`;

    fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) throw new Error('Cập nhật tham số thất bại!');
            return response.json();
        })
        .then(() => {
            alert('Cập nhật tham số thành công!');
            loadParameters();
        })
        .catch(error => console.error('Lỗi:', error));
}
