<?php

use App\Models\Post;
use App\Models\User;

$posts = Post::fetchAllInCurrentComp();

include 'Header.php'; ?>

<section class="mx-auto">
    <h1 class="mb-5 text-center">Feed</h1>

    <?php
    foreach ($posts as $postArr) {
        $post = new Post();
        $post->load($postArr['post_id']);
        $user = User::fetch($postArr['user_id']);

        include 'Post.php';
        echo "<hr class='my-5'>";
    }
?>

<section>

<?php include 'Footer.php'; ?>