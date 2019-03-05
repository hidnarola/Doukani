<?php

class Offers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('offer', '', TRUE);
        $this->load->library('permission');
        $this->load->model('dbcart', '', TRUE);
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('email');
        $this->per_page = 10;
    }

    public function index($today = NULL) {

        $data = array();
        $data['page_title'] = 'Offer List';
        $url = site_url() . 'admin/offers/index';
        $admin_user = $this->session->userdata('user');
        $data['admin_user'] = $admin_user;
        $cat = 0;
        $status = 0;
        $search = '';

        $query = ' offer_id from offers where offers.is_delete in (0,3) ';

        if (isset($_GET['cat']) && $_GET['cat'] != '0')
            $cat = $_GET['cat'];
        if (isset($_GET['status']) && $_GET['status'] != '0')
            $status = $_GET['status'];
        if (isset($_GET['dt']) && !empty($_GET['dt']))
            $dt = $_GET['dt'];

        if (isset($today) && $today == 'today')
            $today_request = 'today/';
        else
            $today_request = '';

        $data['today_request'] = $today_request;
        $que = '';
        $url = site_url() . 'admin/offers/index/' . $today_request;

        if (isset($_GET['userid']))
            $user_path = 'userid=' . $_GET['userid'];
        else
            $user_path = 'request=yes';

        $url .= '?' . $user_path;
        $search .= '?' . $user_path;

        if ($cat == 'all' && $status == "all")
            $que .= ' ';
        else if ($cat != 'all' && $status == "all")
            $que .= " and offers.offer_category_id = '" . $cat . "' ";
        else if ($cat == 'all' && $status != "all")
            $que .= " and offer_is_approve = '" . $status . "'  ";
        else
            $que .= " and offer_is_approve = '" . $status . "' and offers.offer_category_id='" . $cat . "'";

        $url .= '&cat=' . $cat . '&status=' . $status;
        $search .= '&cat=' . $cat . '&status=' . $status;

        if (isset($dt) && $dt != '') {
            $pieces = explode(" to ", $dt);
            $start_date = date("Y-m-d", strtotime($pieces[0]));
            $end_date = '';
            if (isset($pieces[1]))
                $end_date = date("Y-m-d", strtotime($pieces[1]));

            $que .= "  and  (date(offer_posted_on)>='" . $start_date . "' and date(offer_posted_on)<='" . $end_date . "') ";
            $url .= '&dt=' . $dt;
            $search .= '&dt=' . $dt;
        }

        if (isset($today) && $today == 'today') {
            $que .= "  and (('" . date('Y-m-d') . "' between offer_start_date and offer_end_date) or (offer_start_date<=CURDATE() and is_enddate=1)) ";
            $url = site_url() . 'admin/offers/index/' . $today_request . '?cat=' . $cat . '&status=' . $status;
            $search .= '?cat=' . $cat . '&status=' . $status;
        }

        if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
            $que .= "  and offer_user_company_id=" . $_REQUEST['userid'];
        }

        if ($que != '')
            $wh = $query . $que;
        else
            $wh = $query;

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '&per_page=' . $per_page;
            $search .= '&per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        if (isset($_REQUEST['page']) && !empty($search))
            $search .= '&page=' . $_REQUEST['page'];
        elseif (isset($_REQUEST['page']))
            $search .= '?page=' . $_REQUEST['page'];

        $data['url'] = $url;
        $data['search'] = $search;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

        $sql_query = '';
        $sql_query = " order by offers.offer_id desc limit " . $offset . " ," . $per_page;

        if ($que != '')
            $sql_query = ' offers.is_delete in (0,3) ' . $que . ' ' . $sql_query;
        else
            $sql_query = $sql_query;

        $offer_sql = 'select *, if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fo.start_date and fo.end_date and offers.offer_is_approve="approve" and offers.is_delete = 0,"f_ad","-" ) as offer_f_status, offers.offer_id offer_id ,if(offers.phone_no!="",offers.phone_no,if(u.contact_number !="",u.contact_number,if(u.phone!="",u.phone,"-"))) as user_contact_number, if(u.nick_name!="",u.nick_name,u.username) user_name,ouc.id company_user_id
                from offers 
                left join featured_offers fo on fo.offer_id=offers.offer_id  and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fo.start_date and fo.end_date) 
                left join user u on u.user_id=offers.offer_user_company_id
                left join offer_user_company ouc on u.user_id=ouc.user_id
                ';

        if (!empty($sql_query))
            $offer_sql .= ' where ' . $sql_query;

        $offers = $this->dbcommon->get_distinct($offer_sql);
        $data['offers'] = $offers;

        $pagination_data = $this->dbcommon->pagination($url, $wh, $per_page, 'yes');
        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];

        $category = $this->dbcommon->select('category');
        $data['category'] = $category;
//        $offer_company = ' company_status = 0 ';
//        $company = $this->dbcommon->filter('offer_user_company',$offer_company);
//        $data['company'] = $company;

        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/offers/index', $data);
    }

    public function add() {

        $data = array();
        $data['page_title'] = 'Add Offer';

        $user = array($this->session->userdata('user'));
        $admin_permission = $this->session->userdata('admin_modules_permission');
        $category = $this->dbcommon->select('category');
        $data['category'] = $category;

        $offer_company = ' company_status = 0 and company_is_inappropriate="Approve"';
        $company = $this->dbcommon->filter('offer_user_company', $offer_company);
        $data['company'] = $company;

        if (!empty($_POST) && $_POST['offer_title'] != ''):
            $uplado_err_cnt = 0;
//            if($_SERVER['REMOTE_ADDR'] == '203.109.68.198') {
                $this->form_validation->set_rules('offer_title', 'Offer Title', 'trim|required|max_length[80]');
                $this->form_validation->set_rules('offer_description', 'Offer Description', 'trim|required');
                $this->form_validation->set_rules('offer_user_company_id', 'Offer Company', 'trim|required');
                $this->form_validation->set_rules('phone_no', 'Phone No.', 'trim|required');
//                $this->form_validation->set_rules('phone_no', 'Phone No.', 'trim|required|min_length[10]');
                if ($this->form_validation->run() == FALSE):
                    $this->load->view('admin/offers/add', $data);
                else:
                    $where = " where user_id ='" . $_POST['offer_user_company_id'] . "'";
                    $company_user = $this->dbcommon->getdetails('offer_user_company', $where);
                    $offer_slug = $this->dbcommon->generate_slug($_POST['offer_title']);
                    $data = array(
                        'offer_title' => $_POST['offer_title'],
                        'offer_slug' => $offer_slug,
                        'offer_image' => '',
                        'offer_posted_by' => $user[0]->user_id,
                        'offer_posted_on' => date('Y-m-d H:i:s'),
                        'offer_url' => $_POST['offer_url'],
                        'offer_is_approve' => ($admin_permission == 'only_listing') ? 'unapprove' : $_POST['offer_is_approve'],
                        'offer_user_company_id' => $_POST['offer_user_company_id'],
                        'is_delete' => 0,
                        'offer_category_id' => $company_user[0]->offer_category_id,
                        'offer_description' => $_POST['offer_description'],
                        'phone_no' => $_POST['phone_no']
                    );
                    if (isset($_POST['st_dt_0']) && $_POST['st_dt_0'] == 'st_now') {
                        $data['offer_start_date'] = date('Y-m-d');
                    } else {
                        $data['offer_start_date'] = $_POST['start_date'];
                    }

                    if (isset($_POST['end_dt_0']) && $_POST['end_dt_0'] == 'end_never') {
                        $data['offer_end_date'] = '0000-00-00';
                        $data['is_enddate'] = 1;
                    } else {
                        $data['offer_end_date'] = $_POST['end_date'];
                        $data['is_enddate'] = 0;
                    }

                    if (isset($_POST['offer_is_approve']) && $_POST['offer_is_approve'] == 'approve') {
                        $data['offer_approve_date'] = date('Y-m-d H:i:s');
                    }

                    $result = $this->dbcommon->insert('offers', $data, '1');
                    if (isset($result) && isset($_POST['offer_is_approve']) && $_POST['offer_is_approve'] == 'approve') {
                        if (isset($_FILES['offer_image_0'])) {
                            $picture_ban = '';
                            $target_dir = document_root . offers;
                            $total_images = count($_FILES['offer_image_0']['name']);
                            for ($i = 0; $i < $total_images; $i++){
                                $upload_picture = $_FILES['offer_image_0']['name'][$i];
                                $ext = explode(".", $_FILES['offer_image_0']['name'][$i]);
                                $picture_ban = time() . $i . "." . end($ext);
                                $target_file = $target_dir . "original/" . $picture_ban;
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                $imageFileType = strtolower($imageFileType);
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $uplado_err_cnt++;
                                }
                                if ($uploadOk == 0) {
                                    $uplado_err_cnt++;
                                }  else {
                                    if (move_uploaded_file($_FILES['offer_image_0']["tmp_name"][$i], $target_file)) {
                                        $file_save['offer_id'] = $result;
                                        $file_save['file_path'] = $picture_ban;
                                        $file_save['is_active'] = 1;
                                        $save_file = $this->dbcommon->insert('offer_images', $file_save);
                                        $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
                                        $dest = document_root . offers . 'original/' . $picture_ban;
                                        $medium = $target_dir . "offer_detail/" . $picture_ban;
                                        if (file_exists(document_root . offers . 'original/' . $picture_ban)) {
                                            $this->dbcommon->crop_product_image($target_file, image_product_detail_width, image_product_detail_height, $medium, 'offer_detail', $picture_ban);
                                        }
                                        $medium = $target_dir . "medium/" . $picture_ban;
                                        if (file_exists(document_root . offers . 'original/' . $picture_ban)) {
                                            $this->dbcommon->crop_product_image($target_file, image_medium_width, image_medium_height, $medium, 'medium', $picture_ban);
                                        }
                                        if (file_exists(document_root . offers . 'original/' . $picture_ban))
                                            $this->dbcommon->watermarkOfferImage($picture_ban, $WaterMark, $dest, 50, 'original');
                                    }else{
                                        $uplado_err_cnt++;
                                    }
                                }
                            }
                        }
                        $this->dbcommon->send_offer_mail($company_user, $offer_slug, $data['offer_start_date'], $data['offer_end_date'], $picture_ban, NULL, $_POST['offer_title']);
                    }
                    if ($result):
                        if($uplado_err_cnt > 0){
                            $this->session->set_flashdata(array('msg1' => 'Offers added successfully. But some of images were not uploaded.', 'class' => 'alert-success'));
                        }else{
                            $this->session->set_flashdata(array('msg1' => 'Offers added successfully.', 'class' => 'alert-success'));
                        }
                        redirect('admin/offers');
                    else:
                        $data['msg'] = 'Offers not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/offers/add', $data);
                    endif;
                endif;
//            }else{
//            // validation
//                $this->form_validation->set_rules('offer_title', 'Offer Title', 'trim|required|max_length[80]');
//                $this->form_validation->set_rules('offer_description', 'Offer Description', 'trim|required');
//                $this->form_validation->set_rules('offer_user_company_id', 'Offer Company', 'trim|required');
//                $this->form_validation->set_rules('phone_no', 'Phone No.', 'trim|required|min_length[10]');
//
//                if ($this->form_validation->run() == FALSE):
//                    $this->load->view('admin/offers/add', $data);
//                else:
//
//                    $picture_ban = '';
//                    if (isset($_FILES['offer_image_0']['tmp_name']) && $_FILES['offer_image_0']['tmp_name'] != '') {
//                        $target_dir = document_root . offers;
//                        $profile_picture = $_FILES['offer_image_0']['name'];
//                        $ext = explode(".", $_FILES['offer_image_0']['name']);
//                        $picture_ban = time() . "." . end($ext);
//                        $target_file = $target_dir . "original/" . $picture_ban;
//                        $uploadOk = 1;
//                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
//                        $imageFileType = strtolower($imageFileType);
//                        // Allow certain file formats
//                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//                            $data['msg_class'] = 'alert-info';
//                            $uploadOk = 0;
//                            $this->load->view('admin/offers/add', $data);
//                        }
//                        if ($uploadOk == 0) {
//                            $data['msg'] = "Sorry, your file was not uploaded.";
//                            $data['msg_class'] = 'alert-info';
//                            $this->load->view('admin/offers/add', $data);
//                        } else {
//                            if (move_uploaded_file($_FILES['offer_image_0']["tmp_name"], $target_file)) {
//
//                                /* Image Processing */
//                                $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
//                                $dest = document_root . offers . 'original/' . $picture_ban;
//
//                                $medium = $target_dir . "offer_detail/" . $picture_ban;
//                                if (file_exists(document_root . offers . 'original/' . $picture_ban)) {
//                                    $this->dbcommon->crop_product_image($target_file, image_product_detail_width, image_product_detail_height, $medium, 'offer_detail', $picture_ban);
//                                }
//
//                                $medium = $target_dir . "medium/" . $picture_ban;
//                                if (file_exists(document_root . offers . 'original/' . $picture_ban)) {
//                                    $this->dbcommon->crop_product_image($target_file, image_medium_width, image_medium_height, $medium, 'medium', $picture_ban);
//                                }
//
//                                if (file_exists(document_root . offers . 'original/' . $picture_ban))
//                                    $this->dbcommon->watermarkOfferImage($picture_ban, $WaterMark, $dest, 50, 'original');
//                            }
//                        }
//                    }
//
//                    $where = " where user_id ='" . $_POST['offer_user_company_id'] . "'";
//                    $company_user = $this->dbcommon->getdetails('offer_user_company', $where);
//
//                    $offer_slug = $this->dbcommon->generate_slug($_POST['offer_title']);
//
//                    $data = array(
//                        'offer_title' => $_POST['offer_title'],
//                        'offer_slug' => $offer_slug,
//                        'offer_image' => $picture_ban,
//                        'offer_posted_by' => $user[0]->user_id,
//                        'offer_posted_on' => date('Y-m-d H:i:s'),
//                        'offer_url' => $_POST['offer_url'],
//                        'offer_is_approve' => ($admin_permission == 'only_listing') ? 'unapprove' : $_POST['offer_is_approve'],
//                        'offer_user_company_id' => $_POST['offer_user_company_id'],
//                        'is_delete' => 0,
//                        'offer_category_id' => $company_user[0]->offer_category_id,
//                        'offer_description' => $_POST['offer_description'],
//                        'phone_no' => $_POST['phone_no']
//                    );
//
//                    if (isset($_POST['st_dt_0']) && $_POST['st_dt_0'] == 'st_now') {
//                        $data['offer_start_date'] = date('Y-m-d');
//                    } else {
//                        $data['offer_start_date'] = $_POST['start_date'];
//                    }
//
//                    if (isset($_POST['end_dt_0']) && $_POST['end_dt_0'] == 'end_never') {
//                        $data['offer_end_date'] = '0000-00-00';
//                        $data['is_enddate'] = 1;
//                    } else {
//                        $data['offer_end_date'] = $_POST['end_date'];
//                        $data['is_enddate'] = 0;
//                    }
//
//                    if (isset($_POST['offer_is_approve']) && $_POST['offer_is_approve'] == 'approve') {
//                        $data['offer_approve_date'] = date('Y-m-d H:i:s');
//                    }
//
//                    $result = $this->dbcommon->insert('offers', $data);
//
//                    if (isset($result) && isset($_POST['offer_is_approve']) && $_POST['offer_is_approve'] == 'approve') {
//                        $this->dbcommon->send_offer_mail($company_user, $offer_slug, $data['offer_start_date'], $data['offer_end_date'], $picture_ban, NULL, $_POST['offer_title']);
//                    }
//
//                    if ($result):
//                        $this->session->set_flashdata(array('msg1' => 'Offers added successfully.', 'class' => 'alert-success'));
//                        redirect('admin/offers');
//                    else:
//                        $data['msg'] = 'Offers not added, Please try again';
//                        $data['msg_class'] = 'alert-info';
//                        $this->load->view('admin/offers/add', $data);
//                    endif;
//                endif;
//            }
        else:
//            echo $user[0]->user_id;die;
            $this->load->view('admin/offers/add', $data);
        endif;
    }

    public function edit($offer_id = null) {

        $data = array();
        $data['page_title'] = 'Edit Offer';
        $where = " where offer_id='" . $offer_id . "' and is_delete=0";
        $offers = $this->dbcommon->getdetails('offers', $where);
        $admin_permission = $this->session->userdata('admin_modules_permission');
        $admin_user = $this->session->userdata('user');
        $category = $this->dbcommon->select('category');
        $data['category'] = $category;

        $user = array($this->session->userdata('user'));
        $data['user_role'] = $user[0]->user_role;

        $offer_company = ' company_status = 0 and company_is_inappropriate="Approve"';
        $company = $this->dbcommon->filter('offer_user_company', $offer_company);
        $data['company'] = $company;

        if ($offer_id != null && !empty($offers) && (($admin_permission == 'only_listing' && $offers[0]->offer_posted_by == $admin_user->user_id && $offers[0]->offer_is_approve == 'unapprove') || empty($admin_permission))):
            $data['offers'] = $offers;
            $con = ' is_active = 1 AND offer_id = ' . $offer_id;
            $data['offer_images'] = $this->dbcommon->select('offer_images', $con);
            if (!empty($_POST)):

                $this->form_validation->set_rules('offer_title', 'Offer Title', 'trim|required|max_length[80]');
                $this->form_validation->set_rules('offer_description', 'Offer Description', 'trim|required');
                $this->form_validation->set_rules('offer_user_company_id', 'Offer Company', 'trim|required');
                $this->form_validation->set_rules('phone_no', 'Phone No.', 'trim|required');
//                $this->form_validation->set_rules('phone_no', 'Phone No.', 'trim|required|min_length[10]');

                if ($this->form_validation->run() == FALSE):
                    $this->load->view('admin/offers/edit', $data);
                else:

                    $picture_ban = $offers[0]->offer_image;
                
//                    if($_SERVER['REMOTE_ADDR'] == '203.109.68.198') {
                        if (isset($_FILES['offer_image_0'])) {
                            $picture_ban = '';
                            $target_dir = document_root . offers;
                            $total_images = count($_FILES['offer_image_0']['name']);
                            for ($i = 0; $i < $total_images; $i++){
                                $upload_picture = $_FILES['offer_image_0']['name'][$i];
                                $ext = explode(".", $_FILES['offer_image_0']['name'][$i]);
                                $picture_ban = time() . $i . "." . end($ext);
                                $target_file = $target_dir . "original/" . $picture_ban;
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                $imageFileType = strtolower($imageFileType);
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $uplado_err_cnt++;
                                }
                                if ($uploadOk == 0) {
                                    $uplado_err_cnt++;
                                }  else {
                                    if (move_uploaded_file($_FILES['offer_image_0']["tmp_name"][$i], $target_file)) {
                                        $file_save['offer_id'] = $offers[0]->offer_id;
                                        $file_save['file_path'] = $picture_ban;
                                        $file_save['is_active'] = 1;
                                        $save_file = $this->dbcommon->insert('offer_images', $file_save);
                                        $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
                                        $dest = document_root . offers . 'original/' . $picture_ban;
                                        $medium = $target_dir . "offer_detail/" . $picture_ban;
                                        if (file_exists(document_root . offers . 'original/' . $picture_ban)) {
                                            $this->dbcommon->crop_product_image($target_file, image_product_detail_width, image_product_detail_height, $medium, 'offer_detail', $picture_ban);
                                        }
                                        $medium = $target_dir . "medium/" . $picture_ban;
                                        if (file_exists(document_root . offers . 'original/' . $picture_ban)) {
                                            $this->dbcommon->crop_product_image($target_file, image_medium_width, image_medium_height, $medium, 'medium', $picture_ban);
                                        }
                                        if (file_exists(document_root . offers . 'original/' . $picture_ban))
                                            $this->dbcommon->watermarkOfferImage($picture_ban, $WaterMark, $dest, 50, 'original');
                                    }else{
                                        $uplado_err_cnt++;
                                    }
                                }
                            }
                        }
//                    }else{
//                        if (isset($_FILES['offer_image_0']['tmp_name']) && $_FILES['offer_image_0']['tmp_name'] != '') {
//                            $target_dir = document_root . offers;
//                            $profile_picture = $_FILES['offer_image_0']['name'];
//                            $ext = explode(".", $_FILES['offer_image_0']['name']);
//                            $picture_ban = time() . "." . end($ext);
//                            $target_file = $target_dir . "original/" . $picture_ban;
//                            $uploadOk = 1;
//                            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
//                            $imageFileType = strtolower($imageFileType);
//
//                            // Allow certain file formats
//                            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//                                $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//                                $data['msg_class'] = 'alert-info';
//                                $uploadOk = 0;
//                                $this->load->view('admin/offers/edit', $data);
//                            }
//                            if ($uploadOk == 0) {
//                                $data['msg'] = "Sorry, your file was not uploaded.";
//                                $data['msg_class'] = 'alert-info';
//                                $this->load->view('admin/offers/edit', $data);
//                            } else {
//                                if (move_uploaded_file($_FILES["offer_image_0"]["tmp_name"], $target_file)) {
//                                    $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
//                                    $dest = document_root . offers . 'original/' . $picture_ban;
//
//    //                                    $this->dbcommon->crop_offer_image($target_file,260,165, $medium, 'medium', $picture_ban);
//                                    $medium = $target_dir . "offer_detail/" . $picture_ban;
//                                    if (file_exists(document_root . offers . 'original/' . $picture_ban)) {
//                                        $this->dbcommon->crop_product_image($target_file, image_product_detail_width, image_product_detail_height, $medium, 'offer_detail', $picture_ban);
//                                    }
//
//                                    $medium = $target_dir . "medium/" . $picture_ban;
//                                    if (file_exists(document_root . offers . 'original/' . $picture_ban)) {
//                                        $this->dbcommon->crop_product_image($target_file, image_medium_width, image_medium_height, $medium, 'medium', $picture_ban);
//                                    }
//
//                                    if (file_exists(document_root . offers . 'original/' . $picture_ban))
//                                        $this->dbcommon->watermarkOfferImage($picture_ban, $WaterMark, $dest, 50, 'original');
//
//                                    @unlink($target_dir . "product_detail/" . $offers[0]->offer_image);
//                                    @unlink($target_dir . "original/" . $offers[0]->offer_image);
//                                    @unlink($target_dir . "medium/" . $offers[0]->offer_image);
//                                }
//                            }
//                        }
//                    }

                    $where = " where user_id ='" . $_POST['offer_user_company_id'] . "'";
                    $company_user = $this->dbcommon->getdetails('offer_user_company', $where);

                    $data = array(
                        'offer_title' => $_POST['offer_title'],
                        'offer_image' => $picture_ban,
                        'offer_category_id' => $_POST['cat_id'],
                        'offer_url' => $_POST['offer_url'],
                        'offer_is_approve' => ($admin_permission == 'only_listing') ? 'unapprove' : $_POST['offer_is_approve'],
                        'offer_modified_by' => $user[0]->user_id,
                        'offer_modified_on' => date('Y-m-d H:i:s'),
                        'offer_user_company_id' => $_POST['offer_user_company_id'],
                        'offer_category_id' => $company_user[0]->offer_category_id,
                        'offer_description' => $_POST['offer_description'],
                        'phone_no' => $_POST['phone_no']
                    );

                    if (isset($_POST['st_dt_0']) && $_POST['st_dt_0'] == 'st_now') {
                        $data['offer_start_date'] = date('Y-m-d');
                    } else {
                        $data['offer_start_date'] = $_POST['start_date'];
                    }

                    if (isset($_POST['end_dt_0']) && $_POST['end_dt_0'] == 'end_never') {
                        $data['offer_end_date'] = '0000-00-00';
                        $data['is_enddate'] = 1;
                    } else {
                        $data['offer_end_date'] = $_POST['end_date'];
                        $data['is_enddate'] = 0;
                    }

                    if (isset($_POST['offer_is_approve']) && $_POST['offer_is_approve'] == 'approve' &&
                            $offers[0]->offer_is_approve != $_POST['offer_is_approve']) {
                        $data['offer_approve_date'] = date('Y-m-d H:i:s');
                    }

                    $array = array('offer_id' => $offers[0]->offer_id);
                    $result = $this->dbcommon->update('offers', $array, $data);

                    if ($result):

                        if (isset($_POST['offer_is_approve']) && $_POST['offer_is_approve'] == 'approve' &&
                                $offers[0]->offer_is_approve != $_POST['offer_is_approve']) {

                            $offer_slug = $offers[0]->offer_slug;
                            $this->dbcommon->send_offer_mail($company_user, $offer_slug, $data['offer_start_date'], $data['offer_end_date'], $picture_ban, NULL, $_POST['offer_title']);
                        }

                        $this->session->set_flashdata(array('msg1' => 'Offer updated successfully.', 'class' => 'alert-success'));

                        $today = '';
                        if ($this->uri->segment(5) != '')
                            $today = '/' . $this->uri->segment(5);

                        $redirect = $_SERVER['QUERY_STRING'];
                        if (!empty($_SERVER['QUERY_STRING']))
                            $redirect = '/?' . $redirect;
                        redirect('admin/offers/index' . $today . $redirect);
                    //                        redirect('admin/offers');
                    else:
                        $data['msg'] = 'Offer not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/offers/edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/offers/edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg1' => 'Offer not found', 'class' => 'alert-info'));
            $today = '';
            if ($this->uri->segment(5) != '')
                $today = '/' . $this->uri->segment(5);

            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect('admin/offers/index' . $today . $redirect);

//            redirect('admin/offers');
        endif;
    }

    public function delete($offer_id = null, $today = NULL) {

        $comma_ids = '';
        $data = array();
        $checked_val = $this->input->post('checked_val', TRUE);

        if ($today != '') {
            $today = '/' . $today;
        } else {
            $today = $this->input->post('today', TRUE);

            if (isset($today) && !empty($today))
                $today = '/' . $today;
            else
                $today = '/';
        }
        if ($checked_val != '') {
            $cat_ids = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $cat_ids);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $offer_id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $del_offer = $this->db->query('update offers set is_delete=1 where offer_id in (' . $comma_ids . ') and is_delete=0');

        if (isset($del_offer)) {
            $this->session->set_flashdata(array('msg1' => 'Offer(s) deleted successfully', 'class' => 'alert-success'));
            redirect('admin/offers/index' . $today . $redirect_url);
        } else {
            $this->session->set_flashdata(array('msg1' => 'Offer(s) not found', 'class' => 'alert-info'));
            redirect('admin/offers/index' . $today . $redirect_url);
        }
    }
    
    public function delete_offer_image(){
        if($this->input->post()){
            $image_id = $this->input->post('image_id');
            $offer_id = $this->input->post('offer_id');
            $del_img['is_active'] = 0;
            $con['is_active'] = 1;
            $con['id'] = $image_id;
            $con['offer_id'] = $offer_id;
            $remove_img = $this->dbcommon->update('offer_images', $con, $del_img);
//            $remove_image = $this->db->query('update offer_images set is_active = 0 where id = ' . $image_id . ' AND offer_id = ' . $offer_id . ' and is_active = 1');
            if($remove_img){
                echo 'success';
            }else{
                echo 'fail';
            }
        }
        exit;
    }

    public function view($offer_id = null) {

        $data = array();
        $data['page_title'] = 'View Offer';
        $where = " where offer_id='" . $offer_id . "' and is_delete<>1";
        $offers = $this->dbcommon->getdetails('offers', $where);

        $category = $this->dbcommon->select('category');
        $data['category'] = $category;

        $user = array($this->session->userdata('user'));

        $offer_company = ' company_status = 0 ';
        $company = $this->dbcommon->filter('offer_user_company', $offer_company);
        $data['company'] = $company;

        if ($offer_id != null && !empty($offers)):
            $data['offers'] = $offers;
            $this->load->view('admin/offers/view', $data);
        else:
            $this->session->set_flashdata(array('msg1' => 'Offer not found', 'class' => 'alert-info'));
            redirect('admin/offers');
        endif;
    }

    function filterOfferList() {
        $cat = $this->input->post("cat");
        $store = $this->input->post("store");
        $main_data = array();
        if ($cat == 'all' && $store == "all") {
            $query = 1;
            $main_data['offers'] = $this->dbcommon->filter('offers', $query);
        } else if ($cat != 'all' && $store == "all") {
            $query = "offer_category_id = '" . $cat . "'";
            $main_data['offers'] = $this->dbcommon->filter('offers', $query);
        } else if ($cat == 'all' && $store != "all") {
            $query = "store_id = '" . $store . "'";
            $main_data['offers'] = $this->dbcommon->filter('offers', $query);
        } else {
            $query = "store_id = '" . $store . "' and offer_category_id='" . $cat . "'";
            $main_data['offers'] = $this->dbcommon->filter('offers', $query);
        }
        echo $this->load->view('admin/offers/offer_list', $main_data, TRUE);
        exit();
    }

    function update_status() {

        $status = $this->input->post("status");
        $values = $this->input->post("checked_val");
        $order = explode(",", $this->input->post("checked_val"));
        $field_name = "offer_is_approve";
        $success = 0;

        $offers_list = $this->db->query('select o.offer_title,o.offer_id,o.offer_user_company_id,o.offer_is_approve,o.offer_slug, o.offer_start_date,o.offer_end_date,o.is_enddate,o.offer_image,o.offer_description  FROM offers o 
                left join offer_user_company ouc on ouc.user_id=o.offer_user_company_id
                where ouc.company_status=0 and ouc.company_is_inappropriate="Approve" and o.is_delete=0 and o.offer_id in(' . $values . ')');
        $result = $offers_list->result_array();

        foreach ($result as $list) {
            $data[$field_name] = $status;
            $array = array('offer_id' => $list['offer_id'], 'is_delete' => 0);

            if ($list['offer_is_approve'] != 'approve' && $status == 'approve') {

                $data['offer_approve_date'] = date('Y-m-d H:i:s');
                $where = " where user_id ='" . $list['offer_user_company_id'] . "'";
                $company_user = $this->dbcommon->getdetails('offer_user_company', $where);

                if ($list['is_enddate'] == 0)
                    $offer_end_date = $list['offer_end_date'];
                else
                    $offer_end_date = NULL;

                $this->dbcommon->send_offer_mail($company_user, $list['offer_slug'], $list['offer_start_date'], $offer_end_date, $list['offer_image'], $list['is_enddate'], $list['offer_title']);
            }

            $result = $this->dbcommon->update('offers', $array, $data);

            if (isset($result))
                $success++;
        }

        if ($success > 0)
            $this->session->set_flashdata(array('msg1' => 'Offer(s) updated successfully', 'class' => 'alert-success'));

        redirect('admin/offers');
    }

    /*
     * Make Offer As Featured
     */

    public function insert_featured_offer() {

        $start_date = $this->dbcommon->get_usa_time(date("Y-m-d H:i:s", strtotime($_REQUEST['from_date'])));
        $end_date = $this->dbcommon->get_usa_time(date("Y-m-d H:i:s", strtotime($_REQUEST['to_date'])));

        $checked_values = explode(",", $_POST['checked_values']);
        print_r($checked_values);
        $success = 0;
        foreach ($checked_values as $val) {
            echo $val;
            $res = $this->db->query('select * from offers where offer_is_approve="approve" '
                    . 'and is_delete=0 and offer_id =' . $val);

            if ($res->num_rows() > 0) {
                $data = $res->result_array();

                $del_arr = array('offer_id' => $data[0]['offer_id']);
                $this->dbcommon->delete('featured_offers', $del_arr);

                $arra = array(
                    'offer_id' => $data[0]['offer_id'],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                );

                $result = $this->dbcommon->insert('featured_offers', $arra);
                $success++;
            }
        }
        if ($success > 0)
            $this->session->set_flashdata(array('msg1' => 'Offer(s) featured successfully', 'class' => 'alert-info'));

//        if(isset($_POST['today']))
//            redirect('admin/offers/index/today');
//        else
        redirect('admin/offers/index');
    }

    /*
     * Make Offer As Un-Featured
     */

    public function update_unfeatured_offer($user_id = NULL) {

        $redirect_url = '';
        $success = 0;

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

        $result = $this->db->query('select o.offer_id from featured_offers fo 
                 left join offers o on o.offer_id = fo.offer_id
                 where o.offer_id in (' . $comma_ids . ')')->result_array();

        foreach ($result as $res) {

            $wh = array('offer_id' => $res['offer_id']);
            $this->dbcommon->delete('featured_offers', $wh);
            $success++;
        }

        if ($success > 0)
            $this->session->set_flashdata(array('msg1' => 'Offer un-featured successfully', 'class' => 'alert-info'));

        redirect('admin/offers/featured_offers/' . $redirect_url);
    }

    public function featured_offers() {

        $data = array();
        $data['page_title'] = 'Featured Offers';
        $url = site_url() . 'admin/offers/featured_offers';
        $search = '';
        $wh_count = ' o.offer_id
            FROM featured_offers fo 
            LEFT JOIN offers o ON o.offer_id=fo.offer_id
            WHERE o.is_delete =0 AND o.offer_is_approve = "approve" GROUP BY fo.offer_id ';
        
        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        $data['url'] = $url;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;
        $pagination_data = $this->dbcommon->pagination($url, $wh_count, $per_page, 'yes');
        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];
        $data['featured_offers'] = $this->offer->get_featured_offers($offset, $per_page);

        echo $this->load->view('admin/offers/featured_offers', $data, TRUE);
    }

}

?>