<?php

class Announcement_model extends CI_Model {

	public $announcement_id, $title, $content, $posted_by, $posted_on;

	/**
	 * Create a new badge.
	 **/
    function __construct($announcement_id = null, $title = null, $content = null, $posted_by = null, $posted_on = null)
    {
        parent::__construct();
        $this->announcement_id   = $announcement_id;
        $this->title            = $title;
        $this->content          = $content;
        $this->posted_by        = $posted_by;
        $this->posted_on        = $posted_on;
    }

    /**
     * Save the current badge.
     **/
    public function save()
    {
    	if($this->announcement_id == null)
    	{
    		$this->db->insert("Announcements", array(
  				"title" => $this->title,
  				"content" => $this->content,
    			"posted_by" => $this->posted_by
    		));
    		$this->announcement_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"title" => $this->title,
				  "content" => $this->content,
    			"posted_by" => $this->posted_by
       	);
    		$this->db->where("announcement_id", $this->announcement_id);
    		$this->db->update("Announcements", $update_data);
    	}
    }

    /**
     * Delete this annoucement
     **/
    public function delete() {
      if($this->announcement_id !== null) {
        $this->db->query("DELETE FROM Announcements WHERE announcement_id = ? LIMIT 1", array($this->announcement_id));
      }

      $this->announcement_id = null;
    }

    /**
     * Return the user model who posted this.
     **/
    public function getPostedByUser() {
      $this->load->model("Users_model");
      return Users_model::LoadById($this->posted_by);
    }

    /**
     * Load a badge by id.
     **/
    public static function LoadById($announcement_id)
    {
    	$result = &get_instance()->db->get_where("Announcements", array("announcement_id" => $announcement_id));
    	$result = $result->result();
    	return count($result) != 0 ? Announcement_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a class with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Announcement_model(
   			$row->announcement_id,
   			$row->title,
   			$row->content,
   			$row->posted_by,
   			$row->posted_on
   		);
   	}

    /**
     * Return all announcements ordered by post date.
     **/
    public static function All()
    {
      $result = &get_instance()->db->order_by("posted_on", "DESC")->get_where("Announcements", array());
      $ret = array();
      foreach($result->result() as $r)
        $ret[] = Announcement_model::LoadWithData($r);
      return $ret;
    }

    /**
     * Returns announcements for the given user (currently just all announcements
     **/
    public static function AnnouncementsForUser($user_id, $limit = null) {
      $result = &get_instance()->db->order_by("posted_on", "DESC");
      if($limit !== null) {
        $result->limit($limit);
      }
      $result = $result->get_where("Announcements", array());
      $ret = array();
      foreach($result->result() as $r)
        $ret[] = Announcement_model::LoadWithData($r);
      return $ret; 
    }
}

