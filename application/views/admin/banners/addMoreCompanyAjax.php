<div class='form-group'>
    <label class='col-md-2 control-label' for='inputSelect'>Offer Company</label>
    <div class='col-md-5'>
        <select class="form-control select2" name="offer_user_company_id_<?php echo $curInd; ?>[]" id="offer_user_company_id<?php echo $curInd; ?>_<?php echo $curInd2; ?>">
            <option value="0">Select Company</option>
            <?php
            foreach ($company as $com) {
                ?>
                <option value="<?php echo $com['id']; ?>" style="padding-top:15px;"><?php echo str_replace('\n', " ", $com['company_name']); ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>