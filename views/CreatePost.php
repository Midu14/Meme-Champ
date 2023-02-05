<?php
require_once 'Header.php';
?>


<section class="mx-auto">
    <h1>Create a post</h1>
    <form enctype="multipart/form-data" method="post">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</section>

<?php
require_once 'Footer.php';
?>
