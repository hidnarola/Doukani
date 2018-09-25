<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trial extends My_controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

//        $email_id = SITE_ADMIN_EMAIL;
        $email_id = 'kek@narola.email';
        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];

        $this->db->select('SUM(b.store_amount) AS store_balance, GROUP_CONCAT(b.id) balance_ids, s.store_name');
        $this->db->join('orders o', 'o.id = b.order_id', 'LEFT');
        $this->db->join('store s', 's.store_owner = b.store_owner', 'LEFT');
        $this->db->where('o.status', 'completed');
        $this->db->where('o.is_delete', 0);
        $this->db->where('o.delivery_type', 'PREPAID');
        $this->db->where('o.id = b.order_id');
        $this->db->where('b.store_owner',   $user_id);
        $this->db->where('b.status', 1);
        $this->db->group_by('o.id');

        $query = $this->db->get('balance b');
        $balance = $query->row_array();

        if (isset($balance) && $balance['store_balance'] > 0)
            $amount = number_format($balance['store_balance'], 2);
        else
            $amount = 0.00;

        $button_label = 'Update Payment Status';
        $title = 'Payment Request';
        $store_name = $balance['store_name'];
        $button_link = base_url() . 'admin/users/e_wallet/?userid=' . $user_id;

        $count_of_peding_request = $this->dbcommon->getnumofdetails_(' * FROM e_wallet_request_response WHERE store_owner = ' . $user_id . ' AND status = 0');

        if ($count_of_peding_request == 0) {
            $in_wallet_data = array(
                'store_owner' => $user_id,
                'amount' => $amount,
                'status' => 0,
                'balance_ids' => $balance['balance_ids'],
                'created_by' => $user_id,
                'created_date' => date('Y-m-d H:i:s')
            );
            $result = $this->dbcommon->insert('e_wallet_request_response', $in_wallet_data);

            $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;">                        
                        <h3>Payment Request</h3>
                                        <p style="margin: 1em 0;">
                                        Hello Admin,
                                        </p>
                                        <p style="margin: 1em 0;">
                                        ' . $store_name . ' has sent request for AED ' . $amount . '
                                        </p>
    <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:240px; " href="' . $button_link . '">' . $button_label . '</a></div>';

            $new_data = $this->dbcommon->mail_format($title, $content);
            send_mail($email_id, $title, $new_data, 'info@doukani.com');
        }
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