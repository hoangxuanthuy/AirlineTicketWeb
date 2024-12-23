document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const passengerForm = document.getElementById('passengerForm');
    const continueBtn = document.querySelector('.continue-btn');
    const progressSteps = document.querySelectorAll('.progress-step');

    // Button actions with navigation
    continueBtn.addEventListener('click', function(e) {
        e.preventDefault();

        // Check if all required fields are filled
        const requiredFields = passengerForm.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        });

        if (isValid) {
            // Redirect to the next page
            window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Seat/index.html"; // Replace with the actual URL of the next page
        } else {
            alert('Vui lòng điền đầy đủ thông tin!');
        }
    });

    // Add click event listeners for progress bar navigation
    progressSteps.forEach((step, index) => {
        step.addEventListener('click', function(e) {
            e.preventDefault();

            if (index === 1) {
                window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Seat/index.html"; // Replace with the actual URL for the "Chọn chỗ ngồi" page
            } else if (index === 2) {
                window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Review/index.html"; // Replace with the actual URL for the "Xem lại" page
            } else if (index === 3) {
                window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/Pay/index.html"; // Replace with the actual URL for the "Thanh toán" page
            }
        });
    });

    // Error handling for invalid inputs
    passengerForm.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.classList.add('error');
        });

        input.addEventListener('input', function() {
            if (this.value) {
                this.classList.remove('error');
            }
        });
    });

    // Phone number validation
    const phoneInput = passengerForm.querySelector('input[type="tel"]');
    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // CCCD validation (only numbers)
    const cccdInput = passengerForm.querySelector('input[name="cccd"]');
    if (cccdInput) {
        cccdInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    // Date validation
    const dateInputs = passengerForm.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.addEventListener('input', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            
            if (selectedDate > today) {
                this.classList.add('error');
                alert('Ngày không hợp lệ');
                this.value = '';
            }
        });
    });
});
