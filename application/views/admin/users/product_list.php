<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb store'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-header">
                                        <h1 class='pull-left'>
                                            <i class='icon-building'></i>
                                            <span>Block User's Products</span>
                                        </h1>
                                    </div>
                                </div>
                            </div>                            
                            <div class='title'>
                                <?php 
                                    echo 'Email ID: <u>' . @$email_id . '</u><br>';
                                    echo 'Username: ' . @$username;                                    
                                ?>
                            </div>                            
                            <hr class="hr-normal">                            
                            <div class='row'>
                                <div class='col-sm-12' id="filter_list">
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Listings</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area'>
                                                    <table class='table table-striped superCategoryList' style='margin-bottom:0;'>
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Image</th>
                                                                <th>Category</th>
                                                                <th>Price</th>
                                                                <th>Status</th>
                                                                <th>Product Is</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($product)):
                                                                foreach ($product as $pro) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $pro['product_name']; ?></td>
                                                                        <td>
                                                                            <?php if (!empty($pro['product_image'])) { ?>
                                                                                <a data-lightbox='flatty' href='<?php echo base_url() . product . "original/" . $pro['product_image']; ?>'>
                                                                                    <img style="height: 40px; width: 64px;" src="<?php echo base_url() . product . "original/" . $pro['product_image']; ?>" onerror="this.src='<?php echo site_url(); ?>/assets/upload/No_Image.png'"/>
                                                                                </a>
                                                                            <?php } else { ?> 
                                                                                <img style="height: 40px; width: 64px;" src="<?php echo site_url(); ?>assets/upload/No_Image.png"/>
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></td>
                                                                        <td><?php echo number_format($pro['product_price']); ?></td>
                                                                        <td><?php
                                                                            if ((int) $pro['product_is_sold'] == 1 && (int) $pro['product_deactivate'] != 1)
                                                                                echo 'Sold';
                                                                            elseif ((int) $pro['product_is_sold'] != 1 && (int) $pro['product_deactivate'] == 1)
                                                                                echo 'Deactivated';
                                                                            elseif (((int) $pro['product_is_sold'] == 0 || (int) $pro['product_is_sold'] == null) && ((int) $pro['product_deactivate'] == '' || (int) $pro['product_deactivate'] == null))
                                                                                echo 'Available';
                                                                            elseif ((int) $pro['product_is_sold'] == 1 && (int) $pro['product_deactivate'] == 1)
                                                                                echo 'Sold & Deactivated';
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo$pro['product_is_inappropriate']; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            endif;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="col-sm-12 text-right pag_bottom">
                                                        <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>	
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>               
    </body>
</html>