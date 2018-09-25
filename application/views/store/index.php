<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
        <?php $this->load->view('include/head'); ?>
        <link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>
        <style>
            .modal-header{
                background-color:#ed1b33;
                color:white;
            }
            .create_store_init_form .store_name_status{position: absolute;top: 55px;}
        </style> 
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <body  class="uesr-landing-page">
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container">
            <header class="user-header">
                <?php
                $logo_link = HTTPS . website_url . 'allstores';
                $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=2')->row_array();
                $doukani_logo = $doukani_loge_img['image_name'];
                if (empty($doukani_logo))
                    $doukani_logo = 'assets/front/images/DoukaniLogo.png';
                else
                    $doukani_logo = doukani_logo . 'original/' . $doukani_logo;
                ?>
                <div class="user-logo">
                    <a href=""><img src="<?php echo HTTPS . website_url . $doukani_logo; ?>" alt="Doukani Logo" /></a>
                </div>
                <div class="user-nav">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav store-page-nav">
                                    <li><a href="<?php echo HTTPS . website_url; ?>">HOME</a></li>
                                    <?php
                                    if (!empty($header_menu)) {
                                        foreach ($header_menu as $page) {
                                            $page_url = HTTPS . website_url . $page['slug_url'];
                                            if ($page['direct_url'] != ''){
                                                $page_url = $page['direct_url'];
                                            }
                                    ?>
                                        <li><a href="<?php echo $page_url; ?>"><?php echo strtoupper($page['page_title']); ?> </a></li>
                                    <?php
                                        }
                                    }
                                    $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
                                    $array = array('page_state' => 1, 'page_id' => 23);
                                    $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');
                                    if ($header_menu[0]['direct_url'] != '')
                                        $contact_url = $header_menu[0]['direct_url'];
                                    else
                                        $contact_url = $header_menu[0]['slug_url'];
                                    ?>
                                        <li><a href="<?php echo HTTPS . website_url . $contact_url; ?> "><?php echo strtoupper($header_menu[0]['page_title']); ?></a></li>
                                    <li>
                                        <?php
                                        if (isset($current_user) && $current_user != '') {
                                            $where = " where user_id='" . $current_user['user_id'] . "'";
                                            $user = $this->dbcommon->getrowdetails('user', $where);
                                            $profile_picture = '';
                                            $profile_picture = $this->dbcommon->load_picture($user->profile_picture, $user->facebook_id, $user->twitter_id, $user->username, $user->google_id);
                                            if ($current_user['nick_name'] != '')
                                                $m_nm = 'Welcome, ' . $current_user['nick_name'];
                                            elseif ($current_user['username'] != '')
                                                $m_nm = 'Welcome, ' . $current_user['username'];
                                            else
                                                $m_nm = '';
                                        ?>
                                        <div class="user-wrap">
                                            <div class="dropdown Welcomeuser">
                                                <a class="user-btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="<?php echo $profile_picture; ?>" class="avtar-img" alt="Profile Image" onerror="this.src='<?php echo HTTPS . website_url; ?>assets/upload/avtar.png'"/>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    <li class="user-data">
                                                        <p class="user-name"><?php echo $m_nm; ?><span class="free-ads"><?php echo $user->userAdsLeft; ?> Ads left</span></p>
                                                    </li>
                                                    <li><a href="<?php echo HTTPS . website_url; ?>user/my_listing<?php echo (isset($_REQUEST['view'])) ? '?view='.$_REQUEST['view'] : ''; ?>" tabindex="-1" role="menuitem" rel="nofollow">My Ads</a></li>
                                                    <li><a href="<?php echo HTTPS . website_url; ?>user/post_ads" tabindex="-1" role="menuitem" rel="nofollow"><i class="fa fa-plus"></i>Post Free Ad</a></li>
                                                    <li role="presentation"><a href="<?php echo HTTPS . website_url; ?>user/index" tabindex="-1" role="menuitem" rel="nofollow">My Profile</a></li>
                                                    <?php if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') { ?>
                                                    <li><a href="<?php echo HTTPS . website_url; ?>user/store" tabindex="-1" role="menuitem" rel="nofollow">My Store</a></li>
                                                    <?php
                                                    }
                                                    $my_order_path = '';
                                                    if (isset($current_user['user_role']) && $current_user['user_role'] == 'storeUser') {
                                                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser')
                                                            $my_order_path = HTTPS . website_url . 'user/orders/sold';
                                                        else
                                                            $my_order_path = HTTPS . website_url . 'user/orders/bought';
                                                    } else
                                                        $my_order_path = HTTPS . website_url . 'user/orders/bought';
                                                    ?>
                                                    <li><a href="<?php echo $my_order_path; ?>" tabindex="-1" role="menuitem" rel="nofollow">My Orders</a></li>
                                                    <li><a href="<?php echo HTTPS . website_url; ?>login/signout" tabindex="-1" role="menuitem" rel="nofollow">Sign out</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                        }else{
                                        ?>
                                        <div class="user-login-btn">
                                            <a href="javascript:void(0);" onclick="load_page();" rel="nofollow">SIGN IN</a>
                                            <span> / </span>
                                            <a href="<?php echo HTTPS . website_url; ?>registration" rel="nofollow">SIGN UP</a>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>
            </header>
            <section class="user-hero-section">
                <?php if ($this->session->flashdata('msg1')): ?>
                    <div class='alert  alert-info'>
                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                        <center><?php echo $this->session->flashdata('msg1'); ?></center>
                    </div>
                <?php endif; ?>
                <form class="create_store_init_form">
                    <input type="text" name="store_name" id="store_name" placeholder="Store Name" />
                    <button type="submit" id="create_store_btn">Create Store</button>
                    <span id="store_name_status" class="store_name_status"></span>
                </form>
                    
                <div class="user-edit-part">
                    <?php
                    echo $store_page_content;
                    ?>
<!--                    <div class="user-edit-part-l">
                        <h3>Doukani </h3>
                        <p>is a one stop platform that brings all the <br/>buyers and sellers together. </p>
                    </div>-->
                    <div class="user-edit-part-r">
                        <?php
                        if (!empty($feature_banners)) {
                            $banner_url = '';
                            if(!empty($feature_banners[0]['site_url'])){
                                if (strpos($feature_banners[0]['site_url'], 'http://') !== false || strpos($feature_banners[0]['site_url'], 'https://') !== false) {
                                    $banner_url = 'href="' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                } else {
                                    $banner_url = 'href="http://' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                }
//                                $banner_url = 'href="//' . $feature_banners[0]['site_url'] . '" target="_blank"';
                            }
                            if ($feature_banners[0]['ban_txt_img'] == 'image') {
                        ?>
                        <a <?php echo $banner_url; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" rel="nofollow"><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner"  /></a>
                        <?php
                            } elseif ($feature_banners[0]['ban_txt_img'] == 'text') {
                        ?>
                        <a <?php echo $banner_url; ?>  onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" rel="nofollow">
                        <div class="">
				<?php
				echo $feature_banners[0]['text_val'];
				?>
			</div>
                        </a>
                        <?php
                            }
                        }
                        ?>
                        <!--<img src="assets/front/images/ad-banner.jpg" alt="" />-->
                    </div>
                </div>
            </section>
            <?php if (sizeof($featured_stores) > 0) { ?>
            <section class="user-list-section">
                <h2>Featured <span>Stores</span></h2>
                <div class="user-list-section-store-wrap">
                    <div id="owl-user-list" class="owl-carousel owl-theme user-list-section-store" style="width:100%;">
                        <?php
                        foreach ($featured_stores as $fea) {
                            $store_cover_image = '';
                            $store_start = thumb_start_grid_store_cover . HTTPS . website_url;
                            $store_end = thumb_end_grid_store_cover;
                            if ($fea['store_cover_image'] != '')
                                $store_cover_image = $store_start . store_cover . "original/" . $fea['store_cover_image'] . $store_end;
                            else
                                $store_cover_image = $store_start . HTTPS . website_url . 'assets/upload/store_cover_image.png' . $store_end;
                            $profile_picture = '';
                            $profile_picture = $this->dbcommon->load_picture($fea['profile_picture'], $fea['facebook_id'], $fea['twitter_id'], $fea['username'], $fea['google_id'], 'original', 'all-store-user');
                            $store_link = HTTP . $fea['store_domain'] . after_subdomain . remove_home;
                        ?>
                        <div class="item">
                            <div class="user-list-section-store-li">
                                <div class="user-store-list-slider-img">
                                    <a href="<?php echo $store_link; ?>"><img src="<?php echo $store_cover_image; ?>" alt="" /></a>
                                </div>
                                <div class="user-store-list-slider-img-user">
                                    <span><img src="<?php echo $profile_picture; ?>" alt="Image" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"/> </span>
                                    <h6><a href="<?php echo $store_link; ?>"><?php echo $fea['store_name']; ?></a></h6>
                                </div>
                                <div class="user-store-list-slider-btn">
                                    <a href="<?php echo $store_link; ?>">Visit Store</a>
                                    <?php
                                    $btn_name = '<i class="fa fa-plus"></i> Follow';
                                    if (isset($login_userid) && $login_userid != '') {
                                        $count_array = array('user_id' => $login_userid,
                                            'seller_id' => $fea['user_id']);
                                        $is_following = $this->dbcommon->get_count('followed_seller', $count_array);
                                    } else
                                        $is_following = 0;
                                    if ($is_following > 0)
                                        $btn_name = 'Following';
                                    if (isset($login_userid)) {
                                        if ($login_userid != $fea['user_id']) {
                                        if ($btn_name == 'Following') {
                                    ?>
                                    <a href="<?php echo base_url(); ?>allstores/unfollow/<?php echo $fea['user_id']; ?>" id="following<?php echo $fea['user_id']; ?>"><?php echo $btn_name; ?></a>
                                    <?php
                                        } else {
                                            if (isset($current_user) && (sizeof($current_user) == 0) || (isset($current_user) && sizeof($current_user) > 0 && $current_user != '' && $current_user['user_id'] != $fea['user_id'])) {
                                    ?>
                                    <a href="<?php echo base_url(); ?>allstores/addfollow/<?php echo $fea['user_id']; ?>"><?php echo $btn_name; ?></a>
                                    <?php
                                            }
                                        }
                                    }else {
                                    ?>
                                    <a href="javascript:void(0);">-</a>
                                    <?php
                                    }
                                    } else {
                                    ?>
                                    <a href="<?php echo base_url(); ?>login/index"> <?php echo $btn_name; ?></a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php } ?>
        </div>
        <?php // $this->load->view('include/footer'); ?>
        <footer class=" copyright">
            <div class="container">
                <div class="row">
                    <?php $this->load->view('include/footer-bar'); ?>
                </div>
            </div>
        </footer>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/owl.carousel.js"></script>    
        <script>
            $(document).ready(function () {
                var owl = $("#owl-user-list");
                owl.owlCarousel({
                    items: 4, //10 items above 1000px browser width
                    pagination: false,
                    autoPlay: true,
                    navigation: true
                });
            });
        </script>
        <?php $this->load->view('include/footer-common-js'); ?>
    </body>
</html>