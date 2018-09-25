<div class='form-group'>
    <label class='col-md-2 control-label' for='inputSelect'>Select Super Category</label>
    <div class='col-md-5'>
        <select class="form-control" name="superCategory_<?php echo $curInd; ?>[]" id="superCategory_<?php echo $curInd; ?>_<?php echo $curInd2; ?>"  onchange="showSubcategory(this, '<?php echo $curInd; ?>', '<?php echo $curInd2; ?>')">
            <option value="0">Select Super Category</option>
            <?php
            foreach ($superCategories as $scategory) {
                ?>
                <option value="<?php echo $scategory['category_id']; ?>" style="padding-top:15px;"><?php echo str_replace('\n', " ", $scategory['catagory_name']); ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>

<div class='form-group'>
    <label class='col-md-2 control-label' for='inputSelect'>Select Sub Category</label>
    <div class='col-md-5'>
        <select name="category_<?php echo $curInd; ?>[]" id="sub_category_<?php echo $curInd; ?>_<?php echo $curInd2; ?>" class="form-control">
        </select>
    </div>
</div>
