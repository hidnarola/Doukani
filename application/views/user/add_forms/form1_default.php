<form  name="default_form" action='<?php echo base_url() . 'user/post_ads' ?>' class='form form-horizontal validate-form default_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form1">   
    <h4><i class="fa fa-info-circle"></i>Item Details</h4>
    <hr />
    <div class='form-group'>                                            
        <input type="hidden" name="cat_id" id="cat_id_form1" value="<?php echo set_value('cat_id'); ?>">
        <input type="hidden" name="sub_cat" id="sub_cat_form1" value="<?php echo set_value('sub_cat'); ?>">
        <div class="col-md-2 col-sm-3">Ad Title <span> *</span></div>
        <div class="col-md-6 col-sm-8 controls">
            <input placeholder='Title' class="form-control" name="pro_name" type='text'  maxlength="80" value="<?php echo set_value('pro_name'); ?>" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>
        <div class="col-md-2 col-sm-3">Description <span> *</span></div>					
        <div class='col-md-8 col-sm-8 '>
            <textarea class='input-block-level wysihtml5 form-control' name="pro_desc1"  id="pro_desc1"  rows='10' placeholder="Description" data-rule-required='true'></textarea>
        </div>        
    </div>    									
    <div class='form-group'>     
        <div class="col-md-2 col-sm-3">Price</div>
        <div class='col-md-3 col-sm-4 controls'>
            <input class="form-control price_txt"  placeholder="Price" name="pro_price" type="text" value="<?php echo (isset($_POST['pro_price']) && !empty($_POST['pro_price'])) ? set_value('pro_price') : ''; ?>" />            
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
                <input class="form-control total_stock"  placeholder="Total Stock" name="total_stock" id="total_stock" type="text"  value="<?php echo (isset($_POST['total_stock']) && !empty($_POST['total_stock'])) ? set_value('total_stock') : '0'; ?>" data-rule-required='true' />
            </div>
        </div>	
    <?php } ?>

    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
        <div class="form-group delivery_option_section">                    
            <div class="col-md-2 col-sm-3">Delivery Option <span> *</span></div>
            <div class="col-md-6 col-sm-8 controls">
                <select class="select2 form-control" name="delivery_option" id="delivery_option" data-rule-required='true'>
                    <option value="">Delivery Option</option>
                    <?php foreach ($delivery_options as $d): ?>                    
                        <option value="<?php echo $d['id'] ?>"><?php echo $d['option_text'] ?></option>                    
                    <?php endforeach; ?>                                   
                </select>
            </div>
        </div>
        <div class="form-group product_weight_section">                    
            <div class="col-md-2 col-sm-3">Product Weight <span> *</span></div>
            <div class="col-md-6 col-sm-8 controls">
                <select class="select2 form-control" name="weight" id="weight" data-rule-required='true'>
                    <option value="">Product Weight</option>
                    <?php foreach ($product_weights as $w): ?>                    
                        <option value="<?php echo $w['id'] ?>"><?php echo $w['weight_text'] ?></option>                    
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    <?php } ?>

    <h4><i class="fa fa-home"></i>Contact Details</h4>
    <hr />				
    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Country <span> *</span></div>
        <div class="col-md-6 col-sm-8 controls">
            <select class="form-control" name="location" id="location_con_form1" onchange="show_emirates_form1(this.value);" data-rule-required='true' >
                <option value="">Select Country</option>
                <?php foreach ($location as $st): ?>
                    <?php if ($st['country_id'] == 4) { ?>
                        <option value="<?php echo $st['country_id']; ?>" selected><?php echo $st['country_name']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $st['country_id']; ?>"  <?php echo set_select('location', $st['country_id']); ?>><?php echo $st['country_name']; ?></option>
                    <?php } ?>                                        
                <?php endforeach; ?>                                	
            </select>
        </div>
    </div>				
    <div class="form-group">
        <div class="col-md-2 col-sm-3">Emirate <span> *</span></div>
        <div class="col-md-6 col-sm-8 controls">
            <select class="form-control " name="city" id="city_form1" data-rule-required='true'>
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
            <input data-latitude="latitude1" data-longitude="longitude1" data-type="googleMap" data-map_id="map1" data-lat="24.231234" data-lang="54.472382" data-input_id="google_input1" id="google_input1" type="text" class="textfield form-control" value="" name="address"   placeholder="Enter a location" />
            <input data-type="latitude1" type="hidden" name="latitude" value="">
            <input data-type="longitude1" type="hidden" name="longitude" value="">
            <span class="message_note"></span>
            <span class="message_error1" id="address_error"></span>

        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-sm-3"></div>
        <div class="col-md-6 col-sm-8" id="map1" style="height:300px">
        </div>
    </div>

    <!--display:none; -->				
    <div class="row form-group" style="margin-top:20px; display:none;" >
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form1"/><input type="text" class="form-control" name="cov_img" id="cov_img_form1"/></div>
    </div>
    <div class="row form-group" style="margin-top:20px; display:none;" >
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form1" name="video" /></div>
    </div>		
    <div class="form-actions form-actions-padding-sm btn-css005">
        <div class="">		
            <div class="col-md-2 col-sm-3"></div>
            <div class="col-md-8 col-sm-7">
                <button class='btn col-md-3' type='submit' id="form1_submit" name="default_submit" style="background-color:#ed1b33;color:#fff;padding:8px 33px;"><i class='icon-save'></i>Post</button>
                <a  href='<?php echo base_url(); ?>user/post_ads' title="Cancel" class="btn btn-black  col-md-3" style="color:#fff;padding:8px 33px;">Cancel</a><input type="hidden" name="form1_images_arr" id="form1_images_arr"   class="form-control" /> 
            </div>
        </div>
    </div>
</form>

