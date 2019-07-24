<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends CI_Controller 
{
	public function track($eventType, $entityType, $entityId) 
	{
		$this->user = Users_model::LoadById($this->session->userdata("akshara_user"));
		if($this->input->post()) {
			$this->load->model("trackingevents_model");
			TrackingEvents_model::track(
				$eventType,
				$entityType,
				$entityId,
				$this->input->post("other_data"),
				$this->input->post("page_url"),
				$this->user !== null ? $this->user->user_id : null
			);
		}
		else {
			die("Cannot access this page directly.");
		}

		exit();
	}
}