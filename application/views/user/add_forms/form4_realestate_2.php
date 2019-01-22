<form name="real_estate_shared_form" style="display: none;" action='<?php echo base_url() . 'user/post_ads' ?>' class='form form-horizontal validate-form real_estate_shared_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form4">
    <h4><i class="fa fa-info-circle"></i>Item Details</h4>
    <hr />				 
    <input type="hidden" name="cat_id" id="cat_id_form4" value="<?php echo set_value('cat_id'); ?>">
    <input type="hidden" name="sub_cat" id="sub_cat_form4" value="<?php echo set_value('sub_cat'); ?>">	
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Ad Title <span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input class="form-control" placeholder="Title" name="shared_ad_title" type="text"  maxlength="80" value="<?php echo set_value('shared_ad_title'); ?>" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>
        <div class="col-md-2 col-sm-3">Describe what makes your ad unique<span> *</span></div>					
        <div class='col-md-8 col-sm-8 '>
            <textarea class='input-block-level wysihtml5 form-control' id='shared_pro_desc' name="shared_pro_desc" rows="10" placeholder="Description" data-rule-required='true'><?php echo set_value('shared_pro_desc'); ?></textarea>            
        </div>
    </div>
    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
     <div class='form-group'>     
        <div class="col-md-2 col-sm-3">Original Price</div>
        <div class='col-md-3 col-sm-4 controls'>
            <input class="form-control shared_original_price" id="form_org_price4"  placeholder="Price" name="shared_original_price" type="text" value="<?php  echo (isset($_POST['shared_original_price']) && !empty($_POST['shared_original_price'])) ? set_value('shared_original_price') : ''; ?>" />            
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
                <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
            </div>
        </div>
    </div>
    <div class='form-group  price_check'>                        
        <div class="col-md-2 col-sm-3">Discounted Price</div>					
        <div class="col-md-6 col-sm-8">
            <div class="input-group controls price-group share_grp">        
                <span style="color: #333333;" class="input-group-addon">Dirham</span>
                <input type="text" id="shared_price" name="shared_price" class="form-control price_txt"   value="<?php echo (isset($_POST['shared_price']) && !empty($_POST['shared_price'])) ? set_value('shared_price') : ''; ?>">
                <span style="color: #333333;" class="input-group-addon">.00</span>
            </div>
            <div class="checkbox ">
                <label>
                    <input type="checkbox" name="shared_free" value="1">
                    Free
                </label>
            </div>
        </div>        
        <span for="shared_price" class="help-block has-error"></span>
    </div>
    <?php }else{ ?>
    <div class='form-group  price_check'>                        
        <div class="col-md-2 col-sm-3">Price</div>					
        <div class="col-md-6 col-sm-8">
            <div class="input-group controls price-group share_grp">        
                <span style="color: #333333;" class="input-group-addon">Dirham</span>
                <input type="text" id="shared_price" name="shared_price" class="form-control price_txt"   value="<?php echo (isset($_POST['shared_price']) && !empty($_POST['shared_price'])) ? set_value('shared_price') : ''; ?>">
                <span style="color: #333333;" class="input-group-addon">.00</span>
            </div>
            <div class="checkbox ">
                <label>
                    <input type="checkbox" name="shared_free" value="1">
                    Free
                </label>
            </div>
        </div>        
        <span for="shared_price" class="help-block has-error"></span>
    </div>
    <?php } ?>
    <div class='form-group'>
        <div class="col-md-2 col-sm-3 "></div>
        <div class="col-md-4 col-sm-6">
            <div class="alert alert-info price_zero_lbl realestate_price">
                <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
            </div>
        </div>
        <span for="houses_price" class="help-block has-error for_share_price"></span>
    </div>
    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
        <div class='form-group'>     
            <div class="col-md-2 col-sm-3">Total Stock <span> *</span></div>                      
            <div class='col-md-6 col-sm-8 controls'>
                <input class="form-control total_stock"  placeholder="Total Stock" name="total_stock" id="total_stock" type="text"  value="<?php echo set_value('total_stock'); ?>" data-rule-required='true' />
            </div>
        </div>  
    <?php } ?>
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
    <div class="form-group" >
        <div class="col-md-2 col-sm-3">My Ad is in</div>
        <div class='col-md-6 col-sm-8 controls'>
            <select id="shared_language" name="shared_language" class="select2 form-control">
                <option value="0">Select</option>
                <option value="english" <?php echo set_select('shared_language', 'english'); ?>>English</option>
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
            <select class="form-control " name="location" id="location_con_form4" onchange="show_emirates_form4(this.value);" data-rule-required='true' >	
                <option value="">Select Country</option>
                <?php foreach ($location as $st): ?>
                    <?php if ($st['country_id'] == 4) { ?>
                        <option value="<?php echo $st['country_id']; ?>" selected><?php echo $st['country_name']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $st['country_id']; ?>" <?php echo set_select('location', $st['country_id']); ?>><?php echo $st['country_name']; ?></option>
                    <?php } ?>                                        
                <?php endforeach; ?>                                	
            </select>
        </div>
    </div>	
    <div class="row form-group">
        <div class="col-md-2 col-sm-3">Emirate <span> *</span></div>
        <div class="col-md-6 col-sm-8 controls">
            <select class="form-control " name="city" id="city_form4" data-rule-required='true' >
                <option value="">-- Select Emirate --</option>
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
        <div class="col-md-2 col-sm-3">Address<span> *</span></div>
        <div class="col-md-6 col-sm-8 controls">
            <input data-latitude="latitude4" data-longitude="longitude4" data-type="googleMap" data-map_id="map4" data-lat="24.231234" data-lang="54.472382" data-input_id="google_input4" id="google_input4" type="text" class="textfield form-control" value="" name="address"   placeholder="Enter a location" data-rule-required='true' />
            <input data-type="latitude4" type="hidden" name="latitude" value="">
            <input data-type="longitude4" type="hidden" name="longitude" value="">
            <span class="message_note"></span>
            <span class="message_error4" id="address_error"></span>
        </div>
    </div>	
    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3"></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input type="text" class="form-control" placeholder="Neighbourhood (Optional)" name="shared_pro_neighbourhood" maxlength="50"value="<?php echo set_value('shared_pro_neighbourhood'); ?>" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-sm-3"></div>
        <div class="col-md-6 col-sm-8" id="map4" style="height:300px">
        </div>
    </div>

    <div class="form-actions form-actions-padding-sm btn-css005">
        <div class="">
            <div class="col-md-2 col-sm-3"></div>
            <div class="col-md-8 col-sm-7">
                <button class='btn col-md-3' type='submit' id="form4_submit" name="real_estate_shared_submit" style="background-color:#ed1b33;color:#fff;padding:8px 33px;">
                    <i class='icon-save'></i>
                    Post
                </button>
                <a href='<?php echo base_url(); ?>user/post_ads' title="Cancel" class="btn btn-black  col-md-3" style="color:#fff;padding:8px 33px;">Cancel</a><input type="hidden" name="form4_images_arr" id="form4_images_arr"   class="form-control" /> 
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