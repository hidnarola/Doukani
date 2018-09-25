<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends My_controller {

    public function __construct() {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dbuser', '', TRUE);
        $this->load->model('store', '', TRUE);
        $this->load->model('dbcart', '', TRUE);
        $this->load->model('dashboard', '', TRUE);

        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->library('facebook');
        $this->load->library('googleplus');
        $this->load->library('twconnect');

        $this->load->helper('email');
        $this->load->helper('form');
        $this->load->helper('page_not_found');

        $emirate = $this->uri->segment(1);
        if (empty($emirate))
            $this->session->unset_userdata('request_for_statewise');

        if (!empty($emirate) && in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $this->session->set_userdata('request_for_statewise', $emirate);
            $emirate = $this->session->userdata('request_for_statewise');
        } elseif (isset($_REQUEST['state_id_selection']))
            $emirate = $_REQUEST['state_id_selection'];
        elseif ($this->session->userdata('request_for_statewise') != '') {
            $emirate = $this->session->userdata('request_for_statewise');
        }

        if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
            define("emirate_slug", $emirate . '/');
        else
            define("emirate_slug", '');
    }

    public function index() {
        header('Content-type: text/html; charset=utf-8');

        $session_data = array();
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-t');

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'Login';
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        if (isset($_POST['submit'])):
            $this->form_validation->set_rules('uname', 'UserName', 'trim|required');
            $this->form_validation->set_rules('password1', 'Password', 'trim');
            //$this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE) {
                $data['msg2'] = "";
                $this->load->view('login/index', $data);
            } else {

                $where = " where (email_id='" . addslashes($_POST['uname']) . "' or username='" . $_POST['uname'] . "') and password='" . addslashes(md5($_POST['password1'])) . "' ";

                $user = $this->dblogin->isExist($where);
                if ($user) {
                    $my_array = $this->db->query("select * from user where (email_id='" . addslashes($_POST['uname']) . "' or username='" . $_POST['uname'] . "') and password='" . addslashes(md5($_POST['password1'])) . "'  limit 1")->row_array();

                    if ($user->is_delete == 4) {
                        //$data['msg2'] = 'Your Account Is Block By Admin';

                        $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
                        $array = array('page_state' => 1, 'page_id' => 23);
                        $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

                        if ($header_menu[0]['direct_url'] != '')
                            $contact_url = $header_menu[0]['direct_url'];
                        else
                            $contact_url = $header_menu[0]['slug_url'];

                        $data['msg2'] = '<font color="red">Your Account Is Blocked By Admin. To Unblock  &nbsp; <a href="' . site_url() . $contact_url . '"><span><u>' . $header_menu[0]['page_title'] . '</u></span></a>&nbsp;&nbsp;</font>';

                        $data['msg_class'] = 'alert-info';
                        $this->load->view('login/index', $data);
                    } else if ($user->status == "inactive") {
                        $data['msg2'] = 'Your Account Is Not Active';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('login/index', $data);
                    } else if ($user->is_delete == 1) {
                        $data['msg2'] = 'Your account has been deleted earlier.';
                        $data['msg_class'] = 'alert-info';
                        $data['deleted_earlier'] = 1;
                        $data['user_id'] = $user->user_id;
                        $this->load->view('login/index', $data);
                    } elseif ($user->is_delete == 2) {

                        $data = array(
                            'last_logged_in' => date('Y-m-d H:i:s')
                        );
                        $array = array('user_id' => $user->user_id);
                        $result = $this->dbcommon->update('user', $array, $data);

                        $this->session->set_userdata('gen_user', $my_array);
                        $this->dbcart->add_user_cart($user->user_id);
                        $this->session->set_userdata('show_user_popup', 'yes');

                        redirect('login/agree');
                    } else if ($user->user_role == 'offerUser') {
                        $data['msg2'] = 'Offer Company\'s User can not be logged in.';
                        $data['msg_class'] = 'alert-info';
                        $data['deleted_earlier'] = 1;
                        $data['user_id'] = $user->user_id;
                        $this->load->view('login/index', $data);
                    } elseif ($user->user_role == NULL || $user->user_role == '') {

                        $data = array(
                            'last_logged_in' => date('Y-m-d H:i:s')
                        );
                        $array = array('user_id' => $user->user_id);
                        $result = $this->dbcommon->update('user', $array, $data);

                        $this->session->set_userdata('gen_user', $my_array);
                        $this->dbcart->add_user_cart($user->user_id);
                        $this->session->set_userdata('show_user_popup', 'yes');

                        redirect('login/user_role');
                    } elseif ($user->is_delete == 5) {

                        $data = array(
                            'last_logged_in' => date('Y-m-d H:i:s')
                        );
                        $array = array('user_id' => $user->user_id);
                        $result = $this->dbcommon->update('user', $array, $data);

                        $this->session->set_userdata('gen_user', $my_array);
                        $this->dbcart->add_user_cart($user->user_id);
                        $this->session->set_userdata('show_user_popup', 'yes');
//                        redirect('login/create_store');
                        redirect('user/store');
                    } else {

                        $data = array(
                            'last_logged_in' => date('Y-m-d H:i:s')
                        );

                        if ($user->user_role == 'storeUser')
                            $my_array['last_login_as'] = '';

                        $array = array('user_id' => $user->user_id);
                        $result = $this->dbcommon->update('user', $array, $data);

                        $this->session->set_userdata('gen_user', $my_array);
                        $this->dbcart->add_user_cart($user->user_id);
                        $this->session->set_userdata('show_user_popup', 'yes');

                        if ($this->session->userdata('client_request') != '')
                            $redirect_url = $this->session->userdata('client_request');
                        else
                            $redirect_url = $this->input->post('REFERER_url');

                        if (empty($redirect_url))
                            redirect('user/index/');
                        else
                            redirect($redirect_url);

                        exit;
                    }
                } else {
                    $data['msg2'] = 'Username and Password not matched.';
                    $data['msg_class'] = 'alert-info';

                    $this->load->view('login/index', $data);
                }
            }
        else:

            $result = array();
            if (isset($_GET['ident']) && isset($_GET['activate'])):
                $data['ident'] = $_GET['ident'];
                $data['activate'] = $_GET['activate'];
            endif;
            $msg = $this->session->flashdata('msg');
            if (!empty($msg)):
                $data['msg2'] = $this->session->flashdata('msg');
                $data['msg_class'] = $this->session->flashdata('class');
            endif;

            if ($this->session->userdata('gen_user')):
                redirect('user/index/');
            else:
                $this->load->view('login/index', $data);
            endif;
        endif;
    }

    /* redirect to Twitter for authentication */

    public function redirect() {
        /* twredirect() parameter - callback point in your application */
        /* by default the path from config file will be used */
        $ok = $this->twconnect->twredirect('login/callback');

        if (!$ok) {
            echo 'Could not connect to Twitter. Refresh the page or try again later.';
        }
    }

    /* return point from Twitter */
    /* you have to call $this->twconnect->twprocess_callback() here! */

    public function callback() {
        $ok = $this->twconnect->twprocess_callback();

        if ($ok == true) {
            redirect('login/success');
        } else {
            redirect('login/failure');
        }
    }

    /* authentication successful */
    /* it should be a different function from callback */
    /* twconnect library should be re-loaded */
    /* but you can just call this function, not necessarily redirect to it */

    public function success() {


        $from_date = date('Y-m-d');
        $to_date = date('Y-m-t');

        // saves Twitter user information to $this->twconnect->tw_user_info
        // twaccount_verify_credentials returns the same information
        $d = $this->twconnect->twaccount_verify_credentials();

        $twitter_user = $this->twconnect->tw_user_info;
        if (isset($twitter_user->id)) {

            $name = $twitter_user->screen_name;
            $twitter_id = $twitter_user->id;
            $twitter_name = $twitter_user->name;
            $twitter_email = $twitter_user->email;
            if (empty($twitter_email)) {
                $this->session->set_flashdata('msg', 'Email-id already Registered...');
                redirect('home');
            } else {
                $userDetails = $this->dbuser->getUserDetails(array("email_id" => $twitter_email));

                if (empty($userDetails)) {
                    echo $twitter_email;
                    if (empty($twitter_email)) {

                        $data['msg2'] = 'Please verify your email address in twitter';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('login/index', $data);
                        return;
                    }

                    $slug_email_id = $twitter_email;
                    // $get_char_slug = strstr($slug_email_id, '@', true);
                    $get_char_slug = $name;
                    $user_slug = $this->dbcommon->generate_slug($get_char_slug, 'U');

                    $insertArr = array(
                        'username' => preg_replace('/[^A-Za-z0-9\-]/', '', $name),
                        'email_id' => $twitter_email,
                        'twitter_id' => $twitter_id,
                        'status' => 'active',
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'first_name' => $twitter_name,
                        'insert_from' => 'web',
                        'is_delete' => 2,
                        'last_logged_in' => date('Y-m-d H:i:s'),
                        'user_slug' => $user_slug
                    );

                    if ($this->dbuser->insert($insertArr)) {
                        $userId = $this->db->insert_id();
                        $userDetails = $this->dbuser->getUserDetails(array("user_id" => $userId));
                    }
                }
                if (!empty($userDetails)) {

                    if ($userDetails->twitter_id == $twitter_id) {
                        if (in_array($userDetails->is_delete, array(0, 2, 3, 5))) {

                            $up_data = array(
                                'last_logged_in' => date('Y-m-d H:i:s'),
                                'twitter_id' => $twitter_id
                            );
                            if ($userDetails->user_role == 'storeUser')
                                $userDetails->last_login_as = '';

                            $array1 = array('user_id' => $userDetails->user_id);
                            $this->dbcommon->update('user', $array1, $up_data);

                            $session_data['gen_user'] = (array) $userDetails;
                            $session_data["logged_in"] = TRUE;
                            $session_data["tw_logged_in"] = TRUE;
                            $this->session->set_userdata($session_data);
                            $this->dbcart->add_user_cart($userDetails->user_id);

                            $redirect = $this->session->userdata('client_request');
                            $sub_domain = $this->session->userdata('client_request_subdomain');
                            if ($sub_domain != '') {
                                $client_request_subdomain = $this->session->userdata('client_request_subdomain');
                                $this->session->unset_userdata('client_request_subdomain');
                                $redirect = $this->session->userdata('client_request');
                                if ($redirect == '')
                                    $redirect = '/home';
                                $this->session->unset_userdata('client_request');

                                header('Location:' . HTTPS . $client_request_subdomain . $redirect);
                            }
                            elseif (isset($redirect)) {
                                $this->session->unset_userdata('client_request');
                                header('Location:' . $redirect);
                            } else {
                                redirect('user/index/');
                            }
                        } else {

                            if ($userDetails->is_delete == 1)
                                $this->session->set_flashdata('msg', 'Your account has been deleted earlier.');
                            elseif ($userDetails->is_delete == 4) {

                                $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
                                $array = array('page_state' => 1, 'page_id' => 23);
                                $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

                                if ($header_menu[0]['direct_url'] != '')
                                    $contact_url = $header_menu[0]['direct_url'];
                                else
                                    $contact_url = $header_menu[0]['slug_url'];

                                $this->session->set_flashdata('msg', '<font color="red">Your Account Is Blocked By Admin. To Unblock  &nbsp; <a href="' . site_url() . $contact_url . '"><span><u>' . $header_menu[0]['page_title'] . '</u></span></a>&nbsp;&nbsp;</font>');
                            }

                            redirect('home');
                        }
                    }
                    else {
                        $this->session->set_flashdata('msg', 'Email-id already Registered...');
                        redirect('home');
                    }
                }
            }
        }
    }

    /* authentication un-successful */

    public function failure() {

        $this->session->unset_userdata('tw_access_token');
        $this->session->unset_userdata('tw_request_token');
        $this->session->unset_userdata('tw_status');

        $this->session->set_flashdata(array('msg5' => 'Something went wrong, Please try again.', 'class' => 'alert-success'));
        redirect('login/index');
    }

    /* clear session */

    public function clearsession() {

        $this->session->sess_destroy();

        redirect('/login');
    }

    public function signout() {

        $this->session->unset_userdata('gen_user');
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('fb_logged_in');
        $this->session->unset_userdata('fb_token');

        $this->session->unset_userdata('doukani_products');
        $this->session->unset_userdata('cart_products');
        $this->session->unset_userdata('doukani_products_quantity');
        $this->session->unset_userdata('request_for_statewise');

        $this->session->unset_userdata('fb_logged_in');
        $this->session->unset_userdata('fb_token');

        $this->session->unset_userdata('tw_access_token');
        $this->session->unset_userdata('tw_request_token');
        $this->session->unset_userdata('tw_status');
        $this->session->unset_userdata('gp_logged_in');

        $this->session->unset_userdata('client_request');
        $this->session->unset_userdata('client_request_subdomain');
        $this->session->unset_userdata('client_request_subdomain_uri');
        $this->session->unset_userdata('URI_STRING');

        header("Location:" . HTTPS . doukani_website);
    }

    public function forget_password() {

        if ($this->session->userdata('gen_user') != '')
            redirect('user/index');
        else {
            $result = array();
            $result['is_logged'] = 0;
            $result['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $result['loggedin_user'] = $current_user['user_id'];
                $result['is_logged'] = 1;
            }
            $result = array_merge($result, $this->get_elements());
            $result['page_title'] = 'Forgot Password';
            $this->form_validation->set_rules('email_id', 'Email Address', 'trim|required|valid_email|max_length[250]');
            if ($this->form_validation->run() == false) {
                $result['msg'] = '';
                $this->load->view('login/forget_password', $result);
            } else {
                $where = " where email_id='" . addslashes($_POST['email_id']) . "' or username='" . $_POST['email_id'] . "'";
                $user = $this->dblogin->isExist($where);
                if (!empty($user)):

                    $username = $user->username;
                    $email_id = $user->email_id;
                    $activate_key = $this->my_encryption->safe_b64encode($user->password);
                    $button_link = base_url() . "login/reset_password?ident=" . $user->user_id . "&activate=" . $activate_key;
                    $button_label = 'Reset Password';
                    $parser_data = array();
                    $title = 'Forgot Password?';

                    $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> 
        <h3 style="color:#7f7f7f; font-size:16px;">Reset your password</h3>
        <strong>Username:</strong>' . $username . '<p style="margin: 1em 0;">
                                        <strong>E-mail:</strong>
                                        <a href="mailto:' . $email_id . '" style="color: #000000 !important;">' . $email_id . '</a></p>
                        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>';

                    $new_data = $this->dbcommon->mail_format($title, $content);
                    $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

                    if (send_mail($user->email_id, 'Reset Password', $new_data)) {
                        $this->session->set_flashdata(array('msg3' => 'The reset password mail sent successfully.', 'class' => 'alert-success'));
                        redirect('login/forget_password');
                    } else {
                        $result['msg'] = 'Mail sending failed, Please try again';
                        $result['msg_class'] = 'alert-info';
                        $this->load->view('login/forget_password', $result);
                    }
                else:
                    $result['msg'] = 'Sorry! There is not any User register with this email address.';
                    $result['msg_class'] = 'alert-info';
                    $this->load->view('login/forget_password', $result);
                endif;
            }
        }
    }

    public function reset_password() {

        if ($this->session->userdata('gen_user') != '')
            redirect('user/index');
        else {

            $data = array();
            $data = array_merge($data, $this->get_elements());
            $data['page_title'] = 'Reset Password';
            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';

            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            if (isset($_POST['submit'])):
                if (!empty($_POST['ident']) && !empty($_POST['activate'])) :
                    $userId = $_POST['ident'];
                    $activateKey = $_POST['activate'];
                    $where = " where user_id='" . $userId . "'";
                    $user = $this->dblogin->isExist($where);
                    if (!empty($user)):
                        $thekey = $this->my_encryption->safe_b64encode($user->password);
                        if ($thekey == $activateKey):
                            $password = $_POST['password'];
                            $new_password = md5($password);
                            $data = array('password' => $new_password);
                            $array = array('user_id' => $user->user_id);
                            $result = $this->dbcommon->update('user', $array, $data);
                            $this->session->set_flashdata(array('msg3' => 'Your password changed successfully', 'class' => 'alert-success'));
                            redirect('login/index');
                        else:
                            $data['msg'] = 'Your password not change...';
                            $data['msg_class'] = 'alert-info';
                            $data['ident'] = $userId;
                            $data['activate'] = $activateKey;
                            $this->load->view('login/reset_password', $data);
                        endif;
                    else:
                        $data['msg'] = 'Your password not change...';
                        $data['msg_class'] = 'alert-info';
                        $data['ident'] = $userId;
                        $data['activate'] = $activateKey;
                        $this->load->view('login/reset_password', $data);
                    endif;
                endif;
            else:
                if (isset($_GET['ident']) && isset($_GET['activate'])):
                    $data['ident'] = $_GET['ident'];
                    $data['activate'] = $_GET['activate'];
                    $this->load->view('login/reset_password', $data);
                else:
                    redirect('login/index');
                endif;
            endif;
        }
    }

    function agree() {
        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user)) {
            $data = array();
            $data = array_merge($data, $this->get_elements());
            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {

                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            $where = " where page_id=21";
            $term_link = $this->dbcommon->getrowdetails('pages_cms', $where);
            $data['term_link'] = $term_link;

            $data['page_title'] = 'Agree for Terms & Conditions';
            $this->load->view('login/agree', $data);
        } else {
            override_404();
        }
    }

    public function user_role() {

        $data = array();
        $current_user = $this->session->userdata('gen_user');
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';

        if (isset($current_user)) {
            $data = array();
            $data = array_merge($data, $this->get_elements());
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
            $data['page_title'] = 'Select User Type';

            $where = " where page_id=28";
            $term_link = $this->dbcommon->getrowdetails('pages_cms', $where);
            $data['term_link'] = $term_link;

            if (isset($_REQUEST['submit'])) {
                $this->form_validation->set_rules('user_role', '', 'required');
                if ($this->form_validation->run() == FALSE):
                    $data['error'] = $this->load->view('login/user_role', $data);
                else:

                    $current_user['user_role'] = $_REQUEST['user_role'];
                    $this->session->set_userdata('gen_user', $current_user);

                    $query_settings = '';
                    if ($_POST['user_role'] == 'generalUser')
                        $query_settings = ' id=3 and `key`="no_of_post_month_classified_user" limit 1';
                    elseif ($_POST['user_role'] == 'offerUser')
                        $query_settings = ' id=11 and `key`="no_of_post_month_offer_user" limit 1';
                    elseif ($_POST['user_role'] == 'storeUser')
                        $query_settings = ' id=9 and `key`="no_of_post_month_store_user" limit 1';

                    if ($query_settings != '') {
                        $ads_cnt = $this->dbcommon->filter('settings', $query_settings);

                        if ($ads_cnt[0]['val'] > 0)
                            $cnt_ads = $ads_cnt[0]['val'];
                        else
                            $cnt_ads = default_no_of_ads;
                    } else
                        $cnt_ads = default_no_of_ads;

                    if (isset($_POST['user_role']) && $_POST['user_role'] == 'storeUser') {
                        $current_user = $this->session->userdata('gen_user');
                        $current_user['user_role'] = $_POST['user_role'];
                        $current_user['is_delete'] = 5;
                        $current_user['userTotalAds'] = $cnt_ads;
                        $current_user['userAdsLeft'] = $cnt_ads;
                        $current_user['last_login_as'] = 'storeUser';

                        $this->session->set_userdata('gen_user', $current_user);

                        $in_data = array();

                        $in_data['user_role'] = $_POST['user_role'];
                        $in_data['is_delete'] = 5;
                        $in_data['userTotalAds'] = $cnt_ads;
                        $in_data['userAdsLeft'] = $cnt_ads;

                        $array = array('user_id' => $current_user['user_id']);
                        $result = $this->dbcommon->update('user', $array, $in_data);

                        $where = " where store_owner ='" . $current_user['user_id'] . "'";
                        $store = $this->dbcommon->getdetails('store_new_details', $where);
                        if (((isset($current_user['google_id']) || !empty($current_user['google_id'])) || (isset($current_user['twitter_id']) || !empty($current_user['twitter_id'])) || (isset($current_user['facebook_id']) || !empty($current_user['facebook_id'])) ) && empty($current_user['password']) && isset($store) && sizeof($store) == 0)
                            redirect('login/create_store');
                        else
                            redirect('user/index');
                    } else {

                        $current_user = $this->session->userdata('gen_user');

                        $current_user['user_role'] = $_POST['user_role'];
                        $current_user['is_delete'] = 0;
                        $current_user['userTotalAds'] = $cnt_ads;
                        $current_user['userAdsLeft'] = $cnt_ads;

                        $this->session->set_userdata('gen_user', $current_user);

                        $in_data = array();

                        $in_data['user_role'] = $_POST['user_role'];
                        $in_data['is_delete'] = 0;
                        $in_data['userTotalAds'] = $cnt_ads;
                        $in_data['userAdsLeft'] = $cnt_ads;

                        $array = array('user_id' => $current_user['user_id']);
                        $result = $this->dbcommon->update('user', $array, $in_data);

                        redirect('user/index');
                    }
                endif;
            }
            $this->load->view('login/user_role', $data);
        } else
            redirect('home');
    }

    public function create_store() {

        $data = array();

        $data = array_merge($data, $this->get_elements());
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';

        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');

            $query = ' FIND_IN_SET(1, category_type) > 0 order by cat_order';
            $category = $this->dbcommon->filter('category', $query);

            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;

            $data['page_title'] = 'Create Store';
            $this->load->view('login/create_store', $data);
        } else
            redirect('home');
    }

    public function check_subdomain_name($store_url = NULL) {

        $where = ' store_id from store where store_domain="' . $_POST['store_domain'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0)
            return 0;
        else
            return 1;
    }

    public function ajax_createstore() {

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        if (isset($_POST['store_submit'])) {

            $success = 1;
            $where = ' store_id from store where store_name="' . trim($_POST['store_name']) . '"';
            $count_store_name = $this->dbcommon->getnumofdetails_($where);

            $where = ' store_id from store where store_domain="' . trim($_POST['store_domain']) . '"';
            $count_store_domain = $this->dbcommon->getnumofdetails_($where);

            $category_id = trim($_POST['category_id']);
            $store_domain = trim($_POST['store_domain']);
            $store_name = trim($_POST['store_name']);
            $website_link = trim($_POST['webiste_link']);

            if (isset($category_id) && (int) $category_id == 0) {
                if (empty($_POST['webiste_link'])) {
                    $success = 0;
                    $arr = array('response' => 'website_name_error');
                    echo json_encode($arr);
                    exit;
                }
            }
            if (isset($category_id) && (int) $category_id > 0 && empty($store_name)) {
                $success = 0;
                $arr = array('response' => 'store_empty_name_error');
                echo json_encode($arr);
                exit;
            }
            if (empty($store_domain)) {
                $success = 0;
                $arr = array('response' => 'store_empty_domain_error');
                echo json_encode($arr);
                exit;
            }

            if ($count_store_name > 0) {
                $success = 0;
                $arr = array('response' => 'store_name_error');
                echo json_encode($arr);
                exit;
            }
            if ($count_store_domain > 0) {
                $success = 0;
                $arr = array('response' => 'store_domain_error');
                echo json_encode($arr);
                exit;
            }

//            else                 
            if ($success > 0) {
                $in_storedata = array(
                    'store_owner' => $current_user['user_id'],
                    'category_id' => $_POST['category_id'],
                    'sub_category_id' => $_POST['sub_category_id'],
                    'store_domain' => strtolower(str_replace('.', '', $_POST['store_domain'])),
                    'store_name' => $_POST['store_name'],
                    'store_description' => (isset($category_id) && (int) $category_id > 0) ? $_POST['store_description'] : '',
                    'meta_title' => $_POST['meta_title'],
                    'meta_description' => $_POST['meta_description'],
                    'store_status' => 0,
                    'store_details_verified' => 0,
                    'new_data_status' => 0,
                    'store_is_inappropriate' => 'NeedReview',
                    'shipping_cost' => (isset($category_id) && (int) $category_id > 0) ? $_POST['shipping_cost'] : '',
                    'website_url' => (isset($category_id) && (int) $category_id == 0) ? $_POST['webiste_link'] : ''
                );

                $this->dbcommon->insert('store', $in_storedata);

                $in_storedata = array(
                    'store_owner' => $current_user['user_id'],
                    'category_id' => $_POST['category_id'],
                    'sub_category_id' => $_POST['sub_category_id'],
                    'store_domain' => strtolower(str_replace('.', '', $_POST['store_domain'])),
                    'store_name' => $_POST['store_name'],
                    'store_description' => (isset($category_id) && (int) $category_id > 0) ? $_POST['store_description'] : '',
                    'meta_title' => $_POST['meta_title'],
                    'meta_description' => $_POST['meta_description'],
                    'store_status' => 0,
                    'store_is_inappropriate' => 'NeedReview',
                    'website_url' => (isset($category_id) && (int) $category_id == 0) ? $_POST['webiste_link'] : ''
                );


                $store_id = $this->db->insert_id();
                $in_new_details = $in_storedata;
                $in_new_details['store_id'] = $store_id;

                $this->dbcommon->insert('store_new_details', $in_new_details);

                $send_msg = 'Store waiting for Approval';
                $text = 'Thank you for createing store. Currently,Our team is reviewing your store details and will upldate you very soon...';
                $store_domain = strtolower(str_replace('.', '', $_POST['store_domain'])) . after_subdomain . remove_home;
                $button_link = base_url() . "login/index";
                $button_label = 'Click here to Login';

                $parser_data = array();
                $title = $send_msg;
                $detail = $text;
                $content = '
           <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>
            <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:12px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;">' . $detail . '</h6><br>
            Visit your store after login:
            <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . HTTP . $store_domain . '">' . strtolower(str_replace('.', '', $_POST['store_domain'])) . after_subdomain . '</a><br>
            </div>';

                $new_data = $this->dbcommon->mail_format($title, $content);
                $new_data = $this->parser->parse_string($new_data, $parser_data, '1');
                if ($current_user['email_id'] != '') {
                    if (send_mail($current_user['email_id'], $send_msg, $new_data, 'info@doukani.com')) {
                        
                    }
                }

                $current_user['is_delete'] = 0;
                $current_user['last_login_as'] = 'storeUser';
                $this->session->set_userdata('gen_user', $current_user);

                $data = array('is_delete' => 0);
                $array = array('user_id' => $current_user['user_id']);
                $result = $this->dbcommon->update('user', $array, $data);

                $arr = array('response' => 'success');
                echo json_encode($arr);
            }
        }
        exit;
    }

    public function user_agree() {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user)) {
            $data = array('is_delete' => 0);
            $array = array('user_id' => $current_user['user_id'], 'is_delete' => 2);
            $result = $this->dbcommon->update('user', $array, $data);

            $current_user['is_delete'] = 0;
            $this->session->set_userdata('gen_user', $current_user);

            if ($current_user['user_role'] == 'storeUser') {
                $current_user['is_delete'] = 5;
                $this->session->set_userdata('gen_user', $current_user);
            }

            redirect('user/index');
        } else
            redirect('home');
    }

    public function ajax_login() {

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('username', 'UserName', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE) {
                $data['msg2'] = "";
                //$this->load->view('login/index', $data);
            } else {
                $where = " where (email_id='" . addslashes($_POST['username']) . "' or username='" . $_POST['username'] . "') and password='" . addslashes(md5($_POST['password'])) . "'";
                //and is_delete=0
                $my_array = $this->db->query("select * from user where (email_id='" . addslashes($_POST['username']) . "' or username='" . $_POST['username'] . "') and password='" . addslashes(md5($_POST['password'])) . "'  limit 1")->row_array();

                // and is_delete=0 
                $user = $this->dblogin->isExist($where);

                if ($user) {
                    if ($user->is_delete == 4) {

                        $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
                        $array = array('page_state' => 1, 'page_id' => 23);
                        $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

                        if ($header_menu[0]['direct_url'] != '')
                            $contact_url = $header_menu[0]['direct_url'];
                        else
                            $contact_url = $header_menu[0]['slug_url'];

                        $arr = array('response' => '<font color="red">Your Account Is Blocked By Admin. To Unblock  &nbsp; <a href="' . site_url() . $contact_url . '"><span><u>' . $header_menu[0]['page_title'] . '</u></span></a>&nbsp;&nbsp;</font>');
                        echo json_encode($arr);
                    } else if ($user->status == "inactive") {
                        $arr = array('response' => 'Your Account Is Not Active');
                        echo json_encode($arr);
                    } else if ($user->is_delete == 1) {
                        $arr = array('response' => 'Your account has been deleted earlier.');
                        echo json_encode($arr);
                    } else if ($user->user_role == 'offerUser') {
                        $arr = array('response' => 'Offer Company\'s User can not be logged in.');
                        echo json_encode($arr);
                    } elseif ($user->is_delete == 2) {

                        $data = array(
                            'last_logged_in' => date('Y-m-d H:i:s')
                        );
                        $array = array('user_id' => $user->user_id);
                        $result = $this->dbcommon->update('user', $array, $data);

                        $this->session->set_userdata('gen_user', $my_array);
                        $this->dbcart->add_user_cart($user->user_id);

                        $this->session->set_userdata('show_user_popup', 'yes');

                        $arr = array('response' => 'not_agree');
                        echo json_encode($arr);
                        //redirect('login/agree');
                    } elseif ($user->user_role == NULL || $user->user_role == '') {

                        $data = array(
                            'last_logged_in' => date('Y-m-d H:i:s')
                        );
                        $array = array('user_id' => $user->user_id);
                        $result = $this->dbcommon->update('user', $array, $data);

                        $this->session->set_userdata('gen_user', $my_array);
                        $this->dbcart->add_user_cart($user->user_id);
                        $this->session->set_userdata('show_user_popup', 'yes');
                        $arr = array('response' => 'user_role');
                        echo json_encode($arr);
                    } elseif ($user->is_delete == 5) {

                        $data = array(
                            'last_logged_in' => date('Y-m-d H:i:s')
                        );
                        $array = array('user_id' => $user->user_id);
                        $result = $this->dbcommon->update('user', $array, $data);

                        $this->session->set_userdata('gen_user', $my_array);
                        $this->dbcart->add_user_cart($user->user_id);
                        $this->session->set_userdata('show_user_popup', 'yes');
                        $arr = array('response' => 'create_store');
                        echo json_encode($arr);
                    } else {

                        $data = array('last_logged_in' => date('Y-m-d H:i:s'));
                        if ($user->user_role == 'storeUser')
                            $my_array['last_login_as'] = '';

                        $array = array('user_id' => $user->user_id);
                        $result = $this->dbcommon->update('user', $array, $data);

                        $this->session->set_userdata('gen_user', $my_array);
                        $this->dbcart->add_user_cart($user->user_id);
                        $this->session->set_userdata('show_user_popup', 'yes');
                        $redirect = $this->session->userdata('client_request');

                        $arr = array('response' => 'agree');
                        echo json_encode($arr);
                    }
                } else {
                    $arr = array('response' => 'Username and Password not matched.');
                    echo json_encode($arr);
                }
            }
        }
        exit;
    }

    public function facebook_login() {

        header('Content-type: text/html; charset=utf-8');
        $session_data = array();
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-t');

        $data = array();
        $data = array_merge($data, $this->get_elements());

        /* Facebook Login Start */
        $data['fb_login_url'] = $this->facebook->get_login_url();
        $data['user_me'] = $this->facebook->get_user();
        $data['page_title'] = 'Login';

        if (!empty($data['user_me'])) {

            if (empty($data['user_me']['email'])) {

                $data['msg2'] = 'Please verify your email address in facebook';
                $data['msg_class'] = 'alert-info';
                $this->load->view('login/index', $data);
                return;
            }

            if ($data['user_me']['name'] == '')
                $uname = $this->dbcommon->make_username($data['user_me']['email']);
            else
                $uname = $data['user_me']['name'];

            $firstName = $data['user_me']['first_name'];
            $lastName = $data['user_me']['last_name'];
            $name = $data['user_me']['name'];
            $email = $data['user_me']['email'];
            $fbId = $data['user_me']['id'];
            $loginToken = $this->session->userdata("fb_token");

            $userDetails = $this->dbuser->getUserDetails(array("email_id" => $email));

            if (empty($userDetails)) {

                $slug_email_id = $email;
                $get_char_slug = $uname;
                $user_slug = $this->dbcommon->generate_slug($get_char_slug, 'U');

                $insertArr = array(
                    "username" => preg_replace('/[^A-Za-z0-9\-]/', '', $uname),
                    "email_id" => $email,
                    "facebook_id" => $fbId,
                    "login_token" => $loginToken,
                    "status" => 'active',
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'insert_from' => 'web',
                    'is_delete' => 2,
                    'last_logged_in' => date('Y-m-d H:i:s'),
                    'user_slug' => $user_slug,
                    'user_role' => 'generalUser'
                );

                if ($this->dbuser->insert($insertArr)) {

                    $userId = $this->db->insert_id();
                    $userDetails = $this->dbuser->getUserDetails(array("user_id" => $userId));
                }
            }

            if (!empty($userDetails)) {

                if ($userDetails->facebook_id == $fbId) {

                    if (in_array($userDetails->is_delete, array(0, 2, 3, 5))) {

                        $up_data = array(
                            'last_logged_in' => date('Y-m-d H:i:s'),
                            'facebook_id' => $fbId
                        );

                        if ($userDetails->user_role == 'storeUser')
                            $userDetails->last_login_as = '';

                        $array1 = array('user_id' => $userDetails->user_id);
                        $this->dbcommon->update('user', $array1, $up_data);

                        $session_data['gen_user'] = (array) $userDetails;
                        $session_data["logged_in"] = TRUE;
                        $session_data["fb_logged_in"] = TRUE;
                        $sess = $this->session->set_userdata($session_data);
                        $this->dbcart->add_user_cart($userDetails->user_id);

                        $redirect = $this->session->userdata('client_request');

                        $sub_domain = $this->session->userdata('client_request_subdomain');
                        if ($sub_domain != '') {
                            $client_request_subdomain = $this->session->userdata('client_request_subdomain');
                            $this->session->unset_userdata('client_request_subdomain');
                            $redirect = $this->session->userdata('client_request');
                            if ($redirect == '')
                                $redirect = '/home';
                            $this->session->unset_userdata('client_request');

                            header('Location:' . HTTPS . $client_request_subdomain . $redirect);
                        }
                        elseif (isset($redirect)) {
                            $this->session->unset_userdata('client_request');
                            header('Location:' . $redirect);
                        } else {
                            redirect('user/index');
                        }

                        exit;
                    } else {

                        if ($userDetails->is_delete == 1)
                            $this->session->set_flashdata('msg', 'Your account has been deleted earlier.');
                        elseif ($userDetails->is_delete == 4) {

                            $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
                            $array = array('page_state' => 1, 'page_id' => 23);
                            $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

                            if ($header_menu[0]['direct_url'] != '')
                                $contact_url = $header_menu[0]['direct_url'];
                            else
                                $contact_url = $header_menu[0]['slug_url'];

                            $this->session->set_flashdata('msg', '<font color="red">Your Account Is Blocked By Admin. To Unblock  &nbsp; <a href="' . site_url() . $contact_url . '"><span><u>' . $header_menu[0]['page_title'] . '</u></span></a>&nbsp;&nbsp;</font>');
                        }
                        redirect('home');
                    }
                }
                else {
                    $this->session->set_flashdata('msg', 'Email-id already Registered...');
                    redirect('home');
                }
            }
        } else {

            header('Location:' . $this->facebook->get_login_url());

            $data['msg2'] = 'Signup/Login Failed';
            $data['msg_class'] = 'alert-info';
            $this->load->view('login/index', $data);
            //}
        }
        /* Facebook Login Complete */
    }

    public function google_login() {

        header('Content-type: text/html; charset=utf-8');
        $session_data = array();
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-t');

        $data = array();
        $data = array_merge($data, $this->get_elements());

        /* Google Plus Login Start */
        $this->googleplus->client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me'));
        if (isset($_GET['code'])) {

            $this->googleplus->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->googleplus->client->getAccessToken();
            header('Location: ' . filter_var($this->googleplus->redirect_uri, FILTER_SANITIZE_URL));
        }
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

            $this->googleplus->client->setAccessToken($_SESSION['access_token']);
        }
        if (isset($_SESSION['access_token']) && $this->googleplus->client->getAccessToken()) {

            $me = $this->googleplus->plus->people->get('me');
            // echo '<pre>';
            // print_r($me["emails"][0]["value"]);
            // echo '</pre>';
            // exit;
            if (!empty($me)) {
                if (!empty($me)) {

                    if (empty($me['emails'][0]['value'])) {
                        $data['msg2'] = 'Please verify your email address in google+';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('login/index', $data);
                        return;
                    }

                    if ($me["displayName"] == '')
                        $uname = $this->dbcommon->make_username($me['emails'][0]['value']);
                    else
                        $uname = $me['displayName'];

                    $googleUsername = str_replace(' ', '.', $uname);
                    $googleUsername = strtolower($googleUsername);
                    $googleName = $me["displayName"];
                    $googleEmail = $me["emails"][0]["value"];
                    $googleId = $me["id"];
                    $image = $me["image"]["url"];
                    $firstname = $me["name"]["givenName"];
                    $lastname = $me["name"]["familyName"];

                    $userDetails = $this->dbuser->getUserDetails(array("email_id" => $googleEmail));

                    if (empty($userDetails)) {

                        $slug_email_id = $googleEmail;
                        $get_char_slug = $googleUsername;
                        $user_slug = $this->dbcommon->generate_slug($get_char_slug, 'U');

                        $insertArr = array(
                            "username" => preg_replace('/[^A-Za-z0-9\-]/', '', $googleUsername),
                            "email_id" => $googleEmail,
                            "google_id" => $googleId,
                            "status" => 'active',
                            'from_date' => $from_date,
                            'to_date' => $to_date,
                            'first_name' => $firstname,
                            'last_name' => $lastname,
                            'insert_from' => 'web',
                            'is_delete' => 2,
                            'last_logged_in' => date('Y-m-d H:i:s'),
                            'user_slug' => $user_slug,
                            'user_role' => 'generalUser'
                        );

                        if ($this->dbuser->insert($insertArr)) {
                            $userId = $this->db->insert_id();
                            $userDetails = $this->dbuser->getUserDetails(array("user_id" => $userId));
                        }
                    }
                    if (!empty($userDetails)) {

                        if ($userDetails->google_id == $googleId) {
                            if (in_array($userDetails->is_delete, array(0, 2, 3, 5))) {

                                $up_data = array(
                                    'last_logged_in' => date('Y-m-d H:i:s'),
                                    'google_id' => $googleId
                                );

                                if ($userDetails->user_role == 'storeUser')
                                    $userDetails->last_login_as = '';

                                $array1 = array('user_id' => $userDetails->user_id);
                                $this->dbcommon->update('user', $array1, $up_data);

                                $session_data['gen_user'] = (array) $userDetails;
                                $session_data["logged_in"] = TRUE;
                                $session_data["gp_logged_in"] = TRUE;
                                $this->session->set_userdata($session_data);
                                $this->dbcart->add_user_cart($userDetails->user_id);

                                $redirect = $this->session->userdata('client_request');

                                $sub_domain = $this->session->userdata('client_request_subdomain');
                                if ($sub_domain != '') {
                                    $client_request_subdomain = $this->session->userdata('client_request_subdomain');
                                    $this->session->unset_userdata('client_request_subdomain');
                                    $redirect = $this->session->userdata('client_request');
                                    if ($redirect == '')
                                        $redirect = '/home';
                                    $this->session->unset_userdata('client_request');

                                    header('Location:' . HTTPS . $client_request_subdomain . $redirect);
                                }
                                elseif (isset($redirect)) {
                                    $this->session->unset_userdata('client_request');
                                    header('Location:' . $redirect);
                                } else {
                                    redirect('user/index');
                                }
                                exit;
                            } else {

                                if ($userDetails->is_delete == 1)
                                    $this->session->set_flashdata('msg', 'Your account has been deleted earlier.');
                                elseif ($userDetails->is_delete == 4) {

                                    $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
                                    $array = array('page_state' => 1, 'page_id' => 23);
                                    $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

                                    if ($header_menu[0]['direct_url'] != '')
                                        $contact_url = $header_menu[0]['direct_url'];
                                    else
                                        $contact_url = $header_menu[0]['slug_url'];

                                    $this->session->set_flashdata('msg', '<font color="red">Your Account Is Blocked By Admin. To Unblock  &nbsp; <a href="' . site_url() . $contact_url . '"><span><u>' . $header_menu[0]['page_title'] . '</u></span></a>&nbsp;&nbsp;</font>');
                                }

                                redirect('home');
                            }
                        }
                        else {
                            $this->session->set_flashdata('msg', 'Email-id already Registered...');
                            redirect('home');
                        }
                    }
                } else {
                    $this->session->set_flashdata("error", "There was problem login with Google Plus. Please try again!");
                    redirect(base_url() . "login/index");
                }
                // $_SESSION['access_token'] = $this->googleplus->client->getAccessToken();
            }
            //If Google plus login is not successfull
            $this->session->set_flashdata("error", "There was problem login with Google Plus. Please try again!");
            redirect(base_url() . "login/index");
            exit;
        }

        $data['googlePlusLoginUrl'] = $this->googleplus->client->createAuthUrl();

        /* Google Plus Login Complete */
    }

    public function twitter_login() {

        /* Twitter Login Start */
        $data['twitter_login_url'] = base_url() . "login/redirect";
        /* Twitter Login Complete */
    }

    function login_page() {
        $this->load->view('login/index');
    }

    public function show_sub_cat() {

        $filter_val = $this->input->post("value");

        $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(1, sub_category_type) > 0";
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);

        echo $this->load->view('admin/stores/sub_cat', $main_data, TRUE);
        exit();
    }

    function user_for() {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user)) {
            $data = array();
            $data = array_merge($data, $this->get_elements());

            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';

            if ($this->session->userdata('gen_user')) {
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            if (isset($_POST['submit'])) {

                $current_user['last_login_as'] = $_POST['user_for'];
                $this->session->set_userdata('gen_user', $current_user);

                $redirect = $this->session->userdata('client_request');
                if (!empty($redirect))
                    $redirect = $redirect;
                else
                    $redirect = 'user/index';

                redirect($redirect);
            }
            $data['page_title'] = 'Login for';
            $this->load->view('login/store_user_login', $data);
        } else
            redirect('home');
    }

}
