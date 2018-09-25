<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VideoUploads extends My_controller {

    function __construct() {
        // Construct our parent class
        parent::__construct();
		
		error_reporting(E_ALL | E_STRICT);
        $this->load->library("VideoUploader");
    }

    /*
     * Initiate VideoUploader class when the image is uploaded
     */
    public function index() {

        if ($this->input->post()) {					
			$upload_handler = new VideoUploader();
            exit;
        }
    }

    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */