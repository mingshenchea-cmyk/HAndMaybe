<?php
require '../../../_base.php';
//-----------------------------------------------------------------------------

$query = get('query');

$_users = getAllUser();

//-----------------------------------------------------------------------------
// Include the header
include '../../../_head.php';
?>

<link rel="stylesheet" href="/css/member.css">

<div class="container">
    <?php
    foreach ($_users as $users):
        // Check if searching or category filtering
        $shouldDisplay = false;
        ?>

        <?php if (!empty($query)): ?>
            <?php
            // If there is a search keyword
            if (stripos($users->name, $query) !== false): ?>
                <?php $shouldDisplay = true; ?>
            <?php endif ?>
        <?php else: ?>
            <?php
            // If no search query, display all users
            $shouldDisplay = true;
            ?>
        <?php endif ?>

        <?php
        if ($shouldDisplay): 
            if($users->role == "Member"): ?>
            <div class='member'>
                <a href='/page/admin/member/member_detail.php?user_id=<?=$users->user_id?>' class='profile_link'>
                    <img class='profile_photo' src="/photos/<?= $users->profile_photo ?>"
                        alt="<?= htmlspecialchars($users->profile_photo) ?>">
                    <p class='name'><?= $users->name ?></p>
                </a>
            </div>
            <?php endif ?>
        <?php endif ?>
    <?php endforeach ?>
</div>

</html>

<?php
// Include the footer
include '../../../_foot.php';
?>