<form name="vehicle_form" style="display: none;" action='<?php echo base_url() . 'user/listings_edit/' . $product[0]['product_id'] ?>' class='form form-horizontal validate-form vehicle_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form2">
    <h4><i class="fa fa-info-circle"></i>Item Details</h4>
    <hr />
    <input type="hidden" name="cat_id" value="<?php if (isset($product[0]['category_id'])) echo $product[0]['category_id']; ?>" id="cat_id_form2">
    <input type="hidden" name="sub_cat" value="<?php if (isset($product[0]['sub_category_id'])) echo $product[0]['sub_category_id']; ?>" id="sub_cat_form2">                                            					     
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Ad Title<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input class="form-control" value="<?php echo $product[0]['product_name']; ?>" placeholder="Title" name="title" type="text"  maxlength="80" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>
        <div class="col-md-2 col-sm-3">Description<span> *</span></div>					
        <div class='col-md-8 col-sm-8 '>			
            <textarea class='input-block-level wysihtml5 form-control' id='vehicle_pro_desc' name="vehicle_pro_desc" rows="10" placeholder="Description" data-rule-required='true'><?php echo $product[0]['product_description']; ?></textarea>				
        </div>
    </div>	
    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
    <div class='form-group'>     
        <div class="col-md-2 col-sm-3">Original Price</div>
        <div class='col-md-3 col-sm-4 controls'>
            <input class="form-control original_price"  id="form_org_price2" placeholder="Price" name="vehicle_original_price" type="text" value="<?php  echo $product[0]['original_price']; ?>" />            
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
            <input class="form-control price_txt" id="form_pro_price2" placeholder="Price" value="<?php echo $product[0]['product_price']; ?>" name="vehicle_pro_price" id="vehicle_pro_price" type="text" />
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
                <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
            </div>
        </div>
    </div>
    <?php }else{ ?>
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Price</div>
        <div class='col-md-3 col-sm-4 controls'>
            <input class="form-control price_txt" placeholder="Price" value="<?php echo $product[0]['product_price']; ?>" name="vehicle_pro_price" id="vehicle_pro_price" type="text" />
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
            <div class="col-md-2 col-sm-3">Total Stock<span> *</span></div>
            <div class='col-md-6 col-sm-8 controls'>
                <input class="form-control"  placeholder="Total Stock" value="<?php echo $product[0]['total_stock']; ?>" name="total_stock" type="text"  data-rule-required='true' />
            </div>
        </div>
    <?php } ?>

    <div class='form-group'>                                                                        
        <div class="col-md-2 col-sm-3">Car Brand<span> *</span></div>
        <input type="hidden" id="mybrand" value="<?php echo $product[0]['product_brand']; ?>">
        <div class='col-md-6 col-sm-8 controls'>
                <!--<input class="form-control"  placeholder="Brand" name="pro_brand" type="text" value="<?php //echo $product[0]['product_brand'];         ?>" /> -->                                                  
            <select name="pro_brand"  class="form-control select2 " onchange="show_model(this.value);" id="pro_brand" data-rule-required='true'>    
                <option value="">Select Brand</option>  
                <?php foreach ($brand as $col): ?>
                    <option value="<?php echo $col['brand_id']; ?>"  <?php echo ($product[0]['product_brand'] == $col['brand_id']) ? 'selected' : ''; ?>><?php echo $col['name']; ?></option>
                <?php endforeach; ?>
            </select>                                               
        </div>
    </div>
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Car Model<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select id="pro_model" name="vehicle_pro_model" class="select2 form-control" data-rule-required='true'>
                <?php foreach ($model as $col): ?>
                    <option value="<?php echo $col['model_id']; ?>"  <?php echo ($product[0]['model'] == $col['model_id']) ? 'selected' : ''; ?> class="myhide"><?php echo $col['name']; ?></option>
                <?php endforeach; ?>                                                                                                  <option value="-1" <?php echo (isset($product[0]['model']) && $product[0]['model'] == '-1') ? 'selected' : ''; ?>>Other</option>
            </select>  
        </div>
    </div>
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Type Of Car<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select id="vehicle_pro_type_of_car" name="vehicle_pro_type_of_car" class="select2 form-control " data-rule-required='true'>
                <option value="">Select Car Type</option>
                <option value="Small cars" <?php if (isset($product[0]['type_of_car']) && $product[0]['type_of_car'] == "Small cars") echo 'selected'; ?>>Small cars</option>
                <option value="Medium cars" <?php if (isset($product[0]['type_of_car']) && $product[0]['type_of_car'] == "Medium cars") echo 'selected'; ?>>Medium cars</option>
                <option value="Family cars" <?php if (isset($product[0]['type_of_car']) && $product[0]['type_of_car'] == "Family cars") echo 'selected'; ?>>Family cars</option>
                <option value="Estate cars" <?php if (isset($product[0]['type_of_car']) && $product[0]['type_of_car'] == "Estate cars") echo 'selected'; ?>>Estate cars</option>


                <option value="Multi-purpose vehicles (MPV)" <?php if (isset($product[0]['type_of_car']) && $product[0]['type_of_car'] == "Multi-purpose vehicles (MPV)") echo 'selected'; ?>>Multi-purpose vehicles (MPV)</option>

                <option value="4x4 and Sport Utility Vehicles (SUV)" <?php if (isset($product[0]['type_of_car']) && $product[0]['type_of_car'] == "4x4 and Sport Utility Vehicles (SUV)") echo 'selected'; ?>>4x4 and Sport Utility Vehicles (SUV)</option>

                <option value="Coupes, roadsters and cabriolets" <?php if (isset($product[0]['type_of_car']) && $product[0]['type_of_car'] == "Coupes, roadsters and cabriolets") echo 'selected'; ?>>Coupes, roadsters and cabriolets</option>

                <option value="Wheelchair Accessible (WAVs)" <?php if (isset($product[0]['type_of_car']) && $product[0]['type_of_car'] == "Wheelchair Accessible (WAVs") echo 'selected'; ?>>Wheelchair Accessible (WAVs)</option>

            </select>

        </div>
    </div>
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Year<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input class="form-control datepicker-years" value="<?php echo $product[0]['year']; ?>" placeholder="Select Year" id="vehicle_pro_year" name="vehicle_pro_year" type="text" data-rule-required='true' />
            <label for="year_error" class="error" id="year_error" style="display:none;"></label>
        </div>
    </div>
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Mileage<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select name="vehicle_pro_mileage" id="vehicle_pro_mileage"  class="select2 form-control" data-rule-required='true'>
                <option value="">Select Mileage</option>
                <?php foreach ($mileage as $col): ?>
                    <option value="<?php echo $col['mileage_id']; ?>"
                    <?php
                    if ($col['mileage_id'] == $product[0]['millage'])
                        echo 'selected=selected';
                    else
                        echo '';
                    ?>><?php echo $col['name']; ?></option>            
                        <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Condition<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input class="form-control" value="<?php echo $product[0]['vehicle_condition']; ?>"  placeholder="Condition" name="vehicle_pro_condition" id="vehicle_pro_condition" type="text" maxlength="30" data-rule-required='true' />
        </div>
    </div>

    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Choose Color<span> *</span></div>
        <div class='col-md-6 col-sm-8 single-select'>
            <select name="vehicle_pro_color"  class="form-control selectpicker" id="ms" data-rule-required='true' style="display:none;"> 
                <option value="">Select Color</option>                                  
                <?php foreach ($colors as $col): ?>                                     
                    <option style="color:<?php echo $col['font_color']; ?>;background-color:<?php echo $col['background_color']; ?>" value="<?php echo $col['id']; ?>"
                    <?php
                    if ($product[0]['color'] == $col['id'])
                        echo 'selected=selected';
                    else
                        echo '';
                    ?>><?php echo $col['name']; ?></option>
                        <?php endforeach; ?>
            </select>       
        </div>
    </div>

    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
        <div class="form-group delivery_option_section">                    
            <div class="col-md-2 col-sm-3">Delivery Option <span> *</span></div>
            <div class="col-md-6 col-sm-8 controls">
                <select class="select2 form-control" name="delivery_option" id="delivery_option" data-rule-required='true' >
                    <option value="">Select Delivery Option</option>
                    <?php foreach ($delivery_options as $d): ?>                    
                        <option value="<?php echo $d['id'] ?>" <?php echo ($product[0]['delivery_option'] == $d['id']) ? 'selected' : ''; ?>><?php echo $d['option_text'] ?></option>                    
                    <?php endforeach; ?>                                   
                </select>
            </div>
        </div>
        <div class="form-group product_weight_section">                    
            <div class="col-md-2 col-sm-3">Product Weight <span> *</span></div>
            <div class="col-md-6 col-sm-8 controls">
                <select class="select2 form-control" name="weight" id="weight" data-rule-required='true' >
                    <option value="">Select Product Weight</option>
                    <?php foreach ($product_weights as $w): ?>                    
                        <option value="<?php echo $w['id'] ?>" <?php echo ($product[0]['weight'] == $w['id']) ? 'selected' : ''; ?>><?php echo $w['weight_text'] ?></option>                    
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    <?php } ?>

    <h4><i class="fa fa-home"></i>Contact Details</h4>
    <hr />
    <div class="form-group">                    						
        <div class="col-md-2 col-sm-3">Country<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select class="form-control" name="location" id="location_con_form2" onchange="show_emirates_form2(this.value);" data-rule-required='true' >
                <option value="">Select Country</option>						
                <?php foreach ($location as $st): ?>
                    <?php if ($st['country_id'] == $product[0]['country_id']) { ?>
                        <option value="<?php echo $st['country_id']; ?>" selected><?php echo $st['country_name']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $st['country_id']; ?>" ><?php echo $st['country_name']; ?></option>
                    <?php } ?>                                        
                <?php endforeach; ?>                                	
            </select>
        </div>
    </div>
    <div class="form-group" >
        <input type="hidden" id='mycounter2' value="<?php echo $mycounter; ?>">
        <div class="col-md-2 col-sm-3">Emirate<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <select id="city_form2" name="state" class="select2 form-control" data-rule-required="true">
                <option value="">Select Emirate</option>
                <?php foreach ($state as $o) { ?>
                    <option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id']) ? 'selected' : ''; ?>><?php echo $o['state_name']; ?></option>
                <?php } ?>
            </select>                     
        </div>
    </div> 
    <div class="form-group">
        <div class="col-md-2 col-sm-3">Address</div>
        <div class="col-md-6 col-sm-8 controls">
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
            <input  data-zoom="15" data-latitude="latitude2" data-longitude="longitude2" data-type="googleMap" data-map_id="map2" data-lat="<?= $product_latitude ?>" data-lang="<?= $product_longitude ?>" data-input_id="google_input2" id="google_input2" type="text" class="textfield form-control" value="<?= $product[0]['address'] ?>" name="address"   placeholder="Enter a location" />
            <input data-type="latitude2" type="hidden" name="latitude" value="<?= $product[0]['latitude'] ?>">
            <input data-type="longitude2" type="hidden" name="longitude" value="<?= $product[0]['longitude'] ?>">

            <span class="message_note"></span>
            <span class="message_error2" id="address_error"></span>

        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-sm-3"></div>
        <div class="col-md-6 col-sm-8" id="map2" style="height:300px">
        </div>
    </div>
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form2"/>

            <?php $ext = explode(".", $product[0]['product_image']); ?>										
            <input type="text" class="form-control" name="cov_img" id="cov_img_form2" value="<?php echo $ext[0]; ?>"/>
        </div>
    </div>
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form2" name="video" /></div>
    </div>											
    <div class="form-actions form-actions-padding-sm btn-css005">
        <div class="">
            <div class="col-md-2 col-sm-3"></div>
            <div class="col-md-8 col-sm-7">
                <button class='btn col-md-3' type='submit' id="form2_submit" name="vehicle_submit" style="background-color:#ed1b33;color:#fff;padding:8px 33px;">
                    <i class='icon-save'></i>
                    <?php echo ($product[0]['product_is_inappropriate'] == 'NeedReview' && $product[0]['product_image'] == NULL) ? 'Repost' : 'Submit' ?>
                </button>
                <a href='<?php echo base_url(); ?>user/my_listing' title="Cancel" class="btn btn-black  col-md-3" style="color:#fff;padding:8px 33px;">Cancel</a><input type="hidden" name="form2_images_arr" id="form2_images_arr"   class="form-control" /> 
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
            $('#form2 #form_pro_price2').after('<label for="pro_name" class="error">Price less than to original price.</label>');
        } 
        if(oprice <= price){
            $('#form2 #form_org_price2').after('<label for="pro_name" class="error">Original price more than to discounted price.</label>');
        }
}   
});
</script>