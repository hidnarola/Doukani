<div id="shipping_addresses_list">
    <div class="adress-block">
<?php  if(isset($shipping_addresses) && sizeof($shipping_addresses)>0) { 

$i = 0;
$len = count($shipping_addresses);
foreach($shipping_addresses as $address) {
        
        $checked = '';
        if(isset($shipping_part) && $shipping_part=='yes') {
            if ($i == $len - 1)
                $checked = 'checked';
            else
                $checked = '';
        }
        
        echo '<label id="span_'.$address['id'].'">
                <input type="radio" name="address_select" id="address_select_'.$address['id'].'" class="address-radio" value="'.$address['id'].'" '.$checked.'>';
        echo '<p class="cart_cust_name">'.$address['customer_name'].'</p>';
        $user_address = '';
        if(!empty($address['address_1']))
                $user_address .= $address['address_1'];
        if(!empty($address['address_2']))
                $user_address .= ', '.$address['address_2'];
        if(!empty($address['state_id']))
                $user_address .= ', '.$address['state_id'];
        if(!empty($address['po_box']))
                $user_address .= ', PO Box: '.$address['po_box'];        
        echo '<address class="cart_cust_add">'.$user_address.'</address>';
        echo '<div class="action"> <a href="javascript:void(0);" id="editadd_'.$address['id'].'" class="editadd" displaytext="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;';
        echo '<a href="javascript:void(0);" id="deleteadd_'.$address['id'].'" class="deleteadd" displaytext="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i>
</a>
        </div>
        </label>';
        $i++;
}
	
}
?>
    </div>
</div>