<?php

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Comment;
use App\Models\Enums\ReplyTarget;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;

include 'Header.php';

/**
 * @var Post $post
 * @var User $user
 */


function show_comments(Post $post) {
    $comments = Comment::getReplies($post->getId(), ReplyTarget::POST);

    show_replies($comments);
}

function show_replies(array $comments, $level = 0) {
    if (empty($comments)) {
        return;
    }

    foreach ($comments as $comment) {
        show_comment($comment, $level);
        $replies = Comment::getReplies($comment->getId());
        show_replies($replies, $level+1);
    }
}

function show_comment($comment, $level = 0) {
    $owner = $comment->getOwner();

    ?>

    <li class="list-group-item border-0 px-2 py-0">

        <div class="d-flex">
            <div class="d-flex">
            <?php
            for ($i = 0; $i < $level; $i++) {
                echo "<div class='h-100' style='width: 25px'><div style='width: 2px' class='h-100 mx-auto bg-secondary'></div></div>";
            }
            ?>
            </div>

            <div class="d-block p-2 w-100">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <h5>
                        <?php if ($comment->isDeleted()) { ?>
                            <a href="#">[deleted]</a>
                        <?php } else { ?>
                            <a href="<?= Routing::getCustomUrlTo('profile', ['userId'=>$owner->getId()]) ?>"><?= $owner->getUsername() ?></a>
                        <?php } ?>
                    </h5>
                    <small class="p-1"><?= $comment->getCreatedAt() ?></small>
                    <?php if ($comment->isEdited()) { ?>
                        <small class="p-1">[edited]</small>
                    <?php } ?>
                </div>

                <div>
                    <?php if (!$comment->isDeleted() && Auth::isOwner($owner->getId())) { ?>
                        <a href="<?= Routing::getCustomUrlTo('edit_comment', ['id'=>$comment->getId()]) ?>">Edit</a>
                        <a href="<?= Routing::getCustomUrlTo('delete_comment', ['id'=>$comment->getId()]) ?>">Delete</a>
                    <?php } ?>
                </div>
            </div>

            <?php if ($comment->isDeleted()) { ?>
                <p>[deleted]</p>
            <?php } else { ?>
                <p><?= $comment->getContent() ?></p>
            <?php } ?>

            <div class="d-flex align-items-center">
                <div class="me-2"><?= $comment->getLikes() ?> Likes</div>
                <a href="<?= Routing::getCustomUrlTo('reply_to_comment', ['id'=>$comment->getId()]) ?>" class="me-2"><i class="far fa-comment-alt me-1"></i>Reply</a>

                <a href="<?= Routing::getCustomUrlTo('like_comment', ['id'=>$comment->getId()]) ?>" class="me-2">
                    <?php if (Like::exists(Auth::get('id') ?? 0, $comment->getId())) { ?>
                        <i class="fas fa-heart me-1"></i>
                    <?php } else { ?>
                        <i class="far fa-heart me-1"></i>
                    <?php } ?>
                </a>

            </div>
            </div>
        </div>
    </li>

    <?php } ?>

<section class="mx-auto">

    <?php require_once 'Post.php'; ?>

    <hr class="mt-1">

    <div class="d-flex align-items-center">
        <?php if (Auth::isAuthenticated()) {
            $currentUser = User::fetch(Auth::get('id'));
            $amountOfVotes = Vote::getVoteAmount($post->getId(), Auth::get('id'));
            $formAction = "/" . constant('URL_SUBFOLDER') . "/vote/post/" . $post->getId() . "/user/" . Auth::get('id');
            $remainingPoggers = $currentUser->getRemainingPoggers();

            ?>
            <a href="<?= Routing::getCustomUrlTo('reply_to_post', ['id'=>$post->getId()]) ?>">Create a comment</a>
        <form method="post" action="<?= $formAction ?>" class="d-flex align-items-center ms-auto">
            <input style="width: 80px" class="form-control border-none" value="<?= $amountOfVotes ?>" type="number" name="amount" min="1" max="<?= $remainingPoggers + $amountOfVotes ?>" required/>
            <button class="btn btn-primary ms-2" type="submit">POG</button>
        </form>
        <?php } ?>
    </div>

    <ul class="list-group list-group-flush">
        <?php show_comments($post); ?>
    </ul>
</section>

<?php include 'Footer.php'; ?>
