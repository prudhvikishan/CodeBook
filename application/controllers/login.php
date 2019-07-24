<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
	public function index()
	{
		$this->load->model("Users_model");

		if($this->input->post("username"))
		{
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$user = Users_model::LoadWithCredentials($username, $password);
			
			if($user != null && !$user->isAccountVerified() ) {
				$this->session->set_flashdata("login_error", "Your account is not verified.");
				redirect('login', 'refresh');
			} else if($user != null &&  $user->isAccountVerified())
// 			 else if($user != null &&  new DateTime("now") < $user->expiration_date ) {
// 				$this->session->set_flashdata("login_error", "Your account has expired, please try again.");
// 				redirect('login', 'refresh');
// 			} else if($user != null &&  new DateTime("now") > $user->expiration_date)
			{
				$user->saveInSession();
				
				$home = $user->user_home();
				if($home == null) die("Unknown user type.");
				else header("Location: " . $home);
				exit();
			}
			else
			{
				// Invalid login info.
				$this->session->set_flashdata("login_error", "Invalid username/password, please try again.");

				// Need to call a redirect/refresh so flashdata happens on first incorrect login - Scott
				redirect('login', 'refresh');

			}
		}

		$this->load->view('prelogin/login');	
	}

	public function logout()
	{
		// clear the user sessions
		$this->load->model("Users_model");
		Users_model::ClearSession();

		// forward them to the login page
		$this->session->set_flashdata("logout", "You were successfully logged out.");
		//header("Location: " . base_url() . "login");

		// This accomplishes the same thing as above as a codeigniter method, simpler. - Scott
		redirect('login', 'refresh');
		exit();
	}
}