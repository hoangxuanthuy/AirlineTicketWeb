document.addEventListener('DOMContentLoaded', function () {
    // Lấy các phần tử cần thiết
    const continueBtn = document.querySelector('.continue-button'); // Nút "Tiếp tục"
    const progressSteps = document.querySelectorAll('.progress-step'); // Các bước trên thanh tiến trình

    // Hàm xác thực dữ liệu biểu mẫu
    function validateForm() {
        const requiredFields = document.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('error'); // Thêm class để đánh dấu lỗi
            } else {
                field.classList.remove('error'); // Xóa class lỗi nếu đã nhập đúng
            }
        });

        if (!isValid) {
            alert('Vui lòng điền đầy đủ thông tin trước khi tiếp tục.');
        }

        return isValid;
    }

    // Hàm lưu dữ liệu biểu mẫu vào localStorage
    function saveFormData() {
        const formData = {};
        const fields = document.querySelectorAll('input, select');
        fields.forEach(field => {
            formData[field.name] = field.value;
        });

        localStorage.setItem('formData', JSON.stringify(formData));
    }

    // Hàm tải dữ liệu biểu mẫu từ localStorage
    function loadFormData() {
        const formData = JSON.parse(localStorage.getItem('formData') || '{}');
        const fields = document.querySelectorAll('input, select');
        fields.forEach(field => {
            if (formData[field.name]) {
                field.value = formData[field.name];
            }
        });
    }

    // Gọi hàm loadFormData khi trang được tải
    loadFormData();

    // Xử lý sự kiện khi nhấn nút "Tiếp tục"
    if (continueBtn) {
        continueBtn.addEventListener('click', function (e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định

            if (validateForm()) {
                saveFormData();
                const confirmation = confirm('Bạn có chắc chắn muốn tiếp tục?');
                if (confirmation) {
                    window.location.href = "../review/index.html"; // Thay bằng đường dẫn trang thực tế
                }
            }
        });
    }

    // Xử lý sự kiện khi nhấn vào các bước trên thanh tiến trình
    progressSteps.forEach((step, index) => {
        step.addEventListener('click', function (e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định

            // Đánh dấu bước hiện tại
            progressSteps.forEach((s, i) => {
                s.classList.remove('active');
                if (i <= index) {
                    s.classList.add('active'); // Bật class "active" cho bước hiện tại và các bước trước đó
                }
            });

            // Điều hướng tới trang tương ứng
            if (index === 0) {
                window.location.href = "../information/index.html"; // Điền thông tin
            } else if (index === 1) {
                window.location.href = "../Seat/index.html"; // Chọn chỗ ngồi
            } else if (index === 2) {
                window.location.href = "../review/index.html"; // Xem lại
            } else if (index === 3) {
                window.location.href = "../Pay/index.html"; // Thanh toán
            }
        });
    });

    // Hiệu ứng chọn ghế
    const seats = document.querySelectorAll('.seat'); // Lấy danh sách các ghế

    seats.forEach(seat => {
        seat.addEventListener('click', function () {
            // Toggle trạng thái chọn ghế
            this.classList.toggle('selected');
            updateSelectedSeats();
        });
    });

    function updateSelectedSeats() {
        const selectedSeats = document.querySelectorAll('.seat.selected');
        const seatNumbers = Array.from(selectedSeats).map(seat => seat.textContent);
        console.log('Ghế đã chọn:', seatNumbers); // Hiển thị ghế đã chọn (có thể lưu vào cơ sở dữ liệu hoặc hiển thị trên giao diện)
    }

    // Kiểm tra số điện thoại
    const phoneInput = document.querySelector('input[type="tel"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, ''); // Chỉ cho phép nhập số
        });
    }

    // Kiểm tra CCCD
    const cccdInput = document.querySelector('input[name="cccd"]');
    if (cccdInput) {
        cccdInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, ''); // Chỉ cho phép nhập số
        });
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
document.getElementById("continue-btn2").addEventListener("click", function () {
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
