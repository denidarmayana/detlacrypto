<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Panel extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->model("Home_model",'app');

	}
	public function index()
	{
	    $this->app->cekSessionPanel();
	    $data = [
			'all_members'=>$this->db->get("members")->num_rows(),
			'day_members'=>$this->db->like('created_at',date("Y-m-d"))->get("members")->num_rows(),
			'deposit_xbot_today'=>$this->db->like('created_at',date("Y-m-d"))->get("members")->num_rows()
		];
		$this->load->view("home",$data);
	}
	public function masuk()
	{
		
		$this->load->view("masuk");
	}
	public function action()
	{
		$input = $this->input->post();
		if ($input['username'] == 'cuan' && $input['password'] == 'cuan') {
			$this->session->set_userdata([
				'login_panel'=>TRUE,
				'username'=>$input['username']
			]);
			echo json_encode([
				'code'=>200,
				'message'=>"Sukses Login"
			]);
		}else{
			echo json_encode([
				'code'=>203,
				'message'=>"Gagal Login"
			]);
		}
	}
	public function update_wallet()
	{
		$input = $this->input->post();
		$save = $this->db->update('wallet_wfiliator',[
			'xbot'=>$input['xbot'],
			'doge'=>$input['doge'],
			'trx'=>$input['trx'],
			'btt'=>$input['btt'],
		],['id'=>1]);
		if ($save) {
			$data = [
				'code'=>200,
				'message'=>"Wallet afiliator berhasil diperbaharui"
			];
		}else{
			$data = [
				'code'=>200,
				'message'=>"Wallet afiliator berhasil diperbaharui"
			];
		}
		echo json_encode($data);
	}
	
}