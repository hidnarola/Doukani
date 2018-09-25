<select data-type="reloadMap" class="form-control " name="show_sub_category" id="show_sub_category" onchange="show_sub_cat_fields(this.value);" >
    <option value="">Select Sub Category</option>
    <?php foreach ($subcat as $cat): ?>    
        <option value="<?php echo $cat['sub_category_id'] ?>" <?php echo set_select('sub_cat', @$_POST['sub_cat']);
    if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0 && $cat['sub_category_id'] == $user_sub_category_id) echo 'selected=selected';
    elseif (isset($sel_sub_cat) && (int) $sel_sub_cat == (int) $cat['sub_category_id']) echo 'selected=selected'; ?> ><?php echo $cat['sub_category_name']; ?></option>


<?php endforeach; ?>
</select>
<label id="subcat_id_err" class="error" style="display:none;">This field is required.</label>