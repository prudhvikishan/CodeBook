<?php

class UserSignup_model extends CI_Model {

	public $user_signup_id, $email, $name, $school, $city, $exam;

	/**
	 * Create a new User signup.
	 **/
    function __construct($user_signup_id = null, $email = null, $name  = null, $school = null, $city = null, $exam = null)
    {
        parent::__construct();
        $this->user_signup_id = $user_signup_id;
        $this->email         = $email;
        $this->name     	 = $name;
        $this->school        = $school;
        $this->city			 = $city;
        $this->exam			 = $exam;
    }


    /**
     * Save user signup.
     **/
    public function save()
    {
    	// If theres no user_id, create a new one.
    	if($this->user_signup_id == null)
    	{
    		$this->db->insert("UserSignup", array(
				"email" => $this->email,
				"name" => $this->name,
				"school" => $this->school,
				"city" => $this->city,
				"exam" => $this->exam
    		));
    		$this->user_signup_id = $this->db->insert_id();
    	}	
    	// Otherwise update the existing one.
    	else
    	{
    		$update_data = array(
    			"email" => $this->email,
  				"name" => $this->name,
				"school" => $this->school,
				"city" => $this->city,
				"exam" => $this->exam
    		);
    		$this->db->where("user_signup_id", $this->usersignup_id);
    		$this->db->update("UserSignup", $update_data);
    	}
    }

    /**
     * Load a user by id.
     **/
    public static function LoadById($user_signup_id)
    {
    	$result = &get_instance()->db->get_where("UserSignup", array("user_signup_id" => $user_signup_id));
    	$result = $result->result();
    	return count($result) != 0 ? UserSignup_model::LoadWithData($result[0]) : null;
    }

    /**
     * Load a user with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Users_model(
   			$row->user_signup_id,
   			$row->email,
   			$row->name,
   			$row->school,
   			$row->city,
   			$row->exam
   		);
   	}
}
?>
