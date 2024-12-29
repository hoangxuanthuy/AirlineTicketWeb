
document.addEventListener('DOMContentLoaded', async function () {
    // Xác minh biểu mẫu
    const passengerForm = document.getElementById('passengerForm');
    const continueBtn = document.querySelector('.continue-btn');
    const progressSteps = document.querySelectorAll('.progress-step');
    let bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo')) || {};
    let fromAirport = bookingInfo.startAdress; ;
    let toAirport = bookingInfo.endAdress;
    if (bookingInfo) {
        document.getElementById("departure-date-1").textContent = bookingInfo.departureDate; // Updated property
        document.getElementById("departure-airport").textContent =fromAirport + " - " + toAirport;
        document.getElementById("departure-time").textContent = bookingInfo.departure_time;
        document.getElementById("departure-arrival-time").textContent = bookingInfo.arrival_time;
    }

    



UpdateSearchFormData()

    // Hành động nút với điều hướng
    continueBtn.addEventListener('click', function (e) {
        e.preventDefault();

        // Kiểm tra xem tất cả các trường bắt buộc đã được điền chưa
        const requiredFields = passengerForm.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('error'); // Đánh dấu trường lỗi
            } else {
                field.classList.remove('error'); // Loại bỏ trạng thái lỗi
            }
        });

        if (isValid) {
            // Chuyển hướng đến trang tiếp theo
            let bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo')) || {};
            let userInfo = {
                fullName: document.getElementById('fullName').value,
                gender: document.getElementById('gender').value,
                birthDate: document.getElementById('birthDate').value,
                cccd: document.getElementById('cccd').value,
                nationality: document.getElementById('nationality').value,
                phoneNumber: document.getElementById('phoneNumber').value
            };
            
            bookingInfo.userInfo = userInfo;

            sessionStorage.setItem('bookingInfo', JSON.stringify(bookingInfo));

            window.location.href = "../Seat/index.php"; // Thay thế bằng URL thực tế của trang tiếp theo
        } else {
            alert('Vui lòng điền đầy đủ thông tin!');
        }
    });

    // Thêm sự kiện click cho các bước trong thanh tiến trình
    progressSteps.forEach((step, index) => {
        step.addEventListener('click', function (e) {
            e.preventDefault();

            if (index === 1) {
                window.location.href = "../Seat/index.php"; // Thay thế bằng URL của trang "Chọn chỗ ngồi"
            } else if (index === 2) {
                window.location.href = "../review/index.php"; // Thay thế bằng URL của trang "Xem lại"
            } else if (index === 3) {
                window.location.href = "../Pay/index.php"; // Thay thế bằng URL của trang "Thanh toán"
            }
        });
    });

    // Xử lý lỗi khi nhập dữ liệu không hợp lệ
    passengerForm.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('invalid', function (e) {
            e.preventDefault();
            this.classList.add('error'); // Đánh dấu trường lỗi
        });

        input.addEventListener('input', function () {
            if (this.value) {
                this.classList.remove('error'); // Loại bỏ trạng thái lỗi khi nhập dữ liệu đúng
            }
        });
    });

    // Xác minh số điện thoại
    const phoneInput = passengerForm.querySelector('input[type="tel"]');
    phoneInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, ''); // Chỉ cho phép nhập số
    });

    // Xác minh CCCD (chỉ cho phép số)
    const cccdInput = passengerForm.querySelector('input[name="cccd"]');
    if (cccdInput) {
        cccdInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, ''); // Chỉ cho phép nhập số
        });
    }

    // Xác minh ngày tháng
    const dateInputs = passengerForm.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.addEventListener('input', function () {
            const selectedDate = new Date(this.value);
            const today = new Date();

            if (selectedDate > today) {
                this.classList.add('error'); // Đánh dấu ngày không hợp lệ
                alert('Ngày không hợp lệ');
                this.value = ''; // Xóa giá trị không hợp lệ
            }
        });
    });

    // Retrieve and display selected flight data
  
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
            <li><a href="../TCN_NhanVien/Taikhoan.php">Tài khoản</a></li>
            <li><a href="../TCN_NhanVien/Phieudat.php">Xử lý phiếu đặt</a></li>
            <li><a href="../TCN_NhanVien/Xulyve.php">Xử lý vé</a></li>
            <li><a href="../TCN_NhanVien/Xulytt.php">Xử lý thông tin KH</a></li>
            <li><a href="#" id="logout-link">Đăng xuất</a></li>
        `;

        } else if (userRole === "director") {
            // Menu cho Giám đốc
            accountMenu.innerHTML = `
                <li><a href="http://172.20.10.4:8000/TCN/TCN_Lichsu.php">Tài khoản</a></li>
                <li><a href="#">Quản lý báo cáo</a></li>
                <li><a href="#">Xem thống kê</a></li>
                <li><a href="#">Quản lý nhân viên</a></li>
                <li><a href="#" id="logout-link">Đăng xuất</a></li>
            `;
        } else {
            // Menu cho Người dùng thông thường
            accountMenu.innerHTML = `
                <li><a href="http://172.20.10.4:8000/TCN/TCN_Lichsu.php">Tài khoản</a></li>
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
document.getElementById("continue-btn").addEventListener("click", function () {
    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!sessionStorage.getItem("username")) {
        // Nếu chưa đăng nhập, chuyển hướng tới trang đăng nhập
        alert("Vui lòng đăng nhập trước khi chọn chuyến bay.");
        window.location.href = "../../Sign In/index.php"; // Đường dẫn tới trang Sign In
    } else {
        // Nếu đã đăng nhập, chuyển tới trang thông tin
        window.location.href = "../information/index.php"; // Đường dẫn tới trang thông tin
    }
});


//get from local storage
async function UpdateSearchFormData() 
{

     loadAirports();
    loadSeatClasses();
    updateUserAccountInfo();
}

function updateUserAccountInfo() {
    const loggedInUser = sessionStorage.getItem("username");
    const userRole = sessionStorage.getItem("role");

    if (loggedInUser) {
        const userAccount = document.getElementById("user-account");
        const accountMenu = document.getElementById("account-menu");

        userAccount.textContent = loggedInUser;

        if (userRole === "employee") {
            accountMenu.innerHTML = `
                <li><a href="../TCN_NhanVien/Taikhoan.php">Tài khoản</a></li>
                <li><a href="../TCN_NhanVien/Phieudat.php">Xử lý phiếu đặt</a></li>
                <li><a href="../TCN_NhanVien/Xulyve.php">Xử lý vé</a></li>
                <li><a href="../TCN_NhanVien/Xulytt.php">Xử lý thông tin KH</a></li>
                <li><a href="#" id="logout-link">Đăng xuất</a></li>
            `;
        } else if (userRole === "director") {
            accountMenu.innerHTML = `
                <li><a href="http://172.20.10.4:8000/TCN/TCN_Lichsu.php">Tài khoản</a></li>
                <li><a href="#">Quản lý báo cáo</a></li>
                <li><a href="#">Xem thống kê</a></li>
                <li><a href="#">Quản lý nhân viên</a></li>
                <li><a href="#" id="logout-link">Đăng xuất</a></li>
            `;
        } else {
            accountMenu.innerHTML = `
                <li><a href="http://172.20.10.4:8000/TCN/TCN_Lichsu.php">Tài khoản</a></li>
                <li><a href="#" id="logout-link">Đăng xuất</a></li>
            `;
        }

        document.getElementById("logout-link").addEventListener("click", (e) => {
            e.preventDefault();
            sessionStorage.removeItem("username");
            sessionStorage.removeItem("role");
            location.reload();
        });
    }
}

// Modify fetchAirportName to use window.airportsCache
function fetchAirportName(airportId) {   
    airportId = parseInt(airportId);
    return window.airportsCache[airportId] || "Unknown Airport";
}

// Remove or comment out the duplicate loadAirports function
// function loadAirports() {
//     // ...existing code...
// }

function loadAirports(currentPage = 1) {
    console.log('Loading airports...');
    let authToken = sessionStorage.getItem('auth_token');
    console.log(authToken);
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    // Load theo mã sân bay
    const url = `http://${serverIp}:${serverPort}/api/airports`;

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        console.log(response);
        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
        return response.json();
    })
    .then(data => {
        const fromSelect = document.getElementById('from-airport');
        fromSelect.innerHTML = ''; // Clear existing options
        data.forEach(airport => {
            const option = document.createElement('option');
            option.value = airport.airport_id;
            option.textContent = `${airport.airport_name} - (${airport.address})`;
            fromSelect.appendChild(option);
        });
        let bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo')) || {};
fromSelect.value = bookingInfo.fromAirport || data[0].airport_id;
        const toSelect = document.getElementById('to-airport');
        toSelect.innerHTML = ''; // Clear existing options
        data.forEach(airport => {
            const option = document.createElement('option');
            option.value = airport.airport_id;
            option.textContent = `${airport.airport_name} - (${airport.address})`;
            toSelect.appendChild(option);
        });

        toSelect.value = bookingInfo.toAirport || data[0].airport_id;
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu Sân bay:', error);
        alert('Không thể tải dữ liệu Sân bay. Vui lòng thử lại!');
    });
}

function loadSeatClasses() {
    let authToken = sessionStorage.getItem('auth_token');
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    const url = `http://${serverIp}:${serverPort}/api/seatclass`;

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        console.log(response);
        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
        return response.json();
    })
    .then(data => {
        const seatClassSelect = document.getElementById('seat-class');
        seatClassSelect.innerHTML = ''; // Clear existing options
        data.forEach(seatClass => {
            const option = document.createElement('option');
            option.value = seatClass.seat_class_id;
            option.textContent = seatClass.seat_class_name;
            seatClassSelect.appendChild(option);
        });

        let bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo')) || {};
        seatClassSelect.value = parseInt(bookingInfo.seatClass) || data[0].seat_class_id;
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu Hạng ghế:', error);
        alert('Không thể tải dữ liệu Hạng ghế. Vui lòng thử lại!');
    });
}

function loadSeatClasses() {
    let authToken = sessionStorage.getItem('auth_token');
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    const url = `http://${serverIp}:${serverPort}/api/seatclass`;

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        console.log(response);
        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
        return response.json();
    })
    .then(data => {
        const seatClassSelect = document.getElementById('seat-class');
        seatClassSelect.innerHTML = ''; // Clear existing options
        data.forEach(seatClass => {
            const option = document.createElement('option');
            option.value = seatClass.seat_class_id;
            option.textContent = seatClass.seat_class_name;
            seatClassSelect.appendChild(option);
        });

        let bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo')) || {};
        seatClassSelect.value = parseInt(bookingInfo.seatClass) || data[0].seat_class_id;
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu Hạng ghế:', error);
        alert('Không thể tải dữ liệu Hạng ghế. Vui lòng thử lại!');
    });
}
