<html>
    <head>
        <link href="<?php echo base_url(); ?>assets/front/stylesheets/bootstrap-tour/bootstrap-tour.css" rel="stylesheet">    
        <link href="<?php echo base_url(); ?>assets/front/stylesheets/bootstrap-tour/bootstrap-tour-standalone.css" rel="stylesheet">
        <?php $this->load->view('include/head'); ?>        
        <link href='<?php echo base_url(); ?>assets/front/dist/css/bootstrap-switch.css' rel='stylesheet' type='text/css' />
        <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap-switch.js"></script>    
        <link href="<?php echo base_url(); ?>assets/front/dist/css/bootstrap.css" rel="stylesheet">    
        <link href="<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />        
        <link href='<?php echo base_url(); ?>assets/front/dist/css/Open_Sans.css' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/front/images/favicon.ico" />             

        <link href="<?php echo base_url(); ?>assets/front/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/responsive.css" rel="stylesheet">

        <link href='https://fonts.googleapis.com/css?family=Mrs+Sheppards&subset=latin,latin-ext' rel='stylesheet' type='text/css'>  
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/cropper.min.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/main.css">  

        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/demo.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-tour/bootstrap-tour.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-tour/bootstrap-tour-standalone.min.js" type="text/javascript"></script>
        <style>
            #send-message-popup{z-index: 111111;}
            .tour-backdrop {background-color: #000 !important;}
            .croppicModalObj {margin: 0px auto !important;}
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
            .modal-backdrop.fade.in {/*display:none;*/}
            .modal-header {background-color:#ed1b33;color:white;}
            .action {
                width: 400px;
                height: 30px;
                margin: 10px 0;
            }
            .cropped>img {margin-right: 10px;}
            .imageBox {
                position: relative;
                height: 400px;
                width: 400px;
                border:1px solid #aaa;
                background: #fff;
                overflow: hidden;
                background-repeat: no-repeat;
                cursor:move;
            }
            .imageBox .thumbBox {
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
            .imageBox .spinner {
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
    <body>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>        
            <?php $this->load->view('include/menu'); ?>       
            <div class="page">     
                <div class="container">
                    <div class="row">
                        <?php $this->load->view('include/sub-header'); ?>          
                        <div class="col-sm-12 main dashboard">              
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>                     
                            <div class="col-sm-9 ContentRight">
                                <?php if (validation_errors() != false) { ?>
                                    <div class='alert alert-info text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo validation_errors(); ?>
                                    </div>
                                <?php } ?>
                                <?php if (isset($msg) && !empty($msg)): ?>
                                    <div class='alert <?php echo $msg_class; ?> text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $msg; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('flash_message') != ''): ?>
                                    <div class='alert alert-info text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $this->session->flashdata('flash_message'); ?>
                                    </div>
                                <?php endif; ?>

                                <!--breadcrumb-->
                                <?php $this->load->view('user/user_menu'); ?>
                                <!--//row-->
                                <div class="row profile">  
                                    <?php
                                    $profile_picture = '';
                                    $profile_picture = $this->dbcommon->load_picture($current_user->profile_picture, $current_user->facebook_id, $current_user->twitter_id, $current_user->username, $current_user->google_id, 'original', 'user-profile');
                                    ?>
                                    <div class="col-lg-3 col-md-3 col-sm-12 text-center">   
                                        <form enctype="multipart/form-data" id="imageform" name="imageform">                              
                                            <label title="Upload image file" for="inputImage" class="btn btn-primary btn-upload"><input type="file" accept="image/*" name="file" id="inputImage" class="sr-only" ><span title="" data-toggle="tooltip" class="docs-tooltip"><span class="fa fa-upload"></span></span>
                                            </label>
                                        </form>
                                        <div class="mt " title="Upload Image">                                   
                                            <div id="cropContainerModal" class="">
                                                <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle tour-step-backdrop" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" id="upload_image" alt="Profile Image" />   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 tour-step-backdrop" id="profile_section">                               
                                        <form name="profile_form" id="profile_form" method="post" class="form form-horizontal validate-form " enctype="multipart/form-data"  action="<?php echo base_url(); ?>user/index" onsubmit="return  submit_call();">
                                            <div class="userupdateform">
                                                <div class="col-sm-6">
                                                    <h3 class="user_index_name"><?php
                                                        if ($current_user->nick_name != ''): echo $current_user->nick_name;
                                                        else: echo $current_user->username;
                                                        endif;
                                                        ?></h3>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <a href="<?php echo site_url() . 'user/followers'; ?>">
                                                        <p class="followers"><?php echo $total_followers; ?> Followers</p>
                                                    </a>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>User Name <span style="color:red;">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="username"  id="username" class="form-control" value="<?php echo $current_user->username; ?>" data-rule-required='true' />
                                                            <span id="username_status"></span>
                                                        </div>

                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Nick Name</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" placeholder="Nick Name" name="nick_name" id="nick_name"  value="<?php echo $current_user->nick_name; ?>"/>
                                                        </div>  
                                                    </div>

                                                    <div class="form-group row">
                                                        <label>
                                                            &nbsp; &nbsp;<input data-target='#change-password' data-toggle='collapse' id='changepasswordcheck' type='checkbox' name="pwd_flag" value='0'>
                                                            Change password?
                                                        </label>
                                                    </div>
                                                    <div class='collapse' id='change-password'>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4">
                                                                <label>New Password</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="password" class="pwstrength form-control" placeholder="New Password" name="password" id="password_p"  />
                                                            </div>  
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-sm-4">
                                                                <label>Confirm Password</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" data-rule-equalto="#password_p" id="confirm_password"  />
                                                            </div>  
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Address</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <?php
                                                            $address = '';
                                                            if ($current_user->address != '')
                                                                $address .= $current_user->address;
                                                            ?>
                                                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Nationality<span style="color:red;">*</span></label>
                                                        </div>                                              
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="nationality" id="nationality" data-rule-required='true' >
                                                                <option value="">Select Nationality</option>
                                                                <?php foreach ($nationality as $loc) { ?>
                                                                    <option <?php if ($current_user->nationality == $loc['nation_id']) echo 'selected'; ?> value="<?php echo $loc['nation_id']; ?>"><?php echo $loc['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>                                                
                                                    </div>                                                    
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Email</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="email" name="email" readonly="readonly" class="form-control" value="<?php echo $current_user->email_id; ?>" data-rule-required='true' />
                                                        </div>                                                
                                                    </div>                                                    
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Gender</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="gender">
                                                                <option value="1" <?php if ($current_user->gender == 1) echo 'selected'; ?>>Male</option>
                                                                <option value="0" <?php if ($current_user->gender == 0) echo 'selected'; ?>>Female</option>
                                                            </select>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Birth Date<span style="color:red;">*</span></label>
                                                        </div>  
                                                        <div class="col-sm-8">                                                    
                                                            <div class='datetimepicker input-group' id='datepicker'>                    
                                                                <input class='form-control bdate' data-format='yyyy-MM-dd'  name="date_of_birth"  id="date_of_birth" placeholder='Select Birth Date' type='text' value="<?php if (isset($current_user->date_of_birth)) echo $current_user->date_of_birth; ?>" id="date_of_birth" ><span class='input-group-addon'><i class="fa fa-calendar"></i></span>         
                                                            </div>
                                                            <font color="#b94a48"><label id="lbl_dbo"></label></font>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Country<span style="color:red;">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="location" id="location" onchange="javascript:show_emirates1(this);" data-rule-required='true' >
                                                                <option value="">Select Country</option>
                                                                <?php foreach ($location as $loc) { ?>
                                                                    <option <?php if ($current_user->country == $loc['country_id']) echo 'selected'; ?> value="<?php echo $loc['country_id']; ?>"><?php echo $loc['country_name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4"><?php //print_r($current_user);                                                                       ?>
                                                            <label>Emirate <span style="color:red;">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="city" id="sub_state_list" data-rule-required='true'>    
                                                                <option value="">Select Emirate</option>
                                                                <?php foreach ($cities as $city) { ?>
                                                                    <option <?php if ($current_user->state == $city['state_id']) echo 'selected'; ?> value="<?php echo $city['state_id']; ?>"><?php echo $city['state_name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4" style="padding-right: 0;">
                                                            <label>Contact Number <span style="color:red;">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $current_user->phone; ?>" data-rule-required='true' />
                                                        </div>                                                
                                                    </div>
                                                    <?php if ($current_user->user_role == 'storeUser') { ?>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4" style="padding-right: 0;">
                                                                <label>Instagram Link</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="text" name="instagram_social_link"  class="form-control" value="<?php echo $current_user->instagram_social_link; ?>" />
                                                            </div>                                                
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4" style="padding-right: 0;">
                                                                <label>Facebook Link</label>
                                                            </div>                                                        
                                                            <div class="col-sm-12">                                   
                                                                <input type="text" name="facebook_social_link"  class="form-control" value="<?php echo $current_user->facebook_social_link; ?>" />
                                                            </div>                                               
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4" style="padding-right: 0;">
                                                                <label>Twitter Link</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="text" name="twitter_social_link"  class="form-control" value="<?php echo $current_user->twitter_social_link; ?>" />
                                                            </div>                                                
                                                        </div>

                                                    <?php } ?>
                                                    <?php //if($sub_set==0):  ?>
                                                    <div class="form-group row">                                                        
                                                        <div class="col-sm-12">
                                                            <label><input name="subscription" type="checkbox" <?php if ($sub_set == 0) echo 'checked'; ?> />Newsletter Subscription</label>
                                                        </div>
                                                    </div>
                                                    <?php //endif;  ?>
                                                    <?php //if($chat==0):  ?>
                                                    <div class="form-group row">                                                        
                                                        <div class="col-sm-12">                                                  
                                                            <label><input name="notification" type="checkbox" value=1  <?php if ($current_user->chat_notification == 1) echo 'checked'; ?> />Email Chat Notification</label>
                                                        </div>
                                                    </div>
                                                    <?php //endif;  ?>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <button name="submit" class="btn btn-blue red-btn" >Update</button>
                                                            <a type="submit" name="delete" id="delete" class="btn btn-blue btn-del black-btn" >Delete Account</a>
                                                            <!-- <a class="delete-account" href="#">Delete My Account</a> -->
                                                        </div>  
                                                    </div>
                                                </div>                                
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <?php
                                        $logged_user_details = $this->session->userdata('gen_user');
                                        if (isset($is_able_request_for_store) && $is_able_request_for_store == 0 && $logged_user_details['user_role'] == 'generalUser') {
                                            ?>
                                            <div class="panel panel-default make_store_user_div">
                                                <div class="panel-heading btn btn-blue btn-block blue-btn">Create Store with Us</div>
                                                <div class="panel-body">                                                        
                                                    <?php
                                                    echo '<div class="text_display">Contact us to sell your products on our Website.</div>';
                                                    ?>                                                        
                                                    <a class="btn btn-block mybtn send_create_store_request" href="javascript:void();">Click me !!!</a>                                                    
                                                </div>                                                    
                                            </div>
                                            <?php
                                        }

                                        if (isset($e_wallet_amount) && $e_wallet_amount > 0) {
//                                        pr($logged_user_details->last_login_as);
                                            if (isset($logged_user_details) && isset($logged_user_details['last_login_as']) && $logged_user_details['last_login_as'] == 'storeUser') {
                                                ?>
                                                <div class="panel panel-default e_wallet_div">
                                                    <div class="panel-heading btn btn-blue btn-block blue-btn">W-wallet</div>
                                                    <div class="panel-body">                                                        
                                                        <?php
                                                        echo '<div class="amount_display">AED ' . number_format($e_wallet_amount, 2) . '</div>';
                                                        ?>
                                                        <a class="btn btn-block mybtn" href="<?php echo base_url() . 'user/send_payment_request'; ?>">Send Payment Request</a>                                                    
                                                    </div>                                                    
                                                </div>                                                                                        
                                                <?php
                                            }
                                        }
                                        ?>
                                        <div class="form-group">                                    
                                            <a href="<?php echo site_url() . 'privacy'; ?>" class="btn btn-blue btn-block blue-btn">Privacy </a>
                                        </div>
                                        <div class="ads-left text-center">
                                            <img src="<?php echo base_url(); ?>assets/front/images/ads_left.png" alt="Image">
                                            <h3><span><?php echo $current_user->userAdsLeft; ?></span> Ads Left</h3>
                                        </div>
                                        <div class="form-group">                                    
                                            <a href="javascript:void(0);" id="buy_ads" class="btn btn-block mybtn">Buy Ads </a>
                                        </div>                              
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--//content-->
                    </div>  

                </div>

                <?php $this->load->view('include/footer'); ?>        
            </div>
            <div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog"  aria-hidden="true">
                <form id="img_upload" name="img_upload" method="post"> 
                    <div id="loading" style="text-align:center">
                        <img id="loading-image" src="<?php echo base_url(); ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
                    </div>
                    <div class="modal-dialog modal-md">
                        <div class="modal-content rounded">                     
                            <div class="modal-header text-center orange-background">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button" id="close_popup">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 id="myLargeModalLabel" class="modal-title">Crop Your Image</h4>
                                <input type="hidden" name="img_name" id="img_name" >
                            </div>
                            <!-- <img id="image" src="<?php //echo site_url();                                                                        ?>assets/upload/profile/thumb/1455007355.jpeg" />  -->
                            <img id="image" name="image" src="" width="50%" height="50%" />
                            <div id='preview' align="center">

                            </div>                                                      
                            <input type="submit" id="upload_img" name="upload_img" value="Crop & Save" class="btn btn-blue btn-block blue-btn">

                            <div class="docs-data" style="display:none;">
                                <input type="hidden" id="target_dir" name="target_dir" value="<?php echo document_root . profile; ?>"><br>
                                <input type="hidden" id="user_page" name="user_page" value="user_page"><br>
                                X=<input type="text" id="dataX"  name="dataX" placeholder="x">px<br>
                                Y=<input type="text" id="dataY" name="dataY" placeholder="y">px<br>
                                Width=<input type="text" id="dataWidth" name="dataWidth" placeholder="width">px            
                                Height=<input type="text" id="dataHeight" name="dataHeight" placeholder="height"> px
                                Rotate=<input type="text" id="dataRotate" name="dataRotate" placeholder="rotate">
                                ScaleX=<input type="text" id="dataScaleX" name="dataScaleX" placeholder="scaleX">
                                ScaleY:<input type="text" id="dataScaleY" name="dataScaleY" placeholder="scaleY">                       
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal fade center" id="replyModal" tabindex="-1" role="dialog"  aria-hidden="true">                <form id="img_upload" name="img_upload" action="" method="post">            
                    <div class="modal-dialog appup modal-md">
                        <div class="modal-content rounded">                     
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-info-circle"></i>Information
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </h4>                   
                            </div>
                            <div class="modal-body text-center">                    
                                <a href="<?php echo doukani_app; ?>" name="app_url" id="app_url" target="_blank">
                                    <img src="<?php echo site_url() . 'assets/front/images/iphone_icon.png'; ?>" alt="Iphone Image">
                                </a>
                                <h4>Download our app to purchase more ads.</h4>                 
                            </div>  
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal fade sure" id="boostConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">  
                            <h4 class="modal-title"><i class="fa fa-shopping-cart"></i>Buy Ads
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </h4>                   
                        </div>
                        <div class="modal-body">
                            <!--<h4 class="modal-title">Doukani</h4>-->
                            <p>Are you sure want to Buy Ads?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default yes_i_want" value="yes">Yes, I want</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade boost" id="boostModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <div class="icn"><img src="<?php echo site_url() . 'assets/front/images/ads_left.png'; ?>" alt="" /></div>
                            <h4 class="left-ad"><?php echo $current_user->userAdsLeft; ?> Ads Left</h4>
                            <a class="boost-btn" id="buy_more_ads" ><span class="ic"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span><span>Buy More Ads</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade boost1" id="purchase_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm modal-purchase" role="document" >            
                    <div class="modal-content">              
                        <div class="modal-body"> 
                            <!--              <div id="loading11" style="text-align:center;display:none;">
                                            <img id="loading-image" src="<?php echo base_url(); ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
                                            </div>  -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <!--<button type="button" class="back"><i class="fa fa-caret-left"></i></button>-->              
                            <div class="icn"><i class="fa fa-shopping-cart"></i></div>
                            <h4 class="boost-title">Buy More Ads</h4>
                            <p class="boost-text">These ads you can buy them if you used your free ads for the current month </p>
                            <div class="ad-list">
                                <table class="table table-striped">
                                    <?php if (isset($buy_ad_price) && sizeof($buy_ad_price) > 0) { ?>
                                        <tbody>
                                            <?php foreach ($buy_ad_price as $price) { ?>
                                                <tr>
                                                    <td><h3 class="hour"><?php echo $price['ads']; ?> <span>Ads</span></h3></td>
                                                    <td><div class="purchase_price">AED <span><?php echo $price['amount']; ?></span><br /><a href="javascript:void(0);" class="pur-btn purchase_ad_" id="<?php echo $price['ads']; ?>">Purchase</a></div></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">  
                            <h4 class="modal-title"><i class="fa fa-check-square-o"></i>Confirmation
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </h4>                   
                        </div>
                        <div class="modal-body">                  
                            <p>Are you sure you want to delete this account?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('user/send_store_details'); ?>
            <div id="loading1" style="text-align:center" class="loader_display">
                <img id="loading-image" src="<?php echo base_url(); ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
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

                                                                $(document).on('click', '.send_create_store_request', function () {
                                                                    $(document).find('#view_model').modal();
                                                                });

                                                                var flag2 = 0;
                                                                $(document).ready(function () {

                                                                    $(document).find('#loading1').hide();
                                                                    show_sub_cat($('#category_id').val());

                                                                    $(document).on("change", "#username", function (e) {
                                                                        var uname = $(document).find('#username').val();
                                                                        if (uname) {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: '<?php echo site_url() . 'home/check_username' ?>',
                                                                                data: {
                                                                                    username: uname, user_id: '<?php echo $current_user->user_id; ?>'
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

                                                                    var tour = new Tour({
                                                                        name: "tour",
                                                                        container: "body",
                                                                        keyboard: true,
                                                                        backdrop: false,
                                                                        basePath: "",
                                                                        onShow: function (key, value) {

                                                                            if (value == "0") {
                                                                                $('#profile_section').addClass('profile_update_form_index');
                                                                            }
                                                                            if (value == "1") {
                                                                                $('#profile_section').removeClass('profile_update_form_index');
                                                                            }
                                                                        }
                                                                    });

                                                                    tour.addSteps([
                                                                        {
                                                                            element: "#upload_image",
                                                                            title: "Upload Image",
                                                                            content: "Set Your Profile Image",
                                                                            placement: 'top',
                                                                            backdrop: true,
                                                                        },
                                                                        {
                                                                            element: "#profile_section",
                                                                            title: "User Profile",
                                                                            content: "Update Your Profile Details",
                                                                            placement: 'top',
                                                                            backdrop: true,
                                                                        }
                                                                    ]);

                                                                    tour.init();
                                                                    tour.start();
                                                                });

                                                                $(document).on("click", "#delete", function (e) {
                                                                    $("#deleteConfirm").modal('show');
                                                                    $(document).on("click", ".yes_i_want_delete", function (e) {
                                                                        var val = $(this).val();
                                                                        if (val == 'yes') {
                                                                            var url = "<?php echo base_url(); ?>user/delete_account";
                                                                            $.post(url, {delete: 'yes'}, function (data) {
                                                                                window.location = "<?php echo base_url(); ?>login";
                                                                            });
                                                                        }
                                                                    });
                                                                });

                                                                $(document).on("click", "#buy_ads", function (e) {
                                                                    $('#profile_section').addClass('profile_update_form_index');
                                                                    $(document).find("#boostConfirm").modal('show');
                                                                    $(document).on("click", ".yes_i_want", function (e) {

                                                                        $(document).find('#boostConfirm').modal('hide');
                                                                        var val = $(this).val();
                                                                        if (val == 'yes') {
                                                                            $(document).find("#boostModel").modal('show');
                                                                            $(document).on("click", "#buy_more_ads", function (e) {
                                                                                $(document).find('#boostModel').modal('hide');
                                                                                $(document).find("#purchase_popup").modal('show');

                                                                                $(document).on("click", ".purchase_ad_", function (e) {

                                                                                    $(document).find(".ad-list").html('<div style="text-align:center;"><img id="loading-image" src="<?php echo base_url(); ?>assets/front/images/ajax-loader.gif" alt="Loading..." /></div>');
                                                                                    var buy_ads = $(this).attr('id');
                                                                                    var url = "<?php echo base_url(); ?>payment/buy_ad_payment_request/";

                                                                                    $.post(url, {success: "success", buy_ads: buy_ads}, function (response) {
                                                                                        window.location = response;
                                                                                    });
                                                                                });
                                                                            });
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
                                                                    $('#profile_section').addClass('profile_update_form_index');
                                                                    var file = $('#inputImage')[0].files[0];
                                                                    blobURL = URL.createObjectURL(file);
                                                                    $('#crop_img_type').val(file.type);
                                                                    $('#loading').show();

                                                                    var ext = file.name.split('.').pop().toLowerCase();
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
//    $("#upload_img").click(manage_crop_image);

                                                                $(document).on("click", "#upload_img", function (e) {
                                                                    $body = $("body");
                                                                    $body.addClass("loading");
                                                                    $(document).find('#loading').show();
                                                                    manage_crop_image(e);
                                                                });

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
                                                                        url: "<?php echo base_url(); ?>user/crop_image_upload",
                                                                        data: form_data,
                                                                        async: false,
                                                                        contentType: false,
                                                                        processData: false,
                                                                        success: function (data) {
                                                                            window.location.href = "<?php echo base_url() . 'user/index/'; ?>";
                                                                        }
                                                                    });
                                                                }
                                                                var val = $("#location").val();
                                                                //show_emirates1(<?php //echo $current_user->county;                                                                       ?>);
                                                                function show_emirates1(val) {
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

                                                                $(document).on("keypress", "#phone", function (e) {
                                                                    var charCode = (e.which) ? e.which : e.keyCode;
                                                                    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
                                                                        return false;
                                                                    }
                                                                    return true;
                                                                });

                                                                function submit_call() {

                                                                    if (flag2 == 1) {
                                                                        return false;
                                                                    }

                                                                    var curDate = new Date();
                                                                    var dob = $("#date_of_birth").val();
                                                                    var inputDate = new Date(dob);
                                                                    if (inputDate != 'Invalid Date')
                                                                    {
                                                                        if (inputDate < curDate)
                                                                        {
                                                                            $("#lbl_dbo").hide();
                                                                            jQuery('#userForm').attr('action', "<?php echo base_url(); ?>user/index").submit();
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
                                                                        $("#lbl_dbo").text("This field is required.");
                                                                        return false;
                                                                    }
                                                                }

                                                                var flag1 = 0;
                                                                $(document).on("change", "#store_name", function (e) {
                                                                    var store_name = $(this).val();
                                                                    if (store_name) {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: '<?php echo site_url() . 'home/check_store_name' ?>',
                                                                            data: {
                                                                                store_name: store_name, user_id: '<?php echo $logged_user_details['user_id']; ?>'
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

                                                                function ValidURL(str) {
                                                                    var regexp = /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
                                                                    if (regexp.test(str)) {
                                                                        return 1;
                                                                    } else {
                                                                        return 0;
                                                                    }
                                                                }

                                                                $(document).on("keypress keyup focusin blur cut paste", "#store_domain", function (e) {
                                                                    //$("#store_domain").keypress(function() {            
                                                                    $('#full_domain').html('');
                                                                    $('#full_domain').html($('#store_domain').val() + '.doukani.com');
                                                                });
                                                                $(document).on("keypress", "#store_domain", function (e) {
                                                                    var valid = (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 122) || (e.which == 8);
                                                                    if (!valid) {
                                                                        e.preventDefault();
                                                                    }
                                                                });

                                                                function show_sub_cat(val) {
                                                                    $('.domain').show();
                                                                    if (val > 0) {
                                                                        $('.new_webiste').hide();
                                                                        $('.sub_cat_block').show();
                                                                        $('.new_store_det').show();
                                                                        $('.store_desc_grp').show();
                                                                        $("input[name='category_id']").val(val);
                                                                        var url = "<?php echo base_url(); ?>login/show_sub_cat";
                                                                        $.post(url, {value: val}, function (data)
                                                                        {
                                                                            $("#sub_category_id").html(data);
                                                                        });
                                                                    } else {
                                                                        $('.new_webiste').show();
                                                                        $('.store_desc_grp').hide();
                                                                        $('.sub_cat_block').hide();
                                                                        $('.new_store_det').hide();
                                                                    }
                                                                }

                                                                $("#request_from").validate({
                                                                    rules:
                                                                            {
                                                                                webiste_link: {
                                                                                    required: true,
                                                                                    url: true
                                                                                },
                                                                            },
                                                                    messages:
                                                                            {
                                                                                webiste_link: {
                                                                                    required: "Website URL is required.",
                                                                                    url: 'Please enter a valid URL.'
                                                                                },
                                                                            }
                                                                });

//                                                                $("#request_from").submit(function (event) {
//                                                                    if (flag1 == 1)
//                                                                        return false;
//                                                                    var form = $("#request_from");
//                                                                    if (form.valid() == true) {
//                                                                        $(document).find('#loading1').show();
//                                                                        $(document).find('#loading1').css('z-index', '11111111');
//                                                                    }
//                                                                    if ($('#category_id').val() == 0) {
//                                                                        if (ValidURL($('#webiste_link').val()) != 1) {
//                                                                            $(document).find('#loading1').hide();
//                                                                            $(document).find('.response_message').html('Please enter a valid url.');
//                                                                            $(document).find("#search_alert").modal('show');
//                                                                            $(document).find('#search_alert').css('z-index', '99999999');
//                                                                            return false;
//                                                                        }
//                                                                    }
//                                                                    $("#request_from").submit();
//                                                                });
                                                                function isNumber1(evt) {
                                                                    e = (evt) ? evt : window.event;
                                                                    var valid = (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 122) || (e.which == 8);
                                                                    if (!valid) {
                                                                        e.preventDefault();
                                                                    }
                                                                }
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

                                                                $("#request_from").submit(function (event) {
                                                                    if (flag1 == 1 || flag2 == 1)
                                                                        return false;
                                                                });
            </script>
    </body>
</html>