<?php

use App\Helpers\Routing;

include 'Header.php';

/**
 * @var Routing
 * @var string $status
 */

if ($status == 'rejected') {
    $values = $_SESSION['form_signup']['values'];
    $errors = $_SESSION['form_signup']['errors'];

    $username = $values['username'] ?? '';
    $username_error = $errors['username'] ?? '';

    $email = $values['email'] ?? '';
    $email_error = $errors['email'] ?? '';

    $password = $values['password'] ?? '';
    $password_error = $errors['password'] ?? '';
}

?>

<section class="mx-auto">
    <h1 class="text-center">Sign Up</h1>

    <form action="/<?=constant('URL_SUBFOLDER')?>/api/signup" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= $username ?? '' ?>">
            <div class="text-danger"><?= $username_error ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="text" name="email" class="form-control" value="<?= $email ?? '' ?>">
            <div class="text-danger"><?= $email_error ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" value="<?= $password ?? '' ?>">
            <div class="text-danger"><?= $password_error ?? '' ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>

    </form>
<section>
<?php include 'Footer.php'; ?>