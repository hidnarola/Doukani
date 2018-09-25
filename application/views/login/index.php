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
                                <?php if (isset($msg2)): ?>
                                    <div class='alert <?php echo $msg_class; ?> text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $msg2; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('msg3') != ''): ?>
                                    <div class='alert  alert-info'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <center><?php echo $this->session->flashdata('msg3'); ?></center>
                                    </div>
                                <?php endif; ?>		
                                <?php if ($this->session->flashdata('msg5') != ''): ?>
                                    <div class='alert  alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <center><?php echo $this->session->flashdata('msg5'); ?></center>
                                    </div>
                                <?php endif; ?>	

                                <h3>Login</h3>
                                <form action='<?php echo base_url(); ?>login/index' class='validate-form' method='post'>
                                    <div class="col-sm-12 login-div user-login-div">
                                        <div class="social_main">
                                            <h4>Login with Social</h4>
                                            <?php //echo $fb_login_url; ?>
                                            <a href="<?php echo $fb_login_url; ?>" class="btn btn-block btn-fb"><i class="fa fa-facebook"></i>Sign In With Facebook</a>
                                            <a href="<?php echo $twitter_login_url; ?>" class="btn btn-block btn-twit"><i class="fa fa-twitter"></i>Sign In With Twitter</a>
                                            <a href="<?php echo $googlePlusLoginUrl; ?>" class="btn btn-block btn-g-plus"><i class="fa fa-google-plus"></i>Sign In With Google+</a>
                                            <!-- <a href="<?php echo $fb_login_url; ?>" class="btn btn-block btn-email" name="faebook_login"><i class="fa fa-envelope"></i>Sign In With Email</a> -->
                                            <div class="text-right signup-link">Not Yet Registered? <a href="<?php echo base_url(); ?>registration"><span>Sign up</span></a></div>
                                        </div>
                                        <div class="user-login">
                                            <?php
                                            $url = "";
                                            if (isset($_SERVER['HTTP_REFERER'])) {
                                                $url = $_SERVER['HTTP_REFERER'];
                                            }
                                            ?>
                                            <input type="hidden" name="REFERER_url" value="<?php echo $url; ?>" />
                                            <h4>Login with Doukani</h4>
                                            <div class="form-group un">
                                                <input type="text" class="form-control" placeholder="Username"  name="uname" id="uname" data-rule-required="true" />
                                            </div>
                                            <div class="form-group pwd">
                                                <input type="password" class="form-control" placeholder="Password"  name="password1" id="password1" data-rule-required="true"/>
                                            </div>
                                            <button class="btn btn-block btn-black" name="submit">Log in</button>
                                            <div class="text-right signup-link"><a href="<?php echo base_url(); ?>login/forget_password">Forgot Password?</a></div> 
                                        </div>   
                                        <div class="clearfix"></div>                     
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
