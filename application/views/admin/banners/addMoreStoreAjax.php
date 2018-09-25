<div class='form-group'>
    <label class='col-md-2 control-label' for='inputSelect'>Select Store</label>
    <div class='col-md-5'>
        <select class="form-control select2" name="store_id_<?php echo $curInd; ?>[]" id="store_id<?php echo $curInd; ?>_<?php echo $curInd2; ?>">
            <option value="0">Select Store</option>
            <?php
            foreach ($stores as $s) {
                ?>
                <option value="<?php echo $s['store_id']; ?>" style="padding-top:15px;"><?php echo $s['store_domain'].'.doukani.com'; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>