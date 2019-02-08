<?php
if (isset($_GET['userid']) && $_GET['userid'] != '')
    $redirect_url = base_url() . 'admin/classifieds/listings_add/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . '?userid=' . $_GET['userid'];
else
    $redirect_url = base_url() . 'admin/classifieds/listings_add/' . $this->uri->segment(4) . '/' . $this->uri->segment(5);
?>
<form name="real_estate_shared_form" style="display: none;" action='<?php echo $redirect_url; ?>' class='form form-horizontal validate-form real_estate_shared_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form4">
    <input type="hidden" name="cat_id" id="cat_id_form4" value="<?php echo set_value('cat_id'); ?>">
    <input type="hidden" name="sub_cat" id="sub_cat_form4" value="<?php echo set_value('sub_cat'); ?>">                                            
    <h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
    <hr />                                         
    <div class='form-group controls'>                        
        <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
        <div class='col-md-5'>
            <input class="form-control" placeholder="Ad Title" name="shared_ad_title" type="text"  maxlength="80" value="<?php echo set_value('shared_ad_title'); ?>" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Describe what makes your ad unique<span> *</span></label>
        <div class='col-md-8 col-sm-8 '>
            <textarea class='input-block-level wysihtml5 form-control' placeholder="Description" name="shared_pro_desc" rows="10"  data-rule-required='true' ><?php echo set_value('shared_pro_desc'); ?></textarea>
        </div>
    </div>    
     <?php if(isset($user_role) && $user_role == 'storeUser')  { ?>
    <div class='form-group original_price_section' <?php if (isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?>>     
        <label class='col-md-2 control-label' for='inputText1'>Original Price</label>
        <div class='col-md-3 controls'>
            <input class="form-control shared_original_price" id="form_org_price4"  placeholder="Price" name="shared_original_price" type="text" value="<?php  echo (isset($_POST['shared_original_price']) && !empty($_POST['shared_original_price'])) ? set_value('shared_original_price') : ''; ?>" />            
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
                <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
            </div>
        </div>
    </div>
      <?php } ?>
    <?php //  if (isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?>
    <div class='form-group'  >                        
        <label class='col-md-2 control-label' for='inputText1'>Price</label>    
        <div class="input-group col-md-5 controls price_cont">
            <span class="input-group-addon">Dirham</span>
            <input type="text" id="shared_price" name="shared_price" class="form-control price_txt" value="<?php echo (isset($_POST['shared_price']) && !empty($_POST['shared_price'])) ? set_value('shared_price') : ''; ?>">
            <span class="input-group-addon">.00</span>
        </div>
        <div class="checkbox col-md-1">
            <label>
                <input type="checkbox" name="shared_free" value="1">
                Free
            </label>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
                <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?php echo price_zero_label; ?>
            </div>
        </div>
        <span for="shared_price" class="help-block has-error col-md-offset-2 col-xs-10 for_share_price"></span>
    </div>


    <div class='form-group total_stock_div' <?php if (isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?>>                        
        <label class='col-md-2 control-label' for='inputText1'>Total Stock<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control total_stock"  placeholder="Total Stock" name="total_stock" type="text" value="<?php echo set_value('total_stock'); ?>"  />
            <input type="hidden" name="ad_type" id="form4_ad_type" value="<?php if (isset($user_role) && $user_role == 'storeUser') echo '1'; ?>">
        </div>
    </div>


    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>My Ad is in</label>
        <div class='col-md-5'>
            <select id="shared_language" name="shared_language" class="select2 form-control">
                <option value="0">Select</option>
                <option value="english" <?php if (isset($_REQUEST['shared_language']) && $_REQUEST['shared_language'] == 'NeedReview') echo set_select('shared_language', 'english'); ?>>English</option>
            </select>                     
        </div>
    </div>                          
    
    <?php if (isset($user_category_id) && (int) $user_category_id > 0) { ?>
        <div class="form-group delivery_option_section">                    
            <label class='col-md-2 control-label' for='inputText1'>Delivery Option <span> *</span></label>
            <div class="col-md-5 controls">
                <select class="select2 form-control" name="delivery_option" id="delivery_option" data-rule-required='true' >
                    <option value="">Select Delivery Option</option>
                    <?php foreach ($delivery_options as $d): ?>                    
                        <option value="<?php echo $d['id'] ?>"><?php echo $d['option_text'] ?></option>                    
                    <?php endforeach; ?>                                   
                </select>
            </div>
        </div>
        <div class="form-group product_weight_section">                    
            <label class='col-md-2 control-label' for='inputText1'>Product Weight <span> *</span></label>
            <div class="col-md-5 controls">
                <select class="select2 form-control" name="weight" id="weight" data-rule-required='true' >
                    <option value="">Select Product Weight</option>
                    <?php foreach ($product_weights as $w): ?>                    
                        <option value="<?php echo $w['id'] ?>"><?php echo $w['weight_text'] ?></option>                    
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    <?php } ?>
    
    <h4><i class="fa fa-home"></i>&nbsp;&nbsp;Contact Details</h4>
    <hr />  
    <div class="form-group">                    
        <label class='col-md-2 control-label' for='inputText1'>Country <span> *</span></label>
        <div class="col-md-5 controls">
            <select class="select2 form-control" name="location" id="location_con_form4" onchange="show_emirates_form4(this.value);"  data-rule-required='true' >   
                <option value="">Select Country</option>
                <?php foreach ($location as $st): ?>
                    <?php if ($st['country_id'] == 4) { ?>
                        <option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $st['country_id'] ?>" <?php echo set_select('location', $st['country_id']); ?> ><?php echo $st['country_name'] ?></option>
                    <?php } ?>                                        
                <?php endforeach; ?>                                   
            </select>
        </div>
    </div>  
    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
        <div class='col-md-5 controls'>
            <select name="state" class="select2 form-control"  id="city_form4" data-rule-required='true'>
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
        <label class='col-md-2 control-label' for='inputText1'>Address<span> *</span></label>
        <div class="col-md-5 controls">
            <input  data-zoom="10" data-latitude="latitude4" data-longitude="longitude4" data-type="googleMap" data-map_id="map4" data-lat="24.231234" data-lang="54.472382" data-input_id="google_input4" id="google_input4" type="text" class="textfield form-control" value="" name="address"   placeholder="Enter a location" data-rule-required='true' />
            <input data-type="latitude4" type="hidden" name="latitude" value="24.231234">
            <input data-type="longitude4" type="hidden" name="longitude" value="54.472382">

            <span class="message_note"></span>
            <span class="message_error2" id="address_error"></span>

        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 "></div>
        <div class="col-md-5" id="map4" style="height:300px">
        </div>
    </div>
    <div class='form-group'>                        
        <div class='col-md-offset-2 col-md-5 controls'>
            <input type="text" class="form-control" placeholder="Neighbourhood (Optional)" name="shared_pro_neighbourhood" maxlength="50" value="<?php echo set_value('shared_pro_neighbourhood'); ?>"/>
        </div>
    </div>
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form4"/>
            <input type="text" class="form-control" name="cov_img" id="cov_img_form4"/>
        </div>
    </div>
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form4" name="video" /></div>
    </div>

    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  onkeypress="return isNumber1(event)" value="<?php echo set_value('pro_phone'); ?>" data-rule-required='true' />
        </div>
    </div>
    <?php
    $admin_permission = $this->session->userdata('admin_modules_permission');
    if ($admin_permission == 'only_listing') {
        ?>    
        <input id="product_is_inappropriate" name="product_is_inappropriate" class="form-control" type="hidden" value="Unapprove">
        <?php } else {
        ?>
        <div class="form-group" >
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
                <button class='btn btn-primary' type='submit' id="form4_submit" name="real_estate_shared_submit" >
                    <i class="fa fa-floppy-o"></i>
                    Save
                </button>                                                       
                <a href='<?php echo site_url() . 'admin/classifieds/' . $this->uri->segment(4) . '/' . $this->uri->segment(5); ?>' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form4_images_arr" id="form4_images_arr"   class="form-control" /> 
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function(){
$('#form4 #shared_price').focusout(function(){
    validateForm();   
});
$('#form4 #form_org_price4').focusout(function(){
    validateForm();   
});
function validateForm(){
    var price = $('#form4 #shared_price').val();
    var oprice = $('#form4 #form_org_price4').val();
     $('.error').hide();
        if(price >= oprice){
            $('#form4 .for_share_price').after('<label for="pro_name" class="error">Price less than to original price.</label>');
        } 
        if(oprice <= price){
            $('#form4 #form_org_price4').after('<label for="pro_name" class="error">Original price more than to discounted price.</label>');
        }
}   
});
</script>