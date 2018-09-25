<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <link href='<?php echo base_url(); ?>assets/front/dist/css/bootstrap-switch.css' rel='stylesheet' type='text/css' />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />

        <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap-switch.js"></script>	 
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>            
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>            
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>            
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/demo.js" type="text/javascript"></script>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="container">
                    <div class="row">          
                        <?php $this->load->view('include/sub-header'); ?>           
                        <div class="col-sm-12 main category-grid">	
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>                    
                            <!--content-->
                            <div class="col-sm-9 ContentRight loginpg">
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
                                                        <input type="hidden" name="user_id" value="<?php echo (isset($user_id)) ? $user_id : ''; ?>"/>
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
                                <form  name="registration" id="registration" action='<?php echo base_url(); ?>classifiedRegistration/index' method='post' enctype="multipart/form-data">
                                    <div class="col-sm-12 login-div regi-div">
                                        <div class="user-login">
                                            <?php
                                            $url = "";
                                            if (isset($_SERVER['HTTP_REFERER'])) {
                                                $url = $_SERVER['HTTP_REFERER'];
                                            }
                                            ?>
                                            <input type="hidden" name="REFERER_url" value="<?php echo $url; ?>" />
                                            <h4>Signup with us</h4>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="First Name" name="fname" id="fname" value="<?php echo set_value('fname'); ?>" />
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Last Name" name="lname" id="lname" value="<?php echo set_value('lname'); ?>" />
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control" placeholder="Email" name="email_id" id="email_id" value="<?php echo set_value('email_id'); ?>" />
                                                <span id="email_status"></span>
                                            </div>

                                            <div class="form-group">      
                                                <input type="text" class="form-control" placeholder="Contact Number" name="phone" id="phone"  onkeypress="return isNumber1(event)" value="<?php echo set_value('phone'); ?>" />
                                            </div>
                                            <div class="form-group">     
                                                <input type="text" class="form-control" placeholder="Username" name="uname" id="uname" value="<?php echo set_value('uname'); ?>" />
                                                <span id="username_status"></span>
                                            </div>
                                            <div class="form-group">   
                                                <input placeholder='Password' class="pwstrength form-control" name="password1" type='password' id="password1"/>
                                            </div>
                                            <div class="form-group">   
                                                <input placeholder='Confirm Password' class="form-control" name="c_password" id="c_password" type='password' data-rule-equalto="#password1"/>
                                            </div>      

                                            <div class="form-group">    
                                                <input type="checkbox" name="term_condition" id="term_condition" checked value="1">  Yes, I agree with <a href="<?php echo site_url() . $term_link->slug_url; ?>" target="_blank"><span><?php echo $term_link->page_title; ?></span></a>
                                            </div>
                                            <button type="submit" name="register" id="register" class="btn btn-block btn-black">Register</button>
                                            <div class="text-right signup-link"><a href="<?php echo base_url(); ?>login/index">Already Registered? <span>Log In</span></a></div>
                                        </div>
                                        <div class="registration_or">or</div>
                                        <div class="social_main social_main_reg">
                                            <h4>Signup with Social</h4>
                                            <a href="<?php echo $fb_login_url; ?>" class="btn btn-block btn-fb" ><i class="fa fa-facebook"></i>Sign Up With Facebook</a>
                                            <a href="<?php echo $twitter_login_url; ?>" class="btn btn-block btn-twit"><i class="fa fa-twitter"></i>Sign Up With Twitter</a>
                                            <a href="<?php echo $googlePlusLoginUrl; ?>" class="btn btn-block btn-g-plus"><i class="fa fa-google-plus"></i>Sign Up With Google+</a>
                                            <!-- <a href="#" class="btn btn-block btn-email" name="faebook_login"><i class="fa fa-envelope"></i>Sign In With Email</a> -->
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
        <!-- / jquery mobile (for touch events) -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
        <!-- / jquery migrate (for compatibility with new jquery) [required] -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>        
        <!-- / jQuery UI Touch Punch -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>        
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>

        <script type="text/javascript">


                                                    $(function () {
                                                        var nowDate = new Date();
                                                        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate() + 1, 0, 0, 0, 0);
//                                                            /, startDate: today
                                                        $(".datetimepicker").datetimepicker({minDate: 0});
                                                    });

                                                    function show_emirates(val) {
                                                        var url = "<?php echo base_url(); ?>admin/users/show_emirates";
                                                        $.post(url, {value: val}, function (data)
                                                        {
                                                            $("#sub_state_list option").remove();
                                                            $("#sub_state_list").append(data);

                                                        });
                                                    }

                                                    var flag1 = 0;
                                                    var flag2 = 0;
                                                    jQuery(document).ready(function ($) {

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


                                                        $(document).on("change", "#uname", function (e) {
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
                                                                uname: "required",
                                                                gender: "required",
                                                                password1: {
                                                                    required: true,
                                                                    minlength: 6
                                                                },
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
                                                                }, store_name: {
                                                                    required: true,
                                                                    minlength: 5,
                                                                    maxlength: 20
                                                                },
                                                                store_domain: {
                                                                    required: true,
                                                                    minlength: 5,
                                                                    maxlength: 15
                                                                }
                                                            },
                                                            messages: {
                                                                fname: "Please enter First Name",
                                                                lname: "Please enter Last Name",
                                                                uname: "Please enter Username",
                                                                gender: "Please select gender",
                                                                user_role: "Please select User Type",
                                                                password1: {
                                                                    required: "Please enter Password",
                                                                    minlength: "Password should be of minimum 6 chars"
                                                                },
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
                                                                }, store_name: {required: "Store name is required.",
                                                                    minlength: "Store name should be of minimum 5 chars",
                                                                    maxlength: "Store name should be of maximum 20 chars"
                                                                },
                                                                store_domain: {
                                                                    required: "Store URL is required.",
                                                                    minlength: "Store domain name should be of minimum 5 chars",
                                                                    maxlength: "Store domain name should be of maximum 15 chars"
                                                                }
                                                            },
                                                            submitHandler: function (form) {
                                                                if (flag1 == 0 && flag2 == 0)
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



        </script>
    </body>
</html>