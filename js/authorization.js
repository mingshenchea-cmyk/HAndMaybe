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