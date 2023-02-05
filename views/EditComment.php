<?php

include 'Header.php';

/**
 * @var int $id
 * @var string $content
 */

?>
<section class="mx-auto">
    <div class="card">
        <div class="card-header">
            <h2>Edit comment</h2>
        </div>

        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="content" class="form-label">Message</label>
                    <textarea name="content" class="form-control" placeholder="<?= $content ?? '' ?>"></textarea>
                    <div class="text-danger"><?= $errors["content"] ?? "" ?></div>
                </div>
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>
    </div>

</section>

<?php include 'Footer.php'; ?>
