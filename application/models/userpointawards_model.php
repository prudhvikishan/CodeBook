<?php

class UserPointAwards_model extends CI_Model {

	public $user_point_award_id, $user_id, $point_value, $event_type, $event_entity_type, $entity_id;

	/**
	 * Create a new question.
	 **/
	function __construct($user_point_award_id = null, $user_id = null, $point_value = null, $event_type = null, $event_entity_type = null, $entity_id = null)
	{
		parent::__construct();
		$this->user_point_award_id  = $user_point_award_id;
		$this->user_id        		= $user_id;
		$this->point_value    		= $point_value;
		$this->event_type      		= $event_type;
		$this->event_entity_type    = $event_entity_type;
		$this->entity_id    		= $entity_id;
	}

	/**
	 * Save the User Point question.
	 **/
	public function save()
	{
		$this->load->model("Users_model");
		$user = Users_model::LoadById($this->user_id);
		$levelBefore = $user->getLevel();
		if($this->user_point_award_id == null)
		{
			$this->db->insert("UserPointAwards", array(
	    		"user_id" => $this->user_id, 
	    		"point_value" => $this->point_value,
	    		"event_type" => $this->event_type,  
	    		"event_entity_type" => $this->event_entity_type,    
	    		"entity_id" => $this->entity_id
			));
			$this->user_point_award_id = $this->db->insert_id();
		}
		else
		{
			$update_data = array(
	    		"user_id" => $this->user_id, 
	    		"point_value" => $this->point_value,
	    		"event_type" => $this->event_type,  
	    		"event_entity_type" => $this->event_entity_type,    
	    		"entity_id" => $this->entity_id
			);
			$this->db->where("user_point_award_id", $this->user_point_award_id);
			$this->db->update("UserPointAwards", $update_data);
		}

		// if their level changed, award them some gold coins
		if($user->getLevel() != $levelBefore) {
			$user->awardGoldCoins(1, "Level Up");
		}
	}

	/**
	 * Load a User Point Awards by id.
	 **/
	public static function LoadById($user_point_award_id)
	{
		$result = &get_instance()->db->get_where("UserPointAwards", array("user_point_award_id" => $user_point_award_id));
		$result = $result->result();
		return count($result) != 0 ? UserPointAwards_model::LoadWithData($result[0]) : null;
	}


	/**
	 * Load a question with an object.
	 **/
	public static function LoadWithData($row)
	{
		return new UserPointAwards_model(
		$row->user_point_award_id, 
		$row->user_id,
		$row->point_value,
		$row->event_type,
		$row->event_entity_type,
		$row->entity_id
		);
	}
	
	public function updateTime($date1){
			$update_data = array( "timestamp" => $date1 );
			$this->db->where("user_point_award_id", $this->user_point_award_id);
			$this->db->update("UserPointAwards", $update_data);
	}
	
}
?>
