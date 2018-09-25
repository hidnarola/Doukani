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
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main category-grid">			
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat-->
                            <div class="col-sm-9 ContentRight">

                                <div class="cart">
                                    <div class="container">
                                        <div class="row bg-cart-pg">

                                            <div class="mainContent cart-text">
                                                <span><?php if (isset($message)) echo $message; ?></span>
                                            </div>
                                            <?php if (isset($order_list) && sizeof($order_list) > 0) { ?>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="cart-ord-number cart-table-th">Order Number</th>
                                                            <th class="cart-purchase cart-table-th">Purchased From</th>
                                                            <th class="cart-price cart-table-th">Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($order_list as $list) {
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <a href="<?php echo site_url() . 'user/order_list/' . $list['id']; ?>"><?php echo $list['order_number']; ?></a>
                                                                </td>                                                        
                                                                <td>
                                                                    <?php echo $list['store_name']; ?>
                                                                </td>
                                                                <td> 
                                                                    <?php echo $list['final_total']; ?>
                                                                </td>
                                                            </tr>								
                                                        <?php } ?>
                                                    </tbody>
                                                </table> 
                                            <?php } ?>
                                            <div class="cart-msg-pg">
                                                <?php if (isset($status) && $status == 'success') { ?>
                                                    <a href="<?php echo site_url() . 'stores'; ?>" class="btn btn-primary">Continue Shopping</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php //$this->session->unset_userdata('order_number');  ?>
                        </div>
                    </div>
                </div>  
            </div>  
        </div>  
        <!--//main-->   
        <?php $this->load->view('include/footer'); ?>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
    </body>
</html>