<?php

class Doukani_logo extends CI_Controller {

    public function __construct() {
        parent::__construct();        
        $this->load->model('dbcommon', '', TRUE);        
    }

    public function index($user_role = null) {
        
        $data = array();
        $data['page_title'] = 'Doukani Logo';
        
        $query = ' 1=1';
        $data['doukani_logo_list'] = $this->dbcommon->filter('doukani_logo',$query);
                
        $this->load->view('admin/doukani_logo/index', $data);
    }
    
    public function edit($logo_id = NULL) {
        
        $data  = array();
        
        $user = $this->session->userdata('user');
        $data['page_title'] = 'Edit Doukani Logo';
        
        $where = " where id='" . $logo_id . "'";
        $logo = $this->dbcommon->getdetails('doukani_logo', $where);
        
        if(!empty($logo)) {
            $data['logo'] = $logo;
            
            $logo_image = '';
            if(isset($_POST['submit'])) {
                
                if (isset($_FILES['image_name']['tmp_name']) && $_FILES['image_name']['tmp_name'] != '') {
                    $target_dir = document_root . doukani_logo;
                    $profile_picture = $_FILES['image_name']['name'];
                    $ext = explode(".", $_FILES["image_name"]['name']);
                    $logo_image = time() . "." . end($ext);
                    $target_file = $target_dir . "original/" . $logo_image;
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    $imageFileType = strtolower($imageFileType);
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $data['msg_class'] = 'alert-info';
                        $uploadOk = 0;
                        $this->load->view('admin/doukani_logo/edit', $data);
                    }
                    if ($uploadOk == 0) {
                        $data['msg'] = "Sorry, your file was not uploaded.";
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/doukani_logo/edit', $data);
                    } else {

                        if (move_uploaded_file($_FILES["image_name"]["tmp_name"], $target_file)) { 
                            
                            $arr = array('id'=>$logo_id);
                            $up_data = array('image_name'=>$logo_image,
                                             'modified_by'=>$user->user_id,
                                             'modified_date'=>date('y-m-d H:i:s', time())
                                             );                    
                            $this->dbcommon->update('doukani_logo',$arr,$up_data);
                            
                            @unlink($target_dir . "original/" . $logo[0]->image_name);
                            $this->session->set_flashdata('msg', 'Doukani Logo changed successfully');
                        }
                    }
                }
                redirect('admin/doukani_logo');
            }
            
            $this->load->view('admin/doukani_logo/edit', $data);
        }
        else {
            redirect('admin/home');
        }
        
    }
    
    
    public function delete($logo_id = NULL) {
     
        $user = $this->session->userdata('user');    
        $logo = $this->db->query('select id from doukani_logo
                                where id = '.$logo_id)->result_array();
        
        foreach($logo as $l) {
            
            $arr = array('id'=>$l['id']);
            
            $up_data = array('image_name'=>'',
                        'modified_by'=>$user->user_id,
                        'modified_date'=>date('y-m-d H:i:s', time())
                        );                    
            
            $this->dbcommon->update('doukani_logo',$arr,$up_data);
            @unlink($target_dir . "original/" . $logo[0]->image_name);
            
            $this->session->set_flashdata('msg', 'Doukani Logo deleted successfully');       
        }
        redirect('admin/doukani_logo');
    }
}

?>