<?php
include '_base.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $email    = req('email');
    $password = req('password');
    $confirm  = req('confirm');
    $name     = req('name');
    $age      = req('age');
    $gender   = req('gender');
    $phone    = req('phone');
    $f = get_file('photo');

    // Validate: email
    if (!$email) {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else if (!is_unique($email, 'user', 'email')) {
        $_err['email'] = 'Duplicated';
    }

    // Validate: password
    if (!$password) {
        $_err['password'] = 'Required';
    }
    else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5-100 characters';
    }

    // Validate: confirm
    if (!$confirm) {
        $_err['confirm'] = 'Required';
    }
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5-100 characters';
    }
    else if ($confirm != $password) {
        $_err['confirm'] = 'Not matched';
    }

    // Validate: name
    if (!$name) {
        $_err['name'] = 'Required';
    }
    else if (strlen($name) > 100) {
        $_err['name'] = 'Maximum 100 characters';
    }

    // Validate: password
    if (!$password) {
        $_err['password'] = 'Required';
    }
    else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5-100 characters';
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

    // Validate: photo (file)
    if (!$f) {
        $_err['photo'] = 'Required';
    }
    else if (!str_starts_with($f->type, 'image/')) {
        $_err['photo'] = 'Must be image';
    }
    else if ($f->size > 5 * 1024 * 1024) {
        $_err['photo'] = 'Maximum 5MB';
    }

    // DB operation
    if (!$_err) {

        // (1) Save photo
        $photo = save_photo($f, 'photos');
        
        // (2) Insert user (member)
        $stm = $_db->prepare('
            INSERT INTO user (role, name, password, age, gender, phone_no, email, profile_photo)
            VALUES ("Member", ?, SHA1(?), ?, ?, ?, ? ,?)
        ');
        $stm->execute([$name, $password, $age, $gender, $phone, $email, $photo]);

        temp('info', 'Record inserted');
        redirect('/login.php');
    }
}

// ----------------------------------------------------------------------------

include '_head.php';

$_title = 'User | Register Member';
?>

<link rel="stylesheet" href="/css/authorization.css">

<div class="auth-container">
    <div class="auth-form">
        <h2><?php echo $_title; ?></h2>
        <p>Already a member? Log in <a href="login.php">here!</a></p>
        <form method="post" class="form" enctype="multipart/form-data">
            <label for="photo">Profile Picture</label>
            <label class="upload" tabindex="0">
                <?= html_file('photo', 'image/*', 'hidden') ?>
                <img src="/images/image.jpg">
            </label>
            <?= err('photo') ?>

            <label for="name">Name</label>
            <?= html_text('name', 'maxlength="100"') ?>
            <?= err('name') ?>

            <label for="email">Email</label>
            <?= html_text('email', 'maxlength="100"') ?>
            <?= err('email') ?>

            <label for="password">Password</label>
            <?= html_password('password', 'maxlength="100"') ?>
            <?= err('password') ?>

            <label for="confirm">Confirm Password</label>
            <?= html_password('confirm', 'maxlength="100"') ?>
            <?= err('confirm') ?>

            <label for="phone">Phone no.</label>
            <?= html_text('phone', 'maxlength="10"') ?>
            <?= err('phone') ?>

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
                <button type="submit">Sign Up</button>
                <button type="reset">Reset</button>
            </div>
        </form>
    </div>
</div>

<?php
include '_foot.php';