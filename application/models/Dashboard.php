<?php

class Dashboard extends CI_Model {

    var $table = 'store';

    function Store() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->dbutil();
    }

    public function get_value($query) {
//        $this->db->cache_on();
        $query = $this->db->query($query);
        return $query->row();
    }

    function get_count($tblname, $perm1, $perm2) {
        $this->db->where($perm1, $perm2);
        return $this->db->count_all_results($tblname);
    }

    function get_specific_count($tblname, $array) {
        foreach ($array as $key => $value) {
            $this->db->where($key, $value);
        }
        $query = $this->db->get($tblname);

        $data = $query->num_rows();
        return $data;
    }

    function get_countAll($tblname) {
        return $this->db->count_all($tblname);
    }

    function get_selected_count($query) {
        $query = $this->db->query($query);
        return $query->num_rows();
    }

    function get_products_count() {

        $query = $this->db->query("SELECT 
		SUM(CASE WHEN product_for='classified' THEN 1 ELSE 0 END) classified_totals,	
		SUM(CASE WHEN product_for='classified' and is_delete=1 THEN 1 ELSE 0 END) classified_deleted,
                SUM(CASE WHEN product_for='classified' and is_delete=2 THEN 1 ELSE 0 END) classified_block_ads,
		SUM(CASE WHEN product_for='classified' and DATE_FORMAT(product_posted_time,'%Y-%m-%d')= CURDATE() and is_delete=0 THEN 1 ELSE 0 END) classified_today_added,
		SUM(CASE WHEN product_for='classified' and product_deactivate=1  and is_delete=0 THEN 1 ELSE 0 END) classified_deactivated_Ads,
		SUM(CASE WHEN product_for='classified' and product_is_inappropriate='Approve'  and is_delete=0  THEN 1 ELSE 0 END) classified_approved_ads,
		SUM(CASE WHEN product_for='classified' and product_is_inappropriate='NeedReview'  and is_delete=0 THEN 1 ELSE 0 END) classified_needreview_ads,
		SUM(CASE WHEN product_for='classified' and product_is_inappropriate='Inappropriate'  and is_delete=0 THEN 1 ELSE 0 END) classified_inappropriate_ads,
		SUM(CASE WHEN product_for='classified' and product_is_inappropriate='Unapprove'  and is_delete=0 THEN 1 ELSE 0 END) classified_unapproved_ads,
		
		SUM(CASE WHEN product_for='store' THEN 1 ELSE 0 END) store_totals,	
		SUM(CASE WHEN product_for='store' and is_delete=1 THEN 1 ELSE 0 END) store_deleted,
                SUM(CASE WHEN product_for='store' and is_delete=2 THEN 1 ELSE 0 END) store_block_ads,
                SUM(CASE WHEN product_for='store' and is_delete=6 THEN 1 ELSE 0 END) store_not_approve_ads,
                
                SUM(CASE WHEN product_for='store' and is_delete=3 THEN 1 ELSE 0 END) store_hold_ads,
		SUM(CASE WHEN product_for='store' and DATE_FORMAT(product_posted_time,'%Y-%m-%d')= CURDATE()  and is_delete=0 THEN 1 ELSE 0 END) store_today_added,
		SUM(CASE WHEN product_for='store' and product_deactivate=1 and is_delete=0  THEN 1 ELSE 0 END)  store_deactivated_Ads,		
		SUM(CASE WHEN product_for='store' and product_is_inappropriate='Approve'  and is_delete=0 THEN 1 ELSE 0 END) store_approved_ads,
		SUM(CASE WHEN product_for='store' and product_is_inappropriate='NeedReview'  and is_delete=0 THEN 1 ELSE 0 END) store_needreview_ads,
		SUM(CASE WHEN product_for='store' and product_is_inappropriate='Inappropriate'  and is_delete=0 THEN 1 ELSE 0 END) store_inappropriate_ads,
		SUM(CASE WHEN product_for='store' and product_is_inappropriate='Unapprove'  and is_delete=0 THEN 1 ELSE 0 END) store_unapproved_ads
            FROM product
        ");
        //echo $this->db->last_query();
        return $query->result_array();
    }

    function repost_counts() {

        $query = $this->db->query("SELECT SUM(CASE WHEN product.product_id = r.productid and product_is_inappropriate='Approve'  and product_for= 'classified' and is_delete=0 THEN 1 ELSE 0 END) repost_classified_approve_ads,
                SUM(CASE WHEN product.product_id = r.productid and product_is_inappropriate='NeedReview'  and product_for= 'classified' and is_delete=0 THEN 1 ELSE 0 END) repost_classified_needreview_ads,
                SUM(CASE WHEN product.product_id = r.productid and product_is_inappropriate='Inappropriate'  and product_for= 'classified' and is_delete=0 THEN 1 ELSE 0 END) repost_classified_inappropriate_ads,
                SUM(CASE WHEN product.product_id = r.productid and product_is_inappropriate='Unapprove'  and product_for= 'classified' and is_delete=0 THEN 1 ELSE 0 END) repost_classified_unapprove_ads,
                
                SUM(CASE WHEN product.product_id = r.productid and product_is_inappropriate='Approve'  and product_for= 'store' and is_delete=0 THEN 1 ELSE 0 END) repost_store_approve_ads,
                SUM(CASE WHEN product.product_id = r.productid and product_is_inappropriate='NeedReview'  and product_for= 'store' and is_delete=0 THEN 1 ELSE 0 END) repost_store_needreview_ads,
                SUM(CASE WHEN product.product_id = r.productid and product_is_inappropriate='Inappropriate'  and product_for= 'store' and is_delete=0 THEN 1 ELSE 0 END) repost_store_inappropriate_ads,
                SUM(CASE WHEN product.product_id = r.productid and product_is_inappropriate='Unapprove'  and product_for= 'store' and is_delete=0 THEN 1 ELSE 0 END) repost_store_unapprove_ads,
                                
                SUM(CASE WHEN product.product_id = r.productid and  product_for='classified' and product_deactivate=1  and is_delete=0 THEN 1 ELSE 0 END) repost_classified_deactivated_Ads,
                SUM(CASE WHEN product.product_id = r.productid and  product_for='store' and product_deactivate=1  and is_delete=0 THEN 1 ELSE 0 END) repost_store_deactivated_Ads,
                
               SUM(CASE WHEN product_for='classified' and product.product_id = r.productid and is_delete=2 THEN 1 ELSE 0 END) repost_classified_block_ads,
               SUM(CASE WHEN product_for='store' and product.product_id = r.productid and is_delete=2 THEN 1 ELSE 0 END) repost_store_block_ads,
               
               SUM(CASE WHEN product.product_id = r.productid and product_for='store' and is_delete=3 THEN 1 ELSE 0 END) repost_store_hold_ads
        FROM product
        LEFT JOIN repost r  ON r.productid = product.product_id
        ");
        //echo $this->db->last_query();
        return $query->row_array();
    }

    function get_stores_count() {

        $query = $this->db->query("SELECT 		
		count(store.store_id) s_store_totals,
		SUM(CASE WHEN store_status=1 THEN 1 ELSE 0 END) s_store_deleted,
		SUM(CASE WHEN store_is_inappropriate='Approve'  and store_status<>1 THEN 1 ELSE 0 END) s_store_approved_ads,
		SUM(CASE WHEN store_is_inappropriate='NeedReview'  and store_status<>1 THEN 1 ELSE 0 END) s_store_needreview_ads,
		SUM(CASE WHEN store_is_inappropriate='Inappropriate' and store_status<>1 THEN 1 ELSE 0 END) s_store_inappropriate_ads,
		SUM(CASE WHEN store_is_inappropriate='Unapprove'  and store_status<>1 THEN 1 ELSE 0 END) s_store_unapproved_ads,		
		SUM(CASE WHEN store_status=3 and store_is_inappropriate='Approve' THEN 1 ELSE 0 END) s_store_hold,
		SUM(CASE WHEN store_status=0 and store_is_inappropriate='Approve' THEN 1 ELSE 0 END) s_store_active,
		SUM(CASE WHEN DATE_FORMAT(store_created_on,'%Y-%m-%d')= CURDATE() and store_status=0 THEN 1 ELSE 0 END) s_store_today_added,
		SUM(CASE WHEN store_status=0 and store_is_inappropriate='Approve' and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between fs.start_date and fs.end_date) THEN 1 ELSE 0 END) s_store_featured_stores,
		SUM(CASE WHEN new_data_status=1 and store_status=0 THEN 1 ELSE 0 END) s_store_store_waiting
                FROM store
                left join featured_stores fs  on fs.store_id=store.store_id
        ");

        return $query->result_array();
    }

    function get_users_count() {

        $query = $this->db->query("SELECT 
                sum(CASE WHEN user_id<>0  THEN 1 ELSE 0 END) total_users,
                sum(CASE WHEN device_type IS NULL and user_role NOT IN ('admin','superadmin')  THEN 1 ELSE 0 END) total_website_users,
                sum(CASE WHEN device_type=1 and user_role NOT IN ('admin','superadmin') THEN 1 ELSE 0 END) total_iphone_users,
                sum(CASE WHEN device_type=0 and user_role NOT IN ('admin','superadmin') THEN 1 ELSE 0 END) total_android_users,
                sum(CASE WHEN is_delete=1 and device_type IS NULL and user_role NOT IN ('admin','superadmin')  THEN 1 ELSE 0 END) delete_website_users,
                sum(CASE WHEN is_delete=1 and device_type=1 and user_role NOT IN ('admin','superadmin') THEN 1 ELSE 0 END) delete_iphone_users,
                sum(CASE WHEN is_delete=1 and device_type=0 and user_role NOT IN ('admin','superadmin') THEN 1 ELSE 0 END) delete_android_users,
                
sum(CASE WHEN user_role='generalUser' and is_delete<>1 and device_type IS NULL THEN 1 ELSE 0 END) classified_website_users,
sum(CASE WHEN user_role='storeUser' and is_delete<>1 and device_type IS NULL THEN 1 ELSE 0 END) store_website_users,
sum(CASE WHEN user_role='offerUser' and is_delete<>1 and device_type IS NULL THEN 1 ELSE 0 END) offer_website_users,
sum(CASE WHEN (user_role='' OR user_role IS NULL) and is_delete<>1 and device_type IS NULL THEN 1 ELSE 0 END) website_users_no_type,

sum(CASE WHEN user_role='generalUser' and is_delete<>1 and device_type=1  and device_type IS NOT NULL THEN 1 ELSE 0 END) classified_iphone_users,
sum(CASE WHEN user_role='storeUser' and is_delete<>1 and device_type=1 and device_type IS NOT NULL THEN 1 ELSE 0 END) store_iphone_users,
sum(CASE WHEN user_role='offerUser' and is_delete<>1 and device_type=1  and device_type IS NOT NULL THEN 1 ELSE 0 END) offer_iphone_users,
sum(CASE WHEN (user_role='' OR user_role IS NULL) and is_delete<>1 and device_type=1 THEN 1 ELSE 0 END) iphone_users_no_type,

sum(CASE WHEN user_role='generalUser' and is_delete<>1 and device_type=0 and device_type IS NOT NULL THEN 1 ELSE 0 END) classified_android_users,
sum(CASE WHEN user_role='storeUser' and is_delete<>1 and device_type=0 and device_type IS NOT NULL THEN 1 ELSE 0 END) store_android_users,
sum(CASE WHEN user_role='offerUser' and is_delete<>1 and device_type=0 and device_type IS NOT NULL THEN 1 ELSE 0 END) offer_android_users,
sum(CASE WHEN (user_role='' OR user_role IS NULL) and is_delete<>1 and device_type=0 THEN 1 ELSE 0 END) android_users_no_type,
                
		sum(CASE WHEN user_role='superadmin' and is_delete<>1 THEN 1 ELSE 0 END) super_admin_users,
		sum(CASE WHEN user_role='admin' and is_delete<>1 THEN 1 ELSE 0 END) admin_users,
		sum(CASE WHEN user_role='generalUser' and is_delete<>1 THEN 1 ELSE 0 END) classified_users,
		sum(CASE WHEN user_role='storeUser' and is_delete<>1 THEN 1 ELSE 0 END) store_users,
		sum(CASE WHEN user_role='offerUser' and is_delete<>1 THEN 1 ELSE 0 END) offer_users,
                sum(CASE WHEN is_delete=2 THEN 1 ELSE 0 END) not_agree_withtd,
		sum(CASE WHEN is_delete=3 and s.store_is_inappropriate='Approve' THEN 1 ELSE 0 END) hold_store_users,
		sum(CASE WHEN is_delete=4 THEN 1 ELSE 0 END) block_users,
		sum(CASE WHEN is_delete=5 THEN 1 ELSE 0 END) not_filled_store_details,
		sum(CASE WHEN user_role='' or user_role IS NULL and is_delete<>1 THEN 1 ELSE 0 END) not_user_type_selected,
		sum(CASE WHEN is_delete=1 THEN 1 ELSE 0 END) delete_users,
                
		sum(CASE WHEN user_role='generalUser' and is_delete=4 THEN 1 ELSE 0 END) classified_block_users,
                sum(CASE WHEN user_role='storeUser' and is_delete=4 THEN 1 ELSE 0 END) store_block_users,
                sum(CASE WHEN user_role='offerUser' and is_delete=4 THEN 1 ELSE 0 END) offer_block_users,
                
                sum(CASE WHEN user_role='generalUser' and is_delete=2 THEN 1 ELSE 0 END) classified_not_agree_users,
                sum(CASE WHEN user_role='storeUser' and is_delete=2 THEN 1 ELSE 0 END) store_not_agree_users,
                sum(CASE WHEN user_role='offerUser' and is_delete=2 THEN 1 ELSE 0 END) offer_not_agree_users           FROM user
        left join store s on s.store_owner = user.user_id
        ");

        return $query->result_array();
    }

    function get_offer_ads_count() {

        $query = $this->db->query("SELECT 		
		SUM(CASE WHEN offer_id<>0 THEN 1 ELSE 0 END) offer_totals,	
		SUM(CASE WHEN is_delete=1 THEN 1 ELSE 0 END) offer_deleted,
                SUM(CASE WHEN is_delete=2 THEN 1 ELSE 0 END) offer_block_ads,
                SUM(CASE WHEN is_delete=6 THEN 1 ELSE 0 END) offer_companynot_approved,
		SUM(CASE WHEN DATE_FORMAT(offer_posted_on,'%Y-%m-%d')= CURDATE() and is_delete=0 THEN 1 ELSE 0 END) offer_today_added,		
		SUM(CASE WHEN offer_is_approve='approve'  and is_delete=0  THEN 1 ELSE 0 END) offer_approved_ads,
		SUM(CASE WHEN offer_is_approve='WaitingForApproval'  and is_delete=0 THEN 1 ELSE 0 END) offer_wait_approval_ads,
		SUM(CASE WHEN offer_is_approve='unapprove'  and is_delete=0 THEN 1 ELSE 0 END) offer_unapprove_ads,
                SUM(CASE WHEN is_delete=3 THEN 1 ELSE 0 END) offer_hold_ads
        FROM offers");

        return $query->result_array();
    }

    function get_companies_count() {

        $query = $this->db->query("SELECT 		
		count(ouc.id) companies_totals,
		SUM(CASE WHEN company_status=1 THEN 1 ELSE 0 END) companies_deleted,
		SUM(CASE WHEN company_is_inappropriate='Approve'  and company_status<>1 THEN 1 ELSE 0 END) companies_approved_ads,
		SUM(CASE WHEN company_is_inappropriate='NeedReview'  and company_status<>1 THEN 1 ELSE 0 END) companies_needreview_ads,
		SUM(CASE WHEN company_is_inappropriate='Inappropriate' and company_status<>1 THEN 1 ELSE 0 END) companies_inappropriate_ads,
		SUM(CASE WHEN company_is_inappropriate='Unapprove'  and company_status<>1 THEN 1 ELSE 0 END) companies_unapproved_ads,		
		SUM(CASE WHEN company_status=3 and company_is_inappropriate='Approve' THEN 1 ELSE 0 END) companies_hold,
		SUM(CASE WHEN company_status=0 and company_is_inappropriate='Approve' THEN 1 ELSE 0 END) companies_active,
		SUM(CASE WHEN DATE_FORMAT(created_date,'%Y-%m-%d')= CURDATE() and company_status=0  THEN 1 ELSE 0 END) companies_today_added,                
		SUM(CASE WHEN company_status=0 and company_is_inappropriate='Approve' and (CONVERT_TZ(NOW(),'+00:00','" . ASIA_DUBAI_OFFSET . "') between fc.start_date and fc.end_date) THEN 1 ELSE 0 END) featured_companies,
                SUM(CASE WHEN is_delete=2 THEN 1 ELSE 0 END) companies_block
                FROM offer_user_company ouc
                left join featured_company fc  on fc.company_user_id = ouc.user_id
        ");

        return $query->result_array();
    }

    function store_request() {

        $this->db->select('COUNT(*) total_request');
        $this->db->where('modified_date IS NULL');
        $this->db->where('status', 0);
        $query = $this->db->get('store_request');
        $result = $query->row_array();
        return $result;
    }

}

?>