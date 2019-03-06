<?php

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('offer', '', TRUE);
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        $this->load->helper('email');
        $this->load->model('store', '', TRUE);
        $this->per_page = 10;
        $this->per_page_ = 10;
        $this->perpageSuffix = "";
        $this->filterSuffix = "";
        if ($this->input->get('per_page')) {
            $this->perpageSuffix = '?per_page=' . $this->input->get('per_page');
        }
        if ($this->input->get('search')) {
            $this->filterSuffix = "?search=" . $this->input->get('search');
            if ($this->input->get('per_page')) {
                $this->perpageSuffix = '&per_page=' . $this->input->get('per_page');
            }
        }
        $this->suffix = $this->filterSuffix . $this->perpageSuffix;
    }

    public function index($user_role = null) {

        $data = array();
        if ($user_role == 'generalUser')
            $data['page_title'] = 'Classified User List';
        elseif ($user_role == 'storeUser')
            $data['page_title'] = 'Store User List';
        elseif ($user_role == 'offerUser')
            $data['page_title'] = 'Offer User List';
        else
            $data['page_title'] = 'User List';

//        $this->session->unset_userdata('listing_userid');
//        $this->session->unset_userdata('repost_userid');

        if ($user_role != '') {
            $con = '';
            $qu = '';
            $search = '';
            $filter_val = '';
            $opt = '';
            $state_id = '';
            $dt = '';
            $ord = ' order by user_id desc';
            $cou = 0;
            $check_is_delete = 0;

            $url = site_url() . 'admin/users/index/' . $user_role;
            $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

            $where = ' u.user_id from user u
                    left join store s on s.store_owner=u.user_id 
                    left join offer_user_company o on o.user_id = u.user_id 
                    left join featured_stores f on f.store_id=s.store_id  and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between f.start_date and f.end_date)  
                    left join featured_company fc on fc.company_user_id=u.user_id  and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fc.start_date and fc.end_date)  
                    ';

            $where .= "where  ";

            if (isset($_GET['filter']))
                $filter_val = $_GET['filter'];

            if (isset($_GET['con']))
                $con = $_GET['con'];

            if (isset($_GET['st']))
                $state_id = $_GET['st'];

            if (isset($_GET['dt']))
                $dt = $_GET['dt'];

            $arr = array('all', 'reg', 'not_reg', 'blo', 'not_blo', 'cou', 'dt', 'wt', 'not_agree');
            if (in_array($filter_val, $arr)) {
                $url = site_url() . 'admin/users/index/' . $user_role . '?filter=' . $filter_val;
                $search = '?filter=' . $filter_val;
            }
            if ($filter_val == 'all')
                $qu .= " user_role = '" . $user_role . "' ";
            elseif ($filter_val == "reg")
                $qu .= " is_registered = 0 and user_role = '" . $user_role . "'";
            elseif ($filter_val == "not_reg")
                $qu .= " is_registered = 1 and user_role = '" . $user_role . "'";
            elseif ($filter_val == "blo") {
                $check_is_delete = 1;
                $qu .= " u.is_delete =4 and user_role = '" . $user_role . "'";
            } elseif ($filter_val == "not_blo") {
                $check_is_delete = 1;
                $qu .= " u.is_delete =0   and user_role = '" . $user_role . "'";
            } elseif ($filter_val == "not_agree") {
                $check_is_delete = 1;
                $qu .= " u.is_delete =2   and user_role = '" . $user_role . "'";
            } elseif ($filter_val == "cou") {
                if ($con == "0" && $state_id == "0")
                    $qu .= " user_role = '" . $user_role . "'";
                elseif ($con != "0" && $state_id != "0" && $state_id != '') {
                    $qu .= " country = " . $con . " and user_role = '" . $user_role . "' and state = " . $state_id;
                    $url = base_url() . 'admin/users/index/' . $user_role . '?filter=' . $filter_val . '&con=' . $con . '&st=' . $state_id;
                    $search = '?filter=' . $filter_val . '&con=' . $con . '&st=' . $state_id;
                } elseif ($con != "0" && $state_id == "0") {
                    $qu .= "  country = " . $con . " and user_role = '" . $user_role . "'";
                    $url = base_url() . 'admin/users/index/' . $user_role . '?filter=' . $filter_val . '&con=' . $con;
                    $search = '?filter=' . $filter_val . '&con=' . $con;
                } else {
                    if ($con != 0) {
                        $qu .= " country = " . $con . " and user_role='" . $user_role . "'";
                        $url = base_url() . 'admin/users/index/' . $user_role . '?filter=' . $filter_val . '&con=' . $con;
                        $search = '?filter=' . $filter_val . '&con=' . $con;
                    } else {
                        $qu .= "  user_role = '" . $user_role . "'";
                        $url = base_url() . 'admin/users/index/' . $user_role;
                    }
                }
            } elseif ($filter_val == "dt") {

                if (!empty($dt)) {
                    $check_is_delete = 1;
                    $dt = str_replace("+", "", $dt);
                    $date = explode("to", $dt);

                    $start_date = date("Y-m-d", strtotime(trim($date[0])));
                    $end_date = date("Y-m-d", strtotime(trim($date[1])));

                    if ($user_role == 'storeUser') {
                        $qu .= " (date(s.store_created_on)  between '" . $start_date . "' and '" . $end_date . "') and u.user_role = '" . $user_role . "' ";
                    } elseif ($user_role == 'offerUser') {
                        $qu .= " (date(o.created_date)  between '" . $start_date . "' and '" . $end_date . "') and u.user_role = '" . $user_role . "' ";
                    } else {
                        $qu .= " (date(u.user_register_date)  between '" . $start_date . "' and '" . $end_date . "') and u.user_role = '" . $user_role . "' ";
                    }
                    $url = base_url() . 'admin/users/index/' . $user_role . '?filter=' . $filter_val . '&dt=' . trim($date[0]) . 'to' . trim($date[1]);
                    $search = '?filter=' . $filter_val . '&dt=' . trim($date[0]) . 'to' . trim($date[1]);
                } else {
                    $qu .= " user_role = '" . $user_role . "' ";
                }
            } elseif ($filter_val == "wt") {
                $check_is_delete = 1;
                $qu .= " s.new_data_status = 1 ";
                $url = base_url() . 'admin/users/index/' . $user_role . '/?filter=wt';
                $search = '?filter=' . $filter_val;
            } else {
                $qu .= " user_role = '" . $user_role . "' ";
            }

            if (isset($_REQUEST['device_type']) && $_REQUEST['device_type'] != '') {
                if ($_REQUEST['device_type'] == 'null')
                    $qu .= " and device_type IS NULL ";
                else
                    $qu .= " and device_type = " . $_REQUEST['device_type'];
                $url = base_url() . 'admin/users/index/' . $user_role . '?filter=' . $filter_val . '&device_type=' . $_REQUEST['device_type'];
                $search = '?filter=' . $filter_val . '&device_type=' . $_REQUEST['device_type'];
            }

            if (isset($_REQUEST['store_is_inappropriate']) && !empty($_REQUEST['store_is_inappropriate'])) {
                $appropriate = $_REQUEST['store_is_inappropriate'];
                $url .= "&store_is_inappropriate=" . $appropriate;
                $qu .= " and store_is_inappropriate = '" . $_REQUEST['store_is_inappropriate'] . "'";
                $search .= '&store_is_inappropriate=' . $_REQUEST['store_is_inappropriate'];
            }

            if (isset($_REQUEST['store_status']) && !empty($_REQUEST['store_status'])) {
                if (in_array($_REQUEST['store_status'], array('0', '3', 0, 3))) {
                    $stat = $_REQUEST['store_status'];
                    $url .= "&store_status=" . $stat;
                    $qu .= " and store_status = '" . $_REQUEST['store_status'] . "'";
                    $search .= '&store_status=' . $_REQUEST['store_status'];
                }
            }

            if (isset($_REQUEST['company_is_inappropriate']) && !empty($_REQUEST['company_is_inappropriate'])) {
                $appropriate = $_REQUEST['company_is_inappropriate'];
                $url .= "&company_is_inappropriate=" . $appropriate;
                $qu .= " and company_is_inappropriate = '" . $_REQUEST['company_is_inappropriate'] . "'";
                $search .= '&company_is_inappropriate=' . $_REQUEST['company_is_inappropriate'];
            }

            if (isset($_REQUEST['company_status']) && !empty($_REQUEST['company_status'])) {
                if (in_array($_REQUEST['company_status'], array(0, 3))) {
                    $stat = $_REQUEST['company_status'];
                    $url .= "&company_status=" . $stat;
                    $qu .= " and company_status = '" . $_REQUEST['company_status'] . "'";
                    $search .= '&company_status=' . $_REQUEST['company_status'];
                }
            }

            if (isset($_REQUEST['search_text']) && !empty($_REQUEST['search_text'])) {
                $stat = $_REQUEST['search_text'];
                $url .= "&search_text=" . $stat;

                if ($user_role == 'generalUser')
                    $qu .= " and ( u.email_id like '%" . $_REQUEST['search_text'] . "%' OR u.nick_name like '%" . $_REQUEST['search_text'] . "%' OR u.username like '%" . $_REQUEST['search_text'] . "%' ) ";
                elseif ($user_role == 'storeUser')
                    $qu .= " and ( u.email_id like '%" . $_REQUEST['search_text'] . "%' OR u.nick_name like '%" . $_REQUEST['search_text'] . "%' OR u.username like '%" . $_REQUEST['search_text'] . "%' OR s.store_name like '%" . $_REQUEST['search_text'] . "%'  OR s.store_domain like '%" . $_REQUEST['search_text'] . "%' ) ";
                elseif ($user_role == 'offerUser')
                    $qu .= " and ( u.email_id like '%" . $_REQUEST['search_text'] . "%' OR u.nick_name like '%" . $_REQUEST['search_text'] . "%' OR u.username like '%" . $_REQUEST['search_text'] . "%' OR o.company_name like '%" . $_REQUEST['search_text'] . "%') ";

                $search .= '&search_text=' . $_REQUEST['search_text'];
            }

            if (isset($_REQUEST['per_page'])) {
                $per_page = $_REQUEST['per_page'];
                $url .= '&per_page=' . $per_page;
                $search .= '&per_page=' . $per_page;
            } else
                $per_page = $this->per_page;

            if (isset($_REQUEST['page']) && !empty($search))
                $search .= '&page=' . $_REQUEST['page'];
            elseif (isset($_REQUEST['page']))
                $search .= '?page=' . $_REQUEST['page'];

            $st_status = '';
            $com_status = '';
            if ($user_role == 'storeUser')
                $st_status = ' and if(s.store_owner=u.user_id,s.store_status<>1,1=1) ';
            elseif ($user_role == 'offerUser')
                $com_status = ' and if(o.user_id=u.user_id,o.company_status<>1,1=1)';

            if ($check_is_delete == 0) {
                if ($qu != '')
                    $wh = $where . '' . $qu . ' and u.is_delete in (0,2,5,3,4) ' . $st_status . $com_status . ' group by u.user_id';
                else
                    $wh = $where . ' u.is_delete in (0,2,5,3,4) ' . $st_status . $com_status . ' group by u.user_id';
            }
            else {
                if ($qu != '')
                    $wh = $where . '' . $qu . ' group by u.user_id';
                else
                    $wh = $where . ' u.user_role="' . $user_role . '"  group by u.user_id';
            }

            $pagination_data = $this->dbcommon->pagination($url, $wh, $per_page, 'yes');
            $data["links"] = $pagination_data['links'];
            $data['total_records'] = $pagination_data['total_rows'];

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

            $location = $this->dbcommon->select('country');
            $data['location'] = $location;

            $where = 'select *,u.user_id as user_id,s.store_id store_id,
                if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between f.start_date and f.end_date and s.store_is_inappropriate="Approve" and s.store_status=0,"f_ad","-") as store_f_status,
                if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fc.start_date and fc.end_date and o.company_is_inappropriate="Approve" and o.company_status=0,"f_ad","-" ) as offer_f_status,
                    o.id company_user_id,u.is_delete as is_delete                    
                    from user u
                    left join store s on s.store_owner=u.user_id 
                    left join offer_user_company o on o.user_id = u.user_id 
                    left join featured_stores f on f.store_id=s.store_id  and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between f.start_date and f.end_date)  
                    left join featured_company fc on fc.company_user_id=u.user_id  and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fc.start_date and fc.end_date)
                    ';

            if ($qu != '')
                $where .= 'where ' . $qu . " and u.user_role = '" . $user_role . "' and u.is_delete in (0,2,5,3,4) " . $st_status . $com_status . " group by u.user_id order by u.user_id desc limit " . $offset . ',' . $per_page;
            else
                $where .= " where   u.user_role = '" . $user_role . "'  and u.is_delete in (0,2,5,3,4) " . $st_status . $com_status . " group by u.user_id order by u.user_id desc limit " . $offset . ',' . $per_page;

            $users = $this->dbcommon->get_distinct($where);
            $data['users'] = $users;
            $data['search'] = $search;
            $data['user_role'] = $user_role;

            $msg = $this->session->flashdata('msg');
            if (!empty($msg)):
                $data['msg'] = $this->session->flashdata('msg');
                $data['msg_class'] = $this->session->flashdata('class');
            endif;
            $data['title'] = 'All Users';
            $this->load->view('admin/users/index', $data);
        }
        else {
            redirect('admin/home');
        }
    }

    function block($id) {

        if (!empty($id)) {
            $data = array('is_delete' => 4);
            $array = array('user_id' => $id, 'is_delete' => 0);
            $result = $this->dbcommon->update('user', $array, $data);

            $user = $this->db->query('select user_id, user_role from user where user_id=' . (int) $id . ' and is_delete=4 limit 1')->row_array();

            if (isset($user) && $user['user_role'] == 'storeUser') {
                $store_user_id = (int) $user['user_id'];

                if ($store_user_id > 0) {
                    $data = array('store_status' => 2);
                    $array = array('store_owner' => $id, 'store_status' => 0);
                    $result = $this->dbcommon->update('store', $array, $data);
                }
            }

            if (isset($user) && $user['user_role'] == 'offerUser') {
                $offer_id = (int) $user['user_id'];

                if ($offer_id > 0) {
                    $data = array('company_status' => 2);
                    $array = array('user_id' => $id, 'company_status' => 0);
                    $result = $this->dbcommon->update('offer_user_company', $array, $data);
                }
            }
            if (isset($result)) {

                if (isset($user) && $user['user_role'] == 'offerUser') {
                    $res = $this->db->query('select offer_id from offers where offer_user_company_id=' . (int) $id . ' and is_delete=0');
                    $res_data = $res->result_array();

                    if ($res->num_rows() > 0) {
                        $in_data = $up_data = array();
                        foreach ($res_data as $val) {

                            $this->db->query('delete from block_offers where offer_id=' . $val['offer_id']);
                            $in_data[] = array('offer_id' => $val['offer_id']);
                            $up_data[] = array('offer_id' => $val['offer_id'], 'is_delete' => 2);
                        }

                        if (isset($in_data) && sizeof($in_data) > 0)
                            $this->db->insert_batch('block_offers', $in_data);
                        if (isset($up_data) && sizeof($up_data) > 0)
                            $this->db->update_batch('offers', $up_data, 'offer_id');
                    }
                }
                else {
                    $res = $this->db->query('select product_id from product where product_posted_by=' . (int) $id . ' and is_delete=0');
                    $res_data = $res->result_array();

                    if ($res->num_rows() > 0) {
                        $in_data = $up_data = array();
                        foreach ($res_data as $val) {
                            $this->db->query('delete from block_product where product_id=' . $val['product_id']);
                            $in_data[] = array('product_id' => $val['product_id']);
                            $up_data[] = array('product_id' => $val['product_id'], 'is_delete' => 2);
                        }

                        if (isset($in_data) && sizeof($in_data) > 0)
                            $this->db->insert_batch('block_product', $in_data);
                        if (isset($up_data) && sizeof($up_data) > 0)
                            $this->db->update_batch('product', $up_data, 'product_id');
                    }
                }
            }
            $redirectUrl = $_POST['redirectUrl'];
            $this->session->set_flashdata(array('msg' => 'User blocked successfully', 'class' => 'alert-success'));
            redirect($redirectUrl);
        }
    }

    function unblock($id) {

        if (!empty($id)) {
            $data = array('is_delete' => 0);
            $array = array('user_id' => $id, 'is_delete' => 4);
            $result = $this->dbcommon->update('user', $array, $data);

            $user = $this->db->query('select user_id,user_role from user where user_id=' . (int) $id . ' and is_delete=0 limit 1')->row_array();

            if (isset($user) && $user['user_role'] == 'storeUser') {
                $store_user_id = (int) $user['user_id'];

                if ($store_user_id > 0) {
                    $data = array('store_status' => 0);
                    $array = array('store_owner' => $id, 'store_status' => 2);
                    $result = $this->dbcommon->update('store', $array, $data);
                }
            }

            if (isset($user) && $user['user_role'] == 'offerUser') {
                $offer_id = (int) $user['user_id'];
                if ($offer_id > 0) {
                    $data = array('company_status' => 0);
                    $array = array('user_id' => $id, 'company_status' => 2);
                    $result = $this->dbcommon->update('offer_user_company', $array, $data);
                }
            }

            if (isset($result)) {

                if (isset($user) && $user['user_role'] == 'offerUser') {
                    $res = $this->db->query('select offer_id from offers where offer_user_company_id=' . (int) $id . ' and is_delete=2');
                    $res_data = $res->result_array();

                    if ($res->num_rows() > 0) {
                        $in_data = $up_data = array();
                        foreach ($res_data as $val) {

                            $this->db->query('delete from block_offers where offer_id=' . $val['offer_id']);
                            $up_data[] = array('offer_id' => $val['offer_id'], 'is_delete' => 0);
                        }

                        if (isset($up_data) && sizeof($up_data) > 0)
                            $this->db->update_batch('offers', $up_data, 'offer_id');
                    }
                }
                else {
                    $res = $this->db->query('select product_id from product where product_posted_by=' . (int) $id . ' and is_delete=2');

                    $res_data = $res->result_array();
                    if ($res->num_rows() > 0) {
                        $in_data = $up_data = array();
                        foreach ($res_data as $val) {
                            $up_data[] = array('product_id' => $val['product_id'], 'is_delete' => 0);
                            $this->db->query('delete from block_product where product_id=' . $val['product_id']);
                        }

                        if (isset($up_data) && sizeof($up_data) > 0) {
                            $this->db->update_batch('product', $up_data, 'product_id');
                        }
                    }
                }
            }

            $redirectUrl = $_POST['redirectUrl'];
            $this->session->set_flashdata(array('msg' => 'User un-blocked successfully', 'class' => 'alert-success'));
            redirect($redirectUrl);
        }
    }

    public function login() {
        $data = array();
        $data['page_title'] = 'Admin Login';

        if (isset($_POST['submit']) && $_POST['submit'] == 'Sign in'):
            $this->form_validation->set_rules('email_id', 'Email', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run() == FALSE) {
                $data['msg'] = "";
                $this->load->view('admin/users/login', $data);
            } else {
                $where = " where (email_id='" . addslashes($_POST['email_id']) . "' or username='" . $_POST['email_id'] . "') and password='" . addslashes(md5($_POST['password'])) . "'";
                $user = $this->dblogin->isExist($where);

                if ($user) {
                    $where_role = " where user_role in ('superadmin','admin') and (email_id='" . addslashes($_POST['email_id']) . "' or username='" . $_POST['email_id'] . "') and  password='" . addslashes(md5($_POST['password'])) . "'";
                    $user_role = $this->dblogin->isExist($where_role);

                    if ($user_role) {
                        if ($user->user_block == 1) {

                            $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
                            $array = array('page_state' => 1, 'page_id' => 23);
                            $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

                            if ($header_menu[0]['direct_url'] != '')
                                $contact_url = $header_menu[0]['direct_url'];
                            else
                                $contact_url = $header_menu[0]['slug_url'];

                            $data['msg'] = '<font color="red">Your Account Is Blocked By Admin. To Unblock  &nbsp; <a href="' . site_url() . $contact_url . '"><span><u>' . $header_menu[0]['page_title'] . '</u></span></a>&nbsp;&nbsp;</font>';
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/users/login', $data);
                        } else if ($user->status == "inactive") {
                            $data['msg'] = 'Your Account Is Not Active';
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/users/login', $data);
                        } else {
                            if ($user->user_role == 'admin') {
                                $where = " where user_id='" . $user->user_id . "'";
                                $admin_permission = $this->dbcommon->readpermission('user_permission', $where);

                                if (isset($admin_permission[0]['permission']) && !empty($admin_permission[0]['permission'])) {
                                    $this->session->set_userdata('admin_modules_permission', $admin_permission[0]['permission']);
                                }
                            }

                            $this->session->set_userdata('user', $user);
                            $data = array(
                                'last_logged_in' => date('Y-m-d H:i:s')
                            );
                            $array = array('user_id' => $user->user_id);
                            $result = $this->dbcommon->update('user', $array, $data);
                            redirect(base_url() . "admin/home");
                        }
                    } else {
                        $data['msg'] = 'You have no rights to access this panel';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/users/login', $data);
                    }
                } else {
                    $data['msg'] = 'Username and Password did not matched.';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/users/login', $data);
                }
            }
        else:
            $result = array();
            if (isset($_GET['ident']) && isset($_GET['activate'])):
                $data['ident'] = $_GET['ident'];
                $data['activate'] = $_GET['activate'];
            endif;
            $msg = $this->session->flashdata('msg');
            if (!empty($msg)):
                $data['msg'] = $this->session->flashdata('msg');
                $data['msg_class'] = $this->session->flashdata('class');
            endif;
            if ($this->uri->segment(1) == 'admin' && $this->session->userdata('user') != '')
                redirect('admin/home');
            else
                $this->load->view('admin/users/login', $data);
        endif;
    }

    public function forget_password() {

        $result = array();
        $result['page_title'] = 'Forget Password';
        if ($this->uri->segment(1) == 'admin' && $this->session->userdata('user') != '')
            redirect('admin/home');
        else {
            $this->form_validation->set_rules('email_id', 'Email Address', 'trim|required|valid_email|max_length[250]');
            if ($this->form_validation->run() == false) {
                $result['msg'] = '';
                $this->load->view('admin/users/forget_password', $result);
            } else {
                $where = " where email_id='" . addslashes($_POST['email_id']) . "' or username='" . $_POST['email_id'] . "'";
                $user = $this->dblogin->isExist($where);
                if (!empty($user)):
                    $username = $user->username;
                    $email_id = $user->email_id;

                    $parser_data = array();

                    $activate_key = $this->my_encryption->safe_b64encode($user->password);
                    $button_link = base_url() . "admin/users/reset_password?ident=" . $user->user_id . "&activate=" . $activate_key;
                    $button_label = 'Reset Password';
                    $parser_data = array();
                    $title = 'Forgot Password?';

                    $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> 
        <h3 style="color:#7f7f7f; font-size:16px;">Reset your password</h3>
        <strong>Username:</strong>' . $username . '<p style="margin: 1em 0;">
                                        <strong>E-mail:</strong>
                                        <a href="mailto:' . $email_id . '" style="color: #000000 !important;">' . $email_id . '</a></p>
                        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>';

                    $new_data = $this->dbcommon->mail_format($title, $content);
                    $new_data = $this->parser->parse_string($new_data, $parser_data, '1');
                    if (send_mail($user->email_id, 'Reset Password', $new_data)) {
                        $result['msg'] = 'The reset password mail was sent successfully.';
                        $result['msg_class'] = 'alert-success';
                        $this->load->view('admin/users/forget_password', $result);
                    } else {
                        $result['msg'] = 'Mail sending failed, Please try again';
                        $result['msg_class'] = 'alert-info';
                        $this->load->view('admin/users/forget_password', $result);
                    }
                else:
                    $result['msg'] = 'Sorry! There is not any User register with this email address.';
                    $result['msg_class'] = 'alert-info';
                    $this->load->view('admin/users/forget_password', $result);
                endif;
            }
        }
    }

    public function reset_password() {
        $data = array();
        $data['page_title'] = 'Reset Password';

        if ($this->uri->segment(1) == 'admin' && $this->session->userdata('user') != '')
            redirect('admin/home');
        else {
            if (isset($_POST['submit']) && $_POST['submit'] == 'reset'):
                if (!empty($_POST['ident']) && !empty($_POST['activate'])) :
                    $userId = $_POST['ident'];
                    $activateKey = $_POST['activate'];
                    $where = " where user_id='" . $userId . "'";
                    $user = $this->dblogin->isExist($where);
                    if (!empty($user)):
                        $thekey = $this->my_encryption->safe_b64encode($user->password);
                        if ($thekey == $activateKey):
                            $password = $_POST['password'];
                            $new_password = md5($password);
                            $data = array('password' => $new_password);
                            $array = array('user_id' => $user->user_id);
                            $result = $this->dbcommon->update('user', $array, $data);
                            $this->session->set_flashdata(array('msg' => 'Your password change successfully', 'class' => 'alert-success'));
                            redirect('admin/users/login');
                        else:
                            $data['msg'] = 'Your password not change...';
                            $data['ident'] = $userId;
                            $data['activate'] = $activateKey;
                            $this->load->view('admin/users/reset_password', $data);
                        endif;
                    else:
                        $data['msg'] = 'Your password not change...';
                        $data['ident'] = $userId;
                        $data['activate'] = $activateKey;
                        $this->load->view('admin/users/reset_password', $data);
                    endif;
                endif;
            else:
                if (isset($_GET['ident']) && isset($_GET['activate'])):
                    $data['ident'] = $_GET['ident'];
                    $data['activate'] = $_GET['activate'];
                    $this->load->view('admin/users/reset_password', $data);
                else:
                    redirect('admin/users/login');
                endif;
            endif;
        }
    }

    public function profile() {

        $data = array();
        $data['page_title'] = 'My Profile';
        $current_user = $this->session->userdata('user');

        $where = " where user_id='" . $current_user->user_id . "'";
        $user = $this->dbcommon->getdetails('user', $where);
        $data['user'] = $user;
        $data['country'] = $this->dbcommon->select('country');
        $where = "country_id=4";
        $data['state'] = $this->dbcommon->filter('state', $where);

        if (!empty($_POST)) {

            $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[3]|max_length[30]');

            if (isset($_REQUEST['nick_name']) && !empty($_REQUEST['nick_name']))
                $this->form_validation->set_rules('nick_name', 'Nickname', 'min_length[3]|max_length[30]|alpha_numeric');

            $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email|max_length[250]');
            $this->form_validation->set_rules('phone', 'Phone No.', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/users/profile', $data);
            } else {
                // check record exist
                $where = " where user_id != '" . $user[0]->user_id . "'and (email_id ='" . addslashes($_POST['email_id']) . "' or username ='" . $_POST['username'] . "')";
                $check_user = $this->dblogin->isExist($where);
                $picture = $user[0]->cover_picture;
                if (empty($check_user)) {

                    /* if (isset($_FILES['cover_picture']['tmp_name']) && $_FILES['cover_picture']['tmp_name'] != '') {
                      $target_dir = document_root . cover;
                      $cover_picture = $_FILES['cover_picture']['name'];
                      $ext = explode(".", $_FILES["cover_picture"]['name']);
                      $picture = time() . "." . end($ext);
                      $target_file = $target_dir . "original/" . $picture;
                      $uploadOk = 1;
                      $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                      // Allow certain file formats
                      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                      $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                      $uploadOk = 0;
                      $data['msg_class'] = 'alert-info';
                      $this->load->view('admin/users/profile', $data);
                      }
                      if ($uploadOk == 0) {
                      $data['msg'] = "Sorry, your file was not uploaded.";
                      $data['msg_class'] = 'alert-info';
                      $this->load->view('admin/users/profile', $data);
                      } else {
                      if (move_uploaded_file($_FILES["cover_picture"]["tmp_name"], $target_file)) {
                      $this->load->library('thumbnailer');
                      $this->thumbnailer->prepare($target_file);
                      list($width, $height, $type, $attr) = getimagesize($target_file);

                      $thumb = $target_dir . "small/" . $picture;
                      $this->dbcommon->crop_store_cover_image($target_file, store_cover_small_thumb_width, store_cover_small_thumb_height, $thumb, 'small', $picture);

                      $thumb = $target_dir . "medium/" . $picture;
                      $this->dbcommon->crop_store_cover_image($target_file, store_cover_medium_thumb_width, store_cover_medium_thumb_height, $thumb, 'medium', $picture);
                      @unlink($target_dir . "original/" . $user[0]->cover_picture);
                      @unlink($target_dir . "medium/" . $user[0]->cover_picture);
                      @unlink($target_dir . "small/" . $user[0]->cover_picture);
                      }
                      }
                      } */
                    $data = array(
                        'username' => $_POST['username'],
                        'nick_name' => $_POST['nick_name'],
                        'email_id' => $_POST['email_id'],
                        'password' => !empty($_POST['password']) ? md5($_POST['password']) : $user[0]->password,
                        'phone' => $_POST['phone'],
                        'contact_number' => $_POST['phone'],
                        'address' => $_POST['address'],
                        'state' => $_POST['state'],
                        // 'cover_picture' => $picture,
                        'chat_notification' => $_POST['chat_notification'],
                        'update_from' => 'web'
                    );
                    $array = array('user_id' => $current_user->user_id);

                    if ($user[0]->user_role == 'storeUser') {
                        $data['facebook_social_link'] = $_POST['facebook_social_link'];
                        $data['twitter_social_link'] = $_POST['twitter_social_link'];
                        $data['instagram_social_link'] = $_POST['instagram_social_link'];
                    }

                    $result = $this->dbcommon->update('user', $array, $data);

                    $where = " where user_id='" . $current_user->user_id . "'";
                    $user = $this->dblogin->isExist($where);
                    if ($user) {
                        $this->session->set_userdata('user', $user);
                        $this->session->set_flashdata(array('msg' => 'Profile updated successfully', 'class' => 'alert-success'));
                        redirect('admin/users/profile');
                    }
                } else {
                    $data['msg'] = 'User already exist with same email / username.';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/users/profile', $data);
                }
            }
        } else {
            $msg = $this->session->flashdata('msg');
            if (!empty($msg)) {
                $data['msg'] = $this->session->flashdata('msg');
                $data['msg_class'] = $this->session->flashdata('class');
            }
            $this->load->view('admin/users/profile', $data);
        }
    }

    public function change_picture() {
        $current_user = $this->session->userdata('user');
        $where = " where user_id='" . $current_user->user_id . "'";
        $user = $this->dbcommon->getdetails('user', $where);
        if (!empty($user[0])):
            if (isset($_FILES['profile_picture']['tmp_name']) && $_FILES['profile_picture']['tmp_name'] != '') {
                $target_dir = document_root . profile;
                $profile_picture = $_FILES['profile_picture']['name'];
                $ext = explode(".", $_FILES["profile_picture"]['name']);
                $picture = time() . "." . end($ext);
                $target_file = $target_dir . "original/" . $picture;
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                $imageFileType = strtolower($imageFileType);
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                    $this->load->view('admin/users/signup', $data);
                }
                if ($uploadOk == 0) {
                    $data['msg'] = "Sorry, your file was not uploaded.";
                    $this->load->view('admin/users/signup', $data);
                } else {
                    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                        $this->load->library('thumbnailer');
                        $this->thumbnailer->prepare($target_file);
                        list($width, $height, $type, $attr) = getimagesize($target_file);
                        @unlink($target_dir . "original/" . $user[0]->profile_picture);
                        /* Image Processing */
                        $thumb = $target_dir . "small/" . $picture;
                        if ($width < $height) {
                            if ($width < profile_thumb_width) {
                                copy($target_file, $thumb);
                            } else {
                                $this->thumbnailer->thumbSymmetric(profile_thumb_width)->save($thumb);
                            }
                        } else {
                            if ($height < profile_thumb_height) {
                                copy($target_file, $thumb);
                            } else {
                                $small = $this->thumbnailer->thumbSymmetricHeight(profile_thumb_height)->save($thumb);
                            }
                        }
                        $medium = $target_dir . "medium/" . $picture;
                        if ($width < $height) {
                            if ($width < profile_medium_thumb_width) {
                                copy($target_file, $medium);
                            } else {
                                $this->thumbnailer->thumbSymmetric(profile_medium_thumb_width)->save($medium);
                            }
                        } else {
                            if ($height < profile_medium_thumb_height) {
                                copy($target_file, $medium);
                            } else {
                                $small = $this->thumbnailer->thumbSymmetricHeight(profile_medium_thumb_height)->save($medium);
                            }
                        }
                        @unlink($target_dir . "small/" . $user[0]->profile_picture);
                        @unlink($target_dir . "medium/" . $user[0]->profile_picture);
                    }
                }
                $data = array('profile_picture' => $picture);
                $array = array('user_id' => $user[0]->user_id);
                $result = $this->dbcommon->update('user', $array, $data);

                $where = " where user_id= " . $user[0]->user_id;
                $user = $this->dblogin->isExist($where);
                if ($user) {
                    $this->session->set_userdata('user', $user);
                    $this->session->set_flashdata(array('msg' => 'Profile picture updated successfully', 'class' => 'alert-success'));
                    redirect('admin/users/profile');
                }
            }
        endif;
    }

    public function verify() {
        if (isset($_GET['ident']) && isset($_GET['activate'])):
            $userId = $_GET['ident'];
            $activate = $_GET['activate'];
            $where = " where user_id='" . $userId . "'";
            $user = $this->dblogin->isExist($where);
            $thekey = $this->my_encryption->safe_b64encode($user->email_id);
            if ($activate == $thekey):
                $data = array('status' => 'active');
                $array = array('user_id' => $user->user_id);
                $result = $this->dbcommon->update('user', $array, $data);
                $this->session->set_flashdata(array('msg' => 'Verified Successfully', 'class' => 'alert-success'));
                redirect('admin/users/login');
            else:
                redirect('admin/users/login');
            endif;
        else:
            redirect('admin/users/login');
        endif;
    }

    public function signout() {
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('listing_filter');
        $this->session->unset_userdata('listing_country');
        $this->session->unset_userdata('listing_state');
        $this->session->unset_userdata('listing_category');
        $this->session->unset_userdata('listing_sub_category');
        $this->session->unset_userdata('listing_status');
        $this->session->unset_userdata('listing_oth_status');
        $this->session->unset_userdata('listing_date');
        $this->session->unset_userdata('listing_userid');

        $this->session->unset_userdata('spam_filter');
        $this->session->unset_userdata('spam_country');
        $this->session->unset_userdata('spam_state');
        $this->session->unset_userdata('spam_category');
        $this->session->unset_userdata('spam_sub_category');
        $this->session->unset_userdata('spam_date');

        $this->session->unset_userdata('repost_filter');
        $this->session->unset_userdata('repost_country');
        $this->session->unset_userdata('repost_state');
        $this->session->unset_userdata('repost_category');
        $this->session->unset_userdata('repost_sub_category');
        $this->session->unset_userdata('repost_status');
        $this->session->unset_userdata('repost_oth_status');
        $this->session->unset_userdata('repost_date');

        $this->session->unset_userdata('repost_userid');
        $this->session->unset_userdata('admin_modules_permission');

        //$this->session->sess_destroy();
        redirect('admin/users/login');
    }

    public function check_username_exist() {

        $where = ' user_id from user where user_id<>' . (int) $_POST['user_id'] . ' and username="' . $_POST['user_username'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_username_exist', 'Username already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_subdomain_name() {

        $where = ' store_id from store where store_domain="' . $_POST['store_domain'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_subdomain_name', 'Subdomain name already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_store_name() {

        $where = ' store_id from store where store_name="' . $_POST['store_name'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_store_name', 'Store name already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_company_name() {

        $where = ' id from offer_user_company where company_name="' . $_POST['company_name'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_company_name', 'Company name already exists');
            return false;
        } else {
            return true;
        }
    }

    public function add_user() {

        $data = array();
        $data['page_title'] = 'Add User';
        $location = $this->dbcommon->select('country');
        $data['location'] = $location;

        $nationality = $this->dbcommon->select_orderby('nationality', 'name', 'asc');
        $data['nationality'] = $nationality;

        if ($this->uri->segment(4) == 'offerUser')
            $query = ' FIND_IN_SET(2, category_type) > 0 order by cat_order';
        elseif ($this->uri->segment(4) == 'storeUser')
            $query = ' FIND_IN_SET(1, category_type) > 0 order by cat_order';
        else
            $query = ' 0=0 order by cat_order';

        $category = $this->dbcommon->filter('category', $query);
        $data['category'] = $category;

        $user = $this->session->userdata('user');

        if (!empty($_POST)):

            $flag = 0;
            // validation
            if (isset($_REQUEST['user_role']) && $_REQUEST['user_role'] == 'storeUser') {

                $this->form_validation->set_rules('store_domain', 'Store sub-domain', 'trim|required|min_length[3]|max_length[20]|callback_check_subdomain_name|alpha_numeric');
                $this->form_validation->set_rules('store_name', 'Store Name', 'trim|required|callback_check_store_name');
                $this->form_validation->set_rules('store_status', 'Active / Hold', 'trim|required');
                $this->form_validation->set_rules('store_is_inappropriate', 'Status', 'trim|required');
//                $this->form_validation->set_rules('shipping_cost', 'Shipping Cost', 'trim|required');
//                $this->form_validation->set_rules('paypal_email_id', 'Paypal Email Id', 'trim|valid_email');
            }

            if (isset($_REQUEST['user_role']) && $_REQUEST['user_role'] == 'offerUser') {
                $flag = 1;
                $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|callback_check_company_name');
                $this->form_validation->set_rules('company_status', 'Active / Hold', 'trim|required');
                $this->form_validation->set_rules('company_is_inappropriate', 'Status', 'trim|required');
            } else {
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
                $this->form_validation->set_rules('email_id', 'Email', 'trim|required|valid_email|max_length[50]');
                $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[30]|alpha_numeric');
            }
            if (isset($_REQUEST['nick_name']) && !empty($_REQUEST['nick_name']))
                $this->form_validation->set_rules('nick_name', 'Nickname', 'min_length[3]|max_length[30]|alpha_numeric');

//            $this->form_validation->set_rules('password', 'Password', 'trim|alpha_numeric|min_length[6]|max_length[15]|matches[cnfpassword]');
//            $this->form_validation->set_rules('cnfpassword', 'Password Confirmation', 'required');
//            $this->form_validation->set_rules('country', 'Country selection', 'required');
//            $this->form_validation->set_rules('state', 'Emirate selection', 'required');
//            $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');
//            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == FALSE):
                $this->load->view('admin/users/signup', $data);
            else:

                $picture = '';
                if (isset($_FILES['company_image']['tmp_name']) && $_FILES['company_image']['tmp_name'] != '') {
                    $target_dir = document_root . company_logo;
                    $profile_picture = $_FILES['company_image']['name'];
                    $ext = explode(".", $_FILES["company_image"]['name']);
                    $picture = time() . "." . end($ext);
                    $target_file = $target_dir . "original/" . $picture;
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    $imageFileType = strtolower($imageFileType);
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $data['msg_class'] = 'alert-info';
                        $uploadOk = 0;
                        $this->load->view('admin/users/signup', $data);
                    }
                    if ($uploadOk == 0) {
                        $data['msg'] = "Sorry, your file was not uploaded.";
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/users/signup', $data);
                    } else {
                        if (move_uploaded_file($_FILES["company_image"]["tmp_name"], $target_file)) {
                            $thumb = $target_dir . "medium/" . $picture;
                            $this->dbcommon->crop_product_image($target_file, 150, 150, $thumb, 'small', $picture);
                        }
                    }
                }

                // check record exist
//                echo $flag;
                if ($flag == 0) {
                    $where = " where email_id='" . addslashes($_POST['email_id']) . "' or username='" . $_POST['username'] . "'";
                    $user = $this->dblogin->isExist($where);
                }

//                print_r($user);exit;

                if (empty($user) || $flag == 1):

                    $from_date = date('Y-m-d');
                    $to_date = date('Y-m-d', strtotime("+1 months", strtotime($from_date)));

                    $query_settings = '';
                    if ($this->uri->segment(4) == 'generalUser')
                        $query_settings = ' id=3 and `key`="no_of_post_month_classified_user" limit 1';
                    elseif ($this->uri->segment(4) == 'offerUser')
                        $query_settings = ' id=11 and `key`="no_of_post_month_offer_user" limit 1';
                    elseif ($this->uri->segment(4) == 'storeUser')
                        $query_settings = ' id=9 and `key`="no_of_post_month_store_user" limit 1';

                    if ($query_settings != '') {
                        $ads_cnt = $this->dbcommon->filter('settings', $query_settings);

                        if ($ads_cnt[0]['val'] > 0)
                            $cnt_ads = $ads_cnt[0]['val'];
                        else
                            $cnt_ads = default_no_of_ads;
                    } else
                        $cnt_ads = default_no_of_ads;

                    $slug_email_id = $_POST['email_id'];

                    if (isset($_POST['company_name']) && $this->uri->segment(4) == 'offerUser')
                        $get_char_slug = $_POST['company_name'];
                    else
                        $get_char_slug = $_POST['username'];
                    if (isset($_POST['password']) && $_POST['password'] != '')
                        $password = md5($_POST['password']);
                    else
                        $password = '';

                    $user_slug = $this->dbcommon->generate_slug($get_char_slug, 'U');

                    $data = array(
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'email_id' => $_POST['email_id'],
                        'phone' => $_POST['phone'],
                        'contact_number' => $_POST['phone'],
                        'nick_name' => $_POST['nick_name'],
                        'username' => $_POST['username'],
                        'password' => $password,
                        'gender' => $_POST['gender'],
                        'date_of_birth' => $_POST['date_of_birth'],
                        'nationality' => $_POST['nationality'],
                        'country' => $_POST['country'],
                        'state' => $_POST['state'],
                        'address' => $_POST['user_address'],
                        'user_role' => (in_array($this->uri->segment(4), array('storeUser', 'offerUser'))) ? $this->uri->segment(4) : 'generalUser',
                        'insert_from' => 'web',
                        'is_delete' => 0,
                        'userTotalAds' => $cnt_ads,
                        'userAdsLeft' => $cnt_ads,
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'status' => ($this->uri->segment(4) == 'offerUser') ? 'active' : 'inactive',
                        'user_slug' => $user_slug
                    );

                    if ($this->uri->segment(4) == 'storeUser') {

                        $data['facebook_social_link'] = $_POST['facebook_social_link'];
                        $data['twitter_social_link'] = $_POST['twitter_social_link'];
                        $data['instagram_social_link'] = $_POST['instagram_social_link'];
//                        $data['paypal_email_id'] = $_POST['paypal_email_id'];
                    }

                    if ($this->uri->segment(4) == 'offerUser') {

                        $data['facebook_social_link'] = $_POST['company_facebook_social_link'];
                        $data['twitter_social_link'] = $_POST['company_twitter_social_link'];
                        $data['instagram_social_link'] = $_POST['company_instagram_social_link'];
                        $data['website_url'] = $_POST['website_url'];
                    }

                    $result = $this->dblogin->insert($data);

                    if ($result):
                        $username = $_POST['username'];
                        $user_id = $this->dblogin->getLastInserted();

                        if ($this->uri->segment(4) == 'offerUser') {

                            $in_companydata = array(
                                'user_id' => $user_id,
                                'company_name' => $_POST['company_name'],
                                'company_description' => $_POST['company_description'],
                                'meta_title' => $_POST['company_meta_title'],
                                'meta_description' => $_POST['company_meta_description'],
                                'company_status' => $_POST['company_status'],
                                'created_by' => $user->user_id,
                                'company_is_inappropriate' => $_POST['company_is_inappropriate'],
                                'is_delete' => 0,
                                'company_logo' => $picture,
                                'offer_category_id' => $_POST['offer_category_id']
                            );

                            if (isset($_POST['company_is_inappropriate']) && $_POST['company_is_inappropriate'] == 'Approve') {
                                $in_companydata['company_approved_on'] = date('y-m-d H:i:s');
                            }
                            $this->dbcommon->insert('offer_user_company', $in_companydata);
                        }

                        if ($this->uri->segment(4) == 'storeUser') {

                            $store_cover_image = '';
                            if (isset($_FILES['store_cover_image']['tmp_name']) && $_FILES['store_cover_image']['tmp_name'] != '') {

                                $target_dir = document_root . store_cover;
                                $profile_picture = $_FILES['store_cover_image']['name'];
                                $ext = explode(".", $_FILES["store_cover_image"]['name']);
                                $store_cover_image = time() . "." . end($ext);
                                $target_file = $target_dir . "original/" . $store_cover_image;
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                $imageFileType = strtolower($imageFileType);
                                // Allow certain file formats
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $data['msg_class'] = 'alert-info';
                                    $uploadOk = 0;
                                    $this->load->view('admin/users/signup', $data);
                                }
                                if ($uploadOk == 0) {
                                    $data['msg'] = "Sorry, your file was not uploaded.";
                                    $data['msg_class'] = 'alert-info';
                                    $this->load->view('admin/users/signup', $data);
                                } else {
                                    if (move_uploaded_file($_FILES["store_cover_image"]["tmp_name"], $target_file)) {

                                        $upload_status = 1;
                                        $this->load->library('thumbnailer');
                                        $this->thumbnailer->prepare($target_file);
                                        list($width, $height, $type, $attr) = getimagesize($target_file);

                                        /* Image Processing */
                                        $thumb = $target_dir . "small/" . $store_cover_image;
                                        $this->dbcommon->crop_store_cover_image($target_file, store_cover_small_thumb_width, store_cover_small_thumb_height, $thumb, 'small', $store_cover_image);


                                        $thumb = $target_dir . "medium/" . $store_cover_image;
                                        $this->dbcommon->crop_store_cover_image($target_file, store_cover_medium_thumb_width, store_cover_medium_thumb_height, $thumb, 'medium', $store_cover_image);
                                    }
                                }
                            }

                            if (isset($_POST['store_details_verified']) && $_POST['store_details_verified'] == '1') {
                                $verified = 1;
                                $new_verified = 0;
                            } else {
                                $verified = 0;
                                $new_verified = 1;
                            }

                            $in_storedata = array(
                                'store_owner' => $user_id,
                                'category_id' => $_POST['category_id'],
                                'sub_category_id' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $_POST['sub_category_id'] : 0,
                                'store_domain' => str_replace('.', '', $_POST['store_domain']),
                                'store_name' => $_POST['store_name'],
                                'store_description' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $_POST['store_description'] : '',
                                'meta_title' => $_POST['meta_title'],
                                'meta_description' => $_POST['meta_description'],
                                'store_status' => $_POST['store_status'],
                                'store_details_verified' => $verified,
                                'store_is_inappropriate' => $_POST['store_is_inappropriate'],
                                'store_cover_image' => $store_cover_image,
                                'new_data_status' => $new_verified,
//                                'shipping_cost' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $_POST['shipping_cost'] : '',
                                'commission_on_purchase_from_store' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $_POST['commission_on_purchase_from_store'] : '',
                                'website_url' => (isset($_POST['category_id']) && (int) $_POST['category_id'] == 0) ? $this->input->post('website_url') : ''
                            );

                            $this->dbcommon->insert('store', $in_storedata);
                            $store_id = $this->db->insert_id();
                            $in_storedata = array(
                                'store_owner' => $user_id,
                                'category_id' => $_POST['category_id'],
                                'sub_category_id' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $_POST['sub_category_id'] : 0,
                                'store_domain' => str_replace('.', '', $_POST['store_domain']),
                                'store_name' => $_POST['store_name'],
                                'store_description' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $_POST['store_description'] : '',
                                'meta_title' => $_POST['meta_title'],
                                'meta_description' => $_POST['meta_description'],
                                'store_status' => $_POST['store_status'],
                                'store_details_verified' => $verified,
                                'store_is_inappropriate' => $_POST['store_is_inappropriate'],
                                'store_cover_image' => $store_cover_image,
                                'store_id' => $store_id,
                                'website_url' => (isset($_POST['category_id']) && (int) $_POST['category_id'] == 0) ? $this->input->post('website_url') : ''
                            );
                            $this->dbcommon->insert('store_new_details', $in_storedata);
                        }

                        if ($this->uri->segment(4) != 'offerUser') {
                            $email_id = $_POST['email_id'];
                            $activate_key = $this->my_encryption->safe_b64encode($email_id);
                            $button_link = base_url() . "registration/verify?ident=" . $user_id . "&activate=" . $activate_key;
                            $button_label = 'Click here to confirm your account';
                            $title = 'Thank you for joining us!';

                            $content = '
            <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;">                        
                            <h3>Account Confirmation</h3><strong>Username:</strong>
                                            ' . $username . '
                                            <p style="margin: 1em 0;">
                                            <strong>E-mail:</strong>
                                            <a href="mailto:' . $email_id . '" style="color: #000000 !important;">' . $email_id . '</a></p>
        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>';


                            $new_data = $this->dbcommon->mail_format($title, $content);
                            $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

                            if (send_mail($email_id, 'Signup | Verification', $new_data, 'info@doukani.com')) {
                                $this->session->set_flashdata(array('msg' => 'The Verification mail sent successfully.', 'class' => 'alert-success'));
                                redirect('admin/users/index/' . $this->uri->segment(4));
                            } else {

                                $data['msg'] = 'Verification mail sending failed, Please try again';
                                $data['msg_class'] = 'alert-info';
                                redirect('admin/users/index/' . $this->uri->segment(4));
                            }
                        } else {
                            $this->session->set_flashdata(array('msg' => 'User Registered successfully.', 'class' => 'alert-success'));
                            redirect('admin/users/index/' . $this->uri->segment(4));
                        }
                    endif;
                else:
                    $data['msg'] = 'User already exist with same email/username.';
                    $data['msg_class'] = 'alert-info';
                    $this->load->view('admin/users/signup', $data);
                endif;
            endif;
        else:
            $this->load->view('admin/users/signup', $data);
        endif;
    }

    public function edit($user_id = null) {

        $data = array();
        $data['page_title'] = 'Edit User';
        $where = " where user_id='" . $user_id . "'";
        $user = $this->dbcommon->getdetails('user', $where);

        $nationality = $this->dbcommon->select_orderby('nationality', 'name', 'asc');
        $data['nationality'] = $nationality;

        $location = $this->dbcommon->select('country');
        $data['country'] = $location;

        $where = " country_id='" . $user[0]->country . "'";
        $state = $this->dbcommon->filter('state', $where);
        $data['state'] = $state;

        if ($user_id != null && !empty($user)):
            $data['user'] = $user;
            if (!empty($_POST)):

                if ($user[0]->user_role != 'offerUser') {
                    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
                    $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
                    $this->form_validation->set_rules('user_username', 'Username', 'required|min_length[3]|max_length[30]|callback_check_username_exist|alpha_numeric');
                }
//                $this->form_validation->set_rules('user_phone', 'Phone', 'required');
//                $this->form_validation->set_rules('user_country', 'Country', 'required');
//                $this->form_validation->set_rules('user_state', 'Emirate', 'required');
//                $this->form_validation->set_rules('date_of_birth', 'Birth date', 'required');
//                $this->form_validation->set_rules('paypal_email_id', 'Paypal Email Id', 'trim|valid_email');

                if (isset($_REQUEST['nick_name']) && !empty($_REQUEST['nick_name']))
                    $this->form_validation->set_rules('nick_name', 'Nickname', 'min_length[3]|max_length[30]|alpha_numeric');

                if (isset($_POST['password']) && !empty($_POST['password'])) {
                    $this->form_validation->set_rules('password', 'Password', 'trim|alpha_numeric|min_length[6]|max_length[15]|matches[confirm_password]');

                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
                }

                if ($this->form_validation->run() == FALSE):
                    $this->load->view('admin/users/edit', $data);
                else:
                    if (isset($_POST['notification']))
                        $notification = 1;
                    else
                        $notification = 0;

                    $data = array(
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'username' => $_POST['user_username'],
                        'nick_name' => $_POST['nick_name'],
//                        'paypal_email_id' => $_POST['paypal_email_id'],
                        'address' => $_POST['user_address'],
                        'phone' => $_POST['user_phone'],
                        'contact_number' => $_POST['user_phone'],
                        'gender' => $_POST['gender'],
                        'nationality' => $_POST['nationality'],
                        'date_of_birth' => $_POST['date_of_birth'],
                        'city' => '',
                        'state' => $_POST['user_state'],
                        'country' => $_POST['user_country'],
                        'userTotalAds' => (int) $_POST['tot_ad'] + (int) $_POST['add_ad'],
                        'userAdsLeft' => (int) $_POST['left_ads'] + (int) $_POST['add_ad'],
                        'chat_notification' => $notification,
                    );

                    if (in_array($user[0]->user_role, array('storeUser', 'offerUser'))) {

                        $data['facebook_social_link'] = $_POST['facebook_social_link'];
                        $data['twitter_social_link'] = $_POST['twitter_social_link'];
                        $data['instagram_social_link'] = $_POST['instagram_social_link'];
                    }
                    if (!empty($_POST['password'])) {
                        $data['password'] = md5($_POST['password']);
                    }

                    if (isset($_POST['status'])) {
                        $data['status'] = $_POST['status'];
                    }

                    $array = array('user_id' => $user[0]->user_id);
                    $result = $this->dbcommon->update('user', $array, $data);
                    if ($result):
                        $this->session->set_flashdata(array('msg' => 'User updated successfully', 'class' => 'alert-success'));

                        $redirect = $_SERVER['QUERY_STRING'];
                        if (!empty($_SERVER['QUERY_STRING']))
                            $redirect = '/?' . $redirect;
                        redirect('admin/users/index/' . $user[0]->user_role . $redirect);
                    else:
                        $data['msg'] = 'User not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/users/edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/users/edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'User not found', 'class' => 'alert-info'));
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect('admin/users/index/' . $redirect);
        endif;
    }

    public function view($user_id = null) {

        $data = array();
        $data['page_title'] = 'View User';
        $where = " where user_id='" . $user_id . "'";
        $user = $this->dbcommon->getdetails('user', $where);

        $sql = $this->db->query("select u.*,u.address,u.state,   u.city,u.username,u.country,u.user_id,u.email_id,u.phone,u.user_block,u.user_register_date, u.device_identifier,u.device_type,u.userAdsLeft,u.user_role,u.userTotalAds currtotads,u.userAdsLeft currleftads, sum(uod.total_ads-uod.ads_left)+(u.userTotalAds-u.userAdsLeft) as totalpostedads ,sum(uod.total_ads+u.userTotalAds) as totalads
					from user u
					left join user_old_data uod on uod.user_id=u.user_id
					where u.user_register_date<>'0000-00-00 00:00:00' and u.user_id=" . (int) $user_id . " group by u.user_id");
        //u.user_role='generalUser' and      
        $res = $sql->row_array();

        $nationality = $this->dbcommon->select('nationality');
        $data['nationality'] = $nationality;

        $location = $this->dbcommon->select('country');
        $data['country'] = $location;
        $where = " country_id='" . $res['country'] . "'";

        $state = $this->dbcommon->filter('state', $where);
        $data['state'] = $state;

        if ($user_id != null && !empty($user)):
            $data['user'] = $res;
            $this->load->view('admin/users/view', $data);
        else:
            $this->session->set_flashdata(array('msg' => 'User not found', 'class' => 'alert-info'));
            redirect('admin/users/index/generalUser');
        endif;
    }

    public function delete($user_id = NULL, $url = NULL) {

        $redirect_url = '';
        $user_role = 'generalUser';

        if ($this->input->post("checked_val") != '') {
            $user_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $user_id);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $user_id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $success = 0;
        $users = $this->db->query('select u.user_id,u.user_role from user u
                                left join store s on s.store_owner=u.user_id
                                left join offer_user_company o on o.user_id=u.user_id
                                where u.user_id in (' . $comma_ids . ') group by u.user_id')->result_array();

        foreach ($users as $key => $u) {

            if ($key == 0)
                $user_role = $u['user_role'];

            $user_id = $u['user_id'];
            if ($u['user_role'] == 'storeUser') {
                $data = array('store_status' => 1);
                $array = array('store_owner' => $u['user_id']);
                $result = $this->dbcommon->update('store', $array, $data);
            } elseif ($u['user_role'] == 'offerUser') {

                $data = array('company_status' => 1);
                $array = array('user_id' => $u['user_id']);
                $result = $this->dbcommon->update('offer_user_company', $array, $data);

                $data = array('is_delete' => 1);
                $array = array('offer_user_company_id' => $u['user_id']);
                $result = $this->dbcommon->update('offers', $array, $data);
            }

            $where = array("user_id" => $user_id);
            $update = array("is_delete" => 1);
            $this->dbcommon->update('user', $where, $update);

            if (in_array($u['user_role'], array('storeUser', 'generalUser'))) {
                $where1 = array("product_posted_by" => $user_id);
                $update1 = array("is_delete" => 1);
                $this->dbcommon->update('product', $where1, $update1);
            }
            $success++;
        }

        if ($success > 0) {
            $this->session->set_flashdata(array('msg' => 'User(s) deleted successfully', 'class' => 'alert-success'));
            redirect('admin/users/index/' . $user_role . '/' . $redirect_url);
        } else {
            $this->session->set_flashdata(array('msg' => 'User(s) not found', 'class' => 'alert-info'));
            redirect('admin/users/index/' . $user_role . '/' . $redirect_url);
        }
    }

    public function show_emirates() {
        if ($this->input->post("value") != '')
            $value = $this->input->post("value");
        else
            $value = 4;

        $query = "country_id= " . $value;
        $main_data['state'] = $this->dbcommon->filter('state', $query);

        echo $this->load->view('admin/users/show_state', $main_data, TRUE);
        exit;
    }

    public function send_message_to_seller() {
        $response = $this->dbcommon->send_mail_seller();
        echo json_encode($response);
        exit;
    }

    //block user's product list
    function block_list($user_id = NULL) {

        $data = array();
        $data['page_title'] = 'User\'s Product Block List';
        $url = site_url() . 'admin/users/block_list/' . $user_id;

        $res = $this->db->query('select email_id,username,user_role from user where user_id=' . (int) $this->uri->segment(4))->row();

        if (isset($res) && sizeof($res) > 0) {
            $data['email_id'] = $res->email_id;
            $data['username'] = (!empty($res->nickname)) ? $res->nickname : $res->username;

            if ($res->user_role == 'offerUser') {
                $query = "  *  FROM offers as o where is_delete=2 and offer_user_company_id=" . (int) $user_id;
                $data["links"] = $this->dbcommon->pagination($url, $query);

                $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
                $offset = ($page == 0) ? 0 : ($page - 1) * $this->per_page;
                $query = ' select ' . $query . ' order by offer_id desc limit ' . $offset . ',' . $this->per_page;

                $offers = $this->dbcommon->get_distinct($query);
                $data['offers'] = $offers;

                echo $this->load->view('admin/users/offers_list', $data, TRUE);
            } else {
                $query = "  p.product_id,p.product_is_sold,p.product_deactivate,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate , 
                        c.catagory_name  FROM product as p  left join category as c on c.category_id=p.category_id left join sub_category as sc on sc.sub_category_id=p.sub_category_id where p.category_id=c.category_id and is_delete=2 and product_posted_by=" . (int) $user_id;

                $data["links"] = $this->dbcommon->pagination($url, $query);

                $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
                $offset = ($page == 0) ? 0 : ($page - 1) * $this->per_page;
                $query = ' select ' . $query . ' order by product_id desc limit ' . $offset . ',' . $this->per_page;

                $product = $this->dbcommon->get_distinct($query);
                $data['product'] = $product;
                echo $this->load->view('admin/users/product_list', $data, TRUE);
            }
        } else {
            redirect('admin/home');
        }
    }

    public function show_sub_cat() {

        $filter_val = $this->input->post("value");
        $user_role = $this->input->post('user_role');
//        $query = "category_id= '" . $filter_val . "'";

        if ($user_role == 'generalUser') {
            $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(0, sub_category_type) > 0 order by sub_cat_order asc";
        } elseif ($user_role == 'storeUser') {
            $query = "category_id= '" . $filter_val . "' AND FIND_IN_SET(1, sub_category_type) > 0 order by sub_cat_order asc";
        }

        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);

        echo $this->load->view('admin/stores/sub_cat', $main_data, TRUE);
        exit();
    }

    public function insert_featured() {

//        $pieces = explode(" to ", $_POST['from_to']);
//        $start_date = date("Y-m-d", strtotime($pieces[0]));
//        $end_date = date("Y-m-d", strtotime($pieces[1]));
        $start_date = $this->dbcommon->get_usa_time(date("Y-m-d H:i:s", strtotime($_REQUEST['from_date'])));
        $end_date = $this->dbcommon->get_usa_time(date("Y-m-d H:i:s", strtotime($_REQUEST['to_date'])));

//        $start_date = date("Y-m-d H:i:s", strtotime($_POST['from_date']));
//        $end_date = date("Y-m-d H:i:s", strtotime($_POST['to_date']));


        $checked_values = explode(",", $_POST['checked_values']);
        $user = $this->session->userdata('user');
        $user_id = $user->user_id;
        $success = 0;
        foreach ($checked_values as $val) {

            $res = $this->db->query('select * from store where store_is_inappropriate="Approve" '
                    . 'and store_status=0 and store_owner in (' . $val . ')');

            if ($res->num_rows() > 0) {
                $data = $res->result_array();

                $del_arr = array('store_id' => $data[0]['store_id']);
                $this->dbcommon->delete('featured_stores', $del_arr);

                $arra = array(
                    'store_id' => $data[0]['store_id'],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                );

                $result = $this->dbcommon->insert('featured_stores', $arra);

                $success++;
            }
        }
        if ($success > 0)
            $this->session->set_flashdata(array('msg' => 'store(s) featured successfully', 'class' => 'alert-info'));

        redirect('admin/users/index/storeUser');
    }

    public function update_unfeatured($store_id = NULL) {

        $redirect_url = '';
        $success = 0;

        if ($this->input->post("checked_val") != '') {
            $store_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $store_id);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $store_id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $result = $this->db->query('select s.store_id from featured_stores fs 
                left join store s on s.store_id=fs.store_id 
                where s.store_id in (' . $comma_ids . ')')->result_array();

        foreach ($result as $res) {

            $wh = array('store_id' => $res['store_id']);
            $this->dbcommon->delete('featured_stores', $wh);

            $success++;
        }

        if ($success > 0)
            $this->session->set_flashdata(array('msg' => 'store un-featured successfully', 'class' => 'alert-info'));

        redirect('admin/users/featured_stores/' . $redirect_url);
    }

    public function featured_stores() {

        $data = array();
        $data['page_title'] = 'Featured Store Users';
        $url = site_url() . 'admin/users/featured_stores/';

        $only_featured = NULL;
        $search = '';
        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'featured') {
            $only_featured = 'yes';
            $search = ' and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fs.start_date and fs.end_date)';
            $url .= $this->uri->segment(4) . '/';
        }

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= $this->uri->segment(4) . '/?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        $wh_count = " s.store_id FROM featured_stores as fs "
                . "left join store as s on s.store_id = fs.store_id  "
                . "left join user as u on u.user_id=s.store_owner  "
                . "where s.store_status=0 and "
                . " u.is_delete=0 and s.store_is_inappropriate='Approve' " . $search;

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;
        $data['featured_stores'] = $this->store->get_featuredstore($offset, $per_page, NULL, $only_featured);
//        echo $this->db->last_query();
        $data['url'] = $url;
        $pagination_data = $this->dbcommon->pagination($url, $wh_count, $per_page, 'yes');

        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];

        echo $this->load->view('admin/users/featured_stores', $data, TRUE);
    }

    /*
     * Make Company User As Featured
     */

    public function insert_featured_company() {

//        $pieces = explode(" to ", $_POST['from_to']);
//        $start_date = date("Y-m-d", strtotime($pieces[0]));
//        $end_date = date("Y-m-d", strtotime($pieces[1]));        
//        $start_date = date("Y-m-d H:i:s", strtotime($_POST['from_date']));
//        $end_date = date("Y-m-d H:i:s", strtotime($_POST['to_date']));

        $start_date = $this->dbcommon->get_usa_time(date("Y-m-d H:i:s", strtotime($_REQUEST['from_date'])));

        $end_date = $this->dbcommon->get_usa_time(date("Y-m-d H:i:s", strtotime($_REQUEST['to_date'])));

        $checked_values = explode(",", $_POST['checked_values_featured']);
        $success = 0;

        $user = $this->session->userdata('user');
        $user_id = $user->user_id;

        foreach ($checked_values as $val) {

            $res = $this->db->query('select * from offer_user_company where company_is_inappropriate="Approve" '
                    . 'and company_status=0 and user_id in (' . $val . ')');

            if ($res->num_rows() > 0) {
                $data = $res->result_array();

                $del_arr = array('company_user_id' => $data[0]['user_id']);
                $this->dbcommon->delete('featured_company', $del_arr);

                $arra = array(
                    'company_user_id' => $data[0]['user_id'],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                );

                $result = $this->dbcommon->insert('featured_company', $arra);

                $success++;
            }
        }
        if ($success > 0)
            $this->session->set_flashdata(array('msg' => 'Company(s) featured successfully', 'class' => 'alert-info'));

        redirect('admin/users/index/offerUser');
    }

    /*
     * Make Company User As Un-Featured
     */

    public function update_unfeatured_company($user_id = NULL) {

        $redirect_url = '';
        $success = 0;

        if ($this->input->post("checked_val") != '') {
            $user_id = explode(",", $this->input->post("checked_val"));
            $comma_ids = implode(',', $user_id);
            if (isset($_REQUEST['redirect_me']) && !empty($_REQUEST['redirect_me']))
                $redirect_url = $_REQUEST['redirect_me'];
        }
        else {
            $comma_ids = $user_id;
            $redirect_url = http_build_query($_REQUEST);
            if (!empty($redirect_url))
                $redirect_url = '?' . http_build_query($_REQUEST);
        }

        $result = $this->db->query('select o.user_id from featured_company fc 
                 left join offer_user_company o on o.user_id = fc.company_user_id  
                 where o.user_id in (' . $comma_ids . ')')->result_array();

        foreach ($result as $res) {

            $wh = array('company_user_id' => $res['user_id']);
            $this->dbcommon->delete('featured_company', $wh);
            $success++;
        }

        if ($success > 0)
            $this->session->set_flashdata(array('msg' => 'Company un-featured successfully', 'class' => 'alert-info'));

        redirect('admin/users/featured_companies/' . $redirect_url);
    }

    public function featured_companies() {

        $data = array();
        $data['page_title'] = 'Featured Offer Users';
        $url = site_url() . 'admin/users/featured_companies/';
        $search = '';
        $only_featured = NULL;

        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'featured') {
            $only_featured = 'yes';
            $search = ' and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fc.start_date and fc.end_date)';
            $url .= $this->uri->segment(4) . '/';
        }

        $wh_count = ' o.user_id
            FROM featured_company fc 
            LEFT JOIN offer_user_company o ON o.user_id=fc.company_user_id 
            LEFT JOIN user u ON u.user_id=o.user_id 
            WHERE o.company_status =0 AND  u.is_delete =0 AND 
            o.company_is_inappropriate = "Approve" ' . $search . ' GROUP BY fc.company_user_id ';

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        $data['url'] = $url;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;
        $pagination_data = $this->dbcommon->pagination($url, $wh_count, $per_page, 'yes');
        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];
        $data['featured_companies'] = $this->offer->get_featuredcompany($offset, $per_page, NULL, $only_featured);

        echo $this->load->view('admin/users/featured_company', $data, TRUE);
    }

    //use to upload profile / store cover image
    public function upload_crop_image($user_id) {

        $target_dir = $_REQUEST['target_dir'];
        $target_file = $target_dir . "thumb/" . $_POST['img_name'];

        if (file_exists(document_root . profile . 'thumb/' . $_POST['img_name'])) {

            $data = file_get_contents($target_file);
            $vImg = imagecreatefromstring($data);
            //$dstImg = imagecreatetruecolor($_REQUEST['dataWidth'], $_REQUEST['dataHeight']);

            $x = $_REQUEST['dataX'];
            $y = $_REQUEST['dataY'];
            $w = $_REQUEST['dataWidth'];
            $h = $_REQUEST['dataHeight'];

            //imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $_REQUEST['dataWidth'], $_REQUEST['dataHeight'], $w, $h);
            //for Original
            $dstImg = imagecreatetruecolor($_REQUEST['dataWidth'], $_REQUEST['dataHeight']);
            imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $_REQUEST['dataWidth'], $_REQUEST['dataHeight'], $w, $h);
            $path = $target_dir . "original/" . $_POST['img_name'];
            imagejpeg($dstImg, $path);

            //for Medium
            $nw = $nh = 100;
            $dstImg = imagecreatetruecolor($nw, $nh);
            imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
            $path = $target_dir . "medium/" . $_POST['img_name'];
            imagejpeg($dstImg, $path);

            //for small
            $nw = $nh = 50;
            $dstImg = imagecreatetruecolor($nw, $nh);
            imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
            $path = $target_dir . "small/" . $_POST['img_name'];
            imagejpeg($dstImg, $path);
            @unlink($target_dir . "thumb/" . $_POST['img_name']);

            $data = array('profile_picture' => $_POST['img_name']);
            $array = array('user_id' => $user_id);
            $result = $this->dbcommon->update('user', $array, $data);
        }

        redirect('admin/users/edit/' . $user_id);
    }

    public function edit_store($store_id = null) {

        $data = array();
        $data['page_title'] = 'Edit Store';
        $where = " where store_id='" . $store_id . "'";
        $old_store_details = $this->dbcommon->getdetails('store', $where);
        $new_store_details = $this->dbcommon->getdetails('store_new_details', $where);
        if ($store_id != null && !empty($old_store_details)):

            $where = "country_id=4";
            $state = $this->dbcommon->filter('state', $where);
            $data['state'] = $state;

            //$query   =  ' category_id="'.$store[0]->category_id.'" order by cat_order';
            $query = ' 0=0 AND FIND_IN_SET(1, category_type) > 0 order by cat_order';
            $category = $this->dbcommon->filter('category', $query);

            $query = ' category_id="' . $old_store_details[0]->category_id . '" AND FIND_IN_SET(1, sub_category_type) > 0 order by sub_cat_order';
            $sub_category = $this->dbcommon->filter('sub_category', $query);

            $data['old_store_details'] = $old_store_details;
            $data['new_store_details'] = $new_store_details;
            $data['category'] = $category;
            $data['sub_category'] = $sub_category;
            $store_owner = $old_store_details[0]->store_owner;

            $product_where = " product_id from product where product_posted_by='" . $store_owner . "'";
            $product_count = $this->dbcommon->getnumofdetails_($product_where);
            $data['product_count'] = $product_count;

            if (!empty($_POST)):
                $this->form_validation->set_rules('store_domain', 'Store sub-domain', 'trim|required|min_length[3]|max_length[20]|callback_check_edit_subdomain_name|alpha_numeric');
                $this->form_validation->set_rules('new_store_name', 'Store Name', 'trim|required|callback_check_edit_store_name');
                $this->form_validation->set_rules('store_status', 'Active / Hold Status', 'trim|required');
                $this->form_validation->set_rules('store_is_inappropriate', 'Status', 'trim|required');

                if (isset($_POST['category_id1']) && (int) $_POST['category_id1'] == 0) {
//                    $this->form_validation->set_rules('shipping_cost', 'Shipping Cost', 'trim|required');
                    $this->form_validation->set_rules('new_website_url', 'Website URL', 'trim|required');
                }

                if ($this->form_validation->run() == FALSE):
                    $this->load->view('admin/stores/edit', $data);
                else:

                    $cnt = 0;

                    if (isset($_POST['store_details_verified']) && $_POST['store_details_verified'] == '1') {
                        $verified = 1;
                        $new_verified = 0;
                        $cnt = 1;
                    } else {
                        $verified = 0;

                        if ($old_store_details[0]->new_data_status == '0')
                            $new_verified = 0;
                        else
                            $new_verified = 1;
                    }

                    $store_cover_image = $new_store_details[0]->store_cover_image;
                    $upload_status = 0;
                    if (isset($_FILES['new_store_cover_image']['tmp_name']) && $_FILES['new_store_cover_image']['tmp_name'] != '') {

                        $target_dir = document_root . store_cover;
                        $profile_picture = $_FILES['new_store_cover_image']['name'];
                        $ext = explode(".", $_FILES["new_store_cover_image"]['name']);
                        $store_cover_image = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $store_cover_image;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $imageFileType = strtolower($imageFileType);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/stores/edit', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/stores/edit', $data);
                        } else {
                            if (move_uploaded_file($_FILES["new_store_cover_image"]["tmp_name"], $target_file)) {

                                $upload_status = 1;
                                $this->load->library('thumbnailer');
                                $this->thumbnailer->prepare($target_file);
                                list($width, $height, $type, $attr) = getimagesize($target_file);

                                /* Image Processing */
                                $thumb = $target_dir . "small/" . $store_cover_image;
                                $this->dbcommon->crop_store_cover_image($target_file, store_cover_small_thumb_width, store_cover_small_thumb_height, $thumb, 'small', $store_cover_image);


                                $thumb = $target_dir . "medium/" . $store_cover_image;
                                $this->dbcommon->crop_store_cover_image($target_file, store_cover_medium_thumb_width, store_cover_medium_thumb_height, $thumb, 'medium', $store_cover_image);

                                if ($old_store_details[0]->new_data_status == 1) {

                                    @unlink($target_dir . "original/" . $new_store_details[0]->store_cover_image);
                                    @unlink($target_dir . "small/" . $new_store_details[0]->store_cover_image);
                                    @unlink($target_dir . "medium/" . $new_store_details[0]->store_cover_image);
                                } else {

                                    @unlink($target_dir . "original/" . $old_store_details[0]->store_cover_image);
                                    @unlink($target_dir . "small/" . $old_store_details[0]->store_cover_image);
                                    @unlink($target_dir . "medium/" . $old_store_details[0]->store_cover_image);
                                }

                                $wh = array('store_id' => $old_store_details[0]->store_id);
                                $image_data = array('store_cover_image' => $store_cover_image);
                                $result = $this->dbcommon->update('store', $wh, $image_data);
                                $result = $this->dbcommon->update('store_new_details', $wh, $image_data);
                            }
                        }
                    }
                    if (isset($_POST['store_status']) && $_POST['store_status'] == 3) {

                        $data1 = array('is_delete' => 3);
                        $array1 = array('user_id' => $old_store_details[0]->store_owner, 'is_delete' => 0, 'status' => 'active');
                        $result = $this->dbcommon->update('user', $array1, $data1);

                        $data2 = array('store_status' => 3);
                        $array2 = array('store_owner' => $old_store_details[0]->store_owner, 'store_status' => 0);
                        $result = $this->dbcommon->update('store', $array2, $data2);
                        $result = $this->dbcommon->update('store_new_details', $array2, $data2);

                        $up3 = array('is_delete' => 3);
                        $data3 = array('product_posted_by' => $old_store_details[0]->store_owner, 'is_delete' => 0, 'product_for' => 'store');
                        $this->dbcommon->update('product', $data3, $up3);
                    } elseif (isset($_POST['store_status']) && $_POST['store_status'] == 0) {

                        $data4 = array('is_delete' => 0);
                        $array4 = array('user_id' => $old_store_details[0]->store_owner, 'is_delete' => 3, 'status' => 'active');
                        $result = $this->dbcommon->update('user', $array4, $data4);

                        $data5 = array('store_status' => 0);
                        $array5 = array('store_owner' => $old_store_details[0]->store_owner, 'store_status' => 3);
                        $result = $this->dbcommon->update('store', $array5, $data5);
                        $result = $this->dbcommon->update('store_new_details', $array5, $data5);

                        $up6 = array('is_delete' => 0);
                        $data6 = array('product_posted_by' => $old_store_details[0]->store_owner, 'is_delete' => 3, 'product_for' => 'store');
                        $this->dbcommon->update('product', $data6, $up6);
                    }

                    $in_data = array(
                        'store_domain' => strtolower(str_replace('.', '', $_POST['store_domain'])),
                        'store_status' => $_POST['store_status'],
                        'store_modified_on' => date('Y-m-d H:i:s'),
                        'store_is_inappropriate' => $_POST['store_is_inappropriate']
                    );

                    $array = array('store_id' => $old_store_details[0]->store_id);
                    /*
                      original Store table
                     */
                    if (isset($_POST['category_id1']))
                        $in_data['category_id'] = $_POST['category_id1'];

                    if (isset($_POST['sub_category_id1']))
                        $in_data['sub_category_id'] = (isset($_POST['category_id1']) && (int) $_POST['category_id1'] > 0) ? $_POST['sub_category_id1'] : 0;

                    $in_data['website_url'] = $this->input->post('new_website_url');
                    $in_data['store_name'] = $this->input->post('new_store_name');

                    $in_data['store_description'] = $this->input->post('new_store_description');

                    $in_data['meta_title'] = $this->input->post('new_meta_title');
                    $in_data['meta_description'] = $this->input->post('new_meta_description');

                    $in_data['store_details_verified'] = $verified;
                    $in_data['new_data_status'] = $new_verified;

                    if ($old_store_details[0]->store_is_inappropriate != $_POST['store_is_inappropriate'] && $_POST['store_is_inappropriate'] == 'Approve') {
                        $in_data['store_approved_on'] = date('Y-m-d H:i:s');
                    }

                    if ($verified == 1 && $upload_status == 0)
                        $in_data['store_cover_image'] = $store_cover_image;

//                    $in_data['shipping_cost'] = (isset($_POST['category_id1']) && (int) $_POST['category_id1'] > 0) ? $this->input->post('shipping_cost') : '';
//                    $in_data['commission_on_purchase_from_store'] = (isset($_POST['category_id1']) && (int) $_POST['category_id1'] > 0) ? $this->input->post('commission_on_purchase_from_store') : '';
//                    $in_data['shipping_cost'] = $this->input->post('shipping_cost');
                    $in_data['commission_on_purchase_from_store'] = $this->input->post('commission_on_purchase_from_store');

                    $result = $this->dbcommon->update('store', $array, $in_data);
                    /*
                      store_new_details table
                     */
                    // if($old_store_details[0]->new_data_status=='1' && $verified=='1') { 
                    $up_data['store_name'] = $this->input->post('new_store_name');
                    $up_data['store_description'] = $this->input->post('new_store_description');
                    $up_data['meta_title'] = $this->input->post('new_meta_title');
                    $up_data['meta_description'] = $this->input->post('new_meta_description');
//                    }
                    if ($verified == 1 && $upload_status == 0)
                        $up_data['store_cover_image'] = $store_cover_image;

                    $result = $this->dbcommon->update('store_new_details', $array, $up_data);

                    $query = 'country_id= 4 order by sort_order';
                    $state_list = $this->dbcommon->filter('state', $query);

                    $state_count = count($state_list);
                    $user_id = $old_store_details[0]->store_owner;

                    if (isset($result)) {

                        if ($old_store_details[0]->store_is_inappropriate != $_POST['store_is_inappropriate']) {
                            $this->store->send_mail_storeuser($old_store_details[0]->store_owner, $_POST['store_is_inappropriate']);
                        }
                    }
                    if ($result):
                        $this->session->set_flashdata(array('msg' => 'Store updated successfully.', 'class' => 'alert-success'));

                        $redirect = $_SERVER['QUERY_STRING'];
                        if (!empty($_SERVER['QUERY_STRING']))
                            $redirect = '/?' . $redirect;
                        redirect('admin/users/index/storeUser' . $redirect);
                    else:
                        $data['msg'] = 'Store not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/stores/edit', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/stores/edit', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Store not found', 'class' => 'alert-info'));
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect('admin/users/index/storeUser' . $redirect);
        endif;
    }

    public function store_shipping_cost($store_id) {
        $data = array();
        $data['page_title'] = 'Store Shipping Cost';

        $where = " where store_id='" . $store_id . "'";
        $store_details = $this->dbcommon->getdetails('store', $where);
        $data['store_details'] = $store_details;

//        if($_SERVER['REMOTE_ADDR'] == '203.109.68.198') {
        $where = "is_active = 1 AND store_id = '" . $store_id . "' ";
        $shipping = $this->dbcommon->select('shipping_costs_admin', $where);
        $shipping = $shipping[0];
//        }else{
//            $where = " store_id = '" . $store_id . "' ";
//            $shipping = $this->dbcommon->select('store_shipping_cost', $where);
//        }
        $data['shipping'] = $shipping;
        if (!empty($_POST)) {
            $current_user = $this->session->userdata('gen_user');

//            if($_SERVER['REMOTE_ADDR'] == '203.109.68.198' || $_SERVER['REMOTE_ADDR'] == '202.71.5.18') {
//                pr($_POST); exit;
            $where = "is_active = 1 AND store_id = '" . $store_id . "' ";
            $shipping_cost = $this->dbcommon->select('shipping_costs_admin', $where);
//                pr($shipping_cost); exit;


            $save_shipping['max_weight'] = $this->input->post('max_weight');
            $save_shipping['cost'] = $this->input->post('cost');
            $save_shipping['cost_per_extra_kg'] = $this->input->post('cost_per_extra_kg');
            if (empty($shipping_cost)) {
                $save_shipping['created'] = date('Y-m-d H:i:s');
                $save_shipping['store_id'] = $store_id;
                $ship_db_save = $this->dbcommon->insert('shipping_costs_admin', $save_shipping);
            } else {
                $save_shipping['modified'] = date('Y-m-d H:i:s');
                $condition['id'] = $shipping_cost[0]['id'];
                $condition['store_id'] = $store_id;
                $ship_db_save = $this->dbcommon->update('shipping_costs_admin', $condition, $save_shipping);
            }
            if ($ship_db_save > 0) {
                $this->session->set_flashdata(array('msg' => 'Shipping cost updated successfully'));
            } else {
                $this->session->set_flashdata(array('msg' => 'Something went wrong. Shipping cost was not updated!'));
            }
            redirect("admin/users/store_shipping_cost/$store_id");
//            }else{
//                $i = 1;
//                foreach ($_POST as $key => $value) {
//                    //code to check store shipping cost exist or not
//                    //where 
//                    $where = " store_id = '" . $store_id . "' AND label_id = " . $i;
//                    $store_shipping = $this->dbcommon->select('store_shipping_cost', $where);
//                    if (isset($store_shipping) && sizeof($store_shipping) > 0) {
//                        $data = array(
//                            'price' => $value,
//                            'modified_by' => $current_user['user_id'],
//                            'modify_date' => date('y-m-d H:i:s', time())
//                        );
//                        $array = array('label_id' => $i , 'store_id'=> $store_id);
//                        $result = $this->dbcommon->update('store_shipping_cost', $array, $data);
//
//                    } else {
//                        //add
//                         $data = array(
//                                'price' => $value,
//                                'modified_by'=> $current_user['user_id'],
//                                'modify_date'=> date('y-m-d H:i:s', time()),
//                                'created_date'=> date('y-m-d H:i:s', time()),
//                                'label_id' => $i,
//                                'store_id' => $store_id
//
//                            );
//                            $this->dbcommon->insert('store_shipping_cost', $data);
//                    }
//
//                    $i++;
//                }
//            }




            $this->session->set_flashdata(array('msg' => 'Shipping cost updated successfully'));
            redirect("admin/users/store_shipping_cost/$store_id");
        }
        $this->load->view('admin/stores/shipping_cost', $data);
    }

    function edit_offers_company($offer_company_id = NULL) {

        $data = array();
        $data['page_title'] = 'Edit Offer Company';
        $where = " where id='" . $offer_company_id . "'";
        $company_details = $this->dbcommon->getdetails('offer_user_company', $where);

        $offer_where = " product_id from product where product_posted_by='" . $offer_company_id . "'";
        $offer_count = $this->dbcommon->getnumofdetails_($offer_where);
        $data['offer_count'] = $offer_count;

        $query = ' FIND_IN_SET(2, category_type) > 0 order by cat_order';
        $category = $this->dbcommon->filter('category', $query);
        $data['category'] = $category;

        if (!empty($company_details)):

            $data['company_details'] = $company_details;

            if (!empty($_POST)):

                $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|callback_check_edit_company_name');
                $this->form_validation->set_rules('company_status', 'Active / Hold', 'trim|required');
                $this->form_validation->set_rules('company_is_inappropriate', 'Status', 'trim|required');

                if ($this->form_validation->run() == FALSE):
                    $this->load->view('admin/users/edit_offer_company_details', $data);
                else:

                    $company_logo = $company_details[0]->company_logo;
                    $upload_status = 0;
                    if (isset($_FILES['company_logo']['tmp_name']) && $_FILES['company_logo']['tmp_name'] != '') {

                        $target_dir = document_root . company_logo;
                        $profile_picture = $_FILES['company_logo']['name'];
                        $ext = explode(".", $_FILES["company_logo"]['name']);
                        $company_logo = time() . "." . end($ext);
                        $target_file = $target_dir . "original/" . $company_logo;
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $imageFileType = strtolower($imageFileType);
                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                            $data['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $data['msg_class'] = 'alert-info';
                            $uploadOk = 0;
                            $this->load->view('admin/users/edit_offer_company_details', $data);
                        }
                        if ($uploadOk == 0) {
                            $data['msg'] = "Sorry, your file was not uploaded.";
                            $data['msg_class'] = 'alert-info';
                            $this->load->view('admin/users/edit_offer_company_details', $data);
                        } else {
                            if (move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file)) {

                                $thumb = $target_dir . "medium/" . $company_logo;
                                $this->dbcommon->crop_product_image($target_file, 150, 150, $thumb, 'small', $company_logo);
                                @unlink($target_dir . "original/" . $company_details[0]->company_logo);
                                @unlink($target_dir . "medium/" . $company_details[0]->company_logo);
                            }
                        }
                    }
                    if (isset($_POST['company_status']) && $_POST['company_status'] == 3) {

                        $data1 = array('is_delete' => 3);
                        $array1 = array('user_id' => $company_details[0]->user_id, 'is_delete' => 0);
                        $this->dbcommon->update('user', $array1, $data1);

                        $up3 = array('is_delete' => 3);
                        $data3 = array('offer_user_company_id' => $company_details[0]->user_id, 'is_delete' => 0);
                        $this->dbcommon->update('offers', $data3, $up3);
                    } elseif (isset($_POST['company_status']) && $_POST['company_status'] == 0) {

                        $data4 = array('is_delete' => 0);
                        $array4 = array('user_id' => $company_details[0]->user_id, 'is_delete' => 3);
                        $this->dbcommon->update('user', $array4, $data4);

                        $up6 = array('is_delete' => 0);
                        $data6 = array('offer_user_company_id' => $company_details[0]->user_id, 'is_delete' => 3);
                        $this->dbcommon->update('offers', $data6, $up6);
                    }

                    $array = array('id' => $offer_company_id);
                    $up_data = array(
                        'company_name' => $_POST['company_name'],
                        'company_description' => $_POST['company_description'],
                        'company_logo' => $company_logo,
                        'meta_title' => $_POST['meta_title'],
                        'meta_description' => $_POST['meta_description'],
                        'company_status' => $_POST['company_status'],
                        'company_is_inappropriate' => $_POST['company_is_inappropriate'],
                        'offer_category_id' => $_POST['offer_category_id']
                    );

                    if (isset($_POST['company_is_inappropriate']) && $_POST['company_is_inappropriate'] == 'Approve' && $_POST['company_is_inappropriate'] != $company_details[0]->company_is_inappropriate) {
                        $up_data['company_approved_on'] = date('y-m-d H:i:s');
                    }

                    $result = $this->dbcommon->update('offer_user_company', $array, $up_data);

                    if ($result):
                        $this->session->set_flashdata(array('msg' => 'Offer Company Details updated successfully.', 'class' => 'alert-success'));
                        $redirect = $_SERVER['QUERY_STRING'];
                        if (!empty($_SERVER['QUERY_STRING']))
                            $redirect = '/?' . $redirect;
                        redirect('admin/users/index/offerUser' . $redirect);
                    else:
                        $data['msg'] = 'Offer Company not added, Please try again';
                        $data['msg_class'] = 'alert-info';
                        $this->load->view('admin/users/edit_offer_company_details', $data);
                    endif;
                endif;
            else:
                $this->load->view('admin/users/edit_offer_company_details', $data);
            endif;
        else:
            $this->session->set_flashdata(array('msg' => 'Offer Company not found', 'class' => 'alert-info'));
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect('admin/users/index/offerUser' . $redirect);
        endif;
    }

    public function check_edit_store_name() {

        $where = ' store_id from store where store_id<>' . (int) $_POST['store_id'] . ' and store_name="' . $_POST['new_store_name'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_edit_store_name', 'Store name already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_edit_subdomain_name() {

        $where = ' store_id from store where store_id<>' . (int) $_POST['store_id'] . ' and store_domain="' . $_POST['store_domain'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_edit_subdomain_name', 'Subdomain name already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_edit_company_name() {

        $where = ' id from offer_user_company where id<> ' . (int) $_POST['id'] . ' and company_name="' . $_POST['company_name'] . '"';
        $count = $this->dbcommon->getnumofdetails_($where);

        if ($count > 0) {
            $this->form_validation->set_message('check_company_name', 'Company name already exists');
            return false;
        } else {
            return true;
        }
    }

    function crop_image_upload() {
        $user_id = $_REQUEST['req_user_id'];
        $files_arr = array();
        $files_arr = $_FILES;

        $extension = explode(".", $_FILES['cropped_image']['name']);
        $picture = time() . "." . end($extension);
        $target_dir = document_root . profile;
        $original_target_file = $target_dir . "original/" . $picture;
        $medium_target_file = $target_dir . "medium/" . $picture;
        $small_target_file = $target_dir . "small/" . $picture;
        $success = 0;

        $_FILES['cropped_image']['name'];
        if (move_uploaded_file($_FILES['cropped_image']['tmp_name'], $original_target_file)) {
            $success++;
        }

        if (move_uploaded_file($_FILES['cropped_image_100']['tmp_name'], $medium_target_file)) {
            
        }
        if (move_uploaded_file($_FILES['cropped_image_50']['tmp_name'], $small_target_file)) {
            
        }

        if ($success > 0) {
            $data = array('profile_picture' => $picture);
            $array = array('user_id' => $user_id);
            $result = $this->dbcommon->update('user', $array, $data);

            if (isset($result))
                echo json_encode('success');
            else
                echo json_encode('fail');
        }
        else {
            echo json_encode('fail');
        }
        exit;
    }

    public function view_store($store_id = null) {

        $data = array();
        $data['page_title'] = 'View Store';
        $where = " where store_id='" . $store_id . "'";
        $old_store_details = $this->dbcommon->getdetails('store', $where);
        $new_store_details = $this->dbcommon->getdetails('store_new_details', $where);
        if ($store_id != null && !empty($old_store_details)):

            $where = "country_id=4";
            $state = $this->dbcommon->filter('state', $where);
            $data['state'] = $state;

            $query = ' 0=0 order by cat_order';
            $category = $this->dbcommon->filter('category', $query);

            $query = ' category_id="' . $old_store_details[0]->category_id . '" order by sub_cat_order';
            $sub_category = $this->dbcommon->filter('sub_category', $query);

            $data['old_store_details'] = $old_store_details;
            $data['new_store_details'] = $new_store_details;
            $data['category'] = $category;
            $data['sub_category'] = $sub_category;
            $store_owner = $old_store_details[0]->store_owner;

            $product_where = " product_id from product where product_posted_by='" . $store_owner . "'";
            $product_count = $this->dbcommon->getnumofdetails_($product_where);
            $data['product_count'] = $product_count;

            $this->db->select('SUM(doukani_amout) AS doukani_balance, SUM(store_amount) AS store_balance');
            $this->db->where('status', 1);
            $this->db->where('store_owner', $store_owner);
            $query = $this->db->get('balance');
            $data['balance'] = $query->row_array();

            $this->load->view('admin/stores/view', $data);
        else:
            $this->session->set_flashdata(array('msg' => 'Store not found', 'class' => 'alert-info'));
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect('admin/users/index/storeUser' . $redirect);
        endif;
    }

    function view_offers_company($offer_company_id = NULL) {

        $data = array();
        $data['page_title'] = 'View Offer Company';
        $where = " where id='" . $offer_company_id . "'";
        $company_details = $this->dbcommon->getdetails('offer_user_company', $where);

        $offer_where = " product_id from product where product_posted_by='" . $offer_company_id . "'";
        $offer_count = $this->dbcommon->getnumofdetails_($offer_where);
        $data['offer_count'] = $offer_count;

        $query = ' 0=0 order by cat_order';
        $category = $this->dbcommon->filter('category', $query);
        $data['category'] = $category;

        if (!empty($company_details)):

            $data['company_details'] = $company_details;
            $this->load->view('admin/users/view_offer_company_details', $data);
        else:
            $this->session->set_flashdata(array('msg' => 'Offer Company not found', 'class' => 'alert-info'));
            $redirect = $_SERVER['QUERY_STRING'];
            if (!empty($_SERVER['QUERY_STRING']))
                $redirect = '/?' . $redirect;
            redirect('admin/users/index/offerUser' . $redirect);
        endif;
    }

    public function winipad_users() {

        $data = array();
        $data['page_title'] = 'WinIpad Users';
        $config = init_pagination();
//        if ($this->input->get('search'))
        $config['first_url'] = base_url() . "admin/users/winipad_users" . $this->suffix;

        $config['suffix'] = $this->suffix;
        $config['base_url'] = base_url() . "admin/users/winipad_users";
        $url = base_url() . "admin/users/winipad_users";

        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
        } else
            $per_page = $this->per_page;

        $config['per_page'] = $per_page;
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $page = ($page == 0) ? 0 : ($page - 1) * $per_page;

        if (isset($_GET['dt']))
            $dt = $_GET['dt'];

        $query = "SELECT * FROM `user` u  Where `u`.`is_delete` =0 AND insert_from = 'web-ipad' ";
        if ($this->input->get('search')) {
            $keyword = $this->input->get('search');
            $keyword = str_replace("'", "''", $keyword);
            $query .= " AND (u.first_name like '%$keyword%'";
            $query .= " OR ";
            $query .= "u.email_id like '%$keyword%'";
            $query .= " OR ";
            $query .= "u.first_name like '%$keyword%'";
            $query .= " OR ";
            $query .= "u.nick_name like '%$keyword%'";
            $query .= " OR ";
            $query .= "u.username like '%$keyword%')";
        }
        if (isset($_GET['filter'])) {
            if ($_GET['filter'] == 'inactive_users') {
                $query .= " AND u.status = 'inactive'";
            } elseif ($_GET['filter'] == 'active_users') {
                $query .= " AND u.status = 'active'";
            }
        }

        if (!empty($dt)) {
            $check_is_delete = 1;
            $dt = str_replace("+", "", $dt);
            $date = explode("to", $dt);
            $start_date = date("Y-m-d", strtotime(trim($date[0])));
            $end_date = date("Y-m-d", strtotime(trim($date[1])));
            $query .= " AND (date(u.user_register_date)  between '" . $start_date . "' and '" . $end_date . "')";
//            $url = base_url() . 'admin/users/index/' . $user_role . '?filter=' . $filter_val . '&dt=' . trim($date[0]) . 'to' . trim($date[1]);
//            $search = '?filter=' . $filter_val . '&dt=' . trim($date[0]) . 'to' . trim($date[1]);
        }

        $query .= "ORDER BY `u`.`user_id` DESC";
        $items = $this->dbcommon->get_distinct($query);

        $config['total_rows'] = count($this->dbcommon->customQuery($query, 2));
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
        $winipad_users = $this->dbcommon->customQuery($query . ' Limit ' . $page . ', ' . $per_page, 2);
//        $data['url'] = $url;
        $data['url'] = $config['first_url'];
        $data['total_records'] = sizeof($items);
        $data['winipad_users'] = $winipad_users;
        $this->load->view('admin/users/winipad_users', $data);
    }

    public function update_winipad_users() {

        $userId = $this->input->post('id');

        $where = " where user_id='" . $userId . "'";
        $user = $this->dblogin->isExist($where);
//        print_r($user);
//        echo $user->user_id;
        $data = array('status' => 'active');
        $array = array('user_id' => $user->user_id);
        $result = $this->dbcommon->update('user', $array, $data);

        $this->session->set_flashdata(array('msg' => 'User is activated successfully', 'class' => 'alert-success'));
//        redirect('admin/users/winipad_users');
        if ($result) {
            echo json_encode('success');
        }
        exit;
    }

    function e_wallet() {

        $user_id = $this->input->get('userid', TRUE);
        if (isset($user_id) && $user_id > 0) {

            $data['page_title'] = 'E-wallet';

            $url = site_url() . 'admin/users/e_wallet/?userid=' . $user_id;
            if (isset($_REQUEST['per_page'])) {
                $per_page = $_REQUEST['per_page'];
                $url .= '?per_page=' . $per_page;
            } else
                $per_page = $this->per_page_;

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

            $this->db->select('e.id e_payment_id, e.status, e.store_owner, s.store_name, s.store_id, e.amount, DATE_FORMAT(CONVERT_TZ(e.created_date,"+00:00","' . ASIA_DUBAI_OFFSET . '"),"%Y-%m-%d %H:%i") AS created_date, DATE_FORMAT(CONVERT_TZ(e.modified_date,"+00:00","' . ASIA_DUBAI_OFFSET . '"),"%Y-%m-%d %H:%i") AS modified_date');

            $this->db->where('s.store_owner', $user_id);
            $this->db->join('store s', 's.store_owner = e.store_owner', 'LEFT');
            $this->db->order_by('e.id', 'DESC');
            $this->db->group_by('e.id');
            $query = $this->db->get('e_wallet_request_response e');
            $result = $query->num_rows();
            $data['count'] = $result;

            $query = ' e.id e_payment_id, e.status, e.store_owner, s.store_name, s.store_id, e.amount, DATE_FORMAT(CONVERT_TZ(e.created_date, "+00:00", "+04:00"), "%Y-%m-%d %H:%i") AS created_date, DATE_FORMAT(CONVERT_TZ(e.modified_date, "+00:00", "+04:00"), "%Y-%m-%d %H:%i") AS modified_date 
FROM e_wallet_request_response e LEFT JOIN store s ON s.store_owner = e.store_owner WHERE s.store_owner = "' . $user_id . '" GROUP BY e.id ORDER BY e.id DESC';
            $pagination_data = $this->dbcommon->pagination($url, $query, $per_page, 'yes');
            $data['url'] = $url;
            $data["links"] = $pagination_data['links'];
            $data['total_records'] = $pagination_data['total_rows'];

            $this->db->select('e.id e_payment_id, e.status, e.store_owner, s.store_name, s.store_id, e.amount, DATE_FORMAT(CONVERT_TZ(e.created_date,"+00:00","' . ASIA_DUBAI_OFFSET . '"),"%Y-%m-%d %H:%i") AS created_date, DATE_FORMAT(CONVERT_TZ(e.modified_date,"+00:00","' . ASIA_DUBAI_OFFSET . '"),"%Y-%m-%d %H:%i") AS modified_date');
            $this->db->where('s.store_owner', $user_id);
            $this->db->join('store s', 's.store_owner = e.store_owner', 'LEFT');
            $this->db->order_by('e.id', 'DESC');
            $this->db->group_by('e.id');
            $this->db->limit($per_page, $offset);
            $query = $this->db->get('e_wallet_request_response e');
            $result = $query->result_array();

            $data['e_wallet_list'] = $result;
//            echo $this->db->last_query();
            $data['user_id'] = $user_id;
            $data['url'] = $url;

            $this->load->view('admin/stores/e_wallet_list', $data);
        } else {
            redirect('admin/home');
        }
    }

    function update_wallet_status($e_payment_id = NULL, $user_id = NULL) {
        if (isset($e_payment_id) && $e_payment_id > 0 && isset($user_id) && $user_id > 0) {

            $current_user = $this->session->userdata('user');
            $wh_data = array('id' => $e_payment_id);
            $up_data = array(
                'status' => 1,
                'modified_date' => date('Y-m-d H:i:s'),
                'modified_by' => $current_user->user_id
            );
            $result = $this->dbcommon->update('e_wallet_request_response', $wh_data, $up_data);

            if ($result > 0)
                $this->session->set_flashdata(array('msg' => 'Request approved successfully', 'class' => 'alert-success'));
            else
                $this->session->set_flashdata(array('msg' => 'Request not approved', 'class' => 'alert-info'));

            redirect('admin/users/e_wallet/?userid=' . $user_id);
        }
    }

    function display_ewallet_request_orders($e_id = NULL) {

        $response = array();

        $this->db->select('o.order_number');
        $this->db->join('balance b', 'b.order_id = o.id', 'LEFT');
        $this->db->join('e_wallet_request_response e', 'FIND_IN_SET(b.id, e.balance_ids) > 0', 'LEFT');
//        $this->db->where('FIND_IN_SET(' . $balance_id . ', e.balance_ids) > 0');
        $this->db->where('FIND_IN_SET(b.id, e.balance_ids)');
        $this->db->where('e.id', $e_id);
        $this->db->group_by('o.id');
        $query = $this->db->get('orders o');

        $result = $query->result_array();
        if (isset($result) && sizeof($result) > 0) {
            foreach ($result as $res) {
                $response[] = $res['order_number'];
            }
        }
        echo json_encode($response);
    }

    function edit_store_request($id = NULL) {

        if (isset($id) && $id > 0) {
            $data['page_title'] = 'Edit Store Request';

            $store_request_details = $this->db->query('SELECT * FROM store_request WHERE id=' . $id)->row_array();
            if (isset($store_request_details) && sizeof($store_request_details) > 0) {
                $user_id = $store_request_details['user_id'];
                $user_details = $this->db->query('SELECT email_id,username, phone, first_name, last_name FROM user WHERE is_delete=0 AND status="active" AND user_id=' . $user_id)->row_array();

                $data['store_request_details'] = $store_request_details;
                $data['user_details'] = $user_details;

                $query = ' FIND_IN_SET(1, category_type) > 0 order by cat_order';
                $category = $this->dbcommon->filter('category', $query);
                $data['category'] = $category;

                $query = ' category_id="' . $store_request_details['category_id'] . '" AND FIND_IN_SET(1, sub_category_type) > 0 order by sub_cat_order';
                $sub_category = $this->dbcommon->filter('sub_category', $query);
                $data['sub_category'] = $sub_category;

                if ($this->input->post()) {

                    $this->form_validation->set_rules('store_domain', 'Store sub-domain', 'trim|required|min_length[3]|max_length[20]|callback_check_subdomain_name|alpha_numeric');
                    $this->form_validation->set_rules('store_name', 'Store Name', 'trim|required|callback_check_store_name');
                    $this->form_validation->set_rules('status', 'Status', 'trim|required');
                    if (isset($_POST['category_id1']) && (int) $_POST['category_id1'] == 0) {
                        $this->form_validation->set_rules('website_url', 'Website URL', 'trim|required');
                    }

                    if ($this->form_validation->run() == FALSE) {
                        
                    } else {

                        $current_user = $this->session->userdata('user');
                        $wh_data = array('id' => $id);
                        $up_data = array(
                            'user_id' => $user_id,
                            'store_name' => $this->input->post('store_name', TRUE),
                            'store_domain' => $this->input->post('store_domain', TRUE),
                            'store_description' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $this->input->post('store_description', TRUE) : '',
                            'website_url' => (isset($_POST['category_id']) && (int) $_POST['category_id'] == 0) ? $this->input->post('website_url', TRUE) : '',
                            'category_id' => $this->input->post('category_id', TRUE),
                            'sub_category_id' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $this->input->post('sub_category_id', TRUE) : 0,
                            'status' => $this->input->post('status', TRUE),
                            'modified_date' => date('Y-m-d H:i:s'),
                            'modified_by' => $current_user->user_id
                        );

                        $this->dbcommon->update('store_request', $wh_data, $up_data);

                        if ($this->input->post('status', TRUE) == 2) {

                            $query_settings = ' id=9 and `key`="no_of_post_month_store_user" limit 1';
                            $ads_cnt = $this->dbcommon->filter('settings', $query_settings);
                            if ($ads_cnt[0]['val'] > 0)
                                $cnt_ads = $ads_cnt[0]['val'];
                            else
                                $cnt_ads = default_no_of_ads;

                            $wh_data = array('user_id' => $user_id);
                            $up_data = array(
                                'userTotalAds' => $cnt_ads,
                                'userAdsLeft' => $cnt_ads,
                                'user_role' => 'storeUser',
                            );
                            $this->dbcommon->update('user', $wh_data, $up_data);

                            $in_data = array(
                                'store_owner' => $user_id,
                                'category_id' => $this->input->post('category_id', TRUE),
                                'sub_category_id' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $this->input->post('sub_category_id', TRUE) : 0,
                                'store_domain' => str_replace('.', '', $_POST['store_domain']),
                                'store_name' => $this->input->post('store_name', TRUE),
                                'store_description' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $this->input->post('store_description', TRUE) : '',
                                'website_url' => (isset($_POST['category_id']) && (int) $_POST['category_id'] == 0) ? $this->input->post('website_url', TRUE) : '',
                                'store_contact_person' => $user_details['first_name'] . ' ' . $user_details['last_name'],
                                'store_status' => 0,
                                'store_is_inappropriate' => 'Approve',
                                'new_data_status' => 0,
                                'store_details_verified' => 1,
                                'store_created_on' => date('Y-m-d H:i:s'),
                                'store_approved_on' => date('Y-m-d H:i:s')
                            );
                            $this->dbcommon->insert('store', $in_data);
                            $store_id = $this->db->insert_id();

                            $store_id = $this->db->insert_id();
                            $in_storedata = array(
                                'store_owner' => $user_id,
                                'category_id' => $this->input->post('category_id', TRUE),
                                'sub_category_id' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $_POST['sub_category_id'] : 0,
                                'store_domain' => str_replace('.', '', $_POST['store_domain']),
                                'store_name' => $this->input->post('store_name', TRUE),
                                'store_description' => (isset($_POST['category_id']) && (int) $_POST['category_id'] > 0) ? $_POST['store_description'] : '',
                                'website_url' => (isset($_POST['category_id']) && (int) $_POST['category_id'] == 0) ? $this->input->post('website_url') : '',
                                'store_status' => 0,
                                'store_details_verified' => 1,
                                'store_is_inappropriate' => 'Approve',
                                'store_id' => $store_id
                            );
                            $this->dbcommon->insert('store_new_details', $in_storedata);

                            $this->store->send_mail_storeuser($user_id, 'Approve');
                        }

                        redirect('admin/users/store_request_list');
                    }
                }

                $this->load->view('admin/users/store_request_form', $data);
            } else {
                redirect('admin/home');
            }
        } else {
            redirect('admin/home');
        }
    }

    function store_request_list() {

        $data['page_title'] = 'Store Request';
        $search = '';
        $url = site_url() . 'admin/users/store_request_list/';
        if (isset($_REQUEST['per_page'])) {
            $per_page = $_REQUEST['per_page'];
            $url .= '?per_page=' . $per_page;
            $search .= '&per_page=' . $per_page;
        } else
            $per_page = $this->per_page_;

        if (isset($_REQUEST['page']) && !empty($search))
            $search .= '&page=' . $_REQUEST['page'];
        elseif (isset($_REQUEST['page']))
            $search .= '?page=' . $_REQUEST['page'];

        $data['search'] = $search;

        $per_page = 10;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

        $query = ' s.store_name, u.email_id, u.phone, s.status FROM store_request s LEFT JOIN user u ON u.user_id = s.user_id WHERE u.user_id = s.user_id AND user_role = "generalUser" AND u.is_delete=0 AND s.status<>1 GROUP BY s.id ORDER BY s.id DESC';
        $pagination_data = $this->dbcommon->pagination($url, $query, $per_page, 'yes');
        $data['url'] = $url;
        $data["links"] = $pagination_data['links'];
        $data['total_records'] = $pagination_data['total_rows'];

        $this->db->select('s.id,s.store_name, u.email_id, u.phone, s.status');
        $this->db->join('user u', 'u.user_id = s.user_id', 'LEFT');
        $this->db->where('u.user_id = s.user_id');
//        $this->db->where('user_role', 'generalUser');
        $this->db->where('u.is_delete', 0);
        $this->db->where('s.status<>1');
        $this->db->order_by('s.id', 'DESC');
        $this->db->group_by('s.id');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('store_request s');
        $result = $query->result_array();

        $data['store_request_list'] = $result;
        $data['url'] = $url;

        $this->load->view('admin/users/store_request_list', $data);
    }

    public function delete_store_request($id = NULL) {

        $redirect_url = http_build_query($_REQUEST);
        if (!empty($redirect_url))
            $redirect_url = '?' . http_build_query($_REQUEST);

        $where = array('id' => $id);
        $update = array('status' => 1);
        $this->dbcommon->update('store_request', $where, $update);

        if (isset($result)) {
            $this->session->set_flashdata(array('msg' => 'Store Request(s) deleted successfully', 'class' => 'alert-success'));
        } else {
            $this->session->set_flashdata(array('msg' => 'Store Request(s) not found', 'class' => 'alert-info'));
        }
        redirect('admin/users/store_request_list/' . $redirect_url);
    }

    function followers($user_id = NULL) {

        if (!is_null($user_id) && (int) $user_id > 0) {
            $data['page_title'] = 'Followers List';
            $search = '';
            $url = '';

            if (isset($_REQUEST['per_page'])) {
                $per_page = $_REQUEST['per_page'];
                $url .= '?per_page=' . $per_page;
                $search .= '?per_page=' . $per_page;
            } else
                $per_page = $this->per_page;

            if (isset($_REQUEST['page']) && !empty($search))
                $search .= '&page=' . $_REQUEST['page'];
            elseif (isset($_REQUEST['page']))
                $search .= '&page=' . $_REQUEST['page'];

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

            $where = ' u.user_id FROM followed_seller fs
                    LEFT JOIN user u ON u.user_id = fs.user_id
                    WHERE  fs.seller_id = ' . $user_id . ' AND u.is_delete NOT IN (1,4)';

            $pagination_data = $this->dbcommon->pagination($url, $where, $per_page, 'yes');
            $data["links"] = $pagination_data['links'];
            $data['total_records'] = $pagination_data['total_rows'];

            $users_list = $this->dbcommon->get_myfollowerslist($user_id, $offset, $per_page);
            $data['users_list'] = $users_list;

            $this->load->view('admin/users/followers_users_list', $data);
        } else {
            redirect('admin/home');
        }
    }

    function following($user_id = NULL) {

        if (!is_null($user_id) && (int) $user_id > 0) {
            $data['page_title'] = 'Following Users List';
            $search = '';
            $url = '';

            if (isset($_REQUEST['per_page'])) {
                $per_page = $_REQUEST['per_page'];
                $url .= '?per_page=' . $per_page;
                $search .= '?per_page=' . $per_page;
            } else
                $per_page = $this->per_page;

            if (isset($_REQUEST['page']) && !empty($search))
                $search .= '&page=' . $_REQUEST['page'];
            elseif (isset($_REQUEST['page']))
                $search .= '&page=' . $_REQUEST['page'];

            $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
            $offset = ($page == 0) ? 0 : ($page - 1) * $per_page;

            $where = ' u.user_id FROM followed_seller fs
                    LEFT JOIN user u ON u.user_id = fs.seller_id
                    WHERE  fs.user_id = ' . $user_id . ' AND u.is_delete NOT IN (1,4)';

            $pagination_data = $this->dbcommon->pagination($url, $where, $per_page, 'yes');
            $data["links"] = $pagination_data['links'];
            $data['total_records'] = $pagination_data['total_rows'];

            $users_list = $this->dbcommon->get_myfollowerslist($user_id, $offset, $per_page, 'following');
            $data['users_list'] = $users_list;

            $this->load->view('admin/users/following_users_list', $data);
        } else {
            redirect('admin/home');
        }
    }

}

?>