<?php

use App\Helpers\Routing;

require_once 'Header.php';

?>

<section class="mx-auto text-center">
    <h1>Dashboard</h1>

    <form action="<?= Routing::getUrlTo('handle_competition_ending') ?>" method="post">
        <button class="btn btn-primary" type="submit">Create new competition</button>
    </form>
</section>

<?php
require_once 'Footer.php';
?>
