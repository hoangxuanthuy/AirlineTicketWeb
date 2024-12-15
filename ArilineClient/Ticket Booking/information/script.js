document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const passengerForm = document.getElementById('passengerForm');
    const continueBtn = document.querySelector('.continue-btn');

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
            // Proceed to next step
            const currentStep = document.querySelector('.progress-step.active');
            const nextStep = currentStep.nextElementSibling;
            
            if (nextStep) {
                currentStep.classList.remove('active');
                nextStep.classList.add('active');
                // Here you would typically handle the navigation to the next page/step
                alert('Proceeding to next step...');
            }
        } else {
            alert('Vui lòng điền đầy đủ thông tin!');
        }
    });

    // Add error class on invalid input
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