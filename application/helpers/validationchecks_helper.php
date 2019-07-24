<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function check_name($string) {
		return preg_match("/[^a-zA-Z \.]/", $string) == 0;
	}
	
	function check_default($post_string)
	{
		return $post_string == '0' ? FALSE : TRUE;
	}
	
	
