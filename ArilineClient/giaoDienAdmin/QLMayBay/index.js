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

    function viewSeats(button) {
        const row = button.closest('tr');
        const planeid = row.cells[0].textContent.trim(); // Lấy mã sân bay từ hàng
        localStorage.setItem('planeID', planeid); // Lưu mã sân bay vào localStorage
        window.location.href = 'GheMayBay.php'; // Chuyển hướng sang trang Cổng bay
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

        //load theo mã Máy bay 
        const searchQuery = document.getElementById('searchInput').value || '';
        // let countryFilter = document.getElementById('countryInput').value || '';
        const url = `http://${serverIp}:${serverPort}/api/airplanes?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

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
                console.error('Lỗi khi tải dữ liệu Máy bay:', error);
                alert('Không thể tải dữ liệu Máy bay. Vui lòng thử lại!');
            });
    }
    // Hàm lấy tổng số dòng từ API riêng
    function fetchTotalCount(currentPage, limit) {
        const serverIp = "172.20.10.4";
        const serverPort = "8000";
        const countUrl = `http://${serverIp}:${serverPort}/api/airplanes/count`;

        fetch(countUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}` // Đảm bảo authToken được lấy từ localStorage
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
                console.error('Lỗi khi lấy tổng số Máy bay:', error);
            });
    }

    function updatePagination(totalCount, currentPage, limit) {
        
        const pagination = document.querySelector('.pagination');

    if (!pagination) {
        console.error('Lỗi: Phần tử .pagination không tồn tại trong DOM.');
        return; // Thoát khỏi hàm nếu không tìm thấy .pagination
    }
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



    // Hiển thị danh sách Máy bay trong bảng
    function displayData(airplanes) {
        const tbody = document.querySelector('table.table tbody');
        tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng
    
        if (!Array.isArray(airplanes) || airplanes.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">Không có dữ liệu</td></tr>';
            return;
        }
    
        airplanes.forEach(airplane => {
            const row = `
            <tr>
                <td>${airplane.plane_id}</td>
                <td>${airplane.plane_name || 'Không xác định'}</td>
                <td>${airplane.airline_id || 'Không xác định'}</td>
                <td>${airplane.first_class_seats || 'Không xác định'}</td>
                <td>${airplane.second_class_seats || 'Không xác định'}</td>
                <td>
                    <button class="btn btn-edit btn-sm" 
                    onclick="editRow(${airplane.plane_id}, '${airplane.plane_name}', '${airplane.airline_id}', ${airplane.first_class_seats}, ${airplane.second_class_seats})">
                    Sửa
                    </button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(${airplane.plane_id})">Xóa</button>
                    <button class="btn btn-xemghe btn-sm" onclick="viewSeats(this)">Xem ghế</button>
                </td>
            </tr>
            `;
            tbody.innerHTML += row;
        });
    }
    
    // Thêm Máy bay
    function Insert(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của form

        // Thu thập dữ liệu từ form
        const formData = {
            plane_name: document.getElementById('plane_name').value.trim(),
            airline_id: document.getElementById('airline_id').value.trim(),
            first_class_seats: document.getElementById('first_class_seats').value.trim(),
            second_class_seats: document.getElementById('second_class_seats').value.trim(),

        };


        // Gửi yêu cầu POST tới API
        fetch('http://172.20.10.4:8000/api/airplanes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                console.log('HTTP Response Status:', response.status); // Log trạng thái HTTP
                if (!response.ok) throw new Error('Failed to insert airplane');
                return response.json();
            })
            .then(data => {
                clearForm(); // Xóa sạch form sau khi thêm thành công
                loadData(1); // Tải lại danh sách Máy bay
                alert('Thêm Máy bay thành công!');
            })
            .catch(error => {
                console.error('Lỗi khi thêm Máy bay:', error);
                alert('Không thể thêm Máy bay. Vui lòng thử lại!');
            });
    }
    // Hàm xóa sạch form sau khi thêm Máy bay
    function clearForm() {

        document.getElementById('plane_name').value = '';
        document.getElementById('airline_id').value = '';
        document.getElementById('first_class_seats').value = '';
        document.getElementById('second_class_seats').value = '';

    }
    // Sửa Máy bay
    function Update(event) {
        event.preventDefault();
    
        const airplaneId = window.currentEditingAirplaneId; // ID Máy bay đang chỉnh sửa
        if (!airplaneId) {
            alert("Vui lòng chọn Máy bay để sửa!");
            return;
        }
    
        // Thu thập dữ liệu từ form
        const updatedData = {
            plane_name: document.getElementById('plane_name').value.trim(),
            airline_id: document.getElementById('airline_id').value.trim(),
            first_class_seats: document.getElementById('first_class_seats').value.trim(),
            second_class_seats: document.getElementById('second_class_seats').value.trim(),
        };
    
        // Gửi request cập nhật
        fetch(`http://172.20.10.4:8000/api/airplanes/${airplaneId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(updatedData)
        })
            .then(response => {
                if (!response.ok) throw new Error(`Failed to update airplane: ${response.status}`);
                return response.json();
            })
            .then(() => {
                alert('Cập nhật Máy bay thành công!');
                clearForm();
                loadData(1); // Tải lại danh sách Máy bay
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật Máy bay:', error);
                alert('Không thể cập nhật Máy bay. Vui lòng thử lại!');
            });
    }
    


    function deleteRow(planeId) {
        if (!confirm(`Bạn có chắc chắn muốn xóa Máy bay với ID ${planeId}?`)) {
            return;
        }
    
        fetch(`http://172.20.10.4:8000/api/airplanes/${planeId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        })
            .then(response => {
                if (!response.ok) throw new Error(`Lỗi khi xóa Máy bay: ${response.status}`);
                return response.json();
            })
            .then(() => {
                alert(`Xóa Máy bay với ID ${planeId} thành công!`);
                loadData(1); // Tải lại danh sách Máy bay
            })
            .catch(error => {
                console.error('Lỗi khi xóa Máy bay:', error);
                alert('Không thể xóa Máy bay. Vui lòng thử lại!');
            });
    }
    

    function editRow(planeId, planeName, airlineId, firstClassSeats, secondClassSeats) {
        // Điền thông tin vào form
        document.getElementById('plane_name').value = planeName || '';
        document.getElementById('airline_id').value = airlineId || '';
        document.getElementById('first_class_seats').value = firstClassSeats || '';
        document.getElementById('second_class_seats').value = secondClassSeats || '';
    
        // Lưu ID Máy bay đang chỉnh sửa vào biến toàn cục
        window.currentEditingAirplaneId = planeId;
    
        console.log(`Editing Plane ID: ${planeId}`);
    }
    
    
    // Thêm sự kiện khi thay đổi input tìm kiếm
    document.getElementById('searchInput').addEventListener('input', () => {
        loadData(1); // Load lại từ trang đầu
    });