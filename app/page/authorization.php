<?php
require '..\_base.php';

// Include the header
include '..\_head.php';
?>

<link rel="stylesheet" href="/css/authorization.css">

<body>
    <div class="auth-container">
        <!-- Toggle Buttons -->
        <div class="auth-tabs">
            <button id="login-tab" class="active">Login</button>
            <button id="signup-tab">Sign Up</button>
        </div>

        <!-- Login Form -->
        <div id="login-form" class="auth-form">
            <h2>Login</h2>
            <form id="login-form-data">
                <input type="text" name="username" placeholder="Username or Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <label>
                    <input type="checkbox" name="remember_me"> Remember Me
                </label>
                <button type="submit">Login</button>
            </form>
            <p><a href="#" id="forgot-password">Forgot Password?</a></p>
        </div>

        <!-- Signup Form -->
        <div id="signup-form" class="auth-form" style="display: none;">
            <h2>Sign Up</h2>
            <form id="signup-form-data">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign Up</button>
            </form>
            <p>By signing up, you agree to our <a href="#">Terms of Service</a>.</p>
        </div>

        <!-- Password Reset Form -->
        <div id="reset-form" class="auth-form" style="display: none;">
            <h2>Reset Password</h2>
            <form id="reset-form-data">
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Reset Password</button>
            </form>
            <p><a href="#" id="back-to-login">Back to Login</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/auth.js"></script>

    
<?php
// Include the footer
include '..\_foot.php';