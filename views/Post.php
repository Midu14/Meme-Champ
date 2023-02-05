<?php

/**
 * @var Post $post
 * @var User $user
 */

use App\Helpers\Routing;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;

?>

<section class="mx-auto mt-3 p-0">
    <div class="">
        <div class="d-flex justify-content-between">
            <div class="d-flex">
                <div class="pfp-wrapper rounded-circle" style="height: 20px; width: 20px">
                    <img class="pfp" src="<?= '/' . constant('URL_SUBFOLDER').'/public/images/uploads/pfps/' . $user->getPfp() ?>">
                </div>
                <small class="ms-1"><a href="<?= Routing::getCustomUrlTo('profile', ['userId'=>$user->getId()]) ?>"><?= $user->getUsername() ?></a></small>
            </div>

            <small><?= $post->getCreatedAt() ?></small>
        </div>
        <h3><a href="<?= Routing::getCustomUrlTo('post', ['id'=>$post->getId()]) ?>"><?= $post->getTitle() ?></a></h3>
        <img class="border" width="100%" src="<?= '/' . constant('URL_SUBFOLDER').'/public/images/uploads/memes/' . $post->getImg() ?>">
        <div class="mt-3">
            <?= Vote::getTotalVotesForPost($post->getId()) ?> Poggers
        </div>
    </div>
</section>