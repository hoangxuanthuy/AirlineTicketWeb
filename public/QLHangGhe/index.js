const menuBtn = document.querySelector('.menu-btn');
    const sidebar = document.querySelector('.sidebar');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });

    // Kiểm tra trạng thái đăng nhập
    const isLoggedIn = localStorage.getItem("isLoggedIn");

    // Nếu chưa đăng nhập, chuyển về trang Login
    if (!isLoggedIn) {
        alert("Vui lòng đăng nhập trước!");
        window.location.href = "Login.html";
    }

    function logout() {
        // Cảnh báo xác nhận trước khi đăng xuất
        const confirmation = window.confirm("Bạn có chắc chắn muốn đăng xuất?");
        
        if (confirmation) {
            // Nếu người dùng chọn OK, quay lại trang đăng nhập
            localStorage.removeItem("isLoggedIn");
            window.location.href = "login.html";  // Chuyển về trang login
        } else {
            // Nếu người dùng chọn Cancel, không làm gì
            console.log("Đăng xuất đã bị hủy");
        }
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
                displayData(data);

                // Cập nhật phân trang
                if (data.length < limit && currentPage === 1) {
                    updatePagination(data.length, currentPage, limit);
                } else {
                    fetchTotalCount(currentPage, limit);
                }
            })
            .catch(error => {
                console.error('Lỗi khi tải dữ liệu Hạng ghế:', error);
                alert('Không thể tải dữ liệu Hạng ghế. Vui lòng thử lại!');
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
                console.error('Lỗi khi lấy tổng số Hạng ghế:', error);
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



    // Hiển thị danh sách Hạng ghế trong bảng
    function displayData(seatclasss) {
        const tbody = document.querySelector('table.table tbody');
        tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

        if (!Array.isArray(seatclasss) || seatclasss.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
            return;
        }

        seatclasss.forEach(seatclass => {
            const row = `
        
        <tr>
            <td>${seatclass.seat_class_id  }</td>
            <td>${seatclass.seat_class_name  || 'Không xác định'}</td>
            <td>${seatclass.price_ratio  || 'Không xác định'}</td>
            <td>
            <button class="btn btn-edit btn-sm" onclick="editRow(this, ${seatclass.seat_class_id })">Sửa</button>
            <button class="btn btn-delete btn-sm" onclick="deleteRow(${seatclass.seat_class_id })">Xóa</button>
            </td>
        </tr>
    `;
            tbody.innerHTML += row;
        });
    }
    // Thêm Hạng ghế
    function Insert(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của form

        // Thu thập dữ liệu từ form
        const formData = {
            seat_class_name : document.getElementById('seat_class_name ').value.trim(),
            price_ratio : document.getElementById('price_ratio ').value.trim(),

        };


        // Gửi yêu cầu POST tới API
        fetch('http://172.20.10.4:8000/api/seatclass', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                console.log('HTTP Response Status:', response.status); // Log trạng thái HTTP
                if (!response.ok) throw new Error('Failed to insert seatclass');
                return response.json();
            })
            .then(data => {
                clearForm(); // Xóa sạch form sau khi thêm thành công
                loadData(1); // Tải lại danh sách Hạng ghế
                alert('Thêm Hạng ghế thành công!');
            })
            .catch(error => {
                console.error('Lỗi khi thêm Hạng ghế:', error);
                alert('Không thể thêm Hạng ghế. Vui lòng thử lại!');
            });
    }
    // Hàm xóa sạch form sau khi thêm Hạng ghế
    function clearForm() {
        document.getElementById('seat_class_name ').value = '';
        document.getElementById('price_ratio ').value = '';
    }
    // Sửa Hạng ghế
    function Update(event) {
        event.preventDefault();

        const seatclassId = window.currentEditingseatclassId; // ID Hạng ghế đang chỉnh sửa
        if (!seatclassId) {
            alert("Vui lòng chọn Hạng ghế để sửa!");
            return;
        }

        // Thu thập dữ liệu từ form
        const updatedData = {
            seat_class_name : document.getElementById('seat_class_name ').value.trim(),
            price_ratio : document.getElementById('price_ratio ').value.trim(),
        };

        // Gửi request cập nhật
        fetch(`http://172.20.10.4:8000/api/seatclass/${seatclassId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(updatedData)
        })
            .then(response => {
                if (!response.ok) throw new Error(`Failed to update seatclass: ${response.status}`);
                return response.json();
            })
            .then(() => {
                alert('Cập nhật Hạng ghế thành công!');
                loadData(1); // Tải lại danh sách Hạng ghế
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật Hạng ghế:', error);
                alert('Không thể cập nhật Hạng ghế. Vui lòng thử lại!');
            });
    }


    function deleteRow(seatclassId) {
        if (!confirm(`Bạn có chắc chắn muốn xóa Hạng ghế với ID ${seatclassId}?`)) {
            return;
        }

        fetch(`http://172.20.10.4:8000/api/seatclass/${seatclassId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        })
            .then(response => {
                if (!response.ok) throw new Error(`Lỗi khi xóa Hạng ghế: ${response.status}`);
                return response.json();
            })
            .then(() => {
                alert(`Xóa Hạng ghế với ID ${seatclassId} thành công!`);
                loadData(1); // Tải lại danh sách Hạng ghế
            })
            .catch(error => {
                console.error('Lỗi khi xóa Hạng ghế:', error);
                alert('Không thể xóa Hạng ghế. Vui lòng thử lại!');
            });
    }

    function editRow(button, seatclassId) {
        // Lấy hàng hiện tại từ nút "Sửa"
        const row = button.closest('tr');

        

        // Lấy giá trị từ các ô trong hàng
        const seat_class_name  = row.cells[1].textContent.trim();
        const price_ratio  = row.cells[2].textContent.trim();
        

        // Điền thông tin vào form
        document.getElementById('seat_class_name').value = seat_class_name;
        document.getElementById('price_ratio ').value = price_ratio ;
        

        // Lưu ID Hạng ghế đang chỉnh sửa vào biến toàn cục
        window.currentEditingseatclassId = seatclassId;

        console.log(`Editing seatclass ID: ${seatclassId}`);
        console.log(`seat_class_name: ${seat_class_name}, price_ratio : ${price_ratio}`);
    }
    // Thêm sự kiện khi thay đổi input tìm kiếm
    document.getElementById('searchInput').addEventListener('input', () => {
        loadData(1); // Load lại từ trang đầu
    });