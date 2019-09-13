<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller 
{

    public function __construct() 
    { 
        parent::__construct();
        $this->load->helper("notification_helper"); 
        $this->load->library('Push_notifications');
    }
    
    public function mobile_services()
    {
    	$this->load->view('services');
    }
    
    public function index()
    {
        redirect('users/login');
    }

    public function dashboard()
    {
        if(!$this->session->userdata('role'))
        {
            redirect('users/login');
        }
        $this->load->view('header');
        $this->load->view('dashboard');
    }

    public function login()
    {   
        $this->form_validation->set_rules('email','Email','required');
        $this->form_validation->set_rules('pwd','Password','required');
        if($this->form_validation->run() === FALSE)
        {
            $this->load->view('login');
        }
        else
        {
            $userData['email']= $this->input->post('email');
            $userData['password']= md5($this->input->post('pwd'));
            $status = $this->users_model->check_user_credintials($userData);
            if($status)
            {              
                $result = $this->users_model->get_user_details($userData['email']);
                if($result->auth_level == 9 || $result->auth_level == 3 )
                {
                     if($result->status == 1)
                     {
                     	$user_data = array('role'=>$result->role,'auth_level' => $result->auth_level,'email'=>$result->email,'user_id'=>$result->user_id);
	                    $this->session->set_userdata($user_data);
	                    //set message
	                    $this->session->set_flashdata('msg','Now You are Logged In');
	                    redirect('users/dashboard');
                     }
                     else
                     {
                     	$this->session->set_flashdata('msg','Admin Approval Not Completed');
                    	redirect('users/login');                     
                     }
                    
                }
                else
                {
                    $this->session->set_flashdata('msg','You are Not Logged In here');
                    redirect('users/login');
                }               
            }
            else
            {
                //set message
                $this->session->set_flashdata('msg','Invalid Login Credintials');
                redirect('users/login');
            }
        }
    }
    
    public function user_view_profile($user_id='')
    {
    	if(empty($user_id))
    	{
    	   $user_id = $this->session->userdata('user_id');
    	}
    	$data['user_data'] = $this->users_model->view_profile($user_id);
    	$this->load->view('header');
	    $this->load->view('view_profile',$data);
    }
    
    public function chat_send($reciver_id)
    {
        
           $data['sender_id']=$this->session->userdata('user_id');
           $data['reciver_id']=$reciver_id;
        
             $config['upload_path'] = "chat_files/";
             $config['allowed_types'] = 'gif|jpg|png|mov|avi|flv|wmv|mp3|mp4';
             $config['max_size']             = 100450;

          $this->load->library('upload', $config);

         if($this->upload->do_upload('chat_file'))
         {
        	
            $image_data = array('upload_data' => $this->upload->data());

	        $data['message'] = $image_data['upload_data']['file_name'];
	  		$file_type = explode('.', $data['message']);
	  		if($file_type[1] == 'gif' || $file_type[1] == 'jpg' || $file_type[1] =='png')
	  		{
	  		    $data['message_type'] = 2;
	  		}
	  		else if($file_type[1] == 'mp3' || $file_type[1] == 'wmv' || $file_type[1] =='wac' || $file_type[1] =='aac')
	  		{
	  		    $data['message_type'] = 3;
	  		}
	  		else if($file_type[1] == 'mov' || $file_type[1] == 'avi' || $file_type[1] =='flv' || $file_type[1] =='wmv' || $file_type[1] =='mp4')
	  		{
	  		    $data['message_type'] = 4;
	  		}
	  		
	  		$data['date_time'] = date('Y-m-d h:i:s a');
	   	    $message_ins = $this->db->insert('chat',$data);
	   	    redirect('users/chat/'.$data['reciver_id']);
		 }
		 else
		 {
		     redirect('users/chat/'.$data['reciver_id']);
		 }
    }
    
    public function change_password()
    {
    	$current_password = md5($this->input->post('password'));    	
    	$new_password = md5($this->input->post('newpassword'));
        $pwd = $this->users_model->view_profile($this->session->userdata('user_id'))->password;       
         	
    	if($pwd == $current_password)
    	{
		$result = $this->users_model->update_password($this->session->userdata('email'),$new_password);
		if($result)
		{
		 	$this->session->set_flashdata('msg','Password Updated successfully');
			redirect('users/dashboard');
		}
		else
		{
			 $this->session->set_flashdata('msg','Unable to Updated');
			redirect('users/dashboard');
		}
    	}
    	else
    	{
    		 $this->session->set_flashdata('msg','Incorrect Current Password');
    		redirect('users/dashboard');
    	}
    	
    }
    
     public function post_tweet($tweet_id = "")
   	 {
   		if(!empty($tweet_id))
   		{
   		  $data1['tweet'] = $this->users_model->get_single_tweet($this->session->userdata('user_id'),$tweet_id);
   		}
   		    $data1['twehet'] = "tweets";
	        $this->form_validation->set_rules('title','Title','required');
	        $this->form_validation->set_rules('title_ar','Arabic Title','required');
	        $this->form_validation->set_rules('body','Body','required');
	        $this->form_validation->set_rules('body_ar','Arabic Body','required');
	        if($this->form_validation->run()=== false)
	        {
	            $this->load->view('header'); 
   	 	        $this->load->view('users/post_tweet',$data1);
	        }
	        else
	        {
	            $data['user_id']  = $this->session->userdata('user_id');
	            $data['tweet_title'] = $this->input->post("title");
	            $data['tweet_title_ar'] = $this->input->post("title_ar");
	            $data['tweet'] = $this->input->post("body");
	            $data['tweet_ar'] = $this->input->post("body_ar");
	            if(!$this->input->post('id'))
	            {
	            	$id = $this->input->post('id');
	            	$result = $this->users_model->post_tweet($data,$id);
	            	$this->session->set_flashdata('msg','You are Tweet Successfully Updated');	
	            }
	            else
	            {
	            	$result = $this->users_model->post_tweet($data);
	            	$this->session->set_flashdata('msg','You are Tweet has Been Posted');	            
	            }	            	          
	            redirect('users/tweets');
	        }
   	 	
   	 }
   	 
   	 public function ratings()
   	 {
   	 	$data['ratings'] = $this->users_model->get_ratings($this->session->userdata('user_id'));
   	 	$this->load->view('header');
   	 	$this->load->view('users/ratings',$data);
   	 
   	 }
   	 
   	 public function tweets()
   	 {    
   	 	$data['tweets'] = $this->users_model->get_tweets($this->session->userdata('user_id'));
   	 	$this->load->view('header');
   	 	$this->load->view('users/tweets',$data);
   	 }
   	 
   	 public function delete_tweet($id)
   	 {
   	 	$this->users_model->delete_tweet($id);
   	 	redirect('users/tweets');
   	 }
   	 
         public function followers()
   	 {
   	 	$data['followers'] = $this->users_model->get_followers($this->session->userdata('user_id'));
   	 	$this->load->view('header');
   	 	$this->load->view('users/followers',$data);
   	 }

    public function  logout()
    {
    	$this->users_model->update_last_sign_out_time($this->session->userdata('user_id'));    	
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('auth_level');
        $this->session->sess_destroy();

        //set message
        $this->session->set_flashdata('msg','successfully Logged out');
        redirect('users/login');
    }
    
    public function offers()
    {
    	$data['offers'] = $this->users_model->get_offers($this->session->userdata('user_id'));
    	$this->load->view('header');
    	$this->load->view('users/offers',$data);
    }
    
    public function update_offer_status() 
    {      
       $id = $this->input->post("id");
       $status = $this->input->post("status");        
         
         if($status == 1) 
         {
             $data = array("status" => 0);
                       
         } 
         elseif($status == 0)         
         {                     
             $data = array("status" => 1);
             
         } 
          $res = $this->users_model->update_offer_status($data,$id);          
    }
    
    public function offer_add()
	{
		$data = array(
				'user_id' => $this->session->userdata('user_id'),
				'promo_code' => $this->input->post('promo_code'),
				'percentage' => $this->input->post('percentage'),
				'description' => $this->input->post('description'),
				'description_ar' => $this->input->post('description_ar'),
				'expire_date' => $this->input->post('expire_date')
			);
		$insert = $this->users_model->offer_add($data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function ajax_edit($id)
	{
		$data = $this->users_model->get_by_id($id);	
		echo json_encode($data);
	}
	
	public function offer_update()
	{
		$data = array(				
				'promo_code' => $this->input->post('promo_code'),
				'percentage' => $this->input->post('percentage'),
				'description' => $this->input->post('description'),
				'description_ar' => $this->input->post('description_ar'),
				'expire_date' => $this->input->post('expire_date')
			);
		$this->users_model->offer_update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function offer_delete($id)
	{
		$this->users_model->delete_offer_by_id($id);
		echo json_encode(array("status" => TRUE));
	} 
	
	public function change_appointment_status() 
    	{      
           $id = $this->input->post("id");          
           $status = $this->input->post("status");
           
           
           if($status == 1)
           {
           		$data = array("status" => 1);
           		$userData = $this->users_model->get_user_details_based_on_appointment_id($id);
           		$user_appointment_details = $this->users_model->get_appintment_details_based_on_appointment_id($id);
           		$booked_user_details = $this->users_model->view_profile($this->session->userdata('user_id'));
           		
		           if($userData->device_type == "Android" || $userData->device_type == "IOS")
		           {		           	   
		           	$message = "Your Appointment Is Confirmed with ".$booked_user_details->clinic_name." Please Attend The Your Booking Time";		                
		           	$data1['booking_user_id'] = $this->session->userdata('user_id');
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message_ar'] = "موعدك مؤكد مع"." ".$booked_user_details->clinic_name." "."يرجى حضور وقت الحجز الخاص بك";
		           	$data1['message'] = $message;
		           	$data1['date'] = $user_appointment_details->date;
		           	$data1['time'] = $user_appointment_details->time;
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);		           	
		           	$res = $this->users_model->update_appointment_status($data, $id);		           			                   
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
		                   $s_data['body'] = $message1;
		                   $s_data['click_action'] = 'com.volive.zorni.Notifications';                
		                   
		                   
		                   //for android
				    if($userData->device_type =='Android')
				    {
				     $re1 = send_notification_android($userData->device_token, $s_data);
				     
				    }				    
				    
				    //for ios
				    if($userData->device_type == "IOS")
				    {
				        
				     $ss = send_notification_ios($userData->device_token,$s_data);
				    }
				   	
		           } 		                    	
           
           }
           else
           {
           	 $data = array("status" => $status);
           	 $userData = $this->users_model->get_user_details_based_on_appointment_id($id);
           		$user_appointment_details = $this->users_model->get_appintment_details_based_on_appointment_id($id);
           		$booked_user_details = $this->users_model->view_profile($this->session->userdata('user_id'));  
           		//$booked_user_details = $this->users_model->view_profile(5);          		         		     

		           if($userData->device_type == "Android" || $userData->device_type == "IOS")
		           {
		               if($status==2)
		              {
		                  $message = "Your Appointment Is Cancelled with ".$booked_user_details->clinic_name." Your Booking Clinic";
		                  $message_ar=  "تم إلغاء موعدك مع "." ".$booked_user_details->clinic_name." "." عيادة الحجز الخاصة بك";
		              }
		              else
		              {
		                 $message = "Your Appointment Is Completed With ".$booked_user_details->username;
		                  $message_ar="اكتمال موعدك مع"." ".$booked_user_details->username;	 
		              }
		           	
		           	$data1['booking_user_id'] = $this->session->userdata('user_id');
		           	$data1['user_id'] = $userData->user_id;
		           	$data1['message'] = $message;
		           	$data1['message_ar'] =$message_ar;
		           	$data1['date'] = $user_appointment_details->date;
		           	$data1['time'] = $user_appointment_details->time;
		           	$data1['doc'] = date('Y-m-d H:i:s');
		           	$insert_notification = $this->users_model->insert_appointment_notification($data1);        	
		           	$res = $this->users_model->update_appointment_status($data, $id);		
		           	if($userData->lang=='ar')
		           	{
		           	    $message1 = $data1['message_ar'];
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
		                   $s_data['title'] =$title; 
		                   $s_data['body'] = $message1;
		                   $s_data['click_action'] = 'com.volive.zorni.Notifications';                
		                   
		                   
		                   //for android
          				    if($userData->device_type =='Android')
          				    {
          				     $re1 = send_notification_android($userData->device_token, $s_data);
          				     //$result = $this->push_notifications->send_android_notification_user($userData->device_token,$s_data);
          				    }				    
          				    
          				    //for ios
          				    if($userData->device_type =='IOS')
          				    {
          				     //$result = $this->send_ios_notification($userData->device_token, $s_data);
          				     $ss = send_notification_ios($userData->device_token,$s_data);
          				    // echo $userdata->device_token;
          				    }				   	
		           }
           
           } 
    	}
    	
     public function get_pending_appointments()
   	 {

      $this->users_model->ap_update_read_status($this->session->userdata('user_id'));
      //echo $this->db->last_query();
      //die;
   	   $data['pending_appointments'] = $this->users_model->get_appointments($this->session->userdata('user_id'),$status = '0');   	     	  
   	   $this->load->view('header');
   	   $this->load->view('users/pending_appointments',$data);
   	 }
   	 
   	 public function get_confirmed_appointments()
   	 {
   	   $data['confirmed_appointments'] = $this->users_model->get_appointments($this->session->userdata('user_id'),$status = '1');   	  
   	   $this->load->view('header');
   	   $this->load->view('users/confirmed_appointments',$data);
   	 }
   	 
   	 public function get_completed_appointments()
   	 {
   	   $data['completed_appointments'] = $this->users_model->get_appointments($this->session->userdata('user_id'),$status = '4');   	  
   	   $this->load->view('header');
   	   $this->load->view('users/completed_appointments',$data);
   	 }
   	 
   	 public function get_cancelled_appointments()
   	 {
   	   $data['cancelled_appointments'] = $this->users_model->get_appointments($this->session->userdata('user_id'),$status = '2');   	  
   	   $this->load->view('header');
   	   $this->load->view('users/cancelled_appointments',$data);
   	 }
   	 
   	  public function delete_appointment($id)
   	 {
  	    $this->users_model->delete_cancelled_appointment($id);
  	    $this->session->set_flashdata('msg','Record was successfully deleted');
  	    redirect('users/get_cancelled_appointments');
   	 }
   	 
   	 public function chat($reciver_id)
   	 {
  	   	 $data['reciver_id'] = $reciver_id;
  	   	 $data['sender_id'] = $this->session->userdata('user_id');	   	 
  	   	 $this->load->view('header');
  	   	 $this->load->view('users/chat',$data);
   	 } 
   	 
   	 public function chat_view()
   	 {
	   	 $sender_id = $this->input->post('sid');
	   	 $reciver_id = $this->input->post('rid');   	 
	   	 
	   	 $sender_det = $this->users_model->view_profile($sender_id);
	   	 $sender_type = $sender_det->auth_level;
	   	 $sender_image = $sender_det->image;
	
	     $reciver_det = $this->users_model->view_profile($reciver_id);
	     $reciver_name = $reciver_det->username;
	   	 $reciver_image = $reciver_det->image;     
	   	 
	   	 if($sender_type == 3)
	   	 {
	   	 $sender_name = $sender_det->clinic_name;
	   	 }
	   	 else
	   	 {
	   	 $sender_name = $sender_det->username;
	   	 }  
	   	 $messages = $this->users_model->chat_msg($sender_id,$reciver_id);
	   // print_r($messages);
	   	
	
	   	foreach($messages as $row)
	   	{
	   	$fsender_id = $row['sender_id'];
	   	$freciver_id = $row['reciver_id'];
	   	$message = $row['message'];
	   	$date = $row['date_time'];
        $cur_date = date('Y-m-d H:i:s');
        $message_type = $row['message_type'];

  		//date calculate coding
  		$start  = date_create($date);
  		$end 	= date_create($cur_date);
  		$diff = date_diff($start,$end);
  		$diff->y . ' years, ';
  		$diff->m . ' months, ';
  		$diff->d . ' days, ';
  		$diff->h .' hours ';
  		$diff->i . ' mins, ';
  		$diff->s . ' seconds';

  		if($diff->d == 0)
  		{
  			if($diff->h == 0)
  			{
  				$dt=  $diff->i . ' mins ago';
  			}
  			else
  			{
  			$dt= $diff->h .' hours '. $diff->i . ' mins ago';
  			}
  		}
  		elseif($diff->m == 0)
  		{
  			$dt= $diff->d . ' days ago';
  		}
  		else
  		{
  			$dt= $diff->m . ' month  Ago';
  		}

	   	
		   	if($fsender_id == $sender_id)
		   	{  	
		   	
		   	echo '<li class="right clearfix"><span class="chat-img pull-right">
		   	 
		                            <img src="'.base_url().'images/'.$sender_image.'" alt="User Avatar" class="img-circle" />
		                        </span>
		                            <div class="chat-body clearfix">
		                                <div class="header">
		                                    <strong class="pull-right primary-font">'.$sender_name.'</strong>
		 <small class="text-muted"><span class="fa fa-clock-o"></span>'.$dt.'</small>
		                                   
		                                </div>
		                                <p style="text-align:right">';
		                                ?>
		                                <?php
		                                if($message_type == 1)
		                                {
		                                  
		                                  echo $message;
		                                   
		                                }
		                                else if($message_type == 2)
		                                {
		                                    ?>
		                                    <img src="<?php echo base_url();?>/chat_files/<?php echo $message; ?>" alt="no file" style="width:200px;height:200px;">
		                                    <?php
		                                }
		                                else if($message_type == 3)
		                                {
		                                    ?>
		                                    <audio controls>
                                              <source src="<?php echo base_url();?>/chat_files/<?php echo $message; ?>" type="audio/ogg">
                                              <source src="<?php echo base_url();?>/chat_files/'.<?php echo $message; ?>.'" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                            </audio>
		                                    <?php
		                                }
		                                else
		                                {
		                                    ?>
                                        
                                       <a href="<?php echo base_url(); ?>admin/chat_view_document/<?php echo $message; ?>" target = "_blank"><button type="button" class="btn btn-success"><span class="fa fa-video-camera"></span></button></a>
                                        
		                                    <?php
		                                }
		                                ?>
		                                </p>
		                            </div>
		                        <?php echo '</li>'; 
		   	 }
		   	 else
		   	 {
		   	 echo ' <li class="left clearfix"><span class="chat-img pull-left">
		                            <img src="'.base_url().'images/'.$reciver_image.'" alt="User Avatar" class="img-circle" />
		                           <i class="fa fa-circle on-active" aria-hidden="true"></i>
		
		                        </span>
		                            <div class="chat-body clearfix">
		                                <div class="header">
		                                    <strong class="primary-font">'.$reciver_name.'</strong> <small class="pull-right text-muted">
		                                        <span class=" fa fa-clock-o"></span>'.$dt.'</small>
		                                </div>
		                                <p>';
		                                ?>
		                                <?php
		                                if($message_type == 1)
		                                {
		                                  ?>
		                                  <?php
		                                  echo $message; ?>
		                                  <?php  
		                                }
		                                else if($message_type == 2)
		                                {
		                                    ?>
		                                    <img src="<?php echo base_url(); ?>chat_files/<?php echo $message; ?>" alt="empty" style="width:100px;height:50px;">
		                                    <?php
		                                }
		                                else if($message_type == 3)
		                                {
		                                    ?>
		                                    <audio controls>
                                              <source src="<?php echo base_url(); ?>chat_files/<?php echo $message; ?>" type="audio/ogg">
                                              <source src=<?php echo base_url(); ?>chat_files/<?php echo $message; ?>" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                            </audio>
		                                    <?php
		                                }
		                                else
		                                {
		                                    ?>
		                                   
		                                    <a href="<?php echo base_url(); ?>admin/chat_view_document/<?php echo $message; ?>" target = "_blank"><button type="button" class="btn btn-success"><span class="fa fa-video-camera"></span></button></a>
		                                    <?php
		                                }
		                                ?>
		                                </p>
		                            </div>
		                        <?php echo '</li>'; 	   	 
		   	 }	
	   	}
   	
   	}
   	
   	/* public function chat_view()
   	 {
	   	 $sender_id = $this->input->post('sid');
	   	 $reciver_id = $this->input->post('rid');   	 
	   	 
	   	 $sender_det = $this->users_model->view_profile($sender_id);
	   	 $sender_type = $sender_det->auth_level;
	   	 $sender_image = $sender_det->image;
	
	    $reciver_det = $this->users_model->view_profile($reciver_id);
	    $reciver_name = $reciver_det->username;
	   	 $reciver_image = $reciver_det->image;     
	   	 
	   	 if($sender_type == 3)
	   	 {
	   	 $sender_name = $sender_det->clinic_name;
	   	 }
	   	 else
	   	 {
	   	 $sender_name = $sender_det->username;
	   	 }  
	   	 $messages = $this->users_model->chat_msg($sender_id,$reciver_id);
	   // print_r($messages);
	   	
	
	   	foreach($messages as $row)
	   	{
	   	$fsender_id = $row['sender_id'];
	   	$freciver_id = $row['reciver_id'];
	   	$message = $row['message'];
	   	$date = $row['date_time'];
        $cur_date = date('Y-m-d H:i:s');

		//date calculate coding
		$start  = date_create($date);
		$end 	= date_create($cur_date);
		$diff = date_diff($start,$end);
		$diff->y . ' years, ';
		$diff->m . ' months, ';
		$diff->d . ' days, ';
		$diff->h .' hours ';
		$diff->i . ' mins, ';
		$diff->s . ' seconds';

		if($diff->d == 0)
		{
			if($diff->h == 0)
			{
				$dt=  $diff->i . ' mins ago';
			}
			else
			{
			$dt= $diff->h .' hours '. $diff->i . ' mins ago';
			}
		}
		elseif($diff->m == 0)
		{
			$dt= $diff->d . ' days ago';
		}
		else
		{
			$dt= $diff->m . ' month  Ago';
		}

	   	
		   	if($fsender_id == $sender_id)
		   	{  	
		   	
		   	 echo '<li class="right clearfix"><span class="chat-img pull-right">
		                            <img src="'.base_url().'images/'.$sender_image.'" alt="User Avatar" class="img-circle" />
		                        </span>
		                            <div class="chat-body clearfix">
		                                <div class="header">
		                                    <strong class="pull-right primary-font">'.$sender_name.'</strong>
		 <small class="text-muted"><span class="fa fa-clock-o"></span>'.$dt.'</small>
		                                   
		                                </div>
		                                <p style="text-align:right">';
		                                ?>
		                                <?php
		                                if($message_type == 1)
		                                {
		                                  ?>
		                                  echo $message;
		                                  <?php  
		                                }
		                                else if($message_type == 2)
		                                {
		                                    ?>
		                                    <img src="<?php echo base_url();?>/chat_files/'.$message.'" alt="Girl in a jacket" style="width:500px;height:600px;">
		                                    <?php
		                                }
		                                else if($message_type == 3)
		                                {
		                                    ?>
		                                    <audio controls>
                                              <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="audio/ogg">
                                              <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                            </audio>
		                                    <?php
		                                }
		                                else
		                                {
		                                    ?>
		                                    <video width="300" height="200" controls>
                                          <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="video/mp4">
                                          <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="video/ogg">
                                        </video>
		                                    <?php
		                                }
		                                ?>
		                                </p>
		                            </div>
		                        <?php echo '</li>'; 	 
		   	 
		   	 
		   	 }
		   	 else
		   	 {
		   	 echo ' <li class="left clearfix"><span class="chat-img pull-left">
		                            <img src="'.base_url().'images/'.$reciver_image.'" alt="User Avatar" class="img-circle" />
		                           <i class="fa fa-circle on-active" aria-hidden="true"></i>
		
		                        </span>
		                            <div class="chat-body clearfix">
		                                <div class="header">
		                                    <strong class="primary-font">'.$reciver_name.'</strong> <small class="pull-right text-muted">
		                                        <span class=" fa fa-clock-o"></span>'.$dt.'</small>
		                                </div>
		                                <p>';
		                                ?>
		                                <?php
		                                if($message_type == 1)
		                                {
		                                  ?>
		                                  echo $message;
		                                  <?php  
		                                }
		                                else if($message_type == 2)
		                                {
		                                    ?>
		                                    <img src="<?php echo base_url();?>/chat_files/'.$message.'" alt="Girl in a jacket" style="width:500px;height:600px;">
		                                    <?php
		                                }
		                                else if($message_type == 3)
		                                {
		                                    ?>
		                                    <audio controls>
                                              <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="audio/ogg">
                                              <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                            </audio>
		                                    <?php
		                                }
		                                else
		                                {
		                                    ?>
		                                    <video width="300" height="200" controls>
                                          <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="video/mp4">
                                          <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="video/ogg">
                                        </video>
		                                    <?php
		                                }
		                                ?>
		                                </p>
		                            </div>
		                        <?php echo '</li>'; 	   	 
		   	 }	
	   	}
   	
   	}*/
   	
   	public function user_chat_view()
   	 {
	   	 $sender_id = $this->input->post('sid');
	   	 $reciver_id = $this->input->post('rid');   	 
	   	 
	   	 $sender_det = $this->users_model->view_profile($sender_id);
	   	 $sender_type = $sender_det->auth_level;
	   	 $sender_image = $sender_det->image;
	
	    $reciver_det = $this->users_model->view_profile($reciver_id);
	    $reciver_name = $reciver_det->username;
	   	 $reciver_image = $reciver_det->image;     
	   	 
	   	 if($sender_type == 3)
	   	 {
	   	 $sender_name = $sender_det->clinic_name;
	   	 }
	   	 else
	   	 {
	   	 $sender_name = $sender_det->username;
	   	 }  
	   	 $messages = $this->users_model->chat_msg($sender_id,$reciver_id);
	   // print_r($messages);
	   	
	
	   	foreach($messages as $row)
	   	{
	   	$fsender_id = $row['sender_id'];
	   	$freciver_id = $row['reciver_id'];
	   	$message = $row['message'];
	   	$message_type = $row['message_type'];
	   	$date = $row['date_time'];
        $cur_date = date('Y-m-d H:i:s');

		//date calculate coding
		$start  = date_create($date);
		$end 	= date_create($cur_date);
		$diff = date_diff($start,$end);
		$diff->y . ' years, ';
		$diff->m . ' months, ';
		$diff->d . ' days, ';
		$diff->h .' hours ';
		$diff->i . ' mins, ';
		$diff->s . ' seconds';

		if($diff->d == 0)
		{
			if($diff->h == 0)
			{
				$dt=  $diff->i . ' mins ago';
			}
			else
			{
			$dt= $diff->h .' hours '. $diff->i . ' mins ago';
			}
		}
		elseif($diff->m == 0)
		{
			$dt= $diff->d . ' days ago';
		}
		else
		{
			$dt= $diff->m . ' month  Ago';
		}

	   	
		   	if($fsender_id == $sender_id)
		   	{  	
		   	
		   	 echo '<li class="right clearfix"><span class="chat-img pull-right">
		   	 
		                            <img src="'.base_url().'images/'.$sender_image.'" alt="User Avatar" class="img-circle" />
		                        </span>
		                            <div class="chat-body clearfix">
		                                <div class="header">
		                                    <strong class="pull-right primary-font">'.$sender_name.'</strong>
		 <small class="text-muted"><span class="fa fa-clock-o"></span>'.$dt.'</small>
		                                   
		                                </div>
		                                <p style="text-align:right">';
		                                ?>
		                                <?php
		                                if($message_type == 1)
		                                {
		                                  ?>
		                                  echo $message;
		                                  <?php  
		                                }
		                                else if($message_type == 2)
		                                {
		                                    ?>
		                                    <img src="<?php echo base_url();?>/chat_files/'.$message.'" alt="Girl in a jacket" style="width:500px;height:600px;">
		                                    <?php
		                                }
		                                else if($message_type == 3)
		                                {
		                                    ?>
		                                    <audio controls>
                                              <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="audio/ogg">
                                              <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                            </audio>
		                                    <?php
		                                }
		                                else
		                                {
		                                    ?>
		                                    <video width="300" height="200" controls>
                                          <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="video/mp4">
                                          <source src="<?php echo base_url();?>/chat_files/'.$message.'" type="video/ogg">
                                        </video>
		                                    <?php
		                                }
		                                ?>
		                                </p>
		                            </div>
		                        <?php echo '</li>'; 
		   	 }
		   	 else
		   	 {
		   	 echo ' <li class="left clearfix"><span class="chat-img pull-left">
		                            <img src="'.base_url().'images/'.$reciver_image.'" alt="User Avatar" class="img-circle" />
		                           <i class="fa fa-circle on-active" aria-hidden="true"></i>
		
		                        </span>
		                            <div class="chat-body clearfix">
		                                <div class="header">
		                                    <strong class="primary-font">'.$reciver_name.'</strong> <small class="pull-right text-muted">
		                                        <span class=" fa fa-clock-o"></span>'.$dt.'</small>
		                                </div>
		                                <p>';
		                                ?>
		                                <?php
		                                if($message_type == 1)
		                                {
		                                  ?>
		                                  <?php
		                                  echo $message; ?>
		                                  <?php  
		                                }
		                                else if($message_type == 2)
		                                {
		                                    ?>
		                                    <img src="<?php echo base_url(); ?>chat_files/<?php echo $message; ?>" alt="Girl in a jacket" style="width:200px;height:150px;">
		                                    <?php
		                                }
		                                else if($message_type == 3)
		                                {
		                                    ?>
		                                    <audio controls>
                                              <source src="<?php echo base_url(); ?>chat_files/<?php echo $message; ?>" type="audio/ogg">
                                              <source src=<?php echo base_url(); ?>chat_files/<?php echo $message; ?>" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                            </audio>
		                                    <?php
		                                }
		                                else
		                                {
		                                    ?>
		                                    <video width="300" height="200" controls>
                                          <source src="<?php echo base_url(); ?>chat_files/<?php echo $message; ?>" type="video/mp4">
                                          <source src="<?php echo base_url(); ?>chat_files/<?php echo $message; ?>" type="video/ogg">
                                        Your browser does not support the video tag.
                                        </video>
		                                    <?php
		                                }
		                                ?>
		                                </p>
		                            </div>
		                        <?php echo '</li>'; 	   	 
		   	 }	
	   	}
   	
   	}
   	
   	
   	
   	
   	public function chat_message()
   	{
	   	 $sender_id = $this->input->post('sid');
	   	 $reciver_id = $this->input->post('rid');
	   	 $message = $this->input->post('message');
	   	 $message_type =1;
	   	 $date_time = date('Y-m-d H:i:s');
	   	 
	   	 $message_ins = $this->db->insert('chat',array('sender_id'=>$sender_id, 'reciver_id'=>$reciver_id,'message'=>$message,'message_type'=>$message_type,'date_time'=>$date_time));
	         
	         $sender_data = $this->users_model->view_profile($sender_id); 
	         $receiver_data = $this->users_model->view_profile($reciver_id); 
	         
		//echo $receiver_data->device_token; 
                        //notification for chat         
                if($receiver_data->device_type == "Android" || $receiver_data->device_type == "IOS")
		           {		           	   
		           	   
		      		   $s_data['name'] = $sender_data->username;
		                   $s_data['image'] = $sender_data->image;
		                   $s_data['date'] = date('Y-m-d H:i:sA');
		                   $s_data['message'] = $message;
		                   $s_data['type'] = 'message';
		                   $s_data['title'] = $sender_data->clinic_name;
		                   $s_data['reciver_id'] = $sender_id;
		                   $s_data['body'] = $message;
		                   $s_data['click_action'] = 'com.volive.zorni.chat.ChatActivity'; 
		                   
		                   //for android
				    if($receiver_data->device_type =='Android')
				    {
				     //$re1 = send_notification_android($receiver_data->device_token, $s_data);
				     $result = $this->push_notifications->send_android_notification_user($receiver_data->device_token,$s_data);
				    }				    
				    
				    //for ios
				    if($receiver_data->device_type =='IOS')
				    {
				     $ss = send_notification_ios($receiver_data->device_token,$s_data);
				    }
				   //print_r($s_data);				    
				   //echo $n_data = json_encode($s_data);				   
		           }   	 
   	
   	}   
}
?>