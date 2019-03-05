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

function get_offer_image_first($offer_id){
    $ci = &get_instance();
    $con = 'is_active = 1 AND offer_id = ' . $offer_id;
    $ci->db->where($con);
    $ci->db->limit(1);
    $query = $ci->db->get('offer_images');
//    echo $ci->db->last_query();
//    $query = $ci->db->result_array();
    return $query->row_array();
}

?>
