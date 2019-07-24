<?php

class Questions_model extends CI_Model {

	public $question_id, $question_text, $explanation, $difficulty, $practice_question, $exam_question, $image_path,
	$sort_order, $question_type, $created_by;

	/**
	 * Create a new question.
	 **/
	function __construct($question_id = null, $question_text = null, $explanation = null, $difficulty = null,
	$practice_question = null, $exam_question = null, $sort_order = null, $question_type = null, $created_by = null, $image_path = null)
	{
		parent::__construct();
		$this->question_id      	= $question_id;
		$this->question_text        = $question_text;
		$this->explanation    		= $explanation;
		$this->difficulty      		= $difficulty;
		$this->practice_question    = $practice_question;
		$this->exam_question    	= $exam_question;
		$this->sort_order        	= $sort_order;
		$this->question_type    	= $question_type;
		$this->created_by			= $created_by;
		$this->image_path			= $image_path;
	}

	/**
	 * Save the current question.
	 **/
	public function save()
	{
		if($this->question_id == null)
		{
			$this->db->insert("Questions", array(
	    		"question_text" => $this->question_text, 
	    		"explanation" => $this->explanation,
	    		"difficulty" => $this->difficulty,  
	    		"practice_question" => $this->practice_question,    
	    		"exam_question" => $this->exam_question,    
	    		"sort_order" => $this->sort_order,      
	    		"question_type" => $this->question_type,
	    		"created_by" => $this->created_by,
	    		"image_path" => $this->image_path
			));
			$this->question_id = $this->db->insert_id();
		}
		else
		{
			$update_data = array(
	    		"question_text" => $this->question_text, 
	    		"explanation" => $this->explanation,
	    		"difficulty" => $this->difficulty,  
	    		"practice_question" => $this->practice_question,    
	    		"exam_question" => $this->exam_question,    
	    		"sort_order" => $this->sort_order,      
	    		"question_type" => $this->question_type,
	    		"created_by" => $this->created_by,
	    		"image_path" => $this->image_path
			);
			$this->db->where("question_id", $this->question_id);
			$this->db->update("Questions", $update_data);
		}
	}

	/**
	 * Load a question by id.
	 **/
	public static function LoadById($question_id)
	{
		$result = &get_instance()->db->get_where("Questions", array("question_id" => $question_id));
		$result = $result->result();
		return count($result) != 0 ? Questions_model::LoadWithData($result[0]) : null;
	}


	/**
	 * Load a question with an object.
	 **/
	public static function LoadWithData($row)
	{
		return new Questions_model(
		$row->question_id,
		$row->question_text,
		$row->explanation,
		$row->difficulty,
		$row->practice_question,
		$row->exam_question,
		$row->sort_order,
		$row->question_type,
		$row->created_by,
		$row->image_path
		);
	}
	
	/**
	* get answers for a question.
	**/
	public function getAnswers()
	{
		$this->load->model("QuestionAnswers_model");
		if($this->question_id == null)
		{
			return array(
				new QuestionAnswers_model(),
				new QuestionAnswers_model(),
				new QuestionAnswers_model(),
				new QuestionAnswers_model()
			);
		} 
		$question_id = $this->question_id;
		 
		$this->db->select('*');
		$this->db->from ('QuestionAnswers');
		$this->db->where('QuestionAnswers.question_id',$question_id);
		$query  = $this->db->get();
		$answers_ar=array();
	
		if ($query->num_rows() > 0)
		{
			$this->load->model("QuestionAnswers_model");
			foreach ($query->result() as $row)
			{
				$answers_ar[]=QuestionAnswers_model::LoadWithData($row);
			}
		}
		return $answers_ar;
	}

	/** 
	 * Get all topics for this question
	 **/
	public function getQuestionTopics()
	{
		$this->load->model("Topics_model");
		$result = $this->db->select("Topics.*")
				 ->from("Topics")
				 ->join("QuestionTopics", "QuestionTopics.topic_id = Topics.topic_id")
				 ->where('QuestionTopics.question_id', $this->question_id)
				 ->get()->result();

		$ret = array();
		foreach($result as $r)
			$ret[] = Topics_model::LoadWithData($r);
		return $ret;
	}

	/**
	 * Add a topic (by topic_id) for this question, if it already has this topic, nothing will happen.
	 **/
	public function addQuestionTopicById($topic_id)
	{
		return $this->db->insert("QuestionTopics", array("question_id" => $this->question_id, "topic_id" => $topic_id));
	}

	/**
	 * Returns the difficulty as in its string representation.
	 **/
	public function getDifficultyString()
	{
		switch($this->difficulty)
		{
			case 0:
				return "Easy";
			case 1:
				return "Medium";
			case 2:
				return "Hard";
			default:
				return $this->difficulty;
		}
	}
	
	
	/**
	 * Returns the difficulty as in its color representation.
	 **/
	public function getDifficultyColor()
	{
		switch($this->difficulty)
		{
			case 0:
				return "green";
			case 1:
				return "yellow";
			case 2:
				return "Red";
			default:
				return "green";
		}
	}
	
	/**
	 * Remove all topics given in the array of topic ids.
	 **/
	public function removeTopics($topics)
	{
		$sql = "DELETE FROM QuestionTopics WHERE question_id = ? AND topic_id = ?";
		foreach($topics as $topic_id)
			$this->db->query($sql, array($this->question_id, $topic_id));
	}
	
	
	/**
	 * Remove all topics 
	 **/
	public function removeAllTopics()
	{
		$sql = "DELETE FROM QuestionTopics WHERE question_id = ? ";
			$this->db->query($sql, array($this->question_id));
	}
	
	/**
	 * Remove all answers 
	 **/
	public function removeAllChoices()
	{
		$sql = "DELETE FROM QuestionAnswers WHERE question_id = ? ";
			$this->db->query($sql, array($this->question_id));
	}
	
	/**
	 * Remove all courses 
	 **/
	public function removeCourses()
	{
		$sql = "DELETE FROM QuestionCourseRelevance WHERE question_id = ? ";
			$this->db->query($sql, array($this->question_id));
	}
	
	
	/**
	 * Remove all courses 
	 **/
	public function deleteQuestion()
	{
		$sql = "DELETE FROM Questions WHERE question_id = ? ";
			$this->db->query($sql, array($this->question_id));
	}
	
   /**
	* get points for question based on difficulty level
	**/
	
	public function getPoints()
	{
		switch($this->difficulty)
		{
			case 0:
				return 50;
			case 1:
				return 50;
			case 3:
				return 50;
			default:
				return 50;
		}
	}
}
?>
