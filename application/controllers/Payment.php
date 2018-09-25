<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dbcart');

//        $this->business_email = 'lp.narola-facilitator@narolainfotech.com';
        $this->business_email = 'adonisaz@gmail.com';
        //$this->url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $this->url = 'https://www.paypal.com/cgi-bin/webscr';
    }

    /*
     * Boost - Ads for Specific Hours
     */

    public function boost_payment_request() {

        if (isset($_POST['success']) && isset($_POST['purchase_hour'])) {

            $boost = $this->get_data('boost');
            $boost = explode('&', $boost);
            $product_id = $_POST['product_id'];
            $amount_text = $boost[0];
            $label = $boost[1];
            $hours_days = $boost[2] . '=hours-' . $product_id;

            $return_data = $this->paypal_charge($amount_text, $label, $hours_days, 'boost');
            echo $return_data;
            exit;
        }
    }

    /*
     * Buy no. Ads for Currenct Month
     */

    public function buy_ad_payment_request() {

        if (isset($_POST['success']) && isset($_POST['buy_ads'])) {

            $buy_ad = $this->get_data('buy_ad');
            $buy_ad = explode('&', $buy_ad);
            $amount_text = $buy_ad[0];
            $label = $buy_ad[1];
            $hours_days = $buy_ad[2] . '=days';

            $return_data = $this->paypal_charge($amount_text, $label, $hours_days, 'buy_ads');
            echo $return_data;
            exit;
        }
    }

    /*
     * checkout - Paypal Request
     */

    public function checkout_request() {

        $address_id = $this->input->post('address_id');
        $success = $this->input->post('success');
        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user) && !empty($current_user) && isset($success) && !empty($success) && isset($address_id) && !empty($address_id)) {

            $label = 'Checkout';
            $return_data = $this->paypal_charge(NULL, $label, NULL, 'checkout');
            $this->session->unset_userdata('doukani_products');
            $this->session->unset_userdata('cart_products');
            $this->session->unset_userdata('doukani_products_quantity');

            echo $return_data;
            exit;
        }
    }

    public function paypal_charge($amount = NULL, $item_name = NULL, $hour_days = NULL, $request = NULL) {

        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user['user_id'])) {

            $this->url = 'https://www.paypal.com/cgi-bin/webscr';
//            $business_email = 'payment@steamsmart.co';            

            $server_url = base_url();
            $return = $server_url;
            $cancel = $server_url;

            if ($request == 'buy_ads')
                $notify_url = $server_url . 'payment/paypal_response_buyads';
            elseif ($request == 'boost')
                $notify_url = $server_url . 'payment/paypal_response_boost';
            elseif ($request == 'checkout')
                $notify_url = $server_url . 'payment/paypal_response_checkout';

            $querystring = "?notify_url=" . urlencode(stripslashes($notify_url)) . "&";
            $querystring .= "business=" . urlencode($this->business_email) . "&";
            $querystring .= "item_name=" . urlencode($item_name) . "&";
            $querystring .= "currency_code=USD&";

            if ($request != 'checkout')
                $querystring .= "amount=" . $amount . "&";

            if ($hour_days != NULL)
                $querystring .= "custom=" . urlencode($current_user['user_id']) . "-" . urlencode($hour_days) . "&";
            else {
                if ($request == 'checkout') {
                    $address_id = $this->input->post('address_id');
                    $success = $this->input->post('success');
                    $current_user = $this->session->userdata('gen_user');
                    $request_product_str = rtrim($this->session->userdata('doukani_products'), ',');
                    $product_arry = explode(",", $this->session->userdata('doukani_products'));

                    $product_str = '';
                    $product_session = array();
                    $product_count = 0;
                    foreach ($product_arry as $id) {
                        $arr = explode('-', $id);
                        if (isset($arr) && !empty($arr) && isset($arr[0]) && isset($arr[1])) {
                            $product_str .= $arr[0] . ',';
                            $product_session[$arr[0]] = $arr[1];
                            $product_count++;
                        }
                    }

                    $products = rtrim($product_str, ',');
                    $products_arr = $this->dbcommon->get_distinct(" select product_name,product_id,product_price,stock_availability,product_posted_by  from product where product_id in (" . $products . ") and  is_delete =0 and  product_is_inappropriate='Approve' and product_deactivate IS NULL and stock_availability > 0 and product_for='store' order by product_posted_by");

                    if ($product_count == sizeof($products_arr)) {

                        $product_result = array();
                        foreach ($products_arr as $product) {
                            foreach ($product_session as $key => $val) {
                                if ($key == $product['product_id']) {
                                    $product['requested_qunatitiy'] = $val;
                                }
                            }
                            $product_result[$product['product_posted_by']][] = $product;
                        }

                        $insert_product = array();
                        $insert_product_cart = array();
                        $str_order_number = '';
                        $product_price = 0;
                        $product_price_ = 0;
                        $seller_shipping_cost = 0;
                        $seller_shipping_cost_ = 0;
                        $qunatity_ = 0;
                        if (sizeof($product_result) > 0) {

                            $in_trans = array('user_id' => $current_user['user_id'], 'status' => 0, 'created_date' => date('Y-m-d H:i:s'));

                            foreach ($product_result as $key => $value) {

                                $sub_total = 0;
                                $final_total = 0;
                                $final_qunatity = 0;
                                $shipping_cost = 0;
                                $qunatity = 0;

                                foreach ($value as $val) {

                                    $qunatity = $val['requested_qunatitiy'];
                                    $qunatity_ += $val['requested_qunatitiy'];
                                    $product_price_ += ($val['product_price'] * $qunatity);
                                }

                                $costing = $this->dbcommon->seller_shipping_cost($key);
                                if (isset($costing->shipping_cost) && !empty($costing->shipping_cost))
                                    $seller_shipping_cost = $costing->shipping_cost;
                                else
                                    $seller_shipping_cost = 0;

                                $seller_shipping_cost_ += $seller_shipping_cost;
                            }
                        }
                    }

                    $final_total_ = $product_price_ + $seller_shipping_cost_;
                    $final_total_ = str_replace(",", "", $this->get_currency($final_total_));

                    $querystring .= "amount=" . urlencode($final_total_) . "&";
                    $querystring .= "custom=" . urlencode($current_user['user_id']) . "/" . urlencode($request_product_str) . "/" . urlencode($product_str) . "/" . urlencode($final_total_) . "/" . urlencode($qunatity_) . "/" . urlencode($product_count) . "/" . urlencode($address_id) . "&";
                } else
                    $querystring .= "custom=" . urlencode($current_user['user_id']) . "&";
            }
            $querystring .= "cmd=_xclick&";
            $querystring .= "no_note=1&";
            $querystring .= "lc=US&";
            $querystring .= "return=" . urlencode(stripslashes($return)) . "&";
            $querystring .= "cancel_return=" . urlencode(stripslashes($cancel));
            $redirect_url = $this->url . $querystring;

            return $redirect_url;
        }
    }

    public function test() {
        $product_table = 'product';
        $right_header = NULL;
        $shipping_address = NULL;
        $this->dbcart->buyer_mail($product_table, $right_header, $shipping_address);
    }

    public function paypal_response_checkout() {

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $postdata = '';
            foreach ($_POST as $key => $val) {
                $body .= $key . "=>" . $val . "\n";
            }

            foreach ($_POST as $i => $v) {
                $postdata .= $i . '=' . urlencode($v) . '&';
            }
            $postdata .= 'cmd=_notify-validate';

            $web = parse_url($this->url);
            if ($web['scheme'] == 'https') {
                $web['port'] = 443;
                $ssl = 'ssl://';
            } else {
                $web['port'] = 80;
                $ssl = '';
            }
            $fp = @fsockopen($ssl . $web['host'], $web['port'], $errnum, $errstr, 30);
            if (!$fp) {
                echo $errnum . ': ' . $errstr;
            } else {
//                /print_r($_POST)                
                fputs($fp, "POST " . $web['path'] . " HTTP/1.1\r\n");
                fputs($fp, "Host: " . $web['host'] . "\r\n");
                fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
                fputs($fp, "Content-length: " . strlen($postdata) . "\r\n");
                fputs($fp, "Connection: close\r\n\r\n");
                fputs($fp, $postdata . "\r\n\r\n");

                while (!feof($fp)) {
                    $info[] = @fgets($fp, 1024);
                }
                fclose($fp);
                $info = implode(',', $info);
//                $this->Inventory_model->test_paypal(array('name' => $info));
                $pos = strpos($info, 'VERIFIED');
                if ($pos === false) {
                    // error log here
                } else {

//                mail('kek@narola.email','Paypal - Checkout',print_r($_POST,1));

                    $current_user = $this->session->userdata('gen_user');
                    $str_custom = explode('/', $_POST['custom']);

                    $user_id = $str_custom[0];
                    $product_ids = $str_custom[1];
                    $product_str = $str_custom[2];
                    $product_count = $str_custom[5];
                    $address_id = $str_custom[6];

                    $user_email = $this->dbcommon->getFieldById($user_id);
//                mail('kek@narola.email','Paypal - Checkout',$user_id.'==='.$product_ids .'====' . $product_str.'===='.$product_count . '====' . $address_id);

                    $in_data = array(
                        'item_name' => $_POST['item_name'],
                        'payment_status' => $_POST['payment_status'],
                        'payer_status' => $_POST['payer_status'],
                        'user_id' => $user_id,
                        'product_id' => $product_ids,
                        'payment_type' => $_POST['payment_type'],
                        'txn_type' => $_POST['txn_type'],
                        'payer_business_name' => $_POST['payer_business_name'],
                        'payer_email' => $_POST['payer_email'],
                        'payment_fee' => $_POST['payment_fee'],
                        'payment_gross' => $_POST['payment_gross'],
                        'shipping' => $_POST['shipping'],
                        'quantity' => $_POST['quantity'],
                        'verify_sign' => $_POST['verify_sign'],
                        'response' => print_r($_POST, 1),
                        'payment_date' => $_POST['payment_date']
                    );
                    $this->dbcommon->insert('paypal_payment', $in_data);

                    if ($_POST['payment_status'] == 'Completed') {

                        $product_arry = explode(",", rtrim($product_ids, ','));
                        $product_session = array();
                        foreach ($product_arry as $id) {
                            $arr = explode('-', $id);
                            if (isset($arr) && !empty($arr) && isset($arr[0]) && isset($arr[1])) {
                                $product_session[$arr[0]] = $arr[1];
                            }
                        }

                        $products = rtrim($product_str, ',');

                        $products_arr = $this->dbcommon->get_distinct(" select product_name,product_id,product_price,stock_availability,product_posted_by from product where product_id in (" . $products . ") and  is_delete =0 and  product_is_inappropriate='Approve' and product_deactivate IS NULL and stock_availability > 0 and product_for='store' order by product_posted_by");

                        if ($product_count == sizeof($products_arr)) {

                            $product_result = array();
                            foreach ($products_arr as $product) {
                                foreach ($product_session as $key => $val) {
                                    if ($key == $product['product_id']) {
                                        $product['requested_qunatitiy'] = $val;
                                    }
                                }
                                $product_result[$product['product_posted_by']][] = $product;
                            }

                            $insert_product = array();
                            $insert_product_cart = array();
                            $i = 1;
                            $str_order_number = '';
                            $delivery_type = 'PREPAID';

                            if (sizeof($product_result) > 0) {

                                $in_trans = array('user_id' => $user_id, 'status' => 0, 'created_date' => date('Y-m-d H:i:s'));
                                $this->dbcommon->insert('transaction', $in_trans);
                                $transaction_id = $this->db->insert_id();

                                foreach ($product_result as $key => $value) {

                                    $ord_no = '';
                                    $ord_no = $this->dbcart->generate_order_number($key);
                                    $order_number[$key] = substr($ord_no + $key, 0, 9);

                                    $sub_total = 0;
                                    $final_total = 0;
                                    $final_qunatity = 0;
                                    $shipping_cost = 0;
                                    $qunatity = 0;

                                    foreach ($value as $val) {

                                        $qunatity = $val['requested_qunatitiy'];
                                        $product_price = $val['product_price'] * $qunatity;

                                        $sub_total += $product_price;
                                        $final_qunatity += $qunatity;
                                        $final_total = $final_total + ($val['product_price'] * $qunatity);

                                        $in_order_products = array(
                                            'product_id' => $val['product_id'],
                                            'quantity' => $qunatity,
                                            'price' => $product_price,
                                            'user_id' => $user_id,
                                            'product_owner' => $val['product_posted_by'],
                                            'created_date' => date('Y-m-d H:i:s')
                                        );

                                        $insert_product[$val['product_posted_by']][] = $in_order_products;

                                        $in_order_products[$val['product_posted_by']][] = array(
                                            'quantity' => $qunatity,
                                            'price' => $product_price,
                                            'product_name' => $val['product_name']
                                        );
                                    }

                                    $costing = $this->dbcommon->seller_shipping_cost($key);
                                    if (isset($costing->shipping_cost) && !empty($costing->shipping_cost))
                                        $seller_shipping_cost = $costing->shipping_cost;
                                    else
                                        $seller_shipping_cost = 0;

                                    $in_data = array(
                                        'transaction_id' => $transaction_id,
                                        'order_number' => $order_number[$key],
                                        'address_id' => $address_id,
                                        'user_id' => $user_id,
                                        'sub_total' => $sub_total,
                                        'shipping_cost' => $seller_shipping_cost,
                                        'final_total' => $final_total + $seller_shipping_cost,
                                        'final_qunatity' => $final_qunatity,
                                        'status' => 'in_progress',
                                        'is_delete' => 0,
                                        'delivery_type' => 0,
                                        'seller_id' => $key,
                                        'created_date' => date('Y-m-d H:i:s'),
                                        'delivery_type' => $delivery_type
                                    );

                                    $str_order_number .= $order_number[$key] . ',';

                                    $this->dbcommon->insert('orders', $in_data);

                                    $order_id = 0;
                                    $order_id = $this->db->insert_id();
                                    $order_ids[$key] = $order_id;

                                    $sold_date = date('F d,Y', time());
                                    $right_header = $this->dbcart->right_header($order_number[$key], $sold_date);
                                    $shipping_address = $this->dbcart->shipping_address($address_id);
                                    $product_table = $this->dbcart->mail_product_list($in_order_products[$key], $sub_total, $seller_shipping_cost, $final_total + $seller_shipping_cost);

                                    //send mail to Buyer
                                    $this->dbcart->buyer_mail($product_table, $right_header, $shipping_address, $user_email);

                                    //Send Mail to Seller                         
                                    $seller_data = $this->dbcommon->seller_data($key);
                                    $email_id = $seller_data->email_id;
                                    $seller_name = (isset($seller_data->nick_name) && !empty($seller_data->nick_name)) ? $seller_data->nick_name : $seller_data->username;

                                    $this->dbcart->seller_mail($seller_name, $sold_date, $right_header, $email_id, $product_table, $shipping_address);
                                    $i++;
                                }

                                $j = 0;
                                $final_batch = array();
                                foreach ($insert_product as $in) {
                                    foreach ($in as $product) {
                                        if ($order_number[$j] = $product['product_owner']) {

                                            $product['order_id'] = $order_ids[$product['product_owner']];
                                            $final_batch[] = $product;
                                        }
                                    }
                                    $j++;
                                }

                                if (sizeof($final_batch) > 0) {

                                    $result = $this->dbcommon->insert_batch('product_orders', $final_batch);
                                    foreach ($product_arry as $res) {

                                        $arr = explode('-', $res);
                                        if (isset($arr) && !empty($arr) && isset($arr[0]) && isset($arr[1])) {
                                            $product_str .= $arr[0] . ',';

                                            $this->db->query('update product set stock_availability= stock_availability - ' . $arr[1] . ' where product_id=' . $arr[0]);
                                        }
                                    }

                                    $del_arr = array('user_id' => $user_id);
                                    $this->dbcommon->delete('user_shopping_cart', $del_arr);

//                                    $this->session->set_userdata('order_number', rtrim($str_order_number, ','));                                    
                                    $in_data = array('orderlist' => rtrim($str_order_number, ','),
                                        'user_id' => $user_id);
                                    $this->dbcommon->insert('order_success_msg', $in_data);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function paypal_response_buyads() {

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $postdata = '';
            foreach ($_POST as $key => $val) {
                $body .= $key . "=>" . $val . "\n";
            }

            foreach ($_POST as $i => $v) {
                $postdata .= $i . '=' . urlencode($v) . '&';
            }
            $postdata .= 'cmd=_notify-validate';

            $web = parse_url($this->url);
            if ($web['scheme'] == 'https') {
                $web['port'] = 443;
                $ssl = 'ssl://';
            } else {
                $web['port'] = 80;
                $ssl = '';
            }
            $fp = @fsockopen($ssl . $web['host'], $web['port'], $errnum, $errstr, 30);
            if (!$fp) {
                echo $errnum . ': ' . $errstr;
            } else {
//                /print_r($_POST)                
                fputs($fp, "POST " . $web['path'] . " HTTP/1.1\r\n");
                fputs($fp, "Host: " . $web['host'] . "\r\n");
                fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
                fputs($fp, "Content-length: " . strlen($postdata) . "\r\n");
                fputs($fp, "Connection: close\r\n\r\n");
                fputs($fp, $postdata . "\r\n\r\n");

                while (!feof($fp)) {
                    $info[] = @fgets($fp, 1024);
                }
                fclose($fp);
                $info = implode(',', $info);
//                $this->Inventory_model->test_paypal(array('name' => $info));
                $pos = strpos($info, 'VERIFIED');
                if ($pos === false) {
                    // error log here
                } else {

                    $current_user = $this->session->userdata('gen_user');
                    $str_custom = explode('-', $_POST['custom']);

                    $user_id = $str_custom[0];
                    $days_text = explode("=", $str_custom[1]);
                    $allowed_ads = $days_text[0];

                    $in_data = array(
                        'item_name' => $_POST['item_name'],
                        'payment_status' => $_POST['payment_status'],
                        'payer_status' => $_POST['payer_status'],
                        'user_id' => $user_id,
                        'payment_type' => $_POST['payment_type'],
                        'txn_type' => $_POST['txn_type'],
                        'payer_business_name' => $_POST['payer_business_name'],
                        'payer_email' => $_POST['payer_email'],
                        'payment_fee' => $_POST['payment_fee'],
                        'payment_gross' => $_POST['payment_gross'],
                        'shipping' => $_POST['shipping'],
                        'quantity' => $_POST['quantity'],
                        'verify_sign' => $_POST['verify_sign'],
                        'response' => print_r($_POST, 1),
                        'payment_date' => $_POST['payment_date']
                    );
                    $this->dbcommon->insert('paypal_payment', $in_data);
//                    

                    if ($_POST['payment_status'] == 'Completed') {

                        $where = " where user_id='" . $user_id . "' and is_delete=0";
                        $user = $this->dbcommon->getrowdetails('user', $where);
                        if (!empty($user)) {
                            $total_ads = (int) $user->userTotalAds + $allowed_ads;
                            $left_ads = (int) $user->userAdsLeft + $allowed_ads;
                            $data = array('userTotalAds' => $total_ads, 'userAdsLeft' => $left_ads);
                            $array = array('user_id' => $user->user_id);

                            $result = $this->dbcommon->update('user', $array, $data);
                        }
                    }
                }
            }
        }
    }

    public function paypal_response_boost() {

        $in_data = array('response' => print_r($_POST));
        $this->dbcommon->insert('paypal_demo', $in_data);

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $postdata = '';
            foreach ($_POST as $key => $val) {
                $body .= $key . "=>" . $val . "\n";
            }

            foreach ($_POST as $i => $v) {
                $postdata .= $i . '=' . urlencode($v) . '&';
            }
            $postdata .= 'cmd=_notify-validate';

            $web = parse_url($this->url);
            if ($web['scheme'] == 'https') {
                $web['port'] = 443;
                $ssl = 'ssl://';
            } else {
                $web['port'] = 80;
                $ssl = '';
            }
            $fp = @fsockopen($ssl . $web['host'], $web['port'], $errnum, $errstr, 30);
            if (!$fp) {
                echo $errnum . ': ' . $errstr;
            } else {
//                /print_r($_POST)                
                fputs($fp, "POST " . $web['path'] . " HTTP/1.1\r\n");
                fputs($fp, "Host: " . $web['host'] . "\r\n");
                fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
                fputs($fp, "Content-length: " . strlen($postdata) . "\r\n");
                fputs($fp, "Connection: close\r\n\r\n");
                fputs($fp, $postdata . "\r\n\r\n");

                while (!feof($fp)) {
                    $info[] = @fgets($fp, 1024);
                }
                fclose($fp);
                $info = implode(',', $info);
//                $this->Inventory_model->test_paypal(array('name' => $info));
                $pos = strpos($info, 'VERIFIED');
                if ($pos === false) {
                    // error log here
                } else {

                    $current_user = $this->session->userdata('gen_user');
                    $str_custom = explode('-', $_POST['custom']);

                    $product_id = $str_custom[2];
                    $user_id = $str_custom[0];
                    $hour_text = explode("=", $str_custom[1]);
                    $add_hours = $hour_text[0];

                    $in_data = array(
                        'item_name' => $_POST['item_name'],
                        'payment_status' => $_POST['payment_status'],
                        'payer_status' => $_POST['payer_status'],
                        'product_id' => $product_id,
                        'user_id' => $user_id,
                        'payment_type' => $_POST['payment_type'],
                        'txn_type' => $_POST['txn_type'],
                        'payer_business_name' => $_POST['payer_business_name'],
                        'payer_email' => $_POST['payer_email'],
                        'payment_fee' => $_POST['payment_fee'],
                        'payment_gross' => $_POST['payment_gross'],
                        'shipping' => $_POST['shipping'],
                        'quantity' => $_POST['quantity'],
                        'verify_sign' => $_POST['verify_sign'],
                        'response' => print_r($_POST, 1),
                        'payment_date' => $_POST['payment_date']
                    );
                    $this->dbcommon->insert('paypal_payment', $in_data);
//                    


                    if ($_POST['payment_status'] == 'Completed') {

                        $product_details = $this->dbcommon->getdetails_("* from product where product_id = " . (int) $product_id . " and product_posted_by=" . (int) $user_id . " and is_delete in (0) and product_is_inappropriate='Approve' and product_for='classified'");

                        if (!empty($product_details)) {

                            $dateFeatured = date('Y-m-d H:i:s');
                            $dateExpire = date("Y-m-d H:i:s", strtotime('+' . $add_hours . ' hours'));

                            $del_arr = array('product_id' => $product_id);
                            $this->dbcommon->delete('featureads', $del_arr);

                            $arra = array('product_id' => $product_id,
                                'cat_id' => $product_details[0]->category_id,
                                'subcat_id' => $product_details[0]->sub_category_id,
                                'product_id' => $product_details[0]->product_id,
                                'User_Id' => $product_details[0]->product_posted_by,
                                'dateFeatured' => $dateFeatured,
                                'dateExpire' => $dateExpire
                            );
                            $result = $this->dbcommon->insert('featureads', $arra);
                        }
                    }
                }
            }
        }
    }

    function get_data($request_from = NULL) {

        $return_status = 0;
        $hours_days = '';
        $label = '';

        if ($request_from == 'boost') {
            $return_status = 1;
            $where = " where hour_value='" . $_POST['purchase_hour'] . "'";
            $price = $this->dbcommon->getrowdetails('featuredad_price', $where);

            if (!empty($price)) {
                
            } else {
                $where = " where hour_value=24";
                $price = $this->dbcommon->getrowdetails('featuredad_price', $where);
            }

            $hours_days = $price->hour_value;
            $amount = $price->amount;
            $label = 'Boost Your Ad for ' . $hours_days . ' Hours';
        } elseif ($request_from == 'buy_ad') {

            $return_status = 1;
            $where = " where ads='" . $_POST['buy_ads'] . "'";
            $price = $this->dbcommon->getrowdetails('buy_ad_price', $where);

            if (!empty($price)) {
                
            } else {
                $where = " where ads=5";
                $price = $this->dbcommon->getrowdetails('buy_ad_price', $where);
            }

            $hours_days = $price->ads;
            $amount = $price->amount;
            $label = 'Buy ' . $hours_days . ' Ads for Current Month';
        }

        $amount_text = $this->get_currency($amount);
        $str = $amount_text . '&' . $label . '&' . $hours_days;

        return $str;
    }

    /*
     * Convert AED to US Dollar     
     */

//    function get_currency($amount = NULL) {
//
//        $from_currency = 'AED';
//        $to_currency = 'USD';
//
//        $results = $this->dbcommon->converCurrency($from_currency, $to_currency, $amount);
//        $regularExpression = '#\<span class=bld\>(.+?)\<\/span\>#s';
//        preg_match($regularExpression, $results, $finalData);
//
//        $amt = trim(str_replace('<span class=bld>', '', $finalData[0]));
//        $amt = trim(str_replace('</span>', '', $amt));
//        $amount_text = str_replace(' ' . $to_currency, '', $amt);
//        $amount_text = number_format($amount_text, 2);
//
//        return $amount_text;
//    }

    function get_currency($amount = NULL) {

        $from_currency = 'AED';
        $to_currency = 'USD';
        $result = $this->db->query('SELECT val FROM settings where id=16')->row_array();
        if (isset($result) && isset($result['val'])) {
            $amount = $amount * $result['val'];
//            $amount_text = number_format($amount, 2);
            return $amount;
        }
    }

}

?>