<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1>Sign in</h1>
            <form id="signInForm">
                <div class="input-group">
                    <input type="text" id="username" placeholder="User Name" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" placeholder="Password" required>
                </div>
                <div class="forgot-link">
                    <a href="../Change Password/index.php">Forgot password?</a>
                </div>
                <button type="submit" class="sign-in-btn">Sign In</button>
                <div class="signup-link">
                    Don't have an account? <a href="../Sign Up/index.php">Sign up</a>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>