<?php

class Store extends CI_Model {

    var $table = 'store';

    function Store() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->dbutil();
        
        $sel_state = $this->uri->segment(1);
        if(empty($sel_state))
            $this->session->unset_userdata('request_for_statewise');
        
        if(!empty($sel_state) && in_array(strtolower($sel_state),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain'))) {
            $this->session->set_userdata('request_for_statewise',$sel_state);
            $sel_state =  $this->session->userdata('request_for_statewise');
        }
        elseif(isset($_REQUEST['state_id_selection']))
            $sel_state = $_REQUEST['state_id_selection'];            
        elseif($this->session->userdata('request_for_statewise')!='')
            $sel_state =  $this->session->userdata('request_for_statewise');
        
        define("state_id_selection1",strtolower($sel_state));
    }

    public function get_all_store($per_page, $offset) {
        $sdata = array();
        $this->db->select('*')->from('store');
        $this->db->limit($per_page, $offset);
        $query_result = $this->db->get();
        //echo $this->db->last_query(); // shows last executed query

        if ($query_result->num_rows() > 0) {
            foreach ($query_result->result_array() as $row) {
                $sdata[] = array('store_id' => $row['store_id'], 'store_name' => $row['store_name'], 'store_image' => $row['store_image'], 'store_contact_person' => $row['store_contact_person']);
            }
        }
        return $sdata;
    }

    public function get_store($store_id) {
        $this->db->select('*');
        $this->db->from('store');
        $this->db->where('store_id', $store_id);
        $this->db->join('user', 'user.user_id = store.store_owner');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function get_featuredstore($start = NULL, $limit = NULL, $condition = NULL, $only_featured = NULL) {

        $str_store = '';

//        if ($this->session->userdata('request_for_statewise') != '')
//            $str_store = ' and p.state_id=' . $this->session->userdata('request_for_statewise');
        if(in_array(state_id_selection1,array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection1);            
            $str_store = ' and pp.state_id=' .$selected_state_id;
        }
        
        $this->db->select('*, if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fs.start_date and fs.end_date,"running","not running") as mystatus, product_count, if(s.website_url<>"",1,0)  as store_counting');
        
        $this->db->where('s.store_status', 0);        
        $this->db->where('u.is_delete', 0);
        $this->db->where('s.store_is_inappropriate', 'Approve');

        if ($condition != '') {
            $where_data = ' (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fs.start_date and fs.end_date) ';
            $this->db->where($where_data);

//            $this->db->where('store_details_verified', 1);            
            $this->db->having('product_count>0 or store_counting>0');
        }

        if($only_featured!=NULL) {
            $where_data = ' (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fs.start_date and fs.end_date) ';
            $this->db->where($where_data);
        }
        
        $this->db->join('store s', 's.store_id=fs.store_id', 'left');
        $this->db->join('user u', 'u.user_id=s.store_owner', 'left');
        
        $this->db->join('(select count(pp.product_id) product_count, pp.product_id sub_product_id, pp.product_posted_by product_posted_by_  from product pp  where pp.product_is_inappropriate="Approve" and pp.product_deactivate IS NULL and pp.is_delete=0 ' . $str_store . ' group by pp.product_id) k','product_posted_by_=s.store_owner','left');
        
        $this->db->group_by('fs.store_id');

        $this->db->from('featured_stores fs');

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function get_user($user_id) {

        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_inquiry($user_id) {
        $this->db->select('*');
        $this->db->from('inquiry');
        $this->db->where('inquiry_id', $user_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_messages($offset, $limit) {
        $sql = 'select inq.*, usr.username, usr.user_id from inquiry inq, user usr where inq.inquiry_sender = usr.user_id limit ' . $offset . ',' . $limit;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function isExist($query) {
        $sql = "select * from $this->table " . $query . " limit 0,1";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_stores($cat_id = -2, $start = NULL, $limit = NULL, $filter = NULL, $search_word = NULL) {

        $str_store = '';

        if(in_array(state_id_selection1,array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection1);            
            $str_store = ' and p.state_id=' . $selected_state_id;
        }

        $this->db->select('*,(select count(p.product_id) as product_count from product p  where p.product_posted_by=s.store_owner and p.product_is_inappropriate="Approve" and product_deactivate IS NULL and is_delete=0 ' . $str_store . ' ) as product_count, if(s.website_url<>"",1,0)  as store_counting');

        $this->db->where('s.store_status', 0);
        $this->db->where('u.is_delete', 0);
        $this->db->where('s.store_is_inappropriate', 'Approve');

        if ($cat_id != NULL && !in_array((int)$cat_id,array(-1,-2))) {
            $cats = explode(",", $cat_id);
            $this->db->where_in('s.category_id', $cats);
        }

        $this->db->join('user u', 'u.user_id = s.store_owner', 'left');
        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
        if ($search_word != NULL) {
            $this->db->join('category c', 'c.category_id = s.category_id', 'left');
            $this->db->join('sub_category sc', 'sc.category_id = c.category_id', 'left');
            $this->db->join('product p1', 'p1.product_posted_by = u.user_id', 'left');

            $search_word_like = ' (s.store_name like "%' . addslashes($search_word) . '%" or '
                    . 's.store_name like "%' . addslashes($search_word) . '%" or '
                    . 's.store_domain like "%' . addslashes($search_word) . '%" or '
                    . 's.store_description like "%' . addslashes($search_word) . '%" or '
                    . 'c.catagory_name like "%' . addslashes($search_word) . '%" or '
                    . 'sc.sub_category_name like "%' . addslashes($search_word) . '%" or '
                    . 'p.product_name like "%' . addslashes($search_word) . '%" ) ';

            $this->db->where($search_word_like);
        }

        if ($filter == '1')
            $this->db->order_by('s.store_approved_on','desc');
        elseif ($filter == '2')
            $this->db->order_by('s.store_total_views','desc');            
        else
            $this->db->order_by('s.store_id','desc');

        $this->db->having('product_count>0 or store_counting>0');

        $this->db->group_by('s.store_id');
        $this->db->order_by('s.store_id','desc');

        $this->db->join('product p', 'p.product_posted_by=s.store_owner', 'left');

        $query = $this->db->get('store s');
//        echo $this->db->last_query();
        return $query->result_array();
    }

    function get_stores_count($cat_id = -2, $filter = NULL, $search_word = NULL) {

        $str_store = '';

//        if ($this->session->userdata('request_for_statewise') != '')
//            $str_store = ' and p.state_id=' . $this->session->userdata('request_for_statewise');
        if(in_array(state_id_selection1,array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection1);            
            $str_store = ' and p.state_id=' . $selected_state_id;
        }
        
        $this->db->select('*,(select count(p.product_id) as product_count from product p  where p.product_posted_by=s.store_owner and p.product_is_inappropriate="Approve" and product_deactivate IS NULL and is_delete=0 ' . $str_store . ') as product_count, if(s.website_url<>"",1,0)  as store_counting');
        $this->db->where('s.store_status', 0);
        $this->db->where('s.store_is_inappropriate', 'Approve');
        $this->db->where('u.is_delete', 0);

        $this->db->join('user u', 'u.user_id = s.store_owner', 'left');

        if ($cat_id != NULL && !in_array((int)$cat_id,array(-1,-2))) {
            $cats = explode(",", $cat_id);
            $this->db->where_in('s.category_id', $cats);
        }

        if ($filter == '1')
            $this->db->order_by('s.store_approved_on','desc');
        elseif ($filter == '2')
            $this->db->order_by('s.store_total_views','desc');            
        else
            $this->db->order_by('s.store_id','desc');
        
        if ($search_word != NULL) {
            $this->db->join('category c', 'c.category_id = s.category_id', 'left');
            $this->db->join('sub_category sc', 'sc.category_id = c.category_id', 'left');
            $this->db->join('product p1', 'p1.product_posted_by = u.user_id', 'left');

            $search_word_like = ' ( s.store_name like "%' . addslashes($search_word) . '%" or '
                    . 's.store_name like "%' . addslashes($search_word) . '%" or '
                    . 's.store_domain like "%' . addslashes($search_word) . '%" or '
                    . 's.store_description like "%' . addslashes($search_word) . '%" or '
                    . 'c.catagory_name like "%' . addslashes($search_word) . '%" or '
                    . 'sc.sub_category_name like "%' . addslashes($search_word) . '%" or '
                    . 'p.product_name like "%' . addslashes($search_word) . '%" ) ';


            $this->db->where($search_word_like);
        }

        $this->db->having('product_count>0 or store_counting>0');
        $this->db->join('product p', 'p.product_posted_by=s.store_owner', 'left');
        $this->db->group_by('s.store_id');
        $query = $this->db->get('store s');

        $data = $query->num_rows();
        return $data;
    }

    /* send mail to user while admin update status for store */

    function send_mail_storeuser($store_owner, $product_status) {

        $where = " where user_id='" . $store_owner . "'";
        $user = $this->dbcommon->getdetails('user', $where);

        if ($product_status == 'Approve') {

            $this->db->query('update product set is_delete=0 where is_delete=6 and product_posted_by = ' . (int) $store_owner . '');

            $send_msg = 'Congratulations!';
            $text = 'Congratulations your store has been approved and you can now add your items and start selling';

            $button_link = base_url() . "login/index";
            $button_label = 'Click here to Login';
            $parser_data = array();
            $title = $send_msg;
            $detail = $text;
            $content = '
       <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>
        <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:12px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;">' . $detail . '</h6>       <br>
        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">' . $button_label . '</a></div>
';

            $new_data = $this->dbcommon->mail_format($title, $content);
            $new_data = $this->parser->parse_string($new_data, $parser_data, '1');
            if ($user[0]->email_id != '') {
                if (send_mail($user[0]->email_id, $send_msg, $new_data, 'info@doukani.com')) {
                    
                }
            }
        }
    }

    /*
      Count Store valid products to check store would be displayed or not.
     */

    function count_store_products($store_id, $store_owner) {

        $this->db->select('p.product_id');

        $this->db->where('s.store_id', $store_id);
        $this->db->where('p.product_posted_by', $store_owner);

        $this->db->where('p.product_is_inappropriate', 'Approve');
        $this->db->where('p.product_deactivate IS NULL');
        $this->db->where('p.is_delete', 0);

        $this->db->where('s.store_status', 0);
        $this->db->where('s.store_is_inappropriate', 'Approve');
        $this->db->where('p.product_for', 'store');

//        if ($this->session->userdata('request_for_statewise') != '')
//            $this->db->where('p.state_id', $this->session->userdata('request_for_statewise'));
        if(in_array(state_id_selection1,array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection1);            
            $this->db->where('p.state_id', $selected_state_id);
        }
        
        $this->db->join('store s', 's.store_owner=p.product_posted_by', 'left');

        $this->db->group_by('p.product_id');
        $query = $this->db->get('product p');

        return $query->num_rows();
    }
    
     //get state id using emiratename
    public function  state_id($emirate_name = NULL) {
        
        $emirate_name = strtolower($emirate_name);
        $select_state_id = 0;
        
        if($emirate_name=='abudhabi')
            $select_state_id = 3796;
        elseif($emirate_name=='ajman')
            $select_state_id = 3797;
        if($emirate_name=='dubai')
            $select_state_id = 3798;
        elseif($emirate_name=='fujairah')
            $select_state_id = 3803;
        elseif($emirate_name=='ras-al-khaimah')
            $select_state_id = 3799;
        elseif($emirate_name=='sharjah')
            $select_state_id = 3800;
        elseif($emirate_name=='umm-al-quwain')
            $select_state_id = 3802;
        
        return $select_state_id;
    }
    
    
    public function findStoreContent(){
        $this->db->select('page_content');
        $this->db->where('slug_url', 'store-page-content');
        $query = $this->db->get('pages_cms');
        return $query->row();
    }
}

?>