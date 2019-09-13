<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() 
    {
        parent::__construct();
    }

    //16/04/2018

    public function get_pending_users($auth_level,$status)
    {
        $query  =$this->db->get_where('users',array('auth_level'=>$auth_level,'status'=>$status));
         return $query->result();   	
        
    }
    
    public function get_users($auth_level)
    {
    	$query = $this->db->query("select * from users where auth_level = '".$auth_level."' and status != 0");
        return $query->result();
    }

    public function updateuserData($data,$user_id)
    {
        $update = $this->db->update('users',$data,array('user_id' =>$user_id));
        return $update?true:false;
    }
    
    public function delete_user_data($user_id)
    {    
    	$delete = $this->db->delete('users',array('user_id'=>$user_id));
        return $delete?true:false;
    }
    
    public function delete_offers($user_id)
    {
    	$delete  = $this->db->delete('offers',array('user_id'=>$user_id));
    	return $delete?true:false;
    }
    
    public function delete_tweets($user_id)
    {
    	$delete  = $this->db->delete('tweets',array('user_id'=>$user_id));
    	return $delete?true:false;
    }
    
    public function delete_followers($user_id)
    {
    	$delete  = $this->db->delete('followers_ratings',array('following_id'=>$user_id));
    	return $delete?true:false;
    }
    
    public function delete_followings_raters($user_id)
    {
    	$delete  = $this->db->delete('followers_ratings',array('user_id'=>$user_id));
    	return $delete?true:false;
    }
    
    public function delete_ratings($user_id)
    {
    	$delete  = $this->db->delete('followers_ratings',array('rater_id'=>$user_id));
    	return $delete?true:false;
    }
    
    public function delete_bookings($user_id)
    {
    	$delete  = $this->db->delete('appointments',array('user_id'=>$user_id));
    	return $delete?true:false;
    }  
    
    
    public function delete_clinic_doctors($user_id)
    {
    	$delete  = $this->db->delete('clinic_doctors',array('clinic_id'=>$user_id));
    	return $delete?true:false;
    
    }
    
    public function delete_appointments($user_id)
    {
    	$delete  = $this->db->delete('appointments',array('booking_id'=>$user_id));
    	return $delete?true:false;
    
    }
    
    //17/04/2018
    
    public function get_provided_services()
    {
    	
    	    $query = $this->db->query("select * from provided_services where status != 2"); 
    	    return $query->result_array();    	   	
    	
    }
    
    public function get_accepted_insurances()
    {
    	$query = $this->db->query("select * from accepted_insurances where status != 2");
    	return $query->result_array();
    }    
   
	
	public function delete_service_by_id($id)
	{
	$this->db->where('id', $id);
	$this->db->delete('provided_services');
	}
	
	public function service_add($data)
	{
        $data['doc'] = date("Y-m-d H:i:s");		
		$this->db->insert('provided_services',$data);
		return $this->db->insert_id();				
	}
	
    public function update_service_status($data,$id)
    {
        $update = $this->db->update('provided_services',$data,array('id' =>$id));
        return $update?true:false;
    }
    
    public function update_insurance_status($data,$id)
    {
        $update = $this->db->update('accepted_insurances',$data,array('id' =>$id));
        return $update?true:false;
    }
    
	public function add_insurance($data)
	{
		$data['doc'] = date("Y-m-d H:i:s");
		$this->db->insert('accepted_insurances', $data);
		return $this->db->insert_id();
	}
	
	public function get_packages()
	{
	 	$query = $this->db->get('packages');
	 	return $query->result();
	}
    
    	public function update_package_status($data,$id)
    	{
        	$update = $this->db->update('packages',$data,array('id' =>$id));
        	return $update?true:false;
    	}
    	
    	public function package_add($data)
	{
		$this->db->insert('packages', $data);
		return $this->db->insert_id();
	}
	
	public function get_package_id($id)
	{
		
		$query = $this->db->get_where('packages',array('id'=>$id)); 
		return $query->row();
	}
	
	public function get_service_by_id($id)
	{
		
		$query = $this->db->get_where('provided_services',array('id'=>$id)); 
		return $query->row();
	}
	
	public function get_insurance_by_id($id)
	{
		
		$query = $this->db->get_where('accepted_insurances',array('id'=>$id)); 
		return $query->row();
	}
	
	public function package_update($where, $data)
	{
		$query = $this->db->update('packages', $data, $where);
		return $query?true:false;
	}
	
	public function insurance_update($where, $data)
	{
		$query = $this->db->update('accepted_insurances', $data, $where);
		return $query?true:false;
	}
	
	public function delete_package_by_id($id)	
	{
		$this->db->where('id', $id);
		$this->db->delete('packages');
	
	}
	
	public function delete_insurance_by_id($id)	
	{
		$this->db->where('id', $id);
		$this->db->delete('accepted_insurances');
	
	}
	
	public function count_users_based_on_auth_level($auth_level)
	{
		$query = $this->db->query("select count(user_id) as total_users from users where auth_level = '".$auth_level."'");
		return $query->row()->total_users;
	}
	
	public function medical_advice_request_view($id)
	{
	 $query = $this->db->get_where('doctor_medical_advices',array('id'=>$id));
	 return $query->row();
	}
    public function get_chat_users($free_dental_id)
      {
        $this->db->where('sender_id',$free_dental_id);
        $this->db->or_where('reciver_id',$free_dental_id);
        $this->db->group_by('sender_id,reciver_id');
        return $this->db->get('chat')->result();
      }

}

?>