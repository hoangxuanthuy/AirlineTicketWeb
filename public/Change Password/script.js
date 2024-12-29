// Form handling functions
function handleChangePassword(event) {
    event.preventDefault();
    const formData = {
        username: document.getElementById('userName').value,
        newPassword: document.getElementById('newPassword').value,
        confirmPassword: document.getElementById('confirmPassword').value
    };
    
    if (formData.newPassword !== formData.confirmPassword) {
        alert('Passwords do not match!');
        return false;
    }
    
    console.log('Password change attempt:', formData);
    alert('Password changed successfully for user: ' + formData.username);
    
    // Redirect to sign in page after successful password change
    window.location.href = 'index.php';
}

document.addEventListener('DOMContentLoaded', function() {
    // Password validation for change password form
    const confirmPasswordInput = document.getElementById('confirmPassword');
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = this.value;
            
            if (newPassword !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Form submission handling
    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', handleChangePassword);
    }
});