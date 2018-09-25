<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb login contrast-background'>
        <div class='middle-container'>
            <div class='middle-row'>
                <div class='middle-wrapper'>
                    <div class='login-container-header'>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='text-center'>
                                        <a href='<?php echo base_url(); ?>admin/users/login'>
                                            <div class='icon-heart'></div>
                                            <span><?php echo $this->config->item('site_name'); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='login-container'>
                        <div class='container'>
                            <div class='row'>
                                <?php if (isset($msg) && !empty($msg)): ?>
                                    <div class='alert <?php echo $msg_class; ?> text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $msg; ?>
                                    </div>
                                <?php endif; ?>
                                <div class='col-sm-4 col-sm-offset-4'>
                                    <h1 class='text-center title'>Forgot password</h1>
                                    <form action='<?php echo base_url(); ?>admin/users/forget_password' class='validate-form' method='post'>
                                        <div class='form-group'>
                                            <div class='controls with-icon-over-input'>
                                                <input value="" placeholder="E-mail" class="form-control" data-rule-required="true" name="email_id" type="text" />
                                                <i class='icon-user text-muted'></i>
                                            </div>
                                        </div>
                                        <button class='btn btn-block' type="submit">Send me instructions</button>
                                    </form>
                                    <div class='text-center'>
                                        <hr class='hr-normal'>
                                        <a href='<?php echo base_url(); ?>admin/users/login'>
                                            <i class='icon-chevron-left'></i>
                                            I already know my password
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='login-container-footer'>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-sm-12'>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / jquery [required] -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
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
        <!-- / theme file [required] -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
        <!-- / demo file [not required!] -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/demo.js" type="text/javascript"></script>
        <!-- / START - page related files and scripts [optional] -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script>
        <!-- / END - page related files and scripts [optional] -->
    </body>
</html>