<?php
include '../../_base.php';

// ----------------------------------------------------------------------------

if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
    $_db->prepare('
        DELETE FROM remember_tokens 
        WHERE user_id = ?
    ')->execute([$_user->user_id]);
}
temp('info', 'Logout successfully');
logout();

// ----------------------------------------------------------------------------