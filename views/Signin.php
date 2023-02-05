<?php

use App\Helpers\Routing;

include 'Header.php';

/**
 * @var Routing
 * @var string $status
 */

if ($status == 'rejected') {
    $errors = $_SESSION['form_signin']['errors'];

    $username_error = $errors['username'] ?? '';
    $password_error = $errors['password'] ?? '';
    $global_err = $errors['global'] ?? '';
}

?>
<section class="mx-auto">
    <h1 class="text-center">Sign In</h1>

    <?php if (isset($global_err) && $global_err) { ?>
    <div class="alert alert-danger" role="alert">
        <?= $global_err ?>
    </div>
    <?php } ?>

    <form action="/<?= constant('URL_SUBFOLDER') ?>/api/signin" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control">
            <div class="text-danger"><?= $username_error ?? "" ?></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
            <div class="text-danger"><?= $password_error ?? "" ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
    </form>

    <a href="<?php echo Routing::getUrlTo('homepage') ?>">Back to homepage</a>
<section>
<?php include 'Footer.php'; ?>