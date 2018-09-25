<?php
$selected_state_id = $this->dbcommon->state_id(state_id_selection);

if ($selected_state_id == '') {
    echo '<option value="">Select Emirate</option>';
}
foreach ($state as $cat) {
    if ($cat['state_name'] != '') {
        
        
        
        if (isset($serach_emirate) && $serach_emirate == 'yes' && !empty($selected_state_id) && $selected_state_id == $cat['state_id']) {
            echo '<option value=' . $cat['state_id'] . ' selected>' . $cat['state_name'] . ' </option>';
        } else {
            if ($selected_state_id == '') {
                if ($cat['state_id'] == $sel_city && isset($sel_city) && $sel_city != 0) {
                    echo '<option value=' . $cat['state_id'] . ' selected>' . $cat['state_name'] . ' </option>';
                } else {
                    echo '<option value=' . $cat["state_id"] . '>' . $cat["state_name"] . '</option>';
                }
            }
        }
    }
}
?>