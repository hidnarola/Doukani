<?php

class Check_user_block {

    function index() {
        $CI = & get_instance();
        $baseURL = $GLOBALS['CFG']->config['base_url'];
        $CI->load->library('session');


        //admin		
        $admin = $CI->uri->segment(1);
        $admin_user = $CI->session->userdata('user');
        $admin_login = false;
        if (!empty($admin_user->email_id) && !empty($admin_user->password)) {
            $admin_login = true;
        }

        //general user
        $user = $CI->uri->segment(1);
        $normal_user = $CI->session->userdata('gen_user');
        $user_login = false;
        if (!empty($normal_user->email_id) && !empty($normal_user->password)) {
            $user_login = true;
        }

        $action = $CI->uri->segment(3);
        $allowWithoutLogin = array('login', 'signup', 'forget_password', 'reset_password', 'verify', 'show_emirates');

        if ($admin == 'admin' && $CI->session->userdata('user') != '') {
            $res = $CI->db->query("select * from user where user_role='admin' and 	user_id=" . (int) $admin_user->user_id . " and user_block=1");
            if ($res->num_rows() > 0) {

                if ($admin_login == true && !in_array($action, $allowWithoutLogin)) {
                    $CI->session->unset_userdata('user');
                    $CI->session->set_flashdata(array('msg' => '<font color="red">Your Account is blocked by Admin. To Unblock  <a href="' . site_url() . 'contact-us' . '"><span><u>Contact Us</u></span></a></font>', 'class' => 'alert-success'));
                    redirect('admin/users/login', 'refresh');
                }
            }
        } elseif ($admin == 'admin' && $CI->session->userdata('user') == '') {
            if (!$admin_login && !in_array($action, $allowWithoutLogin)) {
                $CI->session->set_flashdata(array('msg' => 'Your session is expired. Please Login again...', 'class' => 'alert-success'));
                redirect('admin/users/login', 'refresh');
            }
        } elseif ($user == 'user' && $CI->session->userdata('gen_user') != '') {            
            $res = $CI->db->query("select * from user where user_role in ('generalUser','admin') and user_id=" . (int) $normal_user['user_id'] . " and user_block=1");
            if ($res->num_rows() > 0) {
                $CI->session->unset_userdata('gen_user');
                $CI->session->set_flashdata(array('msg3' => '<font color="red">Your Account is blocked by Admin. To Unblock  <a href="' . site_url() . 'contact-us' . '"><span><u>Contact Us</u></span></a></font>', 'class' => 'alert-success'));
                redirect('login/index', 'refresh');
            }
        } elseif ($user == 'user' && $CI->session->userdata('gen_user') == '') {
            if (!$user_login) {
                redirect('home', 'refresh');
            }
        }
    }

}

?>