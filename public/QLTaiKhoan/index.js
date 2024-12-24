// Biến toàn cục để lưu token
let authToken = null;

// Xử lý DOMContentLoaded
document.addEventListener("DOMContentLoaded", () => {
    authToken = localStorage.getItem("auth_token");
    const isLoggedIn = localStorage.getItem("isLoggedIn");

    if (!authToken || !isLoggedIn) {
        alert("Vui lòng đăng nhập trước!");
        window.location.href = "../login.php";
    } else {
        loadAccounts(1);
    }
});

// Đăng xuất
function logout() {
    if (confirm("Bạn có chắc chắn muốn đăng xuất?")) {
        localStorage.clear();
        window.location.href = "../login.php";
    }
}

// Load danh sách tài khoản
function loadAccounts(currentPage = 1) {
    const limit = 5;
    const offset = (currentPage - 1) * limit;
    const searchQuery = document.getElementById("searchInput").value || "";

    fetch(`http://192.168.60.5:8000/api/accounts?limit=${limit}&offset=${offset}&search=${encodeURIComponent(searchQuery)}`, {
        method: "GET",
        headers: {
            "Authorization": `Bearer ${authToken}`
        }
    })
        .then((response) => response.json())
        .then((data) => {
            displayAccounts(data.accounts || []);
        })
        .catch((error) => {
            console.error("Lỗi khi tải danh sách tài khoản:", error);
        });
}

// Hiển thị danh sách tài khoản
function displayAccounts(accounts) {
    const tbody = document.querySelector("table tbody");
    tbody.innerHTML = "";

    if (accounts.length === 0) {
        tbody.innerHTML = "<tr><td colspan='8' class='text-center'>Không có tài khoản nào</td></tr>";
        return;
    }

    accounts.forEach((account) => {
        const row = `
            <tr>
                <td>${account.id}</td>
                <td>${account.email}</td>
                <td>${account.password}</td>
                <td>${account.account_name}</td>
                <td>${account.citizen_id}</td>
                <td>${account.phone}</td>
                <td>${account.role}</td>
                <td>
                    <button class="btn btn-edit btn-sm" onclick="editRow(${account.id})">Sửa</button>
                    <button class="btn btn-delete btn-sm" onclick="deleteAccount(${account.id})">Xóa</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

// Thêm tài khoản
function addAccount(event) {
    event.preventDefault();

    const formData = {
        email: document.getElementById("email").value.trim(),
        password: document.getElementById("password").value.trim(),
        account_name: document.getElementById("accountName").value.trim(),
        citizen_id: document.getElementById("cccd").value.trim(),
        phone: document.getElementById("phone").value.trim(),
        role: document.getElementById("role").value.trim(),
    };

    fetch("http://192.168.60.5:8000/api/accounts", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${authToken}`,
        },
        body: JSON.stringify(formData),
    })
        .then((response) => response.json())
        .then(() => {
            alert("Thêm tài khoản thành công!");
            loadAccounts(1);
        })
        .catch((error) => {
            console.error("Lỗi khi thêm tài khoản:", error);
        });
}

// Xóa tài khoản
function deleteAccount(accountId) {
    if (confirm("Bạn có chắc chắn muốn xóa tài khoản này?")) {
        fetch(`http://192.168.60.5:8000/api/accounts/${accountId}`, {
            method: "DELETE",
            headers: {
                "Authorization": `Bearer ${authToken}`,
            },
        })
            .then(() => {
                alert("Xóa tài khoản thành công!");
                loadAccounts(1);
            })
            .catch((error) => {
                console.error("Lỗi khi xóa tài khoản:", error);
            });
    }
}

// Sửa tài khoản
function editRow(accountId) {
    // Xử lý logic edit tài khoản
}

// Thêm sự kiện tìm kiếm
document.getElementById("searchInput").addEventListener("input", () => {
    loadAccounts(1);
});
