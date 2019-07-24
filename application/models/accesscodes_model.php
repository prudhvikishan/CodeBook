<?php

class AccessCodes_model extends CI_Model {
	

	public $access_code_id, $acces_code, $user_id, $expiration_date, $used_on;

	/**
	 * Create a new access code.
	 **/
    function __construct($access_code_id = null, $acces_code = null, $user_id = null, $expiration_date = null, $used_on = null)
    {
        parent::__construct();
        $this->access_code_id      = $access_code_id;
        $this->access_code        = $acces_code;
        $this->user_id    = $user_id;
        $this->expiration_date    = $expiration_date;
        $this->used_on    = $used_on;
    }

    /**
     * Save the current address.
     **/
    public function save()
    {
    	if($this->access_code_id == null)
    	{
    		$this->db->insert("AccessCodes", array(
				"access_code" => $this->access_code,
				"user_id" => $this->user_id,
    			"expiration_date" => $this->expiration_date,
    			"used_on" => $this->used_on
    		));
    		$this->access_code_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"access_code" => $this->access_code,
				"user_id" => $this->user_id,
    			"expiration_date" => $this->expiration_date,
    			"used_on" => $this->used_on
       		);
    		$this->db->where("access_code_id", $this->access_code_id);
    		$this->db->update("AccessCodes",$update_data);
    	}
    }
    
    public function updateUsedOnTime(){
    	$data = array(
    	        'used_on' => date('Y-m-d H:i:s',now())
    	);
    	$this->db->where("access_code_id", $this->access_code_id);
    	$this->db->update("AccessCodes",$data);
    }


    /**
     * Load a access code by id.
     **/
    public static function LoadById($access_code_id)
    {
    	$result = &get_instance()->db->get_where("AccessCodes", array("access_code_id" => $access_code_id));
    	$result = $result->result();
    	return count($result) != 0 ? AccessCodes_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a class with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new AccessCodes_model(
   			$row->access_code_id,
   			$row->access_code,
   			$row->user_id,
   			$row->expiration_date,
   			$row->used_on
   		);
   	}
   	
   	public function validateCode(){
   		if($this->user_id == null)
   			return true;
   		else 
   			return false;
   	}
   	
   	/**
   	* Load a access code by access code.
   	**/
   	public static function LoadByAccessCode($access_code)
   	{
   		$result = &get_instance()->db->get_where("AccessCodes", array("access_code" => $access_code));
   		$result = $result->result();
   		return count($result) != 0 ? AccessCodes_model::LoadWithData($result[0]) : null;
   	}
   	
   	
}
?>
