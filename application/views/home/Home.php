<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Extending the custom controller
class Home extends My_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dashboard');
        $this->load->library('pagination');
		$this->load->library('My_PHPMailer');
		$this->load->library('parser');		
		$this->load->helper('email');	
		$current_user   = $this->session->userdata('gen_user');		
		if(isset($current_user)) {
			define("session_userid", $current_user['user_id']);							
		}
		else
			define("session_userid", '');							
    }
    
	/**
     * function to load the home page.
     */
    public function index() {
	
		// getting the banners for home page
        $between_banners 		 = $this->dbcommon->getBanners_forhome('between',"'home_page','all_page'");				
		$data['between_banners'] = $between_banners;
		
        $feature_banners 		 = $this->dbcommon->getBanners_forhome('sidebar',"'home_page','all_page'");        		
        $data['feature_banners'] = $feature_banners;
		
		//echo $this->db->last_query().'<br>';
		//print_r($data['between_banners']);
		//print_r($data['intro_banners']);
		//print_r($data['feature_banners']);
		
		if(isset($feature_banners[0]['ban_id']) && $feature_banners[0]['ban_id']!='')
		{		
			$mycnt	=	$feature_banners[0]['impression_count']+1;
			$array1	=	array('ban_id'=>$feature_banners[0]['ban_id']);
			$data1	=	array('impression_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array1, $data1);
		}        		
		
		if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='')
		{		
			$mycnt	=	$between_banners[0]['impression_count']+1;
			$array1	=	array('ban_id'=>$between_banners[0]['ban_id']);
			$data1	=	array('impression_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array1, $data1);
		}
		
        $product = $this->dbcommon->get_products();
		
		//print_r($product);
        $data['latest_product'] = $product;
        $featured_product = $this->dbcommon->get_featured_ads(null,null);
		
        $data['f_products'] = $featured_product;
        
        // functionality for loading more products
        $total_product = $this->dbcommon->get_products_count();

        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        }
		
        $start = 0;

        $most_viewed_product = $this->dbcommon->get_most_viewed_products($start);

        $data['most_viewed_product'] = $most_viewed_product;

        // merging the data from my_controller
        $data = array_merge($data, $this->get_elements());
        
        $data['page_title'] = 'Doukani';
        
        $data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }
        $this->load->view('home/index', $data);
    }

    /**
     * function to load sub categories using ajax
     */
    public function show_sub_cat() {
        $filter_val = $this->input->post("value");

        $query = "category_id= '" . $filter_val . "'";
        $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);
        $main_data = array_merge($main_data, $this->get_elements());
        echo $this->load->view('include/sub_cat', $main_data, TRUE);
        exit();
    }
    
    /**
     * function to load more products using ajax
     */
    public function show_more_product() {

        $filter_val = $this->input->post("value");
        //$total_product = $this->dbcommon->get_countAll('product');
		
		$query	=	' * from product where is_delete=0 and product_is_inappropriate="Approve" and product_deactivate is null';
		$total_product = $this->dbcommon->getnumofdetails_($query);
        $start = 12 * $filter_val;
        $end = $start + 12;
        $hide = "false";
        if ($end >= $total_product) {
            $hide = "true";
        }

        $most_viewed_product = $this->dbcommon->get_most_viewed_products($start);
        $data['most_viewed_product'] = $most_viewed_product;
		
		$data['is_logged'] = 0;
        if ($this->session->userdata('gen_user'))
            $data['is_logged'] = 1;
        
		
        $arr = array();
        $arr["html"] = $this->load->view('home/more_product', $data, TRUE);
        $arr["val"] = $hide;
        echo json_encode($arr);
        exit();
    }
    
    /**
     * function to load the category page - grid view
     * @param type $cat_id
     * @param type $subcat_id
     */
    public function category($cat_id = null, $subcat_id = null) {
		
		
		if($cat_id!=null)
		{
			$data['between_banners'] = $this->catpage_banner_between($cat_id, $subcat_id);      

        if ($subcat_id != null) {

            $data["subcat_id"] = $subcat_id;
            $where = " sub_category_id = $subcat_id";
            $subcategory = $this->dbcommon->filter('sub_category', $where);
			if(sizeof($subcategory)>0) { 
				$data['subcat_name'] = $subcategory[0]['sub_category_name'];
				$array = array(
					'sub_category_id' => $subcat_id,
					//'product.product_is_inappropriate !=' => 'Inappropriate',
					'product.product_is_inappropriate'=>'Approve',
					'product.product_deactivate'=>null,
					'is_delete' => 0
					);

				$total = $this->dashboard->get_specific_count('product', $array);

				$data['subcat_total'] = $total;
			}
			else
			{
				redirect('home');
			}
        }
        $total_product = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);
	
        $product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, null, 12);
        
        // checking if the category is vehicle or real estate
        if ($cat_id == 7) {			
            $product = $this->dbcommon->get_vehicle_products($cat_id, $subcat_id, null, 12);
			
        }
        if ($cat_id == 8) {
            $product = $this->dbcommon->get_real_estate_products($cat_id, $subcat_id, null, 12);
        }

        $data['product'] = $product;
       
        // functionality for load more product
        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        }

        $query = "category_id= '" . $cat_id . "' order by sub_cat_order asc";
        $subcat = $this->dbcommon->filter('sub_category', $query);
		

        // functionality to show the list of sub categoried after the breadcrumb
        $subcatArr = array();
        $i = 0;
        foreach ($subcat as $sub) {
            $subcatArr[$i]["id"] = $sub["sub_category_id"];
            $subcatArr[$i]["name"] = $sub["sub_category_name"];

            $array = array(
                'sub_category_id' => $sub["sub_category_id"],
				'product.product_is_inappropriate' =>'Approve',
				'product.product_deactivate'=>null,
                //'product.product_is_inappropriate !=' => 'Inappropriate',
                'is_delete' => 0
            );

            $total = $this->dashboard->get_specific_count('product', $array);

            $subcatArr[$i]["total"] = $total;
            $i++;
        }

        $data['subcat'] = $subcatArr;
		 
        //Category Total
        $array = array(
            'category_id' => $cat_id,
            //'product.product_is_inappropriate !=' => 'Inappropriate',
			'product.product_is_inappropriate' =>'Approve',
			'product.product_deactivate'=>null,
            'is_delete' => 0
        );

        $total = $this->dashboard->get_specific_count('product', $array);
        $data['total'] = $total;
		
        //Category name
        $where = " category_id = $cat_id";
        $category = $this->dbcommon->filter('category', $where);
        $data['category_name'] = $category[0]['catagory_name'];
        $data['category_id'] = $cat_id;
        $data['sub_category_id'] = $subcat_id;
        $data = array_merge($data, $this->get_elements());
		if(isset($subcategory[0]['sub_category_name']) && $subcategory[0]['sub_category_name']!='')
			$data['page_title'] =	$data['subcat_total'].' Ads in '.$subcategory[0]['sub_category_name'];
		else
			$data['page_title'] = 	$total.' Ads in '.$category[0]['catagory_name'];

        $breadcrumb = array(
            'Home' => base_url(),
            $category[0]['catagory_name'] => '#',
        );
        if ($subcat_id != null) {
            $breadcrumb = array(
                'Home' => base_url(),
                $category[0]['catagory_name'] => base_url() . 'home/category/' . $cat_id,
                $subcategory[0]['sub_category_name'] => '#'
            );
        }

        $data['breadcrumbs'] = $breadcrumb;
        $data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }
        $this->load->view('home/category_listing_grid', $data);
		}
		else
			redirect('home');
    }

    public function search() {

        // Filteration
		$between_banners 		 = $this->dbcommon->getBanners('','','between items');				
		$data['between_banners'] = $between_banners;   
		if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='') {		
			$mycnt	=	$between_banners[0]['impression_count']+1;
			$array1	=	array('ban_id'=>$between_banners[0]['ban_id']);
			$data1	=	array('impression_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array1, $data1);
		}	
		
        $cat_id 		= $this->input->post("cat");
        $sub_cat_id 	= $this->input->post("sub_cat");
        $city_id 		= $this->input->post("city");
        $location 		= $this->input->post("location");
        $min_amount 	= $this->input->post("min_amount");
        $max_amount 	= $this->input->post("max_amount");
        $search_value   = $this->input->post("search_value");

        $where = "";
        if ($cat_id != "0" && $cat_id != '')
            $where .= " and p.category_id = $cat_id";
        if ($sub_cat_id != "0" && $sub_cat_id != '')
            $where .= " and p.sub_category_id = $sub_cat_id";
		if ($location != "0" && $location != '')
            $where .= " and p.country_id = $location";	
        if ($city_id != "0" && $city_id != '')
            $where .= " and p.state_id = $city_id";
        if ($min_amount != "" && $max_amount != "")
            $where .= " and p.product_price between $min_amount and $max_amount";
        else if ($min_amount != "")
            $where .= " and p.product_price >= $min_amount";
        else if ($max_amount != "")
            $where .= " and p.product_price <= $max_amount";
        if ($search_value != "") {
            $where .= "AND (
                        p.product_name LIKE '%" . $search_value . "%'
                        OR c.catagory_name LIKE '%" . $search_value . "%'
                        OR u.username LIKE '%" . $search_value . "%'
						OR u.nick_name LIKE '%" . $search_value . "%'
                        ) and p.is_delete=0";
        }

		$query1 = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,
                c.catagory_name, u.username, u.profile_picture, u.facebook_id,u.twitter_id,u.google_id
				FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by
                and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where group by p.product_id";
		$prod 			= $this->db->query($query1);
		$total_product  = $prod->num_rows($prod);
		
		$where .= " group by `product_id`";
        $where .= " order by `admin_modified_at`  desc limit 0,12";
        $query = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,
                c.catagory_name, u.username, u.profile_picture, u.facebook_id,u.twitter_id,u.google_id
				FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by
                and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where";
		//p.product_is_inappropriate != 'Inappropriate'
        $product = $this->dbcommon->get_distinct($query);
		
        $data['product'] = $product;
        if ($cat_id != "0" && $cat_id != '') {
            $where = " category_id = $cat_id";
            $category = $this->dbcommon->filter('category', $where);
            $data['category_name'] = $category[0]['catagory_name'];

            $where = " category_id = $cat_id";
            $category = $this->dbcommon->filter('category', $where);
            $data['sub_category'] = $this->dbcommon->filter('sub_category', $where);
        }
		$data['hide'] = "false";
			if ($total_product <= 12) {
				$data['hide'] = "true";
			}
        $data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }
        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = $total_product. ' Ads found' ;
		
		if(isset($_POST['sel_city']))
			$sel_city	=	$_POST['sel_city'];
		else
			$sel_city	=	0;
        
        $data['sel_city'] = $sel_city;
		
        $this->load->view('home/search', $data);
    }
	
	public function more_search() {
		
		$between_banners 		 = $this->dbcommon->getBanners('','','between items');				
		$data['between_banners'] = $between_banners;   
		if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='') {		
			$mycnt	=	$between_banners[0]['impression_count']+1;
			$array1	=	array('ban_id'=>$between_banners[0]['ban_id']);
			$data1	=	array('impression_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array1, $data1);
		}	
        // Filteration
        $cat_id 		= $this->input->post("cat1");
        $sub_cat_id 	= $this->input->post("sub_cat1");
        $city_id 		= $this->input->post("city1");
        $cityname 		= $this->input->post("cityname");
		$location 		= $this->input->post("location");
        $min_amount	 	= $this->input->post("min_amount1");
        $max_amount 	= $this->input->post("max_amount1");
        $search_value 	= $this->input->post("search_value1");

        $where = "";
        if ($cat_id != "0" && $cat_id != '')
            $where .= " and p.category_id = $cat_id";
        if ($sub_cat_id != "0" && $sub_cat_id != '')
            $where .= " and p.sub_category_id = $sub_cat_id";
		if ($location != "0" && $location != '')
            $where .= " and p.country_id = $location";		
        if ($city_id != "0" && $city_id != '')
            $where .= " and p.state_id = $city_id";
			
			
		if ($cityname != "0" && $cityname != '' && $cityname != 'all') {
			$w = array('state_name' => "'" . $cityname . "'");			
            $get_result = $this->dbcommon->getdetailsinfo('state', $w);
			$state_id = $get_result->state_id;
            $where .= " and p.state_id = $state_id";
		}
        if ($min_amount != "" && $max_amount != "")
            $where .= " and p.product_price between $min_amount and $max_amount";
        else if ($min_amount != "")
            $where .= " and p.product_price >= $min_amount";
        else if ($max_amount != "")
            $where .= " and p.product_price <= $max_amount";
        if ($search_value != "") {
            $where .= "AND (
                        p.product_name LIKE '%" . $search_value . "%'
                        OR c.catagory_name LIKE '%" . $search_value . "%'
                        OR u.username LIKE '%" . $search_value . "%'
						OR u.nick_name LIKE '%" . $search_value . "%'
                        ) and p.is_delete=0";
        }
		
		 $query1 = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,u.facebook_id,u.twitter_id,u.google_id,c.catagory_name, u.username, u.profile_picture,p.product_is_sold  FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where group by p.product_id";
				
		$filter_val 	= $this->input->post("value");
		$start 			= 12 * $filter_val;
        $end 			= $start + 12;
        $hide 			= "false";	
		
		$prod 			= $this->db->query($query1);
		$total_product  = $prod->num_rows($prod);

		$where .= " group by `product_id`";
		$where .= " order by `admin_modified_at` desc limit $start,12";
        $query = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold,
                c.catagory_name, u.username, u.profile_picture FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by
                and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where";
		//p.product_is_inappropriate != 'Inappropriate'
        $product = $this->dbcommon->get_distinct($query);
		
        $data['product_data'] = $product;
        if ($cat_id != "0" && $cat_id != '') {
            $where = " category_id = $cat_id";
            $category = $this->dbcommon->filter('category', $where);
            $data['category_name'] = $category[0]['catagory_name'];

            $where = " category_id = $cat_id";
            $category = $this->dbcommon->filter('category', $where);
            $data['sub_category'] = $this->dbcommon->filter('sub_category', $where);
        }
		
		if ($end >= $total_product) {
            $hide = "true";
        }
		
        $data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }
        $data = array_merge($data, $this->get_elements());
        $data['page_title'] = 'Search Results';
		$data["html"] 			= $this->load->view('home/more_search', $data, TRUE);
		$data["val"] 			= $hide;
		$data["total_product"] 	= $total_product;
        echo json_encode($data);
		exit();
    }

	 public function advanced_search() {
	
		$between_banners 		 = $this->dbcommon->getBanners('','','between items');				
		$data['between_banners'] = $between_banners;   
		if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='') {		
			$mycnt	=	$between_banners[0]['impression_count']+1;
			$array1	=	array('ban_id'=>$between_banners[0]['ban_id']);
			$data1	=	array('impression_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array1, $data1);
		}	
		
		//$location = $this->dbcommon->select('country');
		$location = $this->dbcommon->select_orderby('country', 'country_name', 'asc');
		$data['location'] = $location;
		
		$brand = $this->dbcommon->getbrandlist();
        $data['brand']  = $brand;   
		
		$mileage = $this->dbcommon->getmileagelist();
        $data['mileage']    = $mileage; 
		
		$colors = $this->dbcommon->getcolorlist();
        $data['colors'] = $colors;  
		
		$data = array_merge($data, $this->get_elements());
		$where	=	'';
		$data['page_title'] = 'Advanced Search';
		if(isset($_POST['default']) || isset($_POST['vehicle_submit']) || isset($_POST['real_estate_submit']) || isset($_POST['shared_submit']) ) {
			
			$start=0;
			$limit=12;
			
			$where	.=	$this->get_data_advanced($start,$limit);
			$where .= " group by p.product_id";
			$query1 = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,
			c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold  FROM product as p , category as c , user as u,product_vehicles_extras as v,product_realestate_extras r  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where ";
			
			$prod 			= $this->db->query($query1);
			$total_product  = $prod->num_rows($prod);
			
						
			$where .= " order by `admin_modified_at` desc limit 12";
			
			$query = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,
			c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold  FROM product as p , category as c , user as u,product_vehicles_extras as v,product_realestate_extras r  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where ";
					
			$product = $this->dbcommon->get_distinct($query);
			
			$data['hide'] = "false";
			if ($total_product <= 12) {
				$data['hide'] = "true";
			}
			//echo $this->db->last_query();
			//exit;
			$data['product'] = $product;
			$data['page_title'] = $total_product.' Ads found';
			$data['is_logged'] = 0;
			if ($this->session->userdata('gen_user')) {
				$data['is_logged'] = 1;
			}
				
			$this->load->view('home/advanced_search_data', $data);
		}
		else
		{
			$this->load->view('home/advanced_search', $data);	
		}
    }
	
	public function load_more_advanced_search()
	{
		$data=	array();
		$between_banners 		 = $this->dbcommon->getBanners('','','between items');				
		$data['between_banners'] = $between_banners;   
		
		if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='') {		
			$mycnt	=	$between_banners[0]['impression_count']+1;
			$array1	=	array('ban_id'=>$between_banners[0]['ban_id']);
			$data1	=	array('impression_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array1, $data1);
		}	
		
		$arr = array_merge($data, $this->get_elements());
		$arr['page_title'] = 'Search Results';
		
		$cat_id 		= $this->input->post("cat_id");
		$sub_cat_id 	= $this->input->post("sub_cat");
		$country_id 	= $this->input->post("location1");
		$city_id 		= $this->input->post("city");
		$min_amount 	= $this->input->post("from_price");
		$max_amount 	= $this->input->post("to_price");
		$houses_free 	= $this->input->post("houses_free");
		$shared_free 	= $this->input->post("shared_free");
			//print_r($_REQUEST['location']);
		$where = "";
		if ($cat_id != "0" && $cat_id != '')
				$where .= " and p.category_id = $cat_id";
			if ($sub_cat_id != "0" && $sub_cat_id != '')
				$where .= " and p.sub_category_id = $sub_cat_id";
			if ($country_id != "0" && $country_id != '')
				$where .= " and p.country_id = $country_id";
			if ($city_id != "0" && $city_id != '')
				$where .= " and p.state_id = $city_id";
		
		if(isset($houses_free) && $houses_free!='')
			$where .= " and r.free_status=1";
		elseif(isset($houses_free) && $houses_free!='')	
			$where .= " and r.free_status=1";
		else
		{
			if ($min_amount != "" && $max_amount != "")
				$where .= " and p.product_price between $min_amount and $max_amount";
			else if ($min_amount != "")
				$where .= " and p.product_price >= $min_amount";
			else if ($max_amount != "")
				$where .= " and p.product_price <= $max_amount";	
		}	
		$pro_brand 				= $this->input->post("pro_brand");
		$vehicle_pro_model 		= $this->input->post("vehicle_pro_model");
		$vehicle_pro_year 		= $this->input->post("vehicle_pro_year");
		$vehicle_pro_mileage 	= $this->input->post("vehicle_pro_mileage");
		$vehicle_pro_color 		= $this->input->post("vehicle_pro_color");
					
		if($pro_brand != "0" && $pro_brand != "")
			$where .= ' and p.product_brand='.(int)$pro_brand;
		if($vehicle_pro_model != "0" && $vehicle_pro_model != "")
			$where .= ' and v.model='.(int)$vehicle_pro_model;
		if($vehicle_pro_year  != "0" && $vehicle_pro_year != "")	
			$where .= ' and v.year='.(int)$vehicle_pro_year;
		if($vehicle_pro_mileage  != "0" && $vehicle_pro_mileage != "")	
			$where .= ' and v.millage='.(int)$vehicle_pro_mileage;
		if($vehicle_pro_color  != "0" && $vehicle_pro_color != "")	
			$where .= ' and v.color='.(int)$vehicle_pro_color;	
			
			
		$furnished 				= $this->input->post("furnished");
		$bedrooms 				= $this->input->post("bedrooms");
		$bathrooms 				= $this->input->post("bathrooms");
		$pets 					= $this->input->post("pets");
		$broker_fee 			= $this->input->post("broker_fee");
		
		if($furnished != "0" && $furnished != "")
				$where .= ' and r.furnished="'.$furnished.'"';
		if($bedrooms != "0" && $bedrooms != "")
				$where .= ' and r.Bedrooms="'.$bedrooms.'"';
		if($bathrooms != "0" && $bathrooms != "")
				$where .= ' and r.Bathrooms="'.$bathrooms.'"';
		if($pets != "0" && $pets != "")
				$where .= ' and r.pets="'.$pets.'"';					
		if($broker_fee != "0" && $broker_fee != "")
				$where .= ' and r.broker_fee="'.$broker_fee.'"';
				
		$where .= " group by p.product_id";
		
		$query1 = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,
				c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id  FROM product as p , category as c , user as u,product_vehicles_extras as v,product_realestate_extras r  where p.category_id=c.category_id and u.user_id = p.product_posted_by
				and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where ";
				
		$filter_val = $this->input->post("value");
		$start = 12 * $filter_val;
        $end = $start + 12;
        $hide = "false";	
		
		$prod 			= $this->db->query($query1);
		$total_product  = $prod->num_rows($prod);
		
		$where .= " order by `admin_modified_at` desc limit $start,12";							
		$query = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,
					c.catagory_name, u.username, u.profile_picture, u.facebook_id,u.twitter_id,u.google_id  FROM product as p , category as c , user as u,product_vehicles_extras as v,product_realestate_extras r  where p.category_id=c.category_id and u.user_id = p.product_posted_by
					and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where ";
		
		$product_data = $this->dbcommon->get_distinct($query);
		
		//echo $this->db->last_query();
		if ($end >= $total_product) {
            $hide = "true";
        }
		
		$arr['product_data'] = $product_data;
		$arr['is_logged'] = 0;
		if ($this->session->userdata('gen_user')) {
			$arr['is_logged'] = 1;
		}
		$arr["html"] 			= $this->load->view('home/more_advanced_search', $arr, TRUE);
		$arr["val"] 			= $hide;
		$arr["total_product"] 	= $total_product;
		echo json_encode($arr);
		exit();
			
	}
	
	public function get_data_advanced($start,$limit)
	{
		if(isset($_POST['default']) || isset($_POST['vehicle_submit']) || isset($_POST['real_estate_submit']) || isset($_POST['shared_submit']) ) {
			//exit;
			// Filteration
			$cat_id 		= $this->input->post("cat_id");
			$sub_cat_id 	= $this->input->post("sub_cat");
			$country_id 	= $this->input->post("location");
			$city_id 		= $this->input->post("city");
			$min_amount 	= $this->input->post("from_price");
			$max_amount 	= $this->input->post("to_price");
			
			$where = "";
			if ($cat_id != "0" && $cat_id != '')
					$where .= " and p.category_id = $cat_id";
				if ($sub_cat_id != "0" && $sub_cat_id != '')
					$where .= " and p.sub_category_id = $sub_cat_id";
				if ($country_id != "0" && $country_id != '')
					$where .= " and p.country_id = $country_id";
				if ($city_id != "0" && $city_id != '')
					$where .= " and p.state_id = $city_id";
				
			if(isset($_POST['default']))
			{
				if ($min_amount != "" && $max_amount != "")
					$where .= " and p.product_price between $min_amount and $max_amount";
				else if ($min_amount != "")
					$where .= " and p.product_price >= $min_amount";
				else if ($max_amount != "")
					$where .= " and p.product_price <= $max_amount";
			}
			elseif(isset($_POST['vehicle_submit']))
			{
					$pro_brand 				= $this->input->post("pro_brand");
					$vehicle_pro_model 		= $this->input->post("vehicle_pro_model");
					$vehicle_pro_year 		= $this->input->post("vehicle_pro_year");
					$vehicle_pro_mileage 	= $this->input->post("vehicle_pro_mileage");
					$vehicle_pro_color 		= $this->input->post("vehicle_pro_color");
					
					if($pro_brand != "0" && $pro_brand != "")
						$where .= ' and p.product_brand='.(int)$pro_brand;
					if($vehicle_pro_model != "0" && $vehicle_pro_model != "")
						$where .= ' and v.model='.(int)$vehicle_pro_model;
					if($vehicle_pro_year  != "0" && $vehicle_pro_year != "")	
						$where .= ' and v.year='.(int)$vehicle_pro_year;
					if($vehicle_pro_mileage  != "0" && $vehicle_pro_mileage != "")	
						$where .= ' and v.millage='.(int)$vehicle_pro_mileage;
					if($vehicle_pro_color  != "0" && $vehicle_pro_color != "")	
						$where .= ' and v.color='.(int)$vehicle_pro_color;	
						
						
					if ($min_amount != "" && $max_amount != "")
					$where .= " and p.product_price between $min_amount and $max_amount";
					else if ($min_amount != "")	
						$where .= " and p.product_price >= $min_amount";
					else if ($max_amount != "")
						$where .= " and p.product_price <= $max_amount";	
			}
			elseif(isset($_POST['real_estate_submit']))
			{
				$furnished 				= $this->input->post("furnished");
				$bedrooms 				= $this->input->post("bedrooms");
				$bathrooms 				= $this->input->post("bathrooms");
				$pets 					= $this->input->post("pets");
				$broker_fee 			= $this->input->post("broker_fee");
				if($furnished != "0" && $furnished != "")
						$where .= ' and r.furnished="'.$furnished.'"';
				if($bedrooms != "0" && $bedrooms != "")
						$where .= ' and r.Bedrooms="'.$bedrooms.'"';
				if($bathrooms != "0" && $bathrooms != "")
						$where .= ' and r.Bathrooms="'.$bathrooms.'"';
				if($pets != "0" && $pets != "")
						$where .= ' and r.pets="'.$pets.'"';					
				if($broker_fee != "0" && $broker_fee != "")
						$where .= ' and r.broker_fee="'.$broker_fee.'"';
				if(!isset($_POST['houses_free']))				
				{
					if ($min_amount != "" && $max_amount != "")
						$where .= " and p.product_price between $min_amount and $max_amount";
					else if ($min_amount != "")	
						$where .= " and p.product_price >= $min_amount";
					else if ($max_amount != "")
						$where .= " and p.product_price <= $max_amount";				
				}
				else
					$where .= " and r.free_status=1";
			}
			elseif(isset($_POST['shared_submit']))
			{
				if(!isset($_POST['shared_free']))				
				{
					if ($min_amount != "" && $max_amount != "")
						$where .= " and p.product_price between $min_amount and $max_amount";
					else if ($min_amount != "")	
						$where .= " and p.product_price >= $min_amount";
					else if ($max_amount != "")
						$where .= " and p.product_price <= $max_amount";				
				}
				else
					$where .= " and r.free_status=1";
			}
			
			return $where;
		}
	}
    public function search_by_city() {
		
		$between_banners 		 = $this->dbcommon->getBanners('','','between items');				
		$data['between_banners'] = $between_banners;   
		if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='') {		
			$mycnt	=	$between_banners[0]['impression_count']+1;
			$array1	=	array('ban_id'=>$between_banners[0]['ban_id']);
			$data1	=	array('impression_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array1, $data1);
		}	
		if($this->uri->segment(3)!='') {
			$state_id = $this->uri->segment(3);
			$where = array('state_id' => "'" . (int)$state_id . "'");
            $get_result = $this->dbcommon->getdetailsinfo('state', $where);
			$id = $get_result->state_id;			
		}	
		elseif(isset($_REQUEST['selection']) && $_REQUEST['selection']!='' && $_REQUEST['selection']!='all') {
			$selected = $this->input->post("selection");
			$where = array('state_name' => "'" . $selected . "'");
			//$where = array('state_id' => "'" . $selected . "'");
            $get_result = $this->dbcommon->getdetailsinfo('state', $where);
			$id = $get_result->state_id;
			
			$data['selected'] = $selected;
		}
         else {
            $id = null;
        }

			
		$start	=	0;	
		$total_product = $this->dbcommon->get_products_by_city_cnt($id);		
		
		$data['hide'] = "false";
			if ($total_product <= 12) {
					$data['hide'] = "true";
			}
			
        $search_results = $this->dbcommon->get_products_by_city($id,$start);				
        $data['product'] = $search_results;
        $data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }


        $data = array_merge($data, $this->get_elements());
        //$data['selected'] = $selected;
        $data['page_title'] = 'Search Results';
        $this->load->view('home/search', $data);
    }
	/*
	public function search_by_city_more() {
		$filter_val 	= $this->input->post("value");
		
		$total_product = $this->dbcommon->get_products_by_city_cnt($id);		
		
		$start 			= 	12 * $filter_val;
        $end 			= 	$start + 12;
        $hide 			= 	"false";		
		
		if ($end >= $total_product) {
            $hide = "true";
        }
		
		$search_results = $this->dbcommon->get_products_by_city($id,$start);
		
		
		$this->load->view('home/search', $data);
	} */

    public function category_map($cat_id = null, $subcat_id = null, $pro_id = null) {                
        // $data['banner'] = $banners;
        //$data['intro_banners'] = $intro_banners;
        //$data['between_banners'] = $between_banners;

        $count = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);
        $url = base_url() . "home/category_map/" . $cat_id;

        if ($subcat_id != null) {
            $url = base_url() . "home/category_map/" . $cat_id . "/" . $subcat_id;
        }
        $config = array();
        $config["base_url"] = $url;
        $config["total_rows"] = $count;
        $config["per_page"] = 5;
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


        $this->pagination->initialize($config);

        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        $offset = ($page == 0) ? 0 : ($page - 1) * $config["per_page"];



        $product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, $pro_id, $config["per_page"], $offset);
        if ($cat_id == 7) {
            $product = $this->dbcommon->get_vehicle_products($cat_id, $subcat_id, $pro_id, $config["per_page"], $offset);
        }
        if ($cat_id == 8) {
            $product = $this->dbcommon->get_real_estate_products($cat_id, $subcat_id, $pro_id, $config["per_page"], $offset);
        }
		//echo '<pre>';		
		
		//print_r($product);
        $data['product'] = $product;
		//print_r($data['product']);
        $data["links"] = $this->pagination->create_links();

        if ($subcat_id != null && $subcat_id != 0) {
            $data["subcat_id"] = $subcat_id;
            $where = " sub_category_id = $subcat_id";
            $subcategory = $this->dbcommon->filter('sub_category', $where);
			if(sizeof($subcategory)>0) {
            $data['subcat_name'] = $subcategory[0]['sub_category_name'];
            $array = array(
                'sub_category_id' => $subcat_id,
                'is_delete' => 0,
				'product.product_is_inappropriate' =>'Approve',
				'product.product_deactivate'=>null,
            );

            $total = $this->dashboard->get_specific_count('product', $array);
            $data['subcat_total'] = $total;
			 }
			 else
			 {
				redirect('home');
			 }
        }


        if ($pro_id == "" && !empty($product)) {
            $pro_id = $product[0]["product_id"];
        }
        $data['pro_id'] = $pro_id;
                 
        
		$query = "category_id= '" . $cat_id . "' order by sub_cat_order asc";
        $subcat = $this->dbcommon->filter('sub_category', $query);

        $subcatArr = array();
        $i = 0;
        foreach ($subcat as $sub) {
            $subcatArr[$i]["id"] = $sub["sub_category_id"];
            $subcatArr[$i]["name"] = $sub["sub_category_name"];
            $array = array(
                'sub_category_id' => $sub["sub_category_id"],
                'is_delete' => 0,
				'product.product_is_inappropriate' =>'Approve',
				'product.product_deactivate'=>null,
            );

            $total = $this->dashboard->get_specific_count('product', $array);

            $subcatArr[$i]["total"] = $total;
            $i++;
        }
        $data['subcat'] = $subcatArr;

        //Category Total
        $array = array(
            'category_id' => $cat_id,
            'is_delete' => 0,
			'product.product_is_inappropriate' =>'Approve',
			'product.product_deactivate'=>null,
        );

        $total = $this->dashboard->get_specific_count('product', $array);

        $data['total'] = $total;

        //Category name
        $where = " category_id = $cat_id";
        $category = $this->dbcommon->filter('category', $where);
        $data['category_name'] = $category[0]['catagory_name'];
        $data['category_id'] = $cat_id;
        $data['sub_category_id'] = $subcat_id;
        $data = array_merge($data, $this->get_elements());
        //$data['page_title'] = 'Categories';
		if(isset($subcategory[0]['sub_category_name']) && $subcategory[0]['sub_category_name']!='')
			$data['page_title'] =	$data['subcat_total'].' Ads in '.$subcategory[0]['sub_category_name'];
		else
			$data['page_title'] = 	$total.' Ads in '.$category[0]['catagory_name'];
        $breadcrumb = array(
            'Home' => base_url(),
            $category[0]['catagory_name'] => '#',
        );
        if ($subcat_id != null && $subcat_id != 0) {
            $breadcrumb = array(
                'Home' => base_url(),
                $category[0]['catagory_name'] => base_url() . 'home/category/' . $cat_id,
                $subcategory[0]['sub_category_name'] => '#'
            );
        }

        $data['breadcrumbs'] = $breadcrumb;
        $data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }

        $this->load->view('home/category_map', $data);
    }

    public function category_listing($cat_id = null, $subcat_id = null) {		
		
        $data['between_banners'] = $this->catpage_banner_between($cat_id, $subcat_id);      

        $product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, null, 12);
        if ($cat_id == 7) {			
            $product = $this->dbcommon->get_vehicle_products($cat_id, $subcat_id, null, 12);
        }
        if ($cat_id == 8) {
            $product = $this->dbcommon->get_real_estate_products($cat_id, $subcat_id, null, 12);
        }
		
		//print_r($product);
        if ($subcat_id != null && $subcat_id != 0) {
            $data["subcat_id"] = $subcat_id;
            $where = " sub_category_id = $subcat_id";
			
            $subcategory = $this->dbcommon->filter('sub_category', $where);
			
			if(sizeof($subcategory)>0)
			{
            $data['subcat_name'] = $subcategory[0]['sub_category_name'];
            $array = array(
                'sub_category_id' => $subcat_id,
                'is_delete' => 0,
				'product_is_inappropriate' =>'Approve',
				'product_deactivate'=>null,
            );

            $total = $this->dashboard->get_specific_count('product', $array);
			
            $data['subcat_total'] = $total;
			//print_r($data['subcat_total']);
		
			}
			else { redirect('/home');  }
			
        }
        $total_product = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);
		
        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        }

        $data['product'] = $product;

        //SubCategory             
        
		$query = "category_id= '" . $cat_id . "' order by sub_cat_order asc";
        $subcat = $this->dbcommon->filter('sub_category', $query);

        $subcatArr = array();
        $i = 0;
        foreach ($subcat as $sub) {
            $subcatArr[$i]["id"] = $sub["sub_category_id"];
            $subcatArr[$i]["name"] = $sub["sub_category_name"];
            $array = array(
                'sub_category_id' => $sub["sub_category_id"],
                'is_delete' => 0,
				'product_deactivate'=>null,
				'product_is_inappropriate'=>'Approve'
            );

            $total = $this->dashboard->get_specific_count('product', $array);
		
            $subcatArr[$i]["total"] = $total;
            $i++;
        }
		
        $data['subcat'] = $subcatArr;

        //Category Total
        $array = array(
            'category_id' => $cat_id,
            'is_delete' => 0,
			'product_deactivate'=>null,
			'product_is_inappropriate'=>'Approve'
        );

        $total = $this->dashboard->get_specific_count('product', $array);

        $data['total'] = $total;

        //Category name
        $where = " category_id = $cat_id";
        $category = $this->dbcommon->filter('category', $where);
        $data['category_name'] = $category[0]['catagory_name'];
        $data['category_id'] = $cat_id;
        $data['sub_category_id'] = $subcat_id;

        $data = array_merge($data, $this->get_elements());

        //echo "<pre>";                print_r($data); die;
        //$data['page_title'] = 'Categories';
		if(isset($subcategory[0]['sub_category_name']) && $subcategory[0]['sub_category_name']!='')
			$data['page_title'] =	$data['subcat_total'].' Ads in '.$subcategory[0]['sub_category_name'];
		else
			$data['page_title'] = 	$total.' Ads in '.$category[0]['catagory_name'];
        $breadcrumb = array(
            'Home' => base_url(),
            $category[0]['catagory_name'] => '#',
        );
        if ($subcat_id != null) {
            $breadcrumb = array(
                'Home' => base_url(),
                $category[0]['catagory_name'] => base_url() . 'home/category/' . $cat_id,
                $subcategory[0]['sub_category_name'] => '#'
            );
        }

        $data['breadcrumbs'] = $breadcrumb;
        $data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }
        $this->load->view('home/category_listing', $data);
    }

    public function favorite() {

		$query_cnt = "p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,p.product_posted_by,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,u.facebook_id,u.twitter_id,u.google_id,c.catagory_name, u.username, u.profile_picture  FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate = 'Approve' and p.product_deactivate is null and p.product_total_favorite > 0 order by `admin_modified_at`";
		
		$total_product	=	$this->dbcommon->getnumofdetails_($query_cnt);	
		
        //if($this->session->userdata('user')){ 
        $query = "SELECT p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,p.product_posted_by,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,u.facebook_id,u.twitter_id,u.google_id,c.catagory_name, u.username, u.profile_picture  FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate = 'Approve' and p.product_deactivate is null and p.product_total_favorite > 0 order by `admin_modified_at` limit 0,12";
				
        $favproduct = $this->dbcommon->get_distinct($query);
		
		$data['hide'] = "false";
			if ($total_product <= 12) {
					$data['hide'] = "true";
			}
			
		$data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }
		
        $data['favproduct'] = $favproduct;
        $data = array_merge($data, $this->get_elements());
		
        $data['page_title'] = $total_product.' Ads Favorites';
        $this->load->view('home/favorite', $data);
        //}
    }

	public function more_favorite() {
        
		$filter_val 	= $this->input->post("value");
		
		$query_cnt = " p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,p.product_posted_by,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,u.facebook_id,u.twitter_id,u.google_id,c.catagory_name, u.username, u.profile_picture  FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate = 'Approve' and p.product_deactivate is null and p.product_total_favorite > 0 order by `admin_modified_at`";
		
		$total_product	=	$this->dbcommon->getnumofdetails_($query_cnt);		
		
		$start 			= 	12 * $filter_val;
        $end 			= 	$start + 12;
        $hide 			= 	"false";		
		
		if ($end >= $total_product) {
            $hide = "true";
        }
		  
        $query = "SELECT p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,p.product_posted_by,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,u.facebook_id,u.twitter_id,u.google_id,c.catagory_name, u.username, u.profile_picture  FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate = 'Approve' and p.product_deactivate is null and p.product_total_favorite > 0 order by `admin_modified_at` limit $start,12";
		
		$favproduct = $this->dbcommon->get_distinct($query);
		
		$data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }
		
        $data['favproduct'] 	= $favproduct;                
        $data["html"] 			= $this->load->view('home/more_favorite',$data,TRUE);
        $data["val"] 			= $hide;
		$data["total_product"] 	= $total_product;
        echo json_encode($data);
		exit();
    }
	
    public function load_more_category($cat_id = null, $subcat_id = null) {		
	
		// getting the banners for the category page.	  
      $data['between_banners'] = $this->catpage_banner_between($cat_id, $subcat_id);          

        //echo "hide = ".@$data['hide'] ." end = ".$end." Total product = ".$total_product; 
        if ($subcat_id != null && $subcat_id != 0) {
            $query = "SELECT p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,p.product_posted_by,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,u.twitter_id,u.facebook_id,u.google_id,
                  c.catagory_name, u.username, u.profile_picture  FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by
                  and p.is_delete = 0 and   p.product_is_inappropriate='Approve' and p.product_deactivate is null and p.category_id = '" . $cat_id . "' and p.sub_category_id = '" . $subcat_id . "'";
        } else {
            $query = "SELECT p.product_id,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,p.product_posted_by,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,u.twitter_id,u.facebook_id,u.google_id,
                 