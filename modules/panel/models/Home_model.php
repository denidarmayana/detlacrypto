<?php
/**
 * 
 */
class Home_model extends CI_Model
{
	public function cekSessionPanel()
	{
		if ($this->session->userdata("login_panel")) {
			return TRUE;
		}else{
			redirect("pintu");
		}
	}
	public function tgl(){
		date_default_timezone_set("Asia/Jakarta");
		$tanggal = date("Y-m-d");
        $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0]. " ".date("H:i:s");
    }
    public function getDepositToday($coin)
    {
    	date_default_timezone_set("Asia/Jakarta");
        $cek = $this->db->like('created_at',date("Y-m-d"))->get_where("deposit",['coin'=>$coin])->num_rows();
        if ($cek > 0) {
            $data = $this->db->select_sum("balance")->like('created_at',date("Y-m-d"))->get_where("deposit",['coin'=>$coin])->row();
            if ($data) {
                return $data->balance;
            }else{
                return 0;
            }
        }else{
            return number_format(0,8);
        }
    	
    }
    public function getDepositAll($coin)
    {
        date_default_timezone_set("Asia/Jakarta");
        $cek = $this->db->select_sum("balance")->get_where("deposit",['coin'=>$coin])->num_rows();
        if ($cek > 0) {
            $data = $this->db->select_sum("balance")->get_where("deposit",['coin'=>$coin])->row();
            if ($data) {
                return $data->balance;
            }else{
                return 0;
            }
        }else{
             return number_format(0,8);
        }
        
    }
    public function getTrading($username,$coin)
    {
    	date_default_timezone_set("Asia/Jakarta");
    	$data = $this->db->select_sum("profite")->get_where("trading",['coin'=>$coin,'members'=>$username])->row();
    	if ($data) {
    		return $data->profite;
    	}else{
    		return 0;
    	}
    }
    public function getWD($username,$coin)
    {
        date_default_timezone_set("Asia/Jakarta");
        $data = $this->db->select_sum("amount")->get_where("withdrawl",['coin'=>$coin,'members'=>$username])->row();
        if ($data) {
            return $data->amount;
        }else{
            return 0;
        }
    }
    public function setSado($username,$coin)
    {
        $balance = $this->db->select_sum("balance")->get_where("deposit",['username'=>$username,'coin'=>$coin])->row();
        $trade = $this->db->select_sum("profite")->get_where("trading",['members'=>$username,'coin'=>$coin])->row();
        $wd = $this->db->select_sum("amount")->get_where("withdrawl",['members'=>$username,'coin'=>$coin])->row();
        $balances = ($balance->balance+$trade->profite)-$wd->amount;
        if ($balances > 0) {
            return $balances;
        }else{
            return 0; 
        }
        
    }
    public function jumlah_members()
    {
    	date_default_timezone_set("Asia/Jakarta");
    	return $this->db->get("members")->num_rows();
    }
    public function jumlah_members_today()
    {
    	date_default_timezone_set("Asia/Jakarta");
    	return $this->db->like('created_at',date("Y-m-d"))->get("members")->num_rows();
    }
}