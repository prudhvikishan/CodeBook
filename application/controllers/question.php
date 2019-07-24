<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends MY_Controller 
{
	/**
	 * A page to show all of the questions for a given topic_id.
	 **/
	public function by_topic($topic_id)
	{
		$this->requireRole("T");

		$this->load->model("Topics_model");
		$this->load->model("Questions_model");
		
		// Load the objects for the view
		$this->topic = Topics_model::LoadById($topic_id);

		// Load the view
		$this->load->view("question/by_topic");
	}

	/**
	 * The page and action for creating a new question.
	 **/
	public function create($default_topic_id = null)
	{
		$this->requireRole("T");

		$this->load->model("Topics_model");
		$this->load->model("Questions_model");
		$this->default_topic_id = $default_topic_id;
		$this->default_topic = ($default_topic_id ? Topics_model::LoadById($default_topic_id) : null);

		// Load all topics for the tagging modal
		$this->topics = Topics_model::All();

		// Check for form submissions
		if($this->input->post("new_question"))
		{
			$this->load->model("Questions_model");
			$this->load->model("QuestionAnswers_model");

			// Gather all the fields 
			$is_practice 	= in_array("practice", $this->input->post("question_types", array()));
			$is_exam 		= in_array("exam", $this->input->post("question_types", array()));
			$difficulty 	= $this->input->post("question_difficulty");
			$question_text  = $this->input->post("new_question_text");
			$explanation	= $this->input->post("new_question_explanation");
			$correct_choice_indicies = $this->input->post("new_question_answer_correct");
			$choice_texts   = $this->input->post("new_question_choices");

			// upload the image
			// question_image
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$config["encrypt_name"] = true;

			$this->load->library('upload', $config);
			$image_path = null;

			if($this->input->post("question_image")) {
				$success = $this->upload->do_upload("question_image");
				if ( !$success )
				{
					$error = array('error' => $this->upload->display_errors());
					var_dump($error);
					die();
				}

				$data = $this->upload->data();
				$image_path = "uploads/" . $data["file_name"];
			}

			// Create the base exam
			$question = new Questions_model(null, $question_text, $explanation, $difficulty, $is_practice, $is_exam, null, "N", $this->user->user_id, $image_path);
			$question->save();

			// now loop over the choces and create them
			$x = 0;
			foreach($choice_texts as $answer)
			{
				$is_correct = in_array("".$x++, $correct_choice_indicies);
				$answer = new QuestionAnswers_model(null, $question->question_id, $answer, $is_correct);
				$answer->save();
			}

			// Loop over the topics and join them in
			foreach($this->input->post("topics") as $topic)
				$question->addQuestionTopicById($topic);

			$this->session->set_flashdata("flash", "Question Created Successfully!");
		}

		// Render the view
		$this->question = new Questions_model();
		$this->load->view("question/new");
	}

	/**
	 * Edit/Preview a question
	 **/
	public function edit($question_id)
	{
		$this->requireRole("T");

		// Load the models
		$this->load->model("Questions_model");
		$this->load->model("QuestionAnswers_model");
		$this->load->model("Topics_model");
		
		//check if user has admin role
		$isadmin = $this->user->hasRole("A");
		$this->isadmin = $isadmin;

		// Load all topics for the tagging modal
		$this->topics = Topics_model::All();

		// Load the question and its main topic
		$this->question = Questions_model::LoadById($question_id);
		$this->default_topic = null;

		// check if the form was submitted
		if($this->input->post("edit_question"))
		{
			$question_id = $this->input->post("edit_question_id");
			$question = Questions_model::LoadById($question_id);

			// update the base question fields
			$question->practice_question 	= in_array("practice", $this->input->post("question_types"));
			$question->exam_question 		= in_array("exam", $this->input->post("question_types"));
			$question->difficulty 			= $this->input->post("question_difficulty");
			$question->question_text  		= $this->input->post("new_question_text");
			$question->explanation			= $this->input->post("new_question_explanation");

			// see what to do with the image
			// try to upload the image
			// question_image
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$config["encrypt_name"] = true;

			$this->load->library('upload', $config);

			$success = $this->upload->do_upload("question_image");
			if ( !$success )
			{
				if($this->input->post("existing_image")) { 
					$question->image_path = $this->input->post("existing_image");
				} else {
					$question->image_path = null;
				}
			} else {
				$data = $this->upload->data();
				$image_path = "uploads/" . $data["file_name"];
				$question->image_path = $image_path;
			}

			$question->save();

			// nothing to do with topic id at this point.
			$default_topic_id 			= $this->input->post("default_topic_id");

			// Now update the answer choices
			$correct_choice_indicies 	= $this->input->post("new_question_answer_correct");
			if(!$correct_choice_indicies) $correct_choice_indicies = array();
			$choice_texts   			= $this->input->post("new_question_choices");
			$answer_choice_ids			= $this->input->post("edit_question_answer_ids");

			for($x = 0; $x < count($answer_choice_ids); $x++)
			{
				$answer = QuestionAnswers_model::LoadById($answer_choice_ids[$x]);
				$answer->answer_text = $choice_texts[$x];
				$answer->is_correct = in_array("".$x, $correct_choice_indicies);
				$answer->save();
			}

			// sync up the topics
			$topics_wanted = $this->input->post("topics");
			$topics_had = $question->getQuestionTopics();

			// ---------------------------------------------
			// TODO: Move this to the question model.
			$topics_to_add = array();
			$topics_to_remove = array();
			// if a topic is wanted but not had, add it to the add list
			foreach($topics_wanted as $topic_id_wanted)
			{
				$found = false;
				foreach($topics_had as $topic_had)
					if($topic_id_wanted == $topic_had->topic_id)
					{
						$found = true;
						break ;
					}
				if($found == false)
					$topics_to_add[] = $topic_id_wanted;
			}

			// if a topic is had but not wanted, remove it from the list
			foreach($topics_had as $topic_had)
			{
				$found = false;
				foreach($topics_wanted as $topic_id_wanted)
					if($topic_id_wanted == $topic_had->topic_id)
					{
						$found = true;
						break ;
					}
				if($found == false)
					$topics_to_remove[] = $topic_had->topic_id;
			}

			// add the topics we need to add, remove the ones we need to remove.
			$question->removeTopics($topics_to_remove);
			foreach($topics_to_add as $topic_id)
				$question->addQuestionTopicById($topic_id);

			// ---------------------------------------------

			$this->question = $question;
		}

		// check if the form was submitted
		if($this->input->post("delete_question"))
		{
			$question_id = $this->input->post("edit_question_id");
			$question = Questions_model::LoadById($question_id);
			$question->removeAllTopics();
			$question->removeAllChoices();
			$question->removeCourses();
			$question->deleteQuestion();
			
			redirect('/instructor');
			
		}

		
		$this->session->set_flashdata("flash", "Question Updated Successfully!");

		// Load the view
		$this->load->view("question/new");
	}
}