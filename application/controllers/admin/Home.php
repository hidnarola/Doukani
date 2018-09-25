<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('permission');
        $this->load->model('dashboard');
        $this->load->model('dbcommon');
        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));
    }

    public function index() {

        $user = $this->session->userdata('user');
        //        User query
        if ($user != '') {

            $val = $this->dashboard->get_users_count();
            $data['users'] = $val;

            $val = $this->dashboard->get_products_count();
            $data['products'] = $val;

            $val = $this->dashboard->repost_counts();
            $data['repost_counts'] = $val;

            $val = $this->dashboard->get_offer_ads_count();
            $data['offer_ads'] = $val;

            $val = $this->dbcommon->get_featured_ads_count();
            $data['classified_featured_ads'] = $val;

            $val = $this->dashboard->get_stores_count();
            $data['stores'] = $val;

            $val = $this->dashboard->get_companies_count();
            $data['companies'] = $val;

            $val = $this->doukani_balance();
            $data['doukani_balance'] = $val;
            
            $val = $this->store_payment_request();
            $data['store_payment_request'] = $val;
            
            $val = $this->dashboard->store_request();
            $data['create_store_request'] = $val;

//            $val = $this->dashboard->get_count('user', 'device_type', '1');
//            $data['ios'] = $val;
//
//            $val = $this->dashboard->get_count('user', 'device_type', '2');
//            $data['android'] = $val;
//
//            //      Product/Listings query        
//            $val = $this->dashboard->get_countAll('product');
//            $data['total_product'] = $val;
//
//            $val = $this->dashboard->get_count('product', 'product_posted_time', date('y-m-d', time()));
//            $data['today_product'] = $val;
//
//            $val = $this->dashboard->get_count('product', 'product_is_inappropriate', 'NeedReview');
//            $data['waiting_approve_product'] = $val;
//
//            $val = $this->dashboard->get_count('product', 'product_is_inappropriate', 'Inappropriate');
//            $data['spam_product'] = $val;
//
//            //      Offers query        
//            $val = $this->dashboard->get_countAll('offers');
//            $data['total_offer'] = $val;
//
//            $val = $this->dashboard->get_count('offers', 'offer_posted_on', date('y-m-d', time()));
//            $data['today_offer'] = $val;
//
//            $val = $this->dashboard->get_count('offers', 'offer_is_approve', 'WaitingForApproval');
//            $data['waiting_approve_offer'] = $val;
//            
//            $val = $this->dashboard->get_count('offers', 'store_id >', '0');
//            $data['offer_companies'] = $val;
//
//            //      Message query        
//            $val = $this->dashboard->get_count('inquiry', 'inquiry_type', '0');
//            $data['msg_inquiry'] = $val;
//
//            $val = $this->dashboard->get_count('inquiry', 'inquiry_type', '1');
//            $data['msg_support'] = $val;
//
//            $val = $this->dashboard->get_count('inquiry', 'inquiry_type', '2');
//            $data['msg_offer'] = $val;
//
//            //      Virtual Store query        
//            $val = $this->dashboard->get_countAll('store');
//            $data['total_store'] = $val;
//
//            $val = $this->dashboard->get_count('store', 'DATE(store_created_on)', date('y-m-d', time()));
//            $data['today_store'] = $val;
            //save data in cache
//                $this->cache->file->save('user_' . $user->user_id, $data, 900); //15 min cache

            $data['page_title'] = 'Dashboard';

            $this->load->view('admin/home/index', $data);
        } else {
            redirect('admin/users/login');
        }
    }

    function reset_classified_new_session() {

        $this->session->unset_userdata('listing_user');
        $this->session->unset_userdata('listing_filter');
        $this->session->unset_userdata('listing_country');
        $this->session->unset_userdata('listing_state');
        $this->session->unset_userdata('listing_category');
        $this->session->unset_userdata('listing_sub_category');
        $this->session->unset_userdata('listing_status');
        $this->session->unset_userdata('listing_oth_status');
        $this->session->unset_userdata('listing_date');
        $this->session->unset_userdata('listing_per_page');

        $status = $this->input->post('status');
        $this->session->set_userdata('listing_status', $status);
    }

    function reset_classified_repost_session() {

        $this->session->unset_userdata('repost_filter');
        $this->session->unset_userdata('repost_country');
        $this->session->unset_userdata('repost_state');
        $this->session->unset_userdata('repost_category');
        $this->session->unset_userdata('repost_sub_category');
        $this->session->unset_userdata('repost_status');
        $this->session->unset_userdata('repost_oth_status');
        $this->session->unset_userdata('repost_date');
        $this->session->unset_userdata('repost_userid');
        $this->session->unset_userdata('repost_per_page');

        $status = $this->input->post('status');
        $this->session->set_userdata('repost_status', $status);
    }

    function reset_today_ads_date() {

        $this->session->unset_userdata('listing_user');
        $this->session->unset_userdata('listing_filter');
        $this->session->unset_userdata('listing_country');
        $this->session->unset_userdata('listing_state');
        $this->session->unset_userdata('listing_category');
        $this->session->unset_userdata('listing_sub_category');
        $this->session->unset_userdata('listing_status');
        $this->session->unset_userdata('listing_oth_status');
        $this->session->unset_userdata('listing_date');
        $this->session->unset_userdata('listing_per_page');

        $request_date = $this->input->post('today_date');
        $this->session->set_userdata('listing_date', $request_date);
    }

    function doukani_balance() {
        $this->db->select('SUM(doukani_amout) as doukani_balance');
        $this->db->where('status', 1);
        $query = $this->db->get('balance');
        $result = $query->row_array();
        return $result;
    }

    function store_payment_request() {
        $this->db->select('e.store_owner, s.store_name, s.store_id, e.amount');
        $this->db->where('e.status', 0);
        $this->db->join('store s', 's.store_owner = e.store_owner', 'LEFT');
        $query = $this->db->get('e_wallet_request_response e');
        $result = $query->result_array();
  
        return $result;
    }

}

?>