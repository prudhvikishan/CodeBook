<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller 
{
	public function registration() 
	{
		$this->requireRole("A");

		// Get all of the users in descending order as well as the access code they used if any and ignore the codebook school
		$this->results = $this->db->query(
			"SELECT *, u.created as user_created, u.user_id as user_id, u.status as user_status, addr.state as state, addr.city as city
			FROM `Users` u
			/*LEFT JOIN `AccessCodes` ac 
			ON u.user_id = ac.user_id*/
			LEFT JOIN `SchoolUsers` su 
			ON u.user_id = su.user_id
			LEFT JOIN `Schools` s
			ON s.school_id = su.school_id
			LEFT JOIN `Addresses` addr
			ON s.address_id = addr.address_id
			where su.school_id <> 7  
			ORDER BY u.user_id DESC"
			)->result();

		$this->load->view("admin/registration");	
	}

	public function users() 
	{
		$this->load->model("Courses_model");
		$this->requireRole("A");
		$this->courses = Courses_model::All();

		$this->load->view("admin/users");
	}

	public function user($user_id = null) {
		$this->load->model("Users_model");
		$this->requireRole("A");
		$this->viewUser = Users_model::LoadById($user_id);
		$this->examAttempts = $this->user->getExamAttempts($user_id);

		$this->load->view("admin/user");
	}


	// TODO: Finish this...
	public function user_data($user_id, $start_date = null, $end_date = null) {
		$this->requireRole("A");

		// If theres no start date, start at the first date
		if($startDate == null) {
			$startDate = 0;
		}

		// If theres no end date, make the end date today
		if($endDate == null) {
			$endDate = strtotime("tomorrow");
		}

		// If theres a course id set to "*" change it to null
		if($course_id == "-1") {
			$course_id = null;
		}

		$values = array( $user_id, date('Y-m-d', $startDate), date('Y-m-d', $endDate) );
	}

	public function leaderboard() 
	{
		$this->requireRole("A");

		// Get all of the users in descending order as well as the access code they used if any and ignore the codebook school
		$this->results = $this->db->query(
			"SELECT  u.user_id as user_id, u.firstname as firstname, u.lastname as lastname, s.name as schoolname, sum(p.point_value) as points, IFNULL(level, 0) as level  
			FROM `Users` u, `Schools` s, `SchoolUsers` su, `UserPointAwards` p, `View_UserLevel` levels
			where u.user_id = su.user_id and u.user_id=p.user_id and su.school_id=s.school_id  and su.school_id<>7 and u.user_id = levels.user_id
			group by u.user_id
			ORDER BY points DESC"
			)->result();

		$this->load->view("admin/leaderboard");	
	}


	public function schoolreport() 
	{
		$this->requireRole("A");

		// Get all of the users in descending order as well as the access code they used if any
		$this->results = $this->db->query(
			"SELECT s.name AS schoolname, ss.section as section, COUNT( * ) AS totalstudents, SUM( p.userpoints ) AS points
			FROM SchoolUsers su, Schools s, SchoolSections ss, (

				SELECT u.user_id, SUM( p.point_value ) AS userpoints
				FROM Users u
				LEFT JOIN UserPointAwards p ON u.user_id = p.user_id
				GROUP BY u.user_id
			)p
		WHERE su.school_id = s.school_id
		AND su.user_id = p.user_id and su.school_id<>7
		AND ss.school_section_id = su.school_section_id
		GROUP BY su.school_id, su.school_section_id
		order by points desc"
		)->result();

		$this->load->view("admin/schoolreport");	
	}

	public function schoolheatmap() 
	{
		$this->requireRole("A");
		$this->load->model("Schools_model");
		$this->load->model("SchoolSections_model");
		$this->schools = Schools_model::GetAllSchools();
		$this->sections = SchoolSections_model::GetAllSchoolSections();
		$this->courses = Courses_model::All();
		$this->load->view("admin/schoolheatmap");	
	}

	public function users_data($course_id = null, $startDate = null, $endDate = null) {
		$this->requireRole("A");

		// If theres no start date, start at the first date
		if($startDate == null) {
			$startDate = 0;
		}

		// If theres no end date, make the end date today
		if($endDate == null) {
			$endDate = strtotime("tomorrow");
		}

		// If theres a course id set to "*" change it to null
		if($course_id == "-1") {
			$course_id = null;
		}

		$values = $course_id == null ? array(
			date('Y-m-d', $startDate), 
			date('Y-m-d', $endDate)
			) : array(
			$course_id,
			date('Y-m-d', $startDate), 
			date('Y-m-d', $endDate)
			);

		// Get the content times
			$contentResults = $this->db->query(
				"SELECT u.user_id, u.firstname, u.lastname, u.email, tt.content_type,  SUM(tt.total_time) as sum_total_time
				FROM View_TotalContentTopicTimeByUserAndDayAndType tt
				JOIN Users u
				ON u.user_id = tt.user_id " . 
				( 
					$course_id == null ? "" : "JOIN `CourseTopics` ct ON ct.topic_id = tt.topic_id AND ct.course_id = ? "
					) . 
				"WHERE tt.`date` between ? and ? 
				GROUP BY u.user_id, tt.content_type",
				$values
				)->result();

		// Get the exam Times
			$examResults = $this->db->query(
				"SELECT u.user_id, u.firstname, u.lastname, u.email, SUM(tt.total_time) as sum_total_time
				FROM View_TotalQuestionTopicTimeByUserAndDay  tt 
				JOIN Users u
				ON u.user_id = tt.user_id " . 
				($course_id == null ? "" : "JOIN `CourseTopics` ct ON ct.topic_id = tt.topic_id AND ct.course_id = ? ") . 
				"AND `date` between ? and ? " . 
				"GROUP BY u.user_id", 
				$values
				)->result();

			$ret = array();
			foreach ($contentResults as $row) {
				if($row->user_id == null) {
					continue ;
				}
				if(!array_key_exists($row->user_id, $ret)) {
					$ret[$row->user_id] = array(
						"user_id" => $row->user_id,
						"email" => $row->email,
						"name" => $row->firstname . " " . $row->lastname,
						$row->content_type => $row->sum_total_time
						);
				} else {
					$ret[$row->user_id][$row->content_type] = $row->sum_total_time;
				}
			}

			foreach ($examResults as $row) {
				if($row->user_id == null) {
					continue ;
				}
				if(!array_key_exists($row->user_id, $ret)) {
					$ret[$row->user_id] = array(
						"user_id" => $row->user_id,
						"email" => $row->email,
						"name" => $row->firstname . " " . $row->lastname,
						"exams" => $row->sum_total_time
						);
				} else {
					$ret[$row->user_id]["exams"] = $row->sum_total_time;
				}
			}

			header("Content-type: text/json");
			echo json_encode($ret);
			exit();
		}
		
		public function questionreport()
		{
			$this->requireRole("A");
		
			// Get all of the users in descending order as well as the access code they used if any
			$this->results = $this->db->query(
					"select a.question_id, c.name, count(d.question_id) as no_of_times_appeared, 
					(select count(*) from  UserExamAttemptQuestionState e, QuestionAnswers f
					where e.question_id = a.question_id and 
					f.question_id = e.question_id and
					e.chosen_answer_id = f.question_answer_id and f.is_correct = 1) as no_of_times_answered_correct , 
					(select count(*) from  UserExamAttemptQuestionState e, QuestionAnswers f
					where e.question_id = a.question_id and 
					f.question_id = e.question_id and
					e.chosen_answer_id = f.question_answer_id and f.is_correct = 0) as no_of_times_answered_wrong
 					from Questions a, QuestionTopics b , Topics c ,
					 ExamQuestions d where
					a.question_id = b.question_id and b.topic_id = c.topic_id and
					d.question_id = a.question_id group by d.question_id order by no_of_times_answered_wrong desc"
			)->result();
		
			$this->load->view("admin/questionreport");
		}
		
		public function awardpoints()
		{
			$this->requireRole("A");
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->model("Schools_model");
			$this->load->model("SchoolSections_model");
			$schools = Schools_model::GetAllSchools();
			$sections = SchoolSections_model::GetAllSchoolSections();
			$data['schools'] = $schools;
			$data['sections'] = $sections;
			
		    if($this->input->post("award_school")){
		    	$this->form_validation->set_rules('school','School','required|callback_check_default');
		    	$this->form_validation->set_message('check_default', 'Please select one.');
		    	$this->form_validation->set_rules('awardtype','awardtype','required|callback_check_default');
		    	
		    	if ($this->form_validation->run() == FALSE){
		    		$this->load->view("admin/awardpoints", $data);
		    	} else {
		    		$school_id = $this->input->post("school");
		    		$award_type = $this->input->post("awardtype");
		    		$awarddate = $this->input->post("awarddate");
		    		$section_id = $this->input->post("section");
		    		if($section_id == null){
		    			$section_id = 1;
		    		}
		    		$school = Schools_model:: LoadById($school_id);
		    		$users = $school->getUsersBasedOnSectio($section_id);
		    		$award = '';
		    		if($award_type == 'weeklywinner'){
		    			$award = 'Weekly Winner Bonus';
		    		} else if($award_type == 'captainaward') {
		    			$award = 'Captain Award Bonus';
		    		}
		    		foreach ($users as $i => $user){
		    			$this->savePoints($user->user_id, $award,$user->user_id, 150, 'B', $awarddate );
		    		}
		    		$this->session->set_flashdata("success_msg", " Points added successfully.");
		    		redirect('admin/awardpoints', 'refresh');
		    	}
		    } else if($this->input->post("award_user")){
		    	$this->form_validation->set_rules('user_ids', 'User', 'required');
		    	$this->form_validation->set_message('check_default', 'Please select one.');
		    	$this->form_validation->set_rules('awardtype1','awardtype1','required|callback_check_default');
		    	
		    	if ($this->form_validation->run() == FALSE){
		    		$this->load->view("admin/awardpoints", $data);
		    	} else {
		    	$user_ids   = $this->input->post("user_ids");
		    	$award_type1 = $this->input->post("awardtype1");
		    	$awarddate = $this->input->post("awarddate");
					$award = '';
		    		if($award_type1 == 'weeklywinner'){
		    			$award = 'Weekly Winner Bonus';
		    		} else if($award_type1 == 'captainaward') {
		    			$award = 'Captain Award Bonus';
		    		}
		    		foreach ($user_ids as $i => $user_id){
		    			$this->savePoints($user_id, $award,$user_id, 150, 'B', $awarddate);
		    		}
		    		$this->session->set_flashdata("success_msg", " Points added successfully.");
		    		redirect('admin/awardpoints', 'refresh');
		    	}		    
		    } else {
		    	$this->load->view("admin/awardpoints", $data);
		    }
		}
		
		function check_default($post_string)
		{
			return $post_string == '0' ? FALSE : TRUE;
		}
		
		private function savePoints($entity_id, $entity, $user_id, $points, $event_type, $awarddate){
			$this->load->model("UserPointAwards_model");
			$userpointsawards = new UserPointAwards_model(null, $user_id, $points, $event_type, $entity, $entity_id);
			$userpointsawards->save();
			if($awarddate != null){
				$date1 =date("Y-m-d",strtotime($awarddate));
				$userpointsawards->updateTime($date1);
			
			}
		}
		
		public function sendemail()
		{
			$this->requireRole("A");
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->model("Schools_model");
			$schools = Schools_model::GetAllSchools();
			$data['schools'] = $schools;
				
			if($this->input->post("send_school")){
				$this->form_validation->set_rules('school','School','required|callback_check_default');
				$this->form_validation->set_message('check_default', 'Please select one.');
				 
				if ($this->form_validation->run() == FALSE){
					$this->load->view("admin/sendemail", $data);
				} else {
					$school_id = $this->input->post("school");
					$emailContent = $this->input->post("email");
					$subject = $this->input->post("subject");
					$school = Schools_model:: LoadById($school_id);
					$users = $school->getUsers();
					
					foreach ($users as $i => $user){
					$this->send_email($user->email,$emailContent, 'message');
					}
					$this->session->set_flashdata("success_msg", " Email sent successfully.");
					redirect('admin/sendemail', 'refresh');
				}
			} else if($this->input->post("send_user")){
				$this->form_validation->set_rules('user_ids', 'User', 'required');
				$this->form_validation->set_message('check_default', 'Please select one.');
				 
				if ($this->form_validation->run() == FALSE){
					$this->load->view("admin/awardpoints", $data);
				} else {
					$user_ids   = $this->input->post("user_ids");
					$emailContent = $this->input->post("email1");
					$subject = $this->input->post("subject");
						
					foreach ($user_ids as $i => $user_id){
						$this->send_email($user_id,$emailContent, 'message');
						}
					$this->session->set_flashdata("success_msg", " Email sent successfully.");
					redirect('admin/sendemail', 'refresh');
				}
			} else {
				$this->load->view("admin/sendemail", $data);
			}
		}
		
		public function send_email($email, $message, $subject){
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
		
			$this->email->from('support@codebooklearning.com', 'codebook');
			$this->email->to($email);
		
			$this->email->subject($subject);
		
			$this->email->message($message);
		
			if($this->email->send())
			{
				//print 'aadadasd';
			} else {
				//print $this->email->print_debugger();
			}
		}
		
		public function commentreport()
		{
			$this->requireRole("A");
		
			// Get all of the users in descending order as well as the access code they used if any
			$this->results = $this->db->query(
							"SELECT a.content_id, e.name as school_name, b.name, c.firstname,c.lastname, a.comment, a.posted_on FROM ContentComment a, Content b, Users c, SchoolUsers d, Schools e where 
				a.posted_by = c.user_id and a.content_id = b.content_id  and c.user_id = d.user_id and d.school_id = e.school_id order by a.content_id desc"
			)->result();
		
			$this->load->view("admin/commentreport");
		}
		
		public function coinredemptionreport()
		{
			$this->requireRole("A");
		
			// Get all of the users in descending order as well as the access code they used if any
			$this->results = $this->db->query(
									"select b.user_id, b.firstname, b.lastname, a.transaction_date, c.name as reward_name, c.description, c.cost
									from GoldCoinTransactions a, Users b, Rewards c where
									a.user_id = b.user_id and a.explanation = 'Coin Redemption' and a.entity_id = c.reward_id order by a.transaction_id desc"
			)->result();
		
			$this->load->view("admin/coinredemptionreport");
		}
		
		public function questionperfreport()
		{
			$this->requireRole("A");
		
			$this->results = $this->db->query(
											"select ca.userid, ca.topic, ca.rightanswers, ia.wronganswers from 
						(select  u.user_id as userid, t.topic_id as topicid, t.name as topic, count(ueq.question_id) as rightanswers 
						from Users u, UserExamAttempt ue, 
						UserExamAttemptQuestionState ueq, Questions q, QuestionAnswers qa, QuestionTopics qt, Topics t  where 
						u.user_id = ue.user_id and ue.user_exam_attempt_id=ueq.user_exam_attempt_id and ueq.question_id=q.question_id and q.question_id=qa.question_id
						and ueq.chosen_answer_id=qa.question_answer_id and q.question_id=qt.question_id and qt.topic_id=t.topic_id and qa.is_correct=1 group by u.user_id, t.topic_id)  ca,
						(select u1.user_id as userid, t1.topic_id as topicid, t1.name as topic, count(ueq1.question_id) as wronganswers from Users u1, 
						UserExamAttempt ue1, UserExamAttemptQuestionState ueq1, Questions q1, QuestionAnswers qa1,
						 QuestionTopics qt1, Topics t1 where u1.user_id = ue1.user_id and ue1.user_exam_attempt_id=ueq1.user_exam_attempt_id and 
						ueq1.question_id=q1.question_id and q1.question_id=qa1.question_id and q1.question_id=qt1.question_id and 
						qt1.topic_id=t1.topic_id and ueq1.chosen_answer_id=qa1.question_answer_id and qa1.is_correct<>1 group by u1.user_id,t1.topic_id) ia
						where ca.userid=ia.userid and ca.topicid=ia.topicid group by ca.topic, ca.userid"
			)->result();
		
			$this->load->view("admin/questionperfreport");
		}
	}