<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <link href='<?php echo base_url(); ?>assets/front/dist/css/bootstrap-switch.css' rel='stylesheet' type='text/css' />
        <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap-switch.js"></script>	 
    </head>
    <body>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>		
            <!-- / jquery [required] -->
            <!-- / jquery ui -->
            <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
            <!-- / jQuery UI Touch Punch -->
            <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
            <!-- / bootstrap [required] -->
            <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
            <!-- / modernizr -->
            <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
            <!-- / retina -->
            <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
            <!-- / theme file [required] -->
            <script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
            <!-- / demo file [not required!] -->
            <script src="<?php echo base_url(); ?>assets/admin/javascripts/demo.js" type="text/javascript"></script>

            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main category-grid">
                            <?php $this->load->view('include/left-nav'); ?>
                            <div class="col-sm-9 loginpg ContentRight">
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
                                <?php if (isset($deleted_earlier) && !empty($deleted_earlier)): ?>
                                    <div class="text-center"><button data-toggle="modal" data-target="#myModal" class="btn btn-blue">Activate Account</button></div>
                                    <div id="myModal" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Account Activation</h4>
                                                </div>
                                                <form name="activation_frm" method="post">
                                                    <div class="modal-body">
                                                        <h5>Do you want to activate the products posted by you earlier?</h5>
                                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
                                                        <div class="make-switch" data-on-label="YES" data-off-label="NO">
                                                            <input type="checkbox" name="pro_checkbox" checked>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="activate" class="btn btn-blue">Activate</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <h3>Registration</h3>
                                <form  name="registration" id="registration" action='<?php echo base_url(); ?>registration' method='post' enctype="multipart/form-data">
                                    <div class="col-sm-12 login-div registration_main">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="First Name" name="fname" id="fname" value="<?php echo set_value('fname'); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Last Name" name="lname" id="lname" value="<?php echo set_value('lname'); ?>" />
                                                </div>
                                            </div>
                                            <!--<div class="col-sm-4">
                                                    <div class="form-group">
                                                                    <input type="text" class="form-control" placeholder="Nick Name" name="nick_name" id="nick_name"/>
                                                    </div>
                                            </div>-->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="email" class="form-control" placeholder="Email" name="email_id" id="email_id" value="<?php echo set_value('email_id'); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Contact Number" name="phone" id="phone"  onkeypress="return isNumber1(event)" value="<?php echo set_value('phone'); ?>" />
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                    <div class="form-group">
                                                            <select class="form-control" name="account_type">
                                                                    <option>-- Select Account Type --</option>
                                                                    <option>Individual</option>
                                                                    <option>Company</option>
                                                            </select>
                                                    </div>
                                            </div> -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Username" name="username" id="username" value="<?php echo set_value('username'); ?>" />
                                                </div>
                                            </div>
                                            <!--<div class="form-group">
                                                <input type="text" class="form-control" placeholder="Username" />
                                            </div>-->
                                            <div class="col-sm-6">								
                                                <div class='form-group controls'>
                                                    <input placeholder='Password' class="pwstrength form-control" name="password1" type='password' id="password1"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">								
                                                <div class='form-group controls'>
                                                    <input placeholder='Confirm Password' class="form-control" name="c_password" id="c_password" type='password' data-rule-equalto="#password1"/>
                                                </div>
                                            </div>
                                            <!--<div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" data-rule-minlength='6' data-rule-password='true' />
                                                                                </div>    
                                                                        </div>
                                                                        <div class="col-sm-6">							
                                                                                <div class="form-group">
                                                                                        <input type="password" class="form-control" placeholder="Confirm Password" name="c_password" id="c_password" data-rule-equalto="#password"/>
                                                                                </div>
                                                                        </div> -->
                                            <div class="col-sm-3 css-0001">
                                                <div class="form-group ">
                                                    <div class="gender">
                                                        <label><input type="radio" value="1" name="gender" id="gender" checked />Male</label>
                                                        <label><input type="radio" value="0" name="gender" id="gender" />Female</label>
                                                    </div>	
                                                    <label class="error" for="gender"></label>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <select id="user_role" name="user_role" class="select2 form-control" >
                                                        <option value="">User Type</option>
                                                        <option value="generalUser">Classified User</option>
                                                        <option value="storeUser">Store User</option>
                                                        <option value="offerUser">Offer User</option>
                                                    </select>
                                                </div>
                                            </div>						

                                            <div class="col-sm-6">
                                                <div class="form-group">								
                                                    <div class='datetimepicker input-group' id='datepicker'>
                                                        <input class='form-control' data-format='yyyy-MM-dd' name="date_of_birth"  id="date_of_birth" placeholder='Select Birth Date' type='text' value="<?php echo set_value('date_of_birth'); ?>">
                                                        <span class='input-group-addon '><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <label for="date_of_birth" class="error"></label>
                                                    <!--<p>Date: <input type="text" id="datepicker123" class='form-control' data-format='yyyy-MM-dd'/></p>
                                                    <label class="error" for="date_of_birth"></label> -->
                                                    <!--<input type="text" id="date_of_birth" placeholder='Date of Birth' name="date_of_birth" class="form-control"  />  -->							
                                                    <!--<div class='datepicker input-group' id='datepicker'>
                        <input class='form-control' data-format='yyyy-MM-dd' placeholder='Date of Birth' name="date_of_birth" type='text' data-rule-required='true'>
                                                            <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc2/css/bootstrap-glyphicons.css" rel="stylesheet">	<span class='input-group-addon'>										
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                    </div> -->							
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class='form-group'>
                                                    <div class='controls with-icon-over-input'>
                                                        <select id="location" name="location" class="select2 form-control" onchange="show_emirates(this.value);">
                                                            <option value="">Select Nationality</option>
                                                            <?php foreach ($location as $o) { ?>														
                                                                <option value="<?php echo $o['nation_id']; ?>" <?php if (isset($_REQUEST['location']) && $_REQUEST['location'] == $o['nation_id']) echo set_select('location', $o['nation_id'], TRUE); ?> ><?php echo $o['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" name="term_condition" id="term_condition" checked value="1">  Yes, I agree with <a href="<?php echo site_url() . $term_link->slug_url; ?>" target="_blank"><span><?php echo $term_link->page_title; ?></span></a>
                                            </div>

                                            <div class="col-sm-3">
                                                <button type="submit" name="register" id="register" class="btn btn-block btn-black">Register</button>
                                                <div class="text-right signup-link"><a href="<?php echo base_url(); ?>login/index">Already Registered? <span>Log In</span></a></div>
                                            </div>
                                            <!--<div class='form-group'>
                                                    <div class='controls with-icon-over-input'>
                                                            <select id="sub_state_list" name="sub_state_list" class=" form-control">

                                                            </select>
                                                    </div>
                </div>-->                            
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="dis_in or_text col-sm-12">
                                            <span class="">OR</span>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12">
                                            <div class="social_main">
                                                <a href="<?php echo $fb_login_url; ?>" class="btn btn-block btn-fb" name="faebook_login"><i class="fa fa-facebook"></i>Sign Up With Facebook</a>
                                                <a href="<?php echo $twitter_login_url; ?>" class="btn btn-block btn-twit" name="twitter_login"><i class="fa fa-twitter"></i>Sign Up With Twitter</a>
                                                <a href="<?php echo $googlePlusLoginUrl; ?>" class="btn btn-block btn-g-plus" name="faebook_login"><i class="fa fa-google-plus"></i>Sign Up With Google+</a>
                                                <!-- <a href="#" class="btn btn-block btn-email" name="faebook_login"><i class="fa fa-envelope"></i>Sign In With Email</a> -->
                                            </div>							
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--//content-->   
                        </div>
                        <!--//content-->
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('include/footer'); ?>
        <!--//main-->
        <!--	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" /> -->

        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />
        <!-- <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script> -->
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            /* $(function() {
             var date = new Date();
             var currentMonth = date.getMonth();
             var currentDate = date.getDate();
             var currentYear = date.getFullYear();
             $('#datepicker123').datepicker({
             maxDate: new Date(currentYear, currentMonth, currentDate)
             });
             $('#date_of_birth').datepicker({
             maxDate: new Date(currentYear, currentMonth, currentDate)
             });
             });*/
        </script>	
        <!-- / jquery mobile (for touch events) -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
        <!-- / jquery migrate (for compatibility with new jquery) [required] -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
        <!-- / jquery ui -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <!-- / jQuery UI Touch Punch -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <!-- / bootstrap [required] -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
        <!-- / modernizr -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
        <!-- / retina -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <!--//footer-->
    </div>
        <!--<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery-ui.min.js"
            type="text/javascript"></script>
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/start/jquery-ui.css" 
          rel="Stylesheet" type="text/css" />  -->
    <script type="text/javascript">

            $(function () {
                //$( "#datepicker" ).datepicker({  setEndDate: new Date() });
            });
            //$('#date_of_birth').datepicker('setStartDate', '2013-01-01');
            //$( "#datepicker" ).datepicker({  maxDate: new Date() });
            //$('#date_of_birth').datepicker('setStartDate', '2013-01-01');
            /*$(function () {
             $("#date_of_birth").datepicker({
             numberOfMonths: 2,
             onSelect: function (selected) {
             var dt = new Date(selected);
             dt.setDate(dt.getDate() + 1);
             $("#end_date").datepicker("option", "minDate", dt);
             }
             });
             $("#end_date").datepicker({
             numberOfMonths: 2,
             onSelect: function (selected) {
             var dt = new Date(selected);
             dt.setDate(dt.getDate() - 1);
             $("#date_of_birth").datepicker("option", "maxDate", dt);
             }
             });
             }); */
            //show_emirates(val);
            function show_emirates(val) {
                var url = "<?php echo base_url(); ?>admin/users/show_emirates";
                $.post(url, {value: val}, function (data)
                {
                    //                            alert(data);
                    $("#sub_state_list option").remove();
                    $("#sub_state_list").append(data);

                });
            }
            jQuery(document).ready(function ($) {

                $.validator.addMethod("maxDate", function (value, element) {
                    var curDate = new Date();
                    var inputDate = new Date(value);
                    if (inputDate < curDate)
                        return true;
                    return false;
                }, "Birthdate must be less than today's date");

                $("#registration").validate({
                    rules: {
                        fname: "required",
                        lname: "required",
                        username: "required",
                        gender: "required",
                        password1: {
                            required: true,
                            minlength: 6
                        },
                        /* c_password: {
                         required: true,
                         equalTo: '#password'
                         }, */
                        email_id: {
                            required: true,
                            email: true
                        },
                        phone: {
                            required: true,
                            number: true
                        },
                        date_of_birth: {
                            required: true,
                            date: true,
                            maxDate: true
                        },
                        location: {
                            required: true,
                        },
                        user_role: {
                            required: true
                        }
                    },
                    messages: {
                        fname: "Please enter First Name",
                        lname: "Please enter Last Name",
                        username: "Please enter Username",
                        gender: "Please select gender",
                        user_role: "Please select User Type",
                        password1: {
                            required: "Please enter Password",
                            minlength: "Password should be of minimum 6 chars"
                        },
                        /*  c_password: {
                         required: "Please repeat the entered password",
                         equalTo: 'Password mismatch'
                         }, */
                        email_id: {
                            required: "Please enter an email address",
                            email: "Please enter a valid email address"
                        },
                        phone: {
                            required: "Please enter Phone Number",
                            number: "Please enter numeric value"
                        },
                        date_of_birth: {
                            required: "Please enter Birthdate",
                        },
                        location: {
                            required: "Please select Nationality",
                        }
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            });
            function isNumber1(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
                    return false;
                }
                return true;
            }
            // $("[name='my-checkbox']").bootstrapSwitch();
    </script>
    <script>
        $(function () {
            //$( "#datepicker123" ).datepicker({  maxDate: new Date() });
        });
    </script>	
    <!--container-->
</body>
</html>