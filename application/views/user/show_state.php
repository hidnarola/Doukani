<?php foreach ($state as $cat): ?>
    <?php if ($mystate == $cat['state_id']) { ?>
        <option value="<?php echo $cat['state_id']; ?>" selected><?php echo $cat['state_name'] ?></option>
    <?php } else { ?>
        <option value="<?php echo $cat['state_id']; ?>"><?php echo $cat['state_name'] ?></option>
    <?php } ?>
<?php endforeach; ?>

