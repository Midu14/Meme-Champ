<?php

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;

include 'Header.php';

/**
 * @var Auth
 * @var Routing
 * @var string $tab
 * @var string $userId
 */

$user = User::fetch($userId);

function renderComments(User $user)
{
    $comments = $user->getComments();

    if (empty($comments)) {
        echo "no comments";
        return;
    }

    echo "<ul class='list-group mt-3'>";
    foreach ($comments as $comment) {
        if (!$comment->isDeleted()) {
            $content = $comment->getContent();
            $post = (new Post())->load($comment->getPostId());
            $likes = $comment->getLikes();
            $urlToPost = Routing::getCustomUrlTo('post', ['id'=>$comment->getPostId()]);
            ?>

            <a href='<?= $urlToPost ?>'>
                <li class='list-group-item mb-2'>
                    <div class="d-flex">
                        <div><small>Post: <?= $post->getTitle() ?></small></div>
                        <div class="ms-auto"><small><?= $comment->getCreatedAt() ?></small></div>
                    </div>

                    <div class="d-flex">
                        <div>
                            <strong><?= $content ?></strong>
                        </div>
                        <div class="ms-auto"><?= $likes ?> LIKES</div>
                    </div>
                </li>
            </a>

            <?php
        }
    }
    echo "</ul>";
}

function renderPosts(User $user)
{
    $posts = $user->getPosts();

    if (empty($posts)) {
        echo "no posts";
        return;
    }

    echo "<ul class='list-group mt-3'>";
    foreach ($posts as $post) {
        $urlToPost = Routing::getCustomUrlTo('post', ['id'=>$post->getId()]);
        ?>

        <a href='<?= $urlToPost ?>'>
            <li class='list-group-item'>
                <div class="d-flex">
                    <div><small>Posted By <?= $user->getUsername() ?></small></div>
                    <div class="ms-auto"><small><?= $post->getCreatedAt() ?></small></div>
                </div>
                <div class="d-flex">
                    <div><strong><?= $post->getTitle() ?></strong></div>
                    <div class="ms-auto"><?= Vote::getTotalVotesForPost($post->getId()) ?> POGGERS</div>
                </div>
            </li>
        </a>

        <?php
    }
}

function renderVoted(User $user)
{
    
}

function renderLiked(User $user)
{

}

?>
    <style>
        .pfp-wrapper {
            width: 160px;
            height: 160px;
            overflow: hidden;
        }
        .pfp {
            height: inherit;
            width: inherit;
            object-fit: cover;
        }

        section {
            padding: 20px;
            max-width: 600px;
        }
        input, label, small {
            display: block;
        }
        ul {
            list-style: none;
            padding: 0;
        }
    </style>

    <section class="mx-auto">
        <div class="row border rounded shadow p-3 mb-4">
            <div class="col p-0 m-0">

                <?php if (Auth::isOwner($user->getId())) { ?>
                    <a class="" href="<?= Routing::getCustomUrlTo('update_pfp', ['id' => Auth::get('id')]) ?>">
                <?php } ?>

                <div class="pfp-wrapper rounded-circle shadow">
                    <?php if ($user->getPfp()) { ?>
                        <img class="pfp" src="<?= '/'.constant('URL_SUBFOLDER').'/public/images/uploads/pfps/'.$user->getPfp() ?>"/>
                    <?php } else { ?>
                        <img class="pfp" src="<?= '/'.constant('URL_SUBFOLDER').'/public/images/uploads/pfps/defaultpfp.jpg' ?>"/>
                    <?php } ?>
                </div>

                <?php if (Auth::isOwner($user->getId())) { ?>
                    </a>
                <?php } ?>

            </div>
            <div class="col py-3">
                <h2 class="d-inline"><?= $user->getUsername() ?></h2>
                <?php if (Auth::isOwner($user->getId())) { ?>
                    <a class="ms-2" href="<?= Routing::getCustomUrlTo('update_username', ['id' => Auth::get('id')]) ?>">Change</a>
                <?php } ?>
            </div>


            <div class="col text-end p-0 py-3">

            </div>

        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?= $tab == 'posts' ? 'active' : '' ?>" href="<?= Routing::getCustomUrlTo('profile', ['userId' => $user->getId()]) ?>">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $tab == 'comments' ? 'active' : '' ?>" href="<?= Routing::getCustomUrlTo('profile', ['userId' => $user->getId(), 'tab' => 'comments']) ?>">Comments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $tab == 'voted' ? 'active' : '' ?>" href="<?= Routing::getCustomUrlTo('profile', ['userId' => $user->getId(), 'tab' => 'voted']) ?>">Voted</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $tab == 'liked' ? 'active' : '' ?>" href="<?= Routing::getCustomUrlTo('profile', ['userId' => $user->getId(), 'tab' => 'liked']) ?>">Liked</a>
            </li>
        </ul>

        <?php
            if ($tab == 'comments') {
                renderComments($user);
            } else if ($tab == 'voted') {
                renderVoted($user);
            } else if ($tab == 'liked') {
                renderLiked($user);
            } else {
                renderPosts($user);
            }
        ?>

    <section>
<?php include 'Footer.php'; ?>