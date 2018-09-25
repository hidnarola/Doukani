<?php
foreach ($categories as $record) {
    ?>
    <option id="<?php echo $record['category_id']; ?>" value="<?php echo $record['category_id']; ?>" style="padding-top:10px;"><?php echo $record['catagory_name']; ?></option>	
    <?php
}
?>