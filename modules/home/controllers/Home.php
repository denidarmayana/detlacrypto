<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Home extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->model("Home_model",'app');
		$this->app->cekSession();
	}
	public function index()
	{
		$this->load->view("home");
	}
	public function getbonus($coin)
	{
		$cek = $this->db->get_where("reabet",['receive'=>$this->session->userdata("username"),'status'=>0,'coin'=>$coin])->num_rows();
		if ($cek != 0) {
			$bonus_reff = $this->db->select_sum("amount")->get_where("reabet",['receive'=>$this->session->userdata("username"),'status'=>0,'coin'=>$coin])->row();
			if ($bonus_reff) {
				if ($bonus_reff->amount > 0) {
					echo $bonus_reff->amount;
				}else{
					echo 0;	
				}
				
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
		
		
	}
	public function setSado($coin)
	{
		$balance = $this->db->select_sum("balance")->get_where("deposit",['username'=>$this->session->userdata("username"),'coin'=>$coin])->row();
		$trade = $this->db->select_sum("profite")->get_where("trading",['members'=>$this->session->userdata("username"),'coin'=>$coin])->row();
		$balances = $balance->balance+$trade->profite;
		echo $balances;
	}
	public function trading()
	{
		$wining = mt_rand(1, 100);
		$input = $this->input->post();
		$profit = floatval($input['profit']) - floatval($input['base']);
		$profite_keuntungan = (floatval($profit) *40)/100;
		$profite_untuk_user = (floatval($profit) *60)/100;
		$net_profite = floatval($profit) - floatval($profite_keuntungan);
		$profile_reff = (floatval($profite_keuntungan) *5)/100;
		$profite_management = floatval($profite_keuntungan) - floatval($profile_reff);
		$profit_owner = (floatval($profite_management)*60)/100;
		$profit_team = (floatval($profite_management)*40)/100;
		$new_profite = floatval($input['base']) + floatval($profite_untuk_user);
		
		if ($wining <= $input['chance']) {
			$status = 1;
			$profit_val = floatval($new_profite);
			$users = $this->db->get_where("members",['username'=>$this->session->userdata("username")])->row();
			$this->db->insert("sharing",[
				'username'=>$this->session->userdata("username"),
				'profit'=>$profit,
				'upline'=>$profile_reff,
				'team'=>$profit_team,
				'owner'=>$profit_owner,
				'users'=>$profite_untuk_user,
				'coin'=>$input['coin'],
			]);
			$this->db->insert("reabet",[
				'from'=>$this->session->userdata("username"),
				'receive'=>$users->upline,
				'amount'=>$profile_reff,
				'coin'=>$input['coin'],
			]);
		}else{
			$status = 0;
			$profit_val = (0 - floatval($input['base']));
		}
		$this->db->insert("trading",[
			'members'=>$this->session->userdata("username"),
			'profite'=>$profit_val,
			'coin'=>$input['coin'],
		]);
		echo json_encode([
			'status'=>$status,
			'profite'=>number_format($profit_val,8),
			'type'=>($input['type'] == 1 ? "HIGHT" : "LOW"),
			'base'=>$input['base'],
			'chance'=>$input['chance']
		]);
	}
	public function save_deposit()
	{
		$input = $this->input->post();
		if ($input['balance'] > 0) {
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.pasino.io/transfer/send-transfer',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			    "token":"'.$input["token"].'",
			    "coin":"'.$input["token"].'",
			    "user_name":"denidarmayana",
			    "amount":"'.$input["balance"].'"
			}',
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json'
			  ),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			$rows = json_decode($response);
			if ($rows->success == true) {
				$this->db->insert("deposit",[
					'username'=>$input['username'],
					'balance'=>$input['balance'],
					'token'=>$input['token'],
					'transfered'=>1,
					'coin'=>$input["token"]
				]);
			}
			echo $response;
			
		}
		
	}
	public function claim()
	{
		$input = $this->input->post();
		$this->db->update("reabet",['status'=>1],['receive'=>$input['username']]);
		$this->db->insert("deposit",['username'=>$input['username'],'balance'=>$input['amount']]);
		echo json_encode([
			'code'=>200,
			'message'=>"Referral bonus claim successful"
		]);
	}
}