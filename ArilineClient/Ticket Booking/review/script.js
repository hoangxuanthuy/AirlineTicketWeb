document.addEventListener('DOMContentLoaded', function () {

    // let bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo')) || {};
    let fromAirport = getAirportNameById(bookingInfo.fromAirport);
    let toAirport = getAirportNameById(bookingInfo.toAirport);
    if (bookingInfo) {
        document.getElementById("departure-date-1").textContent = bookingInfo.departureDate; // Updated property
        document.getElementById("departure-airport").textContent =fromAirport + " - " + toAirport;
        document.getElementById("departure-time").textContent = bookingInfo.departure_time;
        document.getElementById("departure-arrival-time").textContent = bookingInfo.arrival_time;
    }
    // Lấy các phần tử cần thiết
    const continueBtn = document.querySelector('.continue-btn');
    const progressSteps = document.querySelectorAll('.progress-step');
    const luggageItems = document.querySelectorAll('.luggage-item');
    const totalPriceElement = document.querySelector('.total-price');

    // Hàm tính toán giá
    function updatePrice() {
        const basePrice = 2480000; // Giá vé cơ bản
        const luggagePrice = 240000; // Giá mỗi kiện hành lý
        const selectedLuggage = document.querySelectorAll('.luggage-item.selected');
        const totalLuggagePrice = selectedLuggage.length * luggagePrice;
        const totalPrice = basePrice + totalLuggagePrice;

        totalPriceElement.textContent = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(totalPrice);
    }

    // Xử lý sự kiện chọn hành lý
    luggageItems.forEach(item => {
        item.addEventListener('click', function () {
            this.classList.toggle('selected'); // Toggle trạng thái chọn
            updatePrice(); // Cập nhật giá
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

    // Hiệu ứng nút loading khi nhấn "Tiếp tục"
    if (continueBtn) {
        continueBtn.addEventListener('click', function () {
            this.textContent = 'Loading...';
            this.disabled = true;
            setTimeout(() => {
                this.textContent = 'Tiếp tục';
                this.disabled = false;
            }, 2000); // Giả lập thời gian xử lý
        });
    }

    // Highlight hành lý khi được chọn
    luggageItems.forEach(item => {
        item.addEventListener('click', function () {
            this.classList.toggle('highlight');

            let bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo')) || {};
            // Set all highlighted luggage to bookingInfo
            bookingInfo.luggage = Array.from(document.querySelectorAll('.luggage-item.highlight')).map(item => {
                return {
                    type: item.querySelector('.luggage-type').textContent,
                    weight: item.querySelector('.luggage-weight').textContent
                };
            });
            sessionStorage.setItem('bookingInfo', JSON.stringify(bookingInfo));
        });
    });

    // Xác nhận thông tin trước khi thanh toán
    function showConfirmation() {
        const formData = JSON.parse(localStorage.getItem('passengerFormData'));
        let confirmationText = '';
        for (const key in formData) {
            confirmationText += `${key}: ${formData[key]}\n`;
        }
        alert(`Thông tin xác nhận:\n${confirmationText}`);
    }

    if (continueBtn) {
        continueBtn.addEventListener('click', showConfirmation);
    }

    // Retrieve booking info from sessionStorage
    const bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo'));
    const userInfo = bookingInfo.userInfo;

    // Populate the passenger form with user info
    const passengerForm = document.getElementById('passengerForm');
    if (passengerForm) {
        passengerForm.querySelector('input[type="text"][name="fullName"]').value = userInfo.fullName;
        passengerForm.querySelector('select[name="gender"]').value = userInfo.gender;
        passengerForm.querySelector('input[type="date"][name="birthDate"]').value = userInfo.birthDate;
        passengerForm.querySelector('input[type="text"][name="cccd"]').value = userInfo.cccd;
        passengerForm.querySelector('input[type="text"][name="nationality"]').value = userInfo.nationality;
        passengerForm.querySelector('input[type="tel"][name="phoneNumber"]').value = userInfo.phoneNumber;
    }

    // Display booking preview
    const previewSection = document.createElement('div');
    previewSection.classList.add('booking-preview');
    previewSection.innerHTML = `
        <h2>Preview Your Booking</h2>
        <p><strong>From:</strong> ${bookingInfo.fromAirport}</p>
        <p><strong>To:</strong> ${bookingInfo.toAirport}</p>
        <p><strong>Departure Date:</strong> ${bookingInfo.departureDate}</p>
        <p><strong>Seat Class:</strong> ${bookingInfo.seatClass}</p>
        <p><strong>Adults:</strong> ${bookingInfo.adults}</p>
        <p><strong>Children:</strong> ${bookingInfo.children}</p>
        <p><strong>Seat Numbers:</strong> ${bookingInfo.seatNumbers.join(', ')}</p>
        <p><strong>Luggage:</strong> ${bookingInfo.luggage.map(l => `${l.type} (${l.weight})`).join(', ')}</p>
    `;
    document.querySelector('.main-content').appendChild(previewSection);
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
document.getElementById("continue-btn1").addEventListener("click", function () {
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
