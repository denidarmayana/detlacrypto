<?php
/**
 * 
 */
class Customers extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->view("customers");
	}
	public function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	public function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}
	public function trx()
	{
		$data = $this->db->get_where("sales_transaction",['status'=>0])->row();
		if ($data) {
			$cst = $this->db->get_where("customer",['id'=>$data->customer_id])->row();
			if($cst){
				echo "<table width='100%'>";
				echo "<tr><td>".$data->id."</td><td class='text-end'>".$data->date."</td></tr>";
				echo "<tr><td><b>Pelanggan</b></td><td class='text-end'>".$cst->customer_name."</td></tr>";
				echo "</table>";
				echo "<div class='text-center mt-3'>===========================</div>";
				echo "<table width='100%'>";
				echo "<tr><td>Nama Barang</td><td class='text-end'>Nominal</td></tr>";
				echo "</table>";
				echo "<div class='text-center'>===========================</div>";
				echo "<table width='100%'>";
				$detail = $this->db->get_where("sales_data",['sales_id'=>$data->id])->result();
				$total=0;
				foreach ($detail as $key) {
					$p = $this->db->get_where("product",['id'=>$key->product_id])->row();
					$total+=$key->subtotal;
					echo "<tr><td>".$p->product_name."<br><small>@".$key->quantity." X Rp. ".number_format($key->price_item,0,',','.')."</small></td><td class='text-end' valign='top' width='30%'>Rp. ".number_format($key->subtotal,0,',','.')."</td></tr>";
				}
				echo "</table>";
				echo "<div class='text-center'>===========================</div>";
				echo "<table width='100%'>";
				echo "<tr><td class='text-end'>Total Belanja</td><td class='text-end' valign='top' width='30%'>Rp. ".number_format($total,0,',','.')."</td></tr>";
				echo "</table>";
				echo "<div class='text-center'>===========================</div>";
				echo "<div class='text-center'><i>".ucwords($this->terbilang($total))." Rupiah</i></div>";
				echo "<div class='text-center'>===========================</div>";
			}
		}
	}
}