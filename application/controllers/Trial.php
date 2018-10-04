<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trial extends My_controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($multiple = NULL) {
        $this->load->library('parser');

        $parser_data = array();
        $status1 = 'Approved';
        $product = 'Test product Name';
        $product_status = 'Ad Status : ' . $status1;

        $button_link = base_url() . "login/index";
        $button_label = 'Click here to Login';


        if (is_null($multiple)) {
            $title = $product_status;
            $product_title = ' Your Ad : ' . $product . ' has been updated as ' . $status1 . '.';
            $product_text = '<h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:15px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;">' . $product_title . '</h6>';
        } else {
            $product_title = 'Product List';
            $product_text = '<h3 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:24px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;">' . $product_title . '</h3>';
            $title = 'Ads Status';
        }

        $product_list = array(
            array('product_name' => 'Test 1', 'status' => 'Approved'),
            array('product_name' => 'Test 2', 'status' => 'Un-Approved'),
            array('product_name' => 'Test 1', 'status' => 'Approved'),
            array('product_name' => 'Test 2', 'status' => 'Un-Approved'),
            array('product_name' => 'Test 1', 'status' => 'Approved'),
            array('product_name' => 'Test 2', 'status' => 'Un-Approved'),
            array('product_name' => 'Test 1', 'status' => 'Approved'),
            array('product_name' => 'Test 2', 'status' => 'Un-Approved')
        );

        if (is_null($multiple)) {
            $table = '';
        } else {
            $table = '<table border="1" width="90%" style="border-collapse:collapse;border: 1px solid #ccc !important;">
                    <tr>
                        <th style="text-align:left;padding:8px;">Ad Name</th>
                        <th style="text-align:center;padding:8px;">Status</th>
                    </tr>';
            foreach ($product_list as $list) {
                $table .= '<tr>
                        <td style="padding:5px;">' . $list['product_name'] . '</td>
                        <td style="text-align:center;padding:5px;">' . $list['status'] . '</td>
                    </tr>';
            }
            $table .= '</table>';
        }
        $content = '
       <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>
        ' . $product_text . '
        <br>' . $table .
                '<br>
        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>
';

        $new_data = $this->dbcommon->mail_format($title, $content);
        $new_data = $this->parser->parse_string($new_data, $parser_data, '1');
        print_r($new_data);
    }

    public function test1() {

        $endpoint = 'convert';
        $access_key = 'edcab8e6a5f54519975d58d9971d65ea';

        $from = 'AED';
        $to = 'USD';
        $amount = 10;
        $ch = curl_init('https://openexchangerates.org/api/latest.json?app_id=edcab8e6a5f54519975d58d9971d65ea');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // get the JSON data:
        $json = curl_exec($ch);
        curl_close($ch);
        $conversionResult = json_decode($json, true);
        echo '<pre>';
        print_r(@$conversionResult);
        print_r(@$conversionResult['rates']['USD']);
        die();


        // set API Endpoint, access key, required parameters
        $endpoint = 'convert';
        $access_key = 'c8325d70c95d4df4f89e067d86e870ab';

        $from = 'AED';
        $to = 'USD';
        $amount = 10;
        $ch = curl_init('http://data.fixer.io/api/latest?access_key=' . $access_key . '&from=' . $from . '&to=' . $to . '&amount=' . $amount . '&format=1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // get the JSON data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $conversionResult = json_decode($json, true);
        echo '<pre>';
        print_r(@$conversionResult);
        print_r(@$conversionResult['rates']['USD']);
    }

}

?>