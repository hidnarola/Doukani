<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Extending the custom controller
class Error404 extends My_controller {

    public function __construct() {
        parent::__construct();        
    }
    
    public function index() {			
	
        $data['page_title'] = '404 Page Not Found';        
        $this->load->view('home/error404', $data);
    }
}
?>