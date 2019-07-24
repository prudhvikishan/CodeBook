<?php
class ContentComment_model extends CI_Model {

	public $content_comment_id, $comment, $content_id, $posted_by, $posted_on;

    function __construct($content_comment_id = null, $comment = null, $content_id = null, $posted_by = null, $posted_on = null)
    {
        parent::__construct();
        $this->content_comment_id      = $content_comment_id;
        $this->comment     	  = $comment;
        $this->content_id    = $content_id;
        $this->posted_by     = $posted_by;
        $this->posted_on     = $posted_on;
    }

    public function save()
    {
    	if($this->content_comment_id == null)
    	{
    		$this->db->insert("ContentComment", array(
				"comment" => $this->comment,
				"content_id" => $this->content_id,
				"posted_by" => $this->posted_by,
        "posted_on" => $this->posted_on
    		));
    		$this->content_comment_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"comment" => $this->comment,
				  "content_id" => $this->content_id,
          "posted_by" => $this->posted_by,
          "posted_on" => $this->posted_on,
       		);
    		$this->db->where("content_comment_id", $this->content_comment_id);
    		$this->db->update($update_data);
    	}
    }

    public function getPosterName() {
      $this->load->model("Users_model");
      $user = Users_model::LoadById($this->posted_by);
      if($user) {
        return $user->getName();
      } else {
        return "Anonymous";
      }
    }

    public static function LoadById($content_comment_id)
    {
    	$result = &get_instance()->db->get_where("ContentComment", array("content_comment_id" => $content_comment_id));
    	$result = $result->result();
    	return count($result) != 0 ? ContentComment_model::LoadWithData($result[0]) : null;
    }

   	public static function LoadWithData($row)
   	{
   		return new ContentComment_model(
   			$row->content_comment_id,
   			$row->comment,
   			$row->content_id,
        $row->posted_by,
        $row->posted_on
   		);
   	}

    public static function CommentsForContentId($content_id) {
      $result = &get_instance()->db->get_where("ContentComment", array("content_id" => $content_id));
      $result = $result->result();
      $return = array();
      foreach ($result as $row) {
        $return[] = ContentComment_model::LoadWithData($row);
      }
      return $return;
    }
}