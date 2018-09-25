<?php

class Orders extends My_controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('dbcart', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);

        $this->load->library('pagination');
        $this->per_page = 10;
    }

    function index() {

        $data = array();
        $data['page_title'] = 'Orders List';

        $url = site_url() . 'admin/orders/';
        $where = ' t.id from transaction t left join user u ON u.user_id=t.user_id where t.status=0 GROUP BY t.id';

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;
        $data['url'] = $url;
        $data['transaction_list'] = $this->dbcart->transaction_list($offset, $per_page);
        $pagination_data = $this->dbcommon->pagination($url, $where, $per_page, 'yes');

        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];

        $this->load->view('admin/orders/index', $data);
    }

    function order_list() {

        $arr = array();
        $transaction_id = $this->input->post('transaction_id');
        $arr['transaction_list'] = $this->dbcart->orders(NULL, NULL, $transaction_id);
        $arr['html'] = $this->load->view('admin/orders/order_list', $arr, TRUE);

        echo json_encode($arr);
        exit;
    }

    function order_details($order_id = NULL) {

        $data = array();
        $data['page_title'] = 'Orders Details';
        $data['products'] = $this->dbcart->order_products($order_id);

        $wh_ord = ' * from orders where id=' . $order_id . ' and is_delete=0 ';
        $order_details = $this->dbcommon->getdetails_($wh_ord);

        if (!empty($order_details)) {
            $data['order_details'] = $order_details;

            $wh_buyer = ' * from shipping_address where id=' . $order_details[0]->address_id . ' and user_id=' . $order_details[0]->user_id;
            $data['buyer_details'] = $this->dbcommon->getdetails_($wh_buyer);

            $wh_seller = ' * from user where user_id=' . $order_details[0]->seller_id;
            $data['seller_image'] = $this->dbcommon->getdetails_($wh_seller);

            $wh_seller = ' * from store where store_owner=' . $order_details[0]->seller_id;
            $data['seller_details'] = $this->dbcommon->getdetails_($wh_seller);

            $this->load->view('admin/orders/order_details', $data);
        } else {
            redirect('admin/orders');
        }
    }

    function order_update() {

        $current_user = $this->session->userdata('user');

        $order_id = $this->input->post('order_id');
        $status = $this->input->post('status');

        $up_data = array('status' => $status,
            'modified_date' => date('Y-m-d H:i:s'),
            'modified_by' => $current_user->user_id
        );

        $arr = array('id' => $order_id, 'is_delete' => 0);

        $result = $this->dbcommon->update('orders', $arr, $up_data);

        if (isset($result)) {
            if ($status == 'canceled') {

                $payment_data = array('order_id' => $order_id, 'response_code' => PAY_TABS_PAGE_PAYMENT_SUCCESS);
                $payment_details = $this->dbcommon->getdetailsinfo('paytabs_payment', $payment_data);
                if (isset($payment_details) && sizeof($payment_details) > 0) {
                    $this->load->library('Paytab');
                    $refund_req_data = array(
                        'paypage_id' => $payment_details->pt_invoice_id,
                        'reference_number' => $payment_details->reference_no,
                        'refund_amount' => $payment_details->amount,
                        'refund_reason' => 'Admin canceled Order',
                        'transaction_id' => $payment_details->transaction_id,
                    );
                    $response = $this->paytab->refund_process($refund_req_data);

                    $in_data = array(
                        'result' => $response->result,
                        'response_code' => $response->response_code,
                        'pt_invoice_id' => $payment_details->pt_invoice_id,
                        'amount' => $payment_details->amount,
                        'currency' => $payment_details->currency,
                        'reference_no' => $payment_details->reference_no,
                        'transaction_id' => $payment_details->transaction_id,
                        'created_date' => date('Y-m-d H:i:s'),
                        'user_id' => $payment_details->user_id,
                        'order_id' => $payment_details->order_id,
                        'created_by' => $current_user->user_id
                    );
                    $this->dbcommon->insert('paytabs_payment', $in_data);

                    $up_data = array('status' => 2);
                    $arr = array('order_id' => $order_id, 'status' => 1);
                    $this->dbcommon->update('balance', $arr, $up_data);
                }

                $product_list = $this->dbcart->order_products($order_id);

                if (isset($product_list) && sizeof($product_list) > 0) {
                    foreach ($product_list as $prod) {
                        $this->db->query('update product set stock_availability = stock_availability + ' . $prod['quantity'] . ' where product_id=' . $prod['product_id']);
                    }
                }
            }

            $in_data = array('order_id' => $order_id,
                'status' => $status,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $current_user->user_id
            );

            $this->dbcommon->insert('order_status', $in_data);
            $this->session->set_flashdata('msg', 'Order updated successfully');
        }
        redirect('admin/orders');
    }

    function delete_transaction($transaction_id = NULL) {

        $redirect_url = '';

        if ($this->input->post("checked_val") != '') {
            $transaction_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $transaction_id);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $transaction_id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $success = 0;

        $transactions = $this->db->query('select * from transaction                                 
                                where id in (' . $comma_ids . ')')->result_array();

        foreach ($transactions as $key => $trans) {

            $data = array('status' => 1);
            $wh = array('id' => $trans['id'], 'status' => 0);

            $result = $this->dbcommon->update('transaction', $wh, $data);

            $wh = array('transaction_id' => $trans['id'], 'is_delete' => 0);
            $data = array('is_delete' => 1);
            $this->dbcommon->update('orders', $wh, $data);
            $success++;
        }

        if ($success > 0)
            $this->session->set_flashdata('msg', 'Transaction(s) deleted successfully');
        else
            $this->session->set_flashdata('msg', 'Transaction(s) not deleted');

        redirect('admin/orders' . '/' . $redirect_url);
    }

    function delete_order($order_id = NULL) {

        $redirect_url = '';

        if ($this->input->post("checked_val") != '') {
            $order_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $order_id);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $order_id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $success = 0;
        $orders = $this->db->query('select * from orders                                 
                                where id in (' . $comma_ids . ')')->result_array();

        $current_user = $this->session->userdata('user');

        foreach ($orders as $key => $ord) {

            $result = $this->db->query('UPDATE orders SET is_delete = 1, modified_date = "' . date('Y-m-d H:i:s') . '", modified_by = "' . $current_user->user_id . '"
                                WHERE is_delete = 0
                                AND id = "' . $ord['id'] . '"');

            $success++;

            $num_row1 = $this->dbcommon->getnumofdetails_("* from orders where transaction_id = " . $ord['transaction_id'] . "");
            if ($num_row1 < 1) {
                $data = array('status' => 1);
                $array = array('id' => $ord['transaction_id']);
                $result = $this->dbcommon->update('transaction', $array, $data);
            }
        }

        if ($success > 0)
            $this->session->set_flashdata('msg', 'Order(s) deleted successfully');
        else
            $this->session->set_flashdata('msg', 'Order(s) not deleted');

        redirect('admin/orders/order_listing/' . $redirect_url);
    }

    public function order_listing() {

        $data = array();
        $data['page_title'] = 'Orders Listing';
        $url = site_url() . 'admin/orders/order_listing/';

        if (isset($_POST['search_order']) && !empty($_POST['search_order']))
            $where = ' id from orders where order_number="' . $_POST['search_order'] . '" and is_delete=0';
        else
            $where = ' id from orders where is_delete=0';

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

        $data['url'] = $url;
        $data['orders'] = $this->dbcart->orders($offset, $per_page);
        $pagination_data = $this->dbcommon->pagination($url, $where, $per_page, 'yes');

        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];

        $this->load->view('admin/orders/orders_listing', $data);
    }

    function balance_list() {
        $data = array();
        $data['page_title'] = 'Balance List';

        $url = site_url() . 'admin/orders/balance_list';

        if (isset($_POST['search_order']) && !empty($_POST['search_order']))
            $where = ' id from orders where order_number="' . $_POST['search_order'] . '" and is_delete=0';
        else
            $where = ' id from orders where is_delete=0';

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

        $data['url'] = $url;
        $data['balance_list'] = $this->dbcart->balance_list($offset, $per_page);
        $pagination_data = $this->dbcommon->pagination($url, $where, $per_page, 'yes');

        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];

        $this->load->view('admin/orders/balance_list', $data);
    }

}

?>