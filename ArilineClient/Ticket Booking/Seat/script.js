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
                    window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Review/index.html"; // Thay bằng đường dẫn trang thực tế
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
                window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/information/index.html"; // Điền thông tin
            } else if (index === 1) {
                window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Seat/index.html"; // Chọn chỗ ngồi
            } else if (index === 2) {
                window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Review/index.html"; // Xem lại
            } else if (index === 3) {
                window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Pay/index.html"; // Thanh toán
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
