<?php

class Exams_model extends CI_Model {

	public $exam_id, $name, $description, $time_limit_minutes, $exam_type;

	/**
	 * Create a new exam.
	 **/
    function __construct($exam_id = null, $name = null, $description = null, $time_limit_minutes = null, $exam_type = null)
    {
        parent::__construct();
        $this->exam_id 			  = $exam_id;
        $this->name      		  = $name;
        $this->description        = $description;
        $this->time_limit_minutes = $time_limit_minutes;
        $this->exam_type    	  = $exam_type;
    }

    /**
     * Return true if the given topic_id and exam_type is marked as premium
     **/
    public static function IsPremium($topic_id, $exam_type) {
      $result = &get_instance()->db->query("SELECT is_premium FROM PremiumExams WHERE topic_id = ? AND exam_type = ?", array($topic_id, $exam_type));
      $result = $result->result();
      if(count($result) == 0) {
        return false;
      }
      $result = $result[0];
      return $result->is_premium == 1;
    }

    /**
     * Save the current exam.
     **/
    public function save()
    {
    	if($this->exam_id == null)
    	{
    		$this->db->insert("Exams", array(
				"name" => $this->name,
				"description" => $this->description,
    			"time_limit_minutes" => $this->time_limit_minutes,
    			"exam_type" => $this->exam_type
    		));
    		$this->exam_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
    			"name" => $this->name,
				"description" => $this->description,
    			"time_limit_minutes" => $this->time_limit_minutes,
    			"exam_type" => $this->exam_type
       		);
    		$this->db->where("exam_id", $this->exam_id);
    		$this->db->update("Exams", $update_data);
    	}
    }

    /**
     * Load a exam by id.
     **/
    public static function LoadById($exam_id)
    {
    	$result = &get_instance()->db->get_where("Exams", array("exam_id" => $exam_id));
    	$result = $result->result();
    	return count($result) != 0 ? Exams_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a class with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Exams_model(
   			$row->exam_id,
   			$row->name,
   			$row->description,
   			$row->time_limit_minutes,
   			$row->exam_type
   		);
   	}
   	
   	/**
   	* Add a course (by course_id) for this exam.
   	**/
   	public function addExamCourseById($course_id)
   	{
   		return $this->db->insert("ExamCourseRelevance", array("exam_id" => $this->exam_id, "course_id" => $course_id));
   	}
   	
   	/**
   	* Add a topic (by topic_id) for this exam.
   	**/
   	public function addExamTopicById($topic_id)
   	{
   		return $this->db->insert("ExamTopics", array("exam_id" => $this->exam_id, "topic_id" => $topic_id));
   	}
   	
   	/**
   	* Add questions for this exam.
   	**/
   	public function saveExamQuestions($questions)
   	{
   		foreach ($questions as $m => $question){
   			$this->db->insert("ExamQuestions", array("exam_id" => $this->exam_id, "question_id" => $question->question_id, "sort_order" => $m+1));
   		}
   	}
   	
   	/**
   	*  questions for this exam.
   	**/
   	public function getExamQuestions()
   	{
   		
   		if($this->exam_id == null) return null;
   		$exam_id = $this->exam_id;
   		 
   		$this->db->select('*');
   		$this->db->from ('Questions');
   		$this->db->join('ExamQuestions', 'ExamQuestions.question_id = Questions.question_id', 'inner');
   		$this->db->where('ExamQuestions.exam_id',$exam_id);
   		$this->db->order_by("ExamQuestions.sort_order","asc");
   		$query  = $this->db->get();
   		$questions_ar=array();
   		
   		if ($query->num_rows() > 0)
   		{
   			$this->load->model("Questions_model");
   			foreach ($query->result() as $row)
   			{
   				$questions_ar[]=Questions_model::LoadWithData($row);
   			}
   		}
   		return $questions_ar;
   	}
   	
    /**
     * Get a topic name that this exam belongs to
     * NOTE: This isn't the best since an exam can tecnically be linked to multiple topics.
     **/
    public function getTopic() {
      $results = $this->db->query(
        "SELECT t.* 
          FROM ExamTopics et 
          JOIN Topics t
          ON et.topic_id = t.topic_id
          AND et.exam_id = ?",
        array($this->exam_id)
      )->result();

      foreach ($results as $result) {
        return $result->name;
      }
    }

    public function getTopicId() {
      $results = $this->db->query(
        "SELECT t.* 
          FROM ExamTopics et 
          JOIN Topics t
          ON et.topic_id = t.topic_id
          AND et.exam_id = ?",
        array($this->exam_id)
      )->result();

      foreach ($results as $result) {
        return $result->topic_id;
      }
    }

   	/**
   	* get exam type
   	**/
   	public function getExamType()
   	{
   		switch($this->exam_type)
   		{
   			case 1:
   				return 'Easy';
   			case 2:
   				return 'Medium';
   			case 3:
   				return 'Hard';
   			default:
   				return '';
   		}
   	}
}
?>
