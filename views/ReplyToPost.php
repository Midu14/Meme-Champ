<?php

use App\Helpers\Routing;

include 'Header.php';

/**
 * @var int $id
 */

?>

<style>
    section {
        max-width: 600px;
        padding: 20px;
    }
    input, label, small {
        display: block;
    }
</style>

<section class="mx-auto">
    <div class="card">
        <div class="card-header">
            <h2>Create comment</h2>
        </div>

        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="content" class="form-label">Message</label>
                    <textarea type="text" name="content" class="form-control" value="<?= $content ?? '' ?>"></textarea>
                    <div class="text-danger"><?= $errors["content"] ?? "" ?></div>
                </div>
                <button type="submit" class="btn btn-primary">Reply</button>
            </form>
        </div>
    </div>

</section>

<?php include 'Footer.php'; ?>
