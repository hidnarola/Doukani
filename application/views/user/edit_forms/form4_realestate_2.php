<form name="real_estate_shared_form" style="display: none;" action='<?php echo base_url() . 'user/listings_edit/' . $product[0]['product_id'] ?>' class='form form-horizontal validate-form real_estate_shared_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form4">
    <h4><i class="fa fa-info-circle"></i>Item Details</h4>
    <hr /> 
    <input type="hidden" name="cat_id" value="<?php if (isset($product[0]['category_id'])) echo $product[0]['category_id']; ?>" id="cat_id_form4">
    <input type="hidden" name="sub_cat" value="<?php if (isset($product[0]['sub_category_id'])) echo $product[0]['sub_category_id']; ?>" id="sub_cat_form4">          

    <div class='form-group'>                        
        <div class="col-md-2 col-sm-3">Ad Title<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls'>
            <input class="form-control" placeholder="Ad Title" value="<?php echo $product[0]['product_name']; ?>" name="shared_ad_title" type="text"  maxlength="80" data-rule-required='true' />
        </div>
    </div>
    <div class='form-group'>
        <div class="col-md-2 col-sm-3">Describe what makes your ad unique<span> *</span></div>					
        <div class='col-md-8 col-sm-8 '>			
            <textarea class='input-block-level wysihtml5 form-control' id='shared_pro_desc' name="shared_pro_desc" rows="10" placeholder="Description" data-rule-required='true'><?php echo $product[0]['product_description']; ?></textarea>			
        </div>
    </div>   
    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
        <div class='form-group'>     
            <div class="col-md-2 col-sm-3">Original Price</div>
            <div class='col-md-3 col-sm-4 controls'>
                <input class="form-control shared_original_price" id="form_org_price4"  placeholder="Price" name="shared_original_price" type="text" value="<?php echo $product[0]['original_price']; ?>" />            
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="alert alert-info price_zero_lbl">
                    <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                </div>
            </div>
        </div>
        <div class='form-group'>                        
            <div class="col-md-2 col-sm-3">Discounted Price</div>                                                
            <div class="col-md-6 col-sm-8">
                <div class="input-group controls price-group">
                    <span class="input-group-addon">Dirham</span>
                    <input type="text" value="<?php echo $product[0]['product_price']; ?>" id="shared_price" name="shared_price" class="form-control price_txt" >
                    <span class="input-group-addon">.00</span>
                </div>
                <div class="checkbox col-md-2">
                    <label>
                        <input type="checkbox" <?php echo ($product[0]['free_status'] == 1) ? 'checked' : ''; ?> name="shared_free" value="1">
                        Free
                    </label>
                </div>						  
            </div>
            <span for="shared_price" class="help-block has-error"></span>
        </div>
    <?php } else { ?>
        <div class='form-group'>                        
            <div class="col-md-2 col-sm-3">Price</div>                                                
            <div class="col-md-6 col-sm-8">
                <div class="input-group controls price-group">
                    <span class="input-group-addon">Dirham</span>
                    <input type="text" value="<?php echo $product[0]['product_price']; ?>" id="shared_price" name="shared_price" class="form-control price_txt" >
                    <span class="input-group-addon">.00</span>
                </div>
                <div class="checkbox col-md-2">
                    <label>
                        <input type="checkbox" <?php echo ($product[0]['free_status'] == 1) ? 'checked' : ''; ?> name="shared_free" value="1">
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
        <span for="houses_price" class="help-block has-error"></span>
    </div>

    <?php if (isset($logged_in_user['last_login_as']) && $logged_in_user['last_login_as'] == 'storeUser') { ?>
        <div class='form-group'>                        
            <div class="col-md-2 col-sm-3">Total Stock<span> *</span></div>
            <div class='col-md-6 col-sm-8 controls'>
                <input class="form-control"  placeholder="Total Stock" value="<?php echo $product[0]['total_stock']; ?>" name="total_stock" type="text"  data-rule-required='true' />
            </div>
        </div>
    <?php } ?>

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
            <div class="col-md-2 col-sm-3">Product Weight (in kg)<span> *</span></div>
            <div class="col-md-6 col-sm-8 controls">
                <input type="number" class="form-control" name="weight" id="weight" data-rule-required='true' value="<?php echo $product[0]['weight']; ?>">
    <!--                <select class="select2 form-control" name="weight" id="weight" data-rule-required='true' >
                    <option value="">Select Product Weight</option>
                <?php // foreach ($product_weights as $w): ?>                    
                        <option value="<?php // echo $w['id']  ?>" <?php // echo ($product[0]['weight'] == $w['id']) ? 'selected' : '';  ?>><?php // echo $w['weight_text']  ?></option>                    
                <?php // endforeach; ?>
                </select>-->
            </div>
        </div>
    <?php } ?>

    <h4><i class="fa fa-home"></i>Contact Details</h4>
    <hr />								
    <div class="form-group">                    
        <div class="col-md-2 col-sm-3">Country <span> *</span></div>
        <div class="col-md-6 col-sm-8 controls"> 
            <select class="select2 form-control" name="location" id="location_con_form4" onchange="show_emirates_form4(this.value);" data-rule-required='true'>	
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
        <div class="col-md-2 col-sm-3">Emirate<span> *</span></div>
        <div class='col-md-6 col-sm-8 controls controls'>
            <select id="city_form4" name="state" class="select2 form-control" data-rule-required="true">
                <option value="">Select Emirate</option>
                <?php foreach ($state as $o) { ?>
                    <option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id']) ? 'selected' : ''; ?>><?php echo $o['state_name']; ?></option>
                <?php } ?>
            </select>                     
        </div>
    </div>                                           
    <div class="form-group">
        <div class="col-md-2 col-sm-3">Address<span> *</span></div>
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
            <input  data-zoom="15" data-latitude="latitude4" data-longitude="longitude4" data-type="googleMap" data-map_id="map4" data-lat="<?= $product_latitude ?>" data-lang="<?= $product_longitude ?>" data-input_id="google_input4" id="google_input4" type="text" class="textfield form-control" value="<?= $product[0]['address'] ?>" name="address"   placeholder="Enter a location" data-rule-required='true' />
            <input data-type="latitude4" type="hidden" name="latitude" value="<?= $product[0]['latitude'] ?>">
            <input data-type="longitude4" type="hidden" name="longitude" value="<?= $product[0]['longitude'] ?>">

            <span class="message_note"></span>
            <span class="message_error4" id="address_error"></span>

        </div>
    </div>
    <div class='form-group'>                        
        <div class='col-md-offset-2 col-sm-6 col-sm-8 controls'>
            <input type="hidden" id='mycounter4' value="<?php echo $mycounter; ?>">
            <input type="text" class="form-control" value="<?php echo $product[0]['neighbourhood']; ?>" placeholder="Neighbourhood (Optional)" name="shared_pro_neighbourhood" maxlength="50"/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-sm-3"></div>
        <div class="col-md-6 col-sm-8" id="map4" style="height:300px">
        </div>
    </div>
    <div class="form-group" >
        <div class="col-md-2 col-sm-3">My Ad is in</div>
        <div class='col-md-6 col-sm-8 controls'>
            <select id="shared_language" name="shared_language" class="select2 form-control">
                <option <?php echo ($product[0]['ad_language'] == 0 || $product[0]['ad_language'] == '') ? 'selected' : ''; ?> value="0">Select</option>
                <option <?php echo ($product[0]['ad_language'] == 'english') ? 'selected' : ''; ?> value="english">English</option>
            </select>                     
        </div>
    </div>	
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Youtube Link</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form4"/>
            <?php $ext = explode(".", $product[0]['product_image']); ?>												
            <input type="text" class="form-control" name="cov_img" id="cov_img_form4" value="<?php echo $ext[0]; ?>"/>
        </div>
    </div>
    <div class="row form-group" style="margin-top:20px;display:none;">
        <div class="col-md-2 col-sm-3">Upload Video</div>
        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form4" name="video" /></div>
    </div>				
    <div class="form-actions form-actions-padding-sm btn-css005">
        <div class="">
            <div class="col-md-2 col-sm-3"></div>
            <div class="col-md-8 col-sm-7">
                <button class='btn col-md-3' type='submit' id="form4_submit" name="real_estate_shared_submit" style="background-color:#ed1b33;color:#fff;padding:8px 33px;">
                    <i class='icon-save'></i>
                    <?php echo ($product[0]['product_is_inappropriate'] == 'NeedReview' && $product[0]['product_image'] == NULL) ? 'Repost' : 'Submit' ?>
                </button>
                <a href='<?php echo base_url(); ?>user/my_listing' title="Cancel" class="btn btn-black  col-md-3" style="color:#fff;padding:8px 33px;">Cancel</a><input type="hidden" name="form4_images_arr" id="form4_images_arr"   class="form-control" /> 
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form4 #shared_price').focusout(function () {
            validateForm();
        });
        $('#form4 #form_org_price4').focusout(function () {
            validateForm();
        });
        function validateForm() {
            var price = $('#form4 #shared_price').val();
            var oprice = $('#form4 #form_org_price4').val();
            $('.error').hide();
            if (price >= oprice) {
                $('#form4 .for_share_price').after('<label for="pro_name" class="error">Price less than to original price.</label>');
            }
            if (oprice <= price) {
                $('#form4 #form_org_price4').after('<label for="pro_name" class="error">Original price more than to discounted price.</label>');
            }
        }
    });
</script>