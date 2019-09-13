<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function __construct() 
    {
        parent::__construct();
    }

    public function user_registration($data = array())
    {
        if(!array_key_exists('doc', $data))
        {
            $data['doc'] = date("Y-m-d H:i:s");
        }

        if(!array_key_exists('dom', $data))
        {
            $data['dom'] = date("Y-m-d H:i:s");
        }
        $insert = $this->db->insert('users', $data);
        if($insert){
            return $this->db->insert_id();            
        }else{
            return false;
        }

    }

    public function check_user_credintials($userData)
    {
        $result = $this->db->get_where('users',$userData);
       if($result->num_rows() == 1)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    
    public function check_email_exists($email)
    {
        $result = $this->db->get_where('users',array('email'=>$email));
       if($result->num_rows() == 0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    
    public function get_users($auth_level,$user_id = '')
    {
        if(!empty($user_id))
        {            
            $query = $this->db->query("Select users.*, count(followers_ratings.following_id) as followers from users left join followers_ratings on users.user_id= followers_ratings.following_id where users.status = 1 and users.auth_level ='".$auth_level."' and users.user_id ='".$user_id."' group by users.user_id");
             return $query->row_array();
        }
        else
        {            
            $query = $this->db->query("Select users.*,avg(followers_ratings.ratings) as ratings from users left join followers_ratings on users.user_id= followers_ratings.rater_id where users.status = 1 and users.auth_level = '".$auth_level."' group by users.user_id");
            return $query->result_array();
        }
    }
    
    public function update_password($email,$new_pwd)
    {      
    	$data['password'] = $new_pwd; 
      	if(!array_key_exists('dom', $data))
      	{
      	   $data['dom'] = date("Y-m-d H:i:s");
      	}
	       $update = $this->db->update('users', $data, array('email'=>$email));
	     return $update?true:false;              
    }
    
    public function get_user_details($email)
    {
        $query = $this->db->get_where('users',array('email'=>$email));
        return $query->row();
    }   
    
	//17/04/2018
    public function view_profile($user_id)
    {
    	$query = $this->db->get_where('users',array('user_id'=>$user_id));
        return $query->row();
    }
    
    public function update_last_sign_out_time($user_id)
    {
    	$data['dols'] = date("Y-m-d H:i:s");	
	$update = $this->db->update('users', $data, array('user_id'=>$user_id));
	return $update?true:false; 
    }
    
    //18/04/2018
    public function follow($data)
    {

    	$result = $this->db->insert('followers_ratings',$data);
    	return $result?true:false;
    }
    
    public function unfollow($data)
    {

    	$result = $this->db->delete('followers_ratings',$data);    	
    	return $result?true:false;
    }
    
    public function user_following($user_id)
    {
    	$result = $this->db->query('select * from users where user_id in (SELECT following_id from followers_ratings where user_id = '.$user_id.')');
    	return $result->result();
    }
    
    public function user_book_appointment($userData)
    {
    	$result = $this->db->insert('appointments',$userData);
    	return $result?true:false;
    }
    
    public function get_provided_services_wise_doctors($id)
    {
    	$query = $this->db->query("Select users.*,avg(followers_ratings.ratings) as ratings from users left join followers_ratings on users.user_id= followers_ratings.rater_id where users.status = 1 and users.auth_level = 2 and doctor_speciality = '".$id."' group by users.user_id");
    	return $query->result_array();
    }
    
    public function user_update_profile($data=array(),$user_id)
    {
    	if(!array_key_exists('dom', $data))
    	{
    	   $data['dom'] = date("Y-m-d H:i:s");
    	}
        $this->db->where('user_id',$user_id);
    	$update = $this->db->update('users',$data);
    	return $update?true:false;
    }
    
     public function app_user_update_profile($data=array(),$user_id)
    {
    	if(!array_key_exists('dom', $data))
    	{
    	   $data['dom'] = date("Y-m-d H:i:s");
    	}
        $this->db->where('user_id',$user_id);
    	$update = $this->db->update('users',$data);
    	return $update->row();
    }
    
    public function count_tweets($user_id)
    {
    	$query = $this->db->query("select count('user_id') as total_tweets from tweets where user_id = '".$user_id."'");
    	return $query->row();
    }
    
    public function count_appointments($booking_id)
    {
    	$query = $this->db->query("select count('booking_id') as total_appointments from appointments where booking_id = '".$booking_id."' and status = 1");
    	return $query->row();
    }
    
    public function count_followers($following_id)
    {
    	$query = $this->db->query("select count('following_id') as total_followers from followers_ratings where following_id = '".$following_id."'");
    	return $query->row();
    }
    
    public function chack_following_status($data)
    {    	
    	 $query = $this->db->get_where('followers_ratings',$data);
    	 if($query->num_rows() >= 1)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    
    public function chack_rating_status($data)
    {    	
    	$query = $this->db->get_where('followers_ratings',$data);
    	 if($query->num_rows() >= 1)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    
    public function post_tweet($data,$id='')
    {
      
    	$data['date'] = date("Y-m-d H:i:s");
    	if(!empty($id))
    	{
    	    $update= $this->db->update('tweets',$data,array('id'=>$id));
    	     return $update?true:false;
    	}
    	else
    	{
          $insert =  $this->db->insert('tweets',$data);
           return $insert?true:false;
    	}

    }
    
    public function get_tweets($user_id,$lang="")
    {    	
    	if($lang=='ar')
    	{
    	  $query = $this->db->query("select id,user_id,tweet_title_ar as tweet_title,tweet_ar as tweet,tweet_image,date from tweets where user_id = '".$user_id."' order by id desc");
    	  return $query->result();
    	}
    	else
    	{
    	    $query = $this->db->query("select id,user_id,tweet_title,tweet,tweet_image,date from tweets where user_id = '".$user_id."' order by id desc");
    	  return $query->result();
    	}   	

    }
    
    public function get_single_tweet($user_id,$tweet_id = '')
    {
        if(!empty($tweet_id))
        {
            
            $query = $this->db->get_where('tweets',array('id'=>$tweet_id));
            return $query->row();
        }
        else
        {
            $query = $this->db->get_where('tweets',array('user_id'=>$user_id));
            return $query->result();
            
        }
        
    }
    
    public function delete_tweet($id)
    {
    	$this->db->where(array('id'=>$id));
    	$query = $this->db->delete('tweets');
    	return $query?true:false;
    }
    
    public function get_user_tweets($user_id)
    {
    	$query = $this->db->query("select users.*,tweets.* from users JOIN tweets ON users.user_id = tweets.user_id where users.user_id in (SELECT following_id from followers_ratings where user_id =".$user_id.")");
    	return $query->result();
    }
    
    public function get_reservations($user_id,$auth_level)
    {
    	$query = $this->db->query("select users.*,appointments.*,provided_services.* from users JOIN appointments ON users.user_id = appointments.booking_id join provided_services on provided_services.id=appointments.service WHERE appointments.user_id = '".$user_id."' and appointments.auth_level = '".$auth_level."'");
    	return $query->result();
    }
    
    public function get_user_reservations($user_id,$auth_level)
    {
    	$query = $this->db->query("select users.user_id,users.image,users.username,users.lat,users.lon,users.clinic_name,appointments.id,appointments.user_id,appointments.booking_id,appointments.auth_level,appointments.doctor_name,appointments.name,appointments.customer_age,appointments.customer_gender,appointments.date,appointments.time,appointments.mobile,appointments.service,appointments.booking_time,appointments.status as appointment_status,provided_services.service_name from users RIGHT JOIN appointments ON users.user_id = appointments.booking_id join provided_services on provided_services.id=appointments.service WHERE appointments.user_id = '".$user_id."' and appointments.auth_level = '".$auth_level."' order by appointments.id desc");
    	return $query->result();
    }
    
    public function get_user_medical_advice_requests($user_id)
    {
    	$query = $this->db->query("select users.user_id,users.image,users.username,users.lat,users.lon,doctor_medical_advices.id,doctor_medical_advices.user_id as userid,doctor_medical_advices.doctor_id as booking_id,doctor_medical_advices.description,doctor_medical_advices.medical_slip,doctor_medical_advices.file_type,doctor_medical_advices.date_time,doctor_medical_advices.fees,doctor_medical_advices.status as appointment_status from users JOIN doctor_medical_advices ON users.user_id = doctor_medical_advices.doctor_id WHERE doctor_medical_advices.user_id = '".$user_id."' order by doctor_medical_advices.id desc ");
    	return $query->result();
    }
    
    public function avg_ratings($user_id)
    {
    	$query = $this->db->query("SELECT AVG(ratings) as rating FROM followers_ratings WHERE rater_id='".$user_id."'");
    	return $query->row();
    }
    
    public function free_dental_appointment_status($user_id,$user)
    {
    	$query = $this->db->query("SELECT status from appointments WHERE booking_id ='".$user_id."' and user_id= '".$user."' and auth_level = 4 ORDER BY id desc LIMIT 1");
    	return $query->row();
    }
    
    /* public function offers($auth_level="",$user_id="")
    {
    	if(!empty($user_id))
    	{
    	   $query = $this->db->query('select users.*,offers.* from users right join offers on users.user_id = offers.clinic_id where users.auth_level = "'.$auth_level.'" and users.user_id = "'.$user_id.'"');
    	   return $query->result_array();
    	}
    	else if(!empty($auth_level))
    	{
    	   $query = $this->db->query('select users.*,offers.* from users right join offers on users.user_id = offers.clinic_id where users.auth_level = "'.$auth_level.'"');
    	   return $query->result_array();
    	}
    	else
    	{
    	$query = $this->db->query('select users.*,offers.* from users right join offers on users.user_id = offers.clinic_id');
    	   return $query->result_array();    		
    	}
    	
    } */
    
    public function offers($auth_level="",$user_id="")
    {
    	if(!empty($user_id))
    	{
    	   $query = $this->db->query('select users.user_id,offers.* from users right join offers on users.user_id = offers.user_id where users.auth_level = "'.$auth_level.'" and users.user_id = "'.$user_id.'"');
    	   return $query->result_array();
    	}
    	else if(!empty($auth_level))
    	{
    	   $query = $this->db->query('select users.user_id,offers.* from users right join offers on users.user_id = offers.user_id where users.auth_level = "'.$auth_level.'"');
    	   return $query->result_array();
    	}
    	else
    	{
    	$query = $this->db->query('select users.*,offers.* from users right join offers on users.user_id = offers.user_id where offers.status=1 AND CURDATE() <= offers.expire_date');
    	   return $query->result_array();    		
    	}
    	
    }
    
  public function get_followers($user_id)
	{
	  //$query = $this->db->query("select * from users where user_id in (select user_id from followers_ratings where following_id  = ".$user_id.")");
	  $query = $this->db->query("SELECT followers_ratings.*,users.* from followers_ratings JOIN users ON followers_ratings.user_id = users.user_id WHERE followers_ratings.following_id = '".$user_id."'");
	  return $query->result();
	}
	
	public function get_ratings($user_id)
   	 {
   	 	$query = $this->db->query("select users.*,followers_ratings.* from users join followers_ratings on users.user_id = followers_ratings.user_id WHERE followers_ratings.rater_id = '".$user_id."'");
   	 	return $query->result();
   	 	
   	 }
   	 
   	public function update_appointment_status($data,$id)
   	{
   		$this->db->where('id',$id);
   		$query = $this->db->update('appointments',$data);
   		return $query?true:false;
   	}
   	
    public function delete_cancelled_appointment($id)
    {
    	$this->db->where(array('id'=>$id));
    	$query = $this->db->delete('appointments');
    	return $query?true:false;
    }
    
  public function get_by_id($id)
	{
		
		$query = $this->db->get_where('offers',array('id'=>$id)); 
		return $query->row();
	}
	
	public function get_offers($user_id)
	{
		$query = $this->db->get_where('offers',array('user_id'=>$user_id));
		return $query->result();
	}
 
	public function offer_add($data)
	{
		$this->db->insert('offers', $data);
		return $this->db->insert_id();
	}
 
	public function offer_update($data,$id)
	{		
		$this->db->where('id',$id);
   		$query = $this->db->update('offers',$data);
   		return $query?true:false;   		
	}
 
	public function delete_offer_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete('offers');
		return $query?true:false;
		
	}
	
	public function update_offer_status($data,$id)
	{
	     $update = $this->db->update('offers',$data,array('id' =>$id));
	     return $update?true:false;
	}
	
	 public function get_appointments($user_id,$status)
 	 { 	    
 	    	$query = $this->db->query("SELECT * FROM `appointments` WHERE booking_id = '".$user_id."' and status = '".$status."'");
 	   	return $query->result();   	   
 	 }
   	 
   	 public function get_user_details_based_on_appointment_id($id)
   	 {
   	   $query = $this->db->query('select * from users where user_id in (select user_id from appointments where id = "'.$id.'")');
   	   return $query->row();
   	 } 	 
   	 
   	 public function insert_appointment_notification($data1)
   	 {
   	 	
   	 	$query = $this->db->insert('notifications',$data1);   	 	
   	 	return $query?true:false;
   	 }
   	 
   	 public function get_appintment_details_based_on_appointment_id($id)
   	 {
   	 	$query = $this->db->get_where('appointments',array('id'=>$id));
   	 	return $query->row();
   	 }
   	 
   	 public function get_medical_advice_request_details_based_on_appointment_id($id)
   	 {
   	 	$query = $this->db->get_where('doctor_medical_advices',array('id'=>$id));
   	 	return $query->row();
   	 }
   	 
   	 public function get_user_notifications($user_id,$lang)
   	 {
   	     if($lang=='ar')
   	     {
   	         $query = $this->db->query("select users.*,notifications.message_ar as message,notifications.date,notifications.time,notifications.doc from users join notifications on users.user_id = notifications.booking_user_id where notifications.user_id ='".$user_id."' and (notifications.auth_level = 0 or notifications.auth_level is NULL) order by notifications.id desc");
   	         return $query->result();
   	     }
   	     else
   	     {
   	         $query = $this->db->query("select users.*,notifications.message,notifications.date,notifications.time,notifications.doc from users join notifications on users.user_id = notifications.booking_user_id where notifications.user_id ='".$user_id."' and (notifications.auth_level = 0 or notifications.auth_level is NULL) order by notifications.id desc");
   	         return $query->result();
   	     }
   	 }
   	 
   	  public function get_user_clinic_notifications($user_id,$lang)
   	 {
   	 	
   	 	if($lang=='ar')
   	 	{
   	 	   $query = $this->db->query("select users.*,clinic_avilable_time.message_ar as message,clinic_avilable_time.date,clinic_avilable_time.time from users join clinic_avilable_time on users.user_id = clinic_avilable_time.clinic_id where clinic_avilable_time.user_id ='".$user_id."' order by clinic_avilable_time.id desc");
   	 	   return $query->result();
   	 	}
   	 	else
   	 	{
   	 	    $query = $this->db->query("select users.*,clinic_avilable_time.message,clinic_avilable_time.date,clinic_avilable_time.time from users join clinic_avilable_time on users.user_id = clinic_avilable_time.clinic_id where clinic_avilable_time.user_id ='".$user_id."' order by clinic_avilable_time.id desc");
   	 	    return $query->result();
   	 	}
   	 	
   	 }
   	 
   	 public function get_doctor_notifications($user_id)
   	 {
   	 	$query = $this->db->query("select users.*,notifications.* from users join notifications on users.user_id =notifications.user_id where notifications.booking_user_id=$user_id order by notifications.id desc");
   	 	return $query->result();
   	 }
   	 
   	 //clinic search 
   	 
   	    public function clinic_search_by_service_insurance($insurance,$service ='')
	    {
	        if(!empty($insurance) && !empty($service))
	        {            
	            $query = $this->db->query("Select users.*, count(followers_ratings.following_id) as followers from users left join followers_ratings on users.user_id= followers_ratings.following_id where users.status = 1 and users.auth_level=3 and users.accepted_insurance LIKE '%".$insurance."%' AND users.provided_services LIKE '%".$service."%' group by users.user_id");
	             return $query->result();
	        }
	        else
	        {            
	            $query = $this->db->query("Select users.*, count(followers_ratings.following_id) as followers from users left join followers_ratings on users.user_id= followers_ratings.following_id where users.status = 1 and users.auth_level=3 and users.accepted_insurance LIKE '%".$insurance."%' group by users.user_id");
	             return $query->result();
	       }
	    }
	    
	    public function clinic_search_by_name_service_insurance($insurance,$service,$clinic_name)
	    {	                   
	            $query = $this->db->query("Select users.*, count(followers_ratings.following_id) as followers from users left join followers_ratings on users.user_id= followers_ratings.following_id where users.status = 1 and users.auth_level=3 and users.accepted_insurance LIKE '%".$insurance."%' AND users.provided_services LIKE '%".$service."%' AND users.clinic_name LIKE '%".$clinic_name."%' group by users.user_id");
	             return $query->result();	        
	    }
	    
	     public function clinic_search_by_name_service($service,$clinic_name)
	    {	                   
	            $query = $this->db->query("Select users.*, count(followers_ratings.following_id) as followers from users left join followers_ratings on users.user_id= followers_ratings.following_id where users.status = 1 and users.auth_level=3 and users.provided_services LIKE '%".$service."%' AND users.clinic_name LIKE '%".$clinic_name."%' group by users.user_id");
	             return $query->result();	        
	    }
	    
	     public function clinic_search_by_name_insurance($insurance,$clinic_name)
	    {	                   
	            $query = $this->db->query("Select users.*, count(followers_ratings.following_id) as followers from users left join followers_ratings on users.user_id= followers_ratings.following_id where users.status = 1 and users.auth_level=3 and users.accepted_insurance LIKE '%".$insurance."%' AND users.clinic_name LIKE '%".$clinic_name."%' group by users.user_id");
	             return $query->result();	        
	    }
	    
	     public function clinic_search_by_service($service)
	    {	                   
	            $query = $this->db->query("Select users.*, count(followers_ratings.following_id) as followers from users left join followers_ratings on users.user_id= followers_ratings.following_id where users.status = 1 and users.auth_level=3 AND users.provided_services LIKE '%".$service."%' group by users.user_id");
	             return $query->result();	        
	    }
	     public function clinic_search_by_name($clinic_name)
	    {	                   
	            $query = $this->db->query("Select users.*, count(followers_ratings.following_id) as followers from users left join followers_ratings on users.user_id= followers_ratings.following_id where users.status = 1 and users.auth_level=3 AND users.clinic_name LIKE '%".$clinic_name."%' group by users.user_id");
	             return $query->result();	        
	    } 
	    
	    //clinic search end  	 
   	

            public function chat_msg($sender_id,$reciver_id)
            {
            	$query = $this->db->query("select * from chat where sender_id IN($sender_id,$reciver_id) and reciver_id IN($reciver_id,$sender_id) ORDER BY id ASC");            	
            	return $query->result_array();            
            }
            
             public function get_doctor_data($user_id)
            {
            	$query = $this->db->query("select username,image,doctor_speciality from users where user_id =$user_id");
            	return $query->result_array();            
            }
            
             public function get_free_dental_data($user_id)
            {
            	$query = $this->db->query("select username,image,package_expire_date from users where user_id ='".$user_id."'");
            	return $query->result_array();            
            }
            
            public function user_doctor_chat_list($user_id)
            {
            	$query = $this->db->query("select * from users where user_id in(select distinct doctor_id from doctor_medical_advices where user_id = $user_id and status = 1)");
            	return $query->result_array();            
            }
            
            public function user_free_dental_chat_list($user_id)
            {
            	$query = $this->db->query("select * from users where user_id in (select booking_id from appointments where user_id = $user_id and status = 1)");
            	return $query->result_array();            
            }
            
            public function doctor_chat_list($doctor_id)
            {
            	$query = $this->db->query("select * from users where user_id in (select user_id from doctor_medical_advices where doctor_id = $doctor_id and status = 1)");
            	return $query->result_array();                          
            }
            
            public function free_dental_chat_list($free_dental_id)
            {
            	$query = $this->db->query("select * from users where user_id in (select user_id from appointments where booking_id = $free_dental_id and status = 1)");
            	return $query->result_array();            
            }
            
            public function chat($data)
            {
            	$query = $this->db->insert('chat',$data); 
            	return $query?true:false;   
            }
            
      public function free_dental_appointments($free_dental_id,$status)    
	    {	       
            $query = $this->db->query("SELECT * FROM `appointments` WHERE booking_id = '".$free_dental_id."' and auth_level = 4 and status = '".$status."' order by id desc");	
       
   	        return $query->result();   	   
	    }

      public function location_free_dentals($city)
      {
        $this->db->where('auth_level',4);
        $this->db->where('status',1);
        $this->db->where('city',$city);
        return $this->db->get('users')->result();
        return $this->db->last_query();
      }
      
      public function message_update_read_status($sender_id,$reciver_id)
      {
          $data['status']=1;
         $update = $this->db->update('chat',$data,array('sender_id' =>$reciver_id,'reciver_id'=>$sender_id));
	     return $update?true:false;
      }
      
      public function delete_free_dental_conversion($sender_id,$reciver_id)
      {
          $query = $this->db->query("delete from chat where sender_id IN($sender_id,$reciver_id) and reciver_id IN($reciver_id,$sender_id)");
          return $query?true:false;
      }

      public function ap_update_read_status($booking_id)
      {
        $this->db->update("appointments",array('read_status'=>1),array('booking_id'=>$booking_id));
      }
}
?>