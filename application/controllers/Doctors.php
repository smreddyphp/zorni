<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Doctors extends CI_Controller 
{

    public function __construct() 
    { 
        parent::__construct();
    }
    
    public function dashboard()
    {
	    $this->load->view('header');
	    $this->load->view('doctors/dashboard');    
    }  
    
    public function update_profile()
    {
    
    	$data['username'] = $this->input->post('username');    	
    	$data['about_dr'] = $this->input->post('about_dr');
    	$data['mobile'] = $this->input->post('mobile');
    	$data['dr_fees'] = $this->input->post('dr_fees');
    	$data['email'] = $this->input->post('email');
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
	       redirect('doctors/edit_profile');
	   }
	   else
	   {
	      $this->session->set_flashdata('msg','Unable to Update Your Profile');
	      redirect('doctors/edit_profile');
	   }                
        }
        else
        {
           $data['image'] = $this->input->post('image');
           $result =$this->users_model->user_update_profile($data,$this->session->userdata('user_id'));
	   if($result)
	   {
	       $this->session->set_flashdata('msg','Profile was successfully Updated');
	       redirect('doctors/edit_profile');
	   }
	   else
	   {
	      $this->session->set_flashdata('msg','Unable to Update Your Profile');
	      redirect('doctors/edit_profile');
	   } 
        }     	
    
    }    
    
    
    public function edit_profile()
    {
    	$data['doctor_details'] = $this->users_model->view_profile($this->session->userdata('user_id'));    	
    	$data['user_data'] = $this->users_model->view_profile($this->session->userdata('user_id'));
    	$this->load->view('header');
    	$this->load->view('doctors/edit_profile',$data);
    }
    
    	public function change_medical_advice_status() 
    	{      
           $id = $this->input->post("id");          
           $status = $this->input->post("status");           
           
           if($status == 1)
           {
           		$data = array("status" => 1);

           		$userData = $this->doctors_model->get_user_details_based_on_medical_advice_id($id);
           		//$user_appointment_details = $this->users_model->get_appintment_details_based_on_appointment_id($id);
           		$doctor_details = $this->users_model->view_profile($this->session->userdata('user_id'));  
           		//$booked_user_details = $this->users_model->view_profile(5);          		         		     

		           if($userData->device_type == "Android" || $userData->device_type == "IOS")
		           {		           	   
		           	$message = 'Your Medical Advice Request Is Confirmed chat With Doctor';		                
		           	/*$data1['booking_user_id'] = $this->session->userdata('user_id');
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message'] = $message;
		           	$data1['date'] = $user_appointment_details->date;
		           	$data1['time'] = $user_appointment_details->time;
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);	*/	           	
		           	$res = $this->doctors_model->update_medical_advice_status($data,$id);		           			                   
		     		   
		      		   $s_data['name'] = $doctor_details->user_name;
		                   $s_data['image'] = $doctor_details ->image;
		                   $s_data['date'] = date('Y-m-d H:i:sA');
		                   $s_data['message'] = $message;
		                   $s_data['type'] = 'notification';
		                   $s_data['title'] = 'Medical Advice Request Conformation';
		                   $s_data['body'] = 'Medical Advice Request conformation notification from your Doctor';
		                   $s_data['click_action'] = 'com.volive.zorni.Notifications';                
		                   
		                   
		                   //for android
				   if($userData->device_type =='Android')
				    {
				     $re1 = send_notification_android($userData->device_token,$s_data);
				    }				    
				    
				    //for ios
				    if($userData->device_type =='IOS')
				    {
				     $ss = send_notification_ios($userData->device_token,$s_data);
				    }
				   // echo $n_data;				   
		           } 		                    	
           
           }
           else
           {
           	 $data = array("status" => 2);
           	 $res = $this->doctors_model->update_medical_advice_status($data,$id);           
           }           
                        
             
    	}
      	 
   	 
   	public function get_pending_medical_advices()
   	 {
   	   $data['pending_medical_advices'] = $this->doctors_model->get_medical_advices($this->session->userdata('user_id'),$status = '0');   	     	  
   	   $this->load->view('header');
   	   $this->load->view('doctors/pending_medical_advices',$data);
   	 }
   	 
   	 public function get_confirmed_medical_advices()
   	 {
   	   $data['confirmed_medical_advices'] = $this->doctors_model->get_medical_advices($this->session->userdata('user_id'),$status = '1');   	  
   	   $this->load->view('header');
   	   $this->load->view('doctors/confirmed_medical_advices',$data);
   	 }
   	 
   	 public function get_cancelled_medical_advices()
   	 {
   	   $data['cancelled_medical_advices'] = $this->doctors_model->get_medical_advices($this->session->userdata('user_id'),$status = '2');   	  
   	   $this->load->view('header');
   	   $this->load->view('doctors/cancelled_medical_advices',$data);
   	 }
   	 
   	 public function delete_advice_request($id)
   	 {
   	    $medical_slip = $this->doctors_model->get_medical_advice_document($id);
   	    if(!empty($medical_slip))
   	    {
   	    	$url  = "medical_slips/".$medical_slip;            
	   	unlink($url);	
   	    }
	    $this->doctors_model->delete_medical_advice_request($id);
	    $this->session->set_flashdata('msg','Advice Request was successfully deleted');
	    redirect('doctors/get_cancelled_medical_advices');
   	 } 
   	 
   	    
}
?>