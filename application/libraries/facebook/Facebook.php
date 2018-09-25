<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!file_exists( APPPATH . 'libraries/facebook/Facebook/GraphObject.php')) {   
	//echo 'here';
}
require_once( APPPATH . 'libraries/Facebook/Facebook/GraphObject.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/GraphSessionInfo.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookSession.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookCurl.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookHttpable.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookCurlHttpClient.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookResponse.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookSDKException.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookRequestException.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookAuthorizationException.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookRequest.php' );
require_once( APPPATH . 'libraries/Facebook/Facebook/FacebookRedirectLoginHelper.php' );

use Facebook\GraphSessionInfo;
use Facebook\FacebookSession;
use Facebook\FacebookCurl;
use Facebook\FacebookHttpable;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookResponse;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookRequestException;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphObject;

class Facebook {

    var $ci;
    var $helper;
    var $session;

    public function __construct() {
        $this->ci = & get_instance();

        FacebookSession::setDefaultApplication($this->ci->config->item('api_id', 'facebook'), $this->ci->config->item('app_secret', 'facebook'));
        $this->helper = new FacebookRedirectLoginHelper($this->ci->config->item('redirect_url', 'facebook'));

        if ($this->ci->session->userdata('fb_token')) {
            $this->session = new FacebookSession($this->ci->session->userdata('fb_token'));

            // Validate the access_token to make sure it's still valid
            try {
                if (!$this->session->validate()) {
                    $this->session = false;
                }
            } catch (Exception $e) {
                // Catch any exceptions
                $this->session = false;
            }
        } else {
            try {
                $this->session = $this->helper->getSessionFromRedirect();
            } catch (FacebookRequestException $ex) {
                // When Facebook returns an error
            } catch (\Exception $ex) {
                // When validation fails or other local issues
            }
        }

        if ($this->session) {
            $this->ci->session->set_userdata('fb_token', $this->session->getToken());

            $this->session = new FacebookSession($this->session->getToken());
        }
    }

    public function get_login_url() {
        return $this->helper->getLoginUrl($this->ci->config->item('permissions', 'facebook'));
    }

    public function get_logout_url() {
        if ($this->session) {
            $this->ci->session->set_userdata('fb_token', "");
            return $this->helper->getLogoutUrl($this->session, base_url() . 'login');
        }
        return false;
    }

    public function get_user() {

        if ($this->session) {
            try {
                $request = (new FacebookRequest($this->session, 'GET', '/me?fields=id,name,email,first_name,last_name'))->execute();
                $user = $request->getGraphObject()->asArray();
               
                return $user;
            } catch (FacebookRequestException $e) {
                return false;
            }
        }
    }


}

