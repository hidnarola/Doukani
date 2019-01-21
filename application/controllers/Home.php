<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Extending the custom controller
class Home extends My_controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('store', '', TRUE);
        $this->load->model('dbcart', '', TRUE);
        $this->load->model('dashboard');
        $this->load->model('offer', '', TRUE);
        $this->load->library('pagination');
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('email');
        $this->load->helper('page_not_found');

        $this->per_page = 12;

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user)) {
            define("session_userid", $current_user['user_id']);
        } else
            define("session_userid", '');

        $emirate = $this->uri->segment(1);
        if (empty($emirate))
            $this->session->unset_userdata('request_for_statewise');

        if (!empty($emirate) && in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $this->session->set_userdata('request_for_statewise', $emirate);
            $emirate = $this->session->userdata('request_for_statewise');
        } elseif (isset($_REQUEST['state_id_selection']))
            $emirate = $_REQUEST['state_id_selection'];
        elseif ($this->session->userdata('request_for_statewise') != '') {
            $emirate = $this->session->userdata('request_for_statewise');
        }

        if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
            define("emirate_slug", $emirate . '/');
        else
            define("emirate_slug", '');
    }

    /**
     * function to load the home page.
     */
    public function index($slug = NULL, $load_data = NULL) {


        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user)) {
            $ret_repsonse = $this->dbcommon->select('order_success_msg where user_id=' . $current_user['user_id']);
            if (isset($ret_repsonse) && !empty($ret_repsonse) && isset($current_user)) {
                header("Location:" . HTTPS . doukani_website . 'cart/success');
            }
        }
        $slug = strtolower($slug);
        $first_name = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], "."));

        $full_url = $this->full_url();
        $seg1 = $this->uri->segment(1);
        $seg2 = $this->uri->segment(2);

        if ($_SERVER['HTTP_HOST'] == $full_url) {

            if ($slug != NULL && !in_array(strtolower($seg1), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
                $get_char = strstr($slug, '_', true);
                $return_res = $this->db->query('(select "prod_slug" AS val from product where product_slug = "' . $slug . '")');
                $return_data = $return_res->row();

                if (!empty($return_data) && $return_data->val == 'prod_slug') {
                    $this->item_details($slug, 'store');
                } elseif ($this->uri->segment(1) != '') {
                    $this->seller_followers(NULL, $slug, $first_name);
                } else {
                    override_404();
                }
            } else {
                $where = " where store_domain ='" . $first_name . "' and store_status in (0,3)";
                $store = $this->dbcommon->getdetails('store', $where);
                if (sizeof($store) > 0) {

                    if ($this->uri->segment(2) == 'search')
                        $this->search();
                    else
                        $this->individual_store($first_name, $store);
                }
                else {
                    override_404();
                }
            }
        } else {

            $data = array();
            $data = array_merge($data, $this->get_elements());
            if (($slug == NULL || in_array(strtolower($seg1), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) && ($seg2 == NULL || $seg2 == "followers")) {

                if ($this->uri->segment(1) != '' && $this->uri->segment(2) != '') {

                    $this->seller_followers($this->uri->segment(1), $this->uri->segment(2));
                } else {

                    // getting the banners for home page - in most viewds page
                    $between_banners = $this->dbcommon->getBanner_forCategory('between', "'bw_home_page_ban2','all_page'", null, null);
                    $data['between_banners'] = $between_banners;

                    //after slider
                    $between_banners1 = $this->dbcommon->getBanner_forCategory('between', "'bw_home_page_ban1','all_page'", null, null);
                    $data['between_banners1'] = $between_banners1;

                    $feature_banners = $this->dbcommon->getBanner_forCategory('sidebar', "'home_page','all_page'", null, null);
                    $data['feature_banners'] = $feature_banners;

                    if (isset($feature_banners[0]['ban_id']) && $feature_banners[0]['ban_id'] != '') {
                        $mycnt = $feature_banners[0]['impression_count'] + 1;
                        $array1 = array('ban_id' => $feature_banners[0]['ban_id']);
                        $data1 = array('impression_count' => $mycnt);
                        $this->dbcommon->update('custom_banner', $array1, $data1);
                    }

                    $product = $this->dbcommon->get_products(12);
                    $data['latest_product'] = $product;

                    $featured_product = $this->dbcommon->get_featured_ads(null, 12);
                    $data['f_products'] = $featured_product;

                    // functionality for loading more products
                    $total_product = $this->dbcommon->get_products_count();
                    $data['hide'] = "false";
                    if ($total_product <= 12) {
                        $data['hide'] = "true";
                    } else
                        $data['load_data'] = 'yes';

                    $start = 0;
                    $most_viewed_product = $this->dbcommon->get_most_viewed_products($start);

                    $data['products'] = $most_viewed_product;
                    $data['home_page'] = 'yes';
                    $data['product_page'] = 'yes';
                    $data['page_title'] = 'Free Local Classifieds Ads from all over UAE - Doukani';

                    $current_user = $this->session->userdata('gen_user');
                    if ($current_user)
                        $user_id = $current_user['user_id'];
                    $data['is_logged'] = 0;
                    $data['loggedin_user'] = '';
                    if ($this->session->userdata('gen_user')) {
                        $current_user = $this->session->userdata('gen_user');
                        $data['loggedin_user'] = $current_user['user_id'];
                        $data['is_logged'] = 1;
                    }

                    $data['seo'] = [
                        'description' => 'Extreme offers for vehicles, real estates, electronics and other services. Buy/sell new and used products at lowest price on doukani.',
                        'keyword' => 'vehicles, electronics, services,lowest, clasified, doukani, buy sell, Jobs,  Realestate'
                    ];

                    $this->load->view('home/index', $data);
                }
            } else {

                $not_found = 0;
                if (in_array(strtolower($seg1), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
                    if ($seg2 == 'featured_ads') {
                        $not_found = 1;
                        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
                            $this->get_featured_ads_map();
                        else
                            $this->get_featured_ads();
                    }
                    elseif ($seg2 == 'categories') {
                        $not_found = 1;
                        $this->categories();
                    } elseif ($seg2 == 'latest') {
                        $not_found = 1;
                        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
                            $this->latest_ads_map();
                        else
                            $this->latest_ads();
                    }
                    elseif ($seg2 == 'search') {
                        $not_found = 1;

                        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
                            $this->search_map();
                        else
                            $this->search();
                    }
                    elseif ($seg2 == 'advanced_search') {
                        $not_found = 1;
                        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
                            $this->advanced_search_map();
                        else
                            $this->advanced_search();
                    }

                    $slug = $seg2;
                } else
                    $slug = $seg1;

                $return_res = $this->db->query('(select "cat_slug" AS val from category where category_slug = "' . $slug . '" AND FIND_IN_SET(0, category_type) > 0) UNION (select "sub_cat_slug" AS val from sub_category where sub_category_slug = "' . $slug . '" AND FIND_IN_SET(0, sub_category_type) > 0) UNION (select "selleruser_slug" AS val from user where user_slug = "' . $slug . '") UNION  (select "prod_slug" AS val from product where product_slug = "' . $slug . '")');
                $return_data = $return_res->row();

                if (isset($return_data->val)) {
                    if (isset($_GET['view']) && $_GET['view'] == 'map' && ($return_data->val == 'cat_slug' || $return_data->val == 'sub_cat_slug'))
                        $this->category_map($slug, $return_data->val, strtolower($seg1));
                    elseif ($return_data->val == 'cat_slug' || $return_data->val == 'sub_cat_slug')
                        $this->category($slug, $return_data->val, strtolower($seg1));
                    elseif ($return_data->val == 'selleruser_slug') {
                        $offer_name = $this->uri->segment(2);

                        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
                            $this->seller_listings_map($slug, $offer_name);
                        else
                            $this->seller_listings($slug, $offer_name);
                    }
                    elseif ($return_data->val == 'prod_slug')
                        $this->item_details($slug);
                    else {
                        override_404();
                    }
                } else {
                    if ($not_found != 1)
                        override_404();
                }
            }
        }
    }

    /**
     * function to load sub categories using ajax
     */
    public function show_sub_cat() {
        $filter_val = $this->input->post("value");

//        $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(0, sub_category_type) > 0";
        $query = "category_id= '" . $filter_val . "' ORDER BY sub_cat_order ASC";
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);
        $main_data = array_merge($main_data, $this->get_elements());
        echo $this->load->view('include/sub_cat', $main_data, TRUE);
        exit();
    }

    /**
     * function to load more products using ajax
     */
    public function show_more_product() {

        $filter_val = $this->input->post("value");
        $req_numItems = $this->input->post('req_numItems');
        if (isset($filter_val) && isset($req_numItems)) {

            $total_product = $this->dbcommon->get_products_count();
            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";
            if ($end >= $total_product) {
                $hide = "true";
            }

            $most_viewed_product = $this->dbcommon->get_most_viewed_products($start);
            $data['products'] = $most_viewed_product;

            $arr = array();
            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            $data['req_numItems'] = $req_numItems;
            $data['display_limit'] = 60;
            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'bw_home_page_ban2','all_page'", null, null);
            $data['between_banners'] = $between_banners;
            $data['home_page'] = 'yes';
            $arr["html"] = $this->load->view('home/product_grid_view', $data, TRUE);
            $arr["val"] = $hide;

            $show_button = true;
            if (($data['req_numItems'] + 12) > 60) {
                $show_button = false;
            }
            $arr["val"] = $hide;
            $arr["show_button"] = $show_button;

            echo json_encode($arr);
            exit();
        } else {
            override_404();
        }
    }

    //public function category($cat_id = null, $subcat_id = null) {
    public function category($slug = NULL, $cat_or_subcat = NULL, $emirate_sel = NULL) {

        $data = array();
        $data = array_merge($data, $this->get_elements());

        if (isset($_GET['s']))
            $data['search_value'] = $_GET['s'];

        $cat_id = NULL;
        $subcat_id = NULL;
        $data['product_page'] = 'yes';
        $data['slug'] = $slug;
        $data['slug_for'] = '';
        $display_success = 0;

        if ($cat_or_subcat == 'cat_slug') {

            $data['slug_for'] = 'category';
            $where = " category_slug = '" . $slug . "' ";
            $category = $this->dbcommon->filter('category', $where);

            if (sizeof($category) > 0) {
                $cat_id = (int) $category[0]['category_id'];
                $subcat_id = NULL;
                $seo_title = $cat_name = $category[0]['catagory_name'];
                $data['category_description'] = $category[0]['description'];
                $data['category_name'] = $category[0]['catagory_name'];
                $data['category_icon'] = $category[0]['icon'];
                $data['category_slug'] = $category[0]['category_slug'];

                $data['meta_title'] = $category[0]['meta_title'];
                $data['meta_description'] = $category[0]['meta_description'];
                $data['meta_keywords'] = $category[0]['meta_keywords'];

                $display_success = 1;
            } else {
                override_404();
            }
        } elseif ($cat_or_subcat == 'sub_cat_slug') {

            $data['slug_for'] = 'sub_category';
            $where = " sub_category_slug = '" . $slug . "' ";
            $subcategory = $this->dbcommon->filter('sub_category', $where);

            if (sizeof($subcategory) > 0) {
                $cat_id = (int) $subcategory[0]['category_id'];
                $subcat_id = (int) $subcategory[0]['sub_category_id'];

                $seo_title = $data['subcat_name'] = $subcategory[0]['sub_category_name'];

                $array = array(
                    'sub_category_id' => $subcat_id,
                    'product.product_is_inappropriate' => 'Approve',
                    'product.product_deactivate' => null,
                    'is_delete' => 0,
                    'product_for' => 'classified'
                );

//                if ($this->session->userdata('request_for_statewise') != '')                
                if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                    $array['state_id'] = $this->dbcommon->state_id($emirate_sel);

                $total = $this->dashboard->get_specific_count('product', $array);
                $data['subcat_total'] = $total;

                $where = " category_id = '" . $subcategory[0]['category_id'] . "' ";
                $category = $this->dbcommon->filter('category', $where);

                $data['category_icon'] = $category[0]['icon'];
                $data['sub_category_description'] = $subcategory[0]['description'];
                $data['category_name'] = $subcategory[0]['sub_category_name'];

                $data['meta_title'] = $subcategory[0]['meta_title'];
                $data['meta_description'] = $subcategory[0]['meta_description'];
                $data['meta_keywords'] = $subcategory[0]['meta_keywords'];

                $display_success = 1;
            } else {
                override_404();
            }
        }

        if ($display_success == 1) {
            $data['category_id'] = $cat_id;
            $data['subcat_id'] = $subcat_id;

            $query = "category_id= '" . $cat_id . "' AND FIND_IN_SET(0, sub_category_type) > 0 order by sub_cat_order asc";
            $subcat = $this->dbcommon->filter('sub_category', $query);

            // functionality to show the list of sub categoried after the breadcrumb
            $subcatArr = array();
            $i = 0;

            $seo_cate_list = '';

            foreach ($subcat as $sub) {
                $seo_cate_list .= $sub["sub_category_name"] . ', ';
                $subcatArr[$i]["id"] = $sub["sub_category_id"];
                $subcatArr[$i]["name"] = $sub["sub_category_name"];
                $subcatArr[$i]["sub_category_slug"] = $sub["sub_category_slug"];

                $array = array(
                    'sub_category_id' => $sub["sub_category_id"],
                    'product.product_is_inappropriate' => 'Approve',
                    'product.product_deactivate' => null,
                    'is_delete' => 0,
                    'product_for' => 'classified'
                );

//                if ($this->session->userdata('request_for_statewise') != '')
                if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                    $array['state_id'] = $this->dbcommon->state_id($emirate_sel);

                $total = $this->dashboard->get_specific_count('product', $array);

                $subcatArr[$i]["total"] = $total;
                $i++;
            }
            $data['subcat'] = $subcatArr;

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", $cat_id, $subcat_id);
            $data['between_banners'] = $between_banners;

//            if (isset($_GET['view']) && $_GET['view'] == 'list') {
//                // checking if the category is vehicle or real estate
//                if ($cat_id == 7)
//                    $product = $this->dbcommon->get_vehicle_products($cat_id, $subcat_id, null, 12);
//                elseif ($cat_id == 8)
//                    $product = $this->dbcommon->get_real_estate_products($cat_id, $subcat_id, null, 12);
//                else
//                    $product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, null, 12);
//            } else
//                $product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, null, 12);

            if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {
                $product = $this->dbcommon->get_my_listing(NULL, 0, 12, NULL, NULL, NULL, NULL, $cat_id, $subcat_id);
                $total_product = $this->dbcommon->get_my_listing_count(NULL, NULL, NULL, NULL, NULL, $cat_id, $subcat_id);
            } else {
                $product = $this->dbcommon->get_my_listing(NULL, 0, 12, NULL, NULL, 'generalUser', NULL, $cat_id, $subcat_id);
                $total_product = $this->dbcommon->get_my_listing_count(NULL, NULL, NULL, 'generalUser', NULL, $cat_id, $subcat_id);
            }
            $data['products'] = $product;
            
//            $total_product = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);
            // functionality for load more product
            $data['hide'] = "false";
            if ($total_product <= 12) {
                $data['hide'] = "true";
            } else
                $data['load_data'] = 'yes';

//            $data['total'] = $total;
            $data['total'] = $total_product;

            $data['category_id'] = $cat_id;
            $data['sub_category_id'] = $subcat_id;

            $order_option = '';
            $view = '';
            if ((isset($_GET['view']) && $_GET['view'] == 'list') || (isset($_GET['view']) && $_GET['view'] == 'grid')) {
                $sign = '&';
                $view = '?view=' . $_GET['view'];
            } else
                $sign = '?';
            if (isset($_REQUEST['order']))
                $order_option = $sign . 'order=' . $_REQUEST['order'];

            $data['order_option'] = $order_option;
            $data['category_view'] = $view;
            //print_r($data['page_title']);
            if (isset($_GET['view']) && $_GET['view'] == 'grid')
                $linkk = '/?view=grid';
            elseif (isset($_GET['view']) && $_GET['view'] == 'list')
                $linkk = '/?view=list';
            else
                $linkk = '';

            $breadcrumb = array(
                'Home' => base_url(),
                $category[0]['catagory_name'] => 'javascript:void(0);',
            );

            $emirate = $this->uri->segment(1);

            if ($subcat_id != null) {
                $breadcrumb = array(
                    'Home' => base_url(),
                    $category[0]['catagory_name'] => base_url() . emirate_slug . $category[0]['category_slug'] . $linkk,
                    $subcategory[0]['sub_category_name'] => 'javascript:void(0);'
                );
            }

            $data['breadcrumbs'] = $breadcrumb;
            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            if (in_array($data['slug_for'], array('category', 'sub_category'))) {

                if (empty($data['meta_title']))
                    $meta_title = $seo_title;
                else
                    $meta_title = $data['meta_title'];

                if (empty($data['meta_description']))
                    $meta_description = 'In ' . $seo_title . ' catagory  you can buy ' . trim($seo_cate_list, ', ') . ' at lowest price on doukani';
                else
                    $meta_description = $data['meta_description'];

                if (empty($data['meta_keywords']))
                    $meta_keywords = $seo_cate_list . 'catagory, clasified, doukani';
                else
                    $meta_keywords = $data['meta_description'];

                $data['seo'] = [
                    'title' => $meta_title,
                    'description' => $meta_description,
                    'keyword' => $meta_keywords
                ];
            }
            else {
                $meta_title = $seo_title;
                $meta_description = 'In ' . $seo_title . ' catagory  you can buy ' . trim($seo_cate_list, ', ') . ' at lowest price on doukani';
                $meta_keywords = $seo_cate_list . 'catagory, clasified, doukani';

                $data['seo'] = [
                    'title' => $meta_title,
                    'description' => $meta_description,
                    'keyword' => $meta_keywords
                ];
            }

            $data['page_title'] = $meta_title;
            $data['total'] = $total_product;
            $this->load->view('home/category_listing', $data);
        } else {
            override_404();
        }
    }

    //serach from left menu at Front End or find product from store	
    public function search() {

        $data = array();
        $data = array_merge($data, $this->get_elements());

        $data['slug'] = 'search';
        $data['is_logged'] = 0;
        $data['login_username'] = null;
        $data['current_user'] = '';
        $data['loggedin_user'] = '';
        $data['product_page'] = 'yes';
        $currentusr = $this->session->userdata('gen_user');
        $data['currentusr'] = $currentusr;

        $current_user = $this->session->userdata('gen_user');
        if ($this->session->userdata('gen_user')) {
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
            $logged_in_user = $current_user['username'];
            $data['login_username'] = $logged_in_user;
            $data['loggedin_user'] = $current_user['user_id'];
        }

        $cat_id = $this->input->get_post("cat", TRUE);
        $sub_cat_id = $this->input->get_post("sub_cat", TRUE);
        $data['select_sub_cat_id'] = $sub_cat_id;
        $city_id = $this->input->get_post("city", TRUE);
        $location = $this->input->get_post("location", TRUE);
        $min_amount = $this->input->get_post("min_amount", TRUE);
        $max_amount = $this->input->get_post("max_amount", TRUE);
        //$this->load->library("security");
        $search_value = $this->input->get_post("s");
        //$search_value = $this->security->xss_clean($this->input->get_post("s"));

        $str = explode('==', $this->dbcommon->search_query($cat_id, $sub_cat_id, $city_id, $location, $min_amount, $max_amount, $search_value));
        $where = $str[1];
        $query1 = $str[0];
        $query = $str[0];

        $first_name = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], "."));
        $full_url = $this->full_url();
        $user_status = 0;
        if ($_SERVER['HTTP_HOST'] == $full_url) {

            $where_st = " where store_domain ='" . $first_name . "' and store_status in (0,3)";
            $store = $this->dbcommon->getdetails('store', $where_st);

            if (!empty($store)) {
                $current_user = $this->session->userdata('gen_user');
                $user_status = 0;
                if ($store[0]->store_status == 0)
                    $user_status = 0;
                elseif ($store[0]->store_status == 3 && isset($current_user) && $current_user['user_id'] == $store[0]->store_owner)
                    $user_status = 1;
                elseif ($store[0]->store_status == 0 && $store[0]->store_is_inappropriate == 'Approve')
                    $user_status = 1;
                $data['user_status'] = $user_status;

                $between_banners = $this->dbcommon->getBanner_forCategory('between', "'store_all_page','specific_store_page'", NULL, NULL, NULL, $store[0]->store_id);
                $data['between_banners'] = $between_banners;

                $data['store_url'] = HTTP . $store[0]->store_domain . after_subdomain . '/';
                $result_store_detail = $this->store_common_details($store, $currentusr);
                $data = array_merge($data, $result_store_detail);

                if ($store[0]->store_status == 0 && $store[0]->store_is_inappropriate == 'Approve')
                    $user_status = 0;
                else
                    header("Location:" . HTTPS . doukani_website);

                $data['store_page'] = 'store_page';
                $data['request_from'] = 'search_store_page';
                $data['individual_store_id'] = $store[0]->store_id;

                $state_str = '';
                if (in_array($this->uri->segment(1), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                    $state_str = ' and state_id= ' . $this->dbcommon->state_id($this->uri->segment(1));

                $query1 .= $where . ' and product_for="store" and product_posted_by=' . $store[0]->store_owner . $state_str . ' group by p.product_id';

                $prod = $this->db->query($query1);
                $total_product = $prod->num_rows($prod);

                $where .= " and product_for='store' group by p.product_id";
                $where .= " order by product_posted_time desc limit 0,15";

                $query .= ' and product_posted_by=' . $store[0]->store_owner . ' ' . $where;

                $product = $this->dbcommon->get_distinct($query);

                $data['listing'] = $product;
                $data['hide'] = "false";

                if ($total_product <= 15) {
                    $data['hide'] = "true";
                } else
                    $data['load_data'] = 'yes';

                $data['page_title'] = $total_product . ' Ads found';
                $this->load->view('store/search_store_products', $data);
            } else {
                override_404();
            }
        } else {

            if ($cat_id != "0" && $cat_id != '') {
//                $where1 = " category_id = $cat_id AND FIND_IN_SET(0, category_type) > 0";
                $where1 = " category_id = $cat_id";
                $category = $this->dbcommon->filter('category', $where1);
                $data['category_name'] = $category[0]['catagory_name'];

//                $where1 = " category_id = $cat_id AND FIND_IN_SET(0, sub_category_type) > 0";
                $where1 = " category_id = $cat_id";
                $data['sub_category'] = $this->dbcommon->filter('sub_category', $where1);
            }

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", null, null);
            $data['between_banners'] = $between_banners;

            $query1 .= $where . ' and p.product_for IN("classified", "store") group by p.product_id';

            $prod = $this->db->query($query1);

            $total_product = $prod->num_rows($prod);

            $where .= " and p.product_for IN('classified', 'store') group by p.product_id";
            $where .= " order by featured_ad desc,product_posted_time desc limit 0,12";

            $query .= $where;
            $product = $this->dbcommon->get_distinct($query);

            $data['products'] = $product;
            $data['hide'] = "false";
            if ($total_product <= 12) {
                $data['hide'] = "true";
            } else
                $data['load_data'] = 'yes';

            $data['page_title'] = $total_product . ' Ads found';

            $__catagory_list = [];

//            $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
            $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
            $data['category1'] = $category;

            foreach ($data['category1'] as $a => $b) {
                $__catagory_list[] = $b['catagory_name'];
            }

            $seo_catagory = implode(',', $__catagory_list);
            $seo_catagory = preg_replace('/\s+/', ' ', $seo_catagory);

            $__keywords = explode(' ', $seo_catagory);

            foreach ($__keywords as $a => $b) {
                $__keywords[$a] = trim(trim($b, ' '), ',');

                if (strlen($b) < 3 || in_array($b, ['and', 'then', 'than', 'from'])) {
                    unset($__keywords[$a]);
                }
            }

            $data['seo'] = [
                'description' => 'Search best products from catagory like ' . $seo_catagory . ' at doukani',
                'keyword' => implode(', ', $__keywords) . ' classified, store, doukani, search'
            ];

            $this->load->view('home/search', $data);
        }
    }

    public function search_map() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['slug'] = 'search';
        $data['is_logged'] = 0;
        $data['login_username'] = null;
        $data['current_user'] = '';
        $data['loggedin_user'] = '';
        $data['product_page'] = 'yes';
        $currentusr = $this->session->userdata('gen_user');
        $data['currentusr'] = $currentusr;

        $current_user = $this->session->userdata('gen_user');
        if ($this->session->userdata('gen_user')) {
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
            $logged_in_user = $current_user['username'];
            $data['login_username'] = $logged_in_user;
            $data['loggedin_user'] = $current_user['user_id'];
        }

        $cat_id = $this->input->get_post("cat");
        $sub_cat_id = $this->input->get_post("sub_cat");
        $city_id = $this->input->get_post("city");
        $location = $this->input->get_post("location");
        $min_amount = $this->input->get_post("min_amount");
        $max_amount = $this->input->get_post("max_amount");
        $search_value = $this->input->get_post("s");

        $str = explode('==', $this->dbcommon->search_query($cat_id, $sub_cat_id, $city_id, $location, $min_amount, $max_amount, $search_value));

        $where = $str[1];
        $query1 = $str[0];
        $query = $str[0];

        $query1 .= $where . ' and product_for IN("classified", "store") group by p.product_id';

        $prod = $this->db->query($query1);
        $total_product = $prod->num_rows($prod);

        $emirate_sel = $this->uri->segment(1);
//        if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
//            $url = base_url() . $emirate_sel . '/' . $_SERVER['REQUEST_URI'];
//        else
        $url = base_url() . $_SERVER['REQUEST_URI'];

        if (isset($_REQUEST['page'])) {
            $url = str_replace('?page=' . $_REQUEST['page'], '', $url);
            $url = str_replace('&page=' . $_REQUEST['page'], '', $url);
        }
        $config = $this->dbcommon->pagination_front($total_product, $url);
        $this->pagination->initialize($config);
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];
        $data["links"] = $this->pagination->create_links();

        $where .= " and product_for IN('classified', 'store') group by product_id";
        $where .= " order by featured_ad desc,product_posted_time desc limit " . $offset . "," . $config["per_page"];

        $query .= $where;
        $product = $this->dbcommon->get_distinct($query);
        $data['products'] = $product;

        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        } else
            $data['load_data'] = 'yes';

        $data['page_title'] = $total_product . ' Ads found';

        $__catagory_list = [];

//        $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
        $data['category1'] = $category;

        foreach ($data['category1'] as $a => $b) {
            $__catagory_list[] = $b['catagory_name'];
        }

        $seo_catagory = implode(',', $__catagory_list);
        $seo_catagory = preg_replace('/\s+/', ' ', $seo_catagory);

        $__keywords = explode(' ', $seo_catagory);

        foreach ($__keywords as $a => $b) {
            $__keywords[$a] = trim(trim($b, ' '), ',');

            if (strlen($b) < 3 || in_array($b, ['and', 'then', 'than', 'from'])) {
                unset($__keywords[$a]);
            }
        }

        $data['seo'] = [
            'description' => 'Search best products from catagory like ' . $seo_catagory . ' at doukani',
            'keyword' => implode(', ', $__keywords) . ' classified, store, doukani, search'
        ];

        $this->load->view('home/category_map', $data);
    }

    //load search products using ajax
    public function more_search() {

        $current_user = $this->session->userdata('gen_user');

        $cat_id = $this->input->get_post("cat1");
        $sub_cat_id = $this->input->get_post("sub_cat1");
        $city_id = $this->input->get_post("city1");
        $location = $this->input->get_post("location");
        $min_amount = $this->input->get_post("min_amount1");
        $max_amount = $this->input->get_post("max_amount1");
        $search_value = $this->input->get_post("search_value1");

        $more_str = explode('==', $this->dbcommon->search_query($cat_id, $sub_cat_id, $city_id, $location, $min_amount, $max_amount, $search_value));
        $where = $more_str[1];
        $query1 = $more_str[0];
        $query = $more_str[0];

        $currentusr = $this->session->userdata('gen_user');
        $data['currentusr'] = $currentusr;

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $data['page_title'] = 'Search Results';

        $full_url = $this->full_url();
        $first_name = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], "."));

        if ($_SERVER['HTTP_HOST'] == $full_url) {

            $where_st = " where store_domain ='" . $first_name . "' and store_status=0 and store_is_inappropriate='Approve'";
            $store = $this->dbcommon->getdetails('store', $where_st);

            if (!empty($store)) {

                $current_user = $this->session->userdata('gen_user');
                $user_status = 0;
                if ($store[0]->store_status == 0)
                    $user_status = 0;
                elseif ($store[0]->store_status == 3 && isset($current_user) && $current_user['user_id'] == $store[0]->store_owner)
                    $user_status = 1;
                elseif ($store[0]->store_status == 0 && $store[0]->store_is_inappropriate == 'Approve')
                    $user_status = 1;
                $data['user_status'] = $user_status;

                $between_banners = $this->dbcommon->getBanner_forCategory('between', "'store_all_page','specific_store_page'", NULL, NULL, NULL, $store[0]->store_id);
                $data['between_banners'] = $between_banners;

                $data['store_url'] = HTTP . $store[0]->store_domain . after_subdomain . '/';
                $filter_val = $this->input->get_post("value");
                $start = 15 * $filter_val;
                $end = $start + 15;
                $hide = "false";

                $data['store'] = $store;
                $where_store = " where user_id ='" . $store[0]->store_owner . "' and  is_delete=0 and status='active'";
                $store_user = $this->dbcommon->getdetails('user', $where_store);
                $data['store_user'] = $store_user;

                $query_cnt = " product_id from product where product_posted_by='" . $store[0]->store_owner . "' and is_delete=0 and product_deactivate IS NULL and product_for = 'store' and product_is_inappropriate='Approve'";
                $count_no_of_post = $this->dbcommon->getnumofdetails_($query_cnt);
                $data['count_no_of_post'] = $count_no_of_post;

                $share_url = '';
                if (isset($store[0]->store_cover_image) && $store[0]->store_cover_image != '') {
                    $share_url = base_url() . store_cover . 'medium/' . $store[0]->store_cover_image;
                }

                $data['share_url'] = $share_url;

                $data['store_page'] = 'store_page';
                $query1 .= $where . ' and product_for = "store" and product_posted_by=' . $store[0]->store_owner . ' group by p.product_id';

                $prod = $this->db->query($query1);
                $total_product = $prod->num_rows($prod);

                $where .= " and product_for ='store'  group by p.product_id";
                $where .= " order by `product_posted_time` desc limit " . $start . ",15";

                $query .= ' and product_posted_by=' . $store[0]->store_owner . ' ' . $where;

                $product = $this->dbcommon->get_distinct($query);

                $data['product'] = $product;
                $data['hide'] = "false";

                if ($total_product <= 15) {
                    $data['hide'] = "true";
                }

                $data['is_following'] = 0;
                $count_array = array('user_id' => $currentusr['user_id'],
                    'seller_id' => $store_user[0]->user_id);

                $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
                $data['is_following'] = $following_count;

                if (isset($store[0]->store_approved_on) && !empty($store[0]->store_approved_on))
                    $app_date = $store[0]->store_approved_on;
                else
                    $app_date = $store[0]->store_created_on;

                $store_user_regidate = $this->dbcommon->dateDiff(date('y-m-d H:i:s'), $app_date);
                $data['store_user_regidate'] = $store_user_regidate;

                $data['page_title'] = $total_product . ' Ads found';
                $data['listing'] = $product;
                $data['hide'] = "false";

                if ($end >= $total_product) {
                    $hide = "true";
                }
                $data["val"] = $hide;

                if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                    $data["html"] = $this->load->view('store/store_product_list_view', $data, TRUE);
                else
                    $data["html"] = $this->load->view('store/product_store_grid_view', $data, TRUE);
                echo json_encode($data);
                exit();
            } else {
                override_404();
            }
        } else {

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", null, null);
            $data['between_banners'] = $between_banners;

            $filter_val = $this->input->get_post("value");
            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";

            $query1 .= $where . ' and p.product_for IN("classified", "store") group by p.product_id';

            $prod = $this->db->query($query1);
            $total_product = $prod->num_rows($prod);

            $where .= " and p.product_for IN('classified', 'store')  group by p.product_id";
            $where .= " order by featured_ad desc,product_posted_time desc limit " . $start . ",12";

            $query .= ' ' . $where;

            $product = $this->dbcommon->get_distinct($query);
            $data['products'] = $product;

            $data['hide'] = "false";
            if ($end >= $total_product) {
                $hide = "true";
            }
            $data["val"] = $hide;
            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                $data["html"] = $this->load->view('home/product_listing_view', $data, TRUE);
            else
                $data["html"] = $this->load->view('home/product_grid_view', $data, TRUE);
            echo json_encode($data);
            exit();
        }
    }

    public function advanced_search() {

        $data = array();
        $arr = array_merge($data, $this->get_elements());
        $data['product_page'] = 'yes';
        $data['slug'] = 'advanced_search';

        $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", null, null);
        $data['between_banners'] = $between_banners;

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        $current_user = $this->session->userdata('gen_user');
        if ($this->session->userdata('gen_user')) {
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        //$location = $this->dbcommon->select('country');
        $location = $this->dbcommon->select_orderby('country', 'country_name', 'asc');
        $data['location'] = $location;

        $brand = $this->dbcommon->getbrandlist();
        $data['brand'] = $brand;

        $mileage = $this->dbcommon->getmileagelist();
        $data['mileage'] = $mileage;

        $colors = $this->dbcommon->getcolorlist();
        $data['colors'] = $colors;

        $plate_source = $this->dbcommon->select('plate_source');
        $data['plate_source'] = $plate_source;

        $plate_digit = $this->dbcommon->select('plate_digit');
        $data['plate_digit'] = $plate_digit;

        $where = 'num_for="plate"';
        $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
        $data['repeating_numbers_car'] = $repeating_numbers;

        $where = 'num_for="mobile"';
        $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
        $data['repeating_numbers_mobile'] = $repeating_numbers;

        $plate_digit_mobile = $this->dbcommon->select('plate_digit');
        $data['plate_digit_mobile'] = $plate_digit_mobile;

        $mobile_operators = $this->dbcommon->select('mobile_operators');
        $data['mobile_operators'] = $mobile_operators;

        $data = array_merge($data, $this->get_elements());

        $__catagory_list = [];

//        $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
        $data['category1'] = $category;

        foreach ($data['category1'] as $a => $b) {
            $__catagory_list[] = $b['catagory_name'];
        }

        $seo_catagory = implode(',', $__catagory_list);
        $seo_catagory = preg_replace('/\s+/', ' ', $seo_catagory);

        $__keywords = explode(' ', $seo_catagory);

        foreach ($__keywords as $a => $b) {
            $__keywords[$a] = trim(trim($b, ' '), ',');

            if (strlen($b) < 3 || in_array($b, ['and', 'then', 'than', 'from'])) {
                unset($__keywords[$a]);
            }
        }

        $data['seo'] = [
            'description' => 'Search best products from catagory like ' . $seo_catagory . ' at doukani',
            'keyword' => implode(', ', $__keywords) . ' store, classified, doukani, search'
        ];

        $where = '';
        $data['page_title'] = 'Advanced Search';
        if (isset($_REQUEST['default']) || isset($_REQUEST['vehicle_submit']) || isset($_REQUEST['real_estate_submit']) || isset($_REQUEST['shared_submit']) || isset($_REQUEST['car_number_submit']) || isset($_REQUEST['mobile_number_submit'])) {

            $start = 0;
            $limit = 12;

            $where .= $this->dbcommon->get_data_advanced($start, $limit);
            $where .= " group by p.product_id";

            $like_fav_sql = '';
            $like_fav_field = '';
            if (isset($current_user) && !empty($current_user)) {
                $like_fav_sql = ' left join like_product lp on  lp.product_id = p.product_id left join favourite_product fp on fp.product_id = p.product_id ';

                $like_fav_field = ' ,if(lp.product_id=p.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=p.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite ';
            }

            $sql_list = '';
            $field_list = '';
            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
                $sql_list = 'left join product_realestate_extras on product_realestate_extras.product_id = p.product_id
		left join product_vehicles_extras on product_vehicles_extras.product_id = p.product_id
		left join mileage on mileage.mileage_id=product_vehicles_extras.millage
		left join brand  on  brand.brand_id=p.product_brand
		left join model on model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id
		left join mobile_operators mo on mo.id = cmn.mobile_operator
		left join plate_source ps on ps.id = cmn.plate_source
		left join plate_prefix ppx on ppx.id=cmn.plate_prefix
		left join plate_digit pd on pd.id = cmn.plate_digit
		left join repeating_numbers rn on rn.id = cmn.repeating_number
		left join color on  color.id=product_vehicles_extras.color';

                $field_list = ' ,ps.plate_source_name,
		product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,u.nick_name,p.product_is_sold,mileage.name mileagekm,color.name colorname,u.facebook_id,u.twitter_id,u.google_id,brand.name bname,model.name mname,
		cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix,
		if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit,
		mo.operator_name as mobile_operator,cmn.mobile_number,
		if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number,mo.operator_name as mobile_operator,cmn.mobile_number ';
            }

            $query1 = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_total_likes,c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold,p.product_slug,if(fe.product_id IS NOT NULL and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between fe.dateFeatured and fe.dateExpire),1,'') as featured_ad " . $like_fav_field . $field_list . "
            FROM product as p
             left join category as c on p.category_id=c.category_id
             left join user as u on u.user_id = p.product_posted_by
             left join car_mobile_numbers cmn on cmn.product_id=p.product_id   
             left join product_vehicles_extras as v on v.product_id=p.product_id
             left join product_realestate_extras r on r.product_id=p.product_id             
             left join featureads fe on fe.product_id=p.product_id
             " . $like_fav_sql . $sql_list . "
            where p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null and p.product_for IN('classified', 'store')  $where ";

            $prod = $this->db->query($query1);
            $total_product = $prod->num_rows($prod);

            $where .= " order by featured_ad desc,product_posted_time desc limit 12";

            $query = "SELECT p.product_id,p.product_for,p.category_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold,p.product_total_likes ,p.product_slug,u.user_slug, store.store_domain,
              (IF(p.product_image IS NULL OR p.product_image='',0,1) +
               IF(p.youtube_link IS NULL  OR p.youtube_link='',0,1) +
               IF(p.video_name IS NULL  OR p.video_name='',0,1) +
               (COUNT(DISTINCT pi.product_image_id))) as MyTotal,
               if(fe.product_id IS NOT NULL and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between fe.dateFeatured and fe.dateExpire),1,'') as featured_ad " . $like_fav_field . $field_list . "
            FROM product as p
             left join category as c on p.category_id=c.category_id 
             left join user as u on u.user_id = p.product_posted_by
             left join product_vehicles_extras as v on v.product_id=p.product_id
             left join product_realestate_extras r on r.product_id=p.product_id 
             left join car_mobile_numbers cmn on cmn.product_id=p.product_id   
             left join products_images pi on p.product_id = pi.product_id
             left join featureads fe on fe.product_id=p.product_id
             left join store on store.store_owner = p.product_posted_by
             " . $like_fav_sql . $sql_list . "
             where p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null and p.product_for IN('classified', 'store') " . $where;
//            /left join (select count(*) count_image, product_id sub_product_id from products_images pm group by pm.product_id) k on p.product_id=sub_product_id
            $product = $this->dbcommon->get_distinct($query);

            $data['hide'] = "false";
            if ($total_product <= 12) {
                $data['hide'] = "true";
            } else
                $data['load_data'] = 'yes';

            $data['products'] = $product;
            $data['page_title'] = $total_product . ' Ads found';

            $this->load->view('home/advanced_search_list', $data);
        } else {
            $this->load->view('home/advanced_search', $data);
        }
    }

    public function advanced_search_map() {

        $data = array();
        $arr = array_merge($data, $this->get_elements());
        $data['product_page'] = 'yes';
        $data['advanced_page'] = 'yes';
        $data['slug'] = 'advanced_search';

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        $current_user = $this->session->userdata('gen_user');
        if ($this->session->userdata('gen_user')) {
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $emirate_sel = $this->uri->segment(1);
//        if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
//            $url = base_url() . $emirate_sel . '/' . $_SERVER['REQUEST_URI'];
//        else
        $url = base_url() . $_SERVER['REQUEST_URI'];

        if (isset($_REQUEST['page'])) {
            $url = str_replace('?page=' . $_REQUEST['page'], '', $url);
            $url = str_replace('&page=' . $_REQUEST['page'], '', $url);
        }

        //$location = $this->dbcommon->select('country');
        $location = $this->dbcommon->select_orderby('country', 'country_name', 'asc');
        $data['location'] = $location;

        $brand = $this->dbcommon->getbrandlist();
        $data['brand'] = $brand;

        $mileage = $this->dbcommon->getmileagelist();
        $data['mileage'] = $mileage;

        $colors = $this->dbcommon->getcolorlist();
        $data['colors'] = $colors;

        $plate_source = $this->dbcommon->select('plate_source');
        $data['plate_source'] = $plate_source;

        $plate_digit = $this->dbcommon->select('plate_digit');
        $data['plate_digit'] = $plate_digit;

        $where = 'num_for="plate"';
        $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
        $data['repeating_numbers_car'] = $repeating_numbers;

        $where = 'num_for="mobile"';
        $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
        $data['repeating_numbers_mobile'] = $repeating_numbers;

        $plate_digit_mobile = $this->dbcommon->select('plate_digit');
        $data['plate_digit_mobile'] = $plate_digit_mobile;

        $mobile_operators = $this->dbcommon->select('mobile_operators');
        $data['mobile_operators'] = $mobile_operators;

        $data = array_merge($data, $this->get_elements());

        $__catagory_list = [];

//        $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
        $data['category1'] = $category;

        foreach ($data['category1'] as $a => $b) {
            $__catagory_list[] = $b['catagory_name'];
        }

        $seo_catagory = implode(',', $__catagory_list);
        $seo_catagory = preg_replace('/\s+/', ' ', $seo_catagory);

        $__keywords = explode(' ', $seo_catagory);

        foreach ($__keywords as $a => $b) {
            $__keywords[$a] = trim(trim($b, ' '), ',');

            if (strlen($b) < 3 || in_array($b, ['and', 'then', 'than', 'from'])) {
                unset($__keywords[$a]);
            }
        }

        $data['seo'] = [
            'description' => 'Search best products from catagory like ' . $seo_catagory . ' at doukani',
            'keyword' => implode(', ', $__keywords) . ' classified, doukani, search'
        ];

        $where = '';
        $data['page_title'] = 'Advanced Search';
        if (isset($_REQUEST['default']) || isset($_REQUEST['vehicle_submit']) || isset($_REQUEST['real_estate_submit']) || isset($_REQUEST['shared_submit']) || isset($_REQUEST['car_number_submit']) || isset($_REQUEST['mobile_number_submit'])) {

            $start = 0;
            $limit = 12;

            $where .= $this->dbcommon->get_data_advanced($start, $limit);
            $where .= " group by p.product_id";

            $like_fav_sql = '';
            $like_fav_field = '';
            if (isset($current_user) && !empty($current_user)) {
                $like_fav_sql = ' left join like_product lp on  lp.product_id = p.product_id left join favourite_product fp on fp.product_id = p.product_id ';

                $like_fav_field = ' ,if(lp.product_id=p.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=p.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite ';
            }

            $query1 = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_total_likes,c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold,p.product_slug,if(fe.product_id IS NOT NULL and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between fe.dateFeatured and fe.dateExpire),1,'') as featured_ad " . $like_fav_field . ",
             state.state_name,p.latitude,p.longitude,state.latitude state_latitude, state.longitude state_longitude,p.address
            FROM product as p
             left join state on state.state_id = p.state_id
             left join category as c on p.category_id=c.category_id
             left join user as u on u.user_id = p.product_posted_by
             left join product_vehicles_extras as v on v.product_id=p.product_id
             left join product_realestate_extras r on r.product_id=p.product_id
             left join car_mobile_numbers cmn on cmn.product_id=p.product_id
             left join featureads fe on fe.product_id=p.product_id
             " . $like_fav_sql . "
            where p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null and p.product_for IN('classified', 'store')  $where ";

            $prod = $this->db->query($query1);

            $total_product = $prod->num_rows($prod);

            $config = $this->dbcommon->pagination_front($total_product, $url);
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links();

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];

            $where .= " order by featured_ad desc,product_posted_time desc limit " . $offset . "," . $config["per_page"];

            $query = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold,p.product_total_likes ,p.product_slug,u.user_slug,p.product_for, store.store_domain,
              (IF(p.product_image IS NULL OR p.product_image='',0,1) +
               IF(p.youtube_link IS NULL  OR p.youtube_link='',0,1) +
               IF(p.video_name IS NULL  OR p.video_name='',0,1) +
               (COUNT(DISTINCT pi.product_image_id))) as MyTotal,
               IF(fe.product_id IS NOT NULL and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between fe.dateFeatured and fe.dateExpire),1,'') as featured_ad " . $like_fav_field . ",
               state.state_name,p.latitude,p.longitude,state.latitude state_latitude, state.longitude state_longitude,p.address
            FROM product as p
             left join state on state.state_id = p.state_id
             left join category as c on p.category_id=c.category_id 
             left join user as u on u.user_id = p.product_posted_by
             left join product_vehicles_extras as v on v.product_id=p.product_id
             left join product_realestate_extras r on r.product_id=p.product_id 
             left join car_mobile_numbers cmn on cmn.product_id=p.product_id   
             left join products_images pi on p.product_id = pi.product_id
             left join featureads fe on fe.product_id=p.product_id
             left join store on store.store_owner = p.product_posted_by
             " . $like_fav_sql . "
             where p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null and p.product_for IN('classified', 'store')  " . $where;

            $product = $this->dbcommon->get_distinct($query);

            $data['hide'] = "false";
            if ($total_product <= 12) {
                $data['hide'] = "true";
            } else
                $data['load_data'] = 'yes';

            $data['products'] = $product;
            $data['page_title'] = $total_product . ' Ads found';

            $this->load->view('home/category_map', $data);
        } else {

            $this->load->view('home/advanced_search', $data);
        }
    }

    public function load_more_advanced_search() {
        $data = array();
        $current_user = $this->session->userdata('gen_user');
        $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", null, null);
        $data['between_banners'] = $between_banners;

        $arr = array_merge($data, $this->get_elements());
        $arr['page_title'] = 'Search Results';

        $cat_id = $this->input->get_post("cat_id");
        $sub_cat_id = $this->input->get_post("sub_cat");
        $country_id = $this->input->get_post("location1");
        $city_id = $this->input->get_post("city");
        $min_amount = $this->input->get_post("from_price");
        $max_amount = $this->input->get_post("to_price");
        $houses_free = $this->input->get_post("houses_free");
        $shared_free = $this->input->get_post("shared_free");
        //print_r($_REQUEST['location']);
        $where = "";
        if ($cat_id != "0" && $cat_id != '')
            $where .= " and p.category_id = $cat_id";
        if ($sub_cat_id != "0" && $sub_cat_id != '')
            $where .= " and p.sub_category_id = $sub_cat_id";
        if ($country_id != "0" && $country_id != '')
            $where .= " and p.country_id = $country_id";

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->dbcommon->state_id(state_id_selection);
            $where .= " and p.state_id = " . $selected_state_id . ' ';
        } else {
            if ($city_id != "0" && $city_id != '')
                $where .= " and p.state_id = $city_id" . ' ';
        }

        if (isset($houses_free) && $houses_free != '')
            $where .= " and r.free_status=1";
        elseif (isset($houses_free) && $houses_free != '')
            $where .= " and r.free_status=1";
        else {
            if ($min_amount != "" && $max_amount != "")
                $where .= " and p.product_price between $min_amount and $max_amount";
            else if ($min_amount != "")
                $where .= " and p.product_price >= $min_amount";
            else if ($max_amount != "")
                $where .= " and p.product_price <= $max_amount";
        }
        $pro_brand = $this->input->post("pro_brand");
        $vehicle_pro_model = $this->input->get_post("vehicle_pro_model");
        $vehicle_pro_year = $this->input->get_post("vehicle_pro_year");
        $vehicle_pro_mileage = $this->input->get_post("vehicle_pro_mileage");
        $vehicle_pro_color = $this->input->get_post("vehicle_pro_color");

        if ($pro_brand != "0" && $pro_brand != "")
            $where .= ' and p.product_brand=' . (int) $pro_brand;
        if ($vehicle_pro_model != "0" && $vehicle_pro_model != "")
            $where .= ' and v.model=' . (int) $vehicle_pro_model;
        if ($vehicle_pro_year != "0" && $vehicle_pro_year != "")
            $where .= ' and v.year=' . (int) $vehicle_pro_year;
        if ($vehicle_pro_mileage != "0" && $vehicle_pro_mileage != "")
            $where .= ' and v.millage=' . (int) $vehicle_pro_mileage;
        if ($vehicle_pro_color != "0" && $vehicle_pro_color != "")
            $where .= ' and v.color=' . (int) $vehicle_pro_color;


        $furnished = $this->input->get_post("furnished");
        $bedrooms = $this->input->get_post("bedrooms");
        $bathrooms = $this->input->get_post("bathrooms");
        $pets = $this->input->get_post("pets");
        $broker_fee = $this->input->get_post("broker_fee");

        if ($furnished != "0" && $furnished != "")
            $where .= ' and r.furnished="' . $furnished . '"';
        if ($bedrooms != "0" && $bedrooms != "")
            $where .= ' and r.Bedrooms="' . $bedrooms . '"';
        if ($bathrooms != "0" && $bathrooms != "")
            $where .= ' and r.Bathrooms="' . $bathrooms . '"';
        if ($pets != "0" && $pets != "")
            $where .= ' and r.pets="' . $pets . '"';
        if ($broker_fee != "0" && $broker_fee != "")
            $where .= ' and r.broker_fee="' . $broker_fee . '"';


        $plate_source = $this->input->get_post("plate_source");
        $plate_prefix = $this->input->get_post("plate_prefix");
        $plate_digit = $this->input->get_post("plate_digit");
        $repeating_numbers_car = $this->input->get_post("repeating_numbers_car");

        if ($plate_source != "0" && $plate_source != "")
            $where .= ' and cmn.plate_source=' . $plate_source;
        if ($plate_prefix != "0" && $plate_prefix != "")
            $where .= ' and cmn.plate_prefix=' . $plate_prefix;
        if ($plate_digit != "0" && $plate_digit != "")
            $where .= ' and cmn.plate_digit=' . $plate_digit;
        if ($repeating_numbers_car != "0" && $repeating_numbers_car != "")
            $where .= ' and cmn.repeating_number=' . $repeating_numbers_car;


        $mobile_operators = $this->input->get_post("mobile_operators");
        $repeating_numbers_mobile = $this->input->get_post("repeating_numbers_mobile");

        if ($mobile_operators != "0" && $mobile_operators != "")
            $where .= ' and cmn.mobile_operator=' . $mobile_operators;
        if ($repeating_numbers_mobile != "0" && $repeating_numbers_mobile != "")
            $where .= ' and cmn.repeating_number=' . $repeating_numbers_mobile;


        $where .= " group by p.product_id";

        $like_fav_sql = '';
        $like_fav_field = '';
        if (isset($current_user) && !empty($current_user)) {
            $like_fav_sql = ' left join like_product lp on  lp.product_id = p.product_id left join favourite_product fp on fp.product_id = p.product_id ';

            $like_fav_field = ' ,if(lp.product_id=p.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=p.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite ';
        }

        $sql_list = '';
        $field_list = '';
        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
            $sql_list = 'left join product_realestate_extras on product_realestate_extras.product_id = p.product_id
		left join product_vehicles_extras on product_vehicles_extras.product_id = p.product_id
		left join mileage on mileage.mileage_id=product_vehicles_extras.millage
		left join brand  on  brand.brand_id=p.product_brand
		left join model on model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id
		left join mobile_operators mo on mo.id = cmn.mobile_operator
		left join plate_source ps on ps.id = cmn.plate_source
		left join plate_prefix ppx on ppx.id=cmn.plate_prefix
		left join plate_digit pd on pd.id = cmn.plate_digit
		left join repeating_numbers rn on rn.id = cmn.repeating_number
		left join color on  color.id=product_vehicles_extras.color';

            $field_list = ' ,ps.plate_source_name,
		product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,u.nick_name,p.product_is_sold,mileage.name mileagekm,color.name colorname,u.facebook_id,u.twitter_id,u.google_id,brand.name bname,model.name mname,
		cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix,
		if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit,
		mo.operator_name as mobile_operator,cmn.mobile_number,
		if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number,mo.operator_name as mobile_operator,cmn.mobile_number ';
        }

        $query1 = "SELECT p.product_id,p.category_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_total_likes,p.product_slug,if(fe.product_id IS NOT NULL and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between fe.dateFeatured and fe.dateExpire),1,'') as featured_ad " . $like_fav_field . $field_list . "
                    FROM product as p 
                    left join category as c  on p.category_id=c.category_id
                    left join user as u on u.user_id = p.product_posted_by
                    left join product_vehicles_extras as v on v.product_id=p.product_id
                    left join product_realestate_extras r  on r.product_id=p.product_id
                    left join car_mobile_numbers cmn on cmn.product_id=p.product_id
                    left join featureads fe on fe.product_id=p.product_id                    
                    " . $like_fav_sql . $sql_list . "
                    where
                    p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null and p.product_for IN('classified', 'store') $where ";

        $filter_val = $this->input->post("value");
        $start = 12 * $filter_val;
        $end = $start + 12;
        $hide = "false";

        $prod = $this->db->query($query1);
        $total_product = $prod->num_rows($prod);

        //$where .= " order by `admin_modified_at` desc limit $start,12";
        $where .= " order by featured_ad desc,product_posted_time desc limit $start,12";

        $query = "SELECT p.product_id,p.category_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite, p.product_for, store.store_domain, if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,c.catagory_name, u.username, u.profile_picture, u.facebook_id,u.twitter_id,u.google_id,p.product_total_likes,p.product_slug,u.user_slug,
                (IF(p.product_image IS NULL OR p.product_image='',0,1) +
                IF(p.youtube_link IS NULL  OR p.youtube_link='',0,1) +
                IF(p.video_name IS NULL  OR p.video_name='',0,1) +
                (COUNT(DISTINCT pi.product_image_id))) as MyTotal,
                if(fe.product_id IS NOT NULL and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between fe.dateFeatured and fe.dateExpire),1,'') as featured_ad " . $like_fav_field . $field_list . "
                FROM product as p 
                    left join category as c  on p.category_id=c.category_id
                    left join user as u on u.user_id = p.product_posted_by
                    left join product_vehicles_extras as v on v.product_id=p.product_id
                    left join product_realestate_extras r  on r.product_id=p.product_id
                    left join car_mobile_numbers cmn on cmn.product_id=p.product_id
                    left join products_images pi on p.product_id = pi.product_id
                    left join featureads fe on fe.product_id=p.product_id
                    left join store on store.store_owner = p.product_posted_by
                    " . $like_fav_sql . $sql_list . "
                    where 
                    p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null and p.product_for IN('classified', 'store') $where ";

        $product_data = $this->dbcommon->get_distinct($query);

        if ($end >= $total_product) {
            $hide = "true";
        }

        $arr['products'] = $product_data;
        $arr['is_logged'] = 0;
        $arr['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $arr['loggedin_user'] = $current_user['user_id'];
            $arr['is_logged'] = 1;
        }
        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
            $arr["html"] = $this->load->view('home/product_listing_view', $arr, TRUE);
        else
            $arr["html"] = $this->load->view('home/product_grid_view', $arr, TRUE);

        $arr["val"] = $hide;
        $arr["total_product"] = $total_product;
        echo json_encode($arr);
        exit();
    }

    //product display using google map	Category Wise
    //public function category_map($cat_id = null, $subcat_id = null, $pro_id = null) {     
    public function category_map($slug = NULL, $cat_or_suncat = NULL, $emirate_sel = NULL) {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['slug'] = $slug;
        $data['product_page'] = 'yes';
        $display_success = 0;
        if ($cat_or_suncat == 'cat_slug') {
            $data['slug_for'] = 'category';
            $where = " category_slug = '" . $slug . "' ";
            $category = $this->dbcommon->filter('category', $where);
            $data['category_description'] = $category[0]['description'];
            if (sizeof($category) > 0) {
                $cat_id = (int) $category[0]['category_id'];
                $subcat_id = NULL;
                $seo_title = $cat_name = $category[0]['catagory_name'];
                $data['category_description'] = $category[0]['description'];
                $data['category_name'] = $category[0]['catagory_name'];
                $data['category_icon'] = $category[0]['icon'];
                $data['category_slug'] = $category[0]['category_slug'];

                $data['meta_title'] = $category[0]['meta_title'];
                $data['meta_description'] = $category[0]['meta_description'];
                $data['meta_keywords'] = $category[0]['meta_keywords'];

                $display_success = 1;
            } else {
                override_404();
            }
        } elseif ($cat_or_suncat == 'sub_cat_slug') {

            $data['slug_for'] = 'sub_category';
            $where = " sub_category_slug = '" . $slug . "' ";
            $subcategory = $this->dbcommon->filter('sub_category', $where);
            if (sizeof($subcategory) > 0) {
                $cat_id = (int) $subcategory[0]['category_id'];
                $subcat_id = (int) $subcategory[0]['sub_category_id'];

                $seo_title = $data['subcat_name'] = $subcategory[0]['sub_category_name'];

                $array = array(
                    'sub_category_id' => $subcat_id,
                    'product.product_is_inappropriate' => 'Approve',
                    'product.product_deactivate' => null,
                    'product.is_delete' => 0,
                    'product.product_for' => 'classified'
                );

//                if ($this->session->userdata('request_for_statewise') != '')
                if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                    $array['product.state_id'] = $this->dbcommon->state_id($emirate_sel);

                $total = $this->dashboard->get_specific_count('product', $array);

                $data['subcat_total'] = $total;

                $where = " category_id = '" . $subcategory[0]['category_id'] . "' ";
                $category = $this->dbcommon->filter('category', $where);
                $data['sub_category_description'] = $subcategory[0]['description'];

                $data['category_icon'] = $category[0]['icon'];
                $data['sub_category_description'] = $subcategory[0]['description'];
                $data['category_name'] = $subcategory[0]['sub_category_name'];

                $data['meta_title'] = $subcategory[0]['meta_title'];
                $data['meta_description'] = $subcategory[0]['meta_description'];
                $data['meta_keywords'] = $subcategory[0]['meta_keywords'];
                $display_success = 1;
            } else {
                override_404();
            }
        }

        if ($display_success == 1) {

            $query = "category_id= '" . $cat_id . "' AND FIND_IN_SET(0, sub_category_type) > 0 order by sub_cat_order asc";
            $subcat = $this->dbcommon->filter('sub_category', $query);

            // functionality to show the list of sub categoried after the breadcrumb
            $subcatArr = array();
            $i = 0;

            $seo_cate_list = '';

            foreach ($subcat as $sub) {
                $seo_cate_list .= $sub["sub_category_name"] . ', ';
                $subcatArr[$i]["id"] = $sub["sub_category_id"];
                $subcatArr[$i]["name"] = $sub["sub_category_name"];
                $subcatArr[$i]["sub_category_slug"] = $sub["sub_category_slug"];

                $array = array(
                    'sub_category_id' => $sub["sub_category_id"],
                    'product.product_is_inappropriate' => 'Approve',
                    'product.product_deactivate' => null,
                    'product.is_delete' => 0,
                    'product.product_for' => 'classified'
                );
//                if ($this->session->userdata('request_for_statewise') != '')
                if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                    $array['product.state_id'] = $this->dbcommon->state_id($emirate_sel);

                $total = $this->dashboard->get_specific_count('product', $array);

                $subcatArr[$i]["total"] = $total;
                $i++;
            }
            $data['subcat'] = $subcatArr;

            $order_option = '';

            if (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'lh')
                $order_option = '&order=' . $_REQUEST['order'];
            elseif (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'hl')
                $order_option = '&order=' . $_REQUEST['order'];

            $data['order_option'] = $order_option;

            if (isset($_REQUEST['s']) && !empty($_REQUEST['s']))
                $count = $this->dbcommon->get_my_listing_count(NULL, NULL, NULL, NULL, NULL, $cat_id, $subcat_id);
            else
                $count = $this->dbcommon->get_my_listing_count(NULL, NULL, NULL, 'generalUser', NULL, $cat_id, $subcat_id);

//            $count = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);
            $total_product = $count;
            $search_text = '';
            if (isset($_GET['s']) && !empty($_GET['s']))
                $search_text = '&s=' . $_GET['s'];

            if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                $url = base_url() . $emirate_sel . '/' . $slug . '/?view=map' . $search_text . $order_option;
            else
                $url = base_url() . $slug . '/?view=map' . $search_text . $order_option;

            $config = $this->dbcommon->pagination_front($count, $url);
            $this->pagination->initialize($config);
            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];

            if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {
                $product = $this->dbcommon->get_my_listing(NULL, $offset, $config["per_page"], NULL, NULL, NULL, NULL, $cat_id, $subcat_id);
            } else
                $product = $this->dbcommon->get_my_listing(NULL, $offset, $config["per_page"], NULL, NULL, 'generalUser', NULL, $cat_id, $subcat_id);

//            $product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, NULL, $config["per_page"], $offset);
            $data['products'] = $product;
            $data['hide'] = "false";

            if ($total_product <= 12) {
                $data['hide'] = "true";
            }

            $data['total'] = $total_product;
            $data['category_name'] = $category[0]['catagory_name'];
            $data['category_id'] = $cat_id;
            $data['sub_category_id'] = $subcat_id;

//            if (isset($subcategory[0]['sub_category_name']) && $subcategory[0]['sub_category_name'] != '')
//                $data['page_title'] = $total_product . ' Ads in ' . str_replace('\n', " ", $subcategory[0]['sub_category_name']);
//            else
//                $data['page_title'] = $total_product . ' Ads in ' . str_replace('\n', " ", $category[0]['catagory_name']);
            //print_r($data['page_title']);
            $breadcrumb = array(
                'Home' => base_url(),
                $category[0]['catagory_name'] => 'javascript:void(0);',
            );

            if (isset($_GET['view']) && $_GET['view'] == 'map')
                $linkk = '/?view=map';
            else
                $linkk = '';

            if ($subcat_id != null) {
                $breadcrumb = array(
                    'Home' => base_url(),
                    $category[0]['catagory_name'] => base_url() . emirate_slug . $category[0]['category_slug'] . $linkk,
                    $subcategory[0]['sub_category_name'] => 'javascript:void(0);'
                );
            }

            $data['breadcrumbs'] = $breadcrumb;
            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';

            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            $data['product'] = $product;
            $data["links"] = $this->pagination->create_links();

            $data['exclude_map'] = true;

            if (in_array($data['slug_for'], array('category', 'sub_category'))) {

                if (empty($data['meta_title']))
                    $meta_title = $seo_title;
                else
                    $meta_title = $data['meta_title'];

                if (empty($data['meta_description']))
                    $meta_description = 'In ' . $seo_title . ' catagory  you can buy ' . trim($seo_cate_list, ', ') . ' at lowest price on doukani';
                else
                    $meta_description = $data['meta_description'];

                if (empty($data['meta_keywords']))
                    $meta_keywords = $seo_cate_list . 'catagory, clasified, doukani';
                else
                    $meta_keywords = $data['meta_description'];

                $data['seo'] = [
                    'title' => $meta_title,
                    'description' => $meta_description,
                    'keyword' => $meta_keywords
                ];
            }
            else {
                $meta_title = $seo_title;
                $meta_description = 'In ' . $seo_title . ' catagory  you can buy ' . trim($seo_cate_list, ', ') . ' at lowest price on doukani';
                $meta_keywords = $seo_cate_list . 'catagory, clasified, doukani, category map, map';

                $data['seo'] = [
                    'title' => $meta_title,
                    'description' => $meta_description,
                    'keyword' => $meta_keywords
                ];
            }

            $data['page_title'] = $meta_title;

            $this->load->view('home/category_map', $data);
        } else
            override_404();
    }

    //load more data in Grid View Category Page
    public function load_more_category($cat_id = null, $subcat_id = null) {

        if ($cat_id != NULL && $subcat_id != NULL) {
            if ($subcat_id == 0)
                $subcat_id = NULL;
            // getting the banners for the category page.	  
            //$data['between_banners'] = $this->catpage_banner_between($cat_id, $subcat_id);          
            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", $cat_id, $subcat_id);
            $data['between_banners'] = $between_banners;

//            $total_product = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);

            if (isset($_REQUEST['s']) && !empty($_REQUEST['s']))
                $total_product = $this->dbcommon->get_my_listing_count(NULL, NULL, NULL, NULL, NULL, $cat_id, $subcat_id);
            else
                $total_product = $this->dbcommon->get_my_listing_count(NULL, NULL, NULL, 'generalUser', NULL, $cat_id, $subcat_id);

            $filter_val = $this->input->post("value");

            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";
            if ($end >= $total_product) {
                $hide = "true";
            }

            if (isset($_REQUEST['s']) && !empty($_REQUEST['s']))
                $product = $this->dbcommon->get_my_listing(NULL, $start, 12, NULL, NULL, NULL, NULL, $cat_id, $subcat_id);
            else
                $product = $this->dbcommon->get_my_listing(NULL, $start, 12, NULL, NULL, 'generalUser', NULL, $cat_id, $subcat_id);
            
            $data['products'] = $product;

//            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
//                if ($cat_id == 7)
//                    $product = $this->dbcommon->get_vehicle_products($cat_id, $subcat_id, null, 12, $start);
//                elseif ($cat_id == 8)
//                    $product = $this->dbcommon->get_real_estate_products($cat_id, $subcat_id, null, 12, $start);
//                else
//                    $product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, null, 12, $start);
//            }
//            else {
//                $product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, null, 12, $start);
//            }

            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';

            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }
            $arr = array();
            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                $arr["html"] = $this->load->view('home/product_listing_view', $data, TRUE);
            else
                $arr["html"] = $this->load->view('home/product_grid_view', $data, TRUE);
            $arr["val"] = $hide;
            echo json_encode($arr);
            exit();
        }
        else {
            override_404();
        }
    }

    public function numeric_value($str) {
        return preg_match('/^[0-9,]+$/', $str);
    }

    public function item_details($product_slug = NULL, $for = NULL) {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['product_details_page'] = 'yes';
        $data['slug_for'] = 'product';
        $condition = 'yes';
        $product = $this->dbcommon->get_product_slugwise($product_slug, $for, $condition);

        $current_user = $this->session->userdata('gen_user');
        $data['current_user'] = $current_user;

        if (sizeof($product) > 0) {
            $data['product_slug'] = $product->product_slug;
            $pro_id = $product->product_id;
            $cat_id = $product->category_id;
            $subcat_id = $product->sub_category_id;
            $rand = 'rand';
            $counter = 0;

            $first_name = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], "."));
            $full_url = $this->full_url();
            $user_status = 0;

            $where = " category_id = '" . $product->category_id . "' ";
            $category = $this->dbcommon->filter('category', $where);

            $where = " sub_category_id = '" . $product->sub_category_id . "' ";
            $subcategory = $this->dbcommon->filter('sub_category', $where);

            if ($_SERVER['HTTP_HOST'] == $full_url) {

                $counter = 1;
                $where = " where store_domain ='" . $first_name . "' and store_status in (0,3) ";
                $store = $this->dbcommon->getdetails('store', $where);
                $data['store'] = $store;
                $data['store_url'] = HTTP . $store[0]->store_domain . after_subdomain . '/';

                if (!empty($store)) {
                    if (isset($product->delivery_option) && !empty($product->delivery_option)) {
                        $array = array('id' => $product->delivery_option);
                        $delivery_opt = $this->dbcommon->getdetailsinfo('delivery_options', $array);
                        $data['delivery_option_text'] = $delivery_opt->option_text;
                    }
                    $data['store_page'] = 'store_page';
                    $data['request_from'] = 'store_item_details_page';
                    $data['individual_store_id'] = $store[0]->store_id;

                    $where = " where user_id ='" . $store[0]->store_owner . "' ";
                    $store_user = $this->dbcommon->getdetails('user', $where);

                    if ($store_user[0]->contact_number != '')
                        $data['contact_no'] = $store_user[0]->contact_number;
                    elseif ($store_user[0]->phone != '')
                        $data['contact_no'] = $store_user[0]->phone;
                    else
                        $data['contact_no'] = '';

                    if ($store_user[0]->nick_name != '')
                        $title = $store_user[0]->nick_name;
                    elseif ($store_user[0]->username != '')
                        $title = $store_user[0]->username;

                    $data['seller_name'] = $title;
                    $data['seller_emailid'] = $store_user[0]->email_id;

                    if ($store[0]->store_status == 0)
                        $user_status = 0;
                    elseif ($store[0]->store_status == 3 && isset($current_user) && $current_user['user_id'] == $store[0]->store_owner)
                        $user_status = 1;
                    elseif ($store[0]->store_status == 0 && $store[0]->store_is_inappropriate == 'Approve')
                        $user_status = 1;
                    else
                        header("Location:" . HTTP . doukani_website);

                    $result_store_detail = $this->store_common_details($store, $current_user);
                    $data = array_merge($data, $result_store_detail);

                    $data['store_user'] = $store_user;
                    if (empty($store_user)) {
                        $this->redirect_to_path();
                    } else {
                        if ($product->product_posted_by != $store[0]->store_owner)
                            $this->redirect_to_path();
                    }
                } else {

                    $this->redirect_to_path();
                }
                $store_user_id = $store[0]->store_owner;
                if ($current_user['nick_name'] != '')
                    $sender = $current_user['nick_name'];
                else
                    $sender = $current_user['username'];

                $related_product = $this->dbcommon->get_product_by_categories($cat_id, NULL, $pro_id, 8, '', $rand, $store_user_id);
                $feature_banners = $this->dbcommon->getBanner_forCategory('sidebar', "'store_all_page','store_content_page'", $cat_id, $subcat_id, NULL, $store[0]->store_id);

                $breadcrumb = array(
                    'Home' => HTTP . $store[0]->store_domain . after_subdomain . remove_home,
                    $product->product_name => 'javascript:void(0);'
                );
            }
            else {

                $data['category_slug_details'] = $subcategory[0]['sub_category_slug'];
                $related_product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, $pro_id, 8, '', $rand, NULL, NULL, NULL, NULL,'yes');
               
                    
                $feature_banners = $this->dbcommon->getBanner_forCategory('sidebar', "'all_page','content_page'", $cat_id, $subcat_id);

                $breadcrumb = array(
                    'Home' => HTTP . website_url,
                    $product->catagory_name => HTTP . website_url . $category[0]['category_slug'],
                    $product->sub_category_name => HTTP . website_url . $subcategory[0]['sub_category_slug'],
                    $product->product_name => 'javascript:void(0);'
                );
            }

            if (isset($feature_banners[0]['ban_id']) && $feature_banners[0]['ban_id'] != '') {
                $mycnt = $feature_banners[0]['impression_count'] + 1;
                $array1 = array('ban_id' => $feature_banners[0]['ban_id']);
                $data1 = array('impression_count' => $mycnt);
                $this->dbcommon->update('custom_banner', $array1, $data1);
            }
            $data['feature_banners'] = $feature_banners;

            $data['send_message'] = HTTP . website_url . 'home/send_message_to_seller';

            if ($counter == 0 && $product->is_delete == 3) {
                override_404();
                exit;
            }

            $data["related_product"] = $related_product;
            //'NeedReview','Approve','Unapprove','Inappropriate'            
            if (isset($_POST['report_submit'])) {
                $this->send_report();
            }
            if ($this->session->userdata('gen_user') != '') {
                $owner_email = $current_user['email_id'];
                $data['owner_email'] = $owner_email;
                $nick_name = $current_user['nick_name'];
                $data['nick_name'] = $nick_name;
                $user_id = $current_user['user_id'];
                $data['user_id'] = $user_id;

                $logged_in_user = $current_user['username'];

                $data['is_logged'] = 1;
                $data['login_username'] = $logged_in_user;
                $data['loggedin_user'] = $current_user['user_id'];
                //$in	=	array('product_id'=>$pro_id,'user_id'=>$current_user['user_id']);
                //$this->dbcommon->insert('view_product',$in);
            } else {
                $data['owner_email'] = '';
                $data['nick_name'] = '';
                $data['user_id'] = 0;
                $data['is_logged'] = 0;
                $data['login_username'] = null;
                $data['current_user'] = '';
                $data['loggedin_user'] = '';
            }

            $que = ' where user_id=' . $product->product_posted_by;
            $user_email = $this->dbcommon->getrowdetails('user', $que);

            $data['user_data'] = $user_email;

            $que = ' where user_id=' . $product->product_posted_by . ' and user_id=' . $data['user_id'];
            $user_data = $this->dbcommon->getrowdetails('user', $que);

            if (sizeof($user_data) > 0)
                $data['user_status'] = 'yes';
            else
                $data['user_status'] = 'no';

            if (isset($current_user['user_id'])) {
                $sql = " where user_id=" . $current_user['user_id'];
                $chk_usr = $this->dbcommon->getrowdetails('user', $sql);
                if (sizeof($chk_usr) > 0 && isset($chk_usr->nick_name) && $chk_usr->nick_name != '')
                    $data['nick_name'] = $chk_usr->nick_name;
                elseif (sizeof($chk_usr) > 0 && isset($chk_usr->username) && $chk_usr->username != '')
                    $data['nick_name'] = $chk_usr->username;
                else
                    $data['nick_name'] = '';
            } else
                $data['nick_name'] = '';

            $current_views_count = $product->product_total_views;
            $updated_views_count = $current_views_count + 1;

            $views_count = array(
                'product_total_views' => $updated_views_count
            );
            $data['updated_views_count'] = $updated_views_count;

            $array = array('product_id' => $pro_id);
            $this->dbcommon->update('product', $array, $views_count);

            $product_video = $product->video_name;
            $data["product_video"] = $product_video;

            $product_videoimg = $product->video_image_name;
            $data["product_videoimg"] = $product_videoimg;

            $youtube_link = $product->youtube_link;
            $data["youtube_link"] = $youtube_link;

            $product_images = array();

            $cover_img = $product->product_image;

            $data['cover_img'] = $cover_img;
            $data['product_price'] = $product->product_price;
            $images = $this->dbcommon->get_product_images($pro_id);

            $data['product_images'] = $images;

            $share_url = '';
            $i = 0;
            if (isset($cover_img) && $cover_img != '') {
                $share_url = HTTP . website_url . product . 'original/' . $cover_img;
            } else {
                if (sizeof($product_images) > 0) {
                    foreach ($product_images as $image) {
                        $filename = document_root . product . 'original/' . $image;

                        if (file_exists($filename)) {
                            $share_url = HTTP . website_url . product . 'original/' . $image;
                            $i++;
                            break;
                        }
                        if ($i == 0) {
                            $share_url = HTTP . website_url . 'assets/upload/doukani_log.png';
                        }
                    }
                } else {
                    $share_url = HTTP . website_url . 'assets/upload/doukani_log.png';
                }
            }
            $data['share_url'] = $share_url;

            $array = array('product_id' => "'" . $pro_id . "'");

            if ($cat_id == 7) {
                if ($subcat_id == 144) {
                    $car_number = $this->dbcommon->car_mobile_number_product(NULL, NULL, $pro_id, NULL, NULL, 'car_number');
                    if (!empty($car_number))
                        $product->car_number = $car_number;
                }
                else {
                    $vehicle_features = $this->dbcommon->product_vehicles_extras($pro_id);
                    if (!empty($vehicle_features))
                        $product->vehicle_features = $vehicle_features;
                }
            }
            elseif ($cat_id == 8) {
                $realestate_features = $this->dbcommon->getdetailsinfo('product_realestate_extras', $array);
                if (!empty($realestate_features))
                    $product->realestate_features = $realestate_features;
            }
            elseif ($subcat_id == 145) {
                $mobile_number = $this->dbcommon->car_mobile_number_product(NULL, NULL, $pro_id, NULL, NULL, 'mobile_number');
                if (!empty($mobile_number))
                    $product->mobile_number = $mobile_number;
            }
            $data["product"] = $product;
            //print_r($product);
            $data["selected"] = ($product->state_name) ? $product->state_name : "Dubai";
            $data["product_is_sold"] = $product->product_is_sold;
            $res = strtotime($product->admin_modified_at);

            $data["posted_on"] = rtrim($this->dbcommon->dateDiff(date('Y-m-d H:i:s', $res), date('Y-m-d H:i:s')), ', ') . ' back';

            $data['breadcrumbs'] = $breadcrumb;
//            $data['page_title'] = $product->product_name;
//            $breadcrumb = array(
//                    $product->catagory_name => HTTP . website_url . $category[0]['category_slug'],
//                    $product->sub_category_name => HTTP . website_url . $subcategory[0]['sub_category_slug'],
//                    $product->product_name => 'javascript:void(0);'
//                );
//            $data['page_title'] = 'Doukani.com : ' . $product->product_name . ' brand : ' . $product->catagory_name;
            $data['page_title'] = 'Doukani.com : ' . $product->product_name;
            $data['is_logged'] = 0;
            $data['user_agree'] = 0;

            $data['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            $seo_keyword = trim(preg_replace('/\s+/', ' ', $data['page_title']), ' ');
//            $data['seo']['title'] = $data['title'] = $product->product_name;
//            $data['seo']['description'] = $data['description_'] = 'Buy' . $product->product_description . ' at doukani at lowest price!';
            $data['seo']['title'] = $data['title'] = $data['page_title'];
            $data['seo']['description'] = $data['description_'] = $data['page_title'];
            if ($product->address != '') {
                $data['seo']['keyword'] = $data['keyword_'] = $product->product_name . ', ' . $product->catagory_name . ', ' . $product->address;
            } else
                $data['seo']['keyword'] = $data['keyword_'] = $product->product_name . ', ' . $product->catagory_name;
//            $data['seo']['keyword'] = $data['keyword_'] = str_replace(' ', ', ', $seo_keyword) . ', doukani, classified, lowest, latest';

            if ($counter == 1)
                $this->load->view('store/store_item_details', $data);
            else
                $this->load->view('home/item_details', $data);
            //}
        } else {
            override_404();
        }
    }

    public function change_image_size() {
        $target_dir = document_root . product . "original/";

        $files = array_values(array_filter(scandir($target_dir), function($file) {
                    return !is_dir($file);
                }));
        // echo sizeof($files);
        foreach ($files as $file) {

            $filename = $target_dir . $file;


            ob_start();
            imagepng($filename);
            $contents = ob_get_contents();
            ob_end_clean();

            $base_encoded = base64_encode($contents);
            exit;
            // $percent = 0.5;
            // Content type
            header('Content-Type: image/jpeg');

            // Get new sizes
            list($width, $height) = getimagesize($filename);
            // $newwidth = $width * $percent;
            // $newheight = $height * $percent;
            // Load
            $thumb = imagecreatetruecolor(60, 40);
            // $medium = imagecreatetruecolor(202, 160);
            $source = imagecreatefromjpeg($filename);

            // Resize
            imagecopyresized($thumb, $source, 0, 0, 0, 0, 60, 40, $width, $height);
            // imagecopyresized($medium, $source, 0, 0, 0, 0, 202, 160, $width, $height);

            $small_target_dir = document_root . product . "small1/";
            // $medium_target_dir = document_root . product ."medium1/";
            // Output
            imagejpeg($thumb, $small_target_dir . $file);
            // imagejpeg($medium, $medium_target_dir . $file);
        }
    }

    public function contact_us() {
        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $array = array('page_id' => 23);
        //$data['page'] = $this->dbcommon->get_row('pages_cms', $array);
        $page = $this->dbcommon->get_row('pages_cms', $array);
        $data['page'] = $page;

        $data['page_title'] = 'Contact Us';
        $que = ' page_id=22';
        $data['contact_us_desc'] = $this->dbcommon->filter('pages_cms', $que);
        $breadcrumb = array(
            'Home' => base_url(),
            $page->page_title => 'javascript:void(0);',
        );

        $data['breadcrumbs'] = $breadcrumb;
        if (isset($_POST['submit'])):

            $email = $_POST['email_address'];
            $name = $_POST['name'];
            $subject = $_POST['title'];

            $message = '<b>Message From:</b> ' . $name .
                    '<br/><b>Email:</b> ' . $email .
                    '<br/><b>Subject:</b> ' . $subject .
                    '<br/><b>Message:</b><br/>' .
                    nl2br($_POST['desc']);

            $configs = mail_config();

            $title = 'Report For A Doukani Product';
            $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>        
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Message From:</span> ' . $name . '</div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Email ID:</span> ' . $email . ' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Subject:</span>' . $subject . '</div>            
            <br>
            <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;"><strong>Message</strong></h6>
        <hr>
        <p>' . nl2br($_POST['desc']) . '</p>
        </div>';

            $new_data = $this->dbcommon->mail_format($title, $content);
            $new_data = $this->parser->parse_string($new_data, $parser_data, '1');
            // $this->load->library('email', $configs);
            // $this->email->set_newline("\r\n");
            // $this->email->from($email, $name);
            // $this->email->to('adonis@adonis.name');
            // $this->email->to('admin@doukani.com');
            // $this->email->to('doukani0adonis@gmail.com');
            // $this->email->to('test.narolainfotech@gmail.com');
            // $this->email->subject('Contact Us - Request');
            // $this->email->message($new_data);
            // if ($this->email->send()):

            if (send_mail('doukani@doukani.com', 'Contact Us - Request', $new_data)) :
                $save_data = array(
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message
                );
                $result = $this->dbcommon->insert('contact_us', $save_data);
                $this->session->set_flashdata(array('msg' => 'Message successfully sent', 'class' => 'alert-success'));
                redirect('contact-us');
                exit;
            else:
                $this->session->set_flashdata(array('msg' => 'Message was not sent', 'class' => 'alert-info'));
                redirect('contact-us');
                exit;
            endif;

        endif;
        $this->load->view('home/contact_us', $data);

        // $this->load->view('home/contact_us',$data); 
    }

    public function get_featured_ads() {

        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map') {
            $this->get_featured_ads_map();
        } else {
            $data = array();
            $data = array_merge($data, $this->get_elements());
            $data['slug'] = 'featured_ads';
            $data['order_option'] = '';
            $data['product_page'] = 'yes';

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", null, null);
            $data['between_banners'] = $between_banners;

            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
                $total_product = $this->dbcommon->get_featured_ads_count('yes');
                $result = $this->dbcommon->get_featured_ads(0, 12, 'yes');
            } else {
                $result = $this->dbcommon->get_featured_ads(0, 12);
                $total_product = $this->dbcommon->get_featured_ads_count('');
            }

            $data['page_title'] = 'Featured Ads';

            $data['hide'] = "false";
            if ($total_product <= 12) {
                $data['hide'] = "true";
            } else
                $data['load_data'] = 'yes';


            $seo_word = '';
            foreach ($result as $a => $b) {
                $seo_word .= $b['product_name'] . ', ';
                if ($a > 5) {
                    break;
                }
            }

            $seo_word = rtrim($seo_word, ', ');
            $seo_word = preg_replace('/\s+/', '', $seo_word);

            $data['seo'] = [
                'description' => 'Classified featured ads ' . $seo_word . ' at doukani!',
                'keyword' => str_replace(' ', ', ', $seo_word) . ', Classified, doukani, '
            ];

            $seo_word = str_replace(',', ' ', preg_replace('/\s+/', '', $seo_word));

            $data['products'] = $result;
            $data['featured_data'] = 'yes';

            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            $this->load->view('home/featured_ads_list', $data);
        }
    }

    function get_featured_ads_map() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['slug'] = 'featured_ads';
        $data['product_page'] = 'yes';

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $emirate_sel = $this->uri->segment(1);
        if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
            $url = base_url() . $emirate_sel . '/featured_ads/?view=map';
        else
            $url = base_url() . 'featured_ads/?view=map';

        $total_product = $this->dbcommon->get_featured_ads_count();
        $config = $this->dbcommon->pagination_front($total_product, $url);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];

        $result = $this->dbcommon->get_featured_ads($offset, $config["per_page"]);
        $data['products'] = $result;

        $seo_word = '';
        foreach ($result as $a => $b) {
            $seo_word .= $b['product_name'] . ', ';
            if ($a > 5) {
                break;
            }
        }

        $seo_word = rtrim($seo_word, ', ');
        $seo_word = preg_replace('/\s+/', '', $seo_word);

        $data['seo'] = [
            'description' => 'Classified featured ads ' . $seo_word . ' at doukani!',
            'keyword' => str_replace(' ', ', ', $seo_word) . ', Classified, doukani, '
        ];

        $data['page_title'] = $total_product . ' Featured Ads';

        $this->load->view('home/category_map', $data);
    }

    public function get_morefeatured_ads() {

        $filter_val = $this->input->post("value");

        if (isset($filter_val)) {
            $more_data = array();

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", null, null);
            $more_data['between_banners'] = $between_banners;
            $more_data['is_logged'] = 0;

            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";

            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
                $result = $this->dbcommon->get_featured_ads($start, 12, 'yes');
                $total_product = $this->dbcommon->get_featured_ads_count('yes');
            } else {
                $result = $this->dbcommon->get_featured_ads($start, 12);
                $total_product = $this->dbcommon->get_featured_ads_count();
            }


            if ($end >= $total_product) {
                $hide = "true";
            }

            $more_data['products'] = $result;
            $more_data['featured_data'] = 'yes';

            $arr = array();
            $more_data['is_logged'] = 0;
            $more_data['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $more_data['loggedin_user'] = $current_user['user_id'];
                $more_data['is_logged'] = 1;
            }

            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                $arr["html"] = $this->load->view('home/product_listing_view', $more_data, TRUE);
            else
                $arr["html"] = $this->load->view('home/product_grid_view', $more_data, TRUE);

            $arr["val"] = $hide;
            echo json_encode($arr);
        }
        else {
            override_404();
        }
    }

    public function update_click_count() {
        if (isset($_POST['ban_id'])) {
            $ban_id = $_POST['ban_id'];
            $query = $this->db->query('select ban_id,click_count from custom_banner where ban_id=' . $ban_id)->row_array();

            $mycnt = $query['click_count'] + 1;
            $array = array('ban_id' => $ban_id);
            $data = array('click_count' => $mycnt);
            $this->dbcommon->update('custom_banner', $array, $data);
        }
    }

    public function subscription() {

        if (isset($_POST) && isset($_POST['email'])) {
            $this->load->library('Mcapi');
            $retval = $this->mcapi->lists();

            //$listID = "f18853dfa3"; // obtained by calling lists();  
            $listID = "5197a31f6b"; // obtained by calling lists();  
            $emailAddress = $_POST['email'];
            $retval = $this->mcapi->listSubscribe($listID, $emailAddress);

            if ($this->mcapi->errorCode) {
                $data['val'] = 'fail';
                echo json_encode($data);
            } else {
                $data['val'] = 'success';
                echo json_encode($data);
            }
            exit;
        } else {
            override_404();
        }
    }

    public function show_emirates() {
        //$value = 4;
        if (isset($_POST['value']) && $_POST['value'] != '')
            $val = $_POST['value'];
        else
            $val = 4;

        //if(isset($_POST['value']) && $_POST['value']!='') {
        $query = "country_id= " . $val . ' order by sort_order';
        $main_data['state'] = $this->dbcommon->filter('state', $query);
        if (isset($_POST['sel_city']))
            $main_data['sel_city'] = $_POST['sel_city'];
        else
            $main_data['sel_city'] = '';

        $main_data['serach_emirate'] = 'yes';
        echo $this->load->view('home/show_state', $main_data, TRUE);
        exit;
        //}
    }

    public function show_emirates1() {
        //$value = 4;
        $query = '';
        if (isset($_POST['value']) && $_POST['value'] != '')
            $query = "country_id= " . $_POST['value'];
        else
            $query = "country_id= 0";
        $query .= ' order by sort_order';
        $main_data['state'] = $this->dbcommon->filter('state', $query);

        if (isset($_POST['sel_city']))
            $main_data['sel_city'] = $_POST['sel_city'];
        else
            $main_data['sel_city'] = '';
        echo $this->load->view('home/show_state', $main_data, TRUE);
        exit;
    }

    //get data while posting ad or update post
    public function show_emirates_postadd() {
        //$value = 4;
        if (isset($_POST['value']) && $_POST['value'] != '')
            $val = $_POST['value'];
        else
            $val = 0;
        $query = "country_id= " . $val;
        $main_data['state'] = $this->dbcommon->filter('state', $query);
        echo $this->load->view('home/show_state_postad', $main_data, TRUE);
        exit;
    }

    public function show_sub_category() {
        $filter_val = $this->input->post("value");
//        $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(0, sub_category_type) > 0 order by sub_cat_order";
        $query = "category_id= '" . $filter_val . "' order by sub_cat_order";
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);

        echo $this->load->view('user/sub_cat', $main_data, TRUE);
        exit();
    }

    public function show_model() {
        $value = $this->input->post("value");
        if ($value == '')
            $value = 0;

        $query = "brand_id= " . $value;
        $main_data['model'] = $this->dbcommon->filter('model', $query);

        echo $this->load->view('user/show_model', $main_data, TRUE);
        exit;
    }

    public function categories() {

        $query = '';
        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['product_page'] = 'yes';
//        $data['category'] = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
        $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
        $data['category'] = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);

        $feature_banners = $this->dbcommon->getBanner_forCategory('sidebar', "'home_page','all_page'", null, null);
        $data['feature_banners'] = $feature_banners;

        if (isset($feature_banners[0]['ban_id']) && $feature_banners[0]['ban_id'] != '') {
            $mycnt = $feature_banners[0]['impression_count'] + 1;
            $array1 = array('ban_id' => $feature_banners[0]['ban_id']);
            $data1 = array('impression_count' => $mycnt);
            $this->dbcommon->update('custom_banner', $array1, $data1);
        }

        $product = $this->dbcommon->get_products(12);
        $data['latest_product'] = $product;

        $data['page_title'] = 'Category List';

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        echo $this->load->view('home/category_list', $data, TRUE);
    }

    public function request() {
        $data = array();
        $data = array_merge($data, $this->get_elements());

        $query1 = ' where page_id=27 and page_state=1';
        $page = $this->dbcommon->getrowdetails('pages_cms', $query1);

        $data['page_title'] = $page->page_title;
        $data['page'] = $page;

        $current_user = $this->session->userdata('gen_user');
        if ($current_user != '') {
            $us_que = ' where user_id=' . $current_user['user_id'];
            $user_data = $this->dbcommon->getrowdetails('user', $us_que);
        } else {
            $user_data = array();
        }
        $data['user_data'] = $user_data;
        $query = ' parent_page_id=5 and page_state=1';
        $data['page_links'] = $this->dbcommon->filter('pages_cms', $query);

        $query1 = ' where page_id=5 and page_state=1';
        $page_heading = $this->dbcommon->getrowdetails('pages_cms', $query1);
        $data['page_heading'] = $page_heading;

        if (isset($_POST['submit'])) {

            $file_name = '';
            $count = 0;
            if (isset($_FILES['file_name']) && $_FILES['file_name']) {
                $ext = explode(".", $_FILES['file_name']['name']);
                $file_name = time() . "." . end($ext);
                $target_file = document_root . 'assets/upload/request/' . $file_name;

                //3 MB
                if ($_FILES['file_name']['size'] > 3000000) {
                    $count = 1;
                    $data['msg'] = 'The attachment size exceeds the allowable limit';
                } else {
                    if (move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_file)) {
                        $file_name = $file_name;
                    }
                }
            }

            if ($count == 0) {
                $data = array(
                    'question' => $_POST['question'],
                    'sub_question' => $_POST['sub_question'],
                    'description' => $_POST['description'],
                    'name' => $_POST['name'],
                    'email_id' => $_POST['email_id'],
                    'mobile_number' => $_POST['mobile_number'],
                    'ad_link' => $_POST['ad_link'],
                    'file_name' => $file_name
                );
                $result = $this->dbcommon->insert('inquiry_support_request', $data);
            }

            if ($count == 0 && isset($result)) {
                $parser_data['site_url'] = site_url();

                $subject = '';
                if (($_POST['question'])) {
                    if ($_POST['question'] == "1")
                        $subject = 'Suggestions/Complains';
                    elseif ($_POST['question'] == "2")
                        $subject = 'Registration/Account';
                    elseif ($_POST['question'] == "3")
                        $subject = 'Problem with Ads';
                    elseif ($_POST['question'] == "4")
                        $subject = 'Technical Issues';
                    elseif ($_POST['question'] == "5")
                        $subject = 'Fraud';
                    else
                        $subject = '-';
                }

                if (($_POST['sub_question'])) {
                    if ($_POST['sub_question'] == "1")
                        $sub_subject = 'I am not able to find my ad';
                    elseif ($_POST['sub_question'] == "2")
                        $sub_subject = 'My Ad was deleted';
                    elseif ($_POST['sub_question'] == "3")
                        $sub_subject = 'How to Edit an Ad?';
                    elseif ($_POST['sub_question'] == "4")
                        $sub_subject = 'How to Delete an Ad?';
                    elseif ($_POST['sub_question'] == "5")
                        $sub_subject = 'How to Post an Ad?';
                    elseif ($_POST['sub_question'] == "6")
                        $sub_subject = 'I have problems with my account';
                    elseif ($_POST['sub_question'] == "7")
                        $sub_subject = 'How to Register';
                    elseif ($_POST['sub_question'] == "8")
                        $sub_subject = 'Forgot my Password';
                    elseif ($_POST['sub_question'] == "9")
                        $sub_subject = 'Others';
                    elseif ($_POST['sub_question'] == "10")
                        $sub_subject = 'Suggestions';
                    elseif ($_POST['sub_question'] == "11")
                        $sub_subject = 'Complains';
                    elseif ($_POST['sub_question'] == "12")
                        $sub_subject = 'I want to report a fraud';
                    elseif ($_POST['sub_question'] == "13")
                        $sub_subject = 'I am a victim of a fraud';
                    elseif ($_POST['sub_question'] == "14")
                        $sub_subject = 'I want to report identity theft';
                    elseif ($_POST['sub_question'] == "15")
                        $sub_subject = 'Others';
                    else
                        $sub_subject = '-';
                }

                $parser_data = array();
                $question_title = $subject;
                $sub_title = $sub_subject;
                $description = $_POST['description'];
                $sender_name = $_POST['name'];
                $email_id = $_POST['email_id'];
                $mobile_no = $_POST['mobile_number'];
                $ad_link = $_POST['ad_link'];
                $attachment_link = site_url() . 'home/display_attach/' . base64_encode($file_name);
                $attachment_name = base64_encode($file_name);

                $content = '
       <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>
        <h6 style="font-family: Roboto, sans-serif; color:#ed1b33; font-size:20px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:800; text-transform:uppercase; display:block;">Request For</h6>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-size:17px; color:#333;">Title:' . $question_title . '</div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-size:15px; color:#666;">Subtitle:' . $sub_title . '<br></div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:10px; padding-right:0; padding-bottom:15px; padding-left:0; font-size:14px; color:#999;">Description:' . $description . '</div>
        
        <div style="margin-top:0; margin-right:0; margin-bottom:10px; margin-left:0; padding-top:10px; padding-right:20px; padding-bottom:10px; padding-left:20px; background:rgba(0, 0, 0, 0.04);">
        <h6 style="font-family: Roboto, sans-serif; color:#ed1b33; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:5px; padding-right:0; padding-bottom:10px; padding-left:0; font-weight:400;">Sender Details:</h6>
        
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Name:</span> ' . $sender_name . ' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333"> E-mail: </span> ' . $email_id . ' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:25px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333"> Mobile Number: </span> ' . $mobile_no . '</div>
                  <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#333;">  Ad Link: ' . $ad_link . ' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#333;">Attachment: <a style="color: #000000 !important;" href="' . $attachment_link . '">' . $attachment_name . '</a></div>
</div>    
        </div>
';
                $new_data = $this->dbcommon->mail_format($title, $content);
                $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

                $email = 'support@doukani.com';
//                $email = 'kek@narola.email';
                if (send_mail($email, 'Request for : ' . $subject, $new_data)) {
                    
                }

                $sender_name = $_POST['name'];
                //send to client		
                $parser_data1 = array();
                $title = '';
                $content = '
       <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>
        <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;">Thank You for Your Request Mr./Ms. ' . $sender_name . '</h6>
<br><br>
<p style="font-family: Roboto, sans-serif; color:#333; font-size:13px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:10px; padding-left:0;">The request is being reviewed by our support staff and will be updated to you.</p>
        </div>
';
                $new_data1 = $this->dbcommon->mail_format($title, $content);
                $new_data1 = $this->parser->parse_string($new_data1, $parser_data1, '1');

                if (send_mail($_POST['email_id'], 'Thank you for your request : ' . $subject, $new_data1)) {
                    $this->session->set_flashdata('msg_request', 'Request sent successfully...');
                }

                if (isset($_REQUEST['request_from_app']) && $_REQUEST['request_from_app'] == 'request') {
                    redirect('home/request_app');
                } else
                    redirect('home/request');
            }
            else {

                if ($count == 1) {
                    $data['msg'] = 'The attachment size exceeds the allowable limit';
                } else {
                    $data['msg'] = 'Sending request failed';
                }
            }
        }
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $this->load->view('home/request', $data);
    }

    //display help center page in mobile app 	
    public function request_app() {
        $data = array();
        $data = array_merge($data, $this->get_elements());
        $query1 = ' where page_id=27';
        $page = $this->dbcommon->getrowdetails('pages_cms', $query1);
        $data['page'] = $page;
        $data['page_title'] = $page->page_title;

        $this->load->view('home/request_app', $data);
    }

    //display tems and conditions page in mobile app 
    public function terms_conditions_app() {
        $data = array();
        $query1 = ' where page_id=21';
        $page_heading = $this->dbcommon->getrowdetails('pages_cms', $query1);
        $data['page_heading'] = $page_heading;
        $data['page_title'] = $page_heading->page_title;

        $this->load->view('home/terms_and_conditions_app', $data);
    }

    //display about us page in mobile app 
    public function about_us_app() {
        $data = array();
        $query1 = ' where page_id=30';
        $page_heading = $this->dbcommon->getrowdetails('pages_cms', $query1);
        $data['page_heading'] = $page_heading;
        $data['page_title'] = $page_heading->page_title;

        $this->load->view('home/terms_and_conditions_app', $data);
    }

    public function display_attach() {
        $file = $this->uri->segment(3);
        if ($file != '') {
            $decoded = base64_decode($file);
            $ext = explode(".", $decoded);

            if ($decoded != '' && ($ext[1] == "jpg" || $ext[1] == "png" || $ext[1] == "jpeg" || $ext[1] == "gif")) {
                $data = array();
                $data['img'] = $decoded;
                $this->load->view('home/request_image', $data);
            } elseif ($decoded != '') {
                $this->load->helper('download');

                $data = file_get_contents(base_url() . 'assets/upload/request/' . $decoded);
                $name = $decoded;
                force_download($name, $data);
            } else {
                echo 'file not found';
                exit;
            }
        } else {
            echo 'file not found';
            exit;
        }
    }

    public function faq() {
        $data = array();
        $data = array_merge($data, $this->get_elements());

        $array = array('page_id' => 16);
        $page = $this->dbcommon->get_row('pages_cms', $array);
        $data['page_title'] = $page->page_title;

        $query = "  is_delete=0 order by sort_order asc";
        $faq = $this->dbcommon->filter('faq', $query);

        $data['faq'] = $faq;
        $breadcrumb = array(
            'Home' => base_url(),
            $page->page_title => 'javascript:void(0);',
        );
        $data['page'] = $page;
        $data['breadcrumbs'] = $breadcrumb;
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $this->load->view('home/faq', $data);
    }

    //category grid/listing/ more grid and listing	
    public function catpage_banner_between($cat_id, $subcat_id) {

        if ($cat_id == '')
            $cat_id = null;
        if ($subcat_id == '')
            $subcat_id = null;
        $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", null, null);


        // echo $this->db->last_query();
        // print_r($between_banners);
        /* if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='') {		
          $mycnt	=	$between_banners[0]['impression_count']+1;
          $array1	=	array('ban_id'=>$between_banners[0]['ban_id']);
          $data1	=	array('impression_count'=>$mycnt);
          $this->dbcommon->update('custom_banner', $array1, $data1);
          } */
        return $between_banners;
    }

    function redirect_to_path() {

        $arr = explode(".", base_url(uri_string()));
        unset($arr[0]);
        $redirect = implode(".", $arr);
        header('Location:http://' . $redirect);
    }

    /*
      for store
      get Individual store page with its sundomain name
     */

    function individual_store($first_name = NULL, $store = NULL) {

        $data = array();

        if (!empty($store)) {
            $data['product_page'] = 'yes';
            $data['store_url'] = HTTP . $store[0]->store_domain . after_subdomain . '/';
            $data = array_merge($data, $this->get_elements());

            $data['store_page'] = 'store_page';
            $data['request_from'] = 'store_page';
            $data['individual_store_id'] = $store[0]->store_id;

            $currentusr = $this->session->userdata('gen_user');

            $user_status = 0;

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'store_all_page','specific_store_page'", NULL, NULL, NULL, $store[0]->store_id);

            $data['between_banners'] = $between_banners;

            $data['store'] = $store;

            $where = " where user_id ='" . $store[0]->store_owner . "'";
            $store_user = $this->dbcommon->getdetails('user', $where);
            $data['store_user'] = $store_user;

            if ($store[0]->store_status == '0' && $store[0]->store_is_inappropriate == 'Approve') {
                $user_status = 0;
                $current_views_count = $store[0]->store_total_views;
                $updated_views_count = $current_views_count + 1;

                $views_count = array(
                    'store_total_views' => $updated_views_count
                );

                $array = array('store_id' => $store[0]->store_id);
                $this->dbcommon->update('store', $array, $views_count);
            } elseif ($store[0]->store_status == '0' && isset($currentusr) && $currentusr['user_id'] == $store[0]->store_owner)
                $user_status = 0;
            elseif ($store[0]->store_status == '3' && isset($currentusr) && $currentusr['user_id'] == $store[0]->store_owner)
                $user_status = 1;
            else {
                //override_404();
            }

            if (!empty($store[0]->website_url))
                $data['store_home_page'] = 'yes';

            $data['user_status'] = $user_status;

            if ($store_user[0]->contact_number != '')
                $data['contact_no'] = $store_user[0]->contact_number;
            elseif ($store_user[0]->phone != '')
                $data['contact_no'] = $store_user[0]->phone;
            else
                $data['contact_no'] = '-';
            $data['seller_emailid'] = $store_user[0]->email_id;

            if ($store_user[0]->nick_name != '')
                $title = $store_user[0]->nick_name;
            elseif ($store_user[0]->username != '')
                $title = $store_user[0]->username;

            $data['seller_name'] = $title;
            $data['seller_emailid'] = $store_user[0]->email_id;
            $data['seller_id'] = $store_user[0]->user_id;

            if (isset($store[0]->store_approved_on) && !empty($store[0]->store_approved_on))
                $app_date = $store[0]->store_approved_on;
            else
                $app_date = $store[0]->store_created_on;
            $store_user_regidate = $this->dbcommon->dateDiff(date('y-m-d H:i:s'), $app_date);
            $data['store_user_regidate'] = $store_user_regidate;

            $state_str = '';
            if (in_array($this->uri->segment(1), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                $state_str = ' and state_id= ' . $this->dbcommon->state_id($this->uri->segment(1));

            $query_cnt = " product_id from product where product_posted_by='" . $store[0]->store_owner . "' and is_delete in (0,3) and product_deactivate IS NULL and product_is_inappropriate='Approve' and product_for='store' " . $state_str;
            $count_no_of_post = $this->dbcommon->getnumofdetails_($query_cnt);
            $data['count_no_of_post'] = $count_no_of_post;

            if (!empty($store[0]->website_url))
                $data['page_title'] = $store[0]->store_name;
            else
                $data['page_title'] = $store[0]->store_name . ' has ' . $count_no_of_post . ' ads';

            if (!empty($store[0]->meta_title))
                $meta_title = $store[0]->meta_title;
            else
                $meta_title = $data['page_title'];

            if (!empty($store[0]->meta_description))
                $meta_description = $store[0]->meta_description;
            else
                $meta_description = 'Browse ' . $store[0]->store_name . "'s store and find your favorite products";

            $__catagory_list = [];

            $wh_category_data = array('FIND_IN_SET(1, category_type) > 0');
            $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);

            foreach ($category as $key => $value) {
                $where = " category_id=" . $value['category_id'] . " AND FIND_IN_SET(1, sub_category_type) > 0 order by sub_cat_order asc";
                $sub_categories = $this->dbcommon->filter('sub_category', $where);
                $category[$key]['sub_categories'] = $sub_categories;
            }

            $data['category'] = $category;

            foreach ($data['category'] as $a => $b) {

                if ($store[0]->category_id == $b['category_id']) {
                    $__catagory_list[] = $b['catagory_name'];
                    foreach ($b['sub_categories'] as $__sub_cat) {
                        if ($store[0]->sub_category_id == $__sub_cat['sub_category_id']) {
                            $__catagory_list[] = $__sub_cat['sub_category_name'];
                        }
                    }
                }
            }

            $seo_catagory = implode(',', $__catagory_list);
            $seo_catagory = preg_replace('/\s+/', ' ', $seo_catagory);

            $__keywords = explode(' ', $seo_catagory);

            foreach ($__keywords as $a => $b) {
                $__keywords[$a] = trim(trim($b, ' '), ',');

                if (strlen($b) < 3 || in_array($b, ['and', 'then', 'than', 'from'])) {
                    unset($__keywords[$a]);
                }
            }

            $data['title_'] = $meta_title;
            $data['description_'] = $meta_description . ' at doukani';
            $data['keyword_'] = implode(', ', $__keywords) . ' doukani, store, shop ,seller, storeuser,' . $store[0]->store_name . ',' . $store[0]->store_domain . ',' . $store_user[0]->username . ',' . $store_user[0]->nick_name . '';

            $listing = $this->dbcommon->get_my_listing($store[0]->store_owner, $start = 0, $limit = 15, NULL, $user_status, $store_user[0]->user_role, 'store');
            $data['listing'] = $listing;

            $total_product = $this->dbcommon->get_my_listing_count($store[0]->store_owner, NULL, $user_status, $store_user[0]->user_role, 'store');

            $data['hide'] = "false";
            if ($total_product <= 15) {
                $data['hide'] = "true";
            }

            $data['is_following'] = 0;
            if ($this->session->userdata('gen_user') != '') {
                $logged_in_user = $currentusr['username'];
                $data['is_logged'] = 1;
                $data['login_username'] = $logged_in_user;
                $data['loggedin_user'] = $currentusr['user_id'];

                $count_array = array('user_id' => $currentusr['user_id'],
                    'seller_id' => $store_user[0]->user_id);

                $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
                $data['is_following'] = $following_count;

                if ($currentusr['nick_name'] != '')
                    $sender = $currentusr['nick_name'];
                else
                    $sender = $currentusr['username'];
                if ($currentusr['contact_number'] != '')
                    $sender_number = $store_user[0]->contact_number;
                else
                    $sender_number = $store_user[0]->phone;
            }
            else {
                $data['is_logged'] = 0;
                $data['login_username'] = null;
                $data['current_user'] = '';
                $data['loggedin_user'] = '';
            }

            $share_url = '';
            if (isset($store[0]->store_cover_image) && $store[0]->store_cover_image != '') {
                $share_url = store_cover . 'medium/' . $store[0]->store_cover_image;
            }

            $data['share_url'] = $share_url;
            $data['store_main_page'] = 'yes';
            $this->load->view('store/store_details', $data);
        } else {
            override_404();
        }
    }

    /*
      for specific store
      load more store products
     */

    public function load_more_storelisting() {

        $arr = array();

        $filter_val = $this->input->post("value");
        $user_id = $this->input->post("user_id");
        $user_status = $this->input->post("user_status");

        if (isset($filter_val) && isset($user_id)) {
            $query = " where store_owner ='" . $user_id . "'";
            $store_det = $this->dbcommon->getrowdetails('store', $query, $offset = '0', $limit = '1');
            $arr['store_url'] = HTTP . $store_det->store_domain . after_subdomain . '/';

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'store_all_page','specific_store_page'", NULL, NULL, NULL, $store_det->store_id);
            $arr['between_banners'] = $between_banners;

            $start = 15 * $filter_val;
            $end = $start + 15;
            $hide = "false";

            if (isset($_POST['type']))
                $search = $this->input->post('type', TRUE);
            else
                $search = NULL;

            $cat_id = $store_det->category_id;

            if ($cat_id > 0)
                $total_product = $this->dbcommon->get_my_listing_count($user_id, $search, $user_status, 'storeUser', 'store', $cat_id);
            else
                $total_product = $this->dbcommon->get_my_listing_count($user_id, $search, $user_status, 'storeUser', 'store');

            if ($cat_id > 0)
                $products = $this->dbcommon->get_my_listing($user_id, $start, 15, $search, $user_status, 'storeUser', 'store', $cat_id);
            else
                $products = $this->dbcommon->get_my_listing($user_id, $start, 15, $search, $user_status, 'storeUser', 'store');

            $currentusr = $this->session->userdata('gen_user');

            if ($this->session->userdata('gen_user') != '') {
                $logged_in_user = $currentusr['username'];
                $arr['is_logged'] = 1;
                $arr['login_username'] = $logged_in_user;
                $arr['loggedin_user'] = $currentusr['user_id'];
            } else {
                $arr['is_logged'] = 0;
                $arr['login_username'] = NULL;
                $arr['current_user'] = '';
                $arr['loggedin_user'] = '';
            }

            if ($end >= $total_product) {
                $hide = "true";
            }
            $arr['product_view'] = $_POST['product_view'];
            $arr['listing'] = $products;
            $arr['request_from'] = 'store_page';
            if (isset($_POST['product_view']) && $_POST['product_view'] == 'list') {
                $arr['html'] = $this->load->view('store/store_product_list_view', $arr, TRUE);
            } else {
                $arr['html'] = $this->load->view('store/product_store_grid_view', $arr, TRUE);
            }

            $arr['val'] = $hide;
            $arr['total_product'] = $total_product;

            echo json_encode($arr);

            exit();
        } else {
            override_404();
        }
    }

    public function load_more_storelisting_for_home() {

        $arr = array();
        $filter_val = $this->input->post("value");

        if (isset($filter_val)) {

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'store_all_page', 'store_page_content'");
            $arr['between_banners'] = $between_banners;
            $cat_id = $this->input->post('cat_id', TRUE);
            $start = 15 * $filter_val;
            $end = $start + 15;
            $hide = "false";

            if (isset($_POST['type']))
                $search = $this->input->post('type', TRUE);
            else
                $search = NULL;

            if ($cat_id > 0) {
                $total_product = $this->dbcommon->get_my_listing_count(NULL, $search, 0, 'storeUser', 'store', $cat_id);
                $products = $this->dbcommon->get_my_listing(NULL, $start, 15, $search, 0, 'storeUser', 'store', $cat_id);
            } else {
                $total_product = $this->dbcommon->get_my_listing_count(NULL, $search, 0, 'storeUser', 'store');
                $products = $this->dbcommon->get_my_listing(NULL, $start, 15, $search, 0, 'storeUser', 'store');
            }

            $currentusr = $this->session->userdata('gen_user');

            if ($this->session->userdata('gen_user') != '') {
                $logged_in_user = $currentusr['username'];
                $arr['is_logged'] = 1;
                $arr['login_username'] = $logged_in_user;
                $arr['loggedin_user'] = $currentusr['user_id'];
            } else {
                $arr['is_logged'] = 0;
                $arr['login_username'] = NULL;
                $arr['current_user'] = '';
                $arr['loggedin_user'] = '';
            }

            if ($end >= $total_product) {
                $hide = "true";
            }
            $arr['product_view'] = $_POST['product_view'];
            $arr['listing'] = $products;

            if (isset($_POST['product_view']) && $_POST['product_view'] == 'list') {
                $arr['html'] = $this->load->view('store/store_product_list_view', $arr, TRUE);
            } else {
                $arr['html'] = $this->load->view('store/product_store_grid_view', $arr, TRUE);
            }

            $arr['val'] = $hide;
            $arr['total_product'] = $total_product;

            echo json_encode($arr);

            exit();
        } else {
            override_404();
        }
    }

    function get_allstore_products() {

        $main_data = array();
        $current_user = $this->session->userdata('gen_user');

        $between_banners = $this->dbcommon->getBanner_forCategory('between', "'store_all_page', 'store_page_content'", NULL, NULL, NULL);
        $main_data['between_banners'] = $between_banners;

        $main_data['is_logged'] = 0;
        $main_data['loggedin_user'] = '';

        if ($this->session->userdata('gen_user') != '') {
            $main_data['current_user'] = $current_user;
            $logged_in_user = $current_user['user_id'];
            $main_data['is_logged'] = 1;
            $main_data['login_userid'] = $logged_in_user;
            $main_data['loggedin_user'] = $current_user['user_id'];
        } else {
            $main_data['is_logged'] = 0;
            $main_data['login_userid'] = NULL;
            $main_data['current_user'] = '';
            $main_data['loggedin_user'] = '';
        }

        $filter_val = $this->input->post('value', TRUE);

        if (isset($_POST['type']))
            $search = $this->input->post('type', TRUE);
        else
            $search = NULL;

        $cat_id = $this->input->post('cat_id', TRUE);
        $start = 0;
        $hide = "false";

        if ($cat_id > 0)
            $total_product = $this->dbcommon->get_my_listing_count(NULL, $search, 0, 'storeUser', 'store', $cat_id);
        else
            $total_product = $this->dbcommon->get_my_listing_count(NULL, $search, 0, 'storeUser', 'store');

        $main_data['hide'] = "false";
        if ($total_product <= 15) {
            $main_data['hide'] = "true";
        }

        $main_data['search'] = $search;
        $main_data['product_view'] = $_POST['product_view'];

        if ($cat_id > 0)
            $products = $this->dbcommon->get_my_listing(NULL, $start, 15, $search, 0, 'storeUser', 'store', $cat_id,NULL,'yes');
        else
            $products = $this->dbcommon->get_my_listing(NULL, $start, 15, $search, 0, 'storeUser', 'store',NULL,NULL,'yes');

        $main_data['listing'] = $products;
        $main_data['html'] = $this->load->view('store/filter_store_products', $main_data, TRUE);

        echo json_encode($main_data);
        exit();
    }

    /*
      for store
      get products after searching like all,popular,new with sort functionality
     */

    function get_store_products() {

        $main_data = array();
        $user_id = $this->input->post('user_id', TRUE);

        if (isset($user_id)) {
            $current_user = $this->session->userdata('gen_user');

            $query = ' where store_owner=' . (int) $user_id;
            $store_data = $this->dbcommon->getrowdetails('store', $query, $offset = '0', $limit = '1');

            $user_status = 0;
            if ($store_data->store_status == 0)
                $user_status = 0;
            elseif ($store_data->store_status == 3 && isset($current_user) && $current_user['user_id'] == $store_data->store_owner)
                $user_status = 1;
            elseif ($store_data->store_status == 0 && $store_data->store_is_inappropriate == 'Approve')
                $user_status = 1;

            $main_data['store_url'] = HTTP . $store_data->store_domain . after_subdomain . '/';

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'store_all_page','specific_store_page'", NULL, NULL, NULL, $store_data->store_id);
            $main_data['between_banners'] = $between_banners;

            $main_data['is_logged'] = 0;
            $main_data['loggedin_user'] = '';

            if ($this->session->userdata('gen_user') != '') {
                $main_data['current_user'] = $current_user;
                $logged_in_user = $current_user['user_id'];
                $main_data['is_logged'] = 1;
                $main_data['login_userid'] = $logged_in_user;
                $main_data['loggedin_user'] = $current_user['user_id'];
            } else {
                $main_data['is_logged'] = 0;
                $main_data['login_userid'] = NULL;
                $main_data['current_user'] = '';
                $main_data['loggedin_user'] = '';
            }

            $filter_val = $this->input->post('value', TRUE);

            if (isset($_POST['type']))
                $search = $this->input->post('type', TRUE);
            else
                $search = NULL;

            $user_status = $this->input->post('user_status', TRUE);

            $main_data['user_status'] = $user_status;
            $cat_id = $store_data->category_id;
            $start = 0;
            $hide = "false";

            if ($cat_id > 0)
                $total_product = $this->dbcommon->get_my_listing_count($user_id, $search, $user_status, 'storeUser', 'store', $cat_id);
            else
                $total_product = $this->dbcommon->get_my_listing_count($user_id, $search, $user_status, 'storeUser', 'store');

            $main_data['hide'] = "false";
            if ($total_product <= 15) {
                $main_data['hide'] = "true";
            }

            $main_data['search'] = $search;
            $main_data['product_view'] = $_POST['product_view'];

            if ($cat_id > 0)
                $products = $this->dbcommon->get_my_listing($user_id, $start, 15, $search, $user_status, 'storeUser', 'store', $cat_id);
            else
                $products = $this->dbcommon->get_my_listing($user_id, $start, 15, $search, $user_status, 'storeUser', 'store');

            $main_data['listing'] = $products;
            $main_data['html'] = $this->load->view('store/store_products', $main_data, TRUE);

            echo json_encode($main_data);
            exit();
        }
        else {
            override_404();
        }
    }

    /*
      for store
      fetch common details for all store pages
     */

    function store_common_details($store = NULL, $currentusr = NULL) {

        $store_arr = array();

        if ($store != NULL) {
            $store_arr['store'] = $store;

            $store_arr['store_owner'] = $store[0]->store_owner;
            $where_store = " where user_id ='" . $store[0]->store_owner . "' and  is_delete in (0,3) ";
            $store_user = $this->dbcommon->getdetails('user', $where_store);
            $store_arr['store_user'] = $store_user;

            if (isset($store_user[0]->contact_number) && !empty($store_user[0]->contact_number))
                $store_arr['contact_no'] = $store_user[0]->contact_number;
            elseif (isset($store_user[0]->phone) && !empty($store_user[0]->phone))
                $store_arr['contact_no'] = $store_user[0]->phone;
            else
                $store_arr['contact_no'] = '-';

            if (isset($store_user[0]->nick_name) && !empty($store_user[0]->nick_name))
                $store_arr['seller_name'] = $store_user[0]->nick_name;
            else
                $store_arr['seller_name'] = $store_user[0]->username;

            $store_arr['seller_emailid'] = $store_user[0]->email_id;
            $store_arr['seller_id'] = $store_user[0]->user_id;

            $state_str = '';
            if (in_array($this->uri->segment(1), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                $state_str = ' and state_id= ' . $this->dbcommon->state_id($this->uri->segment(1));

            $query_cnt = " product_id from product where product_posted_by='" . $store[0]->store_owner . "' and is_delete in (0,3) and product_deactivate IS NULL and product_is_inappropriate='Approve' and product_for='store' " . $state_str;
            $count_no_of_post = $this->dbcommon->getnumofdetails_($query_cnt);
            $store_arr['count_no_of_post'] = $count_no_of_post;

            $share_url = '';
            if (isset($store[0]->store_cover_image) && $store[0]->store_cover_image != '') {
                $share_url = base_url() . store_cover . 'medium/' . $store[0]->store_cover_image;
            }

            $store_arr['share_url'] = $share_url;

            $store_arr['is_following'] = 0;
            $count_array = array('user_id' => $currentusr['user_id'],
                'seller_id' => $store_user[0]->user_id);

            $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
            $store_arr['is_following'] = $following_count;

            if (isset($store[0]->store_approved_on) && !empty($store[0]->store_approved_on))
                $app_date = $store[0]->store_approved_on;
            else
                $app_date = $store[0]->store_created_on;

            $store_user_regidate = $this->dbcommon->dateDiff(date('y-m-d H:i:s'), $app_date);
            $store_arr['store_user_regidate'] = $store_user_regidate;

            return $store_arr;
        }
        else {
            
        }
    }

    /*
     * Get FUl, url to check subdomain name
     * */

    function full_url() {

        $first_name = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], "."));
        $full_url_path = $first_name . after_subdomain;
        return $full_url_path;
    }

    public function seller_listings($user_slug = NULL, $offer_name = NULL) {

        $array = array('user_slug' => $user_slug, 'is_delete' => 0, 'status' => 'active');
        $user = $this->dbcommon->get_row('user', $array);

        if (isset($user)) {
            $user_id = $user->user_id;
            $user_role = $user->user_role;
        }

        if (!empty($user) && $user_id != '' && $user_slug != NULL && $user_role != 'offerUser') {

            $current_user = $this->session->userdata('gen_user');

            $data = array();
            $data = array_merge($data, $this->get_elements());
            $data['current_page1'] = 'yes';
            $data['slug'] = $user_slug;
            $order_option = '';
            $view = '';
            if (isset($_GET['view']) && in_array($_GET['view'], array('list', 'grid', 'map'))) {
                $sign = '&';
                $view = '?view=' . $_GET['view'];
            } else
                $sign = '?';
            if (isset($_REQUEST['order']))
                $order_option = $sign . 'order=' . $_REQUEST['order'];

            $data['order_option'] = $order_option;

            $data['product_page'] = 'yes';
            $data['seller_listing_page'] = 'yes';
            $data['request_from'] = 'seller_listing_page';

            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", null, null);
            $data['between_banners'] = $between_banners;

            $seller_option = '';
            if (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'lh')
                $seller_option = 'order=' . $_REQUEST['order'];
            elseif (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'hl')
                $seller_option = 'order=' . $_REQUEST['order'];

            $data['seller_option'] = $seller_option;
            $data['loggedin_user'] = '';
            $data['user'] = $user;

            if (sizeof($user) > 0) {

                if ($this->session->userdata('gen_user') != '')
                    $get_myfollowers = $this->dbcommon->get_myfollowers($user_id, $current_user['user_id']);
                else
                    $get_myfollowers = 0;

                $total_followers = $this->dbcommon->get_myfollowers_count($user_id);

                $data['followers'] = $total_followers;
                $data['get_myfollowers'] = $get_myfollowers;
                if ($user->contact_number != '')
                    $data['contact_no'] = $user->contact_number;
                elseif ($user->phone != '')
                    $data['contact_no'] = $user->phone;
                else
                    $data['contact_no'] = '-';

                $data['seller_emailid'] = $user->email_id;
                $data['seller_id'] = $user->user_id;
                $data['user_agree'] = 0;
                $data['loggedin_user'] = '';

                if ($user->nick_name != '')
                    $title = $user->nick_name;
                elseif ($user->username != '')
                    $title = $user->username;

                $data['seller_name'] = $title;
                $data['is_following'] = 0;
                $data['is_logged'] = 0;

                if ($this->session->userdata('gen_user')) {

                    $data['current_user'] = $current_user;
                    $data['is_logged'] = 1;
                    $logged_in_userid = $current_user['user_id'];
                    $data['login_userid'] = $logged_in_userid;

                    $count_array = array('user_id' => $current_user['user_id'],
                        'seller_id' => $user_id);

                    $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
                    $data['is_following'] = $following_count;

                    if ($current_user['nick_name'] != '')
                        $sender = $current_user['nick_name'];
                    else
                        $sender = $current_user['username'];
                    if ($current_user['contact_number'] != '')
                        $sender_number = $user->contact_number;
                    else
                        $sender_number = $user->phone;
                }
                else {
                    $data['login_userid'] = null;
                    $data['is_logged'] = 0;
                    $data['current_user'] = '';
                    $data['loggedin_user'] = '';
                }

                $start = 0;
                $limit = 12;

                $products = $this->dbcommon->get_my_seller_listing($user_id, $start, $limit);
                $total_product = $this->dbcommon->seller_listing_count($user_id);

                $data['page_title'] = $total_product . ' Ads of ' . $title;

                $data['products'] = $products;

                $data['hide'] = "false";
                if ($total_product <= 12) {
                    $data['hide'] = "true";
                } else
                    $data['load_data'] = 'yes';

                $__catagory_list = [];

                $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
                $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);
                $data['category1'] = $category;

                foreach ($data['category1'] as $a => $b) {
                    $__catagory_list[] = $b['catagory_name'];
                }

                $seo_catagory = implode(',', $__catagory_list);
                $seo_catagory = preg_replace('/\s+/', ' ', $seo_catagory);

                $__keywords = explode(' ', $seo_catagory);

                foreach ($__keywords as $a => $b) {
                    $__keywords[$a] = trim(trim($b, ' '), ',');

                    if (strlen($b) < 3 || in_array($b, ['and', 'then', 'than', 'from'])) {
                        unset($__keywords[$a]);
                    }
                }

                $data['seo'] = [
                    'description' => 'By best products from catagory like ' . $seo_catagory . ' from ' . $user->username . ' at doukani',
                    'keyword' => implode(', ', $__keywords) . ' classified, doukani, seller'
                ];

                $this->load->view('home/seller', $data);
            } else {
                override_404();
            }
        } elseif (!empty($user) && $user_id != '' && $user_slug != NULL && $user_role == 'offerUser') {

            $data = array();
            $data = array_merge($data, $this->get_elements());
            $current_user = $this->session->userdata('gen_user');
            $data['current_user'] = $current_user;
            $data['user'] = $user;
            $company_details = $this->offer->company_details($user_slug);
            $data['company_details'] = $company_details;
            $company_id = $company_details['id'];

            $data['page_title'] = $company_details['company_name'] . " Offers";

            if (!empty($company_details['meta_title']))
                $meta_title = $company_details['meta_title'];
            else
                $meta_title = $data['page_title'];

            if (!empty($company_details['meta_description']))
                $meta_description = $company_details['meta_description'];
            else
                $meta_description = 'Browse ' . $company_details['company_name'] . "'s Company and find your favorite offers";

            $data['seo'] = [
                'title' => $meta_title,
                'description' => $meta_description . ' at doukani',
                'keyword' => ' doukani, offer, company ,seller, offeruser, ' . $company_details['company_name'] . ', ' . $company_details['user_slug'] . ', ' . $company_details['username'] . ', ' . $company_details['nick_name']
            ];

            $data['offer_company_page'] = 'yes';
            $data['company_id'] = $company_id;

            if ((int) $company_id > 0) {

                if ($user->nick_name != '')
                    $title = $user->nick_name;
                elseif ($user->username != '')
                    $title = $user->username;

                $data['seller_name'] = $title;
                $data['request_from'] = 'company_page';
                $data['seller_emailid'] = $user->email_id;
                $data['seller_id'] = $user->user_id;

                $similar_companies = $this->offer->company_details(NULL, 'all', $user->user_id, 0, 12);
                $data['similar_companies'] = $similar_companies;

                $total_followers = $this->dbcommon->get_myfollowers_count($user->user_id);
                $data['total_followers'] = $total_followers;

                $between_banners = $this->dbcommon->getBanner_forCategory('between', "'off_all_page','off_comp_cont'", NULL, NULL, NULL, $company_id);
                $data['between_banners'] = $between_banners;

                $current_views_count = $company_details['company_total_views'];
                $updated_views_count = $current_views_count + 1;

                $views_count = array(
                    'company_total_views' => $updated_views_count
                );

                $array = array('id' => $company_details['id']);
                $this->dbcommon->update('offer_user_company', $array, $views_count);

                $data['is_following'] = 0;
                $count_array = array('user_id' => $current_user['user_id'],
                    'seller_id' => $company_details['user_id']);

                $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
                $data['is_following'] = $following_count;

                if ($this->session->userdata('gen_user') != '') {
                    $data['current_user'] = $current_user;
                    $owner_email = $current_user['email_id'];
                    $data['owner_email'] = $owner_email;
                    $nick_name = $current_user['nick_name'];
                    $data['nick_name'] = $nick_name;
                    $user_id = $current_user['user_id'];
                    $data['user_id'] = $user_id;

                    $logged_in_user = $current_user['username'];

                    $data['is_logged'] = 1;
                    $data['login_username'] = $logged_in_user;
                    $data['loggedin_user'] = $current_user['user_id'];
                    //$in	=	array('product_id'=>$pro_id,'user_id'=>$current_user['user_id']);
                    //$this->dbcommon->insert('view_product',$in);
                } else {
                    $data['current_user'] = '';
                    $data['owner_email'] = '';
                    $data['nick_name'] = '';
                    $data['user_id'] = 0;
                    $data['is_logged'] = 0;
                    $data['login_username'] = null;
                    $data['current_user'] = '';
                    $data['loggedin_user'] = '';
                }

                $total_offers = $this->offer->offers_count(NULL, $company_details['user_id']);

                $offers_list = $this->offer->offers_list(0, $this->per_page, NULL, $company_details['user_id']);
                $data['offers_list'] = $offers_list;

                $data['hide'] = "false";
                if ($total_offers <= $this->per_page) {
                    $data['hide'] = "true";
                }

                $this->load->view('offer/company_offers', $data);
            } else {
                override_404();
            }
        } else {
            override_404();
        }
    }

    public function seller_listings_map($user_slug = NULL, $offer_name = NULL) {
        $array = array('user_slug' => $user_slug, 'is_delete' => 0, 'status' => 'active');
        $user = $this->dbcommon->get_row('user', $array);

        if (isset($user)) {
            $user_id = $user->user_id;
            $user_role = $user->user_role;
        }

        if (!empty($user) && $user_id != '' && $user_slug != NULL && $user_role != 'offerUser') {

            $current_user = $this->session->userdata('gen_user');

            $data = array();
            $data = array_merge($data, $this->get_elements());

            $data['current_page1'] = 'yes';
            $data['slug'] = $user_slug;
            $order_option = '';
            $view = '';
            if (isset($_GET['view']) && in_array($_GET['view'], array('map'))) {
                $sign = '&';
                $view = '?view=' . $_GET['view'];
            } else
                $sign = '?';
            if (isset($_REQUEST['order']))
                $order_option = $sign . 'order=' . $_REQUEST['order'];

            $data['order_option'] = $order_option;

            $data['product_page'] = 'yes';
            $data['seller_listing_page'] = 'yes';
            $data['request_from'] = 'seller_listing_page';

            $seller_option = '';
            if (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'lh')
                $seller_option = 'order=' . $_REQUEST['order'];
            elseif (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'hl')
                $seller_option = 'order=' . $_REQUEST['order'];

            $data['seller_option'] = $seller_option;
            $data['loggedin_user'] = '';
            $data['user'] = $user;

            if (sizeof($user) > 0) {

                if ($this->session->userdata('gen_user') != '')
                    $get_myfollowers = $this->dbcommon->get_myfollowers($user_id, $current_user['user_id']);
                else
                    $get_myfollowers = 0;

                $total_followers = $this->dbcommon->get_myfollowers_count($user_id);
                $data['followers'] = $total_followers;
                $data['get_myfollowers'] = $get_myfollowers;
                if ($user->contact_number != '')
                    $data['contact_no'] = $user->contact_number;
                elseif ($user->phone != '')
                    $data['contact_no'] = $user->phone;
                else
                    $data['contact_no'] = '-';

                $data['seller_emailid'] = $user->email_id;
                $data['seller_id'] = $user->user_id;
                $data['user_agree'] = 0;
                $data['loggedin_user'] = '';

                if ($user->nick_name != '')
                    $title = $user->nick_name;
                elseif ($user->username != '')
                    $title = $user->username;

                $data['seller_name'] = $title;
                $data['is_following'] = 0;
                $data['is_logged'] = 0;

                if ($this->session->userdata('gen_user')) {

                    $data['current_user'] = $current_user;
                    $data['is_logged'] = 1;
                    $logged_in_userid = $current_user['user_id'];
                    $data['login_userid'] = $logged_in_userid;

                    $count_array = array('user_id' => $current_user['user_id'],
                        'seller_id' => $user_id);

                    $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
                    $data['is_following'] = $following_count;

                    if ($current_user['nick_name'] != '')
                        $sender = $current_user['nick_name'];
                    else
                        $sender = $current_user['username'];
                    if ($current_user['contact_number'] != '')
                        $sender_number = $user->contact_number;
                    else
                        $sender_number = $user->phone;
                }
                else {
                    $data['login_userid'] = null;
                    $data['is_logged'] = 0;
                    $data['current_user'] = '';
                    $data['loggedin_user'] = '';
                }

                $emirate_sel = $this->uri->segment(1);
                if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                    $url = base_url() . $emirate_sel . '/' . $user_slug . '/?view=map' . $order_option;
                else
                    $url = base_url() . $user_slug . '/?view=map' . $order_option;

                $total_product = $this->dbcommon->seller_listing_count($user_id);

                $config = $this->dbcommon->pagination_front($total_product, $url);
                $this->pagination->initialize($config);

                $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
                $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];
                $data["links"] = $this->pagination->create_links();
                $data['page_title'] = $total_product . ' Ads of ' . $title;

                $products = $this->dbcommon->get_my_seller_listing($user_id, $offset, $config["per_page"]);

                $data['products'] = $products;

                $data['hide'] = "false";
                if ($total_product <= 12) {
                    $data['hide'] = "true";
                } else
                    $data['load_data'] = 'yes';

                $__catagory_list = [];

                $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
                $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);
                $data['category1'] = $category;

                foreach ($data['category1'] as $a => $b) {
                    $__catagory_list[] = $b['catagory_name'];
                }

                $seo_catagory = implode(',', $__catagory_list);
                $seo_catagory = preg_replace('/\s+/', ' ', $seo_catagory);

                $__keywords = explode(' ', $seo_catagory);

                foreach ($__keywords as $a => $b) {
                    $__keywords[$a] = trim(trim($b, ' '), ',');

                    if (strlen($b) < 3 || in_array($b, ['and', 'then', 'than', 'from'])) {
                        unset($__keywords[$a]);
                    }
                }

                $data['seo'] = [
                    'description' => 'By best products from catagory like ' . $seo_catagory . ' from ' . $user->username . ' at doukani',
                    'keyword' => implode(', ', $__keywords) . ' classified, doukani, seller'
                ];

                $this->load->view('home/category_map', $data);
//                if (isset($_GET['view']) && $_GET['view'] == 'list') {
//                    $this->load->view('home/seller_listview', $data);
//                } else {
//                    $this->load->view('home/seller', $data);
//                }
            } else {
                override_404();
            }
        } else {
            override_404();
        }
    }

    public function seller_followers($user_slug = NULL, $follow = NULL, $sub_domain = NULL) {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['current_page2'] = 'yes';
        if ($user_slug != NULL)
            $array = array('user_slug' => $user_slug, 'is_delete' => 0, 'status' => 'active');
        else {

            if ($follow == 'followers') {
                $where = " where store_domain ='" . $sub_domain . "' and store_status in (0,3) ";
                $store = $this->dbcommon->getdetails('store', $where);
                if (!empty($store))
                    $array = array('user_id' => $store[0]->store_owner, 'is_delete' => 0, 'status' => 'active');
            }
        }

        if (isset($array))
            $user = $this->dbcommon->get_row('user', $array);

        if (isset($user) && sizeof($user) > 0) {

            $user_id = $user->user_id;
            $current_user = $this->session->userdata('gen_user');

            if ($user->contact_number != '')
                $data['contact_no'] = $user->contact_number;
            elseif ($user->phone != '')
                $data['contact_no'] = $user->phone;
            else
                $data['contact_no'] = '-';

            $data['seller_emailid'] = $user->email_id;
            $data['seller_id'] = $user->user_id;

            $myfollowers = $this->dbcommon->get_myfollowerslist($user_id, $start = 0, $limit = 25);
            $total_followers = $this->dbcommon->get_myfollowers_count($user_id);

            $data['hide'] = "false";
            if ($total_followers <= 25) {
                $data['hide'] = "true";
            } else
                $data['load_data'] = 'yes';

            if ($user->nick_name != '')
                $title = $user->nick_name;
            elseif ($user->username != '')
                $title = $user->username;

            $data['seller_name'] = $title;
            $data['seller_emailid'] = $user->email_id;

            $data['is_following'] = 0;
            $data['is_logged'] = 0;

            if ($this->session->userdata('gen_user') != '') {
                $current_user = $this->session->userdata('gen_user');
                $data['current_user'] = $current_user;
                $logged_in_userid = $current_user['user_id'];
                $get_myfollowers = $this->dbcommon->get_myfollowers($user_id, $current_user['user_id']);
                $data['is_logged'] = 1;
                $data['login_userid'] = $logged_in_userid;

                $data['is_logged'] = 1;
                $logged_in_user = $current_user['username'];
                $data['login_username'] = $logged_in_user;

                $count_array = array('user_id' => $current_user['user_id'],
                    'seller_id' => $user_id);
                $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
                $data['is_following'] = $following_count;

                $data['loggedin_user'] = $current_user['user_id'];
            } else {
                $data['login_userid'] = null;
                $data['is_logged'] = 0;
                $data['current_user'] = '';
                $data['loggedin_user'] = '';
                $get_myfollowers = 0;
                $logged_in_user = '';
            }

            $data['get_myfollowers'] = $get_myfollowers;
            $data['myfollowers'] = $myfollowers;
            $data['followers'] = $total_followers;

            $title = '';
            //For Store USer Page
            if (!empty($store)) {

                $data['store_page'] = 'store_followers_page';
                $where = " where user_id ='" . $user_id . "' and is_delete=0 and status='active'";
                $store_user = $this->dbcommon->getdetails('user', $where);
                $data['store_user'] = $store_user;
                $data['store'] = $store;
                $data['store_url'] = HTTP . $store[0]->store_domain . after_subdomain . '/';

                $query_cnt = " product_id from product where product_posted_by='" . $store[0]->store_owner . "' and is_delete in (0,3) and product_deactivate IS NULL and product_is_inappropriate='Approve' and product_for='store' ";
                $count_no_of_post = $this->dbcommon->getnumofdetails_($query_cnt);
                $data['count_no_of_post'] = $count_no_of_post;

                $data['page_title'] = $store[0]->store_name . ' has ' . $count_no_of_post . ' ads';

                if (isset($store[0]->store_approved_on) && !empty($store[0]->store_approved_on))
                    $app_date = $store[0]->store_approved_on;
                else
                    $app_date = $store[0]->store_created_on;

                $store_user_regidate = $this->dbcommon->dateDiff(date('y-m-d H:i:s'), $app_date);
                $data['store_user_regidate'] = $store_user_regidate;

                $data['request_from'] = 'store_followers_page';
                $title = $store[0]->store_name;
                $data['page_title'] = $total_followers . ' Followers of ' . $title . '\'s store';

                $data['seo'] = [
                    'description' => 'Official store followers page for ' . $store[0]->store_name . ' at doukani',
                    'keyword' => 'store, store followers,followers, doukani,' . $store[0]->store_name . ''
                ];


                if ($this->session->userdata('gen_user') != '') {
                    $currentusr = $this->session->userdata('gen_user');
                    $logged_in_user = $currentusr['username'];
                    $data['is_logged'] = 1;
                    $data['login_username'] = $logged_in_user;
                    $data['loggedin_user'] = $currentusr['user_id'];

                    $count_array = array('user_id' => $currentusr['user_id'],
                        'seller_id' => $store_user[0]->user_id);

                    $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
                    $data['is_following'] = $following_count;

                    if ($currentusr['nick_name'] != '')
                        $sender = $currentusr['nick_name'];
                    else
                        $sender = $currentusr['username'];
                    if ($currentusr['contact_number'] != '')
                        $sender_number = $store_user[0]->contact_number;
                    else
                        $sender_number = $store_user[0]->phone;
                }
                else {
                    $data['is_logged'] = 0;
                    $data['login_username'] = null;
                    $data['current_user'] = '';
                    $data['loggedin_user'] = '';
                }

                $this->load->view('store/store_followers', $data);
            } else {
                $data['request_from'] = 'seller_followers_page';
                if ($user->nick_name != '')
                    $title = $user->nick_name;
                elseif ($user->username != '')
                    $title = $user->username;

                $data['page_title'] = $total_followers . ' Followers of ' . $title;

                $data['seo'] = [
                    'description' => 'Official followers page for ' . $user->username . ' at doukani',
                    'keyword' => 'followers, doukani,' . $user->username . ' ,classified'
                ];
                $data['user'] = $user;

                $this->load->view('home/followers', $data);
            }
        } else {
            override_404();
        }
    }

    public function show_prefix() {
        $main_data = array();
        if (isset($_REQUEST['value']) && $_REQUEST['value'] != '')
            $val = $_REQUEST['value'];
        else
            $val = 0;

        $query = "plate_source_id= " . $val;
        $main_data['plate_prefix'] = $this->dbcommon->filter('plate_prefix', $query);

        if (isset($_POST['sel_prefix']))
            $main_data['sel_prefix'] = $_POST['sel_prefix'];
        else
            $main_data['sel_prefix'] = '';
        echo $this->load->view('admin/listings/show_plate_prefix', $main_data, TRUE);
        exit;
    }

    /*
      send message to seller by buyer from common product details page and store product details page
     */

    public function send_reply() {
        if (isset($_POST['reply_submit'])) {

            $product_owner = $_POST['seller_id'];
            $productId = $_POST['productId'];

            $productName = $_POST['productName'];
            $email = $_POST['sender_email'];
            $name = $_POST['sender_name'];

            $que = ' where user_id=' . $product_owner . ' ';
            $user_email = $this->dbcommon->getrowdetails('user', $que);
            $message = json_encode($_POST['message']);

            $in_array = array(
                'product_id' => $productId,
                'sender_id' => $_POST['sender_id'],
                'receiver_id' => $product_owner,
                'message' => $message,
                'product_owner' => $user_email->user_id
            );

            $this->dbcommon->insert('buyer_seller_conversation', $in_array);
            $parser_data = array();

            $sender = $name;
            $button_label = 'Click here to login';
            $button_link = HTTPS . website_url . "login/index";
            $message = str_replace('\n', '', $message);
            $message = str_replace('\r', '', $message);

            $title = 'Reply for your Ad';
            $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> 
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Ad Title:</span> ' . $productName . ' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Sender is :</span> ' . $sender . ' </div>
            
<h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;"><strong>Message : </strong></h6>
        <hr>
        <p>' . $message . '</p>
        <br>
        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>';

            $new_data = $this->dbcommon->mail_format($title, $content);
            $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

            if (sizeof($user_email) > 0) {

                if ($user_email->chat_notification == 1) {
                    if (send_mail($user_email->email_id, 'Reply for your Ad: ' . $productName, $new_data, 'hello@doukani.com')) {
                        
                    }
                }

                $this->session->set_userdata('message_follow_unfllow', 'Your reply has been sent successfully');
                $this->session->set_userdata('send_msg', 'Your reply has been sent successfully');

                if (isset($_POST['request_from']) && !empty($_POST['request_from']))
                    header('Location:' . $_POST['redirect_url']);
                else
                    header('Location:' . HTTP . website_url);
            }
            else {
                if (isset($_POST['request_from']) && !empty($_POST['request_from']))
                    header('Location:' . $_POST['redirect_url']);
                else
                    header('Location:' . HTTP . website_url);
            }
        }
    }

    /*
      send message from store related pages or seller listing page
     */

    function send_msg_seller() {

        if (isset($_POST['send_mail']) && isset($_POST['message']) && $_POST['message'] != '') {
            $current_user = $this->session->userdata('gen_user');
            $in_arr = array(
                'sender_id' => $current_user['user_id'],
                'receiver_id' => $_POST['seller_id'],
                'message' => $_POST['message']
            );

            $this->dbcommon->insert('send_msg_seller', $in_arr);

            if ($current_user['nick_name'] != '')
                $sender = $current_user['nick_name'];
            elseif ($current_user['username'] != '')
                $sender = $current_user['username'];
            else
                $sender = $current_user['first_name'];

            $parser_data = array();
            $subject = $sender . ' has sent massage';
            $sender_name = $sender;
            $message = $_POST['message'];
            $message = str_replace('\n', '', $message);
            $message = str_replace('\r', '', $message);

            $button_label = 'Click here to login';
            $button_link = HTTP . website_url . "login/index";

            $title = $sender_name . ' has sent massage';
            $content = '
    <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>
    
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Sender:</span> ' . $sender_name . ' </div>
        <br>
        <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;"><strong>Message</strong></h6>
    <hr>
    <p>' . $message . '</p>
    <br>
    <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>';

            $new_data = $this->dbcommon->mail_format($title, $content);
            $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

            if (send_mail($_POST['seller_email'], $subject, $new_data, 'stores@doukani.com')) {

                $this->session->set_userdata('send_msg', 'Your message sent successfully');
                $this->session->set_flashdata('msg1', 'Your message sent successfully');

                if (isset($_POST['request_from']) && !empty($_POST['request_from']))
                    header('Location:' . $_POST['redirect_url']);
                else {
                    override_404();
                    exit;
                }
            } else {

                if (isset($_POST['request_from']) && !empty($_POST['request_from']))
                    header('Location:' . $_POST['redirect_url']);
                else {
                    override_404();
                    exit;
                }
            }
        } else {
            if (isset($_POST['redirect_url']))
                header('Location:' . $_POST['redirect_url']);
            else {
                override_404();
                exit;
            }
        }
    }

    public function send_report1() {
        // print_r($_POST);
        // exit;
        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user)) {
            $productCode = $_POST['productCode'];
            $productId = $_POST['productId'];
            $productName = $_POST['productName'];
            $report = $_POST['report'];
            $message = '<b>Report From:</b> ' . $current_user['username'] .
                    '<br/><b>Email:</b> ' . $current_user['email_id'] .
                    '<br/><b>Report for Product:</b> Name-' . $productName . ' | Id-' . $productId . ' | Code-' . $productCode . '<br/>' .
                    '<br/><b>Comments:</b><br/>' .
                    nl2br($_POST['comments']);

            $title = 'Report For A Doukani Product';
            $content = '
            <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>        
            <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Report from:</span> ' . $current_user["username"] . '</div>
            <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Email ID:</span> ' . $current_user['email_id'] . ' </div>
            <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Report for Product:</span> Name-' . $productName . ' | Id-' . $productId . '</div>
                <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Report Title:</span>' . $report . '</div>  
                <br>
                <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;"><strong>Comment</strong></h6>
            <hr>
            <p>' . nl2br($_POST['comments']) . '</p>
            </div>';
            $parser_data = array();
            $new_data = $this->dbcommon->mail_format($title, $content);
            $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

            if (send_mail('freeads@doukani.com', 'Report For A Doukani Product', $new_data)) {
//            if (send_mail('rep@narola.email', 'Report For A Doukani Product', $new_data)) {

                $this->session->set_userdata('send_msg', 'Your report sent successfully');

                if (isset($_POST['request_from']) && !empty($_POST['request_from']))
                    header('Location:' . $_POST['redirect_url']);
                else {
                    override_404();
                }
            } else {
                if (isset($_POST['request_from']) && !empty($_POST['request_from']))
                    header('Location:' . $_POST['redirect_url']);
                else {
                    override_404();
                }
            }
        } else {
            override_404();
        }
    }

    public function send_report() {
        $current_user = $this->session->userdata('gen_user');
//         print_r($current_user);
//         exit;
        if (isset($current_user)) {
            $productCode = $_POST['productCode'];
            $productId = $_POST['productId'];
            $productName = $_POST['productName'];
            $report = $_POST['report'];
            $message = '<b>Report From:</b> ' . $current_user['username'] .
                    '<br/><b>Email:</b> ' . $current_user['email_id'] .
                    '<br/><b>Report for Product:</b> Name-' . $productName . ' | Id-' . $productId . ' | Code-' . $productCode . '<br/>' .
                    '<br/><b>Comments:</b><br/>' .
                    nl2br($_POST['comments']);

            $title = 'Report For A Doukani Product';
            $content = '
            <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>        
            <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Report from:</span> ' . $current_user["username"] . '</div>
            <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Email ID:</span> ' . $current_user['email_id'] . ' </div>
            <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Report for Product:</span><a href="' . $_POST['redirect_url'] . '" > Name-' . $productName . ' | Id-' . $productId . '</a></div>
                <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Report Title:</span>' . $report . '</div>  
                <br>
                <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;"><strong>Comment</strong></h6>
            <hr>
            <p>' . nl2br($_POST['comments']) . '</p>
            </div>';
            $parser_data = array();
            $new_data = $this->dbcommon->mail_format($title, $content);
            $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

            if (send_mail('freeads@doukani.com', 'Report For A Doukani Product', $new_data)) {
//            if (send_mail('rep@narola.email', 'Report For A Doukani Product', $new_data)) {
                $reorted_items_data = array(
                    'reported_from' => $current_user["username"],
                    'email_id' => $current_user['email_id'],
                    'user_id' => $current_user['user_id'],
                    'report_for_product' => $productName,
                    'report_for_product_id' => $productId,
                    'report_title' => $report,
                    'comment' => $_POST['comments'],
                    'content' => $content,
                    'is_delete' => 0,
                    'link' => $_POST['redirect_url']
                );
                $this->dbcommon->insert(TBL_REPORTED_ITEMS, $reorted_items_data);

                $this->session->set_userdata('send_msg', 'Your report sent successfully');

                if (isset($_POST['request_from']) && !empty($_POST['request_from']))
                    header('Location:' . $_POST['redirect_url']);
                else {
                    override_404();
                }
            } else {
                if (isset($_POST['request_from']) && !empty($_POST['request_from']))
                    header('Location:' . $_POST['redirect_url']);
                else {
                    override_404();
                }
            }
        } else {
            override_404();
        }
    }

    function check_product_and_quantity() {
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity');

        if (isset($product_id) && isset($quantity)) {
            $this->dbcart->add_product_incart('multiple', $product_id);

            $check_product = $this->db->query("select * from product where product_id = '" . $product_id . "' limit 1")->row_array();

            if ($check_product['is_delete'] != 0 || $check_product['product_deactivate'] == 1 || $check_product['product_is_inappropriate'] != 'Approve') {
                echo 'Not Available';
            } elseif ($check_product['stock_availability'] <= 0)
                echo 'Out of stock';
            elseif ($quantity > $check_product['stock_availability'])
                echo $check_product['stock_availability'];
            else
                echo 'success';
            exit;
            //echo 'Only '.$check_product['stock_availability'] .' Available in Stock';
        }
    }

    public function valid_state() {

        $state_id = $this->input->get('state_id');

        if (isset($state_id) && !empty($state_id)) {

            $array = array('state_slug' => $state_id);
            $state = $this->dbcommon->get_row('state', $array);

            if (!empty($state)) {
                $this->session->set_userdata('request_for_statewise', $state_id);
                echo $state_id;
            } else {
                $this->session->unset_userdata('request_for_statewise');
                echo 'failure';
            }
        } else {
            $this->session->unset_userdata('request_for_statewise');
            echo 'success';
        }
        exit;
    }

    function load_more_subcategories() {

        $category_id = $this->input->post('category_id');

        $data['category_view'] = $this->input->post('category_view');
        $data['order_option'] = $this->input->post('order_option');

        $query = "category_id= '" . $category_id . "' AND FIND_IN_SET(0, sub_category_type) > 0 order by sub_cat_order ASC LIMIT 10, 1000000000";
        $subcat = $this->dbcommon->filter('sub_category', $query);

        $emirate = $_REQUEST['state_id_selection'];
        if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
            $data['emirate_slug'] = $emirate . '/';
        else
            $data['emirate_slug'] = '';

        $subcatArr = array();
        $i = 0;
        foreach ($subcat as $sub) {
            $subcatArr[$i]["id"] = $sub["sub_category_id"];
            $subcatArr[$i]["name"] = $sub["sub_category_name"];
            $subcatArr[$i]["sub_category_slug"] = $sub["sub_category_slug"];

            $array = array(
                'sub_category_id' => $sub["sub_category_id"],
                'product.product_is_inappropriate' => 'Approve',
                'product.product_deactivate' => null,
                'is_delete' => 0,
                'product_for' => 'classified'
            );

            $total = $this->dashboard->get_specific_count('product', $array);

            $subcatArr[$i]["total"] = $total;
            $i++;
        }
        $data['subcat'] = $subcatArr;
        $arr["html"] = $this->load->view('home/more_sub_categories', $data, TRUE);
        echo json_encode($arr);
        exit();
    }

    function latest_ads() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['product_page'] = 'yes';
        $between_banners = $this->dbcommon->getBanner_forCategory('between', "'latest_ads_page','all_page'", null, null);
        $data['page_title'] = 'Latest Ads';
        $data['latest_page'] = 'yes';
        if (isset($_GET['view']) && $_GET['view'] == 'list') {
            $product = $this->dbcommon->get_my_seller_listing(NULL, NULL, 12, 'yes');
            $total_product = $this->dbcommon->seller_listing_count();
        } else {
            $product = $this->dbcommon->get_product_by_categories(NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, 'yes');
            $total_product = $this->dbcommon->get_products_count();
        }

        $data['products'] = $product;
        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        } else
            $data['load_data'] = 'yes';

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $featured_product = $this->dbcommon->get_featured_ads(null, 12);
        $seo_word = '';
        foreach ($featured_product as $a => $b) {
            $seo_word .= $b['product_name'] . ', ';
            if ($a > 5) {
                break;
            }
        }

        $seo_word = rtrim($seo_word, ', ');
        $seo_word = preg_replace('/\s+/', '', $seo_word);

        $data['seo'] = [
            'description' => 'Classified latest ads ' . $seo_word . ' at doukani!',
            'keyword' => str_replace(' ', ', ', $seo_word) . ', Classified, doukani, '
        ];

        $seo_word = str_replace(',', ' ', preg_replace('/\s+/', '', $seo_word));

        $data['f_products'] = $featured_product;

        $data['between_banners'] = $between_banners;

        $this->load->view('home/latest_ads_listing', $data);
    }

    function latest_ads_map() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['slug'] = 'latest';
        $data['latest_page'] = 'yes';
        $data['product_page'] = 'yes';

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $emirate_sel = $this->uri->segment(1);
        if (in_array($emirate_sel, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
            $url = base_url() . $emirate_sel . '/latest/?view=map';
        else
            $url = base_url() . 'latest/?view=map';

        $featured_product = $this->dbcommon->get_featured_ads(null, 12);
        $data['f_products'] = $featured_product;

        if (isset($_GET['view']) && $_GET['view'] == 'list')
            $total_product = $this->dbcommon->seller_listing_count();
        else
            $total_product = $this->dbcommon->get_products_count();

        if ($total_product > 100)
            $total_product = 100;

        $config = $this->dbcommon->pagination_front($total_product, $url);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];

        if (isset($_GET['view']) && $_GET['view'] == 'list')
            $product = $this->dbcommon->get_my_seller_listing(NULL, $offset, $config["per_page"], 'yes');
        else
            $product = $this->dbcommon->get_product_by_categories(NULL, NULL, NULL, $config["per_page"], $offset, NULL, NULL, NULL, 'yes');

        $data['products'] = $product;

        $seo_word = '';
        foreach ($product as $a => $b) {
            $seo_word .= $b['product_name'] . ', ';
            if ($a > 5) {
                break;
            }
        }

        $seo_word = rtrim($seo_word, ', ');
        $seo_word = preg_replace('/\s+/', '', $seo_word);

        $data['seo'] = [
            'description' => 'Classified latest ads ' . $seo_word . ' at doukani!',
            'keyword' => str_replace(' ', ', ', $seo_word) . ', Classified, doukani, '
        ];

        $seo_word = str_replace(',', ' ', preg_replace('/\s+/', '', $seo_word));

        $data['page_title'] = 'Latest Ads';

        $this->load->view('home/category_map', $data);
    }

    function latest_more_ads() {

        $data = array();
        $filter_val = $this->input->post("value");
        if ($filter_val) {
            $data['latest_page'] = 'yes';

            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";

            if (isset($_POST['view']) && $_POST['view'] == 'list') {
                $product = $this->dbcommon->get_my_seller_listing(NULL, $start, 12, 'yes');
                $total_product = $this->dbcommon->seller_listing_count();
                $data['view'] = 'list';
            } else {
                $product = $this->dbcommon->get_product_by_categories(NULL, NULL, NULL, 12, $start, NULL, NULL, NULL, 'yes');
                $total_product = $this->dbcommon->get_products_count();
                $data['view'] = '';
            }

            $data['product_data'] = $product;
            $data['display_limit'] = 100;

            if ($end >= $total_product) {
                $hide = "true";
            }

            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }
            $data['req_numItems'] = $_POST['req_numItems'];

            if (isset($_POST['view']) && $_POST['view'] == 'list')
                $arr["html"] = $this->load->view('common/limit_data_load_listing', $data, TRUE);
            else
                $arr["html"] = $this->load->view('common/limit_data_load_grid', $data, TRUE);

            $show_button = true;
            if (($data['req_numItems'] + 12) > 100) {
                $show_button = false;
            }
            $arr["val"] = $hide;
            $arr["show_button"] = $show_button;
            echo json_encode($arr);
        } else {
            override_404();
        }
    }

    function check_email_id() {

        $check_email_id = $this->db->query('select user_id from user where email_id="' . $this->input->post('email_id') . '" limit 1')->row_array();

        if (isset($check_email_id) && sizeof($check_email_id) > 0)
            echo 'Email Address already exists';
        else
            echo "OK";
        exit;
    }

    function check_username() {

        $user_id = $this->input->post('user_id');
        $sql = '';
        if (isset($user_id) && !empty($user_id))
            $sql = ' and user_id<>' . $user_id;

        $check_username = $this->db->query('select user_id from user where username="' . $this->input->post('username') . '" ' . $sql . ' limit 1')->row_array();

        if (isset($check_username) && sizeof($check_username) > 0)
            echo 'Username already exists';
        else
            echo "OK";
        exit;
    }

    function check_store_name() {
        $user_id = $this->input->post('user_id');
        $sql = '';
        if (isset($user_id) && !empty($user_id))
            $sql = ' and store_owner<>' . $user_id;

        $check_store_name = $this->db->query('select store_id from store where store_name="' . $this->input->post('store_name') . '" ' . $sql . ' limit 1')->row_array();

        if (isset($check_store_name) && sizeof($check_store_name) > 0)
            echo 'Store name already exists';
        else
            echo "OK";
        exit;
    }

    function check_store_domain() {
        $user_id = $this->input->post('user_id');
        $sql = '';
        if (isset($user_id) && !empty($user_id))
            $sql = ' and store_owner<>' . $user_id;

        $check_store_domain = $this->db->query('select store_id from store where store_domain="' . $this->input->post('store_domain') . '" ' . $sql . ' limit 1')->row_array();

        if (isset($check_store_domain) && sizeof($check_store_domain) > 0)
            echo 'Store domain already exists';
        else
            echo "OK";
        exit;
    }

    function check_company_name() {
        $user_id = $this->input->post('user_id');
        $sql = '';
        if (isset($user_id) && !empty($user_id))
            $sql = ' and user_id<>' . $user_id;

        $check_company_name = $this->db->query('select user_id from offer_user_company where company_name="' . $this->input->post('company_name') . '" ' . $sql . ' limit 1')->row_array();

        if (isset($check_company_name) && sizeof($check_company_name) > 0)
            echo 'Company name already exists';
        else
            echo "OK";
        exit;
    }

}

?>