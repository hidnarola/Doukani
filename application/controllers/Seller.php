<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Seller extends My_controller {

    public function __construct() {        
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dashboard');
        $this->load->helper('form');
        $this->load->helper('page_not_found');
        $this->load->library('pagination');
        $this->load->library('My_PHPMailer');
        $this->load->library('parser');
        
        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user)) {
            define("session_userid", $current_user['user_id']);
        } else
            define("session_userid", '');
        
        $emirate =  $this->uri->segment(1);
        if(empty($emirate))
            $this->session->unset_userdata('request_for_statewise');
        
        if(!empty($emirate) && in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain'))) {
            $this->session->set_userdata('request_for_statewise',$emirate);
            $emirate =  $this->session->userdata('request_for_statewise');
        }
        elseif(isset($_REQUEST['state_id_selection']))
           $emirate = $_REQUEST['state_id_selection'];
        elseif($this->session->userdata('request_for_statewise')!='') {
            $emirate =  $this->session->userdata('request_for_statewise');
        }
        
        if(in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain')))
            define("emirate_slug",$emirate.'/');            
        else
            define("emirate_slug",'');
    }
  
    public function more_seller_products() {
        $filter_val = $this->input->post("value");
        $user_id = $this->input->post("user_id");
        
        if(isset($filter_val) && isset($user_id)) {
            
            $data['seller_listing_page'] = 'yes';
            if ($this->session->userdata('gen_user') != '') {
                $current_user = $this->session->userdata('gen_user');
                $logged_in_userid = $current_user['user_id'];
                $data['login_userid'] = $logged_in_userid;
            } else
                $data['login_userid'] = null;
            $between_banners = $this->dbcommon->getBanner_forCategory('between', "'content_page','all_page'", null, null);
            $data['between_banners'] = $between_banners;

            $array = array('user_id' => $user_id, 'is_delete' => 0, 'status' => 'active');
            $user = $this->dbcommon->get_row('user', $array);
            $data['user'] = $user;

            $start = 12 * $filter_val;
            $end = $start + 12;
            $hide = "false";

            $total_product = $this->dbcommon->seller_listing_count($user_id);
            //$product = $this->dbcommon->get_distinct($query);
            $product = $this->dbcommon->get_my_seller_listing($user_id, $start, 12);
            //echo $this->db->last_query();
            $data['products'] = $product;

            if ($end >= $total_product) {
                $hide = "true";
            }

            $data['user_agree'] = 0;
            $data['loggedin_user'] = '';
            $data['is_logged'] = 0;
            if ($this->session->userdata('gen_user')) {
                $current_user = $this->session->userdata('gen_user');
                $data['loggedin_user'] = $current_user['user_id'];
                $data['is_logged'] = 1;
            }
            $data = array_merge($data, $this->get_elements());

            if (isset($_POST['view']) && $_POST['view'] == 'list') {
                $data["html"] = $this->load->view('home/product_listing_view', $data, TRUE);
            } elseif ($this->uri->segment(4) == 'list') {
                $data["html"] = $this->load->view('home/product_listing_view', $data, TRUE);
            } else {
                $data["html"] = $this->load->view('home/product_grid_view', $data, TRUE);
            }

            //$data["html"] 			= $this->load->view('home/more_search', $data, TRUE);
            $data["val"] = $hide;
            $data["total_product"] = $total_product;
            echo json_encode($data);
            exit();
        }
        else {
            override_404();
        }
    }

    public function more_followers() {
        $filter_val = $this->input->post("value");
        $user_id = $this->input->post("user_id");
        
        if(isset($filter_val) && isset($user_id)) {
            
            if ($this->session->userdata('gen_user') != '') {
                $current_user = $this->session->userdata('gen_user');
                $logged_in_userid = $current_user['user_id'];
                $data['login_userid'] = $logged_in_userid;
            } else
                $data['login_userid'] = null;
            $array = array('user_id' => $user_id, 'is_delete' => 0, 'status' => 'active');
            $user = $this->dbcommon->get_row('user', $array);
            //$data['user'] = $user;

            $start = 25 * $filter_val;
            $end = $start + 25;
            $hide = "false";
            
            if(isset($_REQUEST['following'])  && $_REQUEST['following']=='yes') {
                $data['following_page'] = 'yes';
                $myfollowers = $this->dbcommon->get_myfollowerslist($user_id, $start, 25, 'following');
                $total_product = $this->dbcommon->get_myfollowers_count($user_id, 'following');
            }
            else {
                $myfollowers = $this->dbcommon->get_myfollowerslist($user_id, $start, 25);            
                $total_product = $this->dbcommon->get_myfollowers_count($user_id);
            }
            
            $data['myfollowers'] = $myfollowers;

            if ($end >= $total_product) {
                $hide = "true";
            }

            $data['is_logged'] = 0;
            if ($this->session->userdata('gen_user')) {
                $data['is_logged'] = 1;
            }
            $data = array_merge($data, $this->get_elements());

            //Requst from Store Followers Page
            if(isset($_POST['request_from']) && $_POST['request_from']=='company_followers_page') {
                $data['myfollowers'] = $myfollowers;
            }
            
            $data["html"] = $this->load->view('home/followers_list', $data, TRUE);

            $data["val"] = $hide;
            $data["total_product"] = $total_product;
            echo json_encode($data);
            exit();
        }
        else{
            override_404();
        }
    }

    public function addfollow() {
        
        $seller_id = $this->uri->segment(3);
        $seg4 = $this->uri->segment(4);
        $seg5 = $this->uri->segment(5);
        
        $array = array('user_id' => $seller_id, 'is_delete' => 0, 'status' => 'active');
        $seller_details = $this->dbcommon->get_row('user', $array);
        $user_slug = $seller_details->user_slug;
            
        $current_user = $this->session->userdata('gen_user');
        $user_id = (int) $current_user['user_id'];
        $use = ' where user_id=' . (int) $user_id;

        if ($user_id > 0) {
            $insertArr = array(
                'user_id' => $user_id,
                'seller_id' => $seller_id
            );
            
            $where = array('user_id' => $user_id, 'seller_id' => $seller_id);
            $cnt = $this->dbcommon->get_count('followed_seller', $where);

            if ($cnt > 0) {
                $this->session->set_flashdata(array('msg1' => 'You have already been followed this seller.', 'class' => 'alert-success'));
                /* if($type=='list')
                  redirect('seller/listings/'.$seller_id.'?view=list');
                  else */
                if ($seg4 != '' && $seg4 == 'store') {
                    $where = " where store_owner ='" . $seller_id . "' and store_status=0 and store_is_inappropriate='Approve'";
                    $store = $this->dbcommon->getdetails('store', $where);

                    //redirect('store/store/'.$store[0]->store_domain);
                    $this->session->set_userdata('send_msg', 'You have already been followed this seller.');
                    header('Location:' . HTTP . $store[0]->store_domain . '.' . website_url);
                } 
                elseif($seg4!='') {
                    if($seg5!='')
                        header('Location:' . HTTPS . website_url. $seg4.'/'.$seg5);
                    else
                        header('Location:' . HTTPS . website_url. $seg4);
                }
                else
                    header("Location:".site_url().$user_slug);
            }
            else {
                
                //for seller follow count increment
                $query = ' where user_id=' . (int) $seller_id. ' and is_delete=0 and status="active"' ;
                $sel_del = $this->dbcommon->getrowdetails('user', $query, $offset = '0', $limit = '1');
                if($sel_del->user_id > 0) {
                    $sll_inc = array("followers_count" => $sel_del->followers_count + 1);
                    $wh = array('user_id' => $seller_id);
                    //echo $this->db->last_query();
                    $this->dbcommon->update('user', $wh, $sll_inc);

                    $this->dbcommon->insert('followed_seller', $insertArr);

                    //for logged in user following_count increment
                    $use = ' where user_id=' . (int) $user_id;
                    $use_del = $this->dbcommon->getrowdetails('user', $use, $offset = '0', $limit = '1');
                    $use_inc = array("following_count" => $use_del->following_count + 1);
                    $wh1 = array('user_id' => $user_id);
                    $this->dbcommon->update('user', $wh1, $use_inc);

                    $this->session->set_flashdata(array('msg1' => 'You have been followed this seller.', 'class' => 'alert-success'));
                /* if($type=='list')
                  redirect('seller/listings/'.$seller_id.'?view=list');
                  else */
                    if ($seg4 != '' && $seg4 == 'store') {
                        $where = " where store_owner ='" . $seller_id . "' and store_status=0 and store_is_inappropriate='Approve'";
                        $store = $this->dbcommon->getdetails('store', $where);
                        $this->session->set_userdata('send_msg', 'You have been followed this seller.');
                        //redirect('store/store/'.$store[0]->store_domain);

                        header('Location:' . HTTP . $store[0]->store_domain . '.' . website_url);
                    } 
                    elseif($seg4!='') {
                        if($seg5!='')
                            header('Location:' . HTTPS . website_url. $seg4.'/'.$seg5);
                        else
                            header('Location:' . HTTPS . website_url. $seg4);
                    }
                    else
                        header("Location:".site_url().$user_slug);
                }
                else 
                    header('Location:' . HTTP .website_url);
            }
        }
        else {
            redirect('login');
        }
    }

    public function unfollow() {

        $current_user = $this->session->userdata('gen_user');
        $user_id = (int) $current_user['user_id'];

        $seller_id = $this->uri->segment(3);        
        $seg4 = $this->uri->segment(4);
        $seg5 = $this->uri->segment(5);
        
        $array = array('user_id' => $seller_id, 'is_delete' => 0, 'status' => 'active');        
        $seller_details = $this->dbcommon->get_row('user', $array);
        $user_slug = $seller_details->user_slug;
        
        if ($user_id > 0) {
            $where = array('user_id' => $user_id, 'seller_id' => $seller_id);
            $cnt = $this->dbcommon->get_count('followed_seller', $where);
            if ($cnt > 0) {
                $arr = array('user_id' => $user_id,
                    'seller_id' => $seller_id
                );
                $this->dbcommon->delete('followed_seller', $arr);
                //for seller follow count decrement
                $query = ' where user_id=' . (int) $seller_id.' and is_delete=0 and status="active"';
                $sel_del = $this->dbcommon->getrowdetails('user', $query, $offset = '0', $limit = '1');
                
                if($sel_del->user_id > 0) {
                    
                    $sll_inc = array("followers_count" => $sel_del->followers_count - 1);
                    $wh = array('user_id' => $seller_id);

                    $this->dbcommon->update('user', $wh, $sll_inc);

                    //for logged in user following_count decrement
                    $use = ' where user_id=' . (int) $user_id;
                    $use_del = $this->dbcommon->getrowdetails('user', $use, $offset = '0', $limit = '1');
                    $use_inc = array("following_count" => $use_del->following_count - 1);
                    $wh1 = array('user_id' => $user_id);
                    $this->dbcommon->update('user', $wh1, $use_inc);
                    $this->session->set_flashdata(array('msg1' => 'You have been unfollowed this seller.', 'class' => 'alert-info'));
                    if ($seg4 != '' && $seg4 == 'store') {
                        $where = " where store_owner ='" . $seller_id . "' and store_status=0 and store_is_inappropriate='Approve'";
                        $store = $this->dbcommon->getdetails('store', $where);

                        //header('Location:'.HTTPS.$store[0]->store_domain.'.'.website_url);
                        $this->session->set_userdata('send_msg', 'You have been unfollowed this seller');
                        header('Location:' . HTTP . $store[0]->store_domain . '.' . website_url);
                        //redirect('store/store/'.$store[0]->store_domain);
                    } 
                    elseif($seg4!='') {
                        if($seg5!='')
                            header('Location:' . HTTPS . website_url. $seg4.'/'.$seg5);
                        else
                            header('Location:' . HTTPS . website_url. $seg4);
                    }
                    else
                         header("Location:".site_url().$user_slug);
                }
                else {

                    if ($seg4 != '' && $seg4 == 'store') {
                        $where = " where store_owner ='" . $seller_id . "' and store_status=0 and store_is_inappropriate='Approve'";
                        $store = $this->dbcommon->getdetails('store', $where);

                        //header('Location:'.HTTPS.$store[0]->store_domain.'.'.website_url);
                        header('Location:' . HTTP . $store[0]->store_domain . '.' . website_url);
                        //redirect('store/store/'.$store[0]->store_domain);
                    } 
                    elseif($seg4!='') {
                        if($seg5!='')
                            header('Location:' . HTTPS . website_url. $seg4.'/'.$seg5);
                        else
                            header('Location:' . HTTPS . website_url. $seg4);
                    }
                    else
                         header("Location:".site_url().$user_slug);
                }
            }
            else 
                header('Location:' . HTTP .website_url);            
        }
        else {
            redirect('login/index');
        }
    }

}
