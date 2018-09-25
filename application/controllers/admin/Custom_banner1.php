<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Custom_banner extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('permission');
        $this->load->model('dbcommon');
        $this->load->model(	'dblogin');
		$this->per_page	=	10;
    }

    public function index() {
        
    }

    public function vipBanner($type = 0) {		
				
		$main_data = array();
		$where	='';
		$where1	='';		
		
		$main_data['flash_message'] = $this->session->flashdata('flash_message');
		$url 	= 	base_url() . "admin/custom_banner/vipBanner/".$type;
		
		$arr	=	array('header','sidebar','between');
		if(isset($_GET['ban_name_0']) && $_GET['ban_name_0']!='' && in_array($_GET['ban_name_0'],$arr)) {	
			$where1	= ' and ban_type_name="'.$_GET['ban_name_0'].'"';
			$url 	= 	base_url() . "admin/custom_banner/vipBanner/".$type."/".$this->uri->segment(5);
		}
		
		$where .= " ban_id from custom_banner where ";
		$where .= " ban_type='" . $type . "' ".$where1." order by ban_id desc";
				
		$main_data["links"]	=	$this->dbcommon->pagination($url,$where);

		$page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $this->per_page;
		
		$where = " ban_type='" . $type . "' ".$where1." order by ban_id desc limit ".$offset.','.$this->per_page;
		$main_data['superCategories'] = $this->dbcommon->filter('custom_banner', $where);				

		$this->load->view('admin/banners/vipBanner_list', $main_data);
    }
	
	public function CustomBanner($type = 0) {
        $data = array();
        $main_data = array();
		$where1	='';		
		$where	=	'';
		$url	=	site_url().'admin/custom_banner/CustomBanner/'.$type;		
		
		$arr	=	array('header','sidebar','between');
		if(isset($_GET['ban_name_0']) && $_GET['ban_name_0']!='' && in_array($_GET['ban_name_0'],$arr)) {			
			$where1	= ' and ban_type_name="'.$_GET['ban_name_0'].'"';		
			$url 	= 	base_url() . "admin/custom_banner/CustomBanner/".$type."?ban_name_0=".$_GET['ban_name_0'];
		}
		
        $main_data['flash_message'] = $this->session->flashdata('flash_message');
		
		$where .= " ban_id from custom_banner where ";
		$where .= " ban_type='" . $type . "' ".$where1." order by ban_id desc";
		
		$main_data["links"]	=	$this->dbcommon->pagination($url,$where);
		
		$page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $this->per_page;
		
		$main_data["links"] = $this->pagination->create_links();
			
		$where =''; 
		$where = " ban_type='" . $type . "' ".$where1." order by ban_id desc limit ".$offset.','.$this->per_page;
        $main_data['superCategories'] = $this->dbcommon->filter('custom_banner', $where);
		
        $this->load->view('admin/banners/CustomBanner_list', $main_data);
    }

    public function deletecustom($type = 11, $Id = 0) {
        $target_dir = document_root . banner;
        $data = array();
        $where = " where ban_id='" . $Id . "'";
        $banner = $this->dbcommon->getdetails('custom_banner', $where);
        if ($Id != null && !empty($banner)):
            $where = array("ban_id" => $Id);
            $user = $this->dbcommon->delete('custom_banner', $where);
            if ($user):
                @unlink($target_dir . "original/" . $banner[0]->img_file_name);
                @unlink($target_dir . "small/" . $banner[0]->img_file_name);
                @unlink($target_dir . "medium/" . $banner[0]->img_file_name);
                @unlink($target_dir . "original/" . $banner[0]->big_img_file_name);
                @unlink($target_dir . "small/" . $banner[0]->big_img_file_name);
                @unlink($target_dir . "medium/" . $banner[0]->big_img_file_name);
            endif;
            $this->session->set_flashdata(array('msg' => 'Banner deleted successfully', 'class' => 'alert-success'));
            redirect('admin/custom_banner/CustomBanner/' . $type);
        else:
            $this->session->set_flashdata(array('msg' => 'Banner not found', 'class' => 'alert-info'));
            redirect('admin/custom_banner/CustomBanner/' . $type);
        endif;
    }

    public function deletevip($type = 10, $Id = 0) {
        $target_dir = document_root . banner;
        $data = array();
        $where = " where ban_id='" . $Id . "'";
        $banner = $this->dbcommon->getdetails('custom_banner', $where);
        if ($Id != null && !empty($banner)):
            $where = array("ban_id" => $Id);
            $user = $this->dbcommon->delete('custom_banner', $where);
            if ($user):
                @unlink($target_dir . "original/" . $banner[0]->img_file_name);
                @unlink($target_dir . "small/" . $banner[0]->img_file_name);
                @unlink($target_dir . "medium/" . $banner[0]->img_file_name);
                @unlink($target_dir . "original/" . $banner[0]->big_img_file_name);
                @unlink($target_dir . "small/" . $banner[0]->big_img_file_name);
                @unlink($target_dir . "medium/" . $banner[0]->big_img_file_name);
            endif;
            $this->session->set_flashdata(array('msg' => 'Banner deleted successfully', 'class' => 'alert-success'));
            redirect('admin/custom_banner/vipBanner/' . $type);
        else:
            $this->session->set_flashdata(array('msg' => 'Banner not found', 'class' => 'alert-info'));
            redirect('admin/custom_banner/vipBanner/' . $type);
        endif;
    }

    public function addvip($type) {
        $this->load->helper("file");
        $data = array();
        $main_data = array();

        $main_data['type'] = $type;
        $main_data['title'] = "Vip Banner";
        $main_data['countries'] = $this->dbcommon->select('country');
        $main_data['superCategories'] = $this->dbcommon->select('category');
        $query="user_role != 'admin' and user_role != 'superadmin'";
        $main_data['advertiser'] = $this->dbcommon->filter('user',$query);
        $where = " country_id=4";
        $state = $this->dbcommon->filter('state', $where);
        $main_data['state'] = $state;
		$small_image	='';
        if (!empty($_POST)) {
            if ($_POST['ban_name_0'] == 'offer' || $_POST['ban_name_0'] == 'feature') {
                $i = 0;
                $data = array(
                    'cat_id' => 0,
                    'sup_cat_id' => 0,
                    'site_url' => $_POST['site_url_' . $i],
                    'ban_type_name' => $_POST['ban_name_' . $i],
                    'status' => $_POST['status_' . $i],
                    'ban_show_status' => $_POST['ban_show_status_' . $i],
                    'phone_no' => $_POST['phone_no_' . $i],
                    'pause_banner' => $_POST['pause_banner_' . $i],
                    'impression_day' => $_POST['impression_day_' . $i],
                    'clicks_day' => $_POST['clicks_day_' . $i],
                    'expiry_start_date' => $_POST['ex_st_dt_' . $i],
                    'ban_txt_img' => $_POST['ban_txt_img_' . $i],
                    'text_val' => $_POST['text_ad'],
                    'ban_type' => $type,
                    'advertiser' => $_POST['adv_' . $i],
                    'country' => 4,
                    'state' => $_POST['state']
                );

                if ($_POST['rd_cpm_cpc'] == 'cpm') {
                    $data['cpm'] = $_POST['cpc_cpm_' . $i];
                    $data['cpc'] = 0;
                } else {
                    $data['cpm'] = 0;
                    $data['cpc'] = $_POST['cpc_cpm_' . $i];
                }

                if ($_POST['ex_end_dt_' . $i] == '') {
                    $data['expiry_end_date'] = '0000-00-00';
                } else {
                    $data['expiry_end_date'] = $_POST['ex_end_dt_' . $i];
                }
                $result = $this->dbcommon->insert('custom_banner', $data);
                $bannerId = $this->dblogin->getLastInserted();
                if ($bannerId > 0) {
                    $picture = '';
                    if (isset($_FILES['uploadedfile_' . $i]['tmp_name']) && $_FILES['uploadedfile_' . $i]['tmp_name'] != '') {
                        $target_dir = document_root . banner;
                        $profile_picture = $_FILES['uploadedfile_' . $i]['name'];
                        $ext = explode(".", $_FILES['uploadedfile_' . $i]['name']);
                        $picture = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/sub_cat_add', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/sub_cat_add', $data);
                        } else {
                            if (move_uploaded_file($_FILES['uploadedfile_' . $i]["tmp_name"], $target_file)) {
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
                                    //if ($width < store_medium_thumb_width) {
                                    if ($width < 1600) {
                                        copy($target_file, $thumb);
                                    } else {
                                        //$this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                        $this->thumbnailer->thumbSymmetric(1600)->save($thumb);
                                    }
                                } else {
                                    //if ($height < store_medium_thumb_height) {
                                    if ($height < 86) {
                                        copy($target_file, $thumb);
                                    } else {
                                        //$small = $this->thumbnailer->thumbSymmetricHeight(store_medium_thumb_height)->save($thumb);
                                        $small = $this->thumbnailer->thumbSymmetricHeight(86)->save($thumb);
                                    }
                                }
                                $data = array(
                                    'img_file_name' => $picture
                                );
                                $array = array('ban_id' => $bannerId);
                                $this->dbcommon->update('custom_banner', $array, $data);
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
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/sub_cat_add', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/sub_cat_add', $data);
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
                                $data = array(
                                    'big_img_file_name' => $picture
                                );
                                $array = array('ban_id' => $bannerId);
                                $this->dbcommon->update('custom_banner', $array, $data);
                            }
                        }
                    }//----------------
                    $this->session->set_flashdata('flash_message', 'Banner successfully added.' . $message);
                }
                else
                    show_error("Banner add failed");
                redirect(base_url() . "admin/custom_banner/vipBanner/10");
            }
            else {
                $totalRecord = $_POST['total'];
                $picture = '';
                                    if (isset($_FILES['uploadedfile_' . 0]['tmp_name']) && $_FILES['uploadedfile_' . 0]['tmp_name'] != '') {
                                        $target_dir = document_root . banner;
                                        $profile_picture = $_FILES['uploadedfile_' . 0]['name'];
                                        $ext = explode(".", $_FILES['uploadedfile_' . 0]['name']);
                                        $picture = time() . "." . end($ext);
                                        $target_file = $target_dir . "original/" . $picture;
                                        $uploadOk = 1;
                                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                        // Allow certain file formats
                                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                            $data['msg_class'] = 'alert-info';
                                            $uploadOk = 0;
                                            $this->load->view('admin/category/sub_cat_add', $data);
                                        }
                                        if ($uploadOk == 0) {
                                            $data['msg'] = "Sorry, your file was not uploaded.";
                                            $data['msg_class'] = 'alert-info';
                                            $this->load->view('admin/category/sub_cat_add', $data);
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
                                                
                                                    $small_image = $picture;
                                                
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
                                        // Allow certain file formats
                                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                            $data['msg_class'] = 'alert-info';
                                            $uploadOk = 0;
                                            $this->load->view('admin/category/sub_cat_add', $data);
                                        }
                                        if ($uploadOk == 0) {
                                            $data['msg'] = "Sorry, your file was not uploaded.";
                                            $data['msg_class'] = 'alert-info';
                                            $this->load->view('admin/category/sub_cat_add', $data);
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
                                                
                                                    $big_image = $picture;
                                                
                                               
                                            }
                                        }
                                    }//----------------
                $rand	= rand(0,10);
			if($totalRecord>0) {	
				for ($i = 0; $i <= $totalRecord; $i++) {
                    $category_Array = $_POST['category_' . $i];

                    //// check total no of categories againts each banner
                    if (count($category_Array) > 0) {

                        $j = 0;
                        $smallFileName = "";
                        $largeFileName = "";
                        foreach ($category_Array as $category_id) {
                            $sup_category_id = $_POST['superCategory_0'][$j];
                            $j++;
                            if ($category_id >= 0) {
                                $data = array(
                                    'cat_id' => $sup_category_id,
                                    'sup_cat_id' => $category_id,
									'display_page'=>$_POST['display_page_0'],
                                    'site_url' => $_POST['site_url_' . $i],
                                    'ban_type_name' => $_POST['ban_name_' . $i],
                                    'status' => $_POST['status_' . $i],
                                    'ban_show_status' => $_POST['ban_show_status_' . $i],
                                    'phone_no' => $_POST['phone_no_' . $i],
                                    'pause_banner' => $_POST['pause_banner_' . $i],
                                    'impression_day' => $_POST['impression_day_' . $i],
                                    'clicks_day' => $_POST['clicks_day_' . $i],
                                    'expiry_start_date' => $_POST['ex_st_dt_' . $i],
                                    'ban_txt_img' => $_POST['ban_txt_img_' . $i],
                                    'text_val' => $_POST['text_ad'],
                                    'ban_type' => $main_data['type'],
                                    'advertiser' => $_POST['adv_' . $i],
                                    'country' => 4,
                                    'state' => $_POST['state'],
                                    'img_file_name' => $small_image,
                                    'big_img_file_name' => $big_image,
									'group_no'=>$rand									
                                );

                                if ($_POST['rd_cpm_cpc'] == 'cpm') {
                                    $data['cpm'] = $_POST['cpc_cpm_' . $i];
                                    $data['cpc'] = 0;
                                } else {
                                    $data['cpm'] = 0;
                                    $data['cpc'] = $_POST['cpc_cpm_' . $i];
                                }

                                if ($_POST['ex_end_dt_' . $i] == '') {
									$data['is_endate'] 		 =	'no';
                                    $data['expiry_end_date'] = '0000-00-00';
                                } else {
									$data['is_endate'] 		 =	'yes';
                                    $data['expiry_end_date'] = $_POST['ex_end_dt_' . $i];
                                }

                                $result = $this->dbcommon->insert('custom_banner', $data);
                                $bannerId = $this->dblogin->getLastInserted();
                                if ($bannerId > 0) {
                                    
                                    $this->session->set_flashdata('flash_message', 'Banner successfully added.' . $message);
                                }
                                else
                                    show_error("Banner add failed");
                            }
                        }
                    }
                }// for fover
                
			}
			else {					
				
				$data = array(
                                    'cat_id' => $_POST['superCategory_0'][0],
									'sup_cat_id' => $_POST['category_0'][0],
                                    'site_url' => $_POST['site_url_0'],
                                    'ban_type_name' => $_POST['ban_name_0'],
                                    'status' => $_POST['status_0'],
                                    'ban_show_status' => $_POST['ban_show_status_0'],
                                    'phone_no' => $_POST['phone_no_0'],
                                    'pause_banner' => $_POST['pause_banner_0'],
                                    'impression_day' => $_POST['impression_day_0'],
                                    'clicks_day' => $_POST['clicks_day_0'],
                                    'expiry_start_date' => $_POST['ex_st_dt_0'],
                                    'ban_txt_img' => $_POST['ban_txt_img_0'],
                                    'text_val' => $_POST['text_ad'],
                                    'ban_type' => $main_data['type'],
                                    'advertiser' => $_POST['adv_0'],
                                    'country' => 4,
                                    'state' => $_POST['state'],
                                    'img_file_name' => $small_image,
                                    'big_img_file_name' => $big_image,
									'display_page'=>$_POST['display_page_0'],
									'group_no'=>$rand	
                                );

                                if ($_POST['rd_cpm_cpc'] == 'cpm') {
                                    $data['cpm'] = $_POST['cpc_cpm_0'];
                                    $data['cpc'] = 0;
                                } else {
                                    $data['cpm'] = 0;
                                    $data['cpc'] = $_POST['cpc_cpm_0'];
                                }

                                if ($_POST['ex_end_dt_0'] == '') {
									$data['is_endate'] 		 =	'no';
                                    $data['expiry_end_date'] = '0000-00-00';
                                } else {
									$data['is_endate'] 		 =	'yes';
                                    $data['expiry_end_date'] = $_POST['ex_end_dt_0'];
                                }

                                $result = $this->dbcommon->insert('custom_banner', $data);
                                $bannerId = $this->dblogin->getLastInserted();
                                if ($bannerId > 0) {
                                    
                                    $this->session->set_flashdata('flash_message', 'Banner successfully added.' . $message);
                                }
                                else
                                    show_error("Banner add failed");	
					
			}
			
				redirect(base_url() . "admin/custom_banner/vipBanner/10");
            }
        }
        $this->load->view('admin/banners/addVipBanner', $main_data);
    }

    public function addcustom($type) {

       $this->load->helper("file");
        $data = array();
        $main_data = array();
        $main_data['type'] = $type;
        $main_data['title'] = "Custom Banner";
        $main_data['countries'] = $this->dbcommon->select('country');
        $where = " country_id=4";
        $state = $this->dbcommon->filter('state', $where);
        $main_data['state'] = $state;
        $main_data['superCategories'] = $this->dbcommon->select('category');
        $query="user_role != 'admin' and user_role != 'superadmin'";
        $main_data['advertiser'] = $this->dbcommon->filter('user',$query);

        if (!empty($_POST)) {
            if ($_POST['ban_name_0'] == 'offer' || $_POST['ban_name_0'] == 'feature') {
                $i = 0;
                $data = array(
                    'cat_id' => 0,
                    'sup_cat_id' => 0,
                    'site_url' => $_POST['site_url_' . $i],
                    'ban_type_name' => $_POST['ban_name_' . $i],
                    'status' => $_POST['status_' . $i],
                    'ban_show_status' => $_POST['ban_show_status_' . $i],
                    'phone_no' => $_POST['phone_no_' . $i],
                    'pause_banner' => $_POST['pause_banner_' . $i],
                    'impression_day' => $_POST['impression_day_' . $i],
                    'clicks_day' => $_POST['clicks_day_' . $i],
                    'expiry_start_date' => $_POST['ex_st_dt_' . $i],
                    'ban_txt_img' => $_POST['ban_txt_img_' . $i],
                    'text_val' => $_POST['text_ad'],
                    'ban_type' => $type,
                    'advertiser' => $_POST['adv_' . $i],
                    'country' => 4,
                    'state' => $_POST['state']
                );

                if ($_POST['rd_cpm_cpc'] == 'cpm') {
                    $data['cpm'] = $_POST['cpc_cpm_' . $i];
                    $data['cpc'] = 0;
                } else {
                    $data['cpm'] = 0;
                    $data['cpc'] = $_POST['cpc_cpm_' . $i];
                }

                if ($_POST['ex_end_dt_' . $i] == '') {
					$data['is_endate'] 		 =	'no';
                    $data['expiry_end_date'] =  '0000-00-00';
                } else {
					$data['is_endate'] 		 =	'yes';
                    $data['expiry_end_date'] =  $_POST['ex_end_dt_' . $i];
                }

                $result = $this->dbcommon->insert('custom_banner', $data);
                $bannerId = $this->dblogin->getLastInserted();
                if ($bannerId > 0) {
                    $picture = '';
                    if (isset($_FILES['uploadedfile_' . $i]['tmp_name']) && $_FILES['uploadedfile_' . $i]['tmp_name'] != '') {
                        $target_dir = document_root . banner;
                        $profile_picture = $_FILES['uploadedfile_' . $i]['name'];
                        $ext = explode(".", $_FILES['uploadedfile_' . $i]['name']);
                        $picture = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/sub_cat_add', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/sub_cat_add', $data);
                        } else {
                            if (move_uploaded_file($_FILES['uploadedfile_' . $i]["tmp_name"], $target_file)) {
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
                                $data = array(
                                    'img_file_name' => $picture
                                );
                                $array = array('ban_id' => $bannerId);
                                $this->dbcommon->update('custom_banner', $array, $data);
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
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/sub_cat_add', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/sub_cat_add', $data);
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
                                $data = array(
                                    'big_img_file_name' => $picture
                                );
                                $array = array('ban_id' => $bannerId);
                                $this->dbcommon->update('custom_banner', $array, $data);
                            }
                        }
                    }//----------------
                    $this->session->set_flashdata('flash_message', 'Banner successfully added.' . $message);
                }
                else
                    show_error("Banner add failed");
                redirect(base_url() . "admin/custom_banner/CustomBanner/11");
            }
            else {
                $totalRecord = $_POST['total'];
                $smallFileName = "";
                        $largeFileName = "";
                $picture = '';
                                    if (isset($_FILES['uploadedfile_0']['tmp_name']) && $_FILES['uploadedfile_0']['tmp_name'] != '') {
                                        $target_dir = document_root . banner;
                                        $profile_picture = $_FILES['uploadedfile_0']['name'];
                                        $ext = explode(".", $_FILES['uploadedfile_0']['name']);
                                        $picture = time() . "." . end($ext);
                                        $target_file = $target_dir . "original/" . $picture;
                                        $uploadOk = 1;
                                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                        // Allow certain file formats
                                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                            $data['msg_class'] = 'alert-info';
                                            $uploadOk = 0;
                                            $this->load->view('admin/category/sub_cat_add', $data);
                                        }
                                        if ($uploadOk == 0) {
                                            $data['msg'] = "Sorry, your file was not uploaded.";
                                            $data['msg_class'] = 'alert-info';
                                            $this->load->view('admin/category/sub_cat_add', $data);
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
                                        // Allow certain file formats
                                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                            $data['msg_class'] = 'alert-info';
                                            $uploadOk = 0;
                                            $this->load->view('admin/category/sub_cat_add', $data);
                                        }
                                        if ($uploadOk == 0) {
                                            $data['msg'] = "Sorry, your file was not uploaded.";
                                            $data['msg_class'] = 'alert-info';
                                            $this->load->view('admin/category/sub_cat_add', $data);
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
                                                $largeFileName=$picture;
                                                
                                            }
                                        }
                                    }//----------------
                
				$rand	= rand(0,10);
				if($totalRecord>0) {

					for ($i = 0; $i <= $totalRecord; $i++) {
						$category_Array = $_POST['category_' . $i];

						//// check total no of categories againts each banner
						if (count($category_Array) > 0) {
							$j = 0;
							foreach ($category_Array as $category_id) {
								$sup_category_id = $_POST['superCategory_0'][$j];
								$j++;
								if ($category_id >= 0) {
									$data = array(
										'cat_id' => $sup_category_id,
										'sup_cat_id' => $category_id,
										'site_url' => $_POST['site_url_' . $i],
										'ban_type_name' => $_POST['ban_name_' . $i],
										'status' => $_POST['status_' . $i],
										'ban_show_status' => $_POST['ban_show_status_' . $i],
										'phone_no' => $_POST['phone_no_' . $i],
										'pause_banner' => $_POST['pause_banner_' . $i],
										'impression_day' => $_POST['impression_day_' . $i],
										'clicks_day' => $_POST['clicks_day_' . $i],
										'expiry_start_date' => $_POST['ex_st_dt_' . $i],
										'ban_txt_img' => $_POST['ban_txt_img_' . $i],
										'text_val' => $_POST['text_ad'],
										'ban_type' => $main_data['type'],
										'advertiser' => $_POST['adv_' . $i],
										'country' => 4,
										'state' => $_POST['state'],
										'display_page'=>$_POST['display_page_0'],
										'img_file_name' => $smallFileName,
										'big_img_file_name' => $largeFileName,
										'group_no'=>$rand
									);
									if ($_POST['rd_cpm_cpc'] == 'cpm') {
										$data['cpm'] = $_POST['cpc_cpm_' . $i];
										$data['cpc'] = 0;
									} else {
										$data['cpm'] = 0;
										$data['cpc'] = $_POST['cpc_cpm_' . $i];
									}
									if ($_POST['ex_end_dt_' . $i] == '') {
										$data['expiry_end_date'] = '0000-00-00';
									} else {
										$data['expiry_end_date'] = $_POST['ex_end_dt_' . $i];
									}
									
									$result = $this->dbcommon->insert('custom_banner', $data);
									$bannerId = $this->dblogin->getLastInserted();
									if ($bannerId > 0) {
										$this->session->set_flashdata('flash_message', 'Banner successfully added.' . $message);
									}
									else
										show_error("Banner add failed"); 
								}
							}
						}
					}// For Loop Over       					
				}
				else
				{
					$data = array(
                                    'cat_id' => $_POST['superCategory_0'][0],
									'sup_cat_id' => $_POST['category_0'][0],
                                    'site_url' => $_POST['site_url_0'],
                                    'ban_type_name' => $_POST['ban_name_0'],
                                    'status' => $_POST['status_0'],
                                    'ban_show_status' => $_POST['ban_show_status_0'],
                                    'phone_no' => $_POST['phone_no_0'],
                                    'pause_banner' => $_POST['pause_banner_0'],
                                    'impression_day' => $_POST['impression_day_0'],
                                    'clicks_day' => $_POST['clicks_day_0'],
                                    'expiry_start_date' => $_POST['ex_st_dt_0'],
                                    'ban_txt_img' => $_POST['ban_txt_img_0'],
                                    'text_val' => $_POST['text_ad'],
                                    'ban_type' => $main_data['type'],
                                    'advertiser' => $_POST['adv_0'],
                                    'country' => 4,
                                    'state' => $_POST['state'],
									'display_page'=>$_POST['display_page_0'],
                                    'img_file_name' => $smallFileName,
                                    'big_img_file_name' => $largeFileName,
									'group_no'=>$rand
                                );
                                if ($_POST['rd_cpm_cpc'] == 'cpm') {
                                    $data['cpm'] = $_POST['cpc_cpm_0' ];
                                    $data['cpc'] = 0;
                                } else {
                                    $data['cpm'] = 0;
                                    $data['cpc'] = $_POST['cpc_cpm_0'];
                                }
                                if ($_POST['ex_end_dt_0'] == '') {
                                    $data['expiry_end_date'] = '0000-00-00';
                                } else {
                                    $data['expiry_end_date'] = $_POST['ex_end_dt_0'];
                                }
								
                                $result = $this->dbcommon->insert('custom_banner', $data);
                                $bannerId = $this->dblogin->getLastInserted();
								
                                if ($bannerId > 0) {
                                    $this->session->set_flashdata('flash_message', 'Banner successfully added.' . $message);
                                }
                                else
                                    show_error("Banner add failed");
				}
				redirect(base_url() . "admin/custom_banner/CustomBanner/11");
            }
        }
        $this->load->view('admin/banners/addCustomBanner', $main_data);
    }

    public function editvip($type = 10, $bannerId = 0) {
        $this->load->helper("file");
        $data = array();
        $main_data = array();
		if($bannerId>0) {
        $main_data['type'] = $type;
        $main_data['title'] = "Vip Banner";
        $main_data['countries'] = $this->dbcommon->select('country');
        $main_data['superCategories'] = $this->dbcommon->select('category');
        $main_data['advertiser'] = $this->dbcommon->select('user');
        $where = " where ban_id='" . $bannerId . "'";
        $banner_data = $this->dbcommon->getdetails('custom_banner', $where);
        $main_data['bannerInfo'] = $banner_data;
		if(sizeof($main_data['bannerInfo'])) {
        $where = "category_id='" . $banner_data[0]->cat_id . "'";
        $main_data['sub_cat'] = $this->dbcommon->filter('sub_category', $where);

        $where = "country_id='" . $banner_data[0]->country . "'";
        $sub_category = $this->dbcommon->filter('state', $where);
        $main_data['state'] = $sub_category;

        if (!empty($main_data['bannerInfo'])) {
            if (!empty($_POST)) {
				
                $updateData = array(
                    'ban_type_name' => $_POST['ban_name'],
                    'status' => $_POST['status'],
                    'ban_show_status' => $_POST['ban_show_status'],
                    'phone_no' => $_POST['phone_no'],
                    'pause_banner' => $_POST['pause_banner'],
                    'impression_day' => $_POST['impression_day'],
                    'clicks_day' => $_POST['clicks_day'],
                    'ban_txt_img' => $_POST['ban_txt_img'],
                    'ban_type' => $type,
                    'advertiser' => $_POST['adv'],
                    'country' => 4,
                    'state' => $_POST['state'],
					'display_page'=>$_POST['display_page_0']				
                );
				
                if ($_POST['display_page_0'] == 'all_page' || $_POST['display_page_0'] == 'home_page') {
                    $updateData['sup_cat_id'] = 0;
                    $updateData['cat_id'] = 0;
                } else {
                    $updateData['sup_cat_id'] = $_POST['sub_category'];
                    $updateData['cat_id'] = $_POST['super_category'];
                }
				
                if ($_POST['rd_cpm_cpc'] == 'cpm') {
                    $updateData['cpm'] = $_POST['cpc_cpm'];
                    $updateData['cpc'] = 0;
                } else {
                    $updateData['cpm'] = 0;
                    $updateData['cpc'] = $_POST['cpc_cpm'];
                }
                if ($_POST['st_dt'] == 'st_now') {
                    $updateData['expiry_start_date'] = date('Y-m-d');
                } else {
                    $updateData['expiry_start_date'] = $_POST['ex_st_dt'];
                }
                if ($_POST['end_dt'] == 'end_never') {
					$updateData['is_endate'] 		 =	'no';                    
                    $updateData['expiry_end_date'] = '';
                } else {
					$updateData['is_endate'] 		 =	'yes';
                    $updateData['expiry_end_date'] = $_POST['ex_end_dt'];
                }
                if ($_POST['ban_txt_img'] == "text") {
                    $updateData['site_url'] = "";
                    $updateData['text_val'] = $_POST['text_ad'];
                    $updateData['big_img_file_name'] = "";
                    $updateData['img_file_name'] = "";
                   if ($banner_data[0]->big_img_file_name != "") {
                        @unlink($target_dir . "original/" . $banner_data[0]->big_img_file_name);
                        @unlink($target_dir . "small/" . $banner_data[0]->big_img_file_name);
                        @unlink($target_dir . "medium/" . $banner_data[0]->big_img_file_name);
                    }
                    if ($banner_data[0]->img_file_name != "") {
                        @unlink($target_dir . "original/" . $banner_data[0]->img_file_name);
                        @unlink($target_dir . "small/" . $banner_data[0]->img_file_name);
                        @unlink($target_dir . "medium/" . $banner_data[0]->img_file_name);
                    }
                } else {
                    $picture = '';
                    if (isset($_FILES['uploadedfile']['tmp_name']) && $_FILES['uploadedfile']['tmp_name'] != '') {
                        $target_dir = document_root . banner;
                        $profile_picture = $_FILES['uploadedfile']['name'];
                        $ext = explode(".", $_FILES['uploadedfile']['name']);
                        $picture = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/sub_cat_add', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/sub_cat_add', $data);
                        } else {
                            if (move_uploaded_file($_FILES['uploadedfile' . $i]["tmp_name"], $target_file)) {
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
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/sub_cat_add', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/sub_cat_add', $data);
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
                    $updateData['text_val'] = "";
                    $updateData['site_url'] = $_POST['site_url'];
                }
                $array = array('ban_id' => $bannerId);
                $result = $this->dbcommon->update('custom_banner', $array, $updateData);

                $this->session->set_flashdata('flash_message', 'Banner successfully updated.');
                redirect(base_url() . "admin/custom_banner/vipBanner/" . $main_data['type']);
            }
            $data['title'] = "Edit | Banner ";
            $this->load->view('admin/banners/editVipBanner', $main_data);
        } else {
            show_error("Banner Not Found.");
        }
		}
		else
		{
			$this->session->set_flashdata('flash_message', 'Banner not found.');
			redirect(base_url() . "admin/custom_banner/vipBanner/10");
		}
		}
		else
		{
			$this->session->set_flashdata('flash_message', 'Banner not found.');
			redirect(base_url() . "admin/custom_banner/vipBanner/10");
		}
	
	}

    public function editcustom($type = 11, $bannerId = 0) {

        $this->load->helper("file");
        $data = array();
        $main_data = array();
		if($bannerId>0) {
        $main_data['type'] = $type;
        $main_data['title'] = "Custom Banner";
        $main_data['countries'] = $this->dbcommon->select('country');

        $main_data['superCategories'] = $this->dbcommon->select('category');
        $main_data['advertiser'] = $this->dbcommon->select('user');
        $where = " where ban_id='" . $bannerId . "'";
        $banner_data = $this->dbcommon->getdetails('custom_banner', $where);
        $main_data['bannerInfo'] = $banner_data;
		
		if(sizeof($main_data['bannerInfo'])>0) {
        $where = "category_id='" . $banner_data[0]->cat_id . "'";
        $main_data['sub_cat'] = $this->dbcommon->filter('sub_category', $where);
		
        $where = "country_id='" . $banner_data[0]->country . "'";
        $sub_category = $this->dbcommon->filter('state', $where);
        $main_data['state'] = $sub_category;

        if (!empty($main_data['bannerInfo'])) {
            if (!empty($_POST)) {
				
                $updateData = array(
                    'ban_type_name' => $_POST['ban_name'],
                    'status' => $_POST['status'],
                    'ban_show_status' => $_POST['ban_show_status'],
                    'phone_no' => $_POST['phone_no'],
                    'pause_banner' => $_POST['pause_banner'],
                    'impression_day' => $_POST['impression_day'],
                    'clicks_day' => $_POST['clicks_day'],
                    'ban_txt_img' => $_POST['ban_txt_img'],
                    'ban_type' => $type,
                    'advertiser' => $_POST['adv'],
                    'country' => 4,
                    'state' => $_POST['state'],
                    'display_page'=>$_POST['display_page_0']
                );
				
                //if ($_POST['ban_name'] == 'offer' || $_POST['ban_name'] == 'feature') {				
                if ($_POST['display_page_0'] == 'all_page' || $_POST['display_page_0'] == 'home_page') {
                    $updateData['sup_cat_id'] = 0;
                    $updateData['cat_id'] = 0;
                } else {
                    $updateData['sup_cat_id'] = $_POST['sub_category'];
                    $updateData['cat_id'] = $_POST['super_category'];
                }
                if ($_POST['cpc_cpm'] == 'cpm') {
                    $updateData['cpm'] = $_POST['cpc_cpm'];
                    $updateData['cpc'] = 0;
                } else {
                    $updateData['cpm'] = 0;
                    $updateData['cpc'] = $_POST['cpc_cpm'];
                }

                if ($_POST['st_dt'] == 'st_now') {
                    $updateData['expiry_start_date'] = date('Y-m-d');
                } else {
                    $updateData['expiry_start_date'] = $_POST['ex_st_dt'];
                }
                if ($_POST['end_dt'] == 'end_never') {
					$updateData['is_endate']	   =	'no';
                    $updateData['expiry_end_date'] = 	'0000-00-00';
                } else {
					$updateData['is_endate']	   =	'yes';
                    $updateData['expiry_end_date'] = $_POST['ex_end_dt'];
                }
                if ($_POST['ban_txt_img'] == "text") {
                    $updateData['site_url'] = "";
                    $updateData['text_val'] = $_POST['text_ad'];
                    $updateData['big_img_file_name'] = "";
                    $updateData['img_file_name'] = "";
//                    print_r($main_data['bannerInfo']);die;
                    if ($banner_data[0]->big_img_file_name != "") {
                        @unlink($target_dir . "original/" . $banner_data[0]->big_img_file_name);
                        @unlink($target_dir . "small/" . $banner_data[0]->big_img_file_name);
                        @unlink($target_dir . "medium/" . $banner_data[0]->big_img_file_name);
                    }
                    if ($banner_data[0]->img_file_name != "") {
                        @unlink($target_dir . "original/" . $banner_data[0]->img_file_name);
                        @unlink($target_dir . "small/" . $banner_data[0]->img_file_name);
                        @unlink($target_dir . "medium/" . $banner_data[0]->img_file_name);
                    }
                } else {
                    $picture = '';
                    if (isset($_FILES['uploadedfile']['tmp_name']) && $_FILES['uploadedfile']['tmp_name'] != '') {
                        $target_dir = document_root . banner;
                        $profile_picture = $_FILES['uploadedfile' . $i]['name'];
                        $ext = explode(".", $_FILES['uploadedfile' . $i]['name']);
                        $picture = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/sub_cat_add', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/sub_cat_add', $data);
                        } else {
                            if (move_uploaded_file($_FILES['uploadedfile' . $i]["tmp_name"], $target_file)) {
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
											$mywidth	=	store_medium_thumb_width;
                                    //if ($width < store_medium_thumb_width) {
                                    if ($width < $mywidth) {
                                        copy($target_file, $thumb);
                                    } else {
                                        $this->thumbnailer->thumbSymmetric(store_medium_thumb_width)->save($thumb);
                                    }
                                } else {										
									$myheight	=	store_medium_thumb_height;											
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
                        // Allow certain file formats
						
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {						
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/sub_cat_add', $data);
                        }
                        if ($uploadOk == 0) {						
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/sub_cat_add', $data);
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
                    $updateData['text_val'] = "";
                    $updateData['site_url'] = $_POST['site_url'];
                }
                $array = array('ban_id' => $bannerId);
                $result = $this->dbcommon->update('custom_banner', $array, $updateData);

                $this->session->set_flashdata('flash_message', 'Banner successfully updated.');
                redirect(base_url() . "admin/custom_banner/CustomBanner/" . $main_data['type']);
            }

            $this->load->view('admin/banners/editCustomBanner', $main_data);
        } else {
            show_error("Banner Not Found.");
        }
		}
		else
		{
			$this->session->set_flashdata('flash_message', 'Banner not found.');
			redirect(base_url() . "admin/custom_banner/CustomBanner/11");	
		}
		}		
		else
		{
			$this->session->set_flashdata('flash_message', 'Banner not found.');
			redirect(base_url() . "admin/custom_banner/CustomBanner/11");
		}

    }

    function filterBannerList() {
	
		$type 		= $this->input->get_post("type");
        $ban_name   = $this->input->get_post("name");
        $main_data  = array();
		
		if ($ban_name == 'all') {
           $query = " ban_id from custom_banner where ban_type=" . $type;            
        } else {
            $query = " ban_id from custom_banner where  ban_type= '" . $type . "' and ban_type_name = '" . $ban_name . "'";            
        }
		if($type==10)
			$url1	=	$url1 = base_url() . "admin/custom_banner/vipBanner";
		else
			$url1	=	$url1 = base_url() . "admin/custom_banner/CustomBanner";
			
		if($type!='')
			$url1 .= '/'.$type;
		if($ban_name !='')
			$url1 .= '/'.$ban_name;
			
		$main_data["links"]	=	$this->dbcommon->pagination($url1,$query);
		
		$page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $this->per_page;
		
		$query = '';
        if ($ban_name == 'all') {
            $query = "ban_type=" . $type. " order by ban_id desc limit 0,".$this->per_page;
            $main_data['superCategories'] = $this->dbcommon->filter('custom_banner', $query);
        } else {
            $query = "ban_type= '" . $type . "' and ban_type_name = '" . $ban_name . "' order by ban_id desc limit 0,".$this->per_page;
            $main_data['superCategories'] = $this->dbcommon->filter('custom_banner', $query);
        }
		
		$main_data['type'] = $type;
		echo $this->load->view('admin/banners/BannerList', $main_data, TRUE);						
    }

    function getSubCategory() {
        $superCategoryId = $this->input->post("sup_cat_id");
        $main_data = array();
        $where = " category_id='" . $superCategoryId . "'";
        $main_data['categories'] = $this->dbcommon->filter('sub_category', $where);
        echo $this->load->view('admin/banners/subCategoriesOptions', $main_data, TRUE);
        exit();
    }

    function addMoreCategory() {
        $curt_id = $this->input->post("curt_id");
        $main_id = $this->input->post("main_id");
        $main_data = array();
        $main_data['curInd2'] = $curt_id + 1;
        $main_data['curInd']  = $main_id;
        $main_data['superCategories'] = $this->dbcommon->select('category');
        echo $this->load->view('admin/banners/addMoreCategoryAjax', $main_data, TRUE);
        exit();
    }
}
?>