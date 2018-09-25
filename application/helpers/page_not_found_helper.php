<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function override_404() {
    $CI = & get_instance();
    $data['page_title'] = '404 Page Not Found';
    $CI->load->view('home/error404',$data);
}
?>