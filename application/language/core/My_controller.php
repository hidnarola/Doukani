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
          $where = " category_id=".$value['category_id'];
          $sub_categories = $this->dbcommon->filter('sub_category', $where);
          $category[$key]['sub_categories'] = $sub_categories;
        }
          
        $data['category'] = $category;

        $where = " country_id=4";
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

}