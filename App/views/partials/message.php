<?php

use Framework\Session; ?>

<?php if ($successMessage = Session::getFlashMessage('success_message')) : ?>
    <div class="text-center message bg-green-100 px-4 py-6 my-3">
        <?= $successMessage ?>
    </div>
<?php endif; ?>

<?php if ($errorMessage = Session::getFlashMessage('error_message')) : ?>
    <div class="text-center message bg-red-100 px-4 py-6 my-3">
        <?= $errorMessage ?>
    </div>
<?php endif; ?>