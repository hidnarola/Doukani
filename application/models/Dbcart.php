<?php

class Dbcart extends CI_Model {

    function Dbcart() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->dbutil();
        $this->load->model('dbcommon', '', TRUE);
    }

    /*
      get products details for shopping cart
     */

    function product_list_cart() {

        $product_arry = explode(",", $this->session->userdata('doukani_products'));

        $product_ids = array();
        $str_product = '';
        foreach ($product_arry as $id) {
            $arr = explode('-', $id);
            if (isset($arr[0]) && !empty($arr[0]) && isset($arr[1]) && !empty($arr[1])) {
                $product_ids[] = $arr[0] . ',';
                $str_product .= $arr[0] . ',';
            }
        }

        $this->db->select('s.*,p.*, s.store_id as store, d.id as timeline_id, d.option_text as delivery_timeline, if(is_delete!=0 or product_deactivate!=1 or product_is_inappropriate<>"Approve","* Not Available",if(stock_availability<=0,"* Out of stock","")) as session_product_status', FALSE);

        $this->db->where_in('p.product_id', $product_ids);

        $this->db->join('store s', 's.store_owner = p.product_posted_by', 'left');
        $this->db->join('delivery_options d', 'd.id = p.delivery_option', 'left');
//        $this->db->join('shipping_costs_admin a', 'a.store_id = s.store_id', 'left') //a.max_weight as max_shipping_weight, a.cost, a.cost_per_extra_kg, ;

        $this->db->order_by('', 'ASC');
        $this->db->order_by('p.product_posted_by', 'asc');
        $this->db->order_by('FIELD(p.product_id,' . rtrim($str_product, ',') . ') asc');

        $query = $this->db->get('product p');

        return $query->result_array();
    }

    /*
      Add / Update cart data into database
     */

    public function add_user_cart($user_id) {

        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user['user_id']) && !empty($current_user['user_id'])) {

            $cart = $this->session->userdata('doukani_products');

            if (!empty($cart)) {

                $check_user = $this->db->query("select * from user_shopping_cart where user_id='" . $user_id . "'  limit 1")->row_array();

                if (isset($check_user['user_id']) && !empty($check_user['user_id'])) {
                    $up_data = array('cart_data' => $cart, 'created_date' => date('Y-m-d H:i:s'));
                    $wh = array('user_id' => $user_id);

                    $this->dbcommon->update('user_shopping_cart', $wh, $up_data);
                } else {
                    $in_data = array('user_id' => $user_id,
                        'cart_data' => $cart
                    );
                    $this->dbcommon->insert('user_shopping_cart', $in_data);
                }
            } else {
                $check_user = $this->db->query("select * from user_shopping_cart where user_id='" . $user_id . "'  limit 1")->row_array();

                if (isset($check_user['user_id']) && !empty($check_user['user_id'])) {
                    $this->session->set_userdata('doukani_products', $check_user['cart_data']);
                }
            }
        }
    }

    /*
      get qunatitiy product wise from cart
     */

    public function get_quantity_incart($product_id) {

        $product_arry = explode(",", $this->session->userdata('doukani_products'));
        $product_ids = array();

        foreach ($product_arry as $id) {
            $arr = explode('-', $id);

            if ($arr[0] == $product_id)
                return $arr[1];
        }
    }

    public function add_product_incart($type, $product_id = NULL) {

        if (isset($product_id) && $product_id != NULL)
            $cart_product_id = $product_id;
        else
            $cart_product_id = $this->input->post('cart_product_id', TRUE);

        $cart_product_quantity = $this->input->post('quantity', TRUE);

        if (!empty($cart_product_id) && !empty($cart_product_quantity)) {

            if ($type == 'single') {
                $product_ids = $cart_product_id . '-' . $cart_product_quantity;
            } else {
                $products = $this->session->userdata('doukani_products');

                if (isset($products)) {
                    if (!empty($cart_product_id) && !empty($cart_product_quantity)) {

                        $new_qunatity = 0;
                        $arry_ids = explode(",", $products);
                        $cnt = 0;
                        foreach ($arry_ids as $id) {

                            $arr = explode('-', $id);
                            if ($cart_product_id == $arr[0])
                                $cnt = 1;
                        }
                        if ($cnt == 0)
                            $product_ids = $cart_product_id . '-' . $cart_product_quantity . ',' . $products;
                        else
                            $product_ids = $products;
                    } else {
                        $product_ids = $products;
                    }

                    $arry_ids = explode(",", $product_ids);
                    $concat_str = '';
                    foreach ($arry_ids as $id) {

                        $arr = explode('-', $id);

                        if ($cart_product_id == $arr[0]) {

                            $qty = $cart_product_quantity;
                            $concat_str .= $arr[0] . '-' . $qty . ',';
                        } else {
                            $concat_str .= $id . ',';
                        }
                    }

                    $product_ids = $concat_str;
                } else
                    $product_ids = $cart_product_id . '-' . $cart_product_quantity;
            }

            $this->session->set_userdata('doukani_products', rtrim($product_ids, ','));

            $arry_ids = explode(",", $product_ids);
            $new_qty = 0;

            foreach ($arry_ids as $id) {

                $arr = explode('-', $id);
                if (isset($arr[1]))
                    $new_qty += $arr[1];
            }

            $this->session->set_userdata('doukani_products_quantity', $new_qty);
        }
    }

    public function generate_order_number($key = NULL) {

        $order_number = strtotime(date('y-m-d H:i:s')) + rand(11111, 99999);
        $random = $order_number + rand(111111111, 999999999) + $key;
        $rand_number = substr($random, 0, 9);

        $this->db->select('order_number');
        $this->db->where('order_number', $order_number);
        $query = $this->db->get('orders');
        $res = $query->result_array();

        if (sizeof($res) > 0) {
            $this->generate_order_number();
        } else
            return $order_number;
    }

    function check_product_and_quantity() {

        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity');

        $check_product = $this->db->query("select * from product where product_id = '" . $product_id . "' limit 1")->row_array();

        if ($check_product['is_delete'] != 0 || $check_product['product_deactivate'] == 1 || $check_product['product_is_inappropriate'] != 'Approve') {
            echo 'Not Available';
        } elseif ($check_product['stock_availability'] <= 0)
            echo 'Out of stock';
        elseif ($quantity > $check_product['stock_availability'])
            echo $check_product['stock_availability'];
        else
            echo 'success';
        exit;
    }

    function orders($start = NULL, $limit = NULL, $transaction_id = NULL, $type = NULL, $request_from = NULL) {

        $current_user = $this->session->userdata('gen_user');

        $this->db->select('o.status order_status,o.id order_id,u.*,o.*,st.*');

        $this->db->select('if(DATE_FORMAT(o.modified_date,"%y-%m-%d") < (CURDATE() - INTERVAL 7 DAY ),"yes","no") as delete_rights', FALSE);

        $this->db->where('o.is_delete', 0);

        if ($this->uri->segment(1) == 'user' && $this->uri->segment(4) != '') {
            if ($this->uri->segment(4) == 'new')
                $this->db->where('modified_date IS NULL');
            else
                $this->db->where('o.status', $this->uri->segment(4));
        }

        if (isset($_POST['search_order']) && !empty($_POST['search_order']))
            $this->db->where('order_number', $_POST['search_order']);

        if (isset($type) && $type == 'bought') {
            $this->db->where('o.user_id', $current_user['user_id']);
            $this->db->join('user u', 'u.user_id=o.user_id', 'left');
        } else {
            //sold
            if ($this->uri->segment(1) == 'user' && $request_from != NULL && $request_from == 'front') {
                $this->db->where('o.seller_id', $current_user['user_id']);
                $this->db->where('u.user_role', $current_user['user_role']);
            }
            $this->db->join('user u', 'u.user_id=o.seller_id', 'left');
        }

        $this->db->join('store st', 'st.store_owner=o.seller_id', 'left');
        $this->db->join('shipping_address s', 's.id=o.address_id', 'left');

        if ($transaction_id != NULL)
            $this->db->where('transaction_id', $transaction_id);

        $this->db->where('o.created_date >= now()-interval 3 month');

        $this->db->group_by('o.id');

        $this->db->order_by('o.id', 'desc');

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get('orders o');

        return $query->result_array();
    }

    function orders_count($type = NULL, $request_from = NULL) {

        $current_user = $this->session->userdata('gen_user');

//        $this->db->select('o.status order_status,o.id order_id,u.*,o.*,s.*');
        $this->db->select('o.status order_status,o.id order_id,u.*,o.*');

        $this->db->where('o.is_delete', 0);

        if ($this->uri->segment(1) == 'user' && $this->uri->segment(4) != '') {
            if ($this->uri->segment(4) == 'new')
                $this->db->where('modified_date IS NULL');
            else
                $this->db->where('o.status', $this->uri->segment(4));
        }

        if (isset($_POST['search_order']) && !empty($_POST['search_order']))
            $this->db->where('order_number', $_POST['search_order']);

        if (isset($type) && $type == 'bought') {
            $this->db->where('o.user_id', $current_user['user_id']);
            $this->db->join('user u', 'u.user_id=o.user_id', 'left');
        } else {
//            if($this->uri->segment(1)=='user' && $request_from!=NULL && $request_from=='front' && isset($current_user['last_login_as']) && $current_user['last_login_as']=='storeUser')
            if ($this->uri->segment(1) == 'user' && $request_from != NULL && $request_from == 'front') {
                $this->db->where('o.seller_id', $current_user['user_id']);
                $this->db->where('u.user_role', $current_user['user_role']);
            }
            $this->db->join('user u', 'u.user_id=o.seller_id', 'left');
        }

        $this->db->join('shipping_address s', 's.id=o.address_id', 'left');

        $this->db->where('o.created_date >= now()-interval 3 month');

        $this->db->group_by('o.id');

        $query = $this->db->get('orders o');

        return $query->num_rows();
    }

    function order_products($order_id) {

        $current_user = $this->session->userdata('gen_user');
        $user_id = $current_user['user_id'];

        $this->db->select('*');

        $this->db->where('po.order_id', $order_id);
        if ($this->uri->segment(1) == 'user' && $this->uri->segment(3) != '') {
            $wh = '(user_id="' . $user_id . '" or product_owner="' . $user_id . '")';
            $this->db->where($wh);
        }

        $this->db->join('product p', 'p.product_id=po.product_id', 'left');
        $this->db->join('delivery_options do', 'do.id = p.delivery_option', 'left');
        $this->db->join('product_weight pw', 'pw.id = p.weight', 'left');

        $this->db->group_by('p.product_id');
        $query = $this->db->get('product_orders po');

        $result = $query->result_array();
        return $result;
    }

    function state_name($state_id) {

        $this->db->select('*');
        $this->db->where('state_id', $state_id);
        $this->db->limit(1);
        $query = $this->db->get('state');

        $res = $query->result();
        return $res;
    }

    function transaction_list($start = NULL, $limit = NULL) {

        $this->db->select('*');
        $this->db->join('user u', 'u.user_id=t.user_id', 'left');

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $this->db->where('t.status', 0);

        $this->db->order_by('t.id', 'desc');
        $query = $this->db->get('transaction t');

        return $query->result_array();
    }

    function success_order_list($orders) {

        $this->db->select('*');
        $this->db->join('store s', 's.store_owner = o.seller_id', 'left');
        $this->db->where_in('order_number', $orders);

        $ord_str = implode(',', $orders);
        $this->db->order_by('FIELD(order_number,' . $ord_str . ') asc');

        $result = $this->db->get('orders o');

        return $result->result_array();
    }

    public function common_header($title) {

        $email_watermark = HTTPS . website_url . 'assets/front/emailt-template/img/email-watermark.png';

        $header = '<style>
                    .mail-body,
                    .mail-head{ display:inline-block;}
                </style>    
        <body style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0;">
    <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:30px; padding-right:0; padding-bottom:30px; padding-left:0; background:#f6f6f6;">
        <div style="margin-top:0; margin-right:auto; margin-bottom:a; margin-left:auto; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; max-width:600px;">
            <div style="margin-top:0; margin-right:0; margin-bottom:30px; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; border:1px solid #d6d6d6; background:#fff;">
                <div class="mail-head" style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; background:#f5f5f5; display:inline-block; vertical-align:top; width:100%;">
                    <table style="width:100%; vertical-align:middle;">
                        <tr>
                            <td style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:15px;; text-align:left; color:#000; font-size:20px; font-weight:700; font-family: Roboto, sans-serif; line-height:50px;">' . $title . '&nbsp;</td>
                            <td style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:15px; padding-bottom:0; padding-left:0; text-align:right;"><a href="http://doukani.com" style="display:block; heigh:22px;"><img src="http://doukani.com/assets/front/emailt-template/img/email-logo.png" alt="Doukani"/></a></td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding:25px;">
                    <table style="width:100%; vertical-align:middle; margin:0;">
                        <tr>
                            <td style=" margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; position:relative; display:inline-block; vertical-align:top; width:100%; ">
                                <img src="' . $email_watermark . '" alt="" id="doukani_logo" />
                            </td>
';
        return $header;
    }

    public function common_footer() {

        $google_play = HTTPS . website_url . 'assets/front/emailt-template/img/google-play.png';
        $app_store = HTTPS . website_url . 'assets/front/emailt-template/img/app-store.png';
        $facebook = HTTPS . website_url . 'assets/front/emailt-template/img/email-facebook.png';
        $twitter = HTTPS . website_url . 'assets/front/emailt-template/img/email-twitter.png';
        $youtube = HTTPS . website_url . 'assets/front/emailt-template/img/email-youtube.png';
        $instagram = HTTPS . website_url . 'assets/front/emailt-template/img/email-instragram.png';

        $getpage_url = '';
        $facebook_link = $this->dbcommon->getpageurl(17);
        $twitter_link = $this->dbcommon->getpageurl(18);
        $youtube_link = $this->dbcommon->getpageurl(24);
        $instagram_link = $this->dbcommon->getpageurl(19);


        $footer = '<div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:15px; padding-right:0; padding-bottom:15px; padding-left:0; background:#eee; text-align:center;margin:0">
                        <a href="' . HTTPS . website_url . '" style="font-family: Roboto, sans-serif; color:#333; font-size:16px; line-height:18px; text-decoration:none;">Visit our site</a>
                    </div>
                </div>
            </div>
            <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:40px; padding-right:0; padding-bottom:40px; padding-left:0; border:1px solid #d6d6d6; background:#fff; text-align:center;">
                <h2 style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:10px; padding-left:0; font-family: Roboto, sans-serif; color:#000; font-size:24px; font-weight:700; display:block;">Stay Connected</h2>
                <p style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:20px; padding-left:0; font-family: Roboto, sans-serif; color:#000; font-size:18px; font-weight:500; display:block;">Download Doukani.com\'s Mobile App</p>
                <a href="' . doukani_app . '" style="display:inline-block; vertical-align:top; margin-top:0; margin-right:8px; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; "><img src="' . $google_play . '" alt="Google Play Store" /></a>
                <a href="' . doukani_app . '" style="display:inline-block; vertical-align:top; margin-top:0; margin-right:8px; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; "><img src="' . $app_store . '" alt="Iphone apps" /></a>
            </div>
            <div style="margin-top:15px; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; display:inline-block; vertical-align:top; width:100%;">
                <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; float:left">
                    <a href="' . $facebook_link . '" style="margin-top:0; margin-right:6px; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; display:inline-block; vertical-align:top; width:32px; height:32px;"> <img src="' . $facebook . '" alt="facebook" /></a>
                    <a href="' . $twitter_link . '" style="margin-top:0; margin-right:6px; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; display:inline-block; vertical-align:top; width:32px; height:32px;"> <img src="' . $twitter . '" alt="Twitter" /></a>
                    <a href="' . $youtube_link . '" style="margin-top:0; margin-right:6px; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; display:inline-block; vertical-align:top; width:32px; height:32px;"> <img src="' . $youtube . '" alt="Youtube" /></a>
                    <a href="' . $instagram_link . '" style="margin-top:0; margin-right:6px; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; display:inline-block; vertical-align:top; width:32px; height:32px;"> <img src="' . $instagram . '" alt="Instagram" /></a>
                </div>  
                <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; float:right; color:#333; font-size:12px; font-family: Roboto, sans-serif; line-height:32px;"> ©copyright ' . year . '. Doukani.com - All Right Reserved. </div>
                <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; float:left">It is auto generated email Please do not reply.</div>
            </div>
        </div>
    </div>
  </body>';

        return $footer;
    }

    public function right_header($order_number = NULL, $sold_date = NULL, $delivery_type = NULL) {

        $right_part = '<div style=" float:right; width:100%; margin-bottom:20px; margin-right:7px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #cecece;float:right;padding-botton:25px;">
		<tr bgcolor="#f3f3f3">
		<td width="87"  style="border-right:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Order Id</span></td>
		<td  width="100"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">' . $order_number . '</span></td>
		</tr>
		<tr bgcolor="#f3f3f3">
		<td width="87"  style="border-right:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:center; width:100%; font-weight:bold; color:#000000; line-height:38px; float:left;">Order Date</span></td>
		<td  width="100"><span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;">' . $sold_date . '</span></td>
		</tr>
		 <tr bgcolor="#f3f3f3" >
                        <td width="87" style="border-right:1px solid #cecece;">
                            <span style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; color:#000000; line-height:38px; text-align:center; width:100%; float:left;"><b>Payment</b></span>
                        </td>
                        <td width="100" style="text-align: center;">                            
                            <span style="color: red;"><b>' . (isset($delivery_type) && !is_null($delivery_type) ? $delivery_type : 'Cash On Delivery' ) . '</b></span>
                        </td>
                 </tr>
		</table></div>';

        return $right_part;
    }

    public function shipping_address($address_id = 22) {

        $array = array('id' => $address_id);
        $shipping_details = $this->dbcommon->get_row('shipping_address', $array);
        $_state_name = $this->state_name($shipping_details->state_id);

        $shipping = '<div style="float:left; border:1px solid #cccccc;width:100%;margin:0 0 20px;">
    	<span style=" border-bottom:1px solid #cccccc; background:#eee; width:100%;box-sizing: border-box; float:left; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000305;">
            Shipping Address
        </span>
        <div style="float:left; padding:10px; width:96%;  font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#030002; line-height:28px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr><td>Full Name</td><td>:</td><td>' . $shipping_details->customer_name . '</td></tr>';
        if (isset($shipping_details->address_1) && !empty($shipping_details->address_1))
            $shipping .= '<tr><td>Address 1</td><td>:</td><td>' . $shipping_details->address_1 . '</td></tr>';
        if (isset($shipping_details->address_2) && !empty($shipping_details->address_2))
            $shipping .= '<tr><td>Address 2</td><td>:</td><td>' . $shipping_details->address_2 . '</td></tr>';
        if (isset($shipping_details->state_name) && !empty($shipping_details->state_name))
            $shipping .= '<tr><td>Emirate:</td><td>:</td><td>' . $_state_name[0]->state_name . '</td></tr>';
        if (isset($shipping_details->po_box) && !empty($shipping_details->po_box))
            $shipping .= '<tr><td>PO Box</td><td>:</td><td>' . $shipping_details->po_box . '</td></tr>';
        if (isset($shipping_details->contact_number) && !empty($shipping_details->contact_number))
            $shipping .= '<tr><td>Contact Number</td><td>:</td><td>' . $shipping_details->contact_number . '</td></tr>';
        if (isset($shipping_details->email_id) && !empty($shipping_details->email_id))
            $shipping .= '<tr><td>Email Id</td><td>:</td><td>' . $shipping_details->email_id . '</td></tr>';
        $shipping .= '</table>
        </div>
        </div>';

        return $shipping;
    }

    public function mail_product_list($product_arr = NULL, $sub_total = NULL, $seller_shipping_cost = NULL, $grand_total = NULL) {

        $cart_product_text = '';

        foreach ($product_arr as $pro) {

            $cart_product_text .= '<tr>
                                <td style="border-right:1px solid #cecece;border-top:1px solid #cecece;line-height:30px;padding-left:10px;font-family:Arial, Helvetica, sans-serif;">' . $pro['product_name'] . '</td>
                                <td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;line-height:30px;padding-right:10px;font-family:Arial, Helvetica, sans-serif;"><span style="float:right;margin-right:10px;">' . $pro['quantity'] . '</span></td>
                                <td style="border-right:1px solid #cecece;text-align:center;border-top:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif;color:#000000; margin:10px;float:right;">AED ' . number_format($pro['price'], 2) . '</span></td>
                            </tr>';
        }

        $cart_products_list = '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #cccccc;margin:10px 0 20px;">
                            <tr bgcolor="#f3f3f3">
                                <th width="60%" style="border-right:1px solid #cecece; text-align:left;line-height:30px;padding-left:10px;background:#eee;font-family:Arial, Helvetica, sans-serif;">Product Name</th>
                                <th width="20%" style="border-right:1px solid #cecece;line-height:30px;margin-right:10px;text-align:right;padding-right:10px;background:#eee;font-family:Arial, Helvetica, sans-serif;">Quantity</th>
                                <th width="20%" style="border-right:1px solid #cecece;line-height:30px;margin-right:10px;text-align:right;padding-right:10px;background:#eee;font-family:Arial, Helvetica, sans-serif;">Price</th>
                            </tr>
                            ' . $cart_product_text . '
                            <tr>
                                <th colspan="2" style="border:1px ridge #cecece;"><span style="font-size:17px; font-family:Arial, Helvetica, sans-serif; text-align:left; width:97%; color:#000000; float:left; margin:10px;line-height:30px;">Sub-Total</span></th>
                                <th style="border:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:left;color:#000000; float:left; margin:10px;line-height:30px;float:right;">AED ' . number_format($sub_total, 2) . '</span></th>
                            </tr>                            
                            <tr>
                                <th colspan="2" style="border:1px ridge #cecece;"><span style="font-size:17px; font-family:Arial, Helvetica, sans-serif; text-align:left; width:97%; color:#000000; line-height:30px; float:left; margin:10px;">Shipping Cost</span></th>
                                <th style="border:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000000; float:left; margin:10px;line-height:30px;float:right;">AED ' . number_format($seller_shipping_cost, 2) . '</span></th>
                            </tr>
                            <tr>
                                <th colspan="2" style="border:1px ridge #cecece;"><span style="font-size:17px; font-family:Arial, Helvetica, sans-serif; text-align:left; width:97%; color:#000000; line-height:30px; float:left; margin:10px;">Grand Total<span></th>
                                <th style="border:1px solid #cecece;"><span style="font-size:13px; font-family:Arial, Helvetica, sans-serif; text-align:left; color:#000000; float:left; margin:10px;line-height:30px;float:right;">AED ' . number_format($grand_total, 2) . '</span></th>
                            </tr>
                </table>';
        return $cart_products_list;
    }

    function buyer_mail($product_table = NULL, $right_header = NULL, $shipping_address = NULL, $user_email = NULL) {

        $current_user = $this->session->userdata('gen_user');
        $header_part = $this->common_header('Thank you for Shopping');
        $footer_part = $this->common_footer();

        $title1 = ' <tr>
                    <td colspan="2" style="text-align:center;font-size:22px;color:red">
                        <br>Thank you for purchase<br>
                    </td>
                    </tr>';

        $buyer_mail = $header_part .
        '<td>' . $right_header . '</td></tr>' . $title1 . '
                                            <tr>
                                                <td colspan="2">' . $product_table . '</td>
                                            </tr>
                                            <tr>
                                               <td style="vertical-align:top;" colspan="2">'
        . $shipping_address . '
                                               </td>
                                            </tr>
                </table>' .
        $footer_part;

//        if (isset($current_user['email_id']) && !empty($current_user['email_id'])) {
        if (!empty($user_email)) {
            if (send_mail($user_email, 'Thank you for Shopping from Doukani.com', $buyer_mail)) {                
            }
        }
    }

    function seller_mail($seller_name = NULL, $sold_date = NULL, $right_header = NULL, $email_id = NULL, $product_table = NULL, $shipping_address = NULL) {

        $current_user = $this->session->userdata('gen_user');
        $header_part = $this->dbcart->common_header('Thank you for Selling');
        $footer_part = $this->common_footer();

        $title1 = '<tr>
                        <td colspan="2" style="color:red;text-align:center;font-size:30px;">
                            Congratulations! 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center;font-size:22px;">
                            You sold something at Doukani.com
                        </td>
                    </tr>';

        $title2 = '<tr>                    
                        <td colspan="2">
                            <p style="font-size:14px;font-family:Arial, Helvetica, sans-serif;">
                                Hi ' . $seller_name . ',
                            </p>
                            <p style="font-size:14px;font-family:Arial, Helvetica, sans-serif;">
                                Thank you for being a seller on Doukani.com. You have just sold something at Doukani.com on ' . $sold_date . '
                            </p>
                            <p style="font-size:14px;font-family:Arial, Helvetica, sans-serif;">
                                Please review the details of the transaction below.
                            </p>
                        </td>
                   </tr>';

        $seller_mail = $header_part .
        ' <td>' . $right_header . '</td>
                         </tr>'
        . $title1 . $title2 .
        '                        
                         <tr>
                             <td colspan="2">' . $product_table . '</td>
                         </tr>
                         <tr>
                             <td style="vertical-align:top;" colspan="2">' . $shipping_address . '</td>
                        </tr></table>'
        . $footer_part;

        if (isset($email_id) && !empty($email_id)) {
            if (send_mail($email_id, 'You sold something at Doukani.com', $seller_mail)) {                
            }
        }
    }

    function get_commossion_rate($store_id = NULL) {

        $commission_percentage = 0.0;
        $this->db->select('val');
        $this->db->where('`key`', 'commission_on_purchase_from_store');
        $this->db->limit(1);
        $query = $this->db->get('settings');
        $default_commission = $query->row_array();

        if (isset($default_commission) && sizeof($default_commission) > 0) {
            $commission_percentage = $default_commission['val'];
        }

        if (!is_null($store_id) && $store_id > 0) {
            $this->db->select('commission_on_purchase_from_store');
            $this->db->where('store_id', $store_id);
            $this->db->limit(1);
            $query = $this->db->get('store');
            $store_commission = $query->row_array();
            if (isset($store_commission) && sizeof($store_commission) > 0 && $store_commission['commission_on_purchase_from_store'] > 0) {
                $commission_percentage = $store_commission['commission_on_purchase_from_store'];
            }
//            print_r($store_commission);
        }
        return $commission_percentage;
    }

    function balance_list($start = NULL, $limit = NULL) {

        $this->db->select('o.id order_id, o.order_number, s.store_owner, s.store_name, b.percentage, b.amount, b.store_amount, b.doukani_amout, b.status balance_status, o.status order_status');
        $this->db->join('balance b', 'b.order_id = o.id', 'LEFT');
        $this->db->join('store s', 's.store_owner = b.store_owner', 'LEFT');

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        if (isset($_POST['search_order']) && !empty($_POST['search_order']))
            $this->db->where('o.order_number', $_POST['search_order']);

//        $this->db->where('o.delivery_type', 'PREPAID');
        $this->db->where('o.is_delete', 0);
        $this->db->group_by('o.id');
        $this->db->order_by('o.id', 'desc');

        $query = $this->db->get('orders o');

        $result = $query->result_array();
        return $result;
    }

    function getShippingCost() {

        $session_qunatity = $this->session->userdata('doukani_products');
        $product_list = $this->dbcart->product_list_cart();

        $admin_ship_condition = 'store_id = 0 AND is_active = 1';
        $shipping_admin_cost = $this->dbcommon->select('shipping_costs_admin', $admin_ship_condition)[0];

        $product_ids = array();
        $product_arry = explode(",", $session_qunatity);
        foreach ($product_arry as $id) {
            $arr = explode('-', $id);
            if (isset($arr[0]) && !empty($arr[0]) && isset($arr[1]) && !empty($arr[1])) {
                $product_ids[$arr[0]] = $arr[1];
            }
        }

        $shipping_cost = array();
        $shipping_weight = array();

        foreach ($product_list as $list_key => $list_data) {
            $c_store_id = 0;
            $c_shipping_method_id = 0;
            $c_weight = 0;

            if ($list_data['store'] != $c_store_id) {
                $c_store_id = $list_data['store'];
            }
            if ($list_data['timeline_id'] != $c_shipping_method_id) {
                $c_shipping_method_id = $list_data['timeline_id'];
            }
            if (isset($shipping_weight[$c_store_id][$c_shipping_method_id]) && !empty($shipping_weight[$c_store_id][$c_shipping_method_id])) {
                $c_weight = (float) $shipping_weight[$c_store_id][$c_shipping_method_id] * $product_ids[$list_data['product_id']];
            }
            $c_weight = $c_weight + ($list_data['weight'] * $product_ids[$list_data['product_id']]);
            $shipping_weight[$c_store_id][$c_shipping_method_id] = array('weight' => ceil($c_weight));
        }

        $total_charge = 0;
        if (isset($shipping_weight) && sizeof($shipping_weight) > 0) {
            foreach ($shipping_weight as $w_key => $w_data) {
                $weight = 0;
                $store_ship_condition = 'store_id = ' . $w_key . ' AND is_active = 1';
                $shipping_charges = $this->dbcommon->select('shipping_costs_admin', $store_ship_condition);

                if (empty($shipping_charges)) {
                    $shipping_charges = $shipping_admin_cost;
                }

                $c_charge = 0;
                foreach ($w_data as $k_key => $k_data) {
                    $c_charge = $shipping_charges['cost'];
                    if ($k_data['weight'] > $shipping_charges['max_weight']) {
                        $weight = $k_data['weight'] - $shipping_charges['max_weight'];
                        $n_charge = $weight * $shipping_charges['cost_per_extra_kg'];
                        $c_charge = $c_charge + $n_charge;
                    }
                    $shipping_weight[$w_key][$k_key]['shipping_cost'] = $c_charge;
                    $total_charge = $total_charge + $c_charge;
                }
            }
        }
        $final_result = array();
        $final_result['store_shipping_weight'] = $shipping_weight;
        $final_result['shipping_total'] = $total_charge;

        return $final_result;
    }

}

?>