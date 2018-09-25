<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('store', '', TRUE);
        $this->load->library('pagination');
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('email');
    }

    public function index() {
        
        $data = array();
        $data['page_title'] = 'Stores List';
        $config['base_url'] = site_url() . 'admin/Stores/index/';
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;

        $user = $this->session->userdata('user');
        $query = "select store_id from store where store_owner = " . $user->user_id;
        $store_id = $this->dbcommon->get_distinct($query);

        if ($user->user_role == 'storeUser' && !empty($store_id)) {
            redirect('admin/stores/product/' . $store_id[0]['store_id']);
        }

        $where = ' store_id from store';
        $config['total_rows'] = $this->dbcommon->getnumofdetails_($where);

        //$store_data = $this->dbcommon->select('store');
        $where = '';
        $where .= " 1=1 limit " . $page . " ," . $config['per_page'];
        $data['stores'] = $this->dbcommon->filter('store', $where);

        //$data['stores'] = $store_data;

        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/stores/index', $data);
    }

    public function check_store_name() {

        $where = ' store_id from store where store_id<>' . (int) $_POST['store_id'] . ' and store_name="' . $_POST['new_store_name'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_store_name', 'Store name already exists');
            return false;
        } else {
            return true;
        }
    }

    public function view($store_id = null) {
        $data = array();
        $data['page_title'] = 'View Store';
//        $where = " where store_id='" . $store_id . "'";
//        $store = $this->dbcommon->getdetails('store', $where);
        $store = $this->store->get_store($store_id);
        //print_r($store);die;
        if ($store_id != null && !empty($store)):
            $data['store'] = $store;
            $this->load->view('admin/stores/view', $data);
        else:
            $this->session->set_flashdata(array('msg' => 'Store not found', 'class' => 'alert-info'));
            redirect('admin/stores');
        endif;
    }

    public function delete($store_id = null) {
        $data = array();
        $where = " where store_id='" . $store_id . "'";
        $store = $this->dbcommon->getdetails('store', $where);
        if ($store_id != null && !empty($store)):
            $where = array("store_id" => $store_id);
            $store = $this->dbcommon->delete('store', $where);
            if ($store):
                @unlink($target_dir . "original/" . $store[0]->store_image);
                @unlink($target_dir . "small/" . $store[0]->store_image);
                @unlink($target_dir . "medium/" . $store[0]->store_image);
            endif;
            $this->session->set_flashdata(array('msg' => 'Store deleted successfully', 'class' => 'alert-success'));
            redirect('admin/stores');
        else:
            $this->session->set_flashdata(array('msg' => 'Store not found', 'class' => 'alert-info'));
            redirect('admin/stores');
        endif;
    }

    public function manage_stores() {
        $msg = $this->session->flashdata('msg');
        $data = array();
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/stores/manage_stores', $data);
    }

    public function send_message() {
        if (isset($_POST)):
            $this->load->helper('email');
            $store = $this->store->get_store($_POST['user_id']);
            if (!empty($store) && isset($_POST['subject'])):
                $to = $store->email_id;
                $subject = $_POST['subject'];
                $body = "<pre>" . $_POST['message'] . "</pre>";
                if (send_mail($to, $subject, $body)):
                    $this->session->set_flashdata(array('msg' => 'Message successfully sent to store owner', 'class' => 'alert-success'));
                    redirect('admin/stores');
                else:
                    $this->session->set_flashdata(array('msg' => 'Message was not sent to store owner', 'class' => 'alert-info'));
                    redirect('admin/stores');
                endif;
            else:
                $this->session->set_flashdata(array('msg' => 'Please fill Subject and Title or Store owner not found', 'class' => 'alert-info'));
                redirect('admin/stores');
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Message was not sent to store owner', 'class' => 'alert-info'));
            redirect('admin/stores');
        endif;
    }

// store products function
    public function product($store_id = null) {
        // $query = 'SELECT store_name FROM `classified_app`.`store` where store_id = ' . $store_id;
        $query = 'SELECT store_name FROM `store` where store_id = ' . $store_id;
        $store_name = $this->dbcommon->get_distinct($query);

        $config['base_url'] = site_url() . 'admin/Stores/product/' . $store_id;
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $config['uri_segment'] = 5;
        $config['per_page'] = 10;

        $data['store_name'] = $store_name[0]['store_name'];
        $data['store_id'] = $store_id;

        $where = " p.store_id='" . $store_id . "'";
        $query = "   s.store_name,c.catagory_name,p.store_product_price,p.store_product_name,p.store_product_in_stock,
		p.store_product_description,p.store_product_id,p.store_product_status FROM `store_product` as p,category as c , store as s where " . $where . "and s.store_id=p.store_id and c.category_id=p.store_product_category_id ";
        $config['total_rows'] = $this->dbcommon->getnumofdetails_($query);

        $store_product = $this->dbcommon->select_store_product($where, $page, $config["per_page"]);
        $data['store_product'] = $store_product;

        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/stores/store_products', $data);
    }

    function active($id) {
        if (!empty($id)) {
            $data = array('store_status' => "1");
            $array = array('store_id' => $id);
            $result = $this->dbcommon->update('store', $array, $data);
            redirect('admin/stores');
        }
    }

    function inactive($id) {
        if (!empty($id)) {
            $data = array('store_status' => "0");
            $array = array('store_id' => $id);
            $result = $this->dbcommon->update('store', $array, $data);
            redirect('admin/stores');
        }
    }

    function update_status() {
        $status = $this->input->post("status");
        $order = explode(",", $this->input->post("checked_val"));
        if ($order[0] == 0) {
            array_shift($order);
        }
        foreach ($order as $value) {
            $data = array(
                'store_product_status' => $status
            );
            $array = array('store_product_id' => $value);
            $result = $this->dbcommon->update('store_product', $array, $data);
        }
        $where = " where store_product_id='" . $order[0] . "'";
        $store_product = $this->dbcommon->getdetails('store_product', $where);
        redirect('admin/stores/product/' . $store_product[0]->store_id);
    }

    public function show_sub_cat() {

        $filter_val = $this->input->post("value");

        $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(1, sub_category_type) > 0";
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);

        echo $this->load->view('admin/stores/sub_cat', $main_data, TRUE);
        exit();
    }

}
