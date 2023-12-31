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
	public function action()
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.pasino.io/account/get-socket-token',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		    "token":"'.$this->input->post("token").'"
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$row = json_decode($response);
		if ($row->success == true) {
			$rows = $this->db->get_where("members",['email'=>$this->input->post("email")])->row();
			$this->session->set_userdata([
				'login'=>TRUE,
				'username'=>$rows->username,
				'email'=>$rows->email,
				'token'=>$this->input->post("token"),
				'socket'=>$row->socket_token,
			]);
			$data = [
				'code'=>200,
				'message'=>$row->message
			];
		}else{
			$data = [
				'code'=>203,
				'message'=>$row->message
			];
		}
		echo json_encode($data);
	}
	public function registration()
	{
		$input = $this->input->post();
		$cek_upline =  $this->db->get_where("members",['email'=>$input['upline']])->num_rows();
		if ($cek_upline == 0) {
			$upline = "delta";
		}else{
			$upline = $input['upline'];
		}
		$this->db->insert('members',[
			'email'=>$input['email'],
			'username'=>$input['username'],
			'password'=>$input['password'],
			'upline'=>$upline
		]);
	}
	public function referral()
	{
		$this->load->view("referral");
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect("/");
	}
	
}