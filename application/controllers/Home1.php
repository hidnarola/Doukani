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

        $data   =  array();

	      // getting the banners for home page
            $between_banners         = $this->dbcommon->getBanner('between',"'home_page','all_page'",null,null);                
            $data['between_banners'] = $between_banners;
            
            $feature_banners         = $this->dbcommon->getBanner('sidebar',"'home_page','all_page'",null,null);                
            $data['feature_banners'] = $feature_banners;
            
            if(isset($feature_banners[0]['ban_id']) && $feature_banners[0]['ban_id']!='')
            {       
                $mycnt  =   $feature_banners[0]['impression_count']+1;
                $array1 =   array('ban_id'=>$feature_banners[0]['ban_id']);
                $data1  =   array('impression_count'=>$mycnt);
                $this->dbcommon->update('custom_banner', $array1, $data1);
            }               
            
            if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='')
            {       
                $mycnt  =   $between_banners[0]['impression_count']+1;
                $array1 =   array('ban_id'=>$between_banners[0]['ban_id']);
                $data1  =   array('impression_count'=>$mycnt);
                $this->dbcommon->update('custom_banner', $array1, $data1);
            }

         
          {
        

		        
        		
                $product = $this->dbcommon->get_products();
        		$data['latest_product'] = $product;
        		//echo $this->db->last_query();
        		        
                $featured_product = $this->dbcommon->get_featured_ads(null,12);		
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
               
        		$current_user = $this->session->userdata('gen_user');
                if ($current_user)
                    $user_id = $current_user['user_id'];
        		$data['is_logged'] = 0;	
        		$data['loggedin_user']	=	'';
                if ($this->session->userdata('gen_user')) {
        			$current_user   = $this->session->userdata('gen_user');
        			$data['loggedin_user']= $current_user['user_id'];
                    $data['is_logged'] = 1;
                }
                $this->load->view('home/index', $data);

            }    
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
		
		$arr = array();
		$data['is_logged'] = 0;	
		$data['loggedin_user']	=	'';
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        
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
		$cat_id		=	(int)$cat_id;		
		$subcat_id	=	(int)$subcat_id;
		
		if($cat_id!='')
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
        if ($cat_id == 7) 			
            $product = $this->dbcommon->get_vehicle_products($cat_id, $subcat_id, null, 12);			        
        if ($cat_id == 8) 
            $product = $this->dbcommon->get_real_estate_products($cat_id, $subcat_id, null, 12);			
        
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
			if(sizeof($category)>0) {
				$data['category_name'] = $category[0]['catagory_name'];
				$data['category_id'] = $cat_id;
				$data['sub_category_id'] = $subcat_id;
				$data = array_merge($data, $this->get_elements());
				if(isset($subcategory[0]['sub_category_name']) && $subcategory[0]['sub_category_name']!='')
					$data['page_title'] =	$data['subcat_total'].' Ads in '.str_replace('\n', " ",$subcategory[0]['sub_category_name']);
				else
					$data['page_title'] = 	$total.' Ads in '.str_replace('\n', " ",$category[0]['catagory_name']);
			
				$order_option	=	'';
				
				if(isset($_REQUEST['order']) && $_REQUEST['order']!='' && $_REQUEST['order']=='lh') 
					$order_option	=	'?order='.$_REQUEST['order'];
				elseif(isset($_REQUEST['order']) && $_REQUEST['order']!='' && $_REQUEST['order']=='hl')
					$order_option	=	'?order='.$_REQUEST['order'];
				
				$data['order_option']=	$order_option;
				
				//print_r($data['page_title']);
				$breadcrumb = array(
					'Home' => base_url(),
					$category[0]['catagory_name'] => '#',
				);
				if ($subcat_id != null) {
					$breadcrumb = array(
						'Home' => base_url(),
						$category[0]['catagory_name'] => base_url() . 'home/category/' . $cat_id.'/'.$order_option,
						$subcategory[0]['sub_category_name'] => '#'
					);
				}

				$data['breadcrumbs'] 	=	$breadcrumb;
				$data['is_logged'] 		= 	0;	
				$data['loggedin_user']	=	'';
				if ($this->session->userdata('gen_user')) {
					$current_user   = $this->session->userdata('gen_user');
					$data['loggedin_user']= $current_user['user_id'];
					$data['is_logged'] = 1;
				}
				
				$this->load->view('home/category_listing_grid', $data);
			}
			else
				redirect('home');
		}
		else
			redirect('home');
    }

	//serach from left menu at Front End	
    public function search() {

        // Filteration
		$between_banners 		 = $this->dbcommon->getBanner('between',"'content_page','all_page'",null,null);				
		$data['between_banners'] = $between_banners;   				
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
                c.catagory_name, u.username, u.profile_picture, u.facebook_id,u.twitter_id,u.google_id,p.product_total_likes
				FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by
                and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where group by p.product_id";
		$prod 			= $this->db->query($query1);
		$total_product  = $prod->num_rows($prod);
		
		$where .= " group by `product_id`";
        $where .= " order by `admin_modified_at`  desc limit 0,12";
        $query = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,
                c.catagory_name, u.username, u.profile_picture, u.facebook_id,u.twitter_id,u.google_id,p.product_total_likes
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
			
        $data['is_logged'] 		= 	0;	
		$data['loggedin_user']	=	'';
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
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
	
	//load search products using ajax
	public function more_search() {
		
		$between_banners 		 = $this->dbcommon->getBanner('between',"'content_page','all_page'",null,null);								
		$data['between_banners'] = $between_banners;   
		
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
		
		 $query1 = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,u.facebook_id,u.twitter_id,u.google_id,c.catagory_name, u.username, u.profile_picture,p.product_is_sold,p.product_total_likes  FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where group by p.product_id";
				
		$filter_val 	= $this->input->post("value");
		$start 			= 12 * $filter_val;
        $end 			= $start + 12;
        $hide 			= "false";	
		
		$prod 			= $this->db->query($query1);
		$total_product  = $prod->num_rows($prod);

		$where .= " group by `product_id`";
		$where .= " order by `admin_modified_at` desc limit $start,12";
        $query = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold,
                c.catagory_name, u.username, u.profile_picture,p.product_total_likes FROM product as p , category as c , user as u  where p.category_id=c.category_id and u.user_id = p.product_posted_by
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
		
        $data['is_logged'] 		= 	0;	
		$data['loggedin_user']	=	'';
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
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
	
		$between_banners 		 = $this->dbcommon->getBanner('between',"'content_page','all_page'",null,null);
		$data['between_banners'] = $between_banners;   
		$data['is_logged'] = 0;	
		$data['loggedin_user']	=	'';
		if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
			$data['is_logged'] = 1;
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
			$query1 = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_total_likes,
			c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold  FROM product as p , category as c , user as u,product_vehicles_extras as v,product_realestate_extras r  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where ";
			
			$prod 			= $this->db->query($query1);
			$total_product  = $prod->num_rows($prod);
						
			$where .= " order by `admin_modified_at` desc limit 12";
			
			$query = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,
			c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_is_sold,p.product_total_likes  FROM product as p , category as c , user as u,product_vehicles_extras as v,product_realestate_extras r  where p.category_id=c.category_id and u.user_id = p.product_posted_by and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where ";
					
			$product = $this->dbcommon->get_distinct($query);			
			
			$data['hide'] = "false";
			if ($total_product <= 12) {
				$data['hide'] = "true";
			}
			//echo $this->db->last_query();
			//exit;
			$data['product'] = $product;
			$data['page_title'] = $total_product.' Ads found';
    		$data['is_logged'] 		= 	0;	
			$data['loggedin_user']	=	'';
			if ($this->session->userdata('gen_user')) {
				$current_user   = $this->session->userdata('gen_user');
				$data['loggedin_user']= $current_user['user_id'];
				$data['is_logged'] = 1;
			}
				
			$this->load->view('home/advanced_search_data', $data);
		}
		else
		{
			$this->load->view('home/advanced_search', $data);	
		}
    }
	
	public function load_more_advanced_search() {
		$data=	array();
		$between_banners 		 = $this->dbcommon->getBanner('between',"'content_page','all_page'",null,null);
		$data['between_banners'] = $between_banners;   
		
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
				c.catagory_name, u.username, u.profile_picture,u.facebook_id,u.twitter_id,u.google_id,p.product_total_likes  FROM product as p , category as c , user as u,product_vehicles_extras as v,product_realestate_extras r  where p.category_id=c.category_id and u.user_id = p.product_posted_by
				and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where ";
				
		$filter_val = $this->input->post("value");
		$start = 12 * $filter_val;
        $end = $start + 12;
        $hide = "false";	
		
		$prod 			= $this->db->query($query1);
		$total_product  = $prod->num_rows($prod);
		
		$where .= " order by `admin_modified_at` desc limit $start,12";							
		$query = "SELECT p.product_id,p.product_posted_by,p.product_name,p.product_image,p.product_price,p.product_status,p.product_is_inappropriate ,p.product_total_views, p.product_total_favorite,if(u.nick_name!='',u.nick_name,u.username) as username1,p.product_is_sold,
					c.catagory_name, u.username, u.profile_picture, u.facebook_id,u.twitter_id,u.google_id,p.product_total_likes  FROM product as p , category as c , user as u,product_vehicles_extras as v,product_realestate_extras r  where p.category_id=c.category_id and u.user_id = p.product_posted_by
					and p.is_delete = 0 and p.product_is_inappropriate='Approve' and p.product_deactivate is null $where ";
		
		$product_data = $this->dbcommon->get_distinct($query);
		
		//echo $this->db->last_query();
		if ($end >= $total_product) {
            $hide = "true";
        }
		
		$arr['product_data'] = $product_data;
		$arr['is_logged'] 		= 	0;	
		$arr['loggedin_user']	=	'';
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$arr['loggedin_user']= $current_user['user_id'];
            $arr['is_logged'] = 1;
        }
		$arr["html"] 			= $this->load->view('home/more_advanced_search', $arr, TRUE);
		$arr["val"] 			= $hide;
		$arr["total_product"] 	= $total_product;
		echo json_encode($arr);
		exit();
			
	}
	
	public function get_data_advanced($start,$limit) {
		
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
		
		$between_banners 		 = $this->dbcommon->getBanner('between',"'content_page','all_page'",null,null);								
		$data['between_banners'] = $between_banners;   
			
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

		if($id>0) {	
			$start	=	0;	
			$total_product = $this->dbcommon->get_products_by_city_cnt($id);		
			
			$data['hide'] = "false";
				if ($total_product <= 12) {
						$data['hide'] = "true";
				}
				
			$search_results = $this->dbcommon->get_products_by_city($id,$start);				
			$data['product'] = $search_results;
			$data['is_logged'] = 0;	
			$data['loggedin_user']	=	'';
			if ($this->session->userdata('gen_user')) {
				$current_user   = $this->session->userdata('gen_user');
				$data['loggedin_user']= $current_user['user_id'];
				$data['is_logged'] = 1;
			}


			$data = array_merge($data, $this->get_elements());
			//$data['selected'] = $selected;
			$data['page_title'] = 'Search Results';
			$this->load->view('home/search', $data);
		}
		else
		{
			redirect('home');
		}
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

	//product display using google map	Category Wise
    public function category_map($cat_id = null, $subcat_id = null, $pro_id = null) {     
		$cat_id		=	(int)$cat_id;		
		$subcat_id	=	(int)$subcat_id;
		
		if($cat_id!='') {
			// $data['banner'] = $banners;
			//$data['intro_banners'] = $intro_banners;
			//$data['between_banners'] = $between_banners;
			$order_option	=	'';
			if(isset($_REQUEST['order']) && $_REQUEST['order']!='' && $_REQUEST['order']=='lh') 
				$order_option	=	'?order='.$_REQUEST['order'];
			elseif(isset($_REQUEST['order']) && $_REQUEST['order']!='' && $_REQUEST['order']=='hl')
				$order_option	=	'?order='.$_REQUEST['order'];
			
			$data['order_option']=	$order_option;
			
			$count = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);
			$url = base_url() . "home/category_map/" . $cat_id.'/'.$order_option;

			if ($subcat_id != null) {
				$url = base_url() . "home/category_map/" . $cat_id . "/" . $subcat_id.'/'.$order_option;
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

			if ($subcat_id != 0 && $subcat_id != 0) {
				$data["subcat_id"] = $subcat_id;
				$where = " sub_category_id = $subcat_id";
				$subcategory = $this->dbcommon->filter('sub_category',$where);
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
			$where = " category_id = '".$cat_id."'";
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
					$category[0]['catagory_name'] => base_url() . 'home/category/' . $cat_id.'/'.$order_option,
					$subcategory[0]['sub_category_name'] => '#'
				);
			}

			$data['breadcrumbs'] = $breadcrumb;
		   $data['is_logged'] = 0;	
			$data['loggedin_user']	=	'';
			if ($this->session->userdata('gen_user')) {
				$current_user   = $this->session->userdata('gen_user');
				$data['loggedin_user']= $current_user['user_id'];
				$data['is_logged'] = 1;
			}

			$this->load->view('home/category_map', $data);
		}
		else
			redirect('home');
    }

	//product display using Category Wise Listing
    public function category_listing($cat_id = null, $subcat_id = null) {
		if($cat_id!=''){	
			$cat_id 	= (int)$cat_id;
			$subcat_id  = (int)$subcat_id;
			$data['between_banners'] = $this->catpage_banner_between($cat_id, $subcat_id);      

			$product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, null, 12);
			if ($cat_id == 7) {			
				$product = $this->dbcommon->get_vehicle_products($cat_id, $subcat_id, null, 12);
			}
			if ($cat_id == 8) {
				$product = $this->dbcommon->get_real_estate_products($cat_id, $subcat_id, null, 12);
			}
			$order_option	=	'';
			if(isset($_REQUEST['order']) && $_REQUEST['order']!='' && $_REQUEST['order']=='lh') 
				$order_option	=	'?order='.$_REQUEST['order'];
			elseif(isset($_REQUEST['order']) && $_REQUEST['order']!='' && $_REQUEST['order']=='hl')
				$order_option	=	'?order='.$_REQUEST['order'];
			
			$data['order_option']=	$order_option;
			
			//echo $this->db->last_query();
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
			if(sizeof($category)>0) {
					$data['category_name'] 	= $category[0]['catagory_name'];
					$data['category_id'] 	= $cat_id;
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
							$category[0]['catagory_name'] => base_url() . 'home/category/' . $cat_id.'/'.$order_option,
							$subcategory[0]['sub_category_name'] => '#'
						);
					}

					$data['breadcrumbs'] = $breadcrumb;
					$data['is_logged'] 		= 	0;	
					$data['loggedin_user']	=	'';
					if ($this->session->userdata('gen_user')) {
						$current_user   = $this->session->userdata('gen_user');
						$data['loggedin_user']= $current_user['user_id'];
						$data['is_logged'] = 1;
					}
					$this->load->view('home/category_listing', $data);
				}
				else		
					redirect('home');
		}
		else
			redirect('home');
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
				
        $data['favproduct'] = $favproduct;
        $data = array_merge($data, $this->get_elements());
		$data['is_logged'] = 0;	
			$data['loggedin_user']	=	'';
			if ($this->session->userdata('gen_user')) {
				$current_user   = $this->session->userdata('gen_user');
				$data['loggedin_user']= $current_user['user_id'];
				$data['is_logged'] = 1;
			}
			
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
		$data['loggedin_user']	=	'';
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
            $data['is_logged'] = 1;
        }
		
        $data['favproduct'] 	= $favproduct;                
        $data["html"] 			= $this->load->view('home/more_favorite',$data,TRUE);
        $data["val"] 			= $hide;
		$data["total_product"] 	= $total_product;
        echo json_encode($data);
		exit();
    }
	
	//load more data in Grid View Category Page
    public function load_more_category($cat_id = null, $subcat_id = null) {		
		if($subcat_id==0)
			$subcat_id=NULL;
		// getting the banners for the category page.	  
        $data['between_banners'] = $this->catpage_banner_between($cat_id, $subcat_id);          

		$total_product = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);	
        $filter_val = $this->input->post("value");

        $start = 12 * $filter_val;
        $end = $start + 12;
        $hide = "false";
        if ($end >= $total_product) {
            $hide = "true";
        }
		$product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, null,12,$start);		
        // checking if the category is vehicle or real estate
        if ($cat_id == 7) 			
            $product = $this->dbcommon->get_vehicle_products($cat_id, $subcat_id, null,12,$start);			        
        if ($cat_id == 8) 
            $product = $this->dbcommon->get_real_estate_products($cat_id, $subcat_id, null,12,$start);		
		
        $data['product'] 		= $product;
        $data['is_logged']  	= 0;	
		$data['loggedin_user']	= '';
		
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        $arr = array();

        $arr["html"] = $this->load->view('home/more_category', $data, TRUE);
        $arr["val"] = $hide;
        echo json_encode($arr);
        exit();
    }

    public function load_more_category_listing($cat_id = null, $subcat_id = null) {
		if($subcat_id==0)
			$subcat_id=NULL;
        $data['between_banners'] = $this->catpage_banner_between($cat_id, $subcat_id);  
        $total_product = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);	
		
        $filter_val    = $this->input->post("value");
        $start 		   = 12 * $filter_val;
        $end 		   = $start + 12;
        $hide 		   = "false";
        if ($end >= $total_product) {
            $hide 	= "true";
        }

        $total_product = $this->dbcommon->get_products_by_cat_num($cat_id, $subcat_id);	
		
        $product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, null,12,$start);		
        // checking if the category is vehicle or real estate
        if ($cat_id == 7) 			
            $product = $this->dbcommon->get_vehicle_products($cat_id, $subcat_id, null,12,$start);			        
        if ($cat_id == 8) 
            $product = $this->dbcommon->get_real_estate_products($cat_id, $subcat_id, null,12,$start);		
		
        $data['product'] = $product;

        //Category name
        $where = " category_id = $cat_id";
        $category = $this->dbcommon->filter('category', $where);
        $data['category_name'] = $category[0]['catagory_name'];
        $data['category_id'] = $cat_id;
        $data['is_logged'] 		= 	0;	
		$data['loggedin_user']	=	'';
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
            $data['is_logged'] = 1;
        }
        $arr = array();

        $arr["html"] = $this->load->view('home/more_category_listing', $data, TRUE);
        $arr["val"] = $hide;
        echo json_encode($arr);
        exit();
    }

    public function numeric_value($str) {
        return preg_match('/^[0-9,]+$/', $str);
    }

	public function mark_sold() {
        $current_user = $this->session->userdata('gen_user');
        if ($current_user)
            $user_id = $current_user['user_id'];
        
        $val 		= $this->input->post("value");
        $product_id = $this->input->post("product_id");
        $query 		= " select product_is_sold from product where product_id = $product_id and product_is_sold=0";
        $product 	= $this->dbcommon->get_distinct($query);
        $sold 		= $product[0]["product_is_sold"];
        

        $data = array(
            'product_is_sold' => $sold,
        );
        $array = array('product_id' => $product_id);
        $result = $this->dbcommon->update('product', $array, $data);

        if ($result) {
            echo "Success";
        } else {
            echo "failure";
        }
    }
	
    public function item_details($pro_id = null) {
	//'NeedReview','Approve','Unapprove','Inappropriate'
			$current_user = $this->session->userdata('gen_user');
			
			if ($current_user) {
				$owner_email		=	$current_user['email_id'];
				$data['owner_email']=	$owner_email;
				$nick_name			=	$current_user['nick_name'];
				$data['nick_name']	=	$nick_name;
				$user_id 			= 	$current_user['user_id'];
				$data['user_id']	=	$user_id;
				//$in	=	array('product_id'=>$pro_id,'user_id'=>$current_user['user_id']);
				//$this->dbcommon->insert('view_product',$in);
				
			}
			else
			{
				$data['owner_email']=	'';
				$data['nick_name']	=	'';		
				$data['user_id']	=	0;
			}
					
			$product = $this->dbcommon->get_product($pro_id);
			//print_r($product);
			if(sizeof($product)>0)
			{		
				$feature_banners = $this->dbcommon->getBanner('sidebar',"'all_page','content_page'",null,null);		
				
				if(isset($feature_banners[0]['ban_id']) && $feature_banners[0]['ban_id']!='')
				{		
					$mycnt	=	$feature_banners[0]['impression_count']+1;
					$array1	=	array('ban_id'=>$feature_banners[0]['ban_id']);
					$data1	=	array('impression_count'=>$mycnt);
					$this->dbcommon->update('custom_banner', $array1, $data1);
				}
				$data['feature_banners'] = $feature_banners;
						
				$que	 =	' where user_id='.$product->product_posted_by;
				$user_email	=	$this->dbcommon->getrowdetails('user',$que);			
				
				$que	 	=	' where user_id='.$product->product_posted_by.' and user_id='.$data['user_id'];
				$user_data	=	$this->dbcommon->getrowdetails('user',$que);			
				if(sizeof($user_data)>0)
					$data['user_status']	=	'yes';
				else
					$data['user_status']	=	'no';
				
				if(isset($current_user['user_id']))	 {
				$sql	=	" where user_id=".$current_user['user_id'];		
				$chk_usr =	$this->dbcommon->getrowdetails('user',$sql);
				if(sizeof($chk_usr)>0 && isset($chk_usr->nick_name) && $chk_usr->nick_name!='')
					$data['nick_name']	=	$chk_usr->nick_name;
				elseif(sizeof($chk_usr)>0 && isset($chk_usr->username) && $chk_usr->username!='')
					$data['nick_name']	=	$chk_usr->username;
				else
					$data['nick_name']	=	''; 
				}
				else	
					$data['nick_name']	=	''; 
				if (isset($_POST['reply_submit'])) {
					
					//$query		=	' where user_id ='.(int)$product->product_posted_by;
					$product_owner	=	$product->product_posted_by;			            
					$productId 		= 	$_POST['productId'];			
					//$productCode 	= $_POST['productCode'];
					$productName 	= $_POST['productName'];
					$email 			= $_POST['sender_email'];
					$name 			= $_POST['sender_name'];
					$message		=	$_POST['message'];
					$in_array		=	array(
									'product_id'=>$productId,
									'sender_id'=>$user_id,
									'receiver_id'=>$product_owner,
									'message'=>$message
									);
					$this->dbcommon->insert('buyer_seller_conversation',$in_array);
					//$subject 		= $_POST['subject'];
					$parser_data['site_url']  	= site_url();
					$parser_data['product']   	= $productName;			
					//$parser_data['email']     = $_POST['email_id'];
					$parser_data['redirect_link']= site_url().'login/index';
					$parser_data['sender']		= $data['nick_name'];						
					{
					 $new_data = "
						<style>
							/*<![CDATA[*/
							#outlook a {padding:0;} 
							body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
							.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
							.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
							#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
							img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
							a img {border:none;}
							.image_fix {display:block;}
							Bring inline: Yes.
							p {margin: 1em 0;}
							h1, h2, h3, h4, h5, h6 {color: black !important;}
							h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
							h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
								color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
							}
							h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
								color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
							}
							table td {border-collapse: collapse;}
							table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
							a {color: orange;}
							a:link { color: orange; }
							a:visited { color: blue; }
							a:hover { color: green; }
								/*]]>*/
							</style>
							<table align='center' bgcolor='#f4f7f9' border='0' cellpadding='0' cellspacing='0' id='backgroundTable' style='background: #f4f7f9;' width='100%'>
							<tr>
								<td align='center'>
								<center>
									<table border='0' cellpadding='50' cellspacing='0' style='margin-left: auto;margin-right: auto;width:600px;text-align:center;' width='600'>
									<tr>
										<td align='center' valign='top'>
										<!--<img height='75' src='logo' style='outline:none; text-decoration:none;border:none,display:block;' width='100' />-->
										" . $this->config->item('site_name') . " 
										</td>
									</tr>
									</table>
								</center>
								</td>
							</tr>
							<tr>
								<td align='center'>
								<center>
									<table border='0' cellpadding='30' cellspacing='0' style='margin-left: auto;margin-right: auto;width:600px;text-align:center;' width='600'>
									<tr>
										<td align='left' style='background: #ffffff; border: 1px solid #dce1e5;' valign='top' width=''>
										<table border='0' cellpadding='0' cellspacing='0' width='100%'>
											<tr>
												<td valign='top' align='center'><br>
													<h1 class='logo'><a style='text-decoration:none' href='{site_url}'><font color='#ed1b33'>Doukani</font></a></h1>
												</td>
											</tr>
											<tr>
											<td align='center' valign='top'>
												<h4 ><font color='#00acec' >Reply for your Ad : {product} from {sender} </font></h4>                                        
											</td>
											<tr>
												<td valign='top' align='center' style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5;'>
													<p style='margin: 1em 0;'>
														Please check your Inbox
													</p>
												</td>
											</tr>
											<tr>
											<td align='center' bgcolor='#ed1b33' valign='top'>
												<h3><a href='{redirect_link}' style='color: #ffffff !important'>CLICK HERE TO LOGIN</a></h3>
											</td>
											</tr>
											<tr>
											<td align='center' valign='top'>
												<p style='margin: 1em 0;'>                                      
												<br>
												   If above link does not work please copy and paste the URL link (below) into your browser
											address bar to get to the Page to login.
											<br/>                                    
												</p>
											</td>
											</tr>
											<tr>
												<td><br></td>
											</tr>
											<tr>
												<td align='center'> <font size='1'> &copy; 2016 <b>doukani.com.</b> All rights reserved.</font></td>
											</tr>
										</table>
										</td>
									</tr>
									</table>
								</center>
								</td>
							</tr>
							</table>";
					}	
					$new_data = $this->parser->parse_string($new_data, $parser_data, '1');
					
					if (send_mail($user_email->email_id, 'Reply for your product: '.$productName, $new_data)){				
						$this->session->set_flashdata('msg33','Your reply sent successfully');
						redirect('home/item_details/'.$pro_id);
					}
					else {
						$data['msg'] = 'Your can not reply to yourself.';
						$data['msg_class'] = 'alert-info';
					}
					/*
					$message =
							'<b>Message From:</b> '.$name.
							'<br/><b>Email:</b> '.$email.
							'<br/><b>Subject:</b> '.'Buyer send reply for  your Product:'.$productName .
							'<br/><b>Reply for Product:</b> Name-' . $productName.'<br/><br/><b>Message:</b><br/>'.nl2br($_POST['message']);

					$configs = mail_config();

					$this->load->library('email', $configs);
					$this->email->set_newline("\r\n");
					$this->email->from($email, $name);
					//$this->email->reply_to('oscar@treatmo.com', 'treatmo');
					$this->email->to($user_email->email_id);
					//$this->email->to('nav.narola@narolainfotech.com');
					//$this->email->to('adonis@adonis.name');

					$this->email->subject('Reply For A Doukani Product');
					$this->email->message($message);
					$this->email->send(); */
			}

				if (isset($_POST['report_submit'])) {			
					$current_user = $this->session->userdata('gen_user');
					$productCode = $_POST['productCode'];
					$productId = $_POST['productId'];
					$productName = $_POST['productName'];
					$report = $_POST['report'];
					$message = $message =
							'<b>Report From:</b> ' . $current_user['username'] .
							'<br/><b>Email:</b> ' . $current_user['email_id'] .
							'<br/><b>Report for Product:</b> Name-' . $productName . ' | Id-' . $productId . ' | Code-' . $productCode . '<br/>' .
							'<br/><b>Comments:</b><br/>' .
							nl2br($_POST['comments']);
					$configs = mail_config();

					$this->load->library('email', $configs);
					$this->email->set_newline("\r\n");
					$this->email->from($current_user['email_id'], $current_user['username']);
		//                $this->email->reply_to('oscar@treatmo.com', 'treatmo');
					//$this->email->to('nav.narola@narolainfotech.com');
					$this->email->to('adonis@adonis.name');
					$this->email->subject('Report For A Doukani Product');
					$this->email->message($message);
					$this->email->send();

					$data['msg'] = 'Your report has been sent successfully';
					$data['msg_class'] = 'alert-info';
				}

				if (isset($_POST['inq_sup_submit'])) {		
					$current_user 	= $this->session->userdata('gen_user');
					$productId 		= $_POST['productId'];

					$inquiry_subject = $_POST['inquiry_subject'];
					$inquiry_type 	 = $_POST['inquiry_type'];
					$inquiry_content = $_POST['inquiry_content'];
					$inquiry_code	 = $this->dbcommon->generateRandomString();
					$inquiry	=	array('inquiry_subject'=>$inquiry_subject,
										  'inquiry_type'=>$inquiry_type,
										  'inquiry_content'=>$inquiry_content,
										  'inquiry_posted_on'=>date('y-m-d H:i:s', time()),
										  'product_id'=>$productId,
										  'inquiry_status'=>'open',
										  'inquiry_sender'=>$current_user['user_id'],
										  'inquiry_code'=>$inquiry_code
										 );
					$this->dbcommon->insert('inquiry',$inquiry);

					$data['msg'] = 'Your Message sent successfully';
					$data['msg_class'] = 'alert-info';
				}
				
				
				$current_views_count = $product->product_total_views;
				$updated_views_count = $current_views_count + 1;

				$views_count = array(
					'product_total_views' => $updated_views_count
				);

				$array = array('product_id' => $pro_id);
				$this->dbcommon->update('product', $array, $views_count);

				$product 			= $this->dbcommon->get_product($pro_id);			
				$product_video		= $product->video_name;
				$data["product_video"] = $product_video;
				
				$product_videoimg		= $product->video_image_name;
				$data["product_videoimg"] = $product_videoimg;
				
				$youtube_link		= $product->youtube_link;
				$data["youtube_link"] = $youtube_link;
				//print_r($youtube_link);
				$product_images = array();
				//if ($product->product_image != '')
					//array_push($product_images, $product->product_image);
				$cover_img	= $product->product_image;
				
				$data['cover_img']	=	$cover_img;
				$cat_id 	= $product->category_id;
				$subcat_id 	= $product->sub_category_id;
				$rand		= 'rand';
				$related_product = $this->dbcommon->get_product_by_categories($cat_id, $subcat_id, $pro_id, 12,'',$rand);
				
				$images = $this->dbcommon->get_product_images($pro_id);
				//$product_images = array_merge($product_images, $images);
				$data['product_images'] = $images;
				
				$share_url = '';$i=0;
				 if(isset($cover_img) && $cover_img!='') {
					 $share_url = base_url() . 'assets/upload/product/original/' . $cover_img;
				 }			
				else {
						if(sizeof($product_images) > 0) {
							foreach ($product_images as $image) {
								$filename = document_root . product .'original/'. $image;
								
								if (file_exists($filename)) {
								   $share_url = base_url() . 'assets/upload/product/original/' . $image;
									$i++;
									break;
								}
								if($i==0){
									$share_url = base_url() .'assets/upload/No_Image.png';
								}            
							}
						}
						else {
							$share_url = base_url() .'assets/upload/No_Image.png';
						}
			   }
				//$share_url = base_url() .'assets/upload/No_Image.png';
				$data['share_url'] = $share_url;
				
				$data["related_product"] = $related_product;

				$array = array(
					'product_id' => "'".$pro_id."'"
				);
				//$vehicle_features = $this->dbcommon->getdetailsinfo('product_vehicles_extras', $array);
				$vehicle_features	=	$this->dbcommon->product_vehicles_extras($pro_id);		
				//echo '<pre>';		
				if (!empty($vehicle_features))
					$product->vehicle_features = $vehicle_features;

				$realestate_features = $this->dbcommon->getdetailsinfo('product_realestate_extras', $array);
				if (!empty($realestate_features))
					$product->realestate_features = $realestate_features;

				$data["product"] = $product;		
				//print_r($product);
				$data["selected"] = ($product->state_name) ? $product->state_name : "Dubai";
				$data["product_is_sold"] = $product->product_is_sold;
				$res = strtotime($product->admin_modified_at);
				
				$data["posted_on"] = rtrim($this->dbcommon->dateDiff(date('Y-m-d H:i:s', $res), date('Y-m-d H:i:s')), ', ') . ' back';

				$data = array_merge($data, $this->get_elements());

				$breadcrumb = array(
					'Home' => base_url(),
					$product->catagory_name => base_url() . 'home/category/' . $product->category_id,
					$product->sub_category_name => base_url() . 'home/category/' . $product->category_id . '/' . $product->sub_category_id,
					$product->product_name => '#'
				);

				$data['breadcrumbs'] = $breadcrumb;
				$data['page_title'] = $product->product_name;
				$data['is_logged'] = 0;
				$data['user_agree'] = 0;
				
				$data['loggedin_user']	=	'';
				if ($this->session->userdata('gen_user')) {
					$current_user   = $this->session->userdata('gen_user');
					$data['loggedin_user']= $current_user['user_id'];
					$data['is_logged'] = 1;
				}

				$this->load->view('home/item_details', $data);
				}
				else
				{
					redirect('home');
				}
    }

    public function change_image_size() {
        $target_dir = document_root . product . "original/";

        $files = array_values(array_filter(scandir($target_dir), function($file) {
                            return !is_dir($file);
                        }));
        // echo sizeof($files);
        foreach ($files as $file) {

            $filename = $target_dir . $file;
            

            ob_start();
            imagepng($filename);
            $contents = ob_get_contents();
            ob_end_clean();

            $base_encoded = base64_encode($contents);
            exit;
            // $percent = 0.5;
            // Content type
            header('Content-Type: image/jpeg');

            // Get new sizes
            list($width, $height) = getimagesize($filename);
            // $newwidth = $width * $percent;
            // $newheight = $height * $percent;
            // Load
            $thumb = imagecreatetruecolor(60, 40);
            // $medium = imagecreatetruecolor(202, 160);
            $source = imagecreatefromjpeg($filename);

            // Resize
            imagecopyresized($thumb, $source, 0, 0, 0, 0, 60, 40, $width, $height);
            // imagecopyresized($medium, $source, 0, 0, 0, 0, 202, 160, $width, $height);

            $small_target_dir = document_root . product . "small1/";
            // $medium_target_dir = document_root . product ."medium1/";
            // Output
            imagejpeg($thumb, $small_target_dir . $file);
            // imagejpeg($medium, $medium_target_dir . $file);
        }
    }

  /*  public function seller($user_id) {
        $data = array();
        $data = array_merge($data, $this->get_elements());
        $array = array('user_id' => $user_id);
        $user = $this->dbcommon->get_row('user', $array);
        $data['user'] = $user;
        $data['page_title'] = 'Seller Details';
        $data['is_logged'] = 0;
        if ($this->session->userdata('gen_user')) {
            $data['is_logged'] = 1;
        }

        $products = $this->dbcommon->get_my_listing($user_id);

        $data['products'] = $products;

        $this->load->view('home/seller', $data);
    }
*/
    

    public function contact_us(){
        $data = array();
        $data = array_merge($data, $this->get_elements());
		$data['is_logged'] = 0;	
		$data['loggedin_user']	=	'';
		if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
			$data['is_logged'] = 1;
		}
			
		$array = array('page_id' => 23);
		//$data['page'] = $this->dbcommon->get_row('pages_cms', $array);
		$page = $this->dbcommon->get_row('pages_cms', $array);
		$data['page'] = $page;
		
        $data['page_title'] = 'Contact Us';
		$que	=	' page_id=22';
		$data['contact_us_desc']	=	$this->dbcommon->filter('pages_cms',$que);
		$breadcrumb = array(
            'Home' => base_url(),
             $page->page_title=> '#',
        );       

        $data['breadcrumbs'] = $breadcrumb;
        if (isset($_POST['submit'])):

            $email = $_POST['email'];
            $name = $_POST['name'];
            $subject = $_POST['title'];

            $message =
                    '<b>Message From:</b> ' . $name .
                    '<br/><b>Email:</b> ' . $email .
                    '<br/><b>Subject:</b> ' . $subject .
                    '<br/><b>Message:</b><br/>' .
                    nl2br($_POST['desc']);

            $configs = mail_config();

            $this->load->library('email', $configs);
            $this->email->set_newline("\r\n");
            $this->email->from($email, $name);
//                $this->email->reply_to('oscar@treatmo.com', 'treatmo');
            $this->email->to('nav.narola@narolainfotech.com');
            // $this->email->to('adonis@adonis.name');

            $this->email->subject('Message');
            $this->email->message($message);

            if ($this->email->send()):
                $save_data = array(
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message
                );
                $result = $this->dbcommon->insert('contact_us', $save_data);          
                $this->session->set_flashdata(array('msg' => 'Message successfully sent', 'class' => 'alert-info'));
                redirect('home/contact_us');
                exit;
            else:
                $this->session->set_flashdata(array('msg' => 'Message was not sent', 'class' => 'alert-info'));
                redirect('home/contact_us');
                exit;
            endif;           
        endif;
            $this->load->view('home/contact_us', $data);
        
        // $this->load->view('home/contact_us',$data); 
    }

    public function get_featured_ads(){
        $data = array();
        $data = array_merge($data, $this->get_elements());
		
		$data['between_banners'] = $this->dbcommon->getBanner('between',"'content_page','all_page'",null,null);				   
		
		$data['page_title'] = 'Featured Ads';
		
		$total_product = $this->dbcommon->get_featured_ads_count();
		//echo $this->db->last_query();
		$data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
        }
        $result = $this->dbcommon->get_featured_ads(0,12);
		
        $data['products'] = $result; 

        $data['is_logged'] 		= 	0;	
		$data['loggedin_user']	=	'';
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
            $data['is_logged'] = 1;
        }

        $this->load->view('home/featured_ads', $data);
    }

	public function get_morefeatured_ads(){
        $more_data = array();
		$more_data['between_banners'] = $this->dbcommon->getBanner('between',"'content_page','all_page'",null,null);				
	
        $filter_val = $this->input->post("value");
        
        $more_data['is_logged'] = 0;
		
		$total_product = $this->dbcommon->get_featured_ads_count();
        $start = 12 * $filter_val;
        $end = $start + 12;
        $hide = "false";
        if ($end >= $total_product) {
            $hide = "true";
        }
		
		$result = $this->dbcommon->get_featured_ads($start,12);
		//echo $this->db->last_query();
        $more_data['products'] = $result; 
		$arr = array();
        $more_data['is_logged'] 	= 	0;	
		$more_data['loggedin_user']	=	'';
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$more_data['loggedin_user']= $current_user['user_id'];
            $more_data['is_logged'] = 1;
        }

        $arr["html"] = $this->load->view('home/more_featured_ads', $more_data, TRUE);
        $arr["val"] = $hide;
        echo json_encode($arr);
    }
	
	public function update_click_count() {
		$ban_id	=	$_POST['ban_id'];
		$query	=	$this->db->query('select ban_id,click_count from custom_banner where ban_id='.$ban_id)->row_array();
	
			$mycnt	=	$query['click_count']+1;
			$array	=	array('ban_id'=>$ban_id);
			$data	=	array('click_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array, $data);
				
	}
	
	public function subscription() {
		$this->load->library('Mcapi');  
      if(isset($_POST)):
		$retval = $this->mcapi->lists();  
			/*	  
		if ($this->mcapi->errorCode){  					  
			// echo "Unable to load lists()!";  
			// echo "\n\tCode=".$this->mcapi->errorCode;  
			// echo "\n\tMsg=".$this->mcapi->errorMessage."\n";  
					  
		}else{  					  
			// echo "Lists that matched:".$retval['total']."\n";  
			// echo "Lists returned:".sizeof($retval['data'])."\n";  					  
			// foreach ($retval['data'] as $list){  
				// echo "Id = ".$list['id']." - ".$list['name']."\n";  
				// echo "Web_id = ".$list['web_id']."\n";  
				// echo "\tSub = ".$list['stats']['member_count'];  
				// echo "\tUnsub=".$list['stats']['unsubscribe_count'];  
				// echo "\tCleaned=".$list['stats']['cleaned_count']."\n";  
			// }  					  
		}  */
		
	
		$listID 	  = "f18853dfa3"; // obtained by calling lists();  
		$emailAddress = $_POST['email'];  
		$retval       = $this->mcapi->listSubscribe($listID, $emailAddress);  
				  
		if ($this->mcapi->errorCode){  			
			$this->session->set_flashdata('msg','Unable to subscribe');
			// $data['msg']	=	'Unable to subscribe your Email';
			// $this->load->view('home/index', $data);
			redirect('home/index');	
			//echo "Unable to subscribe email using listSubscribe()!";  
			//echo "\n\tCode=".$this->mcapi->errorCode;  
			//echo "\n\tMsg=".$this->mcapi->errorMessage."\n";  					  
		}else{  					  
			$this->session->set_flashdata('msg', $emailAddress." subscribed successfully");
			//$data['msg']	=	 $emailAddress." subscribed successfully";
			redirect('home/index');	
			//$this->load->view('home/index', $data);			
		} 
		endif;
	}	
	
	public function show_emirates() {
        //$value = 4;
		//if(isset($_POST['value']) && $_POST['value']!='') {
			$query 					= "country_id= " . $_POST['value']. ' order by sort_order';        				
			$main_data['state'] 	= $this->dbcommon->filter('state', $query);
			$main_data['sel_city'] 	= $_POST['sel_city'];
			
			echo $this->load->view('home/show_state', $main_data, TRUE);
			exit;
		//}
    }
	
	public function show_emirates1() {
        //$value = 4;
		$query	=	'';
		if(isset($_POST['value']) && $_POST['value']!='')
			$query 					= "country_id= " . $_POST['value'];        				
		else
			$query 					= "country_id= 0" ;        			
			$query	.=	' order by sort_order';	
		$main_data['state'] 	= $this->dbcommon->filter('state', $query);
		$main_data['sel_city'] 	= $_POST['sel_city'];
		echo $this->load->view('home/show_state', $main_data, TRUE);
        exit;
    }
	
	// //get data while posting ad or update post
	// public function show_emirates_postadd() {
        // //$value = 4;
		// if(isset($_POST['value']) && $_POST['value']!='') 
			// $val	=	$_POST['value'];
		// else
			// $val	=	0;
        // $query 				= "country_id= " . $val;        		
		// $main_data['state'] = $this->dbcommon->filter('state', $query);
		// echo $this->db->last_query();
		// $main_data['sel_city'] 	= $_POST['sel_city'];
		// echo $this->load->view('home/show_state_postad', $main_data, TRUE);
        // exit;
    // }
	
	//get data while posting ad or update post
	public function show_emirates_postadd() {
        //$value = 4;
		if(isset($_POST['value']) && $_POST['value']!='') 
			$val	=	$_POST['value'];
		else
			$val	=	0;			
        $query 					= "country_id= " . $val;        		
		$main_data['state'] 	= $this->dbcommon->filter('state', $query);		
		echo $this->load->view('home/show_state_postad', $main_data, TRUE);
        exit;
    }
	
	
	//for leftnav
	public function show_emirates_left() {
        //$value = 4;
        $query 					= "country_id= " . $_POST['value'];        		
		$main_data['state'] 	= $this->dbcommon->filter('state', $query);
		$main_data['sel_city'] 	= $_POST['sel_city'];
		echo $this->load->view('home/show_state', $main_data, TRUE);
        exit;
    }
	
	public function show_sub_category(){
            $filter_val = $this->input->post("value");
            $query = "category_id= '" . $filter_val . "'";
            $main_data['subcat'] = $this->dbcommon->filter('sub_category', $query);
            
            echo $this->load->view('user/sub_cat', $main_data, TRUE);
            exit();
            
    }
	
	public function show_model() {
        $value = $this->input->post("value");
		if($value=='')
			$value	=	0;	
			
        $query = "brand_id= " . $value;
        $main_data['model'] = $this->dbcommon->filter('model', $query);

        echo $this->load->view('user/show_model', $main_data, TRUE);
        exit;
    }	
	
	public function categories() {
		
		$query	=	'';
		$data	=	array();
		$data 	= 	array_merge($data, $this->get_elements());	
		$data['category'] 	= $this->dbcommon->select_orderby('category', 'cat_order', 'asc');
		$data['sub_category'] 	= $this->dbcommon->select_orderby('sub_category', 'sub_cat_order', 'asc');
		
        $feature_banners 		 = $this->dbcommon->getBanner('sidebar',"'home_page','all_page'",null,null);        		
        $data['feature_banners'] = $feature_banners;
		
		if(isset($feature_banners[0]['ban_id']) && $feature_banners[0]['ban_id']!='')
		{		
			$mycnt	=	$feature_banners[0]['impression_count']+1;
			$array1	=	array('ban_id'=>$feature_banners[0]['ban_id']);
			$data1	=	array('impression_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array1, $data1);
		}  
		
		$product = $this->dbcommon->get_products();
        $data['latest_product'] = $product;
		
		// functionality for loading more products
        $total_product = $this->dbcommon->get_products_count();

        $data['hide'] = "false";
        if ($total_product <= 12) {
            $data['hide'] = "true";
       }	
        // merging the data from my_controller
        $data = array_merge($data, $this->get_elements());
        
        $data['page_title'] = 'Doukani';
        
        $data['is_logged'] 		= 	0;	
		$data['loggedin_user']	=	'';
        if ($this->session->userdata('gen_user')) {
			$current_user   = $this->session->userdata('gen_user');
			$data['loggedin_user']= $current_user['user_id'];
            $data['is_logged'] = 1;
        }
		
		echo $this->load->view('home/category_list', $data, TRUE);
	}
	
	public function request() {
		$data	=	array();
		$data   = array_merge($data, $this->get_elements());
		$data['page_title']	=	'Help Center';
				
		$current_user   	= 	$this->session->userdata('gen_user');
		if($current_user!='') {
		$us_que				=	' where user_id='.$current_user['user_id'];
		$user_data			=	$this->dbcommon->getrowdetails('user',$us_que);				
		}
		else {
				$user_data	=	array();
		}
		$data['user_data']	=	$user_data;
		$query				=	' parent_page_id=5';
		$data['page_links']	=	$this->dbcommon->filter('pages_cms', $query);
		
		$query1				=	' where page_id=5';
		$page_heading		=	$this->dbcommon->getrowdetails('pages_cms',$query1);
		$data['page_heading']=$page_heading;
		
		if(isset($_POST['submit'])) {
			
			$file_name	=	'';			
			if(isset($_FILES['file_name']) && $_FILES['file_name'])	{
				$ext 		 = explode(".", $_FILES['file_name']['name']);
				$file_name	 = time() ."." . end($ext);				
				$target_file = document_root.'assets/upload/request/'.$file_name;
				
				if (move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_file)) {											
					$file_name	=	$file_name;					
				}
			}
			$data = array(
                    'question' => $_POST['question'],
                    'sub_question' => $_POST['sub_question'],                    
                    'description' => $_POST['description'],                    
                    'name' => $_POST['name'],                    
                    'email_id' => $_POST['email_id'],                    
                    'mobile_number' => $_POST['mobile_number'],                    
                    'ad_link' => $_POST['ad_link'],                    
                    'file_name' => $file_name
					);
			$result       = $this->dbcommon->insert('inquiry_support_request', $data);	
						
			if(isset($result))	{				
				
				$parser_data['site_url']  		= site_url();
				
				$subject	=	'';
				if(($_POST['question']) ) {
					if($_POST['question'] =="1") 
						$subject	=	'Suggestions/Complains';
					elseif($_POST['question'] =="2")	
						$subject	=	'Registration/Account';
					elseif($_POST['question'] =="3")	
						$subject	=	'Problem with Ads';
					elseif($_POST['question'] =="4")	
						$subject	=	'Technical Issues';	
					elseif($_POST['question'] =="5")	
						$subject	=	'Fraud';
					else			
						$subject	=	'-';
				}
				
				if(($_POST['sub_question']) ) {
					if($_POST['sub_question'] =="1") 
						$sub_subject	=	'I am not able to find my ad';
					elseif($_POST['sub_question'] =="2")	
						$sub_subject	=	'My Ad was deleted';
					elseif($_POST['sub_question'] =="3")	
						$sub_subject	=	'How to Edit an Ad?';
					elseif($_POST['sub_question'] =="4")	
						$sub_subject	=	'How to Delete an Ad?';	
					elseif($_POST['sub_question'] =="5")	
						$sub_subject	=	'How to Post an Ad?';
					elseif($_POST['sub_question'] =="6")	
						$sub_subject	=	'I have problems with my account';
					elseif($_POST['sub_question'] =="7")	
						$sub_subject	=	'How to Register';
					elseif($_POST['sub_question'] =="8")	
						$sub_subject	=	'Forgot my Password';
					elseif($_POST['sub_question'] =="9")	
						$sub_subject	=	'Others';
					elseif($_POST['sub_question'] =="10")	
						$sub_subject	=	'Suggestions';
					elseif($_POST['sub_question'] =="11")	
						$sub_subject	=	'Complaints';
					elseif($_POST['sub_question'] =="12")	
						$sub_subject	=	'I want to report a fraud';						
					elseif($_POST['sub_question'] =="13")	
						$sub_subject	=	'I am a victim of a fraud';						
					elseif($_POST['sub_question'] =="14")	
						$sub_subject	=	'I want to report identity theft';						
					elseif($_POST['sub_question'] =="15")	
						$sub_subject	=	'Others';						
					else			
						$sub_subject	=	'-';
				}
				
				
				$parser_data['title'] 			= $subject;	
				$parser_data['sub_title'] 		= $sub_subject;	
				$parser_data['description'] 	= $_POST['description'];	
				$parser_data['sender_name'] 	= $_POST['name'];	
				$parser_data['email_id'] 		= $_POST['email_id'];	
				$parser_data['mobile_no'] 		= $_POST['mobile_number'];	
				$parser_data['ad_link'] 		= $_POST['ad_link'];	
				$parser_data['attachment_link'] = site_url().'home/display_attach/'.base64_encode($file_name);	
				$parser_data['attachment_name'] = base64_encode($file_name);	

				{
					$new_data = "<style>
					/*<![CDATA[*/
						#outlook a {padding:0;} 
						body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
						.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
						.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
						#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
						img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
						a img {border:none;}
						.image_fix {display:block;}
						Bring inline: Yes.
						p {margin: 1em 0;}
						h1, h2, h3, h4, h5, h6 {color: black !important;}
						h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
						h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
							color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
						}
						h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
							color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
						}
						table td {border-collapse: collapse;}
						table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
						a {color: orange;}
						a:link { color: orange; }
						a:visited { color: blue; }
						a:hover { color: green; }
							/*]]>*/
						</style>
						
						<table align='center' bgcolor='#f4f7f9' border='0' cellpadding='0' cellspacing='0' id='backgroundTable' style='background: #f4f7f9;' width='100%'>
						<tr>
							<td align='center'>
							<center>
								<table border='0' cellpadding='50' cellspacing='0' style='margin-left: auto;margin-right: auto;width:600px;text-align:center;' width='600'>
								<tr>
									<td align='center' valign='top'>
									<!--<img height='75' src='logo' style='outline:none; text-decoration:none;border:none,display:block;' width='100' />-->
									" . $this->config->item('site_name') . " 
									</td>
								</tr>
								</table>
							</center>
							</td>
						</tr>
						<tr>
							<td align='center'>
							<center>
								<table border='0' cellpadding='30' cellspacing='0' style='margin-left: auto;margin-right: auto;width:600px;text-align:center;' width='600'>
								<tr>
									<td align='left' style='background: #ffffff; border: 1px solid #dce1e5;' valign='top' width=''>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<tr>
											<td valign='top' align='center' colspan='2'>
												<h1 class='logo'><a style='text-decoration:none' href='{site_url}'><font color='#ed1b33'>Doukani</font></a></h1>
											</td>
										</tr>									
										<tr>
											<td></td>
										</tr>
										<tr style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5;'>
											<td valign='top' align='center' colspan='2'>
												<h4><strong>Request For</strong></h4>
											</td>
										</tr>
										<tr>
											<td valign='top' style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5; padding-left:15px;'>
												<p style='margin: 1em 0;'>
													<strong>Title:</strong>
													{title}
												</p>
												<p style='margin: 1em 0;'>
													<strong>Sub-Title:</strong>
													{sub_title}
												</p>												
												<p style='margin: 1em 0;'>
													<strong>Description:</strong>
													{description}
												</p>
											</td>
										</tr>
										<tr style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5;'>
											<td valign='top' align='center' colspan='2'>
												<h4><strong>Sender Details</strong></h4>
											</td>
										</tr>
										<tr>
											<td valign='top' style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5; padding-left:15px;'>
												<p style='margin: 1em 0;'>
													<strong>Name:</strong>
													{sender_name}
												</p>
												<p style='margin: 1em 0;'>
													<strong>E-mail:</strong>
													<a style='color: #000000 !important;' href='{email_id}'>{email_id}</a>
												</p>
												<p style='margin: 1em 0;'>
													<strong>Mobile Number:</strong>
													{mobile_no}
												</p>
											</td>
										</tr>
										<tr>
										<td valign='top' style='border-top: 1px solid #dce1e5;border-bottom: 1px solid #dce1e5; padding-left:15px;'>
											<p style='margin: 1em 0;'>
												<strong>Ad Link</strong>
												<a style='color: #000000 !important;' href='{ad_link}'>{ad_link}</a>
											</p>
											<p style='margin: 1em 0;'>
												<strong>Attachment</strong>
												<a style='color: #000000 !important;' href='{attachment_link}'>{attachment_name}</a>
											</p>
										</td>
										</tr>
										<tr>
											<td><br></td>
										</tr>
										<tr>
											<td align='center'> <font size='1'> &copy; 2016 <b>doukani.com.</b> All rights reserved.</font></td>
										</tr>
									</table>
									</td>
								</tr>
								</table>
							</center>
							</td>
						</tr>
						</table>";
				}	
				$new_data = $this->parser->parse_string($new_data, $parser_data, '1');
				//adonis@adonis.name
				if(send_mail('adonis@adonis.name', 'Request for : '.$subject, $new_data))				
					{} 

				$parser_data1['sender_name'] 	= $_POST['name'];	
				//send to client		
				{
				 $new_data1 = "<style>
						/*<![CDATA[*/
						#outlook a {padding:0;} 
						body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
						.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
						.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
						#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
						img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
						a img {border:none;}
						.image_fix {display:block;}
						Bring inline: Yes.
						p {margin: 1em 0;}
						h1, h2, h3, h4, h5, h6 {color: black !important;}
						h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
						h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
							color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
						}
						h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
							color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
						}
						table td {border-collapse: collapse;}
						table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
						a {color: orange;}
						a:link { color: orange; }
						a:visited { color: blue; }
						a:hover { color: green; }
							/*]]>*/
						</style>
						<table align='center' bgcolor='#f4f7f9' border='0' cellpadding='0' cellspacing='0' id='backgroundTable' style='background: #f4f7f9;' width='100%'>
						<tr>
							<td align='center'>
							<center>
								<table border='0' cellpadding='50' cellspacing='0' style='margin-left: auto;margin-right: auto;width:600px;text-align:center;' width='600'>
								<tr>
									<td align='center' valign='top'>
									<!--<img height='75' src='logo' style='outline:none; text-decoration:none;border:none,display:block;' width='100' />-->
									" . $this->config->item('site_name') . " 
									</td>
								</tr>
								</table>
							</center>
							</td>
						</tr>
						<tr>
							<td align='center'>
							<center>
								<table border='0' cellpadding='30' cellspacing='0' style='margin-left: auto;margin-right: auto;width:600px;text-align:center;' width='600'>
								<tr>
									<td align='left' style='background: #ffffff; border: 1px solid #dce1e5;' valign='top' width=''>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<tr>
											<td valign='top' align='center'><br>
												<h1 class='logo'><a style='text-decoration:none' href='{site_url}'><font color='#ed1b33'>Doukani</font></a></h1>
											</td>
										</tr>
										<tr>
										<td align='center' valign='top'>
											<h4 ><font color='#00acec' >Thank You for Your Mail Mr./Ms. {sender_name} </font></h4>                                        
										</td>									
										<tr>
										<td align='center' valign='top'>
											<p>                                      
											<br>
											   The request is being reviewed by our support staff and will be updated to you.
											<br/>                                    
											</p>
										</td>
										</tr>
										<tr>
											<td><br></td>
										</tr>
										<tr>
											<td align='center'> <font size='1'> &copy; 2016 <b>doukani.com.</b> All rights reserved.</font></td>
										</tr>
									</table>
									</td>
								</tr>
								</table>
							</center>
							</td>
						</tr>
						</table>";
				}	
				$new_data1 = $this->parser->parse_string($new_data1, $parser_data1, '1');
				
				if(send_mail($_POST['email_id'], 'Thank you for your request : '.$subject, $new_data1))
					{}
					
					$this->session->set_flashdata('msg_request','Request sent successfully...');					
					
					if(isset($_REQUEST['request_from_app']) && $_REQUEST['request_from_app']=='request') {						
						redirect('home/request_app');
					}
					else
						redirect('home/request');				
			}
		}
		$data['is_logged'] = 0;	
			$data['loggedin_user']	=	'';
			if ($this->session->userdata('gen_user')) {
				$current_user   = $this->session->userdata('gen_user');
				$data['loggedin_user']= $current_user['user_id'];
				$data['is_logged'] = 1;
			}
		
		
		
			$this->load->view('home/request', $data);	
	}	
		
	public function request_app() {
		$data	=	array();
		$data   = array_merge($data, $this->get_elements());
		$data['page_title']	=	'Help Center';
		
		$this->load->view('home/request_app', $data);	
	}	
	
	//display tems and conditions page in app 
	public function terms_conditions_app() {		
		$data	=	array();
		$query1				=	' where page_id=21';
		$page_heading		=	$this->dbcommon->getrowdetails('pages_cms',$query1);
		$data['page_heading']=	$page_heading;
		$data['page_title']	 =	$page_heading->page_title;
				
		$this->load->view('home/terms_and_conditions_app', $data);	
	}
	
	public function  display_attach() {								
		$file	=	$this->uri->segment(3);
		if($file!='') {		
			$decoded = base64_decode($file);			
			$ext 	=	 explode(".",$decoded);		
			
			 if ($decoded!='' && ($ext[1] == "jpg" || $ext[1] == "png" || $ext[1] == "jpeg" || $ext[1] == "gif")) {
				$data			=	array();
				$data['img']	=	$decoded;
				$this->load->view('home/request_image', $data);	
			 }
			 elseif($decoded!='') {		
				$this->load->helper('download');			
				
				$data = file_get_contents(base_url().'assets/upload/request/'.$decoded);
				$name = $decoded;			
				force_download($name, $data);
			}
			else
			{
				echo 'file not found';
				exit;
			}
		}
		else	{
			echo 'file not found';
			exit;
		}			
			//echo base_url().'assets/front/images'.'/'.$file;
			//echo file_exists(base_url().'assets/front/images'.'/'.$file);
			//if($file!='' && file_exists(base_url().'assets/front/images'.'/'.$file)) {
			//http://localhost:81/classified_application/assets/front/images/site_logo1.png		
			//$redirect='http://localhost:81/classified_application/assets/front/images/site_logo1.png';
			//header('Location:'.$redirect);
	}
	
	public function faq() {	
		$data	=	array();
		$data = array_merge($data, $this->get_elements());
        
		$array = array('page_id' => 16);
		$page = $this->dbcommon->get_row('pages_cms', $array);
		$data['page_title'] = $page->page_title;
		
        $query = "  is_delete=0 order by sort_order asc";
        $faq = $this->dbcommon->filter('faq', $query);
		
		$data['faq']	=	$faq;
		$breadcrumb = array(
            'Home' => base_url(),
             $page->page_title=> '#',
        );       
		$data['page'] = $page;
        $data['breadcrumbs'] = $breadcrumb;	
		$data['is_logged'] = 0;	
			$data['loggedin_user']	=	'';
			if ($this->session->userdata('gen_user')) {
				$current_user   = $this->session->userdata('gen_user');
				$data['loggedin_user']= $current_user['user_id'];
				$data['is_logged'] = 1;
			}
			
		$this->load->view('home/faq', $data);		
	}	

	//category grid/listing/ more grid and listing	
	public function catpage_banner_between($cat_id, $subcat_id) {
		
		 if($cat_id=='')	
			 $cat_id	=	null;
		 if($subcat_id=='')	
			 $subcat_id	=	null; 
		$between_banners = $this->dbcommon->getBanner('between',"'content_page','all_page'",$cat_id, $subcat_id);
		// echo $this->db->last_query();
		// print_r($between_banners);
		/*if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='') {		
			$mycnt	=	$between_banners[0]['impression_count']+1;
			$array1	=	array('ban_id'=>$between_banners[0]['ban_id']);
			$data1	=	array('impression_count'=>$mycnt);
			$this->dbcommon->update('custom_banner', $array1, $data1);
		} */	
		return $between_banners;
	}
	
    	
}
?>