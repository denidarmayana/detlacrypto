<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
/**
 * 
 */
class TokenJWT 
{
	var $key = "PTDarmaPersadaIndonesia";
	public function genrate($username)
	{
		$exp = time() + 3600;
		$payload = [
		    'iss' => 'http://example.org',
		    'aud' => $username,
		    'iat' => time(),
		    'nbf' => time() + 10,
		    "exp" => $exp,
		];
		$jwt = JWT::encode($payload, $this->key, 'HS256');
		return $jwt;
	}
	public function veryfied()
	{
		$authHeader = $this->input->request_headers('Authorization');  
        $arr = explode(" ", $authHeader); 
        $token = $arr[1];   
		$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
		if ($token){
            try{
                $decoded = JWT::decode($token, $this->configToken()['secretkey'], array('HS256'));          
                if ($decoded){
                    return TRUE;
                }
            } catch (\Exception $e) {
                $result = array('pesan'=>'Kode Signature Tidak Sesuai');
                return FALSE;
                
            }
        }
	}
}