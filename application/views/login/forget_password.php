<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
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
                                <?php if (isset($msg) && !empty($msg)): ?>
                                    <div class='alert <?php echo $msg_class; ?> text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $msg; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('msg3') != ''): ?>
                                    <div class='alert  alert-info'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <center><?php echo $this->session->flashdata('msg3'); ?></center>
                                    </div>
                                <?php endif; ?>		
                                <h3>Forgot password</h3>
                                <br>
                                <form action='<?php echo base_url(); ?>login/forget_password' class='validate-form' method='post'>
                                    <div class="col-sm-6 login-div center_part">
                                        <div class="form-group un">
                                            <input type="text" class="form-control" placeholder="E-mail"  name="email_id" id="email_id" data-rule-required="true" data-rule-email='true' />
                                        </div>
                                        <button class="btn btn-block btn-black" name="submit">Send me instructions</button>
                                        <div class="text-right"><a href="<?php echo base_url(); ?>login/index">I already know my password</a></div>

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
        <!--//main-->
        <!--footer-->
        <?php $this->load->view('include/footer'); ?>
        <!--//footer-->    
</body>
</html>