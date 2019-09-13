<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
	public $_uploaded;
    
	function __construct()
    {
        parent::__construct();
        //$this->load->library('push_notifications');
        $this->load->helper('notification_helper');
    }
	
    public function booked_reminder()
    {
        $users = $this->db->query("SELECT * FROM `appointments` WHERE status = 1")->result();
        
        if($users)
        {
            foreach ($users as $key => $value) {
                $month = '';
                $data = array();
                $booked_time = explode('-',$value->time);
                $booked_date = $value->date.' '.@$booked_time[0];
                //echo $booked_date;echo '<br>';
               // echo date('Y-m-d h:i A');
                //echo strtotime(date('Y-m-d h:i A'));echo '<br>';
                if(strtotime(date('Y-m-d h:i A'))==strtotime('-1 day',strtotime($booked_date)))
                {
                    //echo $booked_date = $value->date.' '.@$booked_time[0];echo 'test<br>';
/*                    $month = date('F');
                    $data = array('type'=>'Rent Delay','title'=>'Rent Pay','description'=>'Rent pay for the month of '.$month,'user_id'=>$value->user_id,'is_paid'=>2,'rent_date'=>$value->rent_date,'created_at'=>date('Y-m-d H:i:s'));
                    $this->common_m->save_data_table('request_tickets',$data);
                    send_mail($value->email,'Monthly Rent Alert ','Tomorrow is last date to pay the rent for the month of <b>'.$month.'</b>.');*/
                    $booked_user_details = $this->db->where('user_id',$value->user_id)->get('users')->row();
                    $s_data['name'] = $booked_user_details->role;
                    $s_data['image'] = $booked_user_details->image;
                    $s_data['date'] = date('Y-m-d H:i:sA');
                    $s_data['message'] = 'Your Appointment Is Confirmed Please Attend The Your Booking Time: '.$value->date.' '.@$booked_time[0];
                    $s_data['type'] = 'notification';
                    $s_data['title'] = 'Appointment Conformation';
                    $s_data['body'] = 'appointment conformation notification from your booking user';
                    $s_data['click_action'] = 'com.volive.zorni.Notifications';        


                       
                    if($booked_user_details->device_type =='Android')
                    {
                     
                       //$result = $this->push_notifications->send_android_notification_user($booked_user_details->device_token,$s_data);
                       $result = send_notification_android($booked_user_details->device_token,$s_data);
                    }                   

                    
                    if($booked_user_details->device_type =='IOS')
                    {
                       //$result = $this->push_notifications->send_ios_notification($booked_user_details->device_token, $s_data);
                       $result = send_notification_ios($booked_user_details->device_token, $s_data);
                    }
                   // print_r($result);
                }
            }
        }
    	
    }
    
    public function change_appointment_status()
    {
        $users = $this->db->query("SELECT * FROM `appointments` WHERE status = 1")->result();
        
            foreach ($users as $key => $value) 
            {
                
                 $date = $value->date;
                 $array = explode('-',$value->time);
                 $time = date("H", strtotime($array[1]));
                   $datetime = date('Y-m-d H:i', strtotime(+$time .'hours',strtotime($date)));
                       $reminder = date('Y-m-d H:i',strtotime('+1 hour',strtotime($datetime)));
                      $current_date = date('Y-m-d H:i');
                 
                if($current_date >= $reminder)
                {
                    $userdata  = $this->users_model->view_profile($value->user_id);
	              $booking_data  = $this->users_model->view_profile($value->booking_id);
	              $id = $value->id;          
                 $data['status']=4;
	            $result = $this->users_model->update_appointment_status($data,$id);
	            $this->users_model->message_update_read_status($value->booking_id,$value->user_id);
                    
                    $data2['booking_user_id'] = $value->booking_id;
		           	$data2['user_id'] = $value->user_id;
		           	$data2['message'] = "Your Appointment Time is Completed With ".$booking_data->username." and Date ".$value->date." time is ".$value->time;           	;
		           	$data2['message_ar'] = "اكتمال وقت موعدك مع"." ".$booking_data->username." "."والتاريخ"." ".$value->date." "."الوقت هو".$value->time;
		           	$data2['date'] = date("Y-m-d");
		           	$data2['time'] = date("h:i A");
		           	$data2['doc'] = date('Y-m-d H:i:s');
		           	//print_r($data2);exit;
		           	$insert_notification = $this->users_model->insert_appointment_notification($data2);
                    
                     if($userdata->lang=="ar")
        		       {
        		           $message = "اكتمال وقت موعدك مع"." ".$booking_data->username." "."والتاريخ"." ".$value->date." "."الوقت هو".$value->time;
        		           $title ="وقت الموعد اكتمل";
        		       }
        		       else
        		       {
        		           $title = "Appointment Time Completed";
        		           $message = "Your Appointment Time is Completed With ".$booking_data->username." and Date ".$value->date." time is ".$value->time;
        		       }
        		       
                    $s_data['message'] = $message;
                    $s_data['type'] = 'notification';
                    $s_data['title'] = $title;
                    $s_data['body'] = $data1['message'];
                    $s_data['click_action'] = 'com.volive.zorni.Notifications';  
		           
                    if($userdata->device_type =='Android')
				     {
				         $re1 = send_notification_android($userdata->device_token,$s_data);
				     }
        				      //for ios
    			      if($userdata->device_type =='IOS')
    			      {
    			          $ss = send_notification_ios($userdata->device_token,$s_data);
    			      }
    				      
                }
        }
    	
    }
}

/* End of file home.php */