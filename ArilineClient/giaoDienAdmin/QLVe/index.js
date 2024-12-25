const menuBtn = document.querySelector('.menu-btn');
    const sidebar = document.querySelector('.sidebar');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });

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
        const url = `http://${serverIp}:${serverPort}/api/tickets?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;
    
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
                console.error('Lỗi khi tải dữ liệu Vé:', error);
                alert('Không thể tải dữ liệu Vé. Vui lòng thử lại!');
            });
    }
    // Hàm lấy tổng số dòng từ API riêng
    function fetchTotalCount(currentPage, limit) {
        const serverIp = "192.168.60.5";
        const serverPort = "8000";
        const countUrl = `http://${serverIp}:${serverPort}/api/tickets/count`;
    
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
                console.error('Lỗi khi lấy tổng số Vé:', error);
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
    
    
    
    // Hiển thị danh sách Vé trong bảng
    function displayData(tickets) {
        const tbody = document.querySelector('table.table tbody');
        tbody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng
    
        if (!Array.isArray(tickets) || tickets.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
            return;
        }
    
        tickets.forEach(ticket => {
            const row = `
            
            <tr>
                <td>${ticket.ticket_id}</td>
                <td>${ticket.seat_id || 'Không xác định'}</td>
                <td>${ticket.promotion_id || 'Không xác định'}</td>
                <td>${ticket.client_id || 'Không xác định'}</td>
                <td>${ticket.luggage_id || 'Không xác định'}</td>
                <td>${ticket.flight_id || 'Không xác định'}</td>
                <td>${ticket.ticket_issuance_date || 'Không xác định'}</td>  
                <td>${ticket.status || 'Không xác định'}</td>
                <td>
                <button class="btn btn-edit btn-sm" onclick="cancelRow(${ticket.ticket_id})">Hủy</button>
                <button class="btn btn-delete btn-sm" onclick="deleteRow(${ticket.ticket_id})">Xóa</button>
                </td>
            </tr>
        `; //Chưa xử lý date_time
            tbody.innerHTML += row;
        });
    }
    // Thêm Vé
    // function Insert(event) {
    //     event.preventDefault(); // Ngăn chặn hành vi mặc định của form
    
    //     // Thu thập dữ liệu từ form
    //     const formData = {
    //         plane_id: document.getElementById('plane_id').value.trim(),
    //         departure_airport_id: document.getElementById('departure_airport_id').value.trim(),
    //         arrival_airport_id: document.getElementById('arrival_airport_id').value.trim(),
    //         gate_id: document.getElementById('gate_id').value.trim(),
    //         ticket_time: document.getElementById('ticket_time').value.trim(),
    //         departure_date_time: document.getElementById('departure_date_time').value,
    //         unit_price: document.getElementById('unit_price').value.trim(),
    
    //     };
    
    
    //     // Gửi yêu cầu POST tới API
    //     fetch('http://192.168.60.5:8000/api/tickets', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'Authorization': `Bearer ${authToken}`
    //         },
    //         body: JSON.stringify(formData)
    //     })
    //         .then(response => {
    //             console.log('HTTP Response Status:', response.status); // Log trạng thái HTTP
    //             if (!response.ok) throw new Error('Failed to insert ticket');
    //             return response.json();
    //         })
    //         .then(data => {
    //             clearForm(); // Xóa sạch form sau khi thêm thành công
    //             loadData(1); // Tải lại danh sách Vé
    //             alert('Thêm Vé thành công!');
    //         })
    //         .catch(error => {
    //             console.error('Lỗi khi thêm Vé:', error);
    //             alert('Không thể thêm Vé. Vui lòng thử lại!');
    //         });
    // }
    // // Hàm xóa sạch form sau khi thêm Vé
    // function clearForm() {
    
    
    //     document.getElementById('plane_id').value = '';
    //     document.getElementById('departure_airport_id').value = '';
    //     document.getElementById('arrival_airport_id').value = '';
    //     document.getElementById('gate_id').value = '';
    //     document.getElementById('ticket_time').value = '';
    //     document.getElementById('departure_date_time').value = '';
    //     document.getElementById('unit_price').value = '';
    // }
    // // Sửa Vé
    // function Update(event) {
    //     event.preventDefault();
    
    //     const ticketId = window.currentEditingticketId; // ID Vé đang chỉnh sửa
    //     if (!ticketId) {
    //         alert("Vui lòng chọn Vé để sửa!");
    //         return;
    //     }
    
    //     // Thu thập dữ liệu từ form
    //     const updatedData = {
    //         plane_id: document.getElementById('plane_id').value.trim(),
    //         departure_airport_id: document.getElementById('departure_airport_id').value.trim(),
    //         arrival_airport_id: document.getElementById('arrival_airport_id').value.trim(),
    //         gate_id: document.getElementById('gate_id').value.trim(),
    //         ticket_time: document.getElementById('ticket_time').value.trim(),
    //         departure_date_time: document.getElementById('departure_date_time').value,
    //         unit_price: document.getElementById('unit_price').value.trim(),
    //     };
    
    //     // Gửi request cập nhật
    //     fetch(`http://192.168.60.5:8000/api/tickets/${ticketId}`, {
    //         method: 'PUT',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'Authorization': `Bearer ${authToken}`
    //         },
    //         body: JSON.stringify(updatedData)
    //     })
    //         .then(response => {
    //             if (!response.ok) throw new Error(`Failed to update ticket: ${response.status}`);
    //             return response.json();
    //         })
    //         .then(() => {
    //             alert('Cập nhật Vé thành công!');
    //             loadData(1); // Tải lại danh sách Vé
    //         })
    //         .catch(error => {
    //             console.error('Lỗi khi cập nhật Vé:', error);
    //             alert('Không thể cập nhật Vé. Vui lòng thử lại!');
    //         });
    // }
    
    
    function deleteRow(ticketId) {
        if (!confirm(`Bạn có chắc chắn muốn xóa Vé với ID ${ticketId}?`)) {
            return;
        }
    
        fetch(`http://192.168.60.5:8000/api/tickets/${ticketId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        })
            .then(response => {
                if (!response.ok) throw new Error(`Lỗi khi xóa Vé: ${response.status}`);
                return response.json();
            })
            .then(() => {
                alert(`Xóa Vé với ID ${ticketId} thành công!`);
                loadData(1); // Tải lại danh sách Vé
            })
            .catch(error => {
                console.error('Lỗi khi xóa Vé:', error);
                alert('Không thể xóa Vé. Vui lòng thử lại!');
            });
    }

    function cancelRow(ticketId) {
        if (!confirm(`Bạn có chắc chắn muốn hủy Vé với ID ${ticketId}?`)) {
            return;
        }
    
        // fetch(`http://192.168.60.5:8000/api/tickets/${ticketId}`, {
        //     method: 'DELETE',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'Authorization': `Bearer ${authToken}`
        //     }
        // })
        //     .then(response => {
        //         if (!response.ok) throw new Error(`Lỗi khi xóa Vé: ${response.status}`);
        //         return response.json();
        //     })
        //     .then(() => {
        //         alert(`Xóa Vé với ID ${ticketId} thành công!`);
        //         loadData(1); // Tải lại danh sách Vé
        //     })
        //     .catch(error => {
        //         console.error('Lỗi khi xóa Vé:', error);
        //         alert('Không thể xóa Vé. Vui lòng thử lại!');
        //     });
    }

    document.getElementById('searchInput').addEventListener('input', () => {
        loadData(1); // Load lại từ trang đầu
    });