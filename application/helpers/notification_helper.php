<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	function send_notification_android($registration_ids, $data)
	{	
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array (
		        'to' => $registration_ids,
		        'notification' => array (
		         "body" => $data['message'],
		         "message" => $data['message'],
		          "title" => $data['title']
		        )
		);

	/*	$fields = array(
    		'to'  => $registration_ids,
    		'notification' => $data,
    		'title' => $data
    	);*/
		
		$fields = json_encode ($fields);
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
		$result = curl_exec ($ch);
		curl_close ( $ch );
		return $result;
	}
	

	function send_notification_ios_new($device_token, $data)
	{ 
	     $deviceToken = $device_token; // "ad8c467c949b9c99b0c32151069189206e1f7072a492889f2643e1eadcc25014";  //$_GET['token'];

        // Put your private key's passphrase here:
        $passphrase = 'volive@hyd';  // $_GET['pass'];

        // Put your alert message here:
        $message = 'Test Message only From Codeignter!';
        ///////////////////////////////// HawlikNewPushDevelopment.pem//////////HawlikNewPushDistribution.pem//////////////////
       //$pem_path=base_url()."public/uploads/";
        $ctx = stream_context_create();
          stream_context_set_option($ctx, 'ssl', 'local_cert', "ZorniDistr.pem");
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        if (empty($fp))
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
          $body['aps'] = array(
    		'badge' => +1,
    		'alert' => array(
			    'title' => $data['title'],
                'body' => $data['message'],
			 ), 
    		'info' => $data,
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
//naresh

	function send_notification_ios($ids,$data){

      //$apnsCert = APPPATH.'libraries/Varlet.pem'; // development

      $passphrase = 'volive@hyd';// development

      //$passphrase = "suman@123"; // Production

        //device token

        $deviceToken = $ids;

        //Message will send to ios device

       

        $ctx = stream_context_create();

        //stream_context_set_option($ctx, 'ssl', 'local_cert', "zorni_31_07_dev.pem"); //development
        
        //stream_context_set_option($ctx, 'ssl', 'local_cert', "ZorniDev.pem"); //development
        stream_context_set_option($ctx, 'ssl', 'local_cert', "ZorniDistr.pem");
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

     // $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx); // development

     $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);  // production

        // Create the payload body
        
        

        $body['aps'] = array(
    		'badge' => +1,
    		'alert' => array(
			    'title' => $data['title'],
                'body' => $data['message'],
			 ), 
    		'info' => $data,
    		'sound' => 'default'
    	);
        $payload = json_encode($body);

        // Build the binary notification

        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server

        $result = fwrite($fp, $msg, strlen($msg));
 

        if (!$result){

          return 'Message not delivered' . PHP_EOL;

        } else{ 

          return 'Message successfully delivered'. PHP_EOL;

         } 

        // Close the connection to the server

        fclose($fp);

    }

