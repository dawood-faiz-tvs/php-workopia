<?php if (isset($_SESSION['success_message'])) : ?>
    <div class="text-center message bg-green-100 px-4 py-6 my-3">
        <?= $_SESSION['success_message'] ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['error_message'])) : ?>
    <div class="text-center message bg-red-100 px-4 py-4 my-3">
        <?= $_SESSION['error_message'] ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>