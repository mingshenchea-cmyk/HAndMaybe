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
    $_SESSION['profile_photo'] = $u->profile_photo;
}

if (is_post()) {
    $profile_photo = $_SESSION['profile_photo'];
    $f = get_file('profile_photo');
    $name  = req('name');
    $email = req('email');
    $phone_no  = req('phone_no');
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
            $_err['profile_photo'] = 'Must be image';
        }
        else if ($f->size > 5 * 1024 * 1024) {
            $_err['profile_photo'] = 'Maximum 5MB';
        }
    }

    // Validate: phone
    if (!$phone_no) {
        $_err['phone_no'] = 'Required';
    }
    else if (strlen($phone_no) < 9 || strlen($phone_no) > 10) {
        $_err['phone_no'] = 'Not valid phone number';
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
            unlink("../photos/$profile_photo");
            $profile_photo = save_photo($f, '../photos');
        }
        
        // (2) Update user (email, name, photo)
        $stm = $_db->prepare('
            UPDATE user
            SET name = ?, age = ?, gender = ?, phone_no = ?, email = ?, profile_photo = ?
            WHERE user_id = ?
        ');
        $stm->execute([$name, $age, $gender, $phone_no, $email, $profile_photo, $_user->user_id]);

        // (3) Update global user object
        $_user->email = $email;
        $_user->name = $name;
        $_user->profile_photo = $profile_photo;
        $_user->phone_no = $phone_no;
        $_user->age = $age;
        $_user->gender = $gender;

        temp('info', 'Record updated');
    }
}

// ----------------------------------------------------------------------------

$_title = 'User | Profile';
include '../_head.php';
?>

<link rel="stylesheet" href="/css/profile.css">

<form method="post" class="form" enctype="multipart/form-data">
    <div class="profile-container">
        <h2>Profile Update</h2>

        <label for="profile_photo">Photo</label>
        <label class="upload" tabindex="0">
            <?= html_file('profile_photo', 'image/*', 'hidden') ?>
            <img src="../photos/<?= $profile_photo ?>" alt="Profile Photo">
        </label>
        <?= err('profile_photo') ?>

        <label for="name">Name</label>  
        <?= html_text('name', 'maxlength="100"') ?>
        <?= err('name') ?>

        <label for="email">Email</label>
        <?= html_text('email', 'maxlength="100"') ?>
        <?= err('email') ?>

        <label for="phone_no">Phone no.</label>
        <?= html_text('phone_no', 'maxlength="10"') ?>
        <?= err('phone_no') ?>

        <label for="age">Age</label>
        <?= html_number('age', 1, 99) ?>
        <?= err('age') ?>

        <label for="gender">Gender</label>
        <?php
            $gender_options = [
                'M' => 'Male',
                'F' => 'Female'
            ];
        ?>
        <?= html_radios('gender', $gender_options); ?>
        <?= err('gender') ?>

        <div class="form-buttons">
            <button>Update</button>
            <button type="reset">Reset</button>
            <a href="../logout.php" class="logout-btn">Log Out</a>
        </div>
    </div>
</form>

<?php
include '../_foot.php';