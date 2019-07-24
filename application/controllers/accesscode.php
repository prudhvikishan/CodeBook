<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accesscode extends MY_Controller 
{
	/**
	 * A page to show all of the questions for a given topic_id.
	 **/
	public function generate()
	{
		$this->requireRole("A");
		$codes = array();
		$this->codes = $codes;
		if($this->input->post("generate"))
		{
			$this->load->model("Accesscodes_model");
			$count 	= $this->input->post("count");
			$exp_date  = $this->input->post("expDate");
			$time =date("Y-m-d",strtotime($exp_date));
			$int = (int)$count;
			for ($x=0; $x<$int; $x++){
				$code = $this->random(8);
				$c = Accesscodes_model::LoadByAccessCode($code);
				if($c == null){
					$codes[] = $code;
					$m = new AccessCodes_model(null, $code, null, $time, null);
					$m->save();
				}
			}
			$this->codes = $codes;
		}
		$this->load->view("codes/code");
	}
	
	private function random($length)
	{
		$charset='ABCDEFGHJKMNPQRSTUVWXYZ23456789';
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
	}

	
}