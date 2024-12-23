// Biến toàn cục để lưu token
let authToken = null;

// Lấy token từ localStorage khi trang được tải
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

// Toggle Sidebar
const menuBtn = document.querySelector('.menu-btn');
const sidebar = document.querySelector('.sidebar');
menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
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

// Load customers
function loadCustomers(currentPage = 1) {
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    const serverIp = "192.168.1.6";
    const serverPort = "8000";
    const limit = 5;
    const offset = (currentPage - 1) * limit;

    const searchQuery = document.getElementById('searchInput').value || '';
    const countryFilter = document.getElementById('countryInput').value || '';

    const url = `http://${serverIp}:${serverPort}/api/searchcus?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}&country=${encodeURIComponent(countryFilter)}`;

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
        .then(customers => {
            console.log('API Response:', customers); // Kiểm tra dữ liệu trả về
            if (Array.isArray(customers) && customers.length > 0) {
                displayCustomers(customers);
            } else {
                displayCustomers([]);
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu khách hàng:', error);
            alert('Không thể tải dữ liệu khách hàng. Vui lòng thử lại!');
        });z
}

// Hiển thị danh sách khách hàng trong bảng
function displayCustomers(customers) {
    const tbody = document.querySelector('table.table tbody');
    tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

    if (!Array.isArray(customers) || customers.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
        return;
    }

    customers.forEach(customer => {
        const row = `
            <tr>
                <td>${customer.client_id}</td>
                <td>${customer.client_name || 'Không xác định'}</td>
                <td>${customer.citizen_id || 'Không xác định'}</td>
                <td>${customer.phone || 'Không xác định'}</td>
                <td>${customer.gender || 'Không xác định'}</td>
                <td>${customer.birth_day ? new Date(customer.birth_day).toLocaleDateString('vi-VN') : 'Không xác định'}</td>
                <td>${customer.country || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow(this)">Sửa</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(this)">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}


