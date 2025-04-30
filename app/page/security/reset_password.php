<?php
include '../../_base.php';

$token = get('token');

if($token) {

} else {
    temp('info', 'Invalid token');
    redirect('/');
}