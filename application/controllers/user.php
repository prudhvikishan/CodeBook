<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{
	/**
	* User registration
	*/
	public function registration()
	{
		$this->load->model("Users_model");
		$this->load->model("Schools_model");
		$this->load->model("Classes_model");
		$this->load->model("SchoolSections_model");
		
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[25]|callback_check_name');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[25]|callback_check_name');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[25]|matches[repassword]');
		$this->form_validation->set_rules('repassword', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_user');
		$this->form_validation->set_rules('phone', 'Phone', 'required|numeric|min_length[9]|max_length[11]');
		$this->form_validation->set_rules('class','Class','required|callback_check_default_class');
		$this->form_validation->set_message('check_default_class', 'Please select your class.');
		$this->form_validation->set_message('check_user', 'This email address has already been registered. Please use a different one.');
		$this->form_validation->set_message('check_name', 'Name can only contain letters, spaces and "."');
		$this->form_validation->set_rules('schoolname', 'School Name', 'required|callback_check_name');
		$this->form_validation->set_rules('schoolcity', 'School City', 'required');
		$this->form_validation->set_rules('schoolstate', 'School State', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$schools = Schools_model::GetAllSchoolsWithAddress();
			$classes = Classes_model::GetAllClasses();
			$sections = SchoolSections_model::GetAllSchoolSections();
			$states = $this->getStates();
			
			$data['schools'] = $schools;
			$data['classes'] = $classes;
			$data['sections'] = $sections;
			$data['states'] = $states;
			$this->load->view('user/registration', $data);
		}
		else
		{
			
			$this->db->trans_start();
			$firstname = $this->input->post("firstname");
			$lastname = $this->input->post("lastname");
			$email = $this->input->post("email");
			$phone = $this->input->post("phone");
			$password = $this->input->post("password");
			$repassword = $this->input->post("repassword");
			$school_name = $this->input->post("school");
			$class_id = $this->input->post("class");
			$section_id = $this->input->post("section");
			if($section_id == 0){
				$section_id = 1;
			}
			
			$this->load->model("Address_model");
			$schoolname = $this->input->post("schoolname");
			$schoolcity = $this->input->post("schoolcity");
			$schoolstate = $this->input->post("schoolstate");
			$address = new Address_model(null, null, null, $schoolcity, $schoolstate, null);
			$address->save();
			$school = new Schools_model(null,$schoolname, $schoolname, $address->address_id, 0);
			$school->save();
			
			$user = new Users_model(null, $email, $firstname, $lastname, $password, null, null, $phone);
			$user->save();
			$user->saveSchoolSection($school->school_id,$section_id);
			$user->saveCourses($class_id);
			$user->saveRoles('S');
			$this->send_activation_email($user);
			$this->db->trans_complete();
			$data['message'] = "Your account has successfully been created. As an additional security measure, we have sent you an email to verify your account. Please open your email and click on the account validation link.";
			$data['title'] = "Account Creation";
			$data['status'] = "Success";
			$this->load->view('information/message',$data);
		}

	}
	
	/**
	* Send Activation emaol
	*/
	private function send_activation_email($user)
	{
	
			$this->load->model("Users_model");
			$this->load->helper('date');
	
			$token = $this->generate_token();
			$data['user_id'] = $user->user_id;
			$data['token'] = $token;
			$message = $this->load->view('email/reg_welcome',$data,TRUE);
 			$subject= 'codebook: Welcome to the future of education !';
			$user->saveUserAccountStatus(0,$token,date("Y-m-d H:i:s", now()));
			$this->sendemail($user->email, $message, $subject);
				
	}
	
	private function generate_token(){
			return $this->generateRandom(30) . md5($this->generateRandom(30) . 'AksH@ra');
	}
	
	public function accountActivate($user_id=null,$token=null){
		
		if($user_id == null || $token == null){
			return show_404($this->uri->uri_string());
		}
		$this->load->model("Users_model");
		$this->load->helper('date');
		$user = Users_model::LoadById($user_id);
		
		if($user == null){
			$data['message'] = "Oops ! Looks like there is a problem with your request.";
			$data['status'] = "Error";
		} else {
			if($user->isAccountVerified()){
				$data['message'] = "Account already verified.";
				$data['status'] = "Error";
			} else {
				$token1  = $user->getAccountVerificationToken();
				if($token1 == $token){
					$user->saveUserAccountStatus(1,$token,date("Y-m-d H:i:s", now()));
					$data['message'] = "Hurrah ! Your account has been successfully been validated. Please login to start learning different.";
					$data['status'] = "Success";
					$link = new stdClass();
					$link->url_part = "login";
					$link->label = "Login";
					$data['link'] = $link;
				} else {
					$data['status'] = "Error";
					$data['message'] = "Oops ! Looks like you reached a page which doesn't exist.";
				}
			}
		}
			$data['title'] = "Account Validation";
			$this->load->view('information/message',$data);
				
	}

	/**
	* User registration
	*/
	private function validatecode()
	{
		$this->load->model("Users_model");
	
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_validate_user|callback_check_user_accesslevel|xss_clean');
		$this->form_validation->set_message('validate_user', 'User with the given email address does not exist in the system.');
		$this->form_validation->set_message('check_user_accesslevel', 'Oops..The account associated with this email address has already been validated. Please try to login.');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('user/validatecode');
		}
		$this->form_validation->set_rules('accesscode', 'Access Code', 'required|xss_clean|callback_validate_code');
		$this->form_validation->set_message('validate_code', 'Oops..This code has expired or already been used. Please contact us if you need a new code.');
		
	
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('user/validatecode');
		}
		else
		{
			$this->load->model("AccessCodes_model");
			$this->load->model("Users_model");
			$this->load->helper('date');
				
			$email = $this->input->post("email");
			$accesscode = $this->input->post("accesscode");
			$code = AccessCodes_model::LoadByAccessCode($accesscode);
			$user = Users_model::LoadWithUsername($email);
			$code->user_id =$user->user_id;
			$code->used_on = date("Y-m-d H:i:s", now());
			$code->save();
			$user->expiration_date = $code->expiration_date;
			$user->save();
			
			$message = "<p>Welcome to codebook !</p>";
			$message .= "<p>we make education fun and engaging.</p>";
			$message .= "<p>codebook is a new online learning platform woven with game mechanics to make education a fun and engaging experience.</p>";
			
			$message .= "<p>You are now part of an <b>exclusive club</b>, which will get <b>free access</b> to codebook before we launch it to the rest of the world. You now have access to a vast collection of Mathematics video content, class note and exams. As you finish tasks on codebook, you will earn points which you can then redeem for cool prizes.</p>";
			
			$message .= "<p>Buckle up and get ready to learn different !</p>";
			
			$message .= "<p>Thank you, </p>";
			$message .= "<p>Team codebook.</p>";
			
			$message .= "<p>Please feel to send us an email if you have any questions.</p>";
			$message .= "<p>Copyright  2014 Codebook Technologies, All rights reserved.</p>";
			$subject= 'codebook: Welcome to the future of education !';
			$this->sendemail($email, $message, $subject);
			
			$user->saveInSession();
			
			$home = $user->user_home();
			if($home == null) die("Unknown user type.");
			else header("Location: " . $home);
			exit();
		}
	
	}

	function check_name($string) {
		return preg_match("/[^a-zA-Z \.]/", $string) == 0;
	}
	
	function check_default($post_string)
	{
		return $post_string == '0' ? FALSE : TRUE;
	}
	
	function check_default_class($post_string)
	{
		return $post_string == '0' ? FALSE : TRUE;
	}
	
	function validate_code($post_string)
	{
		$this->load->model("AccessCodes_model");
		$code = AccessCodes_model::LoadByAccessCode($post_string);
		if($code == null)
			return false;
		else
			return $code->validateCode();
	}
	
	function validate_user($post_string)
	{
		$this->load->model("Users_model");
		$user = Users_model::LoadWithUsername($post_string);
		if($user == null)
			return false;
		else
		return true;
	}
	
	function check_user_accesslevel($post_string)
	{
		$this->load->model("Users_model");
		$user = Users_model::LoadWithUsername($post_string);
		if($user != null &&  $user->expiration_date != null && new DateTime("now") > $user->expiration_date)
		return false;
		else
		return true;
	}
	
	function check_user($post_string)
	{
		$this->load->model("Users_model");
		$user = Users_model::LoadWithUsername($post_string);
		if($user == null)
		return true;
		else
		return false;
	}
	
	function check_user1($post_string)
	{
		$this->load->model("Users_model");
		$user = Users_model::LoadWithUsername($post_string);
		if($user == null)
		return false;
		else
		return true;
	}
	
	/**
	*
	* User forgot password
	*
	*/
	
	public function forgotpassword()
	{
		$this->message = "";
		if($this->input->post("submit")){
			$this->load->helper(array('form', 'url'));
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_user1');
			$this->form_validation->set_message('check_user1', 'Invalid email address or user does not exist.');
				
			if (!$this->form_validation->run() == FALSE)
			{
				$email = $this->input->post("email");
				$user = Users_model::LoadWithUsername($email);
				$random = $this->generateRandom(6);
				$user->password = $random;
				$user->save();
				$user->updatePasswordStatus(1);
				$msg = "<br>Recently you asked us to reset your password for your codebooklearning.com account. We have generated a temporary password, please use the below password and dont forget to change it.";
				$msg .= "<br><br>Your new password is ";
				$msg .= $random;
				$msg .= "<br><br>If you have any other questions about your account, please do not hesitate to contact us by e-mail at support@codebooklearning.com.";
				$msg .= "<br><br> -- codebook team.";

				$this->sendemail($email, $msg, 'Password Reset');
				$data['message'] = "Please check your email account for information to reset your password.";
				$data['title'] = "Password Reset";
				$data['status'] = "Success";
				$this->load->view('information/message',$data);
				}
			} else {
			$this->load->view("user/forgot_password");
			}
	}
	
	/**
	 * 
	 * Generates the random string
	 * 
	 */
	private function generateRandom($size){
		$seed = str_split('abcdefghjklmnpqrstuvwxyz'
                 .'ABCDEFGHJKMNPQRSTUVWXYZ'
                 .'1234567890:_-~'); 
		shuffle($seed); 
		$rand = '';
		foreach (array_rand($seed, $size) as $k) $rand .= $seed[$k];
		return $rand;
	}
		
	
	/**
	* User signup
	*/
	public function signup()
	{
		$this->load->model("UserSignup_model");
		$name = $this->input->post("name");
		$email = $this->input->post("email");
		$school = $this->input->post("school");
		$city = $this->input->post("city");
		$exam = $this->input->post("exam");
		
		$user = new UserSignup_model(null, $email,$name, $school, $city,  $exam);
		$user->save();

		$this->load->library('email');


		$config['mailtype'] = 'html';
		$this->email->initialize($config);

		$this->email->from('welcome@codebooklearning.com', 'codebook');
		$this->email->to($email);

		$this->email->subject('Welcome to codebook!');

		$message = "<body background='http://akshara.hanleyandkoch.com/public/images/email-bg.jpg'> ";
		
		$message .="<table background='http://akshara.hanleyandkoch.com/public/images/email-bg.jpg' id='wrapper'  >";

		$message .= "<img style='text-align: right;padding:10px' src='http://akshara.hanleyandkoch.com/public/images/codebook-logo.png' alt='logo' /><br/><br/><br/>";
		
		// Message container
		$message .= "<div style='background: #fff; padding: 20px;'>";

		// Message Header
		$message .= "<p>Hello,</p>";
		
		// Message Paragraph 1
		$message .= "<p>Welcome to codebook, a new online learning platform woven with game mechanics to make education a fun and engaging experience.</p>";

		// Message Paragraph 2
		$message .= "<p>You are now part of an exclusive club, which will get early access to codebook before we launch it to the rest of the world. We are in the final stretch of development and will launch in couple of months.</p>";

		$message .="<p>Buckle up and get ready to learn different !</p>";
		
		$message .= "Thank you, <br/> codebook Team";
		
		$message .= "<p>Please reach out to us at <a href='mailto:support@codebooklearning.com' target='_top'>support@codebooklearning.com</a>, if you have any questions.</p>";

		$message .= "</div>";
		
		$message .= "</table>";
		
		$message .= "</body>";

		$this->email->message($message);

		$this->email->send();
	}	

	
	public function sendemail($email, $message, $subject){
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		$this->email->from('support@codebooklearning.com', 'codebook');
		$this->email->to($email);
		$this->email->bcc('support@codebooklearning.com');
		
		$this->email->subject($subject);
		
		$this->email->message($message);
		
		if($this->email->send())
		{
			//print 'aadadasd';
		} else {
			//print $this->email->print_debugger();
		}
	}
	
	public function getStates(){
		$array = array('Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh','Assam',
		'Bihar','Chandigarh','Chhattisgarh','Dadra and Nagar Haveli','Daman and Diu','Delhi','Goa','Gujarat',
		'Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand','Karnataka','Kerala','Lakshadweep','Madhya Pradesh','Maharashtra',
		'Manipur','Meghalaya','Mizoram','Nagaland','Orissa','Pondicherry','Punjab','Rajasthan','Sikkim','Tamil Nadu',
		'Telangana','Tripura','Uttaranchal','Uttar Pradesh','West Bengal');
		$ret = array();
		foreach($array as $m => $state){
			$s1 = new stdClass();
			$s1->name=$state;
			$s1->value=$state;
			$ret[] = $s1;
		}
		return $ret;
	}
	
	
}