<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller 
{

    public function __construct() 
    { 
        parent::__construct();  
         $this->load->helper("notification_helper");
         $this->check_session();
    } 
    
    public function dashboard()
    {
	    $this->load->view('header');
	    $this->load->view('admin/dashboard');    
    }

    public function check_session()
    {
        if($this->session->userdata('user_id') == "")
        {
            redirect('users/login');
        }
    }
    
    public function update_profile()
    {
    	$data['username'] = $this->input->post('username');
    	$data['email'] = $this->input->post('email');
    	$data['mobile'] = $this->input->post('mobile');
    	$data['location'] = $this->input->post('location');
    	
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
	   $result =$this->users_model->user_update_profile($data,$this->session->userdata('user_id'));
	   if($result)
	   {
	       $this->session->set_flashdata('msg','Profile was successfully Updated');
	       redirect('admin/edit_profile');
	   }
	   else
	   {
	      $this->session->set_flashdata('msg','Unable to Update Your Profile');
	      redirect('admin/edit_profile');
	   }                
        }
        else
        {
           $data['image'] = $this->input->post('image');
           $result =$this->users_model->user_update_profile($data,$this->session->userdata('user_id'));
	   if($result)
	   {
	       $this->session->set_flashdata('msg','Profile was successfully Updated');
	       redirect('admin/edit_profile');
	   }
	   else
	   {
	      $this->session->set_flashdata('msg','Unable to Update Your Profile');
	      redirect('admin/edit_profile');
	   } 
        }     	
    
    }
    
    public function update_fees()
    {
        $data['dr_fees'] = $this->input->post('dr_fees');
    	$user_id = $this->input->post('user_id');
    	$result =$this->users_model->user_update_profile($data,$user_id);
    	if($result)
    	{
    	    $this->session->set_flashdata('msg','Dr.Fees was successfully Updated');
	      redirect('admin/get_active_doctors');
    	}
    	else
    	{
    	     $this->session->set_flashdata('msg','Unable to Update Dr Fees');
	      redirect('admin/get_active_doctors');
    	}
    }
    
    public function clinic_view($user_id)
    {
        //$user_id  =$this->input->post('user_id');
    	$data['user_data'] = $this->users_model->view_profile($user_id);
    	$data['followers'] = $this->users_model->get_followers($user_id);
    	$data['tweets'] = $this->users_model->get_tweets($user_id);
    	$data['ratings'] = $this->users_model->get_ratings($user_id);
    	$data['appointments'] = $this->clinics_model->clinic_all_appointments($user_id);
    	$data['doctors'] = $this->clinics_model->get_doctors_by_clinic($user_id);
    	$data['offers'] = $this->users_model->get_offers($user_id);
    	$this->load->view('header');
    	$this->load->view('admin/clinic_view_profile',$data);
    }
    
    public function doctor_view($user_id)
    {
    	//$user_id  =$this->input->post('user_id');    	
    	$data['user_data'] = $this->users_model->view_profile($user_id);
    	$data['followers'] = $this->users_model->get_followers($user_id);
    	$data['ratings'] = $this->users_model->get_ratings($user_id);
    	$data['tweets'] = $this->users_model->get_tweets($user_id);
    	$data['medical_advices'] = $this->doctors_model->doctor_all_medical_advice_requests($user_id);
    	$data['doctors'] = $this->clinics_model->get_doctors_by_clinic($user_id);
    	$data['offers'] = $this->users_model->get_offers($user_id);
    	$this->load->view('header');
    	$this->load->view('admin/doctor_view_profile',$data);
    }
    
    public function free_dental_view($user_id)
    {
    	$data['user_data'] = $this->users_model->view_profile($user_id);
    	$data['followers'] = $this->users_model->get_followers($user_id);
    	$data['tweets'] = $this->users_model->get_tweets($user_id);
    	$data['ratings'] = $this->users_model->get_ratings($user_id);
    	$data['appointments'] = $this->clinics_model->clinic_all_appointments($user_id);    	
    	$data['offers'] = $this->users_model->get_offers($user_id);
    	$this->load->view('header');
    	$this->load->view('admin/free_dental_view_profile',$data);
    }

    public function get_active_clinics()
    {
        $data['clinics'] = $this->admin_model->get_users($auth_level = 3);
        $this->load->view('header');
        $this->load->view('admin/active_clinics',$data);
    }
    
    public function get_pending_clinics()
    {
        $data['clinics'] = $this->admin_model->get_pending_users($auth_level = 3,$status = 0);
        $this->load->view('header');
        $this->load->view('admin/pending_clinics',$data);
    }       

    public function get_active_doctors()
    {
        $data['doctors'] = $this->admin_model->get_users($auth_level = 2);
        $this->load->view('header');
        $this->load->view('admin/active_doctors',$data);
    }
    
    public function get_active_users()
    {
        $data['users'] = $this->admin_model->get_pending_users($auth_level = 1,$status = 1);
        $this->load->view('header');
        $this->load->view('admin/active_users',$data);
    }
    
    public function get_deactive_users()
    {
        $data['users'] = $this->admin_model->get_pending_users($auth_level = 1,$status = 2);
        $this->load->view('header');
        $this->load->view('admin/pending_users',$data);
    }
    
    public function user_view_profile($user_id='')
    {
    	if(empty($user_id))
    	{
    	   $user_id = $this->session->userdata('user_id');
    	}
    	$data['user_data'] = $this->users_model->view_profile($user_id);
    	$data['appointments'] = $this->db->query("select * from appointments where auth_level = 3 and user_id = '".$user_id."'")->result();
    	$data['freedental_appointments'] = $this->db->query("select * from appointments where auth_level = 4 and user_id = '".$user_id."'")->result();
    	$data['medical_advices'] = $this->db->query("select * from doctor_medical_advices where user_id = '".$user_id."'")->result();
    	$this->load->view('header');
	    $this->load->view('admin/user_view_profile',$data);
    } 
    
    public function get_pending_doctors()
    {
        $data['doctors'] = $this->admin_model->get_pending_users($auth_level = 2,$status = 0);
        $this->load->view('header');
        $this->load->view('admin/pending_doctors',$data);
    }
    
    public function active_free_dentals()
    {
        $data['free_dentals'] = $this->admin_model->get_users($auth_level = 4);
        $this->load->view('header');
        $this->load->view('admin/active_free_dentals',$data);
    }
    
    public function pending_free_dentals()
    {
        $data['free_dentals'] = $this->admin_model->get_pending_users($auth_level = 4,$status = 0);
        $this->load->view('header');
        $this->load->view('admin/pending_free_dentals',$data);
    }     

    public function changeUserstatus() 
    {      
        $user_id = $this->input->post("id");
        $status = $this->input->post("status");
         $user = $this->users_model->view_profile($user_id);
         if ($status == 1)
         {
             $data = array("status" => 1);
             $email = $this->users_model->view_profile($user_id)->email;     
             $res = $this->admin_model->updateuserData($data, $user_id);
             if($user->auth_level==3)
             {
                 $this->email->from('zorni@volive.com','zorni');
                 $this->email->to($email);           
    	         $this->email->subject('Zorni Administrator');
    	         $this->email->message('Your Request Admin Approved Please Login Here '.' http://www.volivesolutions.com/zorni.');          
    	         $email = $this->email->send();  
             }
             else
             {
                 $this->email->from('zorni@volive.com','zorni');
                 $this->email->to($email);           
    	         $this->email->subject('Zorni Administrator');
    	         $this->email->message('Your Request Admin Approved You Can Login in App');          
    	         $email = $this->email->send();  
             }
         } 
          else if($status == 3)
         {                     
             $data = array("status" => 3);
             //$email = $this->users_model->view_profile($user_id)->email;
             $res = $this->admin_model->updateuserData($data, $user_id);
             /*$this->email->from('zorni@volive.com', 'zorni');
             $this->email->to($email);           
	     $this->email->subject('Zorni Administrator');
	     $this->email->message('Your Request Admin Approved Please Login Here '.' http://www.volivesolutions.com/zorni.');            
	     $email = $this->email->send();*/
         }                
             
    }
    
    public function active_deactive_user() 
    {      
        $id = $this->input->post("id");
        $status = $this->input->post("status");
         
         if ($status == 1) 
         {
             $data = array("status" => 2);
                        
         } 
        else 
         {                     
             $data = array("status" => 1);
            
         } 
         $res = $this->admin_model->updateuserData($data, $id);                
             
    }
    
    public function delete_doctor($user_id)
    {	
    	$this->admin_model->delete_offers($user_id);
    	$this->admin_model->delete_tweets($user_id);
    	$this->admin_model->delete_followers($user_id);
    	$this->admin_model->delete_ratings($user_id);
    	$this->admin_model->delete_appointments($user_id);
    	$result = $this->admin_model->delete_user_data($user_id);
    	$this->session->set_flashdata('msg','doctor was successfully deleted');
    	redirect('admin/get_active_doctors');
    }
    
    public function delete_clinic($user_id)
    {
    	$this->admin_model->delete_offers($user_id);
    	$this->admin_model->delete_tweets($user_id);
    	$this->admin_model->delete_followers($user_id);
    	$this->admin_model->delete_ratings($user_id);
    	$this->admin_model->delete_clinic_doctors($user_id);
    //	$this->admin_model->delete_appointments($user_id);
    	$result = $this->admin_model->delete_user_data($user_id);
    	$this->session->set_flashdata('msg','clinic was successfully deleted');
    	redirect('admin/get_active_clinics');
    }
    
    public function delete_free_dental($user_id)
    {
    	$this->admin_model->delete_offers($user_id);
    	$this->admin_model->delete_tweets($user_id);
    	$this->admin_model->delete_followers($user_id);
    	$this->admin_model->delete_ratings($user_id);
    	$this->admin_model->delete_appointments($user_id);
    	$result = $this->admin_model->delete_user_data($user_id);
    	$this->session->set_flashdata('msg','free dental was successfully deleted');
    	redirect('admin/active_free_dentals');
    }
    
     public function delete_user($user_id)
    {
    	
    	$this->admin_model->delete_followings_raters($user_id);    	
    	$this->admin_model->delete_bookings($user_id);
    	$result = $this->admin_model->delete_user_data($user_id);
    	$this->session->set_flashdata('msg','User was successfully deleted');
    	redirect('admin/get_active_users');
    }
    
    public function edit_profile()
    {
    	$data['admin_details'] = $this->users_model->view_profile($this->session->userdata('user_id'));
    	$data['user_data'] = $this->users_model->view_profile($this->session->userdata('user_id'));
    	$this->load->view('header');
    	$this->load->view('admin/edit_profile',$data);
    }
    
    public function get_provided_services()
    {	
      $data['provided_service'] = $this->admin_model->get_provided_services();
      $this->load->view('header');
       $this->load->view('admin/provided_services',$data);
    }       
        
        public function add_services($id = "")
   	 {
   		if(!empty($id))
   		{
   		  $data1['service'] = $this->admin_model->get_service_by_id($id);
   		}
   		
   		$data1['servicae'] = "services";
	        $this->form_validation->set_rules('service_name','Service Name','required');
	        $this->form_validation->set_rules('service_name_ar','Service Name In Arabic','required');	       
	        if($this->form_validation->run() === false)
	        {
	            $this->load->view('header'); 
   	 	        $this->load->view('admin/add_service',$data1);
	        }
	        else
	        {
	            
		      $data['service_name'] = $this->input->post("service_name");
		      $data['service_name_ar'] = $this->input->post("service_name_ar");
		            
		        $config['upload_path']          = "icons/";
		        $config['allowed_types']        = 'gif|jpg|png';
		        $config['max_size']             = 10450;
		        $config['max_width']            = 105424;
		        $config['max_height']           = 76458;
		
		        $this->load->library('upload', $config);
		
		        if($this->upload->do_upload('icon'))
		        {
		        	if($this->input->post("icon"))
				{
				    if($this->input->post("icon") != 'noimage.png')
				    {	
				    	$url  = "icons/".$this->input->post("icon");            
			   		unlink($url);		    
				    }	
				}
           			$image_data = array('upload_data' => $this->upload->data());                
	   			$data['icon'] = $image_data['upload_data']['file_name'];
		            if($this->input->post('id'))
		            {
		            	$id = $this->input->post('id');		            	
		            	$result = $this->admin_model->update_service_status($data,$id);
		            	$this->session->set_flashdata('msg','You are Service Successfully Updated');	
		            }
		            else
		            {
		            	$result = $this->admin_model->service_add($data);
		            	$this->session->set_flashdata('msg','You are Service has Been Added');	            
		            }
		            
		        }
		        else
		        {
		        	    if($this->input->post('id'))
			            {
			            	$id = $this->input->post('id');
			            	$data['icon']= $this->input->post("icon");
			            	$result = $this->admin_model->update_service_status($data,$id);
			            	$this->session->set_flashdata('msg','You are Service Successfully Updated');	
			            }
			            else
			            {
			            	$result = $this->admin_model->service_add($data);
			            	$this->session->set_flashdata('msg','You are Service has Been Added');	            
			            }		        
		        }
		        	            	          
		         redirect('admin/get_provided_services');
		 }
   	 	
   	 }
        
        
    public function update_service_status() 
    {      
        $id = $this->input->post("id");
        $status = $this->input->post("status");
         if ($status == 1) 
         {
             $data = array("status" => 0);
         } 
        else 
         {                     
             $data = array("status" => 1);
         } 
         $res = $this->admin_model->update_service_status($data, $id);
    }
    
    public function update_insurances_status() 
    {      
        $id = $this->input->post("id");
        $status = $this->input->post("status");
         
         if ($status == 1) 
         {
             $data = array("status" => 0);
                        
         } 
        else 
         {                     
             $data = array("status" => 1);
            
         } 
         $res = $this->admin_model->update_insurance_status($data, $id);    
    }
    
    public function insurances()
    {	
       $data['accepted_insurances'] = $this->admin_model->get_accepted_insurances();
       $this->load->view('header');
       $this->load->view('admin/accepted_insurances',$data);
    }
    
    	public function add_insurance()
	{		 				
	       $data = array(
	       'insurance_name' => $this->input->post('insurance_name'),
	       'insurance_name_ar' => $this->input->post('insurance_name_ar')
	       );
		$insert = $this->admin_model->add_insurance($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function insurance_update()
	{
		$data = array(				
				'insurance_name' => $this->input->post('insurance_name'),
	       			'insurance_name_ar' => $this->input->post('insurance_name_ar')
			);
		$this->admin_model->insurance_update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function packages()
	{
		$data['packages'] = $this->admin_model->get_packages();
		$this->load->view('header');
		$this->load->view('admin/packages',$data);
	}
	
	    public function update_package_status() 
	    {      
	        $id = $this->input->post("id");
	        $status = $this->input->post("status");
	         
	         if ($status == 1) 
	         {
	             $data = array("status" => 0);
	                        
	         } 
	        else 
	         {                     
	             $data = array("status" => 1);
	            
	         } 
	         $res = $this->admin_model->update_package_status($data, $id);                
	             
	    }
	    
	public function package_add()
	{
		$data = array(
				'package_name' => $this->input->post('package_name'),
				'package_name_ar' => $this->input->post('package_name_ar'),
				'price' => $this->input->post('price'),
				'months' => $this->input->post('months'),
				'doctors' => $this->input->post('doctors'),
				'books' => $this->input->post('books'),
				'appointments' => $this->input->post('appointments'),
				'free_exams' => $this->input->post('free_exams'),
				'calls' => $this->input->post('calls')
			);
		$insert = $this->admin_model->package_add($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function package_edit($id)
	{
		$data = $this->admin_model->get_package_id($id);		
		echo json_encode($data);
	}
	
	public function insurance_edit($id)
	{
		$data = $this->admin_model->get_insurance_by_id($id);	
		echo json_encode($data);
	}
	
	public function service_edit($id)
	{
		$data = $this->admin_model->get_service_by_id($id);	
		echo json_encode($data);
	}
	
	public function delete_package($id)
	{
		$this->admin_model->delete_package_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	
	public function delete_insurance()
	{
		/*$this->admin_model->delete_insurance_by_id($id);
		echo json_encode(array("status" => TRUE));*/
		    
	        $id = $this->input->post("id");
	        $status = $this->input->post("status");
	         
	         if ($status == 1) 
	         {
	             $data = array("status" => 2);
	                        
	         }	        
	         $res = $this->admin_model->update_insurance_status($data, $id);
	}
	
	public function delete_service($id)
	{
			
		 $id = $this->input->post("id");
	        $status = $this->input->post("status");
	         
	         if ($status == 1) 
	         {
	             $data = array("status" => 2);
	                        
	         }	        
	         $res = $this->admin_model->update_service_status($data, $id);  
	}
	
	public function package_update()
	{
		$data = array(				
				'package_name' => $this->input->post('package_name'),
				'package_name_ar' => $this->input->post('package_name_ar'),
				'price' => $this->input->post('price'),
				'months' => $this->input->post('months'),
				'doctors' => $this->input->post('doctors'),
				'books' => $this->input->post('books'),
				'appointments' => $this->input->post('appointments'),
				'free_exams' => $this->input->post('free_exams'),
				'calls' => $this->input->post('calls')
			);
		$this->admin_model->package_update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function view_document($id)
	{
	  $data['document'] = $this->admin_model->medical_advice_request_view($id);
	  $this->load->view('admin/medical_advice_document_view',$data);
	
	}
	
	public function chat_view_document($message)
	{
	  $data['message'] = $message;
	  $this->load->view('admin/chat_document_view',$data);
	
	}
	
	public function send_push_notification()
	{
	       $this->form_validation->set_rules('send_notification','Select Notifications','required');
	        $this->form_validation->set_rules('title','Tittle','required');
	        $this->form_validation->set_rules('message','Message','required');
	        if($this->form_validation->run() === false)
	        {
	            $this->load->view('header');
	            $this->load->view('admin/push_notifications');
	        }
	        else
	        {
	            $auth_level = $this->input->post('send_notification');
	            $s_data['title'] = $this->input->post('title');
	            $s_data['message'] = $this->input->post('message');
	            $s_data['date'] = date('Y-m-d H:i:sA');
                $s_data['type'] = 'notification';
                $s_data['body'] = $s_data['message'];
                $s_data['click_action'] = 'com.volive.zorni.Notifications';  
	            $users = $this->db->get_where("users",array('auth_level'=>$auth_level,'status'=>1))->result();
	           
	            if($users)
	            {
	                foreach($users as $row)
	                {
	                        //for Android
	                        if($row->device_type=='Android')
        				     {
        				      $re1 = send_notification_android($row->device_token,$s_data);
        				     }				    
        				  
        				      //for ios
        				      if($row->device_type=='IOS')
        				      {
        				        //  echo $row->device_token."</br>";
        				          
        				         $ss = send_notification_ios_new($row->device_token,$s_data);
        				        // print_r($ss);
        				      }	
	                }
	                
	                $res=$this->session->set_flashdata("msg", "Notification Successfully Sent to ".$row->role);
	                
	               redirect('admin/send_push_notification');
	            }
	            else
	            {
	                $this->session->set_flashdata("msg", "No Users Found");
	                redirect('admin/send_push_notification');
	            }
	        }
	}
	
	public function free_dental_chat_view($sender_id,$reciver_id)
	{
	    $data['reciver_id'] = $reciver_id;
	   	$data['sender_id'] = $sender_id;//$this->session->userdata('user_id');
	   	//$data['chat'] = $this->db->where_in('sender_id',$sender_id,FALSE)->where_in('reciver_id',$sender_id,FALSE)->order_by('date_time','ASC')->get('chat')->result();
	   	$this->load->view('header');
	   	$this->load->view('admin/chat_view',$data);
	}

    public function chat()
    {
        $data = array();
        $data['free_dentals'] = $this->admin_model->get_users($auth_level = 4);
        $this->load->view('header');
        $this->load->view('admin/chat_list',$data);
    }
    public function chat_users($dental_id)
    {
        $data = array();
        $data['dental_id'] = $dental_id;
        $free_dentals = $this->admin_model->get_chat_users($dental_id);
        if($free_dentals)
        {
            $users = array();
            $sender_ids = array();
            $reciver_ids = array();
            foreach ($free_dentals as $key => $value) {
                if($dental_id!=$value->sender_id)
                    $sender_ids[] = $value->sender_id;
                if($dental_id!=$value->reciver_id)
                    $reciver_ids[] = $value->reciver_id;
            }
            $sender_ids = array_unique($sender_ids);
            $reciver_ids = array_unique($reciver_ids);
            $ids = array_unique(array_merge($sender_ids,$reciver_ids));
            $data['free_dentals'] = array();
            if($ids)
            {
                foreach ($ids as $key => $value) {
                    $data['free_dentals'][] = $this->users_model->view_profile($value);
                }
            } 

        }
        $this->load->view('header');
        $this->load->view('admin/chat_users_list',$data);
    }	
   
}
?>