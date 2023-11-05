<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct(){
        parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	function index(){
		redirect(site_url('home/dashboard'));
	}
	
	function dashboard(){
		
	}
	
	private function penjualan_daily($bulanan = false){
		
	}
}
