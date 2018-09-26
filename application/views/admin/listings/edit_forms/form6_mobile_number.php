<?php
if (isset($_REQUEST['request_for']) && $_REQUEST['request_for'] == 'user' && isset($_REQUEST['userid'])) {    
    $page_redirect = (isset($_GET['page'])) ? '&page='.$_GET['page'] : '';
    $myredirect_path = base_url() . 'admin/classifieds/listings_edit/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $product[0]['product_id'] . '/?request_for=user&userid=' . $_REQUEST['userid'].$page_redirect; 
    $cancel_path = base_url() . 'admin/classifieds/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/?request_for=user&userid=' . $_REQUEST['userid'].$page_redirect; 
}
else {
    $page_redirect = (isset($_GET['page'])) ? '?page='.$_GET['page'] : '';
    $myredirect_path = base_url() . 'admin/classifieds/listings_edit/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $product[0]['product_id'].$page_redirect;
    $cancel_path = base_url() . 'admin/classifieds/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . $page_redirect;
}
?>
<form  name="mobile_number_form" action='<?php echo $myredirect_path; ?>' class='form form-horizontal validate-form mobile_number_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form6">
    <h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
    <hr />
    <input type="hidden" name="cat_id" id="cat_id_form6" value="<?php echo $product[0]['category_id']; ?>">
    <input type="hidden" name="sub_cat" id="sub_cat_form6" value="<?php echo $product[0]['sub_category_id']; ?>">
    <div class='form-group'>
        <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
        <div class='col-md-5 controls'>
            <input placeholder='Product Name' class="form-control" name="pro_name" type='text'  maxlength="80" value="<?php if(isset($product[0]['product_name'])) echo $product[0]['product_name']; ?>" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Description<span> *</span></label>
        <div class='col-md-8 col-sm-8 '>
            <textarea class='input-block-level wysihtml5 form-control' id="mob_desc" placeholder="Description" name="mob_desc" rows="10"   data-rule-required='true' ><?php if(isset($product[0]['product_description'])) echo $product[0]['product_description']; ?></textarea>
        </div>
    </div>    
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Price</label>
        <div class='col-md-3 controls'>
            <input class="form-control price_txt"  placeholder="Price" name="pro_price" type="text"   value="<?php if(isset($product[0]['product_price'])) echo $product[0]['product_price']; ?>" />
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
            <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?php echo price_zero_label; ?>
            </div>
        </div>
    </div>
    <?php if(isset($product[0]['product_for']) && $product[0]['product_for']=='store') { ?>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Total Stock<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control total_stock"  placeholder="Total Stock" value="<?php if(isset($product[0]['total_stock'])) echo $product[0]['total_stock']; ?>" name="total_stock" type="text"  data-rule-required='true' />
        </div>
    </div>
    <?php } ?>
    <div class="form-group">                    
        <label class='col-md-2 control-label' for='inputText1'>Mobile Operator<span> *</span></label>
        <div class="col-md-5 controls">
            <select class="select2 form-control" name="mobile_operators" id="mobile_operators"  data-rule-required='true' >
                <option value="">Select Mobile Operator</option>
                <?php foreach ($mobile_operators as $pl): ?>
                    <option value="<?php echo $pl['id'] ?>" <?php if(isset($product[0]['mobile_operator']) && $product[0]['mobile_operator']==$pl['id']) echo 'selected=selected'; ?> ><?php echo $pl['operator_name']; ?></option>
                <?php endforeach; ?>                                                           
            </select>
        </div>
    </div>                                            
    <div class="form-group">                    
        <label class='col-md-2 control-label' for='inputText1'>Repeating Number<span> *</span></label>
        <div class="col-md-5 controls">
            <select class="select2 form-control" name="repeating_numbers_mobile" id="repeating_numbers_car"  data-rule-required='true'>
<option value="">Select # of repeating number</option>
<?php foreach ($repeating_numbers_mobile as $pl): ?>
<option value="<?php echo $pl['id'] ?>" <?php if(isset($product[0]['repeating_number']) && $product[0]['repeating_number']==$pl['id']) echo 'selected=selected'; ?> ><?php echo $pl['rep_number']; ?></option>
<?php endforeach; ?>
<option value="-1" <?php if (isset($product[0]['repeating_number']) && $product[0]['repeating_number'] == '-1') echo 'selected'; ?>>More than 8</option>
            </select>
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Mobile Number<span> *</span></label>
        <div class="col-md-5 controls">
            <input class="form-control"  placeholder="Mobile Number" name="mobile_number" type="text"   value="<?php if(isset($product[0]['mobile_number'])) echo $product[0]['mobile_number']; ?>" data-rule-required='true' />
        </div>
    </div>
    <h4><i class="fa fa-home"></i>&nbsp;&nbsp;Contact Details</h4>
    <hr />
    <div class="form-group">                    
        <label class='col-md-2 control-label' for='inputText1'>Country <span> *</span></label>
        <div class="col-md-5 controls">
            <select class="select2 form-control" name="location" id="location_con_form6" onchange="show_emirates_form6(this.value);" data-rule-required='true' >
                <option value="">Select Country</option>
                <?php foreach ($location as $st): ?>
<?php if($st['country_id'] == $product[0]['country_id']) {?>
<option value="<?php echo $st['country_id']; ?>" selected><?php echo $st['country_name']; ?></option>
<?php } else { ?>
<option value="<?php echo $st['country_id']; ?>" ><?php echo $st['country_name']; ?></option>
<?php } ?>                                        
<?php endforeach; ?>   
            </select>
        </div>
    </div>                  
    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
        <div class='col-md-5 controls'> 
            <select  name="state" class="select2 form-control" id="city_form6" data-rule-required='true'>
                 <option value="">Select Emirate</option>
               <?php foreach ($state as $o) { ?>
<option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
<?php } ?>
            </select>                     
        </div>
    </div>

    <div class="form-group">
        <label class='col-md-2 control-label' for='inputText1'>Address</label>
       <div class='col-md-5 controls'>
            <?php
            $product_latitude = '';
            $product_longitude = '';

            if ($product[0]['latitude'] != '' && $product[0]['longitude'] != '') {
                $product_latitude = $product[0]['latitude'];
                $product_longitude = $product[0]['longitude'];
            } else {
                $product_latitude = $product[0]['state_latitude'];
                $product_longitude = $product[0]['state_longitude'];
            }
            ?>
            <input  data-zoom="15" data-latitude="latitude6" data-longitude="longitude6" data-type="googleMap" data-map_id="map6" data-lat="<?= $product_latitude ?>" data-lang="<?= $product_longitude ?>" data-input_id="google_input6" id="google_input6" type="text" class="textfield form-control" value="<?= $product[0]['address'] ?>" name="address"   placeholder="Enter a location" />
            <input data-type="latitude6" type="hidden" name="latitude" value="<?= $product[0]['latitude'] ?>">
            <input data-type="longitude6" type="hidden" name="longitude" value="<?= $product[0]['longitude'] ?>">

            <span class="message_note"></span>
            <span class="message_error6" id="address_error"></span>

        </div>
    </div>
    <div class="form-group">
        <label class='col-md-2 control-label' for='inputText1'></label>
        <div class="col-md-6 col-sm-8" id="map6" style="height:300px">
        </div>
    </div>

    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"   onkeypress="return isNumber1(event)" value="<?php if(isset($product[0]['phone_no'])) echo $product[0]['phone_no']; ?>" data-rule-required='true' />
        </div>
    </div>  
    <!--  display:none;-->
    <div class="row form-group" style="margin-top:20px;display:none;" >
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class="col-md-6 col-sm-8">
            <input type="text" class="form-control" name="youtube" id="youtube_form6"/>
            <?php $ext = explode(".", $product[0]['product_image']); ?>
            <input type="text" class="form-control" name="cov_img" id="cov_img_form6" value="<?php echo $ext[0]; ?>"/></div>
    </div>
    <div class="row form-group" style="margin-top:20px; display:none;" >
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form6" name="video" /></div>
    </div>
    <?php 
        $admin_permission =  $this->session->userdata('admin_modules_permission');
             if($admin_permission == 'only_listing' ) {  ?>    
               <input id="product_is_inappropriate" name="product_is_inappropriate" class="form-control" type="hidden" value="Unapprove">                 
        <?php } else { ?>
    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
        <div class='col-md-5 controls'>
            <select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control  select2 " data-rule-required='true'>
<option value="">Select</option>
<option value="NeedReview" <?php if($product[0]['product_is_inappropriate']=='NeedReview'): echo 'selected=selected'; endif; ?>>NeedReview</option>
<option value="Approve" <?php if($product[0]['product_is_inappropriate']=='Approve'): echo 'selected=selected'; endif; ?>>Approve</option>
<option value="Unapprove" <?php if($product[0]['product_is_inappropriate']=='Unapprove'): echo 'selected=selected'; endif; ?>>Unapprove</option>
<option value="Inappropriate" <?php if($product[0]['product_is_inappropriate']=='Inappropriate'): echo 'selected=selected'; endif; ?>>Inappropriate</option>
</select>                       
        </div>
    </div>
    <?php } ?>
    <div class="form-actions form-actions-padding-sm btn-btm-css">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <button class='btn btn-primary' type='submit' id="form6_submit" name="mobile_number_submit" >
                    <i class="fa fa-floppy-o"></i>
                    <?php echo ($product[0]['product_is_inappropriate']=='NeedReview' && $product[0]['product_image']==NULL) ? 'Repost' : 'Submit' ?>
                </button>
                <a href='<?php echo $cancel_path; ?>' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form6_images_arr" id="form6_images_arr"   class="form-control"  /> 
            </div>
        </div>
    </div>
</form>