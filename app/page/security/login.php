<?php
include '../../_base.php';

// ----------------------------------------------------------------------------

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = null;
}

$max_attempts = 3;
$lockout_time = 300;

if ($_SESSION['login_attempts'] >= $max_attempts) {
    $remaining = $lockout_time - (time() - $_SESSION['last_attempt_time']);
    if ($remaining > 0) {
        $_err['general'] = 'Too many failed attempts. Try again in ' . ceil($remaining / 60) . ' minute(s).';
    } else {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = null;
    }
}

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
            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_attempt_time'] = null;

            temp('info', 'Login successfully!');
            
            if (isset($_POST['remember_me'])) {
                $token = generate_token();
                $token_hash = hash('sha256', $token);
                $expiry = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30); // 30 days
                
                $stm = $_db->prepare('
                    INSERT INTO remember_tokens (user_id, token_hash, expires_at)
                    VALUES (?, ?, ?)
                ');
                $stm->execute([$u->user_id, $token_hash, $expiry]);
            
                setcookie('remember_me', $token, [
                    'expires' => time() + 60 * 60 * 24 * 30,
                    'path' => '/',
                    'httponly' => true,
                ]);
            }

            if ($u->role == 'Admin') {
                login($u, '/page/admin/member/member_maintenance.php'); 
            } else {
                login($u, '/'); 
            }
        }
        else {
            $_SESSION['login_attempts'] += 1;
            $_SESSION['last_attempt_time'] = time();
            $_err['password'] = 'Incorrect password!';
        }
    }
}

// ----------------------------------------------------------------------------
include '../../_head.php';

$_title = 'Login';
?>

<link rel="stylesheet" href="/css/security.css">

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
            <?= err('general') ?>

            <label>
                <input type="checkbox" name="remember_me"> Remember Me
            </label>

            <div class="form-buttons">
                <button type="submit">Login</button>
                <button type="reset">Reset</button>
            </div>
        <p>Forgot your password? Reset password <a href="reset.php">here!</a></p>
        </form>
    </div>
</div>

<?php
include '../../_foot.php';