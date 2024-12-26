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