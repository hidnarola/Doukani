<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stores extends My_controller {

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
        
        $emirate =  $this->uri->segment(1);
        if(empty($emirate))
            $this->session->unset_userdata('request_for_statewise');
        
        if(!empty($emirate) && in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain'))) {
            $this->session->set_userdata('request_for_statewise',$emirate);
            $emirate =  $this->session->userdata('request_for_statewise');
        }
        elseif(isset($_REQUEST['state_id_selection']))
           $emirate = $_REQUEST['state_id_selection'];
        elseif($this->session->userdata('request_for_statewise')!='') {
            $emirate =  $this->session->userdata('request_for_statewise');
        }
        
        if(in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain')))
            define("emirate_slug",$emirate.'/');            
        else
            define("emirate_slug",'');
    }
    
    public function index() {
    
        $data = array();
        $data['store_landing_page'] = 'yes';
        $data = array_merge($data, $this->get_elements());
        $data['product_page'] = 'yes';
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
            'description' => 'Browse best seller stores for products from catagory like ' . $seo_catagory . ' at doukani',
            'keyword' => implode(', ', $__keywords) . ' classified, doukani, store, shop , featured stores, seller'
        ];
        
        $data['page_title'] = 'All Stores';
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
        $store_page_content = $this->store->findStoreContent();
        $data['store_page_content'] = $store_page_content->page_content;
        $feature_banners = $this->dbcommon->getBanner_forCategory('sidebar',"'store_page_content'", NULL, NULL, NULL, NULL);
        $data['feature_banners'] = $feature_banners;
        $this->load->view('store/index',$data);
        
    }
}