const menuBtn = document.querySelector('.menu-btn');
const sidebar = document.querySelector('.sidebar');
let currentEditingAccountId = null;
menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});
let authToken = null;

document.addEventListener("DOMContentLoaded", function () {
    authToken = localStorage.getItem("auth_token");
    const isLoggedIn = localStorage.getItem("isLoggedIn");

    if (!authToken || !isLoggedIn) {
        alert("Vui lòng đăng nhập trước!");
        window.location.href = "../login.php";
    } else {
        console.log("Token:", authToken);
        loadData(1); // Gọi hàm loadAccounts để lấy danh sách tài khoản
    }
});
function logout() {
    const confirmation = window.confirm("Bạn có chắc chắn muốn đăng xuất?");
    if (confirmation) {
        localStorage.removeItem("isLoggedIn");
        window.location.href = "login.html";
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
    const searchQuery = document.getElementById('searchInput').value || '';

    const url = `http://${serverIp}:${serverPort}/api/tickets?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;

    fetch(url, {
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
            displayData(data);
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

function fetchTotalCount(currentPage, limit) {
    const serverIp = "172.20.10.4";
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
            const totalCount = data.totalCount;
            updatePagination(totalCount, currentPage, limit);
        })
        .catch(error => {
            console.error('Lỗi khi lấy tổng số Vé:', error);
        });
}

function updatePagination(totalCount, currentPage, limit) {
    const pagination = document.querySelector(".pagination");
    pagination.innerHTML = "";
    const totalPages = Math.ceil(totalCount / limit);

    // Nút "Trang đầu"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
            <a class="page-link" href="#" onclick="loadData(1)">Đầu</a>
        </li>
    `;

    // Nút "Trang trước"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
            <a class="page-link" href="#" onclick="loadData(${currentPage - 1})">Trước</a>
        </li>
    `;

    // Các trang
    for (let page = 1; page <= totalPages; page++) {
        pagination.innerHTML += `
            <li class="page-item ${currentPage === page ? "active" : ""}">
                <a class="page-link" href="#" onclick="loadData(${page})">${page}</a>
            </li>
        `;
    }

    // Nút "Trang tiếp theo"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
            <a class="page-link" href="#" onclick="loadData(${currentPage + 1})">Sau</a>
        </li>
    `;

    // Nút "Trang cuối"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
            <a class="page-link" href="#" onclick="loadAccounts(${totalPages})">Cuối</a>
        </li>
    `;
}

function displayData(tickets) {
    const tbody = document.querySelector('table.table tbody');
    tbody.innerHTML = '';

    if (!Array.isArray(tickets) || tickets.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-center">Không có dữ liệu</td></tr>';
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
                    <button class="btn btn-edit btn-sm" onclick="cancelRow(${ticket.ticket_id}, '${ticket.status}')">Hủy</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteRow(${ticket.ticket_id})">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function cancelRow(ticketId, status) {
    // Kiểm tra trạng thái vé
    if (status === "Canceled") {
        alert(`Vé với ID ${ticketId} đã bị hủy trước đó.`);
        return;
    }

    // Xác nhận từ người dùng trước khi thực hiện hủy
    if (!confirm(`Bạn có chắc chắn muốn hủy Vé với ID ${ticketId}?`)) {
        return;
    }

    // Gọi API để hủy vé
    const url = `http://172.20.10.4:8000/api/tickets/${ticketId}`;

    fetch(url, {
        method: 'PUT',
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
            alert(`Hủy vé với ID ${ticketId} thành công!`);
            loadData(1); // Tải lại dữ liệu sau khi hủy
        })
        .catch(error => {
            console.error('Lỗi khi hủy vé:', error);
            alert('Không thể hủy vé. Vui lòng thử lại!');
        });
}


function deleteRow(ticketId) {
    if (!confirm(`Bạn có chắc chắn muốn xóa Vé với ID ${ticketId}?`)) {
        return;
    }

    const url = `http://172.20.10.4:8000/api/tickets/${ticketId}`;

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
            alert(`Xóa vé với ID ${ticketId} thành công!`);
            loadData(1);
        })
        .catch(error => {
            console.error('Lỗi khi xóa vé:', error);
            alert('Không thể xóa vé. Vui lòng thử lại!');
        });
}
function addTicket(event) {
    event.preventDefault();

    const seatId = document.getElementById('seatId').value;
    const promotionId = document.getElementById('promotionId').value;
    const clientId = document.getElementById('clientId').value;
    const luggageId = document.getElementById('luggageId').value;
    const flightId = document.getElementById('flightId').value;
    const ticketIssuanceDate = document.getElementById('ticketIssuanceDate').value;
    const status = document.getElementById('status').value;

    const data = {
        seat_id: seatId,
        promotion_id: promotionId,
        client_id: clientId,
        luggage_id: luggageId,
        flight_id: flightId,
        ticket_issuance_date: ticketIssuanceDate,
        status: status
    };

    const url = `http://172.20.10.4:8000/api/tickets`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
            return response.json();
        })
        .then(() => {
            alert('Thêm vé mới thành công!');
            loadData(1); // Tải lại danh sách vé
            document.getElementById('ticketForm').reset(); // Xóa dữ liệu form
        })
        .catch(error => {
            console.error('Lỗi khi thêm vé:', error);
            alert('Không thể thêm vé. Vui lòng thử lại!');
        });
}

document.getElementById('searchInput').addEventListener('input', () => {
    loadData(1);
});