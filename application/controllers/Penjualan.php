<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');
		$this->load->model('penjualan_model');
		$this->load->model('pelanggan_model');
		$this->load->model('kategori_model');
		$this->load->model('produk_model');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	function index(){
		if(isset($_GET['search'])){
			$filter = '';
			if(!empty($_GET['id']) && $_GET['id'] != ''){
				$filter['sales_transaction.id LIKE'] = "%".$_GET['id']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(sales_transaction.date) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(sales_transaction.date) <='] = $_GET['date_end'];
			}

			$total_row = $this->penjualan_model->count_total_filter($filter);
			$data['penjualans'] = $this->penjualan_model->get_filter($filter,url_param());
		}else{
			$total_row = $this->penjualan_model->count_total();
			$data['penjualans'] = $this->penjualan_model->get_all(url_param());
		}
		$data['paggination'] = get_paggination($total_row,get_search());
		$this->load->view('penjualan/index',$data);
	}
	
	function create(){
		// destry cart
		$this->cart->destroy();

		
		$data['customers'] = $this->pelanggan_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();
		//$this->load->view('penjualan/form',$data);
		$cek = $this->db->get_where("sales_transaction",['status'=>0])->num_rows();
		if ($cek == 0) {
			$this->db->insert(" sales_transaction",['id'=>"OUT".strtotime(date("Y-m-d H:i:s")),'is_cash'=>1]);
		}
		$jual = $this->db->get_where("sales_transaction",['status'=>0])->row();
		$data['code_penjualan'] = $jual->id;
		$this->load->view('penjualan/kasir',$data);
	}
	
	public function detail($id){
		$details = $this->penjualan_model->get_detail($id);
		if($details){
			$data['details'] = $details;
			$this->load->view('penjualan/detail',$data);
		}else{
			redirect(site_url('penjualan'));
		}
	}
	public function edit($id){
		// destry cart
		$this->cart->destroy();
		$data['suppliers'] = $this->supplier_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();

		$transaksi = $this->penjualan_model->get_detail($id);
		if($transaksi){
			//print_r($transaksi); exit;
			$data['carts'] = $this->_process_cart($transaksi);
			$data['pembelian'] = $transaksi;
			$this->load->view('penjualan/form',$data);
		}else{
			redirect(site_url('penjualan'));
		}
	}

	private function _process_cart($transaksi = ''){
		if($transaksi & is_array($transaksi)){
			foreach($transaksi as $key => $item){
				$data = array(
					'id'      => $item->product_id,
					'qty'     => $item->quantity,
					'price'   => $item->price_item,
					'category_id' => $item->category_id,
					'category_name' => $item->category_name,
					'name'    => $item->product_name
				);
				$this->cart->insert($data);
			}
		}
		$response = array(
				'data' => $this->cart->contents() ,
				'total_item' => $this->cart->total_items(),
				'total_price' => $this->cart->total()
			);
		return $response;
	}

	public function check_id(){
		$id = $this->input->post('id');
		$check_id = $this->penjualan_model->get_by_id($id);
		if(!$check_id){
			echo "available";
		}else{
			echo "unavailable";
		}
	}
	
	public function check_category_id($category_id){
		$products = $this->produk_model->get_by_category($category_id);
		echo json_encode($products);
	}
	public function check_product_id($product_id){
		$products = $this->produk_model->get_by_id($product_id);
		echo json_encode($products);
	}
	public function get_pelanggan()
	{
	  $cart =  $this->db->get_where('sales_transaction',['id'=>$this->input->post('code')])->row();
	  if ($cart->customer_id != "") {
	  	$data = $this->db->get_where("customer",['id'=>$cart->customer_id])->row();
	  }else{
	  	$data = [
	  		'customer_name'=>"",
	  		'customer_phone'=>"",
	  		'customer_address'=>"",
	  		'limit'=>"",
	  	];
	  }
	  echo json_encode($data);
	}
	public function update_pelanggan()
	{
		$this->db->update("sales_transaction",['customer_id'=>$this->input->post('pelanggan')],['id'=>$this->input->post('code')]);
	}
	public function get_transaksi()
	{
		$code = $this->input->post('barang');
		$total_belanja = $this->db->get_where("sales_data",['sales_id'=>$this->input->post('code')])->result();
		$totals="0";
		foreach ($total_belanja as $tb) {
			$totals+=$tb->subtotal;
		}
		$trx = $this->db->select('customer.limit')->join('customer','sales_transaction.customer_id=customer.id')->get_where("sales_transaction",['sales_transaction.id'=>$this->input->post('code')])->row();
		if ($trx) {
			if ($trx->limit > $totals) {
				$data = $this->db->get_where("product",['id'=>$code])->row();
				if ($data) {
					$data_cart = array(
						'sales_id'=>$this->input->post('code'),
						'product_id'	  =>$data->id,
						'quantity'     => 1,
						'price_item'   => $data->sale_price,
						'type'    => 1,
						'subtotal'=>$data->sale_price
					);
					$cek = $this->db->get_where("sales_data",['sales_id'=>$this->input->post('code'),'product_id'=>$data->id]);
					if ($cek->num_rows() == 0) {
						$this->db->insert("sales_data",$data_cart);
					}else{
						$rows = $cek->row();
						$new_qty = $rows->quantity+1;
						$new_subtotal = $rows->price_item*$new_qty;
						$data_update = array(
							'quantity'     => $new_qty,
							'subtotal'=>$new_subtotal
						);
						$this->db->update("sales_data",$data_update,['sales_id'=>$this->input->post('code'),'product_id'=>$data->id]);
					}
				}else{
					$row = $this->db->like('product_name',$code)->get("product")->row();
					$data_cart = array(
						'sales_id'=>$this->input->post('code'),
						'product_id'	  =>$row->id,
						'quantity'     => 1,
						'price_item'   => $row->sale_price,
						'type'    => 1,
						'subtotal'=>$row->sale_price
					);
					$cek = $this->db->get_where("sales_data",['sales_id'=>$this->input->post('code'),'product_id'=>$row->id]);
					if ($cek->num_rows() == 0) {
						$this->db->insert("sales_data",$data_cart);
					}else{
						$rows = $cek->row();
						$new_qty = $rows->quantity+1;
						$new_subtotal = parseInt($rows->price_item)  * $new_qty;
						$data_update = array(
							'quantity'     => $new_qty,
							'subtotal'=>$new_subtotal
						);
						$this->db->update("sales_data",$data_update,['sales_id'=>$this->input->post('code'),'product_id'=>$rows->id]);
					}
				}
			}else{
				$result = [
					'code'=>203,
					'message'=>'Limit anda tidak mencukupi'
				];
			}
		}else{
			$result = [
				'code'=>203,
				'message'=>'Silahkan Scan kartu atau masukan id pelanggan'
			];
		}
		
		echo json_encode($result);
	}
	public function get_keranjang($id)
	{
	  $cart =  $this->db->get_where('sales_data',['sales_id'=>$id])->result();
      if(!empty($cart) && is_array($cart)){
        foreach($cart as $k){
        	$p = $this->db->get_where("product",['id'=>$k->product_id])->row();
          echo "<tr><td>".$p->product_name."</td><td class='text-center'>".$k->quantity."</td><td class='text-end'>Rp. ".number_format($k->price_item,0,',','.')."</td><td class='text-end' id='subtotal'>Rp. ".number_format($k->subtotal,0,',','.')."</td></tr>";
        }
      }else{
        echo "<tr><td colspan='4' class='text-center'>Belum anda transaksi</td></tr>";
      }
	}
	public function get_total($id)
	{
	  $cart =  $this->db->get_where('sales_data',['sales_id'=>$id]);
	  if ($cart->num_rows() != 0) {
	  	 $total = 0;
		  foreach($cart->result() as $k){
		    	$total+=$k->subtotal;
		  }
	  }else{
	  	$total = 0;
	  }
	 
      echo "Rp. ".number_format($total,0,',','.');
	}
	public function del_transaksi()
	{
		$this->db->delete("sales_transaction",['id'=>$this->input->post("code")]);
		$this->db->delete("sales_data",['sales_id'=>$this->input->post("code")]);
	}
	public function add_item(){
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		$sale_price = $this->input->post('sale_price');

		$get_product_detail =  $this->produk_model->detail_by_id($product_id);
		if($get_product_detail){
			$data = array(
				'id'      => $product_id,
				'qty'     => $quantity,
				'price'   => $sale_price,
				'category_id' => $get_product_detail[0]['category_id'],
				'category_name' => $get_product_detail[0]['category_name'],
				'name'    => $get_product_detail[0]['product_name']
			);
			$this->cart->insert($data);
			echo json_encode(array('status' => 'ok',
							'data' => $this->cart->contents() ,
							'total_item' => $this->cart->total_items(),
							'total_price' => $this->cart->total()
						)
				);
		}else{
			echo json_encode(array('status' => 'error'));
		}

	}
	public function simpan()
	{
		$detail = $this->db->get_where("sales_data",['sales_id'=>$this->input->post('code')])->result();
		foreach ($detail as $d) {
			$produk = $this->db->get_where("product",['id'=>$d->product_id])->row();
			$new_qty = $produk->product_qty - $d->quantity;
			$this->db->update("product",['product_qty'=>$new_qty],['id'=>$d->product_id]);
		}
		$row = $this->db->get_where("sales_transaction",['id'=>$this->input->post('code')])->row();
		$cst = $this->db->get_where("customer",['id'=>$row->customer_id])->row();
		$this->db->update("sales_transaction",[
			'status'=>2,
			'is_cash'=>1,
			'total_price'=>$this->input->post('total'),
			'infaq'=>$this->input->post('infaq'),
			'bayar'=>$this->input->post('bayar'),
			'kembalian'=>$this->input->post('kembalian')
		],['id'=>$this->input->post('code')]);
		$new_limit = $cst->limit - $this->input->post('total');
		$this->db->update('customer',['limit'=>$new_limit],['id'=>$row->customer_id]);
		$data = [
			'code'=>200,
			'message'=>"Transaksi berhasil disimpan"
		];
		echo json_encode($data);
	}
	public function delete_item($rowid){
		if($this->cart->remove($rowid)) {
			echo number_format($this->cart->total());
		}else{
			echo "false";
		}
	}
	public function add_process(){
		$this->form_validation->set_rules('sales_id', 'sales_id', 'required');
		$this->form_validation->set_rules('customer_id', 'customer_id', 'required');
		$this->form_validation->set_rules('is_cash', 'is_cash', 'required');

		$carts =  $this->cart->contents();
		if($this->_check_qty($carts)){
			echo json_encode(array('status' => 'limit'));
			exit;
		}
		
		if($this->form_validation->run() != FALSE && !empty($carts) && is_array($carts)){
			$data['id'] = escape($this->input->post('sales_id'));
			$data['customer_id'] = escape($this->input->post('customer_id'));
			$data['is_cash'] = escape($this->input->post('is_cash'));
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();

			if($data['is_cash'] == 0){
				$data['pay_deadline_date'] = date('Y-m-d', strtotime("+30 days"));
			}else{
				$data['pay_deadline_date'] = date('Y-m-d');
			}

			$this->penjualan_model->insert($data);
			if($data['id']){
				$this->_insert_purchase_data($data['id'],$carts);
			}
			echo json_encode(array('status' => 'ok'));
		}else{
			echo json_encode(array('status' => 'error'));
		}
	}
	
	private function _check_qty($carts){
		$status = false;
		foreach($carts as $key => $cart){
			$product = $this->produk_model->get_by_id($cart['id']);
			if($cart['qty'] > $product[0]['product_qty']){
				$status = true;
				break;
			}
		}
		return $status;
	}
	private function _insert_purchase_data($sales_id,$carts){
		foreach($carts as $key => $cart){
			$purchase_data = array(
				'sales_id' => $sales_id,
				'product_id' => $cart['id'],
				'category_id' => $cart['category_id'],
				'quantity' => $cart['qty'],
				'price_item' => $cart['price'],
				'subtotal' => $cart['subtotal']
			);
			$this->penjualan_model->insert_purchase_data($purchase_data);

			$this->produk_model->update_qty_min($cart['id'],array('product_qty' => $cart['qty']));
		}
		$this->cart->destroy();
	}
	public function delete($transaction_id){
		$transaksi = $this->penjualan_model->get_detail($transaction_id);
		foreach($transaksi as $trans){
			$product = $this->produk_model->get_by_id($trans->product_id);
			$total = $product[0]['product_qty'] - $trans->quantity;
			$this->produk_model->update_qty($product[0]['id'] ,array('product_qty' => $total));
		}
		$this->penjualan_model->delete($transaction_id);
		$this->penjualan_model->delete_purchase_data_trx($transaction_id);
		redirect(site_url('penjualan'));
	}
	public function export_csv(){
		$filter = '';
		if(isset($_GET['search'])) {
			if (!empty($_GET['id']) && $_GET['id'] != '') {
				$filter['sales_transaction.id LIKE'] = "%" . $_GET['id'] . "%";
			}

			if (!empty($_GET['date_from']) && $_GET['date_from'] != '') {
				$filter['DATE(sales_transaction.date) >='] = $_GET['date_from'];
			}

			if (!empty($_GET['date_end']) && $_GET['date_end'] != '') {
				$filter['DATE(sales_transaction.date) <='] = $_GET['date_end'];
			}
		}
		$result = $this->penjualan_model->get_filter_csv($filter);
		if($result){
			$result = $this->_set_csv_format($result);
		}
		//echo json_encode($result);
		$this->csv_library->export('sales.csv',$result);
	}
	public function print_now($id = ""){
		$details = $this->penjualan_model->get_detail($id);
		if($details){
			$data['details'] = $details;
			$this->load->view("penjualan/print",$data);
		}else{
			redirect(site_url('penjualan'));
		}
	}
	
	private function _set_csv_format($datas){
		$result = false;
		if(is_array($datas)){
			$data_before = "";
			foreach($datas as $k => $data){
				$datas[$k]['is_cash'] = ($data['is_cash'] == 1) ? "Cash" : "Bayar Nanti";
				$datas[$k]['pay_deadline_date'] = ($data['is_cash'] == 1) ? "" : $data["pay_deadline_date"];
				$datas[$k]['date'] = date("Y-m-d H:i:s",strtotime($data['date']));
				if($data['id'] == $data_before) {
					$datas[$k]['id'] = "";
					$datas[$k]['customer_id'] = "";
					$datas[$k]['customer_name'] = "";
					$datas[$k]['customer_phone'] = "";
					$datas[$k]['customer_address'] = "";
					$datas[$k]['category_name'] = "";
					$datas[$k]['total_price'] = "";
					$datas[$k]['total_item'] = "";
					$datas[$k]['is_cash'] = "";
					$datas[$k]['pay_deadline_date'] = "";

					$datas[$k]['date'] = "";
				}
				$data_before = $data['id'];
			}
			$result = $datas;
		}
		return $result;
	}
}
