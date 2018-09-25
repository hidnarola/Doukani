<?php

class Upload3 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$this->load->view('home/upload_form', array('error' => ' ' ));
	}

	function do_upload()
	{
		$target_dir = document_root . profile;
		$picture = $_FILES['userfile']['name'];
		$target_file = $target_dir . "original/" . $picture;
		
		$config['upload_path'] = $target_dir . "original/";		
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '100';
		

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('userfile'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('home/upload_form', $error);
		}
		else
		{
			echo 'success';				
		}
	
		$target_dir = document_root . profile;
		$picture = $_FILES['userfile']['name'];
		$target_file = $target_dir . "original/" . $picture;
		 $config = array();
		$config['upload_path'] = $target_dir . "thumb/";		
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '100';
		

		$this->load->library('upload', $config);
		$set_upload	=false;
		/*if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
		
			$set_upload=true;
		} */
		//if($set_upload==true)
		{
			if ( ! $this->upload->do_upload('userfile'))
			{
				$error = array('error' => $this->upload->display_errors());

				$this->load->view('home/upload_form', $error);
			}
			else
			{
								$thumb_cover_art	=	$target_dir . "thumb/" . $picture;
								$config['image_library'] = 'gd2';
								$config['source_image'] = $target_file;
								$config['new_image'] = $thumb_cover_art;
								$config['create_thumb'] = FALSE;
								$config['maintain_ratio'] = TRUE;
								$config['width'] = 200;
								//$config['height'] = 150;
								$config['quality'] = 100;
								//print_r($config);
								
								$this->load->library('image_lib', $config);
								$this->image_lib->fit();
				$data = array('upload_data' => $this->upload->data());

				$this->load->view('home/upload_success', $data);
			}
		}	
	}
}
?>