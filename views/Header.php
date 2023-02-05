<?php

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\User;

/**
 * @var Routing
 * @var Auth
 */

if (Auth::isAuthenticated()) {
    $user = User::fetch(Auth::get('id'));
}

?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="<?= '/' . constant('URL_SUBFOLDER').'/public/images/icon.png'?>">
    <title>MemeChamp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= '/' . constant('URL_SUBFOLDER').'/public/css/style.css'?>">
    <script src="https://kit.fontawesome.com/e74decf3a7.js" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= Routing::getUrlTo('homepage') ?>">
            MemeChamp
        </a>

        <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= Routing::getUrlTo('homepage') ?>">Feed</a>
                </li>

                <?php if (Auth::isAuthenticated()) { ?>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= Routing::getUrlTo('create_post') ?>">Create Post</a>
                </li>
                <?php } ?>

            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <?php if (Auth::isAuthenticated()) { ?>
                    <?php if ($user->isIsAdmin()) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Routing::getUrlTo('dashboard') ?>">Dashboard</a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link"><?= $user->getRemainingPoggers() ?>/<?= $user->getMaxPoggers() ?> POGGERS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Routing::getCustomUrlTo('profile', ['userId' => Auth::get('id')]) ?>"><?= Auth::get('username') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Routing::getUrlTo('signout') ?>">Sign Out</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Routing::getCustomUrlTo('signup', ['status'=>'']) ?>">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Routing::getCustomUrlTo('signin', ['status'=>'']) ?>">Sign In</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

