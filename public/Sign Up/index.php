
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Travel Booking</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-box" id="signUpForm">
            <h1>Sign up</h1>
            <form onsubmit="return handleSignUp(event)">
                <div class="input-group">
                    <input type="text" id="fullName" placeholder="Full name" required>
                </div>
                <div class="input-group">
                    <input type="text" id="citizen-id" placeholder="Citizen ID" required>
                </div>
                <div class="input-group">
                    <input type="tel" id="phoneNumber" placeholder="Phone number" required>
                </div>
                <div class="input-group">
                    <input type="email" id="emailAddress" placeholder="Email address" required>
                </div>
                <!-- <div class="input-group">
                    <input type="text" id="userName" placeholder="User Name" required>
                </div> -->
                <div class="input-group">
                    <input type="password" id="password" placeholder="Create password" required>
                </div>
                <div class="input-group">
                    <input type="password" id="confirmPassword" placeholder="Confirm password" required>
                </div>
                <button type="submit" class="submit-btn">Sign up</button>
                <div class="signin-link">
                    Back to Sign in? <a href="../Sign In/index.php">Sign in</a>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>