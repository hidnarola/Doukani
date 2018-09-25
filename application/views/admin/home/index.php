<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <style>
            a {text-decoration:none !important;}
            .popover-title{ color: #FFF !important; background : #00acec !important;}
            .popover-content {color:#000 !important; font-size:15px; font-weight: 400 !important; font-style: normal;}
            .hr_listing {margin-top: 5px !important; margin-bottom: 5px !important; }
        </style>
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
                                    <i class='icon-dashboard'></i>
                                    <span>Dashboard</span>
                                </h1>		    
                            </div>
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <br>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>
                            <br>
                            <?php $this->load->view('admin/home/users_part'); ?>
                            <?php $this->load->view('admin/home/listings_part'); ?>
                            <?php $this->load->view('admin/home/stores_part'); ?>
                            <?php $this->load->view('admin/home/offers_part'); ?>
                            <?php $this->load->view('admin/home/balance_part'); ?>
                        </div>		
                    </div>
                </div>
            </section>
        </div>    
<?php $this->load->view('admin/include/footer-script'); ?>
    <script>
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        });
        $('body').on('click', function (e) {
            //did not click a popover toggle, or icon in popover toggle, or popover
            if ($(e.target).data('toggle') !== 'popover'
                && $(e.target).parents('[data-toggle="popover"]').length === 0
                && $(e.target).parents('.popover.in').length === 0) { 
                $('[data-toggle="popover"]').popover('hide');
            }
        });        
        
        </script>    
    </body>
</html>