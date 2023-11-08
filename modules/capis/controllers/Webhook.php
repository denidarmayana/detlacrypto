<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Webhook extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		
	}
	public function callback()
	{
		
	}
	public function secret()
	{
		
	}
	public function veryfied($value='')
	{
		echo "cryptoapis-cb-a5e379c1b084f1050e6800c5c962b50bb4ba2d3ad033a18a74840bdcf2a44091";
	}
		
}