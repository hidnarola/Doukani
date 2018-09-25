<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR . get_include_path());

class Googleplus {
	
	public function __construct() {
		
		$CI =& get_instance();
		$CI->config->load('googleplus');
		
		require APPPATH .'third_party/Google/autoload.php';
		
		$cache_path = $CI->config->item('cache_path');
		$GLOBALS['apiConfig']['ioFileCache_directory'] = ($cache_path == '') ? APPPATH .'cache/' : $cache_path;
		
		$this->client = new Google_Client();
		$this->client->setApplicationName($CI->config->item('application_name', 'googleplus'));
		$this->client->setClientId($CI->config->item('client_id', 'googleplus'));
		$this->client->setClientSecret($CI->config->item('client_secret', 'googleplus'));
		$this->client->setRedirectUri($CI->config->item('redirect_uri', 'googleplus'));
		$this->client->setDeveloperKey($CI->config->item('api_key', 'googleplus'));
		$this->client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me'));
		
		$this->plus = new Google_Service_Plus($this->client);
                
    }
	
	public function __get($name) {
		
		if(isset($this->plus->$name)) {
			return $this->plus->$name;
		}
		return false;
		
	}
	
	public function __call($name, $arguments) {
		
		if(method_exists($this->plus, $name)) {
			return call_user_func(array($this->plus, $name), $arguments);
		}
		return false;
		
	}
	
}
?>
