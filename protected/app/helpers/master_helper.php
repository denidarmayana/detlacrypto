<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists("CekSession")) {
	function CekSession()
	{
		$app =& get_instance();
		if ($app->session->userdata('login_user') == TRUE) {
			return TRUE;
		}else{
			redirect("auth");
		}
	}
}