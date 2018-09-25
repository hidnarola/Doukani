<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function pr($data, $status = 0) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if ($status == 1) {
        exit;
    }
}

function init_pagination() {
    $config = array();
    $config['enable_query_strings'] = TRUE;
//    $config['page_query_string'] = TRUE;
//    $config['query_string_segment'] = 'page';
    $config['use_page_numbers'] = TRUE;

    
    $config['uri_segment'] = 4;
    //config for bootstrap pagination class integration
    return $config;
}

?>
