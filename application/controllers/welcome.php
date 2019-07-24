<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller 
{
	public function index()
	{
		
		$this->load->view('prelogin/home');
	}

	public function external() {
		$this->load->view('prelogin/external');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */