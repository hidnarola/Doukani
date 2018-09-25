<?php foreach ($state as $cat): ?>
    <option value="<?php echo $cat['state_id']; ?>"><?php echo $cat['state_name'] ?></option>
<?php endforeach; ?>