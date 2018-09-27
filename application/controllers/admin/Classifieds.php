<?php

// include('font_array.php');
class Classifieds extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('product', '', TRUE);
        $this->load->library('permission');
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('email');
        $this->per_page = 100;
        $this->per_page_ = 10;
        // $this->load->library('UploadHandler');
    }

    public function categories() {

        $data['page_title'] = 'Categories List';
        $query = ' category_id from category';
        $total_product = $this->dbcommon->getnumofdetails_($query);
        $data['total_records'] = $total_product;

        //$data['hide'] = "false";
        if ($total_product <= 10) {
            //    $data['hide'] = "true";
        }

        $query = ' 0=0 order by cat_order';
        $category = $this->dbcommon->filter('category', $query);

        $data['category'] = $category;
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)):
            $data['msg'] = $this->session->flashdata('msg');
            $data['msg_class'] = $this->session->flashdata('class');
        endif;
        $this->load->view('admin/category/index', $data);
    }

    public function load_more_category() {

        $query = ' category_id from category';
        $total_product = $this->dbcommon->getnumofdetails_($query);

        $filter_val = $this->input->post("value");

        $start = 10 * $filter_val;
        $end = $start + 10;
        $hide = "false";
        if ($end >= $total_product) {
            $hide = "true";
        }

        $query = ' 0=0 order by cat_order limit ' . $start . ',' . $this->per_page;
        $category = $this->dbcommon->filter('category', $query);
        $data['category'] = $category;
        $data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }
        //$arr["html"] = $this->load->view('admin/category/more_cat', $data, TRUE);		
        $data["val"] = $hide;
        echo json_encode($data);
        exit();
    }

    public function file_get_contents_curl($url) {
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
        $data['page_title'] = 'Add Category';
        $user = $this->session->userdata('user');
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';

        $target_dir = base_url() . front_fontawesome . 'font-awesome.css';
        $subject = $this->file_get_contents_curl($target_dir);
        // $subject = file_get_contents(document_root . front_fontawesome.'font-awesome.css');
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach ($matches as $match) {
            $icons[] = $match[1];
        }

        $data['icons'] = $icons;

        if (!empty($_POST)):
            // validation 
            $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
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
                    $imageFileType = strtolower($imageFileType);
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

                $category_slug = $this->dbcommon->generate_slug($_POST['cat_name'], 'S');
                $save_data = array(
                    'catagory_name' => $_POST['cat_name'],
                    'category_slug' => $category_slug,
                    'category_image' => $picture,
                    'is_parent' => 0,
                    'cat_order' => $result[0]['cat_order'] + 1,
                    'icon' => $_POST['select_icons'],
                    'color' => $_POST['cat_color'],
                    'description' => $_POST['description'],
                    'meta_title' => $_POST['meta_title'],
                    'meta_description' => $_POST['meta_description'],
                    'meta_keywords' => $_POST['meta_keywords']
                );

                if (isset($_POST['category_type'])) {
                    $types = implode(',', $_POST['category_type']);
                    $save_data['category_type'] = $types;
                }

                $result = $this->dbcommon->insert('category', $save_data);
                if ($result):
                    $this->session->set_flashdata(array('msg' => 'Category added successfully.', 'class' => 'alert-success'));
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

        if ($cat_id != '') {
            $data = array();
            $data['page_title'] = 'Edit Category';
            $where = " where category_id='" . $cat_id . "'";
            $category = $this->dbcommon->getdetails('category', $where);
            $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';
            // $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
            $target_dir = base_url() . front_fontawesome . 'font-awesome.css';
            $subject = $this->file_get_contents_curl($target_dir);
            // $subject = file_get_contents(document_root . front_fontawesome.'font-awesome.css');
            preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

            $icons = array();

            foreach ($matches as $match) {
                $icons[] = $match[1];
            }
            $data['icons'] = $icons;

            if ($cat_id != null && !empty($category)):
                $data['category'] = $category;
                if (!empty($_POST)):
                    $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
                    $this->form_validation->set_error_delimiters('', '');
                    if ($this->form_validation->run() == FALSE):
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
                            $imageFileType = strtolower($imageFileType);
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
                            'icon' => $_POST['select_icons'],
                            'color' => $_POST['cat_color'],
                            'description' => $_POST['description'],
                            'meta_title' => $_POST['meta_title'],
                            'meta_description' => $_POST['meta_description'],
                            'meta_keywords' => $_POST['meta_keywords']
                        );

                        if (isset($_POST['category_type'])) {
                            $types_arr = $_POST['category_type'];
                            $types = implode(',', $types_arr);
                            $data['category_type'] = $types;
                            $sub_categories = $this->db->query('SELECT * FROM sub_category WHERE category_id = ' . $category[0]->category_id)->result_array();
                            if (isset($sub_categories) && sizeof($sub_categories) > 0) {
                                foreach ($sub_categories as $cat) {
                                    if (isset($cat['sub_category_type'])) {
                                        $sub_category_id = $cat['sub_category_id'];
                                        $category_types_arr = explode(',', $cat['sub_category_type']);
                                        if (isset($category_types_arr)) {
                                            $types_str = '';
                                            foreach ($category_types_arr as $arr) {
                                                if (in_array($arr, $types_arr)) {
                                                    $types_str .= $arr . ',';
                                                }
                                            }
                                            $types_str = rtrim($types_str, ',');
                                            $wh_data = array('sub_category_id' => $sub_category_id);
                                            $up_data = array('sub_category_type' => $types_str);
                                            $this->dbcommon->update('sub_category', $wh_data, $up_data);
                                        }
                                    }
                                }
                            }
                        }

                        $array = array('category_id' => $category[0]->category_id);
                        $result = $this->dbcommon->update('category', $array, $data);
                        if ($result):
                            $this->session->set_flashdata(array('msg' => 'Category updated successfully.', 'class' => 'alert-success'));
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
        } else
            redirect('admin/classifieds/categories');
    }

    public function categories_delete($cat_id = null) {

        $comma_ids = '';
        $data = array();

        $checked_val = $this->input->post('checked_val', TRUE);
        $target_dir = document_root . category;

        if ($checked_val != '') {
            $cat_ids = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $cat_ids);
        } else
            $comma_ids = $cat_id;

        $where = " category where category_id in (" . $comma_ids . ")";
        $category = $this->dbcommon->select($where);
        $success = 0;

        if (!empty($category)) {
            foreach ($category as $val) {

                $num_row = $this->dbcommon->getnumofdetails_("* from product where category_id in (" . $val['category_id'] . ") limit 1");

                if ($num_row < 1) {

                    $category_id = $val['category_id'];
                    $image = $val['sub_category_image'];
                    $where = array("category_id" => $val['category_id']);

                    $sub_cat = $this->dbcommon->delete('category', $where);
                    if ($sub_cat):
                        @unlink($target_dir . "original/" . $image);
                        @unlink($target_dir . "small/" . $image);
                        @unlink($target_dir . "medium/" . $image);
                    endif;

                    $success++;
                }
                else {
                    //not to delete
                }
            }

            if ($success > 0) {
                $this->session->set_flashdata(array('msg' => 'Category(s) deleted successfully', 'class' => 'alert-success'));
                redirect('admin/classifieds/categories');
            } else
                redirect('admin/classifieds/categories');
        }
        else {
            redirect('admin/classifieds/categories');
        }
    }

//    Sub Categories Functions
    public function subCategories($cat_id = null) {
        $data = array();
        $data['page_title'] = 'Sub-category List';

        $config['base_url'] = site_url() . 'admin/classifieds/subCategories/' . $cat_id;
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $config['uri_segment'] = 5;

        $query = ' sub_category_id from sub_category where category_id=' . $cat_id;
        $total_product = $this->dbcommon->getnumofdetails_($query);
        $data['total_records'] = $total_product;
        $config['per_page'] = 10;
        $array = array("category_id" => $cat_id);
        $parent_category = $this->dbcommon->get_row('category', $array);
        $data['parent_category'] = $parent_category;

        //$where = " category_id='" . $cat_id . "' limit ".$page.", ".$config["per_page"];		
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

        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['cat_id'] = $cat_id;
        $this->load->view('admin/category/sub_cat_index', $data);
    }

    public function subCategories_add($cat_id = null) {
        $data = array();
        $data['page_title'] = 'Add Sub-category';
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';

        $target_dir = base_url() . front_fontawesome . 'font-awesome.css';
        $subject = $this->file_get_contents_curl($target_dir);
        // $subject = file_get_contents(document_root . front_fontawesome.'font-awesome.css');
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach ($matches as $match) {
            $icons[] = $match[1];
        }

        $data['icons'] = $icons;

        $category_type_details = $this->db->query('SELECT * FROM category WHERE category_id = ' . $cat_id)->row_array();
        $data['category_types'] = explode(',', $category_type_details['category_type']);

        $user = $this->session->userdata('user');
        if (!empty($_POST)):
            // validation 
            $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE):
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
                    $imageFileType = strtolower($imageFileType);
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

                $sub_category_slug = $this->dbcommon->generate_slug($_POST['cat_name'], 'SC');

                $data = array(
                    'sub_category_name' => $_POST['cat_name'],
                    'sub_category_slug' => $sub_category_slug,
                    'sub_category_image' => $picture,
                    'category_id' => $cat_id,
                    'sub_cat_order' => $sub_cat_order,
                    'icon' => $_POST['select_icons'],
                    'description' => $_POST['description'],
                    'meta_title' => $_POST['meta_title'],
                    'meta_description' => $_POST['meta_description'],
                    'meta_keywords' => $_POST['meta_keywords']
                );

                if (isset($_POST['sub_category_type'])) {
                    $types = implode(',', $_POST['sub_category_type']);
                    $data['sub_category_type'] = $types;
                }

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
                    $this->session->set_flashdata(array('msg' => 'Sub Category added successfully', 'class' => 'alert-success'));
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
        $data['page_title'] = 'Edit Sub-category';
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';

        $target_dir = base_url() . front_fontawesome . 'font-awesome.css';
        $subject = $this->file_get_contents_curl($target_dir);
        // $subject = file_get_contents(document_root . front_fontawesome.'font-awesome.css');
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach ($matches as $match) {
            $icons[] = $match[1];
        }

        $data['icons'] = $icons;

        $where = " where sub_category_id='" . $cat_id . "'";
        $category = $this->dbcommon->getdetails('sub_category', $where);

        $category_type_details = $this->db->query('SELECT * FROM category WHERE category_id = ' . $category[0]->category_id)->row_array();
        $data['category_types'] = explode(',', $category_type_details['category_type']);

        if ($cat_id != null && !empty($category)):
            $data['category'] = $category;
            if (!empty($_POST)):
                $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
                $this->form_validation->set_error_delimiters('', '');
                if ($this->form_validation->run() == FALSE):
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
                        $imageFileType = strtolower($imageFileType);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/category/sub_cat_edit', $data);
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
                        'icon' => $_POST['select_icons'],
                        'description' => $_POST['description'],
                        'meta_title' => $_POST['meta_title'],
                        'meta_description' => $_POST['meta_description'],
                        'meta_keywords' => $_POST['meta_keywords']
                    );

                    if (isset($_POST['sub_category_type'])) {
                        $types = implode(',', $_POST['sub_category_type']);
                        $data['sub_category_type'] = $types;
                    }

                    $array = array('sub_category_id' => $category[0]->sub_category_id);
                    $result = $this->dbcommon->update('sub_category', $array, $data);
                    if ($result):
                        $this->session->set_flashdata(array('msg' => 'Sub Category updated successfully', 'class' => 'alert-success'));
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
            redirect('admin/classifieds/categories');
        endif;
    }

    public function subCategories_delete($cat_id = null) {

        $comma_ids = '';
        $data = array();

        $checked_val = $this->input->post('checked_val', TRUE);
        $category_id = $this->input->post('category_id', TRUE);

        $target_dir = document_root . category;

        if ($checked_val != '') {
            $cat_ids = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $cat_ids);
        } else
            $comma_ids = $cat_id;

        $where = " sub_category where sub_category_id in (" . $comma_ids . ")";
        $sub_category = $this->dbcommon->select($where);
        $success = 0;

        if (!empty($sub_category)) {
            foreach ($sub_category as $val) {

                $num_row = $this->dbcommon->getnumofdetails_("* from product where sub_category_id in (" . $val['sub_category_id'] . ") and is_delete=0 limit 1");

                if ($num_row < 1) {

                    $category_id = $val['category_id'];
                    $image = $val['sub_category_image'];
                    $where = array("sub_category_id" => $val['sub_category_id']);

                    $sub_cat = $this->dbcommon->delete('sub_category', $where);
                    if ($sub_cat):
                        @unlink($target_dir . "original/" . $image);
                        @unlink($target_dir . "small/" . $image);
                        @unlink($target_dir . "medium/" . $image);
                    endif;

                    $num_row1 = $this->dbcommon->getnumofdetails_("* from sub_category where category_id = " . $val['category_id'] . "");
                    if ($num_row1 < 1) {
                        $data = array('is_parent' => 0);
                        $array = array('category_id' => $category_id);
                        $result = $this->dbcommon->update('category', $array, $data);
                    }

                    $success++;
                } else {
                    //not to delete
                }
            }

            if ($success > 0) {
                $this->session->set_flashdata(array('msg' => 'Sub Category(s) deleted successfully', 'class' => 'alert-success'));
                redirect('admin/classifieds/subCategories/' . $category_id);
            } else
                redirect('admin/classifieds/subCategories/' . $category_id);
        }
        else {
            redirect('admin/classifieds/subCategories/' . $category_id);
        }
    }

//    Listing function
    public function listings() {

        $product_for = $this->uri->segment(4);
        if (!empty($product_for) && in_array($product_for, array('classified', 'store', 'offer'))) {

            $data = array();

            $data['redirect_admin_to'] = $product_for;
            $data['page_title'] = 'Listing';

            $user = $this->session->userdata('user');
            $data['admin_user'] = $user;
            $data['spam'] = "";
            $data['user_role'] = $user->user_role;

            $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
            $data['category'] = $category;

            $location = $this->dbcommon->select('country');
            $data['location'] = $location;

            $query = '';

            if (isset($_GET['userid']))
                $user_path = 'userid=' . $_GET['userid'];
            else
                $user_path = 'request=yes';

            $url = site_url() . 'admin/classifieds/listings/' . $product_for . '?' . $user_path;

            $where = '';
            $filter_val = 0;
            $filter_opt = 0;
            $sub_cat = 0;
            $state_id = 0;
            $search = '';

            $data['user_category_id'] = '';
            $data['user_sub_category_id'] = '';

            $data['subcat'] = '';

            if (isset($_GET['userid']) && $_GET['userid'] != '') {
                $check_getuser = $this->db->query('select * from user 
                                    left join store on store.store_owner=user.user_id
                                    where user_id=' . (int) $_GET['userid'] . ' and is_delete in(0,3) limit 1')->row_array();
                //and user_role in ("storeUser","generalUser","offerUser","admin","superadmin")
                $chkuser_id = (int) $check_getuser['user_id'];

                if ($chkuser_id > 0) {
                    $data['user_category_id'] = $check_getuser['category_id'];
                    $data['user_sub_category_id'] = $check_getuser['sub_category_id'];

                    $querysubcat = "category_id= '" . $check_getuser['category_id'] . "'";
                    $data['subcat'] = $this->dbcommon->filter('sub_category', $querysubcat);
                } else {
                    redirect('admin/home');
                }
            }

            if (isset($_REQUEST['per_page'])) {
                $per_page = $_REQUEST['per_page'];
            } else {
                $per_page = $this->per_page;
            }

            if (isset($_REQUEST['page']))
                $search .= '?page=' . $_REQUEST['page'];
            //country
            if (isset($_REQUEST['userid']) && $_REQUEST['userid'] != 0) {
                $listing_userid = $_REQUEST['userid'];
            } else {
                $listing_userid = 0;
            }

            if (isset($_REQUEST['filter'])) {
                $filter_val = $_REQUEST['filter'];
            } else {
                $filter_val = 0;
            }
            //country
            if (isset($_REQUEST['con']) && $_REQUEST['con'] != 0) {
                $listing_country = $_REQUEST['con'];
            } else {
                $listing_country = 0;
            }
            //state- emirates
            if (isset($_REQUEST['st']) && $_REQUEST['st'] != 0) {
                $listing_state = $_REQUEST['st'];
            } else {
                $listing_state = 0;
            }
            //category
            if (isset($_REQUEST['cat']) && $_REQUEST['cat'] != 0) {
                $listing_category = $_REQUEST['cat'];
            } else {
                $listing_category = 0;
            }

            //sub-category
            if (isset($_REQUEST['sub_cat']) && $_REQUEST['sub_cat'] != 0) {
                $listing_sub_category = $_REQUEST['sub_cat'];
            } else {
                $listing_sub_category = 0;
            }

            //status
            if (isset($_REQUEST['status']) && $_REQUEST['status'] != "0") {
                $listing_status = $_REQUEST['status'];
            } else {
                $listing_status = 0;
            }

            //other status
            if (isset($_REQUEST['other_status']) && $_REQUEST['other_status'] != "0") {
                $listing_oth_status = $_REQUEST['other_status'];
            } else {
                $listing_oth_status = 0;
            }

            if (isset($_REQUEST['dt']) && $_REQUEST['dt'] != 0) {
                $listing_date = $_REQUEST['dt'];
            } else {
                $listing_date = 0;
            }

            $spam_query = " and p.is_delete=0";

            if ($filter_val == '0') {
                $query .= '' . $spam_query;
                $url .= '&filter=' . $filter_val;
            } elseif ($filter_val == 'emirates') {

                $url .= '&filter=' . $filter_val;
                if ($listing_country == '0' && $listing_state == "0")
                    $query .= $spam_query;
                elseif ($listing_country != '0' && $listing_state == "") {
                    $query .= " and p.country_id = " . $listing_country . '  ' . $spam_query;

                    $url .= '&con=' . $listing_country;
                } elseif ($listing_country != '0' && $listing_state != "0") {
                    $query .= " and p.country_id = " . $listing_country . " and p.state_id = " . $listing_state . '  ' . $spam_query;
                    $url .= '&con=' . $listing_country . '&st=' . $listing_state;
                }
            } elseif ($filter_val == 'category') {

                $url .= '&filter=' . $filter_val;
                if ($listing_category == '0' && $listing_sub_category == "0")
                    $query .= $spam_query;
                elseif ($listing_category != '0' && $listing_sub_category == "0") {
                    $query .= " and c.category_id = " . $listing_category . '  ' . $spam_query;

                    $url .= '&cat=' . $listing_category;
                } elseif ($listing_category != '0' && $listing_sub_category != "0") {
                    $query .= " and c.category_id = " . $listing_category . " and sc.sub_category_id = " . $listing_sub_category . '  ' . $spam_query;

                    $url .= '&cat=' . $listing_category . '&sub_cat=' . $listing_sub_category;
                }
            }

            if ($listing_status != '') {
                if ($listing_status == '0')
                    $query .= $spam_query;
                else {
                    if (in_array($listing_status, array('NeedReview', 'Approve', 'Unapprove', 'Inappropriate'))) {
                        $query .= " and p.product_is_inappropriate= '" . $listing_status . "'" . '  ' . $spam_query;
                        $url .= '&status=' . $listing_status;
                    }
                }
            }

            // other status
            if ($listing_oth_status != '' && $listing_oth_status != "0") {

                if ($listing_oth_status == 'sold') {
                    $query .= "  and p.product_is_sold=1 and (p.product_deactivate is null or p.product_deactivate<>1) " . $spam_query;
                    $url .= '&other_status=' . $listing_oth_status;
                } elseif ($listing_oth_status == 'deactivate') {
                    $query .= "  and (p.product_is_sold<>1 || p.product_is_sold is null || p.product_is_sold='') and p.product_deactivate=1 " . $spam_query;
                    $url .= '&other_status=' . $listing_oth_status;
                } elseif ($listing_oth_status == 'available') {
                    $query .= "  and (p.product_is_sold=0 or p.product_is_sold is null) and  (p.product_deactivate='' or p.product_deactivate is null) " . $spam_query;
                    $url .= '&other_status=' . $listing_oth_status;
                } elseif ($listing_oth_status == 'sold_deactivate') {
                    $query .= "  and p.product_is_sold=1 and p.product_deactivate=1" . $spam_query;
                    $url .= '&other_status=' . $listing_oth_status;
                } else
                    $query .= "";
            }

            if ($filter_val == '0' || $filter_val == 'emirates' || $filter_val == 'category') {

                if (isset($listing_date) && $listing_date != '') {
                    $pieces = explode(" to ", $listing_date);
                    $start_date = date("Y-m-d", strtotime($pieces[0]));
                    $end_date = date("Y-m-d", strtotime($pieces[1]));

                    $query .= "  and  (date(p.product_posted_time)>='" . $start_date . "' and date(p.product_posted_time)<='" . $end_date . "') " . $spam_query;

                    $url .= '&dt=' . $listing_date;
                }
            }

            if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
                $query .= "  and product_posted_by=" . $_REQUEST['userid'];
            }

            //left join repost r on r.productid<>p.product_id
            $wh_count = " p.product_id FROM product as p  
                    left join category as c on c.category_id=p.category_id 
                    left join sub_category as sc on sc.sub_category_id=p.sub_category_id  
                     
                    left join featureads f on f.product_id=p.product_id and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between f.dateFeatured and f.dateExpire)
                    left join user as u on u.user_id=p.product_posted_by
                    left join store st on st.store_owner=u.user_id 
                    where p.category_id=c.category_id and product_for='" . $product_for . "' and p.product_id not in (select productid from repost where p.product_id=repost.productid group by productid)  " . $query . "  group by p.product_id";

            $pagination_data = $this->dbcommon->pagination($url, $wh_count, $per_page, 'yes');

            $data["links"] = $pagination_data['links'];
            $data['total_records'] = $pagination_data['total_rows'];

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

            $query = $query . "   group by p.product_id order by p.product_id desc limit  " . $offset . "," . $per_page;

//            /left join repost r on r.productid<>p.product_id
            $wh = "	select 
                        u.user_id,u.user_role,u.device_type, if(u.nick_name!='',u.nick_name,u.username) user_name,if(p.phone_no!='',p.phone_no,if(u.contact_number !='',u.contact_number,if(u.phone!='',u.phone,'-'))) as user_contact_number, u.email_id, p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate,p.product_is_sold,p.product_deactivate,p.product_posted_by,c.catagory_name,if((CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between f.dateFeatured and f.dateExpire) and p.product_is_inappropriate='Approve' ,'f_ad','') as my_status,st.store_id                        
                        FROM product as p
                        left join category as c on c.category_id=p.category_id 
                        left join sub_category as sc on sc.sub_category_id=p.sub_category_id
                        
                        left join featureads f on f.product_id=p.product_id and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between f.dateFeatured and f.dateExpire)
                        left join user as u on u.user_id=p.product_posted_by
                        left join store st on st.store_owner=u.user_id                        
    			where p.category_id=c.category_id  and product_for='" . $product_for . "' and p.product_id not in (select productid from repost where p.product_id=repost.productid group by productid) " . $query;

            $product = $this->dbcommon->get_distinct($wh);

            $data['product'] = $product;
            $data['mystatus'] = $listing_oth_status;
            $data['search'] = $search;

            $msg = $this->session->flashdata('msg');
            if (!empty($msg)):
                $data['msg'] = $this->session->flashdata('msg');
                $data['msg_class'] = $this->session->flashdata('class');
            endif;
            $this->load->view('admin/listings/index', $data);
        }
        else {
            redirect('admin/home');
        }
    }

    public function listings_add($function = NULL, $redirect = NULL) {

        if ($function != '' && $redirect != '') {
            $this->unset_alllisting_session();

            $data = array();

            $data['redirect_admin_to'] = $redirect;
            $data['page_title'] = 'Add Listing';

            $WaterMark = site_url() . 'assets/front/images/logoWmark.png';

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

            $user = array($this->session->userdata('user'));

            $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
            $data['category'] = $category;

            $category = $this->dbcommon->select('sub_category');
            $data['sub_category'] = $category;

            $location = $this->dbcommon->select('country');
            $data['location'] = $location;
            $where = "country_id=4";
            $state = $this->dbcommon->filter('state', $where);
            $data['state'] = $state;

            $where = " where user_id='" . $user[0]->user_id . "'";

            if (isset($_REQUEST['cat_id']))
                $filter_val = $this->input->post("cat_id");
            else
                $filter_val = 0;

            $query = "category_id	= '" . $filter_val . "'";
            $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

            $data['user_category_id'] = '';
            $data['user_sub_category_id'] = '';
            $data['user_store_status'] = '';
            $data['user_role'] = '';
            $data['productowner_role'] = '';
            $productowner_role = '';

            if (isset($_GET['userid']) && $_GET['userid'] != '') {
                $check_getuser = $this->db->query('select * from user 
                                left join store on store.store_owner=user.user_id
                                where user_id=' . (int) $_GET['userid'] . ' and is_delete in (0,3) and (CURDATE() between from_date and to_date) and user_role in ("generalUser","offerUser","storeUser") limit 1')->row_array();

                $chkuser_id = (int) $check_getuser['user_id'];

                $data['user_role'] = $check_getuser['user_role'];
                $data['productowner_role'] = $check_getuser['user_role'];
                $productowner_role = $check_getuser['user_role'];
                if ($chkuser_id > 0) {
                    if ((int) $check_getuser['userAdsLeft'] > 0) {
                        $data['user_category_id'] = $check_getuser['category_id'];
                        $data['user_sub_category_id'] = $check_getuser['sub_category_id'];
                        $data['user_store_status'] = $check_getuser['store_status'];
                    } else
                        redirect('admin/home');
                }
                else {
                    redirect('admin/home');
                }
            }

            $admin_permission = $this->session->userdata('admin_modules_permission');
            if (!empty($_POST)):

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

                if (isset($_POST['default_submit'])) {
                    if (isset($_REQUEST['cat_id']))
                        $filter_val = $this->input->post("cat_id");
                    else
                        $filter_val = 0;
                    $query = "category_id	= '" . $filter_val . "'";
                    $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                    $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                    $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                    $this->form_validation->set_rules('pro_name', 'Ad Name', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('pro_desc', 'Description', 'trim|required|max_length[650]');
                    $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                    // if(isset($data['productowner_role']) && $data['productowner_role']=='storeUser') {
                    if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                    }

                    if ($this->form_validation->run() == FALSE):

                        $this->load->view('admin/listings/add', $data);
                    else:

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
                            if (file_exists(document_root . product . 'video_image/' . $video_img)) {
                                $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                            }
                        } else {
                            $video = '';
                            $video_img = '';
                        }

                        $product_slug = $this->dbcommon->generate_slug($_POST['pro_name'], 'P');

                        $data = array(
                            'product_code' => $pro_code,
                            'product_name' => $_POST['pro_name'],
                            'product_slug' => $product_slug,
                            'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                            'category_id' => $_POST['cat_id'],
                            'sub_category_id' => $_POST['sub_cat'],
                            'product_description' => $_POST['pro_desc'],
                            'product_price' => str_replace(",", "", $_POST['pro_price']),
                            'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                            'product_posted_time' => date('y-m-d H:i:s', time()),
                            'admin_modified_at' => date('y-m-d H:i:s', time()),
                            'product_brand' => 0,
                            'product_posted_by' => $user[0]->user_id,
                            'admin_modified_by' => $user[0]->user_id,
                            'state_id' => $_POST['state'],
                            'country_id' => $_POST['location'],
                            'phone_no' => $_POST['pro_phone'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'video_image_name' => $video_img,
                            'insert_from' => 'web',
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $data['stock_availability'] = $_POST['total_stock'];
                            $data['total_stock'] = $_POST['total_stock'];
                            $data['product_for'] = 'store';
                        }

                        $result = $this->dbcommon->insert('product', $data);
                        $proid = $this->dblogin->getLastInserted();

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $this->dbcommon->product_stock_track($proid);
                        }

                    endif;
                }

                if (isset($_POST['vehicle_submit'])) {

                    if (isset($_REQUEST['cat_id']))
                        $filter_val = $this->input->post("cat_id");
                    else
                        $filter_val = 0;
                    $query = "category_id	= '" . $filter_val . "'";
                    $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                    $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                    $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                    $this->form_validation->set_rules('title', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('vehicle_pro_desc', 'Description', 'trim|required|max_length[650]');
                    $this->form_validation->set_rules('pro_brand', 'Brand', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_model', 'Model', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_type_of_car', 'Type Of Car', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_year', 'Year', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_mileage', 'Mileage', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_condition', 'Condition', 'trim|required');
                    $this->form_validation->set_rules('vehicle_pro_color', 'Color', 'trim|required');
                    $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
//                $this->form_validation->set_rules('vehicle_pro_price', 'Price', 'trim|required');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                    if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                    }

                    if ($this->form_validation->run() == FALSE):

                        $this->load->view('admin/listings/add', $data);
                    else:
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
                            'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                            'category_id' => $_POST['cat_id'],
                            'sub_category_id' => $_POST['sub_cat'],
                            'state_id' => $_POST['state'],
                            'product_brand' => $_POST['pro_brand'],
                            'product_description' => $_POST['vehicle_pro_desc'],
                            'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                            'product_price' => str_replace(",", "", $_POST['vehicle_pro_price']),
                            'product_posted_time' => date('y-m-d H:i:s', time()),
                            'admin_modified_at' => date('y-m-d H:i:s', time()),
                            'admin_modified_by' => $user[0]->user_id,
                            'product_posted_by' => $user[0]->user_id,
                            'country_id' => $_POST['location'],
                            'phone_no' => $_POST['pro_phone'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'video_image_name' => $video_img,
                            'insert_from' => 'web',
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $data['stock_availability'] = $_POST['total_stock'];
                            $data['total_stock'] = $_POST['total_stock'];
                            $data['product_for'] = 'store';
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

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $this->dbcommon->product_stock_track($proid);
                        }

                    endif;
                }

                if (isset($_POST['real_estate_houses_submit'])) {
                    if (isset($_REQUEST['cat_id']))
                        $filter_val = $this->input->post("cat_id");
                    else
                        $filter_val = 0;
                    $query = "category_id	= '" . $filter_val . "'";
                    $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                    $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                    $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                    $this->form_validation->set_rules('houses_ad_title', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('house_pro_desc', 'Description', 'trim|required|max_length[650]');
                    $this->form_validation->set_rules('pro_square_meters', 'Square Meters', 'trim|required');
                    $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');
                    $this->form_validation->set_rules('address', 'Address', 'trim|required');
                    if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                    }

                    if ($this->form_validation->run() == FALSE):

                        $this->load->view('admin/listings/add', $data);
                    else:
                        $pro = strtoupper(substr($_POST['title'], 0, 2));
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
                            'product_price' => str_replace(",", "", $_POST['houses_price']),
                            'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                            'product_posted_time' => date('y-m-d H:i:s', time()),
                            'admin_modified_at' => date('y-m-d H:i:s', time()),
                            'state_id' => $_POST['state'],
                            'country_id' => $_POST['location'],
                            'admin_modified_by' => $user[0]->user_id,
                            'product_posted_by' => $user[0]->user_id,
                            'phone_no' => $_POST['pro_phone'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'video_image_name' => $video_img,
                            'insert_from' => 'web',
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $data['stock_availability'] = $_POST['total_stock'];
                            $data['total_stock'] = $_POST['total_stock'];
                            $data['product_for'] = 'store';
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
                            'Area' => $_POST['pro_square_meters'],
                            'ad_language' => $_POST['houses_language']
                        );
                        $result = $this->dbcommon->insert('product_realestate_extras', $data_extras);

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $this->dbcommon->product_stock_track($proid);
                        }
                    endif;
                }

                if (isset($_POST['real_estate_shared_submit'])) {

                    if (isset($_REQUEST['cat_id']))
                        $filter_val = $this->input->post("cat_id");
                    else
                        $filter_val = 0;
                    $query = "category_id	= '" . $filter_val . "'";
                    $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                    $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                    $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                    $this->form_validation->set_rules('shared_ad_title', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('shared_pro_desc', 'Description', 'trim|required|max_length[650]');
                    $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');
                    $this->form_validation->set_rules('address', 'Address', 'trim|required');

                    if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                    }

                    if ($this->form_validation->run() == FALSE):

                        $this->load->view('admin/listings/add', $data);
                    else:
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
                            'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                            'category_id' => $_POST['cat_id'],
                            'sub_category_id' => $_POST['sub_cat'],
                            'product_description' => $_POST['shared_pro_desc'],
                            'product_price' => str_replace(",", "", $_POST['shared_price']),
                            'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                            'product_posted_time' => date('y-m-d H:i:s', time()),
                            'admin_modified_at' => date('y-m-d H:i:s', time()),
                            'country_id' => $_POST['location'],
                            'state_id' => $_POST['state'],
                            'admin_modified_by' => $user[0]->user_id,
                            'product_posted_by' => $user[0]->user_id,
                            'phone_no' => $_POST['pro_phone'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'video_image_name' => $video_img,
                            'insert_from' => 'web',
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $data['stock_availability'] = $_POST['total_stock'];
                            $data['total_stock'] = $_POST['total_stock'];
                            $data['product_for'] = 'store';
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

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $this->dbcommon->product_stock_track($proid);
                        }

                    endif;
                }

                if (isset($_POST['car_number_submit'])) {

                    if (isset($_REQUEST['cat_id']))
                        $filter_val = $this->input->post("cat_id");
                    else
                        $filter_val = 0;
                    $query = "category_id	= '" . $filter_val . "'";
                    $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                    $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                    $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                    $this->form_validation->set_rules('pro_name', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('car_desc', 'Description', 'trim|required|max_length[650]');
                    $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
//                $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                    $this->form_validation->set_rules('car_number', 'Car Number', 'trim|required');
                    $this->form_validation->set_rules('plate_source', 'Plate Source', 'trim|required');
                    $this->form_validation->set_rules('plate_digit', 'Plate Digit', 'trim|required');
                    $this->form_validation->set_rules('repeating_numbers_car', 'Repeating Numbers', 'trim|required');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                    if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                    }

                    if ($this->form_validation->run() == FALSE):

                        $this->load->view('admin/listings/add', $data);
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
                            'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                            'category_id' => $_POST['cat_id'],
                            'sub_category_id' => $_POST['sub_cat'],
                            'product_description' => $_POST['car_desc'],
                            'product_price' => str_replace(",", "", $_POST['pro_price']),
                            'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                            'product_posted_time' => date('y-m-d H:i:s', time()),
                            'admin_modified_at' => date('y-m-d H:i:s', time()),
                            'country_id' => $_POST['location'],
                            'state_id' => $_POST['state'],
                            'admin_modified_by' => $user[0]->user_id,
                            'product_posted_by' => $user[0]->user_id,
                            'phone_no' => $_POST['pro_phone'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'video_image_name' => $video_img,
                            'insert_from' => 'web',
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $data['stock_availability'] = $_POST['total_stock'];
                            $data['total_stock'] = $_POST['total_stock'];
                            $data['product_for'] = 'store';
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

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $this->dbcommon->product_stock_track($proid);
                        }

                    endif;
                }

                if (isset($_POST['mobile_number_submit'])) {

                    if (isset($_REQUEST['cat_id']))
                        $filter_val = $this->input->post("cat_id");
                    else
                        $filter_val = 0;
                    $query = "category_id	= '" . $filter_val . "'";
                    $data['sub_category'] = $this->dbcommon->filter('sub_category', $query);

                    $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                    $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                    $this->form_validation->set_rules('pro_name', 'Ad Title', 'trim|required|max_length[80]');
                    $this->form_validation->set_rules('mob_desc', 'Description', 'trim|required|max_length[650]');
                    $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
//                $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');                
                    $this->form_validation->set_rules('mobile_operators', 'Mobile Operator', 'trim|required');
                    $this->form_validation->set_rules('repeating_numbers_mobile', 'Repeating Number', 'trim|required');
                    $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
                    $this->form_validation->set_rules('location', 'Country', 'trim|required');
                    $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                    if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                        $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                    }

                    if ($this->form_validation->run() == FALSE):

                        $this->load->view('admin/listings/add', $data);
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
                            'product_image' => (isset($picture_ban[1])) ? $picture_ban[1] : null,
                            'category_id' => $_POST['cat_id'],
                            'sub_category_id' => $_POST['sub_cat'],
                            'product_description' => $_POST['mob_desc'],
                            'product_price' => str_replace(",", "", $_POST['pro_price']),
                            'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                            'product_posted_time' => date('y-m-d H:i:s', time()),
                            'admin_modified_at' => date('y-m-d H:i:s', time()),
                            'country_id' => $_POST['location'],
                            'state_id' => $_POST['state'],
                            'admin_modified_by' => $user[0]->user_id,
                            'product_posted_by' => $user[0]->user_id,
                            'phone_no' => $_POST['pro_phone'],
                            'youtube_link' => $youtube,
                            'video_name' => $video,
                            'video_image_name' => $video_img,
                            'insert_from' => 'web',
                            'address' => $this->input->post('address'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                        );

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $data['stock_availability'] = $_POST['total_stock'];
                            $data['total_stock'] = $_POST['total_stock'];
                            $data['product_for'] = 'store';
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

                        if (isset($_POST['ad_type']) && $_POST['ad_type'] == '1') {
                            $this->dbcommon->product_stock_track($proid);
                        }
                    endif;
                }

                if (isset($result)):
                    if ($fileName != '')
                        $fileNameArray = explode(',', $fileName);
                    else
                        $fileNameArray = array();

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
                                $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
                                $dest = document_root . product . 'original/' . $file_name;
                                //if($key > 0) {						
                                if (file_exists(document_root . product . 'original/' . $file_name)) {
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

                    $adleft = 0;

                    if (isset($_GET['userid']) && $_GET['userid'] != '') {
                        $res = $this->db->query('select userAdsLeft,is_delete,user_role from user where user_id=' . (int) $_GET['userid'] . ' and userAdsLeft > 0 and is_delete in (0,3,6) and (CURDATE() between from_date and to_date) and status="active"')->row();

                        if (isset($res))
                            $adleft = $res->userAdsLeft;
                        else
                            $adleft = 0;
                    }

                    $array = array('product_id' => $proid);

                    if (isset($_GET['userid']) && $_GET['userid'] != '') {

                        if ($res->user_role == 'generalUser')
                            $redirect_path = 'classified';
                        elseif ($res->user_role == 'storeUser') {
                            if (isset($_POST['ad_type']) && $_POST['ad_type'] == '0')
                                $redirect_path = 'classified';
                            else
                                $redirect_path = 'store';
                        }
                        elseif ($res->user_role == 'offerUser')
                            $redirect_path = 'offer';
                        else
                            $redirect_path = 'classified';
                    }

                    if (isset($_GET['userid']) && $_GET['userid'] != '' && $adleft > 0) {
                        $is_delete = 0;

                        if ($user_ads_count->user_role == 'storeUser') {
                            $where = " where store_owner ='" . $_GET['userid'] . "'";
                            $old_store_details = $this->dbcommon->getdetails('store', $where);

                            if ($old_store_details[0]->store_is_inappropriate != 'Approve' && isset($_POST['ad_type']) && $_POST['ad_type'] == '1')
                                $is_delete = 6;
                            else
                                $is_delete = 0;
                        }
                        else {
                            if ($res->is_delete == 0)
                                $is_delete = 0;
                            elseif ($res->is_delete == 3)
                                $is_delete = 3;
                        }

                        if (in_array($is_delete, array(0, 3, 6))) {
                            $prod_data = array('product_posted_by' => $_GET['userid'],
                                'post_for_user' => 1,
                                'is_delete' => $is_delete
                            );
                            $this->dbcommon->update('product', $array, $prod_data);
                        }

                        $useriid = $_GET['userid'];

                        $ads_left = (int) $res->userAdsLeft;
                        $updated_ads_left = $ads_left - 1;

                        $user_data = array(
                            'userAdsLeft' => $updated_ads_left
                        );

                        $arr = array('user_id' => $useriid);
                        $this->dbcommon->update('user', $arr, $user_data);
                    } elseif (isset($_GET['userid']) && $_GET['userid'] != '' && $adleft <= 0) {

                        $user_data = array(
                            'userAdsLeft' => 0
                        );

                        $arr = array('user_id' => $_GET['userid']);
                        $this->dbcommon->update('user', $arr, $user_data);

                        $arr = array('product_id' => $proid);
                        $this->dbcommon->delete('product', $arr);
                        $this->dbcommon->delete('car_mobile_numbers', $arr);
                        $this->dbcommon->delete('product_realestate_extras', $arr);
                        $this->dbcommon->delete('product_vehicles_extras', $arr);

                        $data['msg'] = 'Sorry, you can\'t add product for this user.';
                        $data['msg_class'] = 'alert-success';
                        $user_set = 'yes';
                        redirect('admin/classifieds/' . $function . '/' . $redirect_path . '/?userid=' . $_GET['userid']);
                    } else {
                        $prod_data = array('product_posted_by' => $user[0]->user_id);
                        $this->dbcommon->update('product', $array, $prod_data);
                    }

                    $this->session->set_flashdata(array('msg' => 'Ad added successfully.', 'class' => 'alert-success'));
                    if (isset($_GET['userid']) && (int) $_GET['userid'] > 0)
                        redirect('admin/classifieds/' . $function . '/' . $redirect_path . '/?userid=' . $_GET['userid']);
                    else
                        redirect('admin/classifieds/' . $function . '/' . $redirect);
                else:
                    $data['msg'] = 'Ad not added, Please try again';
                    $data['msg_class'] = 'alert-info';
                //$this->load->view('admin/listings/add', $data);
                endif;

            else:
                $this->load->view('admin/listings/add', $data);
            endif;
        } else
            redirect('admin/home');
    }

    public function listings_edit($function = NULL, $redirect = NULL, $pro_id = NULL) {

        $WaterMark = site_url() . 'assets/front/images/logoWmark.png';

//        $this->unset_alllisting_session();

        if ($pro_id != '' && $redirect != '' && $function != '') {
            $data = array();

            $data['redirect_admin_to'] = $redirect;
            $admin_permission = $this->session->userdata('admin_modules_permission');
            $admin_user = $this->session->userdata('user');

            $data['page_title'] = 'Edit Listing';
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

            $product_type = 'default';
            $where = array('product_id' => $pro_id);

            $if_vehicle = $this->dbcommon->get_count('product_vehicles_extras', $where);
            $if_real_estate = $this->dbcommon->get_count('product_realestate_extras', $where);
            $if_car_mobile_number = $this->dbcommon->get_count('car_mobile_numbers', $where);

            if ($if_vehicle > 0)
                $product_type = 'vehicle';
            elseif ($if_real_estate > 0)
                $product_type = 'real_estate';
            elseif ($if_car_mobile_number > 0)
                $product_type = 'car_mobile_number';

            $data['product_type'] = $product_type;
            $cal_query = ' select count(product_id) totcnt from products_images where product_id=' . $pro_id . ' having totcnt>0';
            $my_counter = $this->db->query($cal_query);

            if ($my_counter->num_rows() > 0) {
                if ($my_counter->row_array()['totcnt'] > 0)
                    $data['mycounter'] = $my_counter->row_array()['totcnt'] + 1;
                else
                    $data['mycounter'] = $my_counter->row_array()['totcnt'];
            } else
                $data['mycounter'] = 1;


            if ($product_type == 'vehicle')
                $product = $this->dbcommon->get_vehicle_product(null, null, $pro_id, null, null);
            elseif ($product_type == 'real_estate')
                $product = $this->dbcommon->get_real_estate_product(null, null, $pro_id, null, null);
            elseif ($product_type == 'car_mobile_number')
                $product = $this->dbcommon->get_car_mobile_number_product(null, null, $pro_id, null, null);
            else
                $product[] = (array) $this->dbcommon->get_product_admin($pro_id);

            $data['user_role'] = '';
            $data['productowner_role'] = '';
            $productowner_role = '';
            if ((sizeof($product[0]) > 0) && (($admin_permission == 'only_listing' && $product[0]['product_posted_by'] == $admin_user->user_id && $product[0]['product_is_inappropriate'] == 'Unapprove') || empty($admin_permission))) {

                if (isset($product[0]['plate_source'])) {
                    $where = ' plate_source_id=' . $product[0]['plate_source'];
                    $plate_prefix = $this->dbcommon->filter('plate_prefix', $where);
                    $data['plate_prefix'] = $plate_prefix;
                }

                $user_id = $product[0]['product_posted_by'];

                $check_getuser = $this->db->query('select * from user 
                                    left join store on store.store_owner=user.user_id
                                    where user_id=' . (int) $user_id . ' and is_delete in (0,3) and user_role in ("storeUser","generalUser","offerUser") limit 1')->row_array();

                $chkuser_id = (int) $check_getuser['user_id'];
                $user_role = $check_getuser['user_role'];
                $data['productowner_role'] = $check_getuser['user_role'];
                $productowner_role = $check_getuser['user_role'];

                $data['user_category_id'] = '';
                $data['user_sub_category_id'] = '';
                $data['user_store_status'] = '';

                if ($chkuser_id > 0 && $user_role == 'storeUser') {
                    $data['user_category_id'] = $check_getuser['category_id'];
                    $data['user_sub_category_id'] = $check_getuser['sub_category_id'];
                    $data['user_store_status'] = $check_getuser['store_status'];
                }

                $data['user_id'] = $user_id;
                $product_old_img = $product[0]['product_image'];
                $img_cnt = $this->dbcommon->get_images_count($pro_id);

                $data['img_cnt'] = 10 - (int) $img_cnt;

                /* if($product_type=='vehicle')
                  { */
                if (isset($product[0]['product_brand']))
                    $where = " brand_id='" . $product[0]['product_brand'] . "'";
                else
                    $where = " brand_id=0";

                $model = $this->dbcommon->filter('model', $where);
                $data['model'] = $model;
                //}		
                $vido_cnt = 0;
                if ($product[0]['video_name'] != '')
                    $vido_cnt = 1;

                $data['vido_cnt'] = 1 - (int) $vido_cnt;

                $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
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
                $fileName = '';
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
                    if (isset($_FILES)) {
                        end($_FILES);
                        $key = key($_FILES);

                        $input = $key;
                        $d = explode('multiUpload', $input);
                        if (isset($d[1]))
                            $images_num = $d[1];
                    }
                    //if(isset($_FILES))
                    //$images_num =  sizeof($_FILES);
                    //if(isset($_FILES['multiUpload']['name']))
                    //      echo     $images_num = sizeof($_FILES['multiUpload']['name']);

                    if (isset($_POST['default_submit'])) {
                        $img1 = $this->dbcommon->get_images($pro_id);
                        $where = " where category_id='" . $_POST['cat_id'] . "'";
                        $cat_name = $this->dbcommon->getdetails('category', $where);
                        $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                        $pro = strtoupper(substr($_POST['pro_name'], 0, 2));
                        $pro_code = $cat . $pro . $num . $str;

                        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                        $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                        $this->form_validation->set_rules('pro_name', 'Ad Title', 'trim|required|max_length[80]');
                        $this->form_validation->set_rules('pro_desc', 'Description', 'trim|required|max_length[650]');
                        $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
//                        $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                        // if(isset($productowner_role) && $productowner_role=='storeUser') {  
                        if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        }

                        if ($this->form_validation->run() == FALSE):

                            $this->load->view('admin/listings/edit', $data);
                        else:
                            $picture = $product[0]['product_image'];
                            $fileName = $_POST["form1_images_arr"];

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
                                $video_img = $product[0]['video_image_name'];
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


                            $product_bk = (array) $this->dbcommon->getrowdetails('product', $my_wh);
                            $bk1 = json_encode($product_bk);

                            $reatestate_bk = (array) $this->dbcommon->getrowdetails('product_realestate_extras', $my_wh);
                            $bk2 = json_encode($reatestate_bk);

                            $vehicle_bk = (array) $this->dbcommon->getrowdetails('product_vehicles_extras', $my_wh);
                            $bk3 = json_encode($vehicle_bk);

                            $car_mobile_number_bk = (array) $this->dbcommon->getrowdetails('car_mobile_numbers', $my_wh);
                            $bk4 = json_encode($car_mobile_number_bk);

                            $pro_bk = array('product_id' => $pro_id,
                                'product_table' => $bk1,
                                'estate_table' => $bk2,
                                'vehicle_table' => $bk3,
                                'car_mobile_num' => $bk4,
                                'created_by' => $user[0]->user_id
                            );

                            $result = $this->dbcommon->insert('product_old_data', $pro_bk);

                            $this->db->query('delete from product_realestate_extras where product_id=' . $pro_id);
                            $this->db->query('delete from product_vehicles_extras where product_id=' . $pro_id);

                            $data = array(
                                'product_code' => $pro_code,
                                'product_name' => $_POST['pro_name'],
                                'category_id' => $_POST['cat_id'],
                                'sub_category_id' => $_POST['sub_cat'],
                                'product_description' => $_POST['pro_desc'],
                                'product_price' => str_replace(",", "", $_POST['pro_price']),
                                'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                                'admin_modified_at' => date('y-m-d H:i:s', time()),
                                'product_brand' => 0,
                                'state_id' => $_POST['state'],
                                'country_id' => $_POST['location'],
                                'admin_modified_by' => $user[0]->user_id,
                                'phone_no' => $_POST['pro_phone'],
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'update_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {

                                $data['total_stock'] = $_POST['total_stock'];
                                $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                                if ($avail_stock != '')
                                    $avail_stock = $avail_stock;
                                else
                                    $avail_stock = $product[0]['stock_availability'];

                                $data['stock_availability'] = $avail_stock;
                                $data['product_is_sold'] = '';
                                $this->dbcommon->product_stock_track($pro_id);
                            }

                            if ($_POST['product_is_inappropriate'] == 'Approve') {
                                if ($product[0]['product_for'] == 'classified')
                                    $data['product_is_sold'] = 0;

                                $data['product_deactivate'] = null;
                            }

                            $result = $this->dbcommon->update('product', $array, $data);
                        endif;
                    }
                    elseif (isset($_POST['vehicle_submit'])) {
                        $img1 = $this->dbcommon->get_images($pro_id);
                        $where = " where category_id='" . $_POST['cat_id'] . "'";
                        $cat_name = $this->dbcommon->getdetails('category', $where);
                        $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));

                        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                        $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                        $this->form_validation->set_rules('title', 'Ad Title', 'trim|required|max_length[80]');
                        $this->form_validation->set_rules('vehicle_pro_desc', 'Description', 'trim|required|max_length[650]');

                        $this->form_validation->set_rules('pro_brand', 'Brand', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_model', 'Model', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_type_of_car', 'Type Of Car', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_year', 'Year', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_mileage', 'Mileage', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_condition', 'Condition', 'trim|required');
                        $this->form_validation->set_rules('vehicle_pro_color', 'Color', 'trim|required');
                        $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
//                        $this->form_validation->set_rules('vehicle_pro_price', 'Price', 'trim|required');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                        if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        }

                        if ($this->form_validation->run() == FALSE):

                            $this->load->view('admin/listings/edit', $data);
                        else:
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
                                $video_img = $product[0]['video_image_name'];
                                if ($video != '') {
                                    $vid = explode("_", $video);
                                    $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                                    $dest = document_root . product . 'video_image/' . $video_img;
                                    if (file_exists(document_root . product . 'video_image/' . $video_img))
                                        $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                                }
                                $youtube = $product[0]['youtube_link'];
                            }

                            //$img_name   =   $this->image_upload($images_num,$pro_id,$product);
                            $my_wh = ' where product_id=' . $pro_id;

                            $product_bk = (array) $this->dbcommon->getrowdetails('product', $my_wh);
                            $bk1 = json_encode($product_bk);

                            $reatestate_bk = (array) $this->dbcommon->getrowdetails('product_realestate_extras', $my_wh);
                            $bk2 = json_encode($reatestate_bk);

                            $vehicle_bk = (array) $this->dbcommon->getrowdetails('product_vehicles_extras', $my_wh);
                            $bk3 = json_encode($vehicle_bk);

                            $car_mobile_number_bk = (array) $this->dbcommon->getrowdetails('car_mobile_numbers', $my_wh);
                            $bk4 = json_encode($car_mobile_number_bk);

                            $pro_bk = array('product_id' => $pro_id,
                                'product_table' => $bk1,
                                'estate_table' => $bk2,
                                'vehicle_table' => $bk3,
                                'car_mobile_num' => $bk4,
                                'created_by' => $user[0]->user_id
                            );

                            $result = $this->dbcommon->insert('product_old_data', $pro_bk);

                            $this->db->query('delete from product_realestate_extras where product_id=' . $pro_id);

                            $data = array(
                                'product_code' => $pro_code,
                                'product_name' => $_POST['title'],
                                'state_id' => $_POST['state'],
                                //'product_image' => (isset($img_name) && $img_name!='') ? $img_name : $product[0]['product_image'],
                                'sub_category_id' => $_POST['sub_cat'],
                                'category_id' => $_POST['cat_id'],
                                'product_brand' => $_POST['pro_brand'],
                                'country_id' => $_POST['location'],
                                'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                                'product_description' => $_POST['vehicle_pro_desc'],
                                'product_price' => str_replace(",", "", $_POST['vehicle_pro_price']),
                                'admin_modified_at' => date('y-m-d H:i:s', time()),
                                'admin_modified_by' => $user[0]->user_id,
                                'phone_no' => $_POST['pro_phone'],
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'update_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {

                                $data['total_stock'] = $_POST['total_stock'];
                                $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                                if ($avail_stock != '')
                                    $avail_stock = $avail_stock;
                                else
                                    $avail_stock = $product[0]['stock_availability'];

                                $data['stock_availability'] = $avail_stock;
                                $data['product_is_sold'] = '';
                                $this->dbcommon->product_stock_track($pro_id);
                            }

                            if ($_POST['product_is_inappropriate'] == 'Approve') {
                                if ($product[0]['product_for'] == 'classified')
                                    $data['product_is_sold'] = 0;

                                $data['product_deactivate'] = null;
                            }

                            $result = $this->dbcommon->update('product', $array, $data);
                            $query = ' * from product_vehicles_extras where product_id=' . $pro_id;
                            $cnt = $this->dbcommon->getnumofdetails_($query);
                            if ($cnt > 0) {
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
                            } else {
                                $data_extras = array(
                                    'product_id' => $pro_id,
                                    'make' => '',
                                    'model' => $_POST['vehicle_pro_model'],
                                    'type_of_car' => $_POST['vehicle_pro_type_of_car'],
                                    'color' => $_POST['vehicle_pro_color'],
                                    'millage' => $_POST['vehicle_pro_mileage'],
                                    'vehicle_condition' => $_POST['vehicle_pro_condition'],
                                    'year' => (isset($_POST['vehicle_pro_year']) && $_POST['vehicle_pro_year'] != '') ? $_POST['vehicle_pro_year'] : NULL
                                );

                                $result = $this->dbcommon->insert('product_vehicles_extras', $data_extras);
                            }
                        //exit;
                        endif;
                    } elseif (isset($_POST['real_estate_houses_submit'])) {
                        $img1 = $this->dbcommon->get_images($pro_id);
                        $where = " where category_id='" . $_POST['cat_id'] . "'";
                        $cat_name = $this->dbcommon->getdetails('category', $where);
                        $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                        $pro = strtoupper(substr($_POST['houses_ad_title'], 0, 2));

                        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                        $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                        $this->form_validation->set_rules('houses_ad_title', 'Title', 'trim|required|max_length[80]');
                        $this->form_validation->set_rules('house_pro_desc', 'Description', 'trim|required|max_length[650]');
                        $this->form_validation->set_rules('pro_square_meters', 'Square Meters', 'trim|required');
                        $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('state', 'Emirate', 'trim|required');
                        $this->form_validation->set_rules('address', 'Address', 'trim|required');

                        if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        }

                        if ($this->form_validation->run() == FALSE):
                            $this->load->view('admin/listings/edit', $data);
                        else:
                            $pro = strtoupper(substr($_POST['houses_ad_title'], 0, 2));
                            $pro_code = $cat . $pro . $num . $str;

                            //$img_name   =   $this->image_upload($images_num,$pro_id,$product);
                            $fileName = $this->input->post("form3_images_arr");
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
                                $video_img = $product[0]['video_image_name'];
                                if ($video != '') {
                                    $vid = explode("_", $video);
                                    $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                                    $dest = document_root . product . 'video_image/' . $video_img;
                                    if (file_exists(document_root . product . 'video_image/' . $video_img))
                                        $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                                }
                                $youtube = $product[0]['youtube_link'];
                            }


                            $my_wh = ' where product_id=' . $pro_id;
                            $product_bk = (array) $this->dbcommon->getrowdetails('product', $my_wh);
                            $bk1 = json_encode($product_bk);

                            $reatestate_bk = (array) $this->dbcommon->getrowdetails('product_realestate_extras', $my_wh);
                            $bk2 = json_encode($reatestate_bk);

                            $vehicle_bk = (array) $this->dbcommon->getrowdetails('product_vehicles_extras', $my_wh);
                            $bk3 = json_encode($vehicle_bk);

                            $car_mobile_number_bk = (array) $this->dbcommon->getrowdetails('car_mobile_numbers', $my_wh);
                            $bk4 = json_encode($car_mobile_number_bk);

                            $pro_bk = array('product_id' => $pro_id,
                                'product_table' => $bk1,
                                'estate_table' => $bk2,
                                'vehicle_table' => $bk3,
                                'car_mobile_num' => $bk4,
                                'created_by' => $user[0]->user_id
                            );

                            $result = $this->dbcommon->insert('product_old_data', $pro_bk);

                            $this->db->query('delete from product_vehicles_extras where product_id=' . $pro_id);

                            $picture_ban = array();

                            $data = array(
                                'product_code' => $pro_code,
                                'product_name' => $_POST['houses_ad_title'],
                                'category_id' => $_POST['cat_id'],
                                'sub_category_id' => $_POST['sub_cat'],
                                //'product_image' => (isset($img_name) && $img_name!='') ? $img_name : $product[0]['product_image'], 
                                'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                                'product_description' => $_POST['house_pro_desc'],
                                'product_price' => str_replace(",", "", $_POST['houses_price']),
                                'admin_modified_at' => date('y-m-d H:i:s', time()),
                                'state_id' => $_POST['state'],
                                'country_id' => $_POST['location'],
                                'product_brand' => 0,
                                'admin_modified_by' => $user[0]->user_id,
                                'phone_no' => $_POST['pro_phone'],
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'update_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {

                                $data['total_stock'] = $_POST['total_stock'];
                                $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                                if ($avail_stock != '')
                                    $avail_stock = $avail_stock;
                                else
                                    $avail_stock = $product[0]['stock_availability'];

                                $data['stock_availability'] = $avail_stock;
                                $data['product_is_sold'] = '';

                                $this->dbcommon->product_stock_track($pro_id);
                            }

                            if ($_POST['product_is_inappropriate'] == 'Approve') {
                                if ($product[0]['product_for'] == 'classified')
                                    $data['product_is_sold'] = 0;

                                $data['product_deactivate'] = null;
                            }

                            $result = $this->dbcommon->update('product', $array, $data);

                            $query = ' * from product_realestate_extras where product_id=' . $pro_id;
                            $cnt = $this->dbcommon->getnumofdetails_($query);
                            if ($cnt > 0) {
                                $data_extras = array(
                                    'neighbourhood' => $_POST['houses_pro_neighbourhood'],
                                    'address' => $_POST['address'],
                                    'furnished' => $_POST['furnished'],
                                    'pets' => $_POST['pets'],
                                    'free_status' => (isset($_POST['houses_free'])) ? $_POST['houses_free'] : '',
                                    'broker_fee' => $_POST['broker_fee'],
                                    'Bedrooms' => $_POST['bedrooms'],
                                    'Bathrooms' => $_POST['bathrooms'],
                                    'Area' => $_POST['pro_square_meters'],
                                    'ad_language' => $_POST['houses_language']
                                );
                                $result = $this->dbcommon->update('product_realestate_extras', $array, $data_extras);
                            } else {
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
                                    'ad_language' => $_POST['houses_language'],
                                    'product_id' => $pro_id
                                );
                                $result = $this->dbcommon->insert('product_realestate_extras', $data_extras);
                            }
                        endif;
                    } elseif (isset($_POST['real_estate_shared_submit'])) {
                        $img1 = $this->dbcommon->get_images($pro_id);
                        $where = " where category_id='" . $_POST['cat_id'] . "'";
                        $cat_name = $this->dbcommon->getdetails('category', $where);
                        $cat = strtoupper(substr($cat_name[0]->catagory_name, 0, 3));
                        $pro = strtoupper(substr($_POST['shared_ad_title'], 0, 2));

                        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
                        $this->form_validation->set_rules('sub_cat', 'Subcategory', 'trim|required');
                        $this->form_validation->set_rules('shared_ad_title', 'Title', 'trim|required|max_length[80]');
                        $this->form_validation->set_rules('shared_pro_desc', 'Description', 'trim|required|max_length[650]');
                        $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('state', 'Emirate', 'trim|required');
                        $this->form_validation->set_rules('address', 'Address', 'trim|required');

                        if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        }


                        if ($this->form_validation->run() == FALSE):

                            $this->load->view('admin/listings/edit', $data);
                        else:
                            $fileName = $this->input->post("form4_images_arr");

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
                                $video_img = $product[0]['video_image_name'];
                                if ($video != '') {
                                    $vid = explode("_", $video);
                                    $video_img = '0_' . $vid[1] . '_videoimg.jpg';

                                    $dest = document_root . product . 'video_image/' . $video_img;
                                    if (file_exists(document_root . product . 'video_image/' . $video_img))
                                        $this->dbcommon->watermarkImage($video_img, $WaterMark, $dest, 50, 'video_image');
                                }
                                $youtube = $product[0]['youtube_link'];
                            }

                            $pro = strtoupper(substr($_POST['shared_ad_title'], 0, 2));
                            $pro_code = $cat . $pro . $num . $str;
                            $my_wh = ' where product_id=' . $pro_id;
                            $product_bk = (array) $this->dbcommon->getrowdetails('product', $my_wh);
                            $bk1 = json_encode($product_bk);

                            $reatestate_bk = (array) $this->dbcommon->getrowdetails('product_realestate_extras', $my_wh);
                            $bk2 = json_encode($reatestate_bk);

                            $vehicle_bk = (array) $this->dbcommon->getrowdetails('product_vehicles_extras', $my_wh);
                            $bk3 = json_encode($vehicle_bk);

                            $car_mobile_number_bk = (array) $this->dbcommon->getrowdetails('car_mobile_numbers', $my_wh);
                            $bk4 = json_encode($car_mobile_number_bk);

                            $this->db->query('delete from product_vehicles_extras where product_id=' . $pro_id);

                            $pro_bk = array('product_id' => $pro_id,
                                'product_table' => $bk1,
                                'estate_table' => $bk2,
                                'vehicle_table' => $bk3,
                                'car_mobile_num' => $bk4,
                                'created_by' => $user[0]->user_id
                            );

                            $result = $this->dbcommon->insert('product_old_data', $pro_bk);

                            //$img_name   =   $this->image_upload($images_num,$pro_id,$product);

                            $data = array(
                                'product_code' => $pro_code,
                                'product_name' => $_POST['shared_ad_title'],
                                'category_id' => $_POST['cat_id'],
                                'sub_category_id' => $_POST['sub_cat'],
                                //'product_image' => (isset($img_name) && $img_name!='') ? $img_name : $product[0]['product_image'],
                                'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                                'product_description' => $_POST['shared_pro_desc'],
                                'product_price' => str_replace(",", "", $_POST['shared_price']),
                                'admin_modified_at' => date('y-m-d H:i:s', time()),
                                'admin_modified_by' => $user[0]->user_id,
                                'state_id' => $_POST['state'],
                                'country_id' => $_POST['location'],
                                'product_brand' => 0,
                                'phone_no' => $_POST['pro_phone'],
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'update_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {

                                $data['total_stock'] = $_POST['total_stock'];
                                $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                                if ($avail_stock != '')
                                    $avail_stock = $avail_stock;
                                else
                                    $avail_stock = $product[0]['stock_availability'];

                                $data['stock_availability'] = $avail_stock;
                                $data['product_is_sold'] = '';
                                $this->dbcommon->product_stock_track($pro_id);
                            }

                            if ($_POST['product_is_inappropriate'] == 'Approve') {
                                if ($product[0]['product_for'] == 'classified')
                                    $data['product_is_sold'] = 0;

                                $data['product_deactivate'] = null;
                            }

                            $result = $this->dbcommon->update('product', $array, $data);
                            $query = ' * from product_realestate_extras where product_id=' . $pro_id;
                            $cnt = $this->dbcommon->getnumofdetails_($query);
                            if ($cnt > 0) {
                                $data_extras = array(
                                    'neighbourhood' => $_POST['shared_pro_neighbourhood'],
                                    'address' => $_POST['address'],
                                    'free_status' => $_POST['shared_free'],
                                    'ad_language' => $_POST['shared_language']
                                );
                                $result = $this->dbcommon->update('product_realestate_extras', $array, $data_extras);
                            } else {
                                $data_extras = array(
                                    'neighbourhood' => $_POST['shared_pro_neighbourhood'],
                                    'address' => $_POST['address'],
                                    'free_status' => $_POST['shared_free'],
                                    'ad_language' => $_POST['shared_language'],
                                    'product_id' => $pro_id
                                );
                                $result = $this->dbcommon->insert('product_realestate_extras', $data_extras);
                            }
                        endif;
                    } elseif (isset($_POST['car_number_submit'])) {

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
                        $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
//                        $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                        $this->form_validation->set_rules('car_number', 'Car Number', 'trim|required');
                        $this->form_validation->set_rules('plate_source', 'Plate Source', 'trim|required');
                        $this->form_validation->set_rules('plate_digit', 'Plate Digit', 'trim|required');
                        $this->form_validation->set_rules('repeating_numbers_car', 'Repeating Number', 'trim|required');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                        if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        }


                        if ($this->form_validation->run() == FALSE):

                            $this->load->view('admin/listings/edit', $data);
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
                                $video_img = $product[0]['video_image_name'];
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
                            $product_bk = (array) $this->dbcommon->getrowdetails('product', $my_wh);
                            $bk1 = json_encode($product_bk);

                            $reatestate_bk = (array) $this->dbcommon->getrowdetails('product_realestate_extras', $my_wh);
                            $bk2 = json_encode($reatestate_bk);

                            $vehicle_bk = (array) $this->dbcommon->getrowdetails('product_vehicles_extras', $my_wh);
                            $bk3 = json_encode($vehicle_bk);

                            $my_wh .= ' and number_for="mobile_number"';
                            $car_mobile_number_bk = (array) $this->dbcommon->getrowdetails('car_mobile_numbers', $my_wh);
                            $bk4 = json_encode($car_mobile_number_bk);

                            $pro_bk = array('product_id' => $pro_id,
                                'product_table' => $bk1,
                                'estate_table' => $bk2,
                                'vehicle_table' => $bk3,
                                'car_mobile_num' => $bk4,
                                'created_by' => $user[0]->user_id
                            );

                            $result = $this->dbcommon->insert('product_old_data', $pro_bk);

                            $this->db->query('delete from product_realestate_extras where product_id=' . $pro_id);
                            $this->db->query('delete from product_vehicles_extras where product_id=' . $pro_id);

                            $data = array(
                                'product_code' => $pro_code,
                                'product_name' => $_POST['pro_name'],
                                'category_id' => $_POST['cat_id'],
                                'sub_category_id' => $_POST['sub_cat'],
                                'product_description' => $_POST['car_desc'],
                                'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                                'product_price' => str_replace(",", "", $_POST['pro_price']),
                                'admin_modified_at' => date('y-m-d H:i:s', time()),
                                'product_brand' => 0,
                                'state_id' => $_POST['state'],
                                'country_id' => $_POST['location'],
                                'admin_modified_by' => $user[0]->user_id,
                                'phone_no' => $_POST['pro_phone'],
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'update_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {

                                $data['total_stock'] = $_POST['total_stock'];
                                $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                                if ($avail_stock != '')
                                    $avail_stock = $avail_stock;
                                else
                                    $avail_stock = $product[0]['stock_availability'];

                                $data['stock_availability'] = $avail_stock;
                                $data['product_is_sold'] = '';
                                $this->dbcommon->product_stock_track($pro_id);
                            }

                            if ($_POST['product_is_inappropriate'] == 'Approve') {
                                if ($product[0]['product_for'] == 'classified')
                                    $data['product_is_sold'] = 0;

                                $data['product_deactivate'] = null;
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
                        $this->form_validation->set_rules('mob_desc', 'Description', 'trim|required|max_length[650]');
                        $this->form_validation->set_rules('pro_phone', 'Phone No.', 'trim|required|min_length[10]');
//                        $this->form_validation->set_rules('pro_price', 'Price', 'trim|required');
                        $this->form_validation->set_rules('mobile_operators', 'Mobile Operator', 'trim|required');
                        $this->form_validation->set_rules('repeating_numbers_mobile', 'Repeating Number', 'trim|required');
                        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
                        $this->form_validation->set_rules('location', 'Country', 'trim|required');
                        $this->form_validation->set_rules('state', 'Emirate', 'trim|required');

                        if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {
                            $this->form_validation->set_rules('total_stock', 'Total Stock', 'trim|required|is_natural');
                        }


                        if ($this->form_validation->run() == FALSE):

                            $this->load->view('admin/listings/edit', $data);
                        else:
                            $picture = $product[0]['product_image'];
                            $fileName = $_POST["form6_images_arr"];

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
                                $video_img = $product[0]['video_image_name'];
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
                            $product_bk = (array) $this->dbcommon->getrowdetails('product', $my_wh);
                            $bk1 = json_encode($product_bk);

                            $reatestate_bk = (array) $this->dbcommon->getrowdetails('product_realestate_extras', $my_wh);
                            $bk2 = json_encode($reatestate_bk);

                            $vehicle_bk = (array) $this->dbcommon->getrowdetails('product_vehicles_extras', $my_wh);
                            $bk3 = json_encode($vehicle_bk);

                            $my_wh .= ' and number_for="car_number"';
                            $car_mobile_number_bk = (array) $this->dbcommon->getrowdetails('car_mobile_numbers', $my_wh);
                            $bk4 = json_encode($car_mobile_number_bk);

                            $pro_bk = array('product_id' => $pro_id,
                                'product_table' => $bk1,
                                'estate_table' => $bk2,
                                'vehicle_table' => $bk3,
                                'car_mobile_num' => $bk4,
                                'created_by' => $user[0]->user_id
                            );

                            $result = $this->dbcommon->insert('product_old_data', $pro_bk);

                            $this->db->query('delete from product_realestate_extras where product_id=' . $pro_id);
                            $this->db->query('delete from product_vehicles_extras where product_id=' . $pro_id);

                            $data = array(
                                'product_code' => $pro_code,
                                'product_name' => $_POST['pro_name'],
                                'category_id' => $_POST['cat_id'],
                                'sub_category_id' => $_POST['sub_cat'],
                                'product_description' => $_POST['mob_desc'],
                                'product_is_inappropriate' => ($admin_permission == 'only_listing') ? 'Unapprove' : $_POST['product_is_inappropriate'],
                                'product_price' => str_replace(",", "", $_POST['pro_price']),
                                'admin_modified_at' => date('y-m-d H:i:s', time()),
                                'product_brand' => 0,
                                'state_id' => $_POST['state'],
                                'country_id' => $_POST['location'],
                                'admin_modified_by' => $user[0]->user_id,
                                'phone_no' => $_POST['pro_phone'],
                                'youtube_link' => $youtube,
                                'video_name' => $video,
                                'update_from' => 'web',
                                'video_image_name' => $video_img,
                                'address' => $this->input->post('address'),
                                'latitude' => $this->input->post('latitude'),
                                'longitude' => $this->input->post('longitude')
                            );

                            if (isset($product[0]['product_for']) && $product[0]['product_for'] == 'store') {

                                $data['total_stock'] = $_POST['total_stock'];
                                $avail_stock = $this->dbcommon->update_stock($_POST['total_stock'], $product[0]['total_stock'], $product[0]['stock_availability']);

                                if ($avail_stock != '')
                                    $avail_stock = $avail_stock;
                                else
                                    $avail_stock = $product[0]['stock_availability'];

                                $data['stock_availability'] = $avail_stock;
                                $data['product_is_sold'] = '';
                                $this->dbcommon->product_stock_track($pro_id);
                            }

                            if ($_POST['product_is_inappropriate'] == 'Approve') {
                                if ($product[0]['product_for'] == 'classified')
                                    $data['product_is_sold'] = 0;

                                $data['product_deactivate'] = null;
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
                                    'mobile_number' => $_POST['mobile_number'],
                                    'number_for' => 'mobile_number',
                                    'product_id' => $pro_id
                                );
                                $this->dbcommon->insert('car_mobile_numbers', $data_extras);
                            }

                        endif;
                    } else {
                        $this->load->view('admin/listings/edit', $data);
                        //redirect('admin/classifieds/listings_edit/'.$pro_id,$data);
                        //$this->load->view('admin/listings/edit/'.$pro_id, $data);
                    }
                    if (isset($result)) {

                        if (isset($img1)) {
//                            print_r($_POST['cov_img']);
//                            print_r($img1);
//                            exit;
                            //for old images
                            foreach ($img1 as $key => $val) {
                                $ext = explode(".", $val);
                                //$val)
                                if ($_POST['cov_img'] == '' && $key == 1) {
                                    $user_data = array(
                                        'product_image' => $val
                                    );
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

                                            $this->dbcommon->insert('products_images', $insert);
                                        }
                                        $user_data = array(
                                            'product_image' => $val
                                        );
                                        $array = array('product_id' => $pro_id);

                                        $this->dbcommon->update('product', $array, $user_data);
                                        $this->db->query('delete from products_images where product_image= "' . $val . '" and product_id=' . $pro_id);
                                    }
                                }
                            }
                        }
                        //for new images 			
                        $fileNameArray = explode(',', $fileName);

                        if (sizeof($fileNameArray) > 0 && $fileNameArray[0] != '') {
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
                                    $ext = explode(".", base64_decode($file));
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

                                        $user_data = array(
                                            'product_image' => base64_decode($file)
                                        );
                                        $array = array('product_id' => $pro_id);
                                        $this->dbcommon->update('product', $array, $user_data);
                                    }
                                }
                            }
                        }
                    }

                    if (isset($_POST['vehicle_submit']) || isset($_POST['default_submit']) || isset($_POST['real_estate_houses_submit']) || isset($_POST['real_estate_shared_submit']) || isset($_POST['car_number_submit']) || isset($_POST['mobile_number_submit'])):

                        if (isset($result)):
                            $where = " where product_id='" . $pro_id . "' ";
                            $product = $this->dbcommon->getrowdetails('product', $where);

                            $where1 = " where user_id='" . $product->product_posted_by . "' and is_delete=0";
                            $user_em = $this->dbcommon->getrowdetails('user', $where1);
                            $status = $_POST['product_is_inappropriate'];
                            $send_msg = '';

                            //if($product->product_is_inappropriate != $_POST['product_is_inappropriate']) {
                            if ($status == 'Approve') {
                                $send_msg = 'Your product has been updated as Active.';
                                $status1 = 'Active';
                            } elseif ($status == 'Unapprove') {
                                $send_msg = 'Your product has been updated as Unapprove.';
                                $status1 = 'Unapprove';
                            } elseif ($status == 'Inappropriate') {
                                $send_msg = 'Your product has been updated as Inappropriate.';
                                $status1 = 'Inappropriate';
                            } elseif ($status == 'NeedReview') {
                                $send_msg = 'Your product has been updated as In-active.';
                                $status1 = 'In-active';
                            }
                            $parser_data = array();

                            $product = $product->product_name;
                            $product_status = 'Ad Status : ' . $status1;
                            $title = $product_status;
                            $button_link = base_url() . "login/index";
                            $button_label = 'Click here to Login';

                            $product_title = ' Your Ad : ' . $product . ' has been updated as ' . $status1 . '.';
                            $content = '
       <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>
        <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:12px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;">' . $product_title . '</h6>       <br>
        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>
';

                            $new_data = $this->dbcommon->mail_format($title, $content);
                            $new_data = $this->parser->parse_string($new_data, $parser_data, '1');
                            //,'info@doukani.com'
                            if ($user_em->email_id != '') {
                                if (send_mail($user_em->email_id, $send_msg, $new_data)) {
                                    
                                }
                            }
                            //}

                            $this->session->set_flashdata(array('msg' => 'product updated successfully.', 'class' => 'alert-success'));
                            if ($pro_id > 0 && isset($_REQUEST['request_for']) && $_REQUEST['request_for'] == 'user' && isset($user_em->user_id)) {
                                $page_redirect = (isset($_GET['page'])) ? '&page=' . $_GET['page'] : '';
                                redirect('admin/classifieds/' . $function . '/' . $redirect . '/?userid=' . $user_em->user_id . $page_redirect);
                            } else {
                                $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                redirect('admin/classifieds/' . $function . '/' . $redirect . $page_redirect);
                            }
                        else:
                        //echo 'fail';
                        //$data['msg'] = 'product not updated, Please try again';
                        //$data['msg_class'] = 'alert-info';
                        //$this->load->view('admin/listings/edit', $data);
                        endif;
                    endif;
                //exit;
                endif;
            }
            else {
                $this->session->set_flashdata('msg', 'product not found');
                if ($pro_id > 0 && isset($_REQUEST['request_for']) && $_REQUEST['request_for'] == 'user' && isset($_REQUEST['userid'])) {
                    $page_redirect = (isset($_GET['page'])) ? '&page=' . $_GET['page'] : '';
                    redirect('admin/classifieds/' . $function . '/' . $redirect . '/?userid=' . $_REQUEST['userid'] . $page_redirect);
                } else {
                    $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                    redirect('admin/classifieds/' . $function . '/' . $redirect . $page_redirect);
                }
            }
        } else {
            $this->session->set_flashdata(array('msg' => 'product not found', 'class' => 'alert-info'));

            if ($pro_id > 0 && isset($_REQUEST['request_for']) && $_REQUEST['request_for'] == 'user' && isset($user_em->user_id)) {
                $page_redirect = (isset($_GET['page'])) ? '&page=' . $_GET['page'] : '';
                redirect('admin/classifieds/' . $function . '/' . $redirect . '?userid=' . $user_em->user_id . $page_redirect);
            } else {
                $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                redirect('admin/classifieds/' . $function . '/' . $redirect . $page_redirect);
            }
        }
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

    //remove existing video
    public function removevideo() {

        //sub images
        $target_dir = document_root . product;

        @unlink($target_dir . "video/" . $_POST['video']);
        $vid = explode(".", $_POST['video']);
        $name = $_POST['value'];
        $imagename = explode(".", base64_decode($name));
        $img_name = str_replace('_video', '', $imagename[0]);

        @unlink($target_dir . "video_image/" . $img_name . "_videoimg.jpg");
        $array = array('product_id' => $_POST['prod_id']);
        $data = array('video_name' => '',
            'video_image_name' => '');

        $this->dbcommon->update('product', $array, $data);
    }

    public function removemainimage() {
        //main image        
        $target_dir = document_root . product;

        $where = "product_id='" . $_POST['prod_id'] . "'";
        $imagname = $this->dbcommon->filter('product', $where);

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

        $array = array('product_id' => $_POST['prod_id']);
        $data = array('product_image' => $image_name);
        $this->dbcommon->update('product', $array, $data);
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

    //get data while posting ad or update post
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

    public function show_prefix() {
        $main_data = array();
        if (isset($_REQUEST['value']) && $_REQUEST['value'] != '')
            $val = $_REQUEST['value'];
        else
            $val = 0;

        $query = "plate_source_id= " . $val;
        $main_data['plate_prefix'] = $this->dbcommon->filter('plate_prefix', $query);
        $main_data['sel_prefix'] = $_POST['sel_prefix'];
        echo $this->load->view('admin/listings/show_plate_prefix', $main_data, TRUE);
        exit;
    }

    /*
     * Single and Multiple Delete (For All type of Products)
     * 
     */

    public function listings_delete($function = NULL, $redirect = NULL, $pro_id = NULL) {

        $redirect_url = '';
        $data = array();
        if ($this->input->post("checked_val") != '') {
            $product_ids = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $product_ids);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $pro_id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $del_prod = $this->db->query('update product set is_delete=1 where product_id in (' . $comma_ids . ')');

        if (isset($del_prod)) {

            $this->session->set_flashdata(array('msg' => 'Ad(s) deleted successfully', 'class' => 'alert-success'));

            if (isset($_REQUEST['request_for']) && $_REQUEST['request_for'] == 'user' && isset($_REQUEST['userid'])) {
                if (isset($_REQUEST['page']))
                    redirect('admin/classifieds/' . $function . '/' . $redirect . '/?userid=' . $_REQUEST['userid'] . '&page=' . $_REQUEST['page']);
                else
                    redirect('admin/classifieds/' . $function . '/' . $redirect . '/?userid=' . $_REQUEST['userid']);
            }
            else {
                if (isset($_REQUEST['page']))
                    redirect('admin/classifieds/' . $function . '/' . $redirect . '/?page=' . $_REQUEST['page']);
                else
                    redirect('admin/classifieds/' . $function . '/' . $redirect);
            }
        }
        else {
            $this->session->set_flashdata(array('msg' => 'Ad(s) not found', 'class' => 'alert-info'));

            if (isset($_REQUEST['request_for']) && $_REQUEST['request_for'] == 'user' && isset($_REQUEST['userid'])) {

                if (isset($_REQUEST['page']))
                    redirect('admin/classifieds/' . $function . '/' . $redirect . '/?userid=' . $_REQUEST['userid'] . '&page=' . $_REQUEST['page']);
                else
                    redirect('admin/classifieds/' . $function . '/' . $redirect . '/?userid=' . $_REQUEST['userid']);
            }
            else {
                if (isset($_REQUEST['page']))
                    redirect('admin/classifieds/' . $function . '/' . $redirect . '/?page=' . $_REQUEST['page']);
                else
                    redirect('admin/classifieds/' . $function . '/' . $redirect);
            }
        }
    }

    public function listings_view($function = NULL, $redirect = NULL, $pro_id = NULL) {

        if ($pro_id != '' && $redirect != '' && $function != '') {

            $data = array();
            $data['redirect_admin_to'] = $redirect;
            $data['page_title'] = 'View Listing';
            $where = " where product_id='" . $pro_id . "'";
            // $product = $this->dbcommon->getdetails('product', $where);

            $product_type = 'default';

            $where = array('product_id' => $pro_id);

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

            $product_type = 'default';
            $where = array('product_id' => $pro_id);

            $if_vehicle = $this->dbcommon->get_count('product_vehicles_extras', $where);
            $if_real_estate = $this->dbcommon->get_count('product_realestate_extras', $where);
            $if_car_mobile_number = $this->dbcommon->get_count('car_mobile_numbers', $where);

            if ($if_vehicle > 0)
                $product_type = 'vehicle';
            elseif ($if_real_estate > 0)
                $product_type = 'real_estate';
            elseif ($if_car_mobile_number > 0)
                $product_type = 'car_mobile_number';

            $data['product_type'] = $product_type;

            if ($product_type == 'vehicle')
                $product = $this->dbcommon->get_vehicle_product(null, null, $pro_id, null, null);
            elseif ($product_type == 'real_estate')
                $product = $this->dbcommon->get_real_estate_product(null, null, $pro_id, null, null);
            elseif ($product_type == 'car_mobile_number')
                $product = $this->dbcommon->get_car_mobile_number_product(null, null, $pro_id, null, null);
            else
                $product[] = (array) $this->dbcommon->get_product_admin($pro_id);

            $check_getuser = $this->db->query('select * from user where user_id=' . (int) $product[0]['product_posted_by'] . ' and is_delete in (0,3) and user_role in ("storeUser") limit 1')->row_array();

            $chkuser_id = (int) $check_getuser['user_id'];
            $user_role = $check_getuser['user_role'];
            $data['productowner_role'] = $check_getuser['user_role'];
            $productowner_role = $check_getuser['user_role'];

            if (sizeof($product[0]) == 0)
                redirect('admin/home');

            if (isset($product[0]['product_brand']))
                $where = " brand_id='" . $product[0]['product_brand'] . "'";
            else
                $where = " brand_id=0";

            $model = $this->dbcommon->filter('model', $where);
            $data['model'] = $model;


            $cal_query = ' select count(product_id) totcnt from products_images where product_id=' . $pro_id . ' having totcnt>0';
            $my_counter = $this->db->query($cal_query);

            if ($my_counter->num_rows() > 0) {
                if ($my_counter->row_array()['totcnt'] > 0)
                    $data['mycounter'] = $my_counter->row_array()['totcnt'] + 1;
                else
                    $data['mycounter'] = $my_counter->row_array()['totcnt'];
            } else
                $data['mycounter'] = 1;

            $where = " product_id='" . $pro_id . "'";
            $data['images'] = $this->dbcommon->filter('products_images', $where);

            $user_id = $product[0]['product_posted_by'];
            $data['user_id'] = $user_id;

            $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
            $data['category'] = $category;
            $where = "  category_id='" . $product[0]['category_id'] . "'";
            $sub_category = $this->dbcommon->filter('sub_category', $where);
            $data['sub_category'] = $sub_category;

            $location = $this->dbcommon->select('country');
            $data['location'] = $location;

            $where = "country_id='" . $product[0]['country_id'] . "'";
            $sub_category = $this->dbcommon->filter('state', $where);
            $data['state'] = $sub_category;

            $user = array($this->session->userdata('user'));
            $data['user_role'] = $user[0]->user_role;

            if ($pro_id != null && !empty($product)):
                $data['product'] = $product;
                $this->load->view('admin/listings/view', $data);
            else:
                $this->session->set_flashdata(array('msg' => 'product not found', 'class' => 'alert-info'));
                redirect('admin/classifieds/listings/classified');
            endif;
        } else
            redirect('admin/home');
    }

    public function listings_spam() {

        $product_for = $this->uri->segment(4);
        if (!empty($product_for) && in_array($product_for, array('classified', 'store', 'offer'))) {
            $data['page_title'] = 'Spam Listing';
            $data['redirect_admin_to'] = $product_for;

            $user = $this->session->userdata('user');
            $data['admin_user'] = $user;

            $user_path = 'request=yes';

            $url = site_url() . 'admin/classifieds/listings_spam/' . $product_for . '?' . $user_path;

            $filter_val = 0;
            $filter_opt = 0;
            $sub_cat = 0;
            $state_id = 0;
            $search = '';

            if (isset($_REQUEST['page']))
                $search .= '?page=' . $_REQUEST['page'];

            if (isset($_REQUEST['per_page'])) {
                $per_page = $_REQUEST['per_page'];
            } else {
                $per_page = $this->per_page;
            }

            if (isset($_REQUEST['filter'])) {
                $filter_val = $_REQUEST['filter'];
            } else {
                $filter_val = 0;
            }
            //country
            if (isset($_REQUEST['con']) && $_REQUEST['con'] != 0) {
                $spam_country = $_REQUEST['con'];
            } else {
                $spam_country = 0;
            }
            //state- emirates
            if (isset($_REQUEST['st']) && $_REQUEST['st'] != 0) {
                $spam_state = $_REQUEST['st'];
            } else {
                $spam_state = 0;
            }
            //category
            if (isset($_REQUEST['cat']) && $_REQUEST['cat'] != 0) {
                $spam_category = $_REQUEST['cat'];
            } else {
                $spam_category = 0;
            }

            //sub-category
            if (isset($_REQUEST['sub_cat']) && $_REQUEST['sub_cat'] != 0) {
                $spam_sub_category = $_REQUEST['sub_cat'];
            } else {
                $spam_sub_category = 0;
            }

            if (isset($_REQUEST['dt']) && $_REQUEST['dt'] != 0) {
                $spam_date = $_REQUEST['dt'];
            } else {
                $spam_date = 0;
            }

            $spam_query = " and product_for='" . $product_for . "' and p.is_delete=0  ";

            $query = '';

            if ($filter_val == '0') {
                $query .= '' . $spam_query;
                $url .= '&filter=' . $filter_val;
            } elseif ($filter_val == 'emirates') {

                $url .= '&filter=' . $filter_val;

                if ($spam_country == '0' && $spam_state == "0")
                    $query .= $spam_query;
                elseif ($spam_country != '0' && $spam_state == "") {
                    $query .= " and p.country_id = " . $spam_country . '  ' . $spam_query;
                    $url .= '&con=' . $spam_country;
                } elseif ($spam_country != '0' && $spam_state != "0") {
                    $query .= " and p.country_id = " . $spam_country . " and p.state_id = " . $spam_state . $spam_query;
                    $url .= '&con=' . $spam_country . '&st=' . $spam_state;
                }
            } elseif ($filter_val == 'category') {
                $url .= '&filter=' . $filter_val;

                if ($spam_category == '0' && $spam_sub_category == "0")
                    $query .= $spam_query;
                elseif ($spam_category != '0' && $spam_sub_category == "0") {
                    $query .= " and c.category_id = " . $spam_category . ' ' . $spam_query;
                    $url .= '&cat=' . $spam_category;
                } elseif ($spam_category != '0' && $spam_sub_category != "0") {
                    $query .= " and c.category_id = " . $spam_category . " and sc.sub_category_id = " . $spam_sub_category . ' ' . $spam_query;
                    $url .= '&cat=' . $spam_category . '&sub_cat=' . $spam_sub_category;
                }
            }

            if ($filter_val == '0' || $filter_val == 'emirates' || $filter_val == 'category') {
                if (isset($spam_date) && $spam_date != '') {
                    $pieces = explode(" to ", $spam_date);
                    $start_date = date("Y-m-d", strtotime($pieces[0]));
                    $end_date = date("Y-m-d", strtotime($pieces[1]));
                    $query .= " and ( date(product_posted_time)>='" . $start_date . "' and date(product_posted_time)<='" . $end_date . "') ";
                    $url .= '&dt=' . $spam_date;
                }
            }

            $wh_count = " p.product_id FROM product as p 
                    left join category as c on c.category_id=p.category_id 
                    left join sub_category as sc on sc.sub_category_id=p.sub_category_id   
                    left join user as u on u.user_id=p.product_posted_by
                    left join store st on st.store_owner=u.user_id
                    where p.category_id=c.category_id  " . $query . " and product_is_inappropriate='Inappropriate' group by p.product_id";

            $pagination_data = $this->dbcommon->pagination($url, $wh_count, $per_page, 'yes');

            $data["links"] = $pagination_data['links'];
            $data['total_records'] = $pagination_data['total_rows'];

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

            $query = $query . "  group by p.product_id order by p.product_id desc limit  " . $offset . "," . $per_page;

            $wh = "	select 
                            u.user_id,u.user_role,u.device_type,if(u.nick_name!='',u.nick_name,u.username) user_name,if(p.phone_no!='',p.phone_no,if(u.contact_number !='',u.contact_number,if(u.phone!='',u.phone,'-'))) as user_contact_number, u.email_id,p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate,p.product_is_sold,p.product_deactivate,p.product_posted_by,c.catagory_name,st.store_id                             FROM product as p   
                            left join category as c on c.category_id=p.category_id 
                            left join sub_category as sc on sc.sub_category_id=p.sub_category_id 
                            left join user as u on u.user_id=p.product_posted_by
                            left join store st on st.store_owner=u.user_id
                            where p.category_id=c.category_id  and product_is_inappropriate='Inappropriate'  " . $query;

            $product = $this->dbcommon->get_distinct($wh);

            $data['product'] = $product;
            $data['spam'] = "and product_is_inappropriate = 'Inappropriate'";
            $data['user_role'] = $user->user_role;
            $data['search'] = $search;

            $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
            $data['category'] = $category;
            $location = $this->dbcommon->select('country');
            $data['location'] = $location;
            $msg = $this->session->flashdata('msg');
            if (!empty($msg)):
                $data['msg'] = $this->session->flashdata('msg');
                $data['msg_class'] = $this->session->flashdata('class');
            endif;
            $this->load->view('admin/listings/list_index', $data);
        } else
            redirect('admin/home');
    }

    public function filterListing() {
        $filter_val = $this->input->post("option");
        $filter_opt = $this->input->post("value");
        $sub_cat = $this->input->post("subcat");
        $state_id = $this->input->post("state");
        //$spam_query = $this->input->post("spam");
        $spam_query = " product.product_deactivate is null and  product.is_delete = 0 and product.product_is_inappropriate != 'Inappropriate'";
        $main_data = array();
        if ($filter_val == '0') {
            $query = $spam_query;
            $main_data['product'] = $this->dbcommon->filter('product', $query);
        } elseif ($filter_val == 'emirates') {

            if ($filter_opt == '0' && $state_id == "0") {
                $query = $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } elseif ($filter_opt != '0' && $state_id == "") {
                $query = "country_id = " . $filter_opt . ' and ' . $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } elseif ($filter_opt != '0' && $state_id != "0") {

                $query = "country_id = " . $filter_opt . " and state_id = " . $state_id . ' and ' . $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            }
        } elseif ($filter_val == 'category') {
            if ($filter_opt == '0' && $sub_cat == "0") {
                $query = $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } elseif ($filter_opt != '0' && $sub_cat == "0") {
                $query = "category_id = " . $filter_opt . ' and ' . $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } elseif ($filter_opt != '0' && $sub_cat != "0") {
                $query = "category_id = " . $filter_opt . " and sub_category_id = " . $sub_cat . ' and ' . $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            }
        } elseif ($filter_val == 'status') {
            if ($filter_opt == '0') {
                $query = $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            } else {
                if ($filter_opt == 'NeedReview' || $filter_opt == 'Approve' || $filter_opt == 'Unapprove' || $filter_opt == 'Inappropriate')
                    $query = "product_is_inappropriate= '" . $filter_opt . "'" . ' and ' . $spam_query;
                else
                    $query = "product_status= '" . $filter_opt . "'" . ' and ' . $spam_query;
                $main_data['product'] = $this->dbcommon->filter('product', $query);
            }
        } elseif ($filter_val == 'featured') {
            $wh = '';
            if ($filter_opt != '') {
                $pieces = explode(" to ", $filter_opt);
                $start_date = date("Y-m-d", strtotime($pieces[0]));
                $end_date = date("Y-m-d", strtotime($pieces[1]));
                $wh = " and (dateFeatured>='" . $start_date . "' and dateExpire<='" . $end_date . "') ";
            }

            $query = $this->db->query("select * from product p right join featureads f on f.product_id=p.product_id where p.is_delete = 0 and p.product_is_inappropriate != 'Inappropriate' " . $wh . " group by p.product_id");

            $main_data['product'] = $query->result_array();
        } elseif ($filter_val == 'unfeatured') {
            $query = $this->db->query("select * from product p right join featureads f on f.product_id=p.product_id where  p.is_delete = 0 and p.product_is_inappropriate != 'Inappropriate' group by p.product_id order by f.id desc");

            $main_data['product'] = $query->result_array();
        }

        //echo '<pre>';

        echo $this->load->view('admin/listings/list_index', $main_data, TRUE);
        exit();
    }

    public function show_sub_cat() {
        $filter_val = $this->input->post("value");
        $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(0, sub_category_type) > 0 order by sub_cat_order asc";
        if (isset($_POST['userid']) && $_POST['userid'] != '') {

            $check_getuser = $this->db->query('select * from user 
                                left join store on store.store_owner=user.user_id
                                where user_id=' . (int) $_POST['userid'] . ' and is_delete in(0,3) GROUP BY user.user_id limit 1')->row_array();

            $chkuser_id = (int) $check_getuser['user_id'];

            if ($chkuser_id > 0) {

                if (isset($_POST['ad_type']) && $_POST['ad_type'] == "1") {
                    $main_data['user_category_id'] = $check_getuser['category_id'];
                    $main_data['user_sub_category_id'] = $check_getuser['sub_category_id'];
                    $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(1, sub_category_type) > 0 order by sub_cat_order asc";
                }
            } else {
                redirect('admin/home');
            }
        }
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);

        echo $this->load->view('admin/listings/sub_cat', $main_data, TRUE);
        exit();
    }

    public function filter_sub_cat() {
        $filter_val = $this->input->post("value");
        $sel_subcat = $this->input->post("sel_subcat");


        if (isset($_POST['userid']) && $_POST['userid'] != '') {

            $check_getuser = $this->db->query('select * from user 
                                left join store on store.store_owner=user.user_id
                                where user_id=' . (int) $_POST['userid'] . ' and is_delete = 0 and  user_block = 0 limit 1')->row_array();

            $chkuser_id = (int) $check_getuser['user_id'];

            if ($chkuser_id > 0) {

                if ($check_getuser['store_status'] > 0 && $check_getuser['store_is_inappropriate'] != 'Approve')
                    redirect('admin/home');
                else {
                    //print_r($check_getuser);
                    $main_data['user_category_id'] = $check_getuser['category_id'];
                    $main_data['user_sub_category_id'] = $check_getuser['sub_category_id'];
                }
            } else {
                redirect('admin/home');
            }
        }


        $query = "category_id= '" . $filter_val . "' order by sub_cat_order asc";
        $main_data['selected'] = $sel_subcat;
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);
        echo $this->load->view('admin/listings/filter_sub_cat', $main_data, TRUE);
        exit();
    }

    public function order_category() {
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

    public function order_emirate() {
        $order = $this->input->post("order");
        $i = min($order);
        foreach ($order as $value) {
            $data = array(
                'sort_order' => $i
            );
            $array = array('state_id' => $value);
            $result = $this->dbcommon->update('state', $array, $data);
            $i++;
        }
    }

    public function order_sub_category() {
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

    public function update_status($function = NULL, $product_for = NULL) {

        //print_r($_REQUEST);
        $user = array($this->session->userdata('user'));
        $status = $this->input->post("status");

        $order = explode(",", $this->input->post("checked_val"));
        //if ($status == "available" || $status == "sold" || $status == "out of stock" || $status == "discontinued") {
        if ($status == "available" || $status == "sold") {
            //$field_name = "product_status";
            $field_name = "product_is_sold";
        } else {
            $field_name = "product_is_inappropriate";
        }
        if ($order[0] == 0) {
            array_shift($order);
        }
        $success = 0;
        foreach ($order as $value) {

            if ($status == 'sold') {
                $data = array(
                    $field_name => $status,
                    'product_is_sold' => 1,
                    'admin_modified_at' => date('y-m-d H:i:s', time())
                );
                $array = array('product_id' => $value, 'product_is_inappropriate' => 'Approve');
                $in_arr = array('user_id' => $user[0]->user_id,
                    'product_id' => $value
                );

                $this->dbcommon->insert('user_mark_sold', $in_arr);
            } elseif ($status == 'available' || $status == 'Approve') {
                $data = array(
                    $field_name => $status,
                    'product_is_sold' => 0,
                    'product_is_inappropriate' => 'Approve',
                    'product_deactivate' => null,
                    'admin_modified_at' => date('y-m-d H:i:s', time())
                );

                $array = array('product_id' => $value, 'is_delete' => 0);
                $del = array('product_id' => $value);
                $this->dbcommon->delete('user_mark_sold', $del);
            } else {
                $data = array(
                    $field_name => $status,
                    'admin_modified_at' => date('y-m-d H:i:s', time())
                );
                $array = array('product_id' => $value);
            }
            $array = array('product_id' => $value);
            $result = $this->dbcommon->update('product', $array, $data);

            if (isset($result)) {
                $success = 1;

                $where = " where product_id='" . $value . "' and is_delete=0";
                $product = $this->dbcommon->getrowdetails('product', $where);

                $where1 = " where user_id='" . $product->product_posted_by . "' and is_delete=0";
                $user_em = $this->dbcommon->getrowdetails('user', $where1);

                $send_msg = '';
                if ($status == 'available') {
                    $send_msg = 'Your product has been updated as Active.';
                    $status1 = 'Active';
                } elseif ($status == 'sold') {
                    $send_msg = 'Your product has been updated as Sold.';
                    $status1 = 'Sold';
                } elseif ($status == 'Approve') {
                    $send_msg = 'Your product has been updated as Active.';
                    $status1 = 'Active';
                } elseif ($status == 'Unapprove') {
                    $send_msg = 'Your product has been updated as Unapprove.';
                    $status1 = 'Unapprove';
                } elseif ($status == 'Inappropriate') {
                    $send_msg = 'Your product has been updated as Inappropriate.';
                    $status1 = 'Inappropriate';
                }
                $parser_data = array();

                $product = $product->product_name;
                $product_status = 'Ad Status : ' . $status1;
                $title = $product_status;
                $button_link = base_url() . "login/index";
                $button_label = 'Click here to Login';

                $product_title = ' Your Ad : ' . $product . ' has been updated as ' . $status1 . '.';
                $content = '
       <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>
        <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:12px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;">' . $product_title . '</h6>       
        <br>
        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>
';

                $new_data = $this->dbcommon->mail_format($title, $content);
                $new_data = $this->parser->parse_string($new_data, $parser_data, '1');
                if ($user_em->email_id != '') {
                    if (send_mail($user_em->email_id, $send_msg, $new_data, 'info@doukani.com')) {
                        
                    }
                }
            }
        }

        if ($success > 0)
            $this->session->set_flashdata(array('msg' => 'Listing updated successfully', 'class' => 'alert-success'));
        redirect('admin/classifieds/' . $function . '/' . $product_for);
    }

    public function insert_featured($function, $for) {

//        echo $this->get_usa_time('2016-11-16 13:42:55');
        $start_date = $this->dbcommon->get_usa_time(date("Y-m-d H:i:s", strtotime($_REQUEST['from_date'])));
        $end_date = $this->dbcommon->get_usa_time(date("Y-m-d H:i:s", strtotime($_REQUEST['to_date'])));

//        $pieces = explode(" to ", $_POST['from_to']);
//        $start_date = date("Y-m-d H:i:s", strtotime($pieces[0]));
//        $end_date = date("Y-m-d H:i:s", strtotime($pieces[1]));
//        $start_date = date("Y-m-d H:i:s", strtotime($_POST['from_date']));
//        $end_date = date("Y-m-d H:i:s", strtotime($_POST['to_date']));

        $checked_values = explode(",", $_POST['checked_values']);
        $user = $this->session->userdata('user');
        $user_id = $user->user_id;
        $success = 0;
        foreach ($checked_values as $val) {
            $res = $this->db->query('select category_id,sub_category_id,product_id from product where product_is_inappropriate="Approve" and is_delete=0 and product_deactivate is null and product_id=' . (int) $val . ' and product_for="classified" ');

            if ($res->num_rows() > 0) {
                $data = $res->result_array();

                $del_arr = array('product_id' => $data[0]['product_id']);
                $this->dbcommon->delete('featureads', $del_arr);

                $arra = array('product_id' => $data[0]['product_id'],
                    'cat_id' => $data[0]['category_id'],
                    'subcat_id' => $data[0]['sub_category_id'],
                    'product_id' => $data[0]['product_id'],
                    'User_Id' => $user_id,
                    'dateFeatured' => $start_date,
                    'dateExpire' => $end_date
                );

                $result = $this->dbcommon->insert('featureads', $arra);
                $success++;
            }
        }
//        var_dump($success);
//        exit;
        if ($success > 0)
            $this->session->set_flashdata('msg', 'product(s) featured successfully');

        redirect('admin/classifieds/' . $function . '/' . $for);
    }

    public function show_emirates() {

        $value = $this->input->post("value");
        if ($value == '')
            $value = 0;
        $query = "country_id= " . $value;
        $main_data['state'] = $this->dbcommon->filter('state', $query);
        $main_data['sel_city'] = $_REQUEST['sel_city'];
        echo $this->load->view('admin/listings/show_state', $main_data, TRUE);
        exit;
    }

    public function image_upload($images_num, $pro_id, $product) {
        if ($images_num > 0) {
            for ($i = 1; $i <= $images_num; $i++) {
                //print_r($_FILES['multiUpload'.$i]['tmp_name']);
                if (isset($_FILES['multiUpload' . $i]['tmp_name']) && $_FILES['multiUpload' . $i]['tmp_name'] != '') {
                    $target_dir = document_root . product;
                    $profile_picture = $_FILES['multiUpload' . $i]['name'];
                    $ext = explode(".", $_FILES['multiUpload' . $i]['name']);
                    $picture_ban[$i] = time() . $i . "." . end($ext);
                    $target_file = $target_dir . "original/" . $picture_ban[$i];
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    $imageFileType = strtolower($imageFileType);
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

                        if (move_uploaded_file($_FILES['multiUpload' . $i]['tmp_name'], $target_file)) {
                            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                
                            } else {

                                $data1 = array(
                                    'product_id' => $pro_id,
                                    'product_image' => $picture_ban[$i]
                                );
                                //print_r($data1);
                                if ($i > 1)
                                    $result = $this->dbcommon->insert('products_images', $data1);
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
                                if ($i == 1 && isset($_FILES['multiUpload1']['tmp_name'])) {
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
            if (isset($images_num)) :
            /* for ($i = 2; $i <= $images_num; $i++) 
              {
              if (!empty($picture_ban[$i])) {
              $data = array(
              'product_id' => $pro_id,
              'product_image' => $picture_ban[$i]
              );
              // $result = $this->dbcommon->insert('products_images', $data);
              }
              } */
            endif;
            return $picture_ban[1];
        }
    }

    public function show_model() {
        $value = $this->input->post("value");
        if ($value == '')
            $value = 0;

        $query = "brand_id= " . $value;
        $main_data['model'] = $this->dbcommon->filter('model', $query);

        echo $this->load->view('admin/users/show_model', $main_data, TRUE);
        exit;
    }

    public function featured_ads() {

        $url = site_url() . 'admin/classifieds/featured_ads/';
        $main_data['page_title'] = 'Featured Ads';
        $main_data['redirect_admin_to'] = 'classified';

        $only_featured = NULL;
        $search = '';
        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'featured') {
            $only_featured = 'yes';
            $search = ' and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between f.dateFeatured and f.dateExpire)';
            $url .= $this->uri->segment(4) . '/';
        }

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page_;

        $query = ' f.*,if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between f.dateFeatured and f.dateExpire,"running","not running") as my_status, p.product_id,p.product_name,p.product_image from featureads f left join product p on p.product_id=f.product_id where p.is_delete=0 and product_is_inappropriate="Approve" and product_deactivate is null ' . $search;

        $pagination_data = $this->dbcommon->pagination($url, $query, $per_page, 'yes');

        $main_data['url'] = $url;
        $main_data["links"] = $pagination_data['links'];
        $main_data['total_records'] = $pagination_data['total_rows'];

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;
        $query = ' select ' . $query . ' order by f.id desc limit ' . $offset . ',' . $per_page;

        $main_data['featured_ads'] = $this->dbcommon->get_distinct($query);
//        echo $this->db->last_query();
        echo $this->load->view('admin/listings/featured_ads', $main_data, TRUE);
    }

    public function update_unfeatured($prod_id = NULL) {

        $redirect_url = '';
        $success = 0;

        if ($this->input->post("checked_val") != '') {
            $prod_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $prod_id);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $prod_id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $result = $this->db->query('select f.id featured_id,product.category_id,product.sub_category_id,product.product_id from product left join featureads f on f.product_id=product.product_id where product.is_delete=0 and f.id in (' . $comma_ids . ')')->result_array();

        foreach ($result as $res) {
            $wh = array('id' => $res['featured_id']);
            $this->dbcommon->delete('featureads', $wh);
            $success++;
        }

        if ($success > 0)
            $this->session->set_flashdata('msg', 'product(s) un-featured successfully');
        else
            $this->session->set_flashdata('msg', 'product(s) not un-featured');

        redirect('admin/classifieds/featured_ads/' . $redirect_url);
    }

    public function repost_ads() {

        $product_for = $this->uri->segment(4);
        if (!empty($product_for) && in_array($product_for, array('classified', 'store', 'offer'))) {

            $data = array();
            $data['page_title'] = 'Repost Listing';
            $data['redirect_admin_to'] = $product_for;

            $user = $this->session->userdata('user');
            $data['admin_user'] = $user;
            $data['spam'] = "";
            $data['user_role'] = $user->user_role;

            $category = $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
            $data['category'] = $category;

            $location = $this->dbcommon->select('country');
            $data['location'] = $location;
            $query = '';

            if (isset($_GET['userid']))
                $user_path = 'userid=' . $_GET['userid'];
            else
                $user_path = 'request=yes';

            $url = site_url() . 'admin/classifieds/repost_ads/' . $product_for . '?' . $user_path;

            $where = '';
            $filter_val = 0;
            $filter_opt = 0;
            $sub_cat = 0;
            $state_id = 0;
            $search = '';

            if (isset($_REQUEST['userid']) && $_REQUEST['userid'] != 0) {
                $repost_userid = $_REQUEST['userid'];
            } else {
                $repost_userid = 0;
            }

            if (isset($_REQUEST['filter'])) {
                $filter_val = $_REQUEST['filter'];
            } else {
                $filter_val = 0;
            }

            if (isset($_REQUEST['page']))
                $search .= '?page=' . $_REQUEST['page'];

            if (isset($_REQUEST['per_page'])) {
                $per_page = $_REQUEST['per_page'];
            } else {
                $per_page = $this->per_page;
            }

            //country
            if (isset($_REQUEST['con']) && $_REQUEST['con'] != 0) {
                $repost_country = $_REQUEST['con'];
            } else {
                $repost_country = 0;
            }
            //state- emirates
            if (isset($_REQUEST['st']) && $_REQUEST['st'] != 0) {
                $repost_state = $_REQUEST['st'];
            } else {
                $repost_state = 0;
            }
            //category
            if (isset($_REQUEST['cat']) && $_REQUEST['cat'] != 0) {
                $repost_category = $_REQUEST['cat'];
            } else {
                $repost_category = 0;
            }

            //sub-category
            if (isset($_REQUEST['sub_cat']) && $_REQUEST['sub_cat'] != 0) {
                $repost_sub_category = $_REQUEST['sub_cat'];
            } else {
                $repost_sub_category = 0;
            }

            //status
            if (isset($_REQUEST['status']) && $_REQUEST['status'] != "0") {
                $repost_status = $_REQUEST['status'];
            } else {
                $repost_status = 0;
            }

            //other status
            if (isset($_REQUEST['other_status']) && $_REQUEST['other_status'] != "0") {
                $repost_oth_status = $_REQUEST['other_status'];
            } else {
                $repost_oth_status = 0;
            }


            if (isset($_REQUEST['dt']) && $_REQUEST['dt'] != 0) {
                $repost_date = $_REQUEST['dt'];
            } else {
                $repost_date = 0;
            }

            $spam_query = " and p.is_delete=0";

            if ($filter_val == '0') {
                $url .= '&filter=' . $filter_val;
                $query .= '' . $spam_query;
            } elseif ($filter_val == 'emirates') {
                echo 'hello';
                $url .= '&filter=' . $filter_val;
                if ($repost_country == '0' && $repost_state == "0")
                    $query .= $spam_query;
                elseif ($repost_country != '0' && $repost_state == "") {
                    $query .= " and p.country_id = " . $repost_country . '  ' . $spam_query;
                    $url .= '&con=' . $repost_country;
                } elseif ($repost_country != '0' && $repost_state != "0") {
                    $query .= " and p.country_id = " . $repost_country . " and p.state_id = " . $repost_state . '  ' . $spam_query;
                    $url .= '&con=' . $repost_country . '&st=' . $repost_state;
                }
            } elseif ($filter_val == 'category') {
                $url .= '&filter=' . $filter_val;

                if ($repost_category == '0' && $repost_sub_category == "0")
                    $query .= $spam_query;
                elseif ($repost_category != '0' && $repost_sub_category == "0") {
                    $query .= " and c.category_id = " . $repost_category . '  ' . $spam_query;
                    $url .= '&cat=' . $repost_category;
                } elseif ($repost_category != '0' && $repost_sub_category != "0") {
                    $query .= " and c.category_id = " . $repost_category . " and sc.sub_category_id = " . $repost_sub_category . '  ' . $spam_query;
                    $url .= '&cat=' . $repost_category . '&sub_cat=' . $repost_sub_category;
                }
            }

            if ($repost_status != '') {
                if ($repost_status == '0')
                    $query .= $spam_query;
                else {
                    if ($repost_status == 'NeedReview' || $repost_status == 'Approve' || $repost_status == 'Unapprove' || $repost_status == 'Inappropriate')
                        $query .= " and p.product_is_inappropriate= '" . $repost_status . "'" . '  ' . $spam_query;
                    $url .= '&status=' . $repost_status;
                }
            }

            if ($repost_oth_status != '' && $repost_oth_status != "0") {

                if ($repost_oth_status == 'sold') {
                    $query .= "  and p.product_is_sold=1 and (p.product_deactivate<>1 or p.product_deactivate is null )" . $spam_query;
                    $url .= '&other_status=' . $repost_oth_status;
                } elseif ($repost_oth_status == 'deactivate') {
                    $query .= "  and (p.product_is_sold<>1 || p.product_is_sold is null || p.product_is_sold='') and p.product_deactivate=1 " . $spam_query;
                    $url .= '&other_status=' . $repost_oth_status;
                } elseif ($repost_oth_status == 'available') {
                    $query .= "  and (p.product_is_sold=0 or p.product_is_sold is null) and  (p.product_deactivate='' or p.product_deactivate is null) " . $spam_query;
                    $url .= '&other_status=' . $repost_oth_status;
                } elseif ($repost_oth_status == 'sold_deactivate') {
                    $query .= "  and p.product_is_sold=1 and p.product_deactivate=1" . $spam_query;
                    $url .= '&other_status=' . $repost_oth_status;
                } else
                    $query .= "";
            }


            if ($filter_val == '0' || $filter_val == 'emirates' || $filter_val == 'category') {

                if (isset($repost_date) && $repost_date != '') {
                    $pieces = explode(" to ", $repost_date);
                    $start_date = date("Y-m-d", strtotime($pieces[0]));
                    $end_date = date("Y-m-d", strtotime($pieces[1]));

                    $query .= "  and (date(r.created_at)>='" . $start_date . "' and date(r.created_at)<='" . $end_date . "') ";
                    $url .= '&dt=' . $repost_date;
                }
            }

            if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
                $query .= "  and product_posted_by=" . $_REQUEST['userid'];
            }
            $query .= ' and product_deactivate is null';
            $wh_count = " p.product_id FROM product as p 
                    left join category as c on c.category_id=p.category_id 
                    left join sub_category as sc on sc.sub_category_id=p.sub_category_id 
                    right join  repost as  r on r.productid=p.product_id 
                    left join  featureads f on f.product_id=p.product_id and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between f.dateFeatured and f.dateExpire)
                    left join user as u on u.user_id=p.product_posted_by
                    left join store st on st.store_owner=u.user_id
                    where p.category_id=c.category_id and p.product_is_inappropriate<>'Inappropriate' and product_for='" . $product_for . "'   " . $query . ' group by p.product_id';

            $pagination_data = $this->dbcommon->pagination($url, $wh_count, $per_page, 'yes');

            $data["links"] = $pagination_data['links'];
            $data['total_records'] = $pagination_data['total_rows'];

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

            $query = $query . " group by p.product_id order by p.product_reposted_time desc limit  " . $offset . "," . $per_page;

            $wh = "	select 
                    u.user_id,u.user_role,u.device_type,if(u.nick_name!='',u.nick_name,u.username) user_name,if(p.phone_no!='',p.phone_no,if(u.contact_number !='',u.contact_number,if(u.phone!='',u.phone,'-'))) as user_contact_number, u.email_id, 
                    r.id rid,p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate,p.product_is_sold,if(r.productid !='','Repost','New') as product_type,p.product_deactivate,p.product_posted_by,	c.catagory_name,if((CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between f.dateFeatured and f.dateExpire) and p.product_is_inappropriate='Approve' ,'f_ad','') as my_status,st.store_id
                        FROM product as p
    			left join category as c on c.category_id=p.category_id 
    			left join sub_category as sc on sc.sub_category_id=p.sub_category_id 
    			right join  repost as  r on r.productid=p.product_id
                        left join  featureads f on f.product_id=p.product_id and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between f.dateFeatured and f.dateExpire)
                        left join user as u on u.user_id=p.product_posted_by
                        left join store st on st.store_owner=u.user_id
    			where p.category_id=c.category_id  and p.product_is_inappropriate<>'Inappropriate' and product_for='" . $product_for . "' " . $query;

            $product = $this->dbcommon->get_distinct($wh);
            $data['product'] = $product;
            $data['search'] = $search;
            $msg = $this->session->flashdata('msg');
            if (!empty($msg)):
                $data['msg'] = $this->session->flashdata('msg');
                $data['msg_class'] = $this->session->flashdata('class');
            endif;

            $this->load->view('admin/listings/repost_ads_listing', $data);
        }
        else {
            redirect('admin/home');
        }
    }

    //remove radio selection wise 
    public function remove_image_selected() {
        $target_dir = document_root . product;
        $val = $_POST['value'];
        @unlink($target_dir . "original/" . base64_decode($val));
    }

    public function unset_alllisting_session() {

        $this->session->unset_userdata('repost_filter');
        $this->session->unset_userdata('repost_country');
        $this->session->unset_userdata('repost_state');
        $this->session->unset_userdata('repost_category');
        $this->session->unset_userdata('repost_sub_category');
        $this->session->unset_userdata('repost_status');
        $this->session->unset_userdata('repost_oth_status');
        $this->session->unset_userdata('repost_date');
        $this->session->unset_userdata('repost_per_page');
        $this->session->unset_userdata('repost_userid');

        $this->session->unset_userdata('listing_filter');
        $this->session->unset_userdata('listing_country');
        $this->session->unset_userdata('listing_state');
        $this->session->unset_userdata('listing_category');
        $this->session->unset_userdata('listing_sub_category');
        $this->session->unset_userdata('listing_status');
        $this->session->unset_userdata('listing_oth_status');
        $this->session->unset_userdata('listing_date');
        $this->session->unset_userdata('listing_userid');
        $this->session->unset_userdata('listing_per_page');
    }

    public function send_message_to_seller() {
        $response = $this->dbcommon->send_mail_seller();
        echo json_encode($response);
        exit;
    }

    public function like_user_list($product_id = NULL) {

        if (!is_null($product_id) && (int) $product_id > 0) {
            $data['page_title'] = 'Users List';
            $search = '';
            $url = '';
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

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

            $where = ' u.user_id FROM user u
                    LEFT JOIN like_product lp ON lp.user_id = u.user_id
                    WHERE lp.product_id= ' . $product_id . ' GROUP BY u.user_id
                ';
//        $where = ' u.user_id FROM user u
//                    LEFT JOIN like_product lp ON lp.user_id = u.user_id
//                    GROUP BY u.user_id
//                ';

            $pagination_data = $this->dbcommon->pagination($url, $where, $per_page, 'yes');
            $data["links"] = $pagination_data['links'];
            $data['total_records'] = $pagination_data['total_rows'];

            $users_list = $this->product->get_product_like_users($product_id, $offset);
            $data['users_list'] = $users_list;

            $this->load->view('admin/listings/like_users_list', $data);
        } else {
            redirect('admin/home');
        }
    }

    public function favorite_user_list($product_id = NULL) {

        if (!is_null($product_id) && (int) $product_id > 0) {
            $data['page_title'] = 'Users List';
            $search = '';
            $url = '';
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

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

//        $where = ' u.user_id FROM user u
//                    LEFT JOIN favourite_product fp ON fp.user_id = u.user_id
//                    WHERE fp.product_id= ' . $product_id . ' GROUP BY u.user_id
//                ';
            $where = ' u.user_id FROM user u
                    LEFT JOIN favourite_product fp ON fp.user_id = u.user_id
                    GROUP BY u.user_id
                ';

            $pagination_data = $this->dbcommon->pagination($url, $where, $per_page, 'yes');
            $data["links"] = $pagination_data['links'];
            $data['total_records'] = $pagination_data['total_rows'];

            $users_list = $this->product->get_product_favorite_users($product_id, $offset);
            $data['users_list'] = $users_list;

            $this->load->view('admin/listings/favorite_users_list', $data);
        } else {
            redirect('admin/home');
        }
    }

}

?>
