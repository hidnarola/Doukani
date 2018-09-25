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
                            <?php $this->load->view('include/left-nav'); ?>
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
                                <div class="success_register"><i class="fa fa-check" aria-hidden="true"></i></div>
                                <div class="thank_you_title_div">Thank <span style="color: #EB1F33;">you!</span></div>
                                <!--<div class="thank_you_content_div">You are successfully registered with us. Please check your email for further.</div>-->
                                <div class="thank_you_content_div">
                                    <!--<span class="greetings_span">Hey <?php echo $reg_user; ?>,</span><br>-->
                                    Thank you so much for registration.<br>We have sent you email for account activation. Please check your email for further process.
                                </div>
                                <div class="thank_you_content_div about_msg_div">
                                    While you are waiting for activation email, why not check out more about <span style="color: #EB1F33;">Doukani</span> and how it can help you.<br>
                                    <a class="btn btn-default btn_about" href="<?php echo base_url() . 'about-us' ?>">Click here to know more about us</a>
                                </div>
                            </div>
                                
                                </div>
                        </div>
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
    </body>