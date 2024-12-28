function handleSignUp(event) {
    event.preventDefault();
    const submitButton = event.target.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
    }
    const formData = {
        fullName: document.getElementById('fullName').value,
        userId: document.getElementById('citizen-id').value,
        phoneNumber: document.getElementById('phoneNumber').value,
        email: document.getElementById('emailAddress').value,
        password: document.getElementById('password').value,
        confirmPassword: document.getElementById('confirmPassword').value
    };
    
    if (formData.password !== formData.confirmPassword) {
        alert('Passwords do not match!');
        if (submitButton) {
            submitButton.disabled = false;
        }
        return false;
    }
    
    console.log('Sign up attempt:', formData);

    const serverIp = "127.0.0.1";
    const serverPort = "8000";

    console.log('Server IP:', serverIp);
    fetch(`http://${serverIp}:${serverPort}/api/registercus`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: formData.email,
            password: formData.password,
            password_confirmation: formData.confirmPassword,
            account_name: formData.fullName,
            citizen_id: formData.userId,
            phone: formData.phoneNumber
        })
    })
    .then(response => {
        console.log('Response:', response);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text().then(text => text ? JSON.parse(text) : {});
    })
    .then(data => {
        console.log('Data:', data);
        if (data.message === 'Đăng ký thành công!') {
            sessionStorage.setItem('account_id', data.data.account_id);
            sessionStorage.setItem('user_id', data.data.user_id);
            sessionStorage.setItem('client_id', data.data.client_id);
            alert('Sign up successful!\nWelcome ' + formData.fullName);
            window.location.href = '../Sign In/index.html';
        } else {
            alert('Sign up failed: ' + JSON.stringify(data));
            if (submitButton) {
                submitButton.disabled = false;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Sign up failed: ' + error.message);
        if (submitButton) {
            submitButton.disabled = false;
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const signUpForm = document.getElementById('signUpForm');
    // if (signUpForm) {
    //     signUpForm.addEventListener('submit', handleSignUp);
    // }

    // Password validation for sign up form
    const confirmPasswordInput = document.getElementById('confirmPassword');
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});

