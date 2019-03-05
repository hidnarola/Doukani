<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Extending the custom controller
class Alloffers extends My_controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('offer', '', TRUE);
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

    public function index() {

        $data = array();
        $data = array_merge($data, $this->get_elements());

        $data['seo'] = [
            'description' => 'Browse best, hot and incredible offers from different companies at doukani',
            'keyword' => ' offers, doukani, company, featured offers'
        ];

        $data['page_title'] = 'All Offers';
        $offer_company = ' company_status = 0 ';

        $company_list = $this->offer->company_details(NULL, 'all', NULL, 0, 11);
        $data['company_list'] = $company_list;

        $offers_where = ' company_status = 0 ';
        $featured_offers = $this->offer->offers_list(0, $this->per_page, NULL, NULL, "featured");
        $data['offers_list'] = $featured_offers;
        $data['offer_home'] = 'yes';

        $company_banner = $this->dbcommon->getBanner_forCategory('sidebar', "'off_comp_side'", null, null);
        $category_banner = $this->dbcommon->getBanner_forCategory('sidebar', "'off_cat_side'", null, null);
        if (isset($company_banner[0]['ban_id']) && $company_banner[0]['ban_id'] != '') {

            $mycnt = $company_banner[0]['impression_count'] + 1;
            $array1 = array('ban_id' => $company_banner[0]['ban_id']);
            $data1 = array('impression_count' => $mycnt);
            $this->dbcommon->update('custom_banner', $array1, $data1);
        }

        if (isset($category_banner[0]['ban_id']) && $category_banner[0]['ban_id'] != '') {
            $mycnt = $category_banner[0]['impression_count'] + 1;
            $array1 = array('ban_id' => $category_banner[0]['ban_id']);
            $data1 = array('impression_count' => $mycnt);
            $this->dbcommon->update('custom_banner', $array1, $data1);
        }

        $data['company_banner'] = $company_banner;
        $data['category_banner'] = $category_banner;

        $this->load->view('offer/offer_home', $data);
    }

    function companies() {

        $data = array();
        $data = array_merge($data, $this->get_elements());

        $data['page_title'] = 'Offer Companies';

        $company_list = $this->offer->company_details(NULL, 'all', NULL, 0, $this->per_page);
        $data['company_list'] = $company_list;

        $__company_list = [];

        foreach ($company_list as $a => $b) {
            $__company_list[] = $b['company_name'];
        }

        $seo_company_list = implode(',', $__company_list);
        $seo_company_list = preg_replace('/\s+/', ' ', $seo_company_list);

        $__keywords = explode(' ', $seo_company_list);

        foreach ($__keywords as $a => $b) {
            $__keywords[$a] = trim(trim($b, ' '), ',');

            if (strlen($b) < 3 || in_array($b, ['and', 'then', 'than', 'from'])) {
                unset($__keywords[$a]);
            }
        }

        $data['seo'] = [
            'description' => 'Browse best, hot and incredible offers from companies like ' . $seo_company_list . ' at doukani',
            'keyword' => implode(', ', $__keywords) . ' offers, doukani, browse, company'
        ];

        $total_companies = $this->offer->company_count(NULL, 'all');
        $data['hide'] = "false";
        if ($total_companies <= $this->per_page) {
            $data['hide'] = "true";
        }

        $this->load->view('offer/category_companies', $data);
    }

    /*
     * Offers List Category wise and all
     */

    function offers() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'Offers List';

        if (isset($_GET['cat_id']))
            $cat_id = $_GET['cat_id'];
        else
            $cat_id = NULL;

        $__catagory_list = [];

        $wh_category_data = array('FIND_IN_SET(2, category_type) > 0');
        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);

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
            'description' => 'Browse & Search best, hot and incredible offers from catagory like ' . $seo_catagory . ' at doukani',
            'keyword' => implode(', ', $__keywords) . ' offers, doukani, search, browse, category'
        ];

        $where = " category_id = '" . $cat_id . "' AND FIND_IN_SET(2, category_type) > 0 ";
        $category = $this->dbcommon->filter('category', $where);

        if (sizeof($category) > 0) {
            $data['category_name'] = $category[0]['catagory_name'];
        }
        $between_banners = $this->dbcommon->getBanner_forCategory('between', "'off_cat_cont','off_all_page'", $cat_id, 0);
        $data['between_banners'] = $between_banners;
        $data['request_company_name'] = 'yes';

        $offers_list = $this->offer->offers_list(NULL, $this->per_page, $cat_id);
        $data['offers_list'] = $offers_list;
        $total_offers = $this->offer->offers_count($cat_id);

        $data['hide'] = "false";
        if ($total_offers <= $this->per_page) {
            $data['hide'] = "true";
        }

        $this->load->view('offer/category_offers', $data);
    }

    function offer_details_page() {
        $user_slug = $this->uri->segment(1);
        $offer_slug = $this->uri->segment(2);
        $data = array();
        $data = array_merge($data, $this->get_elements());

        $array = array('user_slug' => $user_slug, 'is_delete' => 0, 'status' => 'active', 'user_role' => 'offerUser');
        $check_user_slug = $this->dbcommon->get_row('user', $array);

        $user_id = $check_user_slug->user_id;

        $check_offer_slug = $this->offer->offers_list(NULL, NULL, NULL, $user_id, NULL, NULL, $offer_slug, NULL, 'yes');
//        if($_SERVER['REMOTE_ADDR'] == '203.109.68.198') {
            $con = 'is_active = 1 AND offer_id = ' . $check_offer_slug['offer_id'];
            $data['offer_images'] = $this->dbcommon->select('offer_images', $con);
            
//        }
        $current_user = $this->session->userdata('gen_user');

        if ($user_slug != NULL && isset($check_user_slug) && !empty($check_user_slug)) {

            if ($offer_slug != NULL && $offer_slug == 'followers') {
                $data['company_followers_page'] = 'yes';
                $data['request_from'] = 'company_followers_page';
                $data['user'] = $check_user_slug;
                $company_details = $this->offer->company_details($user_slug);
                $data['company_details'] = $company_details;
                $company_id = $company_details['id'];

                $data['seller_emailid'] = $check_user_slug->email_id;
                $data['seller_id'] = $check_user_slug->user_id;

                if ($check_user_slug->nick_name != '')
                    $title = $check_user_slug->nick_name;
                elseif ($check_user_slug->username != '')
                    $title = $check_user_slug->username;

                $data['seller_name'] = $title;

                $data['is_following'] = 0;
                $count_array = array('user_id' => $current_user['user_id'],
                    'seller_id' => $company_details['user_id']);

                $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
                $data['is_following'] = $following_count;

                $similar_companies = $this->offer->company_details(NULL, 'all', $user_id, 0, $this->per_page);
                $data['similar_companies'] = $similar_companies;

                $myfollowers = $this->dbcommon->get_myfollowerslist($user_id, $start = 0, $limit = 25);
                $total_followers = $this->dbcommon->get_myfollowers_count($user_id);

                $data['myfollowers'] = $myfollowers;
                $data['total_followers'] = $total_followers;
                $data['page_title'] = $total_followers . " Followers of " . $company_details['company_name'];

                $data['hide'] = "false";
                if ($total_followers <= 25) {
                    $data['hide'] = "true";
                } else
                    $data['load_data'] = 'yes';

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

                $this->load->view('offer/company_followers', $data);
            } elseif ($offer_slug != NULL && isset($check_offer_slug) && !empty($check_offer_slug)) {

                if ($check_user_slug->nick_name != '')
                    $title = $check_user_slug->nick_name;
                elseif ($check_user_slug->username != '')
                    $title = $check_user_slug->username;

                $total_followers = $this->dbcommon->get_myfollowers_count($check_user_slug->user_id);
                $data['total_followers'] = $total_followers;
                $data['seller_name'] = $title;
                $data['request_from'] = 'company_page';
                $data['seller_emailid'] = $check_user_slug->email_id;
                $data['seller_id'] = $check_user_slug->user_id;

                $data['request_from'] = 'company_offer_page';
                $data['user'] = $check_user_slug;
                $company_details = $this->offer->company_details($user_slug);
                $data['company_details'] = $company_details;                
                
                $data['check_offer_slug'] = $check_offer_slug;
                $data['page_title'] = $check_offer_slug['offer_title'];
                $data['offer_detail'] = 'yes';

                $user_id = $check_offer_slug['user_id'];

                $current_views_count = $check_offer_slug['offer_total_views'];
                $updated_views_count = $current_views_count + 1;

                $views_count = array(
                    'offer_total_views' => $updated_views_count
                );
                $data['updated_views_count'] = $updated_views_count;

                $array = array('offer_id' => $check_offer_slug['offer_id']);
                $this->dbcommon->update('offers', $array, $views_count);

                $related_offers = $this->offer->offers_list(0, 3, NULL, $user_id, NULL, 'yes', NULL, $check_offer_slug['offer_id']);
                $data['offers_list'] = $related_offers;

                $featured_banners = $this->dbcommon->getBanner_forCategory('sidebar', "'off_catent_page','off_all_page'", null, null);
                $data['featured_banners'] = $featured_banners;

                if (isset($featured_banners[0]['ban_id']) && $featured_banners[0]['ban_id'] != '') {
                    $mycnt = $featured_banners[0]['impression_count'] + 1;
                    $array1 = array('ban_id' => $featured_banners[0]['ban_id']);
                    $data1 = array('impression_count' => $mycnt);
                    $this->dbcommon->update('custom_banner', $array1, $data1);
                }

                $data['current_user'] = $current_user;
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

                $data['is_following'] = 0;
                $count_array = array('user_id' => $current_user['user_id'],
                    'seller_id' => $check_offer_slug['user_id']);

                $following_count = $this->dbcommon->get_count('followed_seller', $count_array);
                $data['is_following'] = $following_count;

                $this->load->view('offer/offer_details', $data);
            } else {
                override_404();
            }
        } else {
            override_404();
        }
    }

    function load_companies() {
        $data = array();
        $wh_cat = '';
        $hide = "false";
        $is_value = 0;
        $cat_id = NULL;
        if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
            $cat_id = $_POST['category_id'];
        }
        if (isset($_POST['value'])) {
            $is_value = 1;
            $filter_val = $this->input->post("value");
        } else
            $filter_val = 1;


        $data['request_company_name'] = 'yes';
        $total_companies = $this->offer->company_count(NULL, 'all');

        if (isset($_POST['value'])) {
            $is_value = 1;
            $filter_val = $this->input->post("value");
            $start = $this->per_page * $filter_val;
            $end = $start + $this->per_page;
            $hide = "false";
            if ($end >= $total_companies) {
                $hide = "true";
            }
        } else {
            $filter_val = 1;
            $hide = "false";
            if ($total_companies <= $this->per_page) {
                $hide = "true";
            }
        }

//        $start = $this->per_page * $filter_val;
//        $end = $start + $this->per_page;
//
//        $start = $this->per_page * $filter_val;
//        $end = $start + $this->per_page;
//        
//        if ($end >= $total_companies) {
//            $hide = "true";
//        }

        if ($is_value == 1) {
            
        } else
            $start = 0;

        $data['company_list'] = $this->offer->company_details(NULL, 'all', NULL, $start, $this->per_page);
        $arr["html"] = $this->load->view('offer/companies_logo_list', $data, TRUE);
        $arr["val"] = $hide;
        echo json_encode($arr);
    }

    /*
     * Display Grid / List View for Offrs - using jquery     * 
     */

    function offer_grid_list_view() {

        $data = array();
        $is_value = 0;
        $category_id = NULL;

        if (isset($_POST['category_id']) && !empty($_POST['category_id']))
            $category_id = $_POST['category_id'];

        $total_offers = $this->offer->offers_count($category_id);

        if (isset($_POST['value'])) {
            $is_value = 1;
            $filter_val = $this->input->post("value");
        } else
            $filter_val = 1;

        $start = $this->per_page * $filter_val;
        $end = $start + $this->per_page;

        $hide = "false";
        if ($end >= $total_offers) {
            $hide = "true";
        }

        if (isset($_POST['off_user_id'])) {

            $user_comapny_id = $this->input->post('user_company_id');
            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'off_all_page','off_comp_cont'", NULL, NULL, NULL, $user_comapny_id);
            $data['between_banners'] = $between_banners;
            $data['request_company_name'] = 'no';
        } else {
            $data['request_company_name'] = 'yes';
            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'off_all_page','off_cat_cont'", $category_id, 0);
            $data['between_banners'] = $between_banners;
        }
        if ($is_value == 1)
            $offers_list = $this->offer->offers_list($start, $this->per_page, $category_id);
        else
            $offers_list = $this->offer->offers_list(0, $this->per_page, $category_id);

        $data['offers_list'] = $offers_list;

        if (isset($_POST['view']) && $_POST['view'] == 'list')
            $arr["html"] = $this->load->view('offer/offer_list_view', $data, TRUE);
        else
            $arr["html"] = $this->load->view('offer/offer_grid_view', $data, TRUE);

        $arr["val"] = $hide;
        echo json_encode($arr);
    }

}

?>  