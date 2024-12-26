document.addEventListener('DOMContentLoaded', function () {
    // Lấy các phần tử cần thiết
    const continueBtn = document.querySelector('.continue-btn');
    const progressSteps = document.querySelectorAll('.progress-step');
    const luggageItems = document.querySelectorAll('.luggage-item');
    const totalPriceElement = document.querySelector('.total-price');
    const promoCodeInput = document.getElementById('promoCode');
    const zaloPayButton = document.querySelector('.zalopay-button');

    // Giá cơ bản và khuyến mãi
    const basePrice = 2960000; // Giá cơ bản tổng cộng
    let finalAmount = basePrice;

    // Hàm tính toán giá
    function updatePrice(discount = 0) {
        finalAmount = basePrice - discount;
        totalPriceElement.textContent = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(finalAmount);
    }

    // Xử lý sự kiện nhập mã khuyến mãi
    promoCodeInput.addEventListener('input', function () {
        const promoCode = this.value.trim().toUpperCase();

        if (promoCode === 'DISCOUNT10') {
            updatePrice(basePrice * 0.1); // Giảm giá 10%
        } else {
            updatePrice(0); // Không giảm giá
        }
    });

    // Xử lý sự kiện chọn hành lý
    luggageItems.forEach(item => {
        item.addEventListener('click', function () {
            this.classList.toggle('selected'); // Toggle trạng thái chọn
            updatePrice(); // Cập nhật giá (nếu có logic liên quan đến hành lý)
        });
    });

    // Hàm xác thực dữ liệu
    function validateForm() {
        const requiredFields = document.querySelectorAll('#passengerForm [required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        });

        if (!isValid) {
            alert('Vui lòng điền đầy đủ thông tin trước khi tiếp tục.');
        }

        return isValid;
    }

    // Lưu dữ liệu biểu mẫu tạm thời vào LocalStorage
    function saveFormData() {
        const formData = {};
        document.querySelectorAll('#passengerForm input, #passengerForm select').forEach(field => {
            formData[field.name] = field.value;
        });
        localStorage.setItem('passengerFormData', JSON.stringify(formData));
    }

    // Tải dữ liệu biểu mẫu từ LocalStorage
    function loadFormData() {
        const savedData = JSON.parse(localStorage.getItem('passengerFormData'));
        if (savedData) {
            document.querySelectorAll('#passengerForm input, #passengerForm select').forEach(field => {
                if (savedData[field.name]) {
                    field.value = savedData[field.name];
                }
            });
        }
    }

    loadFormData(); // Tải dữ liệu khi trang được tải

    // Xử lý sự kiện khi nhấn nút "Tiếp tục"
    if (continueBtn) {
        continueBtn.addEventListener('click', function (e) {
            e.preventDefault();

            if (validateForm()) {
                saveFormData();
                const confirmation = confirm('Bạn có chắc chắn muốn tiếp tục?');
                if (confirmation) {
                    window.location.href = "../Pay/index.html"; // Thay bằng đường dẫn trang tiếp theo
                }
            }
        });
    }

    // Xử lý sự kiện nhấn trên thanh tiến trình
    progressSteps.forEach((step, index) => {
        step.addEventListener('click', function (e) {
            e.preventDefault();

            // Đánh dấu bước hiện tại
            progressSteps.forEach((s, i) => {
                s.classList.remove('active');
                if (i <= index) {
                    s.classList.add('active');
                }
            });

            // Điều hướng tới trang tương ứng
            const pages = [
                "../information/index.html", // Điền thông tin
                "../Seat/index.html", // Chọn chỗ ngồi
                "../review/index.html",      // Xem lại
                "../Pay/index.html"         // Thanh toán
            ];

            if (index < pages.length) {
                window.location.href = pages[index];
            }
        });
    });

    // Hiển thị thông tin chuyến bay từ LocalStorage
    function displayFlightInfo() {
        const flightInfo = JSON.parse(localStorage.getItem('selectedFlight'));
        if (flightInfo) {
            document.querySelector('.flight-route .airport').textContent = `${flightInfo.departure} - ${flightInfo.destination}`;
            document.querySelector('.flight-route .time').textContent = flightInfo.time;
        }
    }

    displayFlightInfo(); // Hiển thị thông tin chuyến bay

    // Xử lý sự kiện nhấn nút ZaloPay
    if (zaloPayButton) {
        zaloPayButton.addEventListener('click', function () {
            alert('Payment successful! Redirecting to home page...');
            window.location.href = "../../TEST/index.html"; // Navigate to TEST/index.html
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Lấy tất cả các bước trong thanh tiến trình
    const progressSteps = document.querySelectorAll(".progress-step");

    // Thêm sự kiện "click" cho từng bước
    progressSteps.forEach((step) => {
        step.addEventListener("click", function (e) {
            e.preventDefault(); // Ngăn hành động mặc định của liên kết

            // Bỏ class "active" của tất cả các bước
            progressSteps.forEach((item) => {
                item.classList.remove("active");
            });

            // Thêm class "active" cho bước được nhấn
            this.classList.add("active");
        });
    });
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


