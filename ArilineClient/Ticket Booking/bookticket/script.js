// Gắn sự kiện click cho từng nút theo ID
document.getElementById("select-flight-1").addEventListener("click", function () {
    window.location.href = "../information/index.html";
});

document.getElementById("select-flight-2").addEventListener("click", function () {
    window.location.href = "/TCN/TCN.html?flight=2";
});

// // Removed DOMContentLoaded wrapper
// const dropdown = document.querySelector(".dropdown-toggle");
// const dropdownMenu = document.querySelector(".dropdown-menu");

// dropdown.addEventListener("click", (e) => {
//     e.preventDefault();
//     // Toggle dropdown menu
//     dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
// });

// // Đóng menu khi click bên ngoài
// document.addEventListener("click", (e) => {
//     if (!dropdown.contains(e.target)) {
//         dropdownMenu.style.display = "none";
//     }
// });

// document.querySelector('.menu-toggle').addEventListener('click', () => {
//     document.querySelector('.nav-menu').classList.toggle('show');
// });

// Pagination Logic
const flightCards = document.querySelectorAll(".flight-card");
const prevBtn = document.querySelector(".prev-btn");
const nextBtn = document.querySelector(".next-btn");
const pageInfo = document.querySelector(".page-info");
const flightsPerPage = 10;
let currentPage = 1;
const totalPages = Math.ceil(flightCards.length / flightsPerPage);

function showPage(page) {
    flightCards.forEach((card, index) => {
        if (index >= (page - 1) * flightsPerPage && index < page * flightsPerPage) {
            card.style.display = "grid";
        } else {
            card.style.display = "none";
        }
    });
    pageInfo.textContent = `Page ${page} of ${totalPages}`;
    prevBtn.disabled = page === 1;
    nextBtn.disabled = page === totalPages;
}

prevBtn.addEventListener("click", () => {
    console.log("Previous button clicked");
    if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
    }
});

nextBtn.addEventListener("click", () => {
    console.log("Next button clicked");
    if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
    }
});

document.getElementById("select-flight-1").addEventListener("click", function () {
    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!sessionStorage.getItem("username")) {
        // Nếu chưa đăng nhập, chuyển hướng tới trang đăng nhập
        alert("Vui lòng đăng nhập trước khi chọn chuyến bay.");
        window.location.href = "../../Sign In/index.html"; // Đường dẫn tới trang Sign In
    } else {
        // Nếu đã đăng nhập, chuyển tới trang thông tin
        window.location.href = "../information/index.html"; // Đường dẫn tới trang thông tin
    }
});
document.addEventListener("DOMContentLoaded", () => {
    // Lấy thông tin từ sessionStorage
   
    const loggedInUser = sessionStorage.getItem("username");
    const userRole = sessionStorage.getItem("role");
 console.log(loggedInUser);
    if (loggedInUser) {
        // Cập nhật dropdown menu với thông tin tài khoản
  
        const userAccount = document.getElementById("user-account");
        const accountMenu = document.getElementById("account-menu");

        // Hiển thị tên người dùng
       
        userAccount.textContent = loggedInUser;
       
        // Cập nhật menu dropdown dựa trên vai trò
        if (userRole == "employee") {
            // Menu cho Nhân viên
            console.log("thuy")
            accountMenu.innerHTML = `
            <li><a href="../TCN_NhanVien/Taikhoan.html">Tài khoản</a></li>
            <li><a href="../TCN_NhanVien/Phieudat.html">Xử lý phiếu đặt</a></li>
            <li><a href="../TCN_NhanVien/Xulyve.html">Xử lý vé</a></li>
            <li><a href="../TCN_NhanVien/Xulytt.html">Xử lý thông tin KH</a></li>
            <li><a href="#" id="logout-link">Đăng xuất</a></li>
        `;
        
        } else if (userRole === "director") {
            // Menu cho Giám đốc
            accountMenu.innerHTML = `
                <li><a href="http://127.0.0.1:5502/ArilineClient/TCN/TCN_Lichsu.html">Tài khoản</a></li>
                <li><a href="#">Quản lý báo cáo</a></li>
                <li><a href="#">Xem thống kê</a></li>
                <li><a href="#">Quản lý nhân viên</a></li>
                <li><a href="#" id="logout-link">Đăng xuất</a></li>
            `;
        } else {
            // Menu cho Người dùng thông thường
            accountMenu.innerHTML = `
                <li><a href="http://127.0.0.1:5502/ArilineClient/TCN/TCN_Lichsu.html">Tài khoản</a></li>
                <li><a href="#" id="logout-link">Đăng xuất</a></li>
            `;
        }

        // Gắn sự kiện cho "Đăng xuất"
        document.getElementById("logout-link").addEventListener("click", (e) => {
            e.preventDefault();
            // Xóa thông tin đăng nhập khỏi sessionStorage
            sessionStorage.removeItem("username");
            sessionStorage.removeItem("role");
           
            // Tải lại trang để làm mới giao diện
            location.reload();
        });
    }
});

