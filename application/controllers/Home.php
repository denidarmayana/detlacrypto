<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct(){
        parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth'));
		}
	}
	
	function index(){
		$this->load->view("home");
	}
	public function save_token()
	{
		$this->db->insert("token",[
			'username'=>$this->session->userdata("username"),
			'token'=>$this->session->userdata("username"),
			'socket'=>$this->input->post("socket"),
		]);
	}
}
