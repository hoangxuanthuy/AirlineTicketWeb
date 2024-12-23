document.addEventListener('DOMContentLoaded', function () {
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
                    window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Pay/index.html"; // Thay bằng đường dẫn trang tiếp theo
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
                "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/information/index.html", // Điền thông tin
                "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Seat/index.html", // Chọn chỗ ngồi
                "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Review/index.html",      // Xem lại
                "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Pay/index.html"         // Thanh toán
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
});
