<?php
	echo '<option value="">Select Emirate</option>';
	foreach ($state as $cat){if($cat['state_name']!='') {
		
		if($cat['state_id']==$sel_city && isset($sel_city) && $sel_city!=0) 
		{
			echo '<option value='.$cat['state_id'].' selected>'.$cat['state_name'].' </option>';
		} 
		else  
		{
			echo '<option value='.$cat["state_id"].'>'.$cat["state_name"].'</option>';
		}		
	}
} ?>