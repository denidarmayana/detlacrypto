<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Auth extends MX_Controller  
{
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		
	}
	public function index()
	{
		$this->load->view("auth");
	}
	public function register()
	{
		$this->load->view("register");
	}
	
}