<?php

class Push_notification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dblogin', '', TRUE);
        $this->load->model('dbcommon', '', TRUE);
        $this->load->model('dashboard', '', TRUE);
        $this->load->library('permission');
        $this->load->library('Device_Notification');
    }

    public function ios() {

        $data = array();
        $data['page_title'] = 'IOS - Push Notification';
        
        $user_where = " is_delete<>1 and status='active'";
        $user_data = $this->dbcommon->filter('user', $user_where);
        $data['user_data'] = $user_data;
        $current_user = $this->session->userdata('user');
        $setting_query = ' where id=7 and `key`="iphone_notification_max_length" ';

        $notification_max_length = $this->dbcommon->getrowdetails('settings', $setting_query);

        $data['notification_max_length'] = $notification_max_length;
	$data['request_page'] =  'ios';
		
        $this->load->view('admin/push_notification/push_notification', $data);
    }

    public function android() {
		$data = array();
		$data['page_title'] = 'Android - Push Notification';
		$data['request_page'] =  'android';
		
		$setting_query = ' where id=13 and `key`="android_notification_max_length" ';

        $notification_max_length = $this->dbcommon->getrowdetails('settings', $setting_query);
        $data['notification_max_length'] = $notification_max_length;
		
		$this->load->view('admin/push_notification/push_notification', $data);
    }

    public function prepare_iphone_notification_ajax() {

        $current_user = $this->session->userdata('user');
        $setting_query = ' where id=7 and `key`="iphone_notification_max_length" ';

        $count = $this->dbcommon->getrowdetails('settings', $setting_query);
        $iphone_notification_max_length = $count->val;

        $messageText = $this->input->get_post('message', true);
        $url = $this->input->get_post('url', true);

        $totalMessageText = $messageText . $url;
        $totalMessageTextLength = mb_strlen($totalMessageText, 'utf-8');

        if ($iphone_notification_max_length < $totalMessageTextLength) {
            echo 'message is too big';
            exit;
        }

        //load devices
        $conditions = array();
        //single phone user
        $query = '';
        if (isset($_POST['blah']) && $_POST['blah'] != "") {
            $ids = $_POST['blah'];
            $query = ' user_id from user where device_type=1 and user_id in(' . $ids . ') and is_delete<>1 and length(login_token)>0 ';
        } else {

            if (isset($_POST['send_all']) && $_POST['send_all'] == "yes") {
                //multiple iphone user			
                $query = ' user_id from user where device_type=1 and is_delete<>1 and length(login_token)>0 ';
            } else {
                echo 'No User selected';
                exit;
            }
        }

        $totalIphoneDeviceUser = $this->dbcommon->getnumofdetails_($query);

        echo "Total = " . $totalIphoneDeviceUser;

        $notify_users_at_once = 40;

        if ($totalIphoneDeviceUser > 0) {
            echo "<div class='attention' style='font-weight:bold;font-size:25;color:red;'>Please do not close the browser until all notification send complete.</div>";
            echo "<div class='notificationReport'></div>";
            echo "<div class='buttonContainers'>";
            $totalSlot = ceil($totalIphoneDeviceUser / $notify_users_at_once);
            if (($totalSlot * $notify_users_at_once) == $totalIphoneDeviceUser) {
                for ($i = 0; $i < $totalSlot; $i++) {
                    $limitStart = ($i * $notify_users_at_once);
                    $lastClass = (($totalSlot - 1) == $i) ? " last" : "";
                    echo "<input class='notificationButton$lastClass' type='button' value='" . ($i + 1) . ")pending' start='$limitStart' number_of_user='$notify_users_at_once' pageNo='" . ($i + 1) . "'>";
                }
            } else {
                for ($i = 0; $i < $totalSlot - 1; $i++) {
                    $limitStart = ($i * $notify_users_at_once);

                    echo "<input class='notificationButton'  type='button' value='" . ($i + 1) . ")pending' start='$limitStart' number_of_user='$notify_users_at_once' pageNo='" . ($i + 1) . "'>";
                }
                $remaining = $totalIphoneDeviceUser - (($totalSlot - 1) * $notify_users_at_once);
                $limitStart = ($totalSlot - 1) * $notify_users_at_once;
                echo "<input class='notificationButton last' type='button' value='" . ($i + 1) . ")pending' start='$limitStart' number_of_user='$remaining' pageNo='" . ($i + 1) . "'>";
            }
            echo "</div>";
        }
        exit();
    }

    public function send_iphone_notification_ajax() {

        $current_user = $this->session->userdata('user');

        $query = '';
        ini_set('memory_limit', '-1');
        ini_set('display_errors', '1');

        $setting_query = ' where id=7 and `key`="iphone_notification_max_length" ';

        $count = $this->dbcommon->getrowdetails('settings', $setting_query);
        $iphone_notification_max_length = $count->val;

        $output = array();
        $this->load->library('Device_Notification');
        $limitStart = $_POST['limit_start'];
        //$limitStart = 10;
        $offset = $_POST['offest'];

        $conditions = array();

        if (isset($_POST['blah']) && $_POST['blah'] != "") {

            $ids = $_POST['blah'];
            $query = ' device_type=1 and user_id in(' . $ids . ') and is_delete<>1 and length(login_token)>0 ';
        } else {
            $query = ' device_type=1 and is_delete<>1 and length(login_token)>0';
        }

        $messageText = trim($_POST['message']);
        $url = $this->input->get_post('url');
        $originalMessageText = $messageText;
        $totalMessageTextLength = mb_strlen($originalMessageText . $url, 'utf-8');

        if ($iphone_notification_max_length < $totalMessageTextLength) {
            echo 'message is too big';
            exit;
        }

        $iphoneDevices = $this->dbcommon->filter('user', $query);

        $total = count($iphoneDevices);
        $output['response_text'] = 'Attempted to send ' . $total . ' Users';
        $success_count = 0;
        $failure_count = 0;
        $output['response'] = '';

        $response = '';
        if (!empty($iphoneDevices)) {
            $in_data = array('phone_type' => 'iphone',
                'message' => $_POST['message'],
                'url' => $_POST['url'],
                'admin_id' => $current_user->user_id
            );

            $this->dbcommon->insert('push_notifications', $in_data);
            $noti_id = $this->db->insert_id();
            $pn_keys = array();
            foreach ($iphoneDevices as $key => $iphoneDevice) {
                // print_r($iphoneDevice['login_token']);
                // echo '<br>';
                $pn_keys[] = $iphoneDevice['login_token'];

                $inno_data = array('device_id' => $iphoneDevice['login_token'],
                    'notification_id' => $noti_id,
                    'user_id' => $iphoneDevice['user_id']
                );

                $this->dbcommon->insert('push_notified_users', $inno_data);
                $success_count++;
            }
            $arr_uni = array_unique($pn_keys);
            $response = $this->device_notification->sendMessageToIPhones($arr_uni, $originalMessageText, $url);
        }

        $output['success_count'] = $success_count;
        $output['failure_count'] = $failure_count;
        $output['response'] = $response;
        $output['temp'] = $arr_uni;
        echo json_encode($output);
        exit();
    }
	
	public function prepare_android_notification_ajax()
    {
        
		//load devices
        $conditions = array();
        //single phone user
        $query = '';
        if (isset($_POST['blah']) && $_POST['blah'] != "") {
            $ids = $_POST['blah'];
            $query = ' user_id from user where device_type=0 and user_id in(' . $ids . ') and is_delete<>1 and length(login_token)>0 ';
        } else {

            if (isset($_POST['send_all']) && $_POST['send_all'] == "yes") {
                //multiple iphone user			
                $query = ' user_id from user where device_type=0 and is_delete<>1 and length(login_token)>0 ';
            } else {
                echo 'No User selected';
                exit;
            }
        }
		
		$totalAndroidDeviceUser = $this->dbcommon->getnumofdetails_($query);
		
        echo "Total = " . $totalAndroidDeviceUser;
		$notify_users_at_once =40;	
        if($totalAndroidDeviceUser > 0)
        {
            echo "<div class='attention' style='font-weight:bold;font-size:25;color:red;'>Please do not close the browser until all notification send complete.</div>";
            echo "<div class='notificationReport'></div>";
            echo "<div class='buttonContainers'>";
            $totalSlot = ceil($totalAndroidDeviceUser / $notify_users_at_once);
            if(($totalSlot * $notify_users_at_once) == $totalAndroidDeviceUser)
            {
                for($i=0;$i < $totalSlot;$i++)
                {
                    $limitStart = ($i*$notify_users_at_once);
                    $lastClass = (($totalSlot-1) == $i)?" last":"";
                    echo "<input class='notificationButton$lastClass' type='button' value='".($i+1).")pending' start='$limitStart' number_of_user='$notify_users_at_once' pageNo='".($i+1)."'>";
                }
            }
            else
            {
                for($i=0;$i < $totalSlot-1;$i++)
                {
                    $limitStart = ($i*$notify_users_at_once);
                    
                    echo "<input class='notificationButton'  type='button' value='".($i+1).")pending' start='$limitStart' number_of_user='$notify_users_at_once' pageNo='".($i+1)."'>";
                }
                $remaining = $totalAndroidDeviceUser -  (($totalSlot-1) * $notify_users_at_once);
                $limitStart = ($totalSlot-1) * $notify_users_at_once;
                echo "<input class='notificationButton last' type='button' value='".($i+1).")pending' start='$limitStart' number_of_user='$remaining' pageNo='".($i+1)."'>";
            }
            echo "</div>";
        }
        exit();
    } 
	
	public function send_android_notification_ajax()
    {
        // $API_KEY = 'AIzaSyDLyHWGKQiTtJFmtV9w5x7LZtUw_JEjO6Y';
        $API_KEY = 'AIzaSyDLyHWGKQiTtJFmtV9w5x7LZtUw_JEjO6Y';
		$query = '';
		$current_user = $this->session->userdata('user');
        $setting_query = ' where id=13 and `key`="android_notification_max_length" ';
		
		if (isset($_POST['blah']) && $_POST['blah'] != "") {

            $ids = $_POST['blah'];
            $query = ' device_type=0 and user_id in(' . $ids . ') and is_delete<>1 and length(login_token)>0 ';
        } 
		else {
            $query = ' device_type=0 and is_delete<>1 and length(login_token)>0';
        }
		
		$androidDeviceUsers = $this->dbcommon->filter('user', $query);

		$count = $this->dbcommon->getrowdetails('settings',$setting_query);		
        $android_notification_max_length = $count->val;
		
		$messageText = trim($_POST['message']);
        $url = $this->input->get_post('url');
        $originalMessageText = $messageText;
        $totalMessageTextLength = mb_strlen($originalMessageText . $url, 'utf-8');

        if ($android_notification_max_length < $totalMessageTextLength) {
            echo 'message is too big';
            exit;
        }
        
        $messageArray = array();
        $title = trim($_POST['title']);
        
        $action      = isset($_POST['action'])?$_POST['action']:"";
        $messageArray['title']  = $title;
        $messageArray['text']   = $messageText;
        $messageArray['action'] = $action;        
        $messageArrayJson = json_encode($messageArray);
        
        $output = array();
        $total = count($androidDeviceUsers);
        $output['response_text'] = 'Attempted to send '.$total.' Users';
        if(!empty($androidDeviceUsers))
        {
		
			$in_data = array('phone_type' => 'android',
				'message' => $_POST['message'],
				'url' => $_POST['url'],
				'admin_id' => $current_user->user_id
			);
			
			$success_count = 0;
			$failure_count = 0;
		
            $this->dbcommon->insert('push_notifications', $in_data);
            $noti_id = $this->db->insert_id();            
			$registration_ids = array();
            foreach ($androidDeviceUsers as $key => $androidDeviceUser) {
                
				$registration_ids[] = $androidDeviceUser['login_token'];

                $inno_data = array('device_id' => $androidDeviceUser['login_token'],
                    'notification_id' => $noti_id,
                    'user_id' => $androidDeviceUser['user_id']
                );

                $this->dbcommon->insert('push_notified_users', $inno_data);
                $success_count++;
            }
            $arr_uni = array_unique($registration_ids);
            $response = $this->device_notification->sendMessageToAndroidPhone($API_KEY,$registration_ids,$messageArrayJson);
			$response = json_decode($response,true);
			
            if(!empty($registration_ids))
            {
                $output['response'] = $response;
                $output['success_count'] = (int)$response['success'];
                $output['failure_count'] = (int)$response['failure'];
                
            }            
        }
        echo json_encode($output);
        exit();
    }
	
	
	
    function get_username() {


        //$user_where = " is_delete=0 and status='active' and (first_name like '%$search%' or last_name like '%$search%') limit 10";

        $user_where = '';
        $search_wh = '';

        if ($this->input->get_post('q') != '')
            $search_wh .= ' and (first_name like "%' . $this->input->get_post('q') . '%" or last_name like "%' . $this->input->get_post('q') . '%"  )';
        $user_where .= " is_delete<>1 and status='active' and first_name <> '' and device_type in (0,1) and length(login_token)>0 " . $search_wh;
        $user_where .= ' limit 20';
        $user_data = $this->dbcommon->filter('user', $user_where);

        $userListArr = array();
        foreach ($user_data as $k => $value) {
            //if(!empty($value['first_name'])){
            $userListArr[$k]['id'] = $value['user_id'];
            $userListArr[$k]['name'] = $value['first_name'] . ' ' . $value['last_name'];
            //}
        }
        echo json_encode($userListArr);
    }

}

?>