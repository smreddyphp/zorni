<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Push_notifications {


        // For Driver from user

	public function send_android_notification($registration_ids, $data,$title){
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array (
		        'to' => $registration_ids,
		        'notification' => array (
		                "body" => $data['message'],
		                "title" => $title,
		                "icon" => "myicon",
                                "click_action" => "com.volive.intex.ontimedriverapp.activities.AcceptRequestDailogActivity"
		        ),
		        'data' => $data
		);
		$fields = json_encode ( $fields );
		$headers = array (
		        'Authorization: key=' . "AIzaSyCE4WXKea4TNpo87PNw8hbKdo8bd8vk5N4",
		        'Content-Type: application/json'
		);
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		//print_r($fields);exit;
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		return $result;
	}
	
	
	
        // Notification For User from driver

	public function send_android_notification_user($registration_ids, $data){
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array (
		        'to' => $registration_ids,
		        'notification' => array (
		                "body" => $data['message'],
		                "title" => $data['title'],
		                "type" => $data['type'],
		                "reciver_id" => $data['reciver_id'],
		                "click_action"=> $data['click_action']	
		        ),
		        'data' => array (
		        "body" => $data['message'],
		                "title" => $data['title'],
		                "reciver_id" => $data['reciver_id'],
		                "type" => $data['type'],
		                "click_action" => $data['click_action']		                
		        )
		);
		$fields = json_encode ( $fields );
		$headers = array (
		        'Authorization: key=' . "AAAACO2Pb2E:APA91bHzVkv-vMCa9qN4FuKrXLKaxF4D0gzBilguOZWIbJkOLD9AnC5uJzHyDF3pSMvc5nkj_5BUsul8qHwtEQnHj_5ggnvZuMrADXowR8YfMKuyCEdtyzw050ClLtZH5x-CCBcT7yOe",
		        'Content-Type: application/json'
		);
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		//print_r($fields);exit;
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		return $result;
	}
	



	
	// for user
	
	public function send_ios_notification($device_token,$data)
	{ 
	     
		 
		// Put your device token here (without spaces):

		$deviceToken = $device_token; // "ad8c467c949b9c99b0c32151069189206e1f7072a492889f2643e1eadcc25014";  //$_GET['token'];

		// Put your private key's passphrase here:
		$passphrase = 'volive@hyd';  // $_GET['pass'];

		// Put your alert message here:
		$message = 'Test Message only From Codeignter!';
		////////////////////////////////////////////////////////////////////////////////
        	//$pem_path=base_url()."public/uploads/";
		$ctx = stream_context_create();
		//stream_context_set_option($ctx, 'ssl', 'local_cert',"zorni_ios.pem");
		//stream_context_set_option($ctx, 'ssl', 'local_cert',"zorni_31_07_dev.pem");
		stream_context_set_option($ctx, 'ssl', 'local_cert',"zorni_31_07_dev.pem");
		stream_context_set_option($ctx, 'ssl', 'passphrase',$passphrase);
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (empty($fp))
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		$body['aps'] = array(
			'alert' => array(
			        'title' => 'Request from user',
             		'body' => $data['message'],              
	                'user_profile' => $data['user_profile'],
					'username' => $data['username'],
					'from_address' => $data['from_address'],
					'req_time' => $data['req_time'],
					'distance'=>$data['distance']		   	 
			 ),
			'sound' => 'default'
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);
		if (!$result)
			return 'Message not delivered' . PHP_EOL;
		else
			return 'Message Successfully delivered' . PHP_EOL;
	}



        // for driver
        public function send_ios_notification_driver($device_token, $data)
	{ 
	     
		 
		// Put your device token here (without spaces):

		$deviceToken = $device_token; // "ad8c467c949b9c99b0c32151069189206e1f7072a492889f2643e1eadcc25014";  //$_GET['token'];

		// Put your private key's passphrase here:
		$passphrase = 'volive@hyd';  // $_GET['pass'];

		// Put your alert message here:
		$message = 'Test Message only From Codeignter!';
		////////////////////////////////////////////////////////////////////////////////
        	//$pem_path=base_url()."public/uploads/";
		$ctx = stream_context_create();
		//stream_context_set_option($ctx, 'ssl', 'local_cert',"zorni_ios.pem");
		stream_context_set_option($ctx, 'ssl', 'local_cert',"zorni_31_07_dev.pem");
		//stream_context_set_option($ctx, 'ssl', 'local_cert',"ONTIME_DRIVER_DEV.pem");
		stream_context_set_option($ctx, 'ssl', 'passphrase',$passphrase);
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (empty($fp))
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		if(isset($data['is_cancel'])){
			$n_title = "Request cancelled";
		}else{
			$n_title = "Request from user";
		}
		$body['aps'] = array(
			'alert' => array(
			        'title' => $n_title,
             		        'body' => $data['message'],              
	                        'user_profile' => $data['user_profile'],
				'username' => $data['username'],
				'from_address' => $data['from_address'],
				'req_time' => $data['req_time'],
				'distance'=>$data['distance'],
				'trip_id' => $data['trip_id']		   	 
			 ),
			'sound' => 'default'
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);
		if (!$result)
			return 'Message not delivered' . PHP_EOL;
		else
			return 'Message Successfully delivered' . PHP_EOL;
	}
	
	public function send_iOS($data, $devicetoken) {
		$deviceToken = $devicetoken;
		$ctx = stream_context_create();
		// ck.pem is your certificate file
		$passphrase = 'volive@hyd';
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'zorni_31_07_dev.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', self::$passphrase);
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		$body['aps'] = array(
			'alert' => array(
			    'title' => $data['mtitle'],
                'body' => $data['mdesc'],
			 ),
			'sound' => 'default'
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);
		if (!$result)
			return 'Message not delivered' . PHP_EOL;
		else
			return 'Message successfully delivered' . PHP_EOL;
	}
	



}