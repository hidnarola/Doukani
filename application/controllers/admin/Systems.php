<?php

class Systems extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dashboard', '', TRUE);
        $this->load->model('dbuser', '', TRUE);
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('email');
        $this->per_page = 10;
    }

    public function get_user_ads() {

        $query_settings = ' id=3 and `key`="no_of_post_month_classified_user" limit 1';
        $classified = $this->dbcommon->filter('settings', $query_settings);

        if ((int) $classified[0]['val'] > 0)
            $cnt_ads_classified = $classified[0]['val'];
        else
            $cnt_ads_classified = default_no_of_ads;

        // echo 'classi:'.$cnt_ads_classified ;
        // echo '<br>';
        $query_settings = ' id=11 and `key`="no_of_post_month_offer_user" limit 1';
        $offer = $this->dbcommon->filter('settings', $query_settings);

        if ((int) $offer[0]['val'] > 0)
            $cnt_ads_offer = $offer[0]['val'];
        else
            $cnt_ads_offer = default_no_of_ads;

        // echo 'offer:'.$cnt_ads_offer;
        // echo '<br>';
        $query_settings = ' id=9 and `key`="no_of_post_month_store_user" limit 1';
        $store = $this->dbcommon->filter('settings', $query_settings);

        if ((int) $store[0]['val'] > 0)
            $cnt_ads_store = $store[0]['val'];
        else
            $cnt_ads_store = default_no_of_ads;
        // echo 'store:'.$cnt_ads_store; 
        // echo '<br>';        
        $where = " 1=1";
        $result = $this->dbcommon->filter('user', $where);
        $up_data = array();

        foreach ($result as $res) {
            if ($res['user_role'] == 'generalUser' || $res['user_role'] == 'storeUser' || $res['user_role'] == 'offerUser') {

                // echo 'UserID==='.$res['user_id'].'==== Role: ===='.$res['user_role'].'====LEft Ads ===='.$res[ 'userAdsLeft'].'====Total Ads===='.$res['userTotalAds'];
                // echo '<br>';

                $cnt = 0;

                if ($res['user_role'] == 'generalUser') {

                    // 25 40
                    if ($cnt_ads_classified != $res['userTotalAds']) {
                        $cnt = 1;
                        if ($cnt_ads_classified > $res['userTotalAds']) {
                            $total_ads = $cnt_ads_classified;

                            $minus = 0;
                            $minus = $cnt_ads_classified - $res['userTotalAds'];
                            $left_ads = $res['userAdsLeft'] + $minus;
                        } else {

                            $total_ads = $cnt_ads_classified;
                            $usedAds = $res['userTotalAds'] - $res['userAdsLeft'];

                            $left = $cnt_ads_classified - $res['userAdsLeft'];
                            if ($left > 0) {
                                $left_ads = $res['userAdsLeft'] + $left;
                            } else {
                                $left_ = $cnt_ads_classified - $usedAds;
                                $left_ads = ($left_ > 0) ? $left_ : 0;
                            }
                        }
                    }
                } elseif ($res['user_role'] == 'storeUser') {

                    if ($cnt_ads_store != $res['userTotalAds']) {
                        $cnt = 1;

                        if ($cnt_ads_store > $res['userTotalAds']) {
                            $total_ads = $cnt_ads_store;

                            $minus = 0;
                            $minus = $cnt_ads_store - $res['userTotalAds'];
                            $left_ads = $res['userAdsLeft'] + $minus;
                        } else {

                            $total_ads = $cnt_ads_store;
                            $left = $cnt_ads_store - $res['userAdsLeft'];

                            $usedAds = $res['userTotalAds'] - $res['userAdsLeft'];

                            if ($left > 0) {
                                $left_ads = $res['userAdsLeft'] + $left;
                            } else {
                                $left_ = $cnt_ads_store - $usedAds;
                                $left_ads = ($left_ > 0) ? $left_ : 0;
                            }
                        }
                    }
                } elseif ($res['user_role'] == 'offerUser') {
                    if ($cnt_ads_offer != $res['userTotalAds']) {
                        $cnt = 1;

                        if ($cnt_ads_offer > $res['userTotalAds']) {
                            $total_ads = $cnt_ads_offer;

                            $minus = 0;
                            $minus = $cnt_ads_offer - $res['userTotalAds'];
                            $left_ads = $res['userAdsLeft'] + $minus;
                        } else {

                            $total_ads = $cnt_ads_offer;
                            $usedAds = $res['userTotalAds'] - $res['userAdsLeft'];
                            $left = $cnt_ads_offer - $res['userAdsLeft'];

                            if ($left > 0) {
                                $left_ads = $res['userAdsLeft'] + $left;
                            } else {
                                $left_ = $cnt_ads_offer - $usedAds;
                                $left_ads = ($left_ > 0) ? $left_ : 0;
                            }
                        }
                    }
                }

                if ($cnt == 1) {
                    $up_data[] = array('user_id' => $res['user_id'], 'userTotalAds' => $total_ads, 'userAdsLeft' => $left_ads);
                }
            }
        }

        if (isset($up_data) && sizeof($up_data) > 0) {
            ini_set('memory_limit', '-1');
            $this->db->update_batch('user', $up_data, 'user_id');
        }
    }

// Manage Country function
    public function location() {
        $data = array();
        $data['page_title'] = 'Country List';
        $config['base_url'] = site_url() . 'admin/Systems/location';
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $config['per_page'] = 10;
        $query = ' country_id from country';

        $config['total_rows'] = $this->dbcommon->getnumofdetails_($query);

        $query = " 1=1 order by country_name  limit " . $page . " ," . $config['per_page'];
        $category = $this->dbcommon->filter('country', $query);
        $data['country'] = $category;
        $data['total_records'] = $config['total_rows'];

        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/country/index', $data);
    }

    public function location_add() {
        $data = array();
        $data['page_title'] = 'Add Country';
        $user = $this->session->userdata('user');
        if (!empty($_POST)):
            // validation 
            $this->form_validation->set_rules('country_name', 'Category Name', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $data['msg'] = "Please fill all required fields";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/country/index', $data);
            else:
                $data = array(
                    'country_name' => $_POST['country_name']
                );
                $result = $this->dbcommon->insert('country', $data);
                if ($result):
                    $this->session->set_flashdata(array('msg' => 'Country added successfully.', 'class' => 'alert-success'));
                    redirect('admin/systems/location');
                else:
                    $data['msg'] = 'Country not added, Please try again';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/country/index', $data);
                endif;
            endif;
        else:
            $this->load->view('admin/country/index');
        endif;
    }

    public function location_edit($country_id = null) {
        $data = array();
        $data['page_title'] = 'Edit Country';
        $where = " where country_id='" . $country_id . "'";
        $country = $this->dbcommon->getdetails('country', $where);
        if ($country_id != null && !empty($country)):
            $data['country'] = $country;
            if (!empty($_POST)):
                $this->form_validation->set_rules('country_name', 'Category Name', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
                    $data['msg'] = "Please fill all required fields";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/country/edit', $data);
                else:

                    $data = array(
                        'country_name' => $_POST['country_name']
                    );
                    $array = array('country_id' => $country[0]->country_id);
                    $result = $this->dbcommon->update('country', $array, $data);
                    if ($result):
                        $this->session->set_flashdata(array('msg' => 'Country updated successfully.', 'class' => 'alert-success'));
                        redirect('admin/systems/location');
                    else:
                        $data['msg'] = 'Country not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/systems/edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/country/edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Country not found', 'class' => 'alert-info'));
            redirect('admin/systems/location');
        endif;
    }

    public function location_delete($country_id = null) {

        $data = array();
        $wh = " * from state where country_id='" . $country_id . "'";
        $res = $this->dbcommon->getnumofdetails_($wh);

        if ($res == 0):
            $where = " where country_id='" . $country_id . "'";
            $category = $this->dbcommon->getdetails('country', $where);
            if ($country_id != null && !empty($category)):
                $where = array("country_id" => $country_id);
                $user = $this->dbcommon->delete('country', $where);

                $this->session->set_flashdata(array('msg' => 'Country deleted successfully', 'class' => 'alert-success'));
                redirect('admin/systems/location');
            else:
                $this->session->set_flashdata(array('msg' => 'Country not found', 'class' => 'alert-info'));
                redirect('admin/systems/location');
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Emirate having this Country, You can not delete this Country ', 'class' => 'alert-info'));
            redirect('admin/systems/location');
        endif;
    }

// Manage State/Emirates Functions
    public function emirates($country_id = null) {

        $data = array();
        $data['page_title'] = 'Emirates List';
        $config['base_url'] = site_url() . 'admin/Systems/emirates/' . $country_id;
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $url = site_url() . 'admin/systems/emirates';
        $where = ' state_id from state where ';
        $where .= "country_id='" . $country_id . "'";

        $pagination_data = $this->dbcommon->pagination($url, $where, $this->per_page, 'yes');
        $data['total_records'] = $pagination_data['total_rows'];

        $where = '';
        $where = "country_id='" . $country_id . "'  order by sort_order limit " . $page . " ," . $config['per_page'];
        $category = $this->dbcommon->filter('state', $where);

        if ($country_id != null && !empty($category)):
            $data['country'] = $category;
        endif;
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $data['country_id'] = $country_id;
        $this->load->view('admin/country/emirates_index', $data);
    }

    public function emirates_add() {
        $data = array();
        $data['page_title'] = 'Add Emirate';
        $user = $this->session->userdata('user');
        if (!empty($_POST)):
            // validation 
            $this->form_validation->set_rules('state_name', 'Category Name', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $data['msg'] = "Please fill all required fields";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/country/emirates_index', $data);
            else:
                $data = array(
                    'state_name' => $_POST['state_name'],
                    'country_id' => $_POST['country_id']
                );
                $result = $this->dbcommon->insert('state', $data);
                if ($result):
                    $this->session->set_flashdata(array('msg' => 'Emirate added successfully', 'class' => 'alert-success'));
                    redirect('admin/systems/emirates/' . $_POST['country_id']);
                else:
                    $data['msg'] = 'Emirate not added, Please try again';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/country/emirates_index', $data);
                endif;
            endif;
        else:
            $this->load->view('admin/country/emirates_index');
        endif;
    }

    public function emirates_edit($state_id = null) {
        $data = array();
        $data['page_title'] = 'Edit Emirate';
        $where = " where state_id='" . $state_id . "'";
        $country = $this->dbcommon->getdetails('state', $where);
        if ($state_id != null && !empty($country)):
            $data['country'] = $country;
            if (!empty($_POST)):
                $this->form_validation->set_rules('state_name', 'Category Name', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
                    $data['msg'] = "Please fill all required fields";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/country/emirates_edit', $data);
                else:

                    $data = array(
                        'state_name' => $_POST['state_name']
                    );
                    $array = array('state_id' => $country[0]->state_id);
                    $result = $this->dbcommon->update('state', $array, $data);
                    if ($result):
                        $this->session->set_flashdata(array('msg' => 'Emirate updated successfully', 'class' => 'alert-success'));
                        redirect('admin/systems/emirates/' . $country[0]->country_id);
                    else:
                        $data['msg'] = 'Emirate not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/country/emirates_edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/country/emirates_edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Emirate not found', 'class' => 'alert-info'));
            redirect('admin/systems/location');
        endif;
    }

    public function emirates_delete($state_id = null) {

        $data = array();
        $where = " where state_id='" . $state_id . "'";
        $country = $this->dbcommon->getdetails('state', $where);
        if ($state_id != null && !empty($country)):
            $where = array("state_id" => $state_id);
            $user = $this->dbcommon->delete('state', $where);

            $this->session->set_flashdata(array('msg' => 'Emirate deleted successfully', 'class' => 'alert-success'));
            redirect('admin/systems/emirates/' . $country[0]->country_id);
        else:
            $this->session->set_flashdata(array('msg' => 'Emirate not found', 'class' => 'alert-info'));
            redirect('admin/systems/emirates/' . $country[0]->country_id);
        endif;
    }

//   Manage Accounts Function
    public function accounts() {

        $data = array();
        $data['page_title'] = 'Admin List';
        $config['base_url'] = site_url() . 'admin/Systems/accounts';

        $url = site_url() . 'admin/systems/accounts';
        $user = $this->session->userdata('user');
        $where = "user_id from user  where user_role = 'admin' and is_delete in (0,4)";

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        $pagination_data = $this->dbcommon->pagination($url, $where, $per_page, 'yes');
        $data['url'] = $url;
        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

        $where = "where user_role = 'admin' and is_delete in (0,4) limit " . $offset . ',' . $per_page;

        $users = $this->dblogin->select($where);
        $data['users'] = $users;

        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;

        $this->load->view('admin/accounts/index', $data);
    }

    public function accounts_add() {

        $data = array();
        $data['page_title'] = 'Add Admin';
        $user = $this->session->userdata('user');

        $where = "country_id=4";
        $data['state'] = $this->dbcommon->filter('state', $where);

        if (!empty($_POST)) {

            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[30]|alpha_numeric');

            if ($this->input->post('nick_name') != '')
                $this->form_validation->set_rules('nick_name', 'Nickname', 'min_length[3]|max_length[30]|alpha_numeric');

            $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('phone', 'Phone No.', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/accounts/add', $data);
            } else {

                $where = " where email_id='" . addslashes($_POST['email_id']) . "' or username='" . $_POST['username'] . "'";
                $user = $this->dblogin->isExist($where);
                if (empty($user)) {
                    for ($i = 0; $i <= 11; $i++) {
                        if (isset($_POST['chk_' . $i])) {
                            $permission[] = $_POST['chk_' . $i];
                        }
                    }

                    if (isset($_FILES['profile_picture']['tmp_name']) && $_FILES['profile_picture']['tmp_name'] != '') {
                        $target_dir = document_root . profile;
                        $profile_picture = $_FILES['profile_picture']['name'];
                        $ext = explode(".", $_FILES["profile_picture"]['name']);
                        $profile_picture = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $profile_picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $imageFileType = strtolower($imageFileType);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $uploadOk = 0;
                            $this->load->view('admin/accounts/add', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $this->load->view('admin/accounts/add', $data);
                        } else {
                            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                                $this->load->library('thumbnailer');
                                $this->thumbnailer->prepare($target_file);
                                list($width, $height, $type, $attr) = getimagesize($target_file);
                                /* Image Processing */
                                $thumb = $target_dir . "small/" . $profile_picture;
                                if ($width < $height) {
                                    if ($width < profile_thumb_width) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(profile_thumb_width)->save($thumb);
                                    }
                                } else {
                                    if ($height < profile_thumb_height) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(profile_thumb_height)->save($thumb);
                                    }
                                }
                                $medium = $target_dir . "medium/" . $profile_picture;
                                if ($width < $height) {
                                    if ($width < profile_medium_thumb_width) {
                                        copy($target_file, $medium);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(profile_medium_thumb_width)->save($medium);
                                    }
                                } else {
                                    if ($height < profile_medium_thumb_height) {
                                        copy($target_file, $medium);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(profile_medium_thumb_height)->save($medium);
                                    }
                                }
                            }
                        }
                    }

                    /* if (isset($_FILES['cover_picture']['tmp_name']) && $_FILES['cover_picture']['tmp_name'] != '') {

                      $target_dir = document_root . cover;
                      $cover_picture = $_FILES['cover_picture']['name'];
                      $ext = explode(".", $_FILES["cover_picture"]['name']);
                      $cover_picture = time() . "." . end($ext);
                      $target_file = $target_dir . "original/" . $cover_picture;
                      $uploadOk = 1;
                      $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                      // Allow certain file formats
                      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                      $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                      $uploadOk = 0;
                      $data['msg_class'] = 'alert-info';
                      $this->load->view('admin/accounts/add', $data);
                      }
                      if ($uploadOk == 0) {
                      $data['msg'] = "Sorry, your file was not uploaded.";
                      $data['msg_class'] = 'alert-info';
                      $this->load->view('admin/accounts/add', $data);
                      } else {
                      if (move_uploaded_file($_FILES["cover_picture"]["tmp_name"], $target_file)) {

                      $this->load->library('thumbnailer');
                      $this->thumbnailer->prepare($target_file);
                      list($width, $height, $type, $attr) = getimagesize($target_file);

                      $thumb = $target_dir . "small/" . $cover_picture;
                      $this->dbcommon->crop_store_cover_image($target_file, store_cover_small_thumb_width, store_cover_small_thumb_height, $thumb, 'small', $cover_picture);

                      $thumb = $target_dir . "medium/" . $cover_picture;
                      $this->dbcommon->crop_store_cover_image($target_file, store_cover_medium_thumb_width, store_cover_medium_thumb_height, $thumb, 'medium', $cover_picture);
                      @unlink($target_dir . "original/" . $user[0]->cover_picture);
                      @unlink($target_dir . "medium/" . $user[0]->cover_picture);
                      @unlink($target_dir . "small/" . $user[0]->cover_picture);
                      }
                      }
                      }
                     */

                    $get_char_slug = $_POST['username'];
                    $user_slug = $this->dbcommon->generate_slug($get_char_slug, 'U');

                    $data = array(
                        'username' => $_POST['username'],
                        'nick_name' => $_POST['nick_name'],
                        'email_id' => $_POST['email_id'],
                        'address' => $_POST['address'],
                        'phone' => $_POST['phone'],
                        'contact_number' => $_POST['phone'],
                        'state' => $_POST['state'],
                        'country' => 4,
                        'password' => md5($_POST['password']),
                        'user_role' => 'admin',
                        'user_register_date' => date('Y-m-d'),
                        'profile_picture' => $profile_picture,
                        // 'cover_picture' => $cover_picture,
                        'status' => 'active',
                        'chat_notification' => $_POST['chat_notification'],
                        'insert_from' => 'web',
                        'is_delete' => 0,
                        'user_slug' => $user_slug
                    );
                    $result = $this->dbcommon->insert('user', $data);

                    $user_id = $this->dblogin->getLastInserted();
                    $data = array(
                        'user_id' => $user_id,
                        'permission' => implode(",", $permission)
                    );
                    $result = $this->dbcommon->insert('user_permission', $data);
                    if ($result) {
                        $this->session->set_flashdata('msg', 'Admin User Account created successfully.');
                        redirect('admin/systems/accounts');
                    }
                } else {
                    $data['msg'] = 'User already exist with same email/username.';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/accounts/add', $data);
                }
            }
        } else {
            $this->load->view('admin/accounts/add', $data);
        }
    }

    public function accounts_edit($user_id = null) {

        $data = array();
        $data['page_title'] = 'Edit Admin';
        $where = " where user_id='" . $user_id . "'";
        $user = $this->dbcommon->getdetails('user', $where);

        $where = "country_id=4";
        $data['state'] = $this->dbcommon->filter('state', $where);

        $where = " where user_id='" . $user[0]->user_id . "'";
        $perm = $this->dbcommon->getdetails('user_permission', $where);
        $data['permission'] = $perm;

        if ($user_id != null && !empty($user)) {
            $data['user'] = $user;
            if (!empty($_POST)) {

                $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric');

                if ($this->input->post('nick_name') != '')
                    $this->form_validation->set_rules('nick_name', 'Nickname', 'min_length[3]|max_length[30]|alpha_numeric');

                $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email|max_length[50]');
                $this->form_validation->set_rules('phone', 'Phone No.', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    $this->load->view('admin/accounts/edit', $data);
                } else {
                    $where = " where user_id != '" . $user[0]->user_id . "'and (email_id ='" . addslashes($_POST['email_id']) . "' or username ='" . $_POST['username'] . "')";
                    $check_user = $this->dblogin->isExist($where);
                    $picture = $user[0]->cover_picture;
                    if (empty($check_user)) {

                        for ($i = 0; $i <= 11; $i++) {
                            if (isset($_POST['chk_' . $i])) {
                                $permission[] = $_POST['chk_' . $i];
                            }
                        }
                        /* if (isset($_FILES['cover_picture']['tmp_name']) && $_FILES['cover_picture']['tmp_name'] != '') {
                          $target_dir = document_root . cover;
                          $cover_picture = $_FILES['cover_picture']['name'];
                          $ext = explode(".", $_FILES["cover_picture"]['name']);
                          $picture = time() . "." . end($ext);
                          $target_file = $target_dir . "original/" . $picture;
                          $uploadOk = 1;
                          $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                          // Allow certain file formats
                          if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                          $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                          $uploadOk = 0;
                          $data['msg_class'] = 'alert-info';
                          $this->load->view('admin/accounts/edit', $data);
                          }
                          if ($uploadOk == 0) {
                          $data['msg'] = "Sorry, your file was not uploaded.";
                          $data['msg_class'] = 'alert-info';
                          $this->load->view('admin/accounts/edit', $data);
                          } else {
                          if (move_uploaded_file($_FILES["cover_picture"]["tmp_name"], $target_file)) {

                          $this->load->library('thumbnailer');
                          $this->thumbnailer->prepare($target_file);
                          list($width, $height, $type, $attr) = getimagesize($target_file);

                          $thumb = $target_dir . "small/" . $picture;
                          $this->dbcommon->crop_store_cover_image($target_file, store_cover_small_thumb_width, store_cover_small_thumb_height, $thumb, 'small', $picture);

                          $thumb = $target_dir . "medium/" . $picture;
                          $this->dbcommon->crop_store_cover_image($target_file, store_cover_medium_thumb_width, store_cover_medium_thumb_height, $thumb, 'medium', $picture);
                          @unlink($target_dir . "original/" . $user[0]->cover_picture);
                          @unlink($target_dir . "medium/" . $user[0]->cover_picture);
                          @unlink($target_dir . "small/" . $user[0]->cover_picture);
                          }
                          }
                          }
                         */
                        $data = array(
                            'username' => $_POST['username'],
                            'password' => !empty($_POST['password']) ? md5($_POST['password']) : $user[0]->password,
                            'email_id' => $_POST['email_id'],
                            'nick_name' => $_POST['nick_name'],
                            'address' => $_POST['address'],
                            'phone' => $_POST['phone'],
                            'contact_number' => $_POST['phone'],
                            'state' => $_POST['state'],
                            // 'cover_picture' => $picture,
                            'chat_notification' => $_POST['chat_notification'],
                            'update_from' => 'web'
                        );


                        $array = array('user_id' => $user[0]->user_id);
                        $result = $this->dbcommon->update('user', $array, $data);
                        if (sizeof($perm) > 0) {
                            $data = array(
                                'permission' => implode(",", $permission)
                            );
                            $result = $this->dbcommon->update('user_permission', $array, $data);
                        } else {
                            $data = array(
                                'user_id' => $user[0]->user_id,
                                'permission' => implode(",", $permission)
                            );
                            $result = $this->dbcommon->insert('user_permission', $data);
                        }
                        //                print_r($data);die;
                        if ($result) {
                            $this->session->set_flashdata('msg', 'Admin User Account updated successfully.');

                            $redirect = $_SERVER['QUERY_STRING'];
                            if (!empty($_SERVER['QUERY_STRING']))
                                $redirect = '/?' . $redirect;

                            redirect('admin/systems/accounts' . $redirect);
                        } else {
                            $data['msg'] = 'User not added, Please try again';
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/accounts/edit', $data);
                        }
                    } else {

                        $data['msg'] = 'User already exist with same email / username.';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/accounts/edit', $data);
                    }
                }
            } //here
            else {
                $this->load->view('admin/accounts/edit', $data);
            }
        } else {
            $this->session->set_flashdata(array('msg' => 'Admin User Account not found', 'class' => 'alert-info'));
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect('admin/systems/accounts' . $redirect);
        }
    }

    public function accounts_view($user_id = null) {

        $data = array();
        $data['page_title'] = 'View Admin';
        $where = " where user_id='" . $user_id . "'";
        $user = $this->dbcommon->getdetails('user', $where);

        $where = "country_id=4";
        $data['state'] = $this->dbcommon->filter('state', $where);

        $where = " where user_id='" . $user[0]->user_id . "'";
        $perm = $this->dbcommon->getdetails('user_permission', $where);
        $data['permission'] = $perm;

        if ($user_id != null && !empty($user)) {
            $data['user'] = $user;
            $this->load->view('admin/accounts/view', $data);
        } else {
            $this->session->set_flashdata(array('msg' => 'Admin User Account not found', 'class' => 'alert-info'));
            redirect('admin/systems/accounts');
        }
    }

    public function accounts_delete($user_id = null) {

        $data = array();
        $success = 0;
        $redirect_url = '';

        if ($this->input->post("checked_val") != '') {
            $user_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $user_id);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $user_id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $users = $this->db->query('select user_id,user_role from user                                 
                                where user_id in (' . $comma_ids . ')')->result_array();

        foreach ($users as $key => $u) {
            $where = array("user_id" => $u['user_id']);
            $update = array("is_delete" => 1);
            $result = $this->dbcommon->update('user', $where, $update);

            $where1 = array("product_posted_by" => $u['user_id']);
            $update1 = array("is_delete" => 1);
            $result = $this->dbcommon->update('product', $where1, $update1);

            if (isset($result))
                $success++;
        }

        if ($success > 0) {
            $this->session->set_flashdata(array('msg' => 'Admin User Account deleted successfully', 'class' => 'alert-success'));
            redirect('admin/systems/accounts' . '/' . $redirect_url);
        } else {
            $this->session->set_flashdata(array('msg' => 'Admin User Account not found', 'class' => 'alert-info'));
            redirect('admin/systems/accounts' . '/' . $redirect_url);
        }
    }

    public function accounts_reactivate($user_id = null) {

        $data = array();
        $where = " where user_id='" . $user_id . "' and is_delete in (1)";
        $user = $this->dbcommon->getdetails('user', $where);
        $user_role = $user[0]->user_role;
        if ($user_id != null && !empty($user)):

            $where = array("user_id" => $user_id);
            $update = array("is_delete" => 0);
            $this->dbcommon->update('user', $where, $update);

            $where1 = array("product_posted_by" => $user_id);
            $update1 = array("is_delete" => 0);
            $this->dbcommon->update('product', $where1, $update1);

            $this->session->set_flashdata(array('msg' => 'Admin User Account Reactivated successfully', 'class' => 'alert-success'));
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect('admin/systems/accounts' . $redirect);
        else:
            $this->session->set_flashdata(array('msg' => 'Admin User Account not found', 'class' => 'alert-info'));
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect('admin/systems/accounts' . $redirect);
        endif;
    }

    public function settings() {

        $data = array();

        $data['page_title'] = 'Settings';
        $colors = $this->dbcommon->select('color');
        $data['colors'] = $colors;

        $brand = $this->dbcommon->select('brand');
        $data['brand'] = $brand;

        $mileage = $this->dbcommon->select('mileage');
        $data['mileage'] = $mileage;

        $settings = $this->dbcommon->select('settings');
        $settings_arr = array();
        foreach ($settings as $value) {
            $settings_arr[$value['key']] = $value['val'];
        }
        if (!empty($_POST)) {

            $colors = array();
            $brand = array();
            $mileage = array();
            foreach ($_POST as $key => $value) {
                $key_values = array("no_of_post_month_classified_user", "adv_availability_classified_user",
                    "no_of_post_month_store_user", "adv_availability_store_user",
                    "no_of_post_month_offer_user", "adv_availability_offer_user",
                    "adv_availability_admin", "iphone_notification_max_length", "android_notification_max_length", "usd_currency_amount", "commission_on_purchase_from_store");

                if (in_array($key, $key_values)) {
                    //echo $key;
                    $data = array(
                        'val' => $_POST[$key]
                    );
                    $array = array('key' => $key);
                    $result = $this->dbcommon->update('settings', $array, $data);
                } elseif ($key == 'colors') {
                    foreach ($value as $k => $val) {
                        if ($val != '')
                            $colors[] = $val;
                    }
                    $array = array('key' => $key);
                    $col = implode(',', $colors);
                    $data = array('val' => $col);
                    $result = $this->dbcommon->update('settings', $array, $data);
                }
                elseif ($key == 'brand') {
                    foreach ($value as $k => $val) {
                        if ($val != '')
                            $brand[] = $val;
                    }
                    $array = array('key' => $key);
                    $col = implode(',', $brand);
                    $data = array('val' => $col);

                    $result = $this->dbcommon->update('settings', $array, $data);
                }
                elseif ($key == 'mileage') {
                    foreach ($value as $k => $val) {
                        if ($val != '')
                            $mileage[] = $val;
                    }
                    $array = array('key' => $key);
                    $col = implode(',', $mileage);
                    $data = array('val' => $col);
                    $result = $this->dbcommon->update('settings', $array, $data);
                }
                //print_r($_POST[$key]);
                //print_r($array);
                //echo '<br>';
            }

            $this->get_user_ads();

            $this->session->set_flashdata(array('msg' => 'Settings updated successfully'));
            redirect('admin/systems/settings');
        }

        $data['settings'] = $settings_arr;
        $this->load->view('admin/settings/index', $data);
    }

    public function shipping_cost() {
        $data = array();
        $data['page_title'] = 'Shipping Cost';
        $shipping = $this->dbcommon->select('shipping_cost');
        $data['shipping'] = $shipping;
        if (!empty($_POST)) {
            $i = 1;
            $current_user = $this->session->userdata('gen_user');
            //echo $current_user['user_id'];
            foreach ($_POST as $key => $value) {
               // if (isset($_POST['price_' . $i]) && !empty($_POST['price_' . $i])) {
                    $data = array(
                        'price' => $_POST['price_' . $i],
                        'modified_by'=> $current_user['user_id'],
                        'modify_date'=> date('y-m-d H:i:s', time())
                    );
                    $array = array('id' => $i);
                    $result = $this->dbcommon->update('shipping_cost', $array, $data);
                    //echo $this->db->last_query();
                    $i++;
               // }
            }
            $this->session->set_flashdata(array('msg' => 'Shipping cost updated successfully'));
            redirect('admin/systems/shipping_cost');
        }
        $this->load->view('admin/settings/shipping_cost', $data);
    }

    function nationality() {

        $data = array();
        $data['page_title'] = 'Nationality List';
        $url = site_url() . 'admin/Systems/nationality';

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

        $query = " 1=1 order by name  limit " . $offset . " ," . $per_page;
        $nationality = $this->dbcommon->filter('nationality', $query);
        $data['nationality'] = $nationality;

        $query = ' nation_id from nationality';
        $pagination_data = $this->dbcommon->pagination($url, $query, $per_page, 'yes');

        $data['url'] = $url;
        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];

        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/country/nationality_index', $data);
    }

    function nationality_add() {
        $data = array();
        $user = $this->session->userdata('user');
        $data['page_title'] = 'Add Nationality';
        if (!empty($_POST)):
            // validation 
            $this->form_validation->set_rules('nationality_name', 'Nationality Name', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $data['msg'] = "Please fill all required fields";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/country/nationality_index', $data);
            else:
                $data = array(
                    'name' => $_POST['nationality_name'],
                    'created_by' => $user->user_id
                );
                $result = $this->dbcommon->insert('nationality', $data);
                if ($result):
                    $this->session->set_flashdata(array('msg' => 'Nationality added successfully.', 'class' => 'alert-success'));
                    redirect('admin/systems/nationality');
                else:
                    $data['msg'] = 'Nationality not added, Please try again';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/country/nationality_index', $data);
                endif;
            endif;
        else:
            $this->load->view('admin/country/nationality_index');
        endif;
    }

    public function nationality_edit($nationality_id = null) {
        $data = array();
        $data['page_title'] = 'Edit Nationality';
        $user = $this->session->userdata('user');
        $where = " where nation_id='" . $nationality_id . "'";
        $nation = $this->dbcommon->getdetails('nationality', $where);
        if ($nationality_id != null && !empty($nation)):
            $data['nation'] = $nation;
            if (!empty($_POST)):
                $this->form_validation->set_rules('nationality_name', 'Nationality Name', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
                    $data['msg'] = "Please fill all required fields";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/country/nationality_edit', $data);
                else:

                    $data = array(
                        'name' => $_POST['nationality_name'],
                        'modified_by' => $user->user_id,
                        'modified_at' => date('y-m-d H:i:s', time())
                    );
                    $array = array('nation_id' => $nation[0]->nation_id);
                    $result = $this->dbcommon->update('nationality', $array, $data);
                    if ($result):
                        $this->session->set_flashdata(array('msg' => 'Nationality updated successfully.', 'class' => 'alert-success'));
                        redirect('admin/systems/nationality');
                    else:
                        $data['msg'] = 'Nationality not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/systems/nationality_edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/country/nationality_edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Nationality not found', 'class' => 'alert-info'));
            redirect('admin/systems/nationality');
        endif;
    }

    public function nationality_delete($nation_id = null) {

        $data = array();
        $checked_val = $this->input->post("checked_val");

        if ($checked_val != '') {
            $cat_ids = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $cat_ids);
        } else
            $comma_ids = $nation_id;

        $del_offer = $this->db->query('delete from nationality where nation_id in (' . $comma_ids . ')');

        if (isset($del_offer)) {
            $this->session->set_flashdata(array('msg' => 'Nationality(s) deleted successfully', 'class' => 'alert-success'));
            redirect('admin/systems/nationality');
        } else {
            $this->session->set_flashdata(array('msg' => 'Nationality(s) not found', 'class' => 'alert-info'));
            redirect('admin/systems/nationality');
        }
    }

    public function change_picture($user_id) {
        $where = " where user_id='" . $user_id . "'";
        $user = $this->dbcommon->getdetails('user', $where);
        if (!empty($user[0])):

            if (isset($_FILES['profile_picture']['tmp_name']) && $_FILES['profile_picture']['tmp_name'] != '') {
                $target_dir = document_root . profile;
                $profile_picture = $_FILES['profile_picture']['name'];
                $ext = explode(".", $_FILES["profile_picture"]['name']);
                $picture = time() . "." . end($ext);
                $target_file = $target_dir . "original/" . $picture;
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                $imageFileType = strtolower($imageFileType);
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                    $this->load->view('admin/users/signup', $data);
                }
                if ($uploadOk == 0) {
                    $data['msg'] = "Sorry, your file was not uploaded.";
                    $this->load->view('admin/users/signup', $data);
                } else {
                    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                        $this->load->library('thumbnailer');
                        $this->thumbnailer->prepare($target_file);
                        list($width, $height, $type, $attr) = getimagesize($target_file);
                        @unlink($target_dir . "original/" . $user[0]->profile_picture);
                        /* Image Processing */
                        $thumb = $target_dir . "small/" . $picture;
                        if ($width < $height) {
                            if ($width < profile_thumb_width) {
                                copy($target_file, $thumb);
                            } else {
                                $this->thumbnailer->thumbSymmetric(profile_thumb_width)->save($thumb);
                            }
                        } else {
                            if ($height < profile_thumb_height) {
                                copy($target_file, $thumb);
                            } else {
                                $small = $this->thumbnailer->thumbSymmetricHeight(profile_thumb_height)->save($thumb);
                            }
                        }
                        $medium = $target_dir . "medium/" . $picture;
                        if ($width < $height) {
                            if ($width < profile_medium_thumb_width) {
                                copy($target_file, $medium);
                            } else {
                                $this->thumbnailer->thumbSymmetric(profile_medium_thumb_width)->save($medium);
                            }
                        } else {
                            if ($height < profile_medium_thumb_height) {
                                copy($target_file, $medium);
                            } else {
                                $small = $this->thumbnailer->thumbSymmetricHeight(profile_medium_thumb_height)->save($medium);
                            }
                        }
                        @unlink($target_dir . "small/" . $user[0]->profile_picture);
                        @unlink($target_dir . "medium/" . $user[0]->profile_picture);
                    }
                }
                $data = array('profile_picture' => $picture);
                $array = array('user_id' => $user[0]->user_id);
                $result = $this->dbcommon->update('user', $array, $data);

                $where = " where user_id= " . $user[0]->user_id;
                $user = $this->dblogin->isExist($where);
                if ($user) {
                    $this->session->set_flashdata(array('msg' => 'Profile picture updated successfully', 'class' => 'alert-success'));
                    redirect('admin/systems/accounts_edit/' . $user_id);
                }
            }
        endif;
    }

    function block($id) {

        if (!empty($id)) {
            $data = array('is_delete' => 4);
            $array = array('user_id' => $id, 'is_delete' => 0);
            $result = $this->dbcommon->update('user', $array, $data);

            if (isset($result)) {
                $res = $this->db->query('select product_id from product where product_posted_by=' . (int) $id . ' and is_delete=0');
                $res_data = $res->result_array();

                if ($res->num_rows() > 0) {

                    foreach ($res_data as $val) {
                        $this->db->query('delete from block_product where product_id=' . $val['product_id']);
                        $data = array('product_id' => $val['product_id']);
                        $this->dbcommon->insert('block_product', $data);
                        $up = array('is_delete' => 2);
                        $data = array('product_id' => $val['product_id'], 'is_delete' => 0);
                        $this->dbcommon->update('product', $data, $up);
                    }
                }
            }
            $redirectUrl = $_POST['redirectUrl'];
            $this->session->set_flashdata(array('msg' => 'User blocked successfully', 'class' => 'alert-success'));
            redirect($redirectUrl);
        }
    }

    function unblock($id) {

        if (!empty($id)) {
            $data = array('is_delete' => 0);
            $array = array('user_id' => $id, 'is_delete' => 4);
            $result = $this->dbcommon->update('user', $array, $data);

            if (isset($result)) {
                $res = $this->db->query('select p.product_id from block_product b left join product p  on p.product_id=b.product_id where p.product_posted_by=' . (int) $id . ' and p.is_delete=2');
                $res_data = $res->result_array();
                if ($res->num_rows() > 0) {
                    foreach ($res_data as $val) {
                        $data = array('product_id' => $val['product_id'], 'is_delete' => 2);
                        $up = array('is_delete' => 0);
                        $this->dbcommon->update('product', $data, $up);
                        $this->db->query('delete from block_product where product_id=' . $val['product_id']);
                    }
                }
            }

            $redirectUrl = $_POST['redirectUrl'];
            $this->session->set_flashdata(array('msg' => 'Admin un-blocked successfully', 'class' => 'alert-success'));
            redirect($redirectUrl);
        }
    }

    public function featuredad_price() {

        $data = array();
        $data['redirect_admin_to'] = 'classified';
        $data['page_title'] = 'Featured Ad Price';

        $prices = $this->dbcommon->select('featuredad_price');

        foreach ($prices as $value) {
            $prices_arr[$value['hour']] = $value['amount'];
        }
        if (!empty($_POST)) {
            $prices_arr = array();
            foreach ($_POST as $key => $value) {
                $array = array('hour' => $key);
                $data = array('amount' => $_POST[$key]);
                $result = $this->dbcommon->update('featuredad_price', $array, $data);
            }
            $this->session->set_flashdata(array('msg' => 'Price updated successfully'));
            redirect('admin/Systems/featuredad_price');
        }
        $data['featured_price'] = $prices_arr;
        $this->load->view('admin/settings/featuredad_price', $data);
    }

    public function buyad_price() {

        $data = array();
        $data['redirect_admin_to'] = 'classified';
        $data['page_title'] = 'Buy Ad Price';

        $prices = $this->dbcommon->select('buy_ad_price');

        foreach ($prices as $value) {
            $prices_arr[$value['no_of_ads']] = $value['amount'];
        }
        if (!empty($_POST)) {
            $prices_arr = array();
            foreach ($_POST as $key => $value) {
                $array = array('no_of_ads' => $key);
                $data = array('amount' => $_POST[$key]);
                $result = $this->dbcommon->update('buy_ad_price', $array, $data);
            }
            $this->session->set_flashdata(array('msg' => 'Price updated successfully'));
            redirect('admin/Systems/buyad_price');
        }
        $data['buyad_price'] = $prices_arr;
        $this->load->view('admin/settings/buyad_price', $data);
    }

}

?>