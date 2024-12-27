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
        loadPromotion(1); // Gọi hàm loadCustomers để lấy dữ liệu
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
function loadPromotion(currentPage = 1) {
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
    const url = `http://${serverIp}:${serverPort}/api/promotions?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

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
            display(data);

            // Cập nhật phân trang
            if (data.length < limit && currentPage === 1) {
                updatePagination(data.length, currentPage, limit);
            } else {
                fetchTotalCount(currentPage, limit);
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu khuyến mãi:', error);
            alert('Không thể tải dữ liệu khuyến mãi. Vui lòng thử lại!');
        });
}
// Hàm lấy tổng số dòng từ API riêng
function fetchTotalCount(currentPage, limit) {
    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const countUrl = `http://${serverIp}:${serverPort}/api/promotions/count`;

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
            console.error('Lỗi khi lấy tổng số khuyến mãi:', error);
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
            <a class="page-link" href="#" onclick="loadPromotion(1)">Đầu</a>
        </li>
    `;

    // Nút "Trang trước"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadPromotion(${currentPage - 1})">Trước</a>
        </li>
    `;

    // Các trang
    for (let page = 1; page <= totalPages; page++) {
        pagination.innerHTML += `
            <li class="page-item ${currentPage === page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadPromotion(${page})">${page}</a>
            </li>
        `;
    }
    
    // Nút "Trang tiếp theo"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadPromotion(${currentPage + 1})">Sau</a>
        </li>
    `;
    // Nút "Trang cuối"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadPromotion(${totalPages})">Cuối</a>
        </li>
    `;
}



// Hiển thị danh sách khách hàng trong bảng
function display(promotions) {
    const tbody = document.querySelector('table.table tbody');
    tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

    if (!Array.isArray(promotions) || promotions.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
        return;
    }

    promotions.forEach(promotion => {
        const row = `
            <tr>
                <td>${promotion.promotion_id}</td>
                <td>${promotion.promotion_name || 'Không xác định'}</td>
                <td>${promotion.start_date ? new Date(promotion.start_date).toLocaleDateString('vi-VN') : 'Không xác định'}</td>
                <td>${promotion.end_date ? new Date(promotion.end_date).toLocaleDateString('vi-VN') : 'Không xác định'}</td>
                <td>${promotion.discount_percentage || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow(this, ${promotion.promotion_id})">Sửa</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(${promotion.promotion_id})">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
    
}
// Thêm khuyến mãi
function Insert(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của form

    // Thu thập dữ liệu từ form
    const formData = {
        promotion_name: document.getElementById('promotionName').value.trim(),
        start_date: document.getElementById('startDate').value,
        end_date: document.getElementById('endDate').value,
        discount_percentage: document.getElementById('discount').value
    };

    // Kiểm tra xem các trường dữ liệu có hợp lệ không
    if (!formData.promotion_name || !formData.start_date || !formData.end_date || !formData.discount_percentage) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }

    // Gửi yêu cầu POST tới API
    fetch('http://172.20.10.4:8000/api/promotions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(formData)
    })
        .then(response => {
            console.log('HTTP Response Status:', response.status); // Log trạng thái HTTP
            if (!response.ok) throw new Error('Failed to insert promotions');
            return response.json();
        })
        .then(data => {
            clearForm(); // Xóa sạch form sau khi thêm thành công
            loadPromotion(1); // Tải lại danh sách khách hàng
            alert('Thêm khuyến mãi thành công!');
        })
        .catch(error => {
            console.error('Lỗi khi thêm khuyến mãi:', error);
            alert('Không thể thêm khuyến mãi. Vui lòng thử lại!');
        });
}
// Hàm xóa sạch form sau khi thêm khuyến mãi
function clearForm() {
    document.getElementById('promotionName').value = '';
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    document.getElementById('discount').value = '';
}
// Sửa khuyến mãi
function Update(event) {
    event.preventDefault();

    const promotionId = window.currentEditingPromotionId; // ID khách hàng đang chỉnh sửa
    if (!promotionId) {
        alert("Vui lòng chọn khuyến mãi để sửa!");
        return;
    }

    // Thu thập dữ liệu từ form
    const updatedData = {
        promotion_name: document.getElementById('promotionName').value.trim(),
        start_date: document.getElementById('startDate').value,
        end_date: document.getElementById('endDate').value,
        discount_percentage: document.getElementById('discount').value
    };

    // Gửi request cập nhật
    fetch(`http://172.20.10.4:8000/api/promotions/${promotionId}`, {
    method: 'PUT',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${authToken}`
    },
    body: JSON.stringify(updatedData)
})

        .then(response => {
            if (!response.ok) throw new Error(`Failed to update promotion: ${response.status}`);
            return response.json();
        })
        .then(() => {
            alert('Cập nhật khuyến mãi thành công!');
            clearForm(); 
            loadPromotion(1); // Tải lại danh sách khách hàng
        })
        .catch(error => {
            console.error('Lỗi khi cập nhật khuyến mãi:', error);
            alert('Không thể cập nhật khuyến mãi. Vui lòng thử lại!');
        });
}


function deleteRow(promotionId) {
    if (!promotionId) {
        alert('Không tìm thấy ID khuyến mãi!');
        return;
    }

    const confirmation = confirm(`Bạn có chắc chắn muốn xóa khuyến mãi với ID ${promotionId}?`);
    if (!confirmation) return;

    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const url = `http://${serverIp}:${serverPort}/api/promotions/${promotionId}`;

    // Gửi yêu cầu DELETE tới API
    fetch(url, {
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
            alert(`Xóa khuyến mãi với ID ${promotionId} thành công!`);
            loadPromotion(1); // Tải lại danh sách khuyến mãi
        })
        .catch(error => {
            console.error('Lỗi khi xóa khuyến mãi:', error);
            alert('Không thể xóa khuyến mãi. Vui lòng thử lại!');
        });
}

function editRow(button) {
    // Lấy hàng hiện tại từ nút "Sửa"
    const row = button.closest('tr');

    // Lấy giá trị từ các ô trong hàng
    const promotionName = row.cells[1].textContent.trim();
    const startDate = row.cells[2].textContent.trim();
    const endDate = row.cells[3].textContent.trim();
    const discount = row.cells[4].textContent.trim();

    // Điền thông tin vào form
    document.getElementById('promotionName').value = promotionName;
    document.getElementById('startDate').value = startDate ? formatToInputDate(startDate) : '';
    document.getElementById('endDate').value = endDate ? formatToInputDate(endDate) : '';
    document.getElementById('discount').value = discount;

    // Lưu ID khuyến mãi đang chỉnh sửa vào biến toàn cục
    const promotionId = row.cells[0].textContent.trim(); // Giả sử ID nằm ở cột đầu tiên
    window.currentEditingPromotionId = promotionId;

    console.log(`Editing Promotion ID: ${promotionId}`);
}

// Hàm chuyển đổi định dạng ngày từ "DD/MM/YYYY" sang "YYYY-MM-DDTHH:mm" cho input datetime-local
function formatToInputDate(datetime) {
    const [day, month, year] = datetime.split('/');
    return `${year}-${month}-${day}T00:00`; // Thêm giờ mặc định là 00:00
}

// Thêm sự kiện khi thay đổi input tìm kiếm
document.getElementById('searchInput').addEventListener('input', () => {
    loadPromotion(1); // Load lại từ trang đầu
});

// Thêm sự kiện khi thay đổi danh sách quốc gia
document.getElementById('countryInput').addEventListener('change', () => {
    loadCustomers(1); // Load lại từ trang đầu
});