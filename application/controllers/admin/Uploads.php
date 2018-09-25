<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Uploads extends CI_Controller {

    /*
     * Initiate UploadHandler class when the image is uploaded
     */
    public function index() {
       
        $target_dir = document_root . product;
        
        $ext = explode(".", $_FILES["file"]['name']);
                        $picture_ban = time() ."_" . trim(str_replace(" ", "_", $_FILES["file"]['name'])) . "." . end($ext);
                        $target_file = $target_dir . "original/" . $picture_ban;
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
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    
                                } else {
                                    $this->load->library('thumbnailer');
                                    $this->thumbnailer->prepare($target_file);
                                    list($width, $height, $type, $attr) = getimagesize($target_file);
                                    /* Image Processing */
                                    $thumb = $target_dir . "small/" . $picture_ban;
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
                                    $thumb = $target_dir . "medium/" . $picture_ban;
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
// if(move_uploaded_file($_FILES['file']['tmp_name'], "uploads/".$_FILES['file']['name'])){
        //     //echo($_POST['index']);
        // }
        // exit;
    }

    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */