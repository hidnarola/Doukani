<option value="">--Select Models--</option>
<?php foreach ($model as $cat): ?>
    <option value="<?php echo $cat['model_id']; ?>"  <?php if (isset($sel_model) && $sel_model == $cat['model_id']) echo 'selected="selected"'; ?>><?php echo $cat['name']; ?></option>
<?php endforeach; ?>
<option value="-1">Other</option>