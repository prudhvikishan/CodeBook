<?php
class Schools_model extends CI_Model {

	public $school_id, $name, $description, $address_id, $is_school_verified;

	/**
	 * Create a new School.
	 **/
    function __construct($school_id = null, $name = null, $description = null, $address_id = null, $is_school_verified = null )
    {
        parent::__construct();
        $this->school_id      = $school_id;
        $this->name     	  = $name;
        $this->description    = $description;
        $this->address_id     = $address_id;
        $this->is_school_verified = $is_school_verified;
    }

    public static function Leaderboard($timeFrame = "all", $school_id = 0) {
      switch($timeFrame) {
        case "7days":
          $startDate = strtotime("-7 days");
          $endDate = strtotime("now");
          break ;
        case "lastweek":
        	$Current = Date('N');
        	$DaysToSunday = 14 - $Current;
        	$DaysFromMonday = 7+$Current - 1;
        	$endDate = StrToTime("- {$DaysToSunday} Days");
        	$startDate = StrToTime("- {$DaysFromMonday} Days");
          break ;
        case "thismonth":
          $startDate = strtotime(date("Y-m", mktime()) . "-01");
          $endDate = strtotime(date("Y-m-d", $startDate) . " +1 month -1 day");
          break ;
        case "thisweek":
          $startDate = strtotime('last Monday', strtotime('tomorrow'));
          $endDate = strtotime("tomorrow");
          break ;
        case "thisyear":
          $startDate = strtotime("January 1st " . date('Y'));
          $endDate = strtotime("now");
          break ;
        case "lastmonth":
          $startDate = strtotime(date("Y-m", mktime()) . "-01 -1 month");
          $endDate = strtotime(date("Y-m-d", $startDate) . " +1 month -1 day");
          break ;
        case "lastyear":
          $startDate = strtotime("first day of january " . (date("Y") -1 ));
          $endDate = strtotime("last day of december" . (date("Y") - 1 ));
          break ;
        default:
          $startDate = 0;
          $endDate = strtotime("tomorrow");
      }
      $query = "SELECT s.name AS schoolname, ss.section AS section, COUNT( * ) AS totalstudents, IFNULL(SUM( p.userpoints ), 0) AS points
                  FROM SchoolUsers su, Schools s, SchoolSections ss, (
                    SELECT u.user_id, SUM( p.point_value ) AS userpoints
                    FROM Users u
                    LEFT JOIN UserPointAwards p 
                    ON u.user_id = p.user_id
                    AND p.`timestamp` BETWEEN ? AND ?
                    GROUP BY u.user_id
                  )p
                WHERE su.school_id = s.school_id
                AND su.school_section_id = ss.school_section_id";
      if($school_id != 0){
      	$query .= " AND su.school_id = " .$school_id;
      }
               $query .=  " AND su.user_id = p.user_id and su.school_id<>7
                GROUP BY su.school_id, ss.school_section_id 
                ORDER BY points desc,schoolname";

      $ret = &get_instance()->db->query(
        $query, 
        array(
          date('Y-m-d', $startDate), 
          date('Y-m-d', $endDate)
        )
      )->result();
      return $ret;
    }

    /**
     * Save the current school.
     **/
    public function save()
    {
    	if($this->school_id == null)
    	{
    		$this->db->insert("Schools", array(
				"name" => $this->name,
				"description" => $this->description,
				"address_id" => $this->address_id,
				"is_school_verified" => $this->is_school_verified
    		));
    		$this->school_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"name" => $this->name,
				"description" => $this->description,
    			"is_school_verified" => $this->is_school_verified
    		
       		);
    		if($this->address_id != null) $update_data["address_id"] = $this->address_id;
    		$this->db->where("school_id", $this->school_id);
    		$this->db->update($update_data);
    	}
    }

    /**
     * Load a School by id.
     **/
    public static function LoadById($school_id)
    {
    	$result = &get_instance()->db->get_where("Schools", array("school_id" => $school_id));
    	$result = $result->result();
    	return count($result) != 0 ? Schools_model::LoadWithData($result[0]) : null;
    }

    
    /**
    * Load a School by Name.
    **/
    public static function LoadByName($school)
    {
    	$result = &get_instance()->db->get_where("Schools", array("name" => $school));
    	$result = $result->result();
    	return count($result) != 0 ? Schools_model::LoadWithData($result[0]) : null;
    }

    /**
     * Load a school with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Schools_model(
   			$row->school_id,
   			$row->name,
   			$row->description,
   			$row->address_id,
   			$row->is_school_verified
   		);
   	}
   	
   	/**
   	* get school address.
   	**/
   	public function getAddress()
   	{
   		$this->load->model("Address_model");
   		 
        $address_id = $this->address_id;
        if($address_id == null) return null;
        return Address_model::LoadWithData(Address_model::LoadById($address_id));
    }
    
    /**
    * Load all Schools.
    **/
    public static function GetAllSchools()
    {
    	$ret = array();
    	$result = &get_instance()->db->order_by('name', 'ASC')->get_where("Schools");
    	$result = $result->result();
    	foreach($result as $r){
    		 $school = Schools_model::LoadWithData($r);
    		 $ret[] = $school;
    	}
    	return $ret;
    }
    
    /**
    * Load all Schools.
    **/
    public static function GetAllSchoolsWithAddress()
    {
    	$ret = array();
    	$result = &get_instance()->db->order_by('name', 'ASC')->get_where("Schools");
    	$result = $result->result();
    	foreach($result as $r){
    		$school = Schools_model::LoadWithData($r);
    		$address = $school->getAddress();
    		if($address != null)
    		{
    			$name=$school->name."(".$address->city.",".$address->state.")";
    		} else {
    			$name=$school->name;
    		}
    		$school->name = $name;
    		$ret[] = $school;
    	}
    	return $ret;
    }
    
    
    /**
    * Return all users for this school
    **/
    public function getUsers()
    {
    
    	$this->db->select('*');
    	$this->db->from ('Users');
    	$this->db->join('SchoolUsers', 'SchoolUsers.user_id = Users.user_id', 'inner');
    	$this->db->where('SchoolUsers.school_id',$this->school_id);
    	$query  = $this->db->get();
    	$users_ar=array();
    
    	if ($query->num_rows() > 0)
    	{
    		$this->load->model("Users_model");
    		foreach ($query->result() as $row)
    		{
    			$users_ar[]=Users_model::LoadWithData($row);
    		}
    	}
    	return $users_ar;
    }
    
    /**
    * Return all users for this school
    **/
    public function getUsersBasedOnSectio($section_id)
    {
    
    	$this->db->select('*');
    	$this->db->from ('Users');
    	$this->db->join('SchoolUsers', 'SchoolUsers.user_id = Users.user_id', 'inner');
    	$this->db->where('SchoolUsers.school_id',$this->school_id);
    	$this->db->where('SchoolUsers.school_section_id',$section_id);
    	$query  = $this->db->get();
    	$users_ar=array();
    	if ($query->num_rows() > 0)
    	{
    		$this->load->model("Users_model");
    		foreach ($query->result() as $row)
    		{
    			$users_ar[]=Users_model::LoadWithData($row);
    		}
    	}
    	return $users_ar;
    }
   	
}
?>
