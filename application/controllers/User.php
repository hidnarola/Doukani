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
        $this->load->model('dbcart');
        $this->load->helper('page_not_found');
        $this->load->library('form_validation');

        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('email');

        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user)) {
            define("session_userid", $current_user['user_id']);
        } else
            define("session_userid", '');

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

        if (!empty($current_user['last_login_as']) && $current_user['last_login_as'] == 'generalUser')
            $product_for = ' and product_for="classified"';
        elseif (!empty($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser')
            $product_for = ' and product_for="store"';
        else
            $product_for = '';

        if (isset($current_user['user_id']) && (int) $current_user['user_id'] > 0) {
            $inbox_cnt_Sql = ' * from buyer_seller_conversation bsc left join product p on p.product_id=bsc.product_id where bsc.status=0 and bsc.receiver_id=' . $current_user['user_id'] . ' and p.product_is_inappropriate="Approve" and p.is_delete=0 and p.product_deactivate IS NULL ' . $product_for;
            $inbox_count = $this->dbcommon->getnumofdetails_($inbox_cnt_Sql);

            define('inbox_count', $inbox_count);
        } else {
            define('inbox_count', '');
        }
    }

    public function index() {

        $a = array();
        $b = array();
        $data = array();
        $data['is_able_request_for_store'] = 0;
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

        $buy_ad_price = $this->dbcommon->select('buy_ad_price');
        $data['buy_ad_price'] = $buy_ad_price;

        //$location = $this->dbcommon->select('country');
        $location = $this->dbcommon->select_orderby('country', 'country_name', 'asc');
        $data['location'] = $location;

        $nationality = $this->dbcommon->select_orderby('nationality', 'name', 'asc');
        $data['nationality'] = $nationality;

        $plate_source = $this->dbcommon->select('plate_source');
        $data['plate_source'] = $plate_source;

        $plate_digit = $this->dbcommon->select('plate_digit');
        $data['plate_digit'] = $plate_digit;

        $where = 'num_for="plate"';
        $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
        $data['repeating_numbers_car'] = $repeating_numbers;

        $where = 'num_for="mobile"';
        $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
        $data['repeating_numbers_mobile'] = $repeating_numbers;

        $plate_digit_mobile = $this->dbcommon->select('plate_digit');
        $data['plate_digit_mobile'] = $plate_digit_mobile;

        $mobile_operators = $this->dbcommon->select('mobile_operators');
        $data['mobile_operators'] = $mobile_operators;

        $current_user = $this->session->userdata('gen_user');

        $where = " where user_id='" . $current_user['user_id'] . "'";
        $user = $this->dbcommon->getrowdetails('user', $where);

        $total_followers = $this->dbcommon->get_myfollowers_count($user->user_id);
        $data['total_followers'] = $total_followers;
        $where_is = " * from subscription where email_address='" . $user->email_id . "'";
        $sub_set = $this->dbcommon->getnumofdetails_($where_is);
        $data['sub_set'] = $sub_set;

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
//        pr($current_user);
        if (isset($current_user) && isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
            $data['e_wallet_amount'] = 0.00;
            $count_of_peding_request = $this->dbcommon->getnumofdetails_(' * FROM e_wallet_request_response WHERE store_owner = ' . $current_user['user_id'] . ' AND status = 0');

            if ($count_of_peding_request == 0) {
                $this->db->select('SUM(b.store_amount) AS store_balance, GROUP_CONCAT(b.id) balance_ids, s.store_name');
                $this->db->join('orders o', 'o.id = b.order_id', 'LEFT');
                $this->db->join('store s', 's.store_owner = b.store_owner', 'LEFT');
                $this->db->where('o.status', 'completed');
                $this->db->where('o.is_delete', 0);
                $this->db->where('o.delivery_type', 'PREPAID');
                $this->db->where('o.id = b.order_id');
                $this->db->where('b.store_owner', $current_user['user_id']);
                $this->db->where('b.status', 1);
                $this->db->group_by('o.id');

                $query = $this->db->get('balance b');
                $balance = $query->row_array();

                if (isset($balance) && $balance['store_balance'] > 0)
                    $data['e_wallet_amount'] = $balance['store_balance'];
            }
        } elseif (isset($current_user) && isset($current_user['user_role']) && $current_user['user_role'] == 'generalUser') {
            $where = 'user_id=' . $current_user['user_id'] . ' AND status <> 1';
            $store_request_status = $this->dbcommon->filter('store_request', $where);
            if (isset($store_request_status) && sizeof($store_request_status) > 0)
                $data['is_able_request_for_store'] = 1;
        }

//        $category = $this->dbcommon->select('category');
        $wh_category_data = array('FIND_IN_SET(1, category_type) > 0');
        $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);
        $data['category1'] = $category;

        if (isset($_POST['submit'])) {

            // validation 
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[30]|alpha_numeric');

            if ($this->input->post('nick_name') != '')
                $this->form_validation->set_rules('nick_name', 'Nickname', 'min_length[3]|max_length[30]|alpha_numeric');

//            if (isset($_REQUEST['paypal_email_id']) && !empty($_REQUEST['paypal_email_id']))
//                $this->form_validation->set_rules('paypal_email_id', 'Paypal Email Id', 'trim|valid_email');

            $this->form_validation->set_rules('nationality', 'Nationality', 'required');
            $this->form_validation->set_rules('location', 'Country', 'required');
            $this->form_validation->set_rules('city', 'City', 'required');
            $this->form_validation->set_rules('phone', 'Phone No.', 'trim|required|min_length[10]');
            $this->form_validation->set_rules('date_of_birth', 'Birth date', 'required');

            if (!empty($_POST['password'])) {
                $this->form_validation->set_rules('password', 'Password', 'trim|alpha_numeric|min_length[6]|max_length[15]|matches[confirm_password]');

                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
            }
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
                        'contact_number' => isset($_POST['phone']) ? $_POST['phone'] : '',
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

                    if (!empty($_POST['password'])) {
                        $data['password'] = md5($_POST['password']);
                    }

                    if ($current_user['user_role'] == 'storeUser') {
                        $data['facebook_social_link'] = $_POST['facebook_social_link'];
                        $data['twitter_social_link'] = $_POST['twitter_social_link'];
                        $data['instagram_social_link'] = $_POST['instagram_social_link'];
                    }

                    $array = array('user_id' => $current_user['user_id']);
                    $result = $this->dbcommon->update('user', $array, $data);

                    $where = " where user_id='" . $current_user['user_id'] . "'";
                    $user = $this->dblogin->isExist($where);
                    if ($user):

                        $my_array = $this->db->query("select * from user where user_id=" . $current_user['user_id'] . " limit 1")->row_array();
                        $my_array['last_login_as'] = $current_user['user_role'];
                        $this->session->set_userdata('gen_user', $my_array);
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
    }

    public function post_ads() {

        $data = array();

        $current_user = $this->session->userdata('gen_user');

        $data['logged_in_user'] = $current_user;
        $user_id = $current_user['user_id'];


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

        $plate_source = $this->dbcommon->select('plate_source');
        $data['plate_source'] = $plate_source;

        $plate_digit = $this->dbcommon->select('plate_digit');
        $data['plate_digit'] = $plate_digit;

        $where = 'num_for="plate"';
        $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
        $data['repeating_numbers_car'] = $repeating_numbers;

        $where = 'num_for="mobile"';
        $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
        $data['repeating_numbers_mobile'] = $repeating_numbers;

        $plate_digit_mobile = $this->dbcommon->select('plate_digit');
        $data['plate_digit_mobile'] = $plate_digit_mobile;

        $mobile_operators = $this->dbcommon->select('mobile_operators');
        $data['mobile_operators'] = $mobile_operators;

        $where = " 1=1";
        $delivery_options = $this->dbcommon->filter('delivery_options', $where);
        $data['delivery_options'] = $delivery_options;

        $where = " 1=1";
        $product_weight = $this->dbcommon->filter('product_weight', $where);
        $data['product_weights'] = $product_weight;

        $data = array_merge($data, $this->get_elements());

        if ($current_user['user_role'] == 'generalUser' || ($current_user['user_role'] == 'storeUser' && $current_user['last_login_as'] == 'generalUser') || $current_user['user_role'] == 'offerUser') {
            $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
            $data['category'] = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);
        } else {
            $wh_category_data = array('FIND_IN_SET(1, category_type) > 0');
            $data['category'] = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);
        }
        $data['page_title'] = 'Post Ads';

        $location = $this->dbcommon->select_orderby('country', 'country_name', 'asc');
        $data['location'] = $location;

        $user = $this->db->query('select * from user 
                                left join store on store.store_owner=user.user_id
                                where user_id=' . (int) $current_user["user_id"] . ' and is_delete in (0,3,6) and (CURDATE() between from_date and to_date) and status="active" limit 1')->row();

        $data['current_user'] = $user;
        $data['user_category_id'] = '';
        $data['user_sub_category_id'] = '';

        if (isset($current_user['user_id']) && $current_user['user_id'] != '') {

            $chkuser_id = (int) $user->user_id;
            if ($chkuser_id > 0) {
                if ((int) $user->userAdsLeft > 0) {

                    if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                        $data['user_category_id'] = $user->category_id;
                        $data['user_sub_category_id'] = $user->sub_category_id;
                    }
                } else {
                    $this->session->set_flashdata('flash_message', 'Sorry, No ads remaining.');
                    redirect('user/index');
                }
            } else {
                redirect('home');
            }
        }

        if ((int) $user->userAdsLeft > 0) {

            if (!empty($user->phone)) {
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
                        $this->form_validation->set_rules('pro_desc1', 'Description', 'trim|required');
                        $this->form_validation->set_rules('pro_desc1', 'Description', 'trim|required|max_length[2000]');

                        //                    $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('city', 'Emirate', 'trim|required');

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                            $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                            $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                        }

                        if ($this->form_validation->run() == FALSE) {

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
                                'product_description' => $_POST['pro_desc1'],
                                'product_price' => str_replace(",", "", $_POST['pro_price']),
                                'product_posted_time' => date('y-m-d H:i:s', time()),
                                'product_brand' => 0,
                                'product_posted_by' => $user_id,
                                'country_id' => $_POST['location'],
                                'state_id' => $_POST['city'],
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'insert_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $_POST['longitude']
                            );

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $data['stock_availability'] = $_POST['total_stock'];
                                $data['total_stock'] = $_POST['total_stock'];
                                $data['delivery_option'] = $_POST['delivery_option'];
                                $data['weight'] = $_POST['weight'];
                                $data['original_price'] = str_replace(",", "", $_POST['original_price']);
                            }

                            $result = $this->dbcommon->insert('product', $data);
                            $proid = $this->dblogin->getLastInserted();

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $this->dbcommon->product_stock_track($proid);
                            }
                        }
                    }

                    if (isset($_POST['vehicle_submit'])) {
                        if (isset($_REQUEST['cat_id']))
                            $filter_val = $this->input->post("cat_id");
                        else
                            $filter_val = 0;
                        $query = "category_id	= '" . $filter_val . "'";
                        $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                        $this->form_validation->set_rules('sub_cat', 'Sub-category', 'trim|required');
                        $this->form_validation->set_rules('title', 'Ad Title', 'trim|required|max_length[80]');
                        $this->form_validation->set_rules('vehicle_pro_desc', 'Description', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_desc', 'Description', 'trim|required|max_length[2000]');
                        // $this->form_validation->set_rules('vehicle_original_price', 'Price', 'trim|required');
                        //                    $this->form_validation->set_rules('vehicle_pro_price', 'Price', 'trim|required');
                        $this->form_validation->set_rules('pro_brand', 'Brand', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_model', 'Model', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_type_of_car', 'Type Of Car', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_year', 'Year', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_mileage', 'Mileage', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_condition', 'Condition', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_color', 'Color', 'trim|required');

                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('city', 'Emirate', 'trim|required');

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                            $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                            $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                        }

                        if ($this->form_validation->run() == FALSE) {
                            $this->load->view('user/post_new_add', $data);
                        } else {
                            $pro = strtoupper(substr($_POST['title'], 0, 2));
                            $pro_code = $cat . $pro . $num . $str;
                            $fileName = $this->input->post("form2_images_arr");
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

                            $product_slug = $this->dbcommon->generate_slug($_POST['title'], 'P');

                            $data = array(
                                'product_code' => $pro_code,
                                'product_name' => $_POST['title'],
                                'product_slug' => $product_slug,
                                'category_id' => $_POST['cat_id'],
                                'sub_category_id' => $_POST['sub_cat'],
                                'product_is_inappropriate' => 'NeedReview',
                                'product_brand' => $_POST['pro_brand'],
                                'product_description' => str_replace(",", "", $_POST['vehicle_pro_desc']),
                                'product_price' => str_replace(",", "", $_POST['vehicle_pro_price']),
                                'product_posted_time' => date('y-m-d H:i:s', time()),
                                'product_posted_by' => $user_id,
                                'country_id' => $_POST['location'],
                                'state_id' => $_POST['city'],
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'insert_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $data['stock_availability'] = $_POST['total_stock'];
                                $data['total_stock'] = $_POST['total_stock'];
                                $data['delivery_option'] = $_POST['delivery_option'];
                                $data['weight'] = $_POST['weight'];
                                $data['original_price'] = str_replace(",", "", $_POST['vehicle_original_price']);
                            }

                            $result = $this->dbcommon->insert('product', $data);
                            $proid = $this->dblogin->getLastInserted();
                            $data_extras = array(
                                'product_id' => $proid,
                                'make' => '',
                                'model' => $_POST['vehicle_pro_model'],
                                'type_of_car' => $_POST['vehicle_pro_type_of_car'],
                                'color' => $_POST['vehicle_pro_color'],
                                'millage' => $_POST['vehicle_pro_mileage'],
                                'vehicle_condition' => $_POST['vehicle_pro_condition'],
                                'year' => (isset($_POST['vehicle_pro_year']) && $_POST['vehicle_pro_year'] != '') ? $_POST['vehicle_pro_year'] : NULL
                            );
                            $result = $this->dbcommon->insert('product_vehicles_extras', $data_extras);

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $this->dbcommon->product_stock_track($proid);
                            }
                        }
                    }

                    if (isset($_POST['real_estate_houses_submit'])) {

                        if (isset($_REQUEST['cat_id']))
                            $filter_val = $this->input->post("cat_id");
                        else
                            $filter_val = 0;
                        $query = "category_id	= '" . $filter_val . "'";
                        $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                        $this->form_validation->set_rules('cat_id', 'Category', 'required');
                        $this->form_validation->set_rules('sub_cat', 'Subcategory', 'required');
                        $this->form_validation->set_rules('houses_ad_title', 'Ad Title', 'trim|required|max_length[80]');
                        $this->form_validation->set_rules('house_pro_desc', 'Description', 'trim|required');
                        $this->form_validation->set_rules('house_pro_desc', 'Description', 'trim|required|max_length[2000]');
                        $this->form_validation->set_rules('pro_square_meters', 'Square Meters', 'trim|required');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('city', 'Emirate', 'trim|required');
                        $this->form_validation->set_rules('address', 'Address', 'trim|required');

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                            $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                            $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                        }

                        if ($this->form_validation->run() == FALSE) {

                            $this->load->view('user/post_new_add', $data);
                        } else {
                            $pro = strtoupper(substr($_POST['houses_ad_title'], 0, 2));
                            $pro_code = $cat . $pro . $num . $str;

                            $fileName = $this->input->post("form3_images_arr");
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

                            $product_slug = $this->dbcommon->generate_slug($_POST['houses_ad_title'], 'P');

                            $data = array(
                                'product_code' => $pro_code,
                                'product_name' => $_POST['houses_ad_title'],
                                'product_slug' => $product_slug,
                                'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                                'category_id' => $_POST['cat_id'],
                                'sub_category_id' => $_POST['sub_cat'],
                                'product_description' => $_POST['house_pro_desc'],
                                'product_is_inappropriate' => 'NeedReview',
                                'product_price' => str_replace(",", "", $_POST['houses_price']),
                                'product_posted_time' => date('y-m-d H:i:s', time()),
                                'country_id' => $_POST['location'],
                                'state_id' => $_POST['city'],
                                'ad_language' => $_POST['houses_language'],
                                'product_posted_by' => $user_id,
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'insert_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $data['stock_availability'] = $_POST['total_stock'];
                                $data['total_stock'] = $_POST['total_stock'];
                                $data['delivery_option'] = $_POST['delivery_option'];
                                $data['weight'] = $_POST['weight'];
                                $data['original_price'] = str_replace(",", "", $_POST['house_original_price']);
                            }

                            $result = $this->dbcommon->insert('product', $data);
                            $proid = $this->dblogin->getLastInserted();
                            $data_extras = array(
                                'product_id' => $proid,
                                'neighbourhood' => $_POST['houses_pro_neighbourhood'],
                                'address' => $_POST['address'],
                                'furnished' => $_POST['furnished'],
                                'Bedrooms' => $_POST['bedrooms'],
                                'Bathrooms' => $_POST['bathrooms'],
                                'pets' => $_POST['pets'],
                                'broker_fee' => $_POST['broker_fee'],
                                'free_status' => $_POST['houses_free'],
                                'area' => $_POST['pro_square_meters'],
                                'ad_language' => $_POST['houses_language']
                            );
                            $result = $this->dbcommon->insert('product_realestate_extras', $data_extras);

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $this->dbcommon->product_stock_track($proid);
                            }
                        }
                    }

                    if (isset($_POST['real_estate_shared_submit'])) {

                        if (isset($_REQUEST['cat_id']))
                            $filter_val = $this->input->post("cat_id");
                        else
                            $filter_val = 0;
                        $query = "category_id	= '" . $filter_val . "'";
                        $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                        $this->form_validation->set_rules('sub_cat', 'Sub-category', 'trim|required');
                        $this->form_validation->set_rules('shared_ad_title', 'Ad Title', 'trim|required|max_length[80]');
                        $this->form_validation->set_rules('shared_pro_desc', 'Description', 'trim|required');
                        $this->form_validation->set_rules('shared_pro_desc', 'Description', 'trim|required|max_length[2000]');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('city', 'Emirate', 'trim|required');
                        $this->form_validation->set_rules('address', 'Address', 'trim|required');

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                            $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                            $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                        }

                        if ($this->form_validation->run() == FALSE) {

                            $this->load->view('user/post_new_add', $data);
                        } else {
                            $pro = strtoupper(substr($_POST['shared_ad_title'], 0, 2));
                            $pro_code = $cat . $pro . $num . $str;

                            $fileName = $this->input->post("form4_images_arr");

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

                            $product_slug = $this->dbcommon->generate_slug($_POST['shared_ad_title'], 'P');

                            $data = array(
                                'product_code' => $pro_code,
                                'product_name' => $_POST['shared_ad_title'],
                                'product_slug' => $product_slug,
                                'category_id' => $_POST['cat_id'],
                                'sub_category_id' => $_POST['sub_cat'],
                                'product_is_inappropriate' => 'NeedReview',
                                'product_description' => $_POST['shared_pro_desc'],
                                'product_price' => str_replace(",", "", $_POST['shared_price']),
                                'product_posted_time' => date('y-m-d H:i:s', time()),
                                'country_id' => $_POST['location'],
                                'state_id' => $_POST['city'],
                                'product_posted_by' => $user_id,
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'insert_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude'),
//                                'stock_availability' => $_POST['total_stock'],
//                                'total_stock' => $_POST['total_stock']
                            );

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $data['stock_availability'] = $_POST['total_stock'];
                                $data['total_stock'] = $_POST['total_stock'];
                                $data['delivery_option'] = $_POST['delivery_option'];
                                $data['weight'] = $_POST['weight'];
                                $data['original_price'] = str_replace(",", "", $_POST['shared_original_price']);
                            }

                            $result = $this->dbcommon->insert('product', $data);
                            $proid = $this->dblogin->getLastInserted();
                            $data_extras = array(
                                'product_id' => $proid,
                                'neighbourhood' => $_POST['shared_pro_neighbourhood'],
                                'address' => $_POST['address'],
                                'ad_language' => $_POST['shared_language']
                            );
                            $result = $this->dbcommon->insert('product_realestate_extras', $data_extras);

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $this->dbcommon->product_stock_track($proid);
                            }
                        }
                    }

                    if (isset($_POST['car_number_submit'])) {

                        if (isset($_REQUEST['cat_id']))
                            $filter_val = $this->input->post("cat_id");
                        else
                            $filter_val = 0;
                        $query = "category_id   = '" . $filter_val . "'";
                        $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                        $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                        $this->form_validation->set_rules('pro_name', 'Ad Title', 'trim|required|max_length[80]');
                        $this->form_validation->set_rules('car_desc', 'Description', 'trim|required');
                        $this->form_validation->set_rules('car_desc', 'Description', 'trim|required|max_length[2000]');
                        //                    $this->form_validation->set_rules('car_original_price', 'Price', 'trim|required');
                        //                    $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                        $this->form_validation->set_rules('car_number', 'Car Number', 'trim|required');
                        $this->form_validation->set_rules('plate_source', 'Plate Source', 'trim|required');
                        $this->form_validation->set_rules('plate_digit', 'Plate Digit', 'trim|required');
                        $this->form_validation->set_rules('repeating_numbers_car', 'Repeating Number ', 'trim|required');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                            $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                            $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                        }

                        if ($this->form_validation->run() == FALSE):
                            $this->load->view('user/post_new_add', $data);
                        else:
                            $pro = strtoupper(substr($_POST['pro_name'], 0, 2));
                            $pro_code = $cat . $pro . $num . $str;

                            $fileName = $this->input->post("form5_images_arr");

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
                                'product_description' => $_POST['car_desc'],
                                'product_price' => str_replace(",", "", $_POST['pro_price']),
                                'product_is_inappropriate' => 'NeedReview',
                                'product_posted_time' => date('y-m-d H:i:s', time()),
                                'country_id' => $_POST['location'],
                                'state_id' => $_POST['state'],
                                'product_posted_by' => $user_id,
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'video_image_name' => $video_img,
                                'insert_from' => 'web',
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $data['stock_availability'] = $_POST['total_stock'];
                                $data['total_stock'] = $_POST['total_stock'];
                                $data['delivery_option'] = $_POST['delivery_option'];
                                $data['weight'] = $_POST['weight'];
                                $data['original_price'] = str_replace(",", "", $_POST['car_original_price']);
                            }

                            $result = $this->dbcommon->insert('product', $data);
                            $proid = $this->dblogin->getLastInserted();
                            $data_extras = array(
                                'product_id' => $proid,
                                'plate_source' => $_POST['plate_source'],
                                'plate_prefix' => $_POST['plate_prefix'],
                                'plate_digit' => $_POST['plate_digit'],
                                'repeating_number' => $_POST['repeating_numbers_car'],
                                'car_number' => $_POST['car_number'],
                                'number_for' => 'car_number'
                            );
                            $result = $this->dbcommon->insert('car_mobile_numbers', $data_extras);

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $this->dbcommon->product_stock_track($proid);
                            }

                        endif;
                    }

                    if (isset($_POST['mobile_number_submit'])) {

                        if (isset($_REQUEST['cat_id']))
                            $filter_val = $this->input->post("cat_id");
                        else
                            $filter_val = 0;
                        $query = "category_id   = '" . $filter_val . "'";
                        $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                        $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                        $this->form_validation->set_rules('pro_name', 'Ad Title', 'trim|required|max_length[80]');
                        $this->form_validation->set_rules('mob_desc', 'Description', 'trim|required');
                        $this->form_validation->set_rules('mob_desc', 'Description', 'trim|required|max_length[2000]');
                        //                    $this->form_validation->set_rules('mobile_original_price', 'Price', 'trim|required');
                        //                    $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                        $this->form_validation->set_rules('mobile_operators', 'Mobile Operator', 'trim|required');
                        $this->form_validation->set_rules('repeating_numbers_mobile', 'Repeating Number', 'trim|required');
                        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                            $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                            $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                        }

                        if ($this->form_validation->run() == FALSE):
                            $this->load->view('user/post_new_add', $data);
                        else:
                            $pro = strtoupper(substr($_POST['pro_name'], 0, 2));
                            $pro_code = $cat . $pro . $num . $str;

                            $fileName = $this->input->post("form6_images_arr");

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
                                'product_description' => $_POST['mob_desc'],
                                'product_price' => str_replace(",", "", $_POST['pro_price']),
                                'product_is_inappropriate' => 'NeedReview',
                                'product_posted_time' => date('y-m-d H:i:s', time()),
                                'country_id' => $_POST['location'],
                                'state_id' => $_POST['state'],
                                'product_posted_by' => $user_id,
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'video_image_name' => $video_img,
                                'insert_from' => 'web',
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $data['stock_availability'] = $_POST['total_stock'];
                                $data['total_stock'] = $_POST['total_stock'];
                                $data['delivery_option'] = $_POST['delivery_option'];
                                $data['weight'] = $_POST['weight'];
                                $data['original_price'] = str_replace(",", "", $_POST['mobile_original_price']);
                            }

                            $result = $this->dbcommon->insert('product', $data);
                            $proid = $this->dblogin->getLastInserted();
                            $data_extras = array(
                                'product_id' => $proid,
                                'mobile_operator' => $_POST['mobile_operators'],
                                'repeating_number' => $_POST['repeating_numbers_mobile'],
                                'mobile_number' => $_POST['mobile_number'],
                                'number_for' => 'mobile_number'
                            );
                            $result = $this->dbcommon->insert('car_mobile_numbers', $data_extras);

                            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                                $this->dbcommon->product_stock_track($proid);
                            }
                        endif;
                    }

                    if (isset($result)) {
                        $fileNameArray = explode(',', $fileName);
                        if (isset($_POST['cov_img']) && $_POST['cov_img'] != '') {

                            if (sizeof($fileNameArray) > 0) {
                                foreach ($fileNameArray as $key => $file) {
                                    $file_name = base64_decode($file);
                                    $ext = explode(".", $file_name);
                                    //$picture 	= 	time() . "." . end($ext);
                                    $target_dir = document_root . product;
                                    $target_file = $target_dir . "original/" . $file_name;
                                    $this->load->library('thumbnailer');

                                    $medium = $target_dir . "product_detail/" . $file_name;
                                    if (file_exists(document_root . product . 'original/' . $file_name)) {
                                        $this->dbcommon->crop_product_image($target_file, image_product_detail_width, image_product_detail_height, $medium, 'product_detail', $file_name);
                                    }

                                    $medium = $target_dir . "medium/" . $file_name;
                                    if (file_exists(document_root . product . 'original/' . $file_name)) {
                                        $this->dbcommon->crop_product_image($target_file, image_medium_width, image_medium_height, $medium, 'medium', $file_name);
                                    }

                                    //watermark
                                    $file_name = base64_decode($file);
                                    $ext = explode(".", base64_decode($file));

                                    $dest = document_root . product . 'original/' . $file_name;
                                    if (file_exists(document_root . product . 'original/' . $file_name)) {
                                        $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
                                        $this->dbcommon->watermarkImage($file_name, $WaterMark, $dest, 50, 'original');
                                        $ext = explode(".", base64_decode($file));
                                        if (isset($_POST['cov_img']) && $_POST['cov_img'] != '' && $_POST['cov_img'] == $ext[0]) {
                                            $user_data = array(
                                                'product_image' => base64_decode($file)
                                            );
                                            $array = array('product_id' => $proid);
                                            $this->dbcommon->update('product', $array, $user_data);
                                        } else {
                                            $insert = array(
                                                'product_id' => $proid,
                                                'product_image' => base64_decode($file)
                                            );
                                            $result = $this->dbcommon->insert('products_images', $insert);
                                            unset($insert);
                                        }
                                    }
                                }
                            }
                        } else {
                            if (sizeof($fileNameArray) > 0) {
                                foreach ($fileNameArray as $key => $file) {
                                    $file_name = base64_decode($file);
                                    $ext = explode(".", $file_name);
                                    //$picture 	= 	time() . "." . end($ext);
                                    $target_dir = document_root . product;
                                    $target_file = $target_dir . "original/" . $file_name;

                                    $this->load->library('thumbnailer');

                                    $medium = $target_dir . "product_detail/" . $file_name;
                                    if (file_exists(document_root . product . 'original/' . $file_name)) {
                                        $this->dbcommon->crop_product_image($target_file, image_product_detail_width, image_product_detail_height, $medium, 'product_detail', $file_name);
                                    }

                                    $medium = $target_dir . "medium/" . $file_name;
                                    if (file_exists(document_root . product . 'original/' . $file_name)) {
                                        $this->dbcommon->crop_product_image($target_file, image_medium_width, image_medium_height, $medium, 'medium', $file_name);
                                    }

                                    //watermark
                                    $file_name = base64_decode($file);
                                    $ext = explode(".", base64_decode($file));
                                    $WaterMark = site_url() . 'assets/front/images/logoWmark.png';

                                    $dest = document_root . product . 'original/' . $file_name;
                                    if (file_exists(document_root . product . 'original/' . $file_name)) {
                                        $this->dbcommon->watermarkImage($file_name, $WaterMark, $dest, 50, 'original');
                                        if ($key > 0) {
                                            $insert = array(
                                                'product_id' => $proid,
                                                'product_image' => base64_decode($file)
                                            );
                                            $result = $this->dbcommon->insert('products_images', $insert);
                                            unset($insert);
                                        } else {
                                            $user_data = array(
                                                'product_image' => base64_decode($file)
                                            );
                                            $array = array('product_id' => $proid);
                                            $this->dbcommon->update('product', $array, $user_data);
                                        }
                                    }
                                }
                            }
                        }

                        $user_ads_count = $this->db->query('select userAdsLeft,is_delete,user_role from user                                
                                    where user_id=' . (int) $current_user["user_id"] . ' and is_delete in (0,3,6) and (CURDATE() between from_date and to_date) and status="active" and userAdsLeft > 0 limit 1')->row();

                        if ((int) $user_ads_count->userAdsLeft > 0) {

                            $ads_left = (int) $user->userAdsLeft;
                            $updated_ads_left = $ads_left - 1;
                            $user_data = array(
                                'userAdsLeft' => $updated_ads_left
                            );

                            $array = array('user_id' => $current_user['user_id']);
                            $this->dbcommon->update('user', $array, $user_data);

                            if ($user_ads_count->user_role == 'storeUser') {
                                $where = " where store_owner ='" . $current_user['user_id'] . "'";
                                $old_store_details = $this->dbcommon->getdetails('store', $where);

                                if ($old_store_details[0]->store_is_inappropriate != 'Approve' && isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser')
                                    $is_delete = 6;
                                else
                                    $is_delete = 0;
                            }
                            else {

                                if ($user_ads_count->is_delete == 0)
                                    $is_delete = 0;
                                elseif ($user_ads_count->is_delete == 3)
                                    $is_delete = 3;
                            }

                            if (in_array($is_delete, array(0, 3, 6))) {
                                $product_for = '';
                                if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser')
                                    $product_for = 'store';
                                elseif (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'generalUser')
                                    $product_for = 'classified';
                                else
                                    $product_for = 'classified';

                                $prod_data = array('is_delete' => $is_delete, 'product_for' => $product_for);
                                $array = array('product_id' => $proid);
                                $this->dbcommon->update('product', $array, $prod_data);
                            }
                        }
                        else {

                            $arr = array('product_id' => $proid);
                            $this->dbcommon->delete('product', $arr);
                            $this->dbcommon->delete('car_mobile_numbers', $arr);
                            $this->dbcommon->delete('product_realestate_extras', $arr);
                            $this->dbcommon->delete('product_vehicles_extras', $arr);
                            $this->session->set_flashdata('msg', 'Sorry, you can\'t add product');
                            redirect('user/index/');
                        }

                        if ($user_ads_count->user_role == 'generalUser') {
                            $_SESSION['general_user_add_posted'] = 'Ad Posted';
                            $_SESSION['last_added_post_item'] = $_POST['pro_name'];
                            redirect('thank_you_adpost');
                        }

                        $this->session->set_flashdata('msg', 'Ad added successfully.');
                        $data['msg'] = 'Ad added successfully.';
                        $data['msg_class'] = 'alert-success';
                        redirect('user/item_details/' . $proid);
                    } else {
                        $this->session->set_flashdata('msg', 'Ad not added, Please try again.');
                        $data['msg'] = 'Ad not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                    }
                } else {
                    $this->load->view('user/post_new_add', $data);
                }
            } else {
                $this->load->view('user/contact_alert', $data);
            }
        } else {
            $this->session->set_flashdata('flash_message', 'Sorry, No ads remaining.');
            redirect('user/index');
        }
    }

    //redirect if user have no ads 
    public function redirect_message() {

        $current_user = $this->session->userdata('gen_user');

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'Message';
        $where = " where user_id='" . $current_user['user_id'] . "'";
        $user = $this->dbcommon->getrowdetails('user', $where);

        $data['current_user'] = $user;
        $where = " where is_delete=0 and CURDATE() between from_date and to_date and userAdsLeft>0 and userTotalAds>0  and status='active' and user_id=" . (int) $current_user['user_id'] . "";

        $check_ad_left = $this->dbcommon->getdetails('user', $where);

        if (empty($check_ad_left))
            $this->load->view('user/pay_wait', $data);
        else
            redirect('user/post_ads');
    }

    public function show_sub_category() {

        $filter_val = $this->input->post("value");
        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user['user_id']) && $current_user['user_id'] != '') {

            $check_getuser = $this->db->query('select * from user 
                                left join store on store.store_owner=user.user_id
                                where user_id=' . (int) $current_user['user_id'] . ' and is_delete in(0,3,6) limit 1')->row_array();

            $chkuser_id = (int) $check_getuser['user_id'];

            if ($chkuser_id > 0) {

                if (!in_array($check_getuser['store_status'], array(0, 3)) && $check_getuser['store_is_inappropriate'] != 'Approve')
                    exit;
                else {
                    //print_r($check_getuser);
                    $main_data['user_category_id'] = $check_getuser['category_id'];
                    $main_data['user_sub_category_id'] = $check_getuser['sub_category_id'];
                }
            } else {
                exit;
                //redirect('home');
            }
        }

        $filter_val = $this->input->post("value");
//        $query = "category_id= '" . $filter_val . "' order by sub_cat_order asc";

        if ($current_user['user_role'] == 'generalUser' || ($current_user['user_role'] == 'storeUser' && $current_user['last_login_as'] == 'generalUser')) {
            $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(0, sub_category_type) > 0 order by sub_cat_order asc";
        } else {
            $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(1, sub_category_type) > 0 order by sub_cat_order asc";
        }

        $main_data['sel_sub_cat'] = $this->input->post("sel_sub_cat");

        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);
        echo $this->load->view('user/sub_cat', $main_data, TRUE);
        exit();
    }

    public function deactivateads() {
        $data = array();
        $data['load_data'] = 'yes';
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        $data['my_deactivateads'] = 'yes';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        $data = array_merge($data, $this->get_elements());

        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user['last_login_as']))
            $last_login_as = $current_user['last_login_as'];
        else
            $last_login_as = NULL;

        $my_deact_ads = $this->dbcommon->get_my_deactivateads($current_user['user_id'], 0, 12, $last_login_as);

        $total_product = $this->dbcommon->get_my_deactivateads_count($current_user['user_id'], $last_login_as);
        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        }
        $data['page_title'] = $total_product . ' Ads Deactivated';
        $data['products'] = $my_deact_ads;
        $data['current_user'] = $current_user;
        $this->load->view('user/deactivate_ads', $data);
    }

    public function deactivateads_map() {
        $data = array();
        $data['load_data'] = 'yes';
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        $data['my_deactivateads'] = 'yes';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        $data = array_merge($data, $this->get_elements());

        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user['last_login_as']))
            $last_login_as = $current_user['last_login_as'];
        else
            $last_login_as = NULL;

        $url = base_url() . 'user/deactivateads/?view=map';
        $total_product = $this->dbcommon->get_my_deactivateads_count($current_user['user_id'], $last_login_as);
        $config = $this->dbcommon->pagination_front($total_product, $url);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];

        $my_deact_ads = $this->dbcommon->get_my_deactivateads($current_user['user_id'], $offset, $config["per_page"], $last_login_as);

        $data['page_title'] = $total_product . ' Ads Deactivated';
        $data['products'] = $my_deact_ads;
        $data['current_user'] = $current_user;
        $this->load->view('home/category_map', $data);
    }

    public function more_deactivateads() {
        $filter_val = $this->input->post("value");
        $current_user = $this->session->userdata('gen_user');

        if (isset($filter_val) && isset($current_user)) {
            if (isset($current_user['last_login_as']))
                $last_login_as = $current_user['last_login_as'];
            else
                $last_login_as = NULL;

            $data['my_deactivateads'] = 'yes';
            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';

            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";

            $total_product = $this->dbcommon->get_my_deactivateads_count($current_user['user_id'], $last_login_as);
            $my_deact_ads = $this->dbcommon->get_my_deactivateads($current_user['user_id'], $start, 12, $last_login_as);

            if ($end >= $total_product) {
                $hide = "true";
            }

            $data['products'] = $my_deact_ads;
            $data['current_user'] = $current_user;

            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                $data["html"] = $this->load->view('home/product_listing_view', $data, TRUE);
            else
                $data["html"] = $this->load->view('home/product_grid_view', $data, TRUE);
            $data["val"] = $hide;
            $data["total_product"] = $total_product;
            echo json_encode($data);
            exit();
        }
        else {
            override_404();
        }
    }

    public function mark_sold($pro_id = NULL) {
        $current_user = $this->session->userdata('gen_user');
        if ($current_user)
            $user_id = $current_user['user_id'];
        if (isset($pro_id)) {
            $query1 = ' * from product where product_id=' . $pro_id . ' and product_posted_by=' . (int) $user_id . ' and is_delete in (0,3) and (product_is_sold =0 or product_is_sold is null)  and product_for="classified" limit 1';

            $res1 = $this->dbcommon->getnumofdetails_($query1);
            if ($res1 > 0) {
                $in_arr = array('user_id' => $user_id,
                    'product_id' => $pro_id
                );

                $this->dbcommon->insert('user_mark_sold', $in_arr);

                $up_arr = array('product_is_sold' => 1,
                    'product_status' => 'sold'
                );
                $array = array('product_posted_by' => (int) $user_id,
                    'product_id' => $pro_id
                );

                $this->dbcommon->update('product', $array, $up_arr);
                $this->session->set_flashdata(array('msg' => 'Ad marked as SOLD Successfully.', 'class' => 'alert-info'));
                redirect('user/my_listing');
            } else {
                $this->session->set_flashdata(array('msg' => 'Please try again.', 'class' => 'alert-info'));
                redirect('user/my_listing');
            }
        }
    }

    //repost if deactivate ads 
    public function repost_ads() {
        $pro_id = $this->uri->segment(3);
        $list = $this->uri->segment(4);

        $current_user = $this->session->userdata('gen_user');
        if (isset($pro_id)) {
            //check user have leftads?
            $query = ' * from user where user_id=' . (int) $current_user['user_id'] . ' and is_delete=0 and userAdsLeft>0 and CURDATE() between date(from_date) and date(to_date)';
            $res = $this->dbcommon->getnumofdetails_($query);
            //print_r($res);
            if ($res > 0) {
                $query1 = ' * from product where product_id=' . $pro_id . ' and product_posted_by=' . (int) $current_user['user_id'] . ' and is_delete=0 limit 1';

                $res1 = $this->dbcommon->getnumofdetails_($query1);
                if ($res1 > 0) {
                    $get_data = $this->db->query(' select * from product where  product_id=' . (int) $pro_id . ' and product_posted_by=' . (int) $current_user['user_id'] . ' and is_delete=0 limit 1');
                    $data = $get_data->row_array();
                    $in_arr = array('userid' => $data['product_posted_by'],
                        'productid' => $data['product_id']
                    );

                    $this->dbcommon->insert('repost', $in_arr);
                    $up_arr = array('product_is_inappropriate' => 'NeedReview',
                        'product_deactivate' => null,
                        'update_from' => 'web'
                    );

                    $array = array('product_posted_by' => (int) $current_user['user_id'],
                        'product_id' => $pro_id
                    );

                    $this->dbcommon->update('product', $array, $up_arr);

                    $up_user = $this->db->query('select * from user where user_id=' . (int) $current_user['user_id'] . ' and is_delete in (0,3,6) and userAdsLeft>0 and CURDATE() between date(from_date) and date(to_date)');
                    $get_user = $up_user->row_array();
                    $min = (int) $get_user['userAdsLeft'] - 1;

                    $up_user = array('userAdsLeft' => $min);
                    $use_arr = array('user_id' => $current_user['user_id']);

                    $this->dbcommon->update('user', $use_arr, $up_user);

                    $this->session->set_flashdata(array('msg' => 'Ad repost successfully.', 'class' => 'alert-info'));
                    if ($list == 'list')
                        redirect('user/my_listing');
                    else
                        redirect('user/deactivateads');
                }
                else {
                    $this->session->set_flashdata(array('msg' => 'Ad is not able to Repost.', 'class' => 'alert-info'));
                    if ($list == 'list')
                        redirect('user/my_listing');
                    else
                        redirect('user/deactivateads');
                }
            }

            else {
                $this->session->set_flashdata(array('msg' => 'No Ads left for this month', 'class' => 'alert-danger'));
                if ($list == 'list')
                    redirect('user/my_listing');
                else
                    redirect('user/deactivateads');
            }
        }
        else {
            if ($list == 'list')
                redirect('user/my_listing');
            else
                redirect('user/deactivateads');
        }
    }

    public function favorite() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['load_data'] = 'yes';
        $current_user = $this->session->userdata('gen_user');
        $data['favorite_ads'] = 'yes';

        $total_product = $this->dbcommon->get_my_favorites_count($current_user['user_id']);
        $my_favs = $this->dbcommon->get_my_favorites($current_user['user_id'], 0, 12);

        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        }

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $data['page_title'] = $total_product . ' Ads Favorites';
        $data['products'] = $my_favs;
        $data['current_user'] = $current_user;
        $this->load->view('user/favorite', $data);
    }

    public function like() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['load_data'] = 'yes';
        $current_user = $this->session->userdata('gen_user');
        $data['like_ads'] = 'yes';

        $total_product = $this->dbcommon->get_my_favorites_count($current_user['user_id'], 'like');
        $my_favs = $this->dbcommon->get_my_favorites($current_user['user_id'], 0, 12, 'like');
        //echo $this->db->last_query();
        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        }

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $data['page_title'] = $total_product . ' Ads Likes';
        $data['products'] = $my_favs;
        $data['current_user'] = $current_user;
        $this->load->view('user/favorite', $data);
    }

    public function favorite_map() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['load_data'] = 'yes';
        $current_user = $this->session->userdata('gen_user');
        $data['favorite_ads'] = 'yes';

        $url = base_url() . 'user/favorite/?view=map';
        $total_product = $this->dbcommon->get_my_favorites_count($current_user['user_id']);

        $config = $this->dbcommon->pagination_front($total_product, $url);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];

        $my_favs = $this->dbcommon->get_my_favorites($current_user['user_id'], $offset, $config["per_page"]);

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $data['page_title'] = $total_product . ' Ads Favorites';
        $data['products'] = $my_favs;
        $data['current_user'] = $current_user;
        $this->load->view('home/category_map', $data);
    }

    public function like_map() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['load_data'] = 'yes';
        $current_user = $this->session->userdata('gen_user');
        $data['like_ads'] = 'yes';

        $url = base_url() . 'user/like/?view=map';
        $total_product = $this->dbcommon->get_my_favorites_count($current_user['user_id'], 'like');

        $config = $this->dbcommon->pagination_front($total_product, $url);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];

        $my_favs = $this->dbcommon->get_my_favorites($current_user['user_id'], $offset, $config["per_page"], 'like');

        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $data['page_title'] = $total_product . ' Ads Likes';
        $data['products'] = $my_favs;
        $data['current_user'] = $current_user;
        $this->load->view('home/category_map', $data);
    }

    public function more_favorite() {

        $filter_val = $this->input->post("value");
        $current_user = $this->session->userdata('gen_user');

        if (isset($filter_val) && isset($current_user)) {

            if (isset($_REQUEST['like']) && $_REQUEST['like'] == 'yes')
                $total_product = $this->dbcommon->get_my_favorites_count($current_user['user_id'], 'like');
            else
                $total_product = $this->dbcommon->get_my_favorites_count($current_user['user_id']);

            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";

            if ($end >= $total_product) {
                $hide = "true";
            }

            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            if (isset($_REQUEST['like']) && $_REQUEST['like'] == 'yes') {
                $favproduct = $this->dbcommon->get_my_favorites($current_user['user_id'], $start, 12, 'like');
                $data['like_ads'] = 'yes';
            } else {
                $favproduct = $this->dbcommon->get_my_favorites($current_user['user_id'], $start, 12);
                $data['favorite_ads'] = 'yes';
            }

            $data['current_user'] = $current_user;
            $data['products'] = $favproduct;

            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                $data["html"] = $this->load->view('home/product_listing_view', $data, TRUE);
            else
                $data["html"] = $this->load->view('home/product_grid_view', $data, TRUE);

            $data["val"] = $hide;
            $data["total_product"] = $total_product;
            echo json_encode($data);
            exit();
        }
        else {
            override_404();
        }
    }

    public function my_listing() {
        $current_user = $this->session->userdata('gen_user');
        $data = array();
        $data['load_data'] = 'yes';
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';

        $featuredad_price = $this->dbcommon->select('featuredad_price');
        $data['featuredad_price'] = $featuredad_price;

        if ($this->session->userdata('gen_user')) {

            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
            $where = " where user_id='" . $current_user['user_id'] . "'";
            $user = $this->dbcommon->getrowdetails('user', $where);
            $data['userAdsLeft'] = $user->userAdsLeft;
        }

        $data = array_merge($data, $this->get_elements());
        $current_user = $this->session->userdata('gen_user');

        $data['user_id'] = $current_user['user_id'];
        $data['my_listing'] = 'yes';

        $user_status = 0;
        if ($current_user['is_delete'] == 3)
            $user_status = 1;

        if (isset($current_user['last_login_as']))
            $last_login_as = $current_user['last_login_as'];
        else
            $last_login_as = NULL;

        if (isset($_REQUEST['val']) && $_REQUEST['val'] == 'Approve')
            $listing = $this->dbcommon->get_my_listing($current_user['user_id'], $start = 0, $limit = 12, NULL, $user_status, $last_login_as, NULL, NULL, NULL, NULL, 'yes');
        else {
            $listing = $this->dbcommon->get_my_listing($current_user['user_id'], $start = 0, $limit = 12, NULL, $user_status, $last_login_as, NULL, NULL, NULL, NULL);
        }

        $total_product = $this->dbcommon->get_my_listing_count($current_user['user_id'], NULL, $user_status, $last_login_as);

        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        }
        if (isset($_REQUEST['val']) && $_REQUEST['val'] == 'Unapprove')
            $title = 'Unapprove';
        elseif (isset($_REQUEST['val']) && $_REQUEST['val'] == 'NeedReview')
            $title = 'In-active';
        else
            $title = 'Approve';

        $data['page_title'] = $total_product . ' Ads in My Ads';

        $data['products'] = $listing;
        $data['current_user'] = $current_user;

        $this->load->view('user/my_listing', $data);
    }

    public function my_listing_map() {

        $current_user = $this->session->userdata('gen_user');
        $data = array();
        $data['my_listing'] = 'yes';
        $data['product_page'] = 'yes';

        $data['load_data'] = 'yes';
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';

        $featuredad_price = $this->dbcommon->select('featuredad_price');
        $data['featuredad_price'] = $featuredad_price;

        if ($this->session->userdata('gen_user')) {

            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
            $where = " where user_id='" . $current_user['user_id'] . "'";
            $user = $this->dbcommon->getrowdetails('user', $where);
            $data['userAdsLeft'] = $user->userAdsLeft;
        }
        $val_req = '';
        if (isset($_REQUEST['val'])) {
            $val_req = $_REQUEST['val'];
            $url = base_url() . 'user/my_listing/?view=map&val=' . $_REQUEST['val'];
        } else
            $url = base_url() . 'user/my_listing/?view=map';


        $data = array_merge($data, $this->get_elements());
        $current_user = $this->session->userdata('gen_user');

        $data['user_id'] = $current_user['user_id'];

        $user_status = 0;
        if ($current_user['is_delete'] == 3)
            $user_status = 1;

        if (isset($current_user['last_login_as']))
            $last_login_as = $current_user['last_login_as'];
        else
            $last_login_as = NULL;

        $total_product = $this->dbcommon->get_my_listing_count($current_user['user_id'], NULL, $user_status, $last_login_as);

        $config = $this->dbcommon->pagination_front($total_product, $url);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];

        $listing = $this->dbcommon->get_my_listing($current_user['user_id'], $offset, $config["per_page"], NULL, $user_status, $last_login_as);

        if (isset($_REQUEST['val']) && $_REQUEST['val'] == 'Unapprove')
            $title = 'Unapprove';
        elseif (isset($_REQUEST['val']) && $_REQUEST['val'] == 'NeedReview')
            $title = 'In-active';
        else
            $title = 'Approve';

        $data['page_title'] = $total_product . ' Ads in My Ads';

        $data['products'] = $listing;
        $data['current_user'] = $current_user;

        $this->load->view('home/category_map', $data);
    }

    public function load_more_mylisting() {
        $filter_val = $this->input->post("value");
        $user_id = $this->input->post("user_id");
        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];

//        if (isset($filter_val) && isset($user_id)) {
        if (isset($filter_val)) {
            if (isset($current_user['last_login_as']))
                $last_login_as = $current_user['last_login_as'];
            else
                $last_login_as = NULL;

            $arr['is_logged'] = 0;
            $arr['loggedin_user'] = '';
            if ($this->session->userdata('gen_user')) {
                $arr['loggedin_user'] = $current_user['user_id'];
                $arr['is_logged'] = 1;
            }

            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";

            $arr['my_listing'] = 'yes';

            $user_status = 0;
            if ($current_user['is_delete'] == 3)
                $user_status = 1;

            $total_product = $this->dbcommon->get_my_listing_count($user_id, NULL, $user_status, $last_login_as);
            $listing = $this->dbcommon->get_my_listing($user_id, $start, 12, NULL, $user_status, $last_login_as);

            if ($end >= $total_product) {
                $hide = "true";
            }
            $arr['current_user'] = $current_user;
            $arr['products'] = $listing;

            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                $arr["html"] = $this->load->view('home/product_listing_view', $arr, TRUE);
            else
                $arr["html"] = $this->load->view('home/product_grid_view', $arr, TRUE);

            $arr["val"] = $hide;
            $arr["total_product"] = $total_product;
            echo json_encode($arr);
            exit();
        }
        else {
            override_404();
        }
    }

    public function listings_edit($pro_id = null) {

        $data = array();

        $current_user = $this->session->userdata('gen_user');
        $data['logged_in_user'] = $current_user;
        $user_id = $current_user['user_id'];

        if (!empty($current_user['last_login_as']) && $current_user['last_login_as'] == 'generalUser')
            $product_for = ' and product_for="classified"';
        elseif (!empty($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser')
            $product_for = ' and product_for="store"';
        else
            $product_for = '';

        $num_row = $this->dbcommon->getnumofdetails_("* from product where product_id = " . (int) $pro_id . " and product_posted_by=" . (int) $user_id . " and is_delete in (0,3,6) " . $product_for);

        $WaterMark = site_url() . 'assets/front/images/logoWmark.png';

        if ($num_row > 0) {

            $data = array_merge($data, $this->get_elements());

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

            $plate_source = $this->dbcommon->select('plate_source');
            $data['plate_source'] = $plate_source;

            $plate_digit = $this->dbcommon->select('plate_digit');
            $data['plate_digit'] = $plate_digit;

            $where = 'num_for="plate"';
            $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
            $data['repeating_numbers_car'] = $repeating_numbers;

            $where = 'num_for="mobile"';
            $repeating_numbers = $this->dbcommon->filter('repeating_numbers', $where);
            $data['repeating_numbers_mobile'] = $repeating_numbers;

            $plate_digit_mobile = $this->dbcommon->select('plate_digit');
            $data['plate_digit_mobile'] = $plate_digit_mobile;

            $mobile_operators = $this->dbcommon->select('mobile_operators');
            $data['mobile_operators'] = $mobile_operators;

            $where = " 1=1";
            $delivery_options = $this->dbcommon->filter('delivery_options', $where);
            $data['delivery_options'] = $delivery_options;

            $where = " 1=1";
            $product_weight = $this->dbcommon->filter('product_weight', $where);
            $data['product_weights'] = $product_weight;

            $data['page_title'] = 'Edit Post';

            $location = $this->dbcommon->select_orderby('country', 'country_name', 'asc');
            $data['location'] = $location;
            $where = " where user_id='" . $current_user['user_id'] . "'";
            $user = $this->dbcommon->getrowdetails('user', $where);
            $data['current_user'] = $user;

            $where = array('product_id' => $pro_id);
            $if_vehicle = $this->dbcommon->get_count('product_vehicles_extras', $where);

            $if_real_estate = $this->dbcommon->get_count('product_realestate_extras', $where);

            $where = array('product_id' => $pro_id, 'number_for' => "car_number");
            $if_car_number = $this->dbcommon->get_count('car_mobile_numbers', $where);

            $where = array('product_id' => $pro_id, 'number_for' => "mobile_number");
            $if_mobile_number = $this->dbcommon->get_count('car_mobile_numbers', $where);

            $where = " where user_id='" . $current_user['user_id'] . "'";

            $product_type = 'default';

            if ($if_vehicle > 0)
                $product_type = 'vehicle';
            elseif ($if_real_estate > 0)
                $product_type = 'real_estate';
            elseif ($if_car_number > 0)
                $product_type = 'car_number';
            elseif ($if_mobile_number > 0)
                $product_type = 'mobile_number';

            $data['product_type'] = $product_type;
            $user_status = 0;
            if ($current_user['user_id'] == 3)
                $user_status = 1;

            if ($product_type == 'vehicle')
                $product = $this->dbcommon->get_vehicle_product(null, null, $pro_id, null, null);
            elseif ($product_type == 'real_estate')
                $product = $this->dbcommon->get_real_estate_product(null, null, $pro_id, null, null);
            elseif ($product_type == 'car_number')
                $product = $this->dbcommon->get_car_mobile_number_product(null, null, $pro_id, null, null, 'car_number');
            elseif ($product_type == 'mobile_number')
                $product = $this->dbcommon->get_car_mobile_number_product(null, null, $pro_id, null, null, 'mobile_number');
            else
                $product[] = (array) $this->dbcommon->get_product_foredit($pro_id);

            $cal_query = ' select count(product_id) totcnt from products_images where product_id=' . $pro_id . ' having totcnt>0';
            $my_counter = $this->db->query($cal_query);

            if ($my_counter->num_rows() > 0) {
                if ($my_counter->row_array()['totcnt'] > 0)
                    $data['mycounter'] = $my_counter->row_array()['totcnt'] + 1;
                else
                    $data['mycounter'] = $my_counter->row_array()['totcnt'];
            } else
                $data['mycounter'] = 1;
            $img_cnt = $this->dbcommon->get_images_count($pro_id);

            $data['img_cnt'] = 10 - (int) $img_cnt;

            $vido_cnt = 0;
            if ($product[0]['video_name'] != '')
                $vido_cnt = 1;

            $data['vido_cnt'] = 1 - (int) $vido_cnt;

            if ($product_type == 'vehicle') {
                $where = " brand_id='" . $product[0]['product_brand'] . "'";
                $model = $this->dbcommon->filter('model', $where);
                $data['model'] = $model;
            }
//            $category = $this->dbcommon->select('category');
//            $data['category1'] = $category;

            if ($current_user['user_role'] == 'generalUser' || ($current_user['user_role'] == 'storeUser' && $current_user['last_login_as'] == 'generalUser') || $current_user['user_role'] == 'offerUser') {
                $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
                $data['category1'] = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);
                $where = " category_id='" . $product[0]['category_id'] . "' AND FIND_IN_SET(0, sub_category_type) > 0 order by sub_cat_order asc";
            } else {
                $wh_category_data = array('FIND_IN_SET(1, category_type) > 0');
                $data['category1'] = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);
                $where = " category_id='" . $product[0]['category_id'] . "' AND FIND_IN_SET(1, sub_category_type) > 0 order by sub_cat_order asc";
            }

            $sub_category = $this->dbcommon->filter('sub_category', $where);
            $data['sub_category1'] = $sub_category;

            $location = $this->dbcommon->select_orderby('country', 'country_name', 'asc');
            $data['location'] = $location;

            $where = "country_id=4";
            $state = $this->dbcommon->filter('state', $where);
            $data['state'] = $state;

            $user = $this->session->userdata('gen_user');

            $data['user_role'] = $user['user_role'];

            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $str = substr(str_shuffle($chars), 0, 3);
            $num = rand(10, 99);

            $array = array('product_id' => $pro_id);

            if ($pro_id != null && !empty($product)) {

                if (isset($product[0]['plate_source'])) {
                    $where = ' plate_source_id=' . $product[0]['plate_source'];
                    $plate_prefix = $this->dbcommon->filter('plate_prefix', $where);
                    $data['plate_prefix'] = $plate_prefix;
                }

                $data['product'] = $product;
                $data['category_id'] = $product[0]['category_id'];
                $data['sub_category_id'] = $product[0]['sub_category_id'];

                $where = " product_id='" . $pro_id . "'";
                $data['images'] = $this->dbcommon->filter('products_images', $where);

                if (isset($_FILES)) {
                    end($_FILES);
                    $key = key($_FILES);

                    $input = $key;
                    $d = explode('multiUpload', $input);
                    if (isset($d[1]))
                        $images_num = $d[1];
                }
                $product_old_img = $product[0]['product_image'];

                $video_img = '';
                if (isset($_POST['default_submit'])) {
                    $img1 = $this->dbcommon->get_images($pro_id);
                    $where = " where category_id='" . $_POST['cat_id'] . "'";
                    $cat_name = $this->dbcommon->getdetails('category', $where);
                    $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                    $pro = strtoupper(substr($_POST['pro_name'], 0, 2));
                    $pro_code = $cat . $pro . $num . $str;

                    $this->form_validation->set_rules('pro_name', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('pro_desc', 'Description', 'trim|required');
                    $this->form_validation->set_rules('pro_desc', 'Description', 'trim|required|max_length[2000]');
                    // $this->form_validation->set_rules('original_price', 'Price', 'trim|required');
//                    $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                    if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                        $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                    }

                    if ($this->form_validation->run() == FALSE) {
                        $this->load->view('user/edit_post_ads', $data);
                    } else {
                        $picture = $product[0]['product_image'];
                        $fileName = $_POST["form1_images_arr"];
                        $img_name = '';
                        $picture_ban = array();
                        $youtube = $_POST["youtube"];
                        $video = $_POST["video"];
                        if ($video != '') {
                            $video = base64_decode($video);
                            $youtube = '';
                            $vid = explode("_", $video);
                            $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                            $dest = document_root . product . 'video_image/' . $video_img;
                            if (file_exists(document_root . product . 'video_image/' . $video_img))
                                $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                        }
                        elseif ($youtube != '') {
                            $video = '';
                            $video_img = '';
                            $youtube = $_POST["youtube"];
                            @unlink($target_dir . "original/" . $product[0]['video_name']);
                            $del_array = array('product_id' => $pro_id);
                            $del_data = array('video_name' => '');
                            $this->dbcommon->update('product', $del_array, $del_data);
                        } else {
                            $video = $product[0]['video_name'];
                            if ($video != '') {
                                $vid = explode("_", $video);
                                $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                                $dest = document_root . product . 'video_image/' . $video_img;
                                if (file_exists(document_root . product . 'video_image/' . $video_img))
                                    $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                            }
                            $youtube = $product[0]['youtube_link'];
                        }


                        $data = array(
                            'product_code' => $pro_code,
                            'product_name' => $_POST['pro_name'],
                            'product_image' => (isset($img_name) && $img_name != '') ? $img_name : $product[0]['product_image'],
                            //'sub_category_id' => $_POST['sub_cat'],
                            'product_is_inappropriate' => 'NeedReview',
                            'product_description' => $_POST['pro_desc'],
                            'product_price' => str_replace(",", "", $_POST['pro_price']),
                            'product_reposted_time' => date('y-m-d H:i:s', time()),
                            'product_brand' => 0,
                            'state_id' => $_POST['state'],
                            'product_modified_by' => $user['user_id'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'update_from' => 'web',
                            'video_image_name' => $video_img,
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {

                            $data['total_stock'] = $_POST['total_stock'];
                            $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                            $data['delivery_option'] = $_POST['delivery_option'];
                            $data['weight'] = $_POST['weight'];
                            $data['original_price'] = str_replace(",", "", $_POST['original_price']);

                            if ($avail_stock != '')
                                $avail_stock = $avail_stock;
                            else
                                $avail_stock = $product[0]['stock_availability'];

                            $data['stock_availability'] = $avail_stock;

                            $this->dbcommon->product_stock_track($pro_id);
                        }

                        $result = $this->dbcommon->update('product', $array, $data);
                    }
                }
                elseif (isset($_POST['vehicle_submit'])) {
                    $img1 = $this->dbcommon->get_images($pro_id);
                    $where = " where category_id='" . $_POST['cat_id'] . "'";
                    $cat_name = $this->dbcommon->getdetails('category', $where);
                    $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));

                    $this->form_validation->set_rules('title', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('vehicle_pro_desc', 'Description', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_desc', 'Description', 'trim|required|max_length[2000]');
//                    $this->form_validation->set_rules('vehicle_pro_price', 'Price', 'trim|required');
                    // $this->form_validation->set_rules('vehicle_original_price', 'Price', 'trim|required');
                    $this->form_validation->set_rules('pro_brand', 'Brand', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_model', 'Model', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_type_of_car', 'Type Of Car', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_year', 'Year', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_mileage', 'Mileage', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_condition', 'Condition', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_color', 'Color', 'trim|required');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                    if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                        $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                    }

                    if ($this->form_validation->run() == FALSE) {

                        $this->load->view('user/edit_post_ads', $data);
                    } else {
                        $pro = strtoupper(substr($_POST['title'], 0, 2));
                        $pro_code = $cat . $pro . $num . $str;
                        //here
                        $fileName = $this->input->post("form2_images_arr");

                        $youtube = $_POST["youtube"];
                        $video = $_POST["video"];
                        if ($video != '') {
                            $video = base64_decode($video);
                            $vid = explode("_", $video);
                            $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                            $dest = document_root . product . 'video_image/' . $video_img;
                            if (file_exists(document_root . product . 'video_image/' . $video_img))
                                $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');

                            $youtube = '';
                        }
                        elseif ($youtube != '') {
                            $video = '';
                            $video_img = '';
                            $youtube = $_POST["youtube"];
                            @unlink($target_dir . "original/" . $product[0]['video_name']);
                            $del_array = array('product_id' => $pro_id);
                            $del_data = array('video_name' => '');
                            $this->dbcommon->update('product', $del_array, $del_data);
                        } else {
                            $video = $product[0]['video_name'];
                            if ($video != '') {
                                $vid = explode("_", $video);
                                $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                                $dest = document_root . product . 'video_image/' . $video_img;
                                if (file_exists(document_root . product . 'video_image/' . $video_img))
                                    $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                            }
                            $youtube = $product[0]['youtube_link'];
                        }

                        $img_name = '';

                        $data = array(
                            'product_code' => $pro_code,
                            'product_name' => $_POST['title'],
                            'state_id' => $_POST['state'],
                            'product_image' => (isset($img_name) && $img_name != '') ? $img_name : $product[0]['product_image'],
                            //'sub_category_id' => $_POST['sub_cat'],
                            'product_is_inappropriate' => 'NeedReview',
                            'product_brand' => $_POST['pro_brand'],
                            'product_description' => $_POST['vehicle_pro_desc'],
                            'product_price' => str_replace(",", "", $_POST['vehicle_pro_price']),
                            'product_reposted_time' => date('y-m-d H:i:s', time()),
                            'product_modified_by' => $user['user_id'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'update_from' => 'web',
                            'video_image_name' => $video_img,
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {

                            $data['total_stock'] = $_POST['total_stock'];
                            $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                            $data['delivery_option'] = $_POST['delivery_option'];
                            $data['weight'] = $_POST['weight'];
                            $data['original_price'] = str_replace(",", "", $_POST['vehicle_original_price']);

                            if ($avail_stock != '')
                                $avail_stock = $avail_stock;
                            else
                                $avail_stock = $product[0]['stock_availability'];

                            $data['stock_availability'] = $avail_stock;

                            $this->dbcommon->product_stock_track($pro_id);
                        }

                        $result = $this->dbcommon->update('product', $array, $data);

                        $data_extras = array(
                            'make' => '',
                            'model' => $_POST['vehicle_pro_model'],
                            'type_of_car' => $_POST['vehicle_pro_type_of_car'],
                            'color' => $_POST['vehicle_pro_color'],
                            'millage' => $_POST['vehicle_pro_mileage'],
                            'vehicle_condition' => $_POST['vehicle_pro_condition'],
                            'year' => (isset($_POST['vehicle_pro_year']) && $_POST['vehicle_pro_year'] != '') ? $_POST['vehicle_pro_year'] : NULL
                        );



                        $result = $this->dbcommon->update('product_vehicles_extras', $array, $data_extras);
                        //exit;
                    }
                }
                elseif (isset($_POST['real_estate_houses_submit'])) {
                    $img1 = $this->dbcommon->get_images($pro_id);
                    $where = " where category_id='" . $_POST['cat_id'] . "'";
                    $cat_name = $this->dbcommon->getdetails('category', $where);
                    $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                    $pro = strtoupper(substr($_POST['houses_ad_title'], 0, 2));

                    $this->form_validation->set_rules('houses_ad_title', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('house_pro_desc', 'Description', 'trim|required');
                    $this->form_validation->set_rules('house_pro_desc', 'Description', 'trim|required|max_length[2000]');
                    $this->form_validation->set_rules('pro_square_meters', 'Square Meters', 'trim|required');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');
                    $this->form_validation->set_rules('address', 'Address', 'trim|required');

                    if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                        $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                    }

                    if ($this->form_validation->run() == FALSE) {
                        $this->load->view('user/edit_post_ads', $data);
                    } else {
                        $pro = strtoupper(substr($_POST['houses_ad_title'], 0, 2));
                        $pro_code = $cat . $pro . $num . $str;
                        $fileName = $this->input->post("form3_images_arr");
                        //$img_name   =   $this->image_upload($images_num,$pro_id,$product);
                        $img_name = '';

                        $picture_ban = array();

                        $youtube = $_POST["youtube"];
                        $video = $_POST["video"];
                        if ($video != '') {
                            $video = base64_decode($video);
                            $vid = explode("_", $video);
                            $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                            $dest = document_root . product . 'video_image/' . $video_img;
                            if (file_exists(document_root . product . 'video_image/' . $video_img))
                                $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');

                            $youtube = '';
                        }
                        elseif ($youtube != '') {
                            $video = '';
                            $video_img = '';
                            $youtube = $_POST["youtube"];
                            @unlink($target_dir . "original/" . $product[0]['video_name']);
                            $del_array = array('product_id' => $pro_id);
                            $del_data = array('video_name' => '');
                            $this->dbcommon->update('product', $del_array, $del_data);
                        } else {
                            $video = $product[0]['video_name'];
                            if ($video != '') {
                                $vid = explode("_", $video);
                                $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                                $dest = document_root . product . 'video_image/' . $video_img;
                                if (file_exists(document_root . product . 'video_image/' . $video_img))
                                    $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                            }
                            $youtube = $product[0]['youtube_link'];
                        }


                        $data = array(
                            'product_code' => $pro_code,
                            'product_name' => $_POST['houses_ad_title'],
                            'product_image' => (isset($img_name) && $img_name != '') ? $img_name : $product[0]['product_image'],
                            'product_is_inappropriate' => 'NeedReview',
                            'product_description' => $_POST['house_pro_desc'],
                            'product_price' => str_replace(",", "", $_POST['houses_price']),
                            'product_reposted_time' => date('y-m-d H:i:s', time()),
                            'state_id' => $_POST['state'],
                            'product_modified_by' => $user['user_id'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'update_from' => 'web',
                            'video_image_name' => $video_img,
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {

                            $data['total_stock'] = $_POST['total_stock'];
                            $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                            $data['delivery_option'] = $_POST['delivery_option'];
                            $data['weight'] = $_POST['weight'];
                            $data['original_price'] = str_replace(",", "", $_POST['house_original_price']);

                            if ($avail_stock != '')
                                $avail_stock = $avail_stock;
                            else
                                $avail_stock = $product[0]['stock_availability'];

                            $data['stock_availability'] = $avail_stock;

                            $this->dbcommon->product_stock_track($pro_id);
                        }

                        $result = $this->dbcommon->update('product', $array, $data);

                        $data_extras = array(
                            'neighbourhood' => $_POST['houses_pro_neighbourhood'],
                            'address' => $_POST['address'],
                            'furnished' => $_POST['furnished'],
                            'pets' => $_POST['pets'],
                            'free_status' => $_POST['houses_free'],
                            'broker_fee' => $_POST['broker_fee'],
                            'Bedrooms' => $_POST['bedrooms'],
                            'Bathrooms' => $_POST['bathrooms'],
                            'Area' => $_POST['pro_square_meters'],
                            'ad_language' => $_POST['houses_language']
                        );
                        $result = $this->dbcommon->update('product_realestate_extras', $array, $data_extras);
                    }
                }
                elseif (isset($_POST['real_estate_shared_submit'])) {
                    $img1 = $this->dbcommon->get_images($pro_id);
                    $where = " where category_id='" . $_POST['cat_id'] . "'";
                    $cat_name = $this->dbcommon->getdetails('category', $where);
                    $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                    $pro = strtoupper(substr($_POST['shared_ad_title'], 0, 2));

                    $this->form_validation->set_rules('shared_ad_title', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('shared_pro_desc', 'Description', 'trim|required');
                    $this->form_validation->set_rules('shared_pro_desc', 'Description', 'trim|required|max_length[2000]');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');
                    $this->form_validation->set_rules('address', 'Address', 'trim|required');

                    if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                        $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                    }

                    if ($this->form_validation->run() == FALSE) {

                        $this->load->view('user/edit_post_ads', $data);
                    } else {
                        $pro = strtoupper(substr($_POST['shared_ad_title'], 0, 2));
                        $pro_code = $cat . $pro . $num . $str;
                        $fileName = $this->input->post("form4_images_arr");

                        //$img_name   =   $this->image_upload($images_num,$pro_id,$product);
                        $img_name = '';

                        $youtube = $_POST["youtube"];
                        $video = $_POST["video"];
                        if ($video != '') {
                            $video = base64_decode($video);
                            $vid = explode("_", $video);
                            $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                            $dest = document_root . product . 'video_image/' . $video_img;
                            if (file_exists(document_root . product . 'video_image/' . $video_img))
                                $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                            $youtube = '';
                        }
                        elseif ($youtube != '') {
                            $video = '';
                            $video_img = '';
                            $youtube = $_POST["youtube"];
                            @unlink($target_dir . "original/" . $product[0]['video_name']);
                            $del_array = array('product_id' => $pro_id);
                            $del_data = array('video_name' => '');
                            $this->dbcommon->update('product', $del_array, $del_data);
                        } else {
                            $video = $product[0]['video_name'];
                            if ($video != '') {
                                $vid = explode("_", $video);
                                $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                                $dest = document_root . product . 'video_image/' . $video_img;
                                if (file_exists(document_root . product . 'video_image/' . $video_img))
                                    $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                            }
                            $youtube = $product[0]['youtube_link'];
                        }

                        $data = array(
                            'product_code' => $pro_code,
                            'product_name' => $_POST['shared_ad_title'],
                            'product_image' => (isset($img_name) && $img_name != '') ? $img_name : $product[0]['product_image'],
                            'product_is_inappropriate' => 'NeedReview',
                            'product_description' => $_POST['shared_pro_desc'],
                            'product_price' => str_replace(",", "", $_POST['shared_price']),
                            'product_reposted_time' => date('y-m-d H:i:s', time()),
                            'product_modified_by' => $user['user_id'],
                            'state_id' => $_POST['state'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'update_from' => 'web',
                            'video_image_name' => $video_img,
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {

                            $data['total_stock'] = $_POST['total_stock'];
                            $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                            $data['delivery_option'] = $_POST['delivery_option'];
                            $data['weight'] = $_POST['weight'];
                            $data['original_price'] = str_replace(",", "", $_POST['shared_original_price']);

                            if ($avail_stock != '')
                                $avail_stock = $avail_stock;
                            else
                                $avail_stock = $product[0]['stock_availability'];

                            $data['stock_availability'] = $avail_stock;

                            $this->dbcommon->product_stock_track($pro_id);
                        }

                        $result = $this->dbcommon->update('product', $array, $data);

                        $data_extras = array(
                            'neighbourhood' => $_POST['shared_pro_neighbourhood'],
                            'address' => $_POST['address'],
                            'free_status' => $_POST['shared_free'],
                            'ad_language' => $_POST['shared_language']
                        );
                        $result = $this->dbcommon->update('product_realestate_extras', $array, $data_extras);
                    }
                }
                elseif (isset($_POST['car_number_submit'])) {

                    $img1 = $this->dbcommon->get_images($pro_id);
                    $where = " where category_id='" . $_POST['cat_id'] . "'";
                    $cat_name = $this->dbcommon->getdetails('category', $where);
                    $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                    $pro = strtoupper(substr($_POST['pro_name'], 0, 2));
                    $pro_code = $cat . $pro . $num . $str;

                    $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                    $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                    $this->form_validation->set_rules('pro_name', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('car_desc', 'Description', 'trim|required');
                    $this->form_validation->set_rules('car_desc', 'Description', 'trim|required|max_length[2000]');
//                    $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                    //                    $this->form_validation->set_rules('car_original_price', 'Price', 'trim|required');
                    $this->form_validation->set_rules('car_number', 'Car Number', 'trim|required');
                    $this->form_validation->set_rules('plate_source', 'Plate Source', 'trim|required');
                    $this->form_validation->set_rules('plate_digit', 'Plate Digit', 'trim|required');
                    $this->form_validation->set_rules('repeating_numbers_car', 'Repeating Numbers', 'trim|required');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                    if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                        $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                    }

                    if ($this->form_validation->run() == FALSE):
                        $this->load->view('user/edit_post_ads', $data);
                    else:
                        $picture = $product[0]['product_image'];
                        $fileName = $_POST["form5_images_arr"];

                        $youtube = $_POST["youtube"];
                        $video = $_POST["video"];
                        if ($video != '') {
                            $video = base64_decode($video);
                            $vid = explode("_", $video);
                            $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                            $dest = document_root . product . 'video_image/' . $video_img;
                            if (file_exists(document_root . product . 'video_image/' . $video_img))
                                $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');

                            $youtube = '';
                        }
                        elseif ($youtube != '') {
                            $video = '';
                            $video_img = '';
                            $youtube = $_POST["youtube"];
                            @unlink($target_dir . "original/" . $product[0]['video_name']);
                            $del_array = array('product_id' => $pro_id);
                            $del_data = array('video_name' => '');
                            $this->dbcommon->update('product', $del_array, $del_data);
                        } else {
                            $video = $product[0]['video_name'];
                            if ($video != '') {
                                $vid = explode("_", $video);
                                $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                                $dest = document_root . product . 'video_image/' . $video_img;
                                if (file_exists(document_root . product . 'video_image/' . $video_img))
                                    $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                            }
                            $youtube = $product[0]['youtube_link'];
                        }

                        $picture_ban = array();
                        $my_wh = ' where product_id=' . $pro_id;

                        $data = array(
                            'product_code' => $pro_code,
                            'product_name' => $_POST['pro_name'],
                            'product_description' => $_POST['car_desc'],
                            'product_is_inappropriate' => 'NeedReview',
                            'product_price' => str_replace(",", "", $_POST['pro_price']),
                            'product_reposted_time' => date('y-m-d H:i:s', time()),
                            'state_id' => $_POST['state'],
                            'country_id' => $_POST['location'],
                            'product_modified_by' => $user['user_id'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'update_from' => 'web',
                            'video_image_name' => $video_img,
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {

                            $data['total_stock'] = $_POST['total_stock'];
                            $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                            $data['delivery_option'] = $_POST['delivery_option'];
                            $data['weight'] = $_POST['weight'];
                            $data['original_price'] = str_replace(",", "", $_POST['car_original_price']);

                            if ($avail_stock != '')
                                $avail_stock = $avail_stock;
                            else
                                $avail_stock = $product[0]['stock_availability'];

                            $data['stock_availability'] = $avail_stock;

                            $this->dbcommon->product_stock_track($pro_id);
                        }

                        $result = $this->dbcommon->update('product', $array, $data);

                        $query = ' * from car_mobile_numbers where product_id=' . $pro_id . ' and number_for="car_number"';
                        $cnt = $this->dbcommon->getnumofdetails_($query);
                        if ($cnt > 0) {
                            $data_extras = array(
                                'plate_source' => $_POST['plate_source'],
                                'plate_prefix' => $_POST['plate_prefix'],
                                'plate_digit' => $_POST['plate_digit'],
                                'repeating_number' => $_POST['repeating_numbers_car'],
                                'car_number' => $_POST['car_number'],
                                'number_for' => 'car_number'
                            );
                            $this->dbcommon->update('car_mobile_numbers', $array, $data_extras);
                        } else {
                            $data_extras = array(
                                'plate_source' => $_POST['plate_source'],
                                'plate_prefix' => $_POST['plate_prefix'],
                                'plate_digit' => $_POST['plate_digit'],
                                'repeating_number' => $_POST['repeating_numbers_car'],
                                'car_number' => $_POST['car_number'],
                                'number_for' => 'car_number',
                                'product_id' => $pro_id
                            );
                            $this->dbcommon->insert('car_mobile_numbers', $data_extras);
                        }

                    endif;
                } elseif (isset($_POST['mobile_number_submit'])) {
                    $img1 = $this->dbcommon->get_images($pro_id);
                    $where = " where category_id='" . $_POST['cat_id'] . "'";
                    $cat_name = $this->dbcommon->getdetails('category', $where);
                    $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                    $pro = strtoupper(substr($_POST['pro_name'], 0, 2));
                    $pro_code = $cat . $pro . $num . $str;

                    $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                    $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                    $this->form_validation->set_rules('pro_name', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('mob_desc', 'Description', 'trim|required');
                    $this->form_validation->set_rules('mob_desc', 'Description', 'trim|required|max_length[2000]');
                    //                    $this->form_validation->set_rules('mobile_original_price', 'Price', 'trim|required');
//                    $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                    $this->form_validation->set_rules('mobile_operators', 'Mobile Operator', 'trim|required');
                    $this->form_validation->set_rules('repeating_numbers_mobile', 'Repeating Number', 'trim|required');
                    $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                    if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        $this->form_validation->set_rules('delivery_option', 'Delivery Option', 'trim|required');
                        $this->form_validation->set_rules('weight', 'Weight', 'trim|required');
                    }

                    if ($this->form_validation->run() == FALSE) {
                        $this->load->view('user/edit_post_ads', $data);
                    } else {
                        $picture = $product[0]['product_image'];
                        $fileName = $_POST["form6_images_arr"];
                        $img_name = '';
                        $picture_ban = array();
                        $youtube = $_POST["youtube"];
                        $video = $_POST["video"];
                        if ($video != '') {
                            $video = base64_decode($video);
                            $youtube = '';
                            $vid = explode("_", $video);
                            $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                            $dest = document_root . product . 'video_image/' . $video_img;
                            if (file_exists(document_root . product . 'video_image/' . $video_img))
                                $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                        }
                        elseif ($youtube != '') {
                            $video = '';
                            $video_img = '';
                            $youtube = $_POST["youtube"];
                            @unlink($target_dir . "original/" . $product[0]['video_name']);
                            $del_array = array('product_id' => $pro_id);
                            $del_data = array('video_name' => '');
                            $this->dbcommon->update('product', $del_array, $del_data);
                        } else {
                            $video = $product[0]['video_name'];
                            if ($video != '') {
                                $vid = explode("_", $video);
                                $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                                $dest = document_root . product . 'video_image/' . $video_img;
                                if (file_exists(document_root . product . 'video_image/' . $video_img))
                                    $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                            }
                            $youtube = $product[0]['youtube_link'];
                        }

                        $data = array(
                            'product_code' => $pro_code,
                            'product_name' => $_POST['pro_name'],
                            'product_image' => (isset($img_name) && $img_name != '') ? $img_name : $product[0]['product_image'],
                            'product_is_inappropriate' => 'NeedReview',
                            'product_description' => $_POST['mob_desc'],
                            'product_price' => str_replace(",", "", $_POST['pro_price']),
                            'product_reposted_time' => date('y-m-d H:i:s', time()),
                            'product_brand' => 0,
                            'state_id' => $_POST['state'],
                            'product_modified_by' => $user['user_id'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'update_from' => 'web',
                            'video_image_name' => $video_img,
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {

                            $data['total_stock'] = $_POST['total_stock'];
                            $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                            $data['delivery_option'] = $_POST['delivery_option'];
                            $data['weight'] = $_POST['weight'];
                            $data['original_price'] = str_replace(",", "", $_POST['mobile_original_price']);

                            if ($avail_stock != '')
                                $avail_stock = $avail_stock;
                            else
                                $avail_stock = $product[0]['stock_availability'];

                            $data['stock_availability'] = $avail_stock;

                            $this->dbcommon->product_stock_track($pro_id);
                        }

                        $result = $this->dbcommon->update('product', $array, $data);

                        $query = ' * from car_mobile_numbers where product_id=' . $pro_id . ' and number_for="mobile_number"';
                        $cnt = $this->dbcommon->getnumofdetails_($query);
                        if ($cnt > 0) {
                            $data_extras = array(
                                'mobile_operator' => $_POST['mobile_operators'],
                                'repeating_number' => $_POST['repeating_numbers_mobile'],
                                'mobile_number' => $_POST['mobile_number'],
                                'number_for' => 'mobile_number'
                            );
                            $this->dbcommon->update('car_mobile_numbers', $array, $data_extras);
                        } else {
                            $data_extras = array(
                                'mobile_operator' => $_POST['mobile_operators'],
                                'repeating_number' => $_POST['repeating_numbers_mobile'],
                                'number_for' => 'mobile_number',
                                'mobile_number' => $_POST['mobile_number'],
                                'product_id' => $pro_id
                            );
                            $this->dbcommon->insert('car_mobile_numbers', $data_extras);
                        }
                    }
                } else {
                    $this->load->view('user/edit_post_ads', $data);
                }

                if (isset($result)) {
                    if (isset($img1)) {
                        //for old images
                        foreach ($img1 as $key => $val) {
                            $ext = explode(".", $val);
                            //$val)
                            if ($_POST['cov_img'] == '' && $key == 1) {
                                $user_data = array('product_image' => $val);
                                $array = array('product_id' => $pro_id);
                                $this->dbcommon->update('product', $array, $user_data);
                                $this->db->query('delete from products_images where product_image= "' . $val . '" and product_id=' . $pro_id);
                            } elseif ($ext[0] == $_POST['cov_img']) {
                                $query = ' product_id from product where product_id=' . $pro_id . ' and product_image="' . $val . '"';
                                $cnt = $this->dbcommon->getnumofdetails_($query);
                                if ($cnt == 0) {

                                    if (isset($product_old_img) && !empty($product_old_img)) {
                                        $insert = array(
                                            'product_id' => $pro_id,
                                            'product_image' => $product_old_img
                                        );

                                        $result = $this->dbcommon->insert('products_images', $insert);
                                    }
                                    $user_data = array(
                                        'product_image' => $val
                                    );
                                    $array = array('product_id' => $pro_id);
                                    $this->dbcommon->update('product', $array, $user_data);

                                    $this->db->query('delete from products_images where product_image= "' . $val . '" and product_id=' . $pro_id);
                                }
                                //
                            } else {
                                
                            }
                        }
                    }
                    //	exit;
                    //for new images 
                    $fileNameArray = explode(',', $fileName);

                    if (sizeof($fileNameArray) > 0 && $fileNameArray[0] != '') {

                        foreach ($fileNameArray as $key => $file) {
                            $file_name = base64_decode($file);
                            $ext = explode(".", $file_name);
                            //$picture 	= 	time() . "." . end($ext);
                            $target_dir = document_root . product;
                            $target_file = $target_dir . "original/" . $file_name;

                            $medium = $target_dir . "product_detail/" . $file_name;
                            if (file_exists(document_root . product . 'original/' . $file_name)) {
                                $this->dbcommon->crop_product_image($target_file, image_product_detail_width, image_product_detail_height, $medium, 'product_detail', $file_name);
                            }

                            $medium = $target_dir . "medium/" . $file_name;
                            if (file_exists(document_root . product . 'original/' . $file_name)) {
                                $this->dbcommon->crop_product_image($target_file, image_medium_width, image_medium_height, $medium, 'medium', $file_name);
                            }

                            //watermark
                            $ext = explode(".", base64_decode($file));
                            $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
                            $dest = document_root . product . 'original/' . $file_name;

                            if (file_exists(document_root . product . 'original/' . $file_name)) {
                                $this->dbcommon->watermarkImage($file_name, $WaterMark, $dest, 50, 'original');
                                $ext = explode(".", base64_decode($file));
//                                print_r($ext);
//                                echo '<br>';
//                                echo $_POST['cov_img'];
//                                exit;
                                if ($ext[0] != $_POST['cov_img']) {
                                    $insert = array(
                                        'product_id' => $pro_id,
                                        'product_image' => base64_decode($file)
                                    );
                                    $result = $this->dbcommon->insert('products_images', $insert);
                                    unset($insert);
                                } else {
                                    $insert = array(
                                        'product_id' => $pro_id,
                                        'product_image' => $product_old_img
                                    );
                                    $result = $this->dbcommon->insert('products_images', $insert);
                                    $user_data = array('product_image' => base64_decode($file));
                                    $array = array('product_id' => $pro_id);
                                    $this->dbcommon->update('product', $array, $user_data);
                                }
                            }
                        }
                    }
                }
                if (isset($_POST['vehicle_submit']) || isset($_POST['default_submit']) || isset($_POST['real_estate_houses_submit']) || isset($_POST['real_estate_shared_submit']) || isset($_POST['car_number_submit']) || isset($_POST['mobile_number_submit'])) {
                    if (isset($result)) {
                        $this->session->set_flashdata('flash_message', 'Ad updated successfully.');
                        redirect('user/item_details/' . $pro_id);
                    } else {

                        $this->session->set_flashdata('flash_message', 'Ad not updated, Please try again');
                        // $this->load->view('user/edit_post_ads', $data);
                    }
                }
            }
        } else {
            override_404();
        }
    }

    //update isdelete for product while delete
    public function removeproduct() {
        $this->db->query('update product set is_delete=1 where product_id=' . $_POST['prod_id'] . ' and product_posted_by=' . session_userid . ' and is_delete in (0,3,6)');
    }
    public function updateproduct() {
        $this->db->query('update product set is_delete=0 where product_id=' . $_POST['prod_id'] . ' and product_posted_by=' . session_userid . ' and is_delete in (0,3,6)');
    }
    
    public function update_hold_product() {
        $this->db->query('update product set is_delete=3 where product_id=' . $_POST['prod_id'] . ' and product_posted_by=' . session_userid . ' and is_delete in (0,3,6)');
    }

    //delete existing images
    public function removeimage() {
        //sub images
        $target_dir = document_root . product;

        $where = "product_image_id='" . $_POST['value'] . "'";
        $imagname = $this->dbcommon->filter('products_images', $where);

        @unlink($target_dir . "original/" . $imagname[0]['product_image']);
        @unlink($target_dir . "small/" . $imagname[0]['product_image']);
        @unlink($target_dir . "medium/" . $imagname[0]['product_image']);

        $array = array('product_image_id' => $_POST['value']);
        $this->dbcommon->delete('products_images', $array);
    }

    //remove jquery uploaded images
    public function remove_image_uploaded() {
        $target_dir = document_root . product;
        $array = explode(",", $_POST['all_data']);
        $not_to = $_POST['not_to_delete'];
        $result = array_diff($array, $not_to);
        foreach ($result as $ar) {
            @unlink($target_dir . "original/" . base64_decode($ar));
            @unlink($target_dir . "small/" . base64_decode($ar));
            @unlink($target_dir . "medium/" . base64_decode($ar));
        }
    }

    //remove jquery uploaded images
    public function remove_video_uploaded() {
        $target_dir = document_root . product;
        @unlink($target_dir . "video/" . base64_decode($_POST['value']));
        $name = $_POST['value'];
        $imagename = explode(".", base64_decode($name));
        $img_name = str_replace('_video', '', $imagename[0]);
        @unlink($target_dir . "video_image/" . $img_name . "_videoimg.jpg");
    }

    //remove existing video
    public function removevideo() {

        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user)) {
            $where = "product_id='" . $_POST['prod_id'] . "' and product_posted_by = " . $current_user['user_id'] . " and video_name='" . $_POST['video'] . "'";
            $vidname = $this->dbcommon->filter('product', $where);

            if (!empty($vidname[0])) {
                $target_dir = document_root . product;
                @unlink($target_dir . "video/" . $_POST['video']);
                $vid = explode(".", $_POST['video']);
                $video_img = str_replace('_video', '', $vid[0]);
                @unlink($target_dir . "video_image/" . $video_img . "_videoimg.jpg");
                $array = array('product_id' => $_POST['prod_id']);
                $data = array('video_name' => '',
                    'video_image_name' => ''
                );
                $this->dbcommon->update('product', $array, $data);
            }
        }
    }

    //remove radio selection wise 
    public function remove_image_selected() {
        $target_dir = document_root . product;
        $val = $_POST['value'];
        @unlink($target_dir . "original/" . base64_decode($val));
    }

    public function removemainimage() {
        //main image
        $target_dir = document_root . product;

        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user)) {
            $where = "product_id='" . $_POST['prod_id'] . "' and product_posted_by = " . $current_user['user_id'];
            $imagname = $this->dbcommon->filter('product', $where);

            if (!empty($imagname)) {
                @unlink($target_dir . "original/" . $imagname[0]['product_image']);
                @unlink($target_dir . "small/" . $imagname[0]['product_image']);
                @unlink($target_dir . "medium/" . $imagname[0]['product_image']);

                $where = "product_id='" . $_POST['prod_id'] . "' order by product_image_id asc limit 1 ";
                $sub_imagname = $this->dbcommon->filter('products_images', $where);
                $image_name = '';
                if (!empty($sub_imagname[0])) {
                    $image_name = $sub_imagname[0]['product_image'];
                    $array = array('product_id' => $_POST['prod_id'], 'product_image' => $image_name);
                    $this->dbcommon->delete('products_images', $array);
                }
                if (!empty($imagname[0])) {
                    $array = array('product_id' => $_POST['prod_id']);
                    $data = array('product_image' => $image_name);
                    $this->dbcommon->update('product', $array, $data);
                }
            }
        }
    }

    public function show_sub_cat() {
        $filter_val = $this->input->post("value");

        $query = "category_id= '" . $filter_val . "'";
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);

        echo $this->load->view('admin/listings/sub_cat', $main_data, TRUE);
        exit();
    }

    public function show_emirates() {

        if (isset($_POST['value'])) {
            //$value = 4;
            $query = "country_id= " . $_POST['value'];
            $current_user = $this->session->userdata('gen_user');

            $where = " where user_id='" . $current_user['user_id'] . "'";
            $user = $this->dbcommon->getrowdetails('user', $where);

            $main_data['mystate'] = $user->state;

            $main_data['state'] = $this->dbcommon->filter('state', $query);
            echo $this->load->view('user/show_state', $main_data, TRUE);
            exit;
        }
    }

    public function show_model() {
        $value = $this->input->post("value");

        if (isset($value)) {
            $sel_model = $this->input->post("sel_model");
            $main_data['sel_model'] = $sel_model;
            $query = "brand_id= " . $value;
            $main_data['model'] = $this->dbcommon->filter('model', $query);

            echo $this->load->view('user/show_model', $main_data, TRUE);
            exit;
        }
    }

    public function show_emirates_postadd() {
        //$value = 4;
        if (isset($_REQUEST['value']) && $_REQUEST['value'] != '')
            $val = $_REQUEST['value'];
        else
            $val = 0;

        $query = "country_id= " . $val;
        $main_data['state'] = $this->dbcommon->filter('state', $query);
        $main_data['sel_city'] = $_POST['sel_city'];
        echo $this->load->view('admin/listings/show_state', $main_data, TRUE);
        exit;
    }

    public function inbox_products() {

        $data = array();
        $sql = $this->db->query('select * from buyer_seller_conversation where product_id=857 order by con_id desc limit 1');
        $res = $sql->result_array();

        $data['res'] = $res;
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $data = array_merge($data, $this->get_elements());
        $current_user = $this->session->userdata('gen_user');

        if (!empty($current_user['last_login_as']) && $current_user['last_login_as'] == 'generalUser')
            $product_for = ' and product_for="classified"';
        elseif (!empty($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser')
            $product_for = ' and product_for="store"';
        else
            $product_for = '';

        $data['user_id'] = $current_user['user_id'];

        $query = ' p.product_name,p.product_id,p.product_image,p.product_slug,bs.con_id,p.product_price,p.product_for,s.*,
		(select count(product_id) mycnt from buyer_seller_conversation bs22 where bs22.status=0 and bs22.product_id=p.product_id and (bs22.receiver_id=' . $current_user['user_id'] . ' )) as counter
			from product p
			right join buyer_seller_conversation bs on bs.product_id=p.product_id
                        left join store s on s.store_owner=p.product_posted_by
			where p.product_deactivate is null and p.is_delete=0 and p.product_is_inappropriate="Approve" 
			and (bs.sender_id=' . $current_user['user_id'] . ' or bs.receiver_id=' . $current_user['user_id'] . ' ) ' . $product_for . ' group by p.product_id order by bs.created_at desc ';
        $total_product = $this->dbcommon->getnumofdetails_($query);

        $url = base_url() . 'user/inbox_products';
        $config = array();
        $config["base_url"] = $url;
        $config["total_rows"] = $total_product;
        $config["per_page"] = 15;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&lt;&lt;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '&gt;&gt;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li>
		<p>';
        $config['cur_tag_close'] = '</p>
		</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];

        $query .= ' limit ' . $page . ', ' . $config["per_page"];
        $product_list = $this->dbcommon->get_distinct('select ' . $query);


        $data['page_title'] = 'Inbox';
        $data['listing'] = $product_list;
        $data['current_user'] = $current_user;

        $sub_bread = array(
            'Home' => base_url(),
            'Products' => '#'
        );
        $data['links'] = $this->pagination->create_links();
        $data['sub_bread'] = $sub_bread;
        $this->load->view('user/inbox_message', $data);
        //$this->load->view('user/inbox_products',$data);			
    }

    public function conversation() {
        $product_id = '';
        $user_id = '';
        $oth_user = '';
        $arr = array();
        $arr['is_logged'] = 0;
        $arr['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $arr['loggedin_user'] = $current_user['user_id'];
            $arr['is_logged'] = 1;
        }

        if (isset($_POST['product_id']))
            $product_id = $_POST['product_id'];
        if (isset($_POST['user_id']))
            $user_id = $_POST['user_id'];
        if (isset($_POST['oth_user']))
            $oth_user = $_POST['oth_user'];

        if ($product_id != '' && $user_id != '' && $oth_user != '') {

            $arr['con_user_id'] = $_POST['user_id'];
            $arr['con_oth_user'] = $_POST['oth_user'];
            $arr['con_product_id'] = $_POST['product_id'];

            $current_user = $this->session->userdata('gen_user');
            $arr['user_id'] = $user_id;
            $arr['current_user'] = $current_user;
            $arr['user_name'] = $current_user['username'];

            if ($current_user['profile_picture'] != '') {
                $profile_picture = base_url() . profile . "original/" . $current_user['profile_picture'];
            } elseif ($current_user['facebook_id'] != '') {
                $profile_picture = 'https://graph.facebook.com/' . $current_user['facebook_id'] . '/picture?type=large';
            } elseif ($current_user['username'] != '') {
                $profile_picture = 'https://twitter.com/' . $current_user['username'] . '/profile_image?size=original';
            } elseif ($current_user['google_id'] != '') {
                $data = file_get_contents('https://picasaweb.google.com/data/entry/api/user/' . $current_user['google_id'] . '?alt=json');
                $d = json_decode($data);
                $profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
            }
            $arr['profile_picture'] = $profile_picture;

            $query = ' bs.product_id,bs.con_id,bs.message,bs.created_at,bs.sender_id,bs.receiver_id,u.username uname,bs.product_id product_id,
			u.profile_picture upick,u1.profile_picture u1pick,u.facebook_id ufb,u1.facebook_id u1fb,
			u.twitter_id utwi,u1.twitter_id u1twei,u.google_id ugoo,u1.google_id u1goo,u.username uname,
			u1.username u1name,u.user_id uid,u1.user_id u1id			
			from buyer_seller_conversation bs	
			left join  user u on u.user_id=bs.sender_id	 
			left join  user u1 on u1.user_id=bs.receiver_id
			where  (bs.sender_id=' . $oth_user . ' or bs.receiver_id=' . $oth_user . ') 
			and (bs.sender_id=' . $user_id . ' or bs.receiver_id=' . $user_id . ') 
			and product_id=' . $product_id . '
			group by bs.con_id order by bs.created_at desc';

            $total_product = $this->dbcommon->getnumofdetails_($query);
            $query .= '';
            $chat_list = $this->dbcommon->get_distinct('select ' . $query);
            $arr['chat_list'] = $chat_list;

            $arr['hide'] = "true";

            $arr["html"] = $this->load->view('user/conversation', $arr, TRUE);
            echo json_encode($arr);
            exit();
        } else {
            override_404();
        }
    }

    public function more_conversation() {
        $product_id = '';
        $user_id = '';
        $oth_user = '';

        if (isset($_POST['product_id']))
            $product_id = $_POST['product_id'];
        if (isset($_POST['user_id']))
            $user_id = $_POST['user_id'];
        if (isset($_POST['oth_user']))
            $oth_user = $_POST['oth_user'];
        $filter_val = $this->input->post("value");

        if ($product_id != '' && $user_id != '' && $oth_user != '') {
            $arr = array();
            $current_user = $this->session->userdata('gen_user');
            $arr['user_id'] = $user_id;
            $arr['current_user'] = $current_user;

            $query = ' bs.product_id,bs.con_id,bs.message,bs.created_at,bs.sender_id,bs.receiver_id,u.username uname,bs.product_id product_id,
			u.profile_picture upick,u1.profile_picture u1pick,u.facebook_id ufb,u1.facebook_id u1fb,
			u.twitter_id utwi,u1.twitter_id u1twei,u.google_id ugoo,u1.google_id u1goo,	u.username uname,
			u1.username u1name,u.user_id uid,u1.user_id u1id			
			from buyer_seller_conversation bs	
			left join  user u on u.user_id=bs.sender_id	 
			left join  user u1 on u1.user_id=bs.receiver_id
			where  (bs.sender_id=' . $oth_user . ' or bs.receiver_id=' . $oth_user . ') 
			and (bs.sender_id=' . $user_id . ' or bs.receiver_id=' . $user_id . ') 
			and product_id=' . $product_id . '  group by bs.con_id order by bs.created_at desc';

            $total_product = $this->dbcommon->getnumofdetails_($query);

            $start = 15 * $filter_val;
            $end = $start + 15;
            $hide = "false";
            if ($end >= $total_product) {
                $hide = "true";
            }

            $query .= ' limit ' . $start . ',15';
            $chat_list = $this->dbcommon->get_distinct('select ' . $query);
            $arr['chat_list'] = $chat_list;

            $arr["html"] = $this->load->view('user/more_conversation', $arr, TRUE);
            $arr["val"] = $hide;
            echo json_encode($arr);
            exit();
        } else {
            override_404();
        }
    }

    public function send_reply() {

        $arr = array();
        $current_user = $this->session->userdata('gen_user');
        if (isset($_POST['mproduct_id']) && isset($_POST['sender_id']) && isset($_POST['receiver_id']) && isset($_POST['reply']) && !empty($_POST['reply'])) {

            $que = ' where user_id=' . $_POST['receiver_id'] . ' and chat_notification=1';
            $user_email = $this->dbcommon->getrowdetails('user', $que);
            $sql = " where user_id=" . $current_user['user_id'];
            $chk_usr = $this->dbcommon->getrowdetails('user', $sql);

            $query = ' where product_id=' . $_POST['mproduct_id'] . ' and is_delete=0 and product_deactivate is null and product_is_inappropriate="Approve"';
            $owner = $this->dbcommon->getrowdetails('product', $query);

            $data = array(
                'product_id' => $_POST['mproduct_id'],
                'sender_id' => $_POST['sender_id'],
                'receiver_id' => $_POST['receiver_id'],
                'message' => json_encode($_POST['reply']),
                'product_owner' => $owner->product_posted_by
            );
            $result = $this->dbcommon->insert('buyer_seller_conversation', $data);
            $id = $this->db->insert_id();
            if (isset($result)) {
                if (isset($current_user['user_id'])) {

                    if (sizeof($chk_usr) > 0 && isset($chk_usr->nick_name) && $chk_usr->nick_name != '')
                        $data['nick_name'] = $chk_usr->nick_name;
                    elseif (sizeof($chk_usr) > 0 && isset($chk_usr->username) && $chk_usr->username != '')
                        $data['nick_name'] = $chk_usr->username;
                    else
                        $data['nick_name'] = '';
                } else
                    $data['nick_name'] = '';

                $parser_data['site_url'] = site_url();
                $parser_data['product'] = $owner->product_name;

                //$parser_data['email']     = $_POST['email_id'];
                $parser_data['redirect_link'] = site_url() . 'login/index';
                $sender = $data['nick_name'];
                $message = $_POST['reply'];
                $message = str_replace('\n', '', $message);
                $message = str_replace('\r', '', $message);

                $title = 'Reply Message';
                $button_label = 'Click here to login';
                $button_link = base_url() . "login/index";

                $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> 
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Sender:</span> ' . $sender . ' </div>
        <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;"><strong>Message : </strong></h6>
        <hr>
        <p>' . $message . '</p>
        <br>
        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>';

                $new_data = $this->dbcommon->mail_format($title, $content);
                $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

                if (sizeof($user_email) > 0) {

                    if (send_mail($user_email->email_id, 'Reply Message', $new_data)) {
                        $arr['mail'] = 'sent';
                    }
                }

                $query1 = ' where con_id=' . $id;
                $datatt = $this->dbcommon->getrowdetails('buyer_seller_conversation', $query1);

                $arr['msg'] = $_POST['reply'];
                $arr['sent_at'] = date('d-m-Y H:i', strtotime($datatt->created_at));

                //$this->load->view('user/trial11',$arr,TRUE);					
                echo json_encode($arr);
                exit;
            }
        }
    }

    public function update_seen() {
        $current_user = $this->session->userdata('gen_user');
        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            if ($product_id != '') {
                $arr = array('product_id' => $product_id, 'status' => 0, 'receiver_id' => $current_user['user_id']);
                $data = array('status' => 1);
                $this->dbcommon->update('buyer_seller_conversation', $arr, $data);

                $inbox_cnt_Sql = ' * from buyer_seller_conversation bsc left join product p on p.product_id=bsc.product_id where bsc.status=0 and bsc.receiver_id=' . $current_user['user_id'] . ' and p.product_is_inappropriate="Approve" and p.is_delete=0 and p.product_deactivate IS NULL';

                $inbox_count = $this->dbcommon->getnumofdetails_($inbox_cnt_Sql);
                $data['inbox_count'] = $inbox_count;

                echo $inbox_count;
            }
        }
    }

    public function item_details($pro_id = null) {

        $current_user = $this->session->userdata('gen_user');
        $data['is_logged'] = 0;
        $data['loggedin_user'] = '';
        if ($this->session->userdata('gen_user')) {
            $current_user = $this->session->userdata('gen_user');
            $data['loggedin_user'] = $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        if ($current_user) {
            $owner_email = $current_user['email_id'];
            $data['owner_email'] = $owner_email;
            $nick_name = $current_user['nick_name'];
            $data['nick_name'] = $nick_name;
            $user_id = $current_user['user_id'];
            $data['user_id'] = $user_id;
        } else {
            $data['owner_email'] = '';
            $data['nick_name'] = '';
            $data['user_id'] = 0;
        }

        if (!empty($current_user['last_login_as']) && $current_user['last_login_as'] == 'generalUser')
            $product_for = ' and product_for="classified"';
        elseif (!empty($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser')
            $product_for = ' and product_for="store"';
        else
            $product_for = '';

        $wh = " where is_delete in (0,3,6) and product_is_inappropriate in ('NeedReview','Approve','Unapprove') and product_deactivate is null";

        $product = $this->dbcommon->getdetails_(' product.*, category.catagory_name, state.state_name, sub_category.sub_category_name, user.username, user.profile_picture, if(product.phone_no <> "", product.phone_no, user.phone ) AS phone, DATE_FORMAT(product.product_posted_time, "%d-%m-%Y") as posted_on, if(user.nick_name!="", user.nick_name, user.username) as username1, user.facebook_id, user.twitter_id, user.google_id,user.user_slug,state.latitude state_latitude,state.longitude state_longitude FROM `product` JOIN `category` ON `category`.`category_id` = `product`.`category_id` LEFT JOIN `sub_category` ON `sub_category`.`sub_category_id` = `product`.`sub_category_id` LEFT JOIN `state` ON `state`.`state_id` = `product`.`state_id` JOIN `user` ON `user`.`user_id` = `product`.`product_posted_by` WHERE `product`.`product_id` = "' . $pro_id . '" AND `product`.`is_delete` in (0,3,6) AND `product`.`product_is_inappropriate` in ("NeedReview","Approve","Unapprove") ' . $product_for . 'group by product.product_id');

        if (sizeof($product) > 0) {
            if ($product[0]->product_for == 'store') {

                if (isset($product[0]->delivery_option) && !empty($product[0]->delivery_option)) {
                    $array = array('id' => $product[0]->delivery_option);
                    $delivery_opt = $this->dbcommon->getdetailsinfo('delivery_options', $array);
                    $data['delivery_option_text'] = $delivery_opt->option_text;
                }
                if (isset($product[0]->weight) && !empty($product[0]->weight)) {
                    $array = array('id' => $product[0]->weight);
                    $weight_opt = $this->dbcommon->getdetailsinfo('product_weight', $array);
                    $data['weight_text'] = $weight_opt->weight_text;
                }
            }
            $que = ' where user_id=' . $product[0]->product_posted_by;
            $user_email = $this->dbcommon->getrowdetails('user', $que);

            $que = ' where user_id=' . $product[0]->product_posted_by . ' and user_id=' . $data['user_id'];
            $user_data = $this->dbcommon->getrowdetails('user', $que);
            if (sizeof($user_data) > 0)
                $data['user_status'] = 'yes';
            else
                $data['user_status'] = 'no';

            if (isset($current_user['user_id'])) {
                $sql = " where user_id=" . $current_user['user_id'];
                $chk_usr = $this->dbcommon->getrowdetails('user', $sql);
                if (sizeof($chk_usr) > 0 && isset($chk_usr->nick_name) && $chk_usr->nick_name != '')
                    $data['nick_name'] = $chk_usr->nick_name;
                elseif (sizeof($chk_usr) > 0 && isset($chk_usr->username) && $chk_usr->username != '')
                    $data['nick_name'] = $chk_usr->username;
                else
                    $data['nick_name'] = '';
            } else
                $data['nick_name'] = '';

            $current_views_count = $product[0]->product_total_views;
            $updated_views_count = $current_views_count + 1;

            $product_video = $product[0]->video_name;
            $data["product_video"] = $product_video;

            $product_videoimg = $product[0]->video_image_name;
            $data["product_videoimg"] = $product_videoimg;

            $youtube_link = $product[0]->youtube_link;
            $data["youtube_link"] = $youtube_link;
            $product_images = array();
            //if ($product[0]->product_image != '')
            //array_push($product_images, $product[0]->product_image);
            $cover_img = $product[0]->product_image;
            $data['cover_img'] = $cover_img;

            $cat_id = $product[0]->category_id;
            $subcat_id = $product[0]->sub_category_id;
            $rand = 'rand';

            $images = $this->dbcommon->get_product_images($pro_id);
            //$product_images = array_merge($product_images, $images);
            $data['product_images'] = $images;
            $share_url = '';
            $i = 0;
            foreach ($product_images as $image) {

                $filename = document_root . product . 'original/' . $image;

                if (file_exists($filename)) {
                    $share_url = base_url() . product . 'original/' . $image;
                    $i++;
                    break;
                }
                if ($i == 0) {
                    $share_url = base_url() . 'assets/upload/No_Image.png';
                }
            }

            $data['share_url'] = $share_url;

            $array = array(
                'product_id' => "'" . $pro_id . "'"
            );
            $vehicle_features = $this->dbcommon->product_vehicles_extras($pro_id);
            if (!empty($vehicle_features))
                $product[0]->vehicle_features = $vehicle_features;

            $realestate_features = $this->dbcommon->getdetailsinfo('product_realestate_extras', $array);
            if (!empty($realestate_features))
                $product[0]->realestate_features = $realestate_features;

            $car_number = $this->dbcommon->car_mobile_number_product(NULL, NULL, $pro_id, NULL, NULL, 'car_number');
            if (!empty($car_number))
                $product[0]->car_number = $car_number;

            $mobile_number = $this->dbcommon->car_mobile_number_product(NULL, NULL, $pro_id, NULL, NULL, 'mobile_number');
            if (!empty($mobile_number))
                $product[0]->mobile_number = $mobile_number;

            $data["product"] = $product;

            $data["selected"] = ($product[0]->state_name) ? $product[0]->state_name : "Dubai";
            $data["product_is_sold"] = $product[0]->product_is_sold;
            if ($product[0]->admin_modified_at != '0000-00-00 00:00:00')
                $res = strtotime($product[0]->admin_modified_at);
            else
                $res = strtotime($product[0]->product_posted_time);

            $data["posted_on"] = rtrim($this->dbcommon->dateDiff(date('Y-m-d H:i:s', $res), date('Y-m-d H:i:s')), ', ') . ' back';
            $data = array_merge($data, $this->get_elements());

            $breadcrumb = array(
                'Home' => base_url(),
                'My Listing' => base_url() . 'user/my_listing?val=Approve'
            );

            $data['breadcrumbs'] = $breadcrumb;
            $data['page_title'] = $product[0]->product_name;
            $data['is_logged'] = 0;
            if ($this->session->userdata('gen_user')) {
                $data['is_logged'] = 1;
            }
            $this->load->view('user/user_product', $data);
        } else {
            override_404();
        }
    }

    public function add_to_favorites() {
        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user))
            $user_id = $current_user['user_id'];

        $val = $this->input->post("value");
        $product_id = $this->input->post("product_id");
        if (!empty($val) && !empty($product_id)) {
            $check_user_prod = $this->dbcommon->getnumofdetails_("  product_id from product where product_id = $product_id and product_posted_by=$user_id");

            if ($check_user_prod == 0) {
                $check_user_prod = $this->dbcommon->getnumofdetails_(" product_id from product where product_id = $product_id and is_delete=0 and product_is_inappropriate='Approve'");
                if ($check_user_prod > 0) {
                    $query = " select product_total_favorite from product where product_id = $product_id";
                    $product = $this->dbcommon->get_distinct($query);
                    $fav = $product[0]["product_total_favorite"];
                    if ($val == -1) {
                        $fav = $fav - 1;
                        $where = array(
                            'product_id' => $product_id,
                            'user_id' => $user_id
                        );

                        $user = $this->dbcommon->delete('favourite_product', $where);
                    } else {
                        $fav = $fav + 1;
                        $data = array(
                            'product_id' => $product_id,
                            'user_id' => $user_id
                        );
                        $result = $this->dbcommon->insert('favourite_product', $data);
                    }

                    $data = array('product_total_favorite' => $fav);
                    $array = array('product_id' => $product_id);
                    $result = $this->dbcommon->update('product', $array, $data);
                    if ($result) {
                        echo preg_replace('/\s+/', '', "Success");
                    } else {
                        echo "failure";
                    }
                } else {
                    echo "failure";
                }
            } else {
                echo 'Sorry, you can not favorite your own product.';
                //echo json_encode($ret_data);
            }
        } else
            echo "failure";
    }

    public function add_to_like() {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user))
            $user_id = $current_user['user_id'];

        $val = $this->input->post("value");
        $product_id = $this->input->post("product_id");
        if (!empty($val) && !empty($product_id)) {
            $check_user_prod = $this->dbcommon->getnumofdetails_("  product_id from product where product_id = $product_id and product_posted_by=$user_id");

            if ($check_user_prod == 0) {
                $check_user_prod = $this->dbcommon->getnumofdetails_(" product_id from product where product_id = $product_id and is_delete=0 and product_is_inappropriate='Approve'");
                if ($check_user_prod > 0) {
                    $query = " select product_total_likes from product where product_id = $product_id";
                    $product = $this->dbcommon->get_distinct($query);
                    $fav = $product[0]["product_total_likes"];
                    if ($val == -1) {
                        $fav = $fav - 1;
                        $where = array(
                            'product_id' => $product_id,
                            'user_id' => $user_id
                        );
                        $user = $this->dbcommon->delete('like_product', $where);
                    } else {
                        $fav = $fav + 1;
                        $data = array(
                            'product_id' => $product_id,
                            'user_id' => $user_id
                        );
                        $result = $this->dbcommon->insert('like_product', $data);
                    }

                    $data = array('product_total_likes' => $fav);
                    $array = array('product_id' => $product_id);
                    $result = $this->dbcommon->update('product', $array, $data);
                    if ($result) {
                        echo preg_replace('/\s+/', '', "Success");
                    } else {
                        echo "failure";
                    }
                } else {
                    echo "failure";
                }
            } else {
                echo 'Sorry, you can not favorite your own product.';
                //echo json_encode($ret_data);
            }
        } else
            echo 'failure';
    }

    public function check_store_name() {

        $where = ' store_id from store where store_id<>' . (int) $_POST['store_id'] . ' and store_name="' . $_POST['store_name'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_store_name', 'Store name already exists');
            return false;
        } else {
            return true;
        }
    }

    /*
     * Update Store Status as Hold / Active
     * 
     */

    function update_store_status() {

        $store_owner = $this->input->post('user_id', TRUE);
        $store_id = $this->input->post('store_id', TRUE);
        $store_status = $this->input->post('store_status', TRUE);

        $current_user = $this->session->userdata('gen_user');

        if (isset($store_owner) && isset($store_id)) {

            if ($store_status == 3) {
                //hold store

                $up_data = array('store_status' => $store_status);
                $arr = array('store_id' => $store_id,
                    'store_owner' => $store_owner,
                    'store_status' => 0
                );
                $result = $this->dbcommon->update('store', $arr, $up_data);
                $result = $this->dbcommon->update('store_new_details', $arr, $up_data);

                $up_data = array('is_delete' => 3);
                $arr = array('user_id' => $store_owner,
                    'is_delete' => 0,
                    'status' => 'active'
                );
                $result = $this->dbcommon->update('user', $arr, $up_data);

                $up_data = array('is_delete' => 3);
                $arr = array('product_posted_by' => $store_owner,
                    'is_delete' => 0,
                    'product_for' => 'store'
                );
                $result = $this->dbcommon->update('product', $arr, $up_data);
            } else {
                //active store

                $up_data = array('store_status' => $store_status);
                $arr = array('store_id' => $store_id,
                    'store_owner' => $store_owner,
                    'store_status' => 3
                );
                $result = $this->dbcommon->update('store', $arr, $up_data);
                $result = $this->dbcommon->update('store_new_details', $arr, $up_data);

                $up_data = array('is_delete' => 0);
                $arr = array('user_id' => $store_owner,
                    'is_delete' => 3,
                    'status' => 'active'
                );
                $result = $this->dbcommon->update('user', $arr, $up_data);

                $up_data = array('is_delete' => 0);
                $arr = array('product_posted_by' => $store_owner,
                    'is_delete' => 3
                );
                $result = $this->dbcommon->update('product', $arr, $up_data);
            }

            $current_user['is_delete'] = $store_status;
            $current_user['last_login_as'] = $current_user['user_role'];
            $this->session->set_userdata('gen_user', $current_user);

            if (!empty($result))
                echo 'success';
            else
                echo 'fail';
        }
        else {
            override_404();
        }
    }

    function store_2() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'My Store';
        $data['current_user'] = '';

        $currentusr = $this->session->userdata('gen_user');

        if ($currentusr['user_role'] == 'storeUser' && isset($currentusr['last_login_as']) && $currentusr['last_login_as'] == 'storeUser') {

            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';

            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            $query = 'country_id= 4 order by sort_order';
            $data['state_list'] = $this->dbcommon->filter('state', $query);

            $where = " where user_id ='" . $currentusr['user_id'] . "'";
            $current_user = $this->dbcommon->getdetails('user', $where);

            $where = " where store_owner ='" . $currentusr['user_id'] . "'";
            $store = $this->dbcommon->getdetails('store_new_details', $where);

            $where = " where store_owner ='" . $currentusr['user_id'] . "'";
            $__store = $this->dbcommon->getdetails('store', $where);

            $query = ' 0=0 order by cat_order';
            $category = $this->dbcommon->filter('category', $query);

            $query = ' category_id="' . $store[0]->category_id . '" order by sub_cat_order';
            $sub_category = $this->dbcommon->filter('sub_category', $query);

            $data['current_user'] = $current_user;
            $data['store'] = $store;
            $data['__store'] = $__store;
            $data['category1'] = $category;
            $data['sub_categories1'] = $sub_category;

            if (!empty($_POST)):

                $this->form_validation->set_rules('store_name', 'Store Name', 'trim|required|callback_check_store_name|min_length[5]|max_length[20]');
                if ((int) $store[0]->category_id > 0)
                    $this->form_validation->set_rules('store_description', 'Store Description', 'trim|required');

                if ($this->form_validation->run() == FALSE):

                    $this->load->view('user/edit_store', $data);
                else:

                    if ($this->input->post('store_name') == $store[0]->store_name &&
                            $this->input->post('store_description') == $store[0]->store_description &&
                            $this->input->post('meta_title') == $store[0]->meta_title &&
                            $this->input->post('meta_description') == $store[0]->meta_description) {

                        $data['msg'] = 'You have not done any changes for update';
                        $data['msg_class'] = 'alert-success';
                        $this->session->set_flashdata('flash_message', 'You have not done any changes for update');
                        redirect('user/store');
                    } else {

                        $array = array('store_id' => $store[0]->store_id);

                        $data = array(
                            'store_name' => $_POST['store_name'],
                            'store_description' => ((int) $store[0]->category_id > 0) ? $_POST['store_description'] : '',
                            'store_modified_on' => date('Y-m-d H:i:s'),
                            'meta_title' => $_POST['meta_title'],
                            'meta_description' => $_POST['meta_description']
                        );

                        $result = $this->dbcommon->update('store_new_details', $array, $data);

                        $data = array('new_data_status' => 1, 'store_details_verified' => 0);
                        $result = $this->dbcommon->update('store', $array, $data);

                        if ($result):
//                            $this->session->set_flashdata('flash_message','Store details updated successfully.');
                            $this->session->set_flashdata('flash_message', 'Your new details will be visible in store once it\'s approved by admin.');
                            redirect('user/store');
                        else:
                            $data['msg'] = 'Store not added, Please try again';
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('user/edit_store', $data);
                        endif;
                    }
                endif;
            else:
                $this->load->view('user/edit_store', $data);
            endif;
        }
        else {
            override_404();
        }
    }

    function store() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'My Store';
        $data['current_user'] = '';

        $currentusr = $this->session->userdata('gen_user');

        if ($currentusr['user_role'] == 'storeUser' && isset($currentusr['last_login_as']) && $currentusr['last_login_as'] == 'storeUser') {

            $data['is_logged'] = 0;
            $data['loggedin_user'] = '';

            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }

            $query = 'country_id= 4 order by sort_order';
            $data['state_list'] = $this->dbcommon->filter('state', $query);

            $where = " where user_id ='" . $currentusr['user_id'] . "'";
            $current_user = $this->dbcommon->getdetails('user', $where);

            $where = " where store_owner ='" . $currentusr['user_id'] . "'";
            $store = $this->dbcommon->getdetails('store_new_details', $where);

            if (isset($store) && sizeof($store) > 0) {

                $where = " where store_owner ='" . $currentusr['user_id'] . "'";
                $__store = $this->dbcommon->getdetails('store', $where);

                $query = ' FIND_IN_SET(1, category_type) > 0 order by cat_order';
                $category = $this->dbcommon->filter('category', $query);

                $query = ' category_id="' . $store[0]->category_id . '" AND FIND_IN_SET(1, sub_category_type) > 0 order by sub_cat_order';
                $sub_category = $this->dbcommon->filter('sub_category', $query);

                $data['current_user'] = $current_user;
                $data['store'] = $store;
                $data['__store'] = $__store;
                $data['category1'] = $category;
                $data['sub_categories1'] = $sub_category;
//            echo '<pre>';
//            print_r($data);exit;

                if (!empty($_POST)):
//                echo '<pre>';
//                print_r($_POST); exit;

                    $this->form_validation->set_rules('store_name', 'Store Name', 'trim|required|callback_check_store_name|min_length[5]|max_length[20]');
                    if ((int) $store[0]->category_id > 0)
                        $this->form_validation->set_rules('store_description', 'Store Description', 'trim|required');

                    if ($this->form_validation->run() == FALSE):

                        $this->load->view('user/edit_store', $data);
                    else:

//                        if ($this->input->post('paypal_email_id') == $data['current_user'][0]->paypal_email_id &&
//                                $this->input->post('store_name') == $store[0]->store_name &&
//                                $this->input->post('store_description') == $store[0]->store_description &&
//                                $this->input->post('meta_title') == $store[0]->meta_title &&
//                                $this->input->post('meta_description') == $store[0]->meta_description) {
                        if ($this->input->post('store_name') == $store[0]->store_name &&
                                $this->input->post('store_description') == $store[0]->store_description &&
                                $this->input->post('meta_title') == $store[0]->meta_title &&
                                $this->input->post('meta_description') == $store[0]->meta_description) {

                            $data['msg'] = 'You have not done any changes for update';
                            $data['msg_class'] = 'alert-success';
                            $this->session->set_flashdata('flash_message', 'You have not done any changes for update');
                            redirect('user/store');
                        } else {

                            $array = array('store_id' => $store[0]->store_id);
                            $user_idarray = array('user_id' => $currentusr['user_id']);

                            $data = array(
                                'store_name' => $_POST['store_name'],
//                            'store_description' => ((int)$store[0]->category_id>0) ? $_POST['store_description'] : '',
                                'store_modified_on' => date('Y-m-d H:i:s'),
                                'meta_title' => $_POST['meta_title'],
                                'meta_description' => $_POST['meta_description']
                            );
                            if (isset($_POST['store_description'])) {
                                $data['store_description'] = $_POST['store_description'];
                            }
                            if (isset($_POST['category_id'])) {
                                $data['category_id'] = $_POST['category_id'];
                            }
                            if (isset($_POST['sub_category_id'])) {
                                $data['sub_category_id'] = $_POST['sub_category_id'];
                            }
                            if (isset($_POST['webiste_link'])) {
                                $data['website_url'] = $_POST['webiste_link'];
                            }
//                            if (isset($_POST['paypal_email_id'])) {
//                                $data_user['paypal_email_id'] = $_POST['paypal_email_id'];
//                            }

                            $result = $this->dbcommon->update('store_new_details', $array, $data);
//                            $result = $this->dbcommon->update('user', $user_idarray, $data_user);
                            if ($current_user[0]->is_delete == 0) {
                                $data = array('new_data_status' => 1, 'store_details_verified' => 0);
                            } else {
                                $data['new_data_status'] = 1;
                                $data['store_details_verified'] = 0;
                            }

//                        echo '<pre>';
//                        print_r($data); exit;
                            $result = $this->dbcommon->update('store', $array, $data);
                            if ($current_user[0]->is_delete > 0) {
                                $array2 = array('user_id' => $current_user[0]->user_id);
                                $update_user['is_delete'] = 0;
                                $res2 = $this->dbcommon->update('user', $array2, $update_user);
                                $_SESSION['gen_user']['is_delete'] = 0;
                            }

                            if ($result):
//                            $this->session->set_flashdata('flash_message','Store details updated successfully.');
                                $this->session->set_flashdata('flash_message', 'Your new details will be visible in store once it\'s approved by admin.');
                                redirect('user/store');
                            else:
                                $data['msg'] = 'Store not added, Please try again';
                                $data['msg_class'] = 'alert-info';
                                $this->load->view('user/edit_store', $data);
                            endif;
                        }
                    endif;
                else:
                    $this->load->view('user/edit_store', $data);
                endif;
            } else {
                redirect('login/create_store');
            }
        } else {
            override_404();
        }
    }

    public function store_cover_upload() {

        $picture = '';
        $target_dir = document_root . store_cover;
        $profile_picture = $_FILES['file']['name'];
        $ext = explode(".", $_FILES["file"]['name']);
        $store_cover_image = time() . "." . end($ext);
        $target_file = $target_dir . "original/" . $store_cover_image;
        $uploadOk = 1;

        $currentusr = $this->session->userdata('gen_user');

        $where = " where store_owner ='" . $currentusr['user_id'] . "'";
        $store = $this->dbcommon->getdetails('store', $where);

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

            $this->load->library('thumbnailer');
            $this->thumbnailer->prepare($target_file);
            list($width, $height, $type, $attr) = getimagesize($target_file);

            $thumb = $target_dir . "small/" . $store_cover_image;
            $this->dbcommon->crop_store_cover_image($target_file, store_cover_small_thumb_width, store_cover_small_thumb_height, $thumb, 'small', $store_cover_image);

            $thumb = $target_dir . "medium/" . $store_cover_image;
            $this->dbcommon->crop_store_cover_image($target_file, store_cover_medium_thumb_width, store_cover_medium_thumb_height, $thumb, 'medium', $store_cover_image);

            $array1 = array('store_owner' => $store[0]->store_owner);
            $up_data = array('store_cover_image' => $store_cover_image,
                'store_modified_on' => date('Y-m-d H:i:s'));

            $result = $this->dbcommon->update('store_new_details', $array1, $up_data);

            $array1 = array('store_id' => $store[0]->store_id);
            $up_data = array('new_data_status' => 1,
                'store_details_verified' => 0);

            $result = $this->dbcommon->update('store', $array1, $up_data);

            if (isset($result))
                echo $store_cover_image;
        }
        exit;
    }

    public function update_shipping_cost() {

        if (isset($_POST['shipping_cost']) && !empty($_POST['shipping_cost'])) {

            $query = 'country_id= 4 order by sort_order';
            $state_list = $this->dbcommon->filter('state', $query);

            $current_user = $this->session->userdata('gen_user');
            $user_id = $current_user['user_id'];

            $wh = array('store_owner' => $user_id);
            $data = array('shipping_cost' => $_POST['shipping_cost']);
            $this->dbcommon->update('store', $wh, $data);

            //        $state_count = count($state_list);
            //        foreach ($state_list as $state) {
            //            $shipping_cost = $this->input->post('state_' . $state['state_id']);
            //
    //            $query = ' where seller_id=' . $user_id . ' and state_id=' . $state['state_id'];
            //            $shipping = $this->dbcommon->getrowdetails('seller_shipping_cost', $query);
            //
    //            $data = array('shipping_cost' => $shipping_cost);
            //
    //            if (isset($shipping) && sizeof($shipping) > 0) {
            //
    //                $data['updated_date'] = date('y-m-d H:i:s');
            //                $wh = array('state_id' => $state['state_id'], 'seller_id' => $user_id);
            //
    //                $this->dbcommon->update('seller_shipping_cost', $wh, $data);
            //            } else {
            //                $data['state_id'] = $state['state_id'];
            //                $data['seller_id'] = $user_id;
            //
    //                $this->dbcommon->insert('seller_shipping_cost', $data);
            //            }
            //        }

            $this->session->set_flashdata('flash_message', 'Shipping Cost Updated Successfully');
        }
        redirect('user/store');
    }

    function orders($type = NULL, $ord_oth_status = NULL) {

        if (isset($type) && !empty($type) && in_array($type, array('bought', 'sold'))) {

            $current_user = $this->session->userdata('gen_user');
            if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'generalUser' && $type == 'sold') {
                redirect('user/index');
            } elseif (isset($current_user['user_role']) && $current_user['user_role'] != 'storeUser' && $type == 'sold') {
                redirect('user/index');
            }

            $data = array();
            $data = array_merge($data, $this->get_elements());

            if ($type == 'sold')
                $data['page_title'] = 'Sold Ads';
            else
                $data['page_title'] = 'Bought Ads';

            $total_product = $this->dbcart->orders_count($type, 'front');
            if ($ord_oth_status != NULL)
                $url = base_url() . 'user/orders/' . $type . '/' . $ord_oth_status;
            else
                $url = base_url() . 'user/orders/' . $type;

            $config = array();
            $config["base_url"] = $url;
            $config["total_rows"] = $total_product;
            $config["per_page"] = 15;
            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';
            $config['use_page_numbers'] = TRUE;
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = '&lt;&lt;';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = '&gt;&gt;';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li><p>';
            $config['cur_tag_close'] = '</p></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);

            $data["links"] = $this->pagination->create_links();

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $config['per_page'];

            $data['orders'] = $this->dbcart->orders($offset, $config['per_page'], NULL, $type, 'front');

            $this->load->view('user/store_user_orders', $data);
        }
        else {
            override_404();
        }
    }

    function order_list($order_id = NULL) {
        $data = array();
        if (isset($order_id) && !empty($order_id)) {
            $data = array_merge($data, $this->get_elements());

            $data['products'] = $this->dbcart->order_products($order_id);
            $current_user = $this->session->userdata('gen_user');

            $wh_ord = ' * from orders where id=' . $order_id . ' and is_delete=0 and (user_id=' . $current_user['user_id'] . ' or seller_id=' . $current_user['user_id'] . ')';

            $order_details = $this->dbcommon->getdetails_($wh_ord);

            if (!empty($order_details)) {
                $data['order_details'] = $order_details;

                $data['page_title'] = $order_details[0]->order_number . ' \'s Details';

                $wh_buyer = ' * from shipping_address where id=' . $order_details[0]->address_id . ' and user_id=' . $order_details[0]->user_id;
                $data['buyer_details'] = $this->dbcommon->getdetails_($wh_buyer);

                $wh_seller = ' * from user where user_id=' . $order_details[0]->seller_id;
                $data['seller_image'] = $this->dbcommon->getdetails_($wh_seller);

                $wh_seller = ' * from store where store_owner=' . $order_details[0]->seller_id;
                $data['seller_details'] = $this->dbcommon->getdetails_($wh_seller);

                $this->load->view('user/order_product_list', $data);
            } else
                override_404();
        } else {
            override_404();
        }
    }

    function order_update() {

        $current_user = $this->session->userdata('gen_user');

        $order_id = $this->input->post('order_id');
        $status = $this->input->post('status');

        $up_data = array('status' => $status,
            'modified_date' => date('Y-m-d H:i:s'),
            'modified_by' => $current_user['user_id']
        );

        $arr = array('id = ' . $order_id . ' AND ' . '(seller_id = ' . $current_user['user_id'] . ' OR user_id = ' . $current_user['user_id'] . ') AND is_delete = 0');
        $result = $this->dbcommon->update('orders', $arr, $up_data);

        if ($status == 'canceled') {
            $payment_data = array('order_id' => $order_id, 'response_code' => PAY_TABS_PAGE_PAYMENT_SUCCESS);
            $payment_details = $this->dbcommon->getdetailsinfo('paytabs_payment', $payment_data);
            if (isset($payment_details) && sizeof($payment_details) > 0) {
                $this->load->library('Paytab');
                $refund_req_data = array(
                    'paypage_id' => $payment_details->pt_invoice_id,
                    'reference_number' => $payment_details->reference_no,
                    'refund_amount' => $payment_details->amount,
                    'refund_reason' => ($current_user['user_role'] == 'storeUser') ? 'Seller canceled Order' : 'Buyer canceled Order',
                    'transaction_id' => $payment_details->transaction_id,
                );
                $response = $this->paytab->refund_process($refund_req_data);

                $in_data = array(
                    'result' => $response->result,
                    'response_code' => $response->response_code,
                    'pt_invoice_id' => $payment_details->pt_invoice_id,
                    'amount' => $payment_details->amount,
                    'currency' => $payment_details->currency,
                    'reference_no' => $payment_details->reference_no,
                    'transaction_id' => $payment_details->transaction_id,
                    'created_date' => date('Y-m-d H:i:s'),
                    'user_id' => $payment_details->user_id,
                    'order_id' => $payment_details->order_id,
                    'created_by' => $current_user['user_id']
                );
                $this->dbcommon->insert('paytabs_payment', $in_data);

                $up_data = array('status' => 2);
                $arr = array('order_id' => $order_id, 'status' => 1);
                $this->dbcommon->update('balance', $arr, $up_data);
            }
            $product_list = $this->dbcart->order_products($order_id);

            if (isset($product_list) && sizeof($product_list) > 0) {
                foreach ($product_list as $prod) {
                    $this->db->query('update product set stock_availability = stock_availability + ' . $prod['quantity'] . ' where product_id=' . $prod['product_id'] . ' and product_posted_by=' . $current_user['user_id']);
                }
            }
        }

        if (isset($result)) {

            $in_data = array('order_id' => $order_id,
                'status' => $status,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $current_user['user_id']
            );

            $this->dbcommon->insert('order_status', $in_data);
            $this->session->set_flashdata(array('msg' => 'Order Status updated successfully.', 'class' => 'alert-info'));
        } else {
            $this->session->set_flashdata(array('msg' => 'Order Status not updated.', 'class' => 'alert-info'));
        }
        redirect('user/order_list/' . $order_id);
    }

    function delete_order() {

        $current_user = $this->session->userdata('gen_user');

        $order_id = $this->input->post('order_id');
        if (isset($order_id)) {
            $result = $this->db->query('UPDATE orders SET is_delete = 1, modified_date = "' . date('Y-m-d H:i:s') . '", `modified_by` = "' . $current_user['user_id'] . '"
                                    WHERE seller_id = "' . $current_user['user_id'] . '"
                                    AND `is_delete` =0
                                    AND `id` = "' . $order_id . '"
                                    AND DATE_FORMAT(modified_date,"%y-%m-%d") < (CURDATE() - INTERVAL 7 DAY )');


            if (isset($result))
                echo 'success';
            else
                echo 'failure';
            exit;
        } else {
            override_404();
        }
    }

    function crop_image_upload() {
        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];
        $files_arr = array();
        $files_arr = $_FILES;

        $extension = explode(".", $_FILES['cropped_image']['name']);
        $picture = time() . "." . end($extension);
        $target_dir = document_root . profile;
        $original_target_file = $target_dir . "original/" . $picture;
        $medium_target_file = $target_dir . "medium/" . $picture;
        $small_target_file = $target_dir . "small/" . $picture;
        $success = 0;

        $_FILES['cropped_image']['name'];
        if (move_uploaded_file($_FILES['cropped_image']['tmp_name'], $original_target_file)) {
            $success++;
        }

        if (move_uploaded_file($_FILES['cropped_image_100']['tmp_name'], $medium_target_file)) {
            
        }
        if (move_uploaded_file($_FILES['cropped_image_50']['tmp_name'], $small_target_file)) {
            
        }

        if ($success > 0) {
            $data = array('profile_picture' => $picture);
            $array = array('user_id' => $user_id);
            $result = $this->dbcommon->update('user', $array, $data);

            if (isset($result))
                echo json_encode('success');
            else
                echo json_encode('fail');
        }
        else {
            echo json_encode('fail');
        }
        exit;
    }

    function delete_account() {

        $current_user = $this->session->userdata('gen_user');
        if (isset($_POST["delete"])) {

            $user_data = array('is_delete' => 1);

            $array = array('user_id' => $current_user['user_id']);
            $this->dbcommon->update('user', $array, $user_data);

            $pro_array = array('product_posted_by' => $current_user['user_id']);
            $this->dbcommon->update('product', $pro_array, $user_data);

            $user_data = array('store_status' => 1);
            $user_array = array('store_owner' => $current_user['user_id']);
            $this->dbcommon->update('store', $user_array, $user_data);

            redirect('login/signout');
            exit;
        }
    }

    function followers() {

        $data = array();
        $data = array_merge($data, $this->get_elements());

        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];
        $data['user_id'] = $user_id;
        $data['my_followers'] = 'yes';

        $myfollowers = $this->dbcommon->get_myfollowerslist($user_id, $start = 0, $limit = 25);
        $total_followers = $this->dbcommon->get_myfollowers_count($user_id);

        $data['hide'] = "false";
        if ($total_followers <= 25)
            $data['hide'] = "true";

        $data['page_title'] = 'My Followers (' . $total_followers . ')';
        $data['myfollowers'] = $myfollowers;

        $this->load->view('home/followers', $data);
    }

    function following() {
        $data = array();
        $data = array_merge($data, $this->get_elements());

        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];
        $data['user_id'] = $user_id;
        $data['following'] = 'yes';

        $myfollowers = $this->dbcommon->get_myfollowerslist($user_id, $start = 0, $limit = 25, 'following');
        $total_followers = $this->dbcommon->get_myfollowers_count($user_id, 'following');
        $data['hide'] = "false";
        if ($total_followers <= 25)
            $data['hide'] = "true";

        $data['following_page'] = 'yes';
        $data['page_title'] = 'You are following to ' . $total_followers . ' users';
        $data['myfollowers'] = $myfollowers;

        $this->load->view('home/followers', $data);
    }

    public function thank_you() {
        $data['page_title'] = 'Thank You';

//        if(!isset($_SESSION['general_user_add_posted'])){
//            redirect('user/my_listing?val=NeedReview');
//        }
        $data = array_merge($data, $this->get_elements());
//        unset($_SESSION['general_user_add_posted']);
        $this->load->view('user/thank_you', $data);
    }

    function send_payment_request() {

        $success = 0;
        $email_id = SITE_ADMIN_EMAIL;
//        $email_id = 'kek@narola.email';
        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];

        if (isset($current_user) && isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
            $this->db->select('SUM(b.store_amount) AS store_balance, GROUP_CONCAT(b.id) balance_ids, s.store_name');
            $this->db->join('orders o', 'o.id = b.order_id', 'LEFT');
            $this->db->join('store s', 's.store_owner = b.store_owner', 'LEFT');
            $this->db->where('o.status', 'completed');
            $this->db->where('o.is_delete', 0);
            $this->db->where('o.delivery_type', 'PREPAID');
            $this->db->where('o.id = b.order_id');
            $this->db->where('b.store_owner', $user_id);
            $this->db->where('b.status', 1);
            $this->db->group_by('o.id');

            $query = $this->db->get('balance b');
            $balance = $query->row_array();

            if (isset($balance) && $balance['store_balance'] > 0)
                $amount = number_format($balance['store_balance'], 2);
            else
                $amount = 0.00;

            $button_label = 'Update Payment Status';
            $title = 'Payment Request';
            $store_name = $balance['store_name'];
            $button_link = base_url() . 'admin/users/e_wallet/?userid=' . $user_id;

            $count_of_peding_request = $this->dbcommon->getnumofdetails_(' * FROM e_wallet_request_response WHERE store_owner = ' . $user_id . ' AND status = 0');

            if ($count_of_peding_request == 0) {
                $in_wallet_data = array(
                    'store_owner' => $user_id,
                    'amount' => $amount,
                    'status' => 0,
                    'balance_ids' => $balance['balance_ids'],
                    'created_by' => $user_id,
                    'created_date' => date('Y-m-d H:i:s')
                );
                $result = $this->dbcommon->insert('e_wallet_request_response', $in_wallet_data);

                $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;">                        
                        <h3>Payment Request</h3>
                                        <p style="margin: 1em 0;">
                                        Hello Admin,
                                        </p>
                                        <p style="margin: 1em 0;">
                                        ' . $store_name . ' has sent request for AED ' . $amount . '
                                        </p>
    <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:240px; " href="' . $button_link . '">' . $button_label . '</a></div>';

                $new_data = $this->dbcommon->mail_format($title, $content);
                send_mail($email_id, $title, $new_data, 'info@doukani.com');

                $success++;
            }
        }
        if ($success > 0) {
            $this->session->set_flashdata('flash_message', 'E-wallet Payment Request sent successfuly.');
        } else {
            $this->session->set_flashdata('flash_message', 'E-wallet Payment Request not sent.');
        }

        redirect('user/index');
    }

    /*
     * Send Request to admin that Classified user has sent Request to make store user
     */

    function send_store_details() {
//        pr($_POST);
//        die();
        if ($this->input->post()) {
            $success = 0;
            $email_id = SITE_ADMIN_EMAIL;
//            $email_id = 'kek@narola.email';

            $current_user = $this->session->userdata('gen_user');
            $user_id = $current_user['user_id'];

            $where = 'user_id=' . $user_id . ' AND status <> 1';
            $store_request_status = $this->dbcommon->filter('store_request', $where);
            if (isset($store_request_status) && sizeof($store_request_status) > 0) {
                $this->session->set_flashdata('flash_message', 'Request not sent.');
            } else {
                $store_name = $this->input->post('store_name', TRUE);
                $store_description = $this->input->post('store_description', TRUE);
                $store_domain = $this->input->post('store_domain', TRUE);
                $website_url = $this->input->post('website_url', TRUE);
                $category_id = $this->input->post('category_id', TRUE);
                $sub_category_id = $this->input->post('sub_category_id', TRUE);

                $in_data = array(
                    'user_id' => $user_id,
                    'store_name' => $store_name,
                    'store_description' => (isset($category_id) && (int) $category_id > 0) ? $store_description : '',
                    'store_domain' => $store_domain,
                    'website_url' => (isset($category_id) && (int) $category_id == 0) ? $website_url : '',
                    'category_id' => $category_id,
                    'sub_category_id' => (isset($category_id) && (int) $category_id > 0) ? $sub_category_id : 0,
                    'status' => 0,
                    'created_date' => date('Y-m-d H:i:s')
                );
                $result = $this->dbcommon->insert('store_request', $in_data);
                $title = 'Classified user has sent request to make Store.';
                $button_label = 'Page Link';
                $button_link = base_url() . 'admin/users/edit_store_request/' . $user_id;

                $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;">                        
                        <h3>Request</h3>
                                        <p style="margin: 1em 0;">
                                        Hello Admin,
                                        </p>
                                        <p style="margin: 1em 0;">
                                        ' . $current_user['email_id'] . ' classified user has sent request to make him/her as store user.</p>
        <a style = "background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:240px; " href = "' . $button_link . '">' . $button_label . '</a></div>';

                $new_data = $this->dbcommon->mail_format($title, $content);
                send_mail($email_id, $title, $new_data, 'info@doukani.com');

                $this->session->set_flashdata('flash_message', 'Request sent successfully.');
            }
            redirect('user/index');
        }
    }

}

?>