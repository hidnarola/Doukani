<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends My_controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('dbcommon');
        $this->load->model('dbcart');

        $this->load->library('My_PHPMailer');
        $this->load->library('parser');

        $this->load->helper('email');
        $this->load->helper('page_not_found');

        $emirate = $this->uri->segment(1);
        if (empty($emirate))
            $this->session->unset_userdata('request_for_statewise');

        if (!empty($emirate) && in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $this->session->set_userdata('request_for_statewise', $emirate);
            $emirate = $this->session->userdata('request_for_statewise');
        } elseif (isset($_REQUEST['state_id_selection']))
            $emirate = $_REQUEST['state_id_selection'];
        elseif ($this->session->userdata('request_for_statewise') != '') {
            $emirate = $this->session->userdata('request_for_statewise');
        }

        if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
            define("emirate_slug", $emirate . '/');
        else
            define("emirate_slug", '');
    }

    public function index($slug = NULL, $load_data = NULL) {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $session_qunatity = $this->session->userdata('doukani_products');
//        echo $session_qunatity;
        $current_user = $this->session->userdata('gen_user');

        if (isset($session_qunatity) && !empty($session_qunatity)) {
            $data['current_user'] = $current_user;
            $login_status = $current_user['user_id'];
            $data['page_title'] = 'Cart';
            $data['product_list'] = $this->dbcart->product_list_cart();
            $admin_ship_condition = 'store_id = 0 AND is_active = 1';
            $data['shipping_admin_cost'] = $this->dbcommon->select('shipping_costs_admin', $admin_ship_condition)[0];

            $shipping_details = $this->dbcart->getShippingCost();

            if (isset($shipping_details) && isset($shipping_details['shipping_total']))
                $data['shipping_cost'] = $shipping_details['shipping_total'];
            else
                $data['shipping_cost'] = 0;

//            if($_SERVER['REMOTE_ADDR'] == '203.109.68.198'){
//                pr($data['shipping_admin_cost']);
//                pr($data['product_list']); exit;
//            }
            $this->load->view('cart/product_cart1', $data);
        } else {
            $data['status'] = 'success';
            $data['message'] = 'your cart is empty <i class="fa fa-frown-o" aria-hidden="true"></i>';
            $this->load->view('cart/cart_message', $data);
        }
    }

    public function shipping_part() {

        $data = array();

        $session_products = $this->session->userdata('doukani_products');

        $current_user = $this->session->userdata('gen_user');
        $step1 = $this->input->post('step1');

        if (isset($current_user['user_id']) && isset($session_products) && !empty($session_products) && !empty($step1) && $step1 == 'complete') {

            $product_arry = explode(",", $session_products);
            $product_ids = array();
            $product_str = '';
            $product_session = array();

            foreach ($product_arry as $id) {
                $arr = explode('-', $id);
                if (isset($arr) && !empty($arr) && isset($arr[0]) && isset($arr[1])) {
                    $product_str .= $arr[0] . ',';
                }
            }

            $products = rtrim($product_str, ',');
            $sellers = $this->dbcommon->get_distinct(" select distinct product_posted_by from product where product_id in (" . $products . ") and  is_delete =0 and  product_is_inappropriate='Approve' and product_deactivate IS NULL and stock_availability > 0 and product_for='store' group by product_posted_by");
            $sel_list = '';

            foreach ($sellers as $sel) {
                $sel_list .= $sel['product_posted_by'] . ',';
            }

            $user_id = $current_user['user_id'];
            $where = "country_id=4";
            $state = $this->dbcommon->filter('state', $where);
            $data['state'] = $state;
            $data['page_title'] = 'Shipping Address';

            $where = 'user_id=' . $user_id;
            $shipping_addresses = $this->dbcommon->filter('shipping_address', $where);
            $data['shipping_addresses'] = $shipping_addresses;
            $last_address = end($shipping_addresses);
            $data['last_address_id'] = $last_address['id'];
            $data['shipping_part'] = 'yes';

            $query = ' page_id in (29,10,11) and page_state=1 order by FIELD(page_id,29,10,11 )';
            $data['other_page_links'] = $this->dbcommon->filter('pages_cms', $query);

            $shipping_details = $this->dbcart->getShippingCost();

            if (isset($shipping_details) && isset($shipping_details['shipping_total']))
                $data['shipping_cost'] = $shipping_details['shipping_total'];
            else
                $data['shipping_cost'] = 0;

            $this->load->view('cart/shipping_address1', $data);
        } else {
            redirect('stores');
        }
    }

    function edit_shipping_address() {

        $shipping_address_id = $this->input->post('address_id');

        $array = array('id' => $shipping_address_id);
        $shipping_details = $this->dbcommon->get_row('shipping_address', $array);

        echo json_encode($shipping_details);
        exit;
    }

    /*
      insert or update shipping address
     */

    function add_edit_shipping_address() {

        $addr = array();

        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];

        $customer_name = $this->input->post('customer_name', TRUE);
        $address_1 = $this->input->post('address_1', TRUE);
        $address_2 = $this->input->post('address_2', TRUE);
        $state_id = $this->input->post('state_id', TRUE);
        $po_box = $this->input->post('po_box', TRUE);
        $contact_number = $this->input->post('contact_number', TRUE);
        $email_id = $this->input->post('email_id', TRUE);

        if (isset($user_id) && isset($customer_name)) {
            if ($this->input->post('address_id') != '')
                $shipping_address_id = $this->input->post('address_id');

            $in_data = array(
                'user_id' => $user_id,
                'customer_name' => $customer_name,
                'address_1' => $address_1,
                'address_2' => $address_2,
                'state_id' => $state_id,
                'po_box' => $po_box,
                'contact_number' => $contact_number,
                'email_id' => $email_id
            );

            if ($this->input->post('address_id') == '') {
                $result = $this->dbcommon->insert('shipping_address', $in_data);
                $shipping_address_id = $this->db->insert_id();
            } else {
                $shipping_address_id = $this->input->post('address_id');
                $wh = array('user_id' => $user_id,
                    'id' => $shipping_address_id
                );
                $result = $this->dbcommon->update('shipping_address', $wh, $in_data);
            }

            echo $shipping_address_id;
            exit();
        }
    }

    function delete_address() {

        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];

        $shipping_address_id = $this->input->post('address_id');
        if (isset($shipping_address_id)) {
            $del_array = array('id' => $shipping_address_id,
                'user_id' => $user_id
            );
            $result = $this->dbcommon->delete('shipping_address', $del_array);

            if (isset($result))
                echo 'success';
            else
                echo 'fail';
        }
    }

    function shipping_addr_list() {

        $ship_data = array();

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user)) {
            $user_id = $current_user['user_id'];

            $where = 'user_id=' . $user_id;
            $shipping_addresses = $this->dbcommon->filter('shipping_address', $where);

            $ship_data['shipping_addresses'] = $shipping_addresses;
            $ship_data["html"] = $this->load->view('cart/address_list', $ship_data, TRUE);
            echo json_encode($ship_data);
            exit();
        }
    }

    /*
      any 1 product user can buy with no. of qunatities
     */

    function buy_now() {

        $current_user = $this->session->userdata('gen_user');

//add- edit product ids and qunatity in session and user_shipping_cart table
        $this->dbcart->add_product_incart('single');

        if (isset($current_user['user_id']) && !empty($current_user['user_id'])) {

            $del_arr = array('user_id' => $current_user['user_id']);
            $this->dbcommon->delete('user_shopping_cart', $del_arr);
            $this->dbcart->add_user_cart($current_user['user_id']);
        }
        redirect('cart');
    }

    /*
      add to cart for Multitple Products
     */

    function add_to_cart() {

        $current_user = $this->session->userdata('gen_user');

//add- edit product ids and qunatity in session and user_shipping_cart table
        $this->dbcart->add_product_incart('multiple');

        if (isset($current_user['user_id']) && !empty($current_user['user_id'])) {

            $del_arr = array('user_id' => $current_user['user_id']);
            $this->dbcommon->delete('user_shopping_cart', $del_arr);
            $this->dbcart->add_user_cart($current_user['user_id']);
        }

        $session_qunatity = $this->session->userdata('doukani_products');
        if (isset($session_qunatity) && !empty($session_qunatity)) {
            $i = 0;
            $arry_ids = explode(",", $session_qunatity);
            $concat_str = '';
            foreach ($arry_ids as $id) {
                $arr = explode('-', $id);
                if (isset($arr[0]) && !empty($arr[0]) && isset($arr[1]) && !empty($arr[1]))
                    $i++;
            }
            echo $i;
        } else
            echo 0;

        exit;
    }

    function delete_product() {

        $product_id = $this->input->post('product_id');
        $session_qunatity = $this->session->userdata('doukani_products');

        if (isset($product_id)) {
            if (isset($session_qunatity) && !empty($session_qunatity)) {
                $arry_ids = explode(",", $session_qunatity);
                $concat_str = '';
                foreach ($arry_ids as $id) {

                    $arr = explode('-', $id);

                    if ($product_id != $arr[0] && isset($arr[1]))
                        $concat_str .= $arr[0] . '-' . $arr[1] . ',';
                }
                $this->session->set_userdata('doukani_products', $concat_str);
                $session_qunatity = $this->session->userdata('doukani_products');
            }

            $current_user = $this->session->userdata('gen_user');

            if (isset($current_user['user_id']) && !empty($current_user['user_id'])) {

                $del_arr = array('user_id' => $current_user['user_id']);
                $this->dbcommon->delete('user_shopping_cart', $del_arr);
                $this->dbcart->add_user_cart($current_user['user_id']);
            }

            $arry_ids = explode(",", $concat_str);
            $new_qty = 0;

            foreach ($arry_ids as $id) {

                $arr = explode('-', $id);
                if (isset($arr[1]))
                    $new_qty += $arr[1];
            }

            $this->session->set_userdata('doukani_products_quantity', $new_qty);

            if (isset($session_qunatity) && !empty($session_qunatity))
                echo 'success';
            else
                echo 'nodata';
            exit;
        }
    }

    function place_order() {

        $shipping_details = $this->dbcart->getShippingCost();
//        pr($shipping_details);
//        die();
        $current_user = $this->session->userdata('gen_user');
        $success = $this->input->post('success');
        $address_id = $this->input->post('address_id');

        if (isset($current_user) && !empty($current_user) && isset($success) && !empty($success) && isset($address_id) && !empty($address_id)) {

            $order_number = array();
            $order_ids = array();

            $user_id = $current_user['user_id'];
            $sub_total = 0;
            $final_shipping_cost = 0;
            $final_total = 0;
            $final_qunatity = 0;
            $status = 'new';
            $is_delete = 0;
            $delivery_type = 'COD';

            $product_arry = explode(",", $this->session->userdata('doukani_products'));
//            pr($product_arry); exit;
            $product_ids = array();
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

            $products_arr = $this->dbcommon->get_distinct("
                    select p.product_name,p.product_id,p.product_price,p.stock_availability,p.product_posted_by, p.delivery_option, s.store_id 
                    from product p
                    LEFT JOIN store s ON s.store_owner = p.product_posted_by
                    where 
                    p.product_id in (" . $products . ") and  p.is_delete =0 and  p.product_is_inappropriate='Approve' and p.product_deactivate IS NULL and p.stock_availability > 0 and p.product_for='store' group by p.product_id order by p.product_posted_by");
//            if($_SERVER['203.109.68.198']){
//                pr($product_arry); exit;
//            }
//            pr($products_arr); exit;            
            if ($product_count == sizeof($products_arr)) {

                $product_result = array();
                foreach ($products_arr as $product) {
                    foreach ($product_session as $key => $val) {
                        if ($key == $product['product_id']) {
                            $product['requested_qunatitiy'] = $val;
                        }
                    }
                    $product_result[$product['store_id']][$product['delivery_option']][] = $product;
                }

                $insert_product = array();
                $insert_store_wise_product = array();
                $insert_product_cart = array();
                $i = 1;
                $str_order_number = '';
//                pr($product_result);
//                exit;
                if (sizeof($product_result) > 0) {

                    $in_trans = array('user_id' => $current_user['user_id'], 'status' => 0, 'created_date' => date('Y-m-d H:i:s'));
                    $this->dbcommon->insert('transaction', $in_trans);
//                    $transaction_id = $this->db->insert_id();
                    $transaction_id = 1;

                    foreach ($product_result as $key => $value) {

                        $ord_no = '';
                        $ord_no = $this->dbcart->generate_order_number($key);
                        $order_number[$key] = substr($ord_no + $key, 0, 9);

                        $sub_total = 0;
                        $final_total = 0;
                        $final_qunatity = 0;
                        $shipping_cost = 0;
                        $qunatity = 0;

                        foreach ($value as $key1 => $val) {
                            $in_order_products = array();
                            foreach ($val as $v) {
                                $qunatity = $v['requested_qunatitiy'];
                                $product_price = $v['product_price'] * $qunatity;

                                $sub_total += $product_price;
                                $final_qunatity += $qunatity;
//                            $final_shipping_cost += $shipping_cost;
//                            $final_total += $sub_total + $final_shipping_cost;
//                            $final_total += $sub_total;
                                $final_total = $final_total + ($v['product_price'] * $qunatity);
                                $in_order_products[] = array(
                                    'product_id' => $v['product_id'],
                                    'quantity' => $qunatity,
                                    'price' => $product_price,
                                    'user_id' => $current_user['user_id'],
                                    'product_owner' => $v['product_posted_by'],
                                    'store_id' => $v['store_id'],
                                    'created_date' => date('Y-m-d H:i:s')
                                );

//                                $insert_product[$v['store_id']][] = $in_order_products;

                                $insert_store_wise_product[$v['store_id']][] = array(
                                    'quantity' => $qunatity,
                                    'price' => $product_price,
                                    'product_name' => $v['product_name']
                                );
                            }
//                            $shipping_details[$key][$key1]['shipping_cost'];
//                            echo $key . '  ' . $key1 . '<br><br>';
//                            print_r($shipping_details['store_shipping_weight'][$key]);
                            $weight = $shipping_details['store_shipping_weight'][$key][$key1]['weight'];
                            $final_shipping_cost = $shipping_details['store_shipping_weight'][$key][$key1]['shipping_cost'];
                            $final_total = $final_total + $final_shipping_cost;
                        }

                        $shipping_data = array('id' => $address_id);
                        $shipping_address_details = $this->dbcommon->getdetailsinfo('shipping_address', $shipping_data);

                        $in_data = array(
                            'transaction_id' => $transaction_id,
                            'order_number' => $order_number[$key],
                            'address_id' => $address_id,
                            'customer_name' => $shipping_address_details->customer_name,
                            'address_1' => $shipping_address_details->address_1,
                            'address_2' => $shipping_address_details->address_2,
                            'state_id' => $shipping_address_details->state_id,
                            'po_box' => $shipping_address_details->po_box,
                            'contact_number' => $shipping_address_details->contact_number,
                            'email_id' => $shipping_address_details->email_id,
                            'user_id' => $current_user['user_id'],
                            'final_qunatity' => $final_qunatity,
                            'status' => 'new',
                            'is_delete' => 0,
                            'delivery_type' => 0,
                            'seller_id' => $key,
                            'created_date' => date('Y-m-d H:i:s'),
                            'delivery_type' => $delivery_type,
                            'delivery_option' => $key1,
                            'sub_total' => $sub_total,
                            'shipping_cost' => $final_shipping_cost,
                            'final_total' => $final_total,
                            'weight' => $weight
                        );

                        $str_order_number .= $order_number[$key] . ',';
//                        echo '<br>Order Data';
//                        pr($in_data);
//                        $this->dbcommon->insert('orders', $in_data);

                        $order_id = 0;
//                        $order_id = $this->db->insert_id();

                        if (isset($in_order_products) && sizeof($in_order_products) > 0) {
                            foreach ($in_order_products as $k => $prod) {
                                $in_order_products[$k]['order_id'] = $order_id;
                            }
                        }
                        if (isset($in_order_products) && sizeof($in_order_products) > 0)
                            $this->dbcommon->insert_batch('product_orders', $in_order_products);

                        echo 'dataa';
                        pr($in_order_products);
                        $order_ids[$key] = $order_id;

                        $commssion_percentage = $this->dbcart->get_commossion_rate($key);
                        $doukani_commission = (($final_total - $final_shipping_cost) * $commssion_percentage) / 100;
                        $in_balance_data = array(
                            'percentage' => $commssion_percentage,
                            'amount' => $final_total - $final_shipping_cost,
                            'store_amount' => ($final_total - $final_shipping_cost) - $doukani_commission,
                            'doukani_amout' => $doukani_commission,
                            'order_id' => $order_id,
                            'store_owner' => $key,
                            'created_date' => date('Y-m-d H:i:s'),
                            'status' => 1
                        );
//                        echo '<br>Balance Data';
//                        pr($in_balance_data);
//                        $this->dbcommon->insert('balance', $in_balance_data);

                        $sold_date = date('F d,Y', time());
                        $right_header = $this->dbcart->right_header($order_number[$key], $sold_date);
                        $shipping_address = $this->dbcart->shipping_address($address_id);
                        $product_table = $this->dbcart->mail_product_list($insert_store_wise_product[$key], $sub_total, $in_data['shipping_cost'], $final_total);
                        $footer_part = $this->dbcart->common_footer();

                        //send mail to Buyer
//                        $this->dbcart->buyer_mail($product_table, $right_header, $shipping_address);
                        //Send Mail to Seller                         
                        $seller_data = $this->dbcommon->seller_data($key);
                        $email_id = $seller_data->email_id;
                        $seller_name = (isset($seller_data->nick_name) && !empty($seller_data->nick_name)) ? $seller_data->nick_name : $seller_data->username;

//                        $this->dbcart->seller_mail($seller_name, $sold_date, $right_header, $email_id, $product_table, $shipping_address);

                        $i++;
                    }
                    $j = 0;
                    $final_batch = array();

//                    pr($insert_product, 1);
                    foreach ($insert_product as $in) {
                        foreach ($in as $product) {
                            if ($order_number[$j] = $product['product_owner']) {
                                $product['order_id'] = $order_ids[$product['product_owner']];
                                $final_batch[] = $product;
                            }
                        }
                        $j++;
                    }
                    die("end.......");

                    if (sizeof($final_batch) > 0) {

                        $result = $this->dbcommon->insert_batch('product_orders', $final_batch);

                        foreach ($product_arry as $res) {

                            $arr = explode('-', $res);
                            if (isset($arr) && !empty($arr) && isset($arr[0]) && isset($arr[1])) {
                                $product_str .= $arr[0] . ',';

//                                $this->db->query('update product set stock_availability= stock_availability - ' . $arr[1] . ' where product_id=' . $arr[0]);
//                                $this->db->query('UPDATE product p 
//                                    LEFT JOIN product_orders po ON po.product_id = p.product_id
//                                    SET p.stock_availability = p.stock_availability - ' . $arr[1] . ' , 
//                                    po.delivery_option = p.delivery_option , po.weight = p.weight
//                                    WHERE p.product_id = ' . $arr[0] . ' AND po.order_id = ' . $order_id);
                            }
                        }

                        $del_arr = array('user_id' => $current_user['user_id']);
                        $this->dbcommon->delete('user_shopping_cart', $del_arr);

                        $this->session->unset_userdata('doukani_products');
                        $this->session->unset_userdata('cart_products');
                        $this->session->unset_userdata('doukani_products_quantity');

                        $in_data = array('orderlist' => rtrim($str_order_number, ','),
                            'user_id' => $current_user['user_id']);
                        $this->dbcommon->insert('order_success_msg', $in_data);

                        $this->session->set_userdata('order_number', rtrim($str_order_number, ','));

                        echo 'success';
                    } else
                        echo 'fail';
                } else
                    echo 'fail';
            } else
                echo 'fail';
        } else {
            redirect('login/index');
        }
    }

    function success() {

        $data = array();
        $data = array_merge($data, $this->get_elements());
        $current_user = $this->session->userdata('gen_user');
        if ($current_user) {

            $ret_repsonse = $this->dbcommon->select('order_success_msg where user_id=' . $current_user['user_id']);
            if (!empty($ret_repsonse)) {
                $order_numbers = $ret_repsonse[0]['orderlist'];
                if (isset($order_numbers) && !empty($order_numbers)) {
                    $arr_ords = explode(',', $order_numbers);

                    $order_list = $this->dbcart->success_order_list($arr_ords);
                    $data['order_list'] = $order_list;

                    $del_arr = array('user_id' => $current_user['user_id']);
                    $this->dbcommon->delete('order_success_msg', $del_arr);

                    $data['status'] = 'success';
                    $data['message'] = 'Thank you for Shopping <i class="fa fa-smile-o" aria-hidden="true"></i>';
                    $this->load->view('cart/cart_message', $data);
                } else {
                    redirect('stores');
                }
            } else {
                redirect('stores');
            }
        }
    }

    function getTotalShippingCost() {

        $shipping_details = $this->dbcart->getShippingCost();

        if (isset($shipping_details) && isset($shipping_details['shipping_total']))
            $shipping_cost = $shipping_details['shipping_total'];
        else
            $shipping_cost = 0;

        echo $shipping_cost;
        exit;
    }

}
