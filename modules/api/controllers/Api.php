<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
/**
 * 
 */
class Api extends RestController  
{
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->model("api_model",'app');
	}
	public function index_get()
	{
		$data= ['application'=>"Crypto Both"];
		$this->response($data,401);
	}
	
	public function login_post()
	{
		$input = html_escape($this->post());
		
		$this->response($data,200);
	}
}