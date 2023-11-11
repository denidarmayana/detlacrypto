<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \RestApis\Blockchain\Constants;
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
	public function index()
	{
		$request = new HttpRequest();
		$request->setUrl('https://rest.cryptoapis.io/wallet-as-a-service/wallets/654b45495b3d5f00067e2bcc/tron/neli/addresses?context=yourExampleString&limit=50&offset=0');
		$request->setMethod(HTTP_METH_GET);

		$request->setHeaders(array(
		    'Content-Type' => 'application/json',
		    'X-API-Key' => 'd15bc724e7215867aca8fe592224e2686062b887'
		));

		try {
		    $response = $request->send();

		    echo $response->getBody();
		} catch (HttpException $ex) {
		    echo $ex;
		}
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