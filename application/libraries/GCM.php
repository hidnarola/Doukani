<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GCM
 *
 * @author narola infotech
 */
 
 //$android_gcm_key = get_rehab_settings('android_gcm_key');
 //echo $android_gcm_key;
// include 'db.php';
class GCM {

    //put your code here
    // constructor
    function __construct() {
        
    }

    /**
     * Sending Push Notification
     */
    public function send_notification($API_KEY, $registatoin_ids, $message) {
        // include config
      //  include_once './config.php';
	
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
	$messageText = base64_encode($message);
	

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data'              => array('payload' => $messageText ),            
        );
        
         $headers = array(
            'Authorization: key='.$API_KEY,
            'Content-Type: application/json'
        );

        /*$headers = array(
           // 'Authorization: key=' . 'AIzaSyB3DkTfa3op4jh7VTw9s4bsk6iz9QzeLnc' 	,
            //'Authorization: key=' . 'AIzaSyCa6gCk_eEVlw7LSzH5chYkzmnYo0_s8u8' 	,
            'Authorization: key=' . GOOGLE_API_KEY	,           
            'Content-Type: application/json'
        );*/
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
	return $result;
    }

}

?>
