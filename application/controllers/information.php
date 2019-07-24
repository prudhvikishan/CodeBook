<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Information extends CI_Controller 
{

	public function contact()
	{
		if($this->input->post("Submit")){
			
			$this->load->helper(array('form', 'url'));
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_user');
			$this->form_validation->set_rules('message','Message','required');
			$this->form_validation->set_rules('subject','Subject','required');
				
			if ($this->form_validation->run() == FALSE)
			{
				
			} else {
			$message = $this->input->post("message");
			$subject = $this->input->post("subject");
			$email = $this->input->post("email");
			$message = "Message from ".$email."   ".$message;
			$this->sendemail($email, $message, "message from contact us - ".$subject);
			$this->session->set_flashdata("message", "We got your message, we will get back to you shortly.");
			redirect("information/contact", "refresh");
		}
		}
		$this->load->view('information/contact');	
	}

	public function pricing() {

		$this->load->view('information/pricing');

	}

	public function message() {

		/* this is the data needed for a message, although I'm not sure how exactly to get it there */
		$data['title'] = "Account Activation";
		$data['message'] = "A message letting a user know their account was activated goes here.";
		$data['status'] = "success";
		$data['link'] = new stdClass;
		$data['link']->label = 'Label';
		$data['link']->url_part = 'login';

		$this->load->view('information/message', $data);
	}

	public function values() {

		$this->load->view('information/values');

	}
	
	public function termsofuse() {
	
		$this->load->view('information/termsofuse');
	
	}

	public function privacypolicy() {
		$this->load->view('information/privacypolicy');

	}
	
	public function sendemail($email, $message, $subject){
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
	
		$this->email->from($email, 'codebook - contact us');
		$this->email->to("admin@codebooklearning.com");
	
		$this->email->subject($subject);
	
		$this->email->message($message);
	
		if($this->email->send())
		{
			//print 'aadadasd';
		} else {
			//print $this->email->print_debugger();
		}
	}
}