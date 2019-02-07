<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='page-header page-header-with-buttons'>
                                <h1 class='pull-left'>
                                    <i class='icon-building'></i>
                                    <span>Stores</span>
                                </h1>
                                <div class='pull-right'>
                                    <i class='fa fa-ambulance'></i>
                                    <a href="<?php echo base_url(); ?>admin/users/store_shipping_cost/<?php echo $old_store_details[0]->store_id; ?>" class="edit_ship_cost">Edit Shipping Cost</a>
                                </div>	
                            </div>
                            <hr>
                            <?php if (validation_errors() != false) { ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='<?php echo base_url(); ?>/'>&times;</a>
                                    <?php echo validation_errors(); ?>                              
                                </div>                          
                            <?php } ?>
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Edit Store
                                        </div>						
                                    </div>
                                    <div class='box-content'>
                                        <?php
                                        $redirect = $_SERVER['QUERY_STRING'];
                                        if (!empty($_SERVER['QUERY_STRING']))
                                            $redirect = '/?' . $redirect;
                                        ?>
                                        <form action='<?php echo base_url() . 'admin/users/edit_store/' . $old_store_details[0]->store_id . $redirect; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="store_edit">
                                            <input class="form-control" name="store_owner" type='hidden' value="<?php echo $old_store_details[0]->store_owner; ?>">
                                            <input class="form-control" name="store_id" type='hidden' value="<?php echo $old_store_details[0]->store_id; ?>">
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Category<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select class="form-control" id="category_id" name="category_id1" onchange="show_sub_cat(this.value);" <?php if ($product_count > 0) echo 'disabled'; ?> data-rule-required="true">
                                                        <option value="">Select Category</option>
                                                        <option value="0" <?php echo ($old_store_details[0]->category_id == 0) ? 'selected' : ''; ?>>Store Website</option>
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>" <?php echo ($cat['category_id'] == $old_store_details[0]->category_id) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                            <div class='form-group sub_cat_block' style="<?php echo ($old_store_details[0]->category_id == 0) ? 'display:none;' : ''; ?>" >
                                                <label class='col-md-2 control-label' for='inputText1'>Sub Category<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select class="form-control" id="sub_category_id" name="sub_category_id1" <?php if ($product_count > 0) echo 'disabled'; ?>>
                                                        <option value="">ALL</option>
                                                        <?php foreach ($sub_category as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>" <?php echo ($cat['sub_category_id'] == $old_store_details[0]->sub_category_id) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Store Sub-domain<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Store Domain' class="form-control" name="store_domain" id="store_domain" type='text' value="<?php echo $old_store_details[0]->store_domain; ?>" data-rule-required='true' onkeypress="return isNumber1(event);" maxlength="20">
                                                    <span id="full_domain"><?php echo $old_store_details[0]->store_domain; ?>.doukani.com</span>
                                                    <br>
                                                    <span class="store_domain_status"></span>
                                                </div>
                                            </div>
                                            <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                <hr class='hr-normal'>
                                                <div class='form-group'>

                                                    <label class='col-md-2 control-label' for='inputText1'>Detail</label>
                                                    <div class='col-md-5 controls'>
                                                        <b style="color:#00acec;">Old Details</b>
                                                    </div>
                                                    <div class='col-md-5 controls'>
                                                        <b style="color:#00acec;">New Details</b>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Store Name<span>*</span></label>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <span><?php echo $old_store_details[0]->store_name; ?></span>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='New Store Name' class="form-control" name="new_store_name" id="new_store_name"  type='text' value="<?php echo $old_store_details[0]->store_name; ?>" data-rule-required='true' maxlength="50" >
                                                        <span class="store_name_status"></span>
                                                    </div>
                                                <?php } ?>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='New Store Name' class="form-control" name="new_store_name" id="new_store_name"  type='text' value="<?php echo $new_store_details[0]->store_name; ?>" data-rule-required='true' maxlength="50" >
                                                        <span class="store_name_status"></span>
                                                    </div>
                                                <?php } ?>   
                                            </div>


                                            <div class='form-group website_url' style="<?php echo ($old_store_details[0]->category_id > 0) ? 'display:none;' : ''; ?>">
                                                <label class='col-md-2 control-label' for='inputText1'>Website URL<span>*</span></label>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <span><?php echo $old_store_details[0]->website_url; ?></span>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='New Website URL' class="form-control" name="new_website_url" type='text' value="<?php echo $old_store_details[0]->website_url; ?>" data-rule-required='true' maxlength="50" >
                                                    </div>
                                                <?php } ?>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='New Website URL' class="form-control" name="new_website_url" type='text' value="<?php echo $new_store_details[0]->website_url; ?>" data-rule-required='true' maxlength="50" >
                                                    </div>
                                                <?php } ?>   
                                            </div>


                                            <div class='form-group store_desc' style="<?php echo ($old_store_details[0]->category_id == 0) ? 'display:none;' : ''; ?>">
                                                <label class='col-md-2 control-label' for='inputText1'>Store Description</label>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <span><?php echo $old_store_details[0]->store_description; ?></span>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class='col-md-5 controls'>
                                                        <textarea cols="78" rows="5" class="form-control" name="new_store_description" ><?php echo $old_store_details[0]->store_description; ?></textarea>
                                                    </div>                                                        
                                                <?php } ?>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <textarea cols="78" rows="5" class="form-control" name="new_store_description" ><?php echo $new_store_details[0]->store_description; ?></textarea>
                                                    </div>
                                                <?php } ?>
                                            </div>                                            
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Store Cover Image</label>
                                                <div class='col-md-5'>
                                                    <div class="cover-size-div">Recommend Size: 1920*440</div>
                                                    <?php
                                                    if ($old_store_details[0]->new_data_status == 1) {
                                                        
                                                    } else {
                                                        ?>

                                                        <input title='Store Cover Image' name='new_store_cover_image' type='file' class='form-control' onchange="javascript:loadimage(this);" id="new_store_cover_image">                                                
                                                    <?php } ?>
                                                </div>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5'>
                                                        <input title='New Store Cover Image' name='new_store_cover_image' type='file' class='form-control' onchange="javascript:loadimage(this);" id="new_store_cover_image">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'></label>
                                                <div class='col-md-9'>
                                                    <img alt="Image" src="" id="blah1">
                                                </div>
                                            </div>
                                            <?php
                                            //if (!empty($old_store_details[0]->store_cover_image)): 
                                            $store_start = thumb_start_grid_store_cover . HTTPS . website_url;
                                            $store_end = thumb_end_grid_store_cover;
                                            if ($old_store_details[0]->store_cover_image != '')
                                                $store_cover_img = $store_start . store_cover . "medium/" . $old_store_details[0]->store_cover_image . $store_end;
                                            else
                                                $store_cover_img = $store_start . base_url() . 'assets/upload/store_cover_image.png' . $store_end;
                                            if ($old_store_details[0]->new_data_status == 1) {
                                                $store_start = thumb_start_grid_store_cover . HTTPS . website_url;
                                                $store_end = thumb_end_grid_store_cover;
                                                if ($new_store_details[0]->store_cover_image != '')
                                                    $new_store_cover_img = $store_start . store_cover . "medium/" . $new_store_details[0]->store_cover_image . $store_end;
                                                else
                                                    $new_store_cover_img = $store_start . base_url() . 'assets/upload/store_cover_image.png' . $store_end;
                                            }
                                            ?>
                                            <div class='form-group'>
                                                <div class="col-md-2"></div>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5'>                                  
                                                    </div>
                                                <?php } else { ?>
                                                    <div class='col-md-5'>
                                                        <img alt="New Store Cover Image" src="<?php echo $store_cover_img; ?>" onerror="this.src='<?php echo $store_start . base_url() . 'assets/upload/store_cover_image.png' . $store_end; ?>'"/>
                                                    </div>
                                                <?php } ?>

                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5'>
                                                        <img alt="New Store Cover Image" src="<?php echo $new_store_cover_img; ?>" onerror="this.src='<?php echo $store_start . base_url() . 'assets/upload/store_cover_image.png' . $store_end; ?>'"/>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php //endif;   ?>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Meta Title</label>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <span><?php echo $old_store_details[0]->meta_title; ?></span>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='New Meta Title' class="form-control" name="new_meta_title" type='text' value="<?php echo $old_store_details[0]->meta_title; ?>" maxlength="255" >
                                                    </div>
                                                <?php } ?>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='New Meta Title' class="form-control" name="new_meta_title" type='text' value="<?php echo $new_store_details[0]->meta_title; ?>" maxlength="255" >
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Meta Description</label>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <span><?php echo $old_store_details[0]->meta_description; ?></span>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class='col-md-5 controls'>
                                                        <textarea cols="78" rows="5" class="form-control" name="new_meta_description" ><?php echo $old_store_details[0]->meta_description; ?></textarea>                                                
                                                    </div>
                                                <?php } ?>
                                                <?php if ($old_store_details[0]->new_data_status == 1) { ?>
                                                    <div class='col-md-5 controls'>
                                                        <textarea cols="78" rows="5" class="form-control" name="new_meta_description" ><?php echo $new_store_details[0]->meta_description; ?></textarea>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <hr class='hr-normal'> 
                                            <?php //if($old_store_details[0]->store_details_verified==0) {    ?>       
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Store's New Details Verification</label>
                                                <div class='col-md-1 controls'>
                                                    <input type="checkbox"  name="store_details_verified" id="store_details_verified"  value="1"  <?php if ($old_store_details[0]->store_details_verified == 1) echo 'checked'; ?> /> 
                                                </div>
                                                <div class='col-md-5 controls' style="color:red;">
                                                    (Note: When you click this, it will display in Store Related Pages (Front End). Make sure for Store's new details before you click to this check box)
                                                </div>
                                            </div>
                                            <?php //}    ?>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Active/Hold Status<span>*</span></label>
                                                <div class='col-md-3 controls'>
                                                    <select name="store_status" id="store_status" data-rule-required='true' class="form-control">    
                                                        <option value="">Select</option>
                                                        <option value="0" <?php if ($old_store_details[0]->store_status == 0) echo 'selected'; ?>>Active</option>
                                                        <option value="3" <?php if ($old_store_details[0]->store_status == 3) echo 'selected'; ?>>Hold</option>
                                                    </select>                
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Status<span>*</span></label>
                                                <div class='col-md-3 controls'>
                                                    <select name="store_is_inappropriate" id="store_is_inappropriate" data-rule-required='true' class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="NeedReview" <?php if ($old_store_details[0]->store_is_inappropriate == 'NeedReview') echo 'selected'; ?>>NeedReview</option>
                                                        <option value="Approve" <?php if ($old_store_details[0]->store_is_inappropriate == 'Approve') echo 'selected'; ?>>Approve</option>
                                                        <option value="Unapprove" <?php if ($old_store_details[0]->store_is_inappropriate == 'Unapprove') echo 'selected'; ?>>Unapprove</option>
                                                        <option value="Inappropriate" <?php if ($old_store_details[0]->store_is_inappropriate == 'Inappropriate') echo 'selected'; ?>>Inappropriate</option>
                                                    </select>                
                                                </div>
                                            </div>                                            
                                            <div class='form-group shopping_cost' style="<?php echo ($old_store_details[0]->category_id == 0) ? 'display:none;' : ''; ?>">
                                                <label class='col-md-2 control-label' for='inputText1'>Shipping Cost</label>
                                                <div class='col-md-3 controls'>
                                                    <input type="text" name="shipping_cost" id="shipping_cost" class="form-control" value="<?php echo $old_store_details[0]->shipping_cost; ?>">
                                                </div>
                                            </div>
                                            <div class='form-group shopping_cost' style="<?php echo ($old_store_details[0]->category_id == 0) ? 'display:none;' : ''; ?>">
                                                <label class='col-md-2 control-label' for='inputText1'>Commission on purchase</label>
                                                <div class='col-md-3 controls'>
                                                    <input type="number" name="commission_on_purchase_from_store" id="commission_on_purchase_from_store" class="form-control" value="<?php echo $old_store_details[0]->commission_on_purchase_from_store; ?>">
                                                    <b>In % (percentage)</b>
                                                </div>
                                            </div>
                                            <?php
//                                                if(isset($state) && sizeof($state)>0) { 
//                                                    foreach ($state as $st) {
                                            ?>
                                            <!--                                            <div class='form-group'>
                                                                                            <label class='col-md-2 control-label' for='inputText1'><?php // echo $st['state_name'];     ?></label>
                                                                                            <div class='col-md-3 controls'>
                                            <?php // $costing =  $this->dbcommon->shipping_cost($old_store_details[0]->store_owner,$st['state_id']);    ?>
                                                                                                <input type="text" name="state_<?php // echo $st['state_id'];    ?>" id="state_<?php // echo $st['state_id'];    ?>" value="<?php // if(isset($costing->shipping_cost) && sizeof($costing->shipping_cost) > 0) echo $costing->shipping_cost    ?>" class="form-control">                                                    
                                                                                            </div>
                                                                                        </div>-->
                                            <?php
//   }
//                                                 }                                              
                                            ?>			   
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit'>
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='<?php echo base_url() . "admin/users/index/storeUser" . $redirect; ?>' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script>
            var flag1 = 0;
            var flag2 = 0;

            $(document).on("change", "#new_store_name", function (e) {
                var store_name = $(this).val();
                if (store_name) {
                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url() . 'home/check_store_name' ?>',
                        data: {
                            store_name: store_name, user_id: '<?php echo $old_store_details[0]->store_owner; ?>'
                        },
                        success: function (response) {
                            if (response == "OK") {
                                $('.store_name_status').html('');
                                flag1 = 0;
                                return true;
                            } else {
                                flag1 = 1;
                                $('.store_name_status').html('<font color="#b94a48">' + response + '</font>');
                                return false;
                            }
                        }
                    });
                } else {
                    $('.store_name_status').html("");
                    return false;
                }
            });


            $(document).on("change", "#store_domain", function (e) {
                var store_domain = $(this).val();
                if (store_domain) {
                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url() . 'home/check_store_domain' ?>',
                        data: {
                            store_domain: store_domain, user_id: '<?php echo $old_store_details[0]->store_owner; ?>'
                        },
                        success: function (response) {
                            if (response == "OK") {
                                $('.store_domain_status').html('');
                                flag2 = 0;
                                return true;
                            } else {
                                flag2 = 1;
                                $('.store_domain_status').html('<font color="#b94a48">' + response + '</font>');
                                return false;
                            }
                        }
                    });
                } else {
                    $('.store_domain_status').html("");
                    return false;
                }
            });

            $("#store_edit").submit(function (event) {
                if (flag1 == 1 || flag2 == 1)
                    return false;
            });

            function isNumber1(evt) {
                e = (evt) ? evt : window.event;
                var valid = (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 122) || (e.which == 8);
                if (!valid) {
                    e.preventDefault();
                }
            }

            $(document).on("keypress keyup focusin blur cut paste", "#store_domain", function (e) {
                //$("#store_domain").keypress(function() {            
                $('#full_domain').html('');
                $('#full_domain').html($('#store_domain').val() + '.doukani.com');
            });

            $(document).on("keypress", "#shipping_cost", function (e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if ((charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 46)
                    return true;
                else
                    return false;
            });

            function show_sub_cat(val) {

                if (val > 0) {
                    $('.website_url').hide();
                    $('.sub_cat_block').show();
                    $('.store_desc').show();
                    $('.shopping_cost').show();

                    $("input[name='category_id1']").val(val);

                    var sub_cat = '<?php echo $old_store_details[0]->sub_category_id; ?>';

                    var url = "<?php echo base_url(); ?>admin/stores/show_sub_cat";
                    $.post(url, {value: val, sub_cat_id: sub_cat}, function (data)
                    {
                        $("#sub_category_id").html(data);
                    });
                } else {
                    $('.sub_cat_block').hide();
                    $('.shopping_cost').hide();
                    $('.store_desc').hide();
                    $('.website_url').show();
                }
            }

            $('#blah1').hide();

            function loadimage(input) {

                var new_store_cover_image = $("#new_store_cover_image").val();
                if (new_store_cover_image != '') {
                    var file_data = $("#new_store_cover_image").prop("files")[0];
                    var type = file_data.type;
                    if (file_data) {
                        if (type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif") {
                            $('#new_store_cover_image').val('');
                            $(document).find('.file-input-name').html('');
                            $(".file-input-name").html("");
                            var imgcon = $("#blah1")[0];
                            $(imgcon).attr("src", "");
                            $(imgcon).hide();

                            $(document).find('.response_message').html('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                            $(document).find("#search_alert").modal('show');
                            return false;
                        }
                    }
                }

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {

                        $('#blah1').attr('src', e.target.result);
                        var imgcon = $("#blah1")[0];
                        var img = imgcon;

                        var pic_real_width, pic_real_height;
                        $("<img/>")
                                .attr("src", $(img).attr("src"))
                                .load(function () {
                                    pic_real_width = this.width;
                                    pic_real_height = this.height;

                                    $(imgcon).attr("src", $(img).attr("src"));
                                    $(imgcon).show();
                                });
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
    </body>
</html>