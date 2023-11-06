<?php
/**
 * 
 */
class Auth extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->view("auth");
	}
	public function action()
	{
		$post = $this->input->post();
		$user = $this->db->get_where("members",['email'=>$post['email']])->row();
		$this->session->set_userdata([
			'logged_in'=>TRUE,
			'email'=>$post['email'],
			'username'=>$user->username,
			'token'=>$post['token']
		]);
	}
}