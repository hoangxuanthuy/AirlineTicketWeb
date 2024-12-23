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

    // const offset = 1;

    // function updatePagination() {
    //     const pagination = document.querySelector('.pagination');
    //     pagination.innerHTML = ''; // Xóa nội dung cũ


    //     const visibleRange = 1; // Số trang liền kề cần hiển thị
    //     const firstPage = 1;
    //     const lastPage = totalPages;

    //     // Nút "First" và "Prev"
    //     // pagination.innerHTML += `
    //     //     <li class="page-item ${offset === firstPage ? 'disabled' : ''}"> 
    //     //         <a class="page-link" href="#" id="prevPage">&lsaquo;</a>
    //     //     </li>
    //     // `;

    //     pagination.innerHTML += `
    //         <li class="page-item ${offset === firstPage ? 'disabled' : ''}">
    //             <a class="page-link" href="#" data-page="${firstPage}" id="firstPage">&laquo;</a>
    //         </li>
    //         <li class="page-item ${offset === firstPage ? 'disabled' : ''}">
    //             <a class="page-link" href="#" data-page="${offset - 1}" id="prevPage">&lsaquo;</a>
    //         </li>
    //     `;

    //     // Vòng lặp hiển thị trang
    //     for (let i = firstPage; i <= lastPage; i++) {
    //         if (
    //             i === firstPage ||  // Trang đầu
    //             i === lastPage ||   // Trang cuối
    //             (i >= offset - visibleRange && i <= offset + visibleRange)  // Các trang gần offset
    //         ) {
    //             pagination.innerHTML += `
    //                 <li class="page-item ${offset === i ? 'active' : ''}">
    //                     <a class="page-link" href="#" data-page="${i}">${i}</a>
    //                 </li>
    //             `;
    //         } else if (
    //             (i === offset - visibleRange - 1 && i > firstPage) ||  // Dấu "..." trước
    //             (i === offset + visibleRange + 1 && i < lastPage)      // Dấu "..." sau
    //         ) {
    //             pagination.innerHTML += `
    //                 <li class="page-item disabled">
    //                     <span class="page-link">...</span>
    //                 </li>
    //             `;
    //         }
    //     }

    //     // Nút "Next" và "Last"
    //     pagination.innerHTML += `
    //         <li class="page-item ${offset === lastPage ? 'disabled' : ''}">
    //             <a class="page-link" href="#" data-page="${offset + 1}" id="nextPage">&rsaquo;</a>
    //         </li>
    //         <li class="page-item ${offset === lastPage ? 'disabled' : ''}">
    //             <a class="page-link" href="#" data-page="${lastPage}" id="lastPage">&raquo;</a>
    //         </li>
    //     `;

    //     // Thêm sự kiện click cho các nút phân trang
    //     pagination.querySelectorAll('a.page-link').forEach(link => {
    //         link.addEventListener('click', function (event) {
    //             event.preventDefault();
    //             const page = parseInt(this.getAttribute('data-page'), 10);
    //             if (!isNaN(page)) {
    //                 currentPage = page; // Cập nhật trang hiện tại
    //                 loadCustomers(currentPage); // Gọi hàm tải dữ liệu trang mới
    //             }
    //         });
    //     });
    // }



    function updatePagination(totalPages, currentPage) {
        const pagination = document.querySelector('.pagination');
        pagination.innerHTML = ''; // Xóa nội dung cũ
    
        const visibleRange = 2; // Số trang liền kề cần hiển thị
        const firstPage = 1;
        const lastPage = totalPages;
    
        // Nút "First" và "Prev"
        pagination.innerHTML += `
            <li class="page-item ${currentPage === firstPage ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${firstPage}">&laquo;</a>
            </li>
            <li class="page-item ${currentPage === firstPage ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage - 1}">&lsaquo;</a>
            </li>
        `;
    
        // Vòng lặp hiển thị trang
        for (let i = firstPage; i <= lastPage; i++) {
            if (
                i === firstPage || // Trang đầu
                i === lastPage ||  // Trang cuối
                (i >= currentPage - visibleRange && i <= currentPage + visibleRange) // Các trang gần currentPage
            ) {
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            } else if (
                (i === currentPage - visibleRange - 1 && i > firstPage) ||  // Dấu "..." trước
                (i === currentPage + visibleRange + 1 && i < lastPage)      // Dấu "..." sau
            ) {
                pagination.innerHTML += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                `;
            }
        }
    
        // Nút "Next" và "Last"
        pagination.innerHTML += `
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage + 1}">&rsaquo;</a>
            </li>
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${lastPage}">&raquo;</a>
            </li>
        `;
    
        // Thêm sự kiện click cho các nút phân trang
        pagination.querySelectorAll('a.page-link').forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const page = parseInt(this.getAttribute('data-page'), 10);
                if (!isNaN(page)) {
                    loadCustomers(page); // Gọi hàm tải dữ liệu trang mới
                }
            });
        });
    }
    


    // Hàm lấy dữ liệu KH ở trnag hiện tại
    function loadCustomers(currentPage = 1) {
        const serverIp = "127.0.0.1";
        const serverPort = "8001";
        const limit = 5; // Số bản ghi mỗi trang
        offset = (currentPage - 1) * limit; // Tính toán offset
    
        // Lấy giá trị từ các trường tìm kiếm (nếu có)
        const searchQuery = document.getElementById('searchInput')?.value || '';
        const countryFilter = document.getElementById('countryInput')?.value || '';
    
        // Xây dựng URL API
        const url = `http://${serverIp}:${serverPort}/api/searchcus?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}&country=${encodeURIComponent(countryFilter)}`;
    
        // Gửi yêu cầu GET tới API
        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}` // Nếu cần token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch customers');
            }
            return response.json();
        })
        .then(data => {
            // Hiển thị dữ liệu khách hàng lên bảng
            displayCustomers(data.customers);
    
            // Cập nhật phân trang dựa trên tổng số trang
            const totalPages = Math.ceil(data.totalCount / limit);
            updatePagination(totalPages, currentPage);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Load customers failed: ' + error.message);
        });
    }
    
    // Hàm hiển thị dữ liệu khách hàng lên bảng
    function displayCustomers(customers) {
        const tbody = document.querySelector('table.table tbody');
        tbody.innerHTML = ''; // Làm trống bảng trước khi thêm dữ liệu mới
    
        customers.forEach(customer => {
            const row = `
                <tr>
                    <td>${customer.customer_id}</td>
                    <td>${customer.customer_name}</td>
                    <td>${customer.citizen_id}</td>
                    <td>${customer.phone}</td>
                    <td>${customer.gender}</td>
                    <td>${customer.birth_day}</td>
                    <td>${customer.country}</td>
                    <td>
                        <button class="btn btn-edit btn-sm" onclick="editRow(this)">Sửa</button>
                        <button class="btn btn-delete btn-sm" onclick="deleteCustomer(this)">Xóa</button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    
    function Clear(){
        document.getElementById('birth').value = '';
        document.getElementById('name').value = '';
        document.getElementById('cccd').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('gender').value = '';
        document.getElementById('country').value = 'chon';

        loadCustomers(1);
    }

    function Insert(event){
        event.preventDefault();
        const submitButton = event.target.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
        }
        const formData = {
            client_name: document.getElementById('name').value,
            citizen_id: document.getElementById('cccd').value,
            phone: document.getElementById('phone').value,
            gender: document.getElementById('gender').value,
            birth_day: document.getElementById('birth').value,
            country: document.getElementById('country').value
            // confirmPassword: document.getElementById('confirmPassword').value
        };

        const token = localStorage.getItem('auth_token');

        const serverIp = "127.0.0.1";
        const serverPort = "8001";

        console.log('Server IP:', serverIp);
        fetch(`http://${serverIp}:${serverPort}/api/customers`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({

                client_name: formData.client_name,
                citizen_id: formData.citizen_id,
                phone: formData.phone,
                gender: formData.gender,
                birth_day: formData.birth_day,
                country: formData.country
            })
        })
        .then(response => {
            console.log('Response:', response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text().then(text => text ? JSON.parse(text) : {});
        })
        .then(data => {
            //TODO: check the status code not the message
            if (data.message === 'Account created successfully') {
                alert('Insert successful!\nWelcome ' + formData.fullName);

                Clear();
            } else {
                alert('Insert failed: ' + JSON.stringify(data));
                if (submitButton) {
                    submitButton.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Insert failed: ' + error.message);
            if (submitButton) {
                submitButton.disabled = false;
            }
        });
    }


    function Update(event){
        event.preventDefault();

        if (!confirm(`Are you sure you want to Update customer ${customerId}?`)) {return;}

        const updatedData = {
            customer_name: document.getElementById('name').value,
            citizen_id: document.getElementById('cccd').value,
            phone: document.getElementById('phone').value,
            gender: document.getElementById('gender').value,
            birth_day: document.getElementById('birth').value,
            country: document.getElementById('country').text,
        };

        const serverIp = "127.0.0.1";
        const serverPort = "8001";

        // Gửi yêu cầu cập nhật tới API
        fetch(`http://${serverIp}:${serverPort}/api/customers/${customerId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}` // Nếu cần token
            },
            body: JSON.stringify(updatedData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to update customer');
            }
            return response.json();
        })
        .then(data => {
            alert(`Customer ${customerId} updated successfully.`);
            Clear(); // Reload lại danh sách khách hàng
        })
        .catch(error => {
            console.error('Error:', error);
            alert(`Update failed: ${error.message}`);
        });
    }


    function deleteRow(button) {
        const row = button.closest('tr');
        const customerId = row.cells[0].textContent; // Lấy mã khách hàng từ hàng
        if (!confirm(`Are you sure you want to delete the customer ${customerId}?`)) {
            return;
        }

        const serverIp = "127.0.0.1";
        const serverPort = "8001";

        // Gửi yêu cầu DELETE tới API
        fetch(`http://${serverIp}:${serverPort}/api/customers/${customerId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}` // Nếu cần token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete customer');
            }
            return response.json();
        })
        .then(data => {
            // Xóa hàng khỏi bảng sau khi xóa thành công
            alert(`Delete customer ${customerId} successfully.`);
            row.remove(); // Xóa hàng khỏi bảng HTML
        })
        .catch(error => {
            console.error('Error:', error);
            alert(`Delete failed: ${error.message}`);
        });
    }

    const customerId = '';

    function updateRow(button) {
        // Lấy dòng của bảng mà nút "Sửa" được nhấn
        const row = button.closest('tr');
        
        // Lấy dữ liệu từ các ô trong dòng đó
        // customerId = row.cells[0].textContent;
        const tenKH = row.cells[1].textContent;
        const cccd = row.cells[2].textContent;
        const sdt = row.cells[3].textContent;
        const gt = row.cells[4].textContent;
        const ngs = row.cells[5].textContent;
        const qg = row.cells[6].textContent;

        // Điền vào các trường trong form
        document.getElementById('birth').value = ngs;
        document.getElementById('name').value = tenKH;
        document.getElementById('cccd').value = cccd;
        document.getElementById('phone').value = sdt;
        document.getElementById('gender').value = gt;
        // document.getElementById('country').value = ngs;

        const countrySelect = document.getElementById('country');
    // Chọn quốc tịch trong danh sách
        for (let option of countrySelect.options) {
            if (option.value === qg) {
                option.selected = true;
                break;
            }
        }
    }
    

    fetch('https://restcountries.com/v3.1/all')
    .then(response => response.json())
    .then(countries => {
        // Sắp xếp các quốc gia theo tên (theo ABC)
        countries.sort((a, b) => {
            const nameA = a.name.common.toUpperCase(); // Chuyển thành chữ hoa để so sánh không phân biệt chữ hoa chữ thường
            const nameB = b.name.common.toUpperCase();
            if (nameA < nameB) {
                return -1; // nameA đứng trước nameB
            }
            if (nameA > nameB) {
                return 1;  // nameA đứng sau nameB
            }
            return 0; // nameA và nameB bằng nhau
        });

        // Điền các quốc gia đã sắp xếp vào <select> quốc tịch
        const countrySelect = document.getElementById('country');
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.name.common; // Mã quốc gia (tên quốc gia)
            option.textContent = country.name.common; // Tên quốc gia
            countrySelect.appendChild(option); // Thêm vào <select>
        });
    })
    .catch(error => console.error('Lỗi khi lấy dữ liệu quốc gia:', error));


    document.addEventListener('DOMContentLoaded', () => {
        loadCustomers(1);
        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(countries => {
                const countrySelect = document.getElementById('countryInput');
                if (!countrySelect) {
                    console.error('Phần tử với id="countryInput" không tồn tại.');
                    return;
                }
                countries.sort((a, b) => {
                    const nameA = a.name.common.toUpperCase();
                    const nameB = b.name.common.toUpperCase();
                    return nameA.localeCompare(nameB);
                });
    
                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name.common;
                    option.textContent = country.name.common;
                    countrySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Lỗi khi lấy dữ liệu quốc gia:', error));
    });
    