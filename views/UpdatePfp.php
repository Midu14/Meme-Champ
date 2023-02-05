<?php

/**
 * @var int $id
 * @var string $status
 */

use App\Helpers\Routing;

include 'Header.php';

$fulfilled = $status == 'fulfilled';
$rejected = $status == 'rejected';

/**
 * @var int $id
 */

?>
<section class="mx-auto">
    <h1>Update Profile Picture</h1>
    <hr>
    <div class="p-2 my-2 border rounded">
        <form enctype="multipart/form-data" action="<?= Routing::getCustomUrlTo('handle_pfp_update', ['id'=>$id]) ?>" method="post">
            <div class="mb-3">
                <label for="pfp" class="form-label">Profile Picture</label>
                <input type="file" name="pfp" class="form-control">
                <?php if ($fulfilled) { ?>
                    <div class="text-success"><?= $_SESSION['form_update_pfp'] ?? "" ?></div>
                <?php } else if ($rejected) { ?>
                    <div class="text-danger"><?= $_SESSION['form_update_pfp'] ?? "" ?></div>
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
<section>
<?php include 'Footer.php'; ?>