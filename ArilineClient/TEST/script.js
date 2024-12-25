

// Lắng nghe sự kiện nhấp chuột trên các liên kết
document.getElementById("home-link").addEventListener("click", function () {
    window.location.href = "/index.html"; // Đường dẫn đến trang chủ
});

document.getElementById("journey-info-link").addEventListener("click", function () {
    window.location.href = "/Ticket Booking//TCN.html"; // Đường dẫn đến trang thông tin hành trình
});

document.getElementById("signin-link").addEventListener("click", function () {
    window.location.href = "/Sign In/index.html"; // Đường dẫn đến trang đăng nhập
});

document.getElementById("signup-link").addEventListener("click", function () {
    window.location.href = "/Sign Up/index.html"; // Đường dẫn đến trang đăng ký
});


document.querySelector('.dropdown-toggle').addEventListener('click', function () {
    const menu = document.querySelector('.dropdown-menu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.banner-slide');
    const prevButton = document.querySelector('.banner-prev');
    const nextButton = document.querySelector('.banner-next');
    const dotsContainer = document.querySelector('.banner-dots');
    let currentSlide = 0;

    // Create dots
    slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('banner-dot');
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.banner-dot');

    function showSlide(n) {
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function goToSlide(n) {
        showSlide(n);
    }

    prevButton.addEventListener('click', prevSlide);
    nextButton.addEventListener('click', nextSlide);

    // Auto-advance slides every 5 seconds
    setInterval(nextSlide, 5000);

    // Show the first slide
    showSlide(0);
});
function loadContent(page) {
    const mainContent = document.getElementById("mainContent");

    // Kiểm tra xem page có trong templates hay không
    if (templates[page]) {
        mainContent.innerHTML = templates[page]; // Tải nội dung từ templates
    } else {
        mainContent.innerHTML = "<p>Nội dung không tìm thấy!</p>";
    }

    // Cập nhật trạng thái active trên sidebar
    document.querySelectorAll(".sidebar-menu a").forEach(link => {
        link.classList.remove("active");
    });
    document.getElementById(page + "Link").classList.add("active");

    // Nếu là "account", khởi tạo tab
    if (page === "account") {
        initializeTabs();
    }
}
document.addEventListener("DOMContentLoaded", () => {
    // Lấy thông tin từ sessionStorage
    const loggedInUser = sessionStorage.getItem("username");
    const userRole = sessionStorage.getItem("role");

    if (loggedInUser) {
        // Cập nhật dropdown menu với thông tin tài khoản
        const userAccount = document.getElementById("user-account");
        const accountMenu = document.getElementById("account-menu");

        // Hiển thị tên người dùng
        userAccount.textContent = loggedInUser;

        // Cập nhật menu dropdown dựa trên vai trò
        if (userRole === "employee") {
            // Menu cho Nhân viên
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
// Gắn sự kiện click cho từng nút theo ID
document.getElementById("button1").addEventListener("click", function () {
    window.location.href = "../Ticket Booking/bookticket/index.html";
});





