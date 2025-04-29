<?php
include '../_base.php';

// ----------------------------------------------------------------------------

// Authenticated users
auth();

if (is_get()) {
    $stm = $_db->prepare('SELECT * FROM user WHERE user_id = ?');
    $stm->execute([$_user->user_id]);
    $u = $stm->fetch();

    if (!$u) {
        redirect('/');
    }

    extract((array)$u);
    $_SESSION['photo'] = $u->profile_photo;
}

if (is_post()) {
    $photo = $_SESSION['photo'];
    $f = get_file('photo');
    $name  = req('name');
    $email = req('email');
    $phone  = req('phone');
    $age = req('age');
    $gender  = req('gender');

    // Validate: email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else {
        $stm = $_db->prepare('
            SELECT COUNT(*) FROM user
            WHERE email = ? AND user_id != ?
        ');
        $stm->execute([$email, $_user->user_id]);

        if ($stm->fetchColumn() > 0) {
            $_err['email'] = 'Duplicated';
        }
    }

    // Validate: name
    if ($name == '') {
        $_err['name'] = 'Required';
    }
    else if (strlen($name) > 100) {
        $_err['name'] = 'Maximum 100 characters';
    }

    // Validate: photo (file) --> optional
    if ($f) {
        if (!str_starts_with($f->type, 'image/')) {
            $_err['photo'] = 'Must be image';
        }
        else if ($f->size > 5 * 1024 * 1024) {
            $_err['photo'] = 'Maximum 5MB';
        }
    }

    // Validate: phone
    if (!$phone) {
        $_err['phone'] = 'Required';
    }
    else if (strlen($phone) < 9 || strlen($phone) > 10) {
        $_err['phone'] = 'Not valid phone number';
    }

    // Validate: age
    if (!$age) {
        $_err['age'] = 'Required';
    }
    else if (($age) < 1 || ($age) > 99) {
        $_err['age'] = 'Not valid age';
    }

    // Validate: gender
    if (!$gender) {
        $_err['gender'] = 'Required';
    }

    // DB operation
    if (!$_err) {

        // (1) Delete and save photo --> optional
        if ($f) {
            unlink("../photos/$photo");
            $photo = save_photo($f, '../photos');
        }
        
        // (2) Update user (email, name, photo)
        $stm = $_db->prepare('
            UPDATE user
            SET name = ?, age = ?, gender = ?, phone_no = ?, email = ?, profile_photo = ?
            WHERE id = ?
        ');
        $stm->execute([$email, $name, $photo, $_user->Invalid]);

        // (3) Update global user object
        $_user->email = $email;
        $_user->name = $name;
        $_user->photo = $photo;

        temp('info', 'Record updated');
        redirect('/');
    }
}

// ----------------------------------------------------------------------------

$_title = 'User | Profile';
include '../_head.php';
?>

<form method="post" class="form" enctype="multipart/form-data">
    <label for="photo">Photo</label>
    <label class="upload" tabindex="0">
        <?= html_file('photo', 'image/*', 'hidden') ?>
        <img src="../photos/<?= $photo ?>">
    </label>
    <?= err('photo') ?>

    <label for="name">Name</label>  
    <?= html_text('name', 'maxlength="100"') ?>
    <?= err('name') ?>

    <label for="email">Email</label>
    <?= html_text('email', 'maxlength="100"') ?>
    <?= err('email') ?>

    <label for="phone">Phone no.</label>
    <?= html_text('phone', 'maxlength="10"') ?>
    <?= err('phone') ?>
    
    <label for="age">age</label>
    <input type='number' id='age' name='age' value='1' min=1 max=99>
    <?= err('age') ?>

    <label>Gender</label>
        <div class="gender-options">
            <label class="gender-option">
                <input type="radio" name="gender" value="M" checked> Male
            </label>
            <label class="gender-option">
                <input type="radio" name="gender" value="F"> Female
            </label>
        </div>
    <?= err('gender') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>

<?php
include '../_foot.php';