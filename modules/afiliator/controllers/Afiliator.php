<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Afiliator extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->model("Home_model",'app');

	}
	public function index()
	{
	    $this->app->cekSessionAfiliator();
		$this->load->view("home");
	}
	public function masuk()
	{
		$this->load->view("masuk");
	}
	public function action()
	{
		$input = $this->input->post();
		if ($input['username'] == 'afiliator' && $input['password'] == 'Sukses@2023') {
			$this->session->set_userdata([
				'login_affiliator'=>TRUE,
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
	
}