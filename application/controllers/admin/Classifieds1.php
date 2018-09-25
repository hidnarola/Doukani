<?php
// include('font_array.php');
class Classifieds extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);
        $this->load->library('permission');
        // $this->load->library('UploadHandler');
    }

    public function categories() {

        $category = $this->dbcommon->select('category');

        $data['category'] = $category;
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/category/index', $data);
    }

    function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
    public function categories_add() {
        
        $data = array();
        $user = $this->session->userdata('user');
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';

        $target_dir = base_url() . front_fontawesome.'font-awesome.css';
        $subject = $this->file_get_contents_curl($target_dir);
        // $subject = file_get_contents(document_root . front_fontawesome.'font-awesome.css');
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach($matches as $match){
            $icons[] = $match[1];
        }
       
        $data['icons'] = $icons;
 
        if (!empty($_POST)):
            // validation 
            $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $this->session->set_userdata('admin_login', '');
                $data['msg'] = "Please fill all required fields";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/category/add', $data);
            else:
                //print_r($_FILES); die;

                $picture = '';
                if (isset($_FILES['cat_image']['tmp_name']) && $_FILES['cat_image']['tmp_name'] != '') {
                    $target_dir = document_root . category;
                    $profile_picture = $_FILES['cat_image']['name'];
                    $ext = explode(".", $_FILES["cat_image"]['name']);
                    $picture = time() . "." . end($ext);
                    $target_file = $target_dir . "original/" . $picture;
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $data['msg_class'] = 'alert-info';
                        $uploadOk = 0;
                        $this->load->view('admin/category/add', $data);
                    }
                    if ($uploadOk == 0) {
                        $data['msg'] = "Sorry, your file was not uploaded.";
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/category/add', $data);
                    } else {
                       
                        if (move_uploaded_file($_FILES["cat_image"]["tmp_name"], $target_file)) {
                           
                            $this->load->library('Thumbnailer');
							
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
                        }
                    }
                }
                // $query = "SELECT max(cat_order)as cat_order  FROM `classified_app`.`category`";
                $query = "SELECT max(cat_order)as cat_order  FROM `category`";
                $result = $this->dbcommon->get_distinct($query);

                $save_data = array(
                    'catagory_name' => $_POST['cat_name'],
                    'category_image' => $picture,
                    'is_parent' => 0,
                    'cat_order' => $result[0]['cat_order'] + 1,
                    'icon'=> $_POST['select_icons'],
                    'color'=>$_POST['cat_color']
                );
                $result = $this->dbcommon->insert('category', $save_data);
                if ($result):
                    $data['msg'] = 'Category added successfully.';
                    $data['msg_class'] = 'alert-success';
                    redirect('admin/classifieds/categories');
                else:
                    $data['msg'] = 'Category not added, Please try again';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/category/add', $data);
                endif;
            endif;
        else:
            $this->load->view('admin/category/add', $data);
        endif;
    }

    public function categories_edit($cat_id = null) {
        $data = array();
        $where = " where category_id='" . $cat_id . "'";
        $category = $this->dbcommon->getdetails('category', $where);
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';
        // $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
        $target_dir = base_url() . front_fontawesome.'font-awesome.css';
        $subject = $this->file_get_contents_curl($target_dir);
        // $subject = file_get_contents(document_root . front_fontawesome.'font-awesome.css');
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach($matches as $match){
            $icons[] = $match[1];
        }
        $data['icons'] = $icons;
        
        if ($cat_id != null && !empty($category)):
            $data['category'] = $category;
            if (!empty($_POST)):
                $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
                    $this->session->set_userdata('admin_login', '');
                    $data['msg'] = "Please fill all required fields";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/category/edit', $data);
                else:
                    $picture = $category[0]->category_image;
                    if (isset($_FILES['cat_image']['tmp_name']) && $_FILES['cat_image']['tmp_name'] != '') {
                        $target_dir = document_root . category;
                        $profile_picture = $_FILES['cat_image']['name'];
                        $ext = explode(".", $_FILES["cat_image"]['name']);
                        $picture = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/edit', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/edit', $data);
                        } else {
                            if (move_uploaded_file($_FILES["cat_image"]["tmp_name"], $target_file)) {
                                $this->load->library('thumbnailer');
                                $this->thumbnailer->prepare($target_file);
                                list($width, $height, $type, $attr) = getimagesize($target_file);
                                @unlink($target_dir . "original/" . $category[0]->category_image);
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
                                @unlink($target_dir . "small/" . $category[0]->category_image);
                                @unlink($target_dir . "medium/" . $category[0]->category_image);
                            }
                        }
                    }
                    $data = array(
                        'catagory_name' => $_POST['cat_name'],
                        'category_image' => $picture,
                        'is_parent' => 0,
                        'icon'=>$_POST['select_icons'],
                        'color'=>$_POST['cat_color']
                    );
                    $array = array('category_id' => $category[0]->category_id);
                    $result = $this->dbcommon->update('category', $array, $data);
                    if ($result):
                        $data['msg'] = 'Category added successfully.';
                        $data['msg_class'] = 'alert-success';
                        redirect('admin/classifieds/categories');
                    else:
                        $data['msg'] = 'Category not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/category/edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/category/edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Category not found', 'class' => 'alert-info'));
            redirect('admin/classifieds/categories');
        endif;
    }

    public function categories_delete($cat_id = null) {
        $target_dir = document_root . category;
        $data = array();
        $where = " where category_id='" . $cat_id . "'";
        $category = $this->dbcommon->getdetails('category', $where);
        if ($cat_id != null && !empty($category)):
            $where = array("category_id" => $cat_id);
            $user = $this->dbcommon->delete('category', $where);
            if ($user):
                @unlink($target_dir . "original/" . $category[0]->category_image);
                @unlink($target_dir . "small/" . $category[0]->category_image);
                @unlink($target_dir . "medium/" . $category[0]->category_image);
            endif;
            $this->session->set_flashdata(array('msg' => 'Category deleted successfully', 'class' => 'alert-success'));
            redirect('admin/classifieds/categories');
        else:
            $this->session->set_flashdata(array('msg' => 'Category not found', 'class' => 'alert-info'));
            redirect('admin/classifieds/categories');
        endif;
    }

//    Sub Categories Functions
    public function subCategories($cat_id = null) {
        $data = array();

        $array = array("category_id" => $cat_id);
        $parent_category = $this->dbcommon->get_row('category', $array);
        $data['parent_category'] = $parent_category;
        $where = " category_id='" . $cat_id . "'";
        $category = $this->dbcommon->filter('sub_category', $where);

        if ($cat_id != null && !empty($category)):
            $data['category'] = $category;
        endif;

        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;

        $data['cat_id'] = $cat_id;
        $this->load->view('admin/category/sub_cat_index', $data);
    }

    public function subCategories_add($cat_id = null) {
        $data = array();

        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';

        $target_dir = base_url() . front_fontawesome.'font-awesome.css';
        $subject = $this->file_get_contents_curl($target_dir);
        // $subject = file_get_contents(document_root . front_fontawesome.'font-awesome.css');
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach($matches as $match){
            $icons[] = $match[1];
        }
       
        $data['icons'] = $icons;

        $user = $this->session->userdata('user');
        if (!empty($_POST)):
            // validation 
            $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $this->session->set_userdata('admin_login', '');
                $data['msg'] = "Please fill all required fields";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/category/sub_cat_add', $data);
            else:
                $picture = '';
                if (isset($_FILES['cat_image']['tmp_name']) && $_FILES['cat_image']['tmp_name'] != '') {
                    $target_dir = document_root . category;
                    $profile_picture = $_FILES['cat_image']['name'];
                    $ext = explode(".", $_FILES["cat_image"]['name']);
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
                        if (move_uploaded_file($_FILES["cat_image"]["tmp_name"], $target_file)) {
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
                        }
                    }
                }
                // $query = "SELECT max(sub_cat_order)as sub_cat_order  FROM `classified_app`.`sub_category` where category_id=$cat_id";
                $query = "SELECT max(sub_cat_order)as sub_cat_order  FROM `sub_category` where category_id=$cat_id";
                $result = $this->dbcommon->get_distinct($query);
                if ($result[0]['sub_cat_order'] == NULL || $result[0]['sub_cat_order'] == "") {
                    $sub_cat_order = 1;
                } else {
                    $sub_cat_order = $result[0]['sub_cat_order'] + 1;
                }

                $data = array(
                    'sub_category_name' => $_POST['cat_name'],
                    'sub_category_image' => $picture,
                    'category_id' => $cat_id,
                    'sub_cat_order' => $sub_cat_order,
                    'icon' => $_POST['select_icons']
                );
                $result = $this->dbcommon->insert('sub_category', $data);
                if ($result):
                    $num_row = $this->dbcommon->getnumofdetails_("* from sub_category where category_id = " . $cat_id . "");
                    if ($num_row > 0) {
                        $data = array(
                            'is_parent' => 1
                        );
                        $array = array('category_id' => $cat_id);
                        $result = $this->dbcommon->update('category', $array, $data);
                    }
                    $data['msg'] = 'Sub Category added successfully.';
                    $data['msg_class'] = 'alert-success';
                    redirect('admin/classifieds/subCategories/' . $cat_id);
                else:
                    $data['msg'] = 'Sub Category not added, Please try again';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/category/sub_cat_add', $data);
                endif;
            endif;
        else:
            $data['cat_id'] = $cat_id;
            $this->load->view('admin/category/sub_cat_add', $data);
        endif;
    }

    public function subCategories_edit($cat_id = null) {
        $data = array();

        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';

        $target_dir = base_url() . front_fontawesome.'font-awesome.css';
        $subject = $this->file_get_contents_curl($target_dir);
        // $subject = file_get_contents(document_root . front_fontawesome.'font-awesome.css');
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach($matches as $match){
            $icons[] = $match[1];
        }
       
        $data['icons'] = $icons;

        $where = " where sub_category_id='" . $cat_id . "'";
        $category = $this->dbcommon->getdetails('sub_category', $where);
        if ($cat_id != null && !empty($category)):
            $data['category'] = $category;
            if (!empty($_POST)):
                $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
                    $this->session->set_userdata('admin_login', '');
                    $data['msg'] = "Please fill all required fields";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/category/sub_cat_edit', $data);
                else:
                    $picture = $category[0]->sub_category_image;
                    if (isset($_FILES['cat_image']['tmp_name']) && $_FILES['cat_image']['tmp_name'] != '') {
                        $target_dir = document_root . category;
                        $profile_picture = $_FILES['cat_image']['name'];
                        $ext = explode(".", $_FILES["cat_image"]['name']);
                        $picture = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/edit', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/category/edit', $data);
                        } else {
                            if (move_uploaded_file($_FILES["cat_image"]["tmp_name"], $target_file)) {
                                $this->load->library('thumbnailer');
                                $this->thumbnailer->prepare($target_file);
                                list($width, $height, $type, $attr) = getimagesize($target_file);
                                @unlink($target_dir . "original/" . $category[0]->sub_category_image);
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
                                @unlink($target_dir . "small/" . $category[0]->sub_category_image);
                                @unlink($target_dir . "medium/" . $category[0]->sub_category_image);
                            }
                        }
                    }
                    $data = array(
                        'sub_category_name' => $_POST['cat_name'],
                        'sub_category_image' => $picture,
                        'icon' => $_POST['select_icons']
                    );
                    $array = array('sub_category_id' => $category[0]->sub_category_id);
                    $result = $this->dbcommon->update('sub_category', $array, $data);
                    if ($result):
                        $data['msg'] = 'Sub Category added successfully.';
                        $data['msg_class'] = 'alert-success';
                        redirect('admin/classifieds/subCategories/' . $category[0]->category_id);
                    else:
                        $data['msg'] = 'Sub Category not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/category/sub_cat_edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/category/sub_cat_edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Sub Category not found', 'class' => 'alert-info'));
            redirect('classifieds/subCategories/' . $category[0]->category_id);
        endif;
    }

    public function subCategories_delete($cat_id = null) {
        $target_dir = document_root . category;
        $data = array();
        $where = " where sub_category_id='" . $cat_id . "'";
        $category = $this->dbcommon->getdetails('sub_category', $where);
        if ($cat_id != null && !empty($category)):
            $where = array("sub_category_id" => $cat_id);
            $user = $this->dbcommon->delete('sub_category', $where);
            if ($user):
                @unlink($target_dir . "original/" . $category[0]->sub_category_image);
                @unlink($target_dir . "small/" . $category[0]->sub_category_image);
                @unlink($target_dir . "medium/" . $category[0]->sub_category_image);
            endif;
            $num_row = $this->dbcommon->getnumofdetails_("* from sub_category where category_id = " . $category[0]->category_id . "");
            if ($num_row < 1) {
                $data = array(
                    'is_parent' => 0
                );
                $array = array('category_id' => $category[0]->category_id);
                $result = $this->dbcommon->update('category', $array, $data);
            }
            $this->session->set_flashdata(array('msg' => 'Sub Category deleted successfully', 'class' => 'alert-success'));
            redirect('admin/classifieds/subCategories/' . $category[0]->category_id);
        else:
            $this->session->set_flashdata(array('msg' => 'Sub Category not found', 'class' => 'alert-info'));
            redirect('admin/classifieds/subCategories/' . $category[0]->category_id);
        endif;
    }

//    Listing function
    public function listings() {
        $user = $this->session->userdata('user');
        if ($user->user_role == 'generalUser') {
			$query = "SELECT p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate , 
                c.catagory_name FROM product as p , category as c where p.is_delete = 0 and p.category_id=c.category_id and 
                p.product_is_inappropriate != 'Inappropriate' and p.product_posted_by = " . $user->user_id;
        } else {		
            $query = "SELECT p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate , 
                c.catagory_name 
				FROM product as p 
				left join category as c on c.category_id=p.category_id
				where p.is_delete = 0 and p.category_id=c.category_id and p.product_is_inappropriate != 'Inappropriate' ";
				// 
        }
        //$product = $this->db->query("SELECT p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate , 
          //      c.catagory_name FROM product as p , category as c where p.is_delete = 0 and p.category_id=c.category_id and p.product_is_inappropriate != 'Inappropriate' ");
		$product =$this->dbcommon->get_distinct($query);
		//$this->dbcommon->filter('product', $query);
        $data['product'] = $product;

        $data['spam'] = "";
        $data['user_role'] = $user->user_role;
        $category = $this->dbcommon->select('category');
        $data['category'] = $category;
        $location = $this->dbcommon->select('country');
        $data['location'] = $location;
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/listings/index', $data);
    }

    public function listings_add() {
         
         $data = array();

        $colors = $this->dbcommon->getcolorlist();
        $data['colors'] = $colors;  
        
        $brand = $this->dbcommon->getbrandlist();
        $data['brand']  = $brand;
        
        $mileage = $this->dbcommon->getmileagelist();
        $data['mileage']    = $mileage; 
        
        $user = array($this->session->userdata('user'));
        $category = $this->dbcommon->select('category');
        $data['category'] = $category;
        $category = $this->dbcommon->select('sub_category');
        $data['sub_category'] = $category;

        $location = $this->dbcommon->select('country');
        $data['location'] = $location;
        $where = "country_id=4";
        $state = $this->dbcommon->filter('state', $where);
        $data['state'] = $state;
        if (!empty($_POST)):
            // echo '<pre>';
            // print_r($_POST);
            // print_r($_FILES);
            // echo '</pre>';
            

            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $str = substr(str_shuffle($chars), 0, 3);
            $num = rand(10, 99);

            $where = " where category_id='" . $_POST['cat_id'] . "'";
            $cat_name = $this->dbcommon->getdetails('category', $where);

            $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));

            $images_num = 0;
			if(isset($_FILES))
				$images_num =  sizeof($_FILES);
            // if(isset($_FILES['multiUpload']['name'])){
                // $images_num = sizeof($_FILES['multiUpload']['name']);
            // }
			
            $picture_ban =array();
            if($images_num > 0){
            for ($i = 1; $i <= $images_num; $i++) {
						//echo 'start'.$_SERVER['DOCUMENT_ROOT'].'=>'.'stop';
                       $picture_ban[$i] = '';
                    // if (isset($_FILES['pro_image_' . $i]['tmp_name']) && $_FILES['pro_image_' . $i]['tmp_name'] != '') {
                    if (isset($_FILES['multiUpload'.$i]['tmp_name'][$i]) && $_FILES['multiUpload'.$i]['tmp_name'][$i] != '') {
						//print_r($_FILES);
                        $target_dir = document_root . product;
                        $profile_picture = $_FILES['multiUpload'.$i]['name'];
                        $ext = explode(".", $_FILES['multiUpload'.$i]['name']);
                        $picture_ban[$i] = time() . $i . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture_ban[$i];
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "mp4") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/listings/add', $data);
                         }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/listings/add', $data);
                        } else {
                            if (move_uploaded_file($_FILES['multiUpload'.$i]['tmp_name'], $target_file)) {
								
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    
                                } else {
                                    $this->load->library('thumbnailer');
                                    $this->thumbnailer->prepare($target_file);
                                    list($width, $height, $type, $attr) = getimagesize($target_file);
                                    /* Image Processing */
                                    $thumb = $target_dir . "small/" . $picture_ban[$i];
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
                                    $thumb = $target_dir . "medium/" . $picture_ban[$i];
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
                                }
                            }
                        }
                    }
                }
				
            }
                $proid = 0;
			
            if(isset($_POST['default_submit'])) {

                $this->form_validation->set_rules('pro_name', 'Product Name', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $this->session->set_userdata('admin_login', '');
                $data['msg'] = "Please fill all required fields ";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/listings/add', $data);
            else:
                 $pro = strtoupper(substr($_POST['pro_name'], 0, 2));
                $pro_code = $cat . $pro . $num . $str;

                $data = array(
                    'product_code' => $pro_code,
                    'product_name' => $_POST['pro_name'],
                    'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                    'category_id' => $_POST['cat_id'],
                    'sub_category_id' => $_POST['sub_cat'],
                    'product_description' => $_POST['pro_desc'],
                    'product_price' =>str_replace(",","",$_POST['pro_price']),
                    'product_posted_time' => date('y-m-d H:i:s'),
                    'product_brand' => 0,
                    'product_posted_by' => $user[0]->user_id,
                    'country_id' => 4,
                    'state_id' => $_POST['state']
                );
                $result = $this->dbcommon->insert('product', $data);		
                $proid = $this->dblogin->getLastInserted();
            endif;
			
            }
		
            if(isset($_POST['vehicle_submit'])){
                $this->form_validation->set_rules('title', 'Ad Title', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $this->session->set_userdata('admin_login', '');
                $data['msg'] = "Please fill all required fields ";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/listings/add', $data);
            else:
                 $pro = strtoupper(substr($_POST['title'], 0, 2));
                $pro_code = $cat . $pro . $num . $str;

                $data = array(
                    'product_code' => $pro_code,
                    'product_name' => $_POST['title'],
                    'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                    'category_id' => $_POST['cat_id'],
                    'sub_category_id' => $_POST['sub_cat'],
                    'state_id' => $_POST['state'],
					'product_brand' => $_POST['pro_brand'],
                    'product_description' => $_POST['vehicle_pro_desc'],
                    'product_price' => str_replace(",","",$_POST['vehicle_pro_price']),
                    'product_posted_time' => date('y-m-d H:i:s'),
                    'product_posted_by' => $user[0]->user_id,
                    
                );

                $result = $this->dbcommon->insert('product', $data);
                $proid = $this->dblogin->getLastInserted();
                $data_extras = array(
                            'product_id' => $proid,
                            'make' =>'',
                            'model' => $_POST['vehicle_pro_model'],
                            'type_of_car' => $_POST['vehicle_pro_type_of_car'],
                            'color' => $_POST['vehicle_pro_color'],
                            'millage' => $_POST['vehicle_pro_mileage'],
                            'vehicle_condition' => $_POST['vehicle_pro_condition'],
                            'year' => $_POST['vehicle_pro_year']
                        );
                        $result = $this->dbcommon->insert('product_vehicles_extras', $data_extras);
                endif;
            }

            if(isset($_POST['real_estate_houses_submit'])){
                 $this->form_validation->set_rules('houses_ad_title', 'Ad Title', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $this->session->set_userdata('admin_login', '');
                $data['msg'] = "Please fill all required fields ";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/listings/add', $data);
            else:
                $pro = strtoupper(substr($_POST['title'], 0, 2));
                $pro_code = $cat . $pro . $num . $str;
                                        
                $data = array(
                    'product_code' => $pro_code,
                    'product_name' => $_POST['houses_ad_title'],
                    'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                    'category_id' => $_POST['cat_id'],
                    'sub_category_id' => $_POST['sub_cat'],
                    'product_description' => $_POST['house_pro_desc'],
                    'product_price' => str_replace(",","",$_POST['houses_price']),
                    'product_posted_time' => date('y-m-d H:i:s'),
                    'country_id' => 4,   
                    'state_id' => $_POST['state'],                  
                    'product_posted_by' => $user[0]->user_id
                    
                );
                
                $result = $this->dbcommon->insert('product', $data);
                $proid = $this->dblogin->getLastInserted();
                $data_extras = array(
                            'product_id' => $proid,
                            'neighbourhood' => $_POST['houses_pro_neighbourhood'],
                            'address' => $_POST['houses_ad_address'],
                            'furnished' => $_POST['furnished'],
                            'Bedrooms' => $_POST['bedrooms'],
                            'Bathrooms' => $_POST['bathrooms'],
                            'pets' => $_POST['pets'],
                            'broker_fee' => $_POST['broker_fee'],
                            'free_status' => $_POST['houses_free'],                         
                            'Area' => $_POST['pro_square_meters'],
                            'ad_language'=> $_POST['houses_language']
                        );
                        $result = $this->dbcommon->insert('product_realestate_extras', $data_extras);
                endif;
            }

            if(isset($_POST['real_estate_shared_submit'])){
                 $this->form_validation->set_rules('shared_ad_title', 'Ad Title', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
                $this->session->set_userdata('admin_login', '');
                $data['msg'] = "Please fill all required fields ";
                $data['msg_class'] = 'alert-info';
                $this->load->view('admin/listings/add', $data);
            else:
                 $pro = strtoupper(substr($_POST['shared_ad_title'], 0, 2));
                $pro_code = $cat . $pro . $num . $str;

                $data = array(
                    'product_code' => $pro_code,
                    'product_name' => $_POST['shared_ad_title'],
                    'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                    'category_id' => $_POST['cat_id'],
                    'sub_category_id' => $_POST['sub_cat'],
                    'product_description' => $_POST['shared_pro_desc'],
                    'product_price' => str_replace(",","",$_POST['shared_price']),
                    'product_posted_time' => date('y-m-d H:i:s'),
                    'country_id' => 4,
                    'state_id' => $_POST['state'],      
                    'product_posted_by' => $user[0]->user_id,
                    
                );
                
                $result = $this->dbcommon->insert('product', $data);
                $proid = $this->dblogin->getLastInserted();
                $data_extras = array(
                            'product_id' => $proid,
                            'neighbourhood' => $_POST['shared_pro_neighbourhood'],
                            'address' => $_POST['shared_ad_address'],
                            'ad_language'=> $_POST['shared_language']
                        );
                        $result = $this->dbcommon->insert('product_realestate_extras', $data_extras);
                endif;
            }
            
           
            for ($i = 2; $i <= $images_num; $i++) {
                if (!empty($picture_ban[$i])) {
                    $data = array(
                        'product_id' => $proid,
                        'product_image' => $picture_ban[$i]
                    );
                    $result = $this->dbcommon->insert('products_images', $data);
                }
            }

            if (isset($result)):

                $ads_left = (int) $user[0]->userAdsLeft;
                $updated_ads_left = $ads_left - 1;
                $user_data = array(
                    'userAdsLeft'=> $updated_ads_left
                    );

                $array = array('user_id' => $user[0]->user_id);
                $this->dbcommon->update('user', $array, $user_data);
                
                $data['msg'] = 'Product added successfully.';
                $data['msg_class'] = 'alert-success';
                redirect('admin/classifieds/listings');
            else:
                $data['msg'] = 'Product not added, Please try again';
                $data['msg_class'] = 'alert-info';
                //$this->load->view('admin/listings/add', $data);
            endif;

        else:
            $this->load->view('admin/listings/add', $data);
        endif;
        
    }

    public function listings_edit($pro_id = null) {
       $data = array();
        
        $colors = $this->dbcommon->getcolorlist();
        $data['colors'] = $colors;    
        
        $brand = $this->dbcommon->getbrandlist();
        $data['brand']  = $brand;   
		
		
		$mileage = $this->dbcommon->getmileagelist();
        $data['mileage']    = $mileage; 
        
        $product_type = 'default';
        $where = array('product_id'=>$pro_id);
        
        $if_vehicle     = $this->dbcommon->get_count('product_vehicles_extras', $where);
        $if_real_estate = $this->dbcommon->get_count('product_realestate_extras', $where);
        if($if_vehicle > 0)
            $product_type = 'vehicle';
        else if($if_real_estate > 0)
            $product_type = 'real_estate';
        
        $data['product_type'] = $product_type;
		
		$cal_query=	' select count(product_id) totcnt from products_images where product_id='.$pro_id.' having totcnt>0';
		$my_counter	=	$this->db->query($cal_query);
		
		if($my_counter->num_rows()>0)
		{				
			if($my_counter->row_array()['totcnt']>0)
				$data['mycounter'] 	=	 $my_counter->row_array()['totcnt']+1;			
			else
				$data['mycounter'] 	=	 $my_counter->row_array()['totcnt'];
			
		}
		else
				$data['mycounter']		=	1; 
				
        $product[] = (array) $this->dbcommon->get_product($pro_id);
        if($product_type=='vehicle')
            $product = $this->dbcommon->get_vehicle_products_admin(null,null,$pro_id,null,null);
        else if($product_type == 'real_estate')
            $product = $this->dbcommon->get_real_estate_products(null,null,$pro_id,null,null);
			
        if($product_type=='vehicle')
		{
			$where = " brand_id='" . $product[0]['product_brand'] . "'";
			$model = $this->dbcommon->filter('model', $where);
			$data['model']  = $model;
		}		
		
        $category = $this->dbcommon->select('category');
        $data['category'] = $category;
        $where = " category_id='" . $product[0]['category_id'] . "'";
        $sub_category = $this->dbcommon->filter('sub_category', $where);
        $data['sub_category'] = $sub_category;
        
        $location = $this->dbcommon->select('country');
        $data['location'] = $location;

        $where = "country_id=4";
        $state = $this->dbcommon->filter('state', $where);
        $data['state'] = $state;
        
        $user = array($this->session->userdata('user'));
                
        $data['user_role'] = $user[0]->user_role;
        
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = substr(str_shuffle($chars), 0, 3);
        $num = rand(10, 99);

        $array = array('product_id' => $pro_id);
        
        if ($pro_id != null && !empty($product)):
            $data['product'] = $product;
        
        $where = " product_id='" . $pro_id . "'";
        $data['images'] = $this->dbcommon->filter('products_images', $where);
        //print_r( $data['images']);
        $images_num = 0;
			if(isset($_FILES))
				$images_num =  sizeof($_FILES);
            //if(isset($_FILES['multiUpload']['name']))
              //      echo     $images_num = sizeof($_FILES['multiUpload']['name']);
                
            if(isset($_POST['default_submit'])) 
            {
			
				
                $where = " where category_id='" . $_POST['cat_id'] . "'";
                $cat_name = $this->dbcommon->getdetails('category', $where);
                $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                $pro = strtoupper(substr($_POST['pro_name'], 0, 2));
                $pro_code = $cat . $pro . $num . $str;
                $this->form_validation->set_rules('pro_name', 'Product Name', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                
                if ($this->form_validation->run() == FALSE):
                    $data['msg'] = "Product Name can not be empty";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/listings/edit', $data);
                else:
                    $picture    =   $product[0]['product_image'];
                    $img_name   =   $this->image_upload($images_num,$pro_id,$product);
					
                    $picture_ban =array();
                    
                    $data = array(
                        'product_code'  => $pro_code,
                        'product_name'  => $_POST['pro_name'],
                        'product_image' => (isset($img_name) && $img_name!='') ? $img_name : $product[0]['product_image'],
                        'sub_category_id' => $_POST['sub_cat'],
                        'product_description' => $_POST['pro_desc'],
                        'product_is_inappropriate'=>$_POST['product_is_inappropriate'],
                        'product_price' => str_replace(",","",$_POST['pro_price']),
                        'product_reposted_time' => date('y-m-d H:i:s'),                     
                        'product_brand' => 0,
                        'state_id' => $_POST['state'],
                        'product_modified_by' => $user[0]->user_id
                    );
                    
                    //$array = array('product_id' => $product[0]->product_id);                  
                    $result = $this->dbcommon->update('product', $array, $data);
                                
                endif;
            }
            elseif(isset($_POST['vehicle_submit']))
            {
                $where = " where category_id='" . $_POST['cat_id'] . "'";
                $cat_name = $this->dbcommon->getdetails('category', $where);
                $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                
                $this->form_validation->set_rules('title', 'Ad Title', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
                    $this->session->set_userdata('admin_login', '');
                    $data['msg'] = "Please fill all required fields ";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/listings/edit', $data);
                else:
                    $pro = strtoupper(substr($_POST['title'], 0, 2));
                    $pro_code = $cat . $pro . $num . $str;
                    //here
                    
                    $img_name   =   $this->image_upload($images_num,$pro_id,$product);
					
                    $data = array(
                        'product_code' => $pro_code,
                        'product_name' => $_POST['title'],
                        'state_id' => $_POST['state'],
                        'product_image' => (isset($img_name) && $img_name!='') ? $img_name : $product[0]['product_image'],
                        'sub_category_id' => $_POST['sub_cat'],
						'product_brand' => $_POST['pro_brand'],
                        'product_is_inappropriate'=>$_POST['product_is_inappropriate'],
                        'product_description' => $_POST['vehicle_pro_desc'],
                        'product_price' => str_replace(",","",$_POST['vehicle_pro_price']),
                        'product_reposted_time' => date('y-m-d H:i:s'),
                        'product_modified_by' => $user[0]->user_id,
                        
                    );
                    
                    $result = $this->dbcommon->update('product',$array,$data);
                    
                    $data_extras = array(                           
                                'make' => '',
                                'model' => $_POST['vehicle_pro_model'],
                                'type_of_car' => $_POST['vehicle_pro_type_of_car'],
                                'color' => $_POST['vehicle_pro_color'],
                                'millage' => $_POST['vehicle_pro_mileage'],
                                'vehicle_condition' => $_POST['vehicle_pro_condition'],
                                'year' => $_POST['vehicle_pro_year']
                            );
                            
                            $result = $this->dbcommon->update('product_vehicles_extras',$array, $data_extras);
                            //exit;
                    endif;
            }
            elseif(isset($_POST['real_estate_houses_submit']))
            {
                
                $where = " where category_id='" . $_POST['cat_id'] . "'";
                $cat_name = $this->dbcommon->getdetails('category', $where);
                $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                $pro = strtoupper(substr($_POST['houses_ad_title'], 0, 2));
                
                $this->form_validation->set_rules('houses_ad_title', 'Title', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
                    $this->session->set_userdata('admin_login', '');
                    $data['msg'] = "Please fill all required fields ";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/listings/add', $data);
                else:
                    $pro = strtoupper(substr($_POST['houses_ad_title'], 0, 2));
                    $pro_code = $cat . $pro . $num . $str;
                    
                    $img_name   =   $this->image_upload($images_num,$pro_id,$product);
                    
                    $picture_ban =array();
                    $data = array(
                        'product_code' => $pro_code,
                        'product_name' => $_POST['houses_ad_title'],
                        'product_image' => (isset($img_name) && $img_name!='') ? $img_name : $product[0]['product_image'],  'product_is_inappropriate'=>$_POST['product_is_inappropriate'],
                        'product_description' => $_POST['house_pro_desc'],
                        'product_price' =>str_replace(",","",$_POST['houses_price']),
                        'product_reposted_time' => date('y-m-d H:i:s'),                                             
                        'state_id' => $_POST['state'],
                        'product_modified_by' => $user[0]->user_id                      
                    );
                    
                    $result = $this->dbcommon->update('product', $array, $data);
                    
                    $data_extras = array(                               
                                'neighbourhood' => $_POST['houses_pro_neighbourhood'],
                                'address' => $_POST['houses_ad_address'],
                                'furnished' => $_POST['furnished'],
                                'pets' => $_POST['pets'],                           
                                'free_status' => $_POST['houses_free'],                         
                                'broker_fee' => $_POST['broker_fee'],
                                'Bedrooms' => $_POST['bedrooms'],
                                'Bathrooms' => $_POST['bathrooms'],
                                'Area' => $_POST['pro_square_meters'],
                                'ad_language'=> $_POST['houses_language']
                            );
                            $result = $this->dbcommon->update('product_realestate_extras',$array, $data_extras);
                    endif;
            }
            elseif(isset($_POST['real_estate_shared_submit']))
            {
                $where = " where category_id='" . $_POST['cat_id'] . "'";
                $cat_name = $this->dbcommon->getdetails('category', $where);
                $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                $pro = strtoupper(substr($_POST['shared_ad_title'], 0, 2));
                
                $this->form_validation->set_rules('shared_ad_title', 'Title', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
                    $this->session->set_userdata('admin_login', '');
                    $data['msg'] = "Please fill all required fields ";
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/listings/add', $data);
                else:
                    $pro = strtoupper(substr($_POST['shared_ad_title'], 0, 2));
                    $pro_code = $cat . $pro . $num . $str;
                    
                    $img_name   =   $this->image_upload($images_num,$pro_id,$product);
                    
                    $data = array(
                        'product_code' => $pro_code,
                        'product_name' => $_POST['shared_ad_title'],
                        'product_image' => (isset($img_name) && $img_name!='') ? $img_name : $product[0]['product_image'],
                        'product_is_inappropriate'=>$_POST['product_is_inappropriate'],                                         
                        'product_description' => $_POST['shared_pro_desc'],
                        'product_price' => str_replace(",","",$_POST['shared_price']),
                        'product_reposted_time' => date('y-m-d H:i:s'),                     
                        'product_modified_by' => $user[0]->user_id,
                        'state_id' => $_POST['state']
                    );
                    
                    $result = $this->dbcommon->update('product', $array, $data);
                    
                    $data_extras = array(                               
                                'neighbourhood' => $_POST['shared_pro_neighbourhood'],
                                'address' => $_POST['shared_ad_address'],
                                'free_status' => $_POST['shared_free'],
                                'ad_language'=> $_POST['shared_language']
                            );
                            $result = $this->dbcommon->update('product_realestate_extras',$array, $data_extras);
                    endif;
            }
            else
            {               
                $this->load->view('admin/listings/edit', $data);
                //redirect('admin/classifieds/listings_edit/'.$pro_id,$data);
                //$this->load->view('admin/listings/edit/'.$pro_id, $data);
            }
            
            
                if(isset($_POST['vehicle_submit']) || isset($_POST['default_submit'])  || isset($_POST['real_estate_houses_submit']) || isset($_POST['real_estate_shared_submit'])):
                    if (isset($result)):
                        $data['msg'] = 'product updated successfully.';
                        $data['msg_class'] = 'alert-success';
                        //echo 'success';
                        redirect('admin/classifieds/listings');                        
                    else:
                        //echo 'fail';
                        $data['msg'] = 'product not updated, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/listings/edit', $data);
                    endif;  
                endif;
            //exit;
          endif; 
    }

    public function removeimage()
    {
        //sub images
        $target_dir = document_root . product;
        
        $where      =   "product_image_id='".$_POST['value']. "'";
        $imagname   = $this->dbcommon->filter('products_images', $where);
        
        @unlink($target_dir . "original/" . $imagname[0]['product_image']);
        @unlink($target_dir . "small/" . $imagname[0]['product_image']);
        @unlink($target_dir . "medium/" . $imagname[0]['product_image']);
        
        $array  =   array('product_image_id'=>$_POST['value']);
        $this->dbcommon->delete('products_images', $array);     
    }
    
    public function removemainimage()
    {
        //main image
        $target_dir = document_root . product;
        
        $where      =   "product_id='".$_POST['prod_id']. "'";
        $imagname   =   $this->dbcommon->filter('product', $where);
        
        @unlink($target_dir . "original/" . $imagname[0]['product_image']);
        @unlink($target_dir . "small/" . $imagname[0]['product_image']);
        @unlink($target_dir . "medium/" . $imagname[0]['product_image']);
        
        $array  =   array('product_id'=>$_POST['prod_id']);
        $data   =   array('product_image'=>"");     
        $this->dbcommon->update('product', $array,$data);       
    }
    public function listings_delete($pro_id = null) {
        $target_dir = document_root . product;
        $data = array();
        $where = " where product_id='" . $pro_id . "'";
        $product = $this->dbcommon->getdetails('product', $where);

        $where = " product_id='" . $pro_id . "'";
        $product_img = $this->dbcommon->filter('products_images', $where);

        if ($pro_id != null && !empty($product)):
            $where = array("product_id" => $pro_id);
            $user = $this->dbcommon->delete('product', $where);

            if ($user):
                @unlink($target_dir . "original/" . $product[0]->product_image);
                @unlink($target_dir . "small/" . $product[0]->product_image);
                @unlink($target_dir . "medium/" . $product[0]->product_image);
            endif;

            $this->session->set_flashdata(array('msg' => 'Listing deleted successfully', 'class' => 'alert-success'));
            if ($product[0]->product_is_inappropriate == 'Inappropriate') {
                redirect('admin/classifieds/listings_spam');
            } else {
                redirect('admin/classifieds/listings');
            }
        else:
            $this->session->set_flashdata(array('msg' => 'Listing not found', 'class' => 'alert-info'));
            if ($product[0]->product_is_inappropriate == 'Inappropriate') {
                redirect('admin/classifieds/listings_spam');
            } else {
                redirect('admin/classifieds/listings');
            }
        endif;
    }

    

    public function listings_view($pro_id = null) {
        $data = array();
        $where = " where product_id='" . $pro_id . "'";
        $product = $this->dbcommon->getdetails('product', $where);

        $category = $this->dbcommon->select('category');
        $data['category'] = $category;
        $where = "  category_id='" . $product[0]->category_id . "'";
        $sub_category = $this->dbcommon->filter('sub_category', $where);
        $data['sub_category'] = $sub_category;

        $location = $this->dbcommon->select('country');
        $data['location'] = $location;

        $where = "country_id='" . $product[0]->country_id . "'";
        $sub_category = $this->dbcommon->filter('state', $where);
        $data['state'] = $sub_category;

        $user = array($this->session->userdata('user'));
        $data['user_role'] = $user[0]->user_role;

        if ($pro_id != null && !empty($product)):
            $data['product'] = $product;
            $this->load->view('admin/listings/view', $data);
        else:
            $this->session->set_flashdata(array('msg' => 'product not found', 'class' => 'alert-info'));
            redirect('admin/classifieds/listings');
        endif;
    }

    public function listings_spam() {
        $user = $this->session->userdata('user');

        if ($user->user_role == 'generalUser') {
            $query = "SELECT p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate , 
                c.catagory_name FROM product as p , category as c where p.category_id=c.category_id and 
                p.product_is_inappropriate = 'Inappropriate' and p.product_posted_by = " . $user->user_id;
        } else {
            $query = "SELECT p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate , 
                c.catagory_name FROM product as p , category as c where p.category_id=c.category_id and 
                p.product_is_inappropriate = 'Inappropriate' ";
        }
        $product = $this->dbcommon->get_distinct($query);
        $data['product'] = $product;


        $data['spam'] = "and product_is_inappropriate = 'Inappropriate'";
        $data['user_role'] = $user->user_role;

        $category = $this->dbcommon->select('category');
        $data['category'] = $category;
        $location = $this->dbcommon->select('country');
        $data['location'] = $location;
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/listings/index', $data);
    }

    function filterListing() {
        $filter_val = $this->input->post("option");
        $filter_opt = $this->input->post("value");
        $sub_cat = $this->input->post("subcat");
        $state_id = $this->input->post("state");
        //$spam_query = $this->input->post("spam");
        $spam_query = " product.is_delete = 0 and product.product_is_inappropriate != 'Inappropriate'";
        $main_data = array();
        if ($filter_val == '0') {
            $query = $spam_query;
            $main_data['product'] = $this->dbcommon->filter('product', $query);
        } else if ($filter_val == 'emirates') {
            if ($filter_opt == '0' && $state_id == "0") {
                $query = $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } else if ($filter_opt != '0' && $state_id == "0") {
                $query = "country_id = " . $filter_opt .' and '. $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } else if ($filter_opt != '0' && $state_id != "0") {
                $query = "country_id = " . $filter_opt . " and state_id = " . $state_id .' and ' .$spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            }
        } else if ($filter_val == 'category') {
            if ($filter_opt == '0' && $sub_cat == "0") {
                $query = $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } else if ($filter_opt != '0' && $sub_cat == "0") {
                $query = "category_id = " . $filter_opt .' and '. $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } else if ($filter_opt != '0' && $sub_cat != "0") {
                $query = "category_id = " . $filter_opt . " and sub_category_id = " . $sub_cat .' and '. $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            }
        } else if ($filter_val == 'status') {
            if ($filter_opt == '0') {
                $query = $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } else {
                $query = "product_status= '" . $filter_opt . "'" .' and '. $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            }
        }
		//echo '<pre>';
		
        echo $this->load->view('admin/listings/list_index', $main_data, TRUE);
        exit();
    }

    function show_sub_cat() {
        $filter_val = $this->input->post("value");

        $query = "category_id= '" . $filter_val . "'";
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);

        echo $this->load->view('admin/listings/sub_cat', $main_data, TRUE);
        exit();
    }

    function filter_sub_cat() {
        $filter_val = $this->input->post("value");
        $query = "category_id= '" . $filter_val . "'";
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);
        echo $this->load->view('admin/listings/filter_sub_cat', $main_data, TRUE);
        exit();
    }

    function order_category() {
        $order = $this->input->post("order");
        $i = min($order);
        foreach ($order as $value) {
            $data = array(
                'cat_order' => $i
            );
            $array = array('category_id' => $value);
            $result = $this->dbcommon->update('category', $array, $data);
            $i++;
        }
    }

    function order_sub_category() {
        $order = $this->input->post("order");
        $i = min($order);
        foreach ($order as $value) {
            $data = array(
                'sub_cat_order' => $i
            );
            $array = array('sub_category_id' => $value);
            $result = $this->dbcommon->update('sub_category', $array, $data);
            $i++;
        }
    }

    function update_status() {

        $status = $this->input->post("status");
        $order = explode(",", $this->input->post("checked_val"));
        if ($status == "available" || $status == "sold" || $status == "out of stock" || $status == "discontinued") {
            $field_name = "product_status";
        } else {
            $field_name = "product_is_inappropriate";
        }
        if ($order[0] == 0) {
            array_shift($order);
        }

        foreach ($order as $value) {
            $data = array(
                $field_name => $status
            );
            $array = array('product_id' => $value);
            $result = $this->dbcommon->update('product', $array, $data);
        }

        redirect('admin/classifieds/listings');
    }

    function show_emirates() {

        $value = $this->input->post("value");
		if($value=='')
				$value=4;
        $query = "country_id= " . $value;
        $main_data['state'] = $this->dbcommon->filter('state', $query);

        echo $this->load->view('admin/listings/show_state', $main_data, TRUE);
        exit;
    }
    function image_upload($images_num,$pro_id,$product)
    {
			if($images_num > 0){
                    for ($i = 1; $i <= $images_num; $i++) 
                    {
						echo "mycounter".$i;
							if (isset($_FILES['multiUpload'.$i]['tmp_name']) && $_FILES['multiUpload'.$i]['tmp_name'] != '') 
							{	
								print_r($_FILES['multiUpload'.$i]['tmp_name']);
								echo '<br>';
								$target_dir = document_root . product;
								$profile_picture = $_FILES['multiUpload'.$i]['name'];
								$ext = explode(".", $_FILES['multiUpload'.$i]['name']);
								$picture_ban[$i] = time() . $i . "." . end($ext);
							   $target_file = $target_dir . "original/" . $picture_ban[$i];
								$uploadOk = 1;
								$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
								// Allow certain file formats
								if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "mp4") {									
									$data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
									$data['msg_class'] = 'alert-info';
									$uploadOk = 0;                              
									$this->load->view('admin/listings/edit', $data);
								 }
								if ($uploadOk == 0) {                               
								
									$data['msg'] = "Sorry, your file was not uploaded.";
									$data['msg_class'] = 'alert-info';
									$this->load->view('admin/listings/edit', $data);
								} else {   
									
									if (move_uploaded_file($_FILES['multiUpload'.$i]['tmp_name'], $target_file)) { 	

										$data = array(
											'product_id' => $pro_id,
											'product_image' => $picture_ban[$i]
										);
										if($i>1)
										$result = $this->dbcommon->insert('products_images', $data);
									
										if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {										
											
										} else {
										
											$this->load->library('thumbnailer');											
											
											$this->thumbnailer->prepare($target_file);											
											list($width, $height, $type, $attr) = getimagesize($target_file);
									 
											$thumb = $target_dir . "small/" . $picture_ban[$i];
											
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
											$thumb = $target_dir . "medium/" . $picture_ban[$i];
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
											if($i==1 && isset($_FILES['multiUpload1']['tmp_name']))
											{
												@unlink($target_dir . "original/" . $product[0]['product_image']);
												@unlink($target_dir . "small/" . $product[0]['product_image']);
												@unlink($target_dir . "medium/" . $product[0]['product_image']);
											}
										}
									} 
									
									}
							}
						
						
					}
                    //exit;
                    if(isset($images_num)) :
                    /*for ($i = 2; $i <= $images_num; $i++) 
                    {
                        if (!empty($picture_ban[$i])) {
                            $data = array(
                                'product_id' => $pro_id,
                                'product_image' => $picture_ban[$i]
                            );
                           // $result = $this->dbcommon->insert('products_images', $data);
                        }
                    }*/
                    endif; 
                    return $picture_ban[1];
                }
                
                
    }
	
	function show_model() 
	{
        $value = $this->input->post("value");
		if($value=='')
			$value=0;	
        $query = "brand_id= " . $value;
        $main_data['model'] = $this->dbcommon->filter('model', $query);

        echo $this->load->view('admin/users/show_model', $main_data, TRUE);
        exit;
    }
	
}

?>