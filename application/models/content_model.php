<?php
class Content_model extends CI_Model {

	public $content_id, $content_type, $content_path, $name, $description, $locked, $premium, $is_hosted_external, $embed_html;

  private static $replace_elements = null;

	/**
	 * Create a new Class.
	 **/
    function __construct($content_id = null, $content_type = "", $content_path = "", $name = "", $description = "", $locked = false, $premium = false, $is_hosted_external=0, $embed_html="")
    {
        parent::__construct();
        $this->content_id     = $content_id;
        $this->content_type   = $content_type;
        $this->content_path   = $content_path;
        $this->name           = $name;
        $this->description    = $description;
        $this->locked         = $locked;
        $this->premium        = $premium;
        $this->is_hosted_external         = $is_hosted_external;
        $this->embed_html        = $embed_html;
    }

    /**
     * Return the replacement elements
     **/
    public static function getReplacementElements() {
      if(self::$replace_elements == null) {
        // go to the DB and load in the elements 
        self::$replace_elements = array();
        $result = &get_instance()->db->get("compiled_html_elements");
        $result = $result->result();
        foreach ($result as $row) {
          self::$replace_elements[$row->text] = $row->replacement;
        }
      }
      return self::$replace_elements;
    }

    /**
     * Compile HTML content
     **/
    public static function compileHTML($html) {
      if(self::$replace_elements == null) {
        // go to the DB and load in the elements 
        self::$replace_elements = array();
        $result = &get_instance()->db->get("compiled_html_elements");
        $result = $result->result();
        foreach ($result as $row) {
          self::$replace_elements[$row->text] = $row->replacement;
        }
      }

      // Loop over the replace elements and drop them in
      foreach (self::$replace_elements as $search => $replace) {
        $html = str_replace($search, $replace, $html);
      }
      return $html; 
    }

    /**
     * Save the current class.
     **/
    public function save()
    {
    	if($this->content_id == null)
    	{
    		$this->db->insert("Content", array(
          "content_type" => $this->content_type,
          "content_path" => $this->content_path,
          "compiled_content" => Content_model::compileHTML($this->content_path),
          "name" => $this->name,
          "description" => $this->description,
          "locked" => $this->locked ? 1 : 0,
          "premium" => $this->premium ? 1 : 0,
          "is_hosted_external" => $this->is_hosted_external,
          "embed_html" => $this->embed_html
    		));
    		$this->content_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
          "content_type" => $this->content_type,
          "content_path" => $this->content_path,
          "compiled_content" => Content_model::compileHTML($this->content_path),
          "name" => $this->name,
          "description" => $this->description,
          "locked" => $this->locked ? 1 : 0,
          "premium" => $this->premium ? 1 : 0,
          "is_hosted_external" => $this->is_hosted_external,
          "embed_html" => $this->embed_html
       	);
    		$this->db->where("content_id", $this->content_id);
    		$this->db->update("Content", $update_data);
    	}
    }

    /**
     * Load a class by id.
     **/
    public static function LoadById($content_id)
    {
    	$result = &get_instance()->db->get_where("Content", array("content_id" => $content_id));
    	$result = $result->result();
    	return count($result) != 0 ? Content_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a class with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Content_model(
   			$row->content_id,
        $row->content_type,
        $row->content_path,
        $row->name,
        $row->description,
        intval($row->locked) == 1 ? true : false,
        intval($row->premium) == 1 ? true : false,
        $row->is_hosted_external,
        $row->embed_html
   		);
   	}

    /**
     * Return true if this content is locked for a user
     **/
    public function available($user) {
      if($this->locked) {
        return false;
      } else {
        return $user->isPremium() || !$this->premium;
      }
    }

    /**
     * Return all content for the given topic.
     **/
    public static function ContentForTopicId($topic_id)
    {
      $ret = array();
      $result = &get_instance()->db->query(
        "SELECT c.* FROM Content c JOIN TopicContent tc ON c.content_id = tc.content_id and tc.topic_id = ? ORDER BY tc.sort_order",
        array( $topic_id )
      );
      foreach($result->result() as $r)
        $ret[] = Content_model::LoadWithData($r);
      return $ret;
    }
    
    /**
    * Return all content for the parent topic.
    **/
    public static function ContentForParentTopicId($parent_topic_id, $topic_id)
    {
    	$ret = array();
    	$result = &get_instance()->db->query(
            "SELECT Topics.topic_id, c.content_id, c.content_type,c.content_path, c.name, c.description FROM Content c JOIN TopicContent tc ON c.content_id = tc.content_id 
            Join CourseTopics ON tc.topic_id = CourseTopics.topic_id Join Topics ON
			Topics.topic_id = tc.topic_id and (CourseTopics.parent_topic_id = ? or CourseTopics.topic_id = ?) order by Topics.topic_id",
    	array( $parent_topic_id , $parent_topic_id));
    	$contents = $result->result();
    	$i=0;
    	foreach($contents as $row){
    		$is_current_topic = false;
    		$content = new Content_model(
    		$row->content_id,
    		$row->content_type,
    		$row->content_path,
    		$row->name,
    		$row->description);
    		foreach ($ret as $k => $r){
    			if($r['topic_id'] == $row->topic_id){
    				$cont = $ret[$k]['content'] ;
    				$cont[] = $content;
    				$ret[$k]['content'] = $cont;
    			} else {
    				if($topic_id == $row->topic_id)
    					$is_current_topic=true;
    				$ret[] = array("topic_id"=> $row->topic_id, "content"=>$content,"is_current_topic"=>$is_current_topic);
    			}
    		}
    		if($i==0){
    			$conts = array();
    			$conts[] = $content;
    			if($topic_id == $row->topic_id)
    				$is_current_topic=true;
    			$ret[] = array("topic_id"=> $row->topic_id, "content"=>$conts,"is_current_topic"=>$is_current_topic);
    		}
    		$i++;    		
    	}
    	return $ret;
    }

    /**
     * Add a topic (by topic_id) for this content, if it already has this topic, nothing will happen.
     **/
    public function addTopicById($topic_id)
    {
      return $this->db->insert("TopicContent", array("content_id" => $this->content_id, "topic_id" => $topic_id));
    }

    /**
     * Return all topics associated with this topic.
     **/
    public function getTopics()
    {
      $this->load->model("Topics_model");
      $result = $this->db->select("Topics.*")
           ->from("Topics")
           ->join("TopicContent", "TopicContent.topic_id = Topics.topic_id")
           ->where('TopicContent.content_id', $this->content_id)
           ->get()->result();

      $ret = array();
      foreach($result as $r)
        $ret[] = Topics_model::LoadWithData($r);
      return $ret;
    }

    /**
     * Remove all topics given in the array of topic ids.
     **/
    public function removeTopics($topics)
    {
      $sql = "DELETE FROM TopicContent WHERE content_id = ? AND topic_id = ?";
      foreach($topics as $topic_id)
        $this->db->query($sql, array($this->content_id, $topic_id));
    }

    /**
     * Returns true if this content is linked to a course that the user is enrolled in.
     **/
    public function canUserView($user_id = null)
    {
      if($user_id === null)
        $user_id = $this->user->user_id;

      $results = $this->db->query("
        SELECT * 
        FROM TopicContent tc 
        JOIN CourseTopics ct 
        ON tc.topic_id = ct.topic_id
        JOIN UserCourses ccu 
        ON ct.course_id = ccu.course_id
        AND ccu.user_id = ?", array($user_id));
      foreach($results->result() as $r)
        return true;
      return false;
    }

    /**
     * Marks content as viewed for the user.
     **/
    public function userViewed($user_id = null)
    {
      if($user_id === null) {
        $user_id = $this->user->user_id;
      }

       $data = array(
          "user_id" => $user_id,
          "content_id" => $this->content_id,
          "interaction_type" => "V"
        );

        return $this->db->insert('UserContentInteraction', $data);


      // $this->db->select('user_content_interaction_id');
      // $this->db->from('UserContentInteraction');
      // $this->db->where('user_id', $user_id);
      // $this->db->where('content_id', $this->content_id);

      // $query = $this->db->get();

      // // See if content has already been viewed, otherwise insert into db.
      // if($query->num_rows == 0) {

      //   $data = array(
      //     "user_id" => $user_id,
      //     "content_id" => $this->content_id,
      //     "interaction_type" => "V"
      //   );

      //   return $this->db->insert('UserContentInteraction', $data);

      // } else {

      //   return false;

      // }

    }

    public function getParentInfo() {
      $this->db->select("CourseTopics.course_id, CourseTopics.topic_id, CourseTopics.parent_topic_id");
      $this->db->from("TopicContent");
      $this->db->join("CourseTopics", "TopicContent.topic_id = CourseTopics.topic_id");
      $this->db->where("content_id", $this->content_id);

      $query = $this->db->get();

      $data['course_id'] = $query->row()->course_id;
      $data['topic_id'] = $query->row()->topic_id;
      $data['parent_topic_id'] = $query->row()->parent_topic_id;
      
      return $data;

    }

    /**
     * Marks content as completed for the user.
     **/
    public function userCompleted($user_id = null)
    {
      if($user_id === null) {
        $user_id = $this->user->user_id;
      }

      $this->db->select('user_content_interaction_id');
      $this->db->from('UserContentInteraction');
      $this->db->where('user_id', $user_id);
      $this->db->where('content_id', $this->content_id);
      $this->db->where('interaction_type', 'C');

      $query = $this->db->get();

      // See if content has already been viewed, otherwise insert into db.
      if($query->num_rows == 0) {

        $data = array(
          "user_id" => $user_id,
          "content_id" => $this->content_id,
          "interaction_type" => "C"
        );

        return $this->db->insert('UserContentInteraction', $data);

      } else {

        return false;

      }

    }

    /**
     * Marks content as viewed for the user.
     **/
    public function userHasViewed($user_id = null)
    {
      if($user_id === null) {
        $user_id = $this->user->user_id;
      }

      $this->db->select('content_id');
      $this->db->from('TopicContent');
      $this->db->where('topic_id', $this->content_id);

      $subcontent = $this->db->get();

      if($subcontent->num_rows > 0) {

        foreach($subcontent->result() as $row) {

          $this->db->select('user_content_interaction_id');
          $this->db->from('UserContentInteraction');
          $this->db->where('user_id', $user_id);
          $this->db->where('content_id', $row->content_id);
          $this->db->where('interaction_type', "V");

          $subquery = $this->db->get();

          if($subquery->num_rows == 0) {

            return false;

          }

        }

        return true;

      } else {

        $this->db->select('user_content_interaction_id');
        $this->db->from('UserContentInteraction');
        $this->db->where('user_id', $user_id);
        $this->db->where('content_id', $this->content_id);
        $this->db->where('interaction_type', "V");

        $query = $this->db->get();

        // See if content has been viewed by the user
        if($query->num_rows == 0) {

          return false;

        } else {

          return true;

        }

      }

    }

    public function resumeContent($user_id = null) {
     if($user_id === null) {
  		$user_id = $this->user->user_id;
  	}
  
  	// $this->db->select("CourseTopics.course_id, TopicContent.topic_id, Topics.name");
  	// $this->db->from("UserContentInteraction");
  	// $this->db->join("TopicContent", "UserContentInteraction.content_id = TopicContent.content_id");
  	// $this->db->join("CourseTopics", "TopicContent.topic_id = CourseTopics.topic_id");
  	// $this->db->join("Topics", "Topics.topic_id = TopicContent.topic_id");
  	// $this->db->where("UserContentInteraction.user_id", $user_id);
  	// $this->db->group_by("UserContentInteraction.user_id, CourseTopics.course_id");
  	// $this->db->order_by("timestamp", "desc");


  
  	// $query = $this->db->get();
  	// $list_ar=array();
   // 	foreach($query->result() as $row) {
  	// 		$list['course_id'] = $row->course_id;
  	// 		$list['topic_id'] = $row->topic_id;
  	// 		$list['topic_name'] = $row->name;
  	// 		$list_ar[]=$list;
  	// }
  	// return $list_ar;

      $results = $this->db->query(
        "SELECT ct.course_id, tc.topic_id, t.name 
          FROM UserContentInteraction uci 
          JOIN TopicContent tc 
          ON uci.content_id = tc.content_id
          AND uci.user_id = ?
          JOIN CourseTopics ct 
          ON tc.topic_id = ct.topic_id
          JOIN Topics t 
          ON t.topic_id = ct.topic_id
          ORDER BY uci.`timestamp` DESC",
          array($user_id)
      )->result();

      $courses = array();
      foreach ($results as $r) {
        if(!array_key_exists($r->course_id, $courses)) {
          $courses[$r->course_id] = array(
            "course_id" => $r->course_id,
            "topic_id" => $r->topic_id,
            "topic_name" => $r->name
          );
        }
      }

      return $courses;
    }

    /**
     * Marks content as viewed for the user.
     **/
    public function userHasCompleted($user_id = null)
    {
      if($user_id === null) {
        $user_id = $this->user->user_id;
      }

        $this->db->select('user_content_interaction_id');
        $this->db->from('UserContentInteraction');
        $this->db->where('user_id', $user_id);
        $this->db->where('content_id', $this->content_id);
        $this->db->where('interaction_type', "C");
        $query = $this->db->get();
        // See if content has been viewed by the user
        if($query->num_rows == 0) {
          return false;
        } else {
          return true;
        }

    }
    
    /**
    * Marks content as viewed for the user.
    **/
    public function isUserCompleted($user_id = null, $content_id)
    {
    	if($user_id === null) {
    		$user_id = $this->user->user_id;
    	}
    
    	$this->db->select('user_content_interaction_id');
    	$this->db->from('UserContentInteraction');
    	$this->db->where('user_id', $user_id);
    	$this->db->where('content_id', $content_id);
    	$this->db->where('interaction_type', "C");
    	$subquery = $this->db->get();
    	if($subquery->num_rows == 0) {
    		return false;
    	}
    	return true;
    }
    
    public function isLastContentForTopic($user_id = null, $topic_id, $content_id){
    	if($user_id === null) {
    		$user_id = $this->user->user_id;
    	}

    	$result = $this->db->query(
            "SELECT tc.content_id FROM TopicContent tc , CourseTopics ct where tc.content_id NOT IN (select uci.content_id  from UserContentInteraction uci 
             where uci.user_id = ? and uci.interaction_type = 'C') and tc.topic_id = ct.topic_id and (ct.topic_id = ? or ct.parent_topic_id = ?)",
    	array( $user_id , $topic_id,$topic_id));
    	$contents = $result->result();
    	if(count($contents) == 1) {
    		foreach ($contents as $r){
    			if($r->content_id == $content_id)
    				return true;
    		}
    	}
    	return false;
    }

}
?>
