<?php
require '../../../_base.php';
//-----------------------------------------------------------------------------

$user_id = get('user_id');

$_users = getAllUser();

//-----------------------------------------------------------------------------
// Include the header
include '../../../_head.php';
?>

<link rel="stylesheet" href="/css/member.css">

<div class="container">
    <?php foreach ($_users as $users): ?>
        <?php if ($user_id == $users->user_id): ?>
            <div class='product_box'>
                <img class='product_image' src="/photos/<?= $users->profile_photo ?>" alt='<?= $users->profile_photo ?>'>
                <div class='detail'>
                    <p class='detail_name'><?= $users->name ?></p>
                    <p class='color'>Age: <?= $users->age ?></p>
                    <?php if ($users->gender == 'M'): ?>
                        <p class='color'>Gender: Male</p>
                    <?php else: ?>
                        <p class='color'>Gender: Female</p>
                    <?php endif ?>
                    <p class='color'>Phone Number: 0<?= $users->phone_no ?></p>
                    <p class='color'>Email: <?= $users->email ?></p>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>

</html>

<?php
// Include the footer
include '../../../_foot.php';
?>