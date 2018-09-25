<div id="HeadertopSection"> 
    <div class="header-banner <?php echo (isset($store_home_page)) ? 'store_img_logo' : ''; ?>">
        <?php
        $header_slug = $this->uri->segment(1);
        if (in_array(strtolower($header_slug), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
            $header_slug = $this->uri->segment(2);

        $this->load->model('dbcommon', '', TRUE);
        $page_type_header = '';

        $controller = $this->router->fetch_class();
        $action = $this->router->fetch_method();

        if (isset($home_page) && $home_page == 'yes' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index') && !isset($store_page)) {
            $intro_banners = $this->dbcommon->getBanner('header', "'home_page','all_page'", null, null);
        } elseif (in_array('latest', array($this->uri->segment(1), $this->uri->segment(1)))) {
            $intro_banners = $this->dbcommon->getBanner('header', "'latest_ads_page','all_page'", null, null);
        } elseif (in_array($this->uri->segment(1), array('allstores', 'store_search')) || in_array($this->uri->segment(1), array('stores', 'store_search')) || in_array($this->uri->segment(2), array('stores', 'store_search')) || (isset($store_page) && in_array($store_page, array('store_page', 'store_followers_page')))) {

            $page_type_header = 'store';
            if (isset($request_from) && $request_from == 'store_page')
                $intro_banners = $this->dbcommon->getBanner_forCategory('header', "'store_all_page','specific_store_page'", NULL, NULL, NULL, $individual_store_id);

            elseif (isset($request_from) && in_array($request_from, array('store_item_details_page', 'search_store_page')))
                $intro_banners = $this->dbcommon->getBanner_forCategory('header', "'store_all_page','store_content_page','specific_store_page'", NULL, NULL, NULL, $individual_store_id);
            else
                $intro_banners = $this->dbcommon->getBanner('header', "'store_all_page'", null, null);
        }
        elseif (in_array($this->uri->segment(1), array('alloffers', 'offers', 'companies')) || (isset($offer_detail) && $offer_detail == 'yes') || (isset($offer_company_page) && $offer_company_page == 'yes') || (isset($company_followers_page) && $company_followers_page == 'yes')) {

            if ($this->uri->segment(1) == 'alloffers')
                $intro_banners = $this->dbcommon->getBanner('header', "'off_all_page','off_home_page'", null, null);
            elseif (in_array($this->uri->segment(1), array('offers', 'companies'))) {
                $intro_banners = $this->dbcommon->getBanner('header', "'off_all_page'", null, null);

                if (isset($_GET['cat_id'])) {
                    $cat_id = $_GET['cat_id'];
                    $intro_banners = $this->dbcommon->getBanner_forCategory('header', "'off_cat_cont','off_all_page'", $cat_id, 0);
                }
            } elseif (isset($offer_detail) && $offer_detail == 'yes')
                $intro_banners = $this->dbcommon->getBanner('header', "'off_all_page','off_catent_page'", null, null);
            elseif (isset($offer_company_page) && $offer_company_page == 'yes' && isset($company_id))
                $intro_banners = $this->dbcommon->getBanner_forCategory('header', "'off_all_page','off_comp_cont'", null, null, null, null, $company_id);
            else
                $intro_banners = $this->dbcommon->getBanner('header', "'off_all_page'", null, null);
        }
        else {
            $hcat_id = NULL;
            $hsubcat_id = NULL;

            if (isset($slug_for) && $slug_for == 'category') {

                $where_h = " category_slug = '" . $header_slug . "' ";
                $category_h = $this->dbcommon->filter('category', $where_h);

                $hcat_id = (int) $category_h[0]['category_id'];
            } elseif (isset($slug_for) && $slug_for == 'sub_category') {

                $where_h = " sub_category_slug = '" . $header_slug . "' ";
                $subcategory_h = $this->dbcommon->filter('sub_category', $where_h);
                // echo $this->db->last_query();
                $hsubcat_id = (int) $subcategory_h[0]['sub_category_id'];
                $hcat_id = (int) $subcategory_h[0]['category_id'];
            } elseif (isset($slug_for) && $slug_for == 'product') {
                $product_s = $this->dbcommon->get_product_slugwise($header_slug);
                if (sizeof($product_s) > 0) {
                    $hcat_id = $product_s->category_id;
                    $hsubcat_id = $product_s->sub_category_id;
                }
            }
            $intro_banners = $this->dbcommon->getBanner_forCategory('header', "'content_page','all_page'", $hcat_id, $hsubcat_id);
        }

        $current_user = $this->session->userdata('gen_user');
//        echo '$page_type_header:  '.$page_type_header;
//        echo '<br>$store_home_page:  '.$store_home_page;
        if (isset($page_type_header) && !empty($page_type_header) && $page_type_header == 'store') {
//            pr($current_user);
            if (isset($current_user) && $current_user != '')
                $redirect_me = HTTPS . website_url . 'user/index';
            else
                $redirect_me = HTTPS . website_url . 'registration';

            $redirect_store_registration = HTTPS . website_url . 'storeRegistration';

            if (!isset($store_home_page)) {
                //---- If user logggd in display paost ad button else store create button
                if (isset($current_user) && $current_user != '') {
                    ?>
                    <a href="<?php echo HTTPS . website_url . 'user/post_ads'; ?>" class="postaddButton" rel="nofollow">
                        <?php
                        $this->load->view('svg_html/post-ad');
                        ?>
                    </a>
                <?php } else {
                    ?>
                    <a href="<?php echo $redirect_store_registration; ?>" class="postaddButton" rel="nofollow"> 
                        <?php $this->load->view('svg_html/create-store'); ?>
                    </a>
                    <?php
                }
            } else {
                 //---- If user logggd in display paost ad button else store create button
                if (isset($current_user) && $current_user != '') {
                    ?>
                    <a href="<?php echo HTTPS . website_url . 'user/post_ads'; ?>" class="postaddButton" rel="nofollow">
                        <?php
                        $this->load->view('svg_html/post-ad');
                        ?>
                    </a>
                <?php } else {
                    ?>
                    <a href="<?php echo $redirect_store_registration; ?>" class="postaddButton" rel="nofollow">
                        <?php $this->load->view('svg_html/add-website'); ?>
                    </a> 
                <?php } ?>
            <?php } ?>
            <?php
        } elseif (in_array($this->uri->segment(1), array('alloffers', 'offers', 'companies')) || (isset($offer_detail) && $offer_detail == 'yes') || (isset($offer_company_page) && $offer_company_page == 'yes') || (isset($company_followers_page) && $company_followers_page == 'yes')) {
            $redirect_me = HTTPS . website_url . 'offers';
            ?>
            <a href="<?php echo $redirect_me; ?>" class="postaddButton" rel="nofollow">
                <?php $this->load->view('svg_html/view_all_offers'); ?>
            </a>
            <?php
        } else {
            if (isset($current_user) && $current_user != '') {
                $redirect_me = HTTPS . website_url . 'user/post_ads';
            } else
                $redirect_me = HTTPS . website_url . 'registration';
            ?>

            <a href="<?php echo $redirect_me; ?>" class="postaddButton" rel="nofollow">
                <?php
                $this->load->view('svg_html/post-ad');
                ?>
            </a>
            <?php
        }
        ?>        
        <?php
        if (!isset($store_home_page)) {
            if (!empty($intro_banners)) {
                if (isset($intro_banners[0]['ban_id']) && $intro_banners[0]['ban_id'] != '') {
                    $mycnt = $intro_banners[0]['impression_count'] + 1;
                    $array1 = array('ban_id' => $intro_banners[0]['ban_id']);
                    $data1 = array('impression_count' => $mycnt);
                    $this->dbcommon->update('custom_banner', $array1, $data1);
                }
                $banner_tag_url = '';
                if (!empty($intro_banners[0]['site_url'])) {
                    if (strpos($intro_banners[0]['site_url'], 'http://') !== false || strpos($intro_banners[0]['site_url'], 'https://') !== false) {
                        $banner_tag_url = 'href="' . $intro_banners[0]['site_url'] . '" target="_blank"';
                    } else {
                        $banner_tag_url = 'href="http://' . $intro_banners[0]['site_url'] . '" target="_blank"';
                    }
//                    $banner_tag_url = 'href="//' . $intro_banners[0]['site_url'] . '" target="_blank"';
                }
                if ($intro_banners[0]['ban_txt_img'] == 'image') {
                    ?>
                    <a <?php echo $banner_tag_url; ?> onclick="javascript:update_count('<?php echo $intro_banners[0]['ban_id']; ?>')" class="mybanner" target="_blank" rel="nofollow" id="headerbanner">                          <img src="<?php echo HTTPS . website_url; ?>assets/upload/banner/original/<?php echo $intro_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner" />
                    </a>

                <?php } elseif ($intro_banners[0]['ban_txt_img'] == 'text') {
                    ?>
                    <a <?php echo $banner_tag_url; ?> onclick="javascript:update_count('<?php echo $intro_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" id="headerbanner" style="text-decoration:none;" rel="nofollow">
                        <div class="">
                            <?php
                            echo $intro_banners[0]['text_val'];
                            ?>
                        </div>
                    </a>
                    <?php
                }
            } else {
                $current_user = $this->session->userdata('gen_user');
                if (isset($current_user) && $current_user != '') {
                    $redirect_me = HTTPS . website_url . 'user/post_ads';
                } else
                    $redirect_me = HTTPS . website_url . 'registration';
                ?>
                <a href="<?php echo $redirect_me; ?>" target="_blank" class="mybanner img-responsive center-block" id="headerbanner" style="text-decoration:none;" rel="nofollow">
                    <img src="<?php echo HTTPS . website_url; ?>assets/front/images/ad1.png" class="img-responsive center-block" alt="Banner"/>
                </a> 
                <?php
            }
        }
        else {
            $doukani_logo = '';
            $logo_link = '';
            if ($this->uri->segment(1) == 'home' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index') && !isset($store_page)) {
                $logo_link = HTTPS . website_url . emirate_slug;
                $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=1')->row_array();
                $doukani_logo = $doukani_loge_img['image_name'];
            } elseif (in_array('stores', array($this->uri->segment(1), $this->uri->segment(2))) ||
                    in_array('store_search', array($this->uri->segment(1), $this->uri->segment(2))) ||
                    (isset($store_page) && $store_page == 'store_page')) {

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
            <div class="logo" itemscope itemtype="https://schema.org/Organization">
                <a href="<?php echo $logo_link; ?>" style="text-decoration:none;" itemprop="url" class="mybanner image_logo_link" id="headerbanner">
                    <img src="<?php echo HTTPS . website_url . $doukani_logo; ?>" alt="Doukani Logo" itemprop="logo" class="img_logo"></a>
                <meta itemprop="name" content="Doukani" />
            </div>       

            <?php
        }
        ?>
    </div>
</div>