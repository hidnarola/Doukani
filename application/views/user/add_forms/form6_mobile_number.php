<form  name="mobile_number_form" action='<?php echo base_url() . 'user/post_ads' ?>' class='form form-horizontal validate-form mobile_number_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form6">
    <h4><i class="fa fa-info-circle"></i>Item Details</h4>
    <hr />
    <input type="hidden" name="cat_id" id="cat_id_form6" value="<?php echo set_value('cat_id'); ?>">
    <input type="hidden" name="sub_cat" id="sub_cat_form6" value="<?php echo set_value('sub_cat'); ?>">
    <div class='form-group'>
        <div class="col-md-2 col-sm-3">Ad Title<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input placeholder='Product Name' class="form-control" name="pro_name" type='text'  maxlength="80" value="<?php echo set_value('pro_name'); ?>"  data-rule-required='true' />
        </div>
    </div>                                    
    <div class='form-group'>
        <div class="col-md-2 col-sm-3">Description<span> *</span></div>					
        <div class='col-md-8 col-sm-8 '>            
             <textarea class='input-block-level wysihtml5 form-control' id='mob_desc' name="mob_desc" rows="10" placeholder="Description" data-rule-required='true'><?php echo set_value('pro_desc'); ?></textarea>            
        </div>
    </div>
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Price</div>
        <div class='col-md-3 col-sm-4 controls'>
            <input class="form-control price_txt"  placeholder="Price" name="pro_price" type="text"   value="<?php echo (isset($_POST['pro_price']) && !empty($_POST['pro_price'])) ? set_value('pro_price') : ''; ?>" />
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
            </div>
        </div>
    </div>

    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
        <div class='form-group'>     
            <div class="col-md-2 col-sm-3">Total Stock <span> *</span></div>                      
            <div class='col-md-6 col-sm-8 controls'>
                <input class="form-control total_stock"  placeholder="Total Stock" name="total_stock" id="total_stock" type="text"  value="<?php echo set_value('total_stock'); ?>" data-rule-required='true' />
            </div>
        </div>  
    <?php } ?>

    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Mobile Operator<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select class="select2 form-control" name="mobile_operators" id="mobile_operators"  data-rule-required='true'  >
                <option value="">Select Mobile Operator</option>
                <?php foreach ($mobile_operators as $pl): ?>
                    <option value="<?php echo $pl['id'] ?>" <?php if (isset($_REQUEST['mobile_operators']) && $_REQUEST['mobile_operators'] == $pl['id']) echo set_select('mobile_operators', $pl['id']); ?> ><?php echo $pl['operator_name']; ?></option>

                <?php endforeach; ?>            

            </select>
        </div>
    </div>
    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Repeating Number<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select class="select2 form-control" name="repeating_numbers_mobile" id="repeating_numbers_mobile"  data-rule-required='true' > 
                <option value="">Select # of repeating number</option>
                <?php foreach ($repeating_numbers_mobile as $pl): ?>
                    <option value="<?php echo $pl['id'] ?>" <?php if (isset($_REQUEST['repeating_numbers_mobile']) && $_REQUEST['repeating_numbers_mobile'] == $pl['id']) echo set_select('repeating_numbers_mobile', $pl['id']); ?> ><?php echo $pl['rep_number']; ?></option>
                <?php endforeach; ?>
                <option value="-1" <?php if (isset($_REQUEST['repeating_numbers_mobile']) && $_REQUEST['repeating_numbers_mobile'] == '-1') echo 'selected'; ?>>More than 8</option>
            </select>
        </div>
    </div>
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Mobile Number<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input class="form-control"  placeholder="Mobile Number" name="mobile_number" type="text"   value="<?php echo set_value('mobile_number'); ?>" data-rule-required='true' />
        </div>
    </div>  
    <h4><i class="fa fa-home"></i>Contact Details</h4>
    <hr />
    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Country <span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select class="select2 form-control" name="location" id="location_con_form6" onchange="show_emirates_form6(this.value);" data-rule-required='true'  >
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
        <div class="col-md-2 col-sm-3">Emirate<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select  name="state" class="select2 form-control" id="city_form6" data-rule-required='true' >
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
        <div class="col-md-2 col-sm-3">Address</div>
        <div class="col-md-6 col-sm-8 controls">
            <input data-latitude="latitude6" data-longitude="longitude6" data-type="googleMap" data-map_id="map6" data-lat="24.231234" data-lang="54.472382" data-input_id="google_input6" id="google_input6" type="text" class="textfield form-control" value="" name="address"   placeholder="Enter a location" />
            <input data-type="latitude6" type="hidden" name="latitude" value="">
            <input data-type="longitude6" type="hidden" name="longitude" value="">
            <span class="message_note"></span>
            <span class="message_error6" id="address_error"></span>

        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-sm-3"></div>
        <div class="col-md-6 col-sm-8" id="map6" style="height:300px">
        </div>
    </div>    
    <!--  display:none;-->
    <div class="row form-group" style="margin-top:20px;display:none;" >
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form6"/><input type="text" class="form-control" name="cov_img" id="cov_img_form6"/></div>
    </div>
    <div class="row form-group" style="margin-top:20px; display:none;" >
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form6" name="video" /></div>
    </div>
    <div class="form-actions form-actions-padding-sm btn-css005">
        <div class="">
            <div class="col-md-2 col-sm-3"></div>
            <div class="col-md-8 col-sm-7">
                <button class='btn col-md-3' type='submit' id="form6_submit" name="mobile_number_submit" style="background-color:#ed1b33;color:#fff;padding:8px 33px;">
                    <i class='icon-save'></i>
                    Post
                </button>
                <a href='<?php echo base_url(); ?>user/post_ads' title="Cancel" class="btn btn-black  col-md-3" style="color:#fff;padding:8px 33px;">Cancel</a><input type="hidden" name="form6_images_arr" id="form6_images_arr"   class="form-control" /> 
            </div>
        </div>
    </div>                                            
</form>