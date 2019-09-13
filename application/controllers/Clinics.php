<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clinics extends CI_Controller 
{

    public function __construct() 
    { 
        parent::__construct();
         $this->load->helper("notification_helper");
    } 
    
    public function dashboard()
    {
	    $this->load->view('header');
	    $this->load->view('clinics/dashboard');    
    }  
    
    public function update_profile()
    {
    
    	$data['clinic_name'] = $this->input->post('clinic_name');
    	$data['clinic_manager_name'] = $this->input->post('clinic_manager_name');
    	$data['clinic_number'] = $this->input->post('clinic_number');
    	$data['email'] = $this->input->post('email');
    	$data['working_hours'] = $this->input->post('working_hours');
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
	   $result =$this->users_model->user_update_profile($data,$user_id = $this->session->userdata('user_id'));
	   if($result)
	   {
	       $this->session->set_flashdata('msg','Profile was successfully Updated');
	       redirect('clinics/edit_profile');
	   }
	   else
	   {
	      $this->session->set_flashdata('msg','Unable to Update Your Profile');
	      redirect('clinics/edit_profile');
	   }                
        }
        else
        {
           $data['image'] = $this->input->post('image');
           $result =$this->users_model->user_update_profile($data,$this->session->userdata('user_id'));
	   if($result)
	   {
	       $this->session->set_flashdata('msg','Profile was successfully Updated');
	       redirect('clinics/edit_profile');
	   }
	   else
	   {
	      $this->session->set_flashdata('msg','Unable to Update Your Profile');
	      redirect('clinics/edit_profile');
	   } 
        }     	
    
    }
    
    public function doctors()
    {
    	$data['doctors'] = $this->clinics_model->get_doctors_by_clinic($this->session->userdata('user_id'));
    	$provided_services = $this->users_model->view_profile($this->session->userdata('user_id'))->provided_services;    	
    	$data['services'] = $this->clinics_model->get_clinic_provided_services($provided_services);    	
    	$this->load->view('header');
    	$this->load->view('clinics/clinic_doctors',$data);
    }    
    
    public function edit_profile()
    {
    	if(!$this->session->userdata('user_id'))
    	{
    		redirect('users/login');
    	}
    	$data['clinic_details'] = $this->users_model->view_profile($this->session->userdata('user_id'));
    	$data['user_data'] = $this->users_model->view_profile($this->session->userdata('user_id'));
    	$this->load->view('header');
    	$this->load->view('clinics/edit_profile',$data);
    }
    
    public function doctor_add()
	{
		$data = array(
				'clinic_id' => $this->session->userdata('user_id'),
				'name' => $this->input->post('name'),
				'about' => $this->input->post('about'),
				'about_ar' => $this->input->post('about_ar'),
				'mobile' => $this->input->post('mobile'),
				'email' => $this->input->post('email'),
				'service' => $this->input->post('service')
			);
		$insert = $this->clinics_model->doctor_add($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function avilable_time($user_id,$id)
	{
		$data['user_id'] = $user_id;
		$data['id'] = $id;
		$this->load->view('header');
		$this->load->view('clinics/avilable_time',$data);
	}
	
	 public function send_avilable_time()
   	 {
   		
	           $data['user_id'] = $this->input->post("user_id");
	           $data['date'] = $this->input->post("date");
	            $time = date('h:i A',strtotime($this->input->post("time")));
	           $timestamp = strtotime($time) + 60*60;
                $time2 = date('h:i A', $timestamp);
              $data['time'] = $time.'-'.$time2;
	           $id = $this->input->post("id");
	           $data['clinic_id'] =  $this->session->userdata('user_id');
	           $clinic = $this->users_model->view_profile($data['clinic_id']);
	           $data['doc'] = date('Y-m-d H:i:s');
	           $data['message'] = "Your Requeste From ".$clinic->clinic_name." Updated Clinic Avilable date is ".$data['date']." and time is ".$data['time']." This ".$clinic->clinic_name." If You Avilable This time Please Re-confirming The Appointment From Reservation Section ";
	           $results1 = $this->clinics_model->clinic_avilable_time($data);
		           	$data2['booking_user_id'] = $this->session->userdata('user_id');
		           	
		           	$data2['user_id'] = $this->input->post("user_id");
		           	$data2['message'] = $data['message'];
		           	$data2['message_ar'] ="يرجى تحديث طلبك من "." ".$clinic->clinic_name." "." ، يجب التوجه لقسم الحجوزات لإعادة تأكيد الموعد المتاح للعيادة"." ".$data['date']." "." والوقت المتاح هو "." ".$data['time']." "."التاريخ المتاح هو ".$data['date'];
		           	$msg_ar = $clinic->clinic_name." "."تحديث التاريخ والوقت المتاحين إذا كنت متوافراً هذه المرة يرجى إعادة تأكيد الموعد من قسم الحجز";
		           	$data2['date'] = date("Y-m-d");
		           	$data2['time'] = date("h:i A");
		           	$data2['doc'] = date('Y-m-d H:i:s');
		           	//print_r($data2);exit;
		           	$insert_notification = $this->users_model->insert_appointment_notification($data2);
	           $data1['date'] = $data['date'];
	           $data1['time'] = $data['time'];
	           $data1['status'] = 3;
	           
	           $results = $this->users_model->update_appointment_status($data1,$id);
	            if($results)
	            {
	                $user_id = $this->input->post("user_id");
	                $userdata  = $this->users_model->view_profile($user_id);
	                
	                $clinic  = $this->users_model->view_profile($data['clinic_id']);
	            	$this->email->from('zorni@clinic.com', 'zorni');
                    $this->email->to($userdata->email);           
	                $this->email->subject('Clinic Avilable Timings');
	                $this->email->message("Your Requeste From Clinic is Updated  Avilable date '".$data['date']."' and time is '".$data['time']."'.  Clinic Avilable Timings .If Yoou Have Intrest to Attend This Date and time please confirm this appointment");        
	                $email = $this->email->send();
	                if($email)
	                {
	                    if($userdata->device_type == "Android" || $userdata->device_type == "IOS")
		                {
		                    
		                    if($userdata->lang =='ar')
		                    {
		                        $message =$msg_ar;
		                        $title ="المواعيد المتاحة للعيادة";
		                    }
		                    else
		                    {
		                        $message =$data2['message'];
		                        $title = 'Clinic Available Timing';
		                    }
		                    $s_data['name'] = $clinic->role;
		                    $s_data['image'] = $clinic->image;
		                    $s_data['date'] = date('Y-m-d H:i:s A');
		                    $s_data['message'] = $message;
		                    $s_data['type'] = 'notification';
		                    $s_data['title'] = $title;
		                    $s_data['body'] = $message;
		                    $s_data['click_action'] = 'com.volive.zorni.Notifications';   
		                    /*print_r($s_data);
		                    die;*/
		                    if($userdata->device_type =='Android')
        				     {
        				        $re1 = send_notification_android($userdata->device_token,$s_data);
        				         $this->session->set_flashdata('msg','Successfully Sent');
	            	            redirect('users/get_pending_appointments'); 
        				     }				    
        				    
        				      //for ios
        				      if($userdata->device_type =='IOS')
        				      {
        				         $ss = send_notification_ios_new($userdata->device_token,$s_data);
        				          $this->session->set_flashdata('msg','Successfully Sent');
	            	            redirect('users/get_pending_appointments'); 
        				      }	
		                }
	                    
	                    
	                }
	                else
	                {
	                    if($userdata->device_type == "Android" || $userdata->device_type == "IOS")
		                {
		                    
		                    if($userdata->lang=='ar')
		                    {
		                        $message =$data2['message_ar'];
		                    }
		                    else
		                    {
		                        $message =$data2['message'];
		                    }
		                    $s_data['name'] = $clinic->role;
		                    $s_data['image'] = $clinic->image;
		                     $s_data['date'] = date('Y-m-d H:i:sA');
		                    $s_data['message'] = $message;
		                    $s_data['type'] = 'notification';
		                    $s_data['title'] = 'Clinic Avilable Timings';
		                    $s_data['body'] = $message;
		                    $s_data['click_action'] = 'com.volive.zorni.Notifications';   
		                    if($userdata->device_type =='Android')
        				     {
        				        $re1 = send_notification_android($userdata->device_token,$s_data);
        				         $this->session->set_flashdata('msg','Successfully Sent');
	            	            redirect('users/get_pending_appointments'); 
        				     }				    
        				    
        				      //for ios
        				      if($userdata->device_type =='IOS')
        				      {
        				         $ss = send_notification_ios($userdata->device_token,$s_data);
        				          $this->session->set_flashdata('msg','Successfully Sent');
	            	            redirect('users/get_pending_appointments'); 
        				      }
		                }
	                } 
	            	
	            }
	            else
	            {
	            	
	            	$this->session->set_flashdata('msg','Unable to Send Avilable Time');
	            	redirect('users/get_pending_appointments');
	            }
   	 }
	
	public function ajax_edit($id)
	{
		$data = $this->clinics_model->get_by_id($id);	
		
		/*$ser_id =  $data->service;
		
		$data1 = $this->clinics_model->get_service_name_by_id($ser_id);
		//print_r($data1);
		$data->ser_name = $data1->service_name;*/
		echo json_encode($data);
	}
	
	public function doctor_update()
	{
		$data = array(				
				'name' => $this->input->post('name'),
				'about' => $this->input->post('about'),
				'about_ar' => $this->input->post('about_ar'),
				'mobile' => $this->input->post('mobile'),
				'email' => $this->input->post('email'),
				'service' => $this->input->post('service')
			);
		$this->clinics_model->doctor_update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function doctor_delete($id)
	{
		$this->clinics_model->delete_doctor_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	
	public function change_doctor_status() 
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
	           $res = $this->clinics_model->update_doctor_status($data,$id);  
   	 }
   	    	   	 
   
}
?>