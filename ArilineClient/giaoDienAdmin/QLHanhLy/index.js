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

    
        function loadData(currentPage = 1) {
            if (!authToken) {
                alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
                window.location.href = "../login.php";
                return;
            }

            const serverIp = "192.168.60.5";
            const serverPort = "8000";
            const limit = 5;
            const offset = (currentPage - 1) * limit;

            //load theo mã sân bay 
            const searchQuery = document.getElementById('searchInput').value || '';
            // let countryFilter = document.getElementById('countryInput').value || '';
            // if (countryFilter === 'chon') {
            //     countryFilter = '';
            // }
            const url = `http://${serverIp}:${serverPort}/api/luggage?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

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
                    console.error('Lỗi khi tải dữ liệu Cổng bay:', error);
                    alert('Không thể tải dữ liệu Cổng bay. Vui lòng thử lại!');
                });
        }
        // Hàm lấy tổng số dòng từ API riêng
        function fetchTotalCount(currentPage, limit) {
            const serverIp = "192.168.60.5";
            const serverPort = "8000";
            const countUrl = `http://${serverIp}:${serverPort}/api/luggage/count`;

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
                    console.error('Lỗi khi lấy tổng số Cổng bay:', error);
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



        // Hiển thị danh sách Cổng bay trong bảng
        function displayData(luggages) {
            const tbody = document.querySelector('table.table tbody');
            tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

            if (!Array.isArray(luggages) || luggages.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
                return;
            }

            luggages.forEach(luggage => {
                const row = `
            
            <tr>
                <td>${luggage.luggage_id }</td>
                <td>${luggage.weight || 'Không xác định'}</td>
                <td>${luggage.price || 'Không xác định'}</td>
                <td>
                <button class="btn btn-edit btn-sm" onclick="editRow(this, ${luggage.luggage_id})">Sửa</button>
                <button class="btn btn-delete btn-sm" onclick="deleteRow(${luggage.luggage_id})">Xóa</button>
                </td>
            </tr>
        `;
                tbody.innerHTML += row;
            });
        }
        // Thêm Cổng bay
        function Insert(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của form

            // Thu thập dữ liệu từ form
            const formData = {
                weight: document.getElementById('weight').value.trim(),
                price: document.getElementById('price').value.trim(),

            };


            // Gửi yêu cầu POST tới API
            fetch('http://192.168.60.5:8000/api/luggage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify(formData)
            })
                .then(response => {
                    console.log('HTTP Response Status:', response.status); // Log trạng thái HTTP
                    if (!response.ok) throw new Error('Failed to insert luggage');
                    return response.json();
                })
                .then(data => {
                    clearForm(); // Xóa sạch form sau khi thêm thành công
                    loadData(1); // Tải lại danh sách Cổng bay
                    alert('Thêm cổng bay thành công!');
                })
                .catch(error => {
                    console.error('Lỗi khi thêm cổng bay:', error);
                    alert('Không thể thêm cổng bay. Vui lòng thử lại!');
                });
        }
        // Hàm xóa sạch form sau khi thêm Cổng bay
        function clearForm() {
            document.getElementById('weight').value = '';
            document.getElementById('price').value = '';
        }
        // Sửa Cổng bay
        function Update(event) {
            event.preventDefault();

            const luggageId = window.currentEditingluggageId; // ID cổng bay đang chỉnh sửa
            if (!luggageId) {
                alert("Vui lòng chọn Cổng bay để sửa!");
                return;
            }

            // Thu thập dữ liệu từ form
            const updatedData = {
                weight: document.getElementById('weight').value.trim(),
                price: document.getElementById('price').value.trim(),
            };

            // Gửi request cập nhật
            fetch(`http://192.168.60.5:8000/api/luggage/${luggageId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify(updatedData)
            })
                .then(response => {
                    if (!response.ok) throw new Error(`Failed to update luggage: ${response.status}`);
                    return response.json();
                })
                .then(() => {
                    alert('Cập nhật Cổng bay thành công!');
                    loadData(1); // Tải lại danh sách Cổng bay
                })
                .catch(error => {
                    console.error('Lỗi khi cập nhật Cổng bay:', error);
                    alert('Không thể cập nhật Cổng bay. Vui lòng thử lại!');
                });
        }


        function deleteRow(luggageId) {
            if (!confirm(`Bạn có chắc chắn muốn xóa Cổng bay với ID ${luggageId}?`)) {
                return;
            }

            fetch(`http://192.168.60.5:8000/api/luggage/${luggageId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error(`Lỗi khi xóa Cổng bay: ${response.status}`);
                    return response.json();
                })
                .then(() => {
                    alert(`Xóa cổng bay với ID ${luggageId} thành công!`);
                    loadData(1); // Tải lại danh sách Cổng bay
                })
                .catch(error => {
                    console.error('Lỗi khi xóa Cổng bay:', error);
                    alert('Không thể xóa Cổng bay. Vui lòng thử lại!');
                });
        }

        function editRow(button, luggageId) {
            // Lấy hàng hiện tại từ nút "Sửa"
            const row = button.closest('tr');

            

            // Lấy giá trị từ các ô trong hàng
            const weight = row.cells[1].textContent.trim();
            const price = row.cells[2].textContent.trim();
            

            // Điền thông tin vào form
            document.getElementById('weight').value = weight;
            document.getElementById('price').value = price;
            

            // Lưu ID Cổng bay đang chỉnh sửa vào biến toàn cục
            window.currentEditingluggageId = luggageId;

            console.log(`Editing luggage ID: ${luggageId}`);
            console.log(`weight: ${weight}, price: ${price}`);
        }
        // Thêm sự kiện khi thay đổi input tìm kiếm
        document.getElementById('searchInput').addEventListener('input', () => {
            loadData(1); // Load lại từ trang đầu
        });
