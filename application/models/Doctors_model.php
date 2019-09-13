<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Doctors_model extends CI_Model {

    public function __construct() 
    {
        parent::__construct();
    }
    
    public function medical_advice_request($data)
    {
    	$data['date_time'] = date("Y-m-d H:i:s");
    	$result = $this->db->insert('doctor_medical_advices',$data);
    	return $result?true:false;
    }
    
        public function get_medical_advices($user_id,$status)
	{
	
	  // $query = $this->db->query("SELECT * FROM doctor_medical_advices WHERE doctor_id = '".$user_id."' and status = '".$status."'");
	   $query = $this->db->query("SELECT doctor_medical_advices.*,users.username,users.user_id,users.image,users.age,users.gender FROM doctor_medical_advices JOIN users ON doctor_medical_advices.user_id = users.user_id WHERE doctor_medical_advices.doctor_id = '".$user_id."' AND doctor_medical_advices.status = '".$status."'");
	   return $query->result();   	   
	}
	
	 public function get_user_details_based_on_medical_advice_id($id)
   	 {
   	   $query = $this->db->query('select * from users where user_id in (select user_id from doctor_medical_advices where id = "'.$id.'")');
   	   return $query->row();
   	 }
   	 
   	 public function update_medical_advice_status($data,$id)
   	 {
   		$this->db->where('id',$id);
   		$query = $this->db->update('doctor_medical_advices',$data);
   		return $query?true:false;
   	 }
   	 
   	    public function delete_medical_advice_request($id)
	    {
	    	$this->db->where(array('id'=>$id));
	    	$query = $this->db->delete('doctor_medical_advices');
	    	return $query?true:false;
	    }
	    
	 public function get_medical_advice_document($id)
   	 {
   	   $query = $this->db->query("select medical_slip from doctor_medical_advices where id ='".$id."'");
   	   return $query->row()->medical_slip;
   	 }
   	 
   	 public function doctor_all_medical_advice_requests($doctor_id)
   	 {
   	 	$this->db->order_by("id","desc");
   	 	$query = $this->db->get_where('doctor_medical_advices',array('doctor_id'=>$doctor_id));
   	 	return $query->result();
   	 }  
    		
    
}
?>