<?php

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Comment;
use App\Models\User;

include 'Header.php';

/**
 * @var Comment $comment
 * @var User $user owner of the comment
 * @var array $errors
 * @var string $content
 */

?>

<section class="mx-auto">

    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <h5>
                    <?php if ($comment->isDeleted()) { ?>
                        <a href="#">[deleted]</a>
                    <?php } else { ?>
                        <a href="<?= Routing::getCustomUrlTo('profile', ['userId'=>$user->getId()]) ?>"><?= $user->getUsername() ?></a>
                    <?php } ?>
                </h5>

                <small class="p-1"><?= $comment->getCreatedAt() ?></small>
                <?php if ($comment->isEdited()) { ?>
                    <small class="p-1">[edited]</small>
                <?php } ?>
            </div>

            <?php if ($comment->isDeleted()) { ?>
                <p>[deleted]</p>
            <?php } else { ?>
                <p><?= $comment->getContent() ?></p>
            <?php } ?>
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
