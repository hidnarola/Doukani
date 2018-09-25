<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Extending the custom controller
class Winipad extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dblogin', '', TRUE);
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('email');
    }

    public function index() {

        $data = array();
        $data['page_title'] = 'Chance to win iPad';
        $where = " where page_id=21";
        $term_link = $this->dbcommon->getrowdetails('pages_cms', $where);
        $data['term_link'] = $term_link;
        if (isset($_POST['register'])) {

            $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('email_id', 'Email', 'trim|required|valid_email|max_length[50]|callback_check_email_exists');

            if ($this->form_validation->run() == FALSE) {
                
            } else {
                if (isset($_POST['term_condition']) && $_POST['term_condition'] == 1)
                    $agree_status = 0;
                else
                    $agree_status = 2;
                $from_date = date('Y-m-d');
                $to_date = date('Y-m-d', strtotime("+1 months", strtotime($from_date)));
                $name = explode(" ", $_POST['name']);
                $username = explode("@", $_POST['email_id']);
                $email_id = $_POST['email_id'];
                $get_char_slug = $username[0];
                $password = $this->generatePassword(6);
                $user_slug = $this->dbcommon->generate_slug($get_char_slug, 'U');
                $uname = preg_replace('/[^A-Za-z0-9\-]/', '', $username[0]);
                $unique_code = md5(uniqid(rand(), true));
                $in_data = array(
                    'email_id' => $email_id,
                    'username' => $uname,
                    'password' => md5($password),
                    'status' => 'inactive',
                    'is_delete' => $agree_status,
                    'first_name' => $name[0],
                    'last_name' => $name[1],
                    'insert_from' => 'web-ipad',
                    'user_slug' => $user_slug,
                    'unique_code' => $unique_code,
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'last_logged_in' => date('Y-m-d H:i:s')
                );
                $result = $this->dblogin->insert($in_data);
                if (isset($result)) {
                    $username = $uname;
                    $user_id = $this->dblogin->getLastInserted();
                    $parser_data = array();
                    $activate_key = $this->my_encryption->safe_b64encode($email_id);
                    $button_link = base_url() . "registration/verify?ident=" . $user_id . "&activate=" . $activate_key;
                    $button_label = 'Click here to confirm your account';
                    $title = 'Thank you for joining us!';

                    $content = '<div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"><h3>Account Confirmation</h3><p style="margin: 1em 0;"><strong>E-mail: </strong><a href="mailto:' . $email_id . '" style="color: #000000 !important;">' . $email_id . '</a></p><p  style="margin: 1em 0;"><strong>Username: </strong>' . $username . '</p></strong><p  style="margin: 1em 0;"><strong>Password: </strong>' . $password . '</p><p  style="margin: 1em 0;"><strong>Unique Code: </strong>' . $unique_code . '</p><br><a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:240px; " href="' . $button_link . '">' . $button_label . '</a></div>';

                    $new_data = $this->dbcommon->mail_format($title, $content);
                    $new_data = $this->parser->parse_string($new_data, $parser_data, '1');
                    if (send_mail($email_id, 'Signup | Verification', $new_data, 'info@doukani.com')) {
                        $data['msg'] = 'The Verification mail sent successfully.';
                        $data['msg_class'] = 'alert-success';
                        $this->session->set_flashdata('msg5', 'The Verification mail sent successfully.');
                        redirect('winipad');
                    } else {
                        $this->db->query('delete from user where user_id = ' . $user_id);
                        $data['msg'] = 'Verification mail sending failed, Please try again';
                        $data['msg_class'] = 'alert-info';
                    }
                }
            }
        }
        $this->load->view('winipad/index', $data);
    }

    public function check_email_exists() {

        $check_email_id = $this->db->query('select user_id from user where email_id="' . $this->input->post('email_id') . '" limit 1')->row_array();

        if (isset($check_email_id) && sizeof($check_email_id) > 0) {
            $this->form_validation->set_message('check_email_exists', 'Email Address already exists');
            return false;
        } else {
            return true;
        }
    }

    function generatePassword($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function winipadVerification() {
        $data = array();
        $data['page_title'] = 'Enter unique code to win iPad';
        if (isset($_POST['save'])) {

            $this->form_validation->set_rules('unique_code', 'Unique Code', 'required');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $unique_code = $_POST['unique_code'];
                $result = $this->dbcommon->check_unique_code($unique_code);
                if (!empty($result)) {
//                    print_r($result);exit;
                    if ($result['status'] == 'inactive') {
                        $data = array('status' => 'active');
                        $result = $this->dblogin->update_user($result['user_id'], $unique_code, $data);
                        $data['msg'] = 'Your account has been verified Successfully.';
                        $data['msg_class'] = 'alert-success';
                        $this->session->set_flashdata('msg5', 'Your account has been verified Successfully.');
                        redirect('winipad');
                    } else {
                        $data['msg'] = 'Your Account is already active.';
                        $data['msg_class'] = 'alert-info';
                    }
                } else {
                    $data['msg'] = 'Verification Code wrong, Please try again';
                    $data['msg_class'] = 'alert-info';
                }
            }
        }
        $this->load->view('winipad/winipadverification', $data);
    }

}

?>