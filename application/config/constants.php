<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */

define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('document_root', $_SERVER['DOCUMENT_ROOT'] . '/');

define('profile', 'assets/upload/profile/');
define('image_allowed_upload', 'jpg|png|bmp|gif|jpeg');

define('profile_thumb_width', 27);
define('profile_thumb_height', 27);

define('profile_medium_thumb_width', 202);
define('profile_medium_thumb_height', 202);

define('cover', 'assets/upload/cover_picture/');
define('cover_medium_thumb_width', 367);
define('cover_medium_thumb_height', 202);

define('image_product_detail_width', 800);
define('image_product_detail_height', 356);

define('image_medium_width', 284);
define('image_medium_height', 179);

define('stores', 'assets/upload/stores/');
define('store_small_thumb_width', 60);
define('store_small_thumb_height', 40);
define('store_medium_thumb_width', 202);
define('store_medium_thumb_height', 160);

define('store_cover', 'assets/upload/store_cover/');
define('company_logo', 'assets/upload/company_logo/');
define('doukani_logo', 'assets/upload/doukani_logo/');

define('store_cover_small_thumb_width', 384);
define('store_cover_small_thumb_height', 230);
define('store_cover_medium_thumb_width', 1920);
define('store_cover_medium_thumb_height', 440);

define('stores_product', 'assets/upload/stores_product/');
define('offers', 'assets/upload/offers/');
define('offer_company', 'assets/upload/company_logo/');
define('category', 'assets/upload/category/');
define('pages', 'assets/upload/pages/');
define('product', 'assets/upload/product/');
define('banner', 'assets/upload/banner/');
define('front_fontawesome', 'assets/front/dist/font-awesome-4.3.0/css/');
define('front_fontello', 'assets/admin/stylesheets/fontello-7275ca86/css/fontello.css');
define('front_icomoon', 'assets/admin/stylesheets/icomoon/style.css');
define('doukani_app', 'http://app.doukani.com/');
define('doukani_iphone_app', 'https://itunes.apple.com/us/app/doukani/id985499336?mt=8');
define('doukani_android_app', 'https://play.google.com/store/apps/details?id=com.app.doukani&hl=en');
define('doukani_website', 'doukani.com/');
define('website_url', 'doukani.com/');
define('after_subdomain', '.doukani.com');
define('price_zero_label', 'If no price,put zero');

define('TBL_REPORTED_ITEMS', 'reported_items');

if (isset($_SERVER['HTTPS']))
    define('HTTPS', 'https://');
else
    define('HTTPS', 'http://');

define('HTTP', 'http://');
define('remove_home', '/');

define('thumb_start_grid_offer', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_grid_offer', '&zc=1&w=284&h=179&q=70');

define('thumb_start_grid', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_grid', '&zc=2&w=284&h=179&q=70');

define('thumb_start_grid_map', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_grid_map', '&w=181&h=179&q=70');

define('thumb_start_grid_userprofile', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_grid_userprofile', '&zc=2&w=86&h=86&q=70');

define('thumb_start_grid_store_cover', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_grid_store_cover', '&w=346&h=206&q=70');

define('thumb_start_grid_store_cover_big', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_grid_store_cover_big', '&w=1920&h=440&zc=0');

define('thumb_start_store_cover', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_store_cover', '&w=1583&h=250&zc=1');

define('thumb_start_edit_store_cover', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_edit_store_cover', '&w=1194&h=270&zc=0');

define('thumb_start_grid_featured_latest', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_grid_featured_latest', '&zc=2&w=262&h=127&q=70');

define('thumb_start_small', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_small', '&w=68&h=68&q=70');

define('thumb_start_small_store', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_small_store', '&w=70&h=70&q=70');

define('thumb_start_cart', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_end_cart', '&w=70&h=70&q=70');

define('thumb_store_user_start', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_store_user_end', '&w=86&h=86&q=70');

define('thumb_follower_start', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_follower_end', '&w=78&h=78&q=70');

define('thumb_user_image_start', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_user_image_end', '&w=124&h=124&q=70');

define('thumb_user_profile_start', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_user_profile_end', '&w=146&h=146&q=70');

define('thumb_store_page_user_start', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('thumb_store_page_user_end', '&w=94&h=94&q=70');

define('item_details_image_start', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('item_details_image_end', '&h=356&q=70');

define('company_image_start', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('company_image_end', '&h=120&q=70');

define('company_details_image_start', 'https://doukani.com/assets/front/timthumb1.php?src=');
define('company_details_image_end', '&h=150&q=70');

define('static_image_path', 'https://doukani.com/assets/front/images/');

define('default_no_of_ads', 15);
define('default_ads_availability', 45);
define('update_deactivate_ads', 90);

define('ios_app_id', '985499336');
define('android_app_id', 'com.showup.makemevip');
define('year', '2017');

define('home_title', 'UAE leading online free classifieds platform');

define('ASIA_DUBAI_OFFSET', '+04:00');

define('SITE_ADMIN_EMAIL', 'adonis@adonis.name');

define('PAY_TABS_MERCHANT_EMAIL', 'adonis@adonis.name');
define('PAY_TABS_SECRET_KEY', 'cW7Ts6vkXjLCq7lihHx8cFI002Rr9qHlnOfPVK9S3Vuu3QMkxksKZbKZdCrm38IqXXgSHqLLlggo62IDnbnmn8mALNXOWFfTDvMk');
define('PAY_TABS_SITE_URL', 'https://doukani.com');
define('PAY_TABS_RETURN_URL', 'https://doukani.com/');
define('PAY_TABS_IP_MERCHANT', '52.35.194.19');
define('PAY_TABS_CMS_WITH_VERSION', 'VT_PayTabs 0.1.0');
define('PAY_TABS_VALID_SECRET_KEY', 4000);
define('PAY_TABS_PAGE_CREATED_SUCCESS', 4012);
define('PAY_TABS_PAGE_PAYMENT_SUCCESS', 100);
define('PAY_TABS_PAGE_REFUND_SUCCESS', 812);
