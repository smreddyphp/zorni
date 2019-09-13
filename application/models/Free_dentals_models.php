<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Free_dentals_models extends CI_Model {

    public function __construct() 
    {
        parent::__construct();
    }
    
    public function free_dental_appointments($free_dental_id,$status)    
    {
   	    
   	$query = $this->db->query("SELECT * FROM `appointments` WHERE booking_id = '".$free_dental_id."' and auth_level = 4 and status = '".$status."'");
   	echo $this->db->last_query();
   	//return $query->result();   	   
    }

       
}
?>