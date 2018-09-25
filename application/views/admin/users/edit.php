<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <link href="<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />        
        <link href='<?php echo base_url(); ?>assets/front/dist/css/Open_Sans.css' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="<?php echo static_image_path; ?>favicon.ico" />             

        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/cropper.min.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/main.css">  

        <script src="<?php echo base_url(); ?>assets/front/dist/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap.min.js"></script>        
        <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap-switch.js"></script>    
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/demo.js" type="text/javascript"></script>

        <style>
            .croppicModalObj {
                margin: 0px auto !important;
            }
            .bdate {
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
                color: #555;
                display: block;
                font-size: 14px;
                height: 34px;
                line-height: 1.42857;
                padding: 6px 12px;
                transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
                width: 100%;
            }       
            .modal-backdrop.fade.in {
            }       
            .modal-dialog.appup {
                width:350px !important;
            }
            .modal-dialog {       
                width: 1000px !important;
            }
            .modal-header{
                background-color:#ed1b33;
                color:white;
            }

            .action
            {
                width: 400px;
                height: 30px;
                margin: 10px 0;
            }
            .cropped>img
            {
                margin-right: 10px;
            }
            .imageBox
            {
                position: relative;
                height: 400px;
                width: 400px;
                border:1px solid #aaa;
                background: #fff;
                overflow: hidden;
                background-repeat: no-repeat;
                cursor:move;
            }

            .imageBox .thumbBox
            {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 200px;
                height: 200px;
                margin-top: -100px;
                margin-left: -100px;
                box-sizing: border-box;
                border: 1px solid rgb(102, 102, 102);
                box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
                background: none repeat scroll 0% 0% transparent;
            }

            .imageBox .spinner
            {
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                text-align: center;
                line-height: 400px;
                background: rgba(0,0,0,0.7);
            }
        </style>
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
                                    $user_type = '';
                                    if ($user[0]->user_role == 'generalUser') {
                                        $user_type = 'Classified User';
                                        echo "<i class='icon-user'></i>";
                                    } elseif ($user[0]->user_role == 'storeUser') {
                                        $user_type = 'Store User';
                                        echo "<i class='icon-building'></i>";
                                    } elseif ($user[0]->user_role == 'offerUser') {
                                        $user_type = 'Offer User';
                                        echo "<i class='icon-tags'></i>";
                                    }
                                    ?>                                    
                                    <span>Users</span>
                                </h1>				
                            </div>
                            <hr class="hr-normal">
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
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Edit User
                                        </div>						
                                    </div>
                                    <br>
                                    <div class='col-sm-3 col-lg-2'>
                                        <div class='box'>
                                            <div class='box-content'>
                                                <label>Profile Picture</label>
                                                <?php
                                                $profile_picture = '';

                                                $profile_picture = $this->dbcommon->load_picture($user[0]->profile_picture, $user[0]->facebook_id, $user[0]->twitter_id, $user[0]->username, $user[0]->google_id, 'original', 'user-profile');
                                                ?>
                                                <div id='preview' style="cursor: pointer; z-index:-100;">
                                                    <img class="img-responsive" alt="<?php echo $user[0]->username; ?>" id="exist" src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"/>
                                                </div>
                                                <form enctype="multipart/form-data" id="imageform" name="imageform">                              
                                                    <label title="Upload image file" for="inputImage" class="btn btn-primary btn-upload"><input type="file" accept="image/*" name="file" id="inputImage" class="sr-only" ><span title="" data-toggle="tooltip" class="docs-tooltip"><span class="fa fa-upload"></span></span>
                                                    </label>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-lg-10 box">
                                        <div class='box-content box-double-padding'>
                                            <?php
                                            $redirect = $_SERVER['QUERY_STRING'];
                                            if (!empty($_SERVER['QUERY_STRING']))
                                                $redirect = '/?' . $redirect;
                                            ?>
                                            <form action='<?php echo base_url() . 'admin/users/edit/' . $user[0]->user_id . $redirect; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" onsubmit="return  submit_call();" id="userForm" name="userForm">

                                                <input class="form-control" name='user_id'type='hidden' value="<?php echo $user[0]->user_id; ?>" >                                                
                                                <div class="form-group">
                                                    <label class='col-md-3 control-label text-left' for='inputText1'>
                                                        <input data-target='#change-password' data-toggle='collapse' id='changepasswordcheck' type='checkbox' name="pwd_flag" value='0'>
                                                        Change password?
                                                    </label>
                                                </div>
                                                <div class='collapse' id='change-password'>
                                                    <div class="form-group">
                                                        <label class='col-md-2 control-label' for='inputText1'>New Password</label>
                                                        <div class='col-md-5 controls'>
                                                            <input type="text" class="pwstrength form-control" placeholder="New Password" name="password" id="password_p" autocomplete="nope"/>
                                                        </div>  
                                                    </div>
                                                    <div class="form-group">
                                                        <label class='col-md-2 control-label' for='inputText1'>Confirm Password</label>
                                                        <div class='col-md-5 controls'>
                                                            <input type="text" class="form-control" placeholder="Confirm Password" name="confirm_password" data-rule-equalto="#password_p" id="confirm_password" />
                                                        </div>  
                                                    </div>
                                                </div>
                                                <?php if ($user[0]->status == 'inactive') { ?>                                                
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Status</label>
                                                        <div class='col-md-5 controls'>
                                                            <select id="status" name="status" class="form-control">
                                                                <option value="inactive">In-active</option>
                                                                <option value="active">Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>User Type</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='USer Type' disabled class="form-control" type='text' value="<?php echo $user_type; ?>" readonly="">
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>E-mail</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='E-mail Address' class="form-control" name="user_email" type='text' value="<?php echo $user[0]->email_id; ?>"  readonly>
                                                    </div>
                                                </div>  
                                                <!--                                                <div class='form-group'>
                                                                                                    <label class='col-md-2 control-label' for='inputText1'>PayPal E-mail</label>
                                                                                                    <div class='col-md-5 controls'>
                                                                                                        <input placeholder="PayPal E-mail" class="form-control" name="paypal_email_id" id="paypal_email_id" type="text" value="<?php echo $user[0]->paypal_email_id; ?>"/>
                                                                                                        <span id="paypal_email_id"></span>
                                                                                                    </div>
                                                                                                </div>-->

                                                <?php
                                                $rule = "data-rule-required='true'";
                                                $span = "<span>*</span>";
                                                if ($user[0]->user_role == 'offerUser') {
                                                    $rule = '';
                                                    $span = '';
                                                }
                                                ?>

                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>First Name<?php echo $span; ?></label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='First Name' class="form-control" name="first_name" type='text' value="<?php echo $user[0]->first_name; ?>" <?php echo $rule; ?>>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Last Name<?php echo $span; ?></label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Last Name' class="form-control" name="last_name" type='text' value="<?php echo $user[0]->last_name; ?>" <?php echo $rule; ?>>
                                                    </div>
                                                </div>                                  
                                                <div class='form-group'>						
                                                    <label class='col-md-2 control-label' for='inputText1'>Username<?php echo $span; ?></label>
                                                    <div class='col-md-5 controls'>
                                                        <input title='Username' class="form-control" name='user_username'type='text' value="<?php echo $user[0]->username; ?>" <?php echo $rule; ?> id="username">                                                                               <span id="username_status"></span>
                                                    </div>
                                                </div>
                                                <div class='form-group'>                        
                                                    <label class='col-md-2 control-label' for='inputText1'>Nickname</label>
                                                    <div class='col-md-5 controls'>
                                                        <input title='Nickname' class="form-control" name='nick_name'type='text' value="<?php echo $user[0]->nick_name; ?>" >
                                                    </div>
                                                </div>                                                     
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Contact Number</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Phone'  class="form-control"  name="user_phone" type='text' value="<?php echo $user[0]->phone; ?>" onkeypress="return isNumber1(event)"/>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'>Nationality</label>
                                                    <div class='col-md-5 controls'>
                                                        <select id="nationality" name="nationality" class="form-control" >
                                                            <option value="">Select Nationality<option>
                                                                <?php foreach ($nationality as $loc) { ?>
                                                                <option <?php if ($user[0]->nationality == $loc['nation_id']) echo 'selected'; ?> value="<?php echo $loc['nation_id']; ?>"><?php echo $loc['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'>Country<span>*</span></label>
                                                    <div class='col-md-5 controls'>
                                                        <select id="location" name="user_country" class="form-control" onchange="show_emirates(this.value);" data-rule-required='true'>
                                                            <?php foreach ($country as $o) { ?>
                                                                <option value="<?php echo $o['country_id']; ?>" <?php echo($o['country_id'] == $user[0]->country) ? 'selected' : ''; ?>><?php echo $o['country_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'>Emirate</label>
                                                    <div class='col-md-5 controls'>
                                                        <select name="user_state" class="form-control" >
                                                            <?php foreach ($state as $o) : ?>
                                                                <option value= "<?php echo $o['state_id']; ?>" <?php if ($o['state_id'] == $user[0]->state) echo 'selected'; ?>><?php echo $o['state_name']; ?> </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Address</label>
                                                    <div class='col-md-5 controls'>
                                                        <textarea class="form-control"  name="user_address" autocomplete="false"><?php echo $user[0]->address; ?> </textarea>
                                                    </div>
                                                </div>
                                                <?php
                                                if (in_array($user[0]->user_role, array('storeUser', 'offerUser'))) {
                                                    if ($user[0]->user_role == 'offerUser') {
                                                        ?>
                                                        <div class='form-group'>
                                                            <label class='col-md-2 control-label' for='inputText1'>Website URL</label>
                                                            <div class='col-md-5 controls'>
                                                                <input placeholder='Website URL' class="form-control" name="website_url" id="website_url"  type='text' value="<?php echo $user[0]->website_url; ?>" >
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Instagram Link</label>
                                                        <div class='col-md-5 controls'>
                                                            <input type="text" class="form-control"  name="instagram_social_link" id="instagram_social_link"  value="<?php echo $user[0]->instagram_social_link; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Facebook Link</label>
                                                        <div class='col-md-5 controls'>
                                                            <input type="text" class="form-control"  name="facebook_social_link" id="facebook_social_link" value="<?php echo $user[0]->facebook_social_link; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Twitter Link</label>
                                                        <div class='col-md-5 controls'>
                                                            <input type="text" class="form-control"  name="twitter_social_link" id="twitter_social_link" value="<?php echo $user[0]->twitter_social_link; ?>" />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'>Gender</label>
                                                    <div class='col-md-5 controls'>
                                                        <select class="form-control" name="gender">
                                                            <option value="1" <?php if ($user[0]->gender == 1) echo 'selected'; ?>>Male</option>
                                                            <option value="0" <?php if ($user[0]->gender == 0) echo 'selected'; ?>>Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'>Birth Date</label>
                                                    <div class='col-md-5 controls'>
                                                        <div class='datetimepicker input-group' id='datepicker'>                    
                                                            <input class='form-control bdate' data-format='yyyy-MM-dd'  name="date_of_birth"  id="date_of_birth" placeholder='Select Birth Date' type='text' value="<?php if (isset($user[0]->date_of_birth) && $user[0]->date_of_birth != '0000-00-00') echo $user[0]->date_of_birth; ?>" id="date_of_birth" onkeypress="return isNumber1(event)"><span class='input-group-addon'><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <font color="#b94a48" style="font-size: 14px; font-weight:lighter !important; "><span id="lbl_dbo"></span></font>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'></label>
                                                    <div class='col-md-5 controls'>
                                                        <label><input name="subscription" type="checkbox" checked />&nbsp;Newsletter Subscription</label>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'></label>
                                                    <div class='col-md-5 controls'>
                                                        <label><input name="notification" type="checkbox" <?php if ($user[0]->chat_notification == 1) echo 'checked'; ?> />&nbsp;Email Chat Notification</label>
                                                    </div>
                                                </div>
                                                <!--<div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Emirate</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Emirate'  class="form-control"  name="user_city" type='text' value="<?php echo $user[0]->city; ?>" />
                                                    </div>
                                                </div> -->
                                                <?php if (isset($user_type) && $user_type != 'offerUser') { ?>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Left Ads for Current Month</label>
                                                        <div class='col-md-5 controls'>
                                                            <input placeholder='No. of Total Ads'  class="form-control"  name="left_ads"  type='text' value="<?php echo $user[0]->userAdsLeft; ?>" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Alloted Ads for Current Month</label>
                                                        <div class='col-md-5 controls'>
                                                            <input placeholder='No. of Total Ads'  class="form-control"  name="tot_ad"  type='text' value="<?php echo $user[0]->userTotalAds; ?>" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>+ Add Ads for Current Month</label>
                                                        <div class='col-md-5 controls'>
                                                            <input placeholder='No. of Total Ads'  class="form-control"  name="add_ad" type='text' onkeypress="return isNumber1(event)"/>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-actions form-actions-padding-sm">
                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-2">
                                                            <button class='btn btn-primary' type='submit'>
                                                                <i class='icon-save'></i>
                                                                Save
                                                            </button>
                                                            <a href='<?php echo base_url(); ?>admin/users/index/<?php echo $user[0]->user_role . $redirect; ?>' title="Cancel" class="btn">Cancel</a>
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
                </div>
            </section>
        </div>
        <div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <form id="img_upload" name="img_upload" method="post"> 
                <div id="loading" style="text-align:center">
                    <img id="loading-image" src="<?php echo static_image_path; ?>ajax-loader.gif" alt="Loading..." />
                </div>
                <div class="modal-dialog modal-md">
                    <div class="modal-content rounded">                     
                        <div class="modal-header text-center orange-background">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button" id="close_popup">
                                <i class="fa fa-close"></i>
                            </button>
                            <h4 id="myLargeModalLabel" class="modal-title">Crop Your Image</h4>
                            <input type="hidden" name="img_name" id="img_name" >
                            <input type="hidden" value="<?php echo $user[0]->user_id; ?>" name="req_user_id" id="req_user_id">
                            <input type="hidden" id="crop_img_type">
                        </div>                        
                        <img id="image" name="image" src="" width="50%" height="50%" />
                        <div id='preview' align="center">

                        </div>                                                      
                        <input type="submit" id="upload_img" name="upload_img" value="Crop & Save" class="btn btn-primary">
                        <div class="docs-data" style="display:none;">
                            <input type="hidden" id="target_dir" name="target_dir" value="<?php echo document_root . profile; ?>"><br>
                            <input type="hidden" id="user_page" name="user_page" value="user_page"><br>
                            X=<input type="text" id="dataX"  name="dataX" placeholder="x">px<br>
                            Y=<input type="text" id="dataY" name="dataY" placeholder="y">px<br>
                            Width=<input type="text" id="dataWidth" name="dataWidth" placeholder="width">px            
                            Height=<input type="text" id="dataHeight" name="dataHeight" placeholder="height"> px
                            Rotate=<input type="text" id="dataRotate" name="dataRotate" placeholder="rotate">
                            ScaleX=<input type="text" id="dataScaleX" name="dataScaleX" placeholder="scaleX">
                            ScaleY=<input type="text" id="dataScaleY" name="dataScaleY" placeholder="scaleY">                       
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade sure" id="search_alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">  
                        <h4 class="modal-title">Alert
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </h4>                   
                    </div>
                    <div class="modal-body">
                        <p class="response_message"></p>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/javascripts/crop/jquery.form.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/crop/cropper.min.js"></script>   
        <script src="<?php echo site_url(); ?>assets/front/javascripts/crop/main.js"></script>
        <script>
                                                            var flag2 = 0;
                                                            $(document).ready(function () {
                                                                $(document).on("change", "#username", function (e) {
                                                                    var uname = $(this).val();
                                                                    if (uname) {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: '<?php echo site_url() . 'home/check_username' ?>',
                                                                            data: {
                                                                                username: uname, user_id: '<?php echo $user[0]->user_id; ?>'
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
                                                            });

                                                            $(document).on("click", "#close_popup", function (e) {
                                                                $('#img_name').val('');
                                                                $('#inputImage').val('');
                                                            });

                                                            function clean() {
                                                                $('#inputImage').val('');
                                                                $('#img_name').val('');
                                                                $('#image').attr("src", "");
                                                            }
                                                            URL = window.URL || window.webkitURL;
                                                            var blobURL = '';
                                                            $('#inputImage').on('change', function ()
                                                            {
                                                                var file = $('#inputImage')[0].files[0];
                                                                blobURL = URL.createObjectURL(file);
                                                                $('#crop_img_type').val(file.type);
                                                                $('#loading').show();

                                                                var ext = file.name.split('.').pop().toLowerCase();
                                                                console.log(ext);

                                                                if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                                                                    $('#inputImage').val('');
                                                                    $(document).find('.response_message').html('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                                                                    $(document).find("#search_alert").modal('show');
                                                                } else {
                                                                    $("#send-message-popup").modal('show');
                                                                    $('#send-message-popup').on('shown.bs.modal', function () {
                                                                        var image = $(document).find('#send-message-popup #img_upload #image');
                                                                        image.cropper({
                                                                            viewMode: 1,
                                                                            dragMode: 'move',
                                                                            aspectRatio: 1 / 1,
                                                                            cropBoxMovable: false,
                                                                            cropBoxResizable: false,
                                                                            movable: true,
                                                                            toggleDragModeOnDblclick: false
                                                                        });

                                                                        image.on('built.cropper', function () {
                                                                            $('#loading').hide();
                                                                            URL.revokeObjectURL(blobURL);
                                                                        }).cropper('reset').cropper('replace', blobURL);
                                                                    });
                                                                }
                                                            });

                                                            function dataURItoBlob(dataURI) {
                                                                // convert base64 to raw binary data held in a string
                                                                // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
                                                                var byteString = atob(dataURI.split(',')[1]);

                                                                // separate out the mime component
                                                                var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
                                                                console.log()
                                                                // write the bytes of the string to an ArrayBuffer
                                                                var ab = new ArrayBuffer(byteString.length);
                                                                var ia = new Uint8Array(ab);
                                                                for (var i = 0; i < byteString.length; i++) {
                                                                    ia[i] = byteString.charCodeAt(i);
                                                                }

                                                                // write the ArrayBuffer to a blob, and you're done
                                                                var bb = new Blob([ab], {type: mimeString});
                                                                return bb;
                                                            }


                                                            $('#img_upload').on('hidden.bs.modal', manage_crop_image);
                                                            $("#upload_img").click(manage_crop_image);

                                                            function manage_crop_image(e) {

                                                                e.preventDefault();
                                                                var form_data = new FormData($("#img_upload")[0]);

                                                                var croppedCanvas = $('#img_upload #image').cropper('getCroppedCanvas', {height: 300, width: 300});
                                                                var im_url = croppedCanvas.toDataURL();
                                                                var image_binary = im_url;
                                                                var binToblob = dataURItoBlob(image_binary);
                                                                var content_type = binToblob.type;
                                                                var image_type = content_type.split('/');
                                                                form_data.append("cropped_image", binToblob, 'crop_image.' + image_type[1]);

                                                                croppedCanvas = $('#img_upload #image').cropper('getCroppedCanvas', {height: 100, width: 100});
                                                                im_url = croppedCanvas.toDataURL();
                                                                image_binary = im_url;
                                                                binToblob = dataURItoBlob(image_binary);
                                                                content_type = binToblob.type;
                                                                image_type = content_type.split('/');
                                                                form_data.append("cropped_image_100", binToblob, 'crop_image.' + image_type[1]);

                                                                croppedCanvas = $('#img_upload #image').cropper('getCroppedCanvas', {height: 50, width: 50});
                                                                im_url = croppedCanvas.toDataURL();
                                                                image_binary = im_url;
                                                                binToblob = dataURItoBlob(image_binary);
                                                                content_type = binToblob.type;
                                                                image_type = content_type.split('/');
                                                                form_data.append("cropped_image_50", binToblob, 'crop_image.' + image_type[1]);

                                                                $.ajax({
                                                                    type: 'POST',
                                                                    dataType: 'JSON',
                                                                    url: "<?php echo base_url(); ?>admin/users/crop_image_upload",
                                                                    data: form_data,
                                                                    async: false,
                                                                    contentType: false,
                                                                    processData: false,
                                                                    success: function (data) {
                                                                        window.location.href = "<?php echo base_url() . 'admin/users/edit/' . $user[0]->user_id . $redirect; ?>";
                                                                    }
                                                                });
                                                            }


                                                            var val = $("#location").val();
                                                            show_emirates(val);

                                                            function show_emirates(val) {
                                                                var val = $("#location").val();
                                                                var sel_city = $("#sub_state_list").val();
                                                                var url = "<?php echo base_url(); ?>home/show_emirates1";
                                                                $.post(url, {value: val, sel_city: sel_city}, function (data)
                                                                {
                                                                    $("#sub_state_list").html(data);
                                                                    $("#sub_state_list option").remove();
                                                                    $("#sub_state_list").append(data);
                                                                });
                                                            }

                                                            function isNumber1(evt) {
                                                                evt = (evt) ? evt : window.event;
                                                                var charCode = (evt.which) ? evt.which : evt.keyCode;
                                                                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
                                                                    return false;
                                                                }
                                                                return true;
                                                            }

                                                            function submit_call() {

                                                                if (flag2 == 1) {
                                                                    return false;
                                                                }

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
                                                                        $("#lbl_dbo").text("Invalid Date.");
                                                                        return false;
                                                                    }
                                                                }
                                                            }
        </script>
    </body>
</html>