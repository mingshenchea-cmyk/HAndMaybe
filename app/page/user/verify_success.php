<?php
include '../../_base.php';

$token = get('token');

if($token) {
    $stm = $_db->prepare('SELECT * FROM email_verification_tokens WHERE token = ? AND expiry > NOW()');
    $stm->execute([$token]);
    $r = $stm->fetch();
    if(!$r) {
        temp('error', 'Expired token');
        print_r($r);
        // redirect('/');
    }

    $_db->prepare('UPDATE user SET email_verified = 1 WHERE user_id = ?')->execute([$r->user_id]);

    temp('info', 'Email verified');
    redirect('/');
} else {
    temp('error', 'Invalid token');
    redirect('/');
}