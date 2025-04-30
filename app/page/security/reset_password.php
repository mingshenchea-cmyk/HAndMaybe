<?php
include '../../_base.php';

$token = get('token');

if($token) {
    $stm = $_db->prepare('SELECT * FROM password_reset_tokens WHERE token = ? AND expiry > NOW()');
    $stm->execute([$token]);
    $r = $stm->fetch();
    if(!$r) {
        temp('info', 'Expired token');
        redirect('/');
    }
} else {
    temp('info', 'Invalid token');
    redirect('/');
}

if (is_post()) {
    $new_password = req('new_password');
    $confirm      = req('confirm');

    // Validate: new_password
    if ($new_password == '') {
        $_err['new_password'] = 'Required';
    }
    else if (strlen($new_password) < 5 || strlen($new_password) > 100) {
        $_err['new_password'] = 'Between 5-100 characters';
    }

    // Validate: confirm
    if (!$confirm) {
        $_err['confirm'] = 'Required';
    }
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5-100 characters';
    }
    else if ($confirm != $new_password) {
        $_err['confirm'] = 'Not matching!';
    }

    // DB operation
    if (!$_err) {

        // Update user (password)
        $stm = $_db->prepare('
            UPDATE user
            SET password = SHA1(?)
            WHERE user_id = ?
        ');
        $stm->execute([$new_password, $r->user_id]);

        $stm = $_db->prepare('
            DELETE FROM password_reset_tokens 
            WHERE token = ?
        ');
        $stm->execute([$token]);

        temp('info', 'Record updated');
        redirect('/');
    }
}

// ----------------------------------------------------------------------------

$_title = 'Password Reset';
include '../../_head.php';
?>

<link rel="stylesheet" href="/css/security.css">

<div class="auth-container">
    <div class="auth-form">
        <h2><?php echo $_title; ?></h2>
        <form method="post" class="form">
            <label for="new_password">New Password</label>
            <?= html_password('new_password', 'maxlength="100"') ?>
            <?= err('new_password') ?>

            <label for="confirm">Confirm</label>
            <?= html_password('confirm', 'maxlength="100"') ?>
            <?= err('confirm') ?>

            <div class="form-buttons">
                <button type="submit">Reset</button>
            </div>
        </form>
    </div>
</div>