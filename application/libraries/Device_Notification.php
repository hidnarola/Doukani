<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Event for DX_Auth
// You can use DX_Auth_Event to extend DX_Auth to fullfil your needs
// For example: you can use event below to PM user when he already activated the account, etc.

class Device_Notification
{
    
    public function sendMessageToAndroidPhone($API_KEY, $registrationIds, $messageText) {

        $headers =array();
        $headers[] = "Content-Type: application/json";
        $headers[] = 'Authorization: key=' . $API_KEY;
        // $messageText = base64_encode($messageText);
        
        $data = array(
            'registration_ids' => $registrationIds,
            'data' => array('payload'=>$messageText) //TODO Add more params with just simple data instead
        );
        
        $data_string = json_encode($data); 
       
        $ch = curl_init();
		
        // curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");
        // curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        //curl_setopt($ch, CURLOPT_URL, "http://localhost/4sale/receive.php");
        if ($headers)
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        curl_setopt($ch, CURLOPT_POST, true);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    
        $response = curl_exec($ch);
    
        curl_close($ch);

        return $response;
    }
   
    function sendMessageToIPhones($deviceTokens=array(),$msg='',$url=''){    
        //$tokens=array('8a20664c0436ca9cc51a42af2362ee0f4e89ac21d0704d22df6757f65a900b47','5cbcf224c5abcff8515500372040907312a90d543bea255513da2747c1321355');

        // $deviceTokens   =   array();
        // $deviceTokens   =   array
        // (
        // '8a20664c0436ca9cc51a42af2362ee0f4e89ac21d0704d22df6757f65a900b47',
        // '5cbcf224c5abcff8515500372040907312a90d543bea255513da2747c1321355'
        // );
		//Put your device token here (without spaces):
        //print_r($deviceToken);
        $output		= '';
        
		// Put your private key's passphrase here:		
		$passphrase = 'password';
		$message 	= $msg;		
				
		$ctx = stream_context_create();
		//stream_context_set_option($ctx, 'ssl', 'local_cert',dirname(__FILE__).'/ck_pro_7.pem');  
		stream_context_set_option($ctx, 'ssl', 'local_cert',dirname(__FILE__).'/ck_Prod.pem');  
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		
        // Open a connection to the APNS server
        
        //$iosServer = 'ssl://gateway.sandbox.push.apple.com:2195';
        //$iosServer = 'ssl://gateway.sandbox.push.apple.com:2195';
        $iosServer = 'ssl://gateway.push.apple.com:2195';

  
            $fp = stream_socket_client($iosServer, $err, $errstr, 300, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
  
		 //$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 560, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		//$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
				
		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		
		// Create the payload body
		$body['aps'] = array(
			'alert' => $message,
			'sound' => 'default'
			);
		$body['url'] = $url;
		// Encode the payload as JSON
		//$payload = json_encode($body);
        //$payload =json_encode($body, JSON_UNESCAPED_UNICODE);
        $payload = $this->my_json_encode($body);	

        foreach($deviceTokens as $dt){
            
            $deviceToken = $dt;	   
    		// Build the binary notification
			error_reporting(0);
    		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;    			
    		// Send it to the server
    		$result = fwrite($fp, $msg, strlen($msg));
    		//$file = fopen("output.txt","w");
     		//fwrite($file,$msg);
     
    		if (!$result){

                    $output.=$deviceToken.",";
                }
    		else{                    
                    $output.=$result.'<br>';
                }
            //die($output.'--');
		}
                
		// Close the connection to the server
		fclose($fp);
                
                //echo $output;
                
            return $output;
	}
	
	
	
	
	public function my_json_encode($arr)
	{
        //convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). So such characters are being "hidden" from normal json_encoding
        array_walk_recursive($arr, function (&$item, $key) { if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); });
        return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');

	}
}

?>