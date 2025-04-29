<?php
include '_base.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $email    = req('email');
    $password = req('password');

    // Validate: email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }

    // Validate: password
    if ($password == '') {
        $_err['password'] = 'Required';
    }

    // Login user
    if (!$_err) {
        $stm = $_db->prepare('
            SELECT * FROM user
            WHERE email = ? AND password = SHA1(?)
        ');
        $stm->execute([$email, $password]);
        $u = $stm->fetch();

        if ($u) {
            temp('info', 'Login successfully!');
            if ($u->role == 'Admin') {
                login($u, 'member_maintenance.php'); 
            } else {
                login($u, 'page/profile.php'); 
            }
        }
        else {
            $_err['password'] = 'Incorrect password!';
        }
    }
}

// ----------------------------------------------------------------------------
include '_head.php';

$_title = 'Login';
?>

<link rel="stylesheet" href="/css/authorization.css">

<div class="auth-container">
    <div class="auth-form">
        <h2><?php echo $_title; ?></h2>
        <p>Not a member? Sign Up <a href="signup.php">here!</a></p>
        <form action="login.php" method="post" class="form">
            <label for="email">Email</label>
            <?= html_text('email', 'maxlength="100"') ?>
            <?= err('email') ?>

            <label for="password">Password</label>
            <?= html_password('password', 'maxlength="100"') ?>
            <?= err('password') ?>

            <div class="form-buttons">
                <button type="submit">Login</button>
                <button type="reset">Reset</button>
            </div>
        </form>
    </div>
</div>

<?php
include '_foot.php';