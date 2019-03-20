<?php
if (isset($_GET['userid']) && $_GET['userid'] != '')
    $redirect_url = base_url() . 'admin/classifieds/listings_add/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . '?userid=' . $_GET['userid'];
else
    $redirect_url = base_url() . 'admin/classifieds/listings_add/' . $this->uri->segment(4) . '/' . $this->uri->segment(5);
?>
<form name="real_estate_houses_form" style="display: none;" action='<?php echo $redirect_url; ?>' class='form form-horizontal validate-form real_estate_houses_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form3">
    <h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
    <hr />
    <input type="hidden" name="cat_id" id="cat_id_form3" value="<?php echo set_value('cat_id'); ?>">
    <input type="hidden" name="sub_cat" id="sub_cat_form3" value="<?php echo set_value('sub_cat'); ?>">                                                                                                      
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control" placeholder="Ad Title" name="houses_ad_title" id="pro_ad_title" type="text"   maxlength="80" value="<?php echo set_value('houses_ad_title'); ?>" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>
        <label class='col-md-2 control-label' for='inputText1'>Describe what makes your ad unique<span> *</span></label>
        <div class='col-md-8 col-sm-8 '>
            <textarea class='input-block-level wysihtml5 form-control' placeholder="Description" name="house_pro_desc" rows="10" data-rule-required='true'><?php echo set_value('house_pro_desc'); ?></textarea>
        </div>
    </div>  
    <?php if (isset($user_role) && $user_role == 'storeUser') { ?>
        <div class='form-group original_price_section' <?php if (isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?>>     
            <label class='col-md-2 control-label' for='inputText1' >Original Price</label>
            <div class='col-md-3 controls'>
                <input class="form-control house_original_price" id="form_org_price3"  placeholder="Price" name="house_original_price" type="text" value="<?php echo (isset($_POST['house_original_price']) && !empty($_POST['house_original_price'])) ? set_value('house_original_price') : ''; ?>" />            
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="alert alert-info price_zero_lbl">
                    <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php // if (isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1' >Price</label>

        <div class="input-group col-md-5 controls price_cont sell_grp">
            <span class="input-group-addon">Dirham</span>
            <input type="text" id="houses_price" name="houses_price" class="form-control price_txt" value="<?php echo (isset($_POST['houses_price']) && !empty($_POST['houses_price'])) ? set_value('houses_price') : ''; ?>">
            <span class="input-group-addon">.00</span>
        </div>
        <div class="checkbox col-md-1">
            <label>
                <input name="houses_free" type="checkbox" value="1">
                Free
            </label>                                                        
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
                <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?php echo price_zero_label; ?>
            </div>
        </div>
        <span for="houses_price" class="help-block has-error col-md-offset-2 col-xs-10"></span>
    </div>

    <div class='form-group total_stock_div' <?php if (isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?>>
        <label class='col-md-2 control-label' for='inputText1'>Total Stock<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control total_stock"  placeholder="Total Stock" name="total_stock" type="text" value="<?php echo set_value('total_stock'); ?>"  />
            <input type="hidden" name="ad_type" id="form3_ad_type" value="<?php if (isset($user_role) && $user_role == 'storeUser') echo '1'; ?>">
        </div>
    </div>
    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Furnished</label>
        <div class='col-md-5'>
            <select id="furnished" name="furnished" class="select2 form-control">
                <option value="no" <?php if (isset($_REQUEST['furnished']) && $_REQUEST['furnished'] == 'no') echo set_select('furnished', 'no', TRUE); ?> >No</option>
                <option value="yes" <?php if (isset($_REQUEST['furnished']) && $_REQUEST['furnished'] == 'yes') echo set_select('furnished', 'yes', TRUE); ?> >Yes</option>
            </select>                     
        </div>
    </div>
    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Bedrooms</label>
        <div class='col-md-5'>
            <select id="bedrooms" name="bedrooms" class="select2 form-control ">
                <!--<option value="0">Select Number</option>-->
                <option value="1" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '1') echo set_select('bedrooms', '1', TRUE); ?>>1</option>
                <option value="2" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '2') echo set_select('bedrooms', '2', TRUE); ?>>2</option>
                <option value="3" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '3') echo set_select('bedrooms', '3', TRUE); ?>>3</option>
                <option value="4" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '4') echo set_select('bedrooms', '4', TRUE); ?>>4</option>
                <option value="5" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '5') echo set_select('bedrooms', '5', TRUE); ?>>5</option>
                <option value="6" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '6') echo set_select('bedrooms', '6', TRUE); ?>>6</option>
                <option value="7" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '7') echo set_select('bedrooms', '7', TRUE); ?>>7</option>
                <option value="8" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '8') echo set_select('bedrooms', '8', TRUE); ?>>8</option>
                <option value="9" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '9') echo set_select('bedrooms', '9', TRUE); ?>>9</option>
                <option value="10" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '10') echo set_select('bedrooms', '10', TRUE); ?>>10</option>
                <option value="-1" <?php if (isset($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] == '-1') echo set_select('bedrooms', '-1', TRUE); ?>>More than 10</option> 
            </select>                     
        </div>
    </div>

    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Bathrooms</label>
        <div class='col-md-5'>
            <select id="bathrooms" name="bathrooms" class="select2 form-control ">
                <!--<option value="0">Select</option>-->
                <option value="1" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '1') echo set_select('bathrooms', '1', TRUE); ?>>1</option>
                <option value="2" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '2') echo set_select('bathrooms', '2', TRUE); ?>>2</option>
                <option value="3" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '3') echo set_select('bathrooms', '3', TRUE); ?>>3</option>
                <option value="4" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '4') echo set_select('bathrooms', '4', TRUE); ?>>4</option>
                <option value="5" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '5') echo set_select('bathrooms', '5', TRUE); ?>>5</option>
                <option value="6" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '6') echo set_select('bathrooms', '6', TRUE); ?>>6</option>
                <option value="7" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '7') echo set_select('bathrooms', '7', TRUE); ?>>7</option>
                <option value="8" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '8') echo set_select('bathrooms', '8', TRUE); ?>>8</option>
                <option value="9" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '9') echo set_select('bathrooms', '9', TRUE); ?>>9</option>
                <option value="10" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '10') echo set_select('bathrooms', '10', TRUE); ?>>10</option>
                <option value="-1" <?php if (isset($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] == '-1') echo set_select('bathrooms', '-1', TRUE); ?>>More than 10</option>

            </select>                    
        </div>
    </div>
    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Pets</label>
        <div class='col-md-5'>
            <select id="pets" name="pets" class="select2 form-control">
                <!--<option value="0">Select</option>-->
                <option value="no" <?php if (isset($_REQUEST['pets']) && $_REQUEST['pets'] == 'no') echo set_select('pets', 'no', TRUE); ?>>No</option>
                <option value="yes" <?php if (isset($_REQUEST['pets']) && $_REQUEST['pets'] == 'yes') echo set_select('pets', 'yes', TRUE); ?> >Yes</option>

            </select>                     
        </div>
    </div>
    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Broker Fee</label>
        <div class='col-md-5'>
            <select id="broker_fee" name="broker_fee" class="select2 form-control">
                <!--<option value="0">Select</option>-->
                <option value="no" <?php if (isset($_REQUEST['broker_fee']) && $_REQUEST['broker_fee'] == 'no') echo set_select('broker_fee', 'no', TRUE); ?>>No</option>
                <option value="yes" <?php if (isset($_REQUEST['broker_fee']) && $_REQUEST['broker_fee'] == 'yes') echo set_select('broker_fee', 'yes', TRUE); ?> >Yes</option>
            </select>                     
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Square Meters<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control" placeholder="square meters" id="pro_square_meters" name="pro_square_meters" type="number" value="<?php echo set_value('pro_square_meters'); ?>" data-rule-required='true' />
        </div>
    </div>

    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>My Ad is in</label>
        <div class='col-md-5'>
            <select id="houses_language" name="houses_language" class="select2 form-control">
                <option value="0">Select</option>
                <option value="english" <?php if (isset($_REQUEST['houses_language']) && $_REQUEST['houses_language'] == 'NeedReview') echo set_select('houses_language', 'english'); ?>>English</option>
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
            <label class='col-md-2 control-label' for='inputText1'>Product Weight (in kg)<span> *</span></label>
            <div class="col-md-5 controls">
                <input type="number" class="form-control" name="weight" id="weight" data-rule-required='true' value="<?php echo set_value('weight'); ?>">
    <!--                <select class="select2 form-control" name="weight" id="weight" data-rule-required='true' >
                    <option value="">Select Product Weight</option>
                <?php // foreach ($product_weights as $w): ?>                    
                        <option value="<?php // echo $w['id']   ?>"><?php // echo $w['weight_text']   ?></option>                    
                <?php // endforeach; ?>
                </select>-->
            </div>
        </div>
    <?php } ?>

    <h4><i class="fa fa-home"></i>&nbsp;&nbsp;Contact Details</h4>
    <hr />
    <div class="form-group">                    
        <label class='col-md-2 control-label' for='inputText1'>Country <span> *</span></label>
        <div class="col-md-5 controls">
            <select class="select2 form-control" name="location" id="location_con_form3" onchange="show_emirates_form3(this.value);" data-rule-required='true' >        
                <option value="">Select Country</option>    
                <?php foreach ($location as $st): ?>
                    <?php if ($st['country_id'] == 4) { ?>
                        <option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $st['country_id'] ?>" <?php echo set_select('location', $st['country_id'], TRUE); ?> ><?php echo $st['country_name'] ?></option>
                    <?php } ?>                                        
                <?php endforeach; ?>                                   
            </select>
        </div>
    </div>
    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
        <div class='col-md-5 controls'>
            <select name="state" class="select2 form-control"  id="city_form3" data-rule-required='true' >
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
            <input  data-zoom="10" data-latitude="latitude3" data-longitude="longitude3" data-type="googleMap" data-map_id="map3" data-lat="24.231234" data-lang="54.472382" data-input_id="google_input3" id="google_input3" type="text" class="textfield form-control" value="" name="address"   placeholder="Enter a location" data-rule-required='true' />
            <input data-type="latitude3" type="hidden" name="latitude" value="24.231234">
            <input data-type="longitude3" type="hidden" name="longitude" value="54.472382">

            <span class="message_note"></span>
            <span class="message_error2" id="address_error"></span>

        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 "></div>
        <div class="col-md-5" id="map3" style="height:300px">
        </div>
    </div>
    <div class='form-group'>                        
        <div class='col-md-offset-2 col-md-5 controls'>
            <input type="text" class="form-control" placeholder="Neighbourhood (Optional)" name="houses_pro_neighbourhood" maxlength="50" value="<?php echo set_value('houses_pro_neighbourhood'); ?>"/>
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"   onkeypress="return isNumber1(event)" value="<?php echo set_value('pro_phone'); ?>" data-rule-required='true' />
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
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form3"/>
            <input type="text" class="form-control" name="cov_img" id="cov_img_form3"/>
        </div>
    </div>
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form3" name="video" /></div>
    </div>
    <div class="form-actions form-actions-padding-sm btn-btm-css">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <button class='btn btn-primary' type='submit' id="form3_submit" name="real_estate_houses_submit">
                    <i class="fa fa-floppy-o"></i>
                    Save
                </button>
                <a href='<?php echo site_url() . 'admin/classifieds/' . $this->uri->segment(4) . '/' . $this->uri->segment(5); ?>' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form3_images_arr" id="form3_images_arr"   class="form-control" /> 
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form3 #houses_price').focusout(function () {
            validateForm();
        });
        $('#form3 #form_org_price3').focusout(function () {
            validateForm();
        });
        function validateForm() {
            var price = $('#form3 #houses_price').val();
            var oprice = $('#form3 #form_org_price3').val();
            $('.error').hide();
            if (price >= oprice) {
                $('#form3 .sell_grp').after('<label for="pro_name" class="error cls_pro">Price less than to original price.</label>');
            }
            if (oprice <= price) {
                $('#form3 #form_org_price3').after('<label for="pro_name" class="error">Original price more than to discounted price.</label>');
            }
        }
    });
</script>