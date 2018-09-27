<?php

class Product extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_product_like_users($product_id, $start = NULL, $count = NULL) {

        $this->db->select('u.user_id, u.email_id, u.phone, u.is_delete, u.status, u.user_role');
        $this->db->join('like_product lp', 'lp.user_id = u.user_id', 'left');
        $this->db->where('lp.product_id', $product_id);
        $this->db->group_by('u.user_id');

        if (is_null($count)) {
            $limit = 10;
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get('user u');

        if (is_null($count))
            return $query->result_array();
        else
            return $query->num_rows();
    }

    function get_product_favorite_users($product_id, $start = NULL, $count = NULL) {
        $this->db->select('u.user_id, u.email_id, u.phone, u.is_delete, u.status, u.user_role');
        $this->db->join('favourite_product fp', 'fp.user_id = u.user_id', 'left');
        $this->db->where('fp.product_id', $product_id);
        $this->db->group_by('u.user_id');

        if (is_null($count)) {
            $limit = 10;
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get('user u');

        if (is_null($count))
            return $query->result_array();
        else
            return $query->num_rows();
    }

}

?>