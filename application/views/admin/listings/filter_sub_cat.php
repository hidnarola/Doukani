<select id="subcategory" class="select2 form-control" onchange="show_list();" name="sub_cat" 
	
	<?php if(isset($_REQUEST['filter']) && $_REQUEST['filter']=="category") echo ''; else echo 'style="display:none;"'; ?>	
	<?php if(isset($user_sub_category_id) && (int)$user_sub_category_id>0) 	echo 'disabled=disabled'; ?>
	>
	    <option value="0">All Sub Category</option>
	    <?php foreach ($subcat as $cat): 
			if(isset($_REQUEST['sel_subcat']) && $_REQUEST['sel_subcat']==$cat['sub_category_id']) {
		?>	
		<option value="<?php echo $cat['sub_category_id']; ?>" selected><?php echo $cat['sub_category_name']; ?></option>
		<?php }
		 elseif(isset($user_sub_category_id) && (int)$user_sub_category_id>0 && $cat['sub_category_id']==$user_sub_category_id) {
		 	?>
				<option value="<?php echo $cat['sub_category_id']; ?>" <?php if(isset($selected) && $selected>0 ) echo 'selected'; ?>><?php echo $cat['sub_category_name']; ?></option>
		 	<?php 
		 }
		 else {?>
	    <option value="<?php echo $cat['sub_category_id']; ?>"><?php echo $cat['sub_category_name'] ?></option>
	<?php  }  endforeach; ?>
</select>