<html>
    <head>
        <?php $this->load->view('include/head'); ?>   
    </head>
    <body>
        <!--container-->
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="container">
                    <div class="row">
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main postad">
                            <div class="row">
                                <!--cat-->
                                <?php $this->load->view('include/left-nav'); ?>                                
                                <div class="col-sm-9 ContentRight">
                                    <h3></h3>
                                    Sorry, You have no free ads left to post. Wait for next month or you can purchase for this month using PayPal
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>