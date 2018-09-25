<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class My_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('dbcommon', '', TRUE);
        $this->load->library('facebook');
        $this->load->library('googleplus');
        $this->load->library('twconnect');
    }

    public function get_elements() {
        
        $data = array();
//        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
                
        $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);
        
        foreach ($category as $key => $value) {
            $where = " category_id=" . $value['category_id'] . " AND FIND_IN_SET(0, sub_category_type) > 0 order by sub_cat_order asc";
            $sub_categories = $this->dbcommon->filter('sub_category', $where);
            $category[$key]['sub_categories'] = $sub_categories;
        }

        $data['category'] = $category;
        $location = $this->dbcommon->select('country');
        $data['location'] = $location;

        $where = " country_id=4 order by sort_order";
        $state = $this->dbcommon->filter('state', $where);
        $data['state'] = $state;
        
        $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
        $array = array('page_state' => 1,
            'show_in_header' => 1);
        $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');
        $data['header_menu'] = $header_menu;

        $array = array('page_state' => 1, 'show_in_footer' => 1);

        $footer_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

        foreach ($footer_menu as $key => $value) {
            $pages_fields = ' page_id, page_title, slug_url, icon, parent_page_id, direct_url, color ';
            $array = array('page_state' => 1,
                'parent_page_id' => $value['page_id']);
            $footer_sub_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

            $footer_menu[$key]['sub_menu'] = $footer_sub_menu;
        }
        
        $emirate =  $this->uri->segment(1);
        if(!empty($emirate) && !in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain')))
            $this->session->unset_userdata('request_for_statewise');
        
        $data['request_state'] = '';
        if ($this->session->userdata('request_for_statewise') != '') {
            $array = array('state_slug' =>$this->session->userdata('request_for_statewise'));
            $state = $this->dbcommon->get_row('state', $array);
            
            if (!empty($state)) {                
                $data['request_state'] = $state->state_name;
            }
        }
        
        

        $data['footer_menu'] = $footer_menu;
        $data['fb_login_url'] = $this->facebook->get_login_url();
        $data['googlePlusLoginUrl'] = $this->googleplus->client->createAuthUrl();
        $data['twitter_login_url'] = base_url() . "login/redirect";
        //$data['order_option']  		= '';
        return $data;
    }

}
