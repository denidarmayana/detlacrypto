<?php
/**
 * 
 */
class Home_model extends CI_Model
{
	public function cekSession()
	{
		if ($this->session->userdata("login")) {
			return TRUE;
		}else{
			redirect("auth");
		}
	}
}