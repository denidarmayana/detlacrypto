<?php
/**
 * 
 */
class Api_model extends CI_Model
{
	public function curl($url,$data)
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
		  CURLOPT_POSTFIELDS =>$data,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json'
		  ),
		));
		$response = curl_exec($curl);
		return $response;
	}
	public function login_pasino($email,$password)
	{
		$data = '{
			    "user":"'.$email.'",
			    "password":"'.$password.'",
			    "api_key":"31c84acdf24da08c2e60fcf28ee08a64792d38692182533905dc62c04776f8d4"
			}';
		return $this->curl("https://api.pasino.io/api/login",$data);
	}
	public function login($email,$password)
	{
		$sql = "SELECT username,email,password FROM members WHERE email = ?";
		$query = $this->db->query($sql, array($email));
		if ($query->num_rows() == 0) {
			$data = [
				'status'=>FALSE,
				'code'=>203,
				'message'=>"Email not registered",
				'data'=>null
			];
		}else{
			$row = $query->row();
			if (password_verify($password, $row->password)) {
				$this->session->set_userdata([
					'login_user'=>TRUE,
					'email'=>$email,
					'username'=>$row->username,
				]);
				$token = $this->tokenjwt->genrate($email);
				$data = [
					'status'=>TRUE,
					'code'=>200,
					'message'=>"You have been successfully logged in.",
					'data'=>$token,
				];
			}else{
				$data = [
					'status'=>FALSE,
					'code'=>203,
					'message'=>"The password you entered does not match",
					'data'=>null
				];
			}
		}
		return $data;
	}
}