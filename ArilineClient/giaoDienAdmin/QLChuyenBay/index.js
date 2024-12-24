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

    function XemGhe(button) {
        const row = button.closest('tr');
        const fightID = row.cells[0].textContent; // Lấy mã khách hàng từ hàng
        // alert("")
        // Lưu planeID vào localStorage
        localStorage.setItem('fightID', fightID);

        // Chuyển hướng đến GheMayBay.html
        window.location.href = 'GheChuyenBay.html';    
    }

    function XemTG(button) {
        const row = button.closest('tr');
        const fightID = row.cells[0].textContent; // Lấy mã khách hàng từ hàng
        // alert("")
        // Lưu planeID vào localStorage
        localStorage.setItem('fightID', fightID);

        // Chuyển hướng đến GheMayBay.html
        window.location.href = 'TrungGian.html';    
    }