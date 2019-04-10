<?php

//

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */
//$route['404_override'] = 'Error404';
//$route['default_controller'] = "landing";
$route['default_controller'] = "home";
$route['stores'] = "stores";
$route['sitemap\.xml'] = "seo/sitemap_xml";
$route['sitemap\.txt'] = "seo/sitemap_txt";
$route['sitemap\.htm'] = "seo/sitemap_html";

$route['admin/(:any)'] = "admin/$1";
$route['upload'] = 'upload';
$route['upload/do_upload'] = 'upload/do_upload';
$route['store-page-content'] = 'stores/index';
$route['thank_you_adpost'] = 'registration/post_thank_you';


require_once( BASEPATH . 'database/DB.php' );
$db = & DB();

$emirate = $this->uri->segment(1);
if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
//    if($this->uri->segment(2)=='allstores')
//        $route[$emirate.'/allstores'] = 'allstores/index';    
//    else
    if ($this->uri->segment(2) == 'store_search')
        $route[$emirate . '/store_search'] = 'allstores/store_search';
    elseif ($this->uri->segment(2) == 'allstores')
        $route[$emirate . '/allstores'] = 'allstores/index';
    else
        $route[$emirate . '/(:any)'] = 'home/index';
}
else {
    $query = $db->get('pages_cms');
    $result = $query->result();

    foreach ($result as $row) {
        $route[$row->slug_url] = 'pages/page/' . $row->page_id;
    }

    $db1 = & DB();

    $req_seg1 = $this->uri->segment(1);
    $req_seg2 = $this->uri->segment(2);
    $db1->where('user_slug', $req_seg1);
    $db1->where('is_delete', 0);
    $db1->where('status', 'active');
    $db1->where('user_role', 'offerUser');
    $query1 = $db1->get('user');
    $result1 = $query1->result();
    if (isset($result1) && !empty($result1) && $req_seg2 != '') {
        $route[$req_seg1 . '/' . $req_seg2] = 'alloffers/offer_details_page';
    }
}

$route['companies'] = 'alloffers/companies';
$route['contact-us'] = 'home/contact_us';
$route['admin'] = 'admin/home';
$route['home'] = 'home/index';
$route['categories'] = 'home/categories';

if (($this->uri->segment(1) == 'advanced_search' || $this->uri->segment(2) == 'advanced_search') && isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
    $route['advanced_search'] = 'home/advanced_search_map';
else
    $route['advanced_search'] = 'home/advanced_search';

if ($this->uri->segment(2) == 'my_listing' && isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
    $route['user/my_listing'] = 'user/my_listing_map';
else
    $route['user/my_listing'] = 'user/my_listing';

if ($this->uri->segment(2) == 'deactivateads' && isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
    $route['user/deactivateads'] = 'user/deactivateads_map';
else
    $route['user/deactivateads'] = 'user/deactivateads';

if ($this->uri->segment(2) == 'favorite' && isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
    $route['user/favorite'] = 'user/favorite_map';
else
    $route['user/favorite'] = 'user/favorite';

if ($this->uri->segment(2) == 'like' && isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
    $route['user/like'] = 'user/like_map';
else
    $route['user/like'] = 'user/like';

$route['featured_ads'] = 'home/get_featured_ads';
$route['registration'] = 'registration/index';

$route['classifiedRegistration'] = 'ClassifiedRegistration/index';
$route['storeRegistration'] = 'StoreRegistration/index';

$route['allstores'] = 'allstores/index';
$route['allstores/(:any)'] = 'allstores/index';
//$route['allstores'] = 'stores/index';
$route['alloffers'] = 'alloffers/index';
$route['offers'] = 'alloffers/offers';

$route['categories_offers'] = 'alloffers/categories_offers';
$route['company_offers'] = 'alloffers/company_offers';

$route['user/(:any)'] = 'user/$1';
$route['(:any)/followers'] = 'home/index';

$route['store_search'] = 'allstores/store_search';
$route['request'] = 'home/request';
$route['faq'] = 'home/faq';
$route['cart'] = 'cart/index';
$route['login'] = 'login/index';

if (($this->uri->segment(1) == 'latest' || $this->uri->segment(2) == 'latest') && isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
    $route['latest'] = 'home/latest_ads_map';
else
    $route['latest'] = 'home/latest_ads';

$route['send_landing_email'] = 'landing/index';
$route['winipad'] = 'winipad/index';
$route['winipad-verification'] = 'winipad/winipadVerification';

$route['(:any)'] = 'home/index/$1';

if (($this->uri->segment(1) == 'search' || $this->uri->segment(2) == 'search') && isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
    $route['search'] = 'home/search_map';
else
    $route['search'] = 'home/search';

$route['payment_status/(:any)'] = 'paytabs_payment/payment_status/$1';
$route['phone'] = 'phone/index';
$route['test'] = 'test/index';

//$route['(:any)/(:any)']= 'home/index';
//$route['404_override'] = 'Error404';