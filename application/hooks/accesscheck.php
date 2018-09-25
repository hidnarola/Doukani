<?php

class Accesscheck {

    function index() {

        require_once('permissions.php');
        $baseURL = $GLOBALS['CFG']->config['base_url'];

        $routing = & load_class('Router');
        $class = $routing->fetch_class();
        $method = $routing->fetch_method();

        $CI = & get_instance();
        $CI->load->library('session');

        $login = false;
        $user = $CI->session->userdata('user');
        $__gen_user = $CI->session->userdata('gen_user');

        if (empty($__gen_user)) {
            $url_ = $CI->config->site_url($CI->uri->uri_string());
            $current_my_path = $_SERVER['QUERY_STRING'] ? $url_ . '?' . $_SERVER['QUERY_STRING'] : $url_;
            $_redirect_me = str_replace('#1', '', $current_my_path);

            if (strpos($current_my_path, '#1') !== false)
                redirect($_redirect_me, 'refresh');
        }

        if (!empty($user->email_id) && !empty($user->password)) {
            $login = true;
        }
        $gen_login = false;
        if (!empty($__gen_user->email_id) && !empty($__gen_user->password)) {
            $gen_login = true;
        }

        $first_name = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], "."));
        $not_in_url = array('doukani', 'www');

        $in_arr = array('index', 'category', 'search', 'advanced_search', 'get_data_advanced', 'search_by_city', 'category_map', 'category_listing', 'item_details', 'contact_us', 'get_featured_ads', 'categories', 'request', 'faq');

        $sell_arr = array('listings', 'followers');

        if ((($CI->uri->segment(1) == 'home' && in_array($CI->uri->segment(2), $in_arr)) || ($CI->uri->segment(1) == 'seller' && in_array($CI->uri->segment(2), $sell_arr))) || ($CI->uri->segment(1) == 'cart' && $method == 'index')) {
            $CI->session->set_userdata('client_request', $_SERVER['REQUEST_URI']);
        }

        $admin = $CI->uri->segment(1);
        $controller = $CI->router->fetch_class();
        $action = $CI->router->fetch_method();

        $allowWithoutLogin = array('login', 'forget_password', 'reset_password', 'verify', 'show_emirates');


        $action_arr = array('post_ads', 'deactivateads', 'deactivateads_map', 'favorite', 'my_listing', 'listings_edit', 'inbox_products', 'item_details', 'store', 'orders', 'order_list', 'like', 'favorite_map', 'like_map', 'my_listing_map', 'followers');


        if (empty($user) && $admin == 'admin' && (!in_array($action, $allowWithoutLogin))) {
            redirect('admin/users/login', 'refresh');
        } elseif (!empty($user) && $admin == 'admin' && (!in_array($action, $allowWithoutLogin))) {

            $res_block = $CI->db->query("select * from user where user_role='admin' and user_id=" . (int) $user->user_id . " and is_delete=4");

            if ($res_block->num_rows() > 0) {

                if ($admin_login == true && !in_array($action, $allowWithoutLogin)) {
                    $CI->session->unset_userdata('user');
                    redirect('admin/users/login', 'refresh');
                }
            }

            if (!empty($doesNotRequireLogin[$class][$method])):
                return true;
            else:
                $dashboard = $CI->permission->has_permission('dashboard');
                $categoriess = $CI->permission->has_permission('categories');
                $classified = $CI->permission->has_permission('classified');
                $store_mgt = $CI->permission->has_permission('store_mgt');
                $offer_mgt = $CI->permission->has_permission('offer_mgt');

                $user_mgt = $CI->permission->has_permission('user_mgt');
                $system_mgt = $CI->permission->has_permission('system_mgt');
                $page_mgt = $CI->permission->has_permission('page_mgt');
                $push_notification = $CI->permission->has_permission('push_notification');
                $message_mgt = $CI->permission->has_permission('message_mgt');
                $order_mgt = $CI->permission->has_permission('order_mgt');

                $only_listing = $CI->permission->has_permission('only_listing');

                if (!empty($user) && $user->user_role == 'superadmin') {
                    return true;
                } elseif (!empty($user) && ($user->user_role == 'admin')) {

//                    /!isset($_REQUEST['userid']) && 
                    if ($only_listing == 1 && (in_array($controller, array('classifieds', 'users', 'offers')))) {

                        if (in_array($action, array('listings', 'listings_add', 'listings_edit', 'removeimage', 'removemainimage', 'listings_view', 'listings_spam', 'filterListing', 'show_sub_cat', 'filter_sub_cat', 'order_category', 'order_sub_category', 'show_emirates', 'show_emirates_postadd', 'image_upload', 'profile', 'reset_listing', 'reset_listing_spam', 'removevideo', 'remove_image_uploaded', 'show_model', 'featured_ads', 'repost_ads', 'reset_repostlisting', 'categories', 'categories_add', 'subCategories', 'subCategories_add', 'index', 'add', 'edit', 'view', 'featured_offers'
                                        //'categories_delete','subCategories_delete','listings_delete','update_unfeatured','update_status','insert_featured','categories_edit','subCategories_edit'
                                ))) {
                            if ($CI->uri->segment(4) != 'store')
                                return true;
                            else {
                                $CI->session->set_flashdata(array('msg' => 'You have no rights to access that module', 'class' => 'alert-success'));
                                redirect('admin/home', 'refresh');
                            }
                        } else {
                            $CI->session->set_flashdata(array('msg' => 'You have no rights to access that module', 'class' => 'alert-success'));
                            redirect('admin/home', 'refresh');
                        }
                    } elseif ((in_array(1, array($classified, $categoriess)) && $controller == 'classifieds') ||
                            ($offer_mgt == 1 && $controller == 'offers') ||
                            ($user_mgt == 1 && $controller == 'users') ||
                            ($system_mgt == 1 && ($controller == 'custom_banner' || $controller == 'systems' || $controller == 'doukani_logo')) ||
                            ($page_mgt == 1 && $controller == 'pages') || ($page_mgt == 1 && $controller == 'faq') ||
                            ($store_mgt == 1 && $controller == 'classifieds') ||
                            ($push_notification == 1 && $controller == 'push_notification') || $controller == 'home' ||
                            ($message_mgt == 1 && $controller == 'conversation') || ($order_mgt == 1 && $controller == 'orders')) {

                        $segment_4 = $CI->uri->segment(4);
                        $segment_5 = $CI->uri->segment(5);
                        $segment_6 = $CI->uri->segment(6);

                        if ($categoriess == 1 && in_array($action, array('categories', 'categories_add', 'categories_edit', 'categories_delete', 'subCategories', 'subCategories_add', 'subCategories_edit', 'subCategories_delete'))) {
                            return true;
                        } elseif (((isset($segment_4) && !empty($segment_4)) || (isset($segment_5) && !empty($segment_5)) || (isset($segment_6) && !empty($segment_6))) &&
                                ((in_array('store', array($segment_4, $segment_5, $segment_6)) && $store_mgt <> 1) ||
                                (in_array('classified', array($segment_4, $segment_5, $segment_6)) && $classified <> 1))) {
                            $CI->session->set_flashdata(array('msg' => 'You have no rights to access that module', 'class' => 'alert-success'));
                            redirect('admin/home', 'refresh');
                        }
//                            elseif($user_mgt == 1 && in_array($action,array('listings_add','listings','repost_ads'))) {
//                                echo $action;
//                                exit;
//                                //$user_mgt==1 && 
//                                     return true;
//                            }
                        else
                            return true;
                    } else {
                        $in_check = array('show_model', 'show_sub_cat', 'filter_sub_cat');
                        if (in_array($action, $in_check))
                            return true;
                        else {
                            $CI->session->set_flashdata(array('msg' => 'You have no rights to access that module', 'class' => 'alert-success'));
                            redirect('admin/home', 'refresh');
                        }
                    }
                }
            endif;
        } elseif (empty($__gen_user) && $admin == 'user') {

            if (in_array($action, $action_arr)) {
                $CI->session->set_userdata('client_request', $_SERVER['REQUEST_URI']);
            }
            redirect('login/index');
        } elseif (!empty($__gen_user) && $admin == 'user') {

            if (in_array($action, $action_arr)) {
                $CI->session->set_userdata('client_request', $_SERVER['REQUEST_URI']);
            }
            $user_session = $CI->session->userdata('gen_user');
            $res_block = $CI->db->query("select * from user where user_id=" . (int) $user_session['user_id'] . " and is_delete=4");

            if ($res_block->num_rows() > 0) {
                $CI->session->unset_userdata('gen_user');
                redirect('login/index', 'refresh');
            }

            if ($controller == 'user' && $action == 'add_to_favorites' && $user_session['is_delete'] == 2)
                echo 'failure';
            //not agree with terms and conditions
            if ($controller == 'user' && $action != 'agree' && $user_session['is_delete'] == 2)
                redirect('login/agree', 'refresh');
            //Select USer type store and has to fill create store form
//            if ($controller == 'user' && $action != 'create_store' && $user_session['is_delete'] == 5)
//                redirect('login/create_store', 'refresh');
            if ($controller == 'user' && $action != 'store' && $user_session['is_delete'] == 5)
                redirect('user/store', 'refresh');
//            if ($controller == 'user' && $action != 'store2' && $user_session['is_delete'] == 5 && $user_session['user_id'] == 830)
//                redirect('user/store2', 'refresh');
            //if not role (User type selected)
            if ($controller == 'user' && $action != 'user_role' && ($user_session['user_role'] == NULL || $user_session['user_role'] == ''))
                redirect('login/user_role', 'refresh');

            if ($controller == 'user' && $user_session['user_role'] == 'storeUser' && empty($user_session['last_login_as'])) {
                if (!in_array($action, array('add_to_favorites', 'add_to_like')))
                    redirect('login/user_for');
            }
        }
        elseif (empty($__gen_user) && (in_array($action, array('agree', 'user_role', 'create_store')))) {
            redirect('home', 'refresh');
        } elseif (!empty($__gen_user) &&
                ($CI->uri->segment(1) == 'registration' || in_array($action, array('agree', 'user_role', 'create_store')))) {
            $user_session = $CI->session->userdata('gen_user');

            if (($action == 'agree' && in_array($user_session['is_delete'], array(0, 3, 4, 5))) ||
                    (!empty($user_session['user_role']) && $action == 'user_role') ||
                    ($action == 'create_store' && in_array($user_session['is_delete'], array(0, 2, 3, 4))) ||
                    ($CI->uri->segment(1) == 'registration')
            )
                redirect('home', 'refresh');
        } else {

            if ($CI->uri->segment(3) != 'login' && (!in_array($action, $allowWithoutLogin)) && $CI->uri->segment(1) == 'admin') {
                redirect('admin/users/login', 'refresh');
                exit;
            }
        }
        //}
    }

    /* redirect to correct path if user try to access with any sub-domain
      == remove sub-domain name ==
     */

    function redirect_to_path() {

        $arr = explode(".", base_url(uri_string()));
        unset($arr[0]);
        $redirect = implode(".", $arr);
        header('Location:https://' . $redirect);
    }

}

?>