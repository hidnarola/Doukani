<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/token-input.css" type="text/css" />
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
                                    <i class='icon-apple'></i>
                                    <?php if (isset($request_page) && $request_page == 'ios') { ?>
                                        <span>iOS</span>
                                    <?php } else { ?>
                                        <span>Android</span>
                                    <?php } ?>
                                </h1>				
                            </div>
                            <hr class="hr-normal">
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert  alert-info'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <center><?php echo $this->session->flashdata('msg'); ?></center>
                                </div>
                            <?php endif; ?>
                            <?php $this->load->view('admin/push_notification/form_block'); ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
    </body>
    <script type="text/javascript" src="<?php echo site_url(); ?>assets/admin/javascripts/jquery.tokeninput.js"></script>
    <?php $this->load->view('admin/push_notification/script'); ?>    
</html>