<?php
// TODO: Save/Update school
class Classes_model extends CI_Model {

	public $class_id, $name, $description, $school_id;

	/**
	 * Create a new Class.
	 **/
    function __construct($class_id = null, $name = null, $description = null)
    {
        parent::__construct();
        $this->class_id    = $class_id;
        $this->name        = $name;
        $this->description = $description;
    }

    /**
     * Save the current class.
     **/
    public function save()
    {
    	if($this->class_id == null)
    	{
    		$this->db->insert("Classes", array(
				"name" => $this->name,
				"description" => $this->description,
				"school_id" => $this->school_id
    		));
    		$this->class_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"name" => $this->name,
				"description" => $this->description
       		);
    		if($this->school_id != null) $update_data["school_id"] = $this->school_id;
    		$this->db->where("class_id", $this->class_id);
    		$this->db->update($update_data);
    	}
    }

    /**
     * Load a class by id.
     **/
    public static function LoadById($class_id)
    {
    	$result = &get_instance()->db->get_where("Classes", array("class_id" => $class_id));
    	$result = $result->result();
    	return count($result) != 0 ? Classes_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a class with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Classes_model(
   			$row->class_id,
   			$row->name,
   			$row->description
   		);
   	}
   	
   	
   	/**
   	* get school for a class.
   	**/
   	public function getSchool()
   	{
        $school_id = $this->school_id;
        if($school_id == null) return null;
        $this->load->model("Schools_model");
        return Schools_model::LoadWithData(Schools_model::LoadById($school_id));
   	}
   	
   	public static function GetAllClasses()
   	{
   		$ret = array();
   		$result = &get_instance()->db->order_by('description', 'ASC')->get_where("Classes",array('is_active =' => '1'));
   		$result = $result->result();
   		foreach($result as $r){
   			$ret[] = Classes_model::LoadWithData($r); 
   		}
   		return $ret;
   	}
}
?>
