<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Product Order Confirmation</title>
		</head>
		<body>
		<div style="width:1012px;background:#FFFFFF; margin:0 auto;">
		<div style="width:100%;background:#454B56; float:left; margin:0 auto;">
		<div style="padding:20px 0 10px 15px;float:left; width:50%;"><a href="'.base_url().'" target="_blank" id="logo"><img src="'.base_url().'images/logo/'.$this->data['logo'].'" alt="'.$this->data['WebsiteTitle'].'" title="'.$this->data['WebsiteTitle'].'" width="100"></a></div>
		</div>			
		<!--END OF LOGO-->
		<!--start of deal-->
		<div style="width:970px;background:#FFFFFF;float:left; padding:20px; border:1px solid #454B56; ">
		<div style=" float:right; width:35%; margin-bottom:20px; margin-right:7px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #cecece;">
		<tr bgcolor="#f3f3f3">
		<td width="87"  style="border-right:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Order Id</span></td>
		<td  width="100"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">'.$PrdList->row()->dealCodeNumber.'</span></td>
		</tr>
		<tr bgcolor="#f3f3f3">
		<td width="87"  style="border-right:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Order Date</span></td>
		<td  width="100"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">'.date("F j, Y g:i a",strtotime($PrdList->row()->created)).'</span></td>
		</tr>
		 <tr bgcolor="#f3f3f3" >
						<td width="87" style="border-right:1px solid #cecece;">
							<span><b>Payment Instruction</b></span></td>
							<td width="100">
							<span>  '. $pay_method.' </span>
							<span style="color: red;"><b>'.$pay_status.'</b></span>
						</td>
					 </tr>
		</table>
		</div>
		
    <div style="float:left; width:100%;">';
	if($shipAddRess->row()->full_name!=''){
		$message.='<div style="width:49%; float:left; border:1px solid #cccccc; margin-right:10px;">
    	<span style=" border-bottom:1px solid #cccccc; background:#f3f3f3; width:95.8%; float:left; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000305;">Shipping Address</span>
    		<div style="float:left; padding:10px; width:96%;  font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#030002; line-height:28px;">
            	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                	<tr><td>Full Name</td><td>:</td><td>'.stripslashes($shipAddRess->row()->full_name).'</td></tr>
                    <tr><td>Address</td><td>:</td><td>'.stripslashes($shipAddRess->row()->address1).'</td></tr>
					<tr><td>Address 2</td><td>:</td><td>'.stripslashes($shipAddRess->row()->address2).'</td></tr>
					<tr><td>City</td><td>:</td><td>'.stripslashes($shipAddRess->row()->city).'</td></tr>
					<tr><td>Country</td><td>:</td><td>'.stripslashes($shipAddRess->row()->country).'</td></tr>
					<tr><td>State</td><td>:</td><td>'.stripslashes($shipAddRess->row()->state).'</td></tr>
					<tr><td>Zipcode</td><td>:</td><td>'.stripslashes($shipAddRess->row()->postal_code).'</td></tr>
					<tr><td>Phone Number</td><td>:</td><td>'.stripslashes($shipAddRess->row()->phone).'</td></tr>
            	</table>
            </div>
     </div>';
	}else{        
		$message.='<div style="width:49%; float:left; margin-right:10px;">&nbsp;</div>';
	}
	$message.='
    
    
    <div style="width:49%; float:left; border:1px solid #cccccc;">
    	<span style=" border-bottom:1px solid #cccccc; background:#f3f3f3; width:95.7%; float:left; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000305;">Billing Address</span>
    		<div style="float:left; padding:10px; width:96%;  font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#030002; line-height:28px;">
            	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                	<tr><td>Full Name</td><td>:</td><td>'.stripslashes($shipAddRess->row()->full_name).'</td></tr>
                    <tr><td>Address</td><td>:</td><td>'.stripslashes($shipAddRess->row()->address1).'</td></tr>
					<tr><td>Address 2</td><td>:</td><td>'.stripslashes($shipAddRess->row()->address2).'</td></tr>
					<tr><td>City</td><td>:</td><td>'.stripslashes($shipAddRess->row()->city).'</td></tr>
					<tr><td>Country</td><td>:</td><td>'.stripslashes($shipAddRess->row()->country).'</td></tr>
					<tr><td>State</td><td>:</td><td>'.stripslashes($shipAddRess->row()->state).'</td></tr>
					<tr><td>Zipcode</td><td>:</td><td>'.stripslashes($shipAddRess->row()->postal_code).'</td></tr>
					<tr><td>Phone Number</td><td>:</td><td>'.stripslashes($shipAddRess->row()->phone).'</td></tr>
            	</table>
            </div>
    </div>
</div> 
	   
<div style="float:left; width:100%; margin-right:3%; margin-top:10px; font-size:14px; font-weight:normal; line-height:28px;  font-family:Arial, Helvetica, sans-serif; color:#000; overflow:hidden;">   
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="3">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #cecece; width:99.5%;">
					<tr bgcolor="#f3f3f3">
						<td width="17%" style="border-right:1px solid #cecece; text-align:center;">
							<span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Bag Items</span>
						</td>
						<td width="43%" style="border-right:1px solid #cecece;text-align:center;">
							<span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Product Name</span>
						</td>';
					if($digital_item == 'No'){			
						$message.=
						'<td width="12%" style="border-right:1px solid #cecece;text-align:center;">
							<span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Qty</span>
						</td>';
					}
					$message.=
						'<td width="14%" style="border-right:1px solid #cecece;text-align:center;">
							<span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Unit Price</span>
						</td>
						<td width="15%" style="text-align:center;">
							<span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center;">Sub Total</span>
						</td>
					</tr>';	   
			
					$disTotal =0; $giftdisTotal =0;  $shipCost = $grantTotal = 0; $digiDownload=0;
					foreach ($PrdList->result() as $cartRow){
						$product_name = mb_convert_encoding($cartRow->product_name, 'HTML-ENTITIES', 'UTF-8');
						//stripslashes($cartRow->product_name).$atr
						$InvImg = @explode(',',$cartRow->pd_image); 
						$unitPrice = $cartRow->price; 
						$uTot = $unitPrice*$cartRow->quantity;
						if($cartRow->attribute_values != ''){ 
							$atr = '<br>'.$cartRow->attribute_values; }elseif($catRow->attribute_values !=''){$atr = '<br>'.$cartRow->attribute_values; }else{ $atr = '';
						}
						if($cartRow->digital_files != ''){ $digiDownload++; }
						$message.=
					'<tr>
						<td style="border-right:1px solid #cecece; text-align:center;border-top:1px solid #cecece;">
							<span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;">
								<img src="'.base_url().PRODUCTPATHTHUMB.$InvImg[0].'" alt="'.$product_name.'" width="70" />
							</span>
						</td>
						<td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;">
							<a href="'.base_url().'products1/'.urlencode($cartRow->sp_sku).'/'.urlencode($cartRow->pdseourl).'/'.urlencode($cartRow->pd_seller_product_id).'">
								<span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;text-align:center;">'.$product_name.'</span>
							</a>
						</td>';
				if($digital_item == 'No'){			
					$message.='<td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;">'.strtoupper($cartRow->quantity).'</span></td>';			
				}
				$message.='<td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;">'.$this->data['currencySymbol'].number_format($unitPrice * $this->data['currencyValue'],2,'.','').'</span></td>
				<td style="text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:30px;  text-align:center;">'.$this->data['currencySymbol'].number_format($uTot * $this->data['currencyValue'],2,'.','').'</span></td>
			</tr>';
		$grantTotal = $grantTotal + $uTot;
		$shipCost+= $cartRow->shippingcost;
}

	
	$sql = "SELECT sum(up.shippingcost) as tot_ship from (SELECT * FROM shopsy_user_payment WHERE user_id='".$PrdList->row()->user_id."' and dealCodeNumber='".$PrdList->row()->dealCodeNumber."' GROUP BY sell_id) as up";
	$query_result = $this->db->query($sql)->result();
	$shipCost = $query_result[0]->tot_ship;
	$private_total = $grantTotal - $PrdList->row()->discountAmount;
	$private_total = $private_total - $PrdList->row()->giftdiscountAmount; 
	$private_total = $private_total + $PrdList->row()->tax + $shipCost;
				 
$message.='</table></td> </tr><tr><td colspan="3"><table border="0" cellspacing="0" cellpadding="0" style=" margin:10px 0px; width:99.5%;"><tr>
			<td width="460" valign="top" >';

if($PrdList->row()->note !=''){
	$message.='<table width="97%" border="0"  cellspacing="0" cellpadding="0"><tr>
                <td width="87" ><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:left; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Note:</span></td>
               
            </tr>
			<tr>
                <td width="87"  style="border:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:left; width:97%; color:#000000; line-height:24px; float:left; margin:10px;">'.stripslashes($PrdList->row()->note).'</span></td>
            </tr></table>';
}
			
if($PrdList->row()->order_gift == 1){
	$message.='<table width="97%" border="0"  cellspacing="0" cellpadding="0"  style="margin-top:10px;"><tr>
                <td width="87"  style="border:1px solid #cecece;"><span style="font-size:16px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; text-align:center; width:97%; color:#000000; line-height:24px; float:left; margin:10px;">This Order is a gift</span></td>
            </tr></table>';
}
			
$message.='</td>
            <td width="174" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #cecece;">
            <tr bgcolor="#f3f3f3">
                <td width="87"  style="border-right:1px solid #cecece;border-bottom:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Sub Total</span></td>
                <td  style="border-bottom:1px solid #cecece;" width="69"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">'.$this->data['currencySymbol'].number_format($grantTotal * $this->data['currencyValue'],'2','.','').'</span></td>
            </tr>';
if($PrdList->row()->discountAmount > 0){			
	$message.='<tr>
                <td width="87"  style="border-right:1px solid #cecece;border-bottom:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Coupon Discount</span></td>
                <td  style="border-bottom:1px solid #cecece;" width="69"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">'.$this->data['currencySymbol'].number_format($PrdList->row()->discountAmount * $this->data['currencyValue'],'2','.','').'</span></td>
            </tr>';
}
if($PrdList->row()->giftdiscountAmount > 0){			
	$message.='<tr>
                <td width="87"  style="border-right:1px solid #cecece;border-bottom:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Gift Discount</span></td>
                <td  style="border-bottom:1px solid #cecece;" width="69"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">'.$this->data['currencySymbol'].number_format($PrdList->row()->giftdiscountAmount * $this->data['currencyValue'],'2','.','').'</span></td>
            </tr>';
}			
if($shipCost > 0){
	$message.='<tr bgcolor="#f3f3f3">
            <td width="31" style="border-right:1px solid #cecece;border-bottom:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:center; width:100%; color:#000000; line-height:38px; float:left;">Shipping Cost</span></td>
                <td  style="border-bottom:1px solid #cecece;" width="69"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%;  float:left;">'.$this->data['currencySymbol'].number_format($shipCost * $this->data['currencyValue'],2,'.','').'</span></td>
              </tr>';
}			  
if($PrdList->row()->tax > 0){			  
	$message.='';
}			  
$message.='<tr bgcolor="#f3f3f3">
                <td width="87" style="border-right:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">Grand Total</span></td>
                <td width="31"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%;  float:left;">'.$this->data['currencySymbol'].number_format($private_total * $this->data['currencyValue'],'2','.','').'</span></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
        </tr>
    </table>
        </div>
        
        <!--end of left--> 
		<div style="width:50%; float:left;">';
		if($digiDownload>0){
				$message.='<div style="float:left; width:100%;font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; width:100%; color:#000000; line-height:38px; ">'.$digiDownload.' Products are having the digital files in this order, Click <span><a href="'.base_url().'digital-files/'.$enc_user_id.'/'.$enc_dealCodeNumber.'"> here</a> </span>to download these.</div>';
		}
            	$message.='<div style="float:left; width:100%;font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; width:100%; color:#000000; line-height:38px; "><span>'.stripslashes($PrdList->row()->full_name).'</span>,thank you for your purchase.</div>
               <ul style="width:100%; margin:10px 0px 0px 0px; padding:0; list-style:none; float:left; font-size:12px; font-weight:normal; line-height:19px; font-family:Arial, Helvetica, sans-serif; color:#000;">
                    <li>If you have any concerns please contact us.</li>
                    <li>Email: <span>'.stripslashes($SellList->row()->email).' </span></li>
               </ul>
        	</div>
            
            <div style="width:27.4%; margin-right:5px; float:right;">
            
           
            </div>
        
        <div style="clear:both"></div>
        
    </div>
    </div></body></html>