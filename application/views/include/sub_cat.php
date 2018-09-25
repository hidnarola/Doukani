<select class="form-control" name="sub_cat" id="sub_cat_">
    <option value="0">All</option>
    <?php foreach ($subcat as $cat): ?>        
        <option value="<?php echo $cat['sub_category_id']; ?>" <?php echo set_select('sub_cat', @$_REQUEST['sub_cat']) ?> ><?php echo $cat['sub_category_name']; ?></option>        
    <?php endforeach; ?>
</select>