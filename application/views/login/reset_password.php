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
                                <h3>Reset Password</h3>
                                <br>
                                <form action='<?php echo base_url(); ?>login/reset_password' class='validate-form' method='post'>
                                    <div class="col-sm-6 login-div center_part">
                                        <div class="form-group pwd">
                                            <input type="password" class="form-control" placeholder="Password"  name="password" id="password" data-rule-required="true"/>
                                        </div>
                                        <input name="ident" type="hidden" value="<?php echo $ident; ?>"/>
                                        <input name="activate" type="hidden" value="<?php echo $activate; ?>"/>
                                        <button class="btn btn-block btn-black" name="submit">Reset</button>
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
    </div>
</body>
</html>
