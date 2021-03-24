<?php if (!empty($action) && !empty($type) && !empty($button)) : ?>
    <form method="POST" action="<?php echo admin_url('admin.php'); ?>">
        <input type="hidden" name="action" value="<?= $action; ?>" />
        <input type="hidden" name="type" value="<?= $type; ?>" />
        <input type="submit" value="<?= $button; ?>" />
    </form>
<?php endif; ?>