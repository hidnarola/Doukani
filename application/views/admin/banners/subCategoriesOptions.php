<?php
foreach ($categories as $record) {
    ?>
    <option id="<?php echo $record['sub_category_id']; ?>" value="<?php echo $record['sub_category_id']; ?>" style="padding-top:10px;"><?php echo $record['sub_category_name']; ?></option>	
    <?php
}
?>