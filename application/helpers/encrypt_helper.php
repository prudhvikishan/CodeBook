<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function encode($string)
	{
		$CI =&get_instance();
		$CI->load->library("encrypt");
		$encrypted = $CI->encrypt->encode($string, 'CodeB00k123$');
		return $encrypted;
	}

	function decode($string)
	{
		$CI =&get_instance();
		$CI->load->library("encrypt");
		return $CI->encrypt->decode($string, 'CodeB00k123$');
	}