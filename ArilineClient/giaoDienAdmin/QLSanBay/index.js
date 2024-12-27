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


    function XemCong(button) {
        const row = button.closest('tr');
        const gateID = row.cells[0].textContent; // Lấy mã sân bay từ hàng
        // alert("")
        // Lưu gateID vào localStorage
        localStorage.setItem('gateID', gateID);

        // Chuyển hướng đến CongBay.html
        window.location.href = 'CongBay.php';    
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
        // let countryFilter = document.getElementById('countryInput').value || '';
        // if (countryFilter === 'chon') {
        //     countryFilter = '';
        // }
        const url = `http://${serverIp}:${serverPort}/api/airports?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

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
                console.error('Lỗi khi tải dữ liệu Sân bay:', error);
                alert('Không thể tải dữ liệu Sân bay. Vui lòng thử lại!');
            });
    }
    // Hàm lấy tổng số dòng từ API riêng
    function fetchTotalCount(currentPage, limit) {
        const serverIp = "172.20.10.4";
        const serverPort = "8000";
        const countUrl = `http://${serverIp}:${serverPort}/api/airports/count`;

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
                console.error('Lỗi khi lấy tổng số Sân bay:', error);
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



    // Hiển thị danh sách Sân bay trong bảng
    function displayData(airports) {
        const tbody = document.querySelector('table.table tbody');
        tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

        if (!Array.isArray(airports) || airports.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
            return;
        }

        airports.forEach(airport => {
            const row = `
        
        <tr>
            <td>${airport.airport_id }</td>
            <td>${airport.airport_name || 'Không xác định'}</td>
            <td>${airport.address || 'Không xác định'}</td>
            <td>
            <button class="btn btn-edit btn-sm" onclick="editRow(this, ${airport.airport_id})">Sửa</button>
            <button class="btn btn-delete btn-sm" onclick="deleteRow(${airport.airport_id})">Xóa</button>
            <button class="btn btn-custom btn-sm" onclick="XemCong(this)">Xem cổng bay</button>
            </td>
        </tr>
    `;
            tbody.innerHTML += row;
        });
    }
    // Thêm Sân bay
    function Insert(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của form
    
        // Thu thập dữ liệu từ form
        const formData = {
            airport_name: document.getElementById('airport_name').value.trim(),
            address: document.getElementById('address').value.trim()
        };
    
        // Kiểm tra dữ liệu trước khi gửi
        if (!formData.airport_name || !formData.address) {
            alert('Vui lòng điền đầy đủ thông tin trước khi thêm sân bay!');
            return;
        }
    
        // Gửi yêu cầu POST tới API
        fetch('http://172.20.10.4:8000/api/airports', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                if (!response.ok) throw new Error(`Failed to insert airport: ${response.status}`);
                return response.json();
            })
            .then(data => {
                alert('Thêm sân bay thành công!');
                clearForm(); // Xóa dữ liệu trong form
                loadData(1); // Tải lại danh sách sân bay
            })
            .catch(error => {
                console.error('Lỗi khi thêm sân bay:', error);
                alert('Không thể thêm sân bay. Vui lòng thử lại!');
            });
    }
    
    // Hàm xóa sạch form sau khi thêm Sân bay
    function clearForm() {
        document.getElementById('airport_name').value = '';
        document.getElementById('address').value = '';
        window.currentEditingairportId = null;
    }
    // Sửa Sân bay
    function Update(event) {
        event.preventDefault();
    
        const airportId = window.currentEditingairportId; // ID Sân bay đang chỉnh sửa
        if (!airportId) {
            alert("Vui lòng chọn Sân bay để sửa!");
            return;
        }
    
        // Thu thập dữ liệu từ form
        const updatedData = {
            airport_name: document.getElementById('airport_name').value.trim(),
            address: document.getElementById('address').value.trim(),
        };
    
        if (!updatedData.airport_name || !updatedData.address) {
            alert('Tên sân bay và địa chỉ không được để trống!');
            return;
        }
    
        // Gửi request cập nhật
        fetch(`http://172.20.10.4:8000/api/airports/${airportId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(updatedData)
        })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 400) {
                        throw new Error('Dữ liệu không hợp lệ!');
                    } else if (response.status === 404) {
                        throw new Error('Không tìm thấy sân bay!');
                    } else {
                        throw new Error(`Failed to update airport: ${response.status}`);
                    }
                }
                return response.json();
            })
            .then(() => {
                alert('Cập nhật Sân bay thành công!');
                loadData(1); // Tải lại danh sách Sân bay
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật Sân bay:', error);
                alert('Không thể cập nhật Sân bay. Vui lòng thử lại!');
            });
    }
    


    function deleteRow(airportId) {
        if (!confirm(`Bạn có chắc chắn muốn xóa Sân bay với ID ${airportId}?`)) {
            return;
        }

        fetch(`http://172.20.10.4:8000/api/airports/${airportId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        })
            .then(response => {
                if (!response.ok) throw new Error(`Lỗi khi xóa Sân bay: ${response.status}`);
                return response.json();
            })
            .then(() => {
                alert(`Xóa Sân bay với ID ${airportId} thành công!`);
                loadData(1); // Tải lại danh sách Sân bay
            })
            .catch(error => {
                console.error('Lỗi khi xóa Sân bay:', error);
                alert('Không thể xóa Sân bay. Vui lòng thử lại!');
            });
    }

    function editRow(button, airportId) {
        // Lấy hàng hiện tại từ nút "Sửa"
        const row = button.closest('tr');

        

        // Lấy giá trị từ các ô trong hàng
        const weight = row.cells[1].textContent.trim();
        const price = row.cells[2].textContent.trim();
        

        // Điền thông tin vào form
        document.getElementById('airport_name').value = weight;
        document.getElementById('address').value = price;
        

        // Lưu ID Sân bay đang chỉnh sửa vào biến toàn cục
        window.currentEditingairportId = airportId;

        console.log(`Editing airport ID: ${airportId}`);
        console.log(`airport_name: ${airport_name}, address: ${address}`);
    }
    function XemCong(button) {
        const row = button.closest('tr');
        const airportId = row.cells[0].textContent.trim(); // Lấy mã sân bay từ hàng
        localStorage.setItem('gateID', airportId); // Lưu mã sân bay vào localStorage
        window.location.href = 'CongBay.php'; // Chuyển hướng sang trang Cổng bay
    }
    
    // Thêm sự kiện khi thay đổi input tìm kiếm
    document.getElementById('searchInput').addEventListener('input', () => {
        loadData(1); // Load lại từ trang đầu
    });