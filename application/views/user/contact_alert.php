<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <style>
            .list-icons01 a {margin-top:10px;}
        </style>        
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container-->
        <div class="container-fluid">            
            <!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
            <!--//ad1 header-->
            <!--menu-->
            <?php $this->load->view('include/menu'); ?>
            <!--//menu-->        
            <!--body-->
            <div class="page">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main dashboard">
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat-->
                            <!--content-->
                            <div class="col-sm-10 ContentRight"> 
                                <br>
                                <br>
                                <div class="lipsum postadBG">
                                    <div class="box-content ">
                                        <p><b>Hello User, In order to post an ad, Kindly update your contact number <a href="<?php echo HTTPS,website_url.'user/index'; ?>" >here</a>.</b></p>
                                    </div>                                    
                                </div>
                            </div>
                            <!--//content-->
                        </div>
                    </div>
                    <!--//main-->
                </div>
            </div>	
        </div>
        <!--//body-->        
        <!--footer-->
        <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </body>
</html>
