<?php 
	if(sizeof($model)>0) {
	foreach ($model as $cat): ?>
    <option value="<?php echo $cat['model_id']; ?>"><?php echo $cat['name'] ?></option>
<?php endforeach; } ?>
<option value="-1">Other</option>

