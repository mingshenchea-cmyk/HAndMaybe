<?php
include '../../_base.php';

if (is_post()) {
    $email    = req('email');

    // Validate: email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }

    // Login user
    if (!$_err) {
        $stm = $_db->prepare('
            SELECT * FROM user
            WHERE email = ?
        ');
        $stm->execute([$email]);
        $u = $stm->fetch();

        if ($u) {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', time() + 60 * 30); // expires in 30 mins

            $stm = $_db->prepare("
                INSERT INTO password_reset_tokens (token, user_id, expiry) 
                VALUES (?, ?, ?)"
            );
            $stm->execute([$token, $u->user_id, $expiry]);

            $link = "http://" . $_SERVER['HTTP_HOST'] . "/page/security/reset_password.php?token=$token";
            $m = get_mail();
            $m->addAddress($u->email);
            $m->Subject = "H&Maybe account password reset";
            $m->isHTML(true);
            $m->Body = "Click this link to reset your password: <a href='$link'>RESET PASSWORD LINK</a>";
            $m->send();
            
            $_db->prepare('DELETE FROM password_reset_tokens WHERE expiry < NOW()')->execute();

            temp('info', 'Email Sent');
        }
        else {
            $_err['email'] = 'Email does not exist!';
        }
    }
}

// ----------------------------------------------------------------------------
include '../../_head.php';

$_title = 'Password Reset';
?>

<link rel="stylesheet" href="/css/security.css">

<div class="auth-container">
    <div class="auth-form">
        <h2><?php echo $_title; ?></h2>
        <form method="post" class="form">
            <label for="email">Email</label>
            <?= html_text('email', 'maxlength="100"') ?>
            <?= err('email') ?>

            <div class="form-buttons">
                <button type="submit">Reset Password</button>
            </div>
        </form>
    </div>
</div>

<?php
include '../../_foot.php';