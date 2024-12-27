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
        loadSeatClasses(1); // Gọi hàm loadSeatClasses để lấy dữ liệu
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

// Load danh sách hạng ghế
function loadSeatClasses(currentPage = 1) {
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const limit = 5;
    const offset = (currentPage - 1) * limit;

    const searchQuery = document.getElementById('searchInput').value || '';
    const url = `http://${serverIp}:${serverPort}/api/seatclass?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

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
            displaySeatClasses(data);

            // Cập nhật phân trang
            if (data.length < limit && currentPage === 1) {
                updatePagination(data.length, currentPage, limit);
            } else {
                fetchTotalCount(currentPage, limit);
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu hạng ghế:', error);
            alert('Không thể tải dữ liệu hạng ghế. Vui lòng thử lại!');
        });
}

// Hàm lấy tổng số dòng từ API riêng
function fetchTotalCount(currentPage, limit) {
    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const countUrl = `http://${serverIp}:${serverPort}/api/seatclass/count`;

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
            console.error('Lỗi khi lấy tổng số hạng ghế:', error);
        });
}

function updatePagination(totalCount, currentPage, limit) {
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = ''; // Xóa nội dung phân trang cũ
    const totalPages = Math.ceil(totalCount / limit);

    // Nút "Trang đầu"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadSeatClasses(1)">Đầu</a>
        </li>
    `;

    // Nút "Trang trước"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadSeatClasses(${currentPage - 1})">Trước</a>
        </li>
    `;

    // Các trang
    for (let page = 1; page <= totalPages; page++) {
        pagination.innerHTML += `
            <li class="page-item ${currentPage === page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadSeatClasses(${page})">${page}</a>
            </li>
        `;
    }

    // Nút "Trang tiếp theo"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadSeatClasses(${currentPage + 1})">Sau</a>
        </li>
    `;

    // Nút "Trang cuối"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadSeatClasses(${totalPages})">Cuối</a>
        </li>
    `;
}

// Hiển thị danh sách hạng ghế trong bảng
function displaySeatClasses(seatClasses) {
    const tbody = document.querySelector('table.table tbody');
    tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

    if (!Array.isArray(seatClasses) || seatClasses.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
        return;
    }

    seatClasses.forEach(seatClass => {
        const row = `
            <tr>
                <td>${seatClass.seat_class_id}</td>
                <td>${seatClass.seat_class_name || 'Không xác định'}</td>
                <td>${seatClass.price_ratio || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow(this, ${seatClass.seat_class_id})">Sửa</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(${seatClass.seat_class_id})">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

// Thêm hạng ghế
function Insert(event) {
    event.preventDefault();

    const formData = {
        seat_class_name: document.getElementById('seat_class_name').value.trim(),
        price_ratio: document.getElementById('price_ratio').value.trim()
    };

    if (!formData.seat_class_name || !formData.price_ratio) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }

    fetch('http://172.20.10.4:8000/api/seatclass', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(formData)
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to insert seat class');
            return response.json();
        })
        .then(() => {
            alert('Thêm hạng ghế thành công!');
            clearForm();
            loadSeatClasses(1);
        })
        .catch(error => {
            console.error('Lỗi khi thêm hạng ghế:', error);
            alert('Không thể thêm hạng ghế. Vui lòng thử lại!');
        });
}

function clearForm() {
    document.getElementById('seat_class_name').value = '';
    document.getElementById('price_ratio').value = '';
    window.currentEditingSeatClassId='';
}

// Sửa hạng ghế
function editRow(button, seatClassId) {
    const row = button.closest('tr');

    const seatClassName = row.cells[1].textContent.trim();
    const priceRatio = row.cells[2].textContent.trim();

    document.getElementById('seat_class_name').value = seatClassName;
    document.getElementById('price_ratio').value = priceRatio;

    window.currentEditingSeatClassId = seatClassId;
}

function Update(event) {
    event.preventDefault();

    const seatClassId = window.currentEditingSeatClassId;
    if (!seatClassId) {
        alert('Vui lòng chọn hạng ghế để sửa!');
        return;
    }

    const updatedData = {
        seat_class_name: document.getElementById('seat_class_name').value.trim(),
        price_ratio: document.getElementById('price_ratio').value.trim()
    };

    fetch(`http://172.20.10.4:8000/api/seatclass/${seatClassId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(updatedData)
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to update seat class');
            return response.json();
        })
        .then(() => {
            alert('Cập nhật hạng ghế thành công!');
            clearForm();
            loadSeatClasses(1);
        })
        .catch(error => {
            console.error('Lỗi khi cập nhật hạng ghế:', error);
            alert('Không thể cập nhật hạng ghế. Vui lòng thử lại!');
        });
}

// Xóa hạng ghế
function deleteRow(seatClassId) {
    if (!confirm(`Bạn có chắc chắn muốn xóa hạng ghế với ID ${seatClassId}?`)) {
        return;
    }

    fetch(`http://172.20.10.4:8000/api/seatclass/${seatClassId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to delete seat class');
            alert('Xóa hạng ghế thành công!');
            loadSeatClasses(1);
        })
        .catch(error => {
            console.error('Lỗi khi xóa hạng ghế:', error);
            alert('Không thể xóa hạng ghế. Vui lòng thử lại!');
        });
}

// Thêm sự kiện khi thay đổi input tìm kiếm
document.getElementById('searchInput').addEventListener('input', () => {
    loadSeatClasses(1);
});
