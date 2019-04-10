<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Phone extends My_controller {

    public function __construct() {
        parent::__construct();
//		echo 'constructur calling';
//        $this->load->library('Phone');
//		echo 'constructur after calling';
    }

    //update weight
    public function index() {
        error_reporting(E_ALL);
        header('Content-Type: text/html; charset=UTF-8');

        $file_name = 'Delta-smart-products.csv';
        $coun = 0;
        $row = 1;
        $fileDirectory = './assets/files/';
        if (!is_dir($fileDirectory)) {
            mkdir($fileDirectory, 0777);
        }

        $handle = fopen($fileDirectory . "/" . $file_name, "r");

        if (($data1 = fgetcsv($handle, 10000, ",")) !== FALSE) {

            $valid_format = array('Product ID', 'Product Name', 'Price', 'Created Date', 'Weight', 'New Weight');

            if ($valid_format == $data1) {
                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    if ($row == 1) {
                        $row++;
                        continue;
                    }

                    $product_id = $data[0];
                    $product_name = $data[1];
                    $price = $data[2];
                    $created_date = $data[3];
                    $weight = $data[4];
                    $new_weight = $data[5];

                    echo $product_id . ' => ' . $product_name . ' => ' . $price . ' => ' . $created_date . ' => ' . $weight . ' => ' . $new_weight . '<br>';

                    $result = $this->db->query('SELECT * FROM product where product_id = ' . $product_id . ' AND product_name = "' . $product_name . '" AND weight = ' . $weight)->result_array();
                    pr($result);
                    if (isset($result) && sizeof($result) > 0 && isset($result[0]) && !empty($result[0])) {
//                        $this->db->query('UPDATE product SET weight = ' . $new_weight . ' WHERE product_id = ' . $product_id . ' AND product_name = "' . $product_name . '"');
                    }
                    echo '<br>';
                    echo '<br>';
                }
                fclose($handle);
            }
        }



//		echo 'constructur index calling';		
//		$this->Phone->hello();
    }

}
