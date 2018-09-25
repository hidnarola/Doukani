<?php

ini_set('max_execution_time', 7200);

//if (!defined('BASEPATH'))
//	exit('No direct script access allowed');

class New_pushnotifications extends CI_Controller {

    function __construct() {
	parent::__construct();

//	if ($this->uri->segment(2) != "sending_status" || $this->uri->segment(2) != "test") {
//	    if (!$this->dx_auth->is_logged_in()) {
//		redirect(base_url() . "auth");
//	    } else {
//		if (!$this->dx_auth->is_admin()) {
//		    //set flash message here
//		    redirect(base_url());
//		}
//	    }
//
//	    //check permission
//	    if (!$this->dx_auth->has_permission('PUSH_NOTIFICATIONS'))
//		redirect(base_url() . 'no_permission');
//	}
	$this->load->model("site_constants");
    }

    public function index() {
	$this->load->library('Device_Notification');
	$this->load->model('new_device_user');
	$authCode = $this->site_constants->getInfo(array('key' => 'auth_key'));
	$data = array();
	$main_data = array();
	$topMessage = "";
	$data['title'] = "notifications";
	$data['selectedTab'] = "notifications";
	$sendSuccessCount = 0;
	$sendFailedCount = 0;
	$success = "";
	$fail = "";

	if ($this->input->post()) {
	    $this->load->library('Device_Notification');
	    $API_KEY = $this->site_constants->getInfo(array('key' => 'auth_key')); //'AIzaSyC-Rxh3uzGqdD_gqRejOy0NSJZt0mMFtLM';
	    $this->load->model('new_device_user');
	    if ($this->input->post('send_device') != NULL) { //check android device id
		$conditions = array();
		if ($this->input->post('send_device') != NULL) {
		    $conditions[] = "device_id='" . $this->input->post('send_device') . "'";
		    $conditions[] = " device_type='0'";
		    $conditions[] = " LENGTH(pn_key) > 10";
		}
		$androidDeviceUsers = $this->new_device_user->get($conditions, 'device_id');
		$topMessage = "";
		$sendSuccessCount = 0;
		$sendFailedCount = 0;
		$messageArray = array();
		$title = trim($this->input->post('title'));
		$messageText = trim($this->input->post('message'));

		if ($this->input->post('action') != NULL) {
		    $action = $this->input->post('action');
		} else {
		    $action = "";
		}
		$messageArray['title'] = $title;
		$messageArray['text'] = $messageText;
		$messageArray['action'] = $action;

		if ($this->input->post('notification_image') != '') {
		    $folderName = $this->site_constants->getInfo(array('key' => 'notification_image_dir'));
		    $messageArray['url'] = image_base_url() . $folderName . '/' . $this->input->post('notification_image');
		}

		$messageArrayJson = json_encode($messageArray);		
		$output = array();
		$total = count($androidDeviceUsers);
		$output['response_text'] = 'Attempted to send ' . $total . ' Users';
		if (!empty($androidDeviceUsers)) {
		    $registration_ids = array();
		    foreach ($androidDeviceUsers as $androidDeviceUser) {
			$registration_ids[] = $androidDeviceUser['pn_key'];
		    }
		    $output['device_ids'] = $registration_ids;

		    if (!empty($registration_ids)) {
//                        print_r('android');
//                        die;
			$response = $this->device_notification->sendMessageToAndroidPhone($API_KEY, $registration_ids, $messageArrayJson);
			$response = json_decode($response, true);
			$output['response'] = $response;
			$output['success_count'] = (int) $response['success'];
			$output['failure_count'] = (int) $response['failure'];
			if ($output['success_count'] > 0) {
			    $sendSuccessCount = $output['success_count'];
			    $topMessage .= " Notification successfully sent to $sendSuccessCount Device";
			}
			if ($output['failure_count'] > 0) {
			    $sendFailedCount = $output['failure_count'];
			    $topMessage .= " Notification sent failed to $sendFailedCount Device";
			}
		    }
		} else {
		    $topMessage = "<lable style='color:red;font-weight:bold;'>Invalid device id!.</lable>";
		}
	    } 
	    elseif ($this->input->post('iphone_send_device') != NULL) {

		ini_set('memory_limit', '-1');
		ini_set('display_errors', '1');
		$iphone_notification_max_length = $this->config->item('iphone_notification_max_length');
		$output = array();
		$this->load->library('Device_Notification');
		$authCode = $this->site_constants->getInfo(array('key' => 'auth_key'));
		$this->load->model('new_device_user');
		//$limitStart = $_POST['limit_start'];
		//$limitStart = 10;
		//$offset = $_POST['offest'];
		$conditions = array();
		if ($this->input->post('iphone_send_device') != "") {
		    $conditions[] = "device_id='" . $this->input->post('iphone_send_device') . "'";
		    $conditions[] = " device_type='1'";
		    $conditions[] = " LENGTH(pn_key) > 0";
		}


		$messageText = trim($this->input->post('message'));
		$url = $this->input->get_post('url');
		$originalMessageText = $messageText;
		$totalMessageTextLength = mb_strlen($originalMessageText . $url, 'utf-8');

		if ($iphone_notification_max_length < $totalMessageTextLength) {
		    //$topMessage= 'message is tooooooo big';
		    echo "<script language='javascript'>alert('Message is too big');location.href='" . site_url("pushnotifications1") . "';</script>";
		    exit;
		}

		$iphoneDevices = $this->new_device_user->get($conditions, 'device_id');
		$total = count($iphoneDevices);
		$output['response_text'] = 'Ateempted to send ' . $total . ' Users';
		$success_count = 0;
		$failure_count = 0;
		$output['response'] = '';


		$response = '';
		if (!empty($iphoneDevices)) {
		    $pn_keys = array();
		    foreach ($iphoneDevices as $key => $iphoneDevice) {
			$pn_keys[] = $iphoneDevice['pn_key'];
			$success_count++;
			//break;
		    }
//                    print_r('iphone');
//                    die;
		    $response = $this->device_notification->sendMessageToIPhones($pn_keys, $originalMessageText, $url);
		    $output['success_count'] = $success_count;
		    $output['failure_count'] = $failure_count;
		    $output['response'] = $response;
		    $output['temp'] = $pn_keys;
		    if ($output['success_count'] > 0) {
			$sendSuccessCount = $output['success_count'];
			$topMessage .= " Notification successfully sent to $sendSuccessCount Device";
		    }
		    if ($output['failure_count'] > 0) {
			$sendFailedCount = $output['failure_count'];
			$topMessage .= " Notification sent failed to $sendFailedCount Device";
		    }
		} else {
		    $topMessage = "<lable style='color:red;font-weight:bold;'>Invalid device id!.</lable>";
		}
	    } else {
		$this->new_device_user->insert_message();
	    }
	}
	$main_data['topMessage'] = $topMessage;
	$result = $this->new_device_user->get_counter();
	//print_r($result);die;
	if (!empty($result)) {
	    foreach ($result as $result) {
		$success = $result['success'];
		$fail = $result['fail'];
		$main_data['success'] = $success;
		$main_data['fail'] = $fail;
	    }
	} else {
	    $main_data['success'] = $sendSuccessCount;
	    $main_data['fail'] = $sendFailedCount;
	}
	$data['main'] = $this->load->view('admin/admin/new_send_notification', $main_data, TRUE);
	$this->load->view('admin/admin/template', $data);
    }

    //commented function for stop push notification as it is continious running
    //19-10-2014 

    public function sending_status() {
	$this->load->library('GCM');
	$this->load->library('Device_Notification');
	$API_KEY = $this->site_constants->getInfo(array('key' => 'auth_key'));
	$this->load->model('new_device_user');
	$count_a_device = $this->new_device_user->get_a_count();
	$count_i_device = $this->new_device_user->get_i_count();
	$messages = $this->new_device_user->get_message_status();	
	foreach ($messages as $messages) {
	    if ($messages['device_type'] == "A" && $messages['message_status'] == 0) { 
		$userdata['message_status'] = 1;
		$this->new_device_user->update_message_status($messages['id'], $messages['device_type'], $userdata);		
		$topMessage = "";
		$counter = "";
		$sendSuccessCount = 0;
		$sendFailedCount = 0;
		$messageArray = array();
		$title = trim($messages['title']);
		$messageText = trim($messages['message']);
		$action = "message";
		//$action = isset($_POST['action']) ? $_POST['action'] : "";
		$messageArray['title'] = $title;
		$messageArray['text'] = $messageText;
		$messageArray['action'] = $action;
		if ($messages['notification_image'] != '') {
		    $folderName = $this->site_constants->getInfo(array('key' => 'notification_image_dir'));
		    $messageArray['url'] = image_base_url() . $folderName . '/' . $messages['notification_image'];
		}
		$messageArrayJson = json_encode($messageArray);
		$output = array();
		$total = $count_a_device;
		$output['response_text'] = 'Attempted to send ' . $total . ' Users';		
		$conditions = array();
		//$conditions[] = "device_type = 0";		
		//$conditions[] = "LENGTH(pn_key) > 10";
		$output = array();
                $total = $count_a_device;
                $output['response_text'] = 'Attempted to send ' . $total . ' Users';
                for($i=0;$i<$count_a_device;$i=$i+500){
                    $androidDeviceUsers = $this->new_device_user->getAllDevice($conditions, 'device_id',$i,500);		    
		    if (!empty($androidDeviceUsers)) {
                        $registration_ids = array();
                        foreach ($androidDeviceUsers as $androidDeviceUser) {
			    if(!empty($androidDeviceUser['pn_key'])):
				$registration_ids[] = $androidDeviceUser['pn_key'];  
			    endif;
                        }
//                        die;
			$response = $this->gcm->send_notification($API_KEY, $registration_ids, $messageArrayJson);
//			print_r($messageArray);			
//			die;
			
			$response = json_decode($response, true);
			$output['device_id'] = $androidDeviceUser['device_id'];
			$output['device_ids'] = $androidDeviceUser['pn_key'];
			$output['response'] = $response;
			$output['success_count'] = (int) $response['success'];
			$output['failure_count'] = (int) $response['failure'];
			$counter = $this->new_device_user->get_counter_value($messages['id'], $messages['device_type']);
			//Success Count
			$userdata['success'] = $output['success_count'];
			$this->new_device_user->update_counter_value($messages['id'], $messages['device_type'], $userdata);

			//Fail Count
			$userdata['fail'] = $output['failure_count'];
			$this->new_device_user->update_counter_value($messages['id'], $messages['device_type'], $userdata);                                            
                    }
                }		
		$userdata['status'] = "completed";
		$this->new_device_user->update_action($messages['id'], $messages['device_type'], $userdata);
	    }
	    elseif ($messages['device_type'] == "I" && $messages['message_status'] == 0) {
		$userdata['message_status'] = 1;
		$this->new_device_user->update_message_status($messages['id'], $messages['device_type'], $userdata);		 
		ini_set('memory_limit', '-1');
		ini_set('display_errors', '1');
		$iphone_notification_max_length = $this->config->item('iphone_notification_max_length');
		$output = array();
		//$authCode = $this->site_constants->getInfo(array('key' => 'auth_key'));			
		$messageText = trim($messages['message']);
		$url = $messages['url'];
		$originalMessageText = $messageText;
		$totalMessageTextLength = mb_strlen($originalMessageText . $url, 'utf-8');
		if ($iphone_notification_max_length < $totalMessageTextLength) {
		    break;   //message is too big
		}
		$total = $count_i_device;
		$output['response_text'] = 'Ateempted to send ' . $total . ' Users';
		$success_count = 0;
		$failure_count = 0;
		$output['response'] = '';
		$conditions = array();
		$conditions[] = "device_type = 1";
		$conditions[] = "LENGTH(pn_key) > 10";	
		$total = $count_i_device;
		$output['response_text'] = 'Ateempted to send ' . $total . ' Users';                
                for ($i = 0; $i < $count_i_device; $i = $i + 500) {
		    $iphoneDevices = $this->new_device_user->getAllDevice_iphone($conditions, 'device_id', $i, 500);
		    //$iphoneDevices = $this->device_user1->getAllDevice($conditions, 'device_id',0,10);
		    $response = ''; 
		    if (!empty($iphoneDevices)) {
			foreach ($iphoneDevices as $i) {
			    $registration_ids = array();
			    if(!empty($i['pn_key'])):
				$registration_ids[] = $i['pn_key'];
//                                die;
				$response = $this->device_notification->sendMessageToIPhones($registration_ids, $originalMessageText, $url);
				$output['success_count'] = $success_count;
				$output['failure_count'] = $failure_count;
				$output['response'] = $response;
				//$output['temp'] = $iphoneDevices['pn_key'];
				$success_count++;
				$counter = $this->new_device_user->get_counter_value($messages['id'], $messages['device_type']);

				//Success Count
				$userdata['success'] = $output['success_count'];
				$this->new_device_user->update_counter_value($messages['id'], $messages['device_type'], $userdata);

				//Fail Count
				$userdata['fail'] = $output['failure_count'];
				$this->new_device_user->update_counter_value($messages['id'], $messages['device_type'], $userdata);
			    endif;
			}			
			sleep(1);
		    }		  
		}
		$userdata['status'] = "completed";
		$this->new_device_user->update_action($messages['id'], $messages['device_type'], $userdata);
	    }
	}
	echo "run it";
    }

    public function imageuploadajax() {
	$this->load->helper('file');
	if (count($_FILES) > 0) {
	    $folderName = $this->site_constants->getInfo(array('key' => 'notification_image_dir'));
	    $NOTIIFCATION_IMAGE_PATH = SITE_ROOT . '/' . $folderName . '/';
	    $filearray = $_FILES['notification_image'];
	    $output = array();
	    if (!empty($filearray) && $filearray['error'] == 0) {
		$uniqueFileName = md5(time());
		$ext = FileExtension($filearray['name']);
		$fileName = $uniqueFileName . "." . $ext;
		$upload_config['upload_path'] = $NOTIIFCATION_IMAGE_PATH;
		$upload_config['allowed_types'] = 'gif|jpg|png';
		$upload_config['max_size'] = '2048';
		$upload_config['max_width'] = '2048';
		$upload_config['max_height'] = '1500';
		$upload_config['overwrite'] = TRUE;
		$upload_config['file_name'] = $fileName;

		$this->load->library('upload', $upload_config);

		if (!$this->upload->do_upload('notification_image')) {
		    $output['type'] = 'error';
		    $output['message'] = "image Upload Failed " . print_r($this->upload->display_errors(), true);
		} else {
		    $output['type'] = 'success';
		    $output['image_src'] = image_base_url() . $folderName . '/' . $fileName;
		    $output['image_name'] = $fileName;
		}
	    } else {
		$output['type'] = 'error';
		$output['message'] = 'There were some error while uploading file';
	    }
	    echo json_encode($output);
	}
    }

    public function test() {
	echo "I am in test";
	die;
    }

}

