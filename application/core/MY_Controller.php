<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("America/New_York");

class MY_Controller extends CI_Controller 
{
	protected $required_role = null;

	public function __construct()
	{
		parent::__construct();

		$this->load->model("Users_model");
		$this->load->model("Courses_model");
		$this->load->helper('Encrypt');
		
		// Check if theres a user in the session.
		$this->user = Users_model::LoadById($this->session->userdata("akshara_user"));
		if($this->user == null || ($this->required_role != null && !$this->user->hasRole($this->required_role)))
		{
			header("Location: " . base_url() . "login");
			exit();
		}

		// laod all courses for this user (used in the header include)
		$this->allcourses = Courses_model::CoursesForUser($this->user->user_id);
	}

	protected function requireRole($role)
	{
		if($this->user == null || !$this->user->hasRole($role))
		{
			header("Location: " . base_url() . "login");
			exit();
		}
	}

	public function _output($content)
    {
        // Load the base template with output content available as $content
        $data['content'] = &$content;
        $this->content = $content;

        // Show a layout based on the user type
        echo $this->load->view('layouts/main', $data, true);
    }
}
