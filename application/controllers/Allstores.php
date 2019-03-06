<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Extending the custom controller
class Allstores extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('store', '', TRUE);
        $this->load->helper('page_not_found');
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

    function index() {

        $this->output->enable_profiler(TRUE);
        $data = array();

        $data = array_merge($data, $this->get_elements());
        $data['store_landing_page'] = 'yes';
        $data['product_page'] = 'yes';

        $between_banners = $this->dbcommon->getBanner_forCategory('between', "'store_all_page', 'store_page_content'", NULL, NULL, NULL, NULL);
        $arr['between_banners'] = $between_banners;

        $__catagory_list = [];

        $wh_category_data = array('FIND_IN_SET(1, category_type) > 0');
        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);
        $data['category'] = $category;
        foreach ($category as $a => $b) {
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
            'description' => 'Browse best seller products from catagory like ' . $seo_catagory . ' at doukani',
            'keyword' => implode(', ', $__keywords) . ' store products, classified, doukani, store, shop , featured stores, seller'
        ];

        $data['page_title'] = 'Store Products';
        $data['is_following'] = 0;

        $current_user = $this->session->userdata('gen_user');
        if ($this->session->userdata('gen_user') != '') {
            $data['current_user'] = $current_user;
            $logged_in_user = $current_user['user_id'];
            $data['is_logged'] = 1;
            $data['login_userid'] = $logged_in_user;
            $data['loggedin_user'] = $current_user['user_id'];
        } else {
            $data['is_logged'] = 0;
            $data['login_userid'] = null;
            $data['current_user'] = '';
            $data['loggedin_user'] = '';
        }

        $featured_stores = $this->store->get_featuredstore(NULL, NULL, 1);
        $data['featured_stores'] = $featured_stores;
//         echo $this->db->last_query();
        // exit;
//        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
        $wh_category_data = array('FIND_IN_SET(1, category_type) > 0');
        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);

        foreach ($category as $key => $value) {
            $where = " category_id=" . $value['category_id'] . " AND FIND_IN_SET(1, sub_category_type) > 0 order by sub_cat_order asc";
            $sub_categories = $this->dbcommon->filter('sub_category', $where);
            $category[$key]['sub_categories'] = $sub_categories;
        }

        $data['category'] = $category;
        $per_page = 15;

//        if ($_SERVER['REMOTE_ADDR'] == '203.109.68.198') {
        $per_page = 100;
//        }
//        $data['stores'] = $this->store->get_stores(NULL, 0, $per_page);
//        if($_SERVER['REMOTE_ADDR'] == '203.109.68.198') {
            $listing = $this->dbcommon->get_my_listing(NULL, $start = 0, $limit = 100, NULL, 0, 'storeUser', 'store',NULL,NULL,'yes');
//        }else{
//        $listing = $this->dbcommon->get_my_listing(NULL, $start = 0, $limit = 15, NULL, 0, 'storeUser', 'store', NULL, NULL, 'yes');
//        }
//        echo $this->db->last_query();
        $data['listing'] = $listing;
        $total_product = $this->dbcommon->get_my_listing_count(NULL, NULL, 0, 'storeUser', 'store');
        $data['total_product'] = $total_product;

        $data['hide'] = "false";
        if ($total_product <= $per_page) {
            $data['hide'] = "true";
        }

        $this->load->view('store/all_stores', $data);
        $this->output->enable_profiler(FALSE);
    }

    function get_stores() {

        $main_data = array();
        $filter_val = $this->input->post("value", TRUE);

        if (isset($filter_val)) {

            $current_user = $this->session->userdata('gen_user');
            if ($this->session->userdata('gen_user') != '') {
                $main_data['current_user'] = $current_user;
                $logged_in_user = $current_user['user_id'];
                $main_data['is_logged'] = 1;
                $main_data['login_userid'] = $logged_in_user;
                $main_data['loggedin_user'] = $current_user['user_id'];
            } else {
                $main_data['is_logged'] = 0;
                $main_data['login_userid'] = null;
                $main_data['current_user'] = '';
                $main_data['loggedin_user'] = '';
            }


            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";
            $cat_id = $this->input->post('cat_id', TRUE);
            $filters = $this->input->post('filters', TRUE);
            $per_page = 12;
            $this->load->model('store');
            $stores = $this->store->get_stores("" . $cat_id . "", 0, $per_page, $filters);
            $total_stores = $this->store->get_stores_count("" . $cat_id . "", $filters);
//            echo $this->db->last_query();

            $main_data['hide'] = "false";
            if ($total_stores <= $per_page) {
                $main_data['hide'] = "true";
            }
            $main_data["total_stores"] = $total_stores;
            $main_data["val"] = $main_data['hide'];
            $main_data['stores'] = $stores;

            $main_data['html'] = $this->load->view('store/store_grid_view', $main_data, TRUE);
            echo json_encode($main_data);
            exit();
        } else {
            override_404();
        }
    }

    function addfollow() {

        $current_user = $this->session->userdata('gen_user');
        $user_id = (int) $current_user['user_id'];
        $seller_id = $this->uri->segment(3);

        if (isset($user_id) && isset($seller_id)) {

            $insertArr = array(
                'user_id' => $user_id,
                'seller_id' => $seller_id
            );

            $where = array('user_id' => $user_id, 'seller_id' => $seller_id);
            $cnt = $this->dbcommon->get_count('followed_seller', $where);

            if ($cnt > 0) {
                $this->session->set_flashdata(array('msg1' => 'You have already been followed this seller.', 'class' => 'alert-info'));

                if ($store != '' && $store == 'store') {
                    $where = " where store_owner ='" . $seller_id . "' and store_status=0 and store_is_inappropriate='Approve'";
                    $store = $this->dbcommon->getdetails('store', $where);

                    $this->session->set_userdata('send_msg', 'You have already been followed this seller.');
                    header('Location:' . HTTP . website_url . 'stores');
                } else
                    redirect('stores');
            }
            else {
                $this->dbcommon->insert('followed_seller', $insertArr);

                //for seller follow count increment
                $query = ' where user_id=' . (int) $seller_id;
                $sel_del = $this->dbcommon->getrowdetails('user', $query, $offset = '0', $limit = '1');
                $sll_inc = array("followers_count" => $sel_del->followers_count + 1);
                $wh = array('user_id' => $seller_id);
                //echo $this->db->last_query();
                $this->dbcommon->update('user', $wh, $sll_inc);

                //for logged in user following_count increment
                $use = ' where user_id=' . (int) $user_id;
                $use_del = $this->dbcommon->getrowdetails('user', $use, $offset = '0', $limit = '1');
                $use_inc = array("following_count" => $use_del->following_count + 1);
                $wh1 = array('user_id' => $user_id);
                $this->dbcommon->update('user', $wh1, $use_inc);

                $this->session->set_flashdata(array('msg1' => 'You have been followed this seller.', 'class' => 'alert-info'));

                if ($store != '' && $store == 'store') {
                    $where = " where store_owner ='" . $seller_id . "' and store_status=0 and store_is_inappropriate='Approve'";
                    $store = $this->dbcommon->getdetails('store', $where);
                    $this->session->set_userdata('send_msg', 'You have been followed this seller.');
                    //redirect('store/store/'.$store[0]->store_domain);

                    header('Location:' . HTTP . website_url . 'stores');
                } else
                    redirect('stores');
            }
        }
        else {
            override_404();
        }
    }

    public function unfollow() {

        $current_user = $this->session->userdata('gen_user');
        $user_id = (int) $current_user['user_id'];

        $seller_id = $this->uri->segment(3);

        if ($user_id > 0 && isset($seller_id)) {
            $where = array('user_id' => $user_id, 'seller_id' => $seller_id);
            $cnt = $this->dbcommon->get_count('followed_seller', $where);
            if ($cnt > 0) {
                $arr = array('user_id' => $user_id,
                    'seller_id' => $seller_id
                );
                $this->dbcommon->delete('followed_seller', $arr);
                //for seller follow count decrement
                $query = ' where user_id=' . (int) $seller_id;
                $sel_del = $this->dbcommon->getrowdetails('user', $query, $offset = '0', $limit = '1');
                $sll_inc = array("followers_count" => $sel_del->followers_count - 1);
                $wh = array('user_id' => $seller_id);

                $this->dbcommon->update('user', $wh, $sll_inc);

                //for logged in user following_count decrement
                $use = ' where user_id=' . (int) $user_id;
                $use_del = $this->dbcommon->getrowdetails('user', $use, $offset = '0', $limit = '1');
                $use_inc = array("following_count" => $use_del->following_count - 1);
                $wh1 = array('user_id' => $user_id);
                $this->dbcommon->update('user', $wh1, $use_inc);
                $this->session->set_flashdata(array('msg1' => 'You have been unfollowed this seller.', 'class' => 'alert-info'));
                if ($store != '' && $store == 'store') {
                    $where = " where store_owner ='" . $seller_id . "' and store_status=0 and store_is_inappropriate='Approve'";
                    $store = $this->dbcommon->getdetails('store', $where);

                    //header('Location:'.HTTPS.$store[0]->store_domain.'.'.website_url);
                    $this->session->set_userdata('send_msg', 'You have been unfollowed this seller');
                    header('Location:' . HTTP . website_url . 'stores');
                    //redirect('store/store/'.$store[0]->store_domain);
                } else
                    redirect('stores');
            }
            else {

                if ($store != '' && $store == 'store') {
                    $where = " where store_owner ='" . $seller_id . "' and store_status=0 and store_is_inappropriate='Approve'";
                    $store = $this->dbcommon->getdetails('store', $where);

                    //header('Location:'.HTTPS.$store[0]->store_domain.'.'.website_url);
                    header('Location:' . HTTP . website_url . 'stores');
                    //redirect('store/store/'.$store[0]->store_domain);
                } else
                    redirect('stores');
            }
        }
        else {
            redirect('login/index');
        }
    }

    function load_more_stores() {

        $filter_val = $this->input->post("value", TRUE);

        if (isset($filter_val)) {

            $main_data = array();
            $main_data['is_logged'] = 0;
            $main_data['loggedin_user'] = '';

            $current_user = $this->session->userdata('gen_user');
            if ($this->session->userdata('gen_user') != '') {
                $main_data['current_user'] = $current_user;
                $logged_in_user = $current_user['user_id'];
                $main_data['is_logged'] = 1;
                $main_data['login_userid'] = $logged_in_user;
                $main_data['loggedin_user'] = $current_user['user_id'];
            } else {
                $main_data['is_logged'] = 0;
                $main_data['login_userid'] = null;
                $main_data['current_user'] = '';
                $main_data['loggedin_user'] = '';
            }

            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";

            if (isset($_POST['cat_id']))
                $cat_id = $this->input->post('cat_id', TRUE);
            else
                $cat_id = NULL;

            $store_search = 0;
            if (isset($_POST['search_store']))
                $store_search = 1;

            if (isset($_POST['search_word']))
                $search_word = $this->input->post('search_word', TRUE);
            else
                $search_word = NULL;

            $per_page = 12;
            $filter = $this->input->post('filters');
            $stores = $this->store->get_stores("" . $cat_id . "", $start, $per_page, $filter, $search_word);
            $main_data['stores'] = $stores;

            $total_stores = $this->store->get_stores_count("" . $cat_id . "", $filter, $search_word);

            $hide = "false";
            $main_data['hide'] = "false";
            if ($end >= $total_stores) {
                $hide = "true";
            }

            $main_data["val"] = $hide;

//            if ($store_search == 1)
//                $main_data['html'] = $this->load->view('store/more_search_stores', $main_data, TRUE);
//            else
            $main_data['html'] = $this->load->view('store/store_grid_view', $main_data, TRUE);

            echo json_encode($main_data);
        }
    }

    function store_search() {

        $data = array();

        $data = array_merge($data, $this->get_elements());
        $data['product_page'] = 'yes';
        $data['page_title'] = 'Search Stores';
        $data['is_following'] = 0;

        $current_user = $this->session->userdata('gen_user');
        if ($this->session->userdata('gen_user') != '') {
            $data['current_user'] = $current_user;
            $logged_in_user = $current_user['user_id'];
            $data['is_logged'] = 1;
            $data['login_userid'] = $logged_in_user;
            $data['loggedin_user'] = $current_user['user_id'];
        } else {
            $data['is_logged'] = 0;
            $data['login_userid'] = null;
            $data['current_user'] = '';
            $data['loggedin_user'] = '';
        }

        $per_page = 12;
        $search_word = $this->input->get_post('search_value', TRUE);

        $data['stores'] = $this->store->get_stores(NULL, 0, $per_page, NULL, $search_word);
        $total_stores = $this->store->get_stores_count(NULL, NULL, $search_word);

        $total_stores;
        $data['hide'] = "false";
        if ($total_stores <= $per_page) {
            $data['hide'] = "true";
        }

        $this->load->view('store/store_search_page', $data);
    }

}

?>