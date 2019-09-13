<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Free_dentals extends CI_Controller 
{

    public function __construct() 
    { 
        parent::__construct();
    }
    
    public function dashboard()
    {
	    $this->load->view('header');
	    $this->load->view('free_dentals/dashboard');    
    }   
    
    public function update_profile()
    {
    
    	$data['username'] = $this->input->post('username');
    	$data['dentals'] = $this->input->post('dentals');
    	$data['mobile'] = $this->input->post('mobile');
    	$data['about_dr'] = $this->input->post('about_dr');
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
	       redirect('free_dentals/edit_profile');
	   }
	   else
	   {
	      $this->session->set_flashdata('msg','Unable to Update Your Profile');
	      redirect('free_dentals/edit_profile');
	   }              
        }
        else
        {
           $data['image'] = $this->input->post('image');
           $result =$this->users_model->user_update_profile($data,$this->session->userdata('user_id'));
	   if($result)
	   {
	       $this->session->set_flashdata('msg','Profile was successfully Updated');
	       redirect('free_dentals/edit_profile');
	   }
	   else
	   {
	      $this->session->set_flashdata('msg','Unable to Update Your Profile');
	      redirect('free_dentals/edit_profile');
	   } 
        }     	
    
    }   
    
    public function edit_profile()
    {
    	$data['free_dental_details'] = $this->users_model->view_profile($this->session->userdata('user_id'));
    	$data['user_data'] = $this->users_model->view_profile($this->session->userdata('user_id'));
    	$this->load->view('header');
    	$this->load->view('free_dentals/edit_profile',$data);
    }
    
         public function get_pending_apointments()
   	 {
   	   $data['pending_appointments'] = $this->clinics_model->free_dental_appointments ($this->session->userdata('user_id'),$status = '0');   	     	  
   	   $this->load->view('header');
   	   $this->load->view('free_dentals/pending_appointments',$data);
   	 }
   	 
   	 public function get_confirmed_appointments()
   	 {
   	   $data['confirmed_appointments'] = $this->clinics_model->free_dental_appointments ($this->session->userdata('user_id'),$status = '1');   	  
   	   $this->load->view('header');
   	   $this->load->view('free_dentals/confirmed_appointments',$data);
   	 }
   	 
   	 public function get_cancelled_appointments()
   	 {
   	   $data['cancelled_appointments'] = $this->clinics_model->free_dental_appointments ($this->session->userdata('user_id'),$status = '2');   	  
   	   $this->load->view('header');
   	   $this->load->view('free_dentals/cancelled_appointments',$data);
   	 }
   	 
   	 public function delete_appointment($id)
   	 {
	    $this->users_model->delete_cancelled_appointment($id);
	    $this->session->set_flashdata('msg','Record was successfully deleted');
	    redirect('free_dentals/get_cancelled_appointments');
   	 }    
}
?>