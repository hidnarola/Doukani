<?php
echo '<option value="">Select Plate Prefix</option>';
foreach ($plate_prefix as $plate) {
            
    if($plate['id']==$sel_city && isset($sel_prefix) && $sel_prefix!=0) 
    {
            echo '<option value='.$plate['id'].' selected>'.$plate['prefix'].' </option>';
    }
    else  
    {
            echo '<option value='.$plate["id"].'>'.$plate["prefix"].'</option>';
    }
    
} 
?>
<option value="-1">Other</option>