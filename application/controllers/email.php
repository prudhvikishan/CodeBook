<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends MY_Controller 
{
	public function templates($email_name) 
	{
		$this->requireRole("A");

//call_user_func($email_name);		
		$this->$email_name();	
	}

	
		public function reg_welcome(){
			$data['user_id'] = 12;
			$data['token'] = "adaserefdssdfsdf";
			$this->load->view('email/reg_welcome',$data);
		}
	
	}