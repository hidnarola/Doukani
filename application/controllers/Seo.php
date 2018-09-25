<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Seo extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('offer', '', TRUE);
    }

    function sitemap_xml() {
        $data['display_list'] = $this->links();

        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap/sitemap", $data);
    }

    function sitemap_txt() {
        $data['display_list'] = $this->links();

        header("Content-Type: text/text;charset=iso-8859-1");
        $this->load->view("sitemap/sitemap_txt", $data);
    }

    function sitemap_html() {

        $data = array();

        $site_url = HTTPS . website_url;
        $data['site_url'] = $site_url;
        $display_list = array();

        $pages_fields = ' category_slug, catagory_name ';
        $where_str = 'FIND_IN_SET(0, category_type) > 0';
        $category_list = $this->dbcommon->get_specific_colums('category', $pages_fields, $where_str);
        $data['category_list'] = $category_list;

        $pages_fields = ' sub_category_slug, sub_category_name ';
        $where_str = 'FIND_IN_SET(0, sub_category_type) > 0';
        $sub_categories = $this->dbcommon->get_specific_colums('sub_category', $pages_fields, $where_str);
        $data['sub_categories'] = $sub_categories;

        $pages_fields = ' page_title, slug_url ';
        $array = array('page_state' => 1);
        $pages_cms = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');
        $data['pages'] = $pages_cms;

        $pages_fields = ' product_name, product_slug ';
        $array = array('is_delete' => 0, 'product_is_inappropriate' => 'Approve', 'product_deactivate' => NULL, 'product_for' => 'classified');
        $products = $this->dbcommon->get_specific_colums('product', $pages_fields, $array);
        $data['classified_products'] = $products;

        $query = 'select p.product_slug,p.product_name, s.store_domain from product p left join user u on u.user_id=p.product_posted_by
left join store s on s.store_owner=u.user_id where p.is_delete=0 and product_is_inappropriate="Approve" and product_deactivate IS NULL and product_for="store" and s.store_status=0 and s.store_is_inappropriate="Approve" group by p.product_id';

        $products = $this->dbcommon->get_distinct($query);
        $data['store_products'] = $products;

        $offers = $this->offer->offers_list();
        $data['offers'] = $offers;

        $query = 'select user_slug, username, nick_name from user where is_delete=0 and status="active" and user_role in ("superadmin","admin","generalUser")';
        $users = $this->dbcommon->get_distinct($query);
        $data['users'] = $users;

        $pages_fields = ' store_name, store_domain ';
        $array = array('store_status' => 0, 'store_is_inappropriate' => 'Approve');
        $stores = $this->dbcommon->get_specific_colums('store', $pages_fields, $array);
        $data['stores'] = $stores;

        $query = 'select u.user_slug,ouc.company_name from offer_user_company ouc left join user u on u.user_id=ouc.user_id where ouc.company_status=0 and company_is_inappropriate="Approve" and u.is_delete=0 and u.status="active"';

        $companies = $this->dbcommon->get_distinct($query);
        $data['companies'] = $companies;

        header("Content-Type: text/html;charset=iso-8859-1");
        $this->load->view("sitemap/sitemap_html", $data);
    }

    public function links() {
        $site_url = HTTPS . website_url;
        $display_list[] = $site_url;
        $display_list[] = $site_url . 'registration';
        $display_list[] = $site_url . 'login';
        $display_list[] = $site_url . 'login/forget_password';
        $display_list[] = $site_url . 'latest';
        $display_list[] = $site_url . 'featured_ads';
        $display_list[] = $site_url . 'advanced_search';
        $display_list[] = $site_url . 'categories';

        $data = array();

        $where_str = 'FIND_IN_SET(0, category_type) > 0';
        $category_list = $this->dbcommon->get_specific_colums('category', 'category_slug', $where_str);
        if (sizeof($category_list) > 0) {
            foreach ($category_list as $list) {
                $display_list[] = $site_url . $list['category_slug'];
            }
        }

        $where_str = 'FIND_IN_SET(0, sub_category_type) > 0';
        $sub_categories = $this->dbcommon->get_specific_colums('sub_category', 'sub_category_slug', $where_str);
        if (sizeof($sub_categories) > 0) {
            foreach ($sub_categories as $list) {
                $display_list[] = $site_url . $list['sub_category_slug'];
            }
        }

        $array = array('page_state' => 1);
        $pages_cms = $this->dbcommon->get_specific_colums('pages_cms', 'slug_url', $array, 'order', 'asc');
        if (sizeof($pages_cms) > 0) {
            foreach ($pages_cms as $list) {
                $display_list[] = $site_url . $list['slug_url'];
            }
        }

        $array = array('is_delete' => 0, 'product_is_inappropriate' => 'Approve', 'product_deactivate' => NULL, 'product_for' => 'classified');
        $products = $this->dbcommon->get_specific_colums('product', 'product_slug', $array);
        foreach ($products as $list) {
            $display_list[] = $site_url . $list['product_slug'];
        }

        $query = 'select p.product_slug, s.store_domain from product p left join user u on u.user_id=p.product_posted_by
left join store s on s.store_owner=u.user_id where p.is_delete=0 and product_is_inappropriate="Approve" and product_deactivate IS NULL and product_for="store" and s.store_status=0 and s.store_is_inappropriate="Approve"';

        $products = $this->dbcommon->get_distinct($query);
        foreach ($products as $list) {
            $display_list[] = HTTP . $list['store_domain'] . after_subdomain . '/' . $list['product_slug'];
        }

        $offers = $this->offer->offers_list();
        foreach ($offers as $list) {
            $display_list[] = $site_url . $list['user_slug'] . '/' . $list['offer_slug'];
        }

        $query = 'select user_slug from user where is_delete=0 and status="active" and user_role in ("superadmin","admin","generalUser")';
        $users = $this->dbcommon->get_distinct($query);
        $data['users'] = $users;
        foreach ($users as $list) {
            $display_list[] = $site_url . $list['user_slug'];
        }

        $array = array('store_status' => 0, 'store_is_inappropriate' => 'Approve');
        $stores = $this->dbcommon->get_specific_colums('store', 'store_domain', $array);
        foreach ($stores as $list) {
            $display_list[] = HTTP . $list['store_domain'] . after_subdomain;
        }

        $query = 'select u.user_slug from offer_user_company ouc left join user u on u.user_id=ouc.user_id where ouc.company_status=0 and company_is_inappropriate="Approve" and u.is_delete=0 and u.status="active"';

        $companies = $this->dbcommon->get_distinct($query);

        foreach ($companies as $list) {
            $display_list[] = $site_url . $list['user_slug'];
        }

        return $display_list;
    }

}

?>