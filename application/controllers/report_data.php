<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_data extends MY_Controller 
{

	public function school_heatmap_data($school_id = null, $section_id = null, $course_id = null) {
		header("Content-type: application/json");
		$args = array();
		if($school_id != 0) {
			$args[] = $school_id;
		} 
		if($section_id != 0) {
			$args[] = $section_id;
		}
		if($course_id != 0) {
			$args[] = $course_id;
		}

		$results = $this->db->query("
			SELECT 
				u.user_id, u.firstname, u.lastname, 
			    s.school_id, s.name as school_name, ss.section as school_section, ss.school_section_id,
			    e.exam_id, e.name as exam_name, e.exam_type, uea.score,
			    t.topic_id, t.name as topic_name
			FROM UserExamAttempt uea
			JOIN SchoolUsers su
			ON uea.user_id = su.user_id
			JOIN Exams e 
			ON uea.exam_id = e.exam_id
			JOIN ExamTopics et 
			ON e.exam_id = et.exam_id
			JOIN Topics t
			ON et.topic_id = t.topic_id
			JOIN CourseTopics ct
			ON ct.topic_id = t.topic_id
			AND ct.topic_id = et.topic_id
			JOIN Users u
			ON uea.user_id = u.user_id
			JOIN Schools s 
			ON su.school_id = s.school_id
			JOIN SchoolSections ss
			ON su.school_section_id = ss.school_section_id
			WHERE uea.score IS NOT NULL" . 
				($school_id != 0 ? " AND s.school_id = ?" : "") .
				($section_id != 0 ? " AND ss.school_section_id = ? " : "") . 
				($course_id != 0 ? " AND ct.course_id = ? " : "") . 
			" ORDER BY ct.course_id, t.topic_id, e.exam_type ASC" ,
			$args
		)->result();

		echo json_encode($results);
		exit();
	}

	public function focus_chart($timeFrame = null) {
		$this->load->model("Topics_model");
		// Compute the start and end date
		switch($timeFrame) {
			case "7days":
				$startDate = strtotime("-7 days");
				$endDate = strtotime("now");
				break ;
			case "thismonth":
				$startDate = strtotime(date("Y-m", mktime()) . "-01");
				$endDate = strtotime(date("Y-m-d", $startDate) . " +1 month -1 day");
				break ;
			case "thisyear":
				$startDate = strtotime("January 1st " . date('Y'));
				$endDate = strtotime("now");
				break ;
			case "lastmonth":
				$startDate = strtotime(date("Y-m", mktime()) . "-01 -1 month");
				$endDate = strtotime(date("Y-m-d", $startDate) . " +1 month -1 day");
				break ;
			case "lastyear":
				$startDate = strtotime("first day of january " . (date("Y") -1 ));
				$endDate = strtotime("last day of december" . (date("Y") - 1 ));
				break ;
			default:
				header('HTTP/1.1 400 Bad Request', true, 400);
				die("Unrecognized focus chart time frame.");
		}

		$endDate = strtotime(date("Y-m-d", $endDate) . " + 1 day");

		// Now run the query for this time range
		$contentResults = $this->db->query("SELECT * FROM View_TotalContentTopicTimeByUserAndDayAndType WHERE `user_id` = ? AND `date` between ? and ? ", array($this->user->user_id, date('Y-m-d', $startDate), date('Y-m-d', $endDate)) )->result();
		$questionResults = $this->db->query("SELECT * FROM View_TotalQuestionTopicTimeByUserAndDay WHERE `user_id` = ? AND `date` between ? and ? ", array($this->user->user_id, date('Y-m-d', $startDate), date('Y-m-d', $endDate)) )->result();

		$topicTotals = array();

		foreach ($contentResults as $content) {
			$topic = Topics_model::LoadById($content->topic_id);
			$parentTopic = Courses_model::LoadById($topic->getParentInfo());
			if(!$parentTopic) {
				$parentTopic = $topic;
			} else if($parentTopic->isIntroCourse()) {
				continue ;
			}

			if(!array_key_exists($parentTopic->name, $topicTotals)) {
				$topicTotals[$parentTopic->name] = array();
			}

			if(!array_key_exists($topic->name, $topicTotals[$parentTopic->name])) {
				$topicTotals[$parentTopic->name][$topic->name] = 0;
			}
			$topicTotals[$parentTopic->name][$topic->name] += $content->total_time;
		}

		foreach ($questionResults as $quiz) {
			$topic = Topics_model::LoadById($quiz->topic_id);
			$parentTopic = Courses_model::LoadById($topic->getParentInfo());
			if(!$parentTopic) {
				$parentTopic = $topic;
			} else if($parentTopic->isIntroCourse()) {
				continue ;
			}

			if(!array_key_exists($parentTopic->name, $topicTotals)) {
				$topicTotals[$parentTopic->name] = array();
			}

			if(!array_key_exists($topic->name, $topicTotals[$parentTopic->name])) {
				$topicTotals[$parentTopic->name][$topic->name] = 0;
			}
			$topicTotals[$parentTopic->name][$topic->name] += $quiz->total_time;
		}

		header("Content-type: application/json");
		echo json_encode(array("startDate" => $startDate, "endDate" => $endDate, "results" => $topicTotals));
		exit();		
	}

	public function activity_chart($timeFrame = null) {
		// Compute the start and end date
		switch($timeFrame) {
			case "7days":
				$startDate = strtotime("-7 days");
				$endDate = strtotime("now");
				break ;
			case "thismonth":
				$startDate = strtotime(date("Y-m", mktime()) . "-01");
				$endDate = strtotime(date("Y-m-d", $startDate) . " +1 month -1 day");
				break ;
			case "thisyear":
				$startDate = strtotime("January 1st " . date('Y'));
				$endDate = strtotime("now");
				break ;
			case "lastmonth":
				$startDate = strtotime(date("Y-m", mktime()) . "-01 -1 month");
				$endDate = strtotime(date("Y-m-d", $startDate) . " +1 month -1 day");
				break ;
			case "lastyear":
				$startDate = strtotime("first day of january " . (date("Y") -1 ));
				$endDate = strtotime("last day of december" . (date("Y") - 1 ));
				break ;
			default:
				header('HTTP/1.1 400 Bad Request', true, 400);
				die("Unrecognized focus chart time frame.");
		}

		$endDate = strtotime(date("Y-m-d", $endDate) . " + 1 day");

		// Now run the query for this time range
		$contentResults = $this->db->query("SELECT * FROM View_TotalContentTopicTimeByUserAndDayAndType WHERE `user_id` = ? AND `date` between ? and ? ", array($this->user->user_id, date('Y-m-d', $startDate), date('Y-m-d', $endDate)) )->result();
		$questionResults = $this->db->query("SELECT * FROM View_TotalQuestionTopicTimeByUserAndDay WHERE `user_id` = ? AND `date` between ? and ? ", array($this->user->user_id, date('Y-m-d', $startDate), date('Y-m-d', $endDate)) )->result();

		// Now loop over the two and compute totals by topic id and type
		$results = array();

		foreach ($contentResults as $content) {
			$date = strtotime(date('Y-m-d', strtotime($content->date))) * 1000;
			if( !array_key_exists($date, $results) ) {
				$results[$date] = array();
			}
			if( !array_key_exists($content->content_type, $results[$date])) {
				$results[$date][$content->content_type] = 0;
			} 

			$results[$date][$content->content_type] += intval($content->total_time);
		}

		foreach ($questionResults as $question) {
			$date = strtotime(date('Y-m-d', strtotime($question->date))) * 1000;
			if( !array_key_exists($date, $results) ) {
				$results[$date] = array();
			}
			if( !array_key_exists("questions", $results[$date])) {
				$results[$date]["questions"] = 0;
			} 

			$results[$date]["questions"] += intval($question->total_time);
		}

		header("Content-type: application/json");
		echo json_encode(array("startDate" => $startDate * 1000, "endDate" => $endDate * 1000, "results" => $results));
		exit();
	}

	public function report_card($course_id = null) 
	{
		$this->load->model("Courses_model");
		$this->load->model("Topics_model");

		$this->requireRole("S");
		header("Content-type:application/json");
		
		// Go get the report card data for this user.
		$examResults = $this->db->query(
			"SELECT 
				uc.course_id, et.topic_id,
				uea.user_exam_attempt_id,
				uea.score, uea.correct, uea.possible, uea.status, 
				e.name as exam_name, e.exam_type
			FROM UserCourses uc
			JOIN CourseTopics ct 
			ON ct.course_id = uc.course_id
			AND uc.user_id = ?
			JOIN UserExamAttempt uea 
			ON uc.user_id = uea.user_id
			AND uea.score IS NOT NULL
			JOIN ExamTopics et 
			ON et.topic_id = ct.topic_id
			JOIN Exams e 
			ON uea.exam_id = e.exam_id
			AND et.exam_id = e.exam_id",
			array($this->user->user_id)
		)->result();

		// Also get averages for each topic id
		$topicAverages = $this->db->query(
			"SELECT e.exam_type, et.topic_id, IFNULL(AVG(uea.score), 0) as average, IFNULL(MAX(uea.score), 0) as high_score
			FROM UserCourses us 
			JOIN CourseTopics ct 
			ON us.course_id = ct.course_id
			AND us.user_id = ?
			JOIN ExamTopics et
			ON ct.topic_id = et.topic_id
			JOIN Exams e
			ON e.exam_id = et.exam_id
			JOIN UserExamAttempt uea
			ON et.exam_id = uea.exam_id
			GROUP BY et.topic_id, e.exam_type", array($this->user->user_id))->result();

		// Go get all of the courses
		if($course_id == null) {
			$courses = Courses_model::CoursesForUser($this->user->user_id);
		} else {
			$courses = array( Courses_model::LoadById($course_id) );
		}

		// Go over each course and add its topics
		foreach ($courses as $course) {
			if($course->isIntroCourse()) {
				continue ; 
			}

			$course->topics = $course->getCourseTopics();
			$course->averages = array();

			// Also check if there are any exams taken by the user.
			$resultsForThisCourse = array();
			foreach ($examResults as $examResult) {
				if($examResult->course_id == $course->course_id) {
					$resultsForThisCourse[] = $examResult;
				}
			}

			// if there are any attempts for this course, figure out what topics they go to.
			foreach ($course->topics as $topic) {
				$topic->exam_attempts = array();
				$exam_types_encountered = array();
				foreach ($resultsForThisCourse as $examResult) {
					if($examResult->topic_id == $topic->topic_id) {
						$topic->exam_attempts[] = $examResult;
					}

					// check if theres an average for this topic and exam_type
					$exam_type = $examResult->exam_type;
					$found = false;
					foreach ($topicAverages as $topicAverage) {
						if($topicAverage->topic_id == $topic->topic_id && $topicAverage->exam_type == $exam_type) {
							$found = true;
							if(!in_array($exam_type, $exam_types_encountered)) {
								$topicAverage->average = intval($topicAverage->average);
								$topicAverage->high_score = intval($topicAverage->high_score);
								$topicAverage->topic_name = $topic->name;
								$course->averages[] = $topicAverage;
								$exam_types_encountered[] = $exam_type;
							}
						}
					}

					// If we didnt find a match, set the average to 0
					if($found == false) { 
						$course->averages[] = array(
							"topic_name" => $topic->name,
							"topic_id" => $topic->topic_id, 
							"exam_type" => $exam_type, 
							"average" => 0,
							"high_score" => 0
						);
					}
				}
			}
		}

		// print the results		
		if($course_id == null) {
			echo json_encode($courses);			
		} else {
			echo json_encode($courses[0]);
		}
		
		exit();
	}
	
	public function question_report($course_id = null)
	{
		$this->load->model("Courses_model");
		$this->load->model("Topics_model");
	
		$this->requireRole("S");
		header("Content-type:application/json");
	
	
		$topicQuestions = $this->db->query(
				"select c.topic_id , c.name as topic_name, SUM(CASE WHEN e.is_correct = 1 THEN 1
             ELSE 0 END) AS correct, SUM(CASE WHEN e.is_correct != 1 THEN 1 ELSE 0
            END) AS wrong , count(*) as total, g.name, h.parent_topic_id  
from UserExamAttemptQuestionState a, 
QuestionTopics b, Topics c,  QuestionAnswers e, 
UserExamAttempt f, Courses g, CourseTopics h where a.question_id = b.question_id and
b.topic_id = c.topic_id and a.chosen_answer_id = e.question_answer_id 
and a.user_exam_attempt_id = f.user_exam_attempt_id and g.course_id = h.course_id and c.topic_id = h.topic_id and f.user_id = ? 
and f.status = 'C' and g.course_id = ? group by c.topic_id, c.name order by h.sort_order asc", array($this->user->user_id, $course_id))->result();
	
		// Go get all of the courses
		if($course_id == null) {
			$courses = Courses_model::CoursesForUser($this->user->user_id);
		} else {
			$courses = array( Courses_model::LoadById($course_id) );
		}
	
		// Go over each course and add its topics
		foreach ($courses as $course) {
			if($course->isIntroCourse()) {
				continue ;
			}
	
			$course->topics = $course->getCourseTopics();
			$course->averages = array();
				
	
			foreach ($course->topics as $topic) {
						
						$temp = array();
						$wrong = 0;
						$correct = 0;
							foreach ($topicQuestions as $topicQuestion) {
								if($topicQuestion->parent_topic_id == $topic->topic_id ) {
								$temp[] = array(
								"topic_name" => $topicQuestion->topic_name,
								"topic_id" => $topicQuestion->topic_id, 
								"wrong_answers" => $topicQuestion->wrong, 
								"right_answers" => $topicQuestion->correct,
								"is_parent" => 0
							);
							$wrong = $wrong+$topicQuestion->wrong;
							$correct = $correct+$topicQuestion->correct;
							}
						}
						$course->averages[] = array(
							"topic_name" => $topic->name,
							"topic_id" => $topic->topic_id, 
							"wrong_answers" => $wrong, 
							"right_answers" => $correct,
							"is_parent" => 1
						);
						$course->averages = array_merge($course->averages, $temp);
				}
		}
	
		// print the results
		if($course_id == null) {
			echo json_encode($courses);
		} else {
			echo json_encode($courses[0]);
		}
	
		exit();
	}
}