<?php

class Courses_model extends CI_Model {

	public $course_id, $name, $description;

	/**
	 * Create a new course.
	 **/
    function __construct($course_id = null, $name = null, $description = null)
    {
        parent::__construct();
        $this->course_id      = $course_id;
        $this->name        = $name;
        $this->description    = $description;
    }

    /**
     * Save the current course.
     **/
    public function save()
    {
    	if($this->course_id == null)
    	{
    		$this->db->insert("Courses", array(
				"name" => $this->name,
				"description" => $this->description
    		));
    		$this->course_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"name" => $this->name,
				"description" => $this->description
       		);
    		$this->db->where("course_id", $this->course_id);
    		$this->db->update("Courses", $update_data);
    	}
    }
    
     
    /**
    * Delete the current course.
    **/
    public function delete()
    {
    	if($this->course_id != null)
    	{
    		$this->db->where("course_id", $this->course_id);
    		$this->db->delete("Courses");
    	}
    }

    /**
     * Load a course by id.
     **/
    public static function LoadById($course_id)
    {
    	$result = &get_instance()->db->get_where("Courses", array("course_id" => $course_id));
    	$result = $result->result();
    	return count($result) != 0 ? Courses_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a course with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Courses_model(
   			$row->course_id,
   			$row->name,
   			$row->description
   		);
   	}
   	
    /** 
     * Get all courses
     **/
    public static function All()
    {
      $results = &get_instance()->db->get("Courses")->result();
      $ret = array();
      foreach($results as $r)
        $ret[] = Courses_model::LoadWithData($r);
      return $ret;
    }

    /**
     * Get the completion percentation
     **/
    public function completionPercentageForUser($user, $includeExams = true) {
      if(is_int($user)) {
        $user_id = $user;
      } else {
        $user_id = $user->user_id;
      }

      // Get the total content count
      $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total
                                    FROM `CourseTopics` ct
                                    JOIN `TopicContent` tc
                                    ON tc.topic_id = ct.topic_id
                                    AND ct.course_id = ?', array($this->course_id))->result();
      $totalContent = $results[0];
      $totalContent = intval($totalContent->total);

      // Get the number of parent topics (each has 3 exams)
      if($includeExams == true) {
        $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total
                                      FROM `CourseTopics` ct
                                      WHERE parent_topic_id IS NULL
                                      AND ct.course_id = ?', array($this->course_id))->result();
        $examCount = $results[0];
        $examCount = intval($examCount->total) * 3;    
      } else {
        $examCount = 0;
      }

      // Get the number of completed content items
      $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total 
                                    FROM `CourseTopics` ct
                                    JOIN `TopicContent` tc
                                    ON tc.topic_id = ct.topic_id
                                    AND ct.course_id = ?
                                    JOIN `UserContentInteraction` uci
                                    ON uci.content_id = tc.content_id
                                    AND uci.interaction_type = "C"
                                    AND uci.user_id = ?', array($this->course_id, $user_id))->result();
      $completedContent = $results[0];
      $completedContent = intval($completedContent->total);

      // Get the number of completed exam attempts
      if($includeExams == true) {
        $results = $this->db->query('SELECT IFNULL(COUNT(*), 0) as total
                                      FROM `CourseTopics` ct
                                      JOIN `ExamTopics` et 
                                      ON ct.topic_id = et.topic_id
                                      AND ct.course_id = ?
                                      JOIN `UserExamAttempt` uea 
                                      ON et.exam_id = uea.exam_id
                                      AND uea.user_id = ?
                                      AND uea.status = "C"', array($this->course_id, $user_id))->result();
        $examsComplete = $results[0];
        $examsComplete = intval($examsComplete->total);
      } else {
        $examsComplete = 0;
      }

      return ($completedContent + $examsComplete) / ($totalContent + $examCount) * 100.0;
    }

    public function getFastPercentageForUser($user) {
      // Go through each topic and compute the percent compelte for that topic
      $topics = $this->getCourseTopics();
      $numTopics = count($topics) * 1.0;
      $totalComplete = 0;
      foreach ($topics as $topic) {
        $pct = $topic->getProgressOverview($user);
        $pct = floatval($pct["percentage"]);
        $totalComplete += $pct / $numTopics;
      }
      
      return $totalComplete;
    }

    /**
     * Return how many points have been earned in this course.
     **/
    public function pointsForUser($user) {
      // Get the points for questions in the course
      $results = $this->db->query('SELECT sum(point_value) as points
                                    FROM `UserPointAwards` 
                                    WHERE user_id = ?
                                    AND event_entity_type = "Question"
                                    AND entity_id IN (
                                      SELECT eq.question_id
                                      FROM `CourseTopics` ct
                                      JOIN `ExamTopics` et
                                      ON ct.topic_id = et.topic_id
                                      AND ct.course_id = ?
                                      JOIN `ExamQuestions` eq
                                      ON eq.exam_id = et.exam_id
                                      AND ct.course_id = ?
                                    )', array($user->user_id, $this->course_id, $this->course_id))->result();
      $questionPoints = $results[0];
      $questionPoints = $questionPoints->points;

      $results = $this->db->query('SELECT IFNULL(SUM(upa.point_value), 0) as points
                                    FROM `CourseTopics` ct
                                    JOIN `TopicContent` tc
                                    ON tc.topic_id = ct.topic_id
                                    AND ct.course_id = ?
                                    JOIN `UserPointAwards` upa
                                    ON upa.event_entity_type = "Content"
                                    AND upa.user_id = ?
                                    AND upa.entity_id = tc.content_id', array($this->course_id, $user->user_id))->result();
      $contentPoints = $results[0];
      $contentPoints = $contentPoints->points;

      $results = $this->db->query('SELECT SUM(point_value) as points FROM `UserPointAwards`
                                    WHERE event_entity_type = "Exam Bonus"
                                    AND user_id = ?
                                    AND entity_id IN (
                                       SELECT et.exam_id
                                       FROM `ExamTopics` et
                                       JOIN `CourseTopics` ct
                                       ON et.topic_id = ct.topic_id
                                       AND ct.course_id = ?
                                    )', array($user->user_id, $this->course_id))->result();
      $bonusPoints = $results[0];
      $bonusPoints = $bonusPoints->points;
      
      return $questionPoints + $contentPoints + $bonusPoints;
    }

   	/**
   	* get topics for a course.
   	**/
   	public function getCourseTopics()
   	{
   		if($this->course_id == null) return null;
   		$course_id = $this->course_id;
   		
   		$this->db->select('*');
		  $this->db->from ('Topics');
      $this->db->join('CourseTopics', 'CourseTopics.topic_id = Topics.topic_id', 'inner');
      $this->db->where('CourseTopics.parent_topic_id', null);
		  $this->db->where('CourseTopics.course_id',$course_id);
		  $this->db->order_by("sort_order", "ASC");
		  $query  = $this->db->get();
		  $topics_ar=array();
		
  		if ($query->num_rows() > 0)
  		{
  			$this->load->model("Topics_model");
  			foreach ($query->result() as $row)
  			{
  				$topics_ar[]=Topics_model::LoadWithData($row);
  			}
  		}
  		return $topics_ar;
   	}
   	
    public function isIntroCourse() { return $this->course_id == 25; }

    /**
     * Return the courses which the given user is associated with.
     **/
    public static function CoursesForUser($user_id)
    {
      $results = &get_instance()->db
        ->query("SELECT c.* FROM Courses c JOIN UserCourses uc ON c.course_id = uc.course_id and uc.user_id = ? order by c.course_order asc", array(intval($user_id)))
        ->result();

      $ret = array();
     // $introCourseOnly = false;
      foreach ($results as $row)
      {
        $course = Courses_model::LoadWithData($row);
//         if($course->isIntroCourse() && $course->completionPercentageForUser(intval($user_id), false) < 100) {
//           $introCourseOnly = $course;
//         }
        	$ret[] = $course;
      }

//       if($introCourseOnly != false) {
//         return array($introCourseOnly);
//       }

      return $ret;
    }
}
?>
