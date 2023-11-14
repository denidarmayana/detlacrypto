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
		$this->apikey = "31c84acdf24da08c2e60fcf28ee08a64792d38692182533905dc62c04776f8d4";
	}
	public function index_get()
	{
		$data= ['application'=>"Crypto Both"];
		$this->response($data,401);
	}
	function curlUrl($url,$data)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>json_encode($data),
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json'
		  ),
		));
		$response = curl_exec($curl);
		return $response;
	}
	public function login_post()
	{
		$input = html_escape($this->post());
		$data = [
			'user'=>$input['email'],
			'password'=>$input['password'],
			'api_key'=>$this->apikey
		];
		$execute = $this->curlUrl("https://api.pasino.io/api/login",$data);
		$login = json_decode($execute);
		$data_socket = [
			'token'=>$login->token
		];
		$socket = $this->curlUrl("https://api.pasino.io/account/get-socket-token",$data_socket);
		$socket_row = json_decode($socket);
		if ($login->success == true) {
			$rows = $this->db->get_where("members",['email'=>$input["email"] ])->row();
			$this->session->set_userdata([
				'login'=>TRUE,
				'username'=>$rows->username,
				'email'=>$rows->email,
				'token'=>$login->token,
				'socket'=>$socket_row->socket_token,
			]);
		}
		$resposes = [
			'success'=>$login->success,
			'message'=>$login->message,
			'socket'=>$socket_row->socket_token
		];
		$this->response($resposes,200);
	}
	public function registration_post()
	{
		$input = html_escape($this->post());
		$data = [
			'user_name'=>$input['username'],
			'user_email'=>$input['email'],
			'password'=>$input['password'],
			'agreement'=>1,
			'referrer'=>"",
			'api_key'=>$this->apikey
		];
		$execute = $this->curlUrl("https://api.pasino.io/api/register",$data);
		$login = json_decode($execute);
		if ($login->success == true) {
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
		$this->response($execute,200);
	}
	public function address_post()
	{
		$input = html_escape($this->post());
		$data = [
			'token'=>$this->session->userdata("token"),
			'coin'=>$input['coin']
		];
		$execute = $this->curlUrl("https://api.pasino.io/deposit/get-deposit-information",$data);
		$wallet = json_decode($execute);
		$cek = $this->db->get_where("wallet",['members'=>$this->session->userdata("username"),'coin'=>$input['coin']])->num_rows();
		if ($cek == 0) {
			$this->db->insert('wallet',[
				'members'=>$this->session->userdata("username"),
				'coin'=>$input['coin'],
				'address'=>$wallet->address
			]);
		}else{
			$this->db->update('wallet',[
				'address'=>$wallet->address
			],['members'=>$this->session->userdata("username"),'coin'=>$input['coin']]);
		}
		$this->response($execute,200);
	}
	function getUrl($url)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
	public function balance_post()
	{
		$input = html_escape($this->post());
		$wallet = $this->db->get_where('wallet',['members'=>$this->session->userdata("username"),'coin'=>$input['coin']])->row();
		switch ($input['coin']) {
			case 'DOGE':
				$data = $this->getUrl("https://dogechain.info/api/v1/address/balance/".$wallet->address);
				$result = json_decode($data);
				$balance = $result->balance;
				$address = $wallet->address;
				break;
			case 'TRX':
				$data = $this->getUrl("https://apilist.tronscan.org/api/account?address=".$wallet->address);
				$result = json_decode($data);
				$balance = $data;
				$address = $wallet->address;
				break;
		}
		$response =[
			'success'=>true,
			'balance'=>$balance,
			'wallet'=>$address
		];
		$this->response($response,200);
	}
}