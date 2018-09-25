<?php

class Offer extends CI_Model {

    var $table = 'store';

    function Offer() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->dbutil();
    }

    public function get_featuredcompany($start = NULL, $limit = NULL, $condition = NULL, $only_featured = NULL) {

        $str_store = '';

        $this->db->select('*, if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fc.start_date and fc.end_date,"running","not running") as mystatus');

        $this->db->where('o.company_status', 0);
        $this->db->where('u.is_delete', 0);
        $this->db->where('o.company_is_inappropriate', 'Approve');

        if ($condition != NULL) {
            $where_data = ' (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fc.start_date and fc.end_date) ';
            $this->db->where($where_data);
        }

        if ($only_featured != NULL) {
            $where_data = ' (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fc.start_date and fc.end_date) ';
            $this->db->where($where_data);
        }

        $this->db->join('offer_user_company o', 'o.user_id=fc.company_user_id', 'left');
        $this->db->join('user u', 'u.user_id=o.user_id', 'left');

        $this->db->group_by('fc.company_user_id');
        $this->db->order_by('fc.featured_company_id');

        $this->db->from('featured_company fc');

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_featured_offers($start = NULL, $limit = NULL, $condition = NULL) {

        $str_store = '';

        $this->db->select('*, if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fo.start_date and fo.end_date,"running","not running") as mystatus,if(is_enddate=0 and CURDATE() > offer_end_date and offer_end_date<>"0000-00-00", "1","0") as out_of_date_status');
        $this->db->where('o.is_delete', 0);
        $this->db->where('o.offer_is_approve', 'approve');

        if ($condition != NULL) {
            $where_data = ' (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fo.start_date and fo.end_date) ';
            $this->db->where($where_data);
        }

        $this->db->where('ouc.company_is_inappropriate', 'Approve');

        $this->db->join('offers o', 'o.offer_id=fo.offer_id', 'left');
        $this->db->join('offer_user_company ouc', 'ouc.user_id=o.offer_user_company_id', 'left');

        $this->db->group_by('fo.offer_id');
        $this->db->order_by('fo.featured_offers_id');

        $this->db->from('featured_offers fo');

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    function offers_list($start = NULL, $limit = NULL, $cat_id = NULL, $user_id = NULL, $featured_request = NULL, $rand_request = NULL, $single_slug = NULL, $not_take = NULL, $condition = NULL) {

        $this->db->select('o.offer_id,o.offer_title,o.offer_description,o.offer_image,o.offer_url,o.offer_is_approve,o.offer_start_date, o.offer_end_date, is_enddate, if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fo.start_date and fo.end_date,1,0) as f_status, ouc.company_name,ouc.company_logo,ouc.company_total_views,u.user_slug,ouc.company_is_inappropriate,ouc.company_status,
    if(is_enddate=0 and CURDATE() > offer_end_date and offer_end_date<>"0000-00-00", "1","0") as out_of_date_status,u.user_id,if(u.nick_name!="",u.nick_name,u.username) company_user_name,if(u.contact_number <> "",u.contact_number,if(phone <> "",phone,""))  company_number,o.offer_slug,u.username,o.offer_total_views,u.profile_picture,o.offer_url');

        $this->db->join('offer_user_company ouc', 'ouc.user_id=o.offer_user_company_id', 'left');
        $this->db->join('featured_offers fo', 'fo.offer_id=o.offer_id', 'left');
        $this->db->join('user u', 'u.user_id=ouc.user_id', 'left');
        $this->db->join('category c', 'c.category_id=ouc.offer_category_id', 'left');

        $this->db->where('o.is_delete', 0);
        if ($condition == 'yes') {
            
        } else {
            $this->db->where('o.offer_is_approve', 'approve');
            $this->db->where('ouc.company_is_inappropriate', 'Approve');
            $this->db->where('ouc.company_status', 0);
        }
        $this->db->where('u.is_delete', 0);

        if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {

            $query_string = '';
            $search_value = $_REQUEST['s'];
            $search_value = trim($search_value);
            $impl = explode(" ", $search_value);

            $remove_index = array_filter($impl);
            $reset_arr = array_values($remove_index);
            foreach ($reset_arr as $arr) {
                $query_string .= " ( o.offer_title LIKE '%" . addslashes($arr) . "%'
                OR c.catagory_name LIKE '%" . addslashes($arr) . "%'
                OR ouc.company_name LIKE '%" . addslashes($arr) . "%' ) ";
            }

            $this->db->where($query_string);
        }

        if ($not_take != NULL) {
            $this->db->where('o.offer_id<>', $not_take);
        }
        if ($single_slug != NULL) {
            $this->db->where('o.offer_slug', $single_slug);
        }

        if (isset($_REQUEST['off_user_id']) && !empty($_REQUEST['off_user_id']))
            $this->db->where('ouc.user_id', (int) $_REQUEST['off_user_id']);

        if ($user_id != NULL)
            $this->db->where('ouc.user_id', $user_id);

        if ($cat_id != NULL)
            $this->db->where('ouc.offer_category_id', $cat_id);

        $this->db->group_by('o.offer_id');

        if ($featured_request != NULL && $featured_request == 'featured') {
            $where_data = ' (CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fo.start_date and fo.end_date) ';
            $this->db->where($where_data);

            $this->db->order_by('fo.featured_offers_id', 'desc');
        } else {
            if ($rand_request != NULL) {

                $this->db->order_by('f_status', 'desc');
                $this->db->order_by('RAND()');
            } else {
                $this->db->order_by('f_status', 'desc');
                $this->db->order_by('o.offer_posted_on', 'desc');
            }
        }

        $this->db->from('offers o');

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        if ($single_slug != NULL)
            return $query->row_array();
        else
            return $query->result_array();
    }

    function offers_count($cat_id = NULL, $user_id = NULL) {

        $this->db->select('o.offer_id,o.offer_title,o.offer_description,o.offer_image,o.offer_url,o.offer_is_approve,o.offer_start_date, o.offer_end_date, is_enddate, if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fo.start_date and fo.end_date,1,0) as f_status, ouc.company_name,ouc.company_logo');

        $this->db->join('offer_user_company ouc', 'ouc.user_id=o.offer_user_company_id', 'left');
        $this->db->join('featured_offers fo', 'fo.offer_id=o.offer_id', 'left');
        $this->db->join('user u', 'u.user_id=ouc.user_id', 'left');
        $this->db->join('category c', 'c.category_id=ouc.offer_category_id', 'left');

        $this->db->where('o.is_delete', 0);
        $this->db->where('o.offer_is_approve', 'approve');
        $this->db->where('ouc.company_is_inappropriate', 'Approve');
        $this->db->where('ouc.company_status', 0);
        $this->db->where('u.is_delete', 0);

        if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {

            $query_string = '';
            $search_value = $_REQUEST['s'];
            $search_value = trim($search_value);
            $impl = explode(" ", $search_value);

            $remove_index = array_filter($impl);
            $reset_arr = array_values($remove_index);
            foreach ($reset_arr as $arr) {
                $query_string .= " ( o.offer_title LIKE '%" . addslashes($arr) . "%'
                OR c.catagory_name LIKE '%" . addslashes($arr) . "%'
                OR ouc.company_name LIKE '%" . addslashes($arr) . "%' ) ";
            }

            $this->db->where($query_string);
        }

        if (isset($_REQUEST['off_user_id']) && !empty($_REQUEST['off_user_id']))
            $this->db->where('ouc.user_id', (int) $_REQUEST['off_user_id']);

        if ($user_id != NULL)
            $this->db->where('ouc.user_id', $user_id);

        if ($cat_id != NULL)
            $this->db->where('ouc.offer_category_id', $cat_id);

        $this->db->group_by('o.offer_id');

        $this->db->from('offers o');

        $query = $this->db->get();
        return $query->num_rows();
    }

    function company_details($user_slug = NULL, $all = NULL, $user_id = NULL, $start = NULL, $limit = NULL) {

        $this->db->select('ouc.id, ouc.company_name,ouc.company_logo,ouc.company_description,ouc.meta_title,ouc.meta_description,ouc.company_approved_on, if(u.contact_number <> "",u.contact_number,if(phone <> "",phone,""))  company_number, u.email_id,if(u.followers_count IS NOT NULL  OR u.followers_count = 0, 0,u.followers_count) as followers_count,ouc.user_id,ouc.company_total_views ,u.nick_name,u.username,u.website_url,u.facebook_social_link,u.twitter_social_link,u.instagram_social_link,u.user_slug,if(u.nick_name!="",u.nick_name,u.username) company_user_name,
                (select count(o.offer_id) as offers_count from offers o  where o.offer_user_company_id=u.user_id and o.offer_is_approve="Approve" and o.is_delete=0 ) as offers_count, if(CONVERT_TZ(NOW(),"+00:00","' . ASIA_DUBAI_OFFSET . '") between fc.start_date and fc.end_date,1,0) as f_status');

        $this->db->join('user u', 'u.user_id=ouc.user_id', 'left');
        $this->db->join('featured_company fc', 'fc.company_user_id=ouc.user_id', 'left');

        $this->db->where('ouc.company_is_inappropriate', 'Approve');
        $this->db->where('ouc.company_status', 0);
        $this->db->where('u.is_delete', 0);

        if ($user_slug != NULL)
            $this->db->where('u.user_slug', $user_slug);

        $this->db->group_by('ouc.id');

        if (isset($_POST['category_id']) && !empty($_POST['category_id']))
            $this->db->where('ouc.offer_category_id', $_POST['category_id']);

        $this->db->order_by('fc.featured_company_id', 'desc');
        if ($all != NULL) {
            $this->db->where('u.user_id<>' . $user_id);
            if ($user_id != NULL)
                $this->db->order_by('RAND()');
            else
                $this->db->order_by('ouc.id');
        } else
            $this->db->order_by('ouc.id');

        $this->db->from('offer_user_company ouc');

        $this->db->having('offers_count>0');

        if ($limit != null) {
            if ($start != null)
                $this->db->limit($limit, $start);
            else
                $this->db->limit($limit);
        }

        $query = $this->db->get();
        if ($all != NULL)
            return $query->result_array();
        else
            return $query->row_array();
    }

    function company_count($user_slug = NULL, $all = NULL, $user_id = NULL) {

        $this->db->select('ouc.id, ouc.company_name,ouc.company_logo,ouc.company_description,ouc.meta_title,ouc.meta_description,ouc.company_approved_on, if(u.contact_number <> "",u.contact_number,if(phone <> "",phone,""))  company_number, u.email_id,if(u.followers_count IS NOT NULL  OR u.followers_count =0, 0,u.followers_count) as followers_count,ouc.user_id,ouc.company_total_views ,u.username,u.website_url,u.facebook_social_link,u.twitter_social_link,u.instagram_social_link,u.user_slug,(select count(o.offer_id) as offers_count from offers o  where o.offer_user_company_id=u.user_id and o.offer_is_approve="Approve" and o.is_delete=0 ) as offers_count');

        $this->db->join('user u', 'u.user_id=ouc.user_id', 'left');
        $this->db->join('featured_company fc', 'fc.company_user_id=ouc.user_id', 'left');

        $this->db->where('ouc.company_is_inappropriate', 'Approve');
        $this->db->where('ouc.company_status', 0);
        $this->db->where('u.is_delete', 0);

        if (isset($_POST['category_id']) && !empty($_POST['category_id']))
            $this->db->where('ouc.offer_category_id', $_POST['category_id']);

        if ($user_slug != NULL)
            $this->db->where('u.user_slug', $user_slug);

        $this->db->group_by('ouc.id');

        if ($all != NULL) {
            $this->db->where('u.user_id<>' . $user_id);
        }

        $this->db->having('offers_count>0');
        $this->db->from('offer_user_company ouc');

        $query = $this->db->get();

        return $query->num_rows();
    }

}

?>