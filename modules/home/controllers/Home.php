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
		$wd = $this->db->select_sum("amount")->get_where("withdrawl",['members'=>$this->session->userdata("username"),'coin'=>$coin])->row();
		$balances = ($balance->balance+$trade->profite)-$wd->amount;
		if ($balances > 0) {
			echo $balances;
		}else{
			echo 0;	
		}
		
	}
	public function withdrawl()
	{
		$input = $this->input->post();
		$save = $this->db->insert("withdrawl",[
			'members'=>$this->session->userdata("username"),
			'coin'=>$input["coin"],
			'address'=>$input["address"],
			'amount'=>$input["amount"],
		]);
		if ($save) {
			echo json_encode([
				'code'=>200,
				'message'=>"Withdrawl balance success"
			]);
		}else{
			echo json_encode([
				'code'=>203,
				'message'=>"Withdrawl balance failed"
			]);
		}
	}
	public function tradings()
	{
		$wining = mt_rand(1, 100);
		$input = $this->input->post();
		$bet_amt = $input['base'];
		$winning_chance = sprintf("%.2f",$input['chance']);
		$actual_payout = bcdiv(95, $winning_chance, 5);
		$profit = bcsub(bcmul($bet_amt, $actual_payout, 8), $bet_amt, 8);
		echo json_encode([
			'chance'=>$winning_chance,
			'payout'=>$actual_payout,
			'profite'=>$profit,
		]);
	}
	public function trading()
	{
		$wining = mt_rand(1, 100);
		$input = $this->input->post();
		$bet_amt = $input['base'];
		$winning_chance = sprintf("%.2f",$input['chance']);
		$actual_payout = bcdiv(95, $winning_chance, 5);
		$profits = bcsub(bcmul($bet_amt, $actual_payout, 8), $bet_amt, 8);
		$profit = floatval($profits) - floatval($input['base']);
		$profite_keuntungan = (floatval($profit) *40)/100;
		$profite_untuk_user = (floatval($profit) *60)/100;
		$net_profite = floatval($profit) - floatval($profite_keuntungan);
		$profile_reff = (floatval($profite_keuntungan) *5)/100;
		$profite_management = floatval($profite_keuntungan) - floatval($profile_reff);
		$profit_owner = (floatval($profite_management)*60)/100;
		$profit_team = (floatval($profite_management)*40)/100;
		$new_profite = floatval($input['base']) + floatval($profite_keuntungan);
		$trade = $this->db->like("created_at",date("Y-m-d"))->get_where("trading",['members'=>$this->session->userdata("username"),'coin'=>$input['coin']])->num_rows();


		if ($trade >= 1000 ) {
			$chance = $input['chance']/3;
		}else{
			$chance = $input['chance'];
		}
		if ($input['state'] == 1) {
			if ($wining <= $chance ) {
				$status = 1;
				$profit_val = floatval($new_profite);
				$users = $this->db->get_where("members",['username'=>$this->session->userdata("username")])->row();
				$this->db->insert("sharing",[
					'username'=>$this->session->userdata("username"),
					'profit'=>$profite_keuntungan,
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
		}else{
			$status = 0;
			$profit_val = (0 - floatval($input['base']));
		}
		// $status = 0;
		// $profit_val = (0 - floatval($input['base']));
		$this->db->insert("trading",[
			'members'=>$this->session->userdata("username"),
			'profite'=>floatval($profit_val),
			'coin'=>$input['coin'],
		]);
		echo json_encode([
			'status'=>$status,
			'profite'=>number_format($profit_val,8),
			'type'=>($input['type'] == 1 ? "HIGHT" : "LOW"),
			'base'=>$input['base'],
			'chance'=>$chance,
			'state'=>$input['state']
		]);
	}
	public function save_deposit()
	{
		$input = $this->input->post();
		$walet = $this->db->get_where("lumbung",['coin'=>$input["coin"]])->row();
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.pasino.io/withdraw/place-withdrawal',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		    "token":"'.$this->session->userdata("token").'",
		     "coin":"'.$input['coin'].'",
		     "method":"DIRECT",
		     "address":"'.$walet->address.'",
		     "amount":"'.$input['amount'].'"
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		echo $response;
		$rows = json_decode($response);
		if ($rows->success == true) {
			$this->db->insert('deposit',[
				'username'=>$this->session->userdata("username"),
				'balance'=>$input["amount"],
				'coin'=>$input["coin"],
				'token'=>$this->session->userdata("token"),
				'socket'=>$this->session->userdata("socket"),
				'transfered'=>1,
			]);
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