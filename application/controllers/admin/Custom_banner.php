<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Custom_banner extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('permission');
        $this->load->model('dbcommon');
        $this->load->model('dblogin');
        $this->per_page = 20;
    }

    public function index() {
        
    }

    public function vipBanner($type = 0, $banner_for = '') {

        $main_data = array();
        $where = '';
        $where1 = '';
        $search = '';

        $main_data['page_title'] = ucfirst($banner_for) . ' - Vip Banner List';
        $main_data['flash_message'] = $this->session->flashdata('flash_message');
        $url = base_url() . "admin/custom_banner/vipBanner/" . $type . '/' . $banner_for;
        $search_result = 0;
        $banner_for_q = '';
        $web_arr = array('header', 'sidebar', 'between', 'intro', 'feature', 'footer', 'between_app');

        if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] != '' && in_array($_GET['ban_name_0'], $web_arr)) {
            $where1 .= ' and ban_type_name="' . $_GET['ban_name_0'] . '"';
            $url = base_url() . "admin/custom_banner/vipBanner/" . $type . "/" . $banner_for . "?ban_name_0=" . $_GET['ban_name_0'];
            $search = "?ban_name_0=" . $_GET['ban_name_0'];
            $search_result = 1;
        }

        $mob_arr = array('all_page', 'home_page', 'content_page', 'store_all_page', 'specific_store_page', 'store_content_page', 'off_all_page', 'off_home_page', 'off_cat_cont', 'off_comp_cont', 'off_cat_side', 'off_comp_side', 'after_splash_screen', 'before_latest_ads', 'before_featured_items');

        if (isset($_GET['display_page']) && $_GET['display_page'] != '' && in_array($_GET['display_page'], $mob_arr)) {
            $where1 .= ' and display_page="' . $_GET['display_page'] . '"';
            $url = base_url() . "admin/custom_banner/vipBanner/" . $type . "/" . $banner_for . '?display_page=' . $_GET['display_page'];
            $search = '?display_page=' . $_GET['display_page'];
            $search_result = 1;
        }

        if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] != '' && in_array($_GET['ban_name_0'], $web_arr) && isset($_GET['display_page']) && $_GET['display_page'] != '' && in_array($_GET['display_page'], $mob_arr)) {

            $url = base_url() . "admin/custom_banner/vipBanner/" . $type . "/" . $banner_for . "?ban_name_0=" . $_GET['ban_name_0'] . '&display_page=' . $_GET['display_page'];

            $search = "?ban_name_0=" . $_GET['ban_name_0'] . '&display_page=' . $_GET['display_page'];
            $search_result = 1;
        }

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            if ($search_result == 1)
                $url .= '&per_page=' . $per_page;
            else
                $url .= '?per_page=' . $per_page;

            if ($search_result == 1)
                $search .= '&per_page=' . $per_page;
            else
                $search .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        if ((isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'all') || !isset($_GET['ban_name_0'])) {
            if ($banner_for == 'web')
                $banner_for_q = ' and ban_type_name in ("header","sidebar","between") ';
            else
                $banner_for_q = ' and ban_type_name in ("intro","feature","footer","between_app") ';
        }

        $main_data['flash_message'] = $this->session->flashdata('flash_message');

        $where .= " ban_id from custom_banner where ";

        $where .= " ban_type='" . $type . "' " . $banner_for_q . $where1 . " order by ban_id desc";

        $pagination_data = $this->dbcommon->pagination($url, $where, $this->per_page, 'yes');

        $main_data["links"] = $pagination_data['links'];
        $main_data['total_records'] = $pagination_data['total_rows'];

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $this->per_page;

        $main_data["links"] = $this->pagination->create_links();

        $where = '';

        $where = " ban_type='" . $type . "'   " . $banner_for_q . $where1 . " order by ban_id desc limit " . $offset . ',' . $this->per_page;

        $main_data['superCategories'] = $this->dbcommon->filter('custom_banner', $where);
        $main_data['search'] = $search;

        $this->load->view('admin/banners/vipBanner_list', $main_data);
    }

    public function CustomBanner($type = 0, $banner_for = '') {

        $data = array();
        $main_data = array();
        $main_data['page_title'] = ucfirst($banner_for) . ' - Custom Banner List';
        $where1 = '';
        $where = '';
        $search = '';

        $url = site_url() . 'admin/custom_banner/CustomBanner/' . $type . '/' . $banner_for;
        $search_result = 0;
        $banner_for_q = '';
        $web_arr = array('header', 'sidebar', 'between', 'intro', 'feature', 'footer', 'between_app');

        if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] != '' && in_array($_GET['ban_name_0'], $web_arr)) {
            $where1 .= ' and ban_type_name="' . $_GET['ban_name_0'] . '"';
            $url = base_url() . "admin/custom_banner/CustomBanner/" . $type . "/" . $banner_for . "?ban_name_0=" . $_GET['ban_name_0'];
            $search = "?ban_name_0=" . $_GET['ban_name_0'];
            $search_result = 1;
        }

        $mob_arr = array('all_page', 'home_page', 'content_page', 'store_all_page', 'specific_store_page', 'store_content_page', 'off_all_page', 'off_home_page', 'off_cat_cont', 'off_comp_cont', 'off_cat_side', 'off_comp_side', 'after_splash_screen', 'before_latest_ads', 'before_featured_items');

        if (isset($_GET['display_page']) && $_GET['display_page'] != '' && in_array($_GET['display_page'], $mob_arr)) {
            $where1 .= ' and display_page="' . $_GET['display_page'] . '"';
            $url = base_url() . "admin/custom_banner/CustomBanner/" . $type . "/" . $banner_for . '?display_page=' . $_GET['display_page'];
            $search = '?display_page=' . $_GET['display_page'];
            $search_result = 1;
        }

        if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] != '' && in_array($_GET['ban_name_0'], $web_arr) && isset($_GET['display_page']) && $_GET['display_page'] != '' && in_array($_GET['display_page'], $mob_arr)) {

            $url = base_url() . "admin/custom_banner/CustomBanner/" . $type . "/" . $banner_for . "?ban_name_0=" . $_GET['ban_name_0'] . '&display_page=' . $_GET['display_page'];
            $search = "?ban_name_0=" . $_GET['ban_name_0'] . '&display_page=' . $_GET['display_page'];
            $search_result = 1;
        }

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            if ($search_result == 1)
                $url .= '&per_page=' . $per_page;
            else
                $url .= '?per_page=' . $per_page;

            if ($search_result == 1)
                $search .= '&per_page=' . $per_page;
            else
                $search .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        if ((isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'all') || !isset($_GET['ban_name_0'])) {
            if ($banner_for == 'web')
                $banner_for_q = ' and ban_type_name in ("header","sidebar","between") ';
            else
                $banner_for_q = ' and ban_type_name in ("intro","feature","footer","between_app") ';
        }

        $main_data['flash_message'] = $this->session->flashdata('flash_message');

        $where .= " ban_id from custom_banner where ";

        $where .= " ban_type='" . $type . "' " . $banner_for_q . $where1 . " order by ban_id desc";

        $pagination_data = $this->dbcommon->pagination($url, $where, $per_page, 'yes');

        $main_data["links"] = $pagination_data['links'];
        $main_data['total_records'] = $pagination_data['total_rows'];

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

        $where = '';

        $where = " ban_type='" . $type . "'   " . $banner_for_q . $where1 . " order by ban_id desc limit " . $offset . ',' . $per_page;

        $main_data['superCategories'] = $this->dbcommon->filter('custom_banner', $where);
        $main_data['search'] = $search;

        $this->load->view('admin/banners/CustomBanner_list', $main_data);
    }

    public function deletecustom($type = 11, $banner_for = NULL, $Id = 0) {

        $redirect_url = '';
        $target_dir = document_root . banner;
        $data = array();

        if ($this->input->post("checked_val") != '') {
            $type = $this->input->post("type");
            $banner_for = $this->input->post("banner_for");

            $Id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $Id);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $Id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $customs = $this->db->query('select img_file_name,ban_id from custom_banner
                                    where ban_id in (' . $comma_ids . ')')->result_array();
        $success = 0;
        foreach ($customs as $key => $c) {

            $where = array("ban_id" => $c['ban_id']);
            $custom = $this->dbcommon->delete('custom_banner', $where);
            if ($custom):
                @unlink($target_dir . "original/" . $c['img_file_name']);
                @unlink($target_dir . "small/" . $c['img_file_name']);
                @unlink($target_dir . "medium/" . $c['img_file_name']);
                @unlink($target_dir . "original/" . $c['big_img_file_name']);
                @unlink($target_dir . "small/" . $c['big_img_file_name']);
                @unlink($target_dir . "medium/" . $c['big_img_file_name']);
            endif;
            $success++;
        }
        if ($success > 0) {
            $this->session->set_flashdata(array('msg' => 'Custom Banner deleted successfully', 'class' => 'alert-success'));
            redirect('admin/custom_banner/CustomBanner/' . $type . '/' . $banner_for . '/' . $redirect_url);
        } else {
            $this->session->set_flashdata(array('msg' => 'Banner not found', 'class' => 'alert-info'));
            redirect('admin/custom_banner/CustomBanner/' . $type . '/' . $banner_for . '/' . $redirect_url);
        }
    }

    public function deletevip($type = 10, $banner_for = NULL, $Id = 0) {

        $redirect_url = '';
        $target_dir = document_root . banner;
        $data = array();

        if ($this->input->post("checked_val") != '') {
            $type = $this->input->post("type");
            $banner_for = $this->input->post("banner_for");

            $Id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $Id);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $Id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $vips = $this->db->query('select img_file_name,ban_id from custom_banner
                                    where ban_id in (' . $comma_ids . ')')->result_array();
        $success = 0;
        foreach ($vips as $key => $v) {

            $where = array("ban_id" => $v['ban_id']);
            $custom = $this->dbcommon->delete('custom_banner', $where);
            if ($custom):
                @unlink($target_dir . "original/" . $v['img_file_name']);
                @unlink($target_dir . "small/" . $v['img_file_name']);
                @unlink($target_dir . "medium/" . $v['img_file_name']);
                @unlink($target_dir . "original/" . $v['big_img_file_name']);
                @unlink($target_dir . "small/" . $v['big_img_file_name']);
                @unlink($target_dir . "medium/" . $v['big_img_file_name']);
            endif;
            $success++;
        }

        if ($success > 0) {
            $this->session->set_flashdata(array('msg' => 'VIP Banner deleted successfully', 'class' => 'alert-success'));
            redirect('admin/custom_banner/vipBanner/' . $type . '/' . $banner_for . '/' . $redirect_url);
        } else {
            $this->session->set_flashdata(array('msg' => 'Banner not found', 'class' => 'alert-info'));
            redirect('admin/custom_banner/vipBanner/' . $type . '/' . $banner_for . '/' . $redirect_url);
        }
    }

    public function addvip($type, $banner_for) {

        if ($type != '' && $banner_for != '') {

            $this->load->helper("file");
            $data = array();
            $main_data = array();
            $main_data['page_title'] = ucfirst($banner_for) . ' - Add VIP Banner';
            $main_data['type'] = $type;
            $main_data['title'] = "Vip Banner";
            $main_data['countries'] = $this->dbcommon->select('country');
            $main_data['superCategories'] = $this->dbcommon->select('category');
            $query = "user_role != 'admin' and user_role != 'superadmin'";
            $main_data['advertiser'] = $this->dbcommon->filter('user', $query);
            $where = " country_id=4";
            $state = $this->dbcommon->filter('state', $where);
            $main_data['state'] = $state;
            $small_image = '';

            $offer_company = ' is_delete = 0 ';
            $company = $this->dbcommon->filter('offer_user_company', $offer_company);
            $main_data['company'] = $company;

            $store_users = ' store_status = 0 and store_is_inappropriate="Approve"';
            $stores = $this->dbcommon->filter('store', $store_users);
            $main_data['stores'] = $stores;

            if (!empty($_POST)) {

                $smallFileName = "";
                $largeFileName = "";

                $totalRecord = $_POST['total'];
                $company_totalRecord = $_POST['company_total'];
                $store_totalRecord = $_POST['store_total'];

                $cat_str = '';
                $subcat_str = '';
                $company_str = '';
                $store_str = '';

                if (isset($_POST['display_page_0']) && in_array($_POST['display_page_0'], array('content_page', 'off_cat_cont'))) {
                    for ($i = 0; $i <= $totalRecord; $i++) {
                        //for category	
                        if (isset($_POST['superCategory_' . $i]))
                            $cat_str = implode(",", $_POST['superCategory_' . $i]);

                        //for sub-category							
                        if (isset($_POST['subcategory_' . $i]))
                            $subcat_str = implode(",", $_POST['subcategory_' . $i]);
                    }
                }

                if (isset($_POST['display_page_0']) && $_POST['display_page_0'] == 'off_comp_cont') {
                    for ($i = 0; $i <= $company_totalRecord; $i++) {

                        //for company
                        if (isset($_POST['offer_user_company_id_' . $i]))
                            $company_str = implode(",", $_POST['offer_user_company_id_' . $i]);
                    }
                }

                if (isset($_POST['display_page_0']) && in_array($_POST['display_page_0'], array('specific_store_page', 'store_content_page'))) {
                    for ($i = 0; $i <= $store_totalRecord; $i++) {

                        //for store
                        if (isset($_POST['store_id_' . $i]))
                            $store_str = implode(",", $_POST['store_id_' . $i]);
                    }
                }

                $picture = '';

                if ($_POST['ban_txt_img_0'] == 'image') {

                    if (isset($_FILES['uploadedfile_' . 0]['tmp_name']) && $_FILES['uploadedfile_' . 0]['tmp_name'] != '') {
                        $target_dir = document_root . banner;
                        $profile_picture = $_FILES['uploadedfile_' . 0]['name'];
                        $ext = explode(".", $_FILES['uploadedfile_' . 0]['name']);
                        $picture = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $imageFileType = strtolower($imageFileType);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/banners/addVipBanner', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/banners/addVipBanner', $data);
                        } else {
                            if (move_uploaded_file($_FILES['uploadedfile_' . 0]["tmp_name"], $target_file)) {
                                $this->load->library('thumbnailer');
                                $this->thumbnailer->prepare($target_file);
                                list($width, $height, $type, $attr) = getimagesize($target_file);
                                /* Image Processing */
                                $thumb = $target_dir . "small/" . $picture;
                                if ($width < $height) {
                                    if ($width < store_small_thumb_width) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(store_small_thumb_width)->save($thumb);
                                    }
                                } else {
                                    if ($height < store_small_thumb_height) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(store_small_thumb_height)->save($thumb);
                                    }
                                }
                                $thumb = $target_dir . "medium/" . $picture;
                                if ($width < $height) {
                                    if ($width < store_medium_thumb_width) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                    }
                                } else {
                                    if ($height < store_medium_thumb_height) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(store_medium_thumb_height)->save($thumb);
                                    }
                                }

                                $smallFileName = $picture;
                            }
                        }
                    }//----------------
                    $picture = '';
                    if (isset($_FILES['uploadedlargefile']['tmp_name']) && $_FILES['uploadedlargefile']['tmp_name'] != '') {
                        $target_dir = document_root . banner;
                        $profile_picture = $_FILES['uploadedlargefile']['name'];
                        $ext = explode(".", $_FILES['uploadedlargefile']['name']);
                        $picture = time() . "1." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $imageFileType = strtolower($imageFileType);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/banners/addVipBanner', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/banners/addVipBanner', $data);
                        } else {
                            if (move_uploaded_file($_FILES['uploadedlargefile']["tmp_name"], $target_file)) {
                                $this->load->library('thumbnailer');
                                $this->thumbnailer->prepare($target_file);
                                list($width, $height, $type, $attr) = getimagesize($target_file);
                                /* Image Processing */
                                $thumb = $target_dir . "small/" . $picture;
                                if ($width < $height) {
                                    if ($width < store_small_thumb_width) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(store_small_thumb_width)->save($thumb);
                                    }
                                } else {
                                    if ($height < store_small_thumb_height) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(store_small_thumb_height)->save($thumb);
                                    }
                                }
                                $thumb = $target_dir . "medium/" . $picture;
                                if ($width < $height) {
                                    if ($width < store_medium_thumb_width) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                    }
                                } else {
                                    if ($height < store_medium_thumb_height) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(store_medium_thumb_height)->save($thumb);
                                    }
                                }

                                $largeFileName = $picture;
                            }
                        }
                    }//----------------
                }
                $rand = rand(0, 10);

                $from_date = strtotime($_POST['start_date']);
                $to_date = strtotime($_POST['end_date']);
                $diff = $to_date - $from_date;
                $days = floor($diff / (60 * 60 * 24)) + 1;

                if ($_POST['ban_name_0'] != '') {
                    if (isset($_POST['ban_show_status_0']) && ($_POST['ban_show_status_0'] == 'ios' || $_POST['ban_show_status_0'] == 'android' || $_POST['ban_show_status_0'] == 'both'))
                        $ban_status = $_POST['ban_show_status_0'];
                    else
                        $ban_status = 'web';

                    $a = $_POST['site_url_0'];

                    if (strpos(strtolower($a), 'https://') !== false)
                        $_link = str_replace('https://', '', $a);
                    elseif (strpos(strtolower($a), 'http://') !== false)
                        $_link = str_replace('http://', '', $a);
                    else
                        $_link = $a;

                    $data = array(
                        'cat_id' => $cat_str,
                        'sub_cat_id' => $subcat_str,
                        'ban_show_status' => $ban_status,
                        'ban_type_name' => $_POST['ban_name_0'],
                        'site_url' => $_link,
                        'display_page' => $_POST['display_page_0'],
                        'ban_txt_img' => $_POST['ban_txt_img_0'],
                        'status' => $_POST['status_0'],
                        'phone_no' => $_POST['phone_no_0'],
                        'pause_banner' => $_POST['pause_banner_0'],
                        'impression_day' => $_POST['impression_day_0'],
                        'clicks_day' => $_POST['clicks_day_0'],
                        'ban_type' => $main_data['type'],
                        'advertiser' => $_POST['adv_0'],
                        'img_file_name' => $smallFileName,
                        'big_img_file_name' => $largeFileName,
                        'store_id' => $store_str,
                        'user_company_id' => $company_str,
                        'group_no' => $rand
                            //	'expiry_start_date' => $_POST['start_date']
                    );

                    // $data['cpm'] = $_POST['cpc_cpm_0'];
                    //$data['cpc'] = $_POST['cpc_cpm_0'];		
                    if (isset($_POST['ban_txt_img_0']) && $_POST['ban_txt_img_0'] == 'text')
                        $data['text_val'] = $_POST['text_ad'];
                    else
                        $data['text_val'] = '';

                    if ($_POST['st_dt_0'] == 'st_now') {
                        $data['expiry_start_date'] = date('Y-m-d');
                    } else {
                        $data['expiry_start_date'] = $_POST['start_date'];
                    }

                    if (isset($_POST['end_dt_0']) && $_POST['end_dt_0'] == 'end_never') {
                        $data['expiry_end_date'] = '0000-00-00';
                        $data['is_endate'] = 1;
                    } else {
                        $data['expiry_end_date'] = $_POST['end_date'];
                        $data['is_endate'] = 0;
                    }

                    if (isset($_POST['duration']) && $_POST['duration'] == 'cpm') {
                        $data['bidding_option'] = 'cpm';
                        $data['cpm'] = $_POST['cpc_cpm_0'];
                        $data['cpc'] = 0;
                        $data['duration'] = 0;
                    } elseif (isset($_POST['duration']) && $_POST['duration'] == 'cpc') {
                        $data['cpm'] = 0;
                        $data['cpc'] = $_POST['cpc_cpm_0'];
                        $data['bidding_option'] = 'cpc';
                        $data['duration'] = 0;
                    } elseif (isset($_POST['duration']) && $_POST['duration'] == 'duration') {
                        $data['cpm'] = 0;
                        $data['cpc'] = 0;
                        $data['duration'] = $_POST['cpc_cpm_0'];
                        $data['bidding_option'] = 'duration';
                    }

                    $result = $this->dbcommon->insert('custom_banner', $data);
                    $bannerId = $this->dblogin->getLastInserted();

                    if ($bannerId > 0) {
                        if ($cat_str != '') {
                            $catt = explode(",", $cat_str);
                            $subcatt = explode(",", $subcat_str);

                            if (sizeof($catt) > 0 && sizeof($subcatt) > 0) {
                                $merger_cat_subcat = array_combine($catt, $subcatt);
                                //print_r($merger_cat_subcat);
                                foreach ($merger_cat_subcat as $key => $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'category_id' => $key,
                                        'sub_category_id' => $val
                                    );

                                    $this->dbcommon->insert('category_banner', $in_arr);
                                }
                            }
                        }

                        if ($company_str != '') {
                            $companies = explode(",", $company_str);
                            if (sizeof($companies) > 0) {
                                foreach ($companies as $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'company_user_id' => $val
                                    );
                                    $this->dbcommon->insert('company_banner', $in_arr);
                                }
                            }
                        }

                        if ($store_str != '') {
                            $stores = explode(",", $store_str);
                            if (sizeof($stores) > 0) {
                                foreach ($stores as $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'store_id' => $val
                                    );
                                    $this->dbcommon->insert('store_banner', $in_arr);
                                }
                            }
                        }
                        $this->session->set_flashdata('flash_message', 'VIP Banner added successfully.' . $message);
                    } else
                        show_error("Banner add failed");
                }
                else {
                    show_error("Banner add failed");
                }

                redirect(base_url() . "admin/custom_banner/vipBanner/10/" . $banner_for);
            }
        } else {
            redirect('admin/home');
        }
        $this->load->view('admin/banners/addVipBanner', $main_data);
    }

    public function addcustom($type, $banner_for) {

        if ($type != '' && $banner_for != '') {
            $this->load->helper("file");
            $data = array();
            $main_data = array();
            $main_data['page_title'] = ucfirst($banner_for) . ' - Add Custom Banner';
            $main_data['type'] = $type;
            $main_data['title'] = "Custom Banner";
            $main_data['countries'] = $this->dbcommon->select('country');
            $where = " country_id=4";
            $state = $this->dbcommon->filter('state', $where);
            $main_data['state'] = $state;
            $main_data['superCategories'] = $this->dbcommon->select('category');
            $query = "user_role != 'admin' and user_role != 'superadmin'";
            $main_data['advertiser'] = $this->dbcommon->filter('user', $query);

            $offer_company = ' is_delete = 0 ';
            $company = $this->dbcommon->filter('offer_user_company', $offer_company);
            $main_data['company'] = $company;

            $store_users = ' store_status = 0 and store_is_inappropriate="Approve"';
            $stores = $this->dbcommon->filter('store', $store_users);
            $main_data['stores'] = $stores;

            if (!empty($_POST)) {

                $totalRecord = $_POST['total'];
                $company_totalRecord = $_POST['company_total'];
                $store_totalRecord = $_POST['store_total'];

                $cat_str = '';
                $subcat_str = '';
                $company_str = '';
                $store_str = '';

                if (isset($_POST['display_page_0']) && in_array($_POST['display_page_0'], array('content_page', 'off_cat_cont'))) {
                    for ($i = 0; $i <= $totalRecord; $i++) {
                        //for category	
                        if (isset($_POST['superCategory_' . $i]))
                            $cat_str = implode(",", $_POST['superCategory_' . $i]);

                        //for sub-category							
                        if (isset($_POST['subcategory_' . $i]))
                            $subcat_str = implode(",", $_POST['subcategory_' . $i]);
                    }
                }

                if (isset($_POST['display_page_0']) && $_POST['display_page_0'] == 'off_comp_cont') {
                    for ($i = 0; $i <= $company_totalRecord; $i++) {

                        //for company
                        if (isset($_POST['offer_user_company_id_' . $i]))
                            $company_str = implode(",", $_POST['offer_user_company_id_' . $i]);
                    }
                }

                if (isset($_POST['display_page_0']) && in_array($_POST['display_page_0'], array('specific_store_page', 'store_content_page'))) {
                    for ($i = 0; $i <= $store_totalRecord; $i++) {

                        //for store
                        if (isset($_POST['store_id_' . $i]))
                            $store_str = implode(",", $_POST['store_id_' . $i]);
                    }
                }

                $smallFileName = '';
                $largeFileName = '';
                $picture = '';
                if ($_POST['ban_txt_img_0'] == 'image') {
                    if (isset($_FILES['uploadedfile_0']['tmp_name']) && $_FILES['uploadedfile_0']['tmp_name'] != '') {
                        $target_dir = document_root . banner;
                        $profile_picture = $_FILES['uploadedfile_0']['name'];
                        $ext = explode(".", $_FILES['uploadedfile_0']['name']);
                        $picture = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $imageFileType = strtolower($imageFileType);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/banners/addCustomBanner', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/banners/addCustomBanner', $data);
                        } else {
                            if (move_uploaded_file($_FILES['uploadedfile_0']["tmp_name"], $target_file)) {
                                $this->load->library('thumbnailer');
                                $this->thumbnailer->prepare($target_file);
                                list($width, $height, $type, $attr) = getimagesize($target_file);
                                /* Image Processing */
                                $thumb = $target_dir . "small/" . $picture;
                                if ($width < $height) {
                                    if ($width < store_small_thumb_width) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(store_small_thumb_width)->save($thumb);
                                    }
                                } else {
                                    if ($height < store_small_thumb_height) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(store_small_thumb_height)->save($thumb);
                                    }
                                }
                                $thumb = $target_dir . "medium/" . $picture;
                                if ($width < $height) {
                                    if ($width < store_medium_thumb_width) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                    }
                                } else {
                                    if ($height < store_medium_thumb_height) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(store_medium_thumb_height)->save($thumb);
                                    }
                                }
                                $smallFileName = $picture;
                            }
                        }
                    }//----------------
                    $picture = '';
                    if (isset($_FILES['uploadedlargefile']['tmp_name']) && $_FILES['uploadedlargefile']['tmp_name'] != '') {
                        $target_dir = document_root . banner;
                        $profile_picture = $_FILES['uploadedlargefile']['name'];
                        $ext = explode(".", $_FILES['uploadedlargefile']['name']);
                        $picture = time() . "1." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $imageFileType = strtolower($imageFileType);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/banners/addCustomBanner', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/banners/addCustomBanner', $data);
                        } else {
                            if (move_uploaded_file($_FILES['uploadedlargefile']["tmp_name"], $target_file)) {
                                $this->load->library('thumbnailer');
                                $this->thumbnailer->prepare($target_file);
                                list($width, $height, $type, $attr) = getimagesize($target_file);
                                /* Image Processing */
                                $thumb = $target_dir . "small/" . $picture;
                                if ($width < $height) {
                                    if ($width < store_small_thumb_width) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(store_small_thumb_width)->save($thumb);
                                    }
                                } else {
                                    if ($height < store_small_thumb_height) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(store_small_thumb_height)->save($thumb);
                                    }
                                }
                                $thumb = $target_dir . "medium/" . $picture;
                                if ($width < $height) {
                                    if ($width < store_medium_thumb_width) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                    }
                                } else {
                                    if ($height < store_medium_thumb_height) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $small = $this->thumbnailer->thumbSymmetricHeight(store_medium_thumb_height)->save($thumb);
                                    }
                                }
                                $largeFileName = $picture;
                            }
                        }
                    }//----------------
                }
                $rand = rand(0, 10);

                $from_date = strtotime($_POST['start_date']);
                $to_date = strtotime($_POST['end_date']);
                $diff = $to_date - $from_date;
                $days = floor($diff / (60 * 60 * 24)) + 1;
                if ($_POST['ban_name_0'] != '') {

                    if (isset($_POST['ban_show_status_0']) && ($_POST['ban_show_status_0'] == 'ios' || $_POST['ban_show_status_0'] == 'android' || $_POST['ban_show_status_0'] == 'both'))
                        $ban_status = $_POST['ban_show_status_0'];
                    else
                        $ban_status = 'web';

                    $a = $_POST['site_url_0'];

                    if (strpos(strtolower($a), 'https://') !== false)
                        $_link = str_replace('https://', '', $a);
                    elseif (strpos(strtolower($a), 'http://') !== false)
                        $_link = str_replace('http://', '', $a);
                    else
                        $_link = $a;

                    $data = array(
                        'cat_id' => $cat_str,
                        'sub_cat_id' => $subcat_str,
                        'ban_show_status' => $ban_status,
                        'ban_type_name' => $_POST['ban_name_0'],
                        'site_url' => $_link,
                        'display_page' => $_POST['display_page_0'],
                        'ban_txt_img' => $_POST['ban_txt_img_0'],
                        'status' => $_POST['status_0'],
                        'phone_no' => $_POST['phone_no_0'],
                        'pause_banner' => $_POST['pause_banner_0'],
                        'impression_day' => $_POST['impression_day_0'],
                        'clicks_day' => $_POST['clicks_day_0'],
                        'ban_type' => $main_data['type'],
                        'advertiser' => $_POST['adv_0'],
                        'img_file_name' => $smallFileName,
                        'big_img_file_name' => $largeFileName,
                        'store_id' => $store_str,
                        'user_company_id' => $company_str,
                        'group_no' => $rand
                    );

                    //$data['cpm'] = $_POST['cpc_cpm_0'];
                    //$data['cpc'] = $_POST['cpc_cpm_0'];	
                    if (isset($_POST['ban_txt_img_0']) && $_POST['ban_txt_img_0'] == 'text')
                        $data['text_val'] = $_POST['text_ad'];
                    else
                        $data['text_val'] = '';

                    if ($_POST['st_dt_0'] == 'st_now') {
                        $data['expiry_start_date'] = date('Y-m-d');
                    } else {
                        $data['expiry_start_date'] = $_POST['start_date'];
                    }

                    if (isset($_POST['end_dt_0']) && $_POST['end_dt_0'] == 'end_never') {
                        $data['expiry_end_date'] = '0000-00-00';
                        $data['is_endate'] = 1;
                    } else {
                        $data['expiry_end_date'] = $_POST['end_date'];
                        $data['is_endate'] = 0;
                    }

                    if (isset($_POST['duration']) && $_POST['duration'] == 'cpm') {
                        $data['bidding_option'] = 'cpm';
                        $data['cpm'] = $_POST['cpc_cpm_0'];
                        $data['cpc'] = 0;
                        $data['duration'] = 0;
                    } elseif (isset($_POST['duration']) && $_POST['duration'] == 'cpc') {
                        $data['cpm'] = 0;
                        $data['cpc'] = $_POST['cpc_cpm_0'];
                        $data['bidding_option'] = 'cpc';
                        $data['duration'] = 0;
                    } elseif (isset($_POST['duration']) && $_POST['duration'] == 'duration') {
                        $data['cpm'] = 0;
                        $data['cpc'] = 0;
                        $data['duration'] = $_POST['cpc_cpm_0'];
                        $data['bidding_option'] = 'duration';
                    }

                    $result = $this->dbcommon->insert('custom_banner', $data);
                    $bannerId = $this->dblogin->getLastInserted();
                    if ($bannerId > 0) {
                        if ($cat_str != '') {
                            $catt = explode(",", $cat_str);
                            $subcatt = explode(",", $subcat_str);

                            if (sizeof($catt) > 0 && sizeof($subcatt) > 0) {
                                $merger_cat_subcat = array_combine($catt, $subcatt);
                                //print_r($merger_cat_subcat);
                                foreach ($merger_cat_subcat as $key => $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'category_id' => $key,
                                        'sub_category_id' => $val
                                    );
                                    $this->dbcommon->insert('category_banner', $in_arr);
                                }
                            }
                        }

                        if ($company_str != '') {
                            $companies = explode(",", $company_str);
                            if (sizeof($companies) > 0) {
                                foreach ($companies as $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'company_user_id' => $val
                                    );
                                    $this->dbcommon->insert('company_banner', $in_arr);
                                }
                            }
                        }

                        if ($store_str != '') {
                            $stores = explode(",", $store_str);
                            if (sizeof($stores) > 0) {
                                foreach ($stores as $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'store_id' => $val
                                    );
                                    $this->dbcommon->insert('store_banner', $in_arr);
                                }
                            }
                        }

                        $this->session->set_flashdata('flash_message', 'Custom Banner added successfully.' . $message);
                    } else
                        show_error("Banner add failed");
                }
                else {
                    show_error("Banner add failed");
                }

                redirect(base_url() . "admin/custom_banner/CustomBanner/11/" . $banner_for);
            }
            $this->load->view('admin/banners/addCustomBanner', $main_data);
        } else {
            redirect('admin/home');
        }
    }

    public function editvip($type = 10, $banner_for, $bannerId = 0) {
        $this->load->helper("file");
        $data = array();
        $main_data = array();

        if ($bannerId > 0) {
            $main_data['page_title'] = ucfirst($banner_for) . ' - Edit VIP Banner';
            //$main_data['type'] = $type;
            $main_data['title'] = "Vip Banner";
            $main_data['countries'] = $this->dbcommon->select('country');
//            $main_data['superCategories'] = $this->dbcommon->select('category');
            $main_data['advertiser'] = $this->dbcommon->select('user');
            $where = " where ban_id='" . $bannerId . "'";
            $banner_data = $this->dbcommon->getdetails('custom_banner', $where);

            $offer_company = ' is_delete = 0 ';
            $company = $this->dbcommon->filter('offer_user_company', $offer_company);
            $main_data['company'] = $company;

            $store_users = ' store_status = 0 and store_is_inappropriate="Approve"';
            $stores = $this->dbcommon->filter('store', $store_users);
            $main_data['stores'] = $stores;

            $main_data['bannerInfo'] = $banner_data;

            if ($banner_data[0]->display_page == 'content_page')
                $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
            else
                $wh_category_data = array('FIND_IN_SET(1, category_type) > 0');

            $main_data['superCategories'] = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);

            if (sizeof($main_data['bannerInfo'])) {
                $where = "category_id='" . $banner_data[0]->cat_id . "'";
                $main_data['sub_cat'] = $this->dbcommon->filter('sub_category', $where);

                $where = "country_id='" . $banner_data[0]->country . "'";
                $sub_category = $this->dbcommon->filter('state', $where);
                $main_data['state'] = $sub_category;

                if (!empty($main_data['bannerInfo'])) {
                    if (!empty($_POST)) {

                        $totalRecord = $_POST['total'];
                        if ($totalRecord >= -1)
                            $totalRecord = 0;

                        $store_totalRecord = $_POST['store_total'];
                        if ($store_totalRecord >= -1)
                            $store_totalRecord = 0;

                        $company_totalRecord = $_POST['company_total'];
                        if ($company_totalRecord >= -1)
                            $company_totalRecord = 0;

                        $cat_str = '';
                        $subcat_str = '';
                        $company_str = '';
                        $store_str = '';
                        if (isset($_POST['display_page_0']) && in_array($_POST['display_page_0'], array('content_page', 'off_cat_cont'))) {
                            for ($i = 0; $i <= $totalRecord; $i++) {
                                //for category	
                                if (isset($_POST['superCategory_' . $i]))
                                    $cat_str = implode(",", $_POST['superCategory_' . $i]);
                                //for sub-category							
                                if (isset($_POST['subcategory_' . $i]))
                                    $subcat_str = implode(",", $_POST['subcategory_' . $i]);
                            }
                        }

                        if (isset($_POST['display_page_0']) && $_POST['display_page_0'] == 'off_comp_cont') {
                            for ($i = 0; $i <= $company_totalRecord; $i++) {

                                //for company
                                if (isset($_POST['offer_user_company_id_' . $i]))
                                    $company_str = implode(",", $_POST['offer_user_company_id_' . $i]);
                            }
                        }

                        if (isset($_POST['display_page_0']) && in_array($_POST['display_page_0'], array('specific_store_page', 'store_content_page'))) {
                            for ($i = 0; $i <= $store_totalRecord; $i++) {

                                //for store
                                if (isset($_POST['store_id_' . $i]))
                                    $store_str = implode(",", $_POST['store_id_' . $i]);
                            }
                        }

                        $from_date = strtotime($_POST['start_date']);
                        $to_date = strtotime($_POST['end_date']);
                        $diff = $to_date - $from_date;
                        $days = floor($diff / (60 * 60 * 24)) + 1;

                        if (isset($_POST['ban_show_status_0']) && ($_POST['ban_show_status_0'] == 'ios' || $_POST['ban_show_status_0'] == 'android' || $_POST['ban_show_status_0'] == 'both'))
                            $ban_status = $_POST['ban_show_status_0'];
                        else
                            $ban_status = 'web';

                        $updateData = array(
                            'cat_id' => $cat_str,
                            'sub_cat_id' => $subcat_str,
                            'ban_show_status' => $ban_status,
                            'ban_type_name' => $_POST['ban_name'],
                            'status' => $_POST['status'],
                            'phone_no' => $_POST['phone_no'],
                            'pause_banner' => $_POST['pause_banner'],
                            'impression_day' => $_POST['impression_day'],
                            'clicks_day' => $_POST['clicks_day'],
                            'ban_txt_img' => $_POST['ban_txt_img_0'],
                            //'ban_type' => $type,
                            'advertiser' => $_POST['adv'],
                            'expiry_start_date' => $_POST['start_date'],
                            'user_company_id' => $company_str,
                            'store_id' => $store_str
                        );
                        // print_r($updateData);
                        // exit;

                        if (isset($_POST['ban_txt_img_0']) && $_POST['ban_txt_img_0'] == 'text')
                            $updateData['text_val'] = $_POST['text_ad'];
                        else
                            $updateData['text_val'] = '';


                        if (isset($_POST['end_dt_0']) && $_POST['end_dt_0'] == 'end_never') {
                            $updateData['expiry_end_date'] = '0000-00-00';
                            $updateData['is_endate'] = 1;
                        } else {
                            $updateData['expiry_end_date'] = $_POST['end_date'];
                            $updateData['is_endate'] = 0;
                        }

                        if (isset($_POST['duration']) && $_POST['duration'] == 'cpm') {
                            $updateData['bidding_option'] = 'cpm';
                            $updateData['cpm'] = $_POST['cpc_cpm_0'];
                            $updateData['cpc'] = 0;
                            $updateData['duration'] = 0;
                        } elseif (isset($_POST['duration']) && $_POST['duration'] == 'cpc') {
                            $updateData['cpm'] = 0;
                            $updateData['cpc'] = $_POST['cpc_cpm_0'];
                            $updateData['bidding_option'] = 'cpc';
                            $updateData['duration'] = 0;
                        } elseif (isset($_POST['duration']) && $_POST['duration'] == 'duration') {
                            $updateData['cpm'] = 0;
                            $updateData['cpc'] = 0;
                            $updateData['duration'] = $_POST['cpc_cpm_0'];
                            $updateData['bidding_option'] = 'duration';
                        }
                        $picture = '';
                        if ($_POST['ban_txt_img_0'] == 'image') {

                            if (isset($_FILES['uploadedfile']['tmp_name']) && $_FILES['uploadedfile']['tmp_name'] != '') {
                                $target_dir = document_root . banner;
                                $profile_picture = $_FILES['uploadedfile']['name'];
                                $ext = explode(".", $_FILES['uploadedfile']['name']);
                                $picture = time() . "." . end($ext);
                                $target_file = $target_dir . "original/" . $picture;
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                $imageFileType = strtolower($imageFileType);
                                // Allow certain file formats
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $data['msg_class'] = 'alert-info';
                                    $uploadOk = 0;
                                    $this->load->view('admin/banners/editVipBanner', $data);
                                }
                                if ($uploadOk == 0) {
                                    $data['msg'] = "Sorry, your file was not uploaded.";
                                    $data['msg_class'] = 'alert-info';
                                    $this->load->view('admin/banners/editVipBanner', $data);
                                } else {
                                    if (move_uploaded_file($_FILES['uploadedfile']["tmp_name"], $target_file)) {
                                        $this->load->library('thumbnailer');
                                        $this->thumbnailer->prepare($target_file);
                                        list($width, $height, $type, $attr) = getimagesize($target_file);
                                        /* Image Processing */
                                        $thumb = $target_dir . "small/" . $picture;
                                        if ($width < $height) {
                                            if ($width < store_small_thumb_width) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $this->thumbnailer->thumbSymmetric(store_small_thumb_width)->save($thumb);
                                            }
                                        } else {
                                            if ($height < store_small_thumb_height) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $small = $this->thumbnailer->thumbSymmetricHeight(store_small_thumb_height)->save($thumb);
                                            }
                                        }
                                        $thumb = $target_dir . "medium/" . $picture;
                                        if ($width < $height) {
                                            if ($width < store_medium_thumb_width) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                            }
                                        } else {
                                            if ($height < store_medium_thumb_height) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $small = $this->thumbnailer->thumbSymmetricHeight(store_medium_thumb_height)->save($thumb);
                                            }
                                        }
                                        $updateData['img_file_name'] = $picture;
                                    }
                                }
                            }//----------------
                            $picture = '';
                            if (isset($_FILES['uploadedlargefile']['tmp_name']) && $_FILES['uploadedlargefile']['tmp_name'] != '') {
                                $target_dir = document_root . banner;
                                $profile_picture = $_FILES['uploadedlargefile']['name'];
                                $ext = explode(".", $_FILES['uploadedlargefile']['name']);
                                $picture = time() . "1." . end($ext);
                                $target_file = $target_dir . "original/" . $picture;
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                $imageFileType = strtolower($imageFileType);
                                // Allow certain file formats
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $data['msg_class'] = 'alert-info';
                                    $uploadOk = 0;
                                    $this->load->view('admin/banners/editVipBanner', $data);
                                }
                                if ($uploadOk == 0) {
                                    $data['msg'] = "Sorry, your file was not uploaded.";
                                    $data['msg_class'] = 'alert-info';
                                    $this->load->view('admin/banners/editVipBanner', $data);
                                } else {
                                    if (move_uploaded_file($_FILES['uploadedlargefile']["tmp_name"], $target_file)) {
                                        $this->load->library('thumbnailer');
                                        $this->thumbnailer->prepare($target_file);
                                        list($width, $height, $type, $attr) = getimagesize($target_file);
                                        /* Image Processing */
                                        $thumb = $target_dir . "small/" . $picture;
                                        if ($width < $height) {
                                            if ($width < store_small_thumb_width) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $this->thumbnailer->thumbSymmetric(store_small_thumb_width)->save($thumb);
                                            }
                                        } else {
                                            if ($height < store_small_thumb_height) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $small = $this->thumbnailer->thumbSymmetricHeight(store_small_thumb_height)->save($thumb);
                                            }
                                        }
                                        $thumb = $target_dir . "medium/" . $picture;
                                        if ($width < $height) {
                                            if ($width < store_medium_thumb_width) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                            }
                                        } else {
                                            if ($height < store_medium_thumb_height) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $small = $this->thumbnailer->thumbSymmetricHeight(store_medium_thumb_height)->save($thumb);
                                            }
                                        }
                                        $updateData['big_img_file_name'] = $picture;
                                    }
                                }
                            }//----------------
                        }
                        //$updateData['text_val'] = "";
                        $a = $_POST['site_url'];

                        if (strpos(strtolower($a), 'https://') !== false)
                            $_link = str_replace('https://', '', $a);
                        elseif (strpos(strtolower($a), 'http://') !== false)
                            $_link = str_replace('http://', '', $a);
                        else
                            $_link = $a;

                        $updateData['site_url'] = $_link;

                        $array = array('ban_id' => $bannerId);
                        $result = $this->dbcommon->update('custom_banner', $array, $updateData);

                        $delarr = array('banner_id' => $bannerId);
                        $this->dbcommon->delete('category_banner', $delarr);
                        $this->dbcommon->delete('store_banner', $delarr);
                        $this->dbcommon->delete('company_banner', $delarr);

                        if ($cat_str != '') {

                            $catt = explode(",", $cat_str);
                            $subcatt = explode(",", $subcat_str);

                            if (sizeof($catt) > 0 && sizeof($subcatt) > 0) {
                                $merger_cat_subcat = array_combine($catt, $subcatt);
                                //print_r($merger_cat_subcat);
                                foreach ($merger_cat_subcat as $key => $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'category_id' => $key,
                                        'sub_category_id' => $val
                                    );
                                    $this->dbcommon->insert('category_banner', $in_arr);
                                }
                            }
                        }

                        if ($company_str != '') {
                            $companies = explode(",", $company_str);
                            if (sizeof($companies) > 0) {
                                foreach ($companies as $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'company_user_id' => $val
                                    );
                                    $this->dbcommon->insert('company_banner', $in_arr);
                                }
                            }
                        }

                        if ($store_str != '') {
                            $stores = explode(",", $store_str);
                            if (sizeof($stores) > 0) {
                                foreach ($stores as $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'store_id' => $val
                                    );
                                    $this->dbcommon->insert('store_banner', $in_arr);
                                }
                            }
                        }
                        $this->session->set_flashdata('flash_message', 'VIP Banner updated successfully.');
                        $redirect = $_SERVER['QUERY_STRING'];
                        if (!empty($_SERVER['QUERY_STRING']))
                            $redirect = '/?' . $redirect;
                        redirect(base_url() . "admin/custom_banner/vipBanner/" . $type . '/' . $banner_for . $redirect);
                    }
                    $data['title'] = "Edit | Banner ";
                    $this->load->view('admin/banners/editVipBanner', $main_data);
                } else {
                    show_error("Banner Not Found.");
                }
            } else {
                $this->session->set_flashdata('flash_message', 'Banner not found.');
                $redirect = $_SERVER['QUERY_STRING'];
                if (!empty($_SERVER['QUERY_STRING']))
                    $redirect = '/?' . $redirect;
                redirect(base_url() . "admin/custom_banner/vipBanner/10/" . $banner_for . $redirect);
            }
        } else {
            $this->session->set_flashdata('flash_message', 'Banner not found.');
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect(base_url() . "admin/custom_banner/vipBanner/10" . $banner_for . $redirect);
        }
    }

    public function editcustom($type = 11, $banner_for, $bannerId = 0) {

        $this->load->helper("file");
        $data = array();
        $main_data = array();
        if ($bannerId > 0) {
            //$main_data['type'] = $type;
            $main_data['page_title'] = ucfirst($banner_for) . ' - Edit Custom Banner';
            $main_data['title'] = "Custom Banner";
            $main_data['countries'] = $this->dbcommon->select('country');

//            $main_data['superCategories'] = $this->dbcommon->select('category');

            $main_data['advertiser'] = $this->dbcommon->select('user');
            $where = " where ban_id='" . $bannerId . "'";
            $banner_data = $this->dbcommon->getdetails('custom_banner', $where);
            $main_data['bannerInfo'] = $banner_data;

            if ($banner_data[0]->display_page == 'content_page')
                $wh_category_data = array('FIND_IN_SET(0, category_type) > 0');
            else
                $wh_category_data = array('FIND_IN_SET(1, category_type) > 0');

            $main_data['superCategories'] = $this->dbcommon->select_orderby('category', 'cat_order', 'asc', $wh_category_data, true);

            $offer_company = ' is_delete = 0 ';
            $company = $this->dbcommon->filter('offer_user_company', $offer_company);
            $main_data['company'] = $company;

            $store_users = ' store_status = 0 and store_is_inappropriate="Approve"';
            $stores = $this->dbcommon->filter('store', $store_users);
            $main_data['stores'] = $stores;

            if (sizeof($main_data['bannerInfo']) > 0) {
                $where = "category_id='" . $banner_data[0]->cat_id . "'";
                $main_data['sub_cat'] = $this->dbcommon->filter('sub_category', $where);

                $where = "country_id='" . $banner_data[0]->country . "'";
                $sub_category = $this->dbcommon->filter('state', $where);
                $main_data['state'] = $sub_category;

                if (!empty($main_data['bannerInfo'])) {
                    if (!empty($_POST)) {
                        $totalRecord = $_POST['total'];
                        if ($totalRecord >= -1)
                            $totalRecord = 0;

                        $store_totalRecord = $_POST['store_total'];
                        if ($store_totalRecord >= -1)
                            $store_totalRecord = 0;

                        $company_totalRecord = $_POST['company_total'];
                        if ($company_totalRecord >= -1)
                            $company_totalRecord = 0;

                        $cat_str = '';
                        $subcat_str = '';
                        $company_str = '';
                        $store_str = '';
                        if (isset($_POST['display_page_0']) && in_array($_POST['display_page_0'], array('content_page', 'off_cat_cont'))) {
                            for ($i = 0; $i <= $totalRecord; $i++) {
                                //for category	
                                if (isset($_POST['superCategory_' . $i]))
                                    $cat_str = implode(",", $_POST['superCategory_' . $i]);
                                //for sub-category							
                                if (isset($_POST['subcategory_' . $i]))
                                    $subcat_str = implode(",", $_POST['subcategory_' . $i]);
                            }
                        }

                        if (isset($_POST['display_page_0']) && $_POST['display_page_0'] == 'off_comp_cont') {
                            for ($i = 0; $i <= $company_totalRecord; $i++) {

                                //for company
                                if (isset($_POST['offer_user_company_id_' . $i]))
                                    $company_str = implode(",", $_POST['offer_user_company_id_' . $i]);
                            }
                        }

                        if (isset($_POST['display_page_0']) && in_array($_POST['display_page_0'], array('specific_store_page', 'store_content_page'))) {
                            for ($i = 0; $i <= $store_totalRecord; $i++) {

                                //for store
                                if (isset($_POST['store_id_' . $i]))
                                    $store_str = implode(",", $_POST['store_id_' . $i]);
                            }
                        }

                        $from_date = strtotime($_POST['start_date']);
                        $to_date = strtotime($_POST['end_date']);
                        $diff = $to_date - $from_date;
                        $days = floor($diff / (60 * 60 * 24)) + 1;

                        if (isset($_POST['ban_show_status_0']) && ($_POST['ban_show_status_0'] == 'ios' || $_POST['ban_show_status_0'] == 'android' || $_POST['ban_show_status_0'] == 'both'))
                            $ban_status = $_POST['ban_show_status_0'];
                        else
                            $ban_status = 'web';

                        $updateData = array(
                            'cat_id' => $cat_str,
                            'sub_cat_id' => $subcat_str,
                            'ban_type_name' => $_POST['ban_name'],
                            'status' => $_POST['status'],
                            'ban_show_status' => $ban_status,
                            'phone_no' => $_POST['phone_no'],
                            'pause_banner' => $_POST['pause_banner'],
                            'impression_day' => $_POST['impression_day'],
                            'clicks_day' => $_POST['clicks_day'],
                            'ban_txt_img' => $_POST['ban_txt_img_0'],
                            //'ban_type' => $type,
                            'expiry_start_date' => $_POST['start_date'],
                            'advertiser' => $_POST['adv'],
                            'user_company_id' => $company_str,
                            'store_id' => $store_str
                        );
                        // print_r($updateData);
                        // exit;
                        //$data['cpm'] = $_POST['cpc_cpm_0'];
                        //$data['cpc'] = $_POST['cpc_cpm_0'];
                        if (isset($_POST['ban_txt_img_0']) && $_POST['ban_txt_img_0'] == 'text')
                            $updateData['text_val'] = $_POST['text_ad'];
                        else
                            $updateData['text_val'] = '';

                        //if ($_POST['end_date'] == '0000-00-00' || $_POST['end_date'] == '') {
                        if (isset($_POST['end_dt_0']) && $_POST['end_dt_0'] == 'end_never') {
                            $updateData['expiry_end_date'] = '0000-00-00';
                            $updateData['is_endate'] = 1;
                        } else {
                            $updateData['expiry_end_date'] = $_POST['end_date'];
                            $updateData['is_endate'] = 0;
                        }

                        if (isset($_POST['duration']) && $_POST['duration'] == 'cpm') {
                            $updateData['bidding_option'] = 'cpm';
                            $updateData['cpm'] = $_POST['cpc_cpm_0'];
                            $updateData['cpc'] = 0;
                            $updateData['duration'] = 0;
                        } elseif (isset($_POST['duration']) && $_POST['duration'] == 'cpc') {
                            $updateData['cpm'] = 0;
                            $updateData['cpc'] = $_POST['cpc_cpm_0'];
                            $updateData['bidding_option'] = 'cpc';
                            $updateData['duration'] = 0;
                        } elseif (isset($_POST['duration']) && $_POST['duration'] == 'duration') {
                            $updateData['cpm'] = 0;
                            $updateData['cpc'] = 0;
                            $updateData['duration'] = $_POST['cpc_cpm_0'];
                            $updateData['bidding_option'] = 'duration';
                        }

                        $picture = '';
                        if ($_POST['ban_txt_img_0'] == 'image') {
                            if (isset($_FILES['uploadedfile']['tmp_name']) && $_FILES['uploadedfile']['tmp_name'] != '') {

                                $target_dir = document_root . banner;
                                $profile_picture = $_FILES['uploadedfile']['name'];
                                $ext = explode(".", $_FILES['uploadedfile']['name']);
                                $picture = time() . "." . end($ext);
                                $target_file = $target_dir . "original/" . $picture;
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                $imageFileType = strtolower($imageFileType);
                                // Allow certain file formats
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $data['msg_class'] = 'alert-info';
                                    $uploadOk = 0;
                                    $this->load->view('admin/banners/editCustomBanner', $data);
                                }
                                if ($uploadOk == 0) {
                                    $data['msg'] = "Sorry, your file was not uploaded.";
                                    $data['msg_class'] = 'alert-info';
                                    $this->load->view('admin/banners/editCustomBanner', $data);
                                } else {

                                    if (move_uploaded_file($_FILES['uploadedfile']["tmp_name"], $target_file)) {

                                        $this->load->library('thumbnailer');
                                        $this->thumbnailer->prepare($target_file);
                                        list($width, $height, $type, $attr) = getimagesize($target_file);
                                        /* Image Processing */
                                        $thumb = $target_dir . "small/" . $picture;
                                        if ($width < $height) {
                                            if ($width < store_small_thumb_width) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $this->thumbnailer->thumbSymmetric(store_small_thumb_width)->save($thumb);
                                            }
                                        } else {
                                            if ($height < store_small_thumb_height) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $small = $this->thumbnailer->thumbSymmetricHeight(store_small_thumb_height)->save($thumb);
                                            }
                                        }
                                        $thumb = $target_dir . "medium/" . $picture;
                                        if ($width < $height) {
                                            $mywidth = store_medium_thumb_width;
                                            //if ($width < store_medium_thumb_width) {
                                            if ($width < $mywidth) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                            }
                                        } else {
                                            $myheight = store_medium_thumb_height;
                                            //if ($height < store_medium_thumb_height) {
                                            if ($height < $myheight) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $small = $this->thumbnailer->thumbSymmetricHeight(store_medium_thumb_height)->save($thumb);
                                            }
                                        }
                                        $updateData['img_file_name'] = $picture;
                                    }
                                }
                            }//----------------
                            $picture = '';
                            if (isset($_FILES['uploadedlargefile']['tmp_name']) && $_FILES['uploadedlargefile']['tmp_name'] != '') {
                                $target_dir = document_root . banner;
                                $profile_picture = $_FILES['uploadedlargefile']['name'];
                                $ext = explode(".", $_FILES['uploadedlargefile']['name']);
                                $picture = time() . "1." . end($ext);
                                $target_file = $target_dir . "original/" . $picture;
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                $imageFileType = strtolower($imageFileType);
                                // Allow certain file formats

                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $data['msg_class'] = 'alert-info';
                                    $uploadOk = 0;
                                    $this->load->view('admin/banners/editCustomBanner', $data);
                                }
                                if ($uploadOk == 0) {
                                    $data['msg'] = "Sorry, your file was not uploaded.";
                                    $data['msg_class'] = 'alert-info';
                                    $this->load->view('admin/banners/editCustomBanner', $data);
                                } else {
                                    if (move_uploaded_file($_FILES['uploadedlargefile']["tmp_name"], $target_file)) {

                                        $this->load->library('thumbnailer');
                                        $this->thumbnailer->prepare($target_file);
                                        list($width, $height, $type, $attr) = getimagesize($target_file);
                                        /* Image Processing */
                                        $thumb = $target_dir . "small/" . $picture;
                                        if ($width < $height) {
                                            if ($width < store_small_thumb_width) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $this->thumbnailer->thumbSymmetric(store_small_thumb_width)->save($thumb);
                                            }
                                        } else {
                                            if ($height < store_small_thumb_height) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $small = $this->thumbnailer->thumbSymmetricHeight(store_small_thumb_height)->save($thumb);
                                            }
                                        }

                                        $thumb = $target_dir . "medium/" . $picture;
                                        if ($width < $height) {
                                            if ($width < store_medium_thumb_width) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                            }
                                        } else {
                                            if ($height < store_medium_thumb_height) {
                                                copy($target_file, $thumb);
                                            } else {
                                                $small = $this->thumbnailer->thumbSymmetricHeight(store_medium_thumb_height)->save($thumb);
                                            }
                                        }

                                        $updateData['big_img_file_name'] = $picture;
                                    }
                                }
                            }//----------------
                        }
                        //$updateData['text_val'] = "";

                        $a = $_POST['site_url'];

                        if (strpos(strtolower($a), 'https://') !== false)
                            $_link = str_replace('https://', '', $a);
                        elseif (strpos(strtolower($a), 'http://') !== false)
                            $_link = str_replace('http://', '', $a);
                        else
                            $_link = $a;

                        $updateData['site_url'] = $_link;


                        $array = array('ban_id' => $bannerId);
                        $result = $this->dbcommon->update('custom_banner', $array, $updateData);

                        $delarr = array('banner_id' => $bannerId);
                        $this->dbcommon->delete('category_banner', $delarr);
                        $this->dbcommon->delete('store_banner', $delarr);
                        $this->dbcommon->delete('company_banner', $delarr);

                        if ($cat_str != '') {

                            $catt = explode(",", $cat_str);
                            $subcatt = explode(",", $subcat_str);

                            if (sizeof($catt) > 0 && sizeof($subcatt) > 0) {
                                $merger_cat_subcat = array_combine($catt, $subcatt);
                                //print_r($merger_cat_subcat);
                                foreach ($merger_cat_subcat as $key => $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'category_id' => $key,
                                        'sub_category_id' => $val
                                    );
                                    $this->dbcommon->insert('category_banner', $in_arr);
                                }
                            }
                        }

                        if ($company_str != '') {
                            $companies = explode(",", $company_str);
                            if (sizeof($companies) > 0) {
                                foreach ($companies as $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'company_user_id' => $val
                                    );
                                    $this->dbcommon->insert('company_banner', $in_arr);
                                }
                            }
                        }

                        if ($store_str != '') {
                            $stores = explode(",", $store_str);
                            if (sizeof($stores) > 0) {
                                foreach ($stores as $val) {
                                    $in_arr = array('banner_id' => $bannerId,
                                        'store_id' => $val
                                    );
                                    $this->dbcommon->insert('store_banner', $in_arr);
                                }
                            }
                        }
                        $this->session->set_flashdata('flash_message', 'Custom Banner updated successfully.');
                        $redirect = $_SERVER['QUERY_STRING'];
                        if (!empty($_SERVER['QUERY_STRING']))
                            $redirect = '/?' . $redirect;
                        redirect(base_url() . "admin/custom_banner/CustomBanner/11/" . $banner_for . $redirect);
                    }

                    $this->load->view('admin/banners/editCustomBanner', $main_data);
                } else {
                    show_error("Banner Not Found.");
                }
            } else {
                $this->session->set_flashdata('flash_message', 'Banner not found.');
                $redirect = $_SERVER['QUERY_STRING'];
                if (!empty($_SERVER['QUERY_STRING']))
                    $redirect = '/?' . $redirect;
                redirect(base_url() . "admin/custom_banner/CustomBanner/11/" . $banner_for . $redirect);
            }
        } else {
            $this->session->set_flashdata('flash_message', 'Banner not found.');
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect(base_url() . "admin/custom_banner/CustomBanner/11/" . $banner_for . $redirect);
        }
    }

    function filterBannerList() {

        $type = $this->input->get_post("type");
        $ban_name = $this->input->get_post("name");
        $main_data = array();

        if ($ban_name == 'all') {
            $query = " ban_id from custom_banner where ban_type=" . $type;
        } else {
            $query = " ban_id from custom_banner where  ban_type= '" . $type . "' and ban_type_name = '" . $ban_name . "'";
        }
        if ($type == 10)
            $url1 = $url1 = base_url() . "admin/custom_banner/vipBanner";
        else
            $url1 = $url1 = base_url() . "admin/custom_banner/CustomBanner";

        if ($type != '')
            $url1 .= '/' . $type;
        if ($ban_name != '')
            $url1 .= '/' . $ban_name;

        $main_data["links"] = $this->dbcommon->pagination($url1, $query);

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $this->per_page;

        $query = '';
        if ($ban_name == 'all') {
            $query = "ban_type=" . $type . " order by ban_id desc limit 0," . $this->per_page;
            $main_data['superCategories'] = $this->dbcommon->filter('custom_banner', $query);
        } else {
            $query = "ban_type= '" . $type . "' and ban_type_name = '" . $ban_name . "' order by ban_id desc limit 0," . $this->per_page;
            $main_data['superCategories'] = $this->dbcommon->filter('custom_banner', $query);
        }

        $main_data['type'] = $type;
        echo $this->load->view('admin/banners/BannerList', $main_data, TRUE);
    }

    function getSubCategory() {
        $superCategoryId = $this->input->post("sup_cat_id");
        $display_page = $this->input->post("display_page");

        $main_data = array();
//        $where = " category_id='" . $superCategoryId . "'";

        if ($display_page == 'off_cat_cont')
            $where = " category_id='" . $superCategoryId . "' AND FIND_IN_SET(2, sub_category_type) > 0 ";
        else
            $where = " category_id='" . $superCategoryId . "' AND FIND_IN_SET(0, sub_category_type) > 0 ";

        $main_data['categories'] = $this->dbcommon->filter('sub_category', $where);
        echo $this->load->view('admin/banners/subCategoriesOptions', $main_data, TRUE);
        exit();
    }

    function getCategory() {
        $display_page = $this->input->post("display_page");
        $main_data = array();
        $where = " ";

        if ($display_page == 'off_cat_cont')
            $where = " FIND_IN_SET(2, category_type) > 0 ";
        else
            $where = " FIND_IN_SET(0, category_type) > 0 ";

        $main_data['categories'] = $this->dbcommon->filter('category', $where);

        echo $this->load->view('admin/banners/categoriesOptions', $main_data, TRUE);
        exit();
    }

    function addMoreCategory() {
        $curt_id = $this->input->post("curt_id");
        $main_id = $this->input->post("main_id");
        $display_page = $this->input->post("display_page");

        $main_data = array();

        $main_data['curInd2'] = $curt_id + 1;
        $main_data['curInd'] = 0;
        $main_data['superCategories'] = $this->dbcommon->select('category');

        if ($display_page == 'off_cat_cont')
            $where = " FIND_IN_SET(2, category_type) > 0 ";
        else
            $where = " FIND_IN_SET(0, category_type) > 0 ";

        $main_data['superCategories'] = $this->dbcommon->filter('category', $where);

        echo $this->load->view('admin/banners/addMoreCategoryAjax', $main_data, TRUE);
        exit();
    }

    function addMoreCompany() {
        $curt_id = $this->input->post("curt_id");
        $main_id = $this->input->post("main_id");
        $main_data = array();

        $main_data['curInd2'] = $curt_id + 1;
        $main_data['curInd'] = 0;
        $offer_company = ' is_delete = 0 ';
        $company = $this->dbcommon->filter('offer_user_company', $offer_company);
        $main_data['company'] = $company;

        echo $this->load->view('admin/banners/addMoreCompanyAjax', $main_data, TRUE);
        exit();
    }

    function addMoreStore() {
        $curt_id = $this->input->post("curt_id");
        $main_id = $this->input->post("main_id");
        $main_data = array();

        $main_data['curInd2'] = $curt_id + 1;
        $main_data['curInd'] = 0;

        $store_users = ' store_status = 0 and store_is_inappropriate="Approve"';
        $stores = $this->dbcommon->filter('store', $store_users);
        $main_data['stores'] = $stores;

        echo $this->load->view('admin/banners/addMoreStoreAjax', $main_data, TRUE);
        exit();
    }

}

?>