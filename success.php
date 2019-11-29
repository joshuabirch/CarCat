<!-- build success alert box if there are messages in the array -->
<?php if(count($success) > 0) : ?>
<div class="alert alert-success p-2 mb-1" role="alert">
    <?php foreach ($success as $successful) : ?>
        <p class="m-0"><?php echo $successful ?></p>
    <?php endforeach ?>
</div>
<?php endif ?>