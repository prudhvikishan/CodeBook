<?php
class SchoolSections_model extends CI_Model {

	public $school_section_id, $section;

	/**
	 * Create a new School.
	 **/
    function __construct($school_section_id = null, $section = null)
    {
        parent::__construct();
        $this->school_section_id      = $school_section_id;
        $this->section     	  		  = $section;
    }

   

    /**
     * Load a School section by id.
     **/
    public static function LoadById($school_id)
    {
    	$result = &get_instance()->db->get_where("SchoolSections", array("school_section_id" => $school_section_id));
    	$result = $result->result();
    	return count($result) != 0 ? SchoolSections_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a school section with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new SchoolSections_model(
   			$row->school_section_id,
   			$row->section
   		);
   	}
   	
   
    
    /**
    * Load all School Sections.
    **/
    public static function GetAllSchoolSections()
    {
    	$ret = array();
    	$result = &get_instance()->db->order_by('section', 'ASC')->get_where("SchoolSections");
    	$result = $result->result();
    	foreach($result as $r){
    		$ret[] = SchoolSections_model::LoadWithData($r);
    	}
    	return $ret;
    }
   	
}
?>
