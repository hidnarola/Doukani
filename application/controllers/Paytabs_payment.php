<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paytabs_payment extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dbcart');
        $this->load->library('Paytab');
    }

    /*
     * Check Secret Key of Merchant and get Create Page URL 
     */

    public function get_url() {
//        die();
        $secret_key = $this->paytab->check_secret_key();

        if (isset($secret_key) && is_object($secret_key)) {
            if ($secret_key->result == 'valid' && $secret_key->response_code == PAY_TABS_VALID_SECRET_KEY) {
                $product_arry = explode(",", $this->session->userdata('doukani_products'));
                $current_user = $this->session->userdata('gen_user');
                $address_id = $this->input->post('address_id', TRUE);
                $request_data = array();
                $product_list = array();

                $get_cart_details = $this->db->query("select * from user_shopping_cart where user_id='" . $current_user['user_id'] . "'  limit 1")->row_array();
                if (isset($get_cart_details) && sizeof($get_cart_details) > 0) {
                    $request_data['reference_no'] = base64_encode($get_cart_details['id']);
                    $request_data['return_url'] = PAY_TABS_RETURN_URL . 'payment_status/' . $request_data['reference_no'];
                }
//                $this->get_limited_data();

                $request_data['title'] = $this->get_limited_data('Order-' . $current_user['email_id'], 32);

                $shipping_data = array('id' => $address_id);
                $shipping_address_details = $this->dbcommon->getdetailsinfo('shipping_address', $shipping_data);

                if (isset($shipping_address_details) && sizeof($shipping_address_details) > 0) {

                    $customer_name = explode(' ', $shipping_address_details->customer_name);

                    //ShippingData
                    $request_data['shipping_first_name'] = $request_data['cc_first_name'] = $this->get_limited_data($customer_name[0], 32);
                    $request_data['shipping_last_name'] = $request_data['cc_last_name'] = $this->get_limited_data(((isset($customer_name[1]) && !empty($customer_name['1'])) ? $customer_name[1] : $customer_name[0]), 32);
                    $request_data['cc_phone_number'] = $this->get_limited_data($shipping_address_details->contact_number, 32);
                    $request_data['email'] = $this->get_limited_data($shipping_address_details->email_id, 32);

                    $state_data = array('state_id' => $shipping_address_details->state_id);
                    $state_details = $this->dbcommon->getdetailsinfo('state', $state_data);

                    //BilingData & Shipping Data
                    $request_data['address_shipping'] = $request_data['billing_address'] = $this->get_limited_data($shipping_address_details->address_1 . ',' . $shipping_address_details->address_2, 40);
                    $request_data['state_shipping'] = $request_data['state'] = $this->get_limited_data(@$state_details->state_name, 32);
                    $request_data['city_shipping'] = $request_data['city'] = $this->get_limited_data(@$state_details->state_name, 13);
                    $request_data['postal_code_shipping'] = $request_data['postal_code'] = $this->get_limited_data($shipping_address_details->po_box, 9);
                    $request_data['country_shipping'] = $request_data['country'] = 'ARE';

                    $cart_shipping_address = array(
                        'id' => $shipping_address_details->id,
                        'customer_name' => $shipping_address_details->customer_name,
                        'address_1' => $shipping_address_details->address_1,
                        'address_2' => $shipping_address_details->address_2,
                        'state_id' => $shipping_address_details->state_id,
                        'po_box' => $shipping_address_details->po_box,
                        'contact_number' => $shipping_address_details->contact_number,
                        'email_id' => $shipping_address_details->email_id
                    );
                    $this->session->set_userdata('cart_shipping_address', $cart_shipping_address);
                }

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

                    $product_price = 0;
                    $product_price_ = 0;
                    $seller_shipping_cost = 0;
                    $seller_shipping_cost_ = 0;
                    $qunatity_ = 0;
                    if (sizeof($product_result) > 0) {

                        $in_trans = array('user_id' => $current_user['user_id'], 'status' => 0, 'created_date' => date('Y-m-d H:i:s'));

                        foreach ($product_result as $key => $value) {
                            foreach ($value as $val) {
                                $product_list[] = array(
                                    'name' => $val['product_name'],
                                    'price' => $val['product_price'],
                                    'quantity' => $val['requested_qunatitiy'],
                                );
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

                $request_data['products'] = $product_list;
                $request_data['shipping_cost'] = $seller_shipping_cost_;
//                echo '<pre>';
//                print_r($request_data);
//                die();
                $page_create_response = $this->paytab->create_payment_page($request_data);
//                print_r($page_create_response);

                if (isset($page_create_response) && is_object($page_create_response)) {
                    if ($page_create_response->response_code == PAY_TABS_PAGE_CREATED_SUCCESS) {
                        $this->db->query("UPDATE user_shopping_cart SET paytab_p_id = '" . $page_create_response->p_id . "' WHERE user_id='" . $current_user['user_id'] . "'");
                        echo $page_create_response->payment_url;
                        exit;
                    }
                }
            } else {
                
            }
        }
        exit;
    }

    public function get_limited_data($text, $limit) {

        return substr($text, 0, $limit);
    }

    public function payment_status($reference_number = NULL) {

//        echo 'hello - Add calling';        
//        die();
        $check_cart = $this->db->query('SELECT * FROM user_shopping_cart WHERE id = ' . base64_decode($reference_number))->row_array();
        if (isset($check_cart) && sizeof($check_cart) > 0) {
            $result = $this->paytab->verify_payment($check_cart['paytab_p_id']);
//            print_r($result);
//            die();
            if (isset($result) && is_object($result)) {
                //success
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

//                pr($product_session);
//                die();
                $user_id = $current_user['user_id'];
                $product_ids = $request_product_str;
                $cart_shipping_address = $this->session->userdata('cart_shipping_address');
                $address_id = $cart_shipping_address['id'];

                $user_email = $this->dbcommon->getFieldById($user_id);
//                $user_email = 'kek@narola.email';

                $in_data = array(
                    'result' => $result->result,
                    'response_code' => $result->response_code,
                    'pt_invoice_id' => $result->pt_invoice_id,
                    'amount' => $result->amount,
                    'currency' => $result->currency,
                    'reference_no' => $result->reference_no,
                    'transaction_id' => $result->transaction_id,
                    'created_date' => date('Y-m-d H:i:s'),
                    'user_id' => $user_id
                );
                $this->dbcommon->insert('paytabs_payment', $in_data);
                $paytabs_payment_id = $this->db->insert_id();

                if ($result->response_code == PAY_TABS_PAGE_PAYMENT_SUCCESS) {

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
                        $insert_store_wise_product = array();
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
                                    $product_list_store_wise = array(
                                        'quantity' => $qunatity,
                                        'price' => $product_price,
                                        'product_name' => $val['product_name']
                                    );
                                    $insert_store_wise_product[$val['product_posted_by']][] = $product_list_store_wise;
                                }

                                $costing = $this->dbcommon->seller_shipping_cost($key);
                                if (isset($costing->shipping_cost) && !empty($costing->shipping_cost))
                                    $seller_shipping_cost = $costing->shipping_cost;
                                else
                                    $seller_shipping_cost = 0;

                                $in_data = array(
                                    'transaction_id' => $transaction_id,
                                    'order_number' => $order_number[$key],
                                    'address_id' => $cart_shipping_address['id'],
                                    'customer_name' => $cart_shipping_address['customer_name'],
                                    'address_1' => $cart_shipping_address['address_1'],
                                    'address_2' => $cart_shipping_address['address_2'],
                                    'state_id' => $cart_shipping_address['state_id'],
                                    'po_box' => $cart_shipping_address['po_box'],
                                    'contact_number' => $cart_shipping_address['contact_number'],
                                    'email_id' => $cart_shipping_address['email_id'],
                                    'user_id' => $user_id,
                                    'sub_total' => $sub_total,
                                    'shipping_cost' => $seller_shipping_cost,
                                    'final_total' => $final_total + $seller_shipping_cost,
                                    'final_qunatity' => $final_qunatity,
                                    'status' => 'new',
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

                                $wh_data = array('id' => $paytabs_payment_id);
                                $up_data = array('order_id' => $order_id);
                                $this->dbcommon->update('paytabs_payment', $wh_data, $up_data);

                                $commssion_percentage = $this->dbcart->get_commossion_rate($key);
                                $doukani_commission = ($final_total * $commssion_percentage) / 100;
                                $in_data = array(
                                    'percentage' => $commssion_percentage,
                                    'amount' => $final_total,
                                    'store_amount' => $final_total - $doukani_commission,
                                    'doukani_amout' => $doukani_commission,
                                    'order_id' => $order_id,
                                    'store_owner' => $key,
                                    'created_date' => date('Y-m-d H:i:s'),
                                    'status' => 1
                                );
                                $this->dbcommon->insert('balance', $in_data);

                                $sold_date = date('F d,Y', time());
                                $right_header = $this->dbcart->right_header($order_number[$key], $sold_date, $delivery_type);
                                $shipping_address = $this->dbcart->shipping_address($cart_shipping_address['id']);

                                $product_table = $this->dbcart->mail_product_list($insert_store_wise_product[$key], $sub_total, $seller_shipping_cost, $final_total + $seller_shipping_cost);

                                //send mail to Buyer
                                $this->dbcart->buyer_mail($product_table, $right_header, $shipping_address, $user_email);

                                //Send Mail to Seller                         
                                $seller_data = $this->dbcommon->seller_data($key);
                                $email_id = $seller_data->email_id;
//                                $email_id = 'kek@narola.email';
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

                                $this->session->unset_userdata('doukani_products');
                                $this->session->unset_userdata('cart_products');
                                $this->session->unset_userdata('doukani_products_quantity');

                                $this->session->set_userdata('order_number', rtrim($str_order_number, ','));
                                $in_data = array(
                                    'orderlist' => rtrim($str_order_number, ','),
                                    'user_id' => $user_id
                                );
                                $this->dbcommon->insert('order_success_msg', $in_data);
                                redirect('cart/success');
                            }
                        }
                    }
                } else {
                    $this->session->set_flashdata(array('msg' => 'Payment failed. Please try again later.', 'class' => 'alert-success'));
                    redirect('cart');
                }
            } else {
                $this->session->set_flashdata(array('msg' => 'Payment failed. Please try again later.', 'class' => 'alert-success'));
                redirect('cart');
            }
        } else {
            redirect('cart');
        }
    }

    function rate($store_id) {
        $this->dbcart->get_commossion_rate($store_id);
    }

}
