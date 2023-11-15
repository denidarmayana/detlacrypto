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
    public function getDeposit($coin)
    {
    	date_default_timezone_set("Asia/Jakarta");
    	$data = $this->db->select_sum("balance")->like('created_at',date("Y-m-d"))->get_where("deposit",['coin'=>$coin])->row();
    	if ($data) {
    		return abs($data->balance);
    	}else{
    		return 0;
    	}
    }
    public function getMinus($coin)
    {
    	date_default_timezone_set("Asia/Jakarta");
    	$data = $this->db->select_sum("profite")->like('created_at',date("Y-m-d"))->get_where("trading",['coin'=>$coin,'profite <'=>0])->row();
    	if ($data) {
    		return abs($data->profite);
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