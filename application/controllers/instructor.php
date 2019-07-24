<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instructor extends MY_Controller 
{
	public function __construct(){ $this->required_role = "T"; parent::__construct(); }

	public function index($course_id=null)
	{
		// Get all of the courses to show the question bank.
		$this->load->model("Courses_model");
		$this->load->model("Users_model");
		
		if($course_id != null){
			$ret[] = Courses_model::LoadById($course_id);
			$this->courses = $ret;
		} else {
			$this->courses = $this->user->getCourses();
		}
		$this->allcourses = $this->user->getCourses();
		
		$this->load->view("instructor/home");
	}

	public function announcements($action = null, $id = null)
	{	
		$this->load->model("Announcement_model");

		// Check if there was a form submission
		if($this->input->post("submit_announcement")) {
			// Check if its a create or an edit
			if($this->input->post("edit_announcement_id")) {
				// Edit
				$announcement = Announcement_model::LoadById($id);
				$announcement->title = $this->input->post("title");
				$announcement->content = $this->input->post("content");
				$announcement->save();
			} else {
				// Create
				$announcement = new Announcement_model(
					null, 
					$this->input->post("title"),
					$this->input->post("content"),
					$this->user->user_id
				);
				$announcement->save();

				// Send them to the edit page
				header("Location: " . base_url() . "instructor/announcements/edit/" . $announcement->announcement_id);
				exit();
			}
		}

		// Route based on the action
		if($action == null) {
			$this->announcements = Announcement_model::All();
			$this->load->view("announcements/all");
		} else if($action == "new") {
			$this->announcement = new Announcement_model();
			$this->load->view("announcements/form");
		} else if($action == "edit") {
			$this->announcement = Announcement_model::LoadById($id);
			$this->load->view("announcements/form");
		} else if($action == "delete") {
			$this->announcement = Announcement_model::LoadById($id);
			$this->announcement->delete();
			header("Location: " . base_url() . "instructor/announcements");
			exit();
		}
	}
}