<?php
include '../../_base.php';

// ----------------------------------------------------------------------------

// Authenticated users
auth();

if ($_user) {
    $token = bin2hex(random_bytes(32));
    $token = generate_token();
    $token_hash = hash('sha256', $token);
    $expiry = date('Y-m-d H:i:s', time() + 60 * 30); // expires in 30 mins

    $stm = $_db->prepare("
        INSERT INTO email_verification_tokens (token, user_id, expiry) 
        VALUES (?, ?, ?)"
    );
    $stm->execute([$token_hash, $_user->user_id, $expiry]);

    $link = "http://" . $_SERVER['HTTP_HOST'] . "/page/user/verify_success.php?token=$token_hash";
    $m = get_mail();
    $m->addAddress($_user->email);
    $m->Subject = "H&Maybe account email verification";
    $m->isHTML(true);
    $m->Body = "Click this link to verify your email: <a href='$link'>VERIFY EMAIL LINK</a>";
    $m->send();
    
    $_db->prepare('DELETE FROM email_verification_tokens WHERE expiry < NOW()')->execute();

    temp('info', 'Email Sent');
    redirect('/page/user/profile.php');
}