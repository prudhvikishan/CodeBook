<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('send_email'))
{
	function send_email($from = 'admin@aksharas.com', $recipient, $subject = '', $message = '')
	{
		$config = Array(
		 'protocol' => 'smtp',
		 'smtp_host' => 'ssl://gator4106.hostgator.com',
		 'smtp_port' => 465,
		 'smtp_user' => 'admin@aksharas.com',
		 'smtp_pass' => 'Admin123$',
		);

		//load email library
		$CI =& get_instance();
		$CI->load->library('email', $config);
		$CI->email->set_newline("\r\n");

		//set email information and content
		$CI->email->from($from, 'Admin');
		$CI->email->to($recipient);

		$CI->email->subject($subject);
		$CI->email->message($message);

		if($CI->email->send())
		{
			//echo 'aadadasd';
		} else {
			show_error($CI->email->print_debugger());
		}
	}
}