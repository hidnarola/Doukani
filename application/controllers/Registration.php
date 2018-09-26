<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registration extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbuser', '', TRUE);
        $this->load->model('dashboard');
        $this->load->library('facebook');

        $this->load->library('twconnect');
        $this->load->library('googleplus');
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('form');
        $this->load->helper('email');
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

    public function index_2() {
        $data = array();
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        $where = " where page_id=21";
        $term_link = $this->dbcommon->getrowdetails('pages_cms', $where);
        $data['term_link'] = $term_link;

        /* if($this->session->userdata('gen_user')!='')
          redirect('user/index');
          else
          { */
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime("+1 months", strtotime($from_date)));

        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'Sign up';
        //$location = $this->dbcommon->select('country');
        $location = $this->dbcommon->select_orderby('nationality', 'name', 'asc');

        $data['location'] = $location;

        if (isset($_POST['activate'])) {

            $user_id = $_POST['user_id'];

            $user_data = array(
                'is_delete' => 0
            );

            if (isset($_POST['pro_checkbox'])) {
                $pro_array = array('product_posted_by' => $user_id);
                $this->dbcommon->update('product', $pro_array, $user_data);
            }
            $array = array('user_id' => $user_id);
            $this->dbcommon->update('user', $array, $user_data);
//                    $this->get_user_ads();
            $data['msg'] = 'Your account has been reactivated. Please Login.';
            $data['msg_class'] = 'alert-success';
            $this->load->view('login/index', $data);
        }
        $where = "country_id=4";
        $cities = $this->dbcommon->filter('state', $where);

        $data['cities'] = $cities;
        if (isset($_POST['register'])) {

            // validation 
            $this->form_validation->set_rules('fname', 'First Name', 'required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('lname', 'Last Name', 'required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('email_id', 'Email', 'trim|required|valid_email|max_length[50]');
            //|is_unique[user.email_id]
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');

            $this->form_validation->set_rules('user_role', 'User Type', 'required');
            $this->form_validation->set_rules('uname', 'Username', 'required|min_length[3]|max_length[30]|alpha_numeric');
            $this->form_validation->set_rules('password1', 'Password', 'trim|alpha_numeric|min_length[6]|max_length[15]');
            $this->form_validation->set_rules('date_of_birth', 'Birth Date', 'required');

            //$this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                //print_r($this->form_validation);
                // $data['msg'] = "Please fill all required fields";
                // $data['msg_class'] = 'alert-info';
                $this->load->view('registration/index', $data);
            else:
                $city_id = $city_name = '';
                /* if(isset($_POST['sub_state_list'])){
                  $city_id_name = explode("_", $_POST['sub_state_list']);
                  $city_id = $city_id_name[0];
                  //$city_name = $city_id_name[1];
                  } */
                $where = " where email_id='" . addslashes($_POST['email_id']) . "' or username='" . $_POST['uname'] . "'";
                // $where = " where email_id='" . addslashes($_POST['email_id']) . "'";
                // $where1 = " where username='" . $_POST['username'] . "'";
                $user = $this->dblogin->isExist($where);
                //$user1 = $this->dblogin->isExist($where1);


                if (isset($_POST['user_role']) && $_POST['user_role'] == 'storeUser' && !isset($_POST['term_condition']))
                    $agree_status = 2;
                elseif (isset($_POST['user_role']) && $_POST['user_role'] == 'storeUser' && isset($_POST['term_condition']) && $_POST['term_condition'] == 1)
                    $agree_status = 5;
                elseif (isset($_POST['term_condition']) && $_POST['term_condition'] == 1)
                    $agree_status = 0;
                else
                    $agree_status = 2;

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

                $slug_email_id = $_POST['email_id'];
                $get_char_slug = $_POST['uname'];
                $user_slug = $this->dbcommon->generate_slug($get_char_slug, 'U');

                if (empty($user)):

                    $result_data = array(
                        'username' => preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['uname']),
                        'email_id' => $_POST['email_id'],
                        'password' => md5($_POST['password1']),
                        'phone' => $_POST['phone'],
                        'contact_number' => $_POST['phone'],
                        'nationality' => $_POST['location'],
                        'city' => '',
                        'state' => '',
                        'date_of_birth' => $_POST['date_of_birth'],
                        'gender' => $_POST['gender'],
                        'userTotalAds' => $cnt_ads,
                        'userAdsLeft' => $cnt_ads,
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'status' => 'inactive',
                        'first_name' => $_POST['fname'],
                        'last_name' => $_POST['lname'],
                        'insert_from' => 'web',
                        'is_delete' => $agree_status,
                        'user_role' => $_POST['user_role'],
                        'user_slug' => $user_slug,
                        'last_logged_in' => date('Y-m-d H:i:s')
                    );
                    //'nick_name'=>$_POST['nick_name'],

                    $result = $this->dblogin->insert($result_data);
                    /* if($result):
                      $data['msg'] = 'successfully.';
                      $data['msg_class'] = 'alert-success';
                      $this->load->view('registration/index', $data);
                      endif; */
                    if ($result):
                        $username = $_POST['uname'];
                        $user_id = $this->dblogin->getLastInserted();
                        $parser_data = array();
//                        $parser_data['password'] = $link;
//                        $parser_data['username'] = $username;
//                        $parser_data['email'] = $_POST['email_id'];

                        $email_id = $_POST['email_id'];
                        $activate_key = $this->my_encryption->safe_b64encode($email_id);
                        $button_link = base_url() . "registration/verify?ident=" . $user_id . "&activate=" . $activate_key;
                        $button_label = 'Click here to confirm your account';
                        $title = 'Thank you for joining us!';

                        $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;">                        
                        <h3>Account Confirmation</h3><strong>Username:</strong>
                                        ' . $username . '
                                        <p style="margin: 1em 0;">
                                        <strong>E-mail:</strong>
                                        <a href="mailto:' . $email_id . '" style="color: #000000 !important;">' . $email_id . '</a></p>
    <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:240px; " href="' . $button_link . '">' . $button_label . '</a></div>';


                        $new_data = $this->dbcommon->mail_format($title, $content);
                        $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

                        if (send_mail($email_id, 'Signup | Verification', $new_data, 'info@doukani.com')) {
                            $data['msg'] = 'The Verification mail sent successfully.';
                            $data['msg_class'] = 'alert-success';
                            $this->session->set_flashdata('msg5', 'The Verification mail sent successfully.');
                            if ($_POST['user_role'] == 'generalUser') {
                                $this->session->set_userdata('reg_user_name', $username);
                                redirect('registration/thank_you');
                            }
                            redirect('login/index');
                        } else {
                            $this->db->query('delete from user where user_id = ' . $user_id);
                            $data['msg'] = 'Verification mail sending failed, Please try again';
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('registration/index', $data);
                        }
                    endif;
                else:
                    if ($user->is_delete != 1) {
                        $data['msg'] = 'User already exist with same email/username.';
                        $data['msg_class'] = 'alert-info';
                    } else if ($user->is_delete == 1) {
                        $data['msg'] = 'You have been already registered earlier. Do you want to activate your account again as you had chose to remove the account?';
                        $data['msg_class'] = 'alert-info';
                        $data['deleted_earlier'] = 1;
                        $data['user_id'] = $user->user_id;
                    }

                    $this->load->view('registration/index', $data);
                // $this->load->view('registration/index', $data);
                endif;

            endif;
        } else {
            $this->load->view('registration/index', $data);
        }

        //}	
    }

    public function create_session_store() {
        if ($this->input->post()) {
            if (!empty($this->input->post('store_name_create'))) {
                $this->session->set_userdata('store_name_create', $this->input->post('store_name_create'));
                if ($this->session->userdata('store_name_create') && $this->session->userdata('store_name_create') != '') {
                    echo 'success';
                } else {
                    echo 'fail';
                }
            }
        }
    }
    
    /**
     * Activated index registration function
     * Done By Rep
     * on 05-01-2018
     */
    public function index() {
        $data = array();
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        $where = " where page_id=21";
        $term_link = $this->dbcommon->getrowdetails('pages_cms', $where);
        $data['term_link'] = $term_link;

        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime("+1 months", strtotime($from_date)));

        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'Sign up';
        $location = $this->dbcommon->select_orderby('nationality', 'name', 'asc');

        $data['location'] = $location;

        if (isset($_POST['activate'])) {
            $user_id = $_POST['user_id'];
            $user_data = array(
                'is_delete' => 0
            );

            if (isset($_POST['pro_checkbox'])) {
                $pro_array = array('product_posted_by' => $user_id);
                $this->dbcommon->update('product', $pro_array, $user_data);
            }
            $array = array('user_id' => $user_id);
            $this->dbcommon->update('user', $array, $user_data);
            $data['msg'] = 'Your account has been reactivated. Please Login.';
            $data['msg_class'] = 'alert-success';
            $this->load->view('login/index', $data);
        }
        $where = "country_id=4";
        $cities = $this->dbcommon->filter('state', $where);

        $data['cities'] = $cities;
        if (isset($_POST['register'])) {
            // validation 
            $this->form_validation->set_rules('fname', 'First Name', 'required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('lname', 'Last Name', 'required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('email_id', 'Email', 'trim|required|valid_email|max_length[50]');
            //|is_unique[user.email_id]
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');
            $this->form_validation->set_rules('uname', 'Username', 'required|min_length[3]|max_length[30]|alpha_numeric');
            $this->form_validation->set_rules('password1', 'Password', 'trim|alpha_numeric|min_length[6]|max_length[15]');
//            echo '<pre>';
//            print_r($_POST);
//            exit;

            if ($this->form_validation->run() == FALSE):
                $this->load->view('classifiedregistration/index', $data);
            else:

                $city_id = $city_name = '';
                $where = " where email_id='" . addslashes($_POST['email_id']) . "'";
                $user = $this->dblogin->isExist($where);
                //--- ask for these 2
                if (isset($_POST['term_condition']) && $_POST['term_condition'] == 1)
                    $agree_status = 0;
                else
                    $agree_status = 2;
                $query_settings = '';
                $query_settings = ' id=3 and `key`="no_of_post_month_classified_user" limit 1';

                if ($query_settings != '') {
                    $ads_cnt = $this->dbcommon->filter('settings', $query_settings);

                    if ($ads_cnt[0]['val'] > 0)
                        $cnt_ads = $ads_cnt[0]['val'];
                    else
                        $cnt_ads = default_no_of_ads;
                } else
                    $cnt_ads = default_no_of_ads;
                $slug_email_id = $_POST['email_id'];
                $get_char_slug = $_POST['uname'];
                $user_slug = $this->dbcommon->generate_slug($get_char_slug, 'U');

                if (empty($user)):
                    $result_data = array(
                        'username' => preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['uname']),
                        'email_id' => $_POST['email_id'],
                        'password' => md5($_POST['password1']),
                        'phone' => $_POST['phone'],
                        'contact_number' => $_POST['phone'],
                        'nationality' => '',
                        'city' => '',
                        'state' => '',
                        'date_of_birth' => '',
                        'gender' => '',
                        'userTotalAds' => $cnt_ads,
                        'userAdsLeft' => $cnt_ads,
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'status' => 'inactive',
                        'first_name' => $_POST['fname'],
                        'last_name' => $_POST['lname'],
                        'insert_from' => 'web',
                        'is_delete' => $agree_status,
                        'user_role' => 'generalUser',
                        'user_slug' => $user_slug,
                        'last_logged_in' => date('Y-m-d H:i:s')
                    );
                    $result = $this->dblogin->insert($result_data);
                    if ($result):
                        $username = $_POST['uname'];
                        $user_id = $this->dblogin->getLastInserted();

                        $parser_data = array();
                        $email_id = $_POST['email_id'];
                        $activate_key = $this->my_encryption->safe_b64encode($email_id);
                        $button_link = base_url() . "registration/verify?ident=" . $user_id . "&activate=" . $activate_key;
                        $button_label = 'Click here to confirm your account';
                        $title = 'Thank you for joining us!';

                        $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;">                        
                        <h3>Account Confirmation</h3><strong>Username:</strong>
                                        ' . $username . '
                                        <p style="margin: 1em 0;">
                                        <strong>E-mail:</strong>
                                        <a href="mailto:' . $email_id . '" style="color: #000000 !important;">' . $email_id . '</a></p>
    <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:240px; " href="' . $button_link . '">' . $button_label . '</a></div>';


                        $new_data = $this->dbcommon->mail_format($title, $content);
                        $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

                        if (send_mail($email_id, 'Signup | Verification', $new_data, 'info@doukani.com')) {
                            $data['msg'] = 'The Verification mail sent successfully.';
                            $data['msg_class'] = 'alert-success';
                            $this->session->set_flashdata('msg5', 'The Verification mail sent successfully.');

                            redirect('classifiedRegistration/thank_you');

//                            redirect('login/index');
                        } else {
                            $this->db->query('delete from user where user_id = ' . $user_id);
                            $data['msg'] = 'Verification mail sending failed, Please try again';
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('classifiedregistration/index', $data);
                        }
                    endif;
                else:
                    if ($user->is_delete != 1) {
                        $data['msg'] = 'User already exist with same email/username.';
                        $data['msg_class'] = 'alert-info';
                    } else if ($user->is_delete == 1) {
                        $data['msg'] = 'You have been already registered earlier. Do you want to activate your account again as you had chose to remove the account?';
                        $data['msg_class'] = 'alert-info';
                        $data['deleted_earlier'] = 1;
                        $data['user_id'] = $user->user_id;
                    }
                    $this->load->view('classifiedregistration/index', $data);
                endif;

            endif;
        } else {
            $this->load->view('classifiedregistration/index', $data);
        }
    }

    /**
     * commented by rep on 05-01-2018
     */
    public function index_old() {
        $data = array();
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        $where = " where page_id=21";
        $term_link = $this->dbcommon->getrowdetails('pages_cms', $where);
        $data['term_link'] = $term_link;

        /* if($this->session->userdata('gen_user')!='')
          redirect('user/index');
          else
          { */
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime("+1 months", strtotime($from_date)));

        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'Sign up';
        //$location = $this->dbcommon->select('country');
        $location = $this->dbcommon->select_orderby('nationality', 'name', 'asc');

        $data['location'] = $location;

        if (isset($_POST['activate'])) {

            $user_id = $_POST['user_id'];

            $user_data = array(
                'is_delete' => 0
            );

            if (isset($_POST['pro_checkbox'])) {
                $pro_array = array('product_posted_by' => $user_id);
                $this->dbcommon->update('product', $pro_array, $user_data);
            }
            $array = array('user_id' => $user_id);
            $this->dbcommon->update('user', $array, $user_data);
//                    $this->get_user_ads();
            $data['msg'] = 'Your account has been reactivated. Please Login.';
            $data['msg_class'] = 'alert-success';
            $this->load->view('login/index', $data);
        }
        $where = "country_id=4";
        $cities = $this->dbcommon->filter('state', $where);

        $data['cities'] = $cities;
        if (isset($_POST['register'])) {
            if (isset($_POST['store_name'])) {
                $this->session->set_userdata('store_name_create', $_POST['store_name']);
                $where = ' store_id from store where store_name="' . trim($_POST['store_name']) . '"';
                $count_store_name = $this->dbcommon->getnumofdetails_($where);

                $where = ' store_id from store where store_domain="' . trim($_POST['store_domain']) . '"';
                $count_store_domain = $this->dbcommon->getnumofdetails_($where);

                if ($count_store_name > 0) {
                    
                }
                if ($count_store_domain > 0) {
                    
                }
            }

            // validation 
            $this->form_validation->set_rules('fname', 'First Name', 'required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('lname', 'Last Name', 'required|min_length[3]|max_length[30]');
            $this->form_validation->set_rules('email_id', 'Email', 'trim|required|valid_email|max_length[50]');
            //|is_unique[user.email_id]
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');

            $this->form_validation->set_rules('user_role', 'User Type', 'required');
            $this->form_validation->set_rules('uname', 'Username', 'required|min_length[3]|max_length[30]|alpha_numeric');
            $this->form_validation->set_rules('password1', 'Password', 'trim|alpha_numeric|min_length[6]|max_length[15]');
//            $this->form_validation->set_rules('date_of_birth', 'Birth Date', 'required');
            if ($_POST['user_role'] == 'storeUser') {
                $this->form_validation->set_rules('store_domain', 'Store Domain', 'trim|required|min_length[3]|max_length[20]|callback_check_subdomain_name');
            }
//            echo '<pre>';
//            print_r($_POST); exit;
            //$this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                //print_r($this->form_validation);
                // $data['msg'] = "Please fill all required fields";
                // $data['msg_class'] = 'alert-info';
                $this->load->view('registration/index', $data);
            else:

                $city_id = $city_name = '';
                /* if(isset($_POST['sub_state_list'])){
                  $city_id_name = explode("_", $_POST['sub_state_list']);
                  $city_id = $city_id_name[0];
                  //$city_name = $city_id_name[1];
                  } */
                $where = " where email_id='" . addslashes($_POST['email_id']) . "'";
                // $where = " where email_id='" . addslashes($_POST['email_id']) . "'";
                // $where1 = " where username='" . $_POST['username'] . "'";
                $user = $this->dblogin->isExist($where);
                //$user1 = $this->dblogin->isExist($where1);


                if (isset($_POST['user_role']) && $_POST['user_role'] == 'storeUser' && !isset($_POST['term_condition']))
                    $agree_status = 2;
                elseif (isset($_POST['user_role']) && $_POST['user_role'] == 'storeUser' && isset($_POST['term_condition']) && $_POST['term_condition'] == 1)
                    $agree_status = 5;
                elseif (isset($_POST['term_condition']) && $_POST['term_condition'] == 1)
                    $agree_status = 0;
                else
                    $agree_status = 2;

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

                $slug_email_id = $_POST['email_id'];
                $get_char_slug = $_POST['uname'];
                $user_slug = $this->dbcommon->generate_slug($get_char_slug, 'U');


                if (empty($user)):
                    $result_data = array(
                        'username' => preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['uname']),
                        'email_id' => $_POST['email_id'],
                        'password' => md5($_POST['password1']),
                        'phone' => $_POST['phone'],
                        'contact_number' => $_POST['phone'],
                        'nationality' => '',
                        'city' => '',
                        'state' => '',
                        'date_of_birth' => '',
                        'gender' => '',
                        'userTotalAds' => $cnt_ads,
                        'userAdsLeft' => $cnt_ads,
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'status' => 'inactive',
                        'first_name' => $_POST['fname'],
                        'last_name' => $_POST['lname'],
                        'insert_from' => 'web',
                        'is_delete' => $agree_status,
                        'user_role' => $_POST['user_role'],
                        'user_slug' => $user_slug,
                        'last_logged_in' => date('Y-m-d H:i:s')
                    );
                    //'nick_name'=>$_POST['nick_name'],

                    $result = $this->dblogin->insert($result_data);
                    /* if($result):
                      $data['msg'] = 'successfully.';
                      $data['msg_class'] = 'alert-success';
                      $this->load->view('registration/index', $data);
                      endif; */
                    if ($result):
                        $username = $_POST['uname'];
                        $user_id = $this->dblogin->getLastInserted();

                        if (isset($_POST['user_role']) && $_POST['user_role'] == 'storeUser') {
                            $in_storedata = array(
                                'store_owner' => $user_id,
                                'category_id' => 0,
                                'sub_category_id' => 0,
                                'store_domain' => strtolower(str_replace('.', '', $_POST['store_domain'])),
                                'store_name' => $_POST['store_name'],
                                'store_description' => '',
                                'meta_title' => '',
                                'meta_description' => '',
                                'store_status' => 0,
                                'store_details_verified' => 0,
                                'new_data_status' => 0,
                                'store_is_inappropriate' => 'NeedReview',
                                'shipping_cost' => '',
                                'website_url' => ''
                            );

                            $this->dbcommon->insert('store', $in_storedata);

                            $in_storedata = array(
                                'store_owner' => $user_id,
                                'category_id' => 0,
                                'sub_category_id' => 0,
                                'store_domain' => strtolower(str_replace('.', '', $_POST['store_domain'])),
                                'store_name' => $_POST['store_name'],
                                'store_description' => '',
                                'meta_title' => '',
                                'meta_description' => '',
                                'store_status' => 0,
                                'store_is_inappropriate' => 'NeedReview',
                                'website_url' => ''
                            );

                            $store_id = $this->db->insert_id();
                            $in_new_details = $in_storedata;
                            $in_new_details['store_id'] = $store_id;

                            $this->dbcommon->insert('store_new_details', $in_new_details);

                            unset($_SESSION['store_name_create']);
                        }

                        $parser_data = array();
//                        $parser_data['password'] = $link;
//                        $parser_data['username'] = $username;
//                        $parser_data['email'] = $_POST['email_id'];

                        $email_id = $_POST['email_id'];
                        $activate_key = $this->my_encryption->safe_b64encode($email_id);
                        $button_link = base_url() . "registration/verify?ident=" . $user_id . "&activate=" . $activate_key;
                        $button_label = 'Click here to confirm your account';
                        $title = 'Thank you for joining us!';

                        $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;">                        
                        <h3>Account Confirmation</h3><strong>Username:</strong>
                                        ' . $username . '
                                        <p style="margin: 1em 0;">
                                        <strong>E-mail:</strong>
                                        <a href="mailto:' . $email_id . '" style="color: #000000 !important;">' . $email_id . '</a></p>
    <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:240px; " href="' . $button_link . '">' . $button_label . '</a></div>';


                        $new_data = $this->dbcommon->mail_format($title, $content);
                        $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

                        if (send_mail($email_id, 'Signup | Verification', $new_data, 'info@doukani.com')) {
                            $data['msg'] = 'The Verification mail sent successfully.';
                            $data['msg_class'] = 'alert-success';
                            $this->session->set_flashdata('msg5', 'The Verification mail sent successfully.');
                            if ($_POST['user_role'] == 'generalUser') {
                                redirect('registration/thank_you');
                            }
                            redirect('login/index');
                        } else {

                            $this->db->query('delete from user where user_id = ' . $user_id);
                            $data['msg'] = 'Verification mail sending failed, Please try again';
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('registration/index', $data);
                        }
                    endif;
                else:
                    if ($user->is_delete != 1) {
                        $data['msg'] = 'User already exist with same email/username.';
                        $data['msg_class'] = 'alert-info';
                    } else if ($user->is_delete == 1) {
                        $data['msg'] = 'You have been already registered earlier. Do you want to activate your account again as you had chose to remove the account?';
                        $data['msg_class'] = 'alert-info';
                        $data['deleted_earlier'] = 1;
                        $data['user_id'] = $user->user_id;
                    }
                    $this->load->view('registration/index', $data);
                // $this->load->view('registration/index', $data);
                endif;

            endif;
        } else {
            $this->load->view('registration/index', $data);
        }

        //}	
    }

    public function check_subdomain_name() {
        $where = ' store_id from store where store_domain="' . $_POST['store_domain'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_subdomain_name', 'Store domain already exists');
            return false;
        } else {
            return true;
        }
    }

    /* redirect to Twitter for authentication */

    public function redirect() {
        /* twredirect() parameter - callback point in your application */
        /* by default the path from config file will be used */
        $ok = $this->twconnect->twredirect('registration/callback');

        if (!$ok) {
            echo 'Could not connect to Twitter. Refresh the page or try again later.';
        }
    }

    /* return point from Twitter */
    /* you have to call $this->twconnect->twprocess_callback() here! */

    public function callback() {


        $ok = $this->twconnect->twprocess_callback();
        if ($ok) {
            redirect('registration/success');
        } else
            redirect('registration/failure');
    }

    /* authentication successful */
    /* it should be a different function from callback */
    /* twconnect library should be re-loaded */
    /* but you can just call this function, not necessarily redirect to it */

    public function success() {

        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime("+1 months", strtotime($from_date)));

        // saves Twitter user information to $this->twconnect->tw_user_info
        // twaccount_verify_credentials returns the same information
        $twitter_user = $this->twconnect->twaccount_verify_credentials();
        // = $this->twconnect->tw_user_info;		
        if (isset($twitter_user->id)) {

            $name = $twitter_user->screen_name;
            $twitter_id = $twitter_user->id;
            $twitter_name = $twitter_user->name;

            $userDetails = $this->dbuser->getUserDetails(array("twitter_id" => $twitter_id));

            if (empty($userDetails)) {
                $insertArr = array(
                    "username" => $name,
                    "email_id" => '',
                    "twitter_id" => $twitter_id,
                    "status" => 'active',
//                    'userTotalAds' => $cnt_ads,
//                    'userAdsLeft' => $cnt_ads,
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'first_name' => $twitter_name,
                    'insert_from' => 'web',
                    'is_delete' => 2
                );

                if ($this->dbuser->insert($insertArr)) {
                    $userId = $this->db->insert_id();
                    $userDetails = $this->dbuser->getUserDetails(array("user_id" => $userId));
                }
            }
            if (!empty($userDetails)) {
                $session_data['gen_user'] = (array) $userDetails;
                $session_data["logged_in"] = TRUE;
                $session_data["tw_logged_in"] = TRUE;
                $this->session->set_userdata($session_data);
                redirect('user/index');
            }
        }
    }

    /* authentication un-successful */

    public function failure() {

        $this->session->set_flashdata(array('msg' => 'Something went wrong, Please try again.', 'class' => 'alert-success'));
        redirect('registration/index');
    }

    public function verify() {
        if (isset($_GET['ident']) && isset($_GET['activate'])) {
            $userId = $_GET['ident'];
            $activate = $_GET['activate'];
            $where = " where user_id='" . $userId . "'";
            $user = $this->dblogin->isExist($where);

            $where_chk = " where user_id='" . $userId . "' and status='active'";
            $user_chk = $this->dblogin->isExist($where_chk);

            if (sizeof($user_chk) > 0) {
                $data['msg'] = 'Your Account is already active.';
                $data['msg_class'] = 'alert-success';
                $this->session->set_flashdata('msg5', 'Your Account is already active.');

                redirect('login/index');
            } else {
                $thekey = $this->my_encryption->safe_b64encode($user->email_id);
                if ($activate == $thekey):
                    $data = array('status' => 'active');
                    $array = array('user_id' => $user->user_id);
                    $result = $this->dbcommon->update('user', $array, $data);
                    $data['msg'] = 'Verified Successfully.';
                    $data['msg_class'] = 'alert-success';
                    $this->session->set_flashdata('msg5', 'Verified Successfully.');

                    redirect('login/index');
                else:
                    redirect('login/index');
                endif;
            }
        }
        else {
            override_404();
        }
    }

    public function thank_you() {
        $data['page_title'] = 'Thank You';

//        if(isset($_SESSION['reg_user_name'])){
//            $data['reg_user'] = $_SESSION['reg_user_name'];
//        }else{
//            redirect('login/index');
//        }

        $data = array_merge($data, $this->get_elements());
//        unset($_SESSION['reg_user_name']);
        $this->load->view('registration/thank_you', $data);
    }

    public function post_thank_you() {
        $data['page_title'] = 'Thank You';

//        if(!isset($_SESSION['general_user_add_posted'])){
//            redirect('user/my_listing?val=NeedReview');
//        }
        $data = array_merge($data, $this->get_elements());
//        unset($_SESSION['general_user_add_posted']);
        $this->load->view('user/thank_you', $data);
    }

}
