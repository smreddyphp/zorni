<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clinics_model extends CI_Model {

    public function __construct() 
    {
        parent::__construct();
    }
    
    public function get_provided_services_names($provided_services)
    {
    	$query = $this->db->query("select * from provided_services where id in ($provided_services) and status = 1");
    	return $query->result();
    }
    
    public function get_accepted_insurance_names($accepted_insurances)
    {
    	$query = $this->db->query("select * from accepted_insurances where id in ($accepted_insurances) and status = 1");
    	return $query->result();
    }
    
    public function get_doctors_by_clinic($clinic_id)
    {
    	$query = $this->db->query("select * from clinic_doctors where clinic_id = '".$clinic_id."'");
    	return $query->result();
    }
    
    public function get_service_name_by_id($id)
    {
       $query = $this->db->query("select service_name from provided_services where id = '".$id."'");
    	 return $query->row();
    }
 
	public function get_by_id($id)
	{
		
		$query = $this->db->get_where('clinic_doctors',array('id'=>$id,'clinic_id'=>$this->session->userdata('user_id'))); 
		return $query->row();
	}
 
	public function doctor_add($data)
	{
		$this->db->insert('clinic_doctors', $data);
		return $this->db->insert_id();
	}
 
	public function doctor_update($where, $data)
	{
		$query = $this->db->update('clinic_doctors', $data, $where);
		return $query?true:false;
	}
 
	public function delete_doctor_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('clinic_doctors');
	}
	
	public function update_doctor_status($data,$id)
	{
	     $update = $this->db->update('clinic_doctors',$data,array('id' =>$id));
	     return $update?true:false;
	}	
   	 
 	 public function get_service_wise_doctors($clinic_id,$service_id,$lang='')
 	 {
 	         if($lang == 'ar')
 	         {
 	         	$query = $this->db->query("select name,mobile,about_ar as about,service from clinic_doctors where clinic_id='".$clinic_id."' and service = '".$service_id."'");
 	         }
 	         else
 	         {
 	         	$query = $this->db->query("select name,mobile,about,service from clinic_doctors where clinic_id='".$clinic_id."' and service = '".$service_id."'");
 	         } 	 	
 	 	    return $query->result();
 	 }
   	 
   	 public function get_clinic_provided_services($provided_services)
   	 {
   	     $query = $this->db->query("select * from provided_services where id in (".$provided_services.") and status = 1");
   	     return $query->result();
   	 }
   	 
   	 public function clinic_appointments($clinic_id,$status)
   	 {
   	    
   	    	$query = $this->db->query("SELECT * FROM `appointments` WHERE booking_id = '".$clinic_id."' and status = '".$status."'");
   	   	return $query->result();   	   
   	 }
   	 
   	 public function clinic_all_appointments($clinic_id)
   	 {
   	 	$query = $this->db->get_where('appointments',array('booking_id'=>$clinic_id));
   	 	return $query->result();
   	 }

     public function get_appointment_unread($clinic_id,$read_status)
     {
      return $this->db->get_where('appointments',array('booking_id'=>$clinic_id,'status'=>0,'read_status'=>$read_status))->result();
     }
   	 
   	  public function clinic_avilable_time($data)
   	 {
   	 	$this->db->insert('clinic_avilable_time',$data);
   	 	return $this->db->insert_id();
   	 }
    
}
?>