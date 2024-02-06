<?php

use Framework\Session; ?>

<?php if (Session::has('success_message')) : ?>
    <div class="text-center message bg-green-100 px-4 py-6 my-3">
        <?= Session::get('success_message') ?>
    </div>
    <?php Session::clear('success_message'); ?>
<?php endif; ?>
<?php if (Session::has('error_message')) : ?>
    <div class="text-center message bg-red-100 px-4 py-4 my-3">
        <?= Session::get('error_message') ?>
    </div>
    <?php Session::clear('error_message'); ?>
<?php endif; ?>