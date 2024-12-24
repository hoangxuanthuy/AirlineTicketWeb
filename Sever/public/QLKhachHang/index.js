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

    fetch('https://restcountries.com/v3.1/all')
        .then(response => response.json())
        .then(countries => {
            // Sắp xếp các quốc gia theo tên (ABC)
            countries.sort((a, b) => {
                const nameA = a.name.common.toUpperCase();
                const nameB = b.name.common.toUpperCase();
                return nameA.localeCompare(nameB);
            });

            // Điền dữ liệu quốc gia vào cả 2 combobox
            populateCountryOptions('country', countries); // Combobox "Quốc tịch"
            populateCountryOptions('countryInput', countries); // Combobox "Lọc quốc gia"
        })
        .catch(error => console.error('Lỗi khi lấy dữ liệu quốc gia:', error));
});
// Hàm điền dữ liệu vào combobox
function populateCountryOptions(elementId, countries) {
    const countrySelect = document.getElementById(elementId);
    if (!countrySelect) {
        console.error(`Phần tử với id="${elementId}" không tồn tại.`);
        return;
    }

    countries.forEach(country => {
        const option = document.createElement('option');
        option.value = country.name.common; // Mã quốc gia (tên quốc gia)
        option.textContent = country.name.common; // Tên quốc gia
        countrySelect.appendChild(option); // Thêm vào <select>
    });
}
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
    let countryFilter = document.getElementById('countryInput').value || '';
    if (countryFilter === 'chon') {
        countryFilter = '';
    }
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
        .then(data => {
            displayCustomers(data);

            // Cập nhật phân trang
            if (data.length < limit && currentPage === 1) {
                updatePagination(data.length, currentPage, limit);
            } else {
                fetchTotalCount(currentPage, limit);
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu khách hàng:', error);
            alert('Không thể tải dữ liệu khách hàng. Vui lòng thử lại!');
        });
}
// Hàm lấy tổng số dòng từ API riêng
function fetchTotalCount(currentPage, limit) {
    const serverIp = "192.168.1.6";
    const serverPort = "8000";
    const countUrl = `http://${serverIp}:${serverPort}/api/customers/count`;

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
            console.error('Lỗi khi lấy tổng số khách hàng:', error);
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
            <a class="page-link" href="#" onclick="loadCustomers(1)">Đầu</a>
        </li>
    `;

    // Nút "Trang trước"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadCustomers(${currentPage - 1})">Trước</a>
        </li>
    `;

    // Các trang
    for (let page = 1; page <= totalPages; page++) {
        pagination.innerHTML += `
            <li class="page-item ${currentPage === page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadCustomers(${page})">${page}</a>
            </li>
        `;
    }
    
    // Nút "Trang tiếp theo"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadCustomers(${currentPage + 1})">Sau</a>
        </li>
    `;
    // Nút "Trang cuối"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadCustomers(${totalPages})">Cuối</a>
        </li>
    `;
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
                <button class="btn btn-edit btn-sm" onclick="editRow(this, ${customer.client_id})">Sửa</button>
                <button class="btn btn-delete btn-sm" onclick="deleteRow(${customer.client_id})">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}
// Thêm khách hàng
function Insert(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của form

    // Thu thập dữ liệu từ form
    const formData = {
        client_name: document.getElementById('name').value.trim(),
        citizen_id: document.getElementById('cccd').value.trim(),
        phone: document.getElementById('phone').value.trim(),
        gender: document.getElementById('gender').value,
        birth_day: document.getElementById('birth').value,
        country: document.getElementById('country').value
    };

    // Kiểm tra xem các trường dữ liệu có hợp lệ không
    if (!formData.client_name || !formData.citizen_id || !formData.phone || !formData.birth_day || !formData.country) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }

    // Gửi yêu cầu POST tới API
    fetch('http://192.168.1.6:8000/api/customers', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(formData)
    })
        .then(response => {
            console.log('HTTP Response Status:', response.status); // Log trạng thái HTTP
            if (!response.ok) throw new Error('Failed to insert customer');
            return response.json();
        })
        .then(data => {
            clearForm(); // Xóa sạch form sau khi thêm thành công
            loadCustomers(1); // Tải lại danh sách khách hàng
            alert('Thêm khách hàng thành công!');
        })
        .catch(error => {
            console.error('Lỗi khi thêm khách hàng:', error);
            alert('Không thể thêm khách hàng. Vui lòng thử lại!');
        });
}
// Hàm xóa sạch form sau khi thêm khách hàng
function clearForm() {
    document.getElementById('name').value = '';
    document.getElementById('cccd').value = '';
    document.getElementById('phone').value = '';
    document.getElementById('gender').value = '';
    document.getElementById('birth').value = '';
    document.getElementById('country').value = 'Chọn';
}
// Sửa khách hàng
function Update(event) {
    event.preventDefault();

    const customerId = window.currentEditingCustomerId; // ID khách hàng đang chỉnh sửa
    if (!customerId) {
        alert("Vui lòng chọn khách hàng để sửa!");
        return;
    }

    // Thu thập dữ liệu từ form
    const updatedData = {
        client_name: document.getElementById('name').value.trim(),
        citizen_id: document.getElementById('cccd').value.trim(),
        phone: document.getElementById('phone').value.trim(),
        gender: document.getElementById('gender').value,
        birth_day: document.getElementById('birth').value,
        country: document.getElementById('country').value
    };

    // Gửi request cập nhật
    fetch(`http://192.168.1.6:8000/api/customers/${customerId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(updatedData)
    })
        .then(response => {
            if (!response.ok) throw new Error(`Failed to update customer: ${response.status}`);
            return response.json();
        })
        .then(() => {
            alert('Cập nhật khách hàng thành công!');
            loadCustomers(1); // Tải lại danh sách khách hàng
        })
        .catch(error => {
            console.error('Lỗi khi cập nhật khách hàng:', error);
            alert('Không thể cập nhật khách hàng. Vui lòng thử lại!');
        });
}


function deleteRow(clientId) {
    if (!confirm(`Bạn có chắc chắn muốn xóa khách hàng với ID ${clientId}?`)) {
        return;
    }

    fetch(`http://192.168.1.6:8000/api/customers/${clientId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error(`Lỗi khi xóa khách hàng: ${response.status}`);
            return response.json();
        })
        .then(() => {
            alert(`Xóa khách hàng với ID ${clientId} thành công!`);
            loadCustomers(1); // Tải lại danh sách khách hàng
        })
        .catch(error => {
            console.error('Lỗi khi xóa khách hàng:', error);
            alert('Không thể xóa khách hàng. Vui lòng thử lại!');
        });
}

function editRow(button, clientId) {
    // Lấy hàng hiện tại từ nút "Sửa"
    const row = button.closest('tr');

    // Lấy giá trị từ các ô trong hàng
    const name = row.cells[1].textContent.trim();
    const cccd = row.cells[2].textContent.trim();
    const phone = row.cells[3].textContent.trim();
    const gender = row.cells[4].textContent.trim();
    const birthDay = row.cells[5].textContent.trim();
    const country = row.cells[6].textContent.trim();

    // Điền thông tin vào form
    document.getElementById('name').value = name;
    document.getElementById('cccd').value = cccd;
    document.getElementById('phone').value = phone;
    document.getElementById('gender').value = gender;

    // Kiểm tra nếu ngày sinh có giá trị thì định dạng lại, ngược lại để trống
    if (birthDay && birthDay !== 'Không xác định') {
        const formattedDate = birthDay.split('/').reverse().join('-'); // Đổi định dạng dd/mm/yyyy thành yyyy-mm-dd
        document.getElementById('birth').value = formattedDate;
    } else {
        document.getElementById('birth').value = '';
    }

    // Gán quốc tịch nếu tồn tại, ngược lại để trống
    document.getElementById('country').value = country || 'Chọn';

    // Lưu ID khách hàng đang chỉnh sửa vào biến toàn cục
    window.currentEditingCustomerId = clientId;

    console.log(`Editing Customer ID: ${clientId}`);
    console.log(`Name: ${name}, CCCD: ${cccd}, Phone: ${phone}, Gender: ${gender}, Birth Day: ${birthDay}, Country: ${country}`);
}
// Thêm sự kiện khi thay đổi input tìm kiếm
document.getElementById('searchInput').addEventListener('input', () => {
    loadCustomers(1); // Load lại từ trang đầu
});

// Thêm sự kiện khi thay đổi danh sách quốc gia
document.getElementById('countryInput').addEventListener('change', () => {
    loadCustomers(1); // Load lại từ trang đầu
});