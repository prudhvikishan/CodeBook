<?php

class QuestionAnswers_model extends CI_Model {

	public $question_answer_id, $question_id, $answer_text, $is_correct;

	/**
	 * Create a new answer.
	 **/
	function __construct($question_answer_id = null, $question_id = null, $answer_text = null, $is_correct = null)
	{
		parent::__construct();
		$this->question_answer_id   = $question_answer_id;
		$this->question_id        	= $question_id;
		$this->answer_text    		= $answer_text;
		$this->is_correct      		= $is_correct;
	}

	/**
	 * Save the current answer.
	 **/
	public function save()
	{
		if($this->question_answer_id == null)
		{
			$this->db->insert("QuestionAnswers", array(
    		"question_id" => $this->question_id, 
    		"answer_text" => $this->answer_text,
    		"is_correct" => $this->is_correct 
			));
			$this->question_answer_id = $this->db->insert_id();
		}
		else
		{
			$update_data = array(
    		"question_id" => $this->question_id, 
    		"answer_text" => $this->answer_text,
    		"is_correct" => $this->is_correct
			);
			$this->db->where("question_answer_id", $this->question_answer_id);
			$this->db->update("QuestionAnswers", $update_data);
		}
	}

	/**
	 * Load a answer by id.
	 **/
	public static function LoadById($question_answer_id)
	{
		$result = &get_instance()->db->get_where("QuestionAnswers", array("question_answer_id" => $question_answer_id));
		$result = $result->result();
		return count($result) != 0 ? QuestionAnswers_model::LoadWithData($result[0]) : null;
	}


	/**
	 * Load a answer with an object.
	 **/
	public static function LoadWithData($row)
	{
		return new QuestionAnswers_model(
		$row->question_answer_id,
		$row->question_id,
		$row->answer_text,
		$row->is_correct
		);
	}

}
?>
