<?php

function isHTML($string) {
    if ($string != strip_tags($string)) {
        // is HTML
        return true;
    } else {
        // not HTML
        return false;
    }
}

$is_html = 0;

if (isset($_REQUEST) && !empty($_REQUEST)) {
    foreach ($_REQUEST as $k => $v) {
        if (isHTML($v)) {
            $is_html = 1;
        }
    }

    if ($is_html == 1) {
        $this->session->set_flashdata(array('err_msg' => '<font color="red">Oooops! No results found.</font>', 'class' => 'alert-danger'));
        redirect(current_url());
    }
}
?>
<header id="header" itemscope itemtype="https://schema.org/WPHeader">
    <meta itemprop="name" content="Doukani">
    <meta itemprop="description" content="Extreme offers for vehicles, real estates, electronics and other services. Buy/sell new and used products at lowest price on doukani.">
    <?php if ($this->session->flashdata('err_msg') != '') { ?>
        <div class='alert  alert-danger myerr'>
            <a class='close' data-dismiss='alert' href='#'> &times; </a>
            <?php echo $this->session->flashdata('err_msg'); ?>
        </div>
    <?php } ?>        

    <?php if ($this->session->flashdata('msg') != ''): ?>
        <div class='alert  alert-success'>
            <a class='close' data-dismiss='alert' href='#'> &times; </a>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
        <?php
    endif;

    $doukani_logo = '';
    $logo_link = '';
    if ($this->uri->segment(1) == 'home' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index') && !isset($store_page)) {
        $logo_link = HTTPS . website_url . emirate_slug;
        $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=1')->row_array();
        $doukani_logo = $doukani_loge_img['image_name'];
    } elseif (in_array('stores', array($this->uri->segment(1), $this->uri->segment(2))) ||
            in_array('store_search', array($this->uri->segment(1), $this->uri->segment(2))) ||
            ( (isset($store_page) && $store_page == 'store_page') || ($this->uri->segment(1) == 'allstores'))) {

        $logo_link = HTTPS . website_url . 'stores';

        $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=2')->row_array();
        $doukani_logo = $doukani_loge_img['image_name'];
    } elseif (in_array($this->uri->segment(1), array('alloffers', 'offers', 'companies')) || (isset($offer_detail) && $offer_detail == 'yes') || (isset($offer_company_page) && $offer_company_page == 'yes') || (isset($company_followers_page) && $company_followers_page == 'yes')) {

        $logo_link = HTTPS . website_url . 'alloffers';

        $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=3')->row_array();
        $doukani_logo = $doukani_loge_img['image_name'];
    } else {

        $logo_link = HTTPS . website_url . emirate_slug;

        $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=1')->row_array();
        $doukani_logo = $doukani_loge_img['image_name'];
    }

    if (empty($doukani_logo))
        $doukani_logo = 'assets/front/images/DoukaniLogo.png';
    else
        $doukani_logo = doukani_logo . 'original/' . $doukani_logo;
    ?>
    <?php //if (in_array($this->uri->segment(1), array('stores', 'store_search')) || in_array($this->uri->segment(2), array('stores', 'store_search')) || (isset($store_page) && in_array($store_page, array('store_page', 'store_followers_page')))) echo 'classi-sub-head'; else   ?>
    <div class="main-head <?php echo 'classi-sub-head'; ?>"  >
        <div class="logo" itemscope itemtype="https://schema.org/Organization">
            <a href="<?php echo $logo_link; ?>" style="text-decoration:none;" itemprop="url">
                <img src="<?php echo HTTPS . website_url . $doukani_logo; ?>" alt="Doukani Logo" itemprop="logo"></a>
                <!--<link href="<?php //echo HTTPS . website_url . $doukani_logo;               ?>"/>-->
            <meta itemprop="name" content="Doukani" />
        </div>
        <div class="head-action" itemscope itemtype="https://schema.org/SiteNavigationElement">
            <?php
            if (in_array($this->uri->segment(1), array('stores', 'store_search')) || in_array($this->uri->segment(2), array('stores', 'store_search')) || (isset($store_page) && in_array($store_page, array('store_page', 'store_followers_page')))) {

                if (!isset($store_page)) {
                    if (in_array($this->uri->segment(1), array('stores', 'store_search')) || in_array($this->uri->segment(2), array('stores', 'store_search'))) {
                        ?>
                        <div class="search-wrap">
                            <div class="input-group store_search">
                                <?php $this->load->view('include/search_box'); ?>
                            </div>
                        </div>
                        <?php
                    } else {
                        
                    }
                } else {
                    ?>
                    <div class="search-wrap">
                        <div class="input-group store_search">
                            <?php $this->load->view('include/search_box'); ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="search-wrap">
                    <div class="input-group store_search">
                        <?php
                        $this->load->view('include/search_box');

                        if (in_array($this->uri->segment(1), array('alloffers', 'offers', 'companies')) ||
                                (isset($offer_detail) && $offer_detail == 'yes') ||
                                (isset($offer_company_page) && $offer_company_page == 'yes') ||
                                (isset($company_followers_page) && $company_followers_page == 'yes')
                        ) {
                            
                        } else {
                            if (isset($_GET['view']) && $_GET['view'] == 'list')
                                $view_list = '?view=list';
                            elseif (isset($_GET['view']) && $_GET['view'] == 'map')
                                $view_list = '?view=map';
                            elseif (isset($_GET['view']) && $_GET['view'] == 'grid')
                                $view_list = '?view=grid';
                            else
                                $view_list = '';
                            ?>
                            <a href="<?php echo HTTPS . website_url . emirate_slug . 'advanced_search' . $view_list; ?>" class="adv-search" style="font-size:10px;" itemprop="url"><span class="plus_adv" >+</span> <span class="adv_header_lbl" itemprop="name"><b>ADVANCED SEARCH</b></span></a>
                        <?php } ?>
                    </div>
                </div>            
            <?php } ?>

            <ul class="sub-action">
                <?php
                $this->load->model('dbcommon', '', TRUE);
                $current_user = $this->session->userdata('gen_user');
                if (isset($current_user) && $current_user != '') {
                    $where = " where user_id='" . $current_user['user_id'] . "'";
                    $user = $this->dbcommon->getrowdetails('user', $where);
                    ?>
                    <li><a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Ads Left"><i class="fa fa-tags" aria-hidden="true"></i><span class="total-no"><?php echo $user->userAdsLeft; ?></span></a></li>
                    <?php
                }

                $cart_session_data = '';
                $cart_count__ = 0;
                $session_qunatity = $this->session->userdata('doukani_products');

                $_page = $this->uri->segment(1);
                $_page1 = $this->uri->segment(2);
                if ((isset($_page) && (in_array($_page, array('stores', 'store_search', 'cart')))) ||
                        (isset($_page1) && (in_array($_page1, array('stores', 'store_search', 'cart')))) ||
                        (isset($__store_page) && $__store_page == 1)) {
                    $cart_session_data = 'yes';
                    if (isset($session_qunatity) && !empty($session_qunatity)) {
                        $cart_count__ = 0;
                        $arry_ids = explode(",", $session_qunatity);
                        $concat_str = '';
                        foreach ($arry_ids as $id) {
                            $arr = explode('-', $id);
                            if (isset($arr[0]) && !empty($arr[0]) && isset($arr[1]) && !empty($arr[1]))
                                $cart_count__++;
                        }
                    } else
                        $cart_count__ = 0;
                }
                elseif ($this->session->userdata('doukani_products')) {
                    $cart_session_data = 'yes';
                    $session_qunatity = $this->session->userdata('doukani_products');
                    if (isset($session_qunatity) && !empty($session_qunatity)) {
                        $cart_count__ = 0;
                        $arry_ids = explode(",", $session_qunatity);
                        $concat_str = '';
                        foreach ($arry_ids as $id) {
                            $arr = explode('-', $id);
                            if (isset($arr[0]) && !empty($arr[0]) && isset($arr[1]) && !empty($arr[1]))
                                $cart_count__++;
                        }
                    }
                }
                elseif (isset($request_from) && in_array($request_from, array('store_page', 'search_store_page', 'store_item_details_page'))) {
                    $cart_session_data = 'yes';
                    $cart_count__ = 0;
                }

                if (isset($cart_session_data) && $cart_session_data == 'yes') {
                    ?>
                    <li><a href="<?php echo HTTPS . website_url . 'cart'; ?>" data-toggle="tooltip" data-placement="bottom" title="Cart" rel="nofollow"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="total-no"><?php echo $cart_count__; ?></span></a></li>
                <?php } else { ?>
                    <li style="display:none;" class="cart-li"><a href="<?php echo HTTPS . website_url . 'cart'; ?>" data-toggle="tooltip" data-placement="bottom" title="Cart" rel="nofollow"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="total-no"></span></a></li>
                    <?php
                }
                ?>

                <?php if ($this->session->userdata('gen_user')) { ?>
                    <li>
                        <a href="<?php echo HTTPS . website_url; ?>user/favorite" data-toggle="tooltip" data-placement="bottom" title="Favorites List" rel="nofollow"><i class="fa fa-star" aria-hidden="true"></i>
                        </a>
                    </li>                
                <?php } else { ?>
                    <li><a href="<?php echo HTTPS . website_url; ?>login/index" data-toggle="tooltip" data-placement="bottom" title="Favorites List"><i class="fa fa-star" aria-hidden="true" rel="nofollow"></i></a></li>
                <?php } ?>
            </ul>
            <?php
            if (isset($current_user) && $current_user != '') {

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
                            <li><a href="<?php echo HTTPS . website_url; ?>user/my_listing<?php echo (isset($_REQUEST['view'])) ? '?view=' . $_REQUEST['view'] : ''; ?>" tabindex="-1" role="menuitem" rel="nofollow">My Ads</a></li>
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
            <?php } else { ?>
                <div class="btn-group log-wrap" role="group" aria-label="...">
                    <a href="javascript:void(0);" onclick="load_page();" class="btn log-btn" rel="nofollow">Login</a>
                    <a href="<?php echo HTTPS . website_url; ?>registration" class="btn sign-btn" rel="nofollow" itemprop="url"><span itemprop="name">Sign up</span></a>
                </div>
            <?php } ?>
        </div>
    </div>
</header>