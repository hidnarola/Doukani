<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <style>           
            #passstrength {
                color:red;
                font-family:verdana;
                font-size:10px;
                font-weight:bold;
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
                                    <i class='icon-key'></i>
                                    <span>Accounts</span>
                                    <?php 
                                    $redirect = $_SERVER['QUERY_STRING'];
                                    if(!empty($_SERVER['QUERY_STRING']))
                                        $redirect = '/?'.$redirect;
                                    ?>
                                </h1>				
                            </div>
                            <hr class="hr-normal">
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (validation_errors() != false) { ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo validation_errors(); ?>                              
                                </div>                          
                            <?php } ?>
                            <?php
                            if (sizeof($permission) > 0 && $permission[0]->permission != '')
                                $permission_array = explode(",", $permission[0]->permission);
                            else
                                $permission_array = array();
                            ?>

                            <div class='row'>

                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Edit Admin Account
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div><br>
                                    <div class='col-sm-3 col-lg-2'>
                                        <div class='box'>
                                            <div class='box-content'>                                                
                                                <form action='<?php echo base_url(); ?>admin/systems/change_picture/<?php echo $user[0]->user_id; ?>' method='post' enctype="multipart/form-data" id="UserChangePictureForm">
                                                    <div id='preview' style="cursor: pointer; z-index:-100;">
                                                        <?php
                                                        if (!empty($user[0]->profile_picture))
                                                            $profile_image = base_url() . profile . "medium/" . $user[0]->profile_picture;
                                                        else
                                                            $profile_image = base_url() . "assets/upload/avtar.png";
                                                        ?>
                                                        <img class="img-responsive" alt="<?php echo $user[0]->username; ?>" id="exist" src="<?php echo $profile_image; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"/>
                                                        <br>    
                                                        <span id="update_profile">
                                                            <label>Update Image</label>
                                                        </span>
                                                    </div>

                                                    <div id='imageloadbutton' style="display: none">
                                                        <input type="file" name="profile_picture" id="photoimg" />	
                                                    </div>
                                                </form>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-lg-10 box">
                                        <div class='box-content box-double-padding'>
                                            <form action='<?php echo base_url() . 'admin/systems/accounts_edit/' . $user[0]->user_id.$redirect; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">

                                                <div class='form-group'>
                                                    <label class='col-md-3 control-label text-left' for='inputText1'>
                                                        <input data-target='#change-password' data-toggle='collapse' id='changepasswordcheck' type='checkbox' name="pwd_flag" value='0'>
                                                        Change password?
                                                    </label>
                                                </div>
                                                <div class='collapse' id='change-password'>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Password</label>
                                                        <div class='col-md-5 controls'>
                                                            <input placeholder='Password' class="pwstrength form-control" name="password" type='password' id="password"/>
                                                            <span id="passstrength"></span>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Confirm Password</label>
                                                        <div class='col-md-5 controls'>
                                                            <input placeholder='Confirm Password' class="form-control" name="cnfpassword" type='password' data-rule-equalto="#password"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Username</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Username' class="form-control" name="username" type='text'  value="<?php echo $user[0]->username; ?>" data-rule-required='true' />
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Nickname</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Nickname' class="form-control" name="nick_name" type='text' value="<?php echo $user[0]->nick_name; ?>"/>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Email Address</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Email Address' class="form-control" name="email_id" type='text' value="<?php echo $user[0]->email_id; ?>" data-rule-required='true' />
                                                    </div>
                                                </div>

                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Address</label>
                                                    <div class='col-md-5 controls'>
                                                        <textarea placeholder="Address" class="form-control" name="address" rows="4" cols="80"><?php echo $user[0]->address; ?></textarea>              				
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Phone</label>
                                                    <div class='col-md-5 controls'>
                                                        <input class='form-control' id='phone' placeholder='Phone' type='text' name="phone" value="<?php echo $user[0]->phone; ?>"  onkeypress="return isNumber(event)" data-rule-required='true' > 
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'>Emirate</label>
                                                    <div class='col-md-5 controls'>
                                                        <select id="sub_state_list" name="state" class="select2 form-control">
                                                            <option value="0">Select Emirate</option>
                                                            <?php foreach ($state as $o) { ?>
                                                                <option value="<?php echo $o['state_id']; ?>" <?php echo ($user[0]->state == $o['state_id']) ? 'selected' : ''; ?> ><?php echo $o['state_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>    
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Chat Notification</label>
                                                    <div class='col-md-5 controls'>
                                                        <input class='' id='chat_notification' type='checkbox' name="chat_notification" value="1"  <?php if ($user[0]->chat_notification == 1) echo 'checked'; ?> >
                                                    </div>
                                                </div>                                        						   
                                                <!-- <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Cover Picture</label>
                                                    <div class='col-md-5 controls'>
                                                        <input title='Cover Picture' name='cover_picture'type='file'>
                                                        <div class="cover-size-div">Recommend Size: 1920*440</div>
                                                    </div>
                                                </div> -->
                                                <?php //if (!empty($user[0]->cover_picture)): ?>
                                                   <!-- <img alt="Cover Picture" src="<?php //echo base_url() . cover . "small/" . $user[0]->cover_picture;   ?>"/>-->
                                                <?php //endif; ?>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>Permissions</label>
                                                    <div class='col-md-10'>
                                                        <!--<div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' <?php //if(in_array('dashboard',$permission_array )){ echo 'checked';}     ?> value='dashboard' name="chk_0">
                                                                Dashboard
                                                            </label>
                                                        </div> -->
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' <?php
                                                                if (in_array('categories', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> value='categories' name="chk_11" class="chk_module">
                                                                Categories
                                                            </label>
                                                        </div>
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' <?php
                                                                if (in_array('classified', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> value='classified' name="chk_1" class="chk_module">
                                                                Classified Ads Management
                                                            </label>
                                                        </div>
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' <?php
                                                                if (in_array('store_mgt', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> value='store_mgt' name="chk_6" class="chk_module" >
                                                                Store Ads Management
                                                            </label>
                                                        </div>
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' <?php
                                                                if (in_array('offer_mgt', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> value='offer_mgt' name="chk_2" class="chk_module">
                                                                Offer Ads Management
                                                            </label>
                                                        </div>
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' <?php
                                                                if (in_array('user_mgt', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> value='user_mgt' name="chk_3" class="chk_module">
                                                                Users Management
                                                            </label>
                                                        </div>
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox'<?php
                                                                if (in_array('system_mgt', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> value='system_mgt' name="chk_4" class="chk_module">
                                                                System Management
                                                            </label>
                                                        </div>
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' <?php
                                                                if (in_array('page_mgt', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> value='page_mgt' name="chk_5" class="chk_module">
                                                                Pages Management
                                                            </label>
                                                        </div>
                                                        
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' <?php
                                                                if (in_array('push_notification', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> value='push_notification' name="chk_7" class="chk_module">
                                                                Push Notification
                                                            </label>
                                                        </div>
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' value='message_mgt' name="chk_8" <?php
                                                                if (in_array('message_mgt', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> class="chk_module">
                                                                Buyer Seller Conversation
                                                            </label>
                                                        </div>
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' value='order_mgt' name="chk_10" <?php
                                                                if (in_array('order_mgt', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> class="chk_module">
                                                                Order Management
                                                            </label>
                                                        </div>
                                                        <div class='checkbox'>
                                                            <label>
                                                                <input type='checkbox' value='only_listing' name="chk_9" <?php
                                                                if (in_array('only_listing', $permission_array)) {
                                                                    echo 'checked';
                                                                }
                                                                ?> class="chk_only">
                                                                <b>Only Listing</b>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-actions form-actions-padding-sm">
                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-2">
                                                            <button class='btn btn-primary' type='submit'>
                                                                <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
                                                            <a href='<?php echo base_url() ."admin/systems/accounts".$redirect; ?>' title="Cancel" class="btn">Cancel</a>
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
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script type="text/javascript">
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
                    return false;
                }
                return true;
            }

            $(document).ready(function () {
                $('#preview').click(function () {
                    $('#photoimg').click();
                });

                $('#photoimg').live('change', function ()
                {
                    $("#UserChangePictureForm").submit();//	    
                });
                $('#changepasswordcheck').bind('click', function () {
                    if ($(this).is(':checked')) {
                        $('#password').attr({
                            'data-rule-minlength': "6",
                            'data-rule-password': "true",
                            'data-rule-required': 'true'
                        });
                        $('#password-confirmation').attr('data-rule-equalto', '#password');
                    } else {
                        $('#password').removeAttr('data-rule-minlength data-rule-password data-rule-required');
                        $('#password-confirmation').removeAttr('data-rule-equalto');
                    }
                });

                $('.chk_module').on('change', function (e) {
                    $('.chk_only').prop('checked', false);
                });
                $('.chk_only').on('change', function (e) {
                    $('.chk_module').prop('checked', false);
                });
            });

            $('#password').keyup(function (e) {
                var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
                var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
                var enoughRegex = new RegExp("(?=.{6,}).*", "g");
                if (false == enoughRegex.test($(this).val())) {
                    $('#passstrength').html('Minimum 6 Characters');
                } else if (strongRegex.test($(this).val())) {
                    $('#passstrength').className = 'ok';
                    $('#passstrength').html('Strong!');
                } else if (mediumRegex.test($(this).val())) {
                    $('#passstrength').className = 'alert';
                    $('#passstrength').html('Medium!');
                } else {
                    $('#passstrength').className = 'error';
                    $('#passstrength').html('Weak!');
                }
                return true;
            });
        </script>
    </body>
</html>