<?php

class Topics_model extends CI_Model {

	public $topic_id, $name, $description, $locked, $premium;

	/**
	 * Create a new topic.
	 **/
    function __construct($topic_id = null, $name = null, $description = null, $locked = false, $premium = false)
    {
        parent::__construct();
        $this->topic_id       = $topic_id;
        $this->name           = $name;
        $this->description    = $description;
        $this->locked         = $locked;
        $this->premium        = $premium;
    }

    /** 
     * Returns all active topics.
     **/
    public static function All()
    {
   		$query = CI_Controller::get_instance()->db->query("select t.topic_id, CONCAT(CONCAT(t.name, '-', c.name) ,'-',c.description) as name, t.description, t.locked,t.premium from
			Topics t, Courses c, CourseTopics ct  where t.topic_id = ct.topic_id and ct.course_id = c.course_id order by t.name asc");
		$topics_ar=array();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$topics_ar[]=Topics_model::LoadWithData($row);
			}
		}
		return $topics_ar;
    }

    /**
     * Save the current topic.
     **/
    public function save()
    {
    	if($this->topic_id == null)
    	{
    		$this->db->insert("Topics", array(
				"name" => $this->name,
				"description" => $this->description,
        "locked" => $this->locked ? 1 : 0,
        "premium" => $this->premium ? 1 : 0
    		));
    		$this->topic_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"name" => $this->name,
				  "description" => $this->description,
          "locked" => $this->locked ? 1 : 0,
          "premium" => $this->premium ? 1 : 0
       		);
    		$this->db->where("topic_id", $this->topic_id);
    		$this->db->update("Topics",$update_data);
    	}
    }
    
    /**
    * Delete the current topic.
    **/
    public function delete()
    {
    	if($this->topic_id != null)
    	{
    		$this->db->where("topic_id", $this->topic_id);
    		$this->db->delete("Topics");
    	}
    }

    /**
     * Load a topic by id.
     **/
    public static function LoadById($topic_id)
    {
    	$result = &get_instance()->db->get_where("Topics", array("topic_id" => $topic_id));
    	$result = $result->result();
    	return count($result) != 0 ? Topics_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a topic with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Topics_model(
   			$row->topic_id,
   			$row->name,
   			$row->description,
        intval($row->locked) == 1,
        intval($row->premium) == 1
   		);
   	}

    /**
     * Return true if this topic is locked for a user
     **/
    public function available($user) {
      if($this->locked) {
        return false;
      } else {
        return $user->isPremium() || !$this->premium;
      }
    }

    /** 
     * Return all questions associated with this topic.
     **/
    public function getQuestions()
    {
      $this->load->model("Questions_model");
      $result = $this->db->query("SELECT `q`.* FROM Questions q JOIN QuestionTopics qt ON q.question_id = qt.question_id AND qt.topic_id = ?", array($this->topic_id))->result();

      $ret = array();
      foreach($result as $r)
        $ret[] = Questions_model::LoadWithData($r);
      return $ret;
    }
    
    /**
   	* get sub topics for a topic.
   	**/
   	public function getSubTopics()
   	{
   		if($this->topic_id == null) return null;
   		$topic_id = $this->topic_id;
   		
   		$this->db->select('*');
		$this->db->from ('Topics');
        $this->db->join('CourseTopics', 'CourseTopics.topic_id = Topics.topic_id', 'inner');
		$this->db->where('CourseTopics.parent_topic_id',$topic_id);
		$this->db->order_by("sort_order", "ASC");
		$query  = $this->db->get();
		$topics_ar=array();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$topics_ar[]=Topics_model::LoadWithData($row);
			}
		}
		return $topics_ar;
   	}
    
    /**
    * Return questions based on question difficulty and count.
    **/
    public function getQuestionsByDifficulty($difficulty, $no_of_questions)
    {
    	$this->load->model("Questions_model");
    	$result = &get_instance()->db->query("select q.* from Questions q , QuestionTopics qt, CourseTopics ct where 
			q.question_id = qt.question_id and
			q.question_id NOT IN (select eq.question_id from UserExamAttempt uea, ExamQuestions eq where 
			uea.user_id = ? and uea.exam_id = eq.exam_id)  and
			qt.topic_id = ct.topic_id and ((ct.parent_topic_id = ?) or (ct.topic_id = ?)) and q.difficulty = ? order by rand() limit ?", array($this->user->user_id, $this->topic_id, $this->topic_id, $difficulty, $no_of_questions))->result();
    
    	$ret = array();
    	foreach($result as $r)
    	$ret[] = Questions_model::LoadWithData($r);
    	return $ret;
    }
    
    /**
	 * Add a course (by course_id) for this topic.
	 **/
	public function addCourseTopicById($course_id)
	{
		return $this->db->insert("CourseTopics", array("topic_id" => $this->topic_id, "course_id" => $course_id));
	}
	
	/**
	 * Add a topic (by topic_id) for this topic.
	 **/
	public function addTopicTopicById($topic_id, $course_id)
	{
		return $this->db->insert("CourseTopics", array("topic_id" => $this->topic_id, "course_id" => $course_id, "parent_topic_id" => $topic_id));
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
    $this->db->where('topic_id', $this->topic_id);

    $subcontent = $this->db->get();

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

  }

  public function userHasCompleted($user_id = null)
  {
    if($user_id === null) {
      $user_id = $this->user->user_id;
    }

    $this->db->select('content_id');
    $this->db->from('TopicContent');
    $this->db->where('topic_id', $this->topic_id);

    $subcontent = $this->db->get();

    foreach($subcontent->result() as $row) {

      $this->db->select('user_content_interaction_id');
      $this->db->from('UserContentInteraction');
      $this->db->where('user_id', $user_id);
      $this->db->where('content_id', $row->content_id);
      $this->db->where('interaction_type', "C");

      $subquery = $this->db->get();
      if($subquery->num_rows == 0) {

        return false;

      }

    }

    return true;

  }

  /**
   * Counts amount of content for each topic.
   **/
  public function getContentCount()
  {

    // Defaults for content amount.
    $content['video'] = 0;
    $content['docs'] = 0;

    $this->db->select('content_type');
    $this->db->from('TopicContent');
    $this->db->join('Content', 'TopicContent.content_id = Content.content_id');
    $this->db->where('topic_id', $this->topic_id);

    $query = $this->db->get();

    foreach($query->result() as $row) {

      if( strtolower($row->content_type) == 'video' ) {

        $content['video']++;

      } else {

        $content['docs']++;

      }

    }

    return $content;

  }

  public function getFirstContent()
  {
  	$this->load->model("Content_model");
    $this->db->select('*');
    $this->db->from('TopicContent');
    $this->db->join('Content', 'TopicContent.content_id = Content.content_id');
    $this->db->where('topic_id', $this->topic_id);
    $this->db->order_by("sort_order", "ASC");
    $query = $this->db->get();

    foreach($query->result() as $row) {
      return Content_model::LoadWithData($row);
    }

    return null;
  }

  /**
   * Counts amount of content for each topic.
   **/
  public function getProgressOverview($user = null, $includeExams = true)
  {
    if($user == null) {
      $user = $this->user;
    }

    $progress['percentage'] = 0;
    $progress['topic_status'] = '';

    
      // Get the total content count
      $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total
                                    FROM `CourseTopics` ct
                                    JOIN `TopicContent` tc
                                    ON tc.topic_id = ct.topic_id
                                    AND (ct.topic_id = ? or ct.parent_topic_id = ? )', array($this->topic_id, $this->topic_id))->result();
      $totalContent = $results[0];
      $totalContent = $totalContent->total;

      if($includeExams) {
        // Get the number of parent topics (each has 3 exams)
        $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total
                                      FROM `CourseTopics` ct
                                      WHERE parent_topic_id IS NULL
                                      AND ct.topic_id = ?', array($this->topic_id))->result();
        $examCount = $results[0];
        $examCount = $examCount->total * 3;    
      } else {
        $examCount = 0;
      }

      // Get the number of completed content items
      $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total 
                                    FROM `CourseTopics` ct
                                    JOIN `TopicContent` tc
                                    ON tc.topic_id = ct.topic_id
                                    AND (ct.topic_id = ? or ct.parent_topic_id = ? )
                                    JOIN `UserContentInteraction` uci
                                    ON uci.content_id = tc.content_id
                                    AND uci.interaction_type = "C"
                                    AND uci.user_id = ?', array($this->topic_id, $this->topic_id, $user->user_id))->result();
      $completedContent = $results[0];
      $completedContent = $completedContent->total;

      if($includeExams) {
        // Get the number of completed exam attempts
        $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total
                                      FROM `CourseTopics` ct
                                      JOIN `ExamTopics` et 
                                      ON ct.topic_id = et.topic_id
                                      AND (ct.topic_id = ? or ct.parent_topic_id = ? )
                                      JOIN `UserExamAttempt` uea 
                                      ON et.exam_id = uea.exam_id
                                      AND uea.user_id = ?
                                      AND uea.status = "C"', array($this->topic_id, $this->topic_id, $user->user_id))->result();
        $examsComplete = $results[0];
        $examsComplete = $examsComplete->total;
      } else {
        $examsComplete = 0;
      }

      $percentage = ($totalContent + $examCount == 0) ? 0 : ($completedContent + $examsComplete) / ($totalContent + $examCount) * 100.0;
      $progress['percentage'] = number_format($percentage, 0, '.', '');

    switch($progress['percentage']) {
      case 0:
        $progress['topic_status'] = '';
        break;
      case 100: 
        $progress['topic_status'] = 'completed';
        break;
      default:
        $progress['topic_status'] = 'started';
        break;
    }

    return $progress;

  }

  public function hasUserStarted($user) {
    // Get the number of completed content items
    $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total 
                                  FROM `CourseTopics` ct
                                  JOIN `TopicContent` tc
                                  ON tc.topic_id = ct.topic_id
                                  AND (ct.topic_id = ? or ct.parent_topic_id = ? )
                                  JOIN `UserContentInteraction` uci
                                  ON uci.content_id = tc.content_id
                                  AND uci.user_id = ?', array($this->topic_id, $this->topic_id, $this->user->user_id))->result();
    $completedContent = $results[0];
    $completedContent = $completedContent->total;

    // Get the number of completed exam attempts
    $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total
                                  FROM `CourseTopics` ct
                                  JOIN `ExamTopics` et 
                                  ON ct.topic_id = et.topic_id
                                  AND (ct.topic_id = ? or ct.parent_topic_id = ? )
                                  JOIN `UserExamAttempt` uea 
                                  ON et.exam_id = uea.exam_id
                                  AND uea.user_id = ?', array($this->topic_id, $this->topic_id, $this->user->user_id))->result();
    $examsComplete = $results[0];
    $examsComplete = $examsComplete->total;

    return $completedContent + $examsComplete > 0;
  }

  public function getParentInfo() {
    $this->db->select("course_id");
    $this->db->from("CourseTopics");
    $this->db->where("topic_id", $this->topic_id);

    $query = $this->db->get();

    return $query->row()->course_id;
  }
   	

  public function getParentTopic() {
    $this->db->select("parent_topic_id");
    $this->db->from("CourseTopics");
    $this->db->where("topic_id", $this->topic_id);

    $query = $this->db->get();
    $ptid = $query->row()->parent_topic_id;
    if($ptid) {
      $topic = Topics_model::LoadById($ptid);
      $thatParent = $topic->getParentTopic();
      return $thatParent ? $thatParent : $this;
    } else {
      return null;
    }
  }
  
  public function getExamBadges()
  {
      $result = $this->db->query("select a.entity_type, case d.exam_type when 1 then 'Exam 1' when 2 then 'Exam 2' when 3 then 'Exam 3' end as badge_type, c.badge_name, c.badge_description, c.icon_path from UserBadgeAward a, ExamTopics b, Badges c, Exams d where
  	b.exam_id = d.exam_id and a.badge_id = c.badge_id and a.entity_id = b.exam_id and
  	a.entity_type = 'exam' and b.topic_id = ? and a.user_id = ? ", array($this->topic_id, $this->user->user_id))->result();

      return $result;
  }
  
  public function getTopicBadges()
  {
  	$result = $this->db->query("select a.entity_type,'course_completion' as badge_type, c.badge_name, c.badge_description, c.icon_path from UserBadgeAward a,  Badges c where
	a.badge_id = c.badge_id and a.entity_id = ?  and
	a.entity_type ='topic' and a.user_id = ?; ", array($this->topic_id, $this->user->user_id))->result();
  
  	return $result;
  }
  
  public function getAllBadgesForTopic()
  {
  	$ret = array();
  	$ret[] = $this->getExamBadges();
  	$ret[] = $this->getTopicBadges();
  	return $ret;
  }
}
?>
