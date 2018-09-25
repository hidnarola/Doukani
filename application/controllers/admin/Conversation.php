<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Conversation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('store', '', TRUE);
        $this->load->library('pagination');
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('email');
        $this->per_page = 10;
    }

    public function index() {
        
        $data['page_title'] = 'Conversation';
        $url = site_url() . 'admin/conversation/index';
        //$page = $this->per_page; //($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $user = $this->session->userdata('user');
        $query = 'p.product_posted_by, p.product_name,p.product_id,p.product_image,p.product_price,p.product_is_inappropriate,u.username,u.nick_name,u.email_id,bs.product_owner
            from product p 
            right join buyer_seller_conversation bs on bs.product_id=p.product_id   
            left join user u on u.user_id = p.product_posted_by
            where p.product_deactivate is null and p.is_delete=0 and 
            p.product_posted_by<>bs.sender_id
            group by p.product_id order by bs.created_at desc ';

        if(isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page='.$per_page;
        }
        else
            $per_page = $this->per_page;
            
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;
        
        $pagination_data = $this->dbcommon->pagination($url, $query, $per_page,'yes');
        $data['url'] = $url;
        $data["links"] = $pagination_data['links'];            
        $data['total_records'] = $pagination_data['total_rows'];
            
        $query .= ' limit ' . $offset . ', ' . $per_page;
        $product_list = $this->dbcommon->get_distinct('select ' . $query);
        $data['product_list'] = $product_list;

        $this->load->view('admin/conversation/index', $data);
    }

    public function view_conversation($product_id) {
        
        $data['page_title'] = 'Messages';
        $url = site_url() . 'admin/conversation/view_conversation/' . $product_id;
        $user = $this->session->userdata('user');
        $data['user_id'] = $user->user_id;
        $data['profile_pic'] = $user->profile_picture;
        
        if(isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page='.$per_page;
        }
        else
            $per_page = $this->per_page;
            
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;
        
        $where = " where product_id='" . $product_id . "'";
        $product_details = $this->dbcommon->getdetails('product', $where);

        if (sizeof($product_details) > 0) {
            $data['product_details'] = $product_details;

            $sender_details = $this->dbcommon->get_senders_admin($product_id,$offset,$per_page);
            $data['sender_details'] = $sender_details;
            
            $query = ' bs.product_id, bs.con_id, bs.message,bs.created_at, bs.sender_id, bs.receiver_id,bs.product_owner, u.username uname, u.nick_name unick, bs.product_id product_id, u.profile_picture upick, u.facebook_id ufb, u.twitter_id utwi, u.google_id ugoo, u.user_id uid, p.product_posted_by FROM buyer_seller_conversation bs LEFT JOIN user u ON u.user_id=bs.sender_id LEFT JOIN product p ON p.product_id=bs.product_id WHERE bs.product_id = '.$product_id.' AND p.product_posted_by <> bs.sender_id GROUP BY bs.sender_id ORDER BY bs.con_id DESC';
            $pagination_data = $this->dbcommon->pagination($url, $query, $per_page,'yes');
            $data['url'] = $url;
            $data["links"] = $pagination_data['links'];            
            $data['total_records'] = $pagination_data['total_rows'];
        
            $this->load->view('admin/conversation/msg_conversation', $data);
        } else {
            $this->session->set_flashdata(array('msg' => 'Message not found', 'class' => 'alert-info'));
            redirect('admin/conversation');
        }
    }

    function buyer_seller_conversation() {
        $product_id = $this->input->post('product_id', TRUE);
        $buyer_id = $this->input->post('buyer_id', TRUE);
        $product_owner = $this->input->post('product_owner', TRUE);

        $arr = array();
        $arr['conversation'] = '';
        $conversation = $this->dbcommon->buyer_seller_conversation($product_id, $buyer_id, $product_owner);

        $arr['conversation'] = $conversation;

        $arr['buyer_id'] = $buyer_id;
        $arr['product_owner'] = $product_owner;
        $arr['product_id'] = $product_id;

        $arr["html"] = $this->load->view('admin/conversation/buyer_seller_condition', $arr, TRUE);

        echo json_encode($arr);

        exit;
    }

    function message_delete($con_id = NULL) {
        
        $success = 1;
        $comma_ids=0;
        
        if($this->input->post("checked_val")!='') {
            
             $values = $this->input->post("checked_val");
             foreach($values  as $val) {
                 $con_id[] = $val;
             }
            $con_id = implode(",",$con_id); 
            $comma_ids = $con_id;
        }
        elseif($this->input->post("con_id")!='') {
            $con_id = $this->input->post("con_id");
            $comma_ids = $con_id;
        }
        
        $messages = $this->db->query('select * from buyer_seller_conversation                                 
                                      where con_id in ('.$comma_ids.')')->result_array();
                
        foreach($messages as $msg) {
            $arr = array('con_id'=>$msg['con_id']);
            $this->dbcommon->delete('buyer_seller_conversation',$arr);
            $success++;            
        }
        
        if($success > 0)
            echo 'success';
        else 
            echo 'fail';
       exit; 
    }
    
}
