<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message extends CI_Controller {

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
		
		$config['base_url'] = site_url().'admin/message/index';
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$config['per_page'] = 10; 		
		$config['uri_segment'] = 4;
		
        $user = $this->session->userdata('user');
		
		$where = ' inq.* from inquiry inq, user usr where inq.inquiry_sender = usr.user_id';
		$config['total_rows'] = $this->dbcommon->getnumofdetails_($where);		
				
        $msg_data = $this->store->get_messages($page,$config["per_page"]);
		
		$this->pagination->initialize($config); 
		$data["links"] = $this->pagination->create_links();
        $data['message'] = $msg_data;
        $this->load->view('admin/message/index', $data);
    }

    public function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function view_conversation($inquiry_id) {

        $user = $this->session->userdata('user');
        $data['user_id'] = $user->user_id;
        $data['profile_pic'] = $user->profile_picture;

        $where = " where inquiry_id='" . $inquiry_id . "'";
        $inquiry = $this->dbcommon->getdetails('inquiry', $where);
        // echo '<pre>';
        // print_r($inquiry);
        // echo '</pre>';
        // exit;
		if(sizeof($inquiry)>0)
		{		
			if ($inquiry[0]->inquiry_sender == 0):
				$data['profile_pic_sender'] = "msg_blank.jpg";
			else:
				$where = " where user_id='" . $inquiry[0]->inquiry_sender . "'";
				$inquiry = $this->dbcommon->getdetails('user', $where);
				$data['profile_pic_sender'] = $inquiry[0]->profile_picture;
			endif;

			$data['inquiry'] = $inquiry;
			$where = " inquiry_id='" . $inquiry_id . "'";
			$inquiry_msg = $this->dbcommon->filter('inquiry_message', $where);
			$data['inquiry_msg'] = $inquiry_msg;
			$this->load->view('admin/message/msg_conversation', $data);
		}
		else {
			$this->session->set_flashdata(array('msg' => 'Message not found', 'class' => 'alert-info'));
			redirect('admin/message');
		}
    }

    public function reply($inquiry_id) {

        $user = $this->session->userdata('user');
        $where = " where inquiry_id='" . $inquiry_id . "'";
        $inquiry = $this->dbcommon->getdetails('inquiry', $where);
		
        $data['inquiry'] = $inquiry;
		if(sizeof($data['inquiry']) >0)
		{
			$message_code = $this->generateRandomString();
			if (!empty($_POST)) {
				$data = array(
					'message' => $_POST['message'],
					'message_posted_by' => $user->user_id,
					'inquiry_id' => $inquiry_id,
					'message_sent_to' => $inquiry[0]->inquiry_sender,
					'message_code'=>$message_code
				);
				$result = $this->dbcommon->insert('inquiry_message', $data);
				$this->session->set_flashdata(array('msg' => 'Message successfully sent', 'class' => 'alert-info'));
				redirect('admin/message');
			}
			$this->load->view('admin/message/reply', $data);
		}
		else
		{
			$this->session->set_flashdata(array('msg' => 'Message not found', 'class' => 'alert-info'));
			redirect('admin/message');
		}
    }

    public function send_message() {
        if (isset($_POST) && isset($_POST['message'])):
		
            $user = $this->session->userdata('user');
            $inquiry = $this->store->get_inquiry($_POST['user_id']);

            $where = " where user_id='" . $inquiry->inquiry_sender . "'";
            $user_data = $this->dbcommon->getdetails('user', $where);
            if (!empty($inquiry)):
                $to = $user_data[0]->email_id;
                $subject = "Re:" . $inquiry->inquiry_subject;
                $body = "<pre>" . $_POST['message'] . "</pre>";
                if (send_mail($to, $subject, $body)):
                    $message_code = $this->generateRandomString();
                    $data = array(
                        'message' => $_POST['message'],
                        'message_posted_by' => $user->user_id,
                        'inquiry_id' => $_POST['user_id'],
                        'message_code'=>$message_code
                    );
                    $result = $this->dbcommon->insert('inquiry_message', $data);
                    $this->session->set_flashdata(array('msg' => 'Message successfully sent', 'class' => 'alert-info'));
                    redirect('admin/message');
                else:
                    $this->session->set_flashdata(array('msg' => 'Message was not sent', 'class' => 'alert-info'));
                    redirect('admin/message');
                endif;
            else:
                $this->session->set_flashdata(array('msg' => 'Inquiry not found', 'class' => 'alert-info'));
                redirect('admin/message');
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Message was not sent ', 'class' => 'alert-info'));
            redirect('admin/message');
        endif;
    }

    public function delete($inquiry_id = null) {
        $data = array();
        $where = " where inquiry_id='" . $inquiry_id . "'";
        $inquiry = $this->dbcommon->getdetails('inquiry', $where);
        if ($inquiry_id != null && !empty($inquiry)):
            $where = array("inquiry_id" => $inquiry_id);
            $user = $this->dbcommon->delete('inquiry_message', $where);

            $where = array("inquiry_id" => $inquiry_id);
            $user = $this->dbcommon->delete('inquiry', $where);

            $this->session->set_flashdata(array('msg' => 'Message deleted successfully', 'class' => 'alert-success'));
            redirect('admin/message');
        else:
            $this->session->set_flashdata(array('msg' => 'Message not found', 'class' => 'alert-info'));
            redirect('admin/message');
        endif;
    }

    function msg_open($id) {
        if (!empty($id)) {
            $data = array('inquiry_status' => "open");
            $array = array('inquiry_id' => $id);
            $result = $this->dbcommon->update('inquiry', $array, $data);
            redirect('admin/message');
        }
    }

    function msg_close($id) {
        if (!empty($id)) {
            $data = array('inquiry_status' => "close");
            $array = array('inquiry_id' => $id);
            $result = $this->dbcommon->update('inquiry', $array, $data);
            redirect('admin/message');
        }
    }

}