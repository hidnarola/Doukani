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
            
//            if($_SERVER['REMOTE_ADDR'] == '203.109.68.198'){
                $shipping_cost = array();
                $shipping_weight = array();
                
                
                foreach ($data['product_list'] as $list_key => $list_data):
                    $c_store_id = 0;
                    $c_shipping_method_id = 0;
                    $c_weight = 0;
                
                    if($list_data['store'] != $c_store_id){
                        $c_store_id = $list_data['store'];
                    }
                    if($list_data['timeline_id'] != $c_shipping_method_id){
                        $c_shipping_method_id = $list_data['timeline_id'];
                    }
                    if(isset($shipping_weight[$c_store_id][$c_shipping_method_id]) && !empty($shipping_weight[$c_store_id][$c_shipping_method_id])){
                        $c_weight = $shipping_weight[$c_store_id][$c_shipping_method_id];
                    }
                    $c_weight = $c_weight + $list_data['weight'];
//                    echo $c_weight . '<br>';
                    $shipping_weight[$c_store_id][$c_shipping_method_id] = ceil($c_weight);
                endforeach;
                $total_charge = 0;
                foreach ($shipping_weight as $w_key => $w_data):
                    $weight = 0;
                    $store_ship_condition = 'store_id = ' . $w_key . ' AND is_active = 1';
                    $shipping_charges = $this->dbcommon->select('shipping_costs_admin', $store_ship_condition);
                    if(empty($shipping_charges)){
                        $shipping_charges = $data['shipping_admin_cost'];
                    }
                    $c_charge = 0;
                    foreach ($w_data as $k_key => $k_data):
                        $c_charge = $shipping_charges['cost'];
                        if($k_data > $shipping_charges['max_weight']){
                            $weight = $k_data - $shipping_charges['max_weight'];
                            $n_charge = $weight * $shipping_charges['cost_per_extra_kg'];
                            $c_charge = $c_charge + $n_charge;
                        }
                        $total_charge = $total_charge + $c_charge;
                    endforeach;
                endforeach;
                $data['shipping_total'] = $total_charge;
//            }
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

            $shipping_cost_list = $this->dbcommon->get_distinct(" select shipping_cost from store where store_owner in (" . rtrim($sel_list, ',') . ") and  store_status=0 and store_is_inappropriate='Approve' group by store_owner");
            
//            if($_SERVER['REMOTE_ADDR'] == '203.109.68.198'){
                $admin_ship_condition = 'store_id = 0 AND is_active = 1';
                $data['shipping_admin_cost'] = $this->dbcommon->select('shipping_costs_admin', $admin_ship_condition)[0];
                $product_list = $this->dbcart->product_list_cart();
                
                $shipping_cost = array();
                $shipping_weight = array();
                foreach ($product_list as $list_key => $list_data):
                    $c_store_id = 0;
                    $c_shipping_method_id = 0;
                    $c_weight = 0;
                
                    if($list_data['store'] != $c_store_id){
                        $c_store_id = $list_data['store'];
                    }
                    if($list_data['timeline_id'] != $c_shipping_method_id){
                        $c_shipping_method_id = $list_data['timeline_id'];
                    }
                    if(isset($shipping_weight[$c_store_id][$c_shipping_method_id]) && !empty($shipping_weight[$c_store_id][$c_shipping_method_id])){
                        $c_weight = $shipping_weight[$c_store_id][$c_shipping_method_id];
                    }
                    $c_weight = $c_weight + $list_data['weight'];
                    $shipping_weight[$c_store_id][$c_shipping_method_id] = ceil($c_weight);
                endforeach;
                $total_charge = 0;
                foreach ($shipping_weight as $w_key => $w_data):
                    $weight = 0;
                    $store_ship_condition = 'store_id = ' . $w_key . ' AND is_active = 1';
                    $shipping_charges = $this->dbcommon->select('shipping_costs_admin', $store_ship_condition);
                    if(empty($shipping_charges)){
                        $shipping_charges = $data['shipping_admin_cost'];
                    }
                    $c_charge = 0;
                    foreach ($w_data as $k_key => $k_data):
                        $c_charge = $shipping_charges['cost'];
                        if($k_data > $shipping_charges['max_weight']){
                            $weight = $k_data - $shipping_charges['max_weight'];
                            $n_charge = $weight * $shipping_charges['cost_per_extra_kg'];
                            $c_charge = $c_charge + $n_charge;
                        }
                        $total_charge = $total_charge + $c_charge;
                    endforeach;
                endforeach;
                $data['shipping_total'] = $total_charge;
//            }
            

            $seller_total_cost = 0;
            foreach ($shipping_cost_list as $sel) {
                $seller_total_cost += $sel['shipping_cost'];
            }
            if ($seller_total_cost != '')
                $data['seller_total_cost'] = number_format($seller_total_cost, 2);
            else
                $data['seller_total_cost'] = 0;

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

            $products_arr = $this->dbcommon->get_distinct(" select product_name,product_id,product_price,stock_availability,product_posted_by, delivery_option    from product where product_id in (" . $products . ") and  is_delete =0 and  product_is_inappropriate='Approve' and product_deactivate IS NULL and stock_availability > 0 and product_for='store' order by product_posted_by");
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
                    $product_result[$product['product_posted_by']][] = $product;
                }

                $insert_product = array();
                $insert_store_wise_product = array();
                $insert_product_cart = array();
                $i = 1;
                $str_order_number = '';
//                pr($product_result); exit;
                if (sizeof($product_result) > 0) {

                    $in_trans = array('user_id' => $current_user['user_id'], 'status' => 0, 'created_date' => date('Y-m-d H:i:s'));
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
//                            $final_shipping_cost += $shipping_cost;
//                            $final_total += $sub_total + $final_shipping_cost;
//                            $final_total += $sub_total;
                            $final_total = $final_total + ($val['product_price'] * $qunatity);
                            $in_order_products = array(
                                'product_id' => $val['product_id'],
                                'quantity' => $qunatity,
                                'price' => $product_price,
                                'user_id' => $current_user['user_id'],
                                'product_owner' => $val['product_posted_by'],
                                'created_date' => date('Y-m-d H:i:s')
                            );

                            $insert_product[$val['product_posted_by']][] = $in_order_products;

                            $insert_store_wise_product[$val['product_posted_by']][] = array(
                                'quantity' => $qunatity,
                                'price' => $product_price,
                                'product_name' => $val['product_name']
                            );
//                            pr($insert_store_wise_product);
                        }
//                        exit;

                        $costing = $this->dbcommon->seller_shipping_cost($key);
                        if (isset($costing->shipping_cost) && !empty($costing->shipping_cost))
                            $seller_shipping_cost = $costing->shipping_cost;
                        else
                            $seller_shipping_cost = 0;

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
                        $right_header = $this->dbcart->right_header($order_number[$key], $sold_date);
                        $shipping_address = $this->dbcart->shipping_address($address_id);
                        $product_table = $this->dbcart->mail_product_list($insert_store_wise_product[$key], $sub_total, $seller_shipping_cost, $final_total + $seller_shipping_cost);
                        $footer_part = $this->dbcart->common_footer();

                        //send mail to Buyer
                        $this->dbcart->buyer_mail($product_table, $right_header, $shipping_address);

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

//                                $this->db->query('update product set stock_availability= stock_availability - ' . $arr[1] . ' where product_id=' . $arr[0]);
                                $this->db->query('UPDATE product p 
                                    LEFT JOIN product_orders po ON po.product_id = p.product_id
                                    SET p.stock_availability = p.stock_availability - ' . $arr[1] . ' , 
                                    po.delivery_option = p.delivery_option , po.weight = p.weight
                                    WHERE p.product_id = ' . $arr[0] . ' AND po.order_id = ' . $order_id);
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

}
