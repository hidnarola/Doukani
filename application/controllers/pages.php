<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->helper('page_not_found');
        
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

    public function page($id = null) {

        $array = array('page_id' => $id);
        $page = $this->dbcommon->get_row('pages_cms', $array);

        if(!empty($page)) {
            if ($page->direct_url != '')
                redirect($page->direct_url);
            else {
                $data['page_title'] = $page->page_title;
                $data = array_merge($data, $this->get_elements());

                $data['is_logged'] = 0;
                $data['loggedin_user'] = '';
                if ($this->session->userdata('gen_user')) {
                    $current_user = $this->session->userdata('gen_user');
                    $data['loggedin_user'] = $current_user['user_id'];
                    $data['is_logged'] = 1;
                }

                $breadcrumb = array(
                    'Home' => base_url(),
                    $page->page_title => '#',
                );

                $data['breadcrumbs'] = $breadcrumb;
                $data['page'] = $page;
                $this->load->view('pages/page', $data);
            }            
        }
        else {
            override_404();
        }
    }
}