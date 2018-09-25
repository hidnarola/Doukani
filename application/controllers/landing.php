<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends My_controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dashboard');
        $this->load->library('pagination');
    }

    public function index() {
	
        $data = array();        
        $data['page_title'] = 'Doukani';
		
			 $data = array_merge($data, $this->get_elements());
        if (isset($_POST['submit'])):			
            $email 		= 	$_POST['email_id'];            
            $subject 	=	'';

            $message =
                    '<b>Message From:</b> ' . $email .
                    '<br/><b>Email:</b> ' . $email .
                    '<br/><b>Subject:</b> ' . $subject .
                    '<br/><b>Message:</b><br/>' .
                    nl2br('Hi, '.$_POST['email_id']. ' is requested to inform him/her when doukani.com will start');

            $configs = mail_config();

            $this->load->library('email', $configs);
            $this->email->set_newline("\r\n");
            $this->email->from($email,$email);
			//$this->email->reply_to('oscar@treatmo.com', 'treatmo');
            $this->email->to('kek.narola@email');
            // $this->email->to('adonis@adonis.name');

            $this->email->subject('Message');
            $this->email->message($message);

            if ($this->email->send()):                
                $this->session->set_flashdata(array('msg' => 'Sent successfully', 'class' => 'alert-info'));
                redirect('landing');
                exit;
            else:
                $this->session->set_flashdata(array('msg' => 'Message was not sent', 'class' => 'alert-info'));
                redirect('landing');
                exit;
            endif;           
        endif;
            $this->load->view('home/home1', $data);
	}	
}