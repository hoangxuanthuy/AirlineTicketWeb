// Biến toàn cục để lưu token và ID tài khoản đang chỉnh sửa
let authToken = null;
let currentEditingAccountId = null;

// Lấy token từ localStorage khi trang được tải
document.addEventListener("DOMContentLoaded", function () {
    authToken = localStorage.getItem("auth_token");
    const isLoggedIn = localStorage.getItem("isLoggedIn");

    if (!authToken || !isLoggedIn) {
        alert("Vui lòng đăng nhập trước!");
        window.location.href = "../login.php";
    } else {
        console.log("Token:", authToken);
        loadAccounts(1); // Gọi hàm loadAccounts để lấy danh sách tài khoản
    }
});

// Toggle Sidebar
const menuBtn = document.querySelector(".menu-btn");
const sidebar = document.querySelector(".sidebar");
menuBtn.addEventListener("click", () => {
    sidebar.classList.toggle("active");
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

// Load danh sách tài khoản từ API
function loadAccounts(currentPage = 1) {
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }
    document.getElementById("password").disabled = false;
    document.getElementById("role").disabled = false;

    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const limit = 5;
    const offset = (currentPage - 1) * limit;
    const searchQuery = document.getElementById("searchInput").value || "";
    const url = `http://${serverIp}:${serverPort}/api/accounts?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`;
    fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${authToken}`,
        },
    })
        .then(response => {
            console.log('HTTP Response Status:', response.status);
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
            return response.json();
        })
        .then((data) => {
            displayAccounts(data);

            // Cập nhật phân trang
            if (data.length < limit && currentPage === 1) {
                updatePagination(data.length, currentPage, limit);
            } else {
                fetchTotalCount(currentPage, limit);
            }
        })
        .catch((error) => {
            console.error("Lỗi khi tải danh sách tài khoản:", error);
            alert("Không thể tải danh sách tài khoản. Vui lòng thử lại!");
        });
}

// Hàm lấy tổng số dòng từ API
function fetchTotalCount(currentPage, limit) {
    const serverIp = "172.20.10.4";
    const serverPort = "8000";
    const countUrl = `http://${serverIp}:${serverPort}/api/accounts/count`;

    fetch(countUrl, {
        method: "GET",
        headers: {
            Authorization: `Bearer ${authToken}`,
        },
    })
        .then((response) => {
            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
            return response.json();
        })
        .then((data) => {
            const totalCount = data.totalCount;
            updatePagination(totalCount, currentPage, limit);
        })
        .catch((error) => {
            console.error("Lỗi khi lấy tổng số tài khoản:", error);
        });
}

// Cập nhật phân trang
function updatePagination(totalCount, currentPage, limit) {
    const pagination = document.querySelector(".pagination");
    pagination.innerHTML = "";
    const totalPages = Math.ceil(totalCount / limit);

    // Nút "Trang đầu"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
            <a class="page-link" href="#" onclick="loadAccounts(1)">Đầu</a>
        </li>
    `;

    // Nút "Trang trước"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
            <a class="page-link" href="#" onclick="loadAccounts(${currentPage - 1})">Trước</a>
        </li>
    `;

    // Các trang
    for (let page = 1; page <= totalPages; page++) {
        pagination.innerHTML += `
            <li class="page-item ${currentPage === page ? "active" : ""}">
                <a class="page-link" href="#" onclick="loadAccounts(${page})">${page}</a>
            </li>
        `;
    }

    // Nút "Trang tiếp theo"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
            <a class="page-link" href="#" onclick="loadAccounts(${currentPage + 1})">Sau</a>
        </li>
    `;

    // Nút "Trang cuối"
    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
            <a class="page-link" href="#" onclick="loadAccounts(${totalPages})">Cuối</a>
        </li>
    `;
}

// Hiển thị danh sách tài khoản
function displayAccounts(accounts) {
    const tbody = document.querySelector("table tbody");
    tbody.innerHTML = "";

    if (accounts.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có tài khoản nào</td></tr>';
        return;
    }

    accounts.forEach((account) => {
        const row = `
            <tr>
                <td>${account.account_id}</td>
                <td>${account.email}</td>
                <td>${account.account_name}</td>
                <td>${account.citizen_id}</td>
                <td>${account.phone}</td>
                <td>${account.role_name}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editAccount(this, '${account.account_id}')">Sửa</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteAccount(${account.account_id})">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

// Thêm tài khoản
function addAccount(event) {
    event.preventDefault();

    // Lấy dữ liệu từ form
    const role = document.getElementById("role").value.trim();
    let role_id;

    // Xác định role_id dựa trên role
    if (role === "Customer") {
        role_id = 4;
    } else if (role === "Staff") {
        role_id = 3;
    } else {
        alert("Role chỉ có thể là 'Customer' hoặc 'Staff'. Vui lòng nhập lại lại!");
        return;
    }

    // Chuẩn bị dữ liệu gửi đến API
    const formData = {
        email: document.getElementById("email").value.trim(),
        password: document.getElementById("password").value.trim(),
        account_name: document.getElementById("accountName").value.trim(),
        citizen_id: document.getElementById("cccd").value.trim(),
        phone: document.getElementById("phone").value.trim(),
        role_id: role_id, // Sử dụng role_id đã xác định
    };

    // Gửi request đến API
    fetch("http://172.20.10.4:8000/api/accounts", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${authToken}`,
        },
        body: JSON.stringify(formData),
    })
        .then((response) => {
            if (!response.ok) throw new Error("Failed to add account");
            return response.json();
        })
        .then(() => {
            alert("Thêm tài khoản thành công!");
            clearForm(); // Xóa form sau khi thêm thành công
            loadAccounts(1); // Tải lại danh sách tài khoản
        })
        .catch((error) => {
            console.error("Lỗi khi thêm tài khoản:", error);
            alert("Không thể thêm tài khoản. Vui lòng thử lại!");
        });
}


// Xóa tài khoản
function deleteAccount(accountId) {
    if (!confirm("Bạn có chắc chắn muốn xóa tài khoản này?")) return;

    fetch(`http://172.20.10.4:8000/api/accounts/${accountId}`, {
        method: "DELETE",
        headers: {
            Authorization: `Bearer ${authToken}`,
        },
    })
        .then((response) => {
            if (!response.ok) throw new Error("Failed to delete account");
            alert("Xóa tài khoản thành công!");
            loadAccounts(1);
        })
        .catch((error) => {
            console.error("Lỗi khi xóa tài khoản:", error);
            alert("Không thể xóa tài khoản. Vui lòng thử lại!");
        });
}

function editAccount(button, accountId) {
    // Lấy hàng hiện tại từ nút "Sửa"
    const row = button.closest("tr");

    // Lấy giá trị từ các ô trong hàng
    const email = row.cells[1].textContent.trim();
    const accountName = row.cells[2].textContent.trim();
    const cccd = row.cells[3].textContent.trim();
    const phone = row.cells[4].textContent.trim();
    const role = row.cells[5].textContent.trim();

    // Điền thông tin vào form
    document.getElementById("email").value = email;
    document.getElementById("password").value = ""; // Không hiển thị mật khẩu
    document.getElementById("accountName").value = accountName;
    document.getElementById("cccd").value = cccd;
    document.getElementById("phone").value = phone;
    document.getElementById("role").value = role;

    // Vô hiệu hóa các trường `password` và `role`
    document.getElementById("password").disabled = true;
    document.getElementById("role").disabled = true;

    // Lưu giá trị gốc vào dataset
    document.getElementById("password").dataset.original = "";
    document.getElementById("role").dataset.original = role;

    // Gán `accountId` vào biến toàn cục
    window.currentEditingAccountId = accountId;

    console.log(`Editing Account ID: ${accountId}`);
}


// Cập nhật tài khoản
function updateAccount(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của form

    // Kiểm tra xem có tài khoản nào đang được chỉnh sửa không
    if (!window.currentEditingAccountId) {
        alert("Vui lòng chọn tài khoản để sửa!");
        return;
    }
    const originalPassword = document.getElementById("password").dataset.original || "";
    const originalRole = document.getElementById("role").dataset.original || "";
    // Thu thập dữ liệu từ form
    const updatedData = {
        email: document.getElementById("email").value.trim(),
        account_name: document.getElementById("accountName").value.trim(),
        citizen_id: document.getElementById("cccd").value.trim(),
        phone: document.getElementById("phone").value.trim(),
    };
    const newPassword = document.getElementById("password").value.trim();
    const newRole = document.getElementById("role").value.trim();

    // Kiểm tra nếu người dùng cố thay đổi password hoặc role
    if (newPassword !== "" || newRole !== originalRole) {
        alert("Bạn không được phép thay đổi mật khẩu hoặc vai trò!");
        return;
    }
    // Kiểm tra dữ liệu hợp lệ
    if (!updatedData.email || !updatedData.account_name || !updatedData.citizen_id || !updatedData.phone ) {
        alert("Vui lòng điền đầy đủ thông tin trước khi sửa!");
        return;
    }

    // Gửi request cập nhật tới API
    fetch(`http://172.20.10.4:8000/api/accounts/${window.currentEditingAccountId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${authToken}`,
        },
        body: JSON.stringify(updatedData),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Failed to update account");
            }
            return response.json();
        })
        .then(() => {
            alert("Cập nhật tài khoản thành công!");
            clearForm(); // Xóa thông tin form sau khi sửa thành công
            loadAccounts(1); // Tải lại danh sách tài khoản
        })
        .catch((error) => {
            console.error("Lỗi khi cập nhật tài khoản:", error);
            alert("Không thể cập nhật tài khoản. Vui lòng thử lại!");
        });
}


// Tìm kiếm tài khoản
document.getElementById("searchInput").addEventListener("input", () => {
    loadAccounts(1);
});
function clearForm() {
    // Xóa nội dung trong các trường input
    document.getElementById("email").value = "";
    document.getElementById("password").value = "";
    document.getElementById("accountName").value = "";
    document.getElementById("cccd").value = "";
    document.getElementById("phone").value = "";
    document.getElementById("role").value = "";

    // Đặt lại biến toàn cục lưu ID tài khoản đang chỉnh sửa
    window.currentEditingAccountId = null;

}