<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam extends MY_Controller 
{
	public function __construct(){ $this->required_role = "S"; parent::__construct(); }

	public $no_of_exam_questions = 15;
	
	public function getexam($topic_id = null, $exam_type = null, $exam_id = null){
		if($topic_id != null){
			$topic_id = decode($topic_id);
		}
		if($exam_type != null){
			$exam_type= decode($exam_type);
		}
		if($exam_id != null){
			$exam_id = decode($exam_id);
		}
		if($exam_type < 1 || $exam_type > 3) {
			die("There was an error, please try again later.");
		}
		
		$user = $this->user;
		
		$this->load->model("Topics_model");
		$this->load->model("Questions_model");
		$this->load->model("Exams_model");
		$this->load->model("UserExam_model");

		// First check if this is a premium exam
		$exam_premium = Exams_model::IsPremium($topic_id, $exam_type);
		$user_premium = $this->user->IsPremium();
		if($exam_premium && !$user_premium) {
			die("There was an error, please try again later.");
		}

		$previousAttempt = UserExam_model::LoadByUserIdTopicIdExamType($this->user->user_id, $topic_id, $exam_type);

		if($exam_type < 1 || $exam_type > 3) {
			die("There was an error, please try again later.");
		}
		
		//check if alread exam exists
		if($exam_id != null) {
			$userexam = UserExam_model::LoadByUserExamId($user->user_id, $exam_id);
			$user_exam_attempt_id = $userexam->user_exam_attempt_id;
			$exam = $userexam->getExam();
			if($userexam-> status == 'C'){
				return $this->results($user_exam_attempt_id, count($exam->getExamQuestions()), $exam_id, $topic_id);
			}
			$userChosenAnswers = $userexam->getUserExamQuestions();
		} else if($previousAttempt != null){
			$exam = $previousAttempt->getExam();
			$user_exam_attempt_id = $previousAttempt->user_exam_attempt_id;
			$userChosenAnswers = $previousAttempt->getUserExamQuestions();
			header("Location: " . $exam_type . "/" . $exam->exam_id);
			exit();
	    }else {
			$userexam = $this->generateExam($user->user_id, $topic_id, $exam_type);
			$user_exam_attempt_id = $userexam->user_exam_attempt_id;
			$exam = $userexam->getExam();
			$userChosenAnswers = $userexam->getUserExamQuestions();
		}
		
		$questions_list = $exam->getExamQuestions();
		$data['no_of_questions'] = count($questions_list);
		$data['questions'] = $questions_list;
		$data['userchosenanswers'] = $userChosenAnswers;
		$data['topic'] = Topics_model::LoadById($topic_id);
		$data['user_id'] = $user->user_id;
		$data['exam_id'] = $exam->exam_id;
		$data['exam'] = $exam;
		$data['user_exam_attempt_id'] = $user_exam_attempt_id;
		$this->load->view("exam/exam", $data);
	}

	public function generateExam($user_id, $topic_id, $exam_type)
	{
		$this->load->model("Topics_model");
		$this->load->model("Questions_model");
		$this->load->model("Exams_model");
		$this->load->model("UserExam_model");
		
		// Load the objects for the view
		$this->topic = Topics_model::LoadById($topic_id);

		//question counts by difficulty
		 $levels = $this->determineQtnLevels($exam_type);		
		 $hard_questions = round($this->no_of_exam_questions * $levels['hard'] /100);
		 $medium_questions = round($this->no_of_exam_questions * $levels['medium'] /100);
		 $easy_questions = $this->no_of_exam_questions - $hard_questions - $medium_questions;

		 // Load the view
		 $eqlist = $this->topic->getQuestionsByDifficulty(0, $easy_questions);
		 $mqlist = $this->topic->getQuestionsByDifficulty(1, $medium_questions);
		 $hqlist = $this->topic->getQuestionsByDifficulty(3, $hard_questions);
		 $qlist = array_merge($eqlist,$mqlist,$hqlist);
		 $exam = new Exams_model(null, 'Level Exam', 'Level Exam', 60, $exam_type );
		 $exam->save();
		 $exam->addExamTopicById($topic_id);
		 $exam->saveExamQuestions($qlist);
		 
		 $userexam = new UserExam_model(null, $user_id , $exam->exam_id, null, null, null, 'I',  time(), null);
		 $userexam->save();
		 $userexam->saveUserExamQuestions($qlist);
		 return $userexam;
	}
	
	private function determineQtnLevels($exam_type){
		
		switch($exam_type)
		{
			case 1:
				return array( "easy"  => 75, "medium" => 20,"hard" => 5);
			case 2:
				return array ( "easy"  => 45, "medium" => 30,"hard" => 25);
			case 3:
				return array ( "easy"  => 10, "medium" => 50,"hard" => 40);
			default:
				return array ( "easy"  => 75, "medium" => 20,"hard" => 5);
		}
	}
	
	public function saveUserExamQuestion(){
		$user_exam_attempt_id  = $this->input->post('user_exam_attempt_id');
		$question_id  = $this->input->post('question_id');
		$choice = $this->input->post('choice');
		$this->load->model("UserExam_model");
		UserExam_model::LoadById($user_exam_attempt_id)->updateUserExamQuestionChoice($user_exam_attempt_id, $question_id, $choice);
		
	}
	
	public function showResults($user_exam_attempt_id = null,$total_questions_count = null, $exam_id = null, $topic_id = null){
		//$user_exam_attempt_id  = $_POST['user_exam_attempt_id'];
		//$total_questions_count  = $_POST['total_questions_count'];
		//$exam_id = $_POST['exam_id'];
		//$topic_id = $_POST['topic_id'];
		if($user_exam_attempt_id != null) {
			$user_exam_attempt_id = decode($user_exam_attempt_id);
		}
		if($total_questions_count != null){
			$total_questions_count = decode($total_questions_count);
		}
		if($exam_id != null) {
			$exam_id = decode($exam_id);
		}
		if($topic_id != null){
			$topic_id = decode($topic_id);
		}
		$this->load->model("UserExam_model");
		$user_exam = UserExam_model::LoadById($user_exam_attempt_id);
		if($user_exam == null || $user_exam->status == "C") {
			die("This page is no longer available");
		}
		$this->results($user_exam_attempt_id, $total_questions_count, $exam_id, $topic_id);
		
	}
	
	/** 
	 * NOTE: The 3 args total_questions_Count, exam_id and topic_id should be deprecated and not used anymore since they can all be derived 
	 * from the user_exam_attempt_id.
	 **/
	private function results($user_exam_attempt_id, $total_questions_count, $exam_id, $topic_id){
		$this->load->model("Topics_model");
		$this->load->model("Questions_model");
		$this->load->model("Exams_model");
		$this->load->model("UserExam_model");
		$this->load->model("Badges_model");
		
		$user_exam = UserExam_model::LoadById($user_exam_attempt_id);
		$userChosenAnswers = $user_exam->getUserExamQuestions();
		$exam = $user_exam->getExam();
		$exam_id = $exam->exam_id;
		$topic_id = $exam->getTopicId();
		$questions = $exam->getExamQuestions();
		$total_questions_count = count($questions);
		$userAnswers_ar = array();
		$correctAnswers_ar = array();
		$wrongcount = 0;
		$points = 0;
		$old_level = $this->user->getLevel();
		foreach ($questions as $m => $question){
			$answers = $question->getAnswers();
			foreach ($answers as $i => $answer){
				if($answer->is_correct){
					$correctAnswers_ar[] =$answer->question_answer_id;
					$userChosenAnswer = $this->getUserChosenAnswer($userChosenAnswers, $question->question_id);
					$userAnswers_ar[] = $userChosenAnswer;
					if($userChosenAnswer != $answer->question_answer_id){
						$wrongcount++;
					} else {
						if($user_exam->status != 'C')
							$this->savePoints($question->question_id, 'Question',$user_exam->user_id, $question->getPoints(), null );
							$points = $points + $question->getPoints();
					}
				}
			}
		}
		if($wrongcount == 0){
			if($user_exam->status != 'C')
				$this->savePoints($exam_id, 'Exam Bonus',$user_exam->user_id, 500, null );
			$data['bonus'] = 500;
		} else {
			$data['bonus'] = 0;
		}
		
		if($user_exam->status != 'C')
			$data['first_time'] = true;
		else 
			$data['first_time'] = false;
				
		$user_exam->correct = $total_questions_count - $wrongcount;
		$user_exam->score = round((($total_questions_count - $wrongcount)/$total_questions_count)*100);
		$badges = Badges_model::getBadesBasedOnCriteria($user_exam->score, 'exam', $topic_id);
		if(count($badges) > 0){
			foreach ($badges as $p => $badge){
				if($user_exam->status != 'C')
					$this->user->awardBadge($badge, $exam_id, 'exam');
			}
		}
			
		$level_changed = false;
		$new_level = $this->user->getLevel();
		if($user_exam->status != 'C'){
			if($new_level > $old_level){
				$level_changed = true;
			}
		}
		$user_exam->status = 'C';
		$user_exam->save();
		
		$data['level_changed'] = $level_changed;
		$data['level'] = $new_level;
		$data['badges'] = $badges;
		$data['correct_count'] = $user_exam->correct;
		$data['total_question_count'] = $total_questions_count;
		$data['questions'] = $questions;
		$data['correct_answers'] = $correctAnswers_ar;
		$data['user_chosen_answers'] = $userAnswers_ar;
		$data['points'] = $points;
		$data['score'] = $user_exam->score;
		$data['exam'] = $exam;
		$data['topic'] = Topics_model::LoadById($topic_id);
		$data['course_id'] = $data['topic']->getParentInfo();
		$data['topicquestions'] = $user_exam->getExamQuestionsByTopic();
		$this->load->view("exam/results", $data);
		
	}
	
	private function getUserChosenAnswer($userChosenAnswers, $question_id){
		if($userChosenAnswers == null || $question_id == null) return null;
		foreach ($userChosenAnswers as $m => $userChosenAnswer){
			if($userChosenAnswer->question_id == $question_id){
				return $userChosenAnswer->chosen_answer_id;
			}
		}
	}
	
	private function savePoints($entity_id, $entity, $user_id, $points, $event_type){
		$this->load->model("UserPointAwards_model");
		$userpointsawards = new UserPointAwards_model(null, $user_id, $points, $event_type, $entity, $entity_id);
		$userpointsawards->save();
	}
}
