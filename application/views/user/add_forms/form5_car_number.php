<form  name="car_number_form" action='<?php echo base_url() . 'user/post_ads' ?>' class='form form-horizontal validate-form car_number_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form5">
    <h4><i class="fa fa-info-circle"></i>Item Details</h4>
    <hr />
    <input type="hidden" name="cat_id" id="cat_id_form5" value="<?php echo set_value('cat_id'); ?>">
    <input type="hidden" name="sub_cat" id="sub_cat_form5" value="<?php echo set_value('sub_cat'); ?>">
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Ad Title   <span>*</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input placeholder='Product Name' class="form-control" name="pro_name" type='text'  maxlength="80" value="<?php echo set_value('pro_name'); ?>" data-rule-required='true' />
        </div>
    </div>                                    
    <div class='form-group'>
        <div class="col-md-2 col-sm-3">Description<span> *</span></div>					
        <div class='col-md-8 col-sm-8 '>            
            <textarea class='input-block-level wysihtml5 form-control' id='car_desc' name="car_desc" rows="10" placeholder="Description" data-rule-required='true'><?php echo set_value('pro_desc'); ?></textarea>                				
        </div>
    </div>  
    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
        <div class='form-group'>     
            <div class="col-md-2 col-sm-3">Original Price</div>
            <div class='col-md-3 col-sm-4 controls'>
                <input class="form-control car_original_price" id="form_org_price5"  placeholder="Price" name="car_original_price" type="text" value="<?php echo (isset($_POST['car_original_price']) && !empty($_POST['car_original_price'])) ? set_value('car_original_price') : ''; ?>" />            
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="alert alert-info price_zero_lbl">
                    <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                </div>
            </div>
        </div>
        <div class='form-group'>                        
            <div class="col-md-2 col-sm-3">Discounted Price</div>
            <div class='col-md-3 col-sm-4 controls'>
                <input class="form-control price_txt"  id="form_pro_price5" placeholder="Price" name="pro_price" type="text"  value="<?php echo (isset($_POST['pro_price']) && !empty($_POST['pro_price'])) ? set_value('pro_price') : ''; ?>" />
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="alert alert-info price_zero_lbl">
                    <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class='form-group'>                        
            <div class="col-md-2 col-sm-3">Price</div>
            <div class='col-md-3 col-sm-4 controls'>
                <input class="form-control price_txt"  placeholder="Price" name="pro_price" type="text"  value="<?php echo (isset($_POST['pro_price']) && !empty($_POST['pro_price'])) ? set_value('pro_price') : ''; ?>" />
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="alert alert-info price_zero_lbl">
                    <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
        <div class='form-group'>     
            <div class="col-md-2 col-sm-3">Total Stock <span> *</span></div>                      
            <div class='col-md-6 col-sm-8 controls'>
                <input class="form-control total_stock"  placeholder="Total Stock" name="total_stock" id="total_stock" type="text"  value="<?php echo set_value('total_stock'); ?>" data-rule-required='true' />
            </div>
        </div>  
    <?php } ?>

    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Car Number<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input class="form-control"  placeholder="Car Number" name="car_number" type="text"   value="<?php echo set_value('car_number'); ?>" data-rule-required='true' />
        </div>
    </div>
    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Plate Source<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select class="select2 form-control" name="plate_source" id="plate_source" onchange="show_prefix(this.value);" data-rule-required='true' >
                <option value="">Select Plate Source</option>
                <?php foreach ($plate_source as $pl): ?>
                    <option value="<?php echo $pl['id'] ?>" <?php if (isset($_REQUEST['plate_source']) && $_REQUEST['plate_source'] == $pl['id']) echo set_select('plate_source', $pl['id']); ?> ><?php echo $pl['plate_source_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Plate Prefix</div>
        <div class='col-md-6 col-sm-8 controls'>
            <select class="select2 form-control" name="plate_prefix" id="plate_prefix"  >
                <option value="">Select Plate Prefix</option>
            </select>
        </div>
    </div>
    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Plate Digit<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select class="select2 form-control" name="plate_digit" id="plate_digit"  data-rule-required='true'>
                <option value="">Select Plate Digit</option>
                <?php foreach ($plate_digit as $pl): ?>
                    <option value="<?php echo $pl['id'] ?>" <?php if (isset($_REQUEST['plate_digit']) && $_REQUEST['plate_digit'] == $pl['id']) echo set_select('plate_digit', $pl['id']); ?> ><?php echo $pl['digit_text']; ?></option>
                <?php endforeach; ?>
                <option value="-1" <?php if (isset($_REQUEST['plate_digit']) && $_REQUEST['plate_digit'] == '-1') echo 'selected'; ?>>More than 5 Digit plates</option>
            </select>
        </div>
    </div>
    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Repeating Number<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select class="select2 form-control" name="repeating_numbers_car" id="repeating_numbers_car"  data-rule-required='true'>
                <option value="">Select # of repeating number</option>
                <?php foreach ($repeating_numbers_car as $pl): ?>
                    <option value="<?php echo $pl['id'] ?>" <?php if (isset($_REQUEST['repeating_numbers_car']) && $_REQUEST['repeating_numbers_car'] == $pl['id']) echo set_select('repeating_numbers_car', $pl['id']); ?> ><?php echo $pl['rep_number']; ?></option>
                <?php endforeach; ?>
                <option value="-1" <?php if (isset($_REQUEST['repeating_numbers_car']) && $_REQUEST['repeating_numbers_car'] == '-1') echo 'selected'; ?>>More than 5 </option>

            </select>
        </div>
    </div>

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
            <div class="col-md-2 col-sm-3">Product Weight (in kg)<span> *</span></div>
            <div class="col-md-6 col-sm-8 controls">
                <input type="number" class="form-control" name="weight" id="weight" data-rule-required='true' value="<?php echo set_value('weight'); ?>">
    <!--                <select class="select2 form-control" name="weight" id="weight" data-rule-required='true'>
                    <option value="">Product Weight</option>
                <?php // foreach ($product_weights as $w): ?>                    
                        <option value="<?php // echo $w['id']  ?>"><?php // echo $w['weight_text']  ?></option>                    
                <?php // endforeach; ?>
                </select>-->
            </div>
        </div>
    <?php } ?>

    <h4><i class="fa fa-home"></i>Contact Details</h4>
    <hr />
    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Country <span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select class="select2 form-control" name="location" id="location_con_form5" onchange="show_emirates_form5(this.value);" data-rule-required='true' >
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
            <select  name="state" class="select2 form-control" id="city_form5" data-rule-required='true'>
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
            <input data-latitude="latitude5" data-longitude="longitude5" data-type="googleMap" data-map_id="map5" data-lat="24.231234" data-lang="54.472382" data-input_id="google_input5" id="google_input5" type="text" class="textfield form-control" value="" name="address"   placeholder="Enter a location" />
            <input data-type="latitude5" type="hidden" name="latitude" value="">
            <input data-type="longitude5" type="hidden" name="longitude" value="">
            <span class="message_note"></span>
            <span class="message_error5" id="address_error"></span>

        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-sm-3"></div>
        <div class="col-md-6 col-sm-8" id="map5" style="height:300px">
        </div>
    </div>
    <!--  display:none;-->
    <div class="row form-group" style="margin-top:20px;display:none;" >
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class='col-md-6 col-sm-8 controls'><input type="text" class="form-control" name="youtube" id="youtube_form5"/><input type="text" class="form-control" name="cov_img" id="cov_img_form5"/></div>
    </div>
    <div class="row form-group" style="margin-top:20px; display:none;" >
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form5" name="video" /></div>
    </div>                                             
    <div class="form-actions form-actions-padding-sm btn-css005">
        <div class="">
            <div class="col-md-2 col-sm-3"></div>
            <div class="col-md-8 col-sm-7">
                <button class='btn col-md-3' type='submit' id="form5_submit" name="car_number_submit" style="background-color:#ed1b33;color:#fff;padding:8px 33px;">
                    <i class='icon-save'></i>
                    Post
                </button>
                <a href='<?php echo base_url(); ?>user/post_ads' title="Cancel" class="btn btn-black  col-md-3" style="color:#fff;padding:8px 33px;">Cancel</a><input type="hidden" name="form5_images_arr" id="form5_images_arr"   class="form-control" /> 
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form5 #form_pro_price5').focusout(function () {
            validateForm();
        });
        $('#form5 #form_org_price5').focusout(function () {
            validateForm();
        });
        function validateForm() {
            var price = $('#form5 #form_pro_price5').val();
            var oprice = $('#form5 #form_org_price5').val();
            $('.error').hide();
            if (price >= oprice) {
                $('#form5 #form_pro_price5').after('<label for="pro_name" class="error">Price less than to original price.</label>');
            }
            if (oprice <= price) {
                $('#form5 #form_org_price5').after('<label for="pro_name" class="error">Original price more than to discounted price.</label>');
            }
        }
    });
</script>