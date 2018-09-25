<select data-type="reloadMap" class="subcat_cls select2 form-control" name="sub_cat" id="sub_cat" onchange="show_sub_cat_fields(this.value);"   <?php if(isset($user_sub_category_id) && (int)$user_sub_category_id>0) 	echo 'disabled'; ?> >
    <option value="">Select Sub Category</option>
<?php foreach ($subcat as $cat): ?>
	<?php if(isset($_POST['sub_cat_id']) && $cat['sub_category_id']==$_POST['sub_cat_id']) { ?>
	<option value="<?php echo $cat['sub_category_id']; ?>" selected><?php echo $cat['sub_category_name']; ?></option>
	<?php } else { ?>
    <option value="<?php echo $cat['sub_category_id']; ?>" 
    	<?php echo set_select('sub_cat', @$_POST['sub_cat']); 
    		if(isset($user_sub_category_id) && (int)$user_sub_category_id>0 && $cat['sub_category_id']==$user_sub_category_id) {
    				echo 'selected=selected';
    		}
		?> 
    	><?php echo $cat['sub_category_name']; ?></option>
<?php }  endforeach; ?>
</select>
<label id="subcat_id_err" class="error" style="display:none;"><font color="#b94a48">This field is required.</font></label>
