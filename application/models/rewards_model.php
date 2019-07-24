<?php

class Rewards_model extends CI_Model {

	public $reward_id, $name, $description, $image, $cost, $active;

	/**
	 * Create a new exam.
	 **/
    function __construct($reward_id = null, $name = null, $description = null, $image = null, $cost = null, $active = null)
    {
        parent::__construct();
        $this->reward_id 			  = $reward_id;
        $this->name      		  = $name;
        $this->description        = $description;
        $this->image = $image;
        $this->cost       = $cost;
        $this->active       = $active;
    }

    /**
     * Save the current reward.
     **/
    public function save()
    {
    	if($this->reward_id == null)
    	{
    		$this->db->insert("Rewards", array(
  				"name" => $this->name,
  				"description" => $this->description,
    			"image" => $this->image,
    			"cost" => $this->cost,
          "active" => $this->active ? "1" : "0"
    		));
    		$this->reward_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"name" => $this->name,
				  "description" => $this->description,
    			"image" => $this->image,
    			"cost" => $this->cost,
          "active" => $this->active ? "1" : "0"
       		);
    		$this->db->where("reward_id", $this->reward_id);
    		$this->db->update("Rewards", $update_data);
    	}
    }

    /**
     * Load a reward by id.
     **/
    public static function LoadById($reward_id)
    {
    	$result = &get_instance()->db->get_where("Rewards", array("reward_id" => $reward_id));
    	$result = $result->result();
    	return count($result) != 0 ? Rewards_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a class with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Rewards_model(
   			$row->reward_id,
   			$row->name,
   			$row->description,
   			$row->image,
   			$row->cost,
        $row->active == 1 ? true : false
   		);
   	}

    /**
     * Get all active rewards
     **/
    public static function All() {
      $results = &get_instance()->db->get_where("Rewards", array("active" => "1"))->result();
      $ret = array();

      foreach ($results as $row) {
        $ret[] = Rewards_model::LoadWithData($row);
      }

      return $ret;
    }
}
?>
