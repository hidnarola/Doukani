<!DOCTYPE html>
<html lang="en">
    <head>  
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">                	
            <?php $this->load->view('include/header'); ?>        
            <?php $this->load->view('include/menu'); ?>    
            <div class=" page">
                <div class="container">
                    <div class="row">
                        <?php $this->load->view('include/sub-header'); ?>
                        <?php if (isset($offers_list) && sizeof($offers_list) > 0) { ?>
                            <div class="row">
                                <div class="offer-banner">
                                    <h1 class="wrap-title">Today's Featured Offers</h1>
                                    <div id="owl-demo1" class="owl-carousel">
                                        <?php $this->load->view('offer/offer_grid_view'); ?>
                                    </div>
                                    <div class="customNavigation">
                                        <a class="prev" id="demo1_prev"></a>
                                        <a class="next" id="demo1_next"></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="offer-wrap">
                            <div class="gray-box">
                                <h3 class="wrap-title">Categories</h3>
                                <div class="cate-listing">
                                    <div class="cate-list ads">

                                        <ul class="list-ul">
                                            <?php
                                            $cat_count = 1;
                                            foreach ($category as $cat) {
                                                if ($cat_count <= 9) {
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo site_url() . 'offers/?cat_id=' . $cat['category_id']; ?>">
                                                            <div class="cate-block">
                                                                <div class="cate-icn" style="color: <?php echo $cat['color']; ?>"><i class="fa <?php echo $cat['icon']; ?>"></i></div>
                                                                <h4 class="cate-name"><span><?php echo $cat['catagory_name']; ?></span></h4>
                                                            </div>
                                                        </a>
                                                    </li> 
                                                <?php } $cat_count++;
                                            }
                                            ?>
                                            <li>
                                                <a href="<?php echo site_url() . 'offers'; ?>">
                                                    <div class="comp-block more">
                                                        <div class="comp-img"><span>View<br>More</span></div>
                                                    </div>
                                                </a><br><br>
                                            </li>                                                
                                        </ul>
                                    </div>
                                    <div class="offer-ads">
                                        <?php
                                        if (!empty($category_banner)) {
                                            if ($category_banner[0]['ban_txt_img'] == 'image') {
                                                if (strpos($category_banner[0]['site_url'], 'http://') !== false || strpos($category_banner[0]['site_url'], 'https://') !== false) {
                                                    $category_link = 'href="' . $category_banner[0]['site_url'] . '"';
                                                } else {
                                                    $category_link = 'href="http://' . $category_banner[0]['site_url'] . '"';
                                                }
                                                ?>
                                                <a <?php echo $category_link; ?> target="_blank" onclick="javascript:update_count('<?php echo $category_banner[0]['ban_id']; ?>')" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $category_banner[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner" /></a>
                                                <?php
                                            } elseif ($category_banner[0]['ban_txt_img'] == 'text') {
                                                if (strpos($category_banner[0]['site_url'], 'http://') !== false || strpos($category_banner[0]['site_url'], 'https://') !== false) {
                                                    $category_link1 = 'href="' . $category_banner[0]['site_url'] . '"';
                                                } else {
                                                    $category_link1 = 'href="http://' . $category_banner[0]['site_url'] . '"';
                                                }
                                                ?>
                                                <a <?php echo $category_link1; ?> target="_blank"  onclick="javascript:update_count('<?php echo $category_banner[0]['ban_id']; ?>')" class="mybanner img-responsive center-block">
                                                    <div class="">
                                                        <?php
                                                        echo $category_banner[0]['text_val'];
                                                        ?>
                                                    </div>
                                                </a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div><br><br>
                                </div>
                            </div>
                            <div class="gray-box">
                                <h3 class="wrap-title">Companies</h3>
                                <div class="comp-listing">
                                    <div class="comp-list ads">
                                            <?php if (isset($company_list) && sizeof($company_list) > 0) { ?>
                                            <ul class="comp-ul">
    <?php $this->load->view('offer/companies_logo_list'); ?>
                                                <li>
                                                    <a href="<?php echo site_url() . 'companies'; ?>">
                                                        <div class="comp-block more">
                                                            <div class="comp-img"><span>View<br>More</span></div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
<?php } else { ?>
                                            <div class="catlist col-sm-10">
                                                <div class="TagsList">
                                                    <div class="subcats">
                                                        <div class="col-sm-12 no-padding-xs">
                                                            <div class="col-sm-12">
                                                                &nbsp;No results found
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br><br><br>
                                            </div>
<?php } ?>
                                    </div>
                                    <div class="offer-ads">
                                        <?php
                                        if (!empty($company_banner)) {
                                            if ($company_banner[0]['ban_txt_img'] == 'image') {
                                                if (strpos($company_banner[0]['site_url'], 'http://') !== false || strpos($company_banner[0]['site_url'], 'https://') !== false) {
                                                    $company_link = 'href="' . $company_banner[0]['site_url'] . '"';
                                                } else {
                                                    $company_link = 'href="http://' . $company_banner[0]['site_url'] . '"';
                                                }
                                                ?>
                                                <a <?php echo $company_link; ?> target="_blank" onclick="javascript:update_count('<?php echo $company_banner[0]['ban_id']; ?>')" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $company_banner[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner"  /></a>
                                                <?php
                                            } elseif ($company_banner[0]['ban_txt_img'] == 'text') {
                                                if (strpos($company_banner[0]['site_url'], 'http://') !== false || strpos($company_banner[0]['site_url'], 'https://') !== false) {
                                                    $company_link1 = 'href="' . $company_banner[0]['site_url'] . '"';
                                                } else {
                                                    $company_link1 = 'href="http://' . $company_banner[0]['site_url'] . '"';
                                                }
                                                ?>
                                                <a <?php echo $company_link1; ?> target="_blank"  onclick="javascript:update_count('<?php echo $company_banner[0]['ban_id']; ?>')" class="mybanner img-responsive center-block">
                                                    <div class="">
                                                        <?php
                                                        echo $company_banner[0]['text_val'];
                                                        ?>
                                                    </div>
                                                </a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <br><br><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php $this->load->view('include/footer'); ?>
        <script type="text/javascript" src="<?php site_url(); ?>/assets/front/javascripts/owl.carousel.js"></script> 
        <script type="text/javascript">
                                            $(document).ready(function () {
                                                var owl = $("#owl-demo1");
                                                owl.owlCarousel({
                                                    autoPlay: 2000,
                                                    items: 6,
                                                    navigation: true,
                                                    itemsDesktop: [1000, 3],
                                                    itemsDesktopSmall: [900, 3],
                                                    itemsTablet: [600, 2],
                                                    itemsMobile: [400, 1],
                                                    stopOnHover: true
                                                });

                                                $("#demo1_next").click(function () {
                                                    owl.trigger('owl.next');
                                                });
                                                $("#demo1_prev").click(function () {
                                                    owl.trigger('owl.prev');
                                                });
                                            });

        </script>
    </body>
</html>