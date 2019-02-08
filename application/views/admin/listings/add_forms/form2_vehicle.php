<?php
if (isset($_GET['userid']) && $_GET['userid'] != '')
    $redirect_url = base_url() . 'admin/classifieds/listings_add/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . '?userid=' . $_GET['userid'];
else
    $redirect_url = base_url() . 'admin/classifieds/listings_add/' . $this->uri->segment(4) . '/' . $this->uri->segment(5);
?>
<form name="vehicle_form" style="display: none;" action='<?php echo $redirect_url; ?>' class='form form-horizontal validate-form vehicle_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form2">                          
    <h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
    <hr />
    <input type="hidden" name="cat_id" id="cat_id_form2" value="<?php echo set_value('cat_id'); ?>" >
    <input type="hidden" name="sub_cat" id="sub_cat_form2" value="<?php echo set_value('sub_cat'); ?>" >
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control" placeholder="Title" name="title" type="text"  maxlength="80" value="<?php echo set_value('title'); ?>" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Description<span> *</span></label>
        <div class='col-md-8 col-sm-8 '>
            <textarea class='input-block-level wysihtml5 form-control' id="vehicle_pro_desc" placeholder="Description" name="vehicle_pro_desc" rows="10"  data-rule-required='true' ><?php echo set_value('vehicle_pro_desc'); ?></textarea>
        </div>
    </div>   
    <?php if(isset($user_role) && $user_role == 'storeUser')  { ?>
    <div class='form-group original_price_section' <?php if (isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?>>     
        <label class='col-md-2 control-label' for='inputText1'>Original Price</label>
        <div class='col-md-3 controls'>
            <input class="form-control original_price"  id="form_org_price2" placeholder="Price" name="vehicle_original_price" type="text" value="<?php  echo (isset($_POST['vehicle_original_price']) && !empty($_POST['vehicle_original_price'])) ? set_value('vehicle_original_price') : ''; ?>" />            
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
                <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php //if (isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?>
    <div class='form-group' >                        
        <label class='col-md-2 control-label' for='inputText1'>Price</label>
        <div class='col-md-3 controls'>
            <input class="form-control price_txt" <?php if (isset($user_role) && $user_role != 'storeUser'){ echo ''; }else{ echo 'id="form_pro_price2"'; } ?> placeholder="Price" name="vehicle_pro_price" id="vehicle_pro_price" type="text"   value="<?php echo (isset($_POST['vehicle_pro_price']) && !empty($_POST['vehicle_pro_price'])) ? set_value('vehicle_pro_price') : ''; ?>" />
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
                <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?php echo price_zero_label; ?>
            </div>
        </div>
    </div>


    <div class='form-group total_stock_div' <?php if (isset($user_role) && $user_role != 'storeUser') echo 'style="display:none;"'; ?>>
        <label class='col-md-2 control-label' for='inputText1'>Total Stock<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control total_stock"  placeholder="Total Stock" name="total_stock" type="text" value="<?php echo set_value('total_stock'); ?>"  />
            <input type="hidden" name="ad_type" id="form2_ad_type" value="<?php if (isset($user_role) && $user_role == 'storeUser') echo '1'; ?>">
        </div>
    </div>

    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Car Brand<span> *</span></label>                   
        <div class='col-md-5 controls'>
            <!--<input class="form-control"  placeholder="Brand" name="pro_brand" type="text" value="<?php //echo $product[0]['product_brand'];     ?>" /> -->
            <select name="pro_brand"  class="form-control" onchange="show_model(this.value);" id="pro_brand" data-rule-required='true'>    
                <option value="">Select Brand</option>  
                <?php foreach ($brand as $col): ?>
                    <option value="<?php echo $col['brand_id']; ?>" <?php if (isset($_REQUEST['pro_brand']) && $_REQUEST['pro_brand'] == $col['brand_id']) echo set_select('pro_brand', $col['brand_id'], TRUE); ?> ><?php echo $col['name']; ?></option>
                <?php endforeach; ?>
            </select>                                               
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Car Model<span> *</span></label>
        <div class='col-md-5  controls'>
            <select id="pro_model" name="vehicle_pro_model" class="select2 form-control" data-rule-required='true'>
                <?php
                if (isset($model) && sizeof($model) > 0) {
                    foreach ($model as $col):
                        ?>
                        <option value="<?php echo $col['model_id']; ?>"  <?php echo ($product[0]['model'] == $col['model_id']) ? 'selected' : ''; ?>><?php echo $col['name']; ?></option>
                        <?php
                    endforeach;
                }
                ?>
            </select>                     
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Type Of Car<span> *</span></label>
        <div class='col-md-5 controls'>
            <select id="vehicle_pro_type_of_car" name="vehicle_pro_type_of_car" class="select2 form-control" data-rule-required='true'>
                <option value="">Select Car Type</option>
                <option value="Small cars" <?php if (isset($_REQUEST['vehicle_pro_type_of_car']) && $_REQUEST['vehicle_pro_type_of_car'] == "Small cars") echo 'selected'; ?>>Small cars</option>
                <option value="Medium cars" <?php if (isset($_REQUEST['vehicle_pro_type_of_car']) && $_REQUEST['vehicle_pro_type_of_car'] == "Medium cars") echo 'selected'; ?>>Medium cars</option>
                <option value="Family cars" <?php if (isset($_REQUEST['vehicle_pro_type_of_car']) && $_REQUEST['vehicle_pro_type_of_car'] == "Family cars") echo 'selected'; ?>>Family cars</option>
                <option value="Estate cars" <?php if (isset($_REQUEST['vehicle_pro_type_of_car']) && $_REQUEST['vehicle_pro_type_of_car'] == "Estate cars") echo 'selected'; ?>>Estate cars</option>

                <option value="Multi-purpose vehicles (MPV)" <?php if (isset($_REQUEST['vehicle_pro_type_of_car']) && $_REQUEST['vehicle_pro_type_of_car'] == "Multi-purpose vehicles (MPV)") echo 'selected'; ?>>Multi-purpose vehicles (MPV)</option>

                <option value="4x4 and Sport Utility Vehicles (SUV)" <?php if (isset($_REQUEST['vehicle_pro_type_of_car']) && $_REQUEST['vehicle_pro_type_of_car'] == "4x4 and Sport Utility Vehicles (SUV)") echo 'selected'; ?>>4x4 and Sport Utility Vehicles (SUV)</option>

                <option value="Coupes, roadsters and cabriolets" <?php if (isset($_REQUEST['vehicle_pro_type_of_car']) && $_REQUEST['vehicle_pro_type_of_car'] == "Coupes, roadsters and cabriolets") echo 'selected'; ?>>Coupes, roadsters and cabriolets</option>

                <option value="Wheelchair Accessible (WAVs)" <?php if (isset($_REQUEST['vehicle_pro_type_of_car']) && $_REQUEST['vehicle_pro_type_of_car'] == "Wheelchair Accessible (WAVs") echo 'selected'; ?>>Wheelchair Accessible (WAVs)</option>

            </select>

        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Year<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control datepicker-years"  placeholder="Select Year" id="vehicle_pro_year" name="vehicle_pro_year" type="text"  value="<?php echo set_value('vehicle_pro_year'); ?>"data-rule-required='true'  />
            <label for="year_error" class="error" id="year_error" style="display:none;"></label>
        </div>
    </div>
    <div class='form-group'>
        <label class='col-md-2 control-label' for='inputText1'>Mileage<span> *</span></label>
        <div class='col-md-5 controls'>
            <select name="vehicle_pro_mileage" id="vehicle_pro_mileage"  class="form-control" data-rule-required='true'>
                <option value="">Select Mileage</option>
                <?php foreach ($mileage as $col): ?>
                    <option value="<?php echo $col['mileage_id']; ?>" <?php if (isset($_REQUEST['vehicle_pro_mileage']) && $_REQUEST['vehicle_pro_mileage'] == $col['mileage_id']) echo set_select('vehicle_pro_mileage', $col['mileage_id'], TRUE); ?> ><?php echo $col['name']; ?></option>     
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Condition<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control"  placeholder="Condition" name="vehicle_pro_condition" id="vehicle_pro_condition" type="text" maxlength="30" value="<?php echo set_value('vehicle_pro_condition'); ?>" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Choose Color<span> *</span></label>
        <div class='col-md-5 single-select'>
            <select name="vehicle_pro_color"  class="form-control selectpicker" id="ms" data-rule-required='true' style="display:none;"> 
                <option value="">Select Color</option>                                  
                <?php foreach ($colors as $col): ?>                                       
                    <option style="color:<?php echo $col['font_color']; ?>;background-color:<?php echo $col['background_color']; ?>" value="<?php echo $col['id']; ?>" <?php if (isset($_REQUEST['vehicle_pro_color']) && $_REQUEST['vehicle_pro_color'] == $col['id']) echo set_select('vehicle_pro_color', $col['id'], TRUE); ?> ><?php echo $col['name']; ?></option>
                <?php endforeach; ?>
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
            <select class="form-control" name="location" id="location_con_form2" onchange="show_emirates_form2(this.value);" data-rule-required='true' >            
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
    <div class="form-group">
        <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
        <div class='col-md-5 controls'>
            <select  name="state" class="select2 form-control"  id="city_form2" data-rule-required="true">
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
            <input  data-zoom="10" data-latitude="latitude1" data-longitude="longitude1" data-type="googleMap" data-map_id="map1" data-lat="24.231234" data-lang="54.472382" data-input_id="google_input1" id="google_input1" type="text" class="textfield form-control" value="" name="address"   placeholder="Enter a location" />
            <input data-type="latitude1" type="hidden" name="latitude" value="24.231234">
            <input data-type="longitude1" type="hidden" name="longitude" value="54.472382">

            <span class="message_note"></span>
            <span class="message_error2" id="address_error"></span>

        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 "></div>
        <div class="col-md-5" id="map1" style="height:300px">
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"   onkeypress="return isNumber1(event)" value="<?php echo set_value('pro_phone'); ?>" data-rule-required='true' />
        </div>
    </div>  
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form2"/>
            <input type="text" class="form-control" name="cov_img" id="cov_img_form2"/>
        </div>
    </div>
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form2" name="video" /></div>
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
                <button class='btn btn-primary' type='submit' id="form2_submit" name="vehicle_submit">
                    <i class="fa fa-floppy-o"></i>
                    Save
                </button>
                <a href='<?php echo site_url() . 'admin/classifieds/' . $this->uri->segment(4) . '/' . $this->uri->segment(5); ?>' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form2_images_arr" id="form2_images_arr"  class="form-control" />
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function(){
$('#form2 #form_pro_price2').focusout(function(){
    validateForm();   
});
$('#form2 #form_org_price2').focusout(function(){
    validateForm();   
});
function validateForm(){
    var price = $('#form2 #form_pro_price2').val();
    var oprice = $('#form2 #form_org_price2').val();
     $('.error').hide();
        if(price >= oprice){
            $('#form2 #form_pro_price2').after('<label for="pro_name" class="error cls_pro">Price less than to original price.</label>');
        } 
        if(oprice <= price){
            $('#form2 #form_org_price2').after('<label for="pro_name" class="error">Original price more than to discounted price.</label>');
        }
}   
});
</script>