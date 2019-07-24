<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends MY_Controller 
{
	public function __construct(){ $this->required_role = "S"; parent::__construct(); }

	public function index()
	{
		if(!$this->user->isIntroComplete()){
			$courses = Courses_model::CoursesForUser($this->user->user_id);
			foreach($courses as $course):
				if($course->isIntroCourse()) {
					$firstTopic = $course->getCourseTopics();
					$firstTopic = $firstTopic[0];
					$firstContent = $firstTopic->getFirstContent();
					header("Location: " . base_url() . "content/review/" . encode($firstContent->content_id));
					exit();
				}
			endforeach;
			
		} else {
			$this->load->model("Courses_model");
			$this->load->model("Leaderboard_model");
			$this->load->model("Announcement_model");
			$this->load->model("Content_model");
			$this->load->model("Topics_model");
			$this->load->model("Schools_model");
	
			$courses = Courses_model::CoursesForUser($this->user->user_id);
			$ret = array();
			foreach($courses as $course):
			if(!$course->isIntroCourse()) {
				$ret[] = $course;
			}
			endforeach;
			
			
			$this->courses = $ret;
	
			// Load the "all" leaderboard
		//	$this->leaderboard = Leaderboard_model::LeaderboardForUserId($this->user->user_id);
	
			// Load each of the individual course leaderboards
	//		foreach($this->courses as $course) {
	//			$course->leaderboard = Leaderboard_model::LeaderboardForUserIdAndCourseId($this->user->user_id, $course->course_id);
	//		}
	
			$this->resume_point = $this->Content_model->resumeContent();
	
			// Load the top 5 announcements to show.
			$this->announcements = Announcement_model::AnnouncementsForUser($this->user->user_id, 5);
	
			// Load the top 5 newfeed events to show
			$this->newsfeed = $this->user->getNewsfeed();
	
			// Load the 4 most recently awarded badges
			$this->recent_badges = $this->user->getRecentBadges();
	
			// The SCHOOL Leaderboard
	// 		$this->schoolLeaderboard = array(
	// 			"thisweek" => array(
	// 				"title" => "This Week",
	// 				"leaderboard" => Schools_model::Leaderboard("thisweek", $this->user->getSchoolId()),
	// 				"class" => "active"
	// 			),
	// 			"lastweek" => array(
	// 				 "title" => "Last Week",
	// 				  "leaderboard" => Schools_model::Leaderboard("7days", $this->user->getSchoolId()),
	// 				  "class" => ""
	// 			),
	// 			"all" => array(
	// 				"title" => "All Time",
	// 				"leaderboard" => Schools_model::Leaderboard("all", $this->user->getSchoolId()),
	// 				"class" => ""
	// 			)
	// 		);
			if($this->user->getTotalPoints() != 0){
				$this->leaderboard = $this->user->getLeaderboadrdData();
			} else {
				$this->leaderboard = null;
			}
			$this->load->view("student/home");
		}
	}


	/**
	 * Get unseen notifications
	 **/
	public function notifications() {
		$this->load->model("Users_model");
		die(json_encode($this->user->getUnseenAnnouncements()));
	}
	
	/**
	 * Dismiss some notifications
	 * Send a POST Request with an array of announcement ids to dismiss
	 **/
	public function dismiss_notifications() {
		$this->load->model("Users_model");
		$notifications = $this->input->post("notifications");
		if(!$notifications) {
			die("Error: No notifications to dismiss.");
		}

		foreach ($notifications as $id) {
			$this->user->markAnnouncementAsSeen($id);
		}

		die();
	}
	
	/**
	 * Get Point and level data
	 **/
	public function point_data() {
		$temp = $this->user->getNextLevelInfo();
		$total_points = $this->user->getTotalPoints();
		$percent_complete = number_format( ( $total_points / $temp["next_level_points"] ) * 100, 1 ); 
		$next_level_points = $temp["next_level_points"];
		$current_level = $this->user->getLevel();

		header("Content-type: text/json");
		echo json_encode(array(
			"percent_complete" => $percent_complete,
			"total_points" => $total_points,
			"next_level_points" => $next_level_points,
			"current_level" => $current_level
		));
		exit();
	}

	/**
	 * The laerning map.
	 **/
	public function learning_map($course_id)
	{
		// Get all of the courses to show the question bank.
		$this->load->model("Courses_model");
		$this->load->model("Content_model");
		$this->load->model("Topics_model");
		$this->load->model("UserExam_model");
		if($course_id != null){
			$course_id = decode($course_id);
		}
		$this->course = Courses_model::LoadById($course_id);
		$this->resume_point = $this->Content_model->resumeContent();

		if($this->course->isIntroCourse()) {
			$firstTopic = $this->course->getCourseTopics();
			$firstTopic = $firstTopic[0];
			$firstContent = $firstTopic->getFirstContent();
			header("Location: " . base_url() . "content/review/" . encode($firstContent->content_id));
			exit();
		}
		$this->load->view("student/learning_map");
	}

	/**
	 * The Report Card.
	 **/
	public function report_card() 
	{
		$this->load->model("Courses_model");

		$this->courses = Courses_model::CoursesForUser($this->user->user_id);
		$this->load->view("student/report_card");
	}

	/**
	 * The Activity Card.
	 **/
	public function activity() 
	{
		$this->load->model("Courses_model");

		$this->courses = Courses_model::CoursesForUser($this->user->user_id);
		$this->load->view("student/activity");
	}

	/**
	 * The Focus Card.
	 **/
	public function focus() 
	{
		$this->load->model("Courses_model");

		$this->courses = Courses_model::CoursesForUser($this->user->user_id);
		$this->load->view("student/focus");
	}

	/** 
	 * Links to the student course section:
	 *
	 * /student/course/<course_id>/<action>/<parameters>
	 * 
	 * These are the current links:
	 *	/student/course/<course_id>/content/<topic_id>
	 **/
	public function course($course_id, $action, $parameter)
	{
		$this->load->model("Courses_model");
		$this->course = Courses_model::LoadById($course_id);
		if(!$this->course)
			die("Course Not Found.");

		switch(strtolower($action))
		{
			// $parameter should be a topic id.
			case "content":
				$this->load->model("Content_model");
				$this->load->model("Topics_model");
				$this->topic = Topics_model::LoadById($parameter);
				$this->content = Content_model::ContentForTopicId($parameter);
				$this->load->view("student/course/content");
				break ;
			default:
				die("Unknown Action.");
		}
	}

	/**
	 * The user's profile.
	 **/
	public function badges() {
		
		// Load the 4 most recently awarded badges
		$this->badges = $this->user->getAllBadges();
		foreach($this->user->getCourses() as $course) {
			$courserank_ar[] = array( "course_name" => $course->name,
					"course_rank" => $this->user->getCourseRankById($course->course_id)
			);
		}
		$this->courses = $courserank_ar;
		$this->load->view("student/badges");
	}

	/**
	 * Edit the user's profile.
	 **/
	public function settings() {
		
		$this->load->model("Users_model");


		$this->load->library('form_validation');
		
		if($this->input->post("save_changes")){
		   $firstname = $this->input->post("firstname");
			$lastname = $this->input->post("lastname");
			$email = $this->input->post("email");
			$password = $this->input->post("password");

			$this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[25]|callback_check_name');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[25]|callback_check_name');
			$this->form_validation->set_message('check_name', 'Name can only contain letters, spaces and "."');

			if($password != null){
				$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[25]');
			}

			if ($this->form_validation->run() == TRUE)
			{

			if($firstname != null){
				$this->user->firstname = $firstname;
			}
			if($lastname != null){
				$this->user->lastname = $lastname;
			}
			if($email != null){
				$this->user->email = $email;
			}
			if($password != null){
				$this->user->password = $password;
			}
			if($_FILES && $_FILES["imageUpload"]['name']){
				if($_FILES["imageUpload"]["type"] == 'image/png' || $_FILES["imageUpload"]["type"] == 'image/jpg' || $_FILES["imageUpload"]["type"] == 'image/jpeg'){
					try
					{
						if($this->user->profile_pic)
							unlink($this->user->profile_pic);
					}
					catch(Exception $e)
					{
					}
					
					$path = $_FILES['imageUpload']['name'];
					$ext = pathinfo($path, PATHINFO_EXTENSION);
					$this->user->profile_pic = "uploads/". $this->user->user_id.".".$ext;
					
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = '*';
					$config['max_size']	= '100000';
					$config["file_name"] = $this->user->user_id;
					$this->load->library('upload', $config);
					
					$success = $this->upload->do_upload("imageUpload");
					if ( !$success )
					{
						$error = array('error' => $this->upload->display_errors());
						var_dump($error);
						die();
					}
					
					$data = $this->upload->data();
				}
			}

			$this->user->save();
			$this->session->set_flashdata("success_msg", "Settings successfully updated.");
			redirect("student/settings", "refresh");
		}
		}
		$this->load->view("student/edit_profile");
	}

	/**
	 * The help video/page.
	 **/
	public function help() {
		$this->load->view("student/help");
	}

	/**
	 * The rewards page.
	 **/
	public function rewards() {
		$this->load->model("Rewards_model");
		$this->allRewards = Rewards_model::All();
		$this->load->view("student/rewards");
	}

	public function redeem_rewards($reward_id) {
		$this->load->model("Users_model");

		if($this->user->redeemGoldCoinsForReward($reward_id)) {
			$this->session->set_flashdata('sucess', 'You have redeemed the item successfully.');
		} else {
			$this->session->set_flashdata('error', 'You do not have enough coins.');
		}
		
		redirect('student/rewards');
	}

	// /**
	//  * The leaderboards.
	//  **/
	// public function leaderboard()
	// {
	// 	$this->load->model("Courses_model");
	// 	$this->load->model("Leaderboard_model");
	// 	$this->courses = Courses_model::CoursesForUser($this->user->user_id);

	// 	// Load the "all" leaderboard
	// 	$this->AllTimeLeaderboard = Leaderboard_model::LeaderboardForUserId($this->user->user_id);

	// 	// Load the "monthly" leaderboard 
	// 	$this->MonthlyLeaderboard = Leaderboard_model::MonthlyLeaderboardForUserId($this->user->user_id);

	// 	// Load each of the individual course leaderboards
	// 	foreach($this->courses as $course) {
	// 		$course->AllTimeLeaderboard = Leaderboard_model::LeaderboardForUserIdAndCourseId($this->user->user_id, $course->course_id);
	// 		$course->MonthlyLeaderboard = Leaderboard_model::MonthlyLeaderboardForUserIdAndCourseId($this->user->user_id, $course->course_id);
	// 	}

	// 	$this->load->view("student/leaderboard");
	// }

	/**
	 * The SCHOOL Leaderboard
	 **/
	public function school_leaderboard() {
		$this->load->model("Schools_model");
		
		$this->schoolLeaderboard = array(
			"thisweek" => array(
				"title" => "This Week",
				"leaderboard" => Schools_model::Leaderboard("thisweek", $this->user->getSchoolId()),
				"class" => "active"
			),
			"lastweek" => array(
					"title" => "Last Week",
					"leaderboard" => Schools_model::Leaderboard("7days", $this->user->getSchoolId()),
					"class" => ""
			),
			"all" => array(
				"title" => "All Time",
				"leaderboard" => Schools_model::Leaderboard("all", $this->user->getSchoolId()),
				"class" => ""
			)
		);

		$this->load->view("student/school_leaderboard");
	}

	/**
	* The weekly status report.
	**/

	public function status_report() {

		$this->load->view("student/status_report");

	}

	function check_name($string) {
		return preg_match("/[^a-zA-Z \.]/", $string) == 0;
	}
	
		/**
	      *  Question Report.
         **/
	
	       public function question_report()
	
	       {
		               $this->load->model("Courses_model");
		               $this->courses = Courses_model::CoursesForUser($this->user->user_id);
		               $this->load->view("student/question_report");
		       }
}