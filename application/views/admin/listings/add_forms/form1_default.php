<?php
if (isset($_GET['userid']) && $_GET['userid'] != '')
    $redirect_url = base_url() . 'admin/classifieds/listings_add/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.'?userid=' . $_GET['userid'];
else
    $redirect_url = base_url() . 'admin/classifieds/listings_add/'.$this->uri->segment(4).'/'.$this->uri->segment(5);
?>
<form  name="default_form" action='<?php echo $redirect_url; ?>' class='form form-horizontal validate-form default_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form1">
    <h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
    <hr />
    <input type="hidden" name="cat_id" id="cat_id_form1" value="<?php echo set_value('cat_id'); ?>">
    <input type="hidden" name="sub_cat" id="sub_cat_form1" value="<?php echo set_value('sub_cat'); ?>">
    <div class='form-group'>
        <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
        <div class='col-md-5 controls'>
            <input placeholder='Product Name' class="form-control" name="pro_name" type='text'  maxlength="80" value="<?php echo set_value('pro_name'); ?>" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>
        <label class='col-md-2 control-label' for='inputText1'>Description<span> *</span></label>
        <div class='col-md-8 col-sm-8'>
            <textarea class='input-block-level wysihtml5 form-control' id="pro_desc" placeholder="Description" name="pro_desc" rows="10" data-rule-required='true' ><?php echo set_value('pro_desc'); ?></textarea>
        </div>
    </div>   
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Price</label>
        <div class='col-md-3 controls'>
            <input class="form-control price_txt"  placeholder="Price" name="pro_price" type="text"   value="<?php echo (isset($_POST['pro_price']) && !empty($_POST['pro_price'])) ? set_value('pro_price') : ''; ?>" />
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
            <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?php echo price_zero_label; ?>
            </div>
        </div>
    </div>
    
    <?php //if(isset($user_role) && $user_role == 'storeUser')  { ?>
    <div class='form-group total_stock_div' <?php if(isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?> >
        <label class='col-md-2 control-label' for='inputText1'>Total Stock<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control total_stock"  placeholder="Total Stock" name="total_stock" type="text" value="<?php echo set_value('total_stock'); ?>"  />
            <input type="hidden" name="ad_type" id="form1_ad_type" value="<?php if(isset($user_role) && $user_role == 'storeUser') echo '1'; ?>">
        </div>
    </div>
    <?php //} ?>
    
    <h4><i class="fa fa-home"></i>&nbsp;&nbsp;Contact Details</h4>
    <hr />
    <div class="form-group">                    
        <label class='col-md-2 control-label' for='inputText1'>Country <span> *</span></label>
        <div class="col-md-5 controls">
            <select class="select2 form-control" name="location" id="location_con_form1" onchange="show_emirates_form1(this.value);" data-rule-required='true' >
                <option value="">Select Country</option>
                <?php foreach ($location as $st): ?>
                    <?php if ($st['country_id'] == 4) { ?>
                        <option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $st['country_id'] ?>" <?php if (isset($_REQUEST['location']) && $_REQUEST['location'] == $st['country_id']) echo set_select('location', $st['country_id']); ?> ><?php echo $st['country_name'] ?></option>
                    <?php } ?>                                        
                <?php endforeach; ?>                                   
            </select>
        </div>
    </div>                  
    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
        <div class='col-md-5 controls'> 
            <select  name="state" class="select2 form-control" id="city_form1" data-rule-required='true'>
                <option value="">Select Emirate</option>
                <?php foreach ($state as $st): ?>
                    <?php if ($st['state_id'] == @$_POST['city']) { ?>
                        <option value="<?php echo $st['state_id']; ?>" <?php echo set_select('state', @$_POST['city'], TRUE); ?> ><?php echo $st['state_name']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $st['state_id']; ?>" <?php echo set_select('state', @$_POST['city']); ?> ><?php echo $st['state_name']; ?></option>
                    <?php } ?>
                <?php endforeach; ?>
            </select>                     
        </div>
    </div> 
    <div class="form-group">
        <label class='col-md-2 control-label' for='inputText1'>Address</label>
        <div class="col-md-5 controls">
            <input  data-zoom="10" data-latitude="latitude2" data-longitude="longitude2" data-type="googleMap" data-map_id="map2" data-lat="24.231234" data-lang="54.472382" data-input_id="google_input2" id="google_input2" type="text" class="textfield form-control" value="" name="address"   placeholder="Enter a location" />
            <input data-type="latitude2" type="hidden" name="latitude" value="24.231234">
            <input data-type="longitude2" type="hidden" name="longitude" value="54.472382">

            <span class="message_note"></span>
            <span class="message_error2" id="address_error"></span>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 "></div>
        <div class="col-md-5" id="map2" style="height:300px">
        </div>
    </div>

    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"   onkeypress="return isNumber1(event)" value="<?php echo set_value('pro_phone'); ?>" data-rule-required='true' />
        </div>
    </div>  
    <!--  display:none;-->
    <div class="row form-group" style="margin-top:20px;display:none;" >
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form1"/><input type="text" class="form-control" name="cov_img" id="cov_img_form1"/></div>
    </div>
    <div class="row form-group" style="margin-top:20px; display:none;" >
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form1" name="video" /></div>
    </div>
    <?php 
        $admin_permission =  $this->session->userdata('admin_modules_permission');
             if($admin_permission == 'only_listing' ) {  ?>    
               <input id="product_is_inappropriate" name="product_is_inappropriate" class="form-control" type="hidden" value="Unapprove">                 
        <?php } else { ?>
    <div class="form-group">
        <label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
        <div class='col-md-5 controls'>
            <select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control  select2"  data-rule-required='true'>
                <option value="">Select</option>
                <option value="NeedReview" <?php if (isset($_REQUEST['product_is_inappropriate']) && $_REQUEST['product_is_inappropriate'] == 'NeedReview') echo set_select('product_is_inappropriate', 'NeedReview'); ?> >NeedReview</option>
                <option value="Approve" <?php if (isset($_REQUEST['product_is_inappropriate']) && $_REQUEST['product_is_inappropriate'] == 'Approve') echo set_select('product_is_inappropriate', 'Approve'); ?> >Approve</option>
                <option value="Unapprove" <?php if (isset($_REQUEST['product_is_inappropriate']) && $_REQUEST['product_is_inappropriate'] == 'Unapprove') echo set_select('product_is_inappropriate', 'Unapprove'); ?> >Unapprove</option>
                <option value="Inappropriate" <?php if (isset($_REQUEST['product_is_inappropriate']) && $_REQUEST['product_is_inappropriate'] == 'Inappropriate') echo set_select('product_is_inappropriate', 'Inappropriate'); ?>>Inappropriate</option>
            </select>                     
        </div>
    </div>
    <?php } ?>
    <div class="form-actions form-actions-padding-sm btn-btm-css">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <button class='btn btn-primary' type='submit' id="form1_submit" name="default_submit" >
                    <i class="fa fa-floppy-o"></i>
                    Save
                </button>
                <a href='<?php echo site_url().'admin/classifieds/'.$this->uri->segment(4).'/'.$this->uri->segment(5); ?>' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form1_images_arr" id="form1_images_arr"   class="form-control"  />
            </div>
        </div>
    </div>
</form>