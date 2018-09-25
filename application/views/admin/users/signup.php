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
                                    <?php
                                    $seg44 = $this->uri->segment(4);
                                    $user_type = '';
                                    if ($seg44 == 'generalUser') {
                                        $user_type = 'Classified User';
                                        echo "<i class='icon-user'></i>";
                                    } elseif ($seg44 == 'storeUser') {
                                        $user_type = 'Store User';
                                        echo "<i class='icon-building'></i>";
                                    } elseif ($seg44 == 'offerUser') {
                                        $user_type = 'Offer User';
                                        echo "<i class='icon-tags'></i>";
                                    }
                                    ?>
                                    <span>Users</span>
                                </h1>               
                            </div>
                            <hr class="hr-normal">
                            <div class='col-md-12'>
                                <?php if (validation_errors() != false) { ?>
                                    <div class='alert alert-info text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo validation_errors(); ?>                              
                                    </div>                          
                                <?php } ?>
                                <?php if (isset($msg)): ?>
                                    <div class='alert  <?php echo $msg_class; ?>'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $msg; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-plus'></div>
                                            Add User
                                        </div>
                                    </div>                                    
                                    <div class='box-content'>
                                        <form action='<?php echo base_url(); ?>admin/users/add_user/<?php echo $this->uri->segment(4); ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="registration" name="registration" onsubmit="return  submit_call();">
                                            <?php
                                            $rule = "data-rule-required='true'";
                                            $span = "<span>*</span>";
                                            if ($this->uri->segment(4) == 'offerUser') {
                                                $rule = '';
                                                $span = '';
                                            }
                                            ?>

                                            <input type="hidden" name="user_role" value="<?php echo $this->uri->segment(4); ?>">
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>E-mail<?php echo $span; ?></label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder="E-mail" class="form-control" name="email_id" id="email_id" type="text" <?php echo $rule; ?> value="<?php echo set_value('email_id'); ?>"/>
                                                    <span id="email_status"></span>
                                                </div>
                                            </div>    
                                            <?php if ($this->uri->segment(4) == 'storeUser') { ?>
                                                <!--                                                <div class='form-group'>
                                                                                                    <label class='col-md-2 control-label' for='inputText1'>PayPal E-mail</label>
                                                                                                    <div class='col-md-5 controls'>
                                                                                                        <input placeholder="PayPal E-mail" class="form-control" name="paypal_email_id" id="paypal_email_id" type="text" value="<?php echo set_value('paypal_email_id'); ?>"/>
                                                                                                        <span id="paypal_email_id"></span>
                                                                                                    </div>
                                                                                                </div>-->
                                            <?php } ?>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>First Name<?php echo $span; ?></label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder="First Name" class="form-control" name="first_name" id="first_name" type="text" <?php echo $rule; ?> value="<?php echo set_value('first_name'); ?>" />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Last Name<?php echo $span; ?></label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder="Last Name" class="form-control" name="last_name" id="last_name" type="text" <?php echo $rule; ?> value="<?php echo set_value('last_name'); ?>" />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Username<?php echo $span; ?></label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder="Username" class="form-control" name="username"  id="username" type="text" <?php echo $rule; ?> value="<?php echo (isset($_POST['username'])) ? $_POST['username'] : ''; ?>"/>
                                                    <span id="username_status"></span>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Nickname</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder="Nickname" class="form-control" name="nick_name"  id="nick_name" type="text" value="<?php echo (isset($_POST['nick_name'])) ? $_POST['nick_name'] : ''; ?>" />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Contact Number</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Contact Number'  class="form-control"  name="phone" id="phone" type='text'  data-rule-number='true' onkeypress="return isNumber(event)" value="<?php echo (isset($_POST['phone'])) ? $_POST['phone'] : ''; ?>"/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Password</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Password' class="pwstrength form-control" name="password"  type='password' id="password" />
                                                    <!--data-rule-required='true'-->
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Confirm Password</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Confirm Password' class="form-control" name="cnfpassword" id="cnfpassword" type='password' data-rule-equalto="#password"  />
                                                    <!--data-rule-required='true'-->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class='col-md-2 control-label' for='inputText1'>Gender</label>
                                                <div class='col-md-5 controls'>
                                                    <label><input type="radio" value="1" name="gender" id="gender" checked />&nbsp;&nbsp;Male</label>&nbsp;&nbsp;
                                                    <label><input type="radio" value="0" name="gender" id="gender" />&nbsp;&nbsp;Female</label>
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <label class='col-md-2 control-label' for='inputText1'>Birth Date</label>
                                                <div class='datetimepicker input-group col-md-5 controls' id='datepicker'>
                                                    <input class='form-control' data-format='yyyy-MM-dd' name="date_of_birth"  id="date_of_birth" placeholder='Select Birth Date' type='text' value="<?php echo set_value('date_of_birth'); ?>">
                                                    <span class='input-group-addon '><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <font color="#b94a48" style="font-size: 14px; font-weight:lighter !important; "><span id="lbl_dbo"></span></font>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Nationality</label>
                                                <div class='col-md-5 controls'>
                                                    <select id="nationality" name="nationality" class="select2 form-control">   
                                                        <option value="">Select Nationality</option>
                                                        <?php foreach ($nationality as $o) { ?>
                                                            <option value="<?php echo $o['nation_id']; ?>" <?php echo (isset($_POST['nationality']) && $_POST['nationality'] == $o['nation_id']) ? 'selected' : ''; ?>><?php echo $o['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Country<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select id="location" name="country" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required='true'>                                                        
                                                        <?php foreach ($location as $o) { ?>
                                                            <option    value="<?php echo $o['country_id']; ?>" <?php echo (isset($_REQUEST['country']) && $_REQUEST['country'] == $o['country_id']) ? 'selected' : ''; ?>><?php echo $o['country_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Emirate</label>    
                                                <div class='col-md-5 controls'>
                                                    <select id="sub_state_list" name="state" class=" form-control"></select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Address</label>
                                                <div class='col-md-5 controls'>
                                                    <textarea class="form-control"  name="user_address" id="user_address"><?php echo (isset($_REQUEST['user_address'])) ? $_REQUEST['user_address'] : ''; ?></textarea>
                                                </div>
                                            </div>

                                            <!-- Start Store Part -->
                                            <div id="store_details" <?php
                                            if ($this->uri->segment(4) == 'storeUser')
                                                echo '';
                                            else
                                                echo 'style="display:none;"'
                                                ?> >
                                                <hr/>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'></label>
                                                    <div class='col-md-5 controls'>
                                                        <h4><i class="fa fa-home"></i>&nbsp;&nbsp;Store Details</h4>
                                                    </div>
                                                </div>
                                                <hr />

                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Category<span>*</span></label>
                                                    <div class='col-md-5 controls'>
                                                        <select class="form-control" id="category_id" name="category_id" onchange="show_sub_cat1(this.value);" data-rule-required="true">
                                                            <option value="">Select</option>
                                                            <option value="0">Store Website</option>
                                                            <?php foreach ($category as $cat): ?>
                                                                <option value="<?php echo $cat['category_id']; ?>" <?php if (isset($_REQUEST['category_id']) && $_REQUEST['category_id'] == $cat['category_id']) echo 'selected'; ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>                                                    
                                                    </div>
                                                </div>
                                                <div class='form-group sub_cat_block'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Sub Category</label>
                                                    <div class='col-md-5 controls'>
                                                        <select class="form-control" id="sub_category_id" name="sub_category_id">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Store Sub-domain<span>*</span></label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Store Domain' class="form-control" name="store_domain" id="store_domain" type='text'  onkeypress="return isNumber1(event);" maxlength="15" value="<?php echo set_value('store_domain'); ?>" data-rule-required='true'>
                                                        <span id="full_domain"></span>
                                                        <br>
                                                        <span class="store_domain_status"></span>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Store Name<span>*</span></label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Store Name' class="form-control" name="store_name" id="store_name" type='text'  value="<?php echo set_value('store_name'); ?>">
                                                        <span class="store_name_status"></span>
                                                    </div>
                                                </div>

                                                <div class='form-group website_url'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Website URL<span>*</span></label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Website URL' class="form-control" name="website_url" id="website_url" type='text'  value="<?php echo set_value('website_url'); ?>">
                                                    </div>
                                                </div>
                                                <div class='form-group store_desc'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Store Description</label>
                                                    <div class='col-md-5 controls'>
                                                        <textarea cols="78" rows="5" class="form-control" name="store_description" id="store_description" ><?php echo (isset($_REQUEST['store_description'])) ? $_REQUEST['store_description'] : ''; ?></textarea>                                                        
                                                    </div>
                                                </div>
                                                <div class='form-group'>                        
                                                    <label class='col-md-2 control-label' for='inputText1'>Store Cover Image</label>
                                                    <div class='col-md-5'>
                                                        <div class="cover-size-div">Recommend Size: 1920*440</div>
                                                        <input title='Store Cover Image' name='store_cover_image' type='file' id='store_cover_image' onchange="javascript:loadimage1(this);">                        
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'></label>
                                                    <div class='col-md-9'>
                                                        <img alt="Image" src="" id="blah2">
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Meta Title</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Meta Title' class="form-control" name="meta_title" id="meta_title"  type='text' value="<?php echo (isset($_REQUEST['meta_title'])) ? $_REQUEST['meta_title'] : ''; ?>" >
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Meta Description</label>
                                                    <div class='col-md-5 controls'>
                                                        <textarea cols="78" rows="5" class="form-control" name="meta_description" id="meta_description"><?php echo (isset($_REQUEST['meta_description'])) ? $_REQUEST['meta_description'] : ''; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Active/Hold<span>*</span></label>
                                                    <div class='col-md-3 controls'>
                                                        <select name="store_status" id="store_status" class="form-control" data-rule-required='true'>
                                                            <option value="">Select</option>
                                                            <option value="0" <?php echo (isset($_REQUEST['store_status']) && $_REQUEST['store_status'] == "0") ? 'selected' : ''; ?>>Active</option>
                                                            <option value="3" <?php echo (isset($_REQUEST['store_status']) && $_REQUEST['store_status'] == "3") ? 'selected' : ''; ?>>Hold</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Status<span>*</span></label>
                                                    <div class='col-md-3 controls'>
                                                        <select name="store_is_inappropriate" id="store_is_inappropriate" class="form-control" data-rule-required='true'>
                                                            <option value="">Select</option>
                                                            <option value="NeedReview" <?php echo (isset($_REQUEST['store_is_inappropriate']) && $_REQUEST['store_is_inappropriate'] == "NeedReview") ? 'selected' : ''; ?>>NeedReview</option>
                                                            <option value="Approve" <?php echo (isset($_REQUEST['store_is_inappropriate']) && $_REQUEST['store_is_inappropriate'] == "Approve") ? 'selected' : ''; ?>>Approve</option>
                                                            <option value="Unapprove" <?php echo (isset($_REQUEST['store_is_inappropriate']) && $_REQUEST['store_is_inappropriate'] == "Unapprove") ? 'selected' : ''; ?>>Unapprove</option>
                                                            <option value="Inappropriate" <?php echo (isset($_REQUEST['store_is_inappropriate']) && $_REQUEST['store_is_inappropriate'] == "Inappropriate") ? 'selected' : ''; ?>>Inappropriate</option>
                                                        </select>                
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Store Details Verified</label>
                                                    <div class='col-md-1 controls'>
                                                        <input type="checkbox" name="store_details_verified" id="store_details_verified"  value="1" /> 
                                                    </div>
                                                    <div class='col-md-5 controls' style="color:red;">
                                                        (Note: When you click this it will display in Store Related Pages (Front End). Make sure for Store details before you click to this check box)
                                                    </div>
                                                </div>
                                                <div class='form-group shipping_cost'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Shipping Cost</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Shipping Cost' class="form-control" name="shipping_cost" id="shipping_cost"  type='text' value="<?php echo (isset($_REQUEST['shipping_cost'])) ? $_REQUEST['shipping_cost'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class='form-group shipping_cost'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Commission on purchase</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Commission on purchase' class="form-control" name="commission_on_purchase_from_store" id="commission_on_purchase_from_store"  type='number' value="<?php echo (isset($_REQUEST['commission_on_purchase_from_store'])) ? $_REQUEST['commission_on_purchase_from_store'] : ''; ?>">
                                                        <b>In % (percentage)</b>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Instagram Link</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" class="form-control"  name="instagram_social_link" id="instagram_social_link"  value="<?php echo (isset($_REQUEST['instagram_social_link'])) ? $_REQUEST['instagram_social_link'] : ''; ?>" />
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Facebook Link</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" class="form-control"  name="facebook_social_link" id="facebook_social_link" value="<?php echo (isset($_REQUEST['facebook_social_link'])) ? $_REQUEST['facebook_social_link'] : ''; ?>" />
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Twitter Link</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" class="form-control"  name="twitter_social_link" id="twitter_social_link" value="<?php echo (isset($_REQUEST['twitter_social_link'])) ? $_REQUEST['twitter_social_link'] : ''; ?>" />
                                                    </div>
                                                </div>                                            
                                            </div>

                                            <!-- End Store Part -->
                                            <!-- Start Offer Part -->


                                            <div id="company_details" <?php
                                            if ($this->uri->segment(4) == 'offerUser')
                                                echo '';
                                            else
                                                echo 'style="display:none;"'
                                                ?> >
                                                <hr/>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'></label>
                                                    <div class='col-md-5 controls'>
                                                        <h4><i class="fa fa-home"></i>&nbsp;&nbsp;Offer Details</h4>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Company Name<span>*</span></label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Company Name' class="form-control" name="company_name" id="company_name"  type='text' value="<?php echo (isset($_REQUEST['company_name'])) ? $_REQUEST['company_name'] : ''; ?>" data-rule-required='true'>
                                                        <span class="company_name_status"></span>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Company Description</label>
                                                    <div class='col-md-5 controls'>
                                                        <textarea cols="78" rows="5" class="form-control" name="company_description" id="company_description" ><?php echo (isset($_REQUEST['company_description'])) ? $_REQUEST['company_description'] : ''; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class='form-group'>                        
                                                    <label class='col-md-2 control-label' for='inputText1'>Company Logo</label>
                                                    <div class='col-md-5'>
                                                        <input title='Company Logo' name='company_image' type='file' id='company_image' onchange="javascript:loadimage(this);">
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'></label>
                                                    <div class='col-md-9'>
                                                        <img alt="Image" src="" id="blah1">
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Website URL</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Website URL' class="form-control" name="website_url" id="website_url"  type='text' value="<?php echo (isset($_REQUEST['website_url'])) ? $_REQUEST['website_url'] : ''; ?>" >
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Offer Category</label>
                                                    <div class='col-md-5 controls'>
                                                        <select class="form-control" id="offer_category_id" name="offer_category_id">
                                                            <?php foreach ($category as $cat): ?>
                                                                <option value="<?php echo $cat['category_id']; ?>" <?php if (isset($_REQUEST['offer_category_id']) && $_REQUEST['offer_category_id'] == $cat['category_id']) echo 'selected'; ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>                                                    
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Meta Title</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Meta Title' class="form-control" name="company_meta_title" id="company_meta_title"  type='text' value="<?php echo (isset($_REQUEST['company_meta_title'])) ? $_REQUEST['company_meta_title'] : ''; ?>" >
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Meta Description</label>
                                                    <div class='col-md-5 controls'>
                                                        <textarea cols="78" rows="5" class="form-control" name="company_meta_description" id="company_meta_description"><?php echo (isset($_REQUEST['company_meta_description'])) ? $_REQUEST['company_meta_description'] : ''; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Active/Hold <span>*</span></label>
                                                    <div class='col-md-3 controls'>
                                                        <select name="company_status" id="company_status" class="form-control" data-rule-required='true'>
                                                            <option value="">Select</option>
                                                            <option value="0" <?php echo (isset($_REQUEST['company_status']) && $_REQUEST['company_status'] == "0") ? 'selected' : ''; ?>>Active</option>
                                                            <option value="3" <?php echo (isset($_REQUEST['company_status']) && $_REQUEST['company_status'] == "3") ? 'selected' : ''; ?>>Hold</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Status<span>*</span></label>
                                                    <div class='col-md-3 controls'>
                                                        <select name="company_is_inappropriate" id="company_is_inappropriate" class="form-control" data-rule-required='true'>
                                                            <option value="">Select</option>
                                                            <option value="NeedReview" <?php echo (isset($_REQUEST['company_is_inappropriate']) && $_REQUEST['company_is_inappropriate'] == "NeedReview") ? 'selected' : ''; ?>>NeedReview</option>
                                                            <option value="Approve" <?php echo (isset($_REQUEST['company_is_inappropriate']) && $_REQUEST['company_is_inappropriate'] == "Approve") ? 'selected' : ''; ?>>Approve</option>
                                                            <option value="Unapprove" <?php echo (isset($_REQUEST['company_is_inappropriate']) && $_REQUEST['company_is_inappropriate'] == "Unapprove") ? 'selected' : ''; ?>>Unapprove</option>
                                                            <option value="Inappropriate" <?php echo (isset($_REQUEST['company_is_inappropriate']) && $_REQUEST['company_is_inappropriate'] == "Inappropriate") ? 'selected' : ''; ?>>Inappropriate</option>
                                                        </select>                
                                                    </div>
                                                </div> 
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Instagram Link</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" class="form-control"  name="company_instagram_social_link" id="company_instagram_social_link"  value="<?php echo (isset($_REQUEST['company_instagram_social_link'])) ? $_REQUEST['company_instagram_social_link'] : ''; ?>" />
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Facebook Link</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" class="form-control"  name="company_facebook_social_link" id="company_facebook_social_link" value="<?php echo (isset($_REQUEST['company_facebook_social_link'])) ? $_REQUEST['company_facebook_social_link'] : ''; ?>" />
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Twitter Link</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" class="form-control"  name="company_twitter_social_link" id="company_twitter_social_link" value="<?php echo (isset($_REQUEST['company_twitter_social_link'])) ? $_REQUEST['company_twitter_social_link'] : ''; ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- End Offer Part -->
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="regi_submit" name="regi_submit">
                                                            <i class='icon-save'></i>
                                                            Save
                                                        </button>
                                                        <a href='<?php echo base_url() . 'admin/users/index/generalUser'; ?>' title="Cancel" class="btn">Cancel</a>
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
    </body>
</html>
<script>
    $('#blah1').hide();
    $('#blah2').hide();

    var val = $('#location').val();
    show_emirates(val);

    function show_emirates(val) {

        var url = "<?php echo base_url(); ?>admin/users/show_emirates";
        $.post(url, {value: val}, function (data)
        {
            $("#sub_state_list option").remove();
            $("#sub_state_list").append(data);
        });
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
            return false;
        }
        return true;
    }

    $(document).on("keypress keyup focusin blur cut paste", "#store_domain", function (e) {
        $('#full_domain').html('');
        $('#full_domain').html($('#store_domain').val() + '.doukani.com');
    });

    var val = $('#category_id').val();
    show_sub_cat(val);

    function show_sub_cat1(val) {
        if (val > 0) {
            $('.sub_cat_block').show();
            $('.store_desc').show();
            $('.shipping_cost').show();
            $('.website_url').hide();
            $("input[name='category_id']").val(val);

            var url = "<?php echo base_url(); ?>admin/users/show_sub_cat";
            $.post(url, {value: val, user_role: '<?php echo $this->uri->segment(4); ?>'}, function (data)
            {
                $("#sub_category_id").html(data);
            });
        } else {
            $('.sub_cat_block').hide();
            $('.website_url').show();
            $('.store_desc').hide();
            $('.shipping_cost').hide();
        }
    }

    function show_sub_cat(val) {
        $("input[name='category_id']").val(val);

        var url = "<?php echo base_url(); ?>admin/users/show_sub_cat";
        $.post(url, {value: val, user_role: '<?php echo $this->uri->segment(4); ?>'}, function (data)
        {
            $("#sub_category_id").html(data);
        });
    }

    flag1 = 0;
    flag2 = 0;
    flag3 = 0;
    flag4 = 0;
    flag5 = 0;

    $(document).ready(function () {
<?php if ($seg44 != 'offerUser') { ?>
            $(document).on("change", "#email_id", function (e) {
                var email_id = $(this).val();
                if (email_id) {
                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url() . 'home/check_email_id' ?>',
                        data: {
                            email_id: email_id
                        },
                        success: function (response) {
                            if (response == "OK") {
                                $('#email_status').html('');
                                flag1 = 0;
                                return true;
                            } else {
                                flag1 = 1;
                                $('#email_status').html('<font color="#b94a48">' + response + '</font>');
                                return false;
                            }
                        }
                    });
                } else {
                    $('#email_status').html("");
                    return false;
                }
            });
<?php } ?>
        $(document).on("change", "#username", function (e) {
            var uname = $(this).val();
            if (uname) {
                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url() . 'home/check_username' ?>',
                    data: {
                        username: uname
                    },
                    success: function (response) {
                        if (response == "OK") {
                            $('#username_status').html('');
                            flag2 = 0;
                            return true;
                        } else {
                            flag2 = 1;
                            $('#username_status').html('<font color="#b94a48">' + response + '</font>');
                            return false;
                        }
                    }
                });
            } else {
                $('#username_status').html("");
                return false;
            }
        });

<?php if ($this->uri->segment(4) == 'offerUser') { ?>
            $(document).on("change", "#company_name", function (e) {
                var company_name = $(this).val();
                if (company_name) {
                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url() . 'home/check_company_name' ?>',
                        data: {
                            company_name: company_name
                        },
                        success: function (response) {
                            if (response == "OK") {
                                $('.company_name_status').html('');
                                flag3 = 0;
                                return true;
                            } else {
                                flag3 = 1;
                                $('.company_name_status').html('<font color="#b94a48">' + response + '</font>');
                                return false;
                            }
                        }
                    });
                } else {
                    $('.company_name_status').html("");
                    return false;
                }
            });
    <?php
}
if ($this->uri->segment(4) == 'storeUser') {
    ?>
            $(document).on("change", "#store_name", function (e) {
                var store_name = $(this).val();
                if (store_name) {
                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url() . 'home/check_store_name' ?>',
                        data: {
                            store_name: store_name
                        },
                        success: function (response) {
                            if (response == "OK") {
                                $('.store_name_status').html('');
                                flag4 = 0;
                                return true;
                            } else {
                                flag4 = 1;
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
                            store_domain: store_domain
                        },
                        success: function (response) {
                            if (response == "OK") {
                                $('.store_domain_status').html('');
                                flag5 = 0;
                                return true;
                            } else {
                                flag5 = 1;
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
<?php } ?>
    });
    function submit_call() {

        if (flag1 == 1 || flag2 == 1) {
            return false;
        }

<?php if ($this->uri->segment(4) == 'offerUser') { ?>
            if (flag3 == 1) {
                return false;
            }
    <?php
}
if ($this->uri->segment(4) == 'storeUser') {
    ?>
            if (flag4 == 1 || flag5 == 1) {
                return false;
            }
<?php } ?>

        var curDate = new Date();
        var dob = $("#date_of_birth").val();
        var inputDate = new Date(dob);
        if (dob != '') {
            if (inputDate != 'Invalid Date')
            {
                if (inputDate < curDate)
                {
                    $("#lbl_dbo").hide();
                    return true;
                } else
                {
                    $("#lbl_dbo").show();
                    $("#lbl_dbo").text("Birthdate must be less than today's date");
                    return false;
                }
                return false;
            } else
            {
                $("#lbl_dbo").show();
                $("#lbl_dbo").text("Invalid Date");
                return false;
            }
        }
    }

    $(document).on("keypress", "#shipping_cost", function (e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if ((charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 46)
            return true;
        else
            return false;
    });



    /* $(document).on('click', '#regi_submit', function () {
     
     var user_role = $('#user_role').val();
     console.log("role:::"+user_role);
     if(user_role=='storeUser') {
     console.log('hello');
     //            $("#registration").validate({
     //                rules: {
     //                    category_id: "required",
     //                    store_domain: "required",
     //                    store_name: "required",
     //                    store_status: "required",
     //                    store_is_inappropriate: "required"
     //                },
     //                messages: {
     //                    category_id: "Please enter Category",
     //                    store_domain: "Please enter Store Domain",
     //                    store_name: "Please enter Store name",
     //                    store_status: "Please enter Active/Hold",
     //                    store_is_inappropriate:"Please select Status"
     //                },
     //                submitHandler: function (form) {                    
     //                    form.submit();
     //                }
     //            });
     }
     else if(user_role=='offerUser') {
     console.log('hello');
     $("#registration").validate({
     rules: {
     company_name: "required",
     company_status: "required",
     company_is_inappropriate: "required"
     },
     messages: {
     company_name: "Please enter Company name",
     company_status: "Please enter Active/Hold",                    
     company_is_inappropriate:"Please select Status"
     },
     submitHandler: function (form) {                    
     console.log('hello submit');
     form.submit();
     }
     });
     }        
     });*/


    function loadimage(input) {

        var company_image = $("#company_image").val();
        if (company_image != '') {
            var file_data = $("#company_image").prop("files")[0];
            var type = file_data.type;
            if (file_data) {
                if (type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif") {
                    $('#company_image').val('');
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


    function loadimage1(input) {

        var store_cover_image = $("#store_cover_image").val();
        if (store_cover_image != '') {
            var file_data = $("#store_cover_image").prop("files")[0];
            var type = file_data.type;
            if (file_data) {
                if (type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif") {
                    $('#store_cover_image').val('');
                    $(document).find('.file-input-name').html('');
                    $(".file-input-name").html("");
                    var imgcon = $("#blah2")[0];
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
                $('#blah2').attr('src', e.target.result);
                var imgcon = $("#blah2")[0];
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

    function isNumber1(evt) {
        e = (evt) ? evt : window.event;
        var valid = (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 122) || (e.which == 8);
        if (!valid) {
            e.preventDefault();
        }
    }
</script>