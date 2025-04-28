<?php
require '..\_base.php';

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
                <label>Remember Me</label>
                    <input type="checkbox" name="remember_me"> 
                <button type="submit">Login</button>
            </form>
            <p><a href="#" id="forgot-password">Forgot Password?</a></p>
        </div>

        <!-- Signup Form -->
        <div id="signup-form" class="auth-form" style="display: none;">
            <h2>Sign up</h2>
            
            <form method="post" class="form" enctype="multipart/form-data">
                <label for="photo">Photo</label>
                <label class="upload" tabindex="0">
                    <?= html_file('photo', 'image/*', 'hidden') ?>
                    <img src="/images/photo.jpg">
                </label>
                <?= err('photo') ?>
                <br><br>

                <label for="name">Name</label>
                <?= html_text('name', 'maxlength="100"') ?>
                <?= err('name') ?>

                <label for="email">Email</label>
                <?= html_text('email', 'maxlength="100"') ?>
                <?= err('email') ?>

                <label for="password">Password</label>
                <?= html_password('password', 'maxlength="100"') ?>
                <?= err('password') ?>

                <label for="confirm">Confirm Password</label>
                <?= html_password('confirm', 'maxlength="100"') ?>
                <?= err('confirm') ?>

                <label for="age">Age</label>
                <input type='number' id='age' name='age' value='1' min=1 max=99>

                <label for="gender">Gender</label>
                    <input type='radio' id='gender_M' name='gender' value='M' >Male
                </label>
                <label>
                    <input type='radio' id='gender_F' name='gender' value='F' >Female
                </label>

                <section>
                    <button>Submit</button>
                    <button type="reset">Reset</button>
                </section>
            </form>
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
    <script>
        $(document).ready(function() {
            // Toggle between login and signup forms
            $('#login-tab').click(function() {
                $('#login-tab').addClass('active');
                $('#signup-tab').removeClass('active');
                $('#login-form').show();
                $('#signup-form').hide();
                $('#reset-form').hide();
            });

            $('#signup-tab').click(function() {
                $('#signup-tab').addClass('active');
                $('#login-tab').removeClass('active');
                $('#signup-form').show();
                $('#login-form').hide();
                $('#reset-form').hide();
            });

            // Show password reset form
            $('#forgot-password').click(function(e) {
                e.preventDefault();
                $('#reset-form').show();
                $('#login-form').hide();
                $('#signup-form').hide();
            });

            // Back to login form from reset form
            $('#back-to-login').click(function(e) {
                e.preventDefault();
                $('#login-form').show();
                $('#reset-form').hide();
            });

            // Handle login form submission
            $('#login-form-data').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'process_login.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response === 'success') {
                            window.location.href = 'dashboard.php'; // Redirect to dashboard
                        } else {
                            alert('Login failed: ' + response); // Show error message
                        }
                    }
                });
            });

            // Handle signup form submission
            $('#signup-form-data').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'process_signup.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response === 'success') {
                            alert('Signup successful! Please login.'); // Show success message
                            $('#signup-tab').removeClass('active');
                            $('#login-tab').addClass('active');
                            $('#signup-form').hide();
                            $('#login-form').show();
                        } else {
                            alert('Signup failed: ' + response); // Show error message
                        }
                    }
                });
            });

            // Handle password reset form submission
            $('#reset-form-data').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'process_reset.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response); // Show success or error message
                    }
                });
            });
        });
    </script>

    
<?php
// Include the footer
include '..\_foot.php';