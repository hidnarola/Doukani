<?php

class Logincheck {

    function isLogin() {
        $CI = & get_instance();
        $login = false;
        $user = $CI->session->userdata('user');
        if (!empty($user->email_id) && !empty($user->password)) {
            $login = true;
        }

        $gen_login = false;
        $gen_user = $CI->session->userdata('gen_user');
        if (!empty($gen_user)) {
            $gen_login = true;
        }
        
        $controller = $CI->router->fetch_class();
        $action = $CI->router->fetch_method();
        if ($CI->uri->segment(1) == "admin") {
            $controller = $CI->uri->segment(2);
            $action = $CI->uri->segment(3);
              $allowWithoutLogin = array('login', 'signup', 'forget_password', 'reset_password', 'verify', 'show_emirates');

            if (!$login && !in_array($action, $allowWithoutLogin)) {
                redirect('admin/users/login', 'refresh');
                exit;
            } else {
                return true;
            }
        }else{
            if ($CI->uri->segment(1) == "user") {
                if (!$gen_login){
                    redirect('login', 'refresh');
                   
                } else {
                    return true;
                   
                }
            }else{
            return true;
            exit;
        }
        }
    }

}

?>