<?php

class UserExam_model extends CI_Model {


	public $user_exam_attempt_id, $user_id, $exam_id, $score, $correct, $possible, $status, $started, $finished;

	/**
	 * Create a new link to user and exam.
	 **/
	function __construct($user_exam_attempt_id = null, $user_id = null, $exam_id = null, $score = null, $correct = null, $possible = null, $status = null, $started = null, $finished = null)
	{
		parent::__construct();
		$this->user_exam_attempt_id     = $user_exam_attempt_id;
		$this->user_id        			= $user_id;
		$this->exam_id 				    = $exam_id;
		$this->score    	  			= $score;
		$this->correct        			= $correct;
		$this->possible 				= $possible;
		$this->status    			    = $status;
		$this->started 					= $started;
		$this->finished    		     	= $finished;
	}

    /**
     * Save the user exam.
     **/
    public function save()
    {
    	if($this->user_exam_attempt_id == null)
    	{
    		$this->db->insert("UserExamAttempt", array(
				"user_id" => $this->user_id,
				"exam_id" => $this->exam_id,
    			"score" => $this->score,
    			"correct" => $this->correct,
    		    "possible" => $this->possible,
    			"status" => $this->status,
    		  	"started" => $this->started,
    		    "finished" => $this->finished
    		));
    		$this->user_exam_attempt_id = $this->db->insert_id();
    	}	
    	else
    	{
    		$update_data = array(
				"user_id" => $this->user_id,
				"exam_id" => $this->exam_id,
    			"score" => $this->score,
    			"correct" => $this->correct,
    		    "possible" => $this->possible,
    			"status" => $this->status,
    		  	"started" => $this->started,
    		    "finished" => $this->finished
    		);
    		$this->db->where("user_exam_attempt_id", $this->user_exam_attempt_id);
    		$this->db->update("UserExamAttempt", $update_data);
    	}
    }

    /**
     * Load a user exam by id.
     **/
    public static function LoadById($user_exam_attempt_id)
    {
    	$result = &get_instance()->db->get_where("UserExamAttempt", array("user_exam_attempt_id" => $user_exam_attempt_id));
    	$result = $result->result();
    	return count($result) != 0 ? UserExam_model::LoadWithData($result[0]) : null;
    }
    
    /**
    * Load a user exam  by userid and exam id.
    **/
    public static function LoadByUserExamId($user_id, $exam_id)
    {
    	$result = &get_instance()->db->get_where("UserExamAttempt", array("user_id" => $user_id, "exam_id" => $exam_id));
    	$result = $result->result();
    	return count($result) != 0 ? UserExam_model::LoadWithData($result[0]) : null;
    }


    /**
     * Load a user exam with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new UserExam_model(
        $row->user_exam_attempt_id,
   			$row->user_id,
   			$row->exam_id,
   			$row->score,
   			$row->correct,
   			$row->possible,
   			$row->status,
   			$row->started,
   			$row->finished
   		);
   	}


    /**
     * Return an instance of this model for the given user, topic id and exam_type
     **/
    public static function LoadByUserIdTopicIdExamType($user_id, $topic_id, $exam_type)
    {
      $result = &get_instance()->db->query("
        SELECT ea.* 
        FROM `UserExamAttempt` ea 
        JOIN `ExamTopics` et
        ON ea.exam_id = et.exam_id
        AND ea.user_id = ?
        AND et.topic_id = ?
        JOIN `Exams` e 
        ON e.exam_id = ea.exam_id 
        AND e.exam_type = ?
        ORDER BY e.exam_id DESC
        LIMIT 1", array($user_id, $topic_id, $exam_type));
      $result = $result->result();
      return count($result) != 0 ? UserExam_model::LoadWithData($result[0]) : null;
    }
    
    /**
   	* save questions for this exam and user.
   	**/
   	public function saveUserExamQuestions($questions)
   	{
   		foreach ($questions as $m => $question){
   			$this->db->insert("UserExamAttemptQuestionState", array("user_exam_attempt_id" => $this->user_exam_attempt_id, "question_id" => $question->question_id));
   		}
   	}
   	
   	/**
   	* get user chosen answers for this exam .
   	**/
   	public function getUserExamQuestions()
   	{
   		$result = $this->db->get_where("UserExamAttemptQuestionState", array("user_exam_attempt_id" => $this->user_exam_attempt_id));
    	$result = $result->result();
    	return $result;
   	}
   	
   	/**
   	* get exam.
   	**/
   	public function getExam()
   	{
   		return Exams_model::LoadById($this->exam_id);
   	}
   	
   	
   	public  function updateUserExamQuestionChoice($user_exam_attempt_id, $question_id, $choice){
   		$update_data = array(
   						"chosen_answer_id" => $choice
   		);
   		$this->db->where("user_exam_attempt_id", $user_exam_attempt_id);
   		$this->db->where("question_id", $question_id);
   		$this->db->update("UserExamAttemptQuestionState", $update_data);
   	}
   	
   	
   	public function getExamQuestionsByTopic(){
   		$results = $this->db->query("select c.topic_id , c.name, SUM(CASE WHEN e.is_correct = 1 THEN 1
             ELSE 0 END) AS correct, SUM(CASE WHEN e.is_correct != 1 THEN 1 ELSE 0
            END) AS wrong , count(*) as total , (select content_id from TopicContent where topic_id = c.topic_id limit 1) as content_id   from UserExamAttemptQuestionState a, 
			QuestionTopics b, Topics c,  QuestionAnswers e where a.question_id = b.question_id and
			b.topic_id = c.topic_id and a.chosen_answer_id = e.question_answer_id and a.user_exam_attempt_id = ?  group by c.topic_id, c.name ",
        array($this->user_exam_attempt_id)
      );
   		return $results->result();
   	}
}
?>
