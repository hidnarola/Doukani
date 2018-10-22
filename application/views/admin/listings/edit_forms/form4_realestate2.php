<?php
if (isset($_REQUEST['request_for']) && $_REQUEST['request_for'] == 'user' && isset($_REQUEST['userid'])) {
    $page_redirect = (isset($_GET['page'])) ? '&page=' . $_GET['page'] : '';
    $myredirect_path = base_url() . 'admin/classifieds/listings_edit/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $product[0]['product_id'] . '/?request_for=user&userid=' . $_REQUEST['userid'] . $page_redirect;
    $cancel_path = base_url() . 'admin/classifieds/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/?request_for=user&userid=' . $_REQUEST['userid'] . $page_redirect;
} else {
    $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
    $myredirect_path = base_url() . 'admin/classifieds/listings_edit/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $product[0]['product_id'] . $page_redirect;
    $cancel_path = base_url() . 'admin/classifieds/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . $page_redirect;
}
?>
<form name="real_estate_shared_form" style="display: none;" action='<?php echo $myredirect_path; ?>' class='form form-horizontal validate-form real_estate_shared_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form4">
    <h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
    <hr />    
    <input type="hidden" name="cat_id" value="<?php if (isset($product[0]['category_id'])) echo $product[0]['category_id']; ?>" id="cat_id_form4">
    <input type="hidden" name="sub_cat" value="<?php if (isset($product[0]['sub_category_id'])) echo $product[0]['sub_category_id']; ?>" id="sub_cat_form4">            
    <input type="hidden" id='mycounter4' value="<?php echo $mycounter; ?>">
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control" placeholder="Ad Title" value="<?php if (isset($product[0]['product_name'])) echo $product[0]['product_name']; ?>" name="shared_ad_title" type="text"  maxlength="80" data-rule-required='true' rows="10"  />
        </div>
    </div>   
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Describe what makes your ad unique<span> *</span></label>
        <div class='col-md-8 col-sm-8 '>
            <textarea class='input-block-level wysihtml5 form-control' placeholder="Description" name="shared_pro_desc" rows="6"  data-rule-required='true' ><?php if (isset($product[0]['product_description'])) echo $product[0]['product_description']; ?></textarea>
        </div>
    </div>    
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Price</label>
        <div class="input-group col-md-5 price_cont">
            <span class="input-group-addon">Dirham</span>
            <input type="text" value="<?php if (isset($product[0]['product_price'])) echo $product[0]['product_price']; ?>" id="shared_price" name="shared_price" class="form-control price_txt" >
            <span class="input-group-addon">.00</span>
        </div>
        <div class="checkbox col-md-1">
            <label>
                <input type="checkbox" <?php echo (isset($product[0]['free_status']) && $product[0]['free_status'] == 1) ? 'checked' : ''; ?> name="shared_free" value="1">
                Free
            </label>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="alert alert-info price_zero_lbl">
                <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;<?php echo price_zero_label; ?>
            </div>
        </div>
        <span for="shared_price" class="help-block has-error col-md-offset-2 col-xs-10"></span>
    </div>

    <?php if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') { ?>
        <div class='form-group'>                        
            <label class='col-md-2 control-label' for='inputText1'>Total Stock<span> *</span></label>
            <div class='col-md-5 controls'>
                <input class="form-control total_stock"  placeholder="Total Stock" value="<?php if (isset($product[0]['total_stock'])) echo $product[0]['total_stock']; ?>" name="total_stock" type="text"  data-rule-required='true' />
            </div>
        </div>
    <?php } ?>

    <?php if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') { ?>
        <div class="form-group delivery_option_section">                    
            <label class='col-md-2 control-label' for='inputText1'>Delivery Option <span> *</span></label>
            <div class="col-md-5 controls">
                <select class="select2 form-control" name="delivery_option" id="delivery_option" data-rule-required='true' >
                    <option value="">Select Delivery Option</option>
                    <?php foreach ($delivery_options as $d): ?>                    
                        <option value="<?php echo $d['id'] ?>" <?php echo ($product[0]['delivery_option'] == $d['id']) ? 'selected' : ''; ?>><?php echo $d['option_text'] ?></option>                    
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
                        <option value="<?php echo $w['id'] ?>" <?php echo ($product[0]['weight'] == $w['id']) ? 'selected' : ''; ?>><?php echo $w['weight_text'] ?></option>                    
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
            <select class="select2 form-control" name="location" id="location_con_form4" onchange="show_emirates_form4(this.value);" data-rule-required='true' >	
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

        <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
        <div class='col-md-5  controls'>
            <select  name="state" class="select2 form-control" onchange="show_emirates(this.value);"  id="city_form4" data-rule-required='true'>
                <option value="">Select</option>
                <?php foreach ($state as $o) { ?>
                    <option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id']) ? 'selected' : ''; ?>><?php echo $o['state_name']; ?></option>
                <?php } ?>
            </select>    													
        </div>
    </div>
    <div class="form-group">
        <label class='col-md-2 control-label' for='inputText1'>Address<span> *</span></label>
        <div class='col-md-5 controls'>
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
        <div class='col-md-offset-2 col-md-5 controls'>

            <input type="text" class="form-control" value="<?php if (isset($product[0]['neighbourhood'])) echo $product[0]['neighbourhood']; ?>" placeholder="Neighbourhood (Optional)" name="shared_pro_neighbourhood" maxlength="50"/>
        </div>
    </div>

    <div class="form-group">
        <label class='col-md-2 control-label' for='inputText1'></label>
        <div class="col-md-6 col-sm-8" id="map4" style="height:300px">
        </div>
    </div>

    <div class="form-group" >
        <label class='col-md-2 control-label' for='inputText1'>My Ad is in</label>
        <div class='col-md-5'>
            <select id="shared_language" name="shared_language" class="select2 form-control">
                <option <?php echo ($product[0]['ad_language'] == 0 || $product[0]['ad_language'] == '') ? 'selected' : ''; ?> value="0">Select</option>
                <option <?php echo ($product[0]['ad_language'] == 'english') ? 'selected' : ''; ?> value="english">English</option>
            </select>                     
        </div>
    </div>
    <div class='form-group'>                        
        <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
        <div class='col-md-5 controls'>
            <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  value='<?php if (isset($product[0]['phone_no'])) echo $product[0]['phone_no']; ?>' onkeypress="return isNumber1(event)" data-rule-required='true' />
        </div>
    </div>
    <?php
    $admin_permission = $this->session->userdata('admin_modules_permission');
    if ($admin_permission == 'only_listing') {
        ?>    
        <input id="product_is_inappropriate" name="product_is_inappropriate" class="form-control" type="hidden" value="Unapprove">                 
    <?php } else { ?>
        <div class="form-group" >
            <label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
            <div class='col-md-5 controls'>
                <select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control select2" data-rule-required='true'>
                    <option value="">Select</option>
                    <option value="NeedReview" <?php if ($product[0]['product_is_inappropriate'] == 'NeedReview'): echo 'selected=selected';
    endif;
        ?>>NeedReview</option>
                    <option value="Approve" <?php if ($product[0]['product_is_inappropriate'] == 'Approve'): echo 'selected=selected';
                        endif;
                        ?>>Approve</option>
                    <option value="Unapprove" <?php if ($product[0]['product_is_inappropriate'] == 'Unapprove'): echo 'selected=selected';
                        endif;
        ?>>Unapprove</option>
                    <option value="Inappropriate" <?php if ($product[0]['product_is_inappropriate'] == 'Inappropriate'): echo 'selected=selected';
                        endif;
                        ?>>Inappropriate</option>
                </select>                   
            </div>
        </div>
            <?php } ?>
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
    <div class="form-actions form-actions-padding-sm btn-btm-css">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <button class='btn btn-primary' type='submit' id="form4_submit" name="real_estate_shared_submit">
                    <i class="fa fa-floppy-o"></i>
<?php echo ($product[0]['product_is_inappropriate'] == 'NeedReview' && $product[0]['product_image'] == NULL) ? 'Repost' : 'Submit' ?>
                </button>
                <a href='<?php echo $cancel_path; ?>' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form4_images_arr" id="form4_images_arr"   class="form-control" /> 
            </div>
        </div>
    </div>
</form>	