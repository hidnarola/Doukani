<?php defined('BASEPATH') OR exit('No direct script access allowed');
class My_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('dbcommon', '', TRUE);
	}

	public function get_elements(){
        $data = array();
        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
   
        foreach ($category as $key=>$value) {
          $where = " category_id=".$value['category_id']. " order by sub_cat_order asc" ;
          $sub_categories = $this->dbcommon->filter('sub_category', $where);
          $category[$key]['sub_categories'] = $sub_categories;		  
        }
          
        $data['category'] = $category;
		$location = $this->dbcommon->select('country');
		$data['location'] = $location;

        $where = " country_id=4  order by sort_order";
        $state = $this->dbcommon->filter('state', $where);
        $data['state'] = $state;
        $pages_fields = ' page_id, page_title, slug_url, parent_page_id ';
        $array = array('page_state'=>1,
            'show_in_header'=>1);
        $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields , $array, 'order', 'asc');
        $data['header_menu'] = $header_menu;

        $array = array('page_state'=>1,
            'show_in_footer'=>1);

        $footer_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields , $array, 'order', 'asc');

        foreach ($footer_menu as $key=>$value) {
             $pages_fields = ' page_id, page_title, slug_url, icon, parent_page_id, direct_url ';
             $array = array('page_state'=>1,
                
            'parent_page_id'=>$value['page_id']);
             $footer_sub_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields , $array, 'order', 'asc');
             
             $footer_menu[$key]['sub_menu'] = $footer_sub_menu;
        }
       
        $data['footer_menu'] = $footer_menu;

        return $data;
    }

    public function get_user_ads(){
        $where = " where `key` = 'no_of_post_month'";
        $settings = $this->dbcommon->getrowdetails('settings', $where);
    
        $no_of_post_month = $settings->val;
        $fields = ' user_id, userAdsLeft, userTotalAds ';
        $result = $this->dbuser->get_specific_colums('user', $fields);
      
        foreach ($result as $res) {
            $array = array('product_posted_by' => $res['user_id'],
                'is_delete'=>0
                );
            $used_ads = $this->dashboard->get_specific_count('product', $array);
            
            $updated_left_ads = (int) $no_of_post_month - $used_ads;
            $ads[] = array('user_id'=>$res['user_id'],
                'userAdsLeft'=>$updated_left_ads
                );
        
            $data = array(
                'userAdsLeft' => $updated_left_ads
            );
            $array = array('user_id' => $res['user_id']);
            $this->dbcommon->update('user', $array, $data);
        }   
    }
}