<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends MY_Controller 
{
	public function __construct(){ $this->required_role = "T"; parent::__construct(); }

	public function addtopic($type, $parent_id, $course_id = null)
	{
		$this->load->model("Courses_model");
		$this->load->model("Topics_model");
		if($this->input->post("save")){
			$topic_name= $this->input->post("topic_name");
			$topic_desc= $this->input->post("topic_description");
			$topic = new Topics_model(null, $topic_name, $topic_desc);
			$topic->save();

			if($type == 'courseId'){
				$topic->addCourseTopicById($parent_id);
			}

			if($type == 'topicId'){
				$topic->addTopicTopicById($parent_id, $course_id);
			}

			$this->session->set_flashdata("flash", "Topic Created Successfully!");
			redirect('/instructor');

		} else {
			if($type == 'courseId'){
				$this->course = new Courses_model($parent_id, null, null);
			}
			if($type == 'topicId'){
				$this->topic = new Topics_model($parent_id, null, null);
			}
			$this->load->view("course/topic_new");
		}

	}
	
	public function addcourse()
	{
	
		$this->load->model("Courses_model");
		if($this->input->post("save")){
			$course_name= $this->input->post("course_name");
			$course_desc= $this->input->post("course_description");
			$course = new Courses_model(null, $course_name, $course_desc);
			$course->save();
	
			redirect('/instructor');
	
		} 
			$this->load->view("course/add_course");
	}
	
	public function edittopic($topic_id)
	{
		$this->load->model("Topics_model");
		
		if($this->input->post("delete")){
			$top_id=$this->input->post("topic_id");
			$topic = new Topics_model(intval($top_id), null, null);
			$topic->delete();
			redirect('/instructor');
	
		} else if($this->input->post("edit")) {
			$topic_name= $this->input->post("topic_name");
			$topic_desc= $this->input->post("topic_description");
			$top_id=$this->input->post("topic_id");
			$topic = new Topics_model(intval($top_id), $topic_name, $topic_desc);
			$topic->save();
			redirect('/instructor');
		} else {
		$this->topic = Topics_model::LoadById($topic_id);
		$this->load->view("course/edit_topic");
		}
	
	}
	
	public function editcourse($course_id)
	{
		$this->load->model("Courses_model");
	
		if($this->input->post("delete")){
			$cour_id=$this->input->post("course_id");
			$course = new Courses_model(intval($cour_id), null, null);
			$course->delete();
			redirect('/instructor');
	
		} else if($this->input->post("edit")) {
			$course_name= $this->input->post("course_name");
			$course_desc= $this->input->post("course_description");
			$cour_id=$this->input->post("course_id");
			$course = new Courses_model(intval($cour_id), $course_name, $course_desc);
			$course->save();
			redirect('/instructor');
		} else {
			$this->course = Courses_model::LoadById($course_id);
			$this->load->view("course/edit_course");
		}
	
	}
}