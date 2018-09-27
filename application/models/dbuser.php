<?php

class Dbuser extends CI_Model {

    var $table = 'user';
    var $primary_key = 'user_id';

    function __construct() {
        parent::__construct();
    }

    function insert($data) {
        if ($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function update($user_id, $data) {
        $this->db->where($this->primary_key, $user_id);
        if ($this->db->update($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function delete($id) {
        $this->db->delete($this->table, array($this->primary_key => $id));
        return true;
    }

    function getdetails($offset = '0', $limit = '1', $query) {
        $sql = "select * from $this->table " . $query . " LIMIT $offset,$limit";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getUserDetails($array) {
        $sql = "select * from $this->table where ";
        foreach ($array as $key => $value) {
            $sql .= " $key='" . $value . "' and";
        }
        $sql = trim($sql, ' and');
        $query = $this->db->query($sql);
        echo $this->db->last_query();
        return $query->row();
    }

    function get_no_of_row($query) {
        $sql = "select * from $this->table " . $query;
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_user_info($user_id) {
        $sql = "select * from $this->table where $this->primary_key='" . $user_id . "'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function get_user_existence($email_id, $user_id) {
        $sql = "select * from $this->table where $this->primary_key!='" . $user_id . "' and email_id='" . $email_id . "' ";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function get_specific_colums($tblname, $fields, $where = null) {
        $this->db->distinct();
        $this->db->select($fields);
        $this->db->from($tblname);
        if ($where != null) {
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    $this->db->where($key, $value);
                }
            }
        }
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    /*     * *************************** To Boost Product ******************************** */

//    $current_user = $this->session->userdata('gen_user');
    //and product_for'classified'
    //need to pass product_id,$add_hours
//        $product_id = 975;
//        $product_details = $this->dbcommon->getdetails_("* from product where product_id = " . (int) $product_id . " and product_posted_by=" . (int) $current_user['user_id'] . " and is_delete in (0) and product_is_inappropriate='Approve'  ");
//        
//        if(!empty($product_details)) {
//                
//            $add_hours =  24;
//            $dateFeatured = date('Y-m-d H:i:s');
//            $dateExpire = date("Y-m-d H:i:s", strtotime('+'.$add_hours.' hours'));
//            $del_arr = array('product_id'=>$product_id);
//            $this->dbcommon->delete('featureads',$del_arr);
//            
//            $arra = array('product_id' => $product_id,
//                    'cat_id' => $product_details[0]->category_id,
//                    'subcat_id' => $product_details[0]->sub_category_id,
//                    'product_id' => $product_details[0]->product_id,
//                    'User_Id' => $product_details[0]->product_posted_by,
//                    'dateFeatured' => $dateFeatured,
//                    'dateExpire' => $dateExpire
//                );
//            
//            $result = $this->dbcommon->insert('featureads', $arra);              
//        }
    /*     * *************************** To Boost Product ******************************** */
}

?>