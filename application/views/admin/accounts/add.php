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
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Add Admin Account
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class='box-content'>
                                        <form action='<?php echo base_url() . 'admin/systems/accounts_add/' ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">

                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Username</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Username' class="form-control" name="username" type='text' value="<?php echo set_value('username'); ?>" data-rule-required='true' />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Nickname</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Nickname' class="form-control" name="nick_name" type='text' />
                                                </div>
                                            </div>  
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Email Address</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Email Address' class="form-control" name="email_id" type='text'  value="<?php echo set_value('email_id'); ?>" data-rule-required='true' />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Password</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Password' class="form-control" name="password" type='password' id="password" data-rule-required='true' />
                                                    <span id="passstrength"></span>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Confirm Password</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Confirm Password' class="form-control" name="cnfpassword" type='password'  data-rule-equalto="#password" data-rule-required='true' />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Address</label>
                                                <div class='col-md-5 controls'>
                                                    <textarea placeholder="Address" class="form-control" name="address" rows="4" cols="80"><?php if (isset($_POST['address'])) echo $_POST['address']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Phone</label>
                                                <div class='col-md-5 controls'>
                                                    <input class='form-control' id='phone' placeholder='Phone' type='text' name="phone"   onkeypress="return isNumber(event)"  value="<?php echo set_value('phone'); ?>" data-rule-required='true' > 
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Emirate</label>
                                                <div class='col-md-5 controls'>
                                                    <select id="sub_state_list" name="state" class="select2 form-control">
                                                        <option value="0">Select Emirate</option>
                                                        <?php foreach ($state as $o) { ?>
                                                            <option value="<?php echo $o['state_id']; ?>" ><?php echo $o['state_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>    
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Chat Notification</label>
                                                <div class='col-md-5 controls'>
                                                    <input class='' id='chat_notification' type='checkbox' name="chat_notification" value="1" >
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Profile Picture</label>
                                                <div class='col-md-5 controls'>
                                                    <input title='Profile Picture' name='profile_picture'type='file'>
                                                </div>
                                            </div>
                                            <!-- <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Cover Picture</label>
                                                <div class='col-md-5 controls'>
                                                    <input title='Cover Picture' name='cover_picture'type='file'>
                                                    <div class="cover-size-div">Recommend Size: 1920*440</div>
                                                </div>
                                            </div> -->
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'>Permissions</label>
                                                <div class='col-md-10'>
                                                    <!--<div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='dashboard' name="chk_0">
                                                            Dashboard
                                                        </label>
                                                    </div> -->
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='categories' name="chk_11" class="chk_module">
                                                            Categories
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='classified' name="chk_1" class="chk_module">
                                                            Classified Ads Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='store_mgt' name="chk_6" class="chk_module">
                                                            Store Ads Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='offer_mgt' name="chk_2" class="chk_module">
                                                            Offer Ads Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='user_mgt' name="chk_3" class="chk_module">
                                                            Users Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='system_mgt' name="chk_4" class="chk_module">
                                                            System Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='page_mgt' name="chk_5" class="chk_module">
                                                            Pages Management
                                                        </label>
                                                    </div>                                                    
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='push_notification' name="chk_7" class="chk_module">
                                                            Push Notification
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='message_mgt' name="chk_8" class="chk_module">
                                                            Buyer Seller Conversation
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='order_mgt' name="chk_10" class="chk_module">
                                                            Order Management
                                                        </label>
                                                    </div>                                                    
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input type='checkbox' value='only_listing' name="chk_9" class="chk_only">
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
                                                        <a href='<?php echo base_url(); ?>admin/systems/accounts' title="Cancel" class="btn">Cancel</a>
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