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
	public function trading()
	{
		$wining = mt_rand(1, 100);
		$input = $this->input->post();
		$profit = floatval($input['profit']) - floatval($input['base']);
		$profite_upline = (floatval($profit) *10)/100;
		$net_profite = floatval($profit) - floatval($profite_upline);
		$profit_owner = (floatval($net_profite)*60)/100;
		$profit_team = (floatval($net_profite)*40)/100;
		if ($wining <= $input['chance']) {
			$status = 1;
			$profit_val = floatval($input['profit']);
		}else{
			$status = 0;
			$profit_val = (0 - floatval($input['base']));
		}
		echo json_encode([
			'status'=>$status,
			'profite'=>number_format($profit_val,8),
			'type'=>($input['type'] == 1 ? "HIGHT" : "LOW"),
			'base'=>$input['base'],
			'chance'=>$input['chance']
		]);
	}
}