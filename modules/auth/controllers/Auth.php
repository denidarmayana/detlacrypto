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
	public function act_login()
	{
		$client = new WebSocket\Client("ws://deltacrypto.biz.id:6969");
		$data = [
			'method'=>"auth",
			'email'=>"deni020988@gmail.com",
			'password'=>"deni020988"
		];
		$client->text(json_encode($data));
		 
		while (true) {
		    try {
		        $message = $client->receive();
		        print_r($message);
		        echo "\n";
		 
		      } catch (\WebSocket\ConnectionException $e) {
		        // Possibly log errors
		        print_r("Error: ".$e->getMessage());
		    }
		}
		$client->close();
	}
	
}