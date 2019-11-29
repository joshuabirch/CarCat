<!-- if there are errors in the array -->
<?php if(count($errors) > 0) : ?>
<!-- build an alert box -->
<div class="alert alert-danger p-2 mb-1" role="alert">
    <!-- Run a foreach loop to display all indexes from array -->
    <?php foreach ($errors as $error) : ?>
        <p class="m-0"><?php echo $error ?></p>
    <?php endforeach ?>
</div>
<?php endif ?>