<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

//include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Services extends REST_Controller 
{

    public function __construct() 
    { 
        parent::__construct();
        $this->load->helper("notification_helper");
        $this->load->library('push_notifications');                  
    }  

    public function check_user_login_post()
    {        
        $userData = array();
        $userData['email'] = $this->input->post('email');
        $userData['password'] = md5($this->input->post('password'));
        $data['device_type'] = $this->input->post('device_type');
        $data['device_token'] = $this->input->post('device_token');
        $lang = $this->input->post('lang');
        $result = $this->users_model->check_user_credintials($userData);
        if($result)
        {
           $data1 = $this->db->get_where('users',array('email' => $userData['email']))->row();
            
            if($data1->auth_level == 1 || $data1->auth_level ==2)
            {
            	if($data1->status == 1)
            	{
            	   $user_id = $this->users_model->get_user_details($userData['email'])->user_id;
            	   $result = $this->users_model->user_update_profile($data,$user_id);            	  
                    $data2 = $this->db->get_where('users',array('email' => $userData['email']))->row();
                    if($lang=='ar')
                    {
                      
	               $message = 'تم تسجيل الدخول بنجاح';
                    }
                    else
                    {
                      $message = 'login Success';
                    }
            	   $json = $this->response(['user'=>$data2,
                    'status' => TRUE,                   
                    'message' =>$message
                    ], REST_Controller::HTTP_OK);
            	
            	}            	
            	else
            	{            	
            	    if($lang=='ar')
                    {
			         $message = 'تم حظر حسابك';
                    }
                    else
                    {                     
		              $message = 'You are Acount Was Blocked';
                    }
            	    $json = $this->response([
                   'status' => FALSE,
                   'message' => $message ,'package_key'=>1                  
                    ], REST_Controller::HTTP_BAD_REQUEST);
            	}
            	
            }
            else if($data1->auth_level == 4)
            {
            	if($data1->status == 1)
            	{
            		 $data2 = $this->db->get_where('users',array('email' => $userData['email']))->row();
            		if($data1->package_expire_date >= date('Y-m-d')) 
            		{
            			$user_id = $this->users_model->get_user_details($userData['email'])->user_id;
	            	    $result = $this->users_model->user_update_profile($data,$user_id);      	  
	                   
	                    if($lang=='ar')
	                    {	                      
		              	 $message = 'تم تسجيل الدخول بنجاح';
	                    }
	                    else
	                    {
	                      $message = 'login Success';
	                    }
	            	   $json = $this->response(['user'=>$data2,
	                    'status' => TRUE,                   
	                    'message' =>$message
	                    ], REST_Controller::HTTP_OK);
            		
	            	}
	            	else
	            	{
	            		if($lang=='ar')
		                {                     
		                  $message ='انتهت الحزمة الخاصة بك';
		                }
		                else
		                {
		                    $message = 'Your Package Was Expired';
		                }
		                $json = $this->response(['user'=>$data2,
		                    'status' => FALSE,
		                    'message' =>$message,'package_key'=>0               
		                ], REST_Controller::HTTP_BAD_REQUEST);
	            	}
            	}            	
            	else
            	{            	
            	    if($lang=='ar')
                    {
			         $message = 'تم حظر حسابك';
                    }
                    else
                    {                     
		              $message = 'You are Acount Was Blocked';
                    }
            	    $json = $this->response([
                   'status' => FALSE,
                   'message' => $message,'package_key'=>1                   
                    ], REST_Controller::HTTP_BAD_REQUEST);
            	}       		
            }
            else
            {
                if($lang=='ar')
                {                     
                  $message = 'أنت غير مسجل هنا';
                }
                else
                {
                    $message = 'You are Not Logged In Here';
                }
                $json = $this->response([
                    'status' => FALSE,
                    'message' =>$message,'package_key'=>1                
                ], REST_Controller::HTTP_BAD_REQUEST);
            }            
        }
        else
        {
          	    if($lang=='ar')
                {
                    $message = 'بيانات اعتماد تسجيل الدخول غير صحيحة';
                }
                else
                {                     
		            $message = 'Incorrect Login Credintials.';
                }

              $json = $this->response([
                'status' => FALSE,
                'message' => $message,'package_key'=>1
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        echo json_encode($json);
    }
    
    public function registration_post($auth_level)
    {
        
        if($auth_level == 1)
        {
            $userData = array();
            $userData['username'] = $this->post('username');            
            $userData['age'] = $this->post('age');
            $userData['gender'] = $this->post('gender');
            $userData['email'] = $this->post('email');
            $userData['password'] = md5($this->post('password'));
            $userData['mobile'] = $this->post('mobile');
            $userData['device_type'] = $this->input->post('device_type');
            $userData['device_token'] = $this->input->post('device_token');
            $lang = $this->input->post('lang');
            $userData['auth_level'] = $auth_level;          
            $userData['role']  = "user";
            $userData['status']  = "1";
            $check_email_existence = $this->users_model->check_email_exists($userData['email']);
            if($check_email_existence)
            {
                $register = $this->users_model->user_registration($userData);
                if($register)
                {
                    $data = $this->db->get_where('users',array('email' => $userData['email']))->row();
                    if($lang=='ar')
                    {
                     
                        $message = 'تم التسجيل بنجاح';
                    }
                    else
                    {
                     $message = 'successfully Registered';
                    }
                    $this->response(['user_data'=>$data,
                        'status' => TRUE,
                        'message' =>$message
                    ], REST_Controller::HTTP_OK);
                }
                else
                {                    
                    if($lang=='ar')
                    {
                     $message = 'حدثت بعض المشاكل ، يرجى المحاولة مرة أخرى';
                    }
                    else
                    {                     
			             $message = 'Some problem occurred, please try again.';
                    }
                    $this->response([
                    'message'=>$message], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else
            {
            	   if($lang=='ar')
                    {                     
					 $message = 'البريد الألكتروني مستخدم مسبقاَ';
                    }
                    else
                    {
                     $message = 'Your Email Id Is Already Exists.';
                    }
                $this->response([
                'message'=>$message], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        else if ($auth_level == 2) 
        {
            
        	$config['upload_path']          = "images/";
            $config['allowed_types']        = '*';            
            $config['max_size'] 			= 1024 * 80;
            $config['file_name'] 			= "profile".time();

            $this->load->library('upload', $config);

            if( ! $this->upload->do_upload('professional_license'))
            {
              $data= array('error' => $this->upload->display_errors());
                    
            }
            else
            {
               $data = array('upload_data' => $this->upload->data());
            }
                                
            $userData = array();
            $userData['username'] = $this->post('username');
            $userData['location'] = $this->post('location');
            $userData['city'] = $this->post('city');
            $userData['doctor_speciality'] = $this->post('doctor_speciality');            
            $userData['professional_license'] = $data['upload_data']['file_name'];
            $userData['email'] = $this->post('email');
            $userData['lat'] = $this->post('lat');
            $userData['lon'] = $this->post('lon');
            $userData['password'] = md5($this->post('password'));
            $userData['mobile'] = $this->post('mobile');
            $lang = $this->input->post('lang');
            $userData['auth_level'] = $auth_level;
            $userData['role']  = "doctor";
            $check_email_existence = $this->users_model->check_email_exists($userData['email']);
            if($check_email_existence)
            {
                $register = $this->users_model->user_registration($userData);
                if($register)
                {
                    $data = $this->db->get_where('users',array('email' => $userData['email']))->row();
                    if($lang=='ar')
                    {
                     	$message = 'تم تسجيلك بنجاح سيتم أرسال رسالة تأكيد عند';
                    }
                    else
                    {                     
						$message = 'Successfully Registered When Admin Approved Your Request You Will Get Confirmation Mail';
                    }
               
                    $this->response(['user_data'=>$data,
                        'status' => TRUE,
                        'message' =>$message
                    ], REST_Controller::HTTP_OK);
                }
                else
                {
                    //set the response and exit
                     if($lang=='ar')
                    {
                     $message = 'حدثت بعض المشاكل ، يرجى المحاولة مرة أخرى';
                    }
                    else
                    {
			         $message = 'Some problem occurred, please try again.';
                    }
                    $this->response([
                    'message'=>$message], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else
            {
                   if($lang=='ar')
                    {
                     $message = 'البريد الألكتروني مستخدم مسبقاَ';
                    }
                    else
                    {                     
			 $message = 'Your Email Id Is Already Exists.';
                    }
                $this->response([
                'message'=>$message], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        else if ($auth_level == 3) 
        {
            $userData = array();
            $userData['clinic_name'] = $this->post('clinic_name');            
            $userData['clinic_manager_name'] = $this->post('clinic_manager_name');
            $userData['clinic_number'] = $this->post('clinic_number');
            $userData['location'] = $this->post('location');  
            $userData['city'] = $this->post('city');
            $userData['lat'] = $this->post('lat');
            $userData['lon'] = $this->post('lon');     
            $userData['provided_services'] = $this->post('provided_services');
            $userData['accepted_insurance'] = $this->post('accepted_insurance');
            $userData['email'] = $this->post('email');
            $userData['password'] = md5($this->post('password'));
            $lang = $this->input->post('lang');
            $userData['mobile'] = $this->post('mobile');
            $userData['auth_level'] = $auth_level;
            $userData['role']  = "clinic";
            $check_email_existence = $this->users_model->check_email_exists($userData['email']);
            if($check_email_existence)
            {
                $register = $this->users_model->user_registration($userData);
                if($register)
                {
                    $data = $this->db->get_where('users',array('email' => $userData['email']))->row();
                    if($lang=='ar')
                    {
                     	$message = 'تم تسجيلك بنجاح سيتم أرسال رسالة تأكيد عند';
                    }
                    else
                    {                     
			 			$message = 'Successfully Registered When Admin Approved Your Request You Will Get Confirmation Mail';
                    }
               
                    $this->response(['user_data'=>$data,
                        'status' => TRUE,
                        'message' =>$message
                    ], REST_Controller::HTTP_OK);
                }
                else
                {
                    //set the response and exit
                     if($lang=='ar')
                    {
                    	 $message = 'حدثت بعض المشاكل ، يرجى المحاولة مرة أخرى';
                    }
                    else
                    {                     
						$message = 'Some problem occurred, please try again.';
                    }
                    $this->response([
                    'message'=>$message], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else
            {
                    if($lang=='ar')
                    {
                    	 $message = 'البريد الألكتروني مستخدم مسبقاَ';
                    }
                    else
                    {                     
			 			$message = 'Your Email Id Is Already Exists.';
                    }
                $this->response([
                'message'=>$message], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        else if ($auth_level == 4)
        {
            $config['upload_path']          = "idcards/";
            $config['allowed_types']        = '*';            
            $config['max_size'] 			= 1024 * 80;
            $config['file_name'] 			= "idcards".time();

            $this->load->library('upload', $config);

            if( ! $this->upload->do_upload('id_card'))
            {
              $data= array('error' => $this->upload->display_errors());
                    
            }
            else
            {
               $data = array('upload_data' => $this->upload->data());
            }
            
            $userData = array();
            $userData['username'] = $this->post('username');        
            $userData['location'] = $this->post('location');
            $userData['city'] = $this->post('city');
            $userData['lat'] = $this->post('lat');
            $userData['lon'] = $this->post('lon');        
            $userData['hospital_name'] = $this->post('hospital_name');
            //$userData['dentals'] = $this->post('dentals');
            $userData['email'] = $this->post('email');
            $userData['password'] = md5($this->post('password'));
            $userData['mobile'] = $this->post('mobile');
            $userData['auth_level'] = $auth_level;
            $userData['role']  = "free_dental";           
            $lang = $this->input->post('lang');
            $userData['id_card'] = $data['upload_data']['file_name'];
            $userData['package_id'] = $this->post('package_id');
            $userData['package_buy_date'] = date('Y-m-d');
            $userData['package_price'] = $this->post('package_price');
            if($this->post('payment_id')){
             $userData['payment_id'] = $this->post('payment_id');
            }            
            $package_id = $userData['package_id'];
            $package_details = $this->db->query("select * from packages where id =$package_id")->row();
           $months = $package_details->months." "."months";
           $userData['package_expire_date'] = date('Y-m-d',strtotime("+ $months", strtotime($userData['package_buy_date'])));
            $check_email_existence = $this->users_model->check_email_exists($userData['email']);
            if($check_email_existence)
            {
                $register = $this->users_model->user_registration($userData);
                if($register)
                {
                    $data = $this->db->get_where('users',array('email' => $userData['email']))->row();
                    if($lang=='ar')
                    {
                        $message = 'تم تسجيلك بنجاح سيتم أرسال رسالة تأكيد عند';
                    }
                    else
                    {                     
			            $message = 'Successfully Registered When Admin Approved Your Request You Will Get Confirmation Mail';
                    }
               
                    $this->response(['user_data'=>$data,
                        'status' => TRUE,
                        'message' =>$message
                    ], REST_Controller::HTTP_OK);
                }
                else
                {
                    //set the response and exit
                    if($lang=='ar')
                    {
                     $message = 'حدثت بعض المشاكل ، يرجى المحاولة مرة أخرى';
                    }
                    else
                    {                     
					 $message = 'Some problem occurred, please try again.';
                    }
                    $this->response([
                    'message'=>$message], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else
            {
                    if($lang=='ar')
                    {
                        $message = 'البريد الألكتروني مستخدم مسبقاَ';
                    }
                    else
                    {                     
			            $message = 'Your Email Id Is Already Exists.';
                    }
                $this->response([
                'message'=>$message], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    
    public function change_password_post()
    {
    	
    	$user_id = $this->post('user_id');
    	$current_password = md5($this->post('currentpassword'));
    	$new_pwd = md5($this->post('newpassword'));
    	$result = $this->users_model->view_profile($user_id);
    	$email = $result->email;
         $lang = $this->input->post('lang');
    	if($result->password == $current_password)
    	{
    		$update = $this->users_model->update_password($email,$new_pwd);
    		    
    		if($update)
    		{
    		     if($lang=='ar')
                    {
                     $message = 'تم تحديث كلمة المرور بنجاح';
                    }
                    else
                    {                     
					 $message = 'Password Updated Successfully';
                    }
    			$json = $this->response([
    			'status'=>TRUE,
    			'message'=>$message
    			], REST_Controller::HTTP_OK);
    		}
    		else
    		{
    		    if($lang=='ar')
                    {
			$message = 'غير قادر على تحديث كلمة المرور';                     
                    }
                    else
                    {
                     $message = 'Unable to Update Password';
                    }
    			$json = $this->response([
    			'status'=>False,
    			'message'=>$message
    			], REST_Controller::HTTP_BAD_REQUEST);
    		}
    	}
    	else
    	{
    	 	        if($lang == 'ar')
                    {
                     $message = 'كلمة المرور الحالية خاطئة';
                    }
                    else
                    {
			        $message = 'Incorrect Current Password';
                    }
    	  
    		$json = $this->response(['status'=>False,'message'=>$message
    		], REST_Controller::HTTP_BAD_REQUEST);
    	}
    	echo json_encode($json);
    }
    
    public function user_get($auth_level,$user_id = '',$user = '',$lang='')
    {   
        $users = $this->users_model->get_users($auth_level,$user_id);
        
        if(!empty($users))
        {
        	       	
        	if(!empty($user_id) && $auth_level==3)
        	{       		
        	        $tweets = $this->users_model->count_tweets($user_id);
        	        if(!empty($user))
        	        {
        	          $data = array('user_id'=>$user,'following_id'=>$user_id);
        	          $users['following_status'] = $this->users_model->chack_following_status($data);        	          
        	        }
        	        
        	        if(!empty($user))
        	        {        	        	
        	          $data = array('user_id'=>$user,'rater_id'=>$user_id);
        	          $users['rating_status'] = $this->users_model->chack_following_status($data);        	          
        	        }       	               	             	            	        
        	        $p_services = $users['provided_services'];
        		if($lang == "ar")
        		{
        		    $services = $this->db->query("select id,service_name_ar as service_name,icon from provided_services where id in ($p_services) and status = 1")->result();
        		    
        		}
        		else
        		{
        		    $services = $this->db->query("select id,service_name,icon from provided_services where id in ($p_services) and status = 1")->result();
        		    
        		}
        		
        		$users['tweets'] = $tweets->total_tweets;
        		$ratings = $this->users_model->avg_ratings($user_id)->rating;
        		$users['rating'] =number_format((float)$ratings, 1, '.', '');
        	/*
        		if($users['rating'] == null)
        		{
        		   $users['rating'] = "";
        		}*/
        		$insurance = $users['accepted_insurance']; 
        		if($lang=='ar')
            	{
            	   $insurances = $this->db->query("select id,insurance_name_ar as insurance_name from accepted_insurances where id in ($insurance) and status=1")->result();
            	}
            	else
            	{
                   
            	   $insurances = $this->db->query("select id,insurance_name from accepted_insurances where id in ($insurance) and status=1")->result();
            	
            	}
         		$json = $this->response(['status'=>TRUE,'clinics'=>$users,'services'=>$services,'insurances'=>$insurances], REST_Controller::HTTP_OK);
        	}
        	else if(!empty($user_id) && $auth_level==2)
        	{
        		if(!empty($user))
        	        {
        	          $data = array('user_id'=>$user,'following_id'=>$user_id);
        	          $users['following_status'] = $this->users_model->chack_following_status($data);        	          
        	        }
        	        
        	        if(!empty($user))
        	        {
        	          $data = array('user_id'=>$user,'rater_id'=>$user_id);
        	          $users['rating_status'] = $this->users_model->chack_following_status($data);        	          
        	        }
        		$tweets = $this->users_model->count_tweets($user_id);
        		$ratings = $this->users_model->avg_ratings($user_id)->rating;
        		$users['rating'] =number_format((float)$ratings, 1, '.', '');
        		/*if($users['rating'] == null)
        		{
        		   $users['rating'] = "";
        		}*/
        		$users['tweets'] = $tweets->total_tweets;
        		
        		if($lang=='ar')
        		{
        		    $serv_id = $users['doctor_speciality'];
        		    $service = $this->db->query("select service_name_ar as service_name,icon from provided_services where id=$serv_id")->row();
        		}
        		else
        		{
        		     $serv_id = $users['doctor_speciality'];
        		    $service = $this->db->query("select service_name,icon from provided_services where id=$serv_id")->row();
        		}
        		$json = $this->response(['status'=>TRUE,'doctors'=>$users,'doctor_speciality'=>$service], REST_Controller::HTTP_OK);
        	}
        	else if(!empty($user_id) && $auth_level == 4)
        	{
        	    
        		if(!empty($user))
        	        {
        	          $data = array('user_id'=>$user,'following_id'=>$user_id);
        	          $users['following_status'] = $this->users_model->chack_following_status($data);        	          
        	        }
        	        
        	        if(!empty($user))
        	        {
        	          $data = array('user_id'=>$user,'rater_id'=>$user_id);
        	          $users['rating_status'] = $this->users_model->chack_following_status($data);        	          
        	        }
        	        
        	        if(!empty($user))
        	        {   
        	          $check = $this->db->query("select count(user_id) as rowcount from appointments where booking_id ='".$user_id."' and user_id= '".$user."' and auth_level = 4")->row()->rowcount;   	          
        	          
        	          if($check == 0)
        	          {
        	              $users['appointment_status'] = '3';
        	          }
        	          else
        	          {
        	           $status  = $this->users_model->free_dental_appointment_status($user_id,$user)->status;
        	             $users['appointment_status'] = $status;
        	          }       	          
        	        }
        	        
        		$tweets = $this->users_model->count_tweets($user_id);
        		$ratings = $this->users_model->avg_ratings($user_id)->rating;
        		$users['rating'] =number_format((float)$ratings, 1, '.', '');
        	/*	if($users['rating'] == null)
        		{
        		   $users['rating'] = "";
        		}*/
        		$users['tweets'] = $tweets->total_tweets;
        		//$service = $this->clinics_model->get_service_name_by_id($users['doctor_speciality']);
        		$json = $this->response(['status'=>TRUE,'free_dentals'=>$users], REST_Controller::HTTP_OK);
        		
        	} 
        	else
        	{
        	        $offers = $this->users_model->offers($auth_level);
        		$services = $this->admin_model->get_provided_services();
        		$json = $this->response(['status'=>TRUE,'clinics'=>$users,'Providing_services'=>$services,'offers'=>$offers], REST_Controller::HTTP_OK);
        	}           
        }
        else
        {  
					if($lang='ar')
                    {
                     
                      $message = 'لايوجد بيانات';
                    }
                    else
                    {
                     $message = 'No Data found';
                    }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        echo json_encode($json);
    }
    
    public function forgot_password_post()
    {
        $email = $this->post('email');
        $lang = $this->input->post('lang');
        $result = $this->users_model->check_email_exists($email);
        
        if($result)
        {
                    if($lang=='ar')
                    {
                     $message = 'معرف البريد الإلكتروني غير صالح';
                    }
                    else
                    {                     
			$message = 'Invalid Email Id';
                    }
            $json = $this->response([
                'status' => FALSE,
                'message' => $message
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        else
        {
            $send_pwd  = mt_rand(10000000,99999999);
             $new_pwd= md5($send_pwd);
            $result = $this->users_model->update_password($email,$new_pwd);
            if($result)
            {
                $this->email->from('zorni@volive.com', 'zorni');
                $this->email->to($email);           
	            $this->email->subject('Zorni Password Recovery');
	            $this->email->message('Your New Password Is '.$send_pwd.'');            
	            $email = $this->email->send();
	            if($email)
	            {
                       if($lang=='ar')
                       {
                          $message = 'تم أرسال كلمو المرور بنجاح على البريد الألكتروني';
                        }
                        else
                        {                          
				$message = 'Password Successfully Sent to Your Email Id.';
                        }
	                $json = $this->response([
	                        'status' => TRUE,
	                        'message' =>$message
	                    ], REST_Controller::HTTP_OK);
	            }
	            else
	            {
                       if($lang=='ar')
                       {
                          $message = 'يرجى المحاولة مرة أخرى';
                        }
                        else
                        {                          
			   $message = 'Please Try Again.';
                         }
	                $json = $this->response([
	                        'status' => FALSE,
	                        'message' =>$message
	                    ], REST_Controller::HTTP_NOT_FOUND);	            
	            }
            }
            else
            {
                       if($lang=='ar')
                       {
                          $message = 'حدثت بعض المشاكل ، يرجى المحاولة مرة أخرى';
                        }
                        else
                        {                          
				$message = 'Some problem occurred, please try again';
                         }
                $json = $this->response([
                    'status' => FALSE,
                    'message'=>$message
                ], REST_Controller::HTTP_NOT_FOUND);
            }
            
        }
            echo json_encode($json);
    }
    
    public function provided_services_accepted_insurances_get($lang='')
    {
    	
    	if($lang=='ar')
    	{
    	   $services = $this->db->query('select id,service_name_ar as service_name from provided_services where status=1')->result();
    	   $insurances = $this->db->query('select id,insurance_name_ar as insurance_name from accepted_insurances where status=1')->result();
		   
    	}
    	else
    	{
           $services = $this->db->query('select id,service_name from provided_services where status=1')->result();
    	   $insurances = $this->db->query('select id,insurance_name from accepted_insurances where status=1')->result();
    	
    	}
    	
    	
    	if(!empty($services) && !empty($insurances))
        {
            $json = $this->response(['status'=>TRUE,'services_names_ar_en'=>$services ,'insurances_names_ar_en'=>$insurances], REST_Controller::HTTP_OK);
        }
        else
        {
                        if($lang=='ar')
                        {
                          $message = 'لايوجد بيانات';
                        }
                        else
                        {                          
			              $message = 'No data found';
                         }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        echo json_encode($json);
    }
    
    public function offers_get($lang='')
    {
    	$offers = $this->users_model->offers();
    	if(!empty($offers ))
        {
            $json = $this->response(['status'=>TRUE,'offers_list'=>$offers], REST_Controller::HTTP_OK);
        }
        else
        {
                        if($lang == 'ar')
                        {
                          
                          $message = 'لايوجد بيانات';
                        }
                        else
                        {
                          $message = 'No data found';
                         }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        echo json_encode($json);
    }
    
    public function user_follow_post()
    {
    	$data['user_id'] = $this->post('user_id');
    	$data['following_id'] = $this->post('following_id');
    	$data['date'] = date("Y-m-d H:i:s");
        $lang = $this->input->post('lang');
    	$result = $this->users_model->follow($data);
    	if($result)
    	{
	            if($lang=='ar')
                {
                  $message = 'المضافين';
                }
                else
                {                          
                    $message = 'Following';
                }
              $json = $this->response(['status'=>TRUE,
    		'message'=>$message
    		], REST_Controller::HTTP_OK);
    	}
    	else
    	{
	            if($lang=='ar')
                {
                  $message = 'غير قادر على المتابعة';
                }
                else
                {                          
                   $message = 'Uable to follow';
                }
                $json = $this->response(['status'=>FALSE,
    		'message'=>$message
    		], REST_Controller::HTTP_NOT_FOUND);
    	}
    	        echo json_encode($json);
    }
    
   /* public function user_give_ratings_post()
    {
    	$data['user_id'] = $this->post('user_id');
    	$data['rater_id'] = $this->post('rater_id');
    	$data['ratings'] = $this->post('ratings');
         $lang = $this->input->post('lang');
    	$data['date'] = date("Y-m-d H:i:s");
    	$result = $this->users_model->follow($data);
    	if($result)
    	{
		    if($lang=='ar')
			{
			 $message = 'تم التقديم بنجاح';
			}
			else
			{
			 $message = 'Successfully Submitted';
			}
    		$json = $this->response(['status'=>TRUE,
    		'message'=>$message
    		], REST_Controller::HTTP_OK);
    	}
    	else
    	{

                    if($lang=='ar')
                    {
                     $message = 'غير قادر على التقديم';
                    }
                    else
                    {                     
			 $message = 'Unable to Submitted';
                    }
    		$json = $this->response(['status'=>FALSE,
    		'message'=>$message
    		], REST_Controller::HTTP_NOT_FOUND);
    	}
    	        echo json_encode($json);
    }*/
    
    public function user_unfollow_post()
    {
    	$data['user_id'] = $this->post('user_id');
    	$data['following_id'] = $this->post('following_id');
         $lang = $this->input->post('lang');
    	$result = $this->users_model->unfollow($data);
    	if($result)
    	{ 
                    if($lang=='ar')
                    {
                     $message = 'ألغاء المتابعة';
                    }
                    else
                    {                     
			$message = 'Unfollow';
                    }
    		$json = $this->response(['status'=>TRUE,
    		'message'=>$message
    		], REST_Controller::HTTP_OK);
    	}
    	else
    	{
    		        if($lang=='ar')
                    {
                         $message = 'غير قادر على ألغاء المتابعة';
                    }
                    else
                    {
			            $message = 'Faild to Unfollow';
                    }
                 $json = $this->response(['status'=>FALSE,
    		'message'=>$message
    		], REST_Controller::HTTP_NOT_FOUND);
    	}
    	  echo json_encode($json);
    }
    
    public function get_user_following_get($user_id,$lang='')
    {
    	$followeing = $this->users_model->user_following($user_id);
    	if(!empty($followeing))
        {
            $json = $this->response(['status'=>TRUE,
            'following_list'=>$followeing], REST_Controller::HTTP_OK);
        }
        else
        {
                       if($lang=='ar')
                        {
                           $message = 'لايوجد بيانات';
                        }
                        else
                        {                         
			                $message = 'No data found';
                         }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    	
    	echo json_encode($json);
    }
    
     public function get_category_wise_doctors_get($lang = '')
     {   
        $servicesid = $this->db->query("select distinct(doctor_speciality) from users where auth_level= 2 and status=1")->result_array();
        $ids = '';
        foreach($servicesid  as $serviceid)
        {          
            $ids .= $serviceid['doctor_speciality'] . ',';          
        }        
      $id = rtrim($ids,','); 
        if($lang =='ar')
    	{
    	    $services  = $this->db->query("select id,service_name_ar as service_name,icon,status,doc from provided_services where id in($id) and status != 2")->result_array();
    	}
    	else
    	{
    	    $services  = $this->db->query("select id,service_name,icon,status,doc from provided_services where id in($id) and status != 2")->result_array();    	   
    	}   	
            
        $count = 0; 
        foreach($services as $service)
        {
                       $user_id = '';
		       $id = $service['id'];		
		
		$json = $this->users_model->get_provided_services_wise_doctors($id);
        
		$services[$count]['doctor'] = $json;
		 // echo $json[0]['ratings'];
		  
		 $count1 =0;
		 foreach($json as $row)
		 {
		      $services[$count]['doctor'][$count1]['ratings']=number_format((float)$json[$count1]['ratings'], 1, '.', ''); //($json[$count1]['ratings'])?$json[$count1]['ratings']:'';
		    $count1++;
		 }
    		if(!empty($json[0]['user_id']))
    		{
    		   $user_id = $json[0]['user_id'];
    		 
    		}
    		$offers = $this->users_model->get_offers($user_id);
    		$services[$count]['offers']= ($offers)?$offers:'';
    		$count++;
        }
        
        if(!empty($services))
    	{
    	   
    		$json = $this->response(['status'=>TRUE,'doctors_list'=>$services], REST_Controller::HTTP_OK);
    	}
    	else
    	{
			            if($lang=='ar')
                        {
                          $message = 'لايوجد بيانات';
                        }
                        else
                        {                          
			              $message = 'No data found';
                        }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
    	}        
			echo json_encode($json);
    }   
    
    public function book_appointment_post()
    {
    	$userData['user_id'] = $this->post('user_id');
    	$userData['booking_id'] = $this->post('booking_id');
    	$userData['name'] = $this->post('name');
    	$userData['customer_age'] = $this->post('customer_age');
    	$userData['customer_gender'] = $this->post('customer_gender');
    	$userData['date'] = $this->post('date');
    	$userData['time'] = $this->post('time');
    	$userData['mobile'] = $this->post('mobile');
    	$userData['service'] = $this->post('service');    	    	
    	$userData['auth_level'] = $this->post('auth_level');
    	 $doctor_name = $this->post('doctor_name');
    	 $insurance = $this->post('insurance');
    	if(!empty($doctor_name))
    	{
    	    $userData['doctor_name'] = $doctor_name;
    	}
    	if(!empty($insurance))
    	{
    	    $userData['insurance'] = $insurance;
    	}
    	    $b= date('Y-m-d');
            $a= date('h:m:s a');
	        $userData['booking_time']=$b." ".$a;
        $lang = $this->input->post('lang');
    	$result = $this->users_model->user_book_appointment($userData);
    	if($result)
    	{
                        if($lang=='ar')
                        {
                          $message = 'تم حجز المواعيد';
                        }
                        else
                        { 
			               $message = 'Appointment Booked';
                        }
    	   $json = $this->response(['status'=>TRUE,'message'=>$message], REST_Controller::HTTP_OK);
    	}
    	else
    	{
                        if($lang=='ar')
                        {
                          $message = 'غير قادر على حجز الموعد';
                        }
                        else
                        {                          
			               $message = 'Unable to Book your appointment';
                         }
    	   $json = $this->response(['status'=>FALSE,
    	   'message'=>$message
    	   ], REST_Controller::HTTP_NOT_FOUND);
    	}
    	echo json_encode($json);
    }
    
    public function get_clinic_doctors_based_on_service_get($clinic_id,$service_id,$lang='')
    {
    	if($clinic_id !="" && $service_id !="")
    	{
    		if($lang == 'ar'){

	          $doctors = $this->clinics_model->get_service_wise_doctors($clinic_id,$service_id,$lang);
	        }else{

	         $doctors = $this->clinics_model->get_service_wise_doctors($clinic_id,$service_id);
	       }
	
			if(!empty($doctors))
			{
				$json = $this->response(['status'=>TRUE,'doctors'=>$doctors],REST_Controller::HTTP_OK);
			}
			else
			{
					if($lang=='ar')
					{
					   $message = 'لايوجد بيانات';
					}
					else
					{                         
		   			   $message = 'No data found';
					}
					 
					$json = $this->response([
						'status' => FALSE,
						'message' =>$message
					], REST_Controller::HTTP_NOT_FOUND);
			}

    	}
    	else
    	{
				if($lang=='ar')
                {
                  $message = 'قيم المعلمات المفقودة';
                }
                else
                {                          
	               $message = 'Missing Parameter Values';
                }
	          $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
    	}
		    
		echo json_encode($json);    
    }
    
    public function get_tweets_get($user_id,$lang='')
    {
    	if($user_id != "")
    	{
    		$tweets = $this->users_model->get_user_tweets($user_id);
	    	if(!empty($tweets))
	    	{
	    		$json = $this->response(['status'=>TRUE,'tweets'=>$tweets],REST_Controller::HTTP_OK);
	    	}
	    	else
	    	{
				if($lang=='ar')
	            {
	              $message = 'لايوجد بيانات';
	            }
	            else
	            {                          
					$message = 'No data found';
	            }
	            $json = $this->response([
	                'status' => FALSE,
	                'message' =>$message
	            ], REST_Controller::HTTP_NOT_FOUND);
	    	}
    	}
    	else
    	{
				if($lang=='ar')
	            {
	              $message = 'قيم المعلمات المفقودة';
	            }
	            else
	            {                          
	               $message = 'Missing Parameter Values';
	            }
	           $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
    	}
    	
    	echo json_encode($json);
    }
    
    public function user_update_profile_post()
    {
       $userData['username'] = $this->post('username');
       $userData['email'] = $this->post('email');
       $userData['mobile'] = $this->post('mobile');
       $lang = $this->input->post('lang');
       $user_id = $this->post('user_id');
     
     	$config['upload_path']          = "images/";    
        $config['allowed_types']        = '*';            
        $config['max_size'] 			= 1024 * 80;
        $config['file_name'] 			= "profile".time();

        $this->load->library('upload', $config);
        $email = $this->post('email');
        $userdata = $this->users_model->get_user_details($email);

        if($this->upload->do_upload('image'))
        {
        	if($userdata->image != 'noimage.png')
    		{
    			$url  = "images/".$userdata->image;           
    	   		unlink($url);
    		}
           	$image_data = array('upload_data' => $this->upload->data());                
			$userData['image'] = $image_data['upload_data']['file_name'];
			$result = $this->users_model->user_update_profile($userData,$user_id);	   	
		if($result)
		{
		    $img = $this->db->get_where('users',array('user_id'=>$user_id))->result_array();
	
         	 if(!empty($img['image']))
		    {
		       
		       $img1 =  $img['image'];
		    }
		    else
		    {
		       $img1 = $userdata->image;
		    }

                if($lang=='ar')
                {
                  $message = 'تم تحديث الملف الشخصي بنجاح';
                }
                else
                {
					$message = 'Profile Updated Successfully';
                }
		    $json = $this->response([
		    'status'=>TRUE,
		    'data'=>$img,
		    'message'=>$message
		    ],REST_Controller::HTTP_OK);
		}
		else
		{
            if($lang=='ar')
            {
              $message = 'غير قادر على تحديث ملفك الشخصي';
            }
            else
            {                          
              $message = 'Unable to Update your profile';
            }
		    $json = $this->response([
		    'status'=>FALSE,
		    'message'=>$message
		    ],REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	else
	{
		$userData['image'] = $this->input->post('image');
		$result = $this->users_model->user_update_profile($userData,$user_id);
                $data = $this->db->get_where('users',array('user_id'=>$user_id))->result_array();
	    	if($result)
			{
					if($lang=='ar')
							{
							  $message = 'تم تحديث الملف الشخصي بنجاح';
							}
							else
							{                          
				                $message = 'Profile Updated Successfully';
							}
						 $json = $this->response([
				'status'=>TRUE,
				'data'=>$data,
				'message'=>$message
				],REST_Controller::HTTP_OK);
			}
			else
			{
							if($lang=='ar')
							{
							  $message = 'غير قادر على تحديث ملفك الشخصي';
							}
							else
							{                          
				                $message = 'Unable to Update your profile';
							}
				$json = $this->response([
				'status'=>FALSE,
				'message'=>$message
				],REST_Controller::HTTP_BAD_REQUEST);
			}
	}
			echo json_encode($json);
    }
    
    public function get_reservations_post()
    {
    	 $user_id = $this->post('user_id');
    	 $auth_level = $this->post('auth_level');
         $lang = $this->input->post('lang');
         if($auth_level==2)
         {
             $reservations = $this->users_model->get_user_medical_advice_requests($user_id);
             $count=0;
             foreach($reservations as $row)
             {
                 $reservations[$count]->name = $this->db->query("select * from users where user_id = '".$row->userid."'")->row()->username;
                 $reservations[$count]->auth_level = $auth_level;
                 $reservations[$count]->customer_age = $this->db->query("select * from users where user_id = '".$row->userid."'")->row()->age;
                 $reservations[$count]->customer_gender = $this->db->query("select * from users where user_id = '".$row->userid."'")->row()->gender;
                 $reservations[$count]->location = $this->db->query("select * from users where user_id='".$row->user_id."'")->row()->location;
                 $speciality = $this->db->query("select doctor_speciality from users where user_id = '".$row->user_id."'")->row()->doctor_speciality;
                 $reservations[$count]->service_name = $this->db->query("select service_name from provided_services where id = '".$speciality."'")->row()->service_name;
                 $reservations[$count]->date = date('Y-m-d',strtotime($row->date_time));
                 $reservations[$count]->time = date('H:m:i',strtotime($row->date_time));
                 $count++;
             }
                 if(!empty($reservations))
        		{
        			$json = $this->response([
        			'status'=>TRUE,
        			'reservations'=>$reservations
        			],REST_Controller::HTTP_OK);
        		}
        		else
        		{
						if($lang=='ar')
						{
						  $message = 'لا توجد تحفظات';
						}
						else
						{                          
			 			 $message = 'No Reservations Found';
						}
        			$json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
        		}
         }
         else
         {
             //$reservations = $this->users_model->get_user_reservations($user_id,$auth_level);
             $reservations = $this->db->query("select id,user_id,booking_id,auth_level,doctor_name,name,customer_age,customer_gender,date,time,mobile,service,booking_time,service as service_name,status as appointment_status from appointments where user_id ='".$user_id."' and auth_level= '".$auth_level."' order by id desc")->result();
             $count =0;
             foreach($reservations as $row)
             {
                 $reservations[$count]->image = $this->users_model->view_profile($row->booking_id)->image;
                 $reservations[$count]->username =$this->users_model->view_profile($row->booking_id)->username; 
                 $reservations[$count]->lat = $this->users_model->view_profile($row->booking_id)->lat;
                 $reservations[$count]->lon =$this->users_model->view_profile($row->booking_id)->lon; 
                 $reservations[$count]->clinic_name = $this->users_model->view_profile($row->booking_id)->clinic_name;
                 if(@$row->service)
                 {
                      $reservations[$count]->service_name = $this->clinics_model->get_service_name_by_id($row->service)->service_name;
                 }
                 $count++;
             }
             if(!empty($reservations))
    		{
    			$json = $this->response([
    			'status'=>TRUE,
    			'reservations'=>$reservations
    			],REST_Controller::HTTP_OK);
    		}
    		else
    		{
				if($lang=='ar')
				{
				  $message = 'لا توجد تحفظات';
				}
				else
				{                          
	 			 $message = 'No Reservations Found';
				}
    			$json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
    		}
         }
		echo json_encode($json);
    }
    
    public function get_packages_get($lang='')
    {
    	$packages = $this->admin_model->get_packages();
    	if(!empty($packages))
    	{
    	  $json = $this->response(['status'=>TRUE,'packages'=>$packages], REST_Controller::HTTP_OK);
        }
        else
        {
            if($lang=='ar')
            {
              $message = 'لايوجد بيانات';
            }
            else
            {                          
              $message = 'No data found';
            }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        echo json_encode($json);
    }
    
    public function get_all_users_get($user_id='',$lang='')
    {
    	$doctors = $this->users_model->get_users($auth_level=2);
    	$clinics = $this->users_model->get_users($auth_level=3);
    	$free_dentals = $this->users_model->get_users($auth_level=4);    	

    	 $count = 0;
	foreach($doctors as $row) 
	{   
	    
	    $id = $row['user_id'];	    
	    $offers = $this->db->get_where('offers',array('user_id'=>$id,'status'=>1))->result_array();	 
	    $doctors[$count]['offer'] = ($offers)?$offers:'';  
	  
	   $doctor_speciality = $row['doctor_speciality'];
	   if($lang=="ar")
	   {
	       $doctor_speciality1 = $this->db->query("select id,service_name_ar as service_name,icon,status,doc from provided_services where id = '".$doctor_speciality."'")->result_array();
	   }
	   else
	   {
	       $doctor_speciality1 = $this->db->query("select id,service_name,icon,status,doc from provided_services where id = '".$doctor_speciality."'")->result_array();
	   }
	   
	   $doctors[$count]['doctor_speciality'] = ($doctor_speciality1)?$doctor_speciality1:'';
          $doctors[$count]['ratings'] = number_format((float)$row['ratings'], 1, '.', '');
          //($row['ratings'])?$row['ratings']:'';
	    $count++;
	}
	
    $count = 0;
	foreach($clinics as $row) 
	{	  	    
	     $id = $row['user_id'];	    
	     $offers = $this->db->get_where('offers',array('user_id'=>$id,'status'=>1))->result_array();	 
	     $clinics[$count]['offer'] = ($offers)?$offers:'';
         $clinics[$count]['ratings'] = number_format((float)$row['ratings'], 1, '.', '');
         //($row['ratings'])?$row['ratings']:'';
	     $count++;
	}
	
            $count = 0;
        	foreach($free_dentals as $row) 
        	{	  	    
        	     $id = $row['user_id'];	    
        	     $offers = $this->db->get_where('offers',array('user_id'=>$id,'status'=>1))->result_array();	 
        	     $free_dentals[$count]['offer'] = ($offers)?$offers:'';
                     $free_dentals[$count]['ratings'] = number_format((float)$row['ratings'], 1, '.', '');
                    // ($row['ratings'])?$row['ratings']:'';	  
        	     $count++;
        	}

        if(!empty($doctors) || !empty($clinics) || !empty($free_dentals))
        {        	       
            if($user_id)
            {
                $msg_unread_count = $this->db->query("select count(reciver_id) as unread_msg from chat where status=0 and reciver_id=$user_id")->row()->unread_msg;
                $notifications = $this->db->query("select count(user_id) as unread_notifications from notifications where read_status=0 and user_id =$user_id and auth_level is null")->row()->unread_notifications;
                $json = $this->response(['status'=>TRUE,'unread_msg_count'=>$msg_unread_count,'unread_notification_count'=>$notifications,'doctors'=>$doctors,'clinics'=>$clinics,'free_dentals'=>$free_dentals], REST_Controller::HTTP_OK);
            }
            else
            {
                $json = $this->response(['status'=>TRUE,'doctors'=>$doctors,'clinics'=>$clinics,'free_dentals'=>$free_dentals], REST_Controller::HTTP_OK);
            }
               
        }
        else
        {
                if($lang=='ar')
                {
                  $message = 'لايوجد بيانات';
                }
                else
                {                          
	                $message = 'No data found';
                }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        echo json_encode($json);
    }
    
    public function get_user_notifications_post()
    {
    	$user_id = $this->post('user_id');
    	if($user_id !="")
    	{
    		$lang = $this->input->post('lang');
	    	$notifications = $this->users_model->get_user_notifications($user_id,$lang);
	    	$array2 = $this->users_model->get_user_clinic_notifications($user_id,$lang);
	    //	$notifications = array_merge($array1,$array2);
	    	$result = $this->db->query("update notifications set read_status = 1 where user_id =$user_id and auth_level is null");
	    	if(!empty($notifications))
	    	{
	    		$json = $this->response(['status'=>TRUE,'unread_notification_count'=>'0','notifications'=>$notifications],REST_Controller::HTTP_OK);
	    	}
	    	else
	    	{
				if($lang=='ar')
	            {
	              $message = 'لايوجد بيانات';
	            }
	            else
	            {                          
	              $message = 'No data found';
	            }
	            $json = $this->response(['status' => FALSE,'message' =>$message], REST_Controller::HTTP_NOT_FOUND);
	    	}
    	}
    	else
    	{
				if($lang=='ar')
                {
                  $message = 'قيم المعلمات المفقودة';
                }
                else
                {                          
	               $message = 'Missing Parameter Values';
                }
	          $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
    	}
        
    	echo json_encode($json);
    }
    
    public function user_un_read_notification_count_post()
    {
        $user_id = $this->input->post("user_id");
        if($user_id !="")
        {
        	$notifications = $this->db->query("select count(user_id) as unread_notifications from notifications where read_status=0 and user_id =$user_id and auth_level is null")->row()->unread_notifications;
	        if(!empty($notifications))
	    	{
	    		$json = $this->response(['status'=>TRUE,'unread_notifications'=>$notifications],REST_Controller::HTTP_OK);
	    	}
	    	else
	    	{
	            $json = $this->response(['status' => FALSE], REST_Controller::HTTP_NOT_FOUND);
	    	}

        }
        else
        {
			if($lang=='ar')
            {
              $message = 'قيم المعلمات المفقودة';
            }
            else
            {                          
               $message = 'Missing Parameter Values';
            }
          $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
        }
        
    	echo json_encode($json);
    }
    
    public function clinic_filter_search_post()
    {   
    	$clinic_name = $this->post('clinic_name'); 	
    	$insurance = $this->post('insurance');
    	$service = $this->post('service');
        $lang = $this->input->post('lang');
       /* $latitude = $this->post('lat');
        $longitude = $this->post('lon');
        
    	//get radius 5 km based on current longitude and latitude
    	
    	//$lati = 17.385044; //latitude
	//$long = 78.486671; //longitude
	$distance = 5; //your distance in KM
	$R = 6371; //constant earth radius. You can add precision here if you wish
	
	$maxLat = $latitude + rad2deg($distance/$R);
	$minLat = $latitude - rad2deg($distance/$R);
	$maxLon = $longitude + rad2deg(asin($distance/$R) / cos(deg2rad($latitude )));
	$minLon = $longitude - rad2deg(asin($distance/$R) / cos(deg2rad($latitude )));

          // echo $maxLat, "<br>", $minLat, "<br>", $maxLon, "<br>", $minLon;
        
        $near_users = $this->db->query("select * from users where $minLat >lat < $maxLat and $minLon > lon < $maxLon")->result();*/
		
    	if(!empty($clinic_name) && !empty($insurance) && !empty($service))
    	{    		
    	   $result = $this->users_model->clinic_search_by_name_service_insurance($insurance,$service,$clinic_name);
    	}
    	else if(!empty($clinic_name) && !empty($insurance))
    	{
    	   $result = $this->users_model->clinic_search_by_name_insurance($insurance,$clinic_name);
    	}
    	else if(!empty($clinic_name) && !empty($service))
    	{
    	   $result = $this->users_model->clinic_search_by_name_service($service,$clinic_name);
    	}
    	else if(!empty($insurance) && !empty($service))
    	{
    	   $result = $this->users_model->clinic_search_by_service_insurance($insurance,$service);
    	}
    	else if(!empty($service))
    	{
    	   $result = $this->users_model->clinic_search_by_service($service);
    	}
    	else if(!empty($insurance))
    	{
    	   $result = $this->users_model->clinic_search_by_service_insurance($insurance);           
    	}
    	else if(!empty($clinic_name))
    	{
    	   $result = $this->users_model->clinic_search_by_name($clinic_name);          
    	}   	
    	
    	if(!empty($result))
    	{
           $count=0;
    	  foreach($result as $clinic)
    	  {
    	     $id = $clinic->user_id;   
             $offers = $this->db->get_where('offers',array('user_id'=>$id,'status'=>1))->result();
            $result[$count]->offers = ($offers)?$offers:'';
             $count++;
    	  }
    	  $json = $this->response(['status'=>TRUE,'clinics'=>$result],REST_Controller::HTTP_OK);
    	}
    	else
    	{
            if($lang=='ar')
            {
              $message = 'لايوجد بيانات';
            }
            else
            {
               $message = 'No data found';
            }
            $json = $this->response(['status' => FALSE,'message' =>$message], REST_Controller::HTTP_NOT_FOUND);
    	}
    	echo json_encode($json); 
    	
    }


   public function chat_post()
   {
        $sender_id = $this->input->post('sender_id');
        $reciver_id = $this->input->post('reciver_id');
        $data['message_type'] = $this->input->post('message_type');
        $data['sender_id'] = $sender_id;
        $data['reciver_id'] = $reciver_id;
        $lang = $this->input->post('lang');
        $message = $this->input->post('message');
        $type = $this->input->post('message_type');
        $b= date('Y-m-d');
        $a= date('h:m:s a');
        $data['date_time']= date('Y-m-d h:i:s a');
        
         if($type == 1)
         {
             $data['message'] = $message;
         }
         else if($type == 2)
         {
                $config['upload_path']          = "chat_files/";    
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 10450;
                $config['max_width']            = 105424;
                $config['max_height']           = 76458;
        
                $this->load->library('upload', $config);
                if($this->upload->do_upload('message'))
                {
                   	$image_data = array('upload_data' => $this->upload->data());                
        			$data['message'] = $image_data['upload_data']['file_name'];
                }
         }
         else if($type == '3')
         {
            
            $tm = date('Y-m-d').'-'.time().'.mp3';
             
            $target_dir =  "chat_files/";
            $target_file = $target_dir . $tm;
             
             $config['upload_path'] = "chat_files/";
             $config['allowed_types']        = '*';
             $config['max_size'] = 100450;
             $config['file_name'] = $tm;

            $this->load->library('upload', $config);
            if($this->upload->do_upload('message'))
            {
               $image_data = array('upload_data' =>$this->upload->data());
    	       $data['message'] = $config['file_name'];
            }
            
            if(move_uploaded_file($_FILES["message"]["tmp_name"], $target_file))
            {
                $data['message'] = $tm;
            }
            else
            {
                $data['message'] ='';
            }
         }
         else if($type == 4)
         {
             $config['upload_path'] = "chat_files/";
             $config['allowed_types']        = 'gif|jpg|png|mov|avi|flv|wmv|mp3|mp4';
             $config['max_size']=100450;
             
            $this->load->library('upload', $config);

            if($this->upload->do_upload('message'))
            {
               $image_data = array('upload_data' => $this->upload->data());
    	     $data['message'] = $image_data['upload_data']['file_name'];
            }
         }
       
        $data_insert = $this->users_model->chat($data);
        $results = $this->users_model->chat_msg($sender_id,$reciver_id);
    
	    if(!empty($results))
	    {
	    	 $sender_data = $this->users_model->view_profile($sender_id); 
	         $receiver_data = $this->users_model->view_profile($reciver_id);
		        
	              if($receiver_data->device_type == "Android" || $receiver_data->device_type == "IOS")
		           {		           	   
		           	   
		      		       $s_data['name'] = $sender_data->username;
		                   $s_data['image'] = $sender_data->image;
		                   $s_data['date'] = date('Y-m-d H:i:s A');
		                   $s_data['message'] = $message;
		                   $s_data['type'] = 'message';
		                   $s_data['title'] = $sender_data->username;
		                   $s_data['reciver_id'] = $sender_id;
		                   $s_data['body'] = $message;
		                   $s_data['click_action'] = 'com.volive.zorni.chat.ChatActivity';                  

		                  	
		                   //for android
				    if($receiver_data->device_type =='Android')
				    {				     
				     $result = $this->push_notifications->send_android_notification_user($receiver_data->device_token,$s_data);
				     $json = $this->response(['status'=>TRUE,'messages'=>$results],REST_Controller::HTTP_OK); 
				    }				    
				    
				    //for ios
				    if($receiver_data->device_type =='IOS')
				    {
				     
				     $ss = send_notification_ios($receiver_data->device_token,$s_data);
				     $json = $this->response(['status'=>TRUE,'messages'=>$results],REST_Controller::HTTP_OK); 
				    }	
				     
		      }	
		      
		      $json = $this->response(['status'=>TRUE,'messages'=>$results],REST_Controller::HTTP_OK); 
	             
	    }
	    else
	    {
            if($lang=='ar')
            {
              $message = 'لايوجد رسائل';
            }
            else
            {                          
              $message = 'No Messages Found';
            }
	                    
	        $json = $this->response(['status'=>FALSE,'messages'=>$message],REST_Controller::HTTP_NOT_FOUND); 
	     }
    echo json_encode($json);

   }

       public function chat_view_post()
       {
       
         $sender_id = $this->input->post('sender_id');
         $reciver_id = $this->input->post('reciver_id');
         $lang = $this->input->post('lang');
        
         $this->users_model->message_update_read_status($sender_id,$reciver_id);
         $result = $this->users_model->chat_msg($sender_id,$reciver_id );
      
         $count = 0;         
        foreach($result as $row)
         {
           $result[$count]['reciver_image'] = ($name = $this->db->query("select image from users where user_id = '".$row['reciver_id']."'")->row())?@$name->image:'';
           $result[$count]['sender_name'] = ($name = $this->db->query("select username from users where user_id = '".$row['sender_id']."'")->row())?@$name->username:'';
           $result[$count]['reciver_name'] = ($name = $this->db->query("select username from users where user_id = '".$row['reciver_id']."'")->row())?@$name->username:'';
           $result[$count]['sender_image'] = ($name = $this->db->query("select image from users where user_id = '".$row['sender_id']."'")->row())?@$name->image:'';
            $count++;
         }
          
	        if(!empty($result))
	        {
	        	$json = $this->response(['status'=>TRUE,'messages'=>$result],REST_Controller::HTTP_OK);  
	        }
	        else
	        {
	            if($lang=='ar')
	            {
	                $message = 'لايوجد رسائل';
	            }
	            else
	            {                          
		            $message = 'No Messages Found';
	            }                
	            $json = $this->response(['status'=>FALSE,'messages'=>$message],REST_Controller::HTTP_NOT_FOUND); 
	         }
              echo json_encode($json); 
       }

        public function user_chat_list_get($user_id,$lang='')
        {
        	if($user_id != "")
        	{
        		$doctors = $this->users_model->user_doctor_chat_list($user_id);
	            //$d_user = $this->users_model->user_doctor_delete_chat_list($user_id);
	            $free_dentals= $this->users_model->user_free_dental_chat_list($user_id);
	            $result1= array_merge($doctors,$free_dentals);
	            $start = $this->db->query("select * from users where user_id in (select distinct(reciver_id) from chat where sender_id = $user_id) and auth_level=3")->result_array();
	           $result = array_merge($result1,$start);
	           /*foreach ($result2 AS $key => $line ) 
	           { 
	                    if (!in_array($line['user_id'], $usedFruits) ) 
	                    { 
	                        $usedFruits[] = $line['user_id']; 
	                        $newArray[] = $line; 
	                    } 
	          } */
	          //$result = $newArray;
	         // print_r($doctors);
	         // die();
				$count = 0;
				foreach($result as $row) 
				{	  	    
					 $id = $row['user_id'];	    
					 $offers = $this->db->query("select * from offers where user_id='".$id."' and status = 1 and CURDATE() <= offers.expire_date")->result_array();	 
					 $result[$count]['offers'] = ($offers)?$offers:'';
					 $ratings = $this->users_model->avg_ratings($id)->rating;
					 $result[$count]['ratings'] = number_format((float)$ratings, 1, '.', '');
					 //($ratings)?$ratings:'';
					 $result[$count]['unread_messages']=$this->db->query("select count(status) as unread_messages from chat where sender_id=$row[user_id] and reciver_id = $user_id and status=0")->row()->unread_messages;
					 $count++;
				}
				
			           if(!empty($result))
			           {
			           	 $json = $this->response(['status'=>TRUE,'chat_list'=>$result],REST_Controller::HTTP_OK);  
			           }
			           else
			            {
	                        if($lang=='ar')
	                        {
	                          $message = 'لم يتم العثور على قائمة دردشة';
	                        }
	                        else
	                        {                          
				               $message = 'No Chat List Found';
	                        }
			              $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND); 
			            }
        	}
        	else
        	{
        		           if($lang=='ar')
	                        {
	                          $message = 'قيم المعلمات المفقودة';
	                        }
	                        else
	                        {                          
				               $message = 'Missing Parameter Values';
	                        }
        		          $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
        	}
           
            			 echo json_encode($json);
     	 }
       
        
        public function request_doctor_medical_advice_post()
        {
             $data['user_id'] = $this->input->post('user_id');
             $data['doctor_id'] = $this->input->post('doctor_id');
             $data['description'] = $this->input->post('description');
             if($this->input->post('payment_id')) {
             	$data['payment_id'] = $this->input->post('payment_id');
             }             
             $data['fees'] = $this->input->post('fees');
             $lang = $this->input->post('lang'); 
             $user_id = $this->input->post('user_id');
             $doctor_id = $this->input->post('doctor_id');         
    	
	         $config['upload_path'] = "medical_slips/";
             $config['allowed_types'] = 'gif|jpg|png|mov|avi|flv|wmv|mp3|mp4';
             $config['max_size']             = 100450;
            //$config['max_width']            = 105424;
            //$config['max_height']           = 76458;             
             $config['file_name'] 			= "slip".time();

             $this->load->library('upload', $config);

        if($this->upload->do_upload('medical_slip'))
        {
        	
            $image_data = array('upload_data' => $this->upload->data()); 
        	$data['file_type'] = $this->input->post('file_type');
   			$data['medical_slip'] = $image_data['upload_data']['file_name'];
	  		$result = $this->doctors_model->medical_advice_request($data);
	   if($result)
	   {  
	       $userData = $this->users_model->view_profile($user_id);         		
           $booked_user_details = $this->users_model->view_profile($doctor_id);
           		 
    			  if($booked_user_details->device_type == "Android" || $booked_user_details->device_type == "IOS")
		           {		  
		               
		           	$message = "You Have New Medical Advice Requset From ".$userData ->username;		                
		           	$data1['booking_user_id'] = $doctor_id;
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message'] = $message;
		           	$data1['message_ar']="لديك نموذج طلب مشورة طبية جديدة". " ".$userData ->username;		                
		           	$data1['auth_level'] = 2;
		           	$data1['date'] = date("Y-m-d");
		           	$data1['time'] = date("h:i A");
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);
		     		if($insert_notification)
                                {
                                    if($booked_user_details->lang=='ar')
        		                    {
        		                        $message1 =$data1['message_ar'];
        		                        $title = 'طلب مشورة طبية جديدة';
        		                    }
        		                    else
        		                    {
        		                        $message1 =$data1['message'];
        		                        $title = 'New Medical Advice Requset';
        		                    }
		      		       $s_data['name'] = $booked_user_details->role;
		                   $s_data['image'] = $booked_user_details->image;
		                   $s_data['date'] = date('Y-m-d H:i:sA');
		                   $s_data['message'] = $message1;
		                   $s_data['type'] = 'notification';
		                   $s_data['title'] = $title;
		                   $s_data['body'] = $message1;
		                   $s_data['click_action'] = 'com.volive.zorni.Notifications';                
		                   
		                        if($lang=='ar')
		                        {
		                          $message = 'تم أرسال طلب الأستشارة الخاصة بك بنجاح';
		                        }
		                        else
		                        {                          
					      			$message = 'Your Medical Advice Request Successfully Send';
		                        } 
                                         
		                     //for android
				     if($booked_user_details->device_type =='Android')
				     {
				        $re1 = send_notification_android($booked_user_details->device_token,$s_data);                                        
                            $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
				     }				    
				    
				      //for ios
				      if($booked_user_details->device_type =='IOS')
				      {
				         $ss = send_notification_ios($booked_user_details->device_token,$s_data);
                                         $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
				      }			       
		    	   
                                  }
                                  else
                                  {
                                        if($lang=='ar')
				                        {
				                          $message = 'تم أرسال طلب الأستشارة الخاصة بك بنجاح';
				                        }
				                        else
				                        {                          
							  				$message = 'Your Medical Advice Request Successfully Send';
				                        } 
                                      $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
                                  }				   
		 }   
           }
           else
	       {
		                if($lang=='ar')
                        {
                          $message = 'غير قادر على إرسال طلب الأستشارة الطبية الخاصة بك';
                        }
                        else
                        {
                           $message = 'Unable to Send your Medical Advice Request';
                        }
		    $json = $this->response([
		    'status'=>FALSE,
		    'message'=>$message
		    ],REST_Controller::HTTP_BAD_REQUEST);
	     }                
        }
        else
        {
          //$data['medical_slip'] = ;
           $result = $this->doctors_model->medical_advice_request($data);
	   if($result)
	   {
	   
	  		 $userData = $this->users_model->view_profile($user_id);           		
           		 $booked_user_details = $this->users_model->view_profile($doctor_id);
	                  if($booked_user_details->device_type == "Android" || $booked_user_details->device_type == "IOS")
		           {
		               
		           	$message = "You Have New Medical Advice Requset From ".$userData ->username;		                
		           	$data1['booking_user_id'] = $doctor_id;
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message'] = $message;
		           	$data1['message_ar']="لديك نموذج طلب مشورة طبية جديدة"." ".$userData ->username;		                
		           	$data1['auth_level'] = 2;
		           	$data1['date'] = date("Y-m-d");
		           	$data1['time'] = date("h:i A");
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);
		     		if($insert_notification)
                                {
                                    if($booked_user_details->lang=='ar')
        		                    {
        		                        $message1 =$data1['message_ar'];
        		                        $title = 'طلب مشورة طبية جديدة';
        		                    }
        		                    else
        		                    {
        		                        $message1 =$data1['message'];
        		                        $title = 'New Medical Advice Requset';
        		                    }
			      		       $s_data['name'] = $booked_user_details->role;
			                   $s_data['image'] = $booked_user_details->image;
			                   $s_data['date'] = date('Y-m-d H:i:sA');
			                   $s_data['message'] = $message1;
			                   $s_data['type'] = 'notification';
			                   $s_data['title'] = $title;
			                   $s_data['body'] = $message1;
			                   $s_data['click_action'] = 'com.volive.zorni.Notifications';                
		                   
		                        if($lang=='ar')
		                        {
		                          $message = 'تم أرسال طلب الأستشارة الخاصة بك بنجاح';
		                        }
		                        else
		                        {                          
					  				$message = 'Your Medical Advice Request Successfully Send';
		                        } 
                                         
		                     //for android
				     if($booked_user_details->device_type =='Android')
				     {
				        $re1 = send_notification_android($booked_user_details->device_token,$s_data);                                        
                                       $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
				     }				    
				    
				      //for ios
				      if($booked_user_details->device_type =='IOS')
				      {
				         $ss = send_notification_ios($booked_user_details->device_token,$s_data);
                                         $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
				      }			       
		    	   
                                  }
                                  else
                                  {
                                        if($lang=='ar')
				                        {
				                          $message = 'تم أرسال طلب الأستشارة الخاصة بك بنجاح';
				                        }
				                        else
				                        {                          
							  				$message = 'Your Medical Advice Request Successfully Send';
				                        } 
                                      $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
                                  }
	   }
	   else
	   {
		       		    if($lang=='ar')
                        {
                          $message = 'غير قادر على إرسال طلب الأستشارة الطبية الخاصة بك';
                        }
                        else
                        {
                           $message = 'Unable to Send your Medical Advice Request';
                        }
                        
		    $json = $this->response([
		    'status'=>FALSE,		    
		    'message'=>$message
		    ],REST_Controller::HTTP_BAD_REQUEST);
	   } 
       }
          

                  
       }
       }

//Doctor Mobile Services 23/05/2018
        
        public function medical_advice_requests_post()
        {
             $user_id = $this->post('doctor_id');
             $status = $this->post('status');
             $lang = $this->input->post('lang');
             if($user_id !="" || $status!=""){
             	$requests_data = $this->doctors_model->get_medical_advices($user_id,$status);
	             if(!empty($requests_data))
	             {
	                $count=0;
	                 foreach($requests_data as $request)
	                 {
	                   $requests_data[$count]->ticket_id = "#ZMATI".$request->id;
	                   $count++;
	                 }
	                 $json = $this->response(['status'=>TRUE,'requests_data'=>$requests_data],REST_Controller::HTTP_OK);
			     }
			     else
			     {
		            if($lang =='ar')
		            {
		               $message = 'لايوجد بيانات';
		            }
		            else
		            {                         
		               $message = 'No data found';
		            }
		            $json = $this->response([
		                'status' => FALSE,
		                'message' =>$message
		            ], REST_Controller::HTTP_NOT_FOUND);
			     }

             }else{
 				if($lang=='ar')
                {
                  $message = 'قيم المعلمات المفقودة';
                }
                else
                {                          
	               $message = 'Missing Parameter Values';
                }
        		$json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
             }
             
			echo json_encode($json);    
        }

        public function all_tweets_post()
        {
            $user_id = $this->post('user_id'); 
            $lang = $this->input->post('lang');
            if($user_id != "" && $lang != ""){
            	$tweets = $this->users_model->get_tweets($user_id,$lang);
	            $count=0;
		            foreach($tweets as $tweet)
		            {           
			             $id = $tweet->id;
			             $dta = $this->db->query("select id,tweet_title as tweet_title_en,tweet_title_ar,tweet as tweet_en,tweet_ar from tweets where id = '".$id."'")->row();
			             $tweets[$count]->tweet_title_en = $dta->tweet_title_en;
			             $tweets[$count]->tweet_title_ar= $dta->tweet_title_ar;
			             $tweets[$count]->tweet_en= $dta->tweet_en;
			             $tweets[$count]->tweet_ar = $dta->tweet_ar;
			             $count++;
		            }
		            if(!empty($tweets))
			         {
			           $json = $this->response(['status'=>TRUE,'tweets'=>$tweets],REST_Controller::HTTP_OK);
					 }
					 else
					 {
		                if($lang == 'ar')
	        			{
	        			  $message = 'لايوجد بيانات';
	        			}
	        			else
	        			{                          
	        	       	  $message = 'No data found';
	        			}
			        $json = $this->response(['status' => FALSE,'message' =>$message], REST_Controller::HTTP_NOT_FOUND);
					 }

            }else{
            		if($lang=='ar')
                    {
                      $message = 'قيم المعلمات المفقودة';
                    }
                    else
                    {                          
		               $message = 'Missing Parameter Values';
                    }
		          $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
            }
			echo json_encode($json);
    
        }

        public function delete_tweet_post()
        {
            $id = $this->post('id');
            $lang = $this->input->post('lang');
            if($id !="")
            {
            	$result = $this->users_model->delete_tweet($id);
		         if($result)
		         {
		                        if($lang=='ar')
		                        {
		                          $message = 'تم حذف التغريدة';
		                        }
		                        else
		                        {                          
				          $message = 'Tweet Was Deleted';
		                        }
				        
		                 $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
			     }
			     else
			     {
		                        if($lang=='ar')
		                        {
					                $message = 'غير قادر على حذفها';
		                        }
		                        else
		                        {                          
					            $message = 'Unable To Deleted';
		                        }
					$json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
			     }
            }
            else
            {
            				if($lang=='ar')
	                        {
	                          $message = 'قيم المعلمات المفقودة';
	                        }
	                        else
	                        {                          
				               $message = 'Missing Parameter Values';
	                        }
        		          $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
            }            
			echo json_encode($json);    
        }

        public function get_followers_post()
        {
             $user_id = $this->post('user_id'); 
             $lang = $this->input->post('lang');
             if($user_id !="")
             {
             	$followers= $this->users_model->get_followers($user_id);
			     if($followers)
			     {
			         $json = $this->response(['status'=>TRUE,'followers'=>$followers],REST_Controller::HTTP_OK);
			     }
			     else
			     {
			        if($lang=='ar')
			        {
			          $message = 'لايوجد بيانات';
			        }
			        else
			        {                          
				   $message = 'No data found';
			        }
			    	$json = $this->response(['status' => FALSE,'message' =>$message], REST_Controller::HTTP_NOT_FOUND);
			     }
             }
             else
             {
         				if($lang=='ar')
                        {
                          $message = 'قيم المعلمات المفقودة';
                        }
                        else
                        {                          
			               $message = 'Missing Parameter Values';
                        }
        		          $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
             }
	   	 		echo json_encode($json);    
        }

        public function get_ratings_post()
        {
            $user_id = $this->post('user_id');
            $lang = $this->input->post('lang');
            if($user_id != "")
            {
            	$ratings = $this->users_model->get_ratings($user_id);             
	             if($ratings)
	             {
	                 $json = $this->response(['status'=>TRUE,'ratings'=>$ratings],REST_Controller::HTTP_OK);
			     }
			     else
			     {
	                if($lang=='ar')
                    {
                      $message = 'لايوجد بيانات';
                    }
                    else
                    {                          
	          			$message = 'No data found';
                    }
		            $json = $this->response(['status' => FALSE,'message' =>$message], REST_Controller::HTTP_NOT_FOUND);
			     }
            }   
            else
            {
    				if($lang=='ar')
                    {
                      $message = 'قيم المعلمات المفقودة';
                    }
                    else
                    {                          
		               $message = 'Missing Parameter Values';
                    }
        		    $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
            }       
            
	    echo json_encode($json);    
        }

        public function get_offers_post()
        {
              $user_id = $this->input->post('user_id');
              if($user_id != "")
              {
              	    $offers = $this->users_model->get_offers($user_id);
		             $lang = $this->input->post('lang');
		             if(!empty($offers))
		             {
		                 $json = $this->response(['status'=>TRUE,'offers'=>$offers],REST_Controller::HTTP_OK);
				     }
				     else
				     {
		                if($lang=='ar')
		                {
		                  $message = 'لايوجد بيانات';
		                }
		                else
		                {                          
			    		   $message = 'No data found';
		                }
			            $json = $this->response(['status' => FALSE,'message' =>$message], REST_Controller::HTTP_NOT_FOUND);
				     }
              } 
              else
              {
      				if($lang=='ar')
                    {
                      $message = 'قيم المعلمات المفقودة';
                    }
                    else
                    {                          
		               $message = 'Missing Parameter Values';
                    }
		          $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
              }        
              
	    		echo json_encode($json);
    
        }

        public function offers_add_post()
        {            
			$data['user_id'] = $this->input->post('user_id');
			$data['promo_code'] = $this->post('promo_code');
			$data['percentage'] = $this->post('percentage');
			$data['description'] = $this->post('description');
			$data['description_ar'] = $this->post('description_ar');
			$data['expire_date'] = $this->post('expire_date');			
	        $lang = $this->post('lang');           
             $result = $this->users_model->offer_add($data);                        
             if($result)
             {
                        if($lang=='ar')
                        {
                          $message = 'تمت إضافة العرض بنجاح';
                        }
                        else
                        {                          
			   $message = 'Offer Added Successfully';
                        }
                     $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
	     }
	     else
	     {
                        if($lang == 'ar')
                        {
                          $message = 'حاول مرة اخرى';
                        }
                        else
                        {                          
			   $message = 'Please Try Again';
                        }
		     $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
	     }
	        echo json_encode($json);
    
        }

        public function delete_offer_post()
        {
             $id = $this->post('id');
             $lang = $this->input->post('lang');
             if($id != "")
             {
             	$result = $this->users_model->delete_offer_by_id($id);
	             if($result)
	             {
	                        if($lang=='ar')
	                        {
	                          $message = 'تم حذف العرض';
	                        }
	                        else
	                        {                          
				   				$message = 'Offer Was Deleted';
	                        }
	                 $json = $this->response(['status'=>TRUE,'message'=>$message ],REST_Controller::HTTP_OK);
			     }
			     else
			     {
		                        if($lang=='ar')
		                        {
		                          $message = 'غير قادر على حذفها';
		                        }
		                        else
		                        {                          
					  $message = 'Unable To Deleted';
		                        }
				  $json = $this->response(['status'=>FALSE,'message'=>$message ],REST_Controller::HTTP_NOT_FOUND);
			     }
             }  
             else
             {
             				if($lang=='ar')
	                        {
	                          $message = 'قيم المعلمات المفقودة';
	                        }
	                        else
	                        {                          
				               $message = 'Missing Parameter Values';
	                        }
        		          $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
             }      
             
			echo json_encode($json);
    
        }

        public function update_offer_post()
        {

             $data = array(				
				'promo_code' => $this->post('promo_code'),
				'percentage' => $this->post('percentage'),
				'description' => $this->post('description'),
				'description_ar' => $this->post('description_ar'),
				'expire_date' => $this->post('expire_date')
			);
            $lang = $this->input->post('lang');
             $id = $this->post('id');          
             $result = $this->users_model->update_offer_status($data,$id);
             if($result)
             {
                        if($lang=='ar')
                        {
                          $message = 'عرض تم تحديثه بنجاح';
                        }
                        else
                        {                          
			   $message = 'Offer Successfully Updated';
                        }

                 $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
	     }
	     else
	     {
                        if($lang=='ar')
                        {
                          $message = 'العرض غير قادر على التحديث';
                        }
                        else
                        {                          
			       			$message = 'Offer Was Unable to Update';
                        }
		       $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
	     }
	      echo json_encode($json);
        }

        public function active_deactive_offer_post()
        {
             $id = $this->input->post("id");
             $status = $this->input->post("status");
             $lang = $this->input->post("lang");        
         
             if($status == 1) 
             {
                $data = array("status" => 0);                     
             } 
             else if($status == 0)         
             {                     
                $data = array("status" => 1);             
             }             
                      
	         $result = $this->users_model->update_offer_status($data,$id);
	         if($result)
	         {
	                        if($lang == 'ar')
	                        {
	                          $message = 'تم تغيير حالة عرضك بنجاح';
	                        }
	                        else
	                        {                          
				    		  $message = 'Your Offer Status Was Successfully Changed';
	                        }

	                 	$json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
		     }
		     else
		     {
	                        if($lang=='ar')
	                        {
	                          $message = 'غير قادر على تغيير حالتك';
	                        }
	                        else
	                        {                          
				  			  $message = 'Unable To Change Your Status';
	                        }
						$json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
		     }
	    		echo json_encode($json);
    
        }

        public function change_medical_advice_status_post() 
    	{      
            $id = $this->input->post("id");          
            $status = $this->input->post("status");
            $user_id = $this->input->post("user_id"); 
            $lang = $this->input->post("lang");        
           
           if($status == 1)
           {
           		$data = array("status" => 1);

           		$userData = $this->doctors_model->get_user_details_based_on_medical_advice_id($id);           		
           		$doctor_details = $this->users_model->view_profile($user_id);
           		$user_appointment_details = $this->users_model->get_medical_advice_request_details_based_on_appointment_id($id);           		         		         		     
                       // print_r($userData); exit;
		           if($userData->device_type == "Android" || $userData->device_type == "IOS")
		           {
		               
		           	$message = "Your Medical Advice Request Is Confirmed ".$doctor_details->username;		                
		           	$data1['booking_user_id'] = $doctor_details->user_id;
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message'] = $message;
		           	$data1['message_ar']="تم تأكيد طلب المشورة الطبية الخاص بك د"." ".$doctor_details->username;		                
		           	$data1['date'] = $user_appointment_details->date_time;
		           	$data1['time'] = $user_appointment_details->date_time;
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);
		           	$result = $this->doctors_model->update_medical_advice_status($data,$id);
                   if($result)
                   {
                                         if($userData->lang=='ar')
            		                    {
            		                        $message1 =$data1['message_ar'];
            		                        $title = 'تأكيد طلب المشورة الطبية';
            		                    }
            		                    else
            		                    {
            		                        $message1 =$data1['message'];
            		                        $title = 'Medical Advice Request Conformation';
            		                    }
                              $s_data['name'] = $doctor_details->username;
		                      $s_data['image'] = $doctor_details->image;
		                      $s_data['date'] = date('Y-m-d H:i:sA');
		                      $s_data['message'] = $message1;
		                      $s_data['type'] = 'notification';
		                      $s_data['title'] =$title;
		                      $s_data['body'] = 'Medical Advice Request conformation notification from your Doctor';
		                      $s_data['click_action'] = 'com.volive.zorni.Notifications';                
		                   
		                                 if($lang =='ar')
                                         {
                                           $message = 'تم إرسال إشعار التأكيد إلى ';
                                         }
                                         else
                                         {                          
		                            $message = 'Confirmation Notification Sent to ';
                                         }
                                         
		                     //for android
				     if($userData->device_type =='Android')
				     {
				        $re1 = send_notification_android($userData->device_token,$s_data);                                        
                                       $json = $this->response(['status'=>TRUE,'message'=>$message.$userData->username],REST_Controller::HTTP_OK);
				     }				    
				    
				      //for ios
				      if($userData->device_type =='IOS')
				      {
				         $ss = send_notification_ios($userData->device_token,$s_data);                                         $json = $this->response(['status'=>TRUE,'message'=>$message.$userData->username],REST_Controller::HTTP_OK);
				      }
              }
              else
              {
                     if($lang =='ar')
                     {
                       $message = 'حاول مرة اخرى ';
                     }
                     else
                     {                          
                $message = 'Please Try Again';
                     }
                  $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
              }				   				   
		           } 		                    	
           
           }
           else
           {
           	        $data = array("status" => $status);
                        $userData = $this->doctors_model->get_user_details_based_on_medical_advice_id($id);
           		$doctor_details = $this->users_model->view_profile($user_id);           		         		         		     
                        $user_appointment_details = $this->users_model->get_medical_advice_request_details_based_on_appointment_id($id);
                        //print_r($user_appointment_details);exit;
		           if($userData->device_type == "Android" || $userData->device_type == "IOS")
		           {
		               if($status==2)
		              {
		                  $message = "Your Appointment Is Cancelled ".$doctor_details->username;
		                  $message_ar="الموعد الخاص بك تم إلغاؤه د"." ".$doctor_details->username;	
		              }
		              else if($status==4)
		              {
		                 $message = "Your Appointment Is Completed With ".$doctor_details->username;
		                  $message_ar="اكتمال موعدك مع"." ".$doctor_details->username;	 
		              }
		           	$data1['booking_user_id'] = $doctor_details->user_id;
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message'] = $message;
		           	$data1['message_ar'] =$message_ar;
		           	$data1['date'] = date('Y-m-d',strtotime($user_appointment_details->date_time));
		           	$data1['time'] = date('h:i:s',strtotime($user_appointment_details->date_time));
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	// print_r($data1);exit;
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);
		           	$result = $this->doctors_model->update_medical_advice_status($data,$id);
                                   if($result)
                                   {
                                       if($userData->lang=='ar')
            		                    {
            		                        $message1 =$data1['message_ar'];
            		                        $title ='حالة طلب المشورة الطبية';
            		                    }
            		                    else
            		                    {
            		                        $message1 =$data1['message'];
            		                        $title = 'Medical Advice Request Status';
            		                    }
                                      $s_data['name'] = $doctor_details->username;
		                      $s_data['image'] = $doctor_details->image;
		                      $s_data['date'] = date('Y-m-d H:i:sA');
		                      $s_data['message'] = $message1;
		                      $s_data['type'] = 'notification';
		                      $s_data['title'] = $title;
		                      $s_data['body'] = $message1;
		                      $s_data['click_action'] = 'com.volive.zorni.Notifications';
		                                                   
                                         if($lang =='ar')
                                         {
                                           $message ='طلب المشورة الطبية إشعار الحالة المرسلة إلى';
                                         }
                                         else
                                         {                          
		                            $message = 'Medical Advice Request Status Notification Sent to ';
                                         }
                                          //for android        
					     if($userData->device_type =='Android')
					     {
					        $re1 = send_notification_android($userData->device_token,$s_data);
	                                        $json = $this->response(['status'=>TRUE,'message'=>$message.$userData->username],REST_Controller::HTTP_OK);
					     }				    
					    
					      //for ios
					      if($userData->device_type =='IOS')
					      {
					         $ss = send_notification_ios($userData->device_token,$s_data); 
	                                         $json = $this->response(['status'=>TRUE,'message'=>$message.$userData->username],REST_Controller::HTTP_OK);
					      }
                                  }
                                  else
                                  {
                                         if($lang =='ar')
                                         {
                                           $message = 'حاول مرة اخرى ';
                                         }
                                         else
                                         {                          
		                            $message = 'Please Try Again';
                                         }
                                      $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
                                  }
				   				   
		           }           	                      
           }                  
               
    	}


    public function doctor_update_profile_post()
    {
    
    	$data['username'] = $this->input->post('username');    	
    	$data['about_dr'] = $this->input->post('about_dr');
    	$data['mobile'] = $this->input->post('mobile');
    	$data['dr_fees'] = $this->input->post('dr_fees');
    	$data['email'] = $this->input->post('email');
    	$data['location'] = $this->input->post('location');
    	$data['what_would_you_get'] = $this->input->post('what_would_you_get');
    	$data['lat'] = $this->input->post('lat');
    	$data['lon'] = $this->input->post('lon');
        $user_id = $this->input->post('user_id');
         $lang = $this->input->post('lang');
    	
	    $config['upload_path']          = "images/";    
        $config['allowed_types']        = '*';            
        $config['max_size']             = 1024 * 80;
        $config['file_name']            = "profile".time();

        $this->load->library('upload', $config);

        if($this->upload->do_upload('image'))
        {
            if($this->input->post("image"))
    		{
    		     if($this->input->post("image") != 'noimage.png')
    		    {	
    		    	$url  = "images/".$this->input->post("image");            
    	   		unlink($url);		    
    		    }
    		}
           $image_data = array('upload_data' => $this->upload->data());                
	       $data['image'] = $image_data['upload_data']['file_name'];
	       $result =$this->users_model->user_update_profile($data,$user_id);
	   if($result)
	   {  

                        if($lang=='ar')
                        {
                           $message = 'تم تحديث الملف الشخصي بنجاح';
                        }
                        else
                        {                          
			                $message = 'Profile Updated Successfully';
                        }
                      //$data= $this->users_model->view_profile($user_id);
                      $data = $this->db->query("select * from users where user_id ='".$user_id."'")->result_array();
                      /*if($data->auth_level == 2)
                      {
                      	  if($lang=='ar')
	                      {
	                         //$data->doctor_speciality  =  $this->db->query("select service_name_ar as service_name from provided_services where id = '".$data->doctor_speciality."'")->row()->service_name;
	                      }
	                      else
	                      {
	                       // $data->doctor_speciality  =  $this->db->query("select service_name from provided_services where id = '".$data->doctor_speciality."'")->row()->service_name;
	                      }
                      
                      }*/
                     
                      
	             $json = $this->response([
		    'status'=>TRUE,
		    'data'=>$data,
		    'message'=>$message
		    ],REST_Controller::HTTP_OK);
           }
           else
	   {
		                if($lang=='ar')
                        {
                           $message = 'غير قادر على تحديث ملفك الشخصي';
                        }
                        else
                        {                         
			               $message = 'Unable to Update your profile';
                        }
		    $json = $this->response([
		    'status'=>FALSE,
		    'message'=>$message
		    ],REST_Controller::HTTP_BAD_REQUEST);
	   }                
        }
        else
        {
           $data['image'] = $this->input->post('image');
           $result =$this->users_model->user_update_profile($data,$user_id);
	   if($result)
	   {

                        if($lang=='ar')
                        {
                          $message = 'تم تحديث الملف الشخصي بنجاح';
                        }
                        else
                        {                          
			               $message = 'Profile Updated Successfully';
                        }
                //$data= $this->users_model->view_profile($user_id);
                $data = $this->db->query("select * from users where user_id ='".$user_id."'")->result_array();
                     if($lang=='ar')
                      {
                         //$data->doctor_speciality  =  $this->db->query("select service_name_ar as service_name from provided_services where id = '".$data->doctor_speciality."'")->row()->service_name;
                      }
                      else
                      {
                        //$data->doctor_speciality  =  $this->db->query("select service_name from provided_services where id = '".$data->doctor_speciality."'")->row()->service_name;
                      }
	       $json = $this->response([
		    'status'=>TRUE,
		    'data'=>$data,
		    'message'=>$message
		    ],REST_Controller::HTTP_OK);
	   }
	   else
	   {
		                if($lang=='ar')
                        {
                          $message = 'غير قادر على تحديث ملفك الشخصي';
                        }
                        else
                        {                          
			               $message = 'Unable to Update your profile';
                        }
                        
		    $json = $this->response([
		    'status'=>FALSE,		    
		    'message'=>$message
		    ],REST_Controller::HTTP_BAD_REQUEST);
	   } 
        }     	
    
    }

        public function delete_medical_advice_request_post()
        {
              $id = $this->post('id');
              $lang = $this->input->post('lang');
              $medical_slip = $this->doctors_model->get_medical_advice_document($id);
   	    if(!empty($medical_slip))
   	    {
   	    	$url  = "medical_slips/".$medical_slip;            
	   	unlink($url);	
   	    }
	     $result = $this->doctors_model->delete_medical_advice_request($id);	    
             if($result)
             {
                        if($lang=='ar')
                        {
                          $message = 'تم حذف طلب المشورة بنجاح';
                        }
                        else
                        {                          
			   $message = 'Advice Request was successfully deleted';
                        }
                 $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
	     }
	     else
	     {
                        if($lang=='ar')
                        {
                          $message = 'غير قادر على حذفها';
                        }
                        else
                        {                          
			  $message = 'Unable To Deleted';
                        }
		$json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
	     }
	    echo json_encode($json);    
        }  

        public function doctor_details_post()
        {
               $user_id = $this->post('user_id');
               $lang = $this->input->post('lang');
               
             $auth_level = $this->users_model->view_profile($user_id)->auth_level; 
               if($auth_level == 2)
               {
	               	$result = $this->users_model->get_doctor_data($user_id);
	               	
	             foreach($result as $row)
	              {
	                  $id = $row['doctor_speciality'];
	                  if($lang =="ar")
    	              {
    	                  
    	                 $service_name = $this->db->query("select service_name_ar as service_name,icon from provided_services where id=$id")->row();
    	              }
    	              else
    	              {
    	                  $id = $row['doctor_speciality'];
    	                 $service_name = $this->db->query("select service_name,icon from provided_services where id=$id")->row();
    	              }
	              }
	               $result['0']['doctor_speciality'] = $service_name->service_name;
	               $result['0']['icon'] = $service_name->icon;
	               $results = $this->users_model->doctor_chat_list($user_id);
        		   $result['0']['conversations'] = count($results);
                   $result['0']['package_status'] = FALSE;
        		   $result['0']['total_appointments'] = $this->db->query("select count(user_id) as requests from doctor_medical_advices where doctor_id=$user_id")->row()->requests;
               }
               else
               {
                   $result = $this->users_model->get_free_dental_data($user_id);
                    //$results = $this->users_model->free_dental_chat_list($user_id);
                    $result1 = $this->users_model->free_dental_chat_list($user_id);
                       $start = $this->db->query("select * from users where user_id in (select distinct(sender_id) from chat where reciver_id = $user_id)")->result_array();
                       $result2= array_merge($result1,$start);
                       foreach ($result2 AS $key => $line ) 
                       { 
                                if ( !in_array($line['user_id'], $usedFruits) ) 
                                { 
                                    $usedFruits[] = $line['user_id']; 
                                    $newArray[] = $line; 
                                } 
                      }

                        if($result['0']['package_expire_date'] >= date('Y-m-d')) {
                           $result['0']['package_status'] =TRUE;
                        }else{
                            $result['0']['package_status'] =FALSE;
                        }
        		 $result['0']['conversations'] = count($newArray);
        		 $result['0']['total_appointments'] = $this->db->query("select count(user_id) as requests from appointments where booking_id=$user_id")->row()->requests;
               }
             // $result = $this->users_model->get_free_dental_data($user_id); 
             if($result)
             {                     
                       
                        $result['0']['tweets'] = $this->users_model->count_tweets($user_id)->total_tweets;
                        $ratings = $this->users_model->avg_ratings($user_id)->rating;
                        $result['0']['rating'] =number_format((float)$ratings, 1, '.', '');
                       // ($ratings)?$ratings:'';
                        $result['0']['followers'] = $this->users_model->count_followers($user_id)->total_followers;
                        $json = $this->response(['status'=>TRUE,'doctor_data'=>$result],REST_Controller::HTTP_OK);
	     }
	     else
	     {
                        if($lang=='ar')
                        {
                          $message = 'لايوجد بيانات';
                        }
                        else
                        {                          
		                    $message = 'No data found';
                        }
		      $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
	     }
	      echo json_encode($json);    
	    
    
        }

        public function doctor_chat_list_get($doctor_id,$lang='')
        {
           $result = $this->users_model->doctor_chat_list($doctor_id);
           
          $count=0;
           foreach($result as $row)
           {
               $result[$count]['unread_messages']=$this->db->query("select count(status) as unread_messages from chat where sender_id=$row[user_id] and reciver_id = $doctor_id and status=0")->row()->unread_messages;
               $count++;
           }
           
           if(!empty($result))
           {
           	$json = $this->response(['status'=>TRUE,'chat_list'=>$result],REST_Controller::HTTP_OK);  
           }
           else
            {
                        if($lang=='ar')
                        {
                          $message = 'لم يتم العثور على قائمة دردشة';
                        }
                        else
                        {                          
			               $message = 'No Chat List Found';
                        }
              $json = $this->response(['status'=>FALSE,
                                'message'=>$message
                ],REST_Controller::HTTP_NOT_FOUND); 
            }
             echo json_encode($json);       

         } 

        public function free_dental_chat_list_get($free_dental_id,$lang='')
        {
           $result1 = $this->users_model->free_dental_chat_list($free_dental_id);
           $start = $this->db->query("select * from users where user_id in (select distinct(sender_id) from chat where reciver_id = $free_dental_id)")->result_array();
           $result2= array_merge($result1,$start);
           foreach ($result2 AS $key => $line ) 
           { 
                    if ( !in_array($line['user_id'], $usedFruits) ) 
                    { 
                        $usedFruits[] = $line['user_id']; 
                        $newArray[] = $line; 
                    } 
          } 
         $result =$newArray;
           $count=0;
           foreach($result as $row)
           {
               $result[$count]['unread_messages']=$this->db->query("select count(status) as unread_messages from chat where sender_id=$row[user_id] and reciver_id = $free_dental_id and status=0")->row()->unread_messages;
               $count++;
           }
           if(!empty($result))
           {
           	$json = $this->response(['status'=>TRUE,'chat_list'=>$result],REST_Controller::HTTP_OK); 
           }
           else
           {
                        if($lang=='ar')
                        {
                          $message = 'لم يتم العثور على قائمة دردشة';
                        }
                        else
                        {                          
			   $message = 'No Chat List Found';
                        }

              $json = $this->response(['status'=>FALSE,
                                'message'=>$message
                ],REST_Controller::HTTP_NOT_FOUND); 
            }
             echo json_encode($json);       

         } 
    
    /*public function free_dental_book_appointment_post()
    {
    	$userData['user_id'] = $this->post('user_id');
    	$userData['booking_id'] = $this->post('booking_id');
    	$userData['name'] = $this->post('name');
    	$userData['customer_age'] = $this->post('customer_age');
    	$userData['customer_gender'] = $this->post('customer_gender');
    	$userData['date'] = $this->post('date');
    	$userData['time'] = $this->post('time');
    	$userData['mobile'] = $this->post('mobile');
        //	$userData['service'] = $this->post('service');    	    	
    	$userData['auth_level'] = $this->post('auth_level');
         $lang = $this->input->post('lang');
         $user_id = $this->post('user_id'); 
         $booking_id = $this->post('booking_id');   	
    	    	
    	$result = $this->users_model->user_book_appointment($userData);
    	if($result)
    	{
    	 
    			$userData = $this->users_model->view_profile($user_id);           		
           		$booked_user_details = $this->users_model->view_profile($booking_id);
           		 
    			  if($booked_user_details->device_type == "Android" || $booked_user_details->device_type == "IOS")
		           {		           	   
		           	$message = "You Have New Appointment Request From  '". $userData ->username."'";		                
		           	$data1['booking_user_id'] = $booking_id;
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message'] = $message;
		           	$data1['auth_level'] = 4;
		           	$data1['date'] = date("Y-m-d");
		           	$data1['time'] = date("h:i A");		           	
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);
		     		if($insert_notification)
                                {
		      		   $s_data['name'] = $booked_user_details->role;
		                   $s_data['image'] = $booked_user_details->image;
		                   $s_data['date'] = date('Y-m-d H:i:sA');
		                   $s_data['message'] = $message;
		                   $s_data['type'] = 'notification';
		                   $s_data['title'] = 'New Appointment Requset';
		                   $s_data['body'] = $message;
		                   $s_data['click_action'] = 'com.volive.zorni.Notifications';                
		                   
		                        if($lang=='ar')
		                        {
		                          $message = 'تم حجز المواعيد';
		                        }
		                        else
		                        { 
					   $message = 'Appointment Booked';
		                         }
                                         
		                     //for android
				     if($booked_user_details->device_type =='Android')
				     {
				        $re1 = send_notification_android($booked_user_details->device_token,$s_data);                                        
                                       $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
				     }				    
				    
				      //for ios
				      if($booked_user_details->device_type =='IOS')
				      {
				         $ss = send_notification_ios($booked_user_details->device_token,$s_data);
                                         $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
				      }			       
		    	   
                                  }
                                  else
                                  {
                                         if($lang=='ar')
		                        {
		                          $message = 'تم حجز المواعيد';
		                        }
		                        else
		                        { 
					   $message = 'Appointment Booked';
		                         }
                                     $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
                                  }
				   				   
		           }    	
                       
    	}
    	else
    	{
                        if($lang=='ar')
                        {
                          $message = 'غير قادر على حجز الموعد';
                        }
                        else
                        {                          
			   $message = 'Unable to Book your appointment';
                         }
    	   $json = $this->response(['status'=>FALSE,'message'=>$message], REST_Controller::HTTP_NOT_FOUND);
    	}
    	       
    
    }*/
    // venkatesh multiple requests send to student or free dental 12-07-2018
    public function free_dental_book_appointment_post()
    {
        //  $userData['service'] = $this->post('service');              
        //$userData['auth_level'] = $this->post('auth_level');
         $lang = $this->input->post('lang');
         $user_id = $this->post('user_id'); 
         //$booking_id = $this->post('booking_id');       
         $city = $this->post('city');  
        if(@$city!='')
        {
            $get_free_dentals = $this->users_model->location_free_dentals($city);
            if(!empty($get_free_dentals))
            {
                $user_details = $this->users_model->view_profile($user_id);
                foreach($get_free_dentals as $key => $value) {
                    $userData = array();
                    $userData['user_id'] = $this->post('user_id');
                    //$userData['booking_id'] = $this->post('booking_id');
                    $userData['name'] = $this->post('name');
                    $userData['customer_age'] = $this->post('customer_age');
                    $userData['customer_gender'] = $this->post('customer_gender');
                    $userData['date'] = $this->post('date');
                    $userData['time'] = $this->post('time');
                    $userData['mobile'] = $this->post('mobile');
                    $userData['description'] = $this->post('description');
                    $userData['booking_time'] = date("Y-m-d H:i:s");
                    $userData['booking_id'] = $value->user_id;
                    $userData['auth_level'] = $value->auth_level;
                   //print_r($userData);
                    $result = $this->users_model->user_book_appointment($userData);
                    if($result)
                    {
                        $booked_user_details = $this->users_model->view_profile($value->user_id);
                        if($booked_user_details->device_type == "Android" || $booked_user_details->device_type == "IOS")
                        {        
                            
                            $message = "You Have New Appointment Request From ". $user_details ->username;                      
                            $data1['booking_user_id'] = $value->user_id;
                            $data1['user_id'] = $user_details->user_id;
                            $data1['message'] = $message;
                            $data1['message_ar'] ="لديك طلب موعد جديد من"." ".$user_details ->username;
                            $data1['auth_level'] = 4;
                            $data1['date'] = date("Y-m-d");
                            $data1['time'] = date("h:i A");                 
                            $data1['doc'] = date('Y-m-d H:i:s');
                            $insert_notification = $this->users_model->insert_appointment_notification($data1);
                            if($insert_notification)
                            {
                                       if($booked_user_details->lang=='ar')
            		                    {
            		                        $message1 =$data1['message_ar'];
            		                        $title = 'طلب موعد جديد';
            		                    }
            		                    else
            		                    {
            		                        $message1 =$data1['message'];
            		                        $title= 'New Appointment Requset';
            		                    }
                                $s_data['name'] = $booked_user_details->role;
                                $s_data['image'] = $booked_user_details->image;
                                $s_data['date'] = date('Y-m-d H:i:sA');
                                $s_data['message'] = $message1;
                                $s_data['type'] = 'notification';
                                $s_data['title'] =$title;
                                $s_data['body'] = $message1;
                                $s_data['click_action'] = 'com.volive.zorni.Notifications';
                                if($lang=='ar')
                                {
                                    $message = 'تم حجز المواعيد';
                                }
                                else
                                { 
                                    $message = 'Appointment Booked';
                                }
                                if($booked_user_details->device_type =='Android')
                                {
                                    $re1 = send_notification_android($booked_user_details->device_token,$s_data);
                                }  
                                
                                //for ios
                                if($booked_user_details->device_type =='IOS')
                                {
                                    $ss = send_notification_ios($booked_user_details->device_token,$s_data);
                                   
                                }
                            }
                            
                        }
                    }
                }
                if($lang=='ar')
                {
                    $message = 'تم حجز المواعيد';
                }
                else
                { 
                    $message = 'Appointment Booked';
                }
                $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
            }
            else
            {
                /*if($lang=='ar')
                {
                    $message = 'غير قادر على حجز الموعد';
                }
                else
                {                          
                    $message = 'Unable to Book your appointment';
                }
                $json = $this->response(['status'=>FALSE,'message'=>$message], REST_Controller::HTTP_NOT_FOUND);*/
                $message = (@$lang=='en')?'No free dentals Avilable':'لا مجاني الأسنان المتاحة';
                $this->response(['status'=>FALSE,'message'=>$message], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        else
        {
            $message = (@$lang=='en')?'User location not found':'موقع المستخدم غير موجود';
            $this->response(['status'=>FALSE,'message'=>$message], REST_Controller::HTTP_NOT_FOUND);
        }
    }

        public function free_dental_appointments_post()
        {
            $free_dental_id = $this->post('free_dental_id');
            $status = $this->post('status');
            $lang = $this->post('lang');
            $appointments = $this->users_model->free_dental_appointments($free_dental_id,$status);
             if(!empty($appointments))
             {                 
                $count=0;
                 foreach($appointments as $appointment)
                 {
                   $appointments[$count]->ticket_id = "#ZFATI".$appointment->id;
                   $appointments[$count]->image = ($name = $this->users_model->view_profile($appointment->user_id))?@$name->image:'';
                   $count++;
                 }
                 $json = $this->response(['status'=>TRUE,'appointments'=>$appointments],REST_Controller::HTTP_OK);
	     }
	     else
	     {
		        if($lang =='ar')
                        {
                           $message = 'لايوجد بيانات';
                        }
                        else
                        {                         
		          $message = 'No data found';
                        }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
	     }
	    echo json_encode($json);
    
        }

        public function free_dental_appointment_change_status_post() 
    	{      
            $id = $this->input->post("id");          
            $status = $this->input->post("status");
            $user_id = $this->input->post("user_id"); 
            $lang = $this->input->post("lang");
            $booking_id = $this->input->post("booking_id");       
           
           if($status == 1)
           {
           		$data = array("status" => 1);
           		
           		$userData = $this->users_model->get_user_details_based_on_appointment_id($id);
           		$user_appointment_details =$this->users_model->get_appintment_details_based_on_appointment_id($id);
           		$booked_user_details = $this->users_model->view_profile($booking_id);          		          		         		     

		           if($userData->device_type == "Android" || $userData->device_type == "IOS")
		           {
		           	$message = "Your Appointment Is Confirmed With ".$booked_user_details->username." Your Booking Date ".$user_appointment_details->date." Time ".$user_appointment_details->time;		                
		           	$data1['booking_user_id'] = $booking_id;
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message'] = $message;
		           	$data1['message_ar'] = "موعدك مؤكد مع"." ".$booked_user_details->username." "."تاريخ الحجز الخاص بك"." ".$user_appointment_details->date." "." زمن "." ".$user_appointment_details->time;
		           	$data1['date'] = $user_appointment_details->date;
		           	$data1['time'] = $user_appointment_details->time;
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);        	
		           	$res = $this->users_model->update_appointment_status($data, $id);		           			                   
		     		            if($res)
                                {
                                       if($userData->lang=='ar')
            		                    {
            		                        $message1 =$data1['message_ar'];
            		                        $title='تأكيد الموعد';
            		                    }
            		                    else
            		                    {
            		                        $message1 =$data1['message'];
            		                        $title = 'Appointment Conformation';
            		                    } 
		      		       $s_data['name'] = $booked_user_details->role;
		                   $s_data['image'] = $booked_user_details->image;
		                   $s_data['date'] = date('Y-m-d H:i:sA');
		                   $s_data['message'] = $message1;
		                   $s_data['type'] = 'notification';
		                   $s_data['title'] = $title;
		                   $s_data['body'] = 'Your appointment Is confirmed your booked Free dental'.$booked_user_details->username;
		                   $s_data['click_action'] = 'com.volive.zorni.Notifications';                
		                   
		                         if($lang =='ar')
                                         {
                                           $message = 'تم إرسال إشعار التأكيد إلى ';
                                         }
                                         else
                                         {                          
		                            $message = 'Confirmation Notification Sent to ';
                                         }
                                         
		                     //for android
				     if($userData->device_type =='Android')
				     {
				        $re1 = send_notification_android($userData->device_token,$s_data);                                        
                                       $json = $this->response(['status'=>TRUE,'message'=>$message.$userData->username],REST_Controller::HTTP_OK);
				     }				    
				    
				      //for ios
				      if($userData->device_type =='IOS')
				      {
				         $ss = send_notification_ios($userData->device_token,$s_data);
                                         $json = $this->response(['status'=>TRUE,'message'=>$message.$userData->username],REST_Controller::HTTP_OK);
				      }
                                  }
                                  else
                                  {
                                         if($lang =='ar')
                                         {
                                           $message = 'حاول مرة اخرى ';
                                         }
                                         else
                                         {                          
		                            $message = 'Please Try Again';
                                         }
                                      $json = $this->response(['status'=>FALSE],REST_Controller::HTTP_NOT_FOUND);
                                  }
				   				   
		           } 		                    	
           
           }
           else
           {
           	        $data = array("status" =>$status);
                        $userData = $this->users_model->get_user_details_based_on_appointment_id($id);
           		$user_appointment_details = $this->users_model->get_appintment_details_based_on_appointment_id($id);
           		$booked_user_details = $this->users_model->view_profile($booking_id);           		         		         		     
                          $res = $this->users_model->update_appointment_status($data,$id);
		           if($userData->device_type == "Android" || $userData->device_type == "IOS")
		           {
		              if($status==2)
		              {
		                  $message = "Your Appointment Is Cancelled ".$booked_user_details->username;
		                  $message_ar="الموعد الخاص بك تم إلغاؤه د"." ".$booked_user_details->username;	
		              }
		              else if($status==4)
		              {
		                 $message = "Your Appointment Is Completed With ".$booked_user_details->username." Give Me Your Rating";
		                  $message_ar="اكتمال موعدك مع"." ".$booked_user_details->username;	 
		              }
		           			                
		           	$data1['booking_user_id'] = $booking_id;
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message'] = $message;
		           	$data1['message_ar'] =$message_ar;
		           	$data1['date'] = $user_appointment_details->date;
		           	$data1['time'] = $user_appointment_details->time;
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);       	
		           	//$result = $this->doctors_model->update_medical_advice_status($data,$id);
                       if($insert_notification)
                       {
                                        if($userData->lang=='ar')
            		                    {
            		                        $message1 =$data1['message_ar'];
            		                        $title = 'حالة التعيين';
            		                    }
            		                    else
            		                    {
            		                        $message1 =$data1['message'];
            		                        $title='Appointment Status';
            		                    } 
                                      $s_data['name'] = $booked_user_details->role;
		                      $s_data['image'] = $booked_user_details->image;
		                      $s_data['date'] = date('Y-m-d H:i:sA');
		                      $s_data['message'] = $message1;
		                      $s_data['type'] = 'notification';
		                      $s_data['title'] = $title;
		                      $s_data['body'] = $message1;
		                      $s_data['click_action'] = 'com.volive.zorni.Notifications';              
		                   
		                   
		                     //for android                                       
                                         if($lang =='ar')
                                         {
                                           $message ='تم إرسال إشعار حالة التعيين إلى';
                                         }
                                         else
                                         {                          
		                                    $message = 'Appointment Status Notification Sent to ';
                                         }
                                         
                                         
        				     if($userData->device_type =='Android')
        				     {
        				        $re1 = send_notification_android($userData->device_token,$s_data);
                                                $json = $this->response(['status'=>TRUE,'message'=>$message.$userData->username],REST_Controller::HTTP_OK);
        				     }				    
        				    
        				      //for ios
        				      if($userData->device_type =='IOS')
        				      {
        				         $ss = send_notification_ios($userData->device_token,$s_data);
                                                 $json = $this->response(['status'=>TRUE,'message'=>$message.$userData->username],REST_Controller::HTTP_OK);
        				      }
                      }
                      else
                      {
                             if($lang =='ar')
                             {
                               $message = 'حاول مرة اخرى ';
                             }
                             else
                             {                          
                               $message = 'Please Try Again';
                             }
                            $json = $this->response(['status'=>FALSE],REST_Controller::HTTP_NOT_FOUND);
                      }
		           }           	                      
           }                  
               
    	}
    	
    	public function user_appointment_cancel_post() 
    	{      
            $id = $this->input->post("id");
            $lang = $this->input->post("lang");
            $data = array("status" => 2);
            $appointment_details =$this->users_model->get_appintment_details_based_on_appointment_id($id);
             $date = $appointment_details->date;
              $time = $appointment_details->time;
              $tim = explode('-',$time);
               $date_time =  $date." ".$tim[0];
               $ap_time =  date('Y-m-d H:i:s', strtotime("-1 day", strtotime($date_time)))."<br>";
               $current_time = date("Y-m-d H:m:s");
            //   if($ap_time >= $current_time)
            //   {
                  $result = $this->users_model->update_appointment_status($data,$id);
                   	if($result)
                   	{
                   	    if($lang =='ar')
                         {
                           $message = 'تم إلغاء موعدكأكيد إلى ';
                         }
                         else
                         {                          
                            $message = 'Your Appointment cancelled';
                         }
              
                      $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
                   	}
                   	else
                   	{
                   	    if($lang =='ar')
                         {
                           $message = 'حاول مرة اخرىد إلى ';
                         }
                         else
                         {                          
                            $message = 'Please Try Again';
                         }
                      $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
                   	}
            /*  }
              else
              {
                       if($lang =='ar')
                         {
                           $message ='لا يتم إلغاء موعدك خلال 24 ساعة';
                         }
                         else
                         {                          
                            $message = 'Your appointment is not cancel within 24 hours time';
                         }
                      $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
              }*/
           	
    	}
    	
    	public function user_reconfirm_appointment_post() 
    	{      
            $id = $this->input->post("id");
            $lang = $this->input->post("lang");
            $data['status'] =  $this->input->post("status");;
            //$appointment_details =$this->users_model->get_appintment_details_based_on_appointment_id($id);
             //$data['date'] = $appointment_details->avilable_date;
              //$data['time'] = $appointment_details->avilable_time;
              $result = $this->users_model->update_appointment_status($data,$id);
                if($result)
               	{
               	    if($data['status'] == 1)
               	    {
               	         if($lang =='ar')
                         {
                           $message = 'أعيد تأكيد موعدك بنجاح';
                         }
                         else
                         {                          
                            $message = 'Your Appointment Re-Confirmed successfully';
                         }
               	    }
               	    else
               	    {
               	         if($lang =='ar')
                         {
                           $message = 'أعيد تأكيد موعدك بنجاح';
                         }
                         else
                         {                          
                            $message = 'Your Appointment Cancelled successfully';
                         }
               	    }
               	   
          
                  $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
               	}
               	else
               	{
               	    if($lang =='ar')
                     {
                       $message = 'حاول مرة اخرىد إلى ';
                     }
                     else
                     {                          
                        $message = 'Please Try Again';
                     }
                  $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
               	}
    	}
    	
    	public function add_tweet_post()
    	{
    	        $data['user_id']  = $this->input->post("user_id");
	            $data['tweet_title'] = $this->input->post("tweet_title");
	            $data['tweet_title_ar'] = $this->input->post("tweet_title_ar");
	            $data['tweet'] = $this->input->post("tweet");
	            $data['tweet_ar'] = $this->input->post("tweet_ar");
	            $lang = $this->input->post('lang');
	            
	            $config['upload_path']          = "tweet_images/";
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 10450;
                $config['max_width']            = 105424;
                $config['max_height']           = 76458;

                $this->load->library('upload', $config);

                if($this->upload->do_upload('tweet_image'))
                {
                    if($this->input->post("tweet_image"))
            		{
            		     if($this->input->post("tweet_image") != 'noimage.png')
            		    {	
            		    	$url  = "tweet_images/".$this->input->post("tweet_image");     
            	   		      unlink($url);		    
            		    }
            		}
            		
            	  $data1 = array('upload_data' => $this->upload->data());
                  $data['tweet_image'] = $data1['upload_data']['file_name'];
                        
                }
	            if($this->input->post('id'))
	            {
	                if(!$this->upload->do_upload('tweet_image'))
	                {
	                    $data['tweet_image'] = $this->input->post("tweet_image");
	                }
	            	$id = $this->input->post('id');
	            	$result = $this->users_model->post_tweet($data,$id);
    	           if($result)
    			   {
    		
                        if($lang=='ar')
                        {
                          $message = 'أنت سقسقة تم تحديثها بنجاح';
                        }
                        else
                        {                          
			                $message = 'You are Tweet Successfully Updated';
                        }
	                    $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
    			   }
    			   else
    			   {
    				                if($lang=='ar')
    		                        {
    		                          $message = 'أنت غير قادر على تحديث';
    		                        }
    		                        else
    		                        {                          
    					             $message = 'You are Tweet Unable to Updated';
    		                        }
    				    $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_BAD_REQUEST);
    			   } 
	            		
	            }
	            else
	            {
	            	  $result = $this->users_model->post_tweet($data);
	            	   if($result)
        			   {
        		
        		                        if($lang=='ar')
        		                        {
        		                          $message = 'أنت Tweet لقد تم نشر';
        		                        }
        		                        else
        		                        {                          
        					              $message = 'You are Tweet has Been Posted';
        		                        }
        			              $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
        			   }
        			   else
        			   {
        				                if($lang=='ar')
        		                        {
        		                          $message = 'أنت غير قادر على النشر';
        		                        }
        		                        else
        		                        {                          
        					              $message = 'You are Tweet Unable to Posted';
        		                        }
        				    $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_BAD_REQUEST);
        			   } 
	            		            
	            }	
    	}
    	
    	
        
        public function update_sign_out_time_device_token_post()
        {
             $user_id = $this->post('user_id');
             $lang = $this->input->post('lang');
             $data['device_token'] = ""; 
             $this->users_model->update_last_sign_out_time($user_id);         
             $result = $this->users_model->user_update_profile($data,$user_id);            
                  if($result)
		   {
	
	                        if($lang=='ar')
	                        {
	                          $message = 'تسجيل الخروج بنجاح';
	                        }
	                        else
	                        {                          
				   $message = 'successfully logout';
	                        }
		       $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
		   }
		   else
		   {
			        if($lang=='ar')
	                        {
	                          $message = 'غير قادر على الخروج';
	                        }
	                        else
	                        {                          
				   $message = 'unable to logout';
	                        }
			    $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_BAD_REQUEST);
		   }
	       echo json_encode($json);    
        }
        
    public function free_dental_update_profile_post()
    {
    
    	$data['username'] = $this->input->post('username');
    	$data['dentals'] = $this->input->post('dentals');
    	$data['mobile'] = $this->input->post('mobile');
    	$data['about_dr'] = $this->input->post('about_dr');
    	$data['email'] = $this->input->post('email');
    	$data['location'] = $this->input->post('location');
    	$data['lat'] = $this->input->post('lat');
    	$data['lon'] = $this->input->post('lon');
        $user_id = $this->input->post('user_id');
         $lang = $this->input->post('lang');
    	
	    $config['upload_path']          = "images/";
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10450;
        $config['max_width']            = 105424;
        $config['max_height']           = 76458;

        $this->load->library('upload', $config);

        if($this->upload->do_upload('image'))
        {
        	if($this->input->post("image"))
		{
		     if($this->input->post("image") != 'noimage.png')
		    {	
		    	$url  = "images/".$this->input->post("image");            
	   		unlink($url);		    
		    }
		}
           $image_data = array('upload_data' => $this->upload->data());                
	   $data['image'] = $image_data['upload_data']['file_name'];
	   $result =$this->users_model->user_update_profile($data,$user_id);
	   if($result)
	   {  

                        if($lang=='ar')
                        {
                          $message = 'تم تحديث الملف الشخصي بنجاح';
                        }
                        else
                        {                          
			   $message = 'Profile Updated Successfully';
                        }
                      //$data= $this->users_model->view_profile($user_id);  
                      $data = $this->db->query("select * from users where user_id ='".$user_id."'")->result_array();
                      
	             $json = $this->response([
		    'status'=>TRUE,
		    'data'=>$data,
		    'message'=>$message
		    ],REST_Controller::HTTP_OK);
           }
           else
	   {
		        if($lang=='ar')
                        {
                           $message = 'غير قادر على تحديث ملفك الشخصي';
                        }
                        else
                        {                         
			   $message = 'Unable to Update your profile';
                        }
		    $json = $this->response([
		    'status'=>FALSE,
		    'message'=>$message
		    ],REST_Controller::HTTP_BAD_REQUEST);
	   }                
        }
        else
        {
           $data['image'] = $this->input->post('image');
           $result =$this->users_model->user_update_profile($data,$user_id);
	   if($result)
	   {

                        if($lang=='ar')
                        {
                          $message = 'تم تحديث الملف الشخصي بنجاح';
                        }
                        else
                        {                          
			              $message = 'Profile Updated Successfully';
                        }
               // $data= $this->users_model->view_profile($user_id);
               $data = $this->db->query("select * from users where user_id ='".$user_id."'")->result_array();
               
	       $json = $this->response([
		    'status'=>TRUE,
		    'data'=>$data,
		    'message'=>$message
		    ],REST_Controller::HTTP_OK);
	   }
	   else
	   {
		                if($lang=='ar')
                        {
                          $message = 'غير قادر على تحديث ملفك الشخصي';
                        }
                        else
                        {                          
			            $message = 'Unable to Update your profile';
                        }
                        
		    $json = $this->response([
		    'status'=>FALSE,		    
		    'message'=>$message
		    ],REST_Controller::HTTP_BAD_REQUEST);
	   } 
        }     	
    
    }
                
     public function free_dental_delete_appointment_post()
   	 {    
	     $id = $this->post('id');
             $lang = $this->input->post('lang');
             $result = $this->users_model->delete_cancelled_appointment($id);
             if($result)
             {
                        if($lang=='ar')
                        {
                          $message = 'تم حذف الموعد بنجاح';
                        }
                        else
                        {                          
			   $message = 'Appointment  was successfully deleted';
                        }
                 $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
	     }
	     else
	     {
                        if($lang=='ar')
                        {
                          $message = 'غير قادر على حذفها';
                        }
                        else
                        {                          
			  $message = 'Unable To Deleted';
                        }
		$json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
	     }
	    echo json_encode($json);    
   	 }
   	 
   	    	    
	    public function get_doctor_notifications_post()
	    {
	    	$user_id = $this->post('user_id');
	        $lang = $this->input->post('lang');
	         $auth_level = $this->input->post('auth_level');
	         if($auth_level==2)
	         {
	             if($lang=="ar")
    	         {
    	             $notifications = $this->db->query("select users.*,notifications.message_ar as message,notifications.date,notifications.time from users join notifications on users.user_id =notifications.user_id where notifications.booking_user_id =$user_id and notifications.auth_level=2 order by notifications.id desc")->result();
    	         }
    	         else
    	         {
    	             $notifications = $this->db->query("select users.*,notifications.message,notifications.date,notifications.time from users join notifications on users.user_id=notifications.user_id where notifications.booking_user_id=$user_id and notifications.auth_level=2 order by notifications.id desc")->result();
    	         }
	         }
	         else
	         {
	             if($lang=="ar")
    	         {
    	             $notifications = $this->db->query("select users.*,notifications.message_ar as message,notifications.date,notifications.time from users join notifications on users.user_id =notifications.user_id where notifications.booking_user_id =$user_id and notifications.auth_level=4 order by notifications.id desc")->result();
    	         }
    	         else
    	         {
    	             $notifications = $this->db->query("select users.*,notifications.message,notifications.date,notifications.time from users join notifications on users.user_id=notifications.user_id where notifications.booking_user_id=$user_id and notifications.auth_level=4 order by notifications.id desc")->result();
    	         }
	         }
	         
	    	
	    	if(!empty($notifications))
	    	{
	    		$json = $this->response(['status'=>TRUE,'notifications'=>$notifications],REST_Controller::HTTP_OK);
	    	}
	    	else
	    	{
		           if($lang=='ar')
                    {
                      $message = 'لايوجد بيانات';
                    }
                    else
                    {                          
		               $message = 'No data found';
                    }
	            $json = $this->response([
	                'status' => FALSE,
	                'message' =>$message
	            ], REST_Controller::HTTP_NOT_FOUND);
	    	}
	    	echo json_encode($json);	    
	    }
	    
	    public function get_notes_get($user_id,$lang="")
	    {
	        if($lang=='ar')
	        {
	            $notes = $this->db->query("select id,user_id,tweet_title_ar as tweet_title,tweet_ar as tweet,tweet_image,date from tweets where user_id = '".$user_id."' order by id desc")->result();
	        }
	        else
	        {
	             $notes = $this->db->query("select id,user_id, tweet_title,tweet,tweet_image,date from tweets where user_id = '".$user_id."' order by id desc")->result();
    	      
	        }
	        $notess  = $this->users_model->view_profile($user_id);
	        $count=0;
	        foreach($notes as $note)
	        {
	               $notes[$count]->username = $notess->username;
	               $notes[$count]->clinic_name = $notess->clinic_name;
	               $notes[$count]->image = $notess->image;
	               $notes[$count]->location = $notess->location;
	               $count++;
	        }
	        if(!empty($notes))
	        {
	            $json = $this->response(['status'=>TRUE,'tweets'=>$notes],REST_Controller::HTTP_OK);
	        }
	        else
	        {
	                    if($lang=='ar')
                        {
                          $message = 'لايوجد بيانات';
                        }
                        else
                        {                          
		          $message = 'No data found';
                        }
		      $json = $this->response(['status'=>FALSE,'message'=>$message],REST_Controller::HTTP_NOT_FOUND);
	        }
	    }
	    
	 public function get_free_dentals_city_base_post()
    {
    	$city = $this->post('city');
    	$lang = $this->post('lang');
    	//$free_dentals = $this->users_model->get_users($auth_level=4);    	

   // $free_dentals = $this->db->query("select * from users where auth_level = 4 and city LIKE '%".$city."%'")->result_array();
    $free_dentals = $this->db->query("Select users.*,avg(followers_ratings.ratings) as ratings from users left join followers_ratings on users.user_id= followers_ratings.rater_id where users.status = 1 and users.auth_level =4 and city LIKE '%".$city."%' group by users.user_id")->result_array();
  // print_r($free_dentals);
  // die;
   
    $count = 0;
	foreach($free_dentals as $row) 
	{	  	    
	     $id = $row['user_id'];	    
	     $offers = $this->db->get_where('offers',array('user_id'=>$id,'status'=>1))->result_array();	 
	     $free_dentals[$count]['offer'] = ($offers)?$offers:'';
        $free_dentals[$count]['ratings'] = number_format((float)$row['ratings'], 1, '.', '');
        //($row['ratings'])?$row['ratings']:'';
	     $count++;
	}
        if(!empty($free_dentals))
        {        	       
	            		       		
 		$json = $this->response(['status'=>TRUE,'free_dentals'=>$free_dentals], REST_Controller::HTTP_OK);
               
        }
        else
        {
                if($lang=='ar')
                {
                  $message = 'لايوجد بيانات';
                }
                else
                {                          
	              $message = 'No data found';
                }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        echo json_encode($json);
    }
    
    public function doctor_cancel_user_chat_post()
    {
    	$user_id = $this->post('user_id');
    	$doctor_id = $this->post('doctor_id');
        $lang = $this->input->post('lang');
    	$result = $this->db->query("update doctor_medical_advices set status=4 where user_id=$user_id and doctor_id=$doctor_id");
    	if($result)
    	{
    		      if($lang=='ar')
                    {
                      $message ='الدردشة مغلقة';
                    }
                    else
                    {                          
	          $message = 'Chat is closed';
                    }
	      $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
    	}
    	else
    	{
		        if($lang=='ar')
                    {
                      $message ='غير قادر على الدردشة قريبة';
                    }
                    else
                    {                          
		         $message = 'unable to chat close';
                    }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
    	}
	    	echo json_encode($json);	    
	    }
	    
	    public function total_count_appointments_post()
	    {
	        $user_id = $this->post('user_id');
	        $auth_level = $this->post('auth_level');
	        if($auth_level==2)
	        {
	           $count_requests['pending'] = $this->db->query("select count(doctor_id) as count_appointments from doctor_medical_advices where status=0 and doctor_id=$user_id")->row()->count_appointments;
	           $count_requests['confirm'] = $this->db->query("select count(doctor_id) as count_appointments from doctor_medical_advices where status=1 and doctor_id=$user_id")->row()->count_appointments;
	           $count_requests['completed'] = $this->db->query("select count(doctor_id) as count_appointments from doctor_medical_advices where status=4 and doctor_id=$user_id")->row()->count_appointments;
	           $count_requests['cancel'] = $this->db->query("select count(doctor_id) as count_appointments from doctor_medical_advices where status=2 and doctor_id=$user_id")->row()->count_appointments;
	        }
	        else if($auth_level==4)
	        {
	            $count_requests['pending'] = $this->db->query("select count(booking_id) as count_appointments from appointments where status=0 and auth_level=4 and booking_id=$user_id")->row()->count_appointments;
	            $count_requests['confirm'] = $this->db->query("select count(booking_id) as count_appointments from appointments where status=1 and auth_level=4 and booking_id=$user_id")->row()->count_appointments;
	            $count_requests['completed'] = $this->db->query("select count(booking_id) as count_appointments from appointments where status=4 and auth_level=4 and booking_id=$user_id")->row()->count_appointments;
	            $count_requests['cancel'] = $this->db->query("select count(booking_id) as count_appointments from appointments where status=2 and auth_level=4 and booking_id=$user_id")->row()->count_appointments;
	        }
	        
	        if(!empty($count_requests))
	        {
	            $json = $this->response(['status'=>TRUE,'count_appointments'=>$count_requests],REST_Controller::HTTP_OK);
	        }
	        else
	        {
	            $json = $this->response(['status'=>FALSE],REST_Controller::HTTP_NOT_FOUND);
	        }
		   
	    }
	    
	    public function delete_free_dental_conversion_post()
	    {
	         $sender_id = $this->input->post('sender_id');
	         $reciver_id = $this->input->post('reciver_id');
	         $lang = $this->input->post('lang');
	         $result = $this->users_model->delete_free_dental_conversion($sender_id,$reciver_id);
	        if($result)
	    	{
	    		      if($lang=='ar')
                        {
                          $message ='التحويل المحذوف بنجاح';
                        }
                        else
                        {                          
		                    $message = 'Conversion Deleted Successfully';
                        }
		      $json = $this->response(['status'=>TRUE,'message'=>$message],REST_Controller::HTTP_OK);
	    	}
	    	else
	    	{
    		        if($lang=='ar')
                    {
                      $message = 'حدثت بعض المشاكل ، يرجى المحاولة مرة أخرى';
                    }
                    else
                    {                     
			          $message = 'Some problem occurred, please try again';
                    }
	            $json = $this->response([
	                'status' => FALSE,
	                'message' =>$message
	            ], REST_Controller::HTTP_NOT_FOUND);
	    	}
	    	echo json_encode($json);
	    }
	    
	public function user_give_ratings_post()
    {
    	$data['user_id'] = $this->post('user_id');
    	$data['rater_id'] = $this->post('rater_id');
    	$data['ratings'] = $this->post('ratings');
    	$data['auth_level'] = $this->post('auth_level');
    	$data['appointment_id'] = $this->post('id');
    	$data1['user_id'] = $this->post('user_id');
    	$data1['rater_id'] = $this->post('rater_id');
    	$data1['auth_level'] = $this->post('auth_level');
    	$data1['appointment_id'] = $this->post('id');
        $lang = $this->input->post('lang');
        $b= date('Y-m-d');
        $a= date('h:m:s a');
        $data['date']=$b." ".$a;
    	$result = $this->users_model->chack_following_status($data1);
    	if($result)
    	{
            if($lang=='ar')
            {
             $message = 'تقييمك بالفعل';
            }
            else
            {                     
	            $message = 'Your ratings Already Given';
            }
    		$json = $this->response(['status'=>FALSE,
    		'message'=>$message
    		], REST_Controller::HTTP_NOT_FOUND);
    	}
    	else
    	{
    	    $result = $this->users_model->follow($data);
        	if($result)
        	{
    		    if($lang=='ar')
    			{
    			 $message = 'تم التقديم بنجاح';
    			}
    			else
    			{
    			 $message = 'Successfully Submitted';
    			}
        		$json = $this->response(['status'=>TRUE,
        		'message'=>$message
        		], REST_Controller::HTTP_OK);
        	}
        	else
        	{
                if($lang=='ar')
                {
                     $message = 'غير قادر على التقديم';
                }
                else
                {                     
		            $message = 'Unable to Submitted';
                }
        		$json = $this->response(['status'=>FALSE,
        		'message'=>$message
        		], REST_Controller::HTTP_NOT_FOUND);
        	}
    	}
    	 echo json_encode($json);
    }
	    
    public function user_update_language_post()
    {
        $userData['lang'] = $this->post('lang');
        $user_id = $this->post('user_id');
        $result = $this->users_model->user_update_profile($userData,$user_id);
        if($result)
        {
               if($userData['lang'] =='ar')
                {
                 $message ='اللغة تغيرت بنجاح';
                }
                else
                {                     
		             $message = 'Language successfully changed';
                }
            $json = $this->response([
                'status' => TRUE,
                'message' =>$message
            ], REST_Controller::HTTP_OK);
        }
        else
        {
                if($userData['lang'] =='ar')
                {
                    $message = 'حدثت بعض المشاكل ، يرجى المحاولة مرة أخرى';
                }
                else
                {                     
		             $message = 'Some problem occurred, please try again.';
                }
            $json = $this->response([
                'status' => FALSE,
                'message' =>$message
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    //Payment Getway Apis
    // For Android
    public function check_payment_post()
	{
			$amount = $this->post('amount');
			
	        mt_srand((double)microtime()*10000);
	        $charid = md5(uniqid(rand(), true));
	        $c = unpack("C*",$charid);
	        $c = implode("",$c);
	        $c = substr($c,0,15);
	        
	        //$url = "https://oppwa.com/v1/checkouts";
	        $url  = "https://test.oppwa.com/v1/checkouts";
	    	$data = "authentication.userId=8a8294186659221201665e4dd62612ed" .
	    		"&authentication.password=6BChhs8srQ" .
	    		"&authentication.entityId=8a8294186659221201665e4e207e12f1" .
	    		"&merchantTransactionId=".$c.
	    		"&amount=".$amount.
	    		"&currency=SAR" .
	    		"&paymentType=DB" .
	    		"&customer.givenName=" .$this->post('first_name').
	            "&customer.surname=" .$this->post('last_name').
	            "&customer.email=" .$this->post('email').
	            "&billing.city=" .$this->post('city').
	            "&billing.state=" .$this->post('state').
	            "&billing.street1=".$this->post('city').
	    		"&billing.country=SA".
	    		"&shopperResultUrl=customui://callback" .
	    		"&notificationUrl=http://www.example.com/notify";
	    
	    	$ch = curl_init();
	    	curl_setopt($ch, CURLOPT_URL, $url);
	    	curl_setopt($ch, CURLOPT_POST, 1);
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
	    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    	$responseData = curl_exec($ch);
	    	if(curl_errno($ch)) {
	    		return curl_error($ch);
	    	}
	    	curl_close($ch);
	    	//return $responseData;
	        
	        $data = json_decode($responseData);
		    $data->TransactionId = $c;
	        print_r(json_encode($data));
	}

//package check_out id creating for android.
	public function package_check_payment_post()
	{
			$amount = $this->post('amount');
			
	        mt_srand((double)microtime()*10000);
	        $charid = md5(uniqid(rand(), true));
	        $c = unpack("C*",$charid);
	        $c = implode("",$c);
	        $c = substr($c,0,15);
	        
	        //$url = "https://oppwa.com/v1/checkouts";
	        $url  = "https://test.oppwa.com/v1/checkouts";
	    	$data = "authentication.userId=8a8294186659221201665e4dd62612ed" .
	    		"&authentication.password=6BChhs8srQ" .
	    		"&authentication.entityId=8a8294186659221201665e4e207e12f1" .
	    		"&merchantTransactionId=".$c.
	    		"&amount=".$amount.
	    		"&currency=SAR" .
	    		"&paymentType=DB" .
	    		"&customer.givenName=" .$this->post('first_name').
	            "&customer.surname=" .$this->post('last_name').
	            "&customer.email=" .$this->post('email').
	            "&billing.city=" .$this->post('city').
	            "&billing.state=" .$this->post('state').
	            "&billing.street1=".$this->post('city').
	    		"&billing.country=SA".
	    		"&shopperResultUrl=customui2://callback" .
	    		"&notificationUrl=http://www.example.com/notify";
	    
	    	$ch = curl_init();
	    	curl_setopt($ch, CURLOPT_URL, $url);
	    	curl_setopt($ch, CURLOPT_POST, 1);
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
	    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    	$responseData = curl_exec($ch);
	    	if(curl_errno($ch)) {
	    		return curl_error($ch);
	    	}
	    	curl_close($ch);
	    	//return $responseData;
	        
	        $data = json_decode($responseData);
		    $data->TransactionId = $c;
	        print_r(json_encode($data));
	}
	
	//For Ios
	    public function check_payment1_post()
	{
			$amount = $this->post('amount');
			
	        mt_srand((double)microtime()*10000);
	        $charid = md5(uniqid(rand(), true));
	        $c = unpack("C*",$charid);
	        $c = implode("",$c);
	        $c = substr($c,0,15);
	        
	        //$url = "https://oppwa.com/v1/checkouts";
	        $url  = "https://test.oppwa.com/v1/checkouts";
	    	$data = "authentication.userId=8a8294186659221201665e4dd62612ed" .
	    		"&authentication.password=6BChhs8srQ" .
	    		"&authentication.entityId=8a8294186659221201665e4e207e12f1" .
	    		"&merchantTransactionId=".$c.
	    		"&amount=".$amount.
	    		"&currency=SAR" .
	    		"&paymentType=DB" .
	    		"&customer.givenName=" .$this->post('first_name').
	            "&customer.surname=" .$this->post('last_name').
	            "&customer.email=" .$this->post('email').
	            "&billing.city=" .$this->post('city').
	            "&billing.state=" .$this->post('state').
	            "&billing.street1=".$this->post('city').
	    		"&billing.country=SA".
	    		"&shopperResultUrl=volive.ZORNI://callback" .
	    		"&notificationUrl=http://www.example.com/notify";
	    
	    	$ch = curl_init();
	    	curl_setopt($ch, CURLOPT_URL, $url);
	    	curl_setopt($ch, CURLOPT_POST, 1);
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
	    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    	$responseData = curl_exec($ch);
	    	if(curl_errno($ch)) {
	    		return curl_error($ch);
	    	}
	    	curl_close($ch);
	    	//return $responseData;
	        
	        $data = json_decode($responseData);
		    $data->TransactionId = $c;
	        print_r(json_encode($data));
	}

	/*function request1_get() 
	{	    
	    $first_name = explode(' ',trim($this->get('first_name')))[0];
	    //$first_name =  preg_replace('/\s+/', '', $this->get('first_name'));
	    $last_name = explode(' ',trim($this->get('last_name')))[0];
	       
	 	$amount = $this->get('amount');
	    mt_srand((double)microtime()*10000);
	    $charid = md5(uniqid(rand(), true));
	    $c = unpack("C*",$charid);
	    $c = implode("",$c);
	    $c = substr($c,0,15);
	    $_SESSION['TransactionId'] = $c;
		    //$url  = "https://oppwa.com/v1/checkouts";
			$url  = "https://test.oppwa.com/v1/checkouts";
	    $data = "authentication.userId=8a8294186659221201665e4dd62612ed" .
		"&authentication.password=6BChhs8srQ" .
		"&authentication.entityId=8a8294186659221201665e4e207e12f1" .
		"&merchantTransactionId=".$c.
		"&amount=".$amount.
		"&currency=SAR".
		"&paymentType=DB".
		"&customer.givenName=" .$first_name.
	    "&customer.surname=" .$last_name.
	    "&customer.email=" .$this->get('email').
	    "&billing.city=" .$this->get('city').
	    "&billing.state=" .$this->get('state').
	    "&billing.street1=".$this->get('city').
		"&billing.country=SA".
		"&notificationUrl=http://www.example.com/notify".
		"&shopperResultUrl=volive.ZORNI://callback";	//comgooglemaps-x-callback://	 comgooglemaps:// msdk.HyperPay.async://callback
	    
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); //this should be set to true in production
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$responseData = curl_exec($ch);
		if(curl_errno($ch))
		{
			print_r(curl_error($ch));
		}
		curl_close($ch);

		//print_r($responseData);

		$data = json_decode($responseData);
	    $data->TransactionId = $c;
	    print_r(json_encode($data));
	}*/

	//appointment booking time
	function request_pay_get() 
	{
		$check_out_id = $this->get('check_out_id');		
		$transaction_number = $this->get('TransactionId');//TransactionId
		
		//$this->paynow_get();
		//$url = "https://oppwa.com/v1/checkouts/".@$check_out_id."/payment";
		$url = "https://test.oppwa.com/v1/checkouts/".@$check_out_id."/payment";
		//$url = "https://test.oppwa.com/v1/checkouts/692310A8D53A090058405A2CA039BC41.sbg-vm-tx01/payment";
		$url .= "?authentication.userId=8a8294186659221201665e4dd62612ed";
		$url .= "&authentication.password=6BChhs8srQ";
		$url .= "&authentication.entityId=8a8294186659221201665e4e207e12f1";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$responseData_pay = curl_exec($ch);
		if(curl_errno($ch)) 
		{
			//return curl_error($ch);
			print_r($ch);
			//print_r(json_decode($ch));
		}		
		curl_close($ch);		
		 //return $responseData_pay;		 
         //print_r($responseData_pay);
        // die;
		 $data1 = json_decode($responseData_pay);

		//print_r($data1);
        //die;
		if($data1->result->code != '')//for test mode
		{
			////////PAYMET STATAUS CHECK//////////
				$data = array();
			$data['booking_id']   	= $this->get('booking_id');
			$data['user_id']   	= $this->get('user_id');
			//$data['appointment_id'] = $this->get('appointment_id');
			$data['user_payment_time']	= date('Y-m-d H:i:s');
			$data['transaction_number']	= $transaction_number;
			$data['check_out_id']	=	$check_out_id;
			$data['amount']	=	$this->get('amount');
			/*$transaction_data = [
				'booking_id'=>($data['booking_id'])?@$data['booking_id']:'',
				'user_id'=>($data['user_id'])?@$data['user_id']:'',
				'package_id'=>($data['package_id'])?@$data['package_id']:'',
				'user_payment_time'=>($data['user_payment_time'])?@$data['user_payment_time']:'',
				'transaction_number'=>($data['transaction_number'])?@$data['transaction_number']:'',
				'check_out_id'=>($data['check_out_id'])?@$data['check_out_id']:'',
				'amount'=>($data['amount'])?@$data['amount']:''
			];*/
			$this->db->insert('transactions_details',$data);
			$insert_id = $this->db->insert_id();
		////////PAYMENT END//////////
		$message_en = "Your Payment Send Successfully your transaction number is ".$data['transaction_number']." and Amount is ".$data['amount'];	
		
		 $message_ar ="إرسال الدفعة بنجاح رقم المعاملة الخاص بك   ".$data['transaction_number']."  بقيمة  ".$data['amount']."  ريال سعودي";
			
			$userdata = $this->db->get_where('users',array('user_id' =>$data['user_id']))->row();
  			
  			        $notification['booking_user_id'] = $this->get('booking_id');
		           	$notification['user_id'] = $this->get('user_id');
		           	$notification['message'] = $message_en;
		           	$notification['message_ar'] = $message_ar;		           	
		           	$notification['doc'] = date('Y-m-d H:i:s');
		         
		           $this->db->insert('notifications',$notification);		
  			
  			if($userdata->lang == 'en')
			{
				$message = $message_en;
				$title ='Payment Status';	
			}else{
				$message = $message_ar;
				$title = 'حالة السداد';
			}			

	          $s_data['date'] = date('Y-m-d H:i:sA');
	          $s_data['message'] = $message;
	          $s_data['type'] = 'notification';
	          $s_data['title'] = $title;
	          $s_data['body'] = $message;
	          $s_data['click_action'] = 'com.volive.zorni.Notifications'; 
			
  			if($userdata->device_type == 'IOS')
			{				 
				$re1 = send_notification_android($userdata->device_token,$s_data);
			}
			
			if($userdata->device_type == 'Android')
			{			
				$re1 = send_notification_android($userdata->device_token,$s_data);
			}

			$json = $this->response(['status' =>TRUE,'message'=>$message,'payment_id'=>$insert_id], REST_Controller::HTTP_OK);			          
		}
		else
		{
	           if($userdata->lang == 'ar')
               {
                  $message1 = 'حدثت بعض المشاكل ، يرجى المحاولة مرة أخرى';
                }else{                          
					$message1 = 'Some problem occurred, please try again';
                }
                $json = $this->response(['status' => FALSE,'message'=>$data1], REST_Controller::HTTP_NOT_FOUND);                            
		}
	}

    //appointment booking time
    function package_request_pay_get() 
    {
        $check_out_id = $this->get('check_out_id');     
        $transaction_number = $this->get('TransactionId');//TransactionId
        
        //$this->paynow_get();
        //$url = "https://oppwa.com/v1/checkouts/".@$check_out_id."/payment";
        $url = "https://test.oppwa.com/v1/checkouts/".@$check_out_id."/payment";
        //$url = "https://test.oppwa.com/v1/checkouts/692310A8D53A090058405A2CA039BC41.sbg-vm-tx01/payment";
        $url .= "?authentication.userId=8a8294186659221201665e4dd62612ed";
        $url .= "&authentication.password=6BChhs8srQ";
        $url .= "&authentication.entityId=8a8294186659221201665e4e207e12f1";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData_pay = curl_exec($ch);
        if(curl_errno($ch)) 
        {
            //return curl_error($ch);
            print_r($ch);
            //print_r(json_decode($ch));
        }       
        curl_close($ch);        
         //return $responseData_pay;         
         //print_r($responseData_pay);
        // die;
         $data1 = json_decode($responseData_pay);

        //print_r($data1);
        //die;
        if($data1->result->code != '')//for test mode
        {
            ////////PAYMET STATAUS CHECK//////////
            $data = array();
            $data['package_id']     = $this->get('package_id');
            if ($this->get('user_id')) {
                $data['user_id']        = $this->get('user_id');
            }            
           // $data['appointment_id'] = $this->get('appointment_id');
            $data['user_payment_time']  = date('Y-m-d H:i:s');
            $data['transaction_number'] = $transaction_number;
            $data['check_out_id']   =   $check_out_id;
            $data['amount'] =   $this->get('amount');
            
            $this->db->insert('transactions_details',$data);
            $insert_id = $this->db->insert_id();

        ////////PAYMENT END//////////
        $message_en = "Your Payment Send Successfully your transaction number is ".$data['transaction_number']." and Amount is ".$data['amount'];   
        
         $message_ar ="إرسال الدفعة بنجاح رقم المعاملة الخاص بك   ".$data['transaction_number']."  بقيمة  ".$data['amount']."  ريال سعودي";
            if(@$data['user_id']) 
            {
                $userdata = $this->db->get_where('users',array('user_id' =>$data['user_id']))->row();            
                //Updating User Package
            $userData['package_id'] = $data['package_id'];
            $userData['package_buy_date'] = date('Y-m-d');
            $userData['package_price'] = $data['amount'];           
            $userData['payment_id'] = $insert_id;
            $package_id = $userData['package_id'];
            $package_details = $this->db->query("select * from packages where id =$package_id")->row();
           $months = $package_details->months." "."months";
           $userData['package_expire_date'] = date('Y-m-d',strtotime("+ $months", strtotime($userData['package_buy_date'])));
           $result = $this->users_model->user_update_profile($userData,$data['user_id']);
                //Ending Package Update
            
                    $notification['booking_user_id'] =0; //$this->get('booking_id');
                    $notification['user_id'] = $this->get('user_id');
                    $notification['auth_level'] = 4;
                    $notification['message'] = $message_en;
                    $notification['message_ar'] = $message_ar;                  
                    $notification['doc'] = date('Y-m-d H:i:s');
                 
                   $this->db->insert('notifications',$notification);        
            
                    if($userdata->lang == 'en')
                    {
                        $message = $message_en;
                        $title ='Payment Status';   
                    }else{
                        $message = $message_ar;
                        $title = 'حالة السداد';
                    }           

                      $s_data['date'] = date('Y-m-d H:i:sA');
                      $s_data['message'] = $message;
                      $s_data['type'] = 'notification';
                      $s_data['title'] = $title;
                      $s_data['body'] = $message;
                      $s_data['click_action'] = 'com.volive.zorni.Notifications'; 
            
                if($userdata->device_type == 'IOS')
                {                
                    $re1 = send_notification_android($userdata->device_token,$s_data);
                }
                
                if($userdata->device_type == 'Android')
                {           
                    $re1 = send_notification_android($userdata->device_token,$s_data);
                }

                $json = $this->response(['status' =>TRUE,'message'=>$message], REST_Controller::HTTP_OK);               
            }
            else
            {
                $json = $this->response(['status' =>TRUE,'message'=>$message_en,'payment_id'=>$insert_id], REST_Controller::HTTP_OK);
            }                             
        }
        else
        {
               if($userdata->lang == 'ar')
               {
                  $message1 = 'حدثت بعض المشاكل ، يرجى المحاولة مرة أخرى';
                }else{                          
                    $message1 = 'Some problem occurred, please try again';
                }
                $json = $this->response(['status' => FALSE,'message'=>$data1], REST_Controller::HTTP_NOT_FOUND);                            
        }
    }

    /*public function check_package_status_get($user_id)
    {       
        $data2 = $this->db->get_where('users',array('user_id'=> $user_id))->row();
        print_r($data2);
        die;
        if($data2->package_expire_date >= date('Y-m-d')){            
    	   $json = $this->response('status' => TRUE], REST_Controller::HTTP_OK);		
    	}else{   		
            $json = $this->response('status' => FALSE], REST_Controller::HTTP_BAD_REQUEST);
    	}
    }*/		
}

            

?>
