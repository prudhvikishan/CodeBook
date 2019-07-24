<?php

class Badges_model extends CI_Model {

	public $badge_id, $badge_name, $badge_description, $icon_path, $point_value;

	/**
	 * Create a new badge.
	 **/
    function __construct($badge_id = null, $badge_name = null, $badge_description = null, $icon_path = null, $point_value = null)
    {
        parent::__construct();
        $this->badge_id           = $badge_id;
        $this->badge_name         = $badge_name;
        $this->badge_description  = $badge_description;
        $this->icon_path          = $icon_path;
        $this->point_value        = $point_value;
    }

    /**
     * Save the current badge.
     **/
    public function save()
    {
    	if($this->badge_id == null)
    	{
    		$this->db->insert("Badges", array(
				"badge_name" => $this->badge_name,
				"badge_description" => $this->badge_description,
    			"icon_path" => $this->icon_path,
    			"point_value" => $this->point_value
    		));
    		$this->badge_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"badge_name" => $this->badge_name,
				"badge_description" => $this->badge_description,
    			"icon_path" => $this->icon_path,
    			"point_value" => $this->point_value
       		);
    		$this->db->where("badge_id", $this->badge_id);
    		$this->db->update($update_data);
    	}
    }

    /**
     * Load a badge by id.
     **/
    public static function LoadById($badge_id)
    {
    	$result = &get_instance()->db->get_where("Badges", array("badge_id" => $badge_id));
    	$result = $result->result();
    	return count($result) != 0 ? Badges_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a class with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Badges_model(
   			$row->badge_id,
   			$row->badge_name,
   			$row->badge_description,
   			$row->icon_path,
   			$row->point_value
   		);
   	}
   	
   	/**
   	* Load badges based on criteria.
   	**/
   	public static function getBadesBasedOnCriteria($value, $entity_type, $entity_id)
   	{
   		$results = &get_instance()->db->query("SELECT b.* FROM Badges b JOIN BadgeCriteria bc ON b.badge_id = bc.badge_id and bc.entity_type = ? and bc.threshold_min < ? and bc.threshold_max > ?", 
        array($entity_type, $value, $value))
        ->result();
      $ret = array();
      foreach ($results as $row)
      {
        $ret[] = Badges_model::LoadWithData($row);
      }
      return $ret;
    }

}

