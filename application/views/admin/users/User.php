<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('store', '', TRUE);
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dashboard');
        $this->load->model('dbuser');
        $this->load->library('form_validation');
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        //$this->load->library('ImageAlter');
        //$this->load->library('ImageManipulator');
        //$this->load->library('Timthumb');
        $current_user = $this->session->userdata('gen_user');
                
        if (isset($current_user)) {
            define("session_userid", $current_user['user_id']);
        } else
            define("session_userid", '');

        $this->load->helper('email');
        $this->per_page = 12;
        $current_user = $this->session->userdata('gen_user');

        if ($current_user['user_role'] == 'storeUser') {
            $where_store = " where store_owner ='" . $current_user['user_id'] . "'";
            $store_details = $this->dbcommon->getdetails('store', $where_store);
            if (!empty($store_details))
                define('session_storedomain', $store_details[0]->store_domain);
            else
                define('session_storedomain', '');
        }
        else {
            define('session_storedomain', '');
        }
    }

    public function index() {

        $a = array();
        $b = array();

        $data = array();
        $this->load->helper(array('form', 'url'));
        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'My Profile';
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        //$location = $this->dbcommon->select('country');
        $location = $this->dbcommon->select_orderby('country', 'country_name', 'asc');
        $data['location'] = $location;

        $nationality = $this->dbcommon->select_orderby('nationality', 'name', 'asc');
        $data['nationality'] = $nationality;

        $current_user = $this->session->userdata('gen_user');

        $where = " where user_id='" . $current_user['user_id'] . "'";
        $user = $this->dbcommon->getrowdetails('user', $where);

        $where_is = " * from subscription where email_address='" . $user->email_id . "'";
        $sub_set = $this->dbcommon->getnumofdetails_($where_is);
        $data['sub_set'] = $sub_set;

        $where_is1 = " user_id from user where chat_notification=1";
        $chat = $this->dbcommon->getnumofdetails_($where_is1);
        $data['chat'] = $chat;
        //print_r($data['sub_set']);
        /* echo '<pre>';
          print_r($user);
          exit; */
        //$inbox_count = $this->dbcommon->getnumofdetails('buyer_seller_conversation',$inbox);		
        $inbox_cnt_Sql = ' * from buyer_seller_conversation bsc left join product p on p.product_id=bsc.product_id where bsc.status=0 and bsc.receiver_id=' . $current_user['user_id'] . ' and p.product_is_inappropriate="Approve" and p.is_delete=0 and p.product_deactivate IS NULL';
        $inbox_count = $this->dbcommon->getnumofdetails_($inbox_cnt_Sql);
        $data['inbox_count'] = $inbox_count;

        if ($user->country != ''):
            $sql = $this->db->query('select * from country where country_id="' . $user->country . '"')->row_array();

            $where = "country_id=" . $user->country;
        else:
            $where = "country_id=4";
        endif;
        $where .= ' order by sort_order';
        $cities = $this->dbcommon->filter('state', $where);

        $data['current_user'] = $user;
        if ($user->nick_name != '')
            $data['page_title'] = $user->nick_name;
        else
            $data['page_title'] = $user->username;

        //$sel	   =	' where seller_id='.$user->user_id;
        //$data['$cnt_followers'] =    $this->dbcommon->getnumofdetails('followed_seller', $sel);

        $data['cities'] = $cities;

        if (isset($_POST['submit'])) {

            // validation 
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('nationality', 'Nationality', 'required');
            $this->form_validation->set_rules('location', 'Country', 'required');
            $this->form_validation->set_rules('city', 'City', 'required');
            $this->form_validation->set_rules('phone', 'Phone No.', 'required');
            $this->form_validation->set_rules('date_of_birth', 'Birth date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('user/index', $data);
            } else {
                $where = " where user_id != '" . $current_user['user_id'] . "'and (email_id ='" . addslashes($_POST['email']) . "' or username ='" . $_POST['username'] . "')";
                $check_user = $this->dblogin->isExist($where);

                $picture = $user->profile_picture;
                if (empty($check_user)) {


                    $city_id = $city_name = '';
                    //print_r($_REQUEST);

                    /*  if(isset($_POST['city'])){
                      $city_id_name = explode("_", $_POST['city']);
                      $city_id = $city_id_name[0];
                      $city_name = $city_id_name[1];
                      } */
                    if (isset($_POST['notification']))
                        $notification = 1;
                    else
                        $notification = 0;

                    $data = array(
                        'username' => $_POST['username'],
//                        'email_id' => $_POST['email'],
                        'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
                        'address' => isset($_POST['address']) ? $_POST['address'] : '',
                        'city' => '',
                        'gender' => $_POST['gender'],
                        'state' => $_POST['city'],
                        'nick_name' => $_POST['nick_name'],
                        'country' => $_POST['location'],
                        'date_of_birth' => isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '',
                        //'profile_picture' => $picture,
                        'chat_notification' => $notification,
                        'nationality' => $_POST['nationality'],
                        'update_from' => 'web'
                    );
                    //print_r($data);
                    //exit;
                    $array = array('user_id' => $current_user['user_id']);
                    $result = $this->dbcommon->update('user', $array, $data);
                    if (isset($_POST['subscription'])) {
                        $this->load->library('Mcapi');
                        $listID = "f18853dfa3"; // obtained by calling lists();  
                        $emailAddress = $_POST['email'];
                        $retval = $this->mcapi->listSubscribe($listID, $emailAddress);
                        $data_in = array('email_address' => $_POST['email']);
                        $result = $this->dbcommon->insert('subscription', $data_in);
                        if ($this->mcapi->errorCode) {
                            
                        } else {
                            
                        }
                    }
                    $where = " where user_id='" . $current_user['user_id'] . "'";
                    $user = $this->dblogin->isExist($where);
                    if ($user):
                        $this->session->set_flashdata(array('msg1' => 'Profile Updated Successfully', 'class' => 'alert-info'));
                        redirect('user/index');
                    endif;
                }
                else {
                    $data['msg'] = 'User already exist with same email / username.';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('user/index', $data);
                }
            }
        } else {
            $msg = $this->session->flashdata('msg1');
            if (!empty($msg)):
                $data['msg'] = $this->session->flashdata('msg1');
                $data['msg_class'] = $this->session->flashdata('class');
            endif;
            //$this->load->view('user/trial_crop', $data);
            $this->load->view('user/index', $data);
            //$this->load->view('user/crop', $data);
        }

        if (isset($_POST["delete"])) {
            $user_data = array(
                'is_delete' => 1
            );

            $array = array('user_id' => $current_user['user_id']);
            $this->dbcommon->update('user', $array, $user_data);

            $pro_array = array('product_posted_by' => $current_user['user_id']);
            $this->dbcommon->update('product', $pro_array, $user_data);

            redirect('login/signout');
            exit;
        }
    }

    public function post_ads() {

        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];

        $data = array();
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $colors = $this->dbcommon->getcolorlist();
        $data['colors'] = $colors;

        $brand = $this->dbcommon->getbrandlist();
        $data['brand'] = $brand;

        $mileage = $this->dbcommon->getmileagelist();
        $data['mileage'] = $mileage;

        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'Post Ads';

        //$location = $this->dbcommon->select('country');
        $location = $this->dbcommon->select_orderby('country', 'country_name', 'asc');
        $data['location'] = $location;
     		
	$user = $this->db->query('select * from user 
                                left join store on store.store_owner=user.user_id
                                where user_id=' . (int) $current_user["user_id"] . ' and is_delete in (0,3) and (CURDATE() between from_date and to_date) and status="active" and user_role in ("storeUser","generalUser","offerUser") limit 1')->row();
        
        $data['current_user'] = $user;
        $data['user_category_id'] = '';
        $data['user_sub_category_id'] = '';
        
        if (isset($current_user['user_id']) && $current_user['user_id'] != '') {
            
            $chkuser_id = (int) $user->user_id;
            
            if ($chkuser_id > 0) {
            
                if ($user->user_role=='storeUser' && in_array($user->store_status,array(0,3)) && $user->store_is_inappropriate != 'Approve')
                    redirect('home');
                else {                        
                    if ((int) $user->userAdsLeft > 0) {
                        $data['user_category_id'] = $user->category_id;
                        $data['user_sub_category_id'] = $user->sub_category_id;                        
                    }
                }
            } else
                redirect('home');
        }

        //if(!empty($check_ad_left))   
        if ((int) $user->userAdsLeft > 0) {
            if (!empty($_POST)) {

                $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $str = substr(str_shuffle($chars), 0, 3);
                $num = rand(10, 99);

                $where = " where category_id='" . $_POST['cat_id'] . "'";
                $cat_name = $this->dbcommon->getdetails('category', $where);
                $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));

                $images_num = 0;
                if (isset($_FILES)) {
                    end($_FILES);
                    $key = key($_FILES);

                    $input = $key;
                    $d = explode('multiUpload', $input);
                    if (isset($d[1]))
                        $images_num = $d[1];
                }

                $picture_ban = array();

                $proid = 0;
                $fileName = '';
                $youtube = '';
                $video = '';
                $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
                if (isset($_POST['default_submit'])) {

                    if (isset($_REQUEST['cat_id']))
                        $filter_val = $this->input->post("cat_id");
                    else
                        $filter_val = 0;
                    $query = "category_id	= '" . $filter_val . "'";
                    $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                    //validation					
                    $this->form_validation->set_rules('cat_id', 'Category', 'required');
                    $this->form_validation->set_rules('sub_cat', 'Sub category', 'required');
                    $this->form_validation->set_rules('pro_name', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('pro_desc', 'Description', 'trim|required|max_length[650]');
                    $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('city', 'Emirate', 'trim|required');
                    //$this->form_validation->set_error_delimiters('', '');
                    if ($this->form_validation->run() == FALSE) {

                        // $this->session->set_userdata('admin_login', '');
                        //$data['msg'] = "Please fill all required fields";
                        //$data['msg_class'] = 'alert-info';
                        $this->load->view('user/post_new_add', $data);
                    } else {
                        $pro = strtoupper(substr($_POST['pro_name'], 0, 2));
                        $pro_code = $cat . $pro . $num . $str;

                        $fileName = $_POST["form1_images_arr"];
                        $youtube = $_POST["youtube"];
                        if ($youtube != '')
                            $youtube = $_POST["youtube"];
                        else
                            $youtube = '';

                        $video = $_POST["video"];

                        if ($video != '') {
                            $video = base64_decode($video);
                            $vid = explode("_", $video);
                            $video_img = '0_' . $vid[1] . '_videoimg.jpg';
                            $dest = document_root . product . 'video_image/' . $video_img;
                            if (file_exists(document_root . product . 'video_image/' . $video_img))
                                $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                        }
                        else {
                            $video = '';
                            $video_img = '';
                        }

                        $product_slug = $this->dbcommon->generate_slug($_POST['pro_name'], 'P');

                        $data = array(
                            'product_code' => $pro_code,
                            'product_name' => $_POST['pro_name'],
                            'product_slug' => $product_slug,
                            'category_id' => $_POST['cat_id'],
                            'sub_category_id' => $_POST['sub_cat'],
                            'product_is_inappropriate' => 'NeedReview',
                            'product_description' => $_POST['pro_desc'],
                            'product_price' => str_replace(",", "", $_POST['pro_price']),
                            'product_posted_time' => date('y-m-d H:i:s', time()),
                            'product_brand' => 0,
                            'product_posted_by' => $user_id,
                            'c