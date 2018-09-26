<?php

class Dbcommon extends CI_Model {

    function Dbcommon() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->dbutil();
        $this->_protect_identifiers = TRUE;

        $sel_state = $this->uri->segment(1);
        if (empty($sel_state))
            $this->session->unset_userdata('request_for_statewise');

        if (!empty($sel_state) && in_array(strtolower($sel_state), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $this->session->set_userdata('request_for_statewise', $sel_state);
            $sel_state = $this->session->userdata('request_for_statewise');
        } elseif (isset($_REQUEST['state_id_selection']))
            $sel_state = $_REQUEST['state_id_selection'];
        elseif ($this->session->userdata('request_for_statewise') != '')
            $sel_state = $this->session->userdata('request_for_statewise');

        define("state_id_selection", strtolower($sel_state));
    }

    //delete product images	
    public function glob_files($source_folder) {
        $FILES = glob($source_folder . "/*.*");
        $i = 0;
        $d = explode('/', APPPATH);

        foreach ($FILES as $key => $file) {
            $FILE_LIST[$key]['name'] = substr($file, ( strrpos($file, "\\") + 1));
            $paths = '';
            $paths = explode("/", $FILE_LIST[$key]['name']);

            $file_date = strtotime(date('Y-m-d', filemtime($file)));
            $prev_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
            $pre_date = strtotime($prev_date);
            /* $vid		=	$this->db->query('select * from product where video_name is not null and video_name <>"" and video_name="'.$paths[8].'"')->num_rows();	 */
            //echo '<br>';
            $res = $this->db->query('select * from product where product_image is not null and product_image<>"" and product_image="' . $paths[8] . '"')->num_rows();
            $res1 = $this->db->query('select * from products_images where product_image="' . $paths[8] . '"')->num_rows();

            //echo $pre_date.'<'.$file_date.'=>'.$paths[8].'=>'.$i.'<br>';			
            //$i++;
            //if($file_date < $pre_date && $res==0 && $res1==0 && $vid==0) 
            if ($file_date < $pre_date && $res == 0 && $res1 == 0) {
                $d = explode('/', APPPATH);
                $path1 = '';
                $path1 = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/' . product . 'original/' . $paths[8];
                @unlink($path1);

                $path2 = '';
                $path2 = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/' . product . 'medium/' . $paths[8];
                @unlink($path2);

                $path3 = '';
                $path3 = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/' . product . 'small/' . $paths[8];
                @unlink($path3);
            }
        }
    }

    public function find_all_videos() {
        $vid = $this->db->query('select video_name from product where video_name is not null and video_name <>""');
        $result = $vid->result_array();
        $new_arr = array_column($result, 'video_name');
        return $new_arr;
    }

    //delete unused videos
    public function deletevideo_files($source_folder) {
        $FILES = glob($source_folder . "/*.*");
        $i = 0;
        $d = explode('/', APPPATH);

        foreach ($FILES as $key => $file) {

            $FILE_LIST[$key]['name'] = substr($file, ( strrpos($file, "\\") + 1));
            $paths = '';
            $paths = explode("/", $FILE_LIST[$key]['name']);

            $file_date = strtotime(date('Y-m-d', filemtime($file)));
            $prev_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
            $pre_date = strtotime($prev_date);
            $vid = $this->db->query('select * from product where video_name is not null and video_name <>"" and video_name="' . $paths[8] . '"')->num_rows();

            if ($file_date < $pre_date && $vid == 0) {
                $d = explode('/', APPPATH);
                $path1 = '';
                $path1 = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/' . product . 'video/' . $paths[8];
                @unlink($path1);
            }
        }
    }

    //delete unused User images
    public function deleteuserimg_files($source_folder) {

        $FILES = glob($source_folder . "/*.*");
        $i = 0;
        $d = explode('/', APPPATH);

        foreach ($FILES as $key => $file) {
            $FILE_LIST[$key]['name'] = substr($file, ( strrpos($file, "\\") + 1));
            $paths = '';
            $paths = explode("/", $FILE_LIST[$key]['name']);

            $file_date = strtotime(date('Y-m-d', filemtime($file)));
            $prev_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
            $pre_date = strtotime($prev_date);

            if ($file_date < $pre_date) {
                $d = explode('/', APPPATH);
                $path1 = '';
                $path1 = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/assets/upload/profile/thumb/' . $paths[8];
                @unlink($path1);
            }
        }
    }

    //delete unused video thumbnails
    public function deletevideoimag_files($source_folder) {
        $FILES = glob($source_folder . "/*.*");
        $i = 0;
        $d = explode('/', APPPATH);

        foreach ($FILES as $key => $file) {

            $FILE_LIST[$key]['name'] = substr($file, ( strrpos($file, "\\") + 1));
            $paths = '';
            $paths = explode("/", $FILE_LIST[$key]['name']);

            $file_date = strtotime(date('Y-m-d', filemtime($file)));
            $prev_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
            $pre_date = strtotime($prev_date);
            $vid = $this->db->query('select * from product where video_image_name is not null and video_image_name <>"" and video_image_name="' . $paths[8] . '"')->num_rows();

            if ($file_date < $pre_date && $vid == 0) {

                $d = explode('/', APPPATH);
                $path1 = '';
                $path1 = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/' . product . 'video_image/' . $paths[8];
                @unlink($path1);
            }
        }
    }

    function insert($table_name, $data) {
        if ($this->db->insert($table_name, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function select($table) {
        $sql = "select * from $table ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //    function select_orderby($table, $field, $order) {
//        $this->db->select('*');
//        $this->db->order_by($field, $order);
//        $query = $this->db->get($table);
//        $data = $query->result_array();
//        return $data;
//    }

    function select_orderby($table, $field, $order, $where = NULL, $where_str = false) {
        $this->db->select('*');
        $this->db->order_by($field, $order);

        if (!is_null($where) && isset($where) && sizeof($where) > 0 && $where_str == false) {
            foreach ($where as $key => $val) {
                $this->db->where($key, $val);
            }
        }
        if (!is_null($where) && isset($where) && sizeof($where) > 0 && $where_str == true) {
            foreach ($where as $val) {
                $this->db->where($val);
            }
        }

        $query = $this->db->get($table);
        $data = $query->result_array();
        return $data;
    }

    function getuserlist($table, $query, $offset = '0', $limit = '1') {
        $sql = "select * from $table where $query LIMIT $offset,$limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function select_store_product($id, $offset, $limit) {
        $sql = "SELECT s.store_name,c.catagory_name,p.store_product_price,p.store_product_name,p.store_product_in_stock,p.store_product_description,p.store_product_id,p.store_product_status FROM `store_product` as p,category as c , store as s where " . $id . "and s.store_id=p.store_id and c.category_id=p.store_product_category_id limit " . $offset . ' , ' . $limit;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function filter($table_name, $query) {
        $sql = "select * from $table_name where $query";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function get_images($prod_id) {
        $img_arr = array();
        $sel_img1 = $this->db->query('select product_image from product where product_id=' . (int) $prod_id . ' limit 1')->row_array();
        $img_arr[0] = $sel_img1['product_image'];

        //print_r($img_arr[0]);
        $sel_img_other = $this->db->query('select product_image from products_images where product_id=' . (int) $prod_id . ' ');
        $res = $sel_img_other->result_array();
        $cnt = 1;

        if ($sel_img_other->num_rows() > 0) {
            foreach ($res as $data) {
                $img_arr[$cnt] = $data['product_image'];
                $cnt++;
            }
        }
        return $img_arr;
    }

    function get_images_count($prod_id) {
        $cnt = 0;
        $sel_img1 = $this->db->query('select product_image from product where product_id=' . (int) $prod_id . ' and product_image !="" limit 1')->num_rows();

        if ($sel_img1 > 0)
            $cnt = 1;

        $sel_img_other = $this->db->query('select product_image from products_images where product_id=' . (int) $prod_id . ' ');
        $res = $sel_img_other->num_rows();

        if ($res > 0)
            $cnt += $res;

        return $cnt;
    }

    function get_distinct($query) {
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function insert_batch($table_name, $array) {
        $this->db->insert_batch($table_name, $array);
    }

    function update($table_name, $array, $data) {

        foreach ($array as $key => $value) {
            $this->db->where($key, $value);
        }
        if ($this->db->update($table_name, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function delete($table_name, $array) {
        foreach ($array as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->delete($table_name);
        return true;
    }

    function checkpermission($table = '', $other_table = '', $id = '', $value = '0') {
        $sql = "select count(*) as cnt from $table where";
        foreach ($other_table as $tablename) {
            $sql .= " 0<(select count(*) as c from $tablename where $id='" . $value . "') or";
        }
        $sql = trim($sql, ' or');
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->cnt;
    }

    function readpermission($table_name, $query) {
        $sql = "select permission from $table_name " . $query;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getdetails($table_name, $query, $offset = '0', $limit = '1') {
        $sql = "select * from $table_name " . $query . " LIMIT $offset,$limit";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getrowdetails($table_name, $query, $offset = '0', $limit = '1') {
        $sql = "select * from $table_name " . $query . " LIMIT $offset,$limit";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function getdetails_($query, $offset = '0', $limit = '1') {
        $sql = "select " . $query . " LIMIT $offset,$limit";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getnumofdetails($table_name, $where) {
        $sql = "select count(*) as cnt from $table_name " . $where;
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->cnt;
    }

    function getnumofdetails_($query) {
        $sql = "select " . $query . "";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    //without select
    function getnumofdetails_select($query) {
        $sql = $query . "";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function getdetailsinfo($table_name, $array) {
        $sql = "select * from $table_name where ";

        foreach ($array as $key => $value) {
            $sql .= " $key= " . $value . " and";
        }
        $sql = trim($sql, ' and');
        $query = $this->db->query($sql);
        return $query->row();
    }

    function getInfo($field_name = '', $table_name, $array = '', $return = "", $limit = '', $orderby = '') {
        if ($field_name == '') {
            $sql = 'select * ';
        } else {
            $str = '';
            foreach ($field_name as $row) {
                $str .= $row . ',';
            }
            $str = rtrim($str, ',');
            $sql = "select " . $str;
        }
        $sql .= ' from ' . $table_name . ' where 2>0 ';
        if ($array != '') {
            foreach ($array as $key => $value) {
                $sql .= "and $key='$value' and";
            }
            $sql = trim($sql, ' and');
        }
        if ($orderby != '') {
            $sql .= " order by $orderby";
        }
        if ($limit != '') {
            $sql .= " limit $limit";
        }
        $query = $this->db->query($sql);
        if ($return == '') {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    function getInfo_($field_name, $table_name) {
        $sql = "select distinct $field_name from $table_name order by $field_name";
        $query = $this->db->query($sql);
        return $this->dbutil->csv_from_result($query);
    }

    function getcsvResult($query) {
        $query_ = $this->db->query($query);
        return $this->dbutil->csv_from_result($query_);
    }

    function getAllInfo_($query, $return = '') {
        $query = $this->db->query($query);
        if ($return == '') {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    //sneha
    function get_countAll($tblname) {
        return $this->db->count_all($tblname);
    }

    function getTotal($table, $conditions) {
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    function gallery_count($table_alias = NULL) {

//        $this->db->select('' . $table_alias . '.product_id,count_image,
//                    IF(' . $table_alias . '.product_image IS NULL OR ' . $table_alias . '.product_image="",0,1) as main_img_count, 
//                    IF(' . $table_alias . '.youtube_link IS NULL  OR ' . $table_alias . '.youtube_link="",0,1) youyube_count ,
//                    IF(' . $table_alias . '.video_name IS NULL  OR ' . $table_alias . '.video_name="",0,1) video_count,
//                        
//                   (IF(' . $table_alias . '.product_image IS NULL OR ' . $table_alias . '.product_image="",0,1) + 
//                    IF(' . $table_alias . '.youtube_link IS NULL  OR ' . $table_alias . '.youtube_link="",0,1) + 
//                    IF(' . $table_alias . '.video_name IS NULL  OR ' . $table_alias . '.video_name="",0,1) +                     
//                    IF(count_image IS NULL  OR count_image="",0,count_image)) as MyTotal ', FALSE);

        $this->db->select('' . $table_alias . '.product_id,
                    IF(' . $table_alias . '.product_image IS NULL OR ' . $table_alias . '.product_image="",0,1) as main_img_count, 
                    IF(' . $table_alias . '.youtube_link IS NULL  OR ' . $table_alias . '.youtube_link="",0,1) youyube_count ,
                    IF(' . $table_alias . '.video_name IS NULL  OR ' . $table_alias . '.video_name="",0,1) video_count,
                        
                   (IF(' . $table_alias . '.product_image IS NULL OR ' . $table_alias . '.product_image="",0,1) + 
                    IF(' . $table_alias . '.youtube_link IS NULL  OR ' . $table_alias . '.youtube_link="",0,1) + 
                    IF(' . $table_alias . '.video_name IS NULL  OR ' . $table_alias . '.video_name="",0,1) +
                    (COUNT(DISTINCT pi.product_image_id))
                ) as MyTotal ', FALSE);
    }

    function get_products($limit = NULL, $start = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }
        $this->db->select('product.product_id,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_posted_by,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_likes,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,
        (
        CASE 
            WHEN product.product_is_sold=1 THEN "SOLD"
            WHEN CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire  THEN "Featured"
            ELSE ""
        END) AS mytag,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold
        ,user.facebook_id,user.twitter_id,user.google_id,product.product_slug,user.user_slug,
        if(featureads.product_id IS NOT NULL and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire),1,"") as featured_ad,product.category_id', FALSE);

        $this->gallery_count('product');

        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
        $this->db->join('featureads', 'featureads.product_id = product.product_id', 'left');

//        $this->db->join('(select count(*) count_image, product_id sub_product_id from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');

        $this->db->where('product.is_delete', 0);
        $this->db->where('product.product_for', 'classified');
        $this->db->where('user.status', 'active');
        $this->db->where('user.is_delete', 0);

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        $this->db->order_by('product.product_posted_time', 'desc');

        $this->db->group_by("product.product_id");

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    function get_products_count() {

        $this->db->select('product.product_id,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture');
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id');
        $this->db->join('user', 'user.user_id = product.product_posted_by');
        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');
        $this->db->where('product.is_delete', 0);
        $this->db->where('product.product_for', 'classified');

//        if($this->session->userdata('request_for_statewise')!='')
        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        $this->db->group_by("product.product_id");

        $query = $this->db->get();
        $data = $query->num_rows();

        return $data;
    }

    function get_product($product_id = null) {

        $this->db->select('product.*,category.catagory_name,state.state_name,sub_category.sub_category_name,user.username, user.profile_picture,
        if( product.phone_no IS not NULL
		OR product.phone_no <> "", product.phone_no, user.phone ) AS phone, DATE_FORMAT(product.product_posted_time,"%d-%m-%Y") as posted_on,if(user.nick_name!="",user.nick_name,user.username) as username1,
         user.facebook_id,user.twitter_id,user.google_id,user.user_slug', FALSE);
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        $this->db->where('product.product_id', $product_id);
        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');

        $this->db->where_in('product.is_delete', array(0, 3));
        $query = $this->db->get();

        $data = $query->row();
        return $data;
    }

    function get_product_slugwise($product_slug = NULL, $for = NULL, $condition = NULL) {

        $this->db->select('product.*,category.catagory_name,state.state_name,sub_category.sub_category_name,user.username, user.profile_picture,
        if(product.phone_no <> "", product.phone_no, user.phone ) AS phone, DATE_FORMAT(product.product_posted_time,"%d-%m-%Y") as posted_on,if(user.nick_name!="",user.nick_name,user.username) as username1,
         user.facebook_id,user.twitter_id,user.google_id,user.user_slug,product.stock_availability,state.latitude state_latitude,state.longitude state_longitude', FALSE);
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        $this->db->where('product.product_slug', $product_slug);
        $this->db->where_in('product.is_delete', array(0, 3));
        if ($condition == 'yes') {
//            $this->db->where('product.product_is_inappropriate', 'NeedReview');
//            $this->db->where('product.product_deactivate',1);
        } else {
            $this->db->where('product.product_is_inappropriate', 'Approve');
            $this->db->where('product.product_deactivate IS NULL');
        }

        if ($for != NULL && $for == 'store')
            $this->db->where('product.product_for', 'store');
        else
            $this->db->where('product.product_for', 'classified');

        $query = $this->db->get();
        $data = $query->row();

        return $data;
    }

    function get_product_foredit($product_id = null) {

        $this->db->select('product.*,category.catagory_name,state.state_name,sub_category.sub_category_name,user.username, user.profile_picture, user.phone, DATE_FORMAT(product.product_posted_time,"%d-%m-%Y") as posted_on,if(user.nick_name!="",user.nick_name,user.username) as username1,user.facebook_id,user.twitter_id,user.google_id,state.latitude state_latitude,state.longitude state_longitude', FALSE);
        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
        $this->db->where('product.product_id', $product_id);

        $this->db->where_in('product.is_delete', array(0, 3, 6));
        $query = $this->db->get();

        $data = $query->row();
        return $data;
    }

    function get_product_admin($product_id = null) {

        $this->db->select('product.*,category.catagory_name,state.state_name,sub_category.sub_category_name,user.username, user.profile_picture,DATE_FORMAT(product.product_posted_time,"%d-%m-%Y") as posted_on,if(user.nick_name!="",user.nick_name,user.username) as username1,user.facebook_id,user.twitter_id,user.google_id,if( product.phone_no IS not NULL
		OR product.phone_no <> "", product.phone_no, user.phone ) AS phone_no,state.latitude state_latitude,state.longitude state_longitude', FALSE);

        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
        $this->db->where('product.product_id', $product_id);
        $this->db->where_in('product.is_delete', array(0, 3));
        $query = $this->db->get();

        $data = $query->row();
        return $data;
    }

    function get_most_viewed_products($start) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }
        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_likes,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,user.facebook_id,user.twitter_id,user.google_id,product.product_slug,user.user_slug,if(featureads.product_id IS NOT NULL and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") not between featureads.dateFeatured and featureads.dateExpire),1,"") as featured_ad');

        $this->gallery_count('product');

        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
//        $this->db->join('(select count(*) count_image, product_id sub_product_id  from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');
        $this->db->join('featureads', 'featureads.product_id = product.product_id', 'left');

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');
        $this->db->where('product.is_delete', 0);
        $this->db->where('product.product_for', 'classified');

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        $this->db->order_by('product.product_total_views', 'desc');
//        $this->db->order_by('featured_ad', 'desc');
//        $this->db->order_by('featureads.id', 'desc');

        $this->db->group_by('product.product_id');
        $this->db->limit(12, $start);

        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    function get_product_by_categories($cat = NULL, $subcat = NULL, $current_pro_id = NULL, $limit = NULL, $start = NULL, $rand = NULL, $posted_by = NULL, $search = NULL, $latest = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }
        $this->db->select('if(cmn.repeating_number="-1","More than 5",if(cmn.repeating_number="","-",rn.rep_number)) as car_repeating_number', FALSE);

        $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

        $this->db->select('product.latitude,product.longitude,product.address,product.stock_availability,product.product_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_likes,product.product_total_favorite,product.product_posted_by,product.state_id,state.state_name,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,user.facebook_id,user.twitter_id,user.google_id,product.product_slug,user.user_slug,state.latitude state_latitude,state.longitude state_longitude,product.stock_availability,if(featureads.product_id IS NOT NULL and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire),1,"") as featured_ad');

        $this->gallery_count('product');

        $this->db->from('product');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
        $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
        $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
//        $this->db->join('(select count(*) count_image, product_id sub_product_id  from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');
        $this->db->join('featureads', 'featureads.product_id = product.product_id', 'left');

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');

        $this->db->where('product.is_delete', 0);
        if ($cat != NULL) {
            $this->db->where('product.category_id', $cat);
        }
        if ($subcat != NULL) {
            $this->db->where('product.sub_category_id', $subcat);
        }
        if ($current_pro_id != NULL) {
            $this->db->where('product.product_id !=', $current_pro_id);
        }

        if ($posted_by != NULL) {
            $this->db->where('product.product_for', 'store');
            $this->db->where('product.product_posted_by', $posted_by);
        } else {
            $this->db->where('product.product_for', 'classified');

            if ($latest != NULL) {
                
            } else
                $this->db->order_by('featured_ad', 'desc');
        }

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {

            $search_value = trim($_REQUEST['s']);
            $impl = explode(" ", $search_value);

            $remove_index = array_filter($impl);
            $reset_arr = array_values($remove_index);

            $query_string = ' ( ';
            foreach ($reset_arr as $arr) {

                $query_string .= " ( product.product_name LIKE '%" . addslashes($arr) . "%'
                OR category.catagory_name LIKE '%" . addslashes($arr) . "%'
                OR user.username LIKE '%" . addslashes($arr) . "%'
                OR user.nick_name LIKE '%" . addslashes($arr) . "%'
                OR sub_category.sub_category_name LIKE '%" . addslashes($arr) . "%' )  AND ";
            }

            $where_ = substr($query_string, 0, -4) . ') ';
            $this->db->where($where_);
        }

        //used while diplaying related items on product details page
        if ($rand == 'rand')
            $this->db->order_by("RAND()");
        else {
            if (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'lh')
                $this->db->order_by('product.product_price', 'asc');
            elseif (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'hl')
                $this->db->order_by('product.product_price', 'desc');
            else {
                if ($search != NULL) {
                    if ($search == 'new')
                        $this->db->order_by('product.admin_modified_at', 'desc');
                    elseif ($search == 'popular')
                        $this->db->order_by('product.product_total_views', 'desc');
                    else
                        $this->db->order_by('product.product_posted_time', 'desc');
                }
                else {
                    $this->db->order_by('product.product_posted_time', 'desc');
                }
            }
        }

        $this->db->group_by("product.product_id");
        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();

        $data = $query->result_array();

        return $data;
    }

    /*
     * Get Vehicle Products
     * @NV
     */

    function get_vehicle_products($cat = null, $subcat = null, $current_pro_id = null, $limit = null, $start = null, $user_id = NULL, $search = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->select('ps.plate_source_name');
        $this->db->select('cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
        $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
        $this->db->select('if(cmn.repeating_number="-1","More than 5",if(cmn.repeating_number="","-",rn.rep_number)) as car_repeating_number', FALSE);

        $this->db->select('product.latitude,product.longitude,product.address,product.product_id,product.product_description,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_name,product.product_image,product.product_posted_by,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,state.state_name,category.catagory_name,user.username, user.profile_picture, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,product.product_brand,brand.name bname,model.name mname,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,product.product_total_likes,product.product_slug,user.user_slug,state.latitude state_latitude,state.longitude state_longitude,product.stock_availability,if(featureads.product_id IS NOT NULL and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire),1,"") as featured_ad');

        $this->gallery_count('product');

        $this->db->from('product');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
        $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
        $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');

        $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');
        $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');

        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');

        $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
        $this->db->join('plate_source ps', 'ps.id=cmn.plate_source', 'left');
        $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
        $this->db->join('plate_digit pd', 'pd.id=cmn.plate_digit', 'left');
        $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
        $this->db->join('featureads', 'featureads.product_id = product.product_id', 'left');

        $this->db->join('user', 'user.user_id=product.product_posted_by', 'left');
//        $this->db->join('(select count(*) count_image, product_id sub_product_id  from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');

        $this->db->where('product.is_delete', 0);
        if ($cat != NULL) {
            $this->db->where('product.category_id', $cat);
        }

        if ($subcat != NULL) {
            $this->db->where('product.sub_category_id', $subcat);
        }

        if ($current_pro_id != NULL) {
            $this->db->where('product.product_id', $current_pro_id);
        }

        if ($user_id != NULL) {
            $this->db->where('product.product_posted_by', $user_id);
            $this->db->where('product.product_for', 'store');
        } else {
            $this->db->where('product.product_for', 'classified');
            $this->db->order_by('featured_ad', 'desc');
        }

        if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {

            $search_value = trim($_REQUEST['s']);
            $impl = explode(" ", $search_value);

            $remove_index = array_filter($impl);
            $reset_arr = array_values($remove_index);

            $query_string = ' ( ';
            foreach ($reset_arr as $arr) {

                $query_string .= " ( product.product_name LIKE '%" . addslashes($arr) . "%'
                OR category.catagory_name LIKE '%" . addslashes($arr) . "%'
                OR user.username LIKE '%" . addslashes($arr) . "%'
                OR user.nick_name LIKE '%" . addslashes($arr) . "%'
                OR sub_category.sub_category_name LIKE '%" . addslashes($arr) . "%' )  AND ";
            }

            $where_ = substr($query_string, 0, -4) . ') ';

            $this->db->where($where_);
        }

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        if (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'lh')
            $this->db->order_by('product.product_price', 'asc');
        elseif (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'hl')
            $this->db->order_by('product.product_price', 'desc');
        else {
            if ($search != NULL) {
                if ($search == 'new')
                    $this->db->order_by('product.admin_modified_at', 'desc');
                elseif ($search == 'popular')
                    $this->db->order_by('product.product_total_views', 'desc');
                else
                    $this->db->order_by('product.product_posted_time', 'desc');
            } else
                $this->db->order_by('product.product_posted_time', 'desc');
        }

        $this->db->group_by('product.product_id');

        if ($limit != NULL) {
            if ($start != NULL)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    function get_vehicle_product($cat = null, $subcat = null, $current_pro_id = null, $limit = null, $start = null) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->select('product.product_id,product.product_description,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_name,product.product_image,product.product_posted_by,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,product.product_total_likes,state.state_name,category.catagory_name,user.username, user.profile_picture, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color,product_vehicles_extras.id color_id, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,product.product_brand,user.facebook_id,user.twitter_id,user.google_id,if( product.phone_no IS not NULL OR product.phone_no <> "", product.phone_no, user.phone ) AS phone_no,product.*,user.user_slug,state.latitude state_latitude,state.longitude state_longitude');

        $this->db->from('product');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        $this->db->where_in('product.is_delete', array(0, 3, 6));
        if ($cat != null) {
            $this->db->where('product.category_id =', $cat);
        }
        if ($subcat != null) {
            $this->db->where('product.sub_category_id =', $subcat);
        }
        if ($current_pro_id != null) {
            $this->db->where('product.product_id =', $current_pro_id);
        }

        $this->db->order_by("product.product_total_views", "desc");
        $this->db->group_by("product.product_id");
        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();

        $data = $query->result_array();

        return $data;
    }

    function get_real_estate_products($cat = NULL, $subcat = NULL, $current_pro_id = NULL, $limit = NULL, $start = NULL, $user_id = NULL, $search = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->select('product.latitude,product.longitude,product.address,product.product_id,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_posted_by,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,product.product_description,state.state_name,category.catagory_name,user.username, user.profile_picture, product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood, product_realestate_extras.address, product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,user.twitter_id,user.facebook_id,user.google_id,product.product_total_likes,product.product_slug,user.user_slug,product_realestate_extras.ad_language as ad_language,state.latitude state_latitude,state.longitude state_longitude,product.stock_availability,if(featureads.product_id IS NOT NULL and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire),1,"") as featured_ad');

        $this->gallery_count('product');

        $this->db->from('product');
        $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
//        $this->db->join('(select count(*) count_image, product_id sub_product_id from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');
        $this->db->join('featureads', 'featureads.product_id = product.product_id', 'left');

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');

        $this->db->where('product.is_delete', 0);
        if ($cat != null) {
            $this->db->where('product.category_id', $cat);
        }
        if ($subcat != null) {
            $this->db->where('product.sub_category_id', $subcat);
        }
        if ($current_pro_id != null) {
            $this->db->where('product.product_id', $current_pro_id);
        }

        if ($user_id != NULL) {
            $this->db->where('product.product_posted_by', $user_id);
            $this->db->where('product.product_for', 'store');
        } else {
            $this->db->where('product.product_for', 'classified');
            $this->db->order_by('featured_ad', 'desc');
        }

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'rak', 'sharjah', 'uaq'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        if (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'lh')
            $this->db->order_by('product.product_price', 'asc');
        elseif (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'hl')
            $this->db->order_by('product.product_price', 'desc');
        else {
            if ($search != NULL) {
                if ($search == 'new')
                    $this->db->order_by('product.admin_modified_at', 'desc');
                elseif ($search == 'popular')
                    $this->db->order_by('product.product_total_views', 'desc');
                else
                    $this->db->order_by('product.product_posted_time', 'desc');
            } else
                $this->db->order_by('product.product_posted_time', 'desc');
        }

        if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {

            $search_value = trim($_REQUEST['s']);
            $impl = explode(" ", $search_value);

            $remove_index = array_filter($impl);
            $reset_arr = array_values($remove_index);

            $query_string = ' ( ';
            foreach ($reset_arr as $arr) {

                $query_string .= " ( product.product_name LIKE '%" . addslashes($arr) . "%'
                OR category.catagory_name LIKE '%" . addslashes($arr) . "%'
                OR user.username LIKE '%" . addslashes($arr) . "%'
                OR user.nick_name LIKE '%" . addslashes($arr) . "%'
                OR sub_category.sub_category_name LIKE '%" . addslashes($arr) . "%' )  AND ";
            }

            $where_ = substr($query_string, 0, -4) . ') ';

            $this->db->where($where_);
        }

        $this->db->group_by("product.product_id");
        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    function get_real_estate_product($cat = null, $subcat = null, $current_pro_id = null, $limit = null, $start = null) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->select('product.product_id,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_posted_by,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,product.product_total_likes,product.product_description,state.state_name,category.catagory_name,user.username, user.profile_picture, product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood, product_realestate_extras.address, product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language,user.facebook_id,user.twitter_id,user.google_id,
		if( product.phone_no IS not NULL OR product.phone_no <> "", product.phone_no, user.phone ) AS phone_no ,product.*,user.user_slug,product_realestate_extras.ad_language as ad_language,state.latitude state_latitude,state.longitude state_longitude');
        $this->db->from('product');
        $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        $this->db->where_in('product.is_delete', array(0, 3, 6));
        if ($cat != null) {
            $this->db->where('product.category_id', $cat);
        }
        if ($subcat != null) {
            $this->db->where('product.sub_category_id', $subcat);
        }
        if ($current_pro_id != null) {
            $this->db->where('product.product_id', $current_pro_id);
        }

        $this->db->order_by("product.product_total_views", "desc");
        $this->db->group_by("product.product_id");
        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    function get_car_mobile_number_product($cat = null, $subcat = null, $current_pro_id = null, $limit = null, $start = null, $num_for = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->select('product.product_id,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_posted_by,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,product.product_total_likes,product.product_description,state.state_name,category.catagory_name,user.username, user.profile_picture, cmn.* ,user.facebook_id,user.twitter_id,user.google_id,
		if( product.phone_no IS not NULL OR product.phone_no <> "", product.phone_no, user.phone ) AS phone_no ,product.*,user.user_slug,product.stock_availability,state.latitude state_latitude,state.longitude state_longitude');
        $this->db->from('product');
        $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        $this->db->where_in('product.is_delete', array(0, 3, 6));
        if ($cat != null) {
            $this->db->where('product.category_id', $cat);
        }
        if ($subcat != null) {
            $this->db->where('product.sub_category_id', $subcat);
        }
        if ($current_pro_id != null) {
            $this->db->where('product.product_id', $current_pro_id);
        }
        if ($num_for != NULL) {
            $this->db->where('number_for', $num_for);
        }

        $this->db->order_by("product.product_total_views", "desc");
        $this->db->group_by("product.product_id");
        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    //get individual product
    function car_mobile_number_product($cat = null, $subcat = null, $current_pro_id = null, $limit = null, $start = null, $num_for = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->select('product.product_id,product.state_id,product.category_id,product.sub_category_id,product.product_posted_time,product.product_posted_by,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,product.product_total_likes,product.product_description,state.state_name,category.catagory_name,user.username, user.profile_picture,user.facebook_id,user.twitter_id,user.google_id,
		if( product.phone_no IS not NULL OR product.phone_no <> "", product.phone_no, user.phone ) AS phone_no ,product.*,user.user_slug,product.stock_availability,state.latitude state_latitude,state.longitude state_longitude');
        $this->db->from('product');
        $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        $this->db->where_in('product.is_delete', array(0, 3));
        if ($cat != null) {
            $this->db->where('product.category_id', $cat);
        }
        if ($subcat != null) {
            $this->db->where('product.sub_category_id', $subcat);
        }
        if ($current_pro_id != null) {
            $this->db->where('product.product_id', $current_pro_id);
        }
        if ($num_for != NULL) {
            if ($num_for == 'car_number') {
                $this->db->select('cmn.*,ps.plate_source_name');
                $this->db->select('if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
                $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
                $this->db->select('if(cmn.repeating_number="-1","More than 5",if(cmn.repeating_number="","-",rn.rep_number)) as car_repeating_number', FALSE);

                $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
                $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
                $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
                $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number and rn.num_for="plate"', 'left');
            }

            if ($num_for == 'mobile_number') {

                $this->db->select('if(cmn.repeating_number="-1","More than 5",if(cmn.repeating_number="","-",rn.rep_number)) as car_repeating_number', FALSE);

                $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

                $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number and rn.num_for="mobile"', 'left');
                $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
            }
            $this->db->where('number_for', $num_for);
        }
        $this->db->order_by("product.product_total_views", "desc");
        $this->db->group_by("product.product_id");
        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        $data = $query->row();
        return $data;
    }

    function get_products_by_cat_num($cat = NULL, $subcat = NULL, $user_id = NULL, $product_for = NULL) {

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete', 0);

        if ($cat != NULL) {
            $this->db->where('product.category_id', $cat);
        }

        if ($subcat != NULL) {
            $this->db->where('product.sub_category_id', $subcat);
        }

        if ($product_for != NULL) {
            $this->db->where('product.product_for', 'store');
        } else {
            $this->db->where('product.product_for', 'classified');
        }

        if ($user_id != NULL) {
            $this->db->where('product.product_posted_by', $user_id);
        }

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('sub_category', 'sub_category.sub_category_id = product.sub_category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {

            $search_value = trim($_REQUEST['s']);
            $impl = explode(" ", $search_value);

            $remove_index = array_filter($impl);
            $reset_arr = array_values($remove_index);

            $query_string = ' ( ';
            foreach ($reset_arr as $arr) {

                $query_string .= " ( product.product_name LIKE '%" . addslashes($arr) . "%'
                OR category.catagory_name LIKE '%" . addslashes($arr) . "%'
                OR user.username LIKE '%" . addslashes($arr) . "%'
                OR user.nick_name LIKE '%" . addslashes($arr) . "%'
                OR sub_category.sub_category_name LIKE '%" . addslashes($arr) . "%' )  AND ";
            }

            $where_ = substr($query_string, 0, -4) . ') ';

            $this->db->where($where_);
        }

        $query = $this->db->get('product');

        $data = $query->num_rows();
        return $data;
    }

    function get_product_images($product_id) {
        $this->db->select('product_image');
        $this->db->from('products_images');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        $data = $query->result_array();
        $img_arr = array();
        foreach ($data as $img) {
            $img_arr[] = $img['product_image'];
        }
        return $img_arr;
    }

    function get_my_listing($user_id = NULL, $start = NULL, $limit = NULL, $search = NULL, $user_status = NULL, $user_role = NULL, $request_from = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.category_id,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,user.facebook_id,user.twitter_id,user.google_id,product.product_slug,product.product_total_likes,user.user_slug,product.stock_availability,state.latitude state_latitude,state.longitude state_longitude,product.product_for,if(featureads.product_id IS NOT NULL and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire),1,"") as featured_ad,state.state_name,product.latitude,product.longitude,state.latitude state_latitude, state.longitude state_longitude,product.address');

        $this->gallery_count('product');
        $this->db->from('product');

        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
        $this->db->join('featureads', 'featureads.product_id = product.product_id', 'left');

//        $this->db->join('(select count(*) count_image, product_id sub_product_id  from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');

        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
            $this->db->select('ps.plate_source_name');
            $this->db->select('product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,brand.name bname,model.name mname', FALSE);
            $this->db->select('cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
            $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->select('if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number,product.product_id', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
            $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
            $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');

            $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
            $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');
            $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
            $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
            $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
            $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
            $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
            $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
            $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');
        }

        if (isset($_REQUEST['val']) && $_REQUEST['val'] == 'Unapprove')
            $this->db->where('product.product_is_inappropriate', 'Unapprove');
        elseif (isset($_REQUEST['val']) && $_REQUEST['val'] == 'NeedReview')
            $this->db->where('product.product_is_inappropriate', 'NeedReview');
        else
            $this->db->where('product.product_is_inappropriate', 'Approve');

        $this->db->where('product.product_deactivate IS NULL');

        if (isset($user_id))
            $this->db->where('product.product_posted_by', $user_id);

        if ($search != NULL) {
            if ($search == 'new')
                $this->db->order_by('product.admin_modified_at', 'desc');
            elseif ($search == 'popular')
                $this->db->order_by('product.product_total_views', 'desc');
            else
                $this->db->order_by('product.product_posted_time', 'desc');
        } else
            $this->db->order_by('product.product_posted_time', 'desc');

        if ($user_status == 1)
            $this->db->where('product.is_delete', 3);
        else
            $this->db->where_in('product.is_delete', array(0, 6));

        if ($user_role != NULL && $user_role == 'storeUser')
            $this->db->where('product.product_for', 'store');
        elseif ($user_role != NULL && $user_role == 'generalUser')
            $this->db->where('product.product_for', 'classified');

        if ($request_from != NULL && $request_from == 'store' && in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        $this->db->group_by("product.product_id");

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    function get_my_listing_count($user_id, $search = NULL, $user_status = NULL, $user_role = NULL, $request_from = NULL) {

        $this->db->select('product.product_id');
        $this->db->from('product');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        if (isset($_REQUEST['val']) && $_REQUEST['val'] == 'Unapprove')
            $this->db->where('product.product_is_inappropriate', 'Unapprove');
        elseif (isset($_REQUEST['val']) && $_REQUEST['val'] == 'NeedReview')
            $this->db->where('product.product_is_inappropriate', 'NeedReview');
        else
            $this->db->where('product.product_is_inappropriate', 'Approve');

        $this->db->where('product.product_deactivate IS NULL');
        $this->db->where('product.product_posted_by', $user_id);

        if ($search != NULL) {
            if ($search == 'new')
                $this->db->order_by('product.admin_modified_at', 'desc');
            elseif ($search == 'popular')
                $this->db->order_by('product.product_total_views', 'desc');
            else
                $this->db->order_by('product.product_posted_time', 'desc');
        } else
            $this->db->order_by('product.product_posted_time', 'desc');

        if ($user_status == 1)
            $this->db->where('product.is_delete', 3);
        else
            $this->db->where_in('product.is_delete', array(0, 6));

        if ($user_role != NULL && $user_role == 'storeUser')
            $this->db->where('product.product_for', 'store');
        elseif ($user_role != NULL && $user_role == 'generalUser')
            $this->db->where('product.product_for', 'classified');

        if ($request_from != NULL && $request_from == 'store' && in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {

            $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
            $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
            $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');

            $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
            $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');
            $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
            $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
            $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
            $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
            $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
            $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
            $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');
        }

        $this->db->group_by("product.product_id");
        $query = $this->db->get();
        $data = $query->num_rows();

        return $data;
    }

    function get_my_seller_listing($user_id = NULL, $start = NULL, $limit = NULL, $latest = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        if ($latest == NULL)
            $fea = '0';
        else
            $fea = '1';

        $fea_sql = 'if(featureads.product_id IS NOT NULL and CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and  featureads.dateExpire),' . $fea . ',"") as featured_ad';

        $this->db->select('ps.plate_source_name');
        $this->db->select('cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
        $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
        $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

        $this->db->select('if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number', FALSE);
        $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

        $this->db->select('product.address,product.product_id,product.category_id,product.sub_category_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.category_id,category.catagory_name,user.username, user.profile_picture, product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,product.product_total_likes,product.product_slug,user.user_slug,brand.name bname,model.name mname,if(featureads.product_id IS NOT NULL and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire),1,"") as featured_ad,state.state_name,product.latitude,product.longitude,state.latitude state_latitude, state.longitude state_longitude');

        $this->gallery_count('product');

        $this->db->from('product');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
        $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
        $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');

        $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
        $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');

        $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
        $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
        $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
        $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
        $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
        $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');

        $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');
//        $this->db->join('(select count(*) count_image, product_id sub_product_id  from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');
        $this->db->join('featureads', 'featureads.product_id = product.product_id', 'left');

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');
        $this->db->where('product.is_delete', 0);

        if ($user_id != NULL)
            $this->db->where('product.product_posted_by', $user_id);

        $this->db->where('product.product_for', 'classified');

        if ($latest != NULL) {
            
        } else
            $this->db->order_by('featured_ad', 'desc');

        if (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'lh')
            $this->db->order_by('product.product_price', 'asc');
        elseif (isset($_REQUEST['order']) && $_REQUEST['order'] != '' && $_REQUEST['order'] == 'hl')
            $this->db->order_by('product.product_price', 'desc');
        else
            $this->db->order_by('product.product_posted_time', 'desc');

//        if($this->session->userdata('request_for_statewise')!='')
        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }


        $this->db->group_by("product.product_id");
        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }
        $query = $this->db->get();

        $data = $query->result_array();

        return $data;
    }

    function seller_listing_count($user_id = NULL) {

        $sel_str = '';
        $where = '';

        if ($user_id != NULL)
            $where = " AND product.product_posted_by = '" . (int) $user_id . "'";

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $sel_str = ' AND product.state_id=' . $selected_state_id;
        }

        $sel_query = "SELECT product.product_id FROM product JOIN category ON category.category_id = product.category_id JOIN user ON user.user_id = product.product_posted_by LEFT JOIN product_realestate_extras ON product_realestate_extras.product_id = product.product_id LEFT JOIN product_vehicles_extras ON product_vehicles_extras.product_id = product.product_id LEFT JOIN mileage ON mileage.mileage_id=product_vehicles_extras.millage LEFT JOIN color ON color.id=product_vehicles_extras.color WHERE product.product_is_inappropriate = 'Approve' AND product.product_deactivate IS NULL AND product.is_delete =0  and product.product_for='classified' " . $where . $sel_str . " GROUP BY product.product_id";

        $product_count = $this->db->query($sel_query);

        return $product_count->num_rows();
    }

    function getBanner_array($type = NULL, $display = NULL, $cat_id = NULL, $sub_cat_id = NULL, $not_this = NULL, $store_id = NULL) {

        $date_wh = 'CURDATE() between expiry_start_date and expiry_end_date';
        $dis_sql = ' display_page in (' . $display . ')';

        $this->db->select('*');
        $this->db->where('ban_type_name', $type);
        $this->db->where('pause_banner', 'no');
        $this->db->where($dis_sql);

        $this->db->where('status', 1);
        $this->db->where('IF(bidding_option = "cpm" , impression_count < impression_day,if(bidding_option = "cpc",click_count < clicks_day,(((CURDATE() between expiry_start_date and expiry_end_date) and expiry_end_date<>"0000-00-00") or (expiry_start_date<=CURDATE() and is_endate=1))))');

        $this->db->order_by("RAND()");
        $this->db->group_by("custom_banner.ban_id");

        if ($not_this != NULL)
            $this->db->where('ban_id<>' . $not_this);

        $this->db->limit('1');

        $query = $this->db->get('custom_banner');
        $res = $query->result_array();

        $mydata = $query->result_array();
        return $mydata;
    }

    function check_duration($banner_id) {

        $cnt = $this->getnumofdetails_(' * from banner_cnt_duration where banner_id=' . $banner_id . ' and date=CURDATE()');
        if ($cnt == 0)
            return 'insert';
        else
            return 'update';
    }

    //insert/update banner count duration
    function insert_update_banner($in_up_var, $banner_id) {
        if ($in_up_var == 'insert') {
            $this->db->query('insert into banner_cnt_duration values (NULL,"' . $banner_id . '",1,"' . date('Y-m-d') . '")');
        } else {
            $impcount = $this->db->query('select count from banner_cnt_duration where banner_id=' . $banner_id . ' and date=CURDATE() limit 1')->row_array();
            $sum = (int) $impcount['count'] + 1;
            $this->db->query('update banner_cnt_duration set count=' . $sum . ' where  banner_id=' . $banner_id . ' and date(`date`)="' . date('Y-m-d') . '"');
        }
    }

    function get_cat_subcat($banner_id) {
        $q1 = $this->db->query('select * from category_banner where banner_id=' . $banner_id);
        $res = $q1->result_array();
        //echo '<pre>';
        $cat_sub_arr = array();
        foreach ($res as $r) {
            $cat_sub_arr[$r['category_id']] = $r['sub_category_id'];
        }
        // print_r($cat_sub_arr);
        // echo '<br>';
        return $cat_sub_arr;
    }

    //for banners 3 type banners: HEader, Sidebar,Between
    function getBanner($type = NULL, $display = NULL, $cat_id = NULL, $sub_cat_id = NULL) {

        $mydata = $this->getBanner_array($type, $display, $cat_id, $sub_cat_id);

        //print_r($mydata);
        if (sizeof($mydata) > 0 && $mydata[0]['ban_id'] != '') {
            $option = $mydata[0]['bidding_option'];

            $banner_cat = $this->get_cat_subcat($mydata[0]['ban_id']);

            if (isset($option) && $option == 'cpm') {
                $this->db->where('bidding_option', 'cpm');
                $this->db->where('impression_count < impression_day');
            } elseif (isset($option) && $option == 'cpc') {
                $this->db->where('bidding_option', 'cpc');
                $this->db->where('click_count < clicks_day');
            } elseif (isset($option) && $option == 'duration') {
                $this->db->where('bidding_option', 'duration');
                $date_wh1 = '((CURDATE() between expiry_start_date and expiry_end_date) or (expiry_start_date=CURDATE() and is_endate=0) )';
                $this->db->where($date_wh1);
                $this->db->where('bd.count < impression_day');
                $this->db->where('bd.date=CURDATE()');

                //check data exist or not
                $check_in_up = $this->check_duration($mydata[0]['ban_id']);
                if ($check_in_up != '')
                    $this->insert_update_banner($check_in_up, $mydata[0]['ban_id']);
            }

            $this->db->where_in('cat_id', array('', 0));
            $this->db->where_in('sub_cat_id', array('', 0));

            $dis_sql = ' display_page in (' . $display . ')';
            $this->db->where($dis_sql);
            $this->db->where('ban_type_name', $type);
            $this->db->where('status', 1);
            $this->db->join('banner_cnt_duration bd', 'bd.banner_id=custom_banner.ban_id', 'left');
            $this->db->join('category_banner cb', 'cb.banner_id=custom_banner.ban_id', 'left');
            $this->db->order_by("RAND()");
            $this->db->group_by("custom_banner.ban_id");
            $this->db->limit('1');

            $query1 = $this->db->get('custom_banner');
            $data = $query1->result_array();

//             echo $this->db->last_query();
//             echo '<br>'; 	

            return $data;
        }
    }

    //to display banner on category page
    function getBanner_forCategory($type = NULL, $display = NULL, $cat_id = NULL, $sub_cat_id = NULL, $not_this = NULL, $store_id = NULL, $user_company_id = NULL) {

        $mydata = $this->getBanner_array($type, $display, $cat_id, $sub_cat_id, $not_this, $store_id);

        if (sizeof($mydata) > 0) {
            //print_r($mydata);
            if (sizeof($mydata) > 0 && $mydata[0]['ban_id'] != '') {

                if ((int) $store_id > 0 && $mydata[0]['store_id'] != '')
                    $this->db->where('FIND_IN_SET(' . $store_id . ',store_id)<>0');

                if ((int) $user_company_id > 0 && $mydata[0]['user_company_id'] != '')
                    $this->db->where('FIND_IN_SET(' . $user_company_id . ',user_company_id)<>0');

                $option = $mydata[0]['bidding_option'];

                $banner_cat = $this->get_cat_subcat($mydata[0]['ban_id']);

                if (isset($option) && $option == 'cpm') {
                    $this->db->where('bidding_option', 'cpm');
                    $this->db->where('impression_count < impression_day');
                } elseif (isset($option) && $option == 'cpc') {
                    $this->db->where('bidding_option', 'cpc');
                    $this->db->where('click_count < clicks_day');
                } elseif (isset($option) && $option == 'duration') {
                    $this->db->where('bidding_option', 'duration');
                    $date_wh1 = '((CURDATE() between expiry_start_date and expiry_end_date and expiry_end_date<>"0000-00-00") or (expiry_start_date<=CURDATE() and is_endate=1) )';

                    $this->db->where($date_wh1);
                    $this->db->where('bd.count < impression_day');
                    $this->db->where('bd.date=CURDATE()');

                    //check data exist or not
                    $check_in_up = $this->check_duration($mydata[0]['ban_id']);
                    if ($check_in_up != '')
                        $this->insert_update_banner($check_in_up, $mydata[0]['ban_id']);
                }

                if ($cat_id == NULL)
                    $cat_id = 0;
                if ($sub_cat_id == NULL)
                    $sub_cat_id = 0;

                $check_cat = 0;
                if ($mydata[0]['cat_id'] != '') {

                    if ($cat_id != '' && $sub_cat_id == 0) {

                        //$check_cat = 1;
                        $this->db->where('cb.category_id', (int) $cat_id);
                        $this->db->where('cb.sub_category_id', 0);
                        $this->db->where('cb.banner_id', (int) $mydata[0]['ban_id']);
                    } else {

                        $cat_arr = explode(",", $mydata[0]['cat_id']);
                        //print_r($cat_arr);
                        if (in_array($cat_id, $cat_arr)) {
                            // echo 'correct';
                            $cat_details = $this->db->query('select * from category_banner where banner_id=' . $mydata[0]['ban_id'] . ' and category_id=' . $cat_id . ' and category_id in (' . $mydata[0]['cat_id'] . ')');
                            $cat_result = $cat_details->result_array();

                            foreach ($cat_result as $cat_r) {

                                if ((int) $cat_r['category_id'] == (int) $cat_id && (int) $cat_r['sub_category_id'] == (int) $sub_cat_id) {

                                    $this->db->where('cb.category_id', (int) $cat_id);
                                    $this->db->where('cb.sub_category_id', (int) $sub_cat_id);
                                    $this->db->where('cb.banner_id', (int) $mydata[0]['ban_id']);
                                } elseif ((int) $cat_r['category_id'] == (int) $cat_id && (int) $cat_r['sub_category_id'] == 0) {

                                    $this->db->where('cb.category_id', (int) $cat_id);
                                    $this->db->where('cb.sub_category_id', 0);
                                    $this->db->where('cb.banner_id', (int) $mydata[0]['ban_id']);
                                } else {

                                    $this->db->where('cb.category_id', (int) $cat_id);
                                    $this->db->where('cb.sub_category_id', (int) $sub_cat_id);
                                    $this->db->where('cb.banner_id', (int) $mydata[0]['ban_id']);
                                }
                            }
                        } else {

                            $this->db->where('cb.category_id', (int) $cat_id);
                            $this->db->where('cb.sub_category_id', (int) $sub_cat_id);
                            $this->db->where('cb.banner_id', (int) $mydata[0]['ban_id']);
                            // if($type=='between')
                            //     echo 'inner-------------';
                        }
                    }
                } else {
                    // if($type=='between')
                    //     echo 'Outer';
                }

                $dis_sql = ' display_page in (' . $display . ')';
                $this->db->where('ban_id', $mydata[0]['ban_id']);

                if ($check_cat == 0)
                    $this->db->where($dis_sql);
                else
                    $this->db->where('display_page', 'all_page');

                $this->db->where('ban_type_name', $type);
                $this->db->where('status', 1);

                $this->db->join('banner_cnt_duration bd', 'bd.banner_id=custom_banner.ban_id', 'left');
                $this->db->join('category_banner cb', 'cb.banner_id=custom_banner.ban_id', 'left');
                $this->db->order_by("RAND()");
                $this->db->group_by("custom_banner.ban_id");

                if ($mydata[0]['ban_txt_img'] == 'image')
                    $this->db->where('big_img_file_name<>""');
                elseif ($mydata[0]['ban_txt_img'] == 'text')
                    $this->db->where('text_val<>""');

                $this->db->limit('1');

                $query1 = $this->db->get('custom_banner');
                $data = $query1->result_array();

                if (sizeof($data) == 0) {

                    $not_this = $mydata[0]['ban_id'];
                    return $this->getBanner_forCategory($type, $display, $cat_id, $sub_cat_id, $not_this);
                    break;
                    // return false;
                } else {
                    return $data;
                }
            }
        } else {
            return false;
        }
    }

    public function get_row($tablename, $array) {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get($tablename);
        $data = $query->row();
        return $data;
    }

    public function get_followers($user_id) {
        $this->db->select('*');
        $this->db->from('followed_seller fs');
        $this->db->join('user', 'user.user_id = fs.seller_id', 'left');
        $this->db->where('fs.seller_id', $user_id);

        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    public function get_myfollowerslist($user_id, $start, $limit, $following = NULL) {
        $this->db->select('*,user.user_id');
        $this->db->from('followed_seller fs');

        if ($following == NULL) {
            $this->db->join('user', 'user.user_id = fs.user_id', 'left');
            $this->db->where('fs.seller_id', $user_id);
        } else {
            $this->db->join('user', 'user.user_id = fs.seller_id', 'left');
            $this->db->where('fs.user_id', $user_id);
        }

        $this->db->where_not_in('user.is_delete', array(1, 4));

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    public function get_myfollowers_count($user_id, $following = NULL) {
        $this->db->select('*');
        $this->db->from('followed_seller fs');

        if ($following == NULL) {
            $this->db->join('user', 'user.user_id = fs.user_id', 'left');
            $this->db->where('fs.seller_id', $user_id);
        } else {
            $this->db->join('user', 'user.user_id = fs.seller_id', 'left');
            $this->db->where('fs.user_id', $user_id);
        }
        $this->db->where_not_in('user.is_delete', array(1, 4));

        $query = $this->db->get();

        $data = $query->num_rows();
        return $data;
    }

    public function get_myfollowers($seller_id, $user_id) {
        $this->db->select('*');
        $this->db->from('followed_seller fs');
        $this->db->join('user', 'user.user_id = fs.seller_id', 'left');
        //$this->db->where('fs.user_id' ,$seller_id);
        $this->db->where('fs.seller_id', $seller_id);
        $this->db->where('fs.user_id', $user_id);
        $this->db->where_not_in('user.is_delete', array(1, 4));

        $query = $this->db->get();

        $data = $query->num_rows();
        return $data;
    }

    function get_specific_colums($tblname, $fields, $where = null, $orderby_field = NULL, $order_type = NULL) {
        $this->db->distinct();
        $this->db->select($fields);
        $this->db->from($tblname);
        if (!empty($where)) {
            if (is_array($where)) {
                foreach ($where as $key => $value) {
                    $this->db->where($key, $value);
                }
            } elseif (is_string($where)) {
                $this->db->where($where);
            }
        }

        $this->db->order_by($orderby_field, $order_type);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    function join_on_pages() {
        $this->db->select('p1.page_id, p1.parent_page_id, p1.page_title, p2.page_title as `parent_title`');
        $this->db->from('pages_cms p1');
        $this->db->join('pages_cms p2', 'p1.parent_page_id = p2.page_id');
        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    function get_my_favorites($user_id, $start, $limit, $like = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->select('product.product_id,product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_is_sold,user.facebook_id,user.twitter_id,user.google_id,product.product_slug,product.product_total_likes,user.user_slug,product.product_for,s.store_domain, state.state_name,product.latitude,product.longitude,state.latitude state_latitude, state.longitude state_longitude,product.address,product.category_id');

        $this->gallery_count('product');
        $this->db->from('product');

        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        $this->db->join('store s', 's.store_owner = product.product_posted_by', 'left');
//        $this->db->join('(select count(*) count_image, product_id sub_product_id  from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');
        $this->db->where('product.is_delete', 0);

        if ($like != NULL) {
            $this->db->where('lp.user_id', $user_id);
            $this->db->where('product.product_total_likes >', 0);
            $this->db->order_by('lp.user_id', 'desc');
        } else {
            $this->db->where('fp.user_id', $user_id);
            $this->db->where('product.product_total_favorite >', 0);
            $this->db->order_by('fp.user_id', 'desc');
        }

        $this->db->order_by('product.product_id', 'desc');
        $this->db->group_by('product.product_id');

        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
            $this->db->select('ps.plate_source_name');
            $this->db->select('product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,brand.name bname,model.name mname', FALSE);
            $this->db->select('cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
            $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->select('if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number,product.product_id');

            $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
            $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
            $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');

            $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
            $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');
            $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
            $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
            $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
            $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
            $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
            $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
            $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');
        }

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    function get_my_favorites_count($user_id, $like = NULL) {

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->select('product.product_id');

        $this->db->from('product');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
        $this->db->join('store s', 's.store_owner = product.product_posted_by', 'left');

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate is null');
        $this->db->where('product.is_delete', 0);

        if ($like != NULL) {
            $this->db->where('lp.user_id', $user_id);
            $this->db->where('product.product_total_likes >', 0);
        } else {
            $this->db->where('fp.user_id', $user_id);
            $this->db->where('product.product_total_favorite >', 0);
        }

        $this->db->group_by("product.product_id");

        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
            $this->db->select('ps.plate_source_name');
            $this->db->select('product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,brand.name bname,model.name mname', FALSE);
            $this->db->select('cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
            $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->select('if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
            $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
            $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');

            $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
            $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');
            $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
            $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
            $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
            $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
            $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
            $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
            $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');
        }
        $query = $this->db->get();

        $data = $query->num_rows();
        return $data;
    }

    function get_count($tblname, $where) {
        foreach ($where as $key => $value) {
            $this->db->where($key, $value);
        }
        $query = $this->db->get($tblname);
        $data = $query->num_rows();
        return $data;
    }

    function getcolorlist() {
        $query = $this->db->query('select color.* from color 
        left join settings on FIND_IN_SET(color.background_color, settings.val)
        where settings.id=4
        ');
        $data = $query->result_array();
        return $data;
    }

    function get_featured_ads($start, $limit = NULL, $list_request = NULL) {

        $this->db->select('featureads.product_id,featureads.User_Id,featureads.dateFeatured,featureads.dateExpire,featureads.cat_id,featureads.subcat_id,if(user.nick_name!="",user.nick_name,user.username) as username1,product.product_name,product.product_posted_by,product.product_price, user.*, category.*,product.product_image,product.product_is_sold,product.product_slug,user.user_slug,product.product_total_favorite,product.product_total_likes,state.state_name,product.latitude,product.longitude,state.latitude state_latitude, state.longitude state_longitude,if(featureads.product_id IS NOT NULL and (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire),1,"") as featured_ad', FALSE);

        $this->gallery_count('product');

        $this->db->from('featureads');
        $this->db->join('category', 'category.category_id = featureads.cat_id', 'left');
        $this->db->join('product', 'product.product_id = featureads.product_id', 'left');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
//        $this->db->join('(select count(*) count_image, product_id sub_product_id  from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');

        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate is null');

        $bet = '(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire)';

        $current_user = $this->session->userdata('gen_user');
        if (isset($current_user) && !empty($current_user)) {
            $this->db->join('like_product lp', 'lp.product_id = product.product_id', 'left');
            $this->db->join('favourite_product fp', 'fp.product_id = product.product_id', 'left');

            $this->db->select('if(lp.product_id=product.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=product.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite', FALSE);
        }

        $this->db->where($bet);
        $this->db->where('product.is_delete', 0);
        $this->db->where('product.product_for', 'classified');

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        if ($list_request != NULL) {
            $this->db->select('ps.plate_source_name');
            $this->db->select('product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,brand.name bname,model.name mname', FALSE);
            $this->db->select('cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
            $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->select('if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
            $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
            $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');

            $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
            $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');
            $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
            $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
            $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
            $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
            $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
            $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
            $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');
        }

        $this->db->order_by('featureads.id', 'desc');
        $this->db->group_by("product.product_id");

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    function get_featured_ads_count($list_request = NULL) {
        $this->db->select('featureads.product_id,featureads.User_Id,featureads.dateFeatured,featureads.dateExpire,featureads.cat_id,featureads.subcat_id,if(user.nick_name!="",user.nick_name,user.username) as username1, product.*, user.*, category.*');
        $this->db->from('featureads');
        $this->db->join('category', 'category.category_id = featureads.cat_id', 'left');
        $this->db->join('product', 'product.product_id = featureads.product_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
//        $this->db->join('(select count(*) count_image, product_id sub_product_id  from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');
        $this->db->where('product.product_is_inappropriate', 'Approve');
        $this->db->where('product.product_deactivate IS NULL');
        $this->db->where('product.product_for', 'classified');

        $bet = 'CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between featureads.dateFeatured and featureads.dateExpire';
        $this->db->where($bet);
        $this->db->where('product.is_delete', 0);

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }
        if ($list_request != NULL) {
            $this->db->select('ps.plate_source_name');
            $this->db->select('product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,brand.name bname,model.name mname', FALSE);
            $this->db->select('cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
            $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->select('if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
            $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
            $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');

            $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
            $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');
            $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
            $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
            $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
            $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
            $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
            $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
            $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');
        }

        $this->db->group_by("product.product_id");

        $query = $this->db->get();
        $cnt = $query->num_rows();

        return $cnt;
    }

    function getbrandlist() {
        $query = $this->db->query('select brand.* from brand 
        left join settings on FIND_IN_SET(brand.brand_id, settings.val)
        where settings.id=5
        ');
        $data = $query->result_array();
        return $data;
    }

    function getmileagelist() {
        $query = $this->db->query('select mileage.* from mileage
        left join settings on FIND_IN_SET(mileage.mileage_id, settings.val)
        where settings.id=6
        ');
        $data = $query->result_array();
        return $data;
    }

    function get_my_deactivateads($user_id, $start, $limit, $user_role = NULL) {
        $this->db->select('product.product_posted_by,product.product_posted_time,product.product_name,product.product_image,product.product_price,product.product_status,product.product_is_inappropriate,product.product_total_views,product.product_total_favorite,product.product_total_likes,category.catagory_name,user.username, user.profile_picture,if(user.nick_name!="",user.nick_name,user.username) as username1,user.facebook_id,user.twitter_id,user.google_id,user.user_slug,product.product_slug,product.product_is_sold,state.state_name,product.latitude,product.longitude,state.latitude state_latitude, state.longitude state_longitude,product.category_id,product.product_id,product.address');

        $this->gallery_count('product');

        $this->db->from('product');
        $this->db->join('state', 'state.state_id = product.state_id', 'left');
        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');
//        $this->db->join('(select count(*) count_image, product_id sub_product_id  from products_images pm group by pm.product_id) k', 'product.product_id=sub_product_id', 'left');
        $this->db->join('products_images pi', 'product.product_id = pi.product_id', 'left');

        $this->db->where_in('product.is_delete', array(0, 3));
        $this->db->where('product.product_is_sold<>1');
        $this->db->where('product.product_deactivate', 1);
        $this->db->where('user.user_id', $user_id);
        $this->db->where('product.product_is_inappropriate', 'NeedReview');

        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
            $this->db->select('ps.plate_source_name');
            $this->db->select('product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,brand.name bname,model.name mname', FALSE);
            $this->db->select('cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
            $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->select('if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number, product.product_id', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
            $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
            $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');

            $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
            $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');
            $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
            $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
            $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
            $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
            $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
            $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
            $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');
        }
        if ($user_role != NULL && $user_role == 'storeUser')
            $this->db->where('product.product_for', 'store');
        elseif ($user_role != NULL && $user_role == 'generalUser')
            $this->db->where('product.product_for', 'classified');

        $this->db->order_by('product.product_posted_time', 'desc');
        $this->db->group_by("product.product_id");

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    function get_my_deactivateads_count($user_id, $user_role) {
        $this->db->select('product.product_id');

        $this->db->from('product');

        $this->db->join('category', 'category.category_id = product.category_id', 'left');
        $this->db->join('user', 'user.user_id = product.product_posted_by', 'left');

        $this->db->where_in('product.is_delete', array(0, 3));
        $this->db->where('product.product_is_sold<>1');
        $this->db->where('product.product_deactivate', 1);
        $this->db->where('user.user_id', $user_id);
        $this->db->where('product.product_is_inappropriate', 'NeedReview');

        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {
            $this->db->select('ps.plate_source_name');
            $this->db->select('product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,if(user.nick_name!="",user.nick_name,user.username) as username1,user.nick_name,product.product_is_sold,mileage.name mileagekm,color.name colorname,user.facebook_id,user.twitter_id,user.google_id,brand.name bname,model.name mname', FALSE);
            $this->db->select('cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix', FALSE);
            $this->db->select('if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->select('if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number, product.product_id', FALSE);
            $this->db->select('mo.operator_name as mobile_operator,cmn.mobile_number');

            $this->db->join('product_realestate_extras', 'product_realestate_extras.product_id = product.product_id', 'left');
            $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id = product.product_id', 'left');
            $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');

            $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
            $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');
            $this->db->join('car_mobile_numbers cmn', 'cmn.product_id = product.product_id', 'left');
            $this->db->join('mobile_operators mo', 'mo.id = cmn.mobile_operator', 'left');
            $this->db->join('plate_source ps', 'ps.id = cmn.plate_source', 'left');
            $this->db->join('plate_prefix ppx', 'ppx.id=cmn.plate_prefix', 'left');
            $this->db->join('plate_digit pd', 'pd.id = cmn.plate_digit', 'left');
            $this->db->join('repeating_numbers rn', 'rn.id = cmn.repeating_number', 'left');
            $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');
        }

        if ($user_role != NULL && $user_role == 'storeUser')
            $this->db->where('product.product_for', 'store');
        elseif ($user_role != NULL && $user_role == 'generalUser')
            $this->db->where('product.product_for', 'classified');

        $this->db->group_by("product.product_id");

        $query = $this->db->get();

        $data = $query->num_rows();
        return $data;
    }

    function product_vehicles_extras($product_id) {
        $this->db->select('product.product_id,brand.name bname,model.name mname,product_vehicles_extras.millage,product_vehicles_extras.color,product_vehicles_extras.type_of_car,product_vehicles_extras.year,product_vehicles_extras.make,product_vehicles_extras.vehicle_condition,mileage.name mileagekm,color.name colorname,product.stock_availability,state.latitude state_latitude,state.longitude state_longitude');

        $this->db->from('product');
        $this->db->join('state', 'state.state_id=product.state_id', 'left');
        $this->db->join('brand', 'brand.brand_id=product.product_brand', 'left');
        $this->db->join('product_vehicles_extras', 'product_vehicles_extras.product_id=product.product_id', 'left');
        $this->db->join('model', 'model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id', 'left');
        $this->db->join('mileage', 'mileage.mileage_id=product_vehicles_extras.millage', 'left');
        $this->db->join('color', 'color.id=product_vehicles_extras.color', 'left');

        $this->db->where_in('product.is_delete', array(0, 3));
        $this->db->where('product.product_id', $product_id);

        $this->db->where('product.product_deactivate IS NULL');
        $this->db->order_by("product.product_posted_time", "desc");
        $this->db->group_by("product.product_id");

        $query = $this->db->get();
        return $query->row();
    }

    function count_product_cat($sub_cat) {

        $this->db->select('count(product_id) as cnt');

        $this->db->where('sub_category_id', $sub_cat);
        $this->db->where('product_is_inappropriate', 'Approve');
        $this->db->where('product_deactivate IS NULL');
        $this->db->where('is_delete', 0);
        $this->db->where('product_for', 'classified');

//        if($this->session->userdata('request_for_statewise')!='')
//            $this->db->where('state_id',$this->session->userdata('request_for_statewise'));
        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->state_id(state_id_selection);
            $this->db->where('product.state_id', $selected_state_id);
        }

        $this->db->from('product');

        $query = $this->db->get();
        $res = $query->row();

        return $res->cnt;
    }

    public function pagination($url = NULL, $where = NULL, $per_page = NULL, $count = NULL) {

        $config = array();
        $config["base_url"] = $url;
        $config["total_rows"] = $this->dbcommon->getnumofdetails_($where);
        $config["per_page"] = ($per_page) ? $per_page : $this->per_page;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);
        if ($count != NULL && $count == 'yes') {
            $ret_arr = array();
            $ret_arr['total_rows'] = $config["total_rows"];
            $ret_arr['links'] = $this->pagination->create_links();
            return $ret_arr;
        } else
            return $this->pagination->create_links();
    }

    function pagination_front($total_product, $url) {
        $config = array();
        $config["base_url"] = $url;
        $config["total_rows"] = $total_product;
        $config["per_page"] = 12;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&lt;&lt;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '&gt;&gt;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><p>';
        $config['cur_tag_close'] = '</p></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        return $config;
    }

    //get product availibiity based on User Role
    public function product_availability($add_days = NULL) {
        $ads_cnt = array();
        $ret_arr = array();
        if ($add_days != NULL)
            $add_days = $add_days;
        else
            $add_days = 0;

        $query_settings = ' id=1 and `key`="adv_availability_classified_user" limit 1';
        $ads_cnt = $this->dbcommon->filter('settings', $query_settings);

        if (!empty($ads_cnt[0]['val']) && (int) $ads_cnt[0]['val'] > 0)
            $ret_arr[$ads_cnt[0]['key']] = (int) $ads_cnt[0]['val'] + (int) $add_days;
        else
            $ret_arr[$ads_cnt[0]['key']] = (int) default_ads_availability + (int) $add_days;


        $query_settings = ' id=12 and `key`="adv_availability_offer_user" limit 1';
        $ads_cnt = $this->dbcommon->filter('settings', $query_settings);

        if (!empty($ads_cnt[0]['val']) && (int) $ads_cnt[0]['val'] > 0)
            $ret_arr[$ads_cnt[0]['key']] = (int) $ads_cnt[0]['val'] + (int) $add_days;
        else
            $ret_arr[$ads_cnt[0]['key']] = (int) default_ads_availability + (int) $add_days;


        $query_settings = ' id=10 and `key`="adv_availability_store_user" limit 1';
        $ads_cnt = $this->dbcommon->filter('settings', $query_settings);

        if (!empty($ads_cnt[0]['val']) && (int) $ads_cnt[0]['val'] > 0)
            $ret_arr[$ads_cnt[0]['key']] = (int) $ads_cnt[0]['val'] + (int) $add_days;
        else
            $ret_arr[$ads_cnt[0]['key']] = (int) default_ads_availability + (int) $add_days;


        $query_settings = ' id=2 and `key`="adv_availability_admin" limit 1';
        $ads_cnt = $this->dbcommon->filter('settings', $query_settings);

        if (!empty($ads_cnt[0]['val']) && (int) $ads_cnt[0]['val'] > 0)
            $ret_arr[$ads_cnt[0]['key']] = (int) $ads_cnt[0]['val'] + (int) $add_days;
        else
            $ret_arr[$ads_cnt[0]['key']] = (int) default_ads_availability + (int) $add_days;

        return $ret_arr;
    }

    /*
     * Deactivate to Offer Ads     * 
     */

    public function deactivate_offer_ads() {

        $no_of_ads = $this->product_availability();

        if (isset($no_of_ads["adv_availability_offer_user"]) && (int) $no_of_ads["adv_availability_offer_user"] > 0)
            $ads = $no_of_ads["adv_availability_offer_user"];
        else
            $ads = default_ads_availability;

        $this->db->having('(st_end+end_now)>' . (int) $ads);

        $this->db->select('o.offer_id,o.offer_posted_by,u.user_id,u.user_role,o.offer_approve_date');
        $this->db->select('DATEDIFF(o.offer_end_date,o.offer_start_date) st_end , DATEDIFF(CURDATE(),o.offer_end_date) as end_now', FALSE);

        $this->db->where('u.is_delete<>1');
        $this->db->where('u.user_role', 'offerUser');
        $this->db->where('o.is_delete<>1');
        $this->db->where('o.is_enddate', 0);
        $this->db->where('o.offer_is_approve', 'approve');
        $this->db->where('o.offer_approve_date<>"0000-00-00 00:00:00"');
        $this->db->where('o.offer_approve_date IS NOT NULL');
        $this->db->where('o.offer_end_date<=CURDATE()');

        $this->db->join('user u', 'u.user_id=o.offer_user_company_id', 'left');

        $this->db->group_by('o.offer_id');
        $this->db->order_by('o.offer_id');
        $q1 = $this->db->get('offers o');

        $result = $q1->result_array();
        $in_data = array();
        $up_data = array();

        foreach ($result as $res) {

            $this->db->select('f.*');
            $this->db->where('f.offer_id', $res['offer_id']);

            $wh_date = 'date_format(f.end_date,"%Y-%m-%d") >= CURDATE()';
            $this->db->where($wh_date);
            $q2 = $this->db->get('featured_offers f');
            $result2 = $q2->result_array();

            if (sizeof($result2) > 0) {
                
            } else {
                $in_data[] = array('offer_id' => $res['offer_id'], 'ad_availability' => $ads, 'offer_approve_date' => $res['offer_approve_date']);

//                $this->insert('deactivated_offers', $in_data);
                //'offer_deactivate' => 1,
                $up_data[] = array('offer_id' => $res['offer_id'], 'offer_is_approve' => 'WaitingForApproval');
//                $wh_arr = array('offer_id' => $res['offer_id']);
//                $this->update('offers', $wh_arr, $up_data);
            }
        }
        if (isset($in_data) && sizeof($in_data) > 0)
            $this->db->insert_batch('deactivated_offers', $in_data);

        if (isset($up_data) && sizeof($up_data) > 0)
            $this->db->update_batch('offers', $up_data, 'offer_id');
    }

    public function update_deactivate_offer_ads() {

        $no_of_ads = $this->product_availability(update_deactivate_ads);

        if (isset($no_of_ads["adv_availability_offer_user"]) && (int) $no_of_ads["adv_availability_offer_user"] > 0)
            $ads = $no_of_ads["adv_availability_offer_user"];
        else
            $ads = default_ads_availability;

        $this->db->having('(st_end+end_now)>' . (int) $ads);

        $this->db->select('o.offer_id,o.offer_posted_on,u.user_id,u.user_role,o.offer_approve_date,o.is_delete');
        $this->db->select('DATEDIFF(o.offer_end_date,o.offer_start_date) st_end , DATEDIFF(CURDATE(),o.offer_end_date) as end_now', FALSE);
        $this->db->where('u.is_delete<>1');
        $this->db->where('o.is_delete<>1');
        $this->db->where('u.user_role', 'offerUser');
        $this->db->where('o.offer_is_approve', 'WaitingForApproval');
        $this->db->where('o.offer_approve_date<>"0000-00-00 00:00:00"');
        $this->db->where('o.offer_approve_date IS NOT NULL');

        $this->db->join('user u', 'u.user_id=o.offer_user_company_id', 'left');
        $q11 = $this->db->get('offers o');

        $result11 = $q11->result_array();
        $in_data = array();
        $up_data = array();
        foreach ($result11 as $rs11) {

            $in_data[] = array('offer_id' => $rs11['offer_id'],
                'ad_availability' => $ads,
                'is_delete' => $rs11['is_delete'],
                'offer_approve_date' => $rs11['offer_approve_date']
            );
//            $this->insert('updated_deactivate_offers', $in_data);

            $up_data[] = array('offer_id' => $rs11['offer_id'], 'is_delete' => 1);
//            $wh_arr = array('offer_id' => $rs11['offer_id']);
//            $this->update('offers', $wh_arr, $up_data);
        }
        if (isset($in_data) && sizeof($in_data) > 0)
            $this->db->insert_batch('updated_deactivate_offers', $in_data);

        if (isset($up_data) && sizeof($up_data) > 0)
            $this->db->update_batch('offers', $up_data, 'offer_id');
    }

    /*
     * Deactivate to Classified, Store Ads
     * 
     */

    public function deactivate_ads() {
        ini_set('max_execution_time', 18000);
        $no_of_ads = $this->product_availability();

        $str_ads_check = '(if(p.product_for="classified" AND (u.user_role="admin" or u.user_role="superadmin"),CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . $no_of_ads["adv_availability_admin"] . ' DAY),
    if(p.product_for="classified",CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . $no_of_ads["adv_availability_classified_user"] . ' DAY),if(p.product_for="store",CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . $no_of_ads["adv_availability_store_user"] . ' DAY),if(p.product_for="offer" , CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . $no_of_ads["adv_availability_offer_user"] . ' DAY),
    CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . default_ads_availability . ' DAY))))))';

        $this->db->select('p.product_id,p.product_posted_time,u.user_id,u.user_role,p.admin_modified_at');

        $this->db->select('(if(p.product_for="classified" AND (u.user_role="admin" OR u.user_role="superadmin"),' . $no_of_ads["adv_availability_admin"] . ',if(p.product_for="classified",' . $no_of_ads["adv_availability_classified_user"] . ',if(p.product_for="offer",' . $no_of_ads["adv_availability_offer_user"] . ', if(p.product_for="store",' . $no_of_ads["adv_availability_store_user"] . ',' . default_ads_availability . '))))) as days_availability', FALSE);

        $this->db->where('u.is_delete<>1');
        $this->db->where('p.is_delete<>1');
        $this->db->where('p.product_is_inappropriate', 'Approve');
        $this->db->where('p.admin_modified_at<>"0000-00-00 00:00:00"');
        $this->db->where('p.admin_modified_at IS NOT NULL');
        $this->db->where($str_ads_check);
        $this->db->where('(p.product_deactivate is null or p.product_deactivate=0)');

        $this->db->join('user u', 'u.user_id=p.product_posted_by', 'left');

        $this->db->group_by('p.product_id');
        $this->db->order_by('p.product_id');
        $q1 = $this->db->get('product p');

        $result = $q1->result_array();

        $in_data = array();
        $up_data = array();

        foreach ($result as $res) {

            $this->db->select('f.*');
            $this->db->where('f.product_id', $res['product_id']);

            $wh_date = 'date_format(f.dateExpire,"%Y-%m-%d") >= CURDATE()';
            $this->db->where($wh_date);
            $q2 = $this->db->get('featureads f');
            $result2 = $q2->result_array();
            if (sizeof($result2) > 0) {
                
            } else {

                $in_data[] = array('product_id' => $res['product_id'], 'ad_availability' => $res['days_availability'], 'admin_modified_at' => $res['admin_modified_at']);

//                $this->insert('deactivated_products', $in_data);

                $up_data[] = array('product_id' => $res['product_id'], 'product_deactivate' => 1, 'product_is_inappropriate' => 'NeedReview');
//                $wh_arr = array('product_id' => $res['product_id']);
//                $this->update('product', $wh_arr, $up_data);
            }
        }
        ini_set('max_execution_time', 18000);
        if (isset($in_data) && sizeof($in_data) > 0)
            $this->db->insert_batch('deactivated_products', $in_data);
        ini_set('max_execution_time', 18000);
        if (isset($up_data) && sizeof($up_data) > 0)
            $this->db->update_batch('product', $up_data, 'product_id');
        // exit;
    }

    //update product status after deactivate and not user in 90 days        
    public function update_deactivate_ads() {
        ini_set('max_execution_time', 18000);
        $no_of_ads = $this->product_availability(update_deactivate_ads);

        $str_ads_check = '(if(p.product_for="classified" AND (u.user_role="admin" OR u.user_role="superadmin"),CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . $no_of_ads["adv_availability_admin"] . ' DAY),if(p.product_for="store",CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . $no_of_ads["adv_availability_store_user"] . ' DAY),if(p.product_for="offer",CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . $no_of_ads["adv_availability_offer_user"] . ' DAY),if(p.product_for="classified" , CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . $no_of_ads["adv_availability_classified_user"] . ' DAY),CURDATE() > ADDDATE(date(p.admin_modified_at), INTERVAL ' . default_ads_availability . ' DAY))))))';

        $wh = '(p.product_is_sold=0  or p.product_is_sold is null or p.product_is_sold=1)';

        $this->db->select('p.product_id,p.product_posted_time,u.user_id,u.user_role,p.admin_modified_at,p.is_delete');

        $this->db->select('(if(p.product_for="classified" AND (u.user_role="admin" OR u.user_role="superadmin"),' . $no_of_ads["adv_availability_admin"] . ',if(p.product_for="store",' . $no_of_ads["adv_availability_store_user"] . ',if(p.product_for="offer",' . $no_of_ads["adv_availability_offer_user"] . ', if( p.product_for="generalUser",' . $no_of_ads["adv_availability_classified_user"] . ',' . default_ads_availability . '))))) as days_availability', FALSE);

        $this->db->where('u.is_delete<>1');
        $this->db->where('p.is_delete<>1');

        $this->db->where('p.product_is_inappropriate', 'NeedReview');
        $this->db->where('p.admin_modified_at<>"0000-00-00 00:00:00"');
        $this->db->where('p.admin_modified_at is not null');
        $this->db->where('p.product_deactivate', 1);
        $this->db->where($str_ads_check);

        $this->db->join('user u', 'u.user_id=p.product_posted_by', 'left');
        $q11 = $this->db->get('product p');

        $result11 = $q11->result_array();

        $in_data = array();
        $up_data = array();
        foreach ($result11 as $rs11) {

            $in_data[] = array('product_id' => $rs11['product_id'],
                'ad_availability' => $rs11['days_availability'],
                'is_delete' => $rs11['is_delete'],
                'admin_modified_at' => $rs11['admin_modified_at']
            );
//            $this->insert('updated_deactivate_ads', $in_data);

            $up_data[] = array('product_id' => $rs11['product_id'], 'is_delete' => 1);
//            $wh_arr = array('product_id' => $rs11['product_id']);
//            $this->update('product', $wh_arr, $up_data);
        }
        ini_set('max_execution_time', 18000);
        if (isset($in_data) && sizeof($in_data) > 0)
            $this->db->insert_batch('updated_deactivate_ads', $in_data);
        ini_set('max_execution_time', 18000);
        if (isset($up_data) && sizeof($up_data) > 0)
            $this->db->update_batch('product', $up_data, 'product_id');
    }

    public function users_ds_update() {
        //assign user specific period of month
        if (date('Y-m-d') == date('Y-m-01')) {

            $from_date = date('Y-m-d');
            $to_date = date('Y-m-t');

            $query_settings = '';

            $query_settings = ' id=3 and `key`="no_of_post_month_classified_user" limit 1';
            $classified = $this->dbcommon->filter('settings', $query_settings);

            if ((int) $classified[0]['val'] > 0)
                $cnt_ads_classified = $classified[0]['val'];
            else
                $cnt_ads_classified = default_no_of_ads;

            $query_settings = ' id=11 and `key`="no_of_post_month_offer_user" limit 1';
            $offer = $this->dbcommon->filter('settings', $query_settings);

            if ((int) $offer[0]['val'] > 0)
                $cnt_ads_offer = $offer[0]['val'];
            else
                $cnt_ads_offer = default_no_of_ads;

            $query_settings = ' id=9 and `key`="no_of_post_month_store_user" limit 1';
            $store = $this->dbcommon->filter('settings', $query_settings);

            if ((int) $store[0]['val'] > 0)
                $cnt_ads_store = $store[0]['val'];
            else
                $cnt_ads_store = default_no_of_ads;

            $chk_user = $this->db->query('select user_id,user_role,from_date,to_date,userAdsLeft,userTotalAds from user');

            $res_user = $chk_user->result_array();

            if ($chk_user->num_rows() > 0) {
                foreach ($res_user as $r) {

                    $data_user = array('user_id' => $r['user_id'],
                        'from_date' => $r['from_date'],
                        'to_date' => $r['to_date'],
                        'total_ads' => $r['userTotalAds'],
                        'ads_left' => $r['userAdsLeft']
                    );

                    $this->insert('user_old_data', $data_user);

                    $wh_user = array(
                        'status' => 'active',
                        'user_id' => $r['user_id']
                    );

                    $cnt_ads = default_no_of_ads;
                    if (isset($r['user_role']) && !empty($r['user_role'])) {
                        if ($r['user_role'] == 'generalUser')
                            $cnt_ads = $cnt_ads_classified;
                        elseif ($r['user_role'] == 'storeUser')
                            $cnt_ads = $cnt_ads_store;
                        elseif ($r['user_role'] == 'offerUser')
                            $cnt_ads = $cnt_ads_offer;
                    }
                    $up_user = array('userAdsLeft' => $cnt_ads,
                        'userTotalAds' => $cnt_ads,
                        'from_date' => $from_date,
                        'to_date' => $to_date
                    );

                    $this->update('user', $wh_user, $up_user);
                }
            }
        }
    }

    public function delete_buyer_seller_conversation() {
        $this->db->query('delete FROM buyer_seller_conversation WHERE created_at < NOW() - INTERVAL 3 MONTH');
    }

    public function get_conversation($product_id, $logged_user) {
        $this->db->select('*');
        $this->db->where('bs.product_id', $product_id);
        $this->db->where('bs.sender_id', $logged_user);
        $this->db->or_where('bs.receiver_id', $logged_user);

        $this->db->join('user u', 'u.user_id=bs.sender_id or u.user_id=bs.receiver_id', 'left');
        $this->db->group_by('bs.con_id');

        $query = $this->db->get('buyer_seller_conversation bs');
        $data = $query->result_array();
        //echo $this->db->last_query();
        return $data;
    }

    public function get_senders($product_id, $logged_user = NULL) {

        $this->db->select('bs.product_id,bs.con_id,bs.message,bs.created_at,bs.sender_id,bs.receiver_id,u.username uname,bs.product_id product_id,
        u.profile_picture upick,u1.profile_picture u1pick,u.facebook_id ufb,u1.facebook_id u1fb,
        u.twitter_id utwi,u1.twitter_id u1twei,u.google_id ugoo,u1.google_id u1goo,     
        u1.username u1name,u.user_id uid,u1.user_id u1id');

        $this->db->join('(SELECT bs1.con_id, max(bs1.sender_id) as latest FROM buyer_seller_conversation bs1 GROUP BY bs1.sender_id) t2', 'bs.sender_id=t2.latest and bs.con_id = t2.con_id', 'left');

        $this->db->join('user u', 'u.user_id=bs.sender_id', 'left');
        $this->db->join('user u1', 'u1.user_id=bs.receiver_id', 'left');

        $this->db->where('bs.product_id', $product_id);
        $this->db->where('(bs.sender_id=' . $logged_user . ' or bs.receiver_id=' . $logged_user . ')');
        $this->db->order_by('bs.con_id', 'DESC');
        $this->db->group_by('bs.sender_id');
        $query = $this->db->get('buyer_seller_conversation bs');

        $data = $query->result_array();

        return $data;
    }

    public function get_senders_admin($product_id, $start, $limit) {

        $this->db->select('bs.product_id,bs.con_id,bs.message,bs.created_at,bs.sender_id,bs.receiver_id,bs.product_owner,u.username uname,u.nick_name unick,bs.product_id product_id,u.profile_picture upick,u.facebook_id ufb,u.twitter_id utwi,u.google_id ugoo,u.user_id uid,p.product_posted_by');

        $this->db->join('user u', 'u.user_id=bs.sender_id', 'left');
        $this->db->join('product p', 'p.product_id=bs.product_id', 'left');

        $this->db->where('bs.product_id', $product_id);
        $this->db->where('p.product_posted_by<>bs.sender_id');
        $this->db->order_by('bs.con_id', 'DESC');
        $this->db->group_by('bs.sender_id');

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get('buyer_seller_conversation bs');

        $data = $query->result_array();

        return $data;
    }

    public function get_senders_count_admin($product_id) {

        $this->db->select('bs.product_id,bs.con_id,bs.message,bs.created_at,bs.sender_id,bs.receiver_id,bs.product_owner,u.username uname,u.nick_name unick,bs.product_id product_id,u.profile_picture upick,u.facebook_id ufb,u.twitter_id utwi,u.google_id ugoo,u.user_id uid,p.product_posted_by');

        $this->db->join('user u', 'u.user_id=bs.sender_id', 'left');
        $this->db->join('product p', 'p.product_id=bs.product_id', 'left');

        $this->db->where('bs.product_id', $product_id);
        $this->db->where('p.product_posted_by<>bs.sender_id');
        $this->db->order_by('bs.con_id', 'DESC');
        $this->db->group_by('bs.sender_id');
        $query = $this->db->get('buyer_seller_conversation bs');

        $count = $query->num_rows();

        return $count;
    }

    public function buyer_seller_conversation($product_id, $buyer_id, $product_owner) {

        $this->db->select('bsc.con_id,bsc.message,bsc.status,bsc.con_id,u.username uname,u.nick_name unick,bsc.product_id product_id,
        u.profile_picture upick,u1.profile_picture u1pick,u.facebook_id ufb,u1.facebook_id u1fb,
        u.twitter_id utwi,u1.twitter_id u1twei,u.google_id ugoo,u1.google_id u1goo,     
        u1.username u1name,u1.nick_name u1nick,u.user_id uid,u1.user_id u1id,bsc.created_at,bsc.status read_status,bsc.sender_id,bsc.receiver_id');

        $this->db->where('product_id', $product_id);
        $this->db->where('(bsc.sender_id =' . $buyer_id . ' or bsc.receiver_id =' . $buyer_id . ')');

        $this->db->join('user u', 'u.user_id=bsc.sender_id', 'left');
        $this->db->join('user u1', 'u1.user_id=bsc.receiver_id', 'left');

        $this->db->group_by('bsc.con_id');
        $this->db->order_by('bsc.con_id', 'ASC');
        $query = $this->db->get('buyer_seller_conversation bsc');

        $data = $query->result_array();

        return $data;
    }

    public function last_up_conv($product_id, $sender_id) {
        $current_user = $this->session->userdata('gen_user');

        $this->db->select('bs.con_id,bs.message,bs.created_at,if(sender_id=' . $current_user['user_id'] . ',"Sent","Replied") as mysent', FALSE);
        $this->db->where('(bs.sender_id =' . $sender_id . ' or bs.receiver_id =' . $sender_id . ')');
        $this->db->where('bs.product_id', $product_id);
        $this->db->order_by('bs.con_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('buyer_seller_conversation bs');
        $data = $query->row_array();

        return $data;
    }

    //for message code
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function last_up_inquiry($inquiry_id) {
        $current_user = $this->session->userdata('gen_user');
        $this->db->select('*');
        $this->db->where('i.inquiry_id', $inquiry_id);
        $this->db->where(('im.message_sent_to=' . $current_user['user_id'] . ' or message_posted_by=' . $current_user['user_id'] . ''));
        $this->db->order_by('im.message_id', 'DESC');
        $this->db->join('inquiry_message im', 'im.inquiry_id=i.inquiry_id', 'left');

        $this->db->limit(1);
        $query = $this->db->get('inquiry i');

        $data = $query->row_array();
        return $data;
    }

    function dateDiff($time1, $time2, $precision = 6) {
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }
        $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
        $diffs = array();

        foreach ($intervals as $interval) {
            $ttime = strtotime('+1 ' . $interval, $time1);
            $add = 1;
            $looped = 0;
            while ($time2 >= $ttime) {
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }

        $count = 0;
        $times = array();
        $data = '';
        foreach ($diffs as $interval => $value) {

            if ($count >= $precision) {
                break;
            }

            if ($value > 0) {
                //echo $interval.'=>'.$value.'<br>';
                if ($value != 1) {
                    //  $interval .= "s";
                }
                if ($interval == 'year')
                    $data = $value . ' yr';
                if ($interval == 'month') {
                    if ($value > 1)
                        $data = $value . ' months';
                    else
                        $data = $value . ' month';
                }
                if ($interval == 'day') {
                    if ($value > 1)
                        $data = $value . ' days';
                    else
                        $data = $value . ' day';
                }
                if ($interval == 'hour') {
                    if ($value > 1)
                        $data = $value . ' hrs';
                    else
                        $data = $value . ' hr';
                }
                if ($interval == 'minute') {
                    if ($value > 1)
                        $data = $value . ' mins';
                    else
                        $data = $value . ' min';
                }
                if ($interval == 'second') {
                    $data = $value . ' sec';
                }

                $times[] = $data; //$value . " " . $interval;

                $count++;
            }
        }

        if (!empty($times[0]))
            return $times[0];
        else
            return 1 . ' sec';
    }

    function myfavorite($product_id, $user_id) {

        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('favourite_product');
        $result = $query->num_rows();
        if ((int) $result > 0)
            $res = 1;
        else
            $res = 0;
        return $res;
    }

    function mylike($product_id, $user_id) {

        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('like_product');
        $result = $query->num_rows();
        if ((int) $result > 0)
            $res = 1;
        else
            $res = 0;
        return $res;
    }

    function getmainimag($product_id) {
        $this->db->select('IF(product_image IS NULL OR product_image="",0,1) main_img_count, 
						  IF(youtube_link IS NULL  OR youtube_link="",0,1) youyube_count,
						  IF(video_name IS NULL  OR video_name="",0,1) video_count');
        $this->db->where('product_id', $product_id);
        $this->db->limit('1');
        $que = $this->db->get('product');
        $cnt = $que->row_array();
        $sum = (int) $cnt['main_img_count'] + (int) $cnt['youyube_count'] + (int) $cnt['video_count'];
        return $sum;
    }

    function get_no_of_images($product_id) {
        $main_cnt = $this->getmainimag($product_id);
        $this->db->select('product_id');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('products_images');
        $res = (int) $query->num_rows() + (int) $main_cnt;
        return $res;
    }

    function getsub_category($category_id) {
        $this->db->select('*');
        $this->db->where('category_id', $category_id);
        $query = $this->db->get('sub_category');
        return $query->result_array();
    }

    public function crop_product_image($src, $width, $height, $destination, $folder, $file_name) {

        $height = 0;

        //$destination = $src;
        $type = strtolower(pathinfo($src, PATHINFO_EXTENSION));
        $allowed_type = array('png', 'jpeg', 'gif', 'jpg');
        $return = 0;
        if (in_array(strtolower($type), $allowed_type)) {
            list($w, $h) = getimagesize($src);

            $ratio = $w / $width;

            $height = $h / $ratio;

            $sourceRatio = $w / $h;
            $targetRatio = $width / $height;

            if ($sourceRatio < $targetRatio) {
                $scale = $w / $width;
            } else {
                $scale = $h / $height;
            }

            $widthPadding = $heightPadding = 0;

            $handle = finfo_open(FILEINFO_MIME);
            $mime_type = finfo_file($handle, $src);
            $mime_type = mime_content_type($src);
            switch (strtolower($mime_type)) {
                case 'image/gif':
                    $img_r = imagecreatefromgif($src);
                    $function = 'imagejgif';
                    break;
                case 'image/png':
                    $img_r = imagecreatefrompng($src);
                    $function = 'imagepng';
                    break;
                case 'image/jpg':
                    $img_r = imagecreatefromjpeg($src);
                    $function = 'imagejpeg';
                    break;
                case 'image/jpeg':
                    $img_r = imagecreatefromjpeg($src);
                    $function = 'imagejpeg';
                    break;
            }

            $dst_r = ImageCreateTrueColor($width, $height);
            //set white background
            $white = imagecolorallocate($dst_r, 255, 255, 255);
            imagefill($dst_r, 0, 0, $white);

            if ((in_array($folder, array('product_detail', 'offer_detail'))) && $w <= image_product_detail_width && $h <= image_product_detail_height) {
                copy($src, $destination);
                $return = 1;
            } elseif ($folder == 'medium' && $w <= image_medium_width && $h <= image_medium_height) {
                copy($src, $destination);
                $return = 1;
            } else {
                imagecopyresampled($dst_r, $img_r, 0, 0, $widthPadding, $heightPadding, $width, $height, $w, $h);
                if ($function($dst_r, $destination)) {
                    $return = 1;
                }
            }
            $WaterMark = '';
            $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
            $dest = document_root . product . 'medium/' . $file_name;

            $WaterMark = site_url() . 'assets/front/images/logoWmark.png';
            $dest = document_root . product . 'product_detail/' . $file_name;
            if (file_exists(document_root . product . 'product_detail/' . $file_name))
                $this->watermarkImage($file_name, $WaterMark, $dest, 50, 'product_detail');

            $dest = document_root . offers . 'offer_detail/' . $file_name;
            if ($folder == 'offer_detail' && file_exists(document_root . offers . 'offer_detail/' . $file_name)) {
                $this->watermarkOfferImage($file_name, $WaterMark, $dest, 50, 'offer_detail');
            }

            $WaterMark = site_url() . 'assets/front/images/small_watermark.png';
            $dest = document_root . product . 'small/' . $file_name;
        }
        // return $return;
    }

    public function watermarkImage($SourceFile, $WaterMark, $DestinationFile = NULL, $opacity, $folder) {
        //$dest	=	site_url().product.'original/'.
        if (!empty($SourceFile)) {
            list($txt, $ext) = explode(".", $SourceFile);
            $main_img = document_root . product . $folder . '/' . $SourceFile;
            $watermark_img = $WaterMark;
            $padding = 5;
            $opacity = $opacity;

            $watermark = imagecreatefrompng($watermark_img);

            $handle = finfo_open(FILEINFO_MIME);
            $mime_type = finfo_file($handle, $main_img);
            $mime_type = mime_content_type($main_img);
            switch (strtolower($mime_type)) {
                case 'image/gif':
                    $image = imagecreatefromgif($main_img);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($main_img);
                    break;
                case 'image/jpg':
                    $image = imagecreatefromjpeg($main_img);
                    break;
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($main_img);
                    break;
                    break;
            }

            //if(!$image || !$watermark) die("Error: main image or watermark could not be loaded!");

            $watermark_size = getimagesize($watermark_img);
            $watermark_width = $watermark_size[0];
            $watermark_height = $watermark_size[1];

            $image_size = getimagesize($main_img);
            $dest_x = $image_size[0] - $watermark_width - $padding;
            $dest_y = $image_size[1] - $watermark_height - $padding;

            // copy watermark on main image
            $newWatermarkWidth = $image_size[0] - 50;

            $marge_right = 10;
            $marge_bottom = 10;

            $sx = imagesx($watermark);
            $sy = imagesy($watermark);

            if ($folder == 'small')
                imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $opacity);
            else {
                $imageQuality = "100";
                $scaleQuality = round(($imageQuality / 100) * 9);
                $invertScaleQuality = 9 - $scaleQuality;
                imagepng($image, $DestinationFile, $invertScaleQuality);

                $marge_right = 10;
                $marge_bottom = 10;
                $sx = imagesx($watermark);
                $sy = imagesy($watermark);
                imagecopy($image, $watermark, imagesx($image) - $sx - $marge_right, imagesy($image) - $sy - $marge_bottom, 0, 0, imagesx($watermark), imagesy($watermark));
            }
            if ($DestinationFile <> '') {
                imagejpeg($image, $DestinationFile, 100);
            } else {
                header('Content-Type: image/jpeg');
                imagejpeg($image);
            }

            imagedestroy($image);
            imagedestroy($watermark);
        }
    }

    public function crop_store_cover_image($src = NULL, $width = NULL, $height = NULL, $destination = NULL, $folder = NULL, $file_name = NULL) {

        //$destination = $src;
        $type = strtolower(pathinfo($src, PATHINFO_EXTENSION));
        $allowed_type = array('png', 'jpeg', 'gif', 'jpg');
        $return = 0;
        if (in_array(strtolower($type), $allowed_type)) {
            list($w, $h) = getimagesize($src);

            $sourceRatio = $w / $h;
            $targetRatio = $width / $height;

            if ($sourceRatio < $targetRatio) {
                $scale = $w / $width;
            } else {
                $scale = $h / $height;
            }

            $cropWidth = $width * $scale;
            $cropHeight = $height * $scale;

            $widthPadding = ($w - $cropWidth) / 2;
            $heightPadding = ($h - $cropHeight) / 2;


            $handle = finfo_open(FILEINFO_MIME);
            $mime_type = finfo_file($handle, $src);
            $mime_type = mime_content_type($src);
            switch (strtolower($mime_type)) {
                case 'image/gif':
                    $img_r = imagecreatefromgif($src);
                    $function = 'imagejgif';
                    break;
                case 'image/png':
                    $img_r = imagecreatefrompng($src);
                    $function = 'imagepng';
                    break;
                case 'image/jpg':
                    $img_r = imagecreatefromjpeg($src);
                    $function = 'imagejpeg';
                    break;
                case 'image/jpeg':
                    $img_r = imagecreatefromjpeg($src);
                    $function = 'imagejpeg';
                    break;
            }

            $dst_r = ImageCreateTrueColor($width, $height);
            //set white background
            $white = imagecolorallocate($dst_r, 255, 255, 255);
            imagefill($dst_r, 0, 0, $white);

            $cropWidth = $width * $scale;
            $cropHeight = $height * $scale;

            imagecopyresampled($dst_r, $img_r, 0, 0, $widthPadding, $heightPadding, $width, $height, $cropWidth, $cropHeight);
            if ($function($dst_r, $destination)) {
                $return = 1;
            }
        }
    }

    public function crop_offer_image($src = NULL, $width = NULL, $height = NULL, $destination = NULL, $folder = NULL, $file_name = NULL) {

        $width = 0;

        //$destination = $src;
        $type = strtolower(pathinfo($src, PATHINFO_EXTENSION));
        $allowed_type = array('png', 'jpeg', 'gif', 'jpg');
        $return = 0;
        if (in_array(strtolower($type), $allowed_type)) {
            list($w, $h) = getimagesize($src);

            $ratio = $h / $height;
            $width = $w / $ratio;

            $sourceRatio = $w / $h;
            $targetRatio = $height / $width;

            if ($sourceRatio < $targetRatio) {
                $scale = $h / $height;
            } else {
                $scale = $w / $width;
            }

            $widthPadding = $heightPadding = 0;

            $handle = finfo_open(FILEINFO_MIME);
            $mime_type = finfo_file($handle, $src);
            $mime_type = mime_content_type($src);
            switch (strtolower($mime_type)) {
                case 'image/gif':
                    $img_r = imagecreatefromgif($src);
                    $function = 'imagejgif';
                    break;
                case 'image/png':
                    $img_r = imagecreatefrompng($src);
                    $function = 'imagepng';
                    break;
                case 'image/jpg':
                    $img_r = imagecreatefromjpeg($src);
                    $function = 'imagejpeg';
                    break;
                case 'image/jpeg':
                    $img_r = imagecreatefromjpeg($src);
                    $function = 'imagejpeg';
                    break;
            }

            $dst_r = ImageCreateTrueColor($width, $height);
            //set white background
            $white = imagecolorallocate($dst_r, 255, 255, 255);
            imagefill($dst_r, 0, 0, $white);

            imagecopyresampled($dst_r, $img_r, 0, 0, $widthPadding, $heightPadding, $width, $height, $w, $h);
            if ($function($dst_r, $destination)) {
                $return = 1;
            }
        }
        // return $return;
    }

    public function watermarkOfferImage($SourceFile, $WaterMark, $DestinationFile = NULL, $opacity, $folder) {

        if (!empty($SourceFile)) {
            list($txt, $ext) = explode(".", $SourceFile);
            $main_img = document_root . offers . $folder . '/' . $SourceFile;
            $watermark_img = $WaterMark;
            $padding = 5;
            $opacity = $opacity;

            $watermark = imagecreatefrompng($watermark_img);

            $handle = finfo_open(FILEINFO_MIME);
            $mime_type = finfo_file($handle, $main_img);
            $mime_type = mime_content_type($main_img);
            switch (strtolower($mime_type)) {
                case 'image/gif':
                    $image = imagecreatefromgif($main_img);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($main_img);
                    break;
                case 'image/jpg':
                    $image = imagecreatefromjpeg($main_img);
                    break;
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($main_img);
                    break;
                    break;
            }

            $watermark_size = getimagesize($watermark_img);
            $watermark_width = $watermark_size[0];
            $watermark_height = $watermark_size[1];

            $image_size = getimagesize($main_img);
            $dest_x = $image_size[0] - $watermark_width - $padding;
            $dest_y = $image_size[1] - $watermark_height - $padding;

            // copy watermark on main image
            $newWatermarkWidth = $image_size[0] - 50;

            $marge_right = 10;
            $marge_bottom = 10;

            $sx = imagesx($watermark);
            $sy = imagesy($watermark);

            if ($folder == 'small')
                imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $opacity);
            else {
                $imageQuality = "100";
                $scaleQuality = round(($imageQuality / 100) * 9);
                $invertScaleQuality = 9 - $scaleQuality;
                imagepng($image, $DestinationFile, $invertScaleQuality);

                $marge_right = 10;
                $marge_bottom = 10;
                $sx = imagesx($watermark);
                $sy = imagesy($watermark);
                imagecopy($image, $watermark, imagesx($image) - $sx - $marge_right, imagesy($image) - $sy - $marge_bottom, 0, 0, imagesx($watermark), imagesy($watermark));
            }
            if ($DestinationFile <> '') {
                imagejpeg($image, $DestinationFile, 100);
            } else {
                header('Content-Type: image/jpeg');
                imagejpeg($image);
            }

            imagedestroy($image);
            imagedestroy($watermark);
        }
    }

    public function getstore_id($user_id) {

        $this->db->select('*');
        $this->db->where('store_owner', $user_id);
        $this->db->from('store');

        $query = $this->db->get();
        $user_data = $query->row_array();
        return $user_data;
    }

    /*     * *
      generate slug for category,sub-category, product,user,etc...
     * * */

    function generate_slug($string = NULL, $for = NULL) {

        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        if ($for == 'P')
            $for1 = 'P_';
        else
            $for1 = $for . '_';

        $t = time();
        $time = date("dhi", $t);
        $total = rand() + $time;
        $rand_number = substr($total, 0, 6);

        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string) . '-' . $rand_number; // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    function mail_format($title = NULL, $content = NULL) {

        $email_logo = 'http://doukani.com/assets/front/emailt-template/img/email-logo.png';
        $email_watermark = HTTPS . website_url . 'assets/front/emailt-template/img/email-watermark.png';
        $google_play = HTTPS . website_url . 'assets/front/emailt-template/img/google-play.png';
        $app_store = HTTPS . website_url . 'assets/front/emailt-template/img/app-store.png';
        $facebook = HTTPS . website_url . 'assets/front/emailt-template/img/email-facebook.png';
        $twitter = HTTPS . website_url . 'assets/front/emailt-template/img/email-twitter.png';
        $youtube = HTTPS . website_url . 'assets/front/emailt-template/img/email-youtube.png';
        $instagram = HTTPS . website_url . 'assets/front/emailt-template/img/email-instragram.png';

        $getpage_url = '';
        $facebook_link = $this->getpageurl(17);
        $twitter_link = $this->getpageurl(18);
        $youtube_link = $this->getpageurl(24);
        $instagram_link = $this->getpageurl(19);

        $mail_format = '
        <style>
            .mail-body,
            .mail-head{ display:inline-block;}
    
        </style>
    
        <body style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0;">
    <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:30px; padding-right:0; padding-bottom:30px; padding-left:0; background:#f6f6f6;">
        <div style="margin-top:0; margin-right:auto; margin-bottom:a; margin-left:auto; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; max-width:664px;">
            <div style="margin-top:0; margin-right:0; margin-bottom:30px; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; border:1px solid #d6d6d6; background:#fff;">
                <div class="mail-head" style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; background:#f5f5f5; display:inline-block; vertical-align:top; width:100%;">
                    <table style="width:100%; vertical-align:middle;">
                        <tr>
                            <td style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:15px;; text-align:left; color:#000; font-size:20px; font-weight:700; font-family: Roboto, sans-serif; line-height:50px;">' . $title . '</td>
                            <td style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:15px; padding-bottom:0; padding-left:0; text-align:right;"><a href="http://doukani.com" style="display:block; heigh:22px;"><img src="http://doukani.com/assets/front/emailt-template/img/email-logo.png" alt="Doukani"/></a></td>
                        </tr>
                    </table>
                </div>  
                    
                <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:40px; padding-right:50px; padding-bottom:20px; padding-left:50px;">
                    <table style="width:100%; vertical-align:middle; margin:0 0 30px;">
                        <tr>
                            <td style=" margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; position:relative; display:inline-block; vertical-align:top; width:100%; ">
                                <img src="' . $email_watermark . '" alt="" />
                            </td>
                            <td>
                                ' . $content . '
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:15px; padding-right:0; padding-bottom:15px; padding-left:0; background:#f6f6f6; text-align:center;">
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
        return $mail_format;
    }

    function getpageurl($id) {
        $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
        $array = array('page_state' => 1, 'page_id' => $id);
        $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

        if ($header_menu[0]['direct_url'] != '')
            $contact_url = $header_menu[0]['direct_url'];
        else
            $contact_url = site_url() . $header_menu[0]['slug_url'];

        return $contact_url;
    }

    public function get_data_advanced($start, $limit) {

        if (isset($_REQUEST['default']) || isset($_REQUEST['vehicle_submit']) || isset($_REQUEST['real_estate_submit']) || isset($_REQUEST['shared_submit']) || isset($_REQUEST['car_number_submit']) || isset($_REQUEST['mobile_number_submit'])) {
            //exit;
            // Filteration
            $cat_id = $this->input->get_post("cat_id");
            $sub_cat_id = $this->input->get_post("sub_cat");
            $country_id = $this->input->get_post("location");
            $city_id = $this->input->get_post("city");
            $min_amount = $this->input->get_post("from_price");
            $max_amount = $this->input->get_post("to_price");

            $where = "";
            if ($cat_id != "0" && $cat_id != '')
                $where .= " and p.category_id = '" . $cat_id . "' ";
            if ($sub_cat_id != "0" && $sub_cat_id != '')
                $where .= " and p.sub_category_id = '" . $sub_cat_id . "' ";
            if ($country_id != "0" && $country_id != '')
                $where .= " and p.country_id = '" . $country_id . "' ";

            if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
                $selected_state_id = $this->dbcommon->state_id(state_id_selection);
                $where .= " and p.state_id = " . $selected_state_id . ' ';
            } else {
                if ($city_id != "0" && $city_id != '')
                    $where .= " and p.state_id = $city_id" . ' ';
            }

            if (isset($_REQUEST['default'])) {
                if ($min_amount != "" && $max_amount != "")
                    $where .= " and p.product_price between '" . $min_amount . "'  and  '" . $max_amount . "' ";
                else if ($min_amount != "")
                    $where .= " and p.product_price >= '" . $min_amount . "' ";
                else if ($max_amount != "")
                    $where .= " and p.product_price <= '" . $max_amount . "' ";
            }
            elseif (isset($_REQUEST['vehicle_submit'])) {
                $pro_brand = $this->input->get_post("pro_brand");
                $vehicle_pro_model = $this->input->get_post("vehicle_pro_model");
                $vehicle_pro_year = $this->input->get_post("vehicle_pro_year");
                $vehicle_pro_mileage = $this->input->get_post("vehicle_pro_mileage");
                $vehicle_pro_color = $this->input->get_post("vehicle_pro_color");
                $vehicle_pro_type_of_car = $this->input->get_post("vehicle_pro_type_of_car");


                if ($pro_brand != "0" && $pro_brand != "")
                    $where .= ' and p.product_brand= "' . (int) $pro_brand . '" ';
                if ($vehicle_pro_model != "0" && $vehicle_pro_model != "")
                    $where .= ' and v.model= "' . (int) $vehicle_pro_model . '" ';
                if ($vehicle_pro_year != "0" && $vehicle_pro_year != "")
                    $where .= ' and v.year="' . (int) $vehicle_pro_year . '" ';
                if ($vehicle_pro_mileage != "0" && $vehicle_pro_mileage != "")
                    $where .= ' and v.millage="' . (int) $vehicle_pro_mileage . '" ';
                if ($vehicle_pro_color != "0" && $vehicle_pro_color != "")
                    $where .= ' and v.color="' . (int) $vehicle_pro_color . '" ';
                if ($vehicle_pro_type_of_car != "0" && $vehicle_pro_type_of_car != "")
                    $where .= ' and v.type_of_car="' . $vehicle_pro_type_of_car . '" ';


                if ($min_amount != "" && $max_amount != "")
                    $where .= " and p.product_price between '" . $min_amount . "' and '" . $max_amount . "' ";

                else if ($min_amount != "")
                    $where .= " and p.product_price >= '" . $min_amount . "' ";
                else if ($max_amount != "")
                    $where .= " and p.product_price <= '" . $max_amount . "' ";
            }
            elseif (isset($_REQUEST['real_estate_submit'])) {
                $furnished = $this->input->get_post("furnished");
                $bedrooms = $this->input->get_post("bedrooms");
                $bathrooms = $this->input->get_post("bathrooms");
                $pets = $this->input->post("pets");
                $broker_fee = $this->input->get_post("broker_fee");

                if ($furnished != "0" && $furnished != "")
                    $where .= ' and r.furnished="' . $furnished . '"';
                if ($bedrooms != "0" && $bedrooms != "")
                    $where .= ' and r.Bedrooms="' . $bedrooms . '"';
                if ($bathrooms != "0" && $bathrooms != "")
                    $where .= ' and r.Bathrooms="' . $bathrooms . '"';
                if ($pets != "0" && $pets != "")
                    $where .= ' and r.pets="' . $pets . '"';
                if ($broker_fee != "0" && $broker_fee != "")
                    $where .= ' and r.broker_fee="' . $broker_fee . '"';
                if (!isset($_REQUEST['houses_free'])) {
                    if ($min_amount != "" && $max_amount != "")
                        $where .= " and p.product_price between '" . $min_amount . "' and  '" . $max_amount . "' ";
                    else if ($min_amount != "")
                        $where .= " and p.product_price >= '" . $min_amount . "' ";
                    else if ($max_amount != "")
                        $where .= " and p.product_price <= '" . $max_amount . "' ";
                } else
                    $where .= " and r.free_status=1";
            }
            elseif (isset($_REQUEST['shared_submit'])) {
                if (!isset($_REQUEST['shared_free'])) {
                    if ($min_amount != "" && $max_amount != "")
                        $where .= " and p.product_price between '" . $min_amount . "' and  '" . $max_amount . "' ";
                    else if ($min_amount != "")
                        $where .= " and p.product_price >= '" . $min_amount . "' ";
                    else if ($max_amount != "")
                        $where .= " and p.product_price <= '" . $max_amount . "' ";
                } else
                    $where .= " and r.free_status=1";
            }
            elseif (isset($_REQUEST['car_number_submit'])) {
                $plate_source = $this->input->get_post("plate_source");
                $plate_prefix = $this->input->get_post("plate_prefix");
                $plate_digit = $this->input->get_post("plate_digit");
                $repeating_numbers_car = $this->input->get_post("repeating_numbers_car");

                if ($plate_source != "0" && $plate_source != "")
                    $where .= ' and cmn.plate_source="' . $plate_source . '"';
                if ($plate_prefix != "0" && $plate_prefix != "")
                    $where .= ' and cmn.plate_prefix="' . $plate_prefix . '"';
                if ($plate_digit != "0" && $plate_digit != "")
                    $where .= ' and cmn.plate_digit="' . $plate_digit . '"';
                if ($repeating_numbers_car != "0" && $repeating_numbers_car != "")
                    $where .= ' and cmn.repeating_number="' . $repeating_numbers_car . '"';

                $where .= ' and cmn.number_for="car_number"';

                if ($min_amount != "" && $max_amount != "")
                    $where .= " and p.product_price between '" . $min_amount . "' and '" . $max_amount . "' ";
                else if ($min_amount != "")
                    $where .= " and p.product_price >= '" . $min_amount . "' ";
                else if ($max_amount != "")
                    $where .= " and p.product_price <= '" . $max_amount . "' ";
            }

            elseif (isset($_REQUEST['mobile_number_submit'])) {

                $mobile_operators = $this->input->get_post("mobile_operators");
                $repeating_numbers_mobile = $this->input->get_post("repeating_numbers_mobile");

                if ($mobile_operators != "0" && $mobile_operators != "")
                    $where .= ' and cmn.mobile_operator="' . $mobile_operators . '"';
                if ($repeating_numbers_mobile != "0" && $repeating_numbers_mobile != "")
                    $where .= ' and cmn.repeating_number="' . $repeating_numbers_mobile . '"';

                $where .= ' and cmn.number_for="mobile_number"';

                if ($min_amount != "" && $max_amount != "")
                    $where .= " and p.product_price between '" . $min_amount . "' and '" . $max_amount . "' ";
                else if ($min_amount != "")
                    $where .= " and p.product_price >= '" . $min_amount . "' ";
                else if ($max_amount != "")
                    $where .= " and p.product_price <= '" . $max_amount . "' ";
            }

            return $where;
        }
    }

    function get_user_address($product_id) {

        $this->db->select('address');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('user');

        return $query->row_array();
    }

    function load_picture($user_profile_picture = NULL, $user_facebook_id = NULL, $user_twitter_id = NULL, $user_username = NULL, $user_google_id = NULL, $folder = NULL, $request_from = NULL) {

        $profile_picture = '';

        if ($user_profile_picture != '') {
            if (isset($folder) && $folder == 'original')
                $folder = $folder;
            elseif (isset($folder) && $folder == 'medium')
                $folder = $folder;
            else
                $folder = 'small';

            $profile_picture = HTTPS . website_url . profile . $folder . "/" . $user_profile_picture;
            if ($request_from == 'user-profile')
                $profile_picture = thumb_user_profile_start . $profile_picture . thumb_user_profile_end;
            elseif ($request_from == 'store-common')
                $profile_picture = thumb_store_page_user_start . $profile_picture . thumb_store_page_user_end;
            elseif ($request_from == 'seller-page')
                $profile_picture = thumb_user_image_start . $profile_picture . thumb_user_image_end;
            elseif ($request_from == 'user-follower')
                $profile_picture = thumb_follower_start . $profile_picture . thumb_follower_end;
            elseif ($request_from == 'all-store-user')
                $profile_picture = thumb_store_user_start . $profile_picture . thumb_store_user_end;
        } elseif ($user_facebook_id != '') {
            $profile_picture = 'https://graph.facebook.com/' . $user_facebook_id . '/picture?type=large';
        } elseif ($user_twitter_id != '') {
            $profile_picture = 'https://twitter.com/' . $user_username . '/profile_image?size=original';
        } elseif ($user_google_id != '') {

            // $data = file_get_contents('https://picasaweb.google.com/data/entry/api/user/'.$user->google_id.'?alt=json');
            $google = @file_get_contents('https://www.googleapis.com/plus/v1/people/' . $user_google_id . '?fields=image&key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek');
            if ($google != false) {
                $d = json_decode($google);
                $profile_picture = $d->{'image'}->{'url'};
            } else
                $profile_picture = HTTPS . website_url . 'assets/upload/avtar.png';
            // $profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
        } else
            $profile_picture = HTTPS . website_url . 'assets/upload/avtar.png';

//        $profile_picture = HTTPS . website_url . 'assets/upload/avtar.png';

        return $profile_picture;
    }

    function make_username($email_id) {

        $username = '';
        if ($email_id != '') {

            $arr = explode('@', $email_id);
            $username = $arr[0];
        }
        return $username;
    }

    public function update_stock($cnt_ads_classified, $userTotalAds, $userAdsLeft) {

        $left_ads = $userAdsLeft;
        if ($cnt_ads_classified != $userTotalAds) {
            $cnt = 1;
            if ($cnt_ads_classified > $userTotalAds) {
                $total_ads = $cnt_ads_classified;

                $minus = 0;
                $minus = $cnt_ads_classified - $userTotalAds;
                $left_ads = $userAdsLeft + $minus;
            } else {

                $total_ads = $cnt_ads_classified;
                $usedAds = $userTotalAds - $userAdsLeft;

                $left = $cnt_ads_classified - $userAdsLeft;
                if ($left > 0) {
                    $left_ads = $userAdsLeft + $left;
                } else {
                    $left_ = $cnt_ads_classified - $usedAds;
                    $left_ads = ($left_ > 0) ? $left_ : 0;
                }
            }
        }
        return $left_ads;
    }

    public function shipping_cost($user_id, $state_id) {

        $query = " where seller_id ='" . $user_id . "' and state_id='" . $state_id . "'";
        $cost = $this->getrowdetails('seller_shipping_cost', $query);
        return $cost;
    }

    public function seller_shipping_cost($seller_id) {

        $query = " where store_owner ='" . $seller_id . "'";
        $cost = $this->getrowdetails('store', $query);
        return $cost;
    }

    public function seller_data($user_id) {

        $query = " where user_id ='" . $user_id . "'";
        $seller = $this->getrowdetails('user', $query);
        return $seller;
    }

    public function product_stock_track($product_id = NULL) {

        $in_data = array('total_stock' => $_POST['total_stock'],
            'product_id' => $product_id,
            'created_date' => date('Y-m-d H:i:s')
        );

        $this->insert('product_stock_track', $in_data);
    }

    public function user_cart_delete() {

        $this->db->query('DELETE FROM user_shopping_cart WHERE created_date < DATE_SUB(CURDATE(), INTERVAL 2 WEEK)');
    }

    //get state id using emiratename
    public function state_id($emirate_name = NULL) {

        $emirate_name = strtolower($emirate_name);
        $select_state_id = 0;

        if ($emirate_name == 'abudhabi')
            $select_state_id = 3796;
        elseif ($emirate_name == 'ajman')
            $select_state_id = 3797;
        if ($emirate_name == 'dubai')
            $select_state_id = 3798;
        elseif ($emirate_name == 'fujairah')
            $select_state_id = 3803;
        elseif ($emirate_name == 'ras-al-khaimah')
            $select_state_id = 3799;
        elseif ($emirate_name == 'sharjah')
            $select_state_id = 3800;
        elseif ($emirate_name == 'umm-al-quwain')
            $select_state_id = 3802;

        return $select_state_id;
    }

    function set_timezone() {

        if (!$this->session->userdata('timezone')) {
            $ip = $this->input->ip_address();
            $query = file_get_contents('http://freegeoip.net/json/' . $ip);
            $res = json_decode($query, true);
            if ($res['time_zone'] != '') {
                $timezone = $res['time_zone'];
            } else {
                $timezone = 'UTC';
            }
            $this->session->set_userdata('timezone', $timezone);
        }
    }

    function get_usa_time($given_date = NULL) {
        $this->set_timezone();
        $user_tz = 'UTC';
        $schedule_date = new DateTime($given_date, new DateTimeZone($this->session->userdata('timezone')));
        $schedule_date->setTimeZone(new DateTimeZone($user_tz));
        $triggerOn = $schedule_date->format('Y-m-d H:i:s');

        return $triggerOn;
    }

    function converCurrency($from = NULL, $to = NULL, $amount = NULL) {
//        $url = "http://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
        $url = "https://finance.google.com/finance/converter?a=$amount&from=$from&to=$to";
        $request = curl_init();
        $timeOut = 0;
        curl_setopt($request, CURLOPT_URL, $url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
//        pr($response,1);
        curl_close($request);

        return $response;
    }

    public function paypal_charge($amount = NULL, $item_name = NULL, $hours = NULL) {

        $current_user = $this->session->userdata('gen_user');

        if (isset($current_user['user_id'])) {
            //$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
//            $url = 'https://www.paypal.com/cgi-bin/webscr';
//            $business_email = 'payment@steamsmart.co';
            $business_email = 'hid.narola-facilitator@narolainfotech.com';
            $item_name = 'Add Funds';
            $server_url = base_url();
            $notify_url = $server_url . 'user/paypal_response';
            $return = $server_url . 'user/my_listing';
            $cancel = $server_url;
            $querystring = "?notify_url=" . urlencode(stripslashes($notify_url)) . "&";
            $querystring .= "business=" . urlencode($business_email) . "&";
            $querystring .= "item_name=" . urlencode($item_name) . "&";
            $querystring .= "currency_code=USD&";
            $querystring .= "amount=" . $amount . "&";
            $querystring .= "custom=" . urlencode($current_user['user_id']) . "&";
            $querystring .= "cmd=_xclick&";
            $querystring .= "no_note=1&";
            $querystring .= "lc=US&";
            $querystring .= "return=" . urlencode(stripslashes($return)) . "&";
            $querystring .= "cancel_return=" . urlencode(stripslashes($cancel));
            $redirect_url = $url . $querystring;
            return $redirect_url;
        }
    }

    function send_offer_mail($company_user = NULL, $offer_slug = NULL, $offer_start_date = NULL, $offer_end_date = NULL, $picture_ban = NULL, $is_enddate = NULL, $offer_title = NULL) {

        $company_name = $company_user[0]->company_name;
        $followers_emailids = $this->dbcommon->select(' followed_seller fs
                left join user u on u.user_id = fs.user_id
                 where seller_id = ' . $company_user[0]->user_id . ' and is_delete<>1 group by u.user_id');

        if (isset($followers_emailids) && sizeof($followers_emailids) > 0) {

            $emial_array = array();
            foreach ($followers_emailids as $fol) {
                $emial_array[] = $fol['email_id'];
            }

            $send_emails = array_unique($emial_array);

            $where = " where user_id ='" . $company_user[0]->user_id . "'";
            $user_details = $this->dbcommon->getdetails('user', $where);

            $user_slug = $user_details[0]->user_slug;
            $date_text = '';
            if (isset($offer_start_date) && $offer_start_date != '') {

                $date = date_create($offer_start_date);
                $start_date = date_format($date, "d-m-Y");

                $date_text = 'Valid from ' . $start_date;

                if (isset($_POST['end_dt_0']) && $_POST['end_dt_0'] == 'end_never') {
                    
                } else {

                    if ((isset($is_enddate) && $is_enddate != NULL && $is_enddate == 0) ||
                            (isset($offer_end_date) && $offer_end_date != NULL)) {

                        $date = date_create($offer_end_date);
                        $end_date = date_format($date, "d-m-Y");
                        $date_text .= ' to ' . $end_date;
                    }
                }
            }

//            $offer_title =  $_POST['offer_title'];            
            $visit_offer_link = '<style>#doukani_logo{display:none;}</style>
                    <div>
                    <a href="' . HTTPS . website_url . $user_slug . '/' . $offer_slug . '" style="font-family: Roboto, sans-serif; color:#FFF; font-size:16px; line-height:18px; text-decoration:none;margin-top:0; margin-right:auto; margin-bottom:20px;display:block; margin-left:auto; padding-top:15px; padding-right:0; padding-bottom:15px; padding-left:0; background:#034694; text-align:center;width:200px;">Visit This Offer
                    </a>
                </div>';

            $upper_part = '
                    <div style="width:100%; margin-bottom:20px; margin-right:7px;text-align:center;">
                    <b style="color: #000;font-size: 20px;font-weight: 700;font-family: Roboto, sans-serif;line-eight 28px;padding: 20px 0;display: block;">' . $offer_title . '</b>';

            if (isset($picture_ban) && !empty($picture_ban)) {
                $image_path = site_url() . "assets/upload/offers/medium/" . $picture_ban;

                $upper_part .= '<img src="' . $image_path . '" alt="Offer Image" style="margin:0 auto 20px;"><div style="color: #000;font-size: 16px;font-weight: 700;font-family: Roboto, sans-serif;padding: 0;display: block;">' . $date_text . '</div>';
            }
            $upper_part .= '</div>';

            $desc = '';
            if (isset($_POST['offer_description']) && !empty($_POST['offer_description'])) {

                $description = $_POST['offer_description'];
                $length = strlen($description);
                if ($length > 300) {
                    $final_desc = substr($description, 0, 300) . '...';
                } else {
                    $final_desc = $description;
                }
                $desc = '<p style="color: #000;font-size: 16px;font-family: Roboto, sans-serif;padding: 0;display: block;">' . $final_desc . '</p><br>';
            }

            $header_part = $this->dbcart->common_header('New Offer from ' . $company_name . ' on Doukani');
            $footer_part = $this->dbcart->common_footer();

            $offer_mail = $header_part . '<td></td></tr>
                        <tr>
                            <td colspan="3">' . $upper_part . '</td>
                        </tr>
                        <tr>
                            <td colspan="4">' . $visit_offer_link . '</td>
                        </tr>
                        <tr>
                            <td colspan="4">' . $desc . '</td>
                        </tr>
                    </table>' .
                    $footer_part;

            //$email_address = 'kek@narola.email';
            if (isset($send_emails) && sizeof($send_emails) > 0) {
                if (send_mail($send_emails, $offer_title, $offer_mail)) {
                    echo 'sent';
                } else {
                    echo 'fail';
                }
            }
        }
    }

    function search_query($cat_id, $sub_cat_id, $city_id, $location, $min_amount, $max_amount, $search_value) {

        $current_user = $this->session->userdata('gen_user');
        $where = "";
        if ($cat_id != "0" && $cat_id != '')
            $where .= " and p.category_id = $cat_id";
        if ($sub_cat_id != "0" && $sub_cat_id != '')
            $where .= " and p.sub_category_id = $sub_cat_id";
        if ($location != "0" && $location != '')
            $where .= " and p.country_id = $location";

        if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
            $selected_state_id = $this->dbcommon->state_id(state_id_selection);
            $where .= " and p.state_id = " . $selected_state_id . ' ';
        } else {
            if ($city_id != "0" && $city_id != '')
                $where .= " and p.state_id = $city_id";
        }

        if ($min_amount != "" && $max_amount != "")
            $where .= " and p.product_price between '" . $min_amount . "' and '" . $max_amount . "'";
        else if ($min_amount != "")
            $where .= " and p.product_price >= '" . $min_amount . "'";
        else if ($max_amount != "")
            $where .= " and p.product_price <= '" . $max_amount . "'";

        if ($search_value != "") {

            $search_value = trim($search_value);
            $impl = explode(" ", $search_value);

            $remove_index = array_filter($impl);
            $reset_arr = array_values($remove_index);

            $query_string = ' AND ( ';
            foreach ($reset_arr as $arr) {

                $query_string .= " ( p.product_name LIKE '%" . addslashes($arr) . "%'
                OR c.catagory_name LIKE '%" . addslashes($arr) . "%'
                OR u.username LIKE '%" . addslashes($arr) . "%'
                OR u.nick_name LIKE '%" . addslashes($arr) . "%'
                OR sc.sub_category_name LIKE '%" . addslashes($arr) . "%' )  AND ";
            }

            $where .= substr($query_string, 0, -4) . ') and p.is_delete=0 ';
        }

        $like_fav_sql = '';
        $like_fav_field = '';
        if (isset($current_user) && !empty($current_user)) {
            $like_fav_sql = ' left join like_product lp on  lp.product_id = p.product_id left join favourite_product fp on fp.product_id = p.product_id ';

            $like_fav_field = ' ,if(lp.product_id=p.product_id and lp.user_id=' . $current_user['user_id'] . ',1,0) my_like,if(fp.product_id=p.product_id and fp.user_id=' . $current_user['user_id'] . ',1,0) my_favorite ';
        }

        $sql_list = '';
        $field_list = '';
        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') {

            $sql_list = 'left join product_realestate_extras on product_realestate_extras.product_id = p.product_id
		left join product_vehicles_extras on product_vehicles_extras.product_id = p.product_id
		left join mileage on mileage.mileage_id=product_vehicles_extras.millage
		left join brand  on  brand.brand_id=p.product_brand
		left join model on model.brand_id=brand.brand_id and product_vehicles_extras.model=model.model_id
		left join car_mobile_numbers cmn on cmn.product_id = p.product_id
		left join mobile_operators mo on mo.id = cmn.mobile_operator
		left join plate_source ps on ps.id = cmn.plate_source
		left join plate_prefix ppx on ppx.id=cmn.plate_prefix
		left join plate_digit pd on pd.id = cmn.plate_digit
		left join repeating_numbers rn on rn.id = cmn.repeating_number
		left join color on  color.id=product_vehicles_extras.color';

            $field_list = ' ,ps.plate_source_name,
		product_realestate_extras.Emirates, product_realestate_extras.PropertyType, product_realestate_extras.Bathrooms, product_realestate_extras.Bedrooms, product_realestate_extras.Area, product_realestate_extras.Amenities, product_realestate_extras.neighbourhood,product_realestate_extras.furnished, product_realestate_extras.pets, product_realestate_extras.broker_fee, product_realestate_extras.free_status, product_realestate_extras.ad_language, product_vehicles_extras.model, product_vehicles_extras.millage, product_vehicles_extras.color, product_vehicles_extras.type_of_car, product_vehicles_extras.year, product_vehicles_extras.make, product_vehicles_extras.vehicle_condition,u.nick_name,p.product_is_sold,mileage.name mileagekm,color.name colorname,u.facebook_id,u.twitter_id,u.google_id,brand.name bname,model.name mname,
		cmn.*,if(cmn.plate_prefix="-1","Other",if(cmn.plate_prefix="","-",ppx.prefix))  as plate_prefix,
		if(cmn.plate_digit="-1","More than 5 Digit plates",if(cmn.plate_digit="","-",pd.digit_text)) as plate_digit,
		mo.operator_name as mobile_operator,cmn.mobile_number,
		if(cmn.number_for="car_number" and cmn.repeating_number="-1","More than 5",if(cmn.number_for="mobile_number" and cmn.repeating_number="-1","More than 8",rn.rep_number)) as car_repeating_number,mo.operator_name as mobile_operator,cmn.mobile_number ';
        }

        $more_str = "SELECT p.product_id,p.category_id,p.stock_availability,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,u.facebook_id,u.twitter_id,u.google_id,c.catagory_name, u.username, u.profile_picture,p.product_is_sold,p.product_total_likes,p.product_slug,u.user_slug,s.state_name,p.latitude,p.longitude,s.latitude state_latitude, s.longitude state_longitude,p.address,
            (IF(p.product_image IS NULL OR p.product_image='',0,1) +
             IF(p.youtube_link IS NULL  OR p.youtube_link='',0,1) +
             IF(p.video_name IS NULL  OR p.video_name='',0,1) +
             (COUNT(DISTINCT pi.product_image_id))) as MyTotal,
             IF(fe.product_id IS NOT NULL and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between fe.dateFeatured and fe.dateExpire),1,'') as featured_ad " . $like_fav_field . $field_list . "
                FROM product  p
                left join state s on s.state_id=p.state_id
                left join category c on c.category_id=p.category_id 
                left join user u on u.user_id = p.product_posted_by
                left join sub_category sc on sc.sub_category_id=p.sub_category_id
                left join products_images pi on p.product_id = pi.product_id
                left join featureads fe on fe.product_id=p.product_id
                " . $like_fav_sql . $sql_list . "
                where  p.category_id=c.category_id and p.sub_category_id=sc.sub_category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate IS NULL";
        //
        //left join (select count(*) count_image, pm.product_id sub_product_id from products_images pm group by pm.product_id) k on p.product_id=sub_product_id
        return $more_str . '==' . $where;
    }

    /*
     * Send Mail To seller
     * 
     */

    function send_mail_seller() {
        if (isset($_POST)):
            //and is_delete in(0,3)
            $get_useremail = $this->db->query('select email_id,user_id,user_role from user where user_id=' . (int) $_POST['user_id'] . '  limit 1')->row_array();

            $get_useremail['email_id'];
            if (!empty($_POST['message']) && !empty($_POST['subject'])) {
                $title = $_POST['subject'];
                $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>        
        <p>' . $_POST['message'] . '</p>
        </div>';
                $parser_data = array();
                $new_data = $this->dbcommon->mail_format($title, $content);
                $new_data = $this->parser->parse_string($new_data, $parser_data, '1');

                if (send_mail($get_useremail['email_id'], $_POST['subject'], $new_data))
                    return 'Mail sent successfully';
                else
                    return 'Mail not sent';
            }
            else {
                return 'Mail not sent';
            }
        endif;
    }

    public function get_reported_items() {
        $this->db->select('r.*,product.product_image');
        $this->db->from('reported_items r');
        $this->db->join('product', 'r.report_for_product_id = product.product_id', 'left');
        $this->db->where('r.is_delete', 0);
        $this->db->order_by('r.id', 'desc');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function get_reported_item($id) {
        $this->db->select('r.content');
        $this->db->from('reported_items r');
        $this->db->where('r.id', $id);

        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }

    public function customQuery($query, $option) {
        $result = $this->db->query($query);
        if ($option == 1) {
            return $result->row();
        } else if ($option == 2) {

            return $result->result_array();
        } else
            return $result->result();
    }

    public function getFieldById($id) {
        $this->db->select('email_id');
        $this->db->where('user_id', $id);
        $result = $this->db->get('user');
        return $result->row()->email_id;
    }

    public function check_unique_code($code) {
        $this->db->select('*');
        $this->db->where('unique_code', $code);
        $this->db->where('insert_from', 'web-ipad');
        $this->db->where('is_delete', 0);
        $query = $this->db->get('user');
        return $query->row_array();
    }

}

?>